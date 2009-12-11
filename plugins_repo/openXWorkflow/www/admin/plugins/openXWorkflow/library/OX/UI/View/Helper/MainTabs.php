<?php

class OX_UI_View_Helper_MainTabs extends OX_UI_View_Helper_WithViewScript
{
    public static function mainTabs(OX_UI_Menu_Section $section = null)
    {
        if ($section) {
            return parent::renderViewScript("main-tabs.html", array (
                    'model' => $section->buildModel(OX_UI_Menu_Section::LEVEL_TAB_MAIN)));
        }
        else {
            return '';
        }
    }
}
