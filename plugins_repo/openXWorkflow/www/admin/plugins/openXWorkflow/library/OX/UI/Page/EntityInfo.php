<?php

/**
 * An entity model used to generate headers (rich title and breadcrubms) for entity
 * edit, add and list pages.
 */

class OX_UI_Page_EntityInfo
{
    /**
     * The entity object or a string being its class.
     */
    private $entity;
    
    /**
     * Id of the entity. If we get a common interface for entities with ids (Identifiable),
     * we can get rid of this. 
     */
    private $entityId;
    
    /**
     * Multioptions corresponding to the entity's siblings (e.g. other campaigns). This
     * can be used to generate breadcrumbs.
     */
    private $aSiblingMultiOption;
    
    /**
     * Icon corresponding to the entity. The prefixes ('icon') and suffixes ('Add', 'Large')
     * will be added automatically.
     */
    private $icon;
    
    /**
     * Current entity edit action name.
     */
    private $editAction;
    
    /**
     * Current entity list action name.
     */
    private $listAction;
    
    /**
     * Current entity controller name.
     */
    private $controller;
    
    /**
     * Current entity module name.
     */
    private $module;
    
    /**
     * Current entity id parameter name, used to generate breadcrumbs.
     */
    private $entityIdParam;
    
    /**
     * Current entity singular type name, e.g. "Campaign".
     */
    private $typeNameSingular;
    
    /**
     * Current entity plural type name, e.g. "Campaigns".
     */
    private $typeNamePlural;
    
    /**
     * Current entity possesive type name, e.g. "in Campaign".
     */
    private $typeNamePossesive;
    
    /**
     * Current entity add type name, e.g. "Add Campaign".
     */
    private $typeNameAdd;
    
    /**
     * Builds a new entity info, see field documentation for details. Use the 
     * getEntityInfo() factory method to obtain instances.
     */
    private function __construct($oEntity, $entityId, $aSiblingMultiOption, 
            $iconCssClassBase, $controller, $module, 
            $editAction, $listAction, $entityIdParam, 
            $typeNameSingular, $typeNamePlural, 
            $typeNameAdd, $typeNamePossesive = null)
    {
        $this->entity = $oEntity;
        $this->entityId = $entityId;
        $this->aSiblingMultiOption = $aSiblingMultiOption;
        
        $this->typeNameSingular = $typeNameSingular;
        $this->typeNamePlural = $typeNamePlural;
        $this->typeNamePossesive = $typeNamePossesive;
        $this->typeNameAdd = $typeNameAdd;
        
        $this->icon = $iconCssClassBase;
        
        $this->controller = $controller;
        $this->module = $module;
        $this->editAction = $editAction;
        $this->listAction = $listAction;
        
        $this->entityIdParam = $entityIdParam;
    }
    
    /**
     * Builds an entity info for the provided entity and parent entity.
     * 
     * @param $oEntityOrClassName the actual entity or entity class name if the entity
     * does not exist yet (e.g. on entity add screen).
     * @param $oParentEntity parent entity or null if the entity does not have a
     * displayable parent entity.
     */
    public static function getEntityInfo($oEntityOrClassName, $oParentEntity = null)
    {
        $entityClass = OX_Common_ClassUtils::getClass($oEntityOrClassName);
        
        switch ($entityClass) {
            case 'AcCampaign' :
                return new OX_UI_Page_EntityInfo($oEntityOrClassName, $oEntityOrClassName && is_object($oEntityOrClassName) ? $oEntityOrClassName->getCampaignId() : null, $oParentEntity ? OX_Common_ArrayUtils::biject($oParentEntity->getCampaigns(), 'campaign_id', 'name') : null, 'Campaign', 'campaigns', 'advertiser', 'edit', 'list', 'campaignId', 'Campaign', 'Campaigns', 'Add Campaign', 'in Campaign');
            
            case 'AcCreative' :
                return new OX_UI_Page_EntityInfo($oEntityOrClassName, $oEntityOrClassName && is_object($oEntityOrClassName) ? $oEntityOrClassName->getCreativeId() : null, $oParentEntity ? OX_Common_ArrayUtils::biject($oParentEntity->getCreatives(), 'creative_id', 'name') : null, 'Creative', 'creatives', 'advertiser', 'edit', 'list', 'creativeId', 'Creative', 'Creatives', 'Add Creative');
            
            case 'AcPlacement' :
                return new OX_UI_Page_EntityInfo($oEntityOrClassName, $oEntityOrClassName && is_object($oEntityOrClassName) ? $oEntityOrClassName->getPlacementId() : null, $oParentEntity ? OX_Common_ArrayUtils::biject($oParentEntity->getPlacements(), 'placement_id', 'name') : null, 'Placement', 'placements', 'advertiser', 'edit', 'list', 'placementId', 'Placement', 'Placements', 'Add Placement');
                
            case 'AcPiggybackPixel' :
                return new OX_UI_Page_EntityInfo($oEntityOrClassName, 
                    $oEntityOrClassName && is_object($oEntityOrClassName) ? $oEntityOrClassName->getId() : null, 
                    null, 'Tag', 'account', 'retargeting-tags', 'edit', 'list', 'retargetingTagId', 
                    'Retargeting Tag', 'Retargeting Tags', 'Add Retargeting Tag', '');
        }
        
        throw new Exception("Unknown entity class: " . $entityClass);
    }
    
    /**
     * Returns edit url for this entity. 
     */
    public function getEntityEditUrl()
    {
        return OX_UI_View_Helper_ActionUrl::actionUrl($this->getEditAction(), $this->getController(), $this->getModule(), array (
                $this->getEntityIdParam() => $this->getEntityId()));
    }
    
    public function getSiblingMultiOptions()
    {
        return $this->aSiblingMultiOption;
    }
    
    public function getEditAction()
    {
        return $this->editAction;
    }
    
    public function getListAction()
    {
        return $this->listAction;
    }
    
    public function getController()
    {
        return $this->controller;
    }
    
    public function getModule()
    {
        return $this->module;
    }
    
    public function getEntity()
    {
        return $this->entity;
    }
    
    public function getEntityId()
    {
        return $this->entityId;
    }
    
    public function getIcon()
    {
        return $this->icon;
    }
    
    public function getTypeNamePlural()
    {
        return $this->typeNamePlural;
    }
    
    public function getTypeNamePossesive()
    {
        return $this->typeNamePossesive;
    }
    
    public function getTypeNameSingular()
    {
        return $this->typeNameSingular;
    }
    
    public function getTypeNameAdd()
    {
        return $this->typeNameAdd;
    }
    
    public function getEntityIdParam()
    {
        return $this->entityIdParam;
    }
}
