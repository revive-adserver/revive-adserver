<?php

/**
 * Helper to generate a link element.
 */
class OX_UI_View_Helper_FormLink extends Zend_View_Helper_FormElement
{


    public function formLink($id, $value = null, $attribs = null)
    {
        unset($attribs['id']);
        if (isset($attribs['text'])) {
            $text = $attribs['text'];
            unset($attribs['text']);
        }
        else {
            $text = '';
        }
        return '<a id="' . $this->view->escape($id) . '" ' . $this->_htmlAttribs($attribs) . '>' . $this->view->escape($text) . '</a>';
    }
}
