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
     * Creates a link documentation help link for a given menu section. If section has no help assigned or section is null 
     * link to main help is returned 
     *
     * @param OA_Admin_Menu_Section $menuSection menu section to find help for
     * @return string url to documentation page
     */
    function getHelpLink($menuSection)
    {
        if ($menuSection != null) {
            $relativeHelpPath = $menuSection->getHelpLink();            
        }
        else {
            $relativeHelpPath = "";
        }
        
        return OA_Admin_Help::buildHelpLink($relativeHelpPath);
    }
    
    
    /**
     * Creates a link documentation help link for a given relative path.
     *
     * @param String $relativeHelpPath help path appened after main doc path and product version
     * @return string url to documentation page
     */
    function buildHelpLink($relativeHelpPath)
    {
        // if empty the main help URL
        if (empty($relativeHelpPath))
        {
            // Send the user to the main page
            $sURL = OX_PRODUCT_DOCSURL;
        }
        else {
            // Send the user to the correct page
            $prefix = "/";
            if(strpos($relativeHelpPath, '/')=== 0) {
                $prefix = ""; //if it starts with / already do not add
            }
            
            $sURL = OX_PRODUCT_DOCSURL . $prefix .$relativeHelpPath;
        }

        return $sURL;
    }
}

?>