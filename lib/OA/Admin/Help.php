<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
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
$Id: Config.php 7436 2007-06-11 14:20:35Z david.keen@openads.org $
*/

/**
 * Defines type of link building
 */
define('OA_HELP_LINK_BUILD_USING_LINK',      1);
define('OA_HELP_LINK_BUILD_USING_ID',        2);
$GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_LINK;

/**
 * A class for generating context sensitive help links to the documentation.
 *
 * @package    OpenXAdmin
 * @author     Marek Bedkowski <marek@bedkowski.pl>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Help
{

    /**
     * A method to get the documentation help link, based on the navID.
     *
     * @param  string $sNavId ID of navigation element in form {num}[.{num}[.{num}]]
     * @return string URL to the documentation.
     *
     * @author Marek Bedkowski <marek@bedkowski.pl>
     */
    function getDocLinkFromPhpAdsNavId($sNavId)
    {
        $accountType = OA_Permission::getAccountType();
        if (isset($GLOBALS['OA_NavigationHelp'][$accountType])) {
            $aNavi2help = $GLOBALS['OA_NavigationHelp'][$accountType];
        } else {
            $aNavi2help = array();
        }

        if (empty($aNavi2help[$sNavId]))
        {
            // Send the user to the main page
            $sURL = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/';
        }
        else
        {
            // Send the user to the correct page
            $sURL = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/' . rtrim(OA_DOCUMENTATION_PATH, '/') . '/';
            if (preg_match('/(\d+\.\d+)/', OA_VERSION, $aMatches))
            {
                $sURL .= $aMatches[1] . '/';
            }
            $sURL .= $aNavi2help[$sNavId][0] . '/';
        }
        return $sURL;
    }

}

?>