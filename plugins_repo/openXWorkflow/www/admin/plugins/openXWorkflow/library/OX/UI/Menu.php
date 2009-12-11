<?php

/**
 * Manages menu entries for the applications. Work in progress, subject to large changes.
 */
class OX_UI_Menu
{
    /** 
     * Root section of the menu, usually not rendered
     * 
     * @var OX_UI_Menu_Section 
     */
    private $rootSection;
    
    /**
     * A flat by-section-id index of all menu entries.
     * 
     * @var array
     */
    private $aSectionsById;


    public function __construct($rootSectionId = "root")
    {
        $this->rootSection = new OX_UI_Menu_Section($rootSectionId, OX_UI_Menu_Section::LEVEL_ROOT, '');
        $this->aSectionsById = array (
                $rootSectionId => $this->rootSection);
    }


    public function appendTo($parentSectionId, $sectionId, $sectionLevel, 
            $sectionLabel = null, $options = null)
    {
        $this->appendSectionTo($parentSectionId, new OX_UI_Menu_Section($sectionId, $sectionLevel, $sectionLabel, $options));
    }


    public function appendMainTabTo($parentSectionId, $sectionId, 
            $sectionLabel = null, $options = null)
    {
        $this->appendTo($parentSectionId, $sectionId, OX_UI_Menu_Section::LEVEL_TAB_MAIN, $sectionLabel, $options);
    }


    public function appendLeftMenuTo($parentSectionId, $sectionId, 
            $sectionLabel = null, $options = null)
    {
        $this->appendTo($parentSectionId, $sectionId, OX_UI_Menu_Section::LEVEL_LEFT_MAIN, $sectionLabel, $options);
    }


    public function appendContentTo($parentSectionId, $sectionId, 
            $sectionLabel = null, $options = null)
    {
        $this->appendTo($parentSectionId, $sectionId, OX_UI_Menu_Section::LEVEL_CONTENT, $sectionLabel, $options);
    }


    public function appendContentTabTo($parentSectionId, $sectionId, 
            $sectionLabel = null, $options = null)
    {
        $this->appendTo($parentSectionId, $sectionId, OX_UI_Menu_Section::LEVEL_TAB_CONTENT, $sectionLabel, $options);
    }


    public function appendSectionTo($sectionId, OX_UI_Menu_Section $section)
    {
        $this->checkSectionExists($sectionId, "OX_UI_Menu::appendTo()");
        
        $appendTo = $this->aSectionsById[$sectionId];
        
        $appendTo->append($section);
        $this->aSectionsById[$section->getId()] = $section;
    }


    /**
     * Returns the section with the provided id, or <code>null</code> if the 
     * section does not exist.
     * 
     * @return OX_UI_Menu_Section
     */
    public function getSection($sectionId)
    {
        if ($this->sectionExists($sectionId)) {
            return $this->aSectionsById[$sectionId];
        }
        else {
            return null;
        }
    }


    /**
     * @param Zend_Controller_Request_Http $request
     * @return OX_UI_Menu_Section corresponding to the action/controller/module from
     * the provided request or null if no section corresponds to the provided request.
     */
    public function getSectionForRequest(Zend_Controller_Request_Http $request)
    {
        return $this->getSection(self::buildSectionIdFromRequest($request));
    }


    public function sectionExists($sectionId)
    {
        return array_key_exists($sectionId, $this->aSectionsById);
    }


    private function checkSectionExists($sectionId, $methodName = '')
    {
        if (!$this->sectionExists($sectionId)) {
            throw new Zend_Exception($methodName . ": " . $sectionId . " does not exist.");
        }
    }


    /**
     * Sets a menu instance in Zend_Registry.
     */
    public static function setInRegistry(OX_UI_Menu $menu)
    {
        Zend_Registry::set("navigation", $menu);
    }


    /**
     * Returns a menu instance from Zend_Registry.
     *
     * @return OX_UI_Menu
     */
    public static function getFromRegistry()
    {
        return Zend_Registry::get("navigation");
    }


    /**
     * Builds section identifier based on the provided HTTP request.
     */
    private static function buildSectionIdFromRequest(Zend_Controller_Request_Http $request)
    {
        $action = $request->getActionName();
        $controller = $request->getControllerName();
        $module = $request->getModuleName();
        
        return self::buildSectionId($module, $controller, $action);
    }
    
    
    /**
     * Builds section identifier basing on given module, controller, action
     */
    public static function buildSectionId($module, $controller, $action)
    {
        return $module . "/" . $controller . "/" . $action;
    }    
}
