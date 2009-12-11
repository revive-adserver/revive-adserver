<?php

class OX_UI_View_Helper_ShadedBox extends OX_UI_View_Helper_WithViewScript
{
    public static function shadedBox($content, $class = '', $id='', $style = '')
    {
        return parent::renderViewScript("shaded-box.html", array (
                'content' => $content, 
                'style' => $style, 
                'id' => $id, 
                'class' => $class));
    }
}
