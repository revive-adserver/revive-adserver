<?php

/**
 * A base class for pages handling specific entities in the system, such as creatives, 
 * campaigns or placements.
 */
class OX_UI_Controller_EntityPage extends OX_UI_Controller_ContentPage
{
    /**
     * Adds a rich header to this page.
     *
     * @param $pageType page type, see constants in OX_UI_Page_Entity_Header
     * @param $oEntityOrClassName the actual entity or entity class name if the entity
     * does not exist yet (e.g. on entity add screen).
     * @param $oParentEntity parent entity or null if the entity does not have a
     * displayable parent entity.
     */
    protected function addEntityHeader($pageType, $oEntityOrClassName, 
            $parentEntity = null)
    {
        $this->view->header = new OX_UI_Page_Entity_Header($pageType, $oEntityOrClassName, $parentEntity);
    }
    
    /**
     * Adds a rich header to an entity list page.
     *
     * @param $oEntityClassName the entity class name for which the list is displayed.
     * @param $oParentEntity parent entity or null if the entity does not have a
     * displayable parent entity.
     */
    protected function addEntityListHeader($oEntityClassName, $parentEntity = null)
    {
        $this->addEntityHeader(OX_UI_Page_Entity_Header::PAGE_TYPE_LIST, $oEntityClassName, $parentEntity);
    }
    
    /**
     * Adds a rich header to an edit entity page.
     *
     * @param $oEntity the actual entity
     * @param $oParentEntity parent entity or null if the entity does not have a
     * displayable parent entity.
     */
    protected function addEntityEditHeader($oEntity, $parentEntityOrClassName = null)
    {
        $this->addEntityHeader(OX_UI_Page_Entity_Header::PAGE_TYPE_EDIT, $oEntity, $parentEntityOrClassName);
    }
    
    /**
     * Adds a rich header to an add entity page.
     *
     * @param $oEntityClassName the entity class name for the entity being added
     * @param $oParentEntity parent entity or null if the entity does not have a
     * displayable parent entity.
     */
    protected function addEntityAddHeader($entityClassName, 
            $parentEntityOrClassName = null)
    {
        $this->addEntityHeader(OX_UI_Page_Entity_Header::PAGE_TYPE_ADD, $entityClassName, $parentEntityOrClassName);
    }
}
