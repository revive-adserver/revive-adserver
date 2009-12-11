<?php

/**
 * A link that can be inserted into a form
 */
class OX_UI_Form_Element_Link extends Zend_Form_Element_Xhtml
{
    public $helper = 'formLink';
    
    public function addClass($value)
    {
        $this->class = OX_UI_Form_Element_Utils::addClass(
            $this->class, $value);
    }

    /**
     * <b>Appends</b> a value to the class attribute if the value does not exist there
     * yet. This is a bit of a hack: it's easiest to call this method setClass because
     * ZF will then handle setting the variables for us.
     */
    public function setClass($value)
    {
        $this->addClass($value);
    }
}