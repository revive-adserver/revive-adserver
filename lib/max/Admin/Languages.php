<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * A class for determining the available translations.
 *
 * @package    MaxUI
 * @subpackage Language
 * @author     Andrew Hill <andrew@m3.net>
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
        $langDirs = opendir(MAX_PATH . '/lib/max/language/');
        while ($langDir = readdir($langDirs)) {
            if (is_dir(MAX_PATH . '/lib/max/language/' . $langDir) &&
                    !in_array($langDir, $this->aDeprecated) &&
                    file_exists(MAX_PATH . '/lib/max/language/' . $langDir . '/index.lang.php')) {
                $languages[$langDir] = $GLOBALS["str_" . $langDir];
            }
        }
        closedir($langDirs);
        asort($languages, SORT_STRING);
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
