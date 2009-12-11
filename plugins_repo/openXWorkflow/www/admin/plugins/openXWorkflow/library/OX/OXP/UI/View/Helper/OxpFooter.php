<?php

/**
 * A helper that outputs OXP footer using phpAds_PageFooter function 
 */
class OX_OXP_UI_View_Helper_OxpFooter
{
    public static function oxpFooter()
    {
        ob_start();
        phpAds_PageFooter();
        $footer = ob_get_contents();
        ob_end_clean();
        
        return $footer;
    }
}