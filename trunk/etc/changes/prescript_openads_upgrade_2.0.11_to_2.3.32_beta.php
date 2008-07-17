<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

$className = 'OA_UpgradePrescript_2_0_11';


class OA_UpgradePrescript_2_0_11
{
    var $oUpgrade;

    function OA_UpgradePrescript_2_0_11()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = $aParams[0];

        if ($this->oUpgrade->oDbh->dbsyntax == 'pgsql') {
            $prefix = $this->oUpgrade->oDBUpgrader->prefix;

            $result = $this->oUpgrade->oDbh->exec("ALTER TABLE {$prefix}zones ALTER zonename TYPE varchar(245)");

            // This ALTER TABLE needs to run in UTC because it stores a UTC timestamp
            $result = $this->oUpgrade->oDbh->exec("SET timezone = 'UTC'");
            $result = $this->oUpgrade->oDbh->exec("ALTER TABLE {$prefix}session ALTER lastused TYPE timestamp");
            $result = $this->oUpgrade->oDbh->exec("SET timezone = DEFAULT");

            $result = $this->oUpgrade->oDbh->exec("ALTER TABLE {$prefix}images ALTER t_stamp TYPE timestamp");

            $result = $this->oUpgrade->oDbh->exec("DROP INDEX ".OA_phpAdsNew::phpPgAdsPrefixedIndex('banners_clientid_idx', $prefix));
            $result = $this->oUpgrade->oDbh->exec("DROP INDEX ".OA_phpAdsNew::phpPgAdsPrefixedIndex('clients_parent_idx', $prefix));
            $result = $this->oUpgrade->oDbh->exec("DROP INDEX ".OA_phpAdsNew::phpPgAdsPrefixedIndex('zones_affiliateid_idx', $prefix));

            $aForeignKeys = $this->oUpgrade->oDbh->getAssoc("
                SELECT
                    r.conname AS fk,
                    c.relname AS table
                FROM
                    pg_catalog.pg_class c JOIN
                    pg_catalog.pg_constraint r ON (r.conrelid = c.oid)
                WHERE
                    c.relname IN ('{$prefix}acls', '{$prefix}banners', '{$prefix}clients', '{$prefix}zones') AND
                    pg_catalog.pg_table_is_visible(c.oid) AND
                    r.contype = 'f'
                ORDER BY
                    1,2
            ");

            foreach ($aForeignKeys as $fkey => $table) {
                $result = $this->oUpgrade->oDbh->exec("ALTER TABLE {$table} DROP CONSTRAINT {$fkey}");
            }

            $aIndexes = array(
                OA_phpAdsNew::phpPgAdsPrefixedIndex('acls_bannerid_idx', $prefix) => 'acls_bannerid',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('acls_bannerid_executionorder_udx', $prefix) => 'acls_bannerid_executionorder',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('acls_bannerid_idx', $prefix) => 'acls_bannerid',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('adclicks_bid_date_idx', $prefix) => 'adclicks_bannerid_date',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('adclicks_date_idx', $prefix) => 'adclicks_date',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('adclicks_zoneid_idx', $prefix) => 'adclicks_zoneid',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('adstats_bid_day_idx', $prefix) => 'adstats_bannerid_day',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('adstats_zoneid_idx', $prefix) => 'adstats_zoneid',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('adviews_bid_date_idx', $prefix) => 'adviews_bannerid_date',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('adviews_date_idx', $prefix) => 'adviews_date',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('adviews_zoneid_idx', $prefix) => 'adviews_zoneid',
                OA_phpAdsNew::phpPgAdsPrefixedIndex('zones_zonename_zoneid_idx', $prefix) => 'zones_zonenameid'
            );

            foreach ($aIndexes as $oldIndex => $newIndex) {
                $result = $this->oUpgrade->oDbh->exec("ALTER INDEX {$oldIndex} RENAME TO {$prefix}{$newIndex}");
            }

            $aFunctions = array(
                'unix_timestamp(timestamptz)',
                'from_unixtime(int4)',
                'to_days(timestamptz)',
                'dayofmonth(timestamptz)',
                'month(timestamptz)',
                'year(timestamptz)',
                'week(timestamptz)',
                'hour(timestamptz)',
                'date_format(timestamptz, text)',
                'if(bool, varchar, varchar)'
            );

            foreach ($aFunctions as $function) {
                $result = $this->oUpgrade->oDbh->exec("DROP FUNCTION {$function}");
            }

            OA_DB::createFunctions();
        }

        return true;
    }
}

?>
