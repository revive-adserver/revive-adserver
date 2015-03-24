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
 * A class for determining the available translations.
 *
 * @package    MaxUI
 * @subpackage Language
 */
class MAX_Admin_Languages
{

    var $aLanguageMap = array(
        'chinese_gb2312'    => 'zh_CN',
        'chinese_big5'      => 'zh_CN',
        'czech'             => 'cs',
        'dutch'             => 'nl',
        'english'           => 'en',
        'english_affiliates'=> 'en',
        'english_us'        => 'en',
        'french'            => 'fr',
        'german'            => 'de',
        'hebrew'            => 'he',
        'indonesian'        => 'id',
        'italian'           => 'it',
        'korean'            => 'ko',
        'polish'            => 'pl',
        'portuguese'        => 'pt_BR',
        'russian_cp1251'    => 'ru',
        'russian_koi8r'     => 'ru',
        'spanish'           => 'es',
        'turkish'           => 'tr'
    );

    var $aDeprecated = array('english_affiliates', 'english_us');

    /**
     * A method for returning an array of the available translations.
     *
     * @return array An array of strings representing the available translations.
     */
    function AvailableLanguages()
    {
        $languages = array();

        foreach (glob(MAX_PATH.'/lib/max/language/*/index.lang.php') as $file) {
            unset($translation_readable);
            if (preg_match('#/(.*?)/index\.lang\.php#', $file, $m)) {
                include($file);
                if (isset($translation_readable)) {
                    $languages[$m[1]] = $translation_readable;
                }
            }
        }

        ksort($languages, SORT_STRING);

        return $languages;
    }

    /**
     * NOTE: This is a temporary wrapper method until the language folders are updated
     * This method maps the language code into it's appropriate string
     *
     * @param string $code The language code (e.g. "en" or "es")
     */
    function languageCodeToString($code)
    {
        // Check that we weren't passed a code
        if (in_array($code, array_keys($this->aLanguageMap))) {
            return $code;
        }

        $map = array_flip($this->aLanguageMap);
        $langString = (isset($map[$code])) ? $map[$code] : 'english';
        if (in_array($langString, $this->aDeprecated)) {
            return 'english';
        }
        return $langString;
    }

}

?>
