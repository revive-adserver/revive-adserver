<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * HTML class for static data
 */
require_once MAX_PATH.'/lib/pear/HTML/QuickForm/static.php';

/**
 * A pseudo-element used for adding raw HTML to form
 * 
 * Intended for use with the default renderer only, template-based
 * ones may (and probably will) completely ignore this
 * 
 * Adds name to element to allow hiding stuff
 */
class OA_Admin_UI_Component_Html extends HTML_QuickForm_static
{
    // {{{ constructor

   /**
    * Class constructor
    * 
    * @param string $name   element name
    * @param string $text   raw HTML to add
    * @access public
    * @return void
    */
    function OA_Admin_UI_Component_Html($name = null, $text = null)
    {
        $this->HTML_QuickForm_static($name, null, $text);
        $this->_type = 'html';
    }

    // }}}
    // {{{ accept()

   /**
    * Accepts a renderer
    *
    * @param HTML_QuickForm_Renderer    renderer object (only works with Default renderer!)
    * @access public
    * @return void 
    */
    function accept(&$renderer)
    {
        $renderer->renderHtml($this);
    } // end func accept

    // }}}

} //end class HTML_QuickForm_html
?>
