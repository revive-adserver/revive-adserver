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
class Language_Loader
{
    private static array $aLastLoaded = [];

    /**
     * The method to load the selected language file.
     *
     * Section should to be a name of requested language file excluding the .lang.php extension.
     * Lang is a name of directory with language files
     *
     * @param string $section section of the system
     * @param string $lang  language symbol
     */
    public static function load($section = 'default', $lang = null)
    {
        if (!defined('phpAds_dbmsname')) {
            define('phpAds_dbmsname', '');
        }
        // Always load the English language, in case of incomplete translations
        if (!self::loadLanguage($section, 'en')) {
            return;
        }

        self::loadLanguage($section, self::resolveLanguage($lang));
    }

    /**
     * Resolve an explicit language, the user preference, or the global configuration.
     */
    public static function resolveLanguage($lang = null): string
    {
        if ($lang === null && !empty($GLOBALS['_MAX']['PREF']['language'])) {
            $lang = $GLOBALS['_MAX']['PREF']['language'];
        }

        // An explicit or user language takes precedence over the configuration,
        // including when the language is English.
        if (!empty($lang) && preg_match('#^[a-z][a-z](_[A-Z][A-Z])?$#', $lang)) {
            return $lang;
        }

        // Map legacy full language names (for example, polish) to locale codes.
        $confMaxLanguage = $GLOBALS['_MAX']['CONF']['max']['language'] ?? 'en';
        if (isset(RV_Admin_Languages::$aOldLanguagesMap[$confMaxLanguage])) {
            $confMaxLanguage = RV_Admin_Languages::$aOldLanguagesMap[$confMaxLanguage];
        }

        return $confMaxLanguage ?: 'en';
    }

    private static function loadLanguage($section, $lang): bool
    {
        if ($lang === (self::$aLastLoaded[$section] ?? null)) {
            return true;
        }

        $path = MAX_PATH . '/lib/max/language/' . $lang . '/' . $section . '.lang.php';

        if (!file_exists($path)) {
            return false;
        }

        $PRODUCT_NAME = PRODUCT_NAME;
        $PRODUCT_URL = PRODUCT_URL;
        $PRODUCT_DOCSURL = PRODUCT_DOCSURL;
        $phpAds_dbmsname = phpAds_dbmsname;

        include $path;

        self::$aLastLoaded[$section] = $lang;

        return true;
    }
}
