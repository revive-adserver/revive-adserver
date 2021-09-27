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
 * A pseudo-element used for adding break between the fields without the header
 */

require_once MAX_PATH . '/lib/pear/HTML/QuickForm/static.php';

class OA_Admin_UI_Component_FormBreak extends HTML_QuickForm_static
{
    /**
     * Class constructor
     *
     * @param string $elementName    Header name
     */
    public function __construct($elementName = null, $text = null)
    {
        parent::__construct($elementName, null, $text);
        $this->_type = 'break';
    }


    /**
     * Accepts a renderer
     *
     * @param HTML_QuickForm_Renderer    renderer object
     */
    public function accept(&$renderer, $required = false, $error = null)
    {
        $renderer->renderElement($this);
    }
}
