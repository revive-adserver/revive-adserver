<?php

/**
 * A header for entity list, edit and add pages. Provides support for generating rich
 * title with links to parent entities and breadcrumbs.
 */
class OX_UI_Page_Entity_Header extends OX_UI_Page_Header
{
    /** Page for adding entities */
    const PAGE_TYPE_ADD = 'add';
    
    /** Page for editing entities */
    const PAGE_TYPE_EDIT = 'edit';
    
    /** Page with lists of entities */
    const PAGE_TYPE_LIST = 'list';
    
    /** Page type */
    private $type;
    
    /**
     * Information about the main entity the page is handling.
     * 
     * @var OX_UI_Page_EntityInfo
     */
    private $entityInfo;
    
    /**
     * Instances of OX_UI_Page_EntityInfo for the current entity's parents (if any) to 
     * form breadcrumbs.
     * 
     * @var array
     */
    private $breadcrumbs;
    
    /**
     * Builds the header instance for the provided page type, entity and parent entity.
     * 
     * @param $oEntityOrClassName the actual entity or entity class name if the entity
     * does not exist yet (e.g. on entity add screen).
     * @param $oParentEntity parent entity or null if the entity does not have a
     * displayable parent entity.
     *      */
    public function __construct($type, $oEntityOrClassName, $oParentEntity)
    {
        $this->type = $type;
        $this->entityInfo = OX_UI_Page_EntityInfo::getEntityInfo($oEntityOrClassName, $oParentEntity);
        $this->breadcrumbs = self::getPageEntityBreadcrumbs($oEntityOrClassName, $oParentEntity);
    }
    
    /**
     * Builds page title in a plain text form, suitable for e.g. browser window title.
     */
    public function getTitleText()
    {
        $result = '';
        
        switch ($this->type) {
            case OX_UI_Page_Entity_Header::PAGE_TYPE_LIST :
                $result .= $this->entityInfo->getTypeNamePlural();
                if (count($this->breadcrumbs) > 0 && $this->breadcrumbs [0]) {
                    $parent = $this->breadcrumbs [0];
                    $result .= ' ' . $parent->getTypeNamePossesive() . ' ' . $parent->getEntity()->getName();
                }
                return $result;
            
            case OX_UI_Page_Entity_Header::PAGE_TYPE_EDIT :
                $result .= $this->entityInfo->getTypeNameSingular() . ' ' . $this->entityInfo->getEntity()->getName();
                return $result;
            
            case OX_UI_Page_Entity_Header::PAGE_TYPE_ADD :
                $result .= $this->entityInfo->getTypeNameAdd();
                return $result;
        }
        
        throw new Exception("Unknown page type: " . $this->type);
    }
    
    /**
     * Builds page title in an XHTML form, suitable for page header.
     */
    public function getTitleXhtml()
    {
        $result = '';
        
        switch ($this->type) {
            case OX_UI_Page_Entity_Header::PAGE_TYPE_LIST :
                $result .= '<span class="label">' . $this->entityInfo->getTypeNamePlural() . '</span>';
                if (count($this->breadcrumbs) > 0 && $this->breadcrumbs [0]) {
                    $parent = $this->breadcrumbs [0];
                    $result .= ' ' . $parent->getTypeNamePossesive();
                    $result .= ' <a href="' . $parent->getEntityEditUrl() . '">' . htmlspecialchars($parent->getEntity()->getName()) . "</a>";
                }
                return $result;
            
            case OX_UI_Page_Entity_Header::PAGE_TYPE_EDIT :
                $result .= '<span class="label">' . $this->entityInfo->getTypeNameSingular() . '</span>';
                $result .= ' ' . htmlspecialchars($this->entityInfo->getEntity()->getName());
                return $result;
            
            case OX_UI_Page_Entity_Header::PAGE_TYPE_ADD :
                $result .= '<span class="label">' . $this->entityInfo->getTypeNameAdd() . '</span>';
                return $result;
        }
        
        throw new Exception("Unknown page type: " . $this->type);
    }
    
