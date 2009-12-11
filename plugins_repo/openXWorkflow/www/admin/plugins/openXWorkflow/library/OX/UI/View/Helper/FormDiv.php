<?php

/**
 * Helper to generate a "text" element
 */
class OX_UI_View_Helper_FormDiv extends Zend_View_Helper_FormElement
{


    /**
     * Generates a 'div' element.
     *
     * @access public
     *
     * @param mixed $value The element value.
     *
     * @param array $attribs Attributes for the element tag.
     *
     * @return string The element XHTML.
     */
    public function formDiv($id, $value = null, $attribs = null)
    {
        unset($attribs['readOnlyValue']);
        $url = null;
        if (isset($attribs['url'])) {
            $url = $attribs['url'];
        }
        unset($attribs['url']);
        
        $xhtml = '<div ' . $this->_htmlAttribs($attribs) . '>';
        if ($url) {
            $xhtml .= '<a href="' . $url . '">';
        }
        $xhtml .= $this->view->escape($value);
        if ($url) {
            $xhtml .= '</a>';
        }
        $xhtml .= '</div>';
        
        return $xhtml;
    }
}
