<?php

/**
 * A helper for displaying text view of boollean value.
 */
class OX_UI_View_Helper_BooleanView
{
    public function booleanView($value, $trueText = null, $falseText = null, $icon = false)
    {
        $result = $value === true ? ($trueText ? $trueText : 'YES') : ($falseText ? $falseText : 'NO'); 
        
        if ($icon) 
        {
            if ($value === true) {
                $result = '<span class="tick" title="' . $result . '"><span>' . $result . '</span></span>';
            } else {
                $result = '';
            }
        } 
        
        return $result;
    }
}
