<?php

/**
 * Renders a standalone label that does not necessarily points to a specific form
 * element.
 */
class OX_UI_View_Helper_StandaloneLabel extends Zend_View_Helper_FormElement
{

    /**
     * Generates a 'label' element.
     */
    public function standaloneLabel($name, $value = null, array $attribs = array())
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable, escape
        if ($id) {
            $attribs['id'] = $id;
        }
        
        if ($disable) {
            return '';
        } else {
            // We need to store the label value in a special attribute (here named 
            // 'labelText') and not in the $value field because the latter gets
            // cleared when the form has validation errors, which would then render
            // an empty label.
            $value = ($escape) ? $this->view->escape(
                $attribs['labelText']) : $attribs['labelText'];
            unset($attribs['labelText']);
            
            // enabled; display label
            $xhtml = '<label ' . $this->_htmlAttribs(
                $attribs) . '>' . $value . '</label>';
        }
        
        return $xhtml;
    }
}
