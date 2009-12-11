<?php

/**
 * A helper for displaying integer numbers in a localized way.
 */
class OX_UI_View_Helper_IntegerFormat
{
    /**
     * Formats given integer number in a localized way
     */
    public static function integerFormat($value)
    {
        return Zend_Locale_Format::toInteger($value);
    }
}
