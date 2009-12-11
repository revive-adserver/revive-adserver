<?php

/**
 * A modification of the original Zend's form button helper that allows rendering
 * buttons with left/right arrows.
 */
class OX_UI_View_Helper_FormButton extends Zend_View_Helper_FormElement
{
    /**
     * Generates a 'button' element. To render a button with an arrow, specify
     * the 'arrow' option with a value of 'left' or 'right'.
     *
     * @return string The element XHTML.
     */
    public function formButton($name, $value = null, $attribs = null)
    {
        $info    = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, id, value, attribs, options, listsep, disable

        // Get content
        $content = '';
        if (isset($attribs['content'])) {
            $content = $attribs['content'];
            unset($attribs['content']);
        } else {
            $content = $value;
        }

        // Ensure type is sane
        $type = 'button';
        if (isset($attribs['type'])) {
            $attribs['type'] = strtolower($attribs['type']);
            if (in_array($attribs['type'], array('submit', 'reset', 'button'))) {
                $type = $attribs['type'];
            }
            unset($attribs['type']);
        }

        // Extract arrow position
        $arrow = null;
        if (isset($attribs['arrow'])) {
            $arrow = $attribs['arrow'];
            unset($attribs['arrow']);
            
            $attribs['class'] = OX_UI_Form_Element_Utils::addClass($attribs['class'], $arrow);
        }
        
        // build the element
        if ($disable) {
            $attribs['disabled'] = 'disabled';
        }

        $content = ($escape) ? $this->view->escape($content) : $content;

        $xhtml = '<button'
                . ' name="' . $this->view->escape($name) . '"'
                . ' id="' . $this->view->escape($id) . '"'
                . ' type="' . $type . '"';

        // add a value if one is given
        if (!empty($value)) {
            $xhtml .= ' value="' . $this->view->escape($value) . '"';
        }

        // add attributes and close start tag
        $xhtml .= $this->_htmlAttribs($attribs) . '>';

        if ($arrow == 'left')
        {
            $xhtml .= '<span></span>';
        }
        
        // add content
        $xhtml .= $content;

        if ($arrow == 'right')
        {
            $xhtml .= '<span>&nbsp;</span>';
        }
        
        $xhtml .= '</button>';

        return $xhtml;
    }
}
