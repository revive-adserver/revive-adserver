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
 * Defines type of link building
 */
define('OA_HELP_LINK_BUILD_USING_LINK', 1);
define('OA_HELP_LINK_BUILD_USING_ID', 2);
$GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_LINK;

/**
 * A class for generating context sensitive help links to the documentation.
 *
 * @package    OpenXAdmin
 */
class OA_Admin_Help
{
    /**
     * Creates a link documentation help link for a given menu section. If
     * section has no help assigned or section is null link to main help is
     * returned.
     *
     * @param OA_Admin_Menu_Section $menuSection menu section to find help for
     * @return string url to documentation page
     */
    public static function getHelpLink($menuSection)
    {
        $relativeHelpPath = $menuSection != null ? $menuSection->getHelpLink() : "";

        // The link is not relative, we directly link to it
        if (strpos($relativeHelpPath, '://') !== false) {
            return $relativeHelpPath;
        }

        // Convert original help links to new Revive Adserver format
        if (strpos($relativeHelpPath, 'settings') !== false) {
            $relativeHelpPath = strpos($relativeHelpPath, '/') !== 0 ? '/admin/' . $relativeHelpPath : '/admin' . $relativeHelpPath;
        } elseif (strpos($relativeHelpPath, '/') !== 0) {
            $relativeHelpPath = '/user/' . $relativeHelpPath;
        } else {
            $relativeHelpPath = '/user' . $relativeHelpPath;
        }

        return self::buildHelpLink($relativeHelpPath);
    }


    /**
     * Creates a link documentation help link for a given relative path.
     *
     * @param String $relativeHelpPath help path appened after main doc path
     * @return string url to documentation page
     */
    private static function buildHelpLink($relativeHelpPath)
    {
        // if empty the main help URL
        if (empty($relativeHelpPath)) {
            // Send the user to the main page
            $sURL = PRODUCT_DOCSURL;
        } else {
            // Send the user to the correct page
            $prefix = "";
            if (strpos($relativeHelpPath, '/') !== 0) {
                $prefix = "/";
            }
            $sURL = PRODUCT_DOCSURL . $prefix . $relativeHelpPath;
        }
        return $sURL;
    }
}
