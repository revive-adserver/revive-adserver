<?php

/**
 * A decorator that renders the Xhtml element content without escaping, replacing the 
 * original content. <b>Please use this decorator as a last resort, consider using 
 * standard elements, view-script based decorators or implementing a custom decorator 
 * wherever possible.
 */
class OX_UI_Form_Decorator_Xhtml extends Zend_Form_Decorator_Abstract
{

    public function render($content)
    {
        $element = $this->getElement();
        $view = $element->getView();
        if (null === $view) {
            return $content;
        }
        
        return $element->getAttrib('content');
    }
}