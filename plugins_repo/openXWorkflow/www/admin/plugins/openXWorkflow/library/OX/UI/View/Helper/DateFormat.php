<?php

/**
 * A helper for displaying Zend Dates in a given format.
 */
class OX_UI_View_Helper_DateFormat
{
    /**
     * Formats given Zend_Date.
     *
     * @param ZendDate $date
     * @param string $variant display variant for the date: 'long' | 'medium' | 'short'
     * @param string $format custom format for the date, if provided, $variant is ignored
     * @return string formatted date string
     */
    public static function dateFormat(Zend_Date $date = null, $variant = 'medium', $format = null)
    {
        return empty($date) ? '' : $date->toString(
            ($format ? $format : OX_Common_Config::getUiDateFormat($variant)));
    }
}
