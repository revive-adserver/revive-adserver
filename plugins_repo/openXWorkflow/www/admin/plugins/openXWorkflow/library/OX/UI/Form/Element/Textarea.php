<?php

/**
 * OX-specific text input.
 */
class OX_UI_Form_Element_Textarea extends Zend_Form_Element_Textarea 
    implements OX_UI_Form_Element_WithAffixes 
{
    protected $_width;
    
    protected $_prefix;
    
    protected $_suffix;
    
    protected $_validationEnabledCallback;


    public function init()
    {
        parent::init();
        OX_UI_Form_Element_Widths::addWidthClass($this);
    }


    public function loadDefaultDecorators()
    {
        OX_UI_Form_Element_WithAffixesUtils::addAllDecorators($this);
    }
    
    
    public function setWidth($width)
    {
        $this->_width = $width;
    }


    public function getWidth()
    {
        return $this->_width;
    }


    public function setHeight($height)
    {
        $this->setClass($height);
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


    public function getValidationEnabledCallback()
    {
        return $this->_validationEnabledCallback;
    }
    
    
    public function setValidationEnabledCallback(array $callback)
    {
        $this->_validationEnabledCallback = $callback;
    }


    /**
     * Overridden to support conditional validation.
     */
    public function isValid($value, $context = null)
    {
        if (count($this->_validationEnabledCallback) == 2 && call_user_func($this->_validationEnabledCallback, $value, $context) === false) {
            return true;
        }
        else {
            return parent::isValid($value, $context);
        }
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
}