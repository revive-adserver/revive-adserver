<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

namespace RV\Dal\Statistics;

use MDB2_Driver_Common;
use OA_DB;
use PEAR;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Condense
{
    private readonly MDB2_Driver_Common $oDbh;
    private readonly string $prefix;
    private readonly \DateTimeImmutable $now;
    private bool $terminate = false;

    public function __construct(
        private readonly ?SymfonyStyle $io = null,
        ?MDB2_Driver_Common $oDbh = null,
        ?string $prefix = null,
        ?\DateTimeImmutable $now = null,
    ) {
        require_once MAX_PATH . '/lib/OA/DB.php';

        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->prefix = $prefix ?? $aConf['table']['prefix'];

        $oDbh ??= OA_DB::singleton();

        if (PEAR::isError($oDbh)) {
            throw new \RuntimeException($oDbh->getMessage());
        }

        $this->oDbh = $oDbh;
        $this->now = $now ?? new \DateTimeImmutable('now');
    }

    public function start(?int $daily, ?int $monthly, ?int $batches = null, bool $dryRun = false): void
    {
        $types = [];

        $firstDay = $this->now->setTimezone(new \DateTimeZone('UTC'))
            ->modify('first day of this month')
            ->setTime(0, 0);

        if (null !== $monthly) {
            if ($monthly++ < 0) {
                throw new \InvalidArgumentException('Monthly value must be >= 0');
            }

            $types['monthly'] = [
                'start' => null,
                'end' => $firstDay->modify("-{$monthly} months"),
            ];
        }

        if (null !== $daily) {
            if ($daily++ < 0) {
                throw new \InvalidArgumentException('Daily value must be >= 0');
            }

            $types['daily'] = [
                'start' => ($types['monthly']['end'] ?? null)?->modify('+1 month'),
                'end' => $firstDay->modify("-{$daily} months"),
            ];
        }

        foreach ($types as $type => $dates) {
            $this->condense($type, $dates['start'], $dates['end'], 'data_summary_ad_hourly', $batches, $dryRun);
            $this->condense($type, $dates['start'], $dates['end'], 'data_intermediate_ad', $batches, $dryRun);

            if ($this->terminate) {
                break;
            }
        }
    }

    private function condense(string $type, ?\DateTimeImmutable $startDate, \DateTimeImmutable $endDate, string $table, ?int $batches, bool $dryRun): void
    {
        $startDate ??= $this->findMinDate($table, $endDate);

        if (null === $startDate) {
            $this->io?->writeln("<comment>Nothing to do for {$type} condensing of {$table}</comment>", OutputInterface::VERBOSITY_VERBOSE);

            return;
        }

        $startDate = new \DateTimeImmutable(
            $startDate->format('Y-m-01'),
        );

        $interval = new \DateInterval('P1M');

        $period = new \DatePeriod(
            $startDate,
            $interval,
            $endDate->modify('+1 minute'),
        );

        if ($this->oDbh->dbsyntax === 'pgsql') {
            $where = match ($type) {
                'daily' => "date_time::time(0) <> '00:00:00'",
                'monthly' => "EXTRACT(DAY from date_time) <> 1 AND date_time::time(0) <> '00:00:00'",
            };
        } else {
            $where = match ($type) {
                'daily' => "DATE_FORMAT(date_time, '%H:%i:%s') <> '00:00:00'",
                'monthly' => "DATE_FORMAT(date_time, '%d %H:%i:%s') <> '01 00:00:00'",
            };
        }

        $stmt = $this->oDbh->prepare("SELECT 1 FROM {$this->prefix}{$table} WHERE date_time > ? AND date_time < ? AND {$where} LIMIT 1");

        foreach ($period as $dtStart) {
            $dtEnd = $dtStart->add($interval);

            $res = $stmt->execute([
                $dtStart->format("Y-m-d"),
                $dtEnd->format("Y-m-d"),
            ]);

            if (!$res->fetchOne()) {
                $this->io?->writeln("<comment>Nothing to {$type} condense in {$table} for {$dtStart->format('Y-m')}</comment>", OutputInterface::VERBOSITY_VERBOSE);
                continue;
            }

            if ($dryRun) {
                $before = $this->countBefore($table, $dtStart, $dtEnd);
                $after = $this->countAfter($table, $dtStart, $dtEnd, $type);
            } else {
                $tmpTable = $this->createTempTable($type, $table, $dtStart, $dtEnd);
                $before = $this->delete($table, $dtStart, $dtEnd);
                $after = $this->insert($table, $tmpTable);
                $this->oDbh->exec("DROP TABLE IF EXISTS {$tmpTable}");
            }

            $this->io?->writeln("<info>Condensed {$before} records from {$table} into {$after} {$type} aggregates for {$dtStart->format('Y-m')}</info>");

            if (null !== $batches && --$batches <= 0) {
                $this->terminate = true;
                break;
            }
        }
    }

    private function countBefore(string $table, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate): int
    {

        $start = $this->oDbh->quote($startDate->format("Y-m-d"));
        $end = $this->oDbh->quote($endDate->format("Y-m-d"));

        return (int) $this->oDbh->queryOne("SELECT COUNT(*) FROM {$this->prefix}{$table} WHERE date_time >= {$start} AND date_time < {$end}");
    }

    private function countAfter(string $table, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate, string $type): int
    {
        $select = $this->getAggregateSql($type, $table, $startDate, $endDate);

        $sql = "SELECT COUNT(*) FROM ({$select}) AS t";

        return (int) $this->oDbh->queryOne($sql);
    }

    private function createTempTable(string $type, string $table, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate): string
    {
        if ($table === 'data_summary_ad_hourly') {
            $tmpTable = "{$this->prefix}{$startDate->format('Ym')}_dsah";
        } else {
            $tmpTable = "{$this->prefix}{$startDate->format('Ym')}_dia";
        }

        $select = $this->getAggregateSql($type, $table, $startDate, $endDate);

        $res = $this->oDbh->exec("CREATE TABLE {$tmpTable} AS {$select}");

        if (PEAR::isError($res)) {
            throw new \RuntimeException($res->getDebugInfo());
        }

        return $tmpTable;
    }

    private function delete(string $table, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate): int
    {
        $start = $this->oDbh->quote($startDate->format("Y-m-d"));
        $end = $this->oDbh->quote($endDate->format("Y-m-d"));

        $res = $this->oDbh->exec("DELETE FROM {$this->prefix}{$table} WHERE date_time >= {$start} AND date_time < {$end}");

        if (PEAR::isError($res)) {
            throw new \RuntimeException($res->getDebugInfo());
        }

        return $res;
    }

    private function insert(string $table, string $tmpTable): int
    {
        $res = $this->oDbh->query("SELECT * FROM {$tmpTable} LIMIT 1");

        if (PEAR::isError($res)) {
            throw new \RuntimeException($res->getDebugInfo());
        }

        $fields = implode(', ', array_keys($res->fetchRow()));

        $res = $this->oDbh->exec("INSERT INTO {$this->prefix}{$table} ({$fields}, updated) SELECT *, NOW() FROM {$tmpTable}");

        if (PEAR::isError($res)) {
            throw new \RuntimeException($res->getDebugInfo());
        }

        return $res;
    }

    private function getAggregateSql(string $type, string $table, \DateTimeImmutable $startDate, \DateTimeImmutable $endDate): string
    {
        $start = $this->oDbh->quote($startDate->format("Y-m-d"));
        $end = $this->oDbh->quote($endDate->format("Y-m-d"));

        if ($this->oDbh->dbsyntax === 'pgsql') {
            $condensedDate = match ($type) {
                'daily' => 'date_time::date::timestamp(0)',
                'monthly' => "date_trunc('month', date_time)",
            };
        } else {
            $condensedDate = match ($type) {
                'daily' => 'CAST(DATE(date_time) AS datetime)',
                'monthly' => "CAST(DATE_FORMAT(date_time, '%Y-%m-01') AS datetime)",
            };
        }

        if ($table === 'data_summary_ad_hourly') {
            return <<<EOF
SELECT
    {$condensedDate} AS date_time,
    ad_id,
    creative_id,
    zone_id,
    SUM(requests) AS requests,
    SUM(impressions) AS impressions,
    SUM(clicks) AS clicks,
    SUM(conversions) AS conversions,
    SUM(total_basket_value) AS total_basket_value,
    SUM(total_num_items) AS total_num_items,
    SUM(total_revenue) AS total_revenue,
    SUM(total_cost) AS total_cost,
    SUM(total_techcost) AS total_techcost
FROM {$this->prefix}{$table}
WHERE date_time >= {$start} AND date_time < {$end}
GROUP BY 1, 2, 3, 4
ORDER BY 1, 2, 3, 4
EOF;
        }

        return <<<EOF
SELECT
    {$condensedDate} AS date_time,
    ad_id,
    creative_id,
    zone_id,
    60 AS operation_interval,
    1 AS operation_interval_id,
    {$condensedDate} AS interval_start,
    {$condensedDate} AS interval_end,
    SUM(requests) AS requests,
    SUM(impressions) AS impressions,
    SUM(clicks) AS clicks,
    SUM(conversions) AS conversions,
    SUM(total_basket_value) AS total_basket_value,
    SUM(total_num_items) AS total_num_items
FROM {$this->prefix}{$table}
WHERE date_time >= {$start} AND date_time < {$end}
GROUP BY 1, 2, 3, 4, 5, 6, 7, 8 
ORDER BY 1, 2, 3, 4
EOF;
    }

    private function findMinDate(string $table, \DateTimeImmutable $endDate): ?\DateTimeImmutable
    {
        $date = $this->oDbh->queryOne("SELECT MIN(date_time) FROM {$this->prefix}{$table} WHERE date_time < '{$endDate->format('Y-m-d')}'");

        return $date ? new \DateTimeImmutable($date) : null;
    }
}
