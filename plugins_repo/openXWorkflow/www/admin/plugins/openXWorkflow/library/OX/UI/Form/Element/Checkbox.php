<?php

/**
 * OX-specific checkbox. The label is by default taken from the element's 'label' attribute.
 * If the element also has a 'text' attribute, 'text' is displayed next to the checkbox and
 * 'label' is displayed above the checkbox, just as for other for elements.
 */
class OX_UI_Form_Element_Checkbox extends Zend_Form_Element_Checkbox
{
    protected $_text;
    
    protected $_prefix;
    
    protected $_suffix;
    
    protected $class = "typeCheckbox";


    public function loadDefaultDecorators()
    {
        parent::loadDefaultDecorators();
        
        if (strlen($this->_prefix) > 0) {
            $this->addDecorator(array (
                    'PrefixCustomLabel' => 'CustomLabel'), array (
                    'labelText' => $this->_prefix, 
                    'class' => 'affix affixCheckbox'));
        }
        
        $label = '';
        if ($this->_text) {
            $label = $this->_text;
        }
        else {
            $label = $this->getLabel();
            $this->setLabel('');
        }
        
        $labelDecorator = new OX_UI_Form_Decorator_CustomLabel(array (
                'labelText' => $label));
        $labelDecorator->setOption('placement', 'APPEND');
        $this->addDecorator($labelDecorator);
        
        if (strlen($this->_suffix) > 0) {
            $this->addDecorator(array (
                    'SuffixCustomLabel' => 'CustomLabel'), array (
                    'labelText' => $this->_suffix, 
                    'class' => 'affix affixCheckbox', 
                    'placement' => 'APPEND'));
        }
    }


    public function setText($text)
    {
        $this->_text = $text;
    }


    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
    }


    public function setSuffix($suffix)
    {
        $this->_suffix = $suffix;
    }
}
