<?php

class OX_UI_View_Helper_LeftMenu extends OX_UI_View_Helper_WithViewScript
{
    public static function leftMenu(OX_UI_Menu_Section $section = null)
    {
        if ($section) {
            return parent::renderViewScript("left-menu.html", array (
                    'model' => $section->buildModel(OX_UI_Menu_Section::LEVEL_LEFT_MAIN)));
        }
        else {
            return '';
        }
    }
}
