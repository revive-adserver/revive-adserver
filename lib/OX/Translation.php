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

require_once MAX_PATH . '/lib/OA/Preferences.php';
require_once 'Zend/Translate.php';

/**
 * This class provides a translation mechanism which can be used throughout
 * the application, the translation memories are loaded from the application
 *
 * @todo This is just wrapping the old GLOBALS array. Need to plug in a proper i18n library.
 */
class OX_Translation
{
    /**
     * Boolean class property to control if the returned string should have HTML special characters escaped.
     *
     * @var boolean $htmlSpecialChars
     */
    public $htmlSpecialChars = false;

    /**
     * The output language to translate strings into
     *
     * @var string The language code for the selected language
     */
    public $locale = 'en_US';

    public $zTrans = false;

    public $debug = false;

    /**
     * Constructor class
     *
     * @param string $transPath The (optional) path to look for .mo translation resources
     * @return OX_Translation
     */
    public function __construct($transPath = null)
    {
        if (isset($GLOBALS['_MAX']['PREF']['language'])) {
            $this->locale = $GLOBALS['_MAX']['PREF']['language'];
        }

        if (!is_null($transPath)) {
            $transFile = MAX_PATH . $transPath . '/' . $this->locale . '.mo';
            if (@is_readable($transFile)) {
                $this->zTrans = new Zend_Translate('gettext', $transFile, $this->locale);
            } elseif (@is_readable(MAX_PATH . $transPath . '/en.mo')) {
                $this->zTrans = new Zend_Translate('gettext', MAX_PATH . $transPath . '/en.mo', 'en');
            }
        }
    }

    /**
     * This method looks up a translation string from the available translation memories
     * It will grow to include wrappers to _gettext or any other translation system that
     * we decide to employ
     *
     * @param string $sString The string (or code-key) to be translated
     * @param array $aValues An array of values to be substituted in the translated string (via sprintf)
     * @param mixed $pluralVar Type of variable controls action:
     *              boolean: Simple true/false control of whether the string should be in pluralized form
     *              string/int: Key of the plural var(s) in the $aValues array
     *              array: Array of string/int keys in the $aValues array
     *
     * @return string The translated string
     */
    public function translate($string, $aValues = [], $pluralVar = false)
    {
        if ($this->zTrans) {
            $return = $this->zTrans->_($string);
        } elseif (!empty($GLOBALS['str' . $string])) {
            $return = $GLOBALS['str' . $string];
        } else {
            $return = $string;
        }

        // If substitution variables have been provided
        if (!empty($aValues)) {
            $return = vsprintf($return, $aValues);
        }
        $return = ($this->htmlSpecialChars) ? htmlspecialchars($return) : $return;

        // For debugging add strike tags
        if ($this->debug) {
            $return = '<strike>' . $return . '</strike>';
        }

        return $return;
    }
}
