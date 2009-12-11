<?php

/**
 * A decorator that renders custom OX-specific form element labels.
 */
class OX_UI_Form_Decorator_RequiredInfo extends Zend_Form_Decorator_Abstract
{

    public function render($content)
    {
        // TODO: run the string through translation
        return OX_UI_Form_Decorator_Utils::wrap(
            "* Required fields", 
            array('tag' => 'span', 
                'class' => 'requirements')) . $content;
    }
}
