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

require_once MAX_PATH . '/lib/OX/Admin/UI/Install/BaseForm.php';

if (!defined('phpAds_installing')) {
    define('phpAds_installing', true);
}

class Test_OX_Admin_UI_Install_BaseForm extends UnitTestCase
{
    public function testPasswordWhitespaceIsPreserved()
    {
        $post = $_POST;
        $get = $_GET;
        $request = $_REQUEST;
        $_GET = [];
        $_REQUEST = ['_qf__password-whitespace' => 1];
        $_POST = [
            'adminPassword' => ' administrator password ',
            'adminPassword2' => ' administrator password ',
            'dbPassword' => "\t database password \t",
            'password' => ' login password ',
            'username' => ' administrator ',
            'dbHost' => ' localhost ',
        ];

        try {
            $form = new OX_Admin_UI_Install_BaseForm('password-whitespace');
            foreach (['adminPassword', 'adminPassword2', 'dbPassword', 'password'] as $field) {
                $form->addElement('password', $field);
            }
            $form->addElement('text', 'username');
            $form->addElement('text', 'dbHost');
            $values = $form->exportValues();

            foreach (['adminPassword', 'adminPassword2', 'dbPassword', 'password'] as $field) {
                $this->assertIdentical($values[$field], $_POST[$field]);
            }
            $this->assertIdentical($values['username'], 'administrator');
            $this->assertIdentical($values['dbHost'], 'localhost');

            $hash = \RV\Manager\PasswordManager::getPasswordHash($values['adminPassword']);
            $this->assertTrue(\RV\Manager\PasswordManager::verifyPassword($_POST['adminPassword'], $hash));
            $this->assertFalse(\RV\Manager\PasswordManager::verifyPassword(trim($_POST['adminPassword']), $hash));
        } finally {
            $_POST = $post;
            $_GET = $get;
            $_REQUEST = $request;
        }
    }

    public function testOrdinaryFormsStillTrimSubmittedValues()
    {
        $post = $_POST;
        $request = $_REQUEST;
        $_POST = ['name' => ' campaign '];
        $_REQUEST = ['_qf__ordinary-form' => 1];

        try {
            $form = new OA_Admin_UI_Component_Form('ordinary-form');
            $form->addElement('text', 'name');
            $this->assertIdentical($form->exportValue('name'), 'campaign');
        } finally {
            $_POST = $post;
            $_REQUEST = $request;
        }
    }
}
