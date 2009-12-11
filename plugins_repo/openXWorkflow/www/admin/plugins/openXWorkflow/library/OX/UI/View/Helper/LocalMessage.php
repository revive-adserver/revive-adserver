<?php

class OX_UI_View_Helper_LocalMessage extends OX_UI_View_Helper_WithViewScript
{
    public static function localMessage($message, $messageType = 'info', $scope = 'local')
    {
        return parent::renderViewScript("message-with-placeholder.html", array (
                'message' => $message, 
                'messageType' => $messageType, 
                'messageScope' => $scope));
    }
}
