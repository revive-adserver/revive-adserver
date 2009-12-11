<?php

/**
 * A form fragment whose visibility is driven by some other form element. A common use
 * case for this kind of fragment is a form that has two mutually exclusive parts
 * whose visibility depends on a checkbox or radio button selection.
 * 
 * See also: OX_UI_Form_Listener_AlternativeController
 */
abstract class OX_UI_Form_Fragment_Alternative extends OX_UI_Form_Fragment_Default
    implements OX_UI_Form_Validate_ValidationEnabledController
{
    private $enabled = true;

    /**
     * Returns the names of display groups this fragment controls.
     */
    public function getControlledDisplayGroupNames()
    {
        return null;
    }

    /**
     * Returns the names of elements and form lines this fragment controls. You only
     * need to return element names if they are contained in a line or display group
     * whose names are not returned by getControlledDisplayGroupNames() or 
     * getControlledElementNames().
     */        
    public function getControlledElementNames()
    {
        return null;
    }

    
    public function getControlledAlternatives()
    {
        return null;
    }
    
    
    /**
     * A counterpart of OX_UI_Form_Fragment::populate(). Called only if this fragment is
     * rendered as 'enabled' on form submission.
     */ 
    protected function populateInternal(OX_UI_Form $form)
    {
    }


    /**
     * Called when this fragment is rendered as 'disabled' on form submission. This method
     * gives the fragment a chance to 'clear' all backing object data this fragment refers to.
     */ 
    protected function clearInternal(OX_UI_Form $form)
    {
    }


    /**
     * A counterpart of OX_UI_Form_Fragment::validate().
     */ 
    protected function validateInternal(OX_UI_Form $form)
    {
        return true;
    }


    public final function populate(OX_UI_Form $form)
    {
        if ($this->enabled) {
            $this->populateInternal($form);
        }
        else {
            $this->clearInternal($form);
        }
    }


    public final function validate(OX_UI_Form $form, array $values)
    {
        if ($this->enabled) {
            return $this->validateInternal($form);
        }
        else {
            return parent::validate($form, $values);
        }
    }


    public final function isEnabled()
    {
        return $this->enabled;
    }


    public final function setEnabled(OX_UI_Form $form, $enabled)
    {
        $this->enabled = $enabled;
        
        $displayGroupNames = $this->getControlledDisplayGroupNames();
        if (isset($displayGroupNames)) {
            foreach ($displayGroupNames as $displayGroupName) {
                $displayGroup = $form->getDisplayGroup($displayGroupName);
                if (!isset($displayGroup)) {
                    throw new Exception('Display group named "' . $displayGroupName . '" not found in fragment of class ' . get_class($this));
                }
                OX_UI_Form_Element_Utils::setVisible($displayGroup, $enabled);
                $elements = $displayGroup->getElements();
                foreach ($elements as $element) {
                    OX_UI_Form_Validate_ValidationEnabledCallbackWrapper::wrapValidationEnabledCallback($element, $this);
                }
            }
        }
        
        $elementNames = $this->getControlledElementNames();
        if (isset($elementNames)) {
            foreach ($elementNames as $elementName) {
                $element = $form->getElement($elementName);
                if (!isset($element)) {
                    throw new Exception('Element named "' . $elementName . '" not found in fragment of class ' . get_class($this));
                }
                OX_UI_Form_Element_Utils::setVisible($element, $enabled);
                OX_UI_Form_Validate_ValidationEnabledCallbackWrapper::wrapValidationEnabledCallback($element, $this);
            }
        }
        
        $alternatives = $this->getControlledAlternatives();
        if (isset($alternatives)) {
            foreach($alternatives as $alternative) {
                $alternative->setEnabled($form, $enabled && $alternative->isEnabled());
            }
        }
    }

    
    public function isValidationEnabled($value, $context)
    {
        return $this->isEnabled();
    }
}
