<?php

/**
 * Resolves the menu section based on the request, if any. Also performs screen-level
 * access checks.
 */
class OX_Workflow_UI_Controller_Plugin_PluginMenuSectionResolver 
    extends OX_UI_Controller_Plugin
{
    private static $_instance;
    
    private $oxpSectionId;
    
    /**
     * Enter description here...
     *
     * @return OX_Forecasting_UI_Controller_Plugin_PluginMenuSectionResolver
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self(); 
        }
        
        return self::$_instance;
    }
    
    
    public function preDispatch(OX_UI_Controller_Default $controller)
    {
        $this->oxpSectionId = 'openXWorkflow-menu';
        Zend_Registry::set('OXP_Menu_Section_ID', $this->oxpSectionId);
        $oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel("Quickly set up your website to serve advertising", 'iconZoneWizardLarge');
        
        Zend_Registry::set('OXP_Menu_Header_Model', $oHeaderModel);
    }
    
    
    public function getSectionId()
    {
        return $this->oxpSectionId;
    }
}