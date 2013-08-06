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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/lib/OA/Central.php';
require_once MAX_PATH . '/lib/OA/PermanentCache.php';

require_once 'Cache/Lite/Function.php';
require_once('SimpleFunctionCache.php');

/**
 * OAP binding to the common OAC API
 *
 */
class OA_Central_Common
{
    /**
     * @var OA_Dal_Central_AdNetworks
     */
    var $oDal;

    /**
     * @var Cache_Lite
     */
    var $oCache;

    /**
     * Class constructor
     *
     * @return OA_Central_AdNetworks
     */
    function OA_Central_Common()
    {
        $this->oDal = new OA_Dal_Central_Common();
        $this->oCache = new Cache_Lite_Function(array(
            'cacheDir'                      => MAX_PATH . '/var/cache/',
            'lifeTime'                      => 86400,
            'defaultGroup'                  => get_class($this),
            'dontCacheWhenTheResultIsFalse' => true
        ));
    }

    /**
     * A method to retrieve the permanently cached result in case of failures
     *
     * @param string $cacheName The cache name
     * @return mixed The cached content
     */
    function retrievePermanentCache($cacheName)
    {
        $oCache = new OA_PermanentCache();
        return $oCache->get($cacheName);
    }


    public function createSimpleFunctionCache($object, $method,  $lifeTime, $groupId = null, $cacheId = null)
    {
        $cacheId = ($cacheId == null) ? $method : $cacheId;
        $groupId = ($groupId == null) ? get_class($this) : $groupId;
    	$oCache = new Cache_Lite(array(
            'cacheDir'                      => MAX_PATH . '/var/cache/',
            'lifeTime'                      => $lifeTime,
            'defaultGroup'                  => $groupId,
            'dontCacheWhenTheResultIsFalse' => true
        ));
        return new SimpleFunctionCache($oCache, new OA_PermanentCache(), $object, $method, $groupId, $cacheId);
    }
}

?>
