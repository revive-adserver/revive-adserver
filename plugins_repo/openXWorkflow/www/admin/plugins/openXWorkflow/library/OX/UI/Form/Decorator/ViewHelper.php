<?php

/**
 * Overridden to fix a strange issue with rendering form button values. See inside
 * for comments.
 */
class OX_UI_Form_Decorator_ViewHelper extends Zend_Form_Decorator_ViewHelper
{
    public function getValue($element)
    {
        if (!$element instanceof Zend_Form_Element) {
            return null;
        }

        foreach ($this->_buttonTypes as $type) {
            if ($element instanceof $type) {
                /**
                 * The fragment below, present in the original implementation
                 * needs to be removed. Otherwise, button values will not render
                 * and we wouldn't be able to tell which submit button was clicked.
                 */
                /*
                if (stristr($type, 'button')) {
                    $element->content = $element->getLabel();
                    return null;
                }
                */
                return $element->getLabel();
            }
        }

        return $element->getValue();
    }
}
