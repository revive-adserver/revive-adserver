<?php

class OX_UI_View_Helper_ContentTabs extends OX_UI_View_Helper_WithViewScript
{
    public static function contentTabs($section)
    {
        if ($section) {
            return parent::renderViewScript("content-tabs.html", array (
                    'model' => $section->buildModel(OX_UI_Menu_Section::LEVEL_TAB_CONTENT)));
        }
        else {
            return '';
        }
    }
}
