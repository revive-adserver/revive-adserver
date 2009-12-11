<?php

class OX_UI_View_Helper_ContextHelp extends OX_UI_View_Helper_WithViewScript
{
    public static function contextHelp()
    {
        //TODO get help link from navigation
        $helpLink = '';
        return parent::renderViewScript("context-help.html", array (
            'helpLink' => $helpLink));
    }
}
