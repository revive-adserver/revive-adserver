<?php

/**
 * A noop helper for form line elements. 
 */
class OX_UI_View_Helper_FormLine extends Zend_View_Helper_FormElement
{
    public function formLine($id, $value = null, $attribs = null)
    {
        return '';
    }
}
