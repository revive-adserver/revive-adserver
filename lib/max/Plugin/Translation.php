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
 * MAX_Plugin_Translation - plugin translation system.
 *
 * @package    OpenXPlugin
 */
class MAX_Plugin_Translation
{
    /**
     * Include plugin translation file. The method is trying to include
     * plugin translation file first for language saved in preferences and
     * if this operation failed for language from global config
     * This method could be called automatically by translate() method
     * lazy initialization
     *
     * @param string $module   Module name
     * @param string $package  Package name
     * @see translate()
     * @todo TODOLANG The CONF fallback below will fail
     *
     * @return boolean         True on success else false
     *
     */
    public static function init($module, $package = null)
    {
        if (isset($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module][$package])) {
            // Already included
            return true;
        }
        if (!empty($GLOBALS['_MAX']['PREF']['language'])) {
            $language = $GLOBALS['_MAX']['PREF']['language'];
        } elseif (!empty($GLOBALS['_MAX']['CONF']['max']['language'])) {
            $language = $GLOBALS['_MAX']['CONF']['max']['language'];
        } else {
            $language = 'en';
        }

        if (MAX_Plugin_Translation::includePluginLanguageFile($module, $package, $language)) {
            return true;
        }
    }

    /**
     * Include plugin (package) language file and assign the translation
     * to global plugin translation variable
     *
     * @access public
     * @static
     * @param string $module    Module name
     * @param string $package   Package name
     * @param string $language  Language
     * @param string $path      We could also pass the language path (used mainly for testing)
     *
     * @return boolean  True if file and translation exists else false
     *
     */
    public static function includePluginLanguageFile($module, $package, $language, $path = null)
    {
        // Required for lazy initialization
        if ($package === null && !isset($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module])) {
            $GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module] = [];
        } elseif (!isset($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module][$package])) {
            $GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module][$package] = [];
        }

        if ($path === null) {
            if ($package === null) {
                $path = MAX_PATH . '/plugins/' . $module . '/_lang/';
            } else {
                $path = MAX_PATH . '/plugins/' . $module . '/' . $package . '/_lang/';
            }
        }

        // Load up the english translation if available
        if (is_readable($path . 'en.php')) {
            $words = null;
            include $path . 'en.php';
            //  If current module is not the default openads module
            if (null !== $words) {
                if ($package === null) {
                    $GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module] = $words;
                } else {
                    $GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module][$package] = $words;
                }
            }
        }

        if (is_readable($path . $language . '.php')) {
            $words = null;
            include $path . $language . '.php';
            //  If current module is not the default openads module
            if (null !== $words) {
                if ($package === null) {
                    $GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module] = array_merge($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module], $words);
                } else {
                    $GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module][$package] = array_merge($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module][$package], $words);
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Translates source text into target language.
     *
     * @param   string  $key Translation term
     * @param   string  $extension extension name
     * @param   string  $group group name
     *
     * @return  string translated text
     */
    public static function translate($key, $extension, $group = null)
    {
        MAX_Plugin_Translation::lazyInit($extension, $group);

        // First try and get a translation from the specific group...
        if (isset($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$extension][$group][$key])) {
            return $GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$extension][$group][$key];
        // If there is no specific translation fall back to the extension...
        // Check it is not an array in case the key is the same as the group name.
        } elseif (isset($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$extension][$key])
            && !is_array($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$extension][$key])) {
            return $GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$extension][$key];
        // If all else fails, give up and return the un-translated string
        } else {
            return $key;
        }
    }

    /**
     * Initialize translation files
     *
     * @param string $module
     * @param string $package
     */
    private static function lazyInit($module, $package)
    {
        if (!isset($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module])) {
            MAX_Plugin_Translation::init($module, $package);
        }
        if (!isset($GLOBALS['_MAX']['PLUGIN_TRANSLATION'][$module][$package])) {
            MAX_Plugin_Translation::init($module, $package);
        }
    }
}
