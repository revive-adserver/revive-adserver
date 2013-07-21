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
require_once MAX_PATH . '/lib/OA/Dal/Central/Common.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/M2M.php';
require_once MAX_PATH . '/lib/OA/Central.php';
require_once MAX_PATH . '/lib/OA/Central/RpcMapper.php';
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
     * @var OA_Central_RpcMapper
     */
    var $oMapper;

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
        $this->oMapper =& new OA_Central_RpcMapper($this);
        $this->oDal = new OA_Dal_Central_Common();
        $this->oCache = new Cache_Lite_Function(array(
            'cacheDir'                      => MAX_PATH . '/var/cache/',
            'lifeTime'                      => 86400,
            'defaultGroup'                  => get_class($this),
            'dontCacheWhenTheResultIsFalse' => true
        ));
    }

    /**
     * Refs R-AN-1: Connecting OpenX Platform with SSO
     *
     * @todo Need clarification
     *
     * @return boolean True on success
     */
    function connectOAPToOAC()
    {
        $result = $this->oMapper->connectOAPToOAC();

        if (PEAR::isError($result)) {
            return false;
        }

        return true;
    }

    /**
     * A method to retrieve the URL of the captcha image
     *
     * @see R-AN-20: Captcha Validation
     *
     * @return string
     */
    function getCaptchaUrl()
    {
        $platformHash = OA_Dal_ApplicationVariables::get('platform_hash');
        $url = OA_Central::buildUrl($GLOBALS['_MAX']['CONF']['oacXmlRpc'], 'captcha');
        $url .= '?ph='.urlencode($platformHash);

        return $url;
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
