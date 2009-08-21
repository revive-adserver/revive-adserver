<?php

// Mock Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics to get direct access to protected methods
class ImportMarketStatisticsTestTask extends Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics {
    public function getActiveAccounts() {
        return parent::getActiveAccounts();
    }
    
    public function shouldSkipAccount($accountId){
        return parent::shouldSkipAccount($accountId);
    }
    
    public function setLastUpdateDate($accountId){
        parent::setLastUpdateDate($accountId);
    }
        
    public function setActiveAccounts($aActiveAccounts)
    {
        $this->aActiveAccounts = $aActiveAccounts;
    }
}
