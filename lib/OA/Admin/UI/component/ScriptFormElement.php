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
 * An element used to add JS script embedded in template 
 */

require_once MAX_PATH.'/lib/OA/Admin/UI/component/CustomFormElement.php';

class OA_Admin_UI_Component_ScriptFormElement 
    extends OA_Admin_UI_Component_CustomFormElement
{
   /**
    * Class constructor
    * 
    * @param string $elementName    custom element name
    */
    function OA_Admin_UI_Component_ScriptFormElement($elementName = null, $vars = null)
    {
        parent::OA_Admin_UI_Component_CustomFormElement($elementName, null, $vars);
        $this->_type = 'script';
    }
} 
?>
