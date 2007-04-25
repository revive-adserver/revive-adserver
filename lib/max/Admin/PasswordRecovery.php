<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

/**
 * Password recovery for Openads
 *
 */

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/PasswordRecovery.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';

class MAX_Admin_PasswordRecovery
{
    /* @var MAX_Dal_PasswordRecovery */
    var $_dal;
     
    /**
     * PHP5-style constructor
     */
    function __construct()
    {
        $this->_useDefaultDal();
    }
   
    /**
     * PHP4-style constructor
     */
    function MAX_Admin_PasswordRecovery()
    {
        $this->__construct();
    }
    
    function _useDefaultDal()
    {
        $oServiceLocator = ServiceLocator::instance();
        $dal =& $oServiceLocator->get('MAX_Dal_PasswordRecovery');
        if (!$dal) {
            $dal = new MAX_Dal_PasswordRecovery();
        }
        $this->_dal =& $dal;
    }
    
    /**
     * Display page header
     * 
     */
    function pageHeader()
    {
        // Setup navigation
        $nav = array ("1" => array("password-recovery.php" => $GLOBALS['strPasswordRecovery']));
        
        $GLOBALS['phpAds_nav'] = array(
            'admin'     => $nav,
            'agency'    => $nav,
            'client'    => $nav,
            'affiliate' => $nav
        );
        
        phpAds_PageHeader("1");

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
            MAX_Admin_Redirect::redirect();
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
                    $this->displayMessage($GLOBALS['strPwdRecEmailSent']);
                } else {
                $this->displayRecoveryRequestForm($GLOBALS['strPwdRecEmailNotFound']);
                }
            }
        } else {
            if (empty($vars['password']) || empty($vars['password2']) || $vars['password'] != $vars['password2']) {
                $this->displayRecoveryResetForm($vars['id'], $GLOBALS['strNotSamePasswords']);
            } elseif ($this->_dal->checkRecoveryId($vars['id'])) {
                $this->_dal->saveNewPassword($vars['id'], stripslashes($vars['password']));
                $this->displayMessage($GLOBALS['strPwdRecPasswordSaved']);
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
            echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
            echo "<span class='tab-r'>{$errormessage}</span></div>";
        }
        
        echo "<form method='post' action='password-recovery.php'>\n";
        
        echo "<div class='install'>".$GLOBALS['strPwdRecEnterEmail']."</div>";
        echo "<table cellpadding='0' cellspacing='0' border='0'>";
        echo "<tr><td colspan='2'><img src='images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "<tr height='24'><td>".$GLOBALS['strEMail'].":&nbsp;</td><td><input type='text' name='email' /></td></tr>";
        echo "<tr height='24'><td>&nbsp;</td><td><input type='submit' value='".$GLOBALS['strProceed']."' /></td></tr>";
        echo "<tr><td colspan='2'><img src='images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
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
            echo "<div class='errormessage' style='width: 400px;'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
            echo "<span class='tab-r'>{$errormessage}</span></div>";
        }
        
        echo "<form method='post' action='password-recovery.php'>\n";
        echo "<input type='hidden' name='id' value='".htmlentities($id)."' />";
        
        echo "<div class='install'>".$GLOBALS['strPwdRecEnterPassword']."</div>";
        echo "<table cellpadding='0' cellspacing='0' border='0'>";
        echo "<tr><td colspan='2'><img src='images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "<tr height='24'><td>".$GLOBALS['strPassword'].":&nbsp;</td><td><input type='password' name='password' /></td></tr>";
        echo "<tr height='24'><td>".$GLOBALS['strRepeatPassword']."&nbsp;</td><td><input type='password' name='password2' /></td></tr>";
        echo "<tr height='24'><td>&nbsp;</td><td><input type='submit' value='".$GLOBALS['strProceed']."' /></td></tr>";
        echo "<tr><td colspan='2'><img src='images/break-el.gif' width='400' height='1' vspace='8'></td></tr>";
        echo "</table>";

        echo "</form>\n";
    }
    
    /**
     * Check if the user is allowed to see the password recovery tools
     *
     */
    function checkAccess()
    {
        return !phpAds_isLoggedIn() && !phpAds_SuppliedCredentials();
    }
    
    /**
     * Send the password recovery email
     *
     * @param string email address
     * @return int Number of emails sent
     */
    function sendRecoveryEmail($email)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $old_prefs = $GLOBALS['_MAX']['PREF'];
        
        $users = $this->_dal->searchMatchingUsers($email);
        
        $agencies = array();
        foreach ($users as $u) {
            $agencies[$u['agencyid']][$u['email']][] = $u;
        }
        
        $sent = 0;
        foreach ($agencies as $agencyId => $emails) {
            $pref = MAX_Admin_Preferences::loadPrefs($agencyId);
            Language_Default::load();
            
            foreach ($emails as $email => $users) {
                $text = '';
                foreach ($users as $u) {
                    $recovery_id = $this->_dal->generateRecoveryId($u['usertype'], $u['id']);
                    if ($u['usertype'] == 'publisher') {
                        $u['usertype'] = 'affiliate';
                    } elseif ($u['usertype'] == 'advertiser') {
                        $u['usertype'] = 'client';
                    }
                    $header = $GLOBALS['str'.ucfirst($u['usertype'])]." {$u['name']}";
                    $text .= $header."\n".str_repeat('-', strlen($header))."\n";
                    $text .= $GLOBALS['strUsername'].": {$u['username']}\n";
                    $text .= $GLOBALS['strPwdRecResetLink'].": ";
                    $text .= Max::constructURL(MAX_URL_ADMIN, "password-recovery.php?id={$recovery_id}")."\n\n";
                }
                
                // Hack
                $GLOBALS['_MAX']['CONF']['email']['admin_name'] = $pref['admin_fullname'];
                $GLOBALS['_MAX']['CONF']['email']['admin'] = $pref['admin_email'];
                
                MAX::sendMail($email, $email, sprintf($GLOBALS['strPwdRecEmailPwdRecovery'], $pref['name']), $text);
                $sent++;
            }
        }

        // Restore preferences
        $GLOBALS['_MAX']['PREF'] = $old_prefs;
        Language_Default::load();

        return $sent;
    }
}

?>
