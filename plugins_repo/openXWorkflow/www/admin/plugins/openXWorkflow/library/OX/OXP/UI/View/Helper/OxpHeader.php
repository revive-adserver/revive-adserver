<?php

/**
 *  A helper that outputs OXP header using phpAds_PageHeader function.
 * Uses OX_Forecasting_UI_Controller_Plugin_PluginMenuSectionResolver
 * to obtain oxp section id to be passed to header function
 */
class OX_OXP_UI_View_Helper_OxpHeader
{
    public static function oxpHeader()
    {
        $oHeaderModel = null;
        $oxpSectionId = Zend_Registry::get('OXP_Menu_Section_ID');
        if (Zend_Registry::getInstance()->offsetExists('OXP_Menu_Header_Model')) { 
            $oHeaderModel = Zend_Registry::get('OXP_Menu_Header_Model');
        }
    
        ob_start();
        phpAds_PageHeader($oxpSectionId, $oHeaderModel,'../../');
        $header = ob_get_contents();
        ob_end_clean();
        
        return $header;
    }
}

