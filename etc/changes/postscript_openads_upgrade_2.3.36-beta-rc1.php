<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

class OA_UpgradePostscript
{
    var $oUpgrade;
    var $oSchema;

    function OA_UpgradePostscript()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        if (PEAR::isError($this->removeDashboardColumns()))
        {
            return false;
        }
        return true;
    }

    function removeDashboardColumns()
    {
        $this->oSchema  = MDB2_Schema::factory(OA_DB::singleton(OA_DB::getDsn()));
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $table = 'preference';
        $aColumns = array(
                          'ad_clicks_sum',
                          'ad_views_sum',
                          'ad_clicks_per_second',
                          'ad_views_per_second',
                          'ad_cs_data_last_sent',
                          'ad_cs_data_last_sent',
                          'ad_cs_data_last_received',
                        );
        $aDef  = $this->oSchema->getDefinitionFromDatabase(array($prefix.$table));
        if (is_array($aDef) && count($aDef)>0)
        {
            $aTask['remove'] = array();
            if (isset($aDef['tables'][$prefix.$table]))
            {
                foreach ($aColumns AS $column)
                {
                    if (isset($aDef['tables'][$prefix.$table]['fields'][$column]))
                    {
                        $aTask['remove'][$column] = array();
                        $this->oUpgrade->oLogger->logOnly("preference.{$column} found");
                    }
                }
            }
            if (count($aTask['remove']>0))
            {
                $result = $this->oSchema->db->manager->alterTable($prefix.$table, $aTask, false);
            }
        }
        $this->oUpgrade->oLogger->logOnly('preference table schema upgrade for dashboard unnecessary');
        return true;
    }

}