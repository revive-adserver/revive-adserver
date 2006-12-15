<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: LegalAgreement.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

/**
 * Legal agreement (terms and conditions) for Max Media Manager
 *
 * Agencies can require that their publishers agree to a set of
 * terms and conditions before using the service.
 * 
 *
 * @since 0.3.22 - Apr 13, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id: LegalAgreement.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
 */

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Dal/LegalAgreement.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';

class MAX_Admin_LegalAgreement
{
    /* @var MAX_Dal_LegalAgreement */
    var $_dal;
    
    /**
     * PHP4-style constructor
     */
    function MAX_Admin_LegalAgreement()
    {
        $this->_useDefaultDal();
    }
    
    function _useDefaultDal()
    {
        $oServiceLocator = ServiceLocator::instance();
        $dal =& $oServiceLocator->get('MAX_Dal_LegalAgreement');
        if (!$dal) {
            $dal = new MAX_Dal_LegalAgreement();
        }
        $this->_dal =& $dal;
    }
    
    function handlePost($vars)
    {
        if (!(isset($vars['agree']) && $vars['agree'])) {
            $this->displayApologyPage();
        } else {
            $this->acceptAgreementForLoggedInUser();
            $this->DisplayThankyou();
        }
    }
    
    /**
     * Display an entire page with the legal agreement form.
     * 
     * This method, combined with handlePost allows semantic, REST-style
     * actions.
     */
    function handleGet($errormessage = '')
    {
        // Setup navigation
        $nav = array ("1" => array("legal-agreement.php" => "Legal notice"));
        
        $GLOBALS['phpAds_nav'] = array(
            'admin'     => $nav,
            'agency'    => $nav,
            'client'    => $nav,
            'affiliate' => $nav
        );
        
        phpAds_PageHeader("1");
        $this->displayAgreementForm($errormessage);
        phpAds_PageFooter();
    }
    
    function displayThankyou()
    {
        MAX_Admin_Redirect::redirect();
    }
    
    /**
     * Marks the currently logged-in user as having agreed to their agency's terms.
     * 
     * Affects the database and the session variables.
     */
    function acceptAgreementForLoggedInUser()
    {
        global $session;
        
        if (!phpAds_isUser(phpAds_Publisher)) {
            MAX::raiseError('Only publishers have automated terms and conditions.');
        }
        $publisher_id = phpAds_getUserID();
        $this->_dal->acceptAgreementForPublisher($publisher_id);
        $session['needs_to_agree'] = false;
        phpAds_SessionDataStore();
        
        $plugins = &MAX_Plugin::getPlugins('legalAgreement');
        foreach ($plugins as $plugin) {
            if ($plugin->getHookType() == LEGALAGREEMENT_PLUGIN_POST_ACCEPT) {
                $plugin->run();
            }
        }
    }
    
    /**
     * Does the currently-logged in user need to agree to terms before continuing?
     */
    function doesCurrentUserNeedToSeeAgreement()
    {
        global $session;
        if (!(isset($session['needs_to_agree']) && $session['needs_to_agree'])) {
            return false;
        }
        $publisher_id = phpAds_getUserID();
        return $this->_dal->isAgreementNecessaryForPublisher($publisher_id);
    }
    
    function displayApologyPage()
    {
        $this->handleGet('Only users who have accepted the Terms and Conditions are allowed to use this product.');
    }
    
    function displayAgreementForm($errormessage = '')
    {
        $text = $this->getAgreementTextForCurrentUser();
        
        echo "<br><br>";
        phpAds_ShowBreak();
        
        if ($errormessage) {
            // Message
            echo "<br>";
            echo "<div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
            echo "<span class='tab-r'>&nbsp;".'Error'."</span><br><br>".$errormessage."</div><br>";
        }

        echo "<br>";
        
        echo "<form method='post' action='legal-agreement.php'>\n";
        echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tr>";
        echo "<td valign='top'><img src='images/install-license.gif'></td>";
        echo "<td width='100%' valign='top'><br>";
        echo "<span class='tab-s'>Legal agreement</span><br>";
        echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
        echo "<span class='install'>{$text}</span><br><br>";
        echo "</td></tr>";
        echo "<tr><td valign='top'>&nbsp;</td><td valign='top'>";
        echo "<input type='checkbox' name='agree' />I agree to the conditions";
        echo "</td> </tr></table>";

        phpAds_ShowBreak();
        echo "<input type='submit' name='continue' value='Continue' style='float: right' />\n";
        echo "</form>\n";
    }
    
    function getAgreementTextForCurrentUser()
    {
        $agency_id = phpAds_getAgencyID();
        $text = $this->_dal->getAgreementTextForAgency($agency_id);
        return $text;
    }
    
}

?>
