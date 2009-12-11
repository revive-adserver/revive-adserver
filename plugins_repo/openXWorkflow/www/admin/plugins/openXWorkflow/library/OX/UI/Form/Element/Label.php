<?php

/**
 * Renders a standalone label that does not necessarily points to a specific form
 * element.
 * 
 * The label text must be provided as the 'labelText' attribute (use setAttrib() or array 
 * constructor to set it), otherwise (if we use the standard 'value' attribute), the label 
 * texts would disappear when the form has validation errors.
 */
class OX_UI_Form_Element_Label extends Zend_Form_Element_Xhtml
{
    public $helper = 'standaloneLabel';

    protected $_width;
    
    protected $class = 'standalone';
    
    public function init()
    {
        parent::init();
        OX_UI_Form_Element_Widths::addWidthClass($this);
    }
    
    public function setWidth($width)
    {
        $this->_width = $width;
    }
    
    public function getWidth()
    {
        return $this->_width;
    }
    
    /**
     * <b>Appends</b> a value to the class attribute if the value does not exist there 
     * yet. This is a bit of a hack: it's easiest to call this method setClass because 
     * ZF will then handle setting the variables for us.
     */
    public function setClass($value)
    {
        $this->class = OX_UI_Form_Element_Utils::addClass($this->class, $value);
    }
}
