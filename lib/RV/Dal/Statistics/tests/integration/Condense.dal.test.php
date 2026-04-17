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

namespace RV\Dal\Statistics\tests\integration;

use RV\Dal\Statistics\Condense;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Style\SymfonyStyle;

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

class Test_Rv_Dal_Statistics_Condense extends \UnitTestCase
{
    private const DATA = [
        ['2025-01-01 12:00:00', 3],
        ['2025-01-12 12:00:00', 3],

        ['2025-02-25 11:00:00', 2],
        ['2025-02-25 12:00:00', 1],
        ['2025-02-25 12:00:00', 2],
        ['2025-02-27 12:00:00', 2],
        ['2025-02-27 13:00:00', 1],

        ['2026-01-25 11:00:00', 2],
        ['2026-01-25 12:00:00', 1],
        ['2026-01-25 12:00:00', 2],

        ['2026-01-27 12:00:00', 1],
        ['2026-01-27 12:00:00', 2],

        ['2026-03-27 13:00:00', 1],
        ['2026-03-27 13:00:00', 2],
        ['2026-03-27 14:00:00', 1],
    ];

    private \MDB2_Driver_Common $oDbh;
    private Condense $oDal;
    private BufferedOutput $oOutput;

    public function __construct()
    {
        parent::__construct();

        $this->oDbh = \OA_DB::singleton();
    }

    public function setUp()
    {
        $this->oDal = new Condense(
            new SymfonyStyle(
                new StringInput(''),
                $this->oOutput = new BufferedOutput(),
            ),
            $this->oDbh,
            now: new \DateTimeImmutable('2026-03-27 15:46:27'),
        );

        $this->generateDataSet(self::DATA);
    }

    public function tearDown()
    {
        \DataGenerator::cleanUp();
    }

