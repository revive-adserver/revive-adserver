<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_128 extends Migration
{

    function Migration_128()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__banners__transparent';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__transparent';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__parameters';
		$this->aTaskList_constructive[] = 'afterAddField__banners__parameters';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__acls_updated';
		$this->aTaskList_constructive[] = 'afterAddField__banners__acls_updated';


		$this->aObjectMap['banners']['parameters'] = array('fromTable'=>'banners', 'fromField'=>'parameters');
		$this->aObjectMap['banners']['acls_updated'] = array('fromTable'=>'banners', 'fromField'=>'acls_updated');
    }



	function beforeAlterField__banners__transparent()
	{
		return $this->beforeAlterField('banners', 'transparent');
	}

	function afterAlterField__banners__transparent()
	{
		return $this->afterAlterField('banners', 'transparent');
	}

	function beforeAddField__banners__parameters()
	{
		return $this->beforeAddField('banners', 'parameters');
	}

	function afterAddField__banners__parameters()
	{
		return $this->afterAddField('banners', 'parameters');
	}

	function beforeAddField__banners__acls_updated()
	{
		return $this->beforeAddField('banners', 'acls_updated');
	}

	function afterAddField__banners__acls_updated()
	{
		return $this->afterAddField('banners', 'acls_updated') && $this->migrateData();
	}

	function migrateData()
	{
	    return $this->migrateSwfProperties() && $this->migrateAcls();
	}

	function migrateSwfProperties()
	{
	    $prefix = $this->getPrefix();
	    
	    $sql = "
	       UPDATE {$prefix}banners
	       SET transparent = 0
	       WHERE transparent = 2";
	    $result = $this->oDBH->exec($sql);
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse($result);
	    }
	    
	    $sql = "
	       SELECT
	           bannerid,
	           htmlcache
	       FROM
	           {$prefix}banners
	       WHERE
	           contenttype = 'swf'
	    ";
	    $aBanners = $this->oDBH->getAssoc($sql);
	    if (PEAR::isError($aBanners)) {
	        return $this->_logErrorAndReturnFalse($aBanners);
	    }
	    foreach ($aBanners as $bannerId => $code) {
	        $code = preg_replace('/^.*(<object.*<\/object>).*$/s', '$1', $code);
            preg_match_all('/alink(\d+).*?dest=(.*?)(?:&amp;atar\d+=(.*?))?(?:&amp;|\')/', $code, $m);
            
            if (count($m[0])) {
                $params = array();
                foreach ($m[1] as $k => $v) {
                    $params[$v] = array(
                        'link' => urldecode($m[2][$k]),
                        'tar'  => isset($m[3][$k]) ? urldecode($m[3][$k]) : ''
                    );
                }
                $params = serialize($params);
                $sql = "
        	       UPDATE {$prefix}banners
        	       SET parameters = '".$this->oDBH->escape($params)."'
        	       WHERE bannerid = '{$bannerId}'
                ";
        	    $result = $this->oDBH->exec($sql);
        	    if (PEAR::isError($result)) {
        	        return $this->_logErrorAndReturnFalse($result);
        	    }
            }
	    }
	    return true;
	}
	
	var $aAclsTypes = array(
        'weekday' => 'Time:Day',
        'time' => 'Time:Hour',
        'date' => 'Time:Date',
        'clientip' => 'Client:Ip',
        'domain' => 'Client:Domain',
        'language' => 'Client:Language',
        'continent' => 'Geo:Continent',
        'country' => 'Geo:Country',
        'browser' => 'Client:Useragent',
        'os' => 'Client:Useragent',
        'useragent' => 'Client:Useragent',
        'referer' => 'Site:Referingpage',
        'source' => 'Site:Source'
    );
    
    var $aPlugins = array();


	function migrateAcls()
	{
	    $tableAcls = $this->getPrefix() . "acls";
	    $sql = "SELECT * FROM $tableAcls";
	    $rsAcls = DBC::NewRecordSet($sql);
	    if (!$rsAcls->find()) {
	        return false;
	    }
	    $aUpdates = array();
	    while ($rsAcls->fetch()) {
	        $bannerid = $rsAcls->get('bannerid');
	        $executionorder = $rsAcls->get('executionorder');
	        $oldType = $rsAcls->get('type');
	        if (!isset($this->aAclsTypes[$oldType])) {
	            $this->_logError("Unknown acls type: $oldType");
	            return false;
	        }
	        $type = $this->aAclsTypes[$oldType];
	        $oldComparison = $rsAcls->get('comparison');
	        $oldData = $rsAcls->get('data');
	        
	        $oPlugin = &$this->_getDeliveryLimitationPlugin($type);
	        if (!$oPlugin) {
	            $this->_logError("Can't find code for delivery limitation plugin: $type.");
	            return false;
	        }
	        
	        $aNewAclsData = $oPlugin->getUpgradeFromEarly($oldComparison, $oldData);
	        
	        $comparison = $aNewAclsData['op'];
	        $data = $aNewAclsData['data'];
	        $aUpdates []= "UPDATE $tableAcls SET type = '$type', comparison = '$comparison', data = '$data'
	        WHERE bannerid = $bannerid
	        AND executionorder = $executionorder";
	    }
	    
	    foreach($aUpdates as $update) {
	        $result = $this->oDBH->exec($update);
	        if (PEAR::isError($result)) {
	            $this->_logError("Couldn't execute update: $update");
	            return false;
	        }
	    }
	    
        $result = MAX_AclReCompileAll(true);
        if (PEAR::isError($result)) {
            $this->_logErrorAndReturnFalse($result);
        }

	    return true;
	}

    /**
     * A private method to instantiate a delivery limitation plugin object.
     *
     * @param string $sType The delivery limitation plugin package and name,
     *                      separated with a colon ":". For example, "Geo:Country".
     * @return
     */
    function _getDeliveryLimitationPlugin($sType)
    {
        $oPlugin = null;
        if (isset($this->aPlugins[$sType])) {
            $oPlugin = $this->aPlugins[$sType];
        }
        if (is_null($oPlugin)) {
            $oPlugin = OA_aclGetPluginFromType($sType);
            $this->aPlugins[$sType] = $oPlugin;
        }
        return $oPlugin;
    }
}

?>