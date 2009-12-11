<?php

class OX_UI_View_Helper_TableHeader extends OX_UI_View_Helper_WithViewScript
{
    public static function tableHeader($tableActions = null, $contentAfter = null, 
            $contentBefore = null, $contentBeforeActions = null, $contentAfterActions = null)
    {
        if (!is_array($tableActions) && $tableActions != null)
        {
            $tableActions = array($tableActions);
        }
        
        return parent::renderViewScript("table-header.html", array (
                'tableActions' => $tableActions, 
                'contentBefore' => $contentBefore, 
                'contentAfter' => $contentAfter,
                'contentBeforeActions' => $contentBeforeActions, 
                'contentAfterActions' => $contentAfterActions
        ));
    }
}
