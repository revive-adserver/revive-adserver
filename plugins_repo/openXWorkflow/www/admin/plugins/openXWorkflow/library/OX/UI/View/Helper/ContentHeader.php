<?php

class OX_UI_View_Helper_ContentHeader extends OX_UI_View_Helper_WithViewScript
{
    /**
     * 
     */
    public static function contentHeader($header)
    {
        return parent::renderViewScript("content-header.html", array (
                'header' => $header));
    }
}
