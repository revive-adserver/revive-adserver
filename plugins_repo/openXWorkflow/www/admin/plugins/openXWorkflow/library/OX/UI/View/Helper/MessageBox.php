<?php

class OX_UI_View_Helper_MessageBox extends OX_UI_View_Helper_WithViewScript
{
    public static function messageBox($message, $messageType = 'info', $messageScope = '')
    {
        return parent::renderViewScript("message.html", array (
                'message' => $message, 
                'messageType' => $messageType, 
                'messageScope' => $messageScope));
    }
}
