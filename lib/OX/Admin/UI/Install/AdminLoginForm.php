<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once 'BaseForm.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 * @author Bernard Lange <bernard@openx.org> 
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