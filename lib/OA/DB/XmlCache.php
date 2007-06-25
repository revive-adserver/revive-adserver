<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once 'Cache/Lite.php';

/**
 * A class to read and save cached XML schema and changesets, useful to store
 * parsed XML files, such as MDB2_Schema table definitions, changesets, etc.
 *
 * It features a predictable cache file name and automatic (un)serialising
 * and zlib (de)compression
 *
 * @package    OpenadsDB
 * @subpackage XmlCache
 * @author     Matteo Beccati <matteo.beccati@openads.org
 */
class OA_DB_XmlCache
{
    /**
     * @var Cache_Lite
     */
    var $oCache;

    /**
     * @var string
     */
    var $cachePath;

    /**
     * Class constructor
     *
     * @return OA_DB_XmlCache
     */
    function OA_DB_XmlCache()
    {
        $this->cachePath = MAX_PATH . '/etc/xmlcache/';
        $this->oCache = new Cache_Lite(array(
            'cacheDir'               => $this->cachePath,
            'fileNameProtection'     => false,
            'lifeTime'               => null
        ));
    }

    /**
     * A method to get the XML cache content
     *
     * @param string $fileName The name of the original file we are retrieving
     * @return mixed The cache content or FALSE in case of cache miss
     */
    function get($fileName)
    {
        $id    = $this->_getId($fileName);
        $group = $this->_getGroup($fileName);

        if ($result = $this->oCache->get($id, $group, true)) {
            return unserialize(gzuncompress($result));
        }

        return false;
    }

    /**
     * A method to save the XML cache content. The content will be serialized and
     * compressed to save space
     *
     * @param mixed  $data     The content to save
     * @param string $fileName The name of the original file we are storing
     * @return bool True if the cache was correctly saved
     */
    function save($data, $fileName)
    {
        if (is_writable($this->cachePath)) {
            $id    = $this->_getId($fileName);
            $group = $this->_getGroup($fileName);
            return $this->oCache->save(gzcompress(serialize($data), 9), $id, $group);
        }

        return false;
    }

    /**
     * A method to remove a cache file
     *
     * @param string $fileName The name of the original file
     * @return bool True if the cache was deleted
     */
    function remove($fileName)
    {
        $id    = $this->_getId($fileName);
        $group = $this->_getGroup($fileName);
        return $this->oCache->remove($id, $group);
    }

    /**
     * Private method to generate the Cache_Lite cache ID from a file name
     *
     * @param string $fileName The name of the original file
     * @return string The cache ID (the base file name without extension)
     */
    function _getId($fileName)
    {
        $fileName = preg_replace('/\.[^.]+?$/', '', $fileName);
        return preg_replace('/[^a-z0-9]/i', '-', basename($fileName)).'.bin';
    }

    /**
     * Private method to generate the Cache_Lite cache group from a file name
     *
     * @param string $fileName The name of the original file
     * @return string The cache group (generated using the file path, or 'default')
     */
    function _getGroup($fileName)
    {
        if (strpos($fileName, MAX_PATH) === 0) {
            $groupName = dirname(substr($fileName, strlen(MAX_PATH) + 1));
            if (!empty($groupName)) {
                return preg_replace('/[^a-z0-9]/i', '-', $groupName);
            }
        }

        return 'default';
    }
}

?>
