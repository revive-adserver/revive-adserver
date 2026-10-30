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

require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/OA/Admin/PasswordRecovery.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Users.php';

class OA_Dal_PasswordRecovery_Test extends OA_Dal_PasswordRecovery
{
    public $user;
    public $ids = [];

    public function getUserFromRecoveryId(string $recoveryId): ?DataObjects_Users
    {
        $this->ids[] = $recoveryId;
        return $this->user;
    }
}

class OA_Admin_PasswordRecovery_Test extends OA_Admin_PasswordRecovery
{
    public $events = [];

    public function pageHeader(bool $isWelcomePage = false)
    {
        $this->events[] = ['header', $isWelcomePage];
    }

    public function pageFooter()
    {
        $this->events[] = ['footer'];
    }

    public function displayRecoveryRequestForm($errormessage = '')
    {
        $this->events[] = ['request', $errormessage];
    }

    public function displayRecoveryResetForm($id, DataObjects_Users $doUser, $errormessage = '')
    {
        $this->events[] = ['reset', $id, $doUser];
    }

    public function displayMessage($message)
    {
        $this->events[] = ['message', $message];
    }
}

class Test_OA_Admin_PasswordRecovery extends UnitTestCase
{
    private $previousDal;
    private $dal;
    private $page;

    public function setUp()
    {
        Language_Loader::load();
        $locator = OA_ServiceLocator::instance();
        $this->previousDal = $locator->get('OA_Dal_PasswordRecovery');
        $this->dal = new OA_Dal_PasswordRecovery_Test();
        $locator->register('OA_Dal_PasswordRecovery', $this->dal);
        $this->page = new OA_Admin_PasswordRecovery_Test();
    }

    public function tearDown()
    {
        $locator = OA_ServiceLocator::instance();
        $locator->remove('OA_Dal_PasswordRecovery');
        if ($this->previousDal !== false) {
            $locator->register('OA_Dal_PasswordRecovery', $this->previousDal);
        }
        Language_Loader::load();
    }

    public function testMissingIdDisplaysRequestFormWithoutLookingUpUser()
    {
        $this->page->handleGet([]);

        $this->assertEqual([['header', false], ['request', ''], ['footer']], $this->page->events);
        $this->assertEqual([], $this->dal->ids);
    }

    public function testUnknownOrExpiredIdDisplaysErrorWithoutReadingNullUser()
    {
        $this->page->handleGet(['id' => 'expired']);

        $this->assertEqual(['expired'], $this->dal->ids);
        $this->assertEqual(
            [['header', false], ['request', $GLOBALS['strPwdRecWrongExpired']], ['footer']],
            $this->page->events,
        );
    }

    public function testValidIdDisplaysResetFormForUser()
    {
        $user = new DataObjects_Users();
        $user->language = 'en';
        $user->password = 'existing-hash';
        $this->dal->user = $user;

        $this->page->handleGet(['id' => 'valid']);

        $this->assertEqual(
            [['header', false], ['reset', 'valid', $user], ['footer']],
            $this->page->events,
        );
    }

    public function testUserWithoutPasswordDisplaysWelcomeAndResetForm()
    {
        $user = new DataObjects_Users();
        $user->language = 'en';
        $user->password = '';
        $this->dal->user = $user;

        ob_start();
        try {
            $this->page->handleGet(['id' => 'welcome']);
        } finally {
            ob_end_clean();
        }

        $this->assertEqual(
            [['header', true], ['message', $GLOBALS['strWelcomePageText']], ['reset', 'welcome', $user], ['footer']],
            $this->page->events,
        );
    }
}
