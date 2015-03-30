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
 * @package    RV_Admin
 * @subpackage Language
 */
class RV_Admin_Languages
{
    public static $aOldLanguagesMap = array(
        'chinese_gb2312' => 'zh_CN',
        'chinese_big5' => 'zh_CN',
        'czech' => 'cs',
        'dutch' => 'nl',
        'english' => 'en',
        'english_affiliates'=> 'en',
        'english_us' => 'en',
        'french' => 'fr',
        'german' => 'de',
        'hebrew' => 'he',
        'indonesian' => 'id',
        'italian' => 'it',
        'korean' => 'ko',
        'polish' => 'pl',
        'portuguese' => 'pt_BR',
        'russian_cp1251' => 'ru',
        'russian_koi8r' => 'ru',
        'spanish' => 'es',
        'turkish' => 'tr'
    );

    /**
     * A method for returning an array of the available translations.
     *
     * @return array An array of strings representing the available translations.
     */
    public static function getAvailableLanguages()
    {
        $languages = array();

        foreach (glob(MAX_PATH.'/lib/max/language/*/index.lang.php') as $file) {
            unset($translation_readable);
            if (preg_match('#/([^/]+)/index\.lang\.php#', $file, $m)) {
                include($file);
                if (isset($translation_readable)) {
                    $languages[$m[1]] = $translation_readable;
                }
            }
        }

        ksort($languages, SORT_STRING);

        return $languages;
    }
}
