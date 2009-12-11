<?php

/**
 * Overrides the default helper for rendering radio buttons to remove the 'for' attribute
 * from the master radio label (there is no way to point this 'for' to).
 */
class OX_UI_View_Helper_FormRadio extends Zend_View_Helper_FormRadio
{
    public function formRadio($name, $value = null, $attribs = null,
        $options = null, $listsep = "<br />\n")
    {
        unset($attribs['noForAttribute']);
        $result = parent::formRadio($name, $value, $attribs, $options, $listsep);
        return $result; 
    }
}
