<?php

/**
 * Defines an element that can have prexix and suffix labels.
 */
interface OX_UI_Form_Element_WithAffixes
{
    public function getPrefix();
    
    public function setPrefix($suffix);
    
    public function getSuffix();
    
    public function setSuffix($suffix);
}
