<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Contains the Pager_HtmlWidgets class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE FREEBSD PROJECT OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   HTML
 * @package    Pager
 * @author     Lorenzo Alberton <l dot alberton at quipo dot it>
 * @copyright  2003-2006 Lorenzo Alberton
 * @license    http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Pager
 */

/**
 * Two constants used to guess the path- and file-name of the page
 * when the user doesn't set any other value
 */
class Pager_HtmlWidgets
{
    var $pager = null;
    
    // {{{ constructor
    
    function Pager_HtmlWidgets(&$pager)
    {
        $this->pager =& $pager;
    }
    
    // }}}
    // {{{ getPerPageSelectBox()

    /**
     * Returns a string with a XHTML SELECT menu,
     * useful for letting the user choose how many items per page should be
     * displayed. If parameter useSessions is TRUE, this value is stored in
     * a session var. The string isn't echoed right now so you can use it
     * with template engines.
     *
     * @param integer $start
     * @param integer $end
     * @param integer $step
     * @param boolean $showAllData If true, perPage is set equal to totalItems.
     * @param array   (or string $optionText for BC reasons)
     *                - 'optionText': text to show in each option.
     *                  Use '%d' where you want to see the number of pages selected.
     *                - 'attributes': (html attributes) Tag attributes or
     *                  HTML attributes (id="foo" pairs), will be inserted in the
     *                  <select> tag
     *                - 'checkMaxLimit': if true, Pager checks if $end is bigger
     *                  than $totalItems, and doesn't show the extra select options
     * @return string xhtml select box
     * @access public
     */
    function getPerPageSelectBox($start=5, $end=30, $step=5, $showAllData=false, $extraParams=array())
    {
        // FIXME: needs POST support
        $optionText = '%d';
        $attributes = '';
        $checkMaxLimit = false;
        if (is_string($extraParams)) {
            //old behavior, BC maintained
            $optionText = $extraParams;
        } else {
            if (array_key_exists('optionText', $extraParams)) {
                $optionText = $extraParams['optionText'];
            }
            if (array_key_exists('attributes', $extraParams)) {
                $attributes = $extraParams['attributes'];
            }
            if (array_key_exists('checkMaxLimit', $extraParams)) {
                $checkMaxLimit = $extraParams['checkMaxLimit'];
            }
        }

        if (!strstr($optionText, '%d')) {
            return $this->pager->raiseError(
                $this->pager->errorMessage(ERROR_PAGER_INVALID_PLACEHOLDER),
                ERROR_PAGER_INVALID_PLACEHOLDER
            );
        }
        $start = (int)$start;
        $end   = (int)$end;
        $step  = (int)$step;
        if (!empty($_SESSION[$this->pager->_sessionVar])) {
            $selected = (int)$_SESSION[$this->pager->_sessionVar];
        } else {
            $selected = $this->pager->_perPage;
        }
        
        if ($checkMaxLimit && $this->pager->_totalItems > 0 && $this->pager->_totalItems < $end) {
            $end = $this->pager->_totalItems;
        }

        $tmp = '<select name="'.$this->pager->_sessionVar.'"';
        if (!empty($attributes)) {
            $tmp .= ' '.$attributes;
        }
        $tmp .= '>';
        $last = $start;
        for ($i=$start; $i<=$end; $i+=$step) {
            $last = $i;
            $tmp .= '<option value="'.$i.'"';
            if ($i == $selected) {
                $tmp .= ' selected="selected"';
            }
            $tmp .= '>'.sprintf($optionText, $i).'</option>';
        }
        if ($showAllData && $last < $this->pager->_totalItems) {
            $tmp .= '<option value="'.$this->pager->_totalItems.'"';
            if ($this->pager->_totalItems == $selected) {
                $tmp .= ' selected="selected"';
            }
            $tmp .= '>';
            if (empty($this->pager->_showAllText)) {
                $tmp .= str_replace('%d', $this->pager->_totalItems, $optionText);
            } else {
                $tmp .= $this->pager->_showAllText;
            }
            $tmp .= '</option>';
        }
        $tmp .= '</select>';
        return $tmp;
    }

    // }}}
    // {{{ getPageSelectBox()

    /**
     * Returns a string with a XHTML SELECT menu with the page numbers,
     * useful as an alternative to the links
     *
     * @param array   - 'optionText': text to show in each option.
     *                  Use '%d' where you want to see the number of pages selected.
     *                - 'autoSubmit': if TRUE, add some js code to submit the
     *                  form on the onChange event
     * @param string    $extraAttributes (html attributes) Tag attributes or
     *                  HTML attributes (id="foo" pairs), will be inserted in the
     *                  <select> tag
     * @return string xhtml select box
     * @access public
     */
    function getPageSelectBox($params = array(), $extraAttributes = '')
    {
        $optionText = '%d';
        if (array_key_exists('optionText', $params)) {
            $optionText = $params['optionText'];
        }

        if (!strstr($optionText, '%d')) {
            return $this->pager->raiseError(
                $this->pager->errorMessage(ERROR_PAGER_INVALID_PLACEHOLDER),
                ERROR_PAGER_INVALID_PLACEHOLDER
            );
        }
        
        $tmp = '<select name="'.$this->pager->_urlVar.'"';
        if (!empty($extraAttributes)) {
            $tmp .= ' '.$extraAttributes;
        }
        if (!empty($params['autoSubmit'])) {
            if ($this->pager->_httpMethod == 'GET') {
                $selector = '\' + '.'this.options[this.selectedIndex].value + \'';
                if ($this->pager->_append) {
                    $href = '?' . $this->pager->_http_build_query_wrapper($this->pager->_linkData);
                    $href = htmlentities($this->pager->_url). preg_replace(
                        '/(&|&amp;|\?)('.$this->pager->_urlVar.'=)(\d+)/',
                        '\\1\\2'.$selector,
                        htmlentities($href)
                    );
                } else {
                    $href = htmlentities($this->pager->_url . str_replace('%d', $selector, $this->pager->_fileName));
                }
                $tmp .= ' onchange="document.location.href=\''
                     . $href .'\''
                     . '"';
            } elseif ($this->pager->_httpMethod == 'POST') {
                $tmp .= " onchange='"
                     . $this->pager->_generateFormOnClick($this->pager->_url, $this->pager->_linkData)
                     . "'";
                $tmp = preg_replace(
                    '/(input\.name = \"'.$this->pager->_urlVar.'\"; input\.value =) \"(\d+)\";/',
                    '\\1 this.options[this.selectedIndex].value;',
                    $tmp
                );
            }
        }
        $tmp .= '>';
        $start = 1;
        $end = $this->pager->numPages();
        $selected = $this->pager->getCurrentPageID();
        for ($i=$start; $i<=$end; $i++) {
            $tmp .= '<option value="'.$i.'"';
            if ($i == $selected) {
                $tmp .= ' selected="selected"';
            }
            $tmp .= '>'.sprintf($optionText, $i).'</option>';
        }
        $tmp .= '</select>';
        return $tmp;
    }
    
    // }}}
}
?>