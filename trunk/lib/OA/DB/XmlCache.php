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
$Id$
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
