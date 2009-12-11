<?php

class OX_UI_View_Helper_TableDropdown 
    extends OX_UI_View_Helper_WithViewScript
{
    /**
     * Should be an array of label to link
     *
     * @param unknown_type $aOptions
     * @return unknown
     */
    public static function tableDropdown($aOptions, $current = 0)
    {
        if (is_array($aOptions) && !empty($aOptions)) {
            $aItems = $aOptions;
            $currentItem = $aOptions[$current]['label'];
        }
        else {
            $aItems = array();
            $currentItem = '-';
        }
        
        return parent::renderViewScript("table-dropdown.html", array (
                'aItems' => $aItems, 
                'selected' => $currentItem));
    }
}
