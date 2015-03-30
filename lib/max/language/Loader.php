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

require_once MAX_PATH . '/lib/RV/Admin/Languages.php';

/**
 * @package    MaxUI
 * @subpackage Language
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
        if(!defined('phpAds_dbmsname')) {
            define('phpAds_dbmsname','');
        }
        $aConf = $GLOBALS['_MAX']['CONF'];
        if (!empty($GLOBALS['_MAX']['PREF'])) {
            $aPref = $GLOBALS['_MAX']['PREF'];
        } else {
            $aPref = array();
        }
        if (is_null($lang) && !empty($aPref['language'])) {
            $lang = $aPref['language'];
        }

        $PRODUCT_NAME = PRODUCT_NAME;
        $PRODUCT_DOCSURL = PRODUCT_DOCSURL;
        $phpAds_dbmsname = phpAds_dbmsname;

        // Always load the English language, in case of incomplete translations
        if (file_exists (MAX_PATH . '/lib/max/language/en/' . $section . '.lang.php')) {
            include MAX_PATH . '/lib/max/language/en/' . $section . '.lang.php';
        } else {
            return; // Wrong section
        }
        // Load the language from preferences, if possible, otherwise load
        // the global preference, if possible
        // If language preference is set, do not load language from config file (common bug here is to check if prefereced language is 'en'!)
        if (!empty($lang)
            && file_exists(MAX_PATH . '/lib/max/language/' . $lang . '/' . $section . '.lang.php'))
        {
            // Now check if is need to load language (english is loaded)
            if ($lang != 'en') {
                include MAX_PATH . '/lib/max/language/' . $lang . '/' . $section . '.lang.php';
            }
        } else {
            // Check if using full language name (polish), if so then set to use two letter abbr (pl).
            if (!empty($aConf['max']['language'])) {
                $confMaxLanguage = $aConf['max']['language'];
                if (isset(RV_Admin_Languages::$aOldLanguagesMap[$confMaxLanguage])) {
                    $confMaxLanguage = RV_Admin_Languages::$aOldLanguagesMap[$confMaxLanguage];
                }
            }

            if (!empty($confMaxLanguage) && $confMaxLanguage != 'en'
                && file_exists(MAX_PATH . '/lib/max/language/' . $confMaxLanguage . '/' . $section . '.lang.php'))
            {
                include MAX_PATH . '/lib/max/language/' . $confMaxLanguage .
                    '/' . $section . '.lang.php';
            }
        }
    }

}

?>
