<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: Languages.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
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

    /**
     * A method for returning an array of the available translations.
     *
     * @static
     * @return array An array of strings representing the available translations.
     */
    function AvailableLanguages()
    {
        $languages = array();
        $langDirs = opendir(MAX_PATH . '/lib/max/language/');
        while ($langDir = readdir($langDirs)) {
            if (is_dir(MAX_PATH . '/lib/max/language/' . $langDir) &&
                    file_exists(MAX_PATH . '/lib/max/language/' . $langDir . '/index.lang.php')) {
                include_once MAX_PATH . '/lib/max/language/' . $langDir . '/index.lang.php' ;
                $languages[$langDir] = $translation_readable;
            }
        }
        closedir($langDirs);
        asort($languages, SORT_STRING);
        return $languages;
    }

}

?>
