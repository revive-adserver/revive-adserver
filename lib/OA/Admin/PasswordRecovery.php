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
 * Password recovery for Revive Adserver
 *
 */

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/PasswordRecovery.php';
require_once MAX_PATH . '/lib/OA/Auth.php';
require_once MAX_PATH . '/lib/OA/Email.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Admin/Redirect.php';


class OA_Admin_PasswordRecovery
{
    /** @var OA_Dal_PasswordRecovery */
    private $_dal;

    public function __construct()
    {
        $this->_useDefaultDal();
    }

    public function _useDefaultDal()
    {
        $oServiceLocator = OA_ServiceLocator::instance();

        $this->_dal = $oServiceLocator->get('OA_Dal_PasswordRecovery') ?: new OA_Dal_PasswordRecovery();
    }

    /**
     * Display page header
     *
     */
    public function pageHeader(bool $isWelcomePage = false)
    {
        $oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel(null, null, $isWelcomePage ? 'welcome' : 'recovery');

        phpAds_PageHeader(phpAds_PasswordRecovery, $oHeaderModel);

        echo "<br><br>";
    }

    /**
     * Display page footer and make sure that the session gets destroyed
     *
     */
    public function pageFooter()
    {
        // Remove session
        unset($GLOBALS['session']);

        phpAds_PageFooter();
    }

    /**
     * Display an entire page with the password recovery form.
     *
     * This method, combined with handlePost allows semantic, REST-style
     * actions.
     */
    public function handleGet($vars)
    {
        if (empty($vars['id'])) {
            $this->pageHeader();
            $this->displayRecoveryRequestForm();
            $this->pageFooter();

            return;
        }

        $doUser = $this->_dal->getUserFromRecoveryId($vars['id']);

        // Load the appropriate language
        Language_Loader::load('default', $doUser->language);

        if (null === $doUser) {
            $this->pageHeader();
            $this->displayRecoveryRequestForm($GLOBALS['strPwdRecWrongExpired']);
            $this->pageFooter();

            return;
        }

        // Empty password hash means welcome page
        $isWelcomePage = '' === $doUser->password;
        $this->pageHeader($isWelcomePage);

        if ($isWelcomePage) {
            $this->displayMessage($GLOBALS['strWelcomePageText']);
            echo "<br><br>";
        }

        $this->displayRecoveryResetForm($vars['id'], $doUser);
        $this->pageFooter();
    }

    /**
     * Display an entire page with the password recovery form.
     *
     * This method, combined with handleGet allows semantic, REST-style
     * actions.
     */
    public function handlePost($vars)
    {
        OA_Permission::checkSessionToken();

        $this->pageHeader();
        if (empty($vars['id'])) {
            if (empty($vars['email'])) {
                $this->displayRecoveryRequestForm($GLOBALS['strEmailRequired']);
            } else {
                $this->sendRecoveryEmail($vars['email']);

                // Always pretend an email was sent, even if not to avoid information disclosure
                $this->displayMessage($GLOBALS['strNotifyPageMessage']);
            }
        } elseif ($doUser = $this->_dal->getUserFromRecoveryId($vars['id'])) {
            $auth = new Plugins_Authentication();
            $auth->validateUsersPassword($vars['newpassword'] ?? '', $vars['newpassword2'] ?? '');

            if (empty($auth->aValidationErrors)) {
                $this->_dal->saveNewPasswordAndLogin($doUser->user_id, $vars['id'], $vars['newpassword']);

                phpAds_SessionRegenerateId(true);
                OX_Admin_Redirect::redirect();
            } else {
                $this->displayRecoveryResetForm($vars['id'], $doUser, current($auth->aValidationErrors));
            }
        } else {
            $this->displayRecoveryRequestForm($GLOBALS['strPwdRecWrongExpired']);
        }
        $this->pageFooter();
    }

    /**
     * Display a message
     *
     * @param string message to be displayed
     */
    public function displayMessage($message)
    {
        phpAds_showBreak();

        echo "<br /><span class='install' >{$message}</span><br /><br />";
        echo "<td width='40%'>&nbsp;</td><td><br />";

        phpAds_showBreak();
    }

