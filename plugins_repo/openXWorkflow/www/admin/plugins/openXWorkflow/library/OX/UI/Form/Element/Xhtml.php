<?php

/**
 * An elements that allows inserting arbitrary XHTML code (without escaping) into the form.
 * <b>Please use this element as a last resort, consider using standard elements (or 
 * implementing a custom one) wherever possible.  
 */
class OX_UI_Form_Element_Xhtml extends Zend_Form_Element_Xhtml
{
    /** XHTML to be output */
    protected $content;

    public function loadDefaultDecorators()
    {
        $this->addDecorator('Xhtml', 
            array('content' => $this->content));
    }
}
