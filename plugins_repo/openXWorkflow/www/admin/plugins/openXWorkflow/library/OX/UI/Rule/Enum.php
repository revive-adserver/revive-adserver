<?php

/**
 * Base class for rules that take values from a predefined list.
 */
abstract class OX_UI_Rule_Enum extends OX_UI_Rule
{


    /**
     * Returns multi options for this rule. Should be implemented in concrete 
     * implementations.
     */
    abstract public function getMultiOptions();


    /**
     * Returns current values the specific rule has as strings.
     */
    abstract public function getStringValues();


    /**
     * Returns current values the specific rule has as identifiers to be used in the form
     * and in calls to the populateRuleValues() method.
     */
    abstract public function getEnumValues();


    /**
     * Populates values in the currently edited rule, called when the user accepts
     * changes made to the rule.
     */
    abstract public function populateRuleValues($values);


    /**
     * Determines whether multiple selections are allowed. Defaults to <code>true</code>.
     */
    public function isMultiSelect()
    {
        return true;
    }


    /**
     * Returns the rules main component width.
     */
    public function getWidth()
    {
        return OX_UI_Form_Element_Widths::LARGE;
    }


    /**
     * Returns the rules main component height.
     */
    public function getHeight()
    {
        return OX_UI_Form_Element_Heights::EXTRA_LARGE;
    }


    /**
     * Adds the enum-specific rule elements.
     */
    public function addRuleElementsWithLine(OX_UI_Form $form, 
            array $lineOptions = array())
    {
        $this->addEnumOptionsElementWithLine($form, $lineOptions);
    }


    public function addEnumOptionsElementWithLine(OX_UI_Form $form, 
            array $lineOptions = array(), 
            $customMultiOptions = null)
    {
        $multiOptions = (isset($customMultiOptions) ? $customMultiOptions : $this->getMultiOptions());
        $selectOptions = array_merge(array ('width' => $this->getWidth(), 
                'multiOptions' => $multiOptions), $this->customEnumElementOptions($form));
        
        if ($this->isMultiSelect()) {
            $selectOptions['height'] = $this->getHeight();
            $selectOptions['id'] = $this->type;
        }
        
        $selectType = $this->isMultiSelect() ? 'multiCheckbox' : 'select';
        
        $form->addElementWithLine($selectType, $this->type, $this->getLineName(), $selectOptions, $lineOptions);
    }


    public function populateRule(OX_UI_Form $form)
    {
        $this->populateRuleValues($form->getValue($this->type));
    }


    public function beforeRender(OX_UI_Form $form)
    {
        $this->setEnumElementCustomOptions($form);
    }
    
    /**
     * Override to provide custom extra options for the actual Enum element.
     */
    protected function customEnumElementOptions(OX_UI_Form $form)
    {
        return array ();
    }


    private function setEnumElementCustomOptions(OX_UI_Form $form)
    {
        $element = $form->getElement($this->type);
        if (!isset($element))
        {
            return;
        }
        
        $elementOptions = $this->customEnumElementOptions($form);
        if ($this->isMultiSelect() && isset($elementOptions['class'])) {
            $class = $elementOptions['class'];
            unset($elementOptions['class']);
            $elementOptions['containerClass'] = $class;
        }
        
        // Use setOptions rather than setAttrib, the former checks for setter methods
        $element->setOptions($elementOptions);
    }
}