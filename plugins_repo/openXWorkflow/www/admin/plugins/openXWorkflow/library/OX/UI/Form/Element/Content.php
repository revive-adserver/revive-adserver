<?php

/**
 * Renders arbitrary content in a form element placeholder.
 */
class OX_UI_Form_Element_Content extends Zend_Form_Element_Xhtml
    implements OX_UI_Form_Element_WithAffixes
{
    public $helper = 'formContent';
    
    protected $_width;
    
    protected $_height;
    
    protected $_prefix;
    
    protected $_suffix;


    public function init()
    {
        parent::init();
        if ($this->_width != null) {
            OX_UI_Form_Element_Widths::addWidthClass($this);
        }
    }


    public function loadDefaultDecorators()
    {
        OX_UI_Form_Element_WithAffixesUtils::addAllDecorators($this);
    }

    
    public function getPrefix()
    {
        return $this->_prefix;
    }
    
    
    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
    }

    
    public function getSuffix()
    {
        return $this->_suffix;
    }
    
    
    public function setSuffix($suffix)
    {
        $this->_suffix = $suffix;
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


    public function setWidth($width)
    {
        $this->_width = $width;
        $this->setAttrib('width', $width);
    }


    public function getWidth()
    {
        return $this->_width;
    }


    public function setHeight($height)
    {
        $this->setClass($height);
        $this->setAttrib('height', $height);
    }


    public function getHeight()
    {
        return $this->_width;
    }
}
