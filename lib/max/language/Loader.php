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
 * @package    MaxUI
 * @subpackage Language
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */

/**
 * A class that can be used to load the necessary language file(s) for
 * selected part of system.
 *
 * @static
 */
class Language_Loader {

    /**
     * The method to load the selected language file.
     * 
     * Section should to be a name of requested language file excluding the .lang.php extension.
     * Lang is a name of directory with language files
     *
     * @param string $section section of the system 
     * @param string $lang  language symbol
     */
    function load($section = 'default', $lang = null) {
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!empty($GLOBALS['_MAX']['PREF'])) {
            $aPref = $GLOBALS['_MAX']['PREF'];
        } else {
            $aPref = array();
        }
        if (is_null($lang) && !empty($aPref['language'])) {
            $lang = $aPref['language'];
        }
        // Always load the English language, in case of incomplete translations
        if (file_exists (MAX_PATH . '/lib/max/language/en/' . $section . '.lang.php')) {
            include MAX_PATH . '/lib/max/language/en/' . $section . '.lang.php';
        } else { 
            return; // Wrong section
        }
        // Load the language from preferences, if possible, otherwise load
        // the global preference, if possible
        if (!empty($lang) && 
                file_exists(MAX_PATH . '/lib/max/language/' . $lang . '/' . $section . '.lang.php')) {
            if ($lang != 'en') {
                include MAX_PATH . '/lib/max/language/' . $lang . '/' . $section . '.lang.php';
            }
        } elseif (($aConf['max']['language'] != 'en') && file_exists(MAX_PATH .
                '/lib/max/language/' . $aConf['max']['language'] . '/' . $section . '.lang.php')) {
            include MAX_PATH . '/lib/max/language/' . $aConf['max']['language'] .
                '/' . $section . '.lang.php';
        }
    }

}

?>
