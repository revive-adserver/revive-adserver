<?php

/**
 * A header for simple content pages. Does not provide support for generating rich
 * title with links to parent entities and breadcrumbs, see OX_UI_Page_Entity_Header.
 */
class OX_UI_Page_Header
{
    /**
     * Page title.
     */
    private $titleText;
    
    /**
     * Page icon css class.
     */
    private $iconCssClass;
    
    public function __construct($title, $icon)
    {
        $this->titleText = $title;
        $this->iconCssClass = !empty($icon) ? 'icon' . $icon . 'Large' : '';
    }
    
    /**
     * Builds page title in a plain text non-escaped form, suitable for e.g. browser window 
     * title.
     */
    public function getTitleText()
    {
        return $this->titleText;
    }
    
    /**
     * Builds page title in an XHTML form, suitable for page header.
     */
    public function getTitleXhtml()
    {
        return '<span class="label">' . htmlspecialchars($this->titleText) . '</span>';
    }
    
    /**
     * Builds icon CSS class for this page's header, ready to be inserted into the markup.
     */
    public function getIconCssClass()
    {
        return $this->iconCssClass;
    }
    
    /**
     * Returns true if this header has breadcrumbs. Always returns false in this 
     * implementation.
     */
    public function hasBreadcrumbs()
    {
        return false;
    }
}