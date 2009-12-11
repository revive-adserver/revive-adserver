<?php

class OX_UI_View_Helper_BalloonHint extends OX_UI_View_Helper_WithViewScript
{
    public static function balloonHint($hint)
    {
        return parent::renderViewScript("balloon-hint.html", array (
                'message' => $hint));
    }
}
