<?php

/**
 * Helper to generate a form element with arbitrary content
 */
class OX_UI_View_Helper_FormContent extends Zend_View_Helper_FormElement
{
    public function formContent($id, $value = null, $attribs = null)
    {
        $allowedAttributes = array_intersect_key($attribs, array (
                'id' => '', 
                'class' => '', 
                'style' => ''));
        $prefix = '';
        $suffix = '';
        $element = 'span';
        $content = '';
        
        if (isset($attribs['width']) || isset($attribs['height'])) {
            $element = 'div';
        }
        
        if (!empty($allowedAttributes)) {
            $prefix = '<' . $element . ' ' . $this->_htmlAttribs($allowedAttributes) . '>';
            $suffix = '</' . $element . '>';
        }
        
        if (isset($attribs['content'])) {
            $content = $attribs['content'];
        }
        elseif (isset($attribs['helperName']) && $this->view) {
            $helper = $this->view->getHelper($attribs['helperName']);
            $content = call_user_func_array(array (
                    $helper, 
                    $attribs['helperName']), (isset($attribs['helperParams']) ? $attribs['helperParams'] : array ()));
        }
        
        return $prefix . $content . $suffix;
    }
}
