<?php

/**
 * Represents a fragment corresponding to an individual entry managed by 
 * OX_UI_Form_Fragment_Multientry.
 */
abstract class OX_UI_Form_Fragment_Multientry_Entry extends OX_UI_Form_Fragment_Default
    implements OX_UI_Form_Validate_ValidationEnabledController
{
    private $prefix;
    private $isTemplate = false;
    private $displayGroupName;

    public final function build(OX_UI_Form $form, array $values)
    {
        $lineName = $this->name('Line');
        $this->buildEntry($form, $values, $lineName);
        $this->addRemoveLink($form, $lineName);
        
        $line = $form->getElement($lineName);
        $line->setAttrib('id', $this->name());
        OX_UI_Form_Validate_ValidationEnabledCallbackWrapper::wrapValidationEnabledCallback(
            $line, $this);
        $form->addDisplayGroup(array($lineName), $this->displayGroupName);
        
        if ($this->isTemplate()) {
            OX_UI_Form_Element_Utils::addClassInElementOptions($line, 'hide');
        }
    }

    /**
     * Adds this entry's elements to the provided form. Use the name() method to obtain
     * names for the individual form elements you are adding.
     *
     * @param OX_UI_Form $form
     * @param array $values
     * @param string $lineName line name to which the elements must be added.
     */
    protected abstract function buildEntry(OX_UI_Form $form, array $values, $lineName);
    
    
    public final function populate(OX_UI_Form $form)
    {
        if (!$this->isTemplate() && !$this->isBlank($form->getValues())) {
            $this->populateEntry($form);
        }
    }
    
    
    /**
     * A counterpart of OX_UI_Form_Fragment::populate() called for this specific entry. 
     */    
    protected function populateEntry(OX_UI_Form $form)
    {
    }
    

    /**
     * Determines whether this entry is empty. If the entry is empty, it will not raise
     * validation errors on submit, even if its fields are required. This implmenetation
     * always returns false.
     * 
     * @return boolean true if this entry is empty
     */
    public function isBlank($values)
    {
        return false;
    }
    
    
    /**
     * A utility method that returns true if all the provided fields are empty 
     * (in terms of PHP's empty() function).  
     * 
     * @param array $fieldNames names of fields to check. Note name() method for each 
     *               field from this array, so provide 'bare' names here (without prefixes). 
     * @return boolean true if all provided fields are not empty. If $fieldNames is empty
     *                  true will be returned.
     */
    protected function isAllFieldsEmpty(array $fieldNames, $values)
    {
        foreach ($fieldNames as $name) {
        	if (!empty($values[$this->name($name)])) {
        	    return false;
        	}
        }
        
        return true;
    }
    
    
    /**
     * Adds the Remove link to the form.
     */
    private function addRemoveLink(OX_UI_Form $form, $lineName)
    {
        $removeLinkName = $this->name('removeLink');
        $form->addElementWithLine('link', $removeLinkName, $lineName, array (
                'text' => 'Remove', 
                'href' => '#', 
                'class' => 'inlineIcon iconDelete', 
                'id' => $removeLinkName));
    }
    

    /**
     * Returns true if this entry is used as a template for other entries. A template
     * entry remains hidden and is never validated.
     * 
     * @return true if this entry is a template 
     */
    public final function isTemplate()
    {
        return $this->isTemplate;
    }
    
    /**
     * Determinthis entry is used as a template for other entries. A template
     * entry remains hidden and is never validated.
     */        
    public final function setTemplate($isTemplate)
    {
        $this->isTemplate = $isTemplate;
    }
    
    
    /**
     * Sets the prefix for this entry's element names.
     */        
    public final function setElementNamePrefix($prefix)
    {
        $this->prefix = $prefix;
    }


    /**
     * Sets the name of display group to which this entry should belong.
     */        
    public function setDisplayGroupName($displayGroupName)
    {
        $this->displayGroupName = $displayGroupName;
    }

    
    public final function isValidationEnabled($value, $context)
    {
        return !$this->isTemplate() && !$this->isBlank($context);
    }
    
    /**
     * Generates a name for this entry's form elements.
     *
     * @param string $name form element name
     * @return element name to use when adding the element to the form
     */
    protected final function name($name = '')
    {
        if (strlen($name) == 0) {
            return $this->prefix;
        } else {
            return $this->prefix . '_' . $name;
        }
    }
}