    /**
     * Display recovery request form
     *
     * @param string error message text
     */
    public function displayRecoveryRequestForm($errormessage = '')
    {
        if (!empty($errormessage)) {
            echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='" . OX::assetPath() . "/images/errormessage.gif' align='absmiddle'>&nbsp;";
            echo "<span class='tab-r'>{$errormessage}</span></div>";
        }

        echo "<form method='post' action='password-recovery.php'>\n";

        echo "<input type='hidden' name='token' value='" . phpAds_SessionGetToken() . "'/>\n";

        echo "<div class='install'>" . $GLOBALS['strPwdRecEnterEmail'] . "</div>";
        echo "<table cellpadding='0' cellspacing='0' border='0'>";
        echo "<tr><td colspan='2'><img src='" . OX::assetPath() . "/images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "<tr height='24'><td>" . $GLOBALS['strEMail'] . ":&nbsp;</td><td><input type='text' name='email' /></td></tr>";
        echo "<tr height='24'><td>&nbsp;</td><td><input type='submit' value='" . $GLOBALS['strProceed'] . "' /></td></tr>";
        echo "<tr><td colspan='2'><img src='" . OX::assetPath() . "/images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "</table>";

        echo "</form>\n";
    }

    /**
     * Display new password form
     *
     * @param string error message text
     */
    public function displayRecoveryResetForm($id, DataObjects_Users $doUser, $errormessage = '')
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        if (!empty($errormessage)) {
            echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='" . OX::assetPath() . "/images/errormessage.gif' align='absmiddle'>&nbsp;";
            echo "<span class='tab-r'>{$errormessage}</span></div>";
        }

        echo "<script src='assets/js/zxcvbn.js'></script>";

        echo "<form method='post' action='password-recovery.php' onsubmit='return max_formValidate(this)'>\n";
        echo "<input type='hidden' name='id' value=\"" . htmlspecialchars($id) . "\" />\n";
        echo "<input type='hidden' name='token' value='" . phpAds_SessionGetToken() . "'/>\n";

        echo "<div class='install'>" . $GLOBALS['strPwdRecEnterPassword'] . "</div>";
        echo "<table cellpadding='0' cellspacing='0' border='0'>";
        echo "<tr><td colspan='2'><img src='" . OX::assetPath() . "/images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "<tr height='24'><td>" . $GLOBALS['strUsername'] . ":&nbsp;</td><td><input type='text' name='username' autocomplete='username' value=\"" . htmlspecialchars($doUser->username) . "\" class='medium flat' disabled /></td></tr>";
        echo "<tr height='24'><td>" . $GLOBALS['strChooseNewPassword'] . ":&nbsp;</td><td><input type='password' name='newpassword' autocomplete='new-password' class='medium flat zxcvbn-check' onblur='max_formValidateElement(this)'/></td></tr>";
        echo "<tr height='24'><td>" . $GLOBALS['strReenterNewPassword'] . ":&nbsp;</td><td><input type='password' name='newpassword2' autocomplete='new-password' class='medium flat' onblur='max_formValidateElement(this)' /></td></tr>";
        echo "<tr height='24'><td>&nbsp;</td><td><input type='submit' value='" . $GLOBALS['strProceed'] . "' /></td></tr>";
        echo "<tr><td colspan='2'><img src='" . OX::assetPath() . "/images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "</table>";

        echo "</form>\n";

