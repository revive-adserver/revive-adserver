<?php

/**
 * A translation helper. Uses OX_Common_Translate as a backend
 */
class OX_UI_View_Helper_T
{
    /**
     * Helper method for string translations
     *
     * @param unknown_type $messageId
     * @param unknown_type $aValues
     * @param unknown_type $locale
     * @return unknown
     */
    public static function t($messageId, $aValues = null, $locale = null)
    {
        return OX_Common_Translator::t($messageId, $aValues, $locale);
    }
}
