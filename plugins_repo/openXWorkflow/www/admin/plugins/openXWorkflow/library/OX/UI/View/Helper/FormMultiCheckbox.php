<?php

/**
 * A modification of Zend's original radio button helper to allow rendering hierarchical
 * structures of inputs.
 */
class OX_UI_View_Helper_FormMultiCheckbox extends Zend_View_Helper_FormMultiCheckbox
{
    public function formMultiCheckbox($name, $value = null, $attribs = null, $options = null, 
            $listsep = "<br />\n")
    {
        $info = $this->_getInfo($name, $value, $attribs, $options, $listsep);
        extract($info); // name, value, attribs, options, listsep, disable
        

        // retrieve attributes for labels (prefixed with 'label_' or 'label')
        $label_attribs = array (
                'style' => 'white-space: nowrap;');
        foreach ($attribs as $key => $val) {
            $tmp = false;
            $keyLen = strlen($key);
            if ((6 < $keyLen) && (substr($key, 0, 6) == 'label_')) {
                $tmp = substr($key, 6);
            } elseif ((5 < $keyLen) && (substr($key, 0, 5) == 'label')) {
                $tmp = substr($key, 5);
            }
            
            if ($tmp) {
                // make sure first char is lowercase
                $tmp [0] = strtolower($tmp [0]);
                $label_attribs [$tmp] = $val;
                unset($attribs [$key]);
            }
        }
        
        unset($attribs ['noForAttribute']);
        
        $labelPlacement = 'append';
        foreach ($label_attribs as $key => $val) {
            switch (strtolower($key)) {
                case 'placement' :
                    unset($label_attribs [$key]);
                    $value = strtolower($val);
                    if (in_array($val, array (
                            'prepend', 
                            'append'))) {
                        $labelPlacement = $val;
                    }
                break;
            }
        }
        
        // the radio button values and labels
        $options = ( array ) $options;
        
        // build the element
        $xhtml = '';
        
        // Id prefix
        $idPrefix = $name;
        if ('[]' == substr($idPrefix, -2)) {
            $idPrefix = substr($idPrefix, 0, strlen($idPrefix) - 2);
        }
        
        // Name for form element
        $name = $this->view->escape($name);
        if ($this->_isArray && ('[]' != substr($name, -2))) {
            $name .= '[]';
        }
        
        // ensure value is an array to allow matching multiple times
        $value = ( array ) $value;
        
        // XHTML or HTML end tag?
        $endTag = ' />';
        if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
            $endTag = '>';
        }
        
        // done!
        $checkboxes = $this->renderCheckboxes($name, $value, $options, $escape, $disable, $label_attribs, $labelPlacement, $endTag, $attribs, $listsep, $idPrefix, true);
        $xhtml .= $checkboxes ['xhtml'];
        
        return $xhtml;
    }
    
    /**
     * Renders (X)HTML for the provided options. May recursively call itself for
     * suboptions.
     */
    private function renderCheckboxes($name, $value, $options, $escape, $disable, 
            $label_attribs, $labelPlacement, $endTag, 
            $attribs, $listsep, $idPrefix = '', 
            $alwaysVisible = false)
    {
        $result = array ();
        $list = array ();
        
        // Check if we have suboptions
        $hierarchy = false;
        foreach ($options as $opt_value => $opt_label) {
            if (is_array($opt_label) && count($opt_label ['multiOptions']) > 0) {
                $hierarchy = true;
                break;
            }
        }
        
        foreach ($options as $opt_value => $opt_label) {
            $opt_multiOptions = null;
            if (is_array($opt_label)) {
                $opt_value = $opt_label ['value'];
                $opt_multiOptions = $opt_label ['multiOptions'];
                $opt_label = $opt_label ['label'];
            }
            
            // Should the label be escaped?
            if ($escape) {
                $opt_label = $this->view->escape($opt_label);
            }
            
            // is it disabled?
            $disabled = '';
            if (true === $disable) {
                $disabled = ' disabled="disabled"';
            } elseif (is_array($disable) && in_array($opt_value, $disable)) {
                $disabled = ' disabled="disabled"';
            }
            
            // is it checked?
            $checked = '';
            if (in_array($opt_value, $value)) {
                $checked = ' checked="checked"';
                $result ['containsChecked'] = true;
            }
            
            // Prepare suboptions, if any
            $suboptions = '';
            if ($opt_multiOptions) {
                $suboptions = $this->renderCheckboxes($name, $value, $opt_multiOptions, $escape, $disable, $label_attribs, $labelPlacement, $endTag, $attribs, $listsep, $idPrefix . $opt_value . '_');
                if (isset($suboptions ['containsChecked'])) {
                    $this->orInArray($result, 'containsChecked', $suboptions ['containsChecked']);
                } else {
                    $this->orInArray($result, 'containsChecked', false);
                }
                $isBranch = true;
            } else {
                $isBranch = false;
            }
            
            // Wrap the radios in labels
            $checkbox = '<label for="' . $this->view->escape($idPrefix . $opt_value) . '" title="' . $opt_label . '"' . $this->_htmlAttribs($label_attribs) . '>';
            $checkbox .= (('prepend' == $labelPlacement) ? $opt_label : '');
            $checkbox .= '<span class="handle' . ($isBranch ? ' branch' : '') . '"></span>';
            $checkbox .= '<input type="checkbox" id="' . $this->view->escape($idPrefix . $opt_value) . '" name="' . $name . '"' . ' value="' . $this->view->escape($opt_value) . '"' . $checked . $disabled . $endTag;
            $checkbox .= (('append' == $labelPlacement) ? $opt_label : '') . '</label>';
            
            // add to the array of checkboxes
            // we need to use tables instead of lists because of IE text wrapping issues
            $wrapped = '<tr>';
            if ($hierarchy) {
                $wrapped .= '<td class="handle"><span></span></td>';
            }
            $wrapped .= '<td class="' . ($isBranch > 0 ? 'branch' : 'leaf') . '">' . $checkbox . (isset($suboptions ['xhtml']) ? $suboptions ['xhtml'] : '') . '</td></tr>';
            $list [] = $wrapped;
        }
        
        $result ['xhtml'] = '<table' . (isset($result ['containsChecked']) || $alwaysVisible ? '' : ' style="display: none"') . '><tbody>' . implode('', $list) . '</tbody></table>';
        
        return $result;
    }
    
    private function orInArray(&$a, $key, $boolean)
    {
        if (isset($a[$key]))
        {
            $a[$key] |= $boolean;
        }
        else
        {
            $a[$key] = $boolean;
        }
    }
}
