<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/Max.php';

require_once OX_PATH . '/lib/OX.php';

/**
 * A class for managing easy redirecton in the administration interface.
 *
 * @package    OpenX
 * @author     Andrew Hill <andrew.hill@openx.net>
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
     *
     */
    function redirect($adminPage = 'index.php', $manualAccountSwitch = false, $redirectTopLevel = false)
    {
        if ($manualAccountSwitch || $redirectTopLevel) {
            // Get the page where the user was in when switched account
            if (!empty($_SERVER['HTTP_REFERER'])) {
                $urlComponents = parse_url($_SERVER['HTTP_REFERER']);
            } elseif (!empty($_SERVER['REQUEST_URI'])) {
                $urlComponents = parse_url($_SERVER['REQUEST_URI']);
            }
            //$urlComponents = (empty($_SERVER['HTTP_REFERER'])) parse_url($_SERVER['HTTP_REFERER']);
            //$urlComponents = parse_url($_SERVER['HTTP_REFERER']);
            $pathInformation = pathinfo($urlComponents['path']);
            $sectionID = $pathInformation['filename'];
            // Get the top level page
            $return_url = OA_Admin_UI::getTopLevelPage($sectionID);
            if (!empty($return_url)) {
                header("Location: $return_url");
            }
        }

        if (!$manualAccountSwitch || empty($return_url)) {
            if (!preg_match('/[\r\n]/', $adminPage)) {
                header('Location: ' . MAX::constructURL(MAX_URL_ADMIN, $adminPage));
            }
        }
        exit;
    }

    function redirectIfNecessary($adminPage)
    {
        $oDesiredUrl = new MAX_Url();
        $oCurrentUrl = new MAX_Url();

        $full_desired_url_string = MAX::constructURL(MAX_URL_ADMIN, $adminPage);
        $oDesiredUrl->useValuesFromString($full_desired_url_string);
        $oCurrentUrl->useValuesFromServerVariableArray($_SERVER);
        if ($oDesiredUrl->equals($oCurrentUrl)) {
            return;
        }
        $this->redirect($adminPage);
    }

}

?>
