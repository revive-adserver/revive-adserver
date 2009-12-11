<?php

/**
 * OX-specific radio buttons element.
 */
class OX_UI_Form_Element_Radio extends Zend_Form_Element_Radio
{
    protected $_validationEnabledCallback;

    public function init()
    {
        $this->setSeparator("</li><li>");
        $this->setAttrib('noForAttribute', true);
    }

    public function loadDefaultDecorators()
    {
        parent::loadDefaultDecorators();
        $this->addDecorator(array('LiWrapperTag' => 'HtmlTag'), 
            array('tag' => 'li'));
        $this->addDecorator(array('UlWrapperTag' => 'HtmlTag'), 
            array('tag' => 'ul', 
                'class' => 'optionList'));
    }

    public function setWidth($width)
    {
        $this->setAttrib('label_class', $width);
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
}
