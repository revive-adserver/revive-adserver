<?php

class OX_UI_View_Helper_DateRangePicker extends OX_UI_View_Helper_WithViewScript
{
    /**
     * Format used to convert Zend_Date instances to strings to insert into URLs.
     */
    const DATE_FORMAT = 'yyyy-MM-dd';
    
    public static function dateRangePicker($dateRange, $rangeUrlTemplate, 
            $customUrlTemplate, $dateRangeIds = null)
    {
        return parent::renderViewScript("date-range-picker.html", array (
                'dateRange' => $dateRange, 
                'dateRanges' => OX_Common_DateRange::getRanges($dateRangeIds), 
                'rangeUrlTemplate' => $rangeUrlTemplate, 
                'customUrlTemplate' => $customUrlTemplate,
                'dateFormat' => self::DATE_FORMAT));
    }
}
