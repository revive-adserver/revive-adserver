<?php

/**
 * A helper for displaying Zend Dates in a given date and time format.
 */
class OX_UI_View_Helper_DateTimeFormat
{


    /**
     * Formats given Zend date with given format. If date or time format is not
     * given OX_Common_DateUtils::DATE_FORMAT and OX_Common_DateUtils::TIME_FORMAT
     * will be used respectively. 
     *
     * @param ZendDate $date
     * @param string $dateFormat
     * @param string $timeFormat
     * @return string formatted date string
     */
    public function dateTimeFormat($date, $dateFormat = null, $timeFormat = null)
    {
        $dateFormat = empty($dateFormat) ? OX_Common_DateUtils::DATE_FORMAT : $dateFormat;
        $timeFormat = empty($timeFormat) ? OX_Common_DateUtils::TIME_FORMAT : $timeFormat;
        
        return $date->toString($dateFormat . ' ' . $timeFormat);
    }

}
