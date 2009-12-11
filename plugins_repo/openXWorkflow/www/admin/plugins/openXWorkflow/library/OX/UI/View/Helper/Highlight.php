<?php

class OX_UI_View_Helper_Highlight 
{
    public static function highlight($text, $search)
    {
        if (!empty($text) && !empty($search)) {
            $strPos = stripos($text,$search);
            if ($strPos !== false ) {
                $strLen = strlen($search);
                return  htmlspecialchars(substr($text, 0, $strPos)) .
                        "<b class='sr'>" . htmlspecialchars(substr($text, $strPos, $strLen)) . "</b>" .
                        htmlspecialchars(substr($text, $strPos+$strLen));
            }
        }
        
        return htmlspecialchars($text);
    }
    
}
