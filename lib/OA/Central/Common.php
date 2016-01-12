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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/lib/OA/Central.php';
require_once MAX_PATH . '/lib/OA/PermanentCache.php';

/**
 * OAP binding to the common OAC API
 *
 */
class OA_Central_Common
{

    /**
     * @var Cache_Lite
     */
    var $oCache;

    /**
     * Class constructor
     */
    function __construct()
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
}
