<?php

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