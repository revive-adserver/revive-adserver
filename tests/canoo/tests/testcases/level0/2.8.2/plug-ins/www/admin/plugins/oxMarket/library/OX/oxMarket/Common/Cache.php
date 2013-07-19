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

require_once MAX_PATH . '/lib/OA/Cache.php';

/**
 * A extension to OA_Cache class that allows to define cache life time
 * and alternative cacheDir
 *
 */
class OX_oxMarket_Common_Cache extends OA_Cache
{

    /**
     * Class constructor
     *
     * @param string $id
     * @param string $group
     * @param int $lifeTime
     * @param string $cacheDir
     * @return OA_Cache
     */
    function __construct($id, $group, $lifeTime = null, $cacheDir = null)
    {
        if (!isset($cacheDir)) {
            $cacheDir = MAX_PATH . '/var/cache/';
        }
        $this->oCache = &new Cache_Lite(array(
            'cacheDir'                      => $cacheDir,
            'lifeTime'                      => $lifeTime,
            'readControlType'               => 'md5',
            'automaticSerialization'        => true
        ));

        $this->id    = $id;
        $this->group = $group;
    }

}

?>