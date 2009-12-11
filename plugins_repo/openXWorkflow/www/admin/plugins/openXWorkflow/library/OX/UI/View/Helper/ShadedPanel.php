<?php

class OX_UI_View_Helper_ShadedPanel extends OX_UI_View_Helper_WithViewScript
{
    public static function shadedPanel($content, $class = '', $id='', $style = '')
    {
        return parent::renderViewScript("shaded-panel.html", array (
                'content' => $content, 
                'style' => $style, 
                'id' => $id, 
                'class' => $class));
    }
}
