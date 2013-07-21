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

require_once MAX_PATH . '/lib/OA/PermanentCache.php';

/**
 * A class to read and save cached XML schema and changesets, useful to store
 * parsed XML files, such as MDB2_Schema table definitions, changesets, etc.
 *
 * It features a predictable cache file name and automatic (un)serialising
 * and zlib (de)compression
 *
 * @package    OpenXDB
 * @subpackage XmlCache
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_DB_XmlCache extends OA_PermanentCache
{
    /**
     * Class constructor
     *
     * @return OA_DB_XmlCache
     */
    function OA_DB_XmlCache()
    {
        parent::OA_PermanentCache(MAX_PATH . '/etc/xmlcache/');
    }
}

?>
