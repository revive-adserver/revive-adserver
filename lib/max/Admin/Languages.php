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
    /**
     * A method for returning an array of the available translations.
     *
     * @return array An array of strings representing the available translations.
     */
    function getAvailableLanguages()
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