    public function test_condense_dryRun(): void
    {
        $aExpect = array_map(static function (array $item) {
            $item[] = '1';
            return $item;
        }, self::DATA);

        $this->oDal->start(1, 2, dryRun: true);

        $this->assertEqual(explode(PHP_EOL, trim($this->oOutput->fetch())), [
            'Condensed 2 records from data_summary_ad_hourly into 1 monthly aggregates for 2025-01',
            'Condensed 5 records from data_summary_ad_hourly into 2 monthly aggregates for 2025-02',
            'Condensed 2 records from data_intermediate_ad into 1 monthly aggregates for 2025-01',
            'Condensed 5 records from data_intermediate_ad into 2 monthly aggregates for 2025-02',
            'Condensed 5 records from data_summary_ad_hourly into 4 daily aggregates for 2026-01',
            'Condensed 5 records from data_intermediate_ad into 4 daily aggregates for 2026-01',
        ]);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_intermediate_ad ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_summary_ad_hourly ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);
    }

    public function test_condense_null_null(): void
    {
        $aExpect = array_map(static function (array $item) {
            $item[] = '1';
            return $item;
        }, self::DATA);

        $this->oDal->start(null, null);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_intermediate_ad ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_summary_ad_hourly ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);
    }

    public function test_condense_5_null(): void
    {
        $aExpect = [
            ['2025-01-01 00:00:00', '3', '1'],
            ['2025-01-12 00:00:00', '3', '1'],

            ['2025-02-25 00:00:00', '1', '1'],
            ['2025-02-25 00:00:00', '2', '2'],
            ['2025-02-27 00:00:00', '1', '1'],
            ['2025-02-27 00:00:00', '2', '1'],

            ['2026-01-25 11:00:00', '2', '1'],
            ['2026-01-25 12:00:00', '1', '1'],
            ['2026-01-25 12:00:00', '2', '1'],

            ['2026-01-27 12:00:00', '1', '1'],
            ['2026-01-27 12:00:00', '2', '1'],

            ['2026-03-27 13:00:00', '1', '1'],
            ['2026-03-27 13:00:00', '2', '1'],
            ['2026-03-27 14:00:00', '1', '1'],
        ];

        $this->oDal->start(5, null);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_intermediate_ad ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_summary_ad_hourly ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);
    }

    public function test_condense_null_5(): void
    {
        $aExpect = [
            ['2025-01-01 00:00:00', '3', '2'],
            ['2025-02-01 00:00:00', '1', '2'],
            ['2025-02-01 00:00:00', '2', '3'],

            ['2026-01-25 11:00:00', '2', '1'],
            ['2026-01-25 12:00:00', '1', '1'],
            ['2026-01-25 12:00:00', '2', '1'],

            ['2026-01-27 12:00:00', '1', '1'],
            ['2026-01-27 12:00:00', '2', '1'],

            ['2026-03-27 13:00:00', '1', '1'],
            ['2026-03-27 13:00:00', '2', '1'],
            ['2026-03-27 14:00:00', '1', '1'],
        ];

        $this->oDal->start(null, 5);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_intermediate_ad ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_summary_ad_hourly ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);
    }

    public function test_condense_0_2(): void
    {
        $aExpect = [
            ['2025-01-01 00:00:00', '3', '2'],
            ['2025-02-01 00:00:00', '1', '2'],
            ['2025-02-01 00:00:00', '2', '3'],
            ['2026-01-25 00:00:00', '1', '1'],
            ['2026-01-25 00:00:00', '2', '2'],
            ['2026-01-27 00:00:00', '1', '1'],
            ['2026-01-27 00:00:00', '2', '1'],

            ['2026-03-27 13:00:00', '1', '1'],
            ['2026-03-27 13:00:00', '2', '1'],
            ['2026-03-27 14:00:00', '1', '1'],
        ];

        $this->oDal->start(0, 2);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_intermediate_ad ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_summary_ad_hourly ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);
    }

    public function test_condense_0_2_batches(): void
    {
        $aExpect = [
            ['2025-01-01 00:00:00', '3', '2'],

            ['2025-02-25 11:00:00', '2', '1'],
            ['2025-02-25 12:00:00', '1', '1'],
            ['2025-02-25 12:00:00', '2', '1'],
            ['2025-02-27 12:00:00', '2', '1'],
            ['2025-02-27 13:00:00', '1', '1'],

            ['2026-01-25 11:00:00', '2', '1'],
            ['2026-01-25 12:00:00', '1', '1'],
            ['2026-01-25 12:00:00', '2', '1'],

            ['2026-01-27 12:00:00', '1', '1'],
            ['2026-01-27 12:00:00', '2', '1'],

            ['2026-03-27 13:00:00', '1', '1'],
            ['2026-03-27 13:00:00', '2', '1'],
            ['2026-03-27 14:00:00', '1', '1'],
        ];

        $this->oDal->start(0, 2, batches: 1);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_intermediate_ad ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_summary_ad_hourly ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);
    }

    public function test_condense_0_null_batches(): void
    {
        $aExpect = [
            ['2025-01-01 00:00:00', '3', '1'],
            ['2025-01-12 00:00:00', '3', '1'],

            ['2025-02-25 00:00:00', '1', '1'],
            ['2025-02-25 00:00:00', '2', '2'],
            ['2025-02-27 00:00:00', '1', '1'],
            ['2025-02-27 00:00:00', '2', '1'],

            ['2026-01-25 11:00:00', '2', '1'],
            ['2026-01-25 12:00:00', '1', '1'],
            ['2026-01-25 12:00:00', '2', '1'],

            ['2026-01-27 12:00:00', '1', '1'],
            ['2026-01-27 12:00:00', '2', '1'],

            ['2026-03-27 13:00:00', '1', '1'],
            ['2026-03-27 13:00:00', '2', '1'],
            ['2026-03-27 14:00:00', '1', '1'],
        ];

        $this->oDal->start(0, null, batches: 2);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_intermediate_ad ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);

        $aResult = $this->oDbh->queryAll('SELECT date_time, ad_id, impressions FROM oa_data_summary_ad_hourly ORDER BY date_time, ad_id', fetchmode: MDB2_FETCHMODE_ORDERED);

        $this->assertEqual($aResult, $aExpect);
    }

    private function generateDataSet(array $aData): void
    {
        foreach ($aData as $item) {
            $aData = [
                'date_time' => (new \DateTimeImmutable($item[0]))->format('Y-m-d H:00:00'),
                'ad_id' => $item[1],
            ];
            $this->insertDIA($aData);
            $this->insertDSAH($aData);
        }
    }

    private function insertDIA(array $aData): void
    {
        /** @var \DataObjects_Data_intermediate_ad $doDIA */
        $doDIA = \OA_Dal::factoryDO('data_intermediate_ad');
        $doDIA->date_time = $aData['date_time'];
        $doDIA->ad_id = $aData['ad_id'];
        $doDIA->impressions = 1;

        \DataGenerator::generateOne($doDIA);
    }

    private function insertDSAH(array $aData): void
    {
        /** @var \DataObjects_Data_summary_ad_hourly $doDSAH */
        $doDSAH = \OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDSAH->date_time = $aData['date_time'];
        $doDSAH->ad_id = $aData['ad_id'];
        $doDSAH->impressions = 1;

        \DataGenerator::generateOne($doDSAH);
    }
}