    /**
     * Builds icon CSS class for this page's header, ready to be inserted into the markup.
     */
    public function getIconCssClass()
    {
        $type = '';
        if ($this->type == self::PAGE_TYPE_ADD) {
            $type = 'Add';
        }
        return 'icon' . $this->entityInfo->getIcon() . $type . 'Large';
    }
    
    /**
     * Returns true if this header has breadcrumbs.
     */
    public function hasBreadcrumbs()
    {
        return count($this->breadcrumbs) > 0;
    }
    
    /**
     * Returns an array of page page breadcrumbs.
     * 
     * @return array
     */
    public function getBreadcrumbsXhtml()
    {
        switch ($this->type) {
            case OX_UI_Page_Entity_Header::PAGE_TYPE_LIST :
                return $this->getSelectBreadcrumbsXhtml();
            
            case OX_UI_Page_Entity_Header::PAGE_TYPE_ADD :
            case OX_UI_Page_Entity_Header::PAGE_TYPE_EDIT :
                return $this->getLinkBreadcrumbsXhtml();
        }
        
        throw new Exception("Unknown page type: " . $this->type);
    }
    
    /**
     * Builds link-based breadcrumbs for navigating to the parent entity.
     */
    private function getLinkBreadcrumbsXhtml()
    {
        $xhtml = array ();
        foreach ($this->breadcrumbs as $bcInfo) {
            if ($bcInfo->getEntity()) {
                $xhtml [] = $this->getLinkBreadcrumbXhtml($bcInfo);
            }
        }
        
        return $xhtml;
    }
    
    private function getLinkBreadcrumbXhtml($bcInfo)
    {
        $bc = '<a class="ent inlineIcon icon' . $bcInfo->getIcon() . '" ';
        $bc .= 'href="' . $bcInfo->getEntityEditUrl() . '">';
        $bc .= $bcInfo->getTypeNameSingular() . ' ' . htmlspecialchars($bcInfo->getEntity()->getName()) . '</a>';
        return $bc;
    }
    
    /**
     * Builds select-based breadcrumbs for navigating between parent entities, useful
     * on list pages.
     */
    private function getSelectBreadcrumbsXhtml()
    {
        $xhtml = array ();
        
        foreach ($this->breadcrumbs as $bcInfo) {
            $xhtml [] = $this->getSelectBreadcrumbXhtml($bcInfo);
        }
        
        return $xhtml;
    }
    
    private function getSelectBreadcrumbXhtml($bcInfo)
    {
        if (count($bcInfo->getSiblingMultiOptions()) <= 1)
        {
            return $this->getLinkBreadcrumbXhtml($bcInfo);
        }
        
        $view = Zend_Registry::getInstance()->get('smartyView');
        $selectHelper = new Zend_View_Helper_FormSelect();
        $selectHelper->setView($view);
        
        $entityInfo = $this->entityInfo;
        
        $actionUrl = OX_UI_View_Helper_ActionUrl::actionUrl($entityInfo->getListAction(), $entityInfo->getController(), $entityInfo->getModule());
        
        $bc = '<form class="nofocus" action="' . $actionUrl . '">';
        $bc .= '<label class="inlineIcon icon' . $bcInfo->getIcon() . '">';
        $bc .= $bcInfo->getTypeNameSingular();
        $bc .= $selectHelper->formSelect($bcInfo->getEntityIdParam(), $bcInfo->getEntityId(), array (
                'class' => 'submit-on-change'), $bcInfo->getSiblingMultiOptions(), '\n');
        $bc .= '</label></form>';
        
        return $bc;
    }
    
    /**
     * Builds breadcrumbs array for the provided entity and parent entity.
     */
    private static function getPageEntityBreadcrumbs($oEntity, $oParentEntity = null)
    {
        $entityClass = OX_Common_ClassUtils::getClass($oEntity);
        
        switch ($entityClass) {
            case 'AcPlacement' :
                if ($oParentEntity) {
                    return array (
                            OX_UI_Page_EntityInfo::getEntityInfo($oParentEntity, $oParentEntity->getAccount()));
                } else {
                    return array ();
                }
        }
        
        return array ();
    }
}
