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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/Max.php';

require_once OX_PATH . '/lib/OX.php';

/**
 * A class for managing easy redirecton in the administration interface.
 *
 * @package    OpenX
 * @static
 */
class OX_Admin_Redirect
{
    /**
     * A method to perform redirects. Only suitable for use once OpenX is installed,
     * as it requires the OpenX configuration file to be correctly set up.
     *
     * @param string  $adminPage           The administration interface page to redirect to
     *                                     (excluding a leading slash ("/")). Default is the
     *                                     index (i.e. login) page.
     * @param boolean $manualAccountSwitch Flag to know if the user has switched account.
     * @param boolean $redirectTopLevel    Flag to know if the redirection should be to the top
     *                                     level, even it not a manual account switch.
     */
    public static function redirect($adminPage = 'index.php', $manualAccountSwitch = false, $redirectTopLevel = false)
    {
        if ($manualAccountSwitch || $redirectTopLevel) {
            // Get the page where the user was in when switched account
            if (!empty($_SERVER['HTTP_REFERER'])) {
                $aUrlComponents = parse_url($_SERVER['HTTP_REFERER']);
            } elseif (!empty($_SERVER['REQUEST_URI'])) {
                $aUrlComponents = parse_url($_SERVER['REQUEST_URI']);
            }
            $aPathInformation = pathinfo($aUrlComponents['path']);
            $sectionID = $aPathInformation['filename'];
            // Get the top level page
            $adminPage = OA_Admin_UI::getTopLevelPage($sectionID);
            if (!empty($adminPage)) {
                header('Location: ' . MAX::constructURL(MAX_URL_ADMIN, $adminPage));
                exit;
            }
        }

        if (!$manualAccountSwitch || empty($return_url) && empty($GLOBALS['installing'])) {
            if (!preg_match('/[\r\n]/', $adminPage)) {
                header('Location: ' . MAX::constructURL(MAX_URL_ADMIN, $adminPage));
                exit;
            }
        }

        exit;
    }
}
