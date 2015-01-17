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

require_once 'Cache/Lite.php';

/**
 * A generic class to easily use Cache Lite
 *
 */
class OA_Cache
{
    /**
     * @var Cache_Lite
     */
    var $oCache;

    /**
     * @var string
     */
    var $id;

    /**
     * @var string
     */
    var $group;

    /**
     * Class constructor
     *
     * @param string $id
     * @param string $group
     * @param int $lifeTime
     * @param string $cacheDir // can be used to read cache backups from different directory
     * @return OA_Cache
     */
    function __construct($id, $group, $lifeTime = null, $cacheDir = null)
    {
        if (!isset($cacheDir)) {
            $cacheDir = MAX_PATH . '/var/cache/';
        }

        $this->oCache = new Cache_Lite(array(
            'cacheDir'                      => $cacheDir,
            'lifeTime'                      => $lifeTime,
            'readControlType'               => 'md5',
            'automaticSerialization'        => true
            //'dontCacheWhenTheResultIsFalse' => true, - this property does not exist
        ));

        $this->id    = $id;
        $this->group = OX_getHostName() . ((!empty($group)) ? '_' . $group : '');
    }

    /**
     * A method to load the cache contents
     *
     * @return mixed
     */
    function load($doNotTestCacheValidity = true)
    {
        return $this->oCache->get($this->id, $this->group, $doNotTestCacheValidity);
    }

    /**
     * A method to save the cache contents
     *
     * @param mixed $cache
     * @return boolean
     */
    function save($cache)
    {
        return $this->oCache->save($cache, $this->id, $this->group);
    }

    function clear()
    {
        return $this->oCache->remove($this->id, $this->group);
    }

    function setFileNameProtection($value=true)
    {
        $this->oCache->_fileNameProtection = $value;
    }

}

?>