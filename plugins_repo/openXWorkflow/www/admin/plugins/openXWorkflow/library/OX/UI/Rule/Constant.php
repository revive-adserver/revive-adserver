<?php

/**
 * A base class for constant (one set value) rules.
 */
abstract class OX_UI_Rule_Constant extends OX_UI_Rule
{
    public abstract function getLabel();
    
    /**
     *
     */
    public function addRuleElementsWithLine(Zend_Form $oForm, 
            array $lineOptions = array())
    {
        $oForm->addElementWithLine('label', $this->type, $this->getLineName(), array (
                'width' => OX_UI_Form_Element_Widths::LARGE, 
                'labelText' => $this->getLabel()), $lineOptions);
    }
    
    public function populateForm(OX_UI_Form $oForm)
    {
        // Do nothing
    }
}
