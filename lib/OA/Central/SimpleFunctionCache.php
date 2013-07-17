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

require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Central/M2M.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/AdNetworks.php';

require_once MAX_PATH . '/lib/max/Admin_DA.php';

require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

require_once('Cache/Lite.php');

/**
 * OXP binding to the currency FX feed OXC API
 *
 */
class SimpleFunctionCache
{
	/**
     * @var Cache_Lite
     */
	private $oCache;
	private $permamentCache;
	public $cacheId;
    public $groupId;
    public $fullId; 
    public $object;
    public $method;
    
    public function SimpleFunctionCache(&$oCache, &$oPermamentCache, &$object, $method, $groupId, $cacheId)
    {
		$this->groupId = $groupId; 
		$this->cacheId = $cacheId;
		$this->fullId = $groupId . "::" . $cacheId;
		$this->oCache = &$oCache;
		$this->permamentCache = &$oPermamentCache;
		$this->object = &$object;
		$this->method = $method;
    }
	
    
    function getFromCache($checkValidity)
    {
    	return unserialize($this->oCache->get($this->cacheId, $this->groupId, !$checkValidity));
    }
    
    
    function getFromPermamentCache()
    {
    	$result = $this->getFromCache(false);
    	return $result ? $result : $this->permamentCache->get($this->fullId);
    }
    
    
    function getFromUserFunction()
    {
    	$result = $this->object->{$this->method}();
		if ($result) {
			$this->oCache->save(serialize($result), $this->cacheId, $this->groupId);
			return $result;
		}
    	return $this->getFromPermamentCache();
    }
    
    
    function get()
    {
    	return ($result = $this->getFromCache(true)) ? $result : $this->getFromUserFunction();
    }
	
    
    function removeCache()
    {
    	$this->oCache->remove($this->cacheId, $this->groupId);
    }
}
?>
