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
 * Password recovery for Openads
 *
 */

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/PasswordRecovery.php';
require_once MAX_PATH . '/lib/OA/Auth.php';
require_once MAX_PATH . '/lib/OA/Email.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Admin/Redirect.php';


class OA_Admin_PasswordRecovery
{
    /**
     *  @var OA_Dal_PasswordRecovery
     */
    var $_dal;

    /**
     * PHP4-style constructor
     */
    function OA_Admin_PasswordRecovery()
    {
        $this->_useDefaultDal();
    }

    function _useDefaultDal()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $dal =& $oServiceLocator->get('OA_Dal_PasswordRecovery');
        if (!$dal) {
            $dal = new OA_Dal_PasswordRecovery();
        }
        $this->_dal =& $dal;
    }

    /**
     * Display page header
     *
     */
    function pageHeader()
    {
        phpAds_PageHeader(phpAds_PasswordRecovery);

        echo "<br><br>";
    }

    /**
     * Display page footer and make sure that the session gets destroyed
     *
     */
    function pageFooter()
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
    function handleGet($vars)
    {
        $this->pageHeader();
        if (empty($vars['id'])) {
            $this->displayRecoveryRequestForm();
        } elseif ($this->_dal->checkRecoveryId($vars['id'])) {
            $this->displayRecoveryResetForm($vars['id']);
        } else {
            OX_Admin_Redirect::redirect();
        }
        $this->pageFooter();
    }

    /**
     * Display an entire page with the password recovery form.
     *
     * This method, combined with handleGet allows semantic, REST-style
     * actions.
     */
    function handlePost($vars)
    {
        $this->pageHeader();
        if (empty($vars['id'])) {
            if (empty($vars['email'])) {
                $this->displayRecoveryRequestForm($GLOBALS['strEmailRequired']);
            } else {
                $sent = $this->sendRecoveryEmail(stripslashes($vars['email']));
                if ($sent) {
                    $this->displayMessage($GLOBALS['strNotifyPageMessage']);
                } else {
                $this->displayRecoveryRequestForm($GLOBALS['strPwdRecEmailNotFound']);
                }
            }
        } else {
            if (empty($vars['newpassword']) || empty($vars['newpassword2']) || $vars['newpassword'] != $vars['newpassword2']) {
                $this->displayRecoveryResetForm($vars['id'], $GLOBALS['strNotSamePasswords']);
            } elseif ($this->_dal->checkRecoveryId($vars['id'])) {
                $userId = $this->_dal->saveNewPasswordAndLogin($vars['id'], stripslashes($vars['newpassword']));
                OX_Admin_Redirect::redirect();
            } else {
                $this->displayRecoveryRequestForm($GLOBALS['strPwdRecWrongId']);
            }
        }
        $this->pageFooter();
    }

    /**
     * Display a message
     *
     * @param string message to be displayed
     */
    function displayMessage($message)
    {
        phpAds_showBreak();

        echo "<br /><span class='install'>{$message}</span><br /><br />";

        phpAds_showBreak();
    }

    /**
     * Display recovery request form
     *
     * @param string error message text
     */
    function displayRecoveryRequestForm($errormessage = '')
    {
        if (!empty($errormessage)) {
            echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='" . OX::assetPath() . "/images/errormessage.gif' align='absmiddle'>";
            echo "<span class='tab-r'>{$errormessage}</span></div>";
        }

        echo "<form method='post' action='password-recovery.php'>\n";

        echo "<div class='install'>".$GLOBALS['strPwdRecEnterEmail']."</div>";
        echo "<table cellpadding='0' cellspacing='0' border='0'>";
        echo "<tr><td colspan='2'><img src='" . OX::assetPath() . "/images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "<tr height='24'><td>".$GLOBALS['strEMail'].":&nbsp;</td><td><input type='text' name='email' /></td></tr>";
        echo "<tr height='24'><td>&nbsp;</td><td><input type='submit' value='".$GLOBALS['strProceed']."' /></td></tr>";
        echo "<tr><td colspan='2'><img src='" . OX::assetPath() . "/images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "</table>";

        echo "</form>\n";
    }

    /**
     * Display new password form
     *
     * @param string error message text
     */
    function displayRecoveryResetForm($id, $errormessage = '')
    {
        if (!empty($errormessage)) {
            echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='" . OX::assetPath() . "/images/errormessage.gif' align='absmiddle'>";
            echo "<span class='tab-r'>{$errormessage}</span></div>";
        }

        echo "<form method='post' action='password-recovery.php'>\n";
        echo "<input type='hidden' name='id' value=\"".htmlspecialchars($id)."\" />";

        echo "<div class='install'>".$GLOBALS['strPwdRecEnterPassword']."</div>";
        echo "<table cellpadding='0' cellspacing='0' border='0'>";
        echo "<tr><td colspan='2'><img src='" . OX::assetPath() . "/images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "<tr height='24'><td>".$GLOBALS['strPassword'].":&nbsp;</td><td><input type='password' name='newpassword' /></td></tr>";
        echo "<tr height='24'><td>".$GLOBALS['strRepeatPassword'].":&nbsp;</td><td><input type='password' name='newpassword2' /></td></tr>";
        echo "<tr height='24'><td>&nbsp;</td><td><input type='submit' value='".$GLOBALS['strProceed']."' /></td></tr>";
        echo "<tr><td colspan='2'><img src='" . OX::assetPath() . "/images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "</table>";

        echo "</form>\n";
    }

    /**
     * Check if the user is allowed to see the password recovery tools
     *
     */
    function checkAccess()
    {
        return !OA_Auth::isLoggedIn() && !OA_Auth::suppliedCredentials();
    }

    /**
     * Send the password recovery email
     *
     * @todo Set email language according to the account preferences
     *
     * @param string email address
     * @return int Number of emails sent
     */
    function sendRecoveryEmail($email)
    {
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aPref = $GLOBALS['_MAX']['PREF'];

        $aUsers = $this->_dal->searchMatchingUsers($email);

        $aEmails = array();
        foreach ($aUsers as $u) {
            $aEmails[$u['email_address']][] = $u;
        }

        $sent = 0;
        foreach ($aEmails as $email => $aUsers) {
            $text = '';
            foreach ($aUsers as $u) {
                $recoveryId = $this->_dal->generateRecoveryId($u['user_id']);

                $header = $GLOBALS['strUser']." {$u['contact_name']}";
                $text .= $header."\n".str_repeat('-', strlen($header))."\n";
                $text .= $GLOBALS['strUsername'].": {$u['username']}\n";
                $text .= $GLOBALS['strPwdRecResetLink'].": ";
                $text .= Max::constructURL(MAX_URL_ADMIN, "password-recovery.php?id={$recoveryId}")."\n\n";
            }

            // Hack
            $aConf['email']['admin_name'] = $aPref['admin_fullname'];
            $aConf['email']['admin']      = $aPref['admin_email'];

            $oEmail = new OA_Email();
            $oEmail->sendMail(sprintf($GLOBALS['strPwdRecEmailPwdRecovery'], $aPref['name']), $text, $email, $u['username']);
            $sent++;
        }

        return $sent;
    }
}

?>
