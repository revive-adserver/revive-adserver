<?php

/**
 * A very simple implementation of OX_UI_Form_Fragment_Alternative which hides and shows
 * the elements with names provided in the constructor. This fragment assumes that the
 * elements have already been added to the form. This fragment does nothing in the build(),
 * populate() and validate() methods.
 */
final class OX_UI_Form_Fragment_Alternative_Simple extends OX_UI_Form_Fragment_Alternative
{
    private $elementNames;
    private $groupNames;


    public function __construct($elementNames = null, $groupNames = null)
    {
        if (!empty($elementNames)) {
            $this->elementNames = is_array($elementNames) ? $elementNames : array($elementNames);
        }
        if (!empty($groupNames)) {
            $this->groupNames = is_array($groupNames) ? $groupNames : array($groupNames);
        }
    }


    public function getControlledElementNames()
    {
        return $this->elementNames;
    }
    
    
    public function getControlledDisplayGroupNames()
    {
        return $this->groupNames;
    }
}
