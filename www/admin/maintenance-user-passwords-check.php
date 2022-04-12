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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH . '/lib/OA/Admin/PasswordRecovery.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

phpAds_PageHeader("maintenance-index");
phpAds_MaintenanceSelection("user-passwords");

(new class() {
    private $aUsers = ['old' => [], 'new' => []];

    public function __construct()
    {
        $oDbh = OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF'];
        $qTbl = $oDbh->quoteIdentifier($aConf['table']['prefix'] . $aConf['table']['users']);
        $sql = "SELECT user_id, username, email_address, password = '' AS new_user FROM {$qTbl} WHERE LENGTH(password) IN (0, 32)";

        $res = $oDbh->query($sql);

        if (PEAR::isError($res)) {
            PEAR::raiseError($res, null, PEAR_ERROR_DIE);
        }

        while ($row = $res->fetchRow()) {
            $this->aUsers[$row['new_user'] ? 'new' : 'old'][$row['user_id']] = $row;
        }
    }

    public function __invoke()
    {
        if (!$this->hasUsersNeedingUpdate()) {
            echo '<br/><br/>';
            echo $GLOBALS['strUserPasswordsEverythingOK'];

            return;
        }

        $form = $this->generateForm();

        if ($form->validate()) {
            OA_Permission::checkSessionToken();

            $this->sendEmails($form->exportValues());

            echo '<br/><br/>';
            echo $GLOBALS['strUserPasswordsEmailsSent'];

            return;
        }

        //get template and display form
        $oTpl = new OA_Admin_Template('form/form.html');
        $oTpl->assign('form', $form->serialize());

        $oTpl->display();
    }

    private function hasUsersNeedingUpdate(): bool
    {
        return !empty($this->aUsers['old']) || !empty($this->aUsers['new']);
    }

    private function sendEmails(array $fields): void
    {
        $oPasswordrecovery = new OA_Admin_PasswordRecovery();

        if (!empty($fields['old'])) {
            $oPasswordrecovery->sendPasswordUpdateEmail(array_keys($fields['old']));
        }

        if (!empty($fields['new'])) {
            $oPasswordrecovery->sendWelcomeEmail(array_keys($fields['new']));
        }
    }

    private function generateForm(): OA_Admin_UI_Component_Form
    {
        $form = new OA_Admin_UI_Component_Form("maint-users-check", "POST", $_SERVER['SCRIPT_NAME']);

        if (!empty($this->aUsers['old'])) {
            $form->addElement('header', 'main_header1', 'Users requiring password reset');

            $elements = [];
            foreach ($this->aUsers['old'] as $id => $row) {
                $elements[] = $form->createElement('checkbox', "old[{$id}]", null, htmlspecialchars("{$row['username']} <{$row['email_address']}>"));
                $elements[] = $form->createElement('html', null, '<br>');
            }

            $form->addGroup($elements, 'group_old');
        }

        if (!empty($this->aUsers['new'])) {
            $form->addElement('header', 'main_header2', 'New users who haven\'t set their password yet');

            $elements = [];
            foreach ($this->aUsers['new'] as $id => $row) {
                $elements[] = $form->createElement('checkbox', "new[{$id}]", null, htmlspecialchars("{$row['username']} <{$row['email_address']}>"));
                $elements[] = $form->createElement('html', null, '<br>');
            }

            $form->addGroup($elements, 'group_new');
        }

        $form->addElement('controls', 'form-controls');
        $form->addElement('submit', 'submit', 'Send email(s)');

        $form->addFormRule(function (array $fields) {
            if (!empty($fields['old']) || !empty($fields['new'])) {
                return true;
            }

            $aErrors = [];

            if (!empty($this->aUsers['old'])) {
                $aErrors['group_old'] = 'You must select at least one user from either group';
            }

            if (!empty($this->aUsers['new'])) {
                $aErrors['group_new'] = 'You must select at least one user from either group';
            }

            return $aErrors ?: true;
        });

        return $form;
    }
})();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

//footer
phpAds_PageFooter();
