<?php

/**
 * The common base class for controllers from the advertiser module.
 */
abstract class OX_UI_Controller_Report extends OX_UI_Controller_ContentPage
{
    const DEFAULT_DATE_RANGE = OX_Common_DateRange::DATE_RANGE_LAST_7_DAYS;
    
    protected function currentDateRange(OX_Common_DateRange $dateRange = null)
    {
        // Read from session
        $store = new Zend_Session_Namespace("report");
        
        if ($dateRange === null) {
            if (!isset($store->currentDateRange)) {
                $store->currentDateRange = new OX_Common_DateRange();
                $store->currentDateRange->setRange(self::DEFAULT_DATE_RANGE);
            }
        }
        else
        {
            $store->currentDateRange = $dateRange;
        }
        
        return $store->currentDateRange;
    }
}
