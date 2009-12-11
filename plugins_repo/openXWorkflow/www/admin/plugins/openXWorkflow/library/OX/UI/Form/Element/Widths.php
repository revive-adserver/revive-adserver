<?php

/**
 * Contains constants describing OX-specific element widths.
 */
class OX_UI_Form_Element_Widths
{
    const EXTRA_LARGE = "widthExtraLarge";
    const LARGER = "widthLarger";
    const LARGE = "widthLarge";
    const MEDIUM_LARGE = "widthMediumLarge";
    const MEDIUM = "widthMedium";
    const MEDIUM_SMALL = "widthMediumSmall";
    const SMALL = "widthSmall";
    const EXTRA_SMALL = "widthExtraSmall";
    
    const DEFAULT_WIDTH = self::MEDIUM_LARGE;
    
    public static function addWidthClass($element)
    {
        $element->class = OX_UI_Form_Element_Utils::addClass($element->class, self::getWidthClass($element));
    }
    
    public static function getWidthClass($element)
    {
        $hasHint = $element->getAttrib('hint') !== null;
        $width = self::DEFAULT_WIDTH;
        if (method_exists($element, 'getWidth')) {
            $elementWidth = $element->getWidth();
            if ($elementWidth) {
                $width = $elementWidth;
            }
        }
        return $width . ($hasHint ? 'Hint' : '');
    }
}
