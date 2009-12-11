<?php

/**
 * A customization of standard Zend's label that renders the directly provided label
 * instead of the label taken from the element. Additionally, this decorator by default
 * switches off the escaping of label content. 
 */
class OX_UI_Form_Decorator_CustomLabel extends Zend_Form_Decorator_Label
{
    private $labelText;
    
    public function __construct($options = array())
    {
        if (isset($options['labelText'])) {
            $this->labelText = $options['labelText'];
            unset($options['labelText']);
        }
        $options['escape'] = false;
        $this->setOptions($options);
    }
    
    public function getClass()
    {
        $element = $this->getElement();
        if (isset($element) && OX_UI_Form_Element_Utils::isClassSetInElement($element, 'hide')) {
            return OX_UI_Form_Element_Utils::addClass($element->getAttrib('class'), 'hide');
        } 
        else {
            return $this->getOption('class');
        }
    }
    
    public function getLabel()
    {
        if (null === ($element = $this->getElement())) {
            return '';
        }
        
        $label = $this->labelText;
        $label = trim($label);

        if (empty($label)) {
            return '';
        }

        if (null !== ($translator = $element->getTranslator())) {
            $label = $translator->translate($label);
        }

        $optPrefix = $this->getOptPrefix();
        $optSuffix = $this->getOptSuffix();
        $reqPrefix = $this->getReqPrefix();
        $reqSuffix = $this->getReqSuffix();

        if (!empty($label)) {
            if ($element->isRequired()) {
                $label = $reqPrefix . $label . $reqSuffix;
            } else {
                $label = $optPrefix . $label . $optSuffix;
            }
        }

        return $label;
    }
}
