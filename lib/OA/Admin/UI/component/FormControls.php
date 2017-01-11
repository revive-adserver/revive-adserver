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
 * A pseudo-element used for adding form controls section ie. the section
 * which contains control buttons at the bottom of the screen.
 */

require_once MAX_PATH.'/lib/pear/HTML/QuickForm/static.php';

class OA_Admin_UI_Component_FormControls 
    extends HTML_QuickForm_static
{

   /**
    * Class constructor
    * 
    * @param string $elementName    Header name
    */
    function __construct($elementName = null, $text = null)
    {
        parent::__construct($elementName, null, $text);
        $this->_type = 'controls';
    }


   /**
    * Accepts a renderer
    *
    * @param HTML_QuickForm_Renderer    renderer object
    */
    function accept(&$renderer, $required = false, $error = null)
    {
        $renderer->renderHeader($this);
    } 
} 
?>
