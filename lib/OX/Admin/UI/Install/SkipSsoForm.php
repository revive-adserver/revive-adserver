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

require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once 'BaseForm.php';

class OX_Admin_UI_Install_SkipSsoForm 
    extends OX_Admin_UI_Install_BaseForm
{
    public function __construct($oTranslation, $action)
    {
        parent::__construct('sso-login-form', 'POST', $_SERVER['SCRIPT_NAME'], null, $oTranslation);
        $this->addElement('hidden', 'action', $action);
        $this->addElement('submit', 'skipRegistration', $GLOBALS['strBtnContinueWithoutRegistering']);
    }
    
}
