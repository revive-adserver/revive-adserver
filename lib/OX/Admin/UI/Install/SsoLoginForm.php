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
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_Install_SsoLoginForm 
    extends OX_Admin_UI_Install_BaseForm
{
    /**
     * Builds SSO login form for installer
     * @param OX_Translation $oTranslation  instance
     */
    public function __construct($oTranslation, $action, $platformHash)
    {
        parent::__construct('sso-login-form', 'POST', $_SERVER['SCRIPT_NAME'], null, $oTranslation);
        $this->addElement('hidden', 'action', $action);
        
        $this->buildLoginSection($platformHash);
    
        $this->addElement('controls', 'form-controls');
        $this->addElement('submit', 'login', $GLOBALS['strBtnContinue']);        
    }


    protected function buildLoginSection($platformHash)
    {
        $this->addElement('hidden', 'platformHash', $platformHash);
        
        //build form
        $this->addElement('header', 'h_account', '');
    
        $this->addElement('text', 'l_username', $GLOBALS['strOpenXUsername'], array('class' => 'medium'));
        $this->addElement('password', 'l_password', $GLOBALS['strPassword'],
            array('class' => 'medium'));
        $this->addElement('checkbox', 'updates_signup', null, $GLOBALS['strSignupUpdates']);
        
    
        //Form validation rules
        $this->addRequiredRule('l_username', $GLOBALS['strOpenXUsername']);
        $this->addRequiredRule('l_password', $GLOBALS['strPassword']);
    }

    
    public function populateAccountData()
    {
        $aFields = $this->exportValues();
        
        $aAccount = array();
        $aAccount['username'] = $aFields['l_username'];
        $aAccount['password'] = $aFields['l_password'];
        $aAccount['platformHash'] = $aFields['platformHash'];
        $aAccount['updates_signup'] = $aFields['updates_signup'];
        
        return $aAccount;
    }
}
?>