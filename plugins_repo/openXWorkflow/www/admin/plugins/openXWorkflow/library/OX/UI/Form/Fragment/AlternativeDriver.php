<?php

/**
 * Drives the visiblity of OX_UI_Form_Fragment_Alternative.
 */
interface OX_UI_Form_Fragment_AlternativeDriver  
{
    /**
     * Returns the OX_Form_Element that should drive the alternative fragment.
     */ 
    public function getDriverElement(OX_UI_Form $form);
}
