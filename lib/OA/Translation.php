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
$Id: Template.php 16124 2008-02-11 18:16:06Z andrew.hill@openads.org $
*/

require_once MAX_PATH . '/lib/OA/Preferences.php';
//require_once MAX_PATH . '/lib/php-gettext/gettext.inc';

/**
 * This class provides a translation mechanism which can be used throughout
 * the application, the translation memories are loaded from the application
 *
 * @todo This is just wrapping the old GLOBALS array. Need to plug in a proper i18n library.
 */
class OA_Translation
{
    /**
     * Boolean class property to control if the returned string should have HTML entities converted.
     *
     * @var boolean $htmlEntities
     */
    var $htmlEntities = false;

    /**
     * The output language to translate strings into
     *
     * @var string The language code for the selected language
     */
    var $locale = 'en_US';

    /**
     * This map maps the possible existing language selections to their new language codes
     * any unrecognised language selections default to english (sorry!)
     *
     * @var array The array mapping existing language -> new language code
     */
    var $languageMap = array(
            'chinese_big5'      => 'zh-t',
            'chinese_gb2312'    => 'zh-s',
            'czech'             => 'cs',
            'dutch'             => 'nl',
            'en'                => 'en_US',
            'french'            => 'fr',
            'german'            => 'de',
            'hebrew'            => 'he',
            'indonesian'        => 'id',
            'italian'           => 'it',
            'korean'            => 'ko',
            'pl'                => 'pl_PL',
            'portuguese'        => 'pt',
            'russian_cp1251'    => 'ru',
            'russian_koi8r'     => 'ru',
            'spanish'           => 'es',
            'turkish'           => 'tr',
            // Deprecated
            'english_affiliates'=> 'en',
            // Deprecated
            'english_us'        => 'en',
        );

    function OA_Translation()
    {
        if (isset($GLOBALS['_MAX']['PREF']['language'])) {
            // We are going to have to map the stored value
            // if it is not the full language_country code.
            $this->locale = $GLOBALS['_MAX']['PREF']['language'];
        }
        
        //$this->locale = 'fr_FR';
//        T_setlocale(LC_ALL, $this->locale);
//        T_bindtextdomain("openx", MAX_PATH . "/lib/OA/locale");
//        T_bind_textdomain_codeset("openx", "UTF-8");
//        T_textdomain("openx");
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
    function translate($sString, $aValues = array(), $pluralVar = false)
    {
        if (!empty($GLOBALS['str' . $sString])) { 
            $sReturn = $GLOBALS['str' . $sString];
        } 
        else {
            $sReturn = $sString;
        }

        // If substitution variables have been provided
        if (!empty($aValues)) {
            $eval = '$sSprintf = sprintf($sReturn, ';
            foreach ($aValues as $key => $value) {
                $aVals[] = '$aValues[\'' . $key . '\']';
            }
            $eval .= implode(',', $aVals);
            $eval .= ');';

            if (@eval($eval) !== false) {
                $sReturn = $sSprintf;
            }
        }

        $sReturn = ($this->htmlEntities) ? htmlentities($sReturn) : $sReturn;
        
        // For debugging
        //$sReturn = '<strike>' . $sReturn . '</strike>';
        return $sReturn;
    }
}

?>
