<?php

class OX_UI_View_Helper_ContextBox extends OX_UI_View_Helper_WithViewScript
{
    public static function contextBox($title, $cssClass,  $shortcuts)
    {
        return parent::renderViewScript("context-box.html", array (
                'shortcuts' => $shortcuts, 
                'title' => $title,
                'cssClass' => $cssClass));
    }
}
