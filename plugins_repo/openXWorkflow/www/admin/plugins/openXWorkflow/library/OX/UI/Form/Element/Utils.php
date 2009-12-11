<?php

/**
 * A number of common utility methods used in OX form elements.
 */
class OX_UI_Form_Element_Utils
{
    /**
     * Controls visibility of the provided element by means of the 'hide' CSS class. 
     * 
     * @param $element
     * @param $visible <code>true</code> to make the element visible, <code>false</code> 
     *         to make the element invisible
     * @return $element for convenience
     */
    public static function setVisible($element, $visible)
    {
        if ($visible) {
            self::removeClassInElementOptions($element, 'hide');
        } else {
            self::addClassInElementOptions($element, 'hide');
        }
        return $element;
    }
    
    
    /**
     * Returns <code>true</code> if the provided element is visible. Element is assumed
     * to be visible if it does not have the 'hide' CSS class. In practice, the element
     * may be invisible even if this function returns <code>true</code> due to other
     * factors that are beyond the scope of this function.
     * 
     * @param $element
     * @return <code>true</code> if the element is visible, <code>false</code> otherwise
     */
    public static function isVisible($element)
    {
        return (!self::isClassSetInElement($element, 'hide') && 
            (!$element->getAttrib('line') || self::isVisible($element->getAttrib('line'))));        
    }
    
    
    /**
     * Adds an entry to an HTML class attribute. If the string already
     * exists in the attribute value, nothing is changed.
     * 
     * @return string
     */
    public static function addClass($class, $value)
    {
        if (strlen($class) == 0) {
            return $value;
        }
        
        if (strpos($class, ' ' . $value) === false && strpos($class, 
            $value . ' ') === false) {
            return $class . ' ' . $value;
        } else {
            return $class;
        }
    }

    
    public static function removeClass($class, $value)
    {
        if (strlen($class) == 0 || strlen($value) == 0) {
            return $class;
        }

        $split = explode(' ', $class);
        return implode(' ', array_diff($split, array($value)));
    }
    
    
    public static function addClassInOptions(&$options, $value, $classKey = 'class')
    {
        if (isset($options[$classKey])) {
            $options[$classKey] = self::addClass($options[$classKey], $value);
        } else {
            $options[$classKey] = $value; 
        }
    }
    
    
    public static function addClassInElementOptions($element, $value)
    {
        $element->setAttrib('class', self::addClass($element->getAttrib('class'), $value));
    }
    
    
    public static function removeClassInElementOptions($element, $value)
    {
        if (empty($element)) {
            OX_Common_Log::backtrace();
        }
        $element->setAttrib('class', self::removeClass($element->getAttrib('class'), $value));
    }

    
    public static function isClassSetInElement($element, $value)
    {
        $class = $element->getAttrib('class');
        if (!empty($class)) {
            return in_array($value, explode(' ', $class));
        }
        else {
            return false; 
        }
    }
}
