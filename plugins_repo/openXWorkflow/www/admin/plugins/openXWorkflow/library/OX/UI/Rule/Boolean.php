<?php

/**
 * A base class for boolean rule elements.
 */
abstract class OX_UI_Rule_Boolean extends OX_UI_Rule
{
    protected $hasNotRelevantOperatorValue = true;


    public function __construct($hasNotRelevantOperatorValue = true)
    {
        $this->hasNotRelevantOperatorValue = $hasNotRelevantOperatorValue;
    }


    public abstract function getBooleanValue();
    
    
    public abstract function populateRuleValue($booleanValue);


    public function getTrueLabel()
    {
        return 'Supported';
    }


    public function getTrueValue()
    {
        return true;
    }


    public function getFalseLabel()
    {
        return 'Not Supported';
    }


    public function getFalseValue()
    {
        return false;
    }


    public function getNullLabel()
    {
        return 'Not Relevant';
    }


    public function getNullValue()
    {
        return "-2";
    }


    protected function isNullValue($value)
    {
        return $value === $this->getNullValue();
    }


    /**
     * Adds the boolean radio selection elements.
     */
    public function addRuleElementsWithLine(OX_UI_Form $oForm, 
            array $lineOptions = array())
    {
        $options = array ();
        if ($this->hasNotRelevantOperatorValue) {
            $options[$this->getNullValue()] = $this->getNullLabel();
        }
        $options[$this->getTrueValue()] = $this->getTrueLabel();
        $options[$this->getFalseValue()] = $this->getFalseLabel();
        
        $oForm->addElementWithLine('radio', $this->type, $this->getLineName(), array (
                'width' => OX_UI_Form_Element_Widths::LARGE, 
                'multiOptions' => $options), $lineOptions);
    }


    public function populateForm(OX_UI_Form $form)
    {
        $form->populate(array (
                $this->type => $this->isEmpty() ? $this->getNullValue() : $this->getBooleanValue()));
    }


    public function populateRule(OX_UI_Form $form)
    {
        $value = $form->getValue($this->type);
        if ($this->isNullValue($value)) {
            $this->clearRule();
        }
        else {
            $this->populateRuleValue($value);
        }
    }


    public function renderRuleExpression()
    {
        return '<em>' . $this->label . '</em>: ' . ($this->getBooleanValue() ? $this->getTrueLabel() : $this->getFalseLabel());
    }
}