        echo "<script>\n";
        echo "max_formSetRequirements('newpassword', '" . addcslashes($GLOBALS['strChooseNewPassword'], "\0..\37'\\") . "', true, 'string+" . ($aConf['security']['passwordMinLength'] ?? OA_Auth::DEFAULT_MIN_PASSWORD_LENGTH) . "');";
        echo "max_formSetRequirements('newpassword2', '" . addcslashes($GLOBALS['strReenterNewPassword'], "\0..\37'\\") . "', true, 'compare:newpassword');";
        echo "</script>\n";
    }

    public function displayResetRequiredUponLogin()
    {
        $this->pageHeader();

        $this->displayMessage("
        <h2>" . htmlspecialchars($GLOBALS['strPasswordResetRequiredTitle']) . "</h2><br>
        <p>" . str_replace("\n", '</p><p>', htmlspecialchars(trim($GLOBALS['strPasswordResetRequired']))) . "</p>
        ");

        $this->pageFooter();
    }

    /**
     * Check if the user is allowed to see the password recovery tools
     *
     */
    public function checkAccess()
    {
        return !OA_Auth::isLoggedIn() && !OA_Auth::suppliedCredentials();
    }

    /**
     * Send the password recovery email
     *
     * @param string email address
     * @return int Number of emails sent
     */
    public function sendRecoveryEmail(string $emailAddress): int
    {
        // Find all users matching the specified email address -
        // the email address may be associated with multiple users
        $aUsers = $this->_dal->searchMatchingUsers($emailAddress);

        $sent = $this->sendEmailToUsers(
            $aUsers,
            'strPwdRecEmailPwdRecovery',
            'strPwdRecEmailBody'
        );

        return $sent;
    }

    /**
     * Send the welcome email, only if the user hasn't set their password yet.
     *
     * @param int[] The userIDs
     */
    public function sendWelcomeEmail(array $userIds): int
    {
        $aUsers = $this->_dal->searchUsersByIds($userIds, true);

        $sent = $this->sendEmailToUsers(
            $aUsers,
            'strWelcomeEmailSubject',
            'strWelcomeEmailBody'
        );

        return $sent;
    }

    /**
     * Send the password update email.
     *
     * @param int[] The userIDs
     */
    public function sendPasswordUpdateEmail(array $userIds): int
    {
        $aUsers = $this->_dal->searchUsersByIds($userIds);

        $sent = $this->sendEmailToUsers(
            $aUsers,
            'strPasswordUpdateEmailSubject',
            'strPasswordUpdateEmailBody'
        );

        return $sent;
    }

    /**
     * Private method to send the actual email(s)
     *
     * @todo Set email language according to the account preferences
     *
     * @param array $aUsers
     * @param string $subjectVar The name of the global variable for the subject translation
     * @param string $bodyVar The name of the global variable for the body translation
     *
     * @return int The number of e-mails that were sent
     */
    private function sendEmailToUsers(array $aUsers, string $subjectVar, string $bodyVar): int
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        if (empty($aUsers)) {
            return 0;
        }

        $applicationName = $aConf['ui']['applicationName'] ?: PRODUCT_NAME;

        // Send a separate password reset link in an email for each
        // of the users found that match the email address
        $sent = 0;
        foreach ($aUsers as $u) {
            // Generate the password reset URL for this user
            $recoveryId = $this->_dal->generateRecoveryId($u['user_id']);
            $recoveryUrl = MAX::constructURL(MAX_URL_ADMIN, "password-recovery.php?id={$recoveryId}");

            // Load the appropriate language details for the email recipient
            Language_Loader::load('default', $u['language']);

            // Generate the password reset email subject
            $emailSubject = sprintf($GLOBALS[$subjectVar], $applicationName);

            // Generate the body of the password reset email for this user
            $emailBody = $GLOBALS[$bodyVar];
            $emailBody = str_replace('{name}', $u['contact_name'], $emailBody);
            $emailBody = str_replace('{username}', $u['username'], $emailBody);
            $emailBody = str_replace('{reset_link}', $recoveryUrl, $emailBody);

            if (!empty($aConf['email']['fromName']) && !empty($aConf['email']['fromAddress'])) {
                $adminSignature = "{$GLOBALS['strPwdRecEmailSincerely']}\n\n{$aConf['email']['fromName']}\n{$aConf['email']['fromAddress']}";
            } elseif (!empty($aConf['email']['fromName'])) {
                $adminSignature = "{$GLOBALS['strPwdRecEmailSincerely']}\n\n{$aConf['email']['fromName']}";
            } elseif (!empty($aConf['email']['fromAddress'])) {
                $adminSignature = "{$GLOBALS['strPwdRecEmailSincerely']}\n\n{$aConf['email']['fromAddress']}";
            } else {
                $adminSignature = "";
            }

            $emailBody = str_replace('{admin_signature}', $adminSignature, $emailBody);
            $emailBody = str_replace('{application_name}', $applicationName, $emailBody);

            // Send the password reset email
            $oEmail = new OA_Email();
            $oEmail->sendMail($emailSubject, $emailBody, $u['email_address'], $u['contact_name']);

            // Iterate the number of emails sent
            $sent++;
        }

        // Return the number of emails sent
        return $sent;
    }
}
