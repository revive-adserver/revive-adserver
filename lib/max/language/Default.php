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
$Id$
*/

/**
 * @package    MaxUI
 * @subpackage Language
 * @author     Andrew Hill <andrew@m3.net>
 */

/**
 * A class that can be used to load the necessary language file(s) for
 * the user interface.
 *
 * @static
 */
class Language_Default
{
    /**
     * The method to load the default language file(s).
     */
    function load()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];
        // Always load the English language, in case of incomplete translations
        include_once MAX_PATH . '/lib/max/language/english/default.lang.php';
        // Load affiliate language file if user is a real affiliate and default is english
        if (phpAds_isUser(phpAds_Affiliate) && phpAds_isAllowed(MAX_AffiliateIsReallyAffiliate)) {
            if ($pref['language'] == 'english' || ($conf['max']['language'] == 'english' && empty($pref['language']))) {
                $pref['language'] = $GLOBALS['_MAX']['PREF']['language'] = 'english_affiliates';
            }
        }
        // Load the language from preferences, if possible, otherwise load
        // the global preference, if possible
        if (($pref['language'] != 'english')  && file_exists(MAX_PATH .
                '/lib/max/language/' . $pref['language'] . '/default.lang.php')) {
            include_once MAX_PATH . '/lib/max/language/' . $pref['language'] .
                '/default.lang.php';
        } elseif (($conf['max']['language'] != 'english') && file_exists(MAX_PATH .
                '/lib/max/language/' . $conf['max']['language'] . '/default.lang.php')) {
            include_once MAX_PATH . '/lib/max/language/' . $conf['max']['language'] .
                '/default.lang.php';
        }
    }
}

?>
