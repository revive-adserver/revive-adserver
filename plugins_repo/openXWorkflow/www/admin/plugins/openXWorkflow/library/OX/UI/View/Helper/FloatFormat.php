<?php

/**
 * A helper for displaying float numbers in a localized way.
 */
class OX_UI_View_Helper_FloatFormat
{
    /**
     * Formats given float number in a localized way
     */
    public static function floatFormat($value = null, $precision = 2)
    {
        if (isset($value)) {
            return Zend_Locale_Format::toFloat($value, array('precision' => $precision));
        } else {
            return '';
        }
    }
}
