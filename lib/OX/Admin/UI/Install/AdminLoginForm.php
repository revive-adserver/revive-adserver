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

/**
 * @package OX_Admin_UI
 * @subpackage Install
 */
class OX_Admin_UI_Install_AdminLoginForm
    extends OX_Admin_UI_Install_BaseForm
{
    /**
     * Builds Ad Server login form for installer
     * @param OX_Translation $oTranslation  instance
     */
    public function __construct($oTranslation, $action)
    {
        parent::__construct('adserver-login-form', 'POST', $_SERVER['SCRIPT_NAME'], null, $oTranslation);
        $this->addElement('hidden', 'action', $action);

        $this->buildLoginSection();

        $this->addElement('controls', 'form-controls');
        $this->addElement('submit', 'save', $GLOBALS['strLogin']);
    }


    protected function buildLoginSection()
    {
        //build form
        $this->addElement('header', 'h_account', '');

        $this->addElement('text', 'username', $GLOBALS['strAdminUsername'], array('class' => 'medium'));
        $this->addElement('password', 'password', $GLOBALS['strAdminPassword'],
            array('class' => 'medium'));


        //Form validation rules
        $this->addRequiredRule('username', $GLOBALS['strAdminUsername']);
        $this->addRequiredRule('password', $GLOBALS['strAdminPassword']);
    }
}

?>