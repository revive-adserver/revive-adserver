<?php

/**
 * A header for entity list, edit and add pages. Provides support for generating rich
 * title with links to parent entities and breadcrumbs.
 */
class OX_UI_Page_Entity_SimpleHeader extends OX_UI_Page_Header
{
    /**
     * Entity name to append to page title
     * 
     * @var string
     */
    private $entityName;
    
    
    /**
     * Builds the header instance for the provided entityName and pageTitle.
     * Basically, it concatenates page title with entity name, adding additional markup
     * and escaping both.
     * 
     * @param $oEntityOrClassName the actual entity or entity class name if the entity
     * does not exist yet (e.g. on entity add screen).
     * @param $oParentEntity parent entity or null if the entity does not have a
     * displayable parent entity.
     *      */
    public function __construct($pageTitle, $entityName = null, $icon = null)
    {
        parent::__construct($pageTitle, $icon);
        $this->entityName = $entityName;
    }
    
    
    /**
     * Builds page title in an XHTML form, suitable for page header.
     */
    public function getTitleXhtml()
    {
        $result = '<span class="label">' . htmlspecialchars($this->getTitleText()) . '</span>'
                  .$this->entityName;
        
        return $result;
    }
}