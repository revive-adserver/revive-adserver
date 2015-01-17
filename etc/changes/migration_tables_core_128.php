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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once(MAX_PATH.'/etc/changes/tools/DeliveryLimitationsMigration_128_324.php');

class Migration_128 extends Migration
{

    function __construct()
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
	    if ($this->oDBH->dbsyntax == 'pgsql') {
    	    $table = $this->oDBH->quoteIdentifier($this->getPrefix().'banners',true);

    	    $sql = "ALTER TABLE {$table} ALTER transparent DROP DEFAULT";
    	    $this->oDBH->exec($sql);
    	    $sql = "ALTER TABLE {$table} ALTER transparent TYPE SMALLINT USING (CASE WHEN transparent = 't' THEN 1 ELSE 0 END)";
    	    $this->oDBH->exec($sql);
    	    $sql = "ALTER TABLE {$table} ALTER transparent SET DEFAULT 0";
    	    $this->oDBH->exec($sql);
	    }
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
            if ($this->oDBH->dbsyntax == 'pgsql') {
                $this->oDBH->exec("SET bytea_output = 'escape'");
            }

	    return $this->migrateSwfProperties() && $this->migrateAcls() && $this->migrateGoogleAdSense();
	}

	function migrateSwfProperties()
	{
        $table = $this->oDBH->quoteIdentifier($this->getPrefix().'banners',true);

	    if ($this->oDBH->dbsyntax == 'mysql') {
    	    $sql = "
    	       UPDATE {$table}
    	       SET transparent = 0
    	       WHERE transparent = 2";
    	    $result = $this->oDBH->exec($sql);
    	    if (PEAR::isError($result)) {
    	        return $this->_logErrorAndReturnFalse('Error migrating SWF properties during migration 128: '.$result->getUserInfo());
    	    }
        }

	    $sql = "
	       SELECT
	           bannerid,
	           htmlcache
	       FROM
	           {$table}
	       WHERE
	           contenttype = 'swf'
	    ";
	    $aBanners = $this->oDBH->getAssoc($sql);
	    if (PEAR::isError($aBanners)) {
	        return $this->_logErrorAndReturnFalse('Error migrating SWF properties during migration 128: '.$aBanners->getUserInfo());
	    }
	    foreach ($aBanners as $bannerId => $code) {
	        $code = preg_replace('/^.*(<object.*<\/object>).*$/s', '$1', $code);
            preg_match_all('/alink(\d+).*?dest=(.*?)(?:&amp;atar\d+=(.*?))?(?:&amp;|\')/', $code, $m);

            if (count($m[0])) {
                $params = array('swf' => array());
                foreach ($m[1] as $k => $v) {
                    $params['swf'][$v] = array(
                        'link' => urldecode($m[2][$k]),
                        'tar'  => isset($m[3][$k]) ? urldecode($m[3][$k]) : ''
                    );
                }
                $params = serialize($params);
                $sql = "
        	       UPDATE {$table}
        	       SET parameters = '".$this->oDBH->escape($params)."'
        	       WHERE bannerid = '{$bannerId}'
                ";
        	    $result = $this->oDBH->exec($sql);
        	    if (PEAR::isError($result)) {
        	        return $this->_logErrorAndReturnFalse('Error migrating SWF properties during migration 128: '.$result->getUserInfo());
        	    }
            }
	    }
	    return true;
	}

	function migrateGoogleAdSense()
	{
        $table = $this->oDBH->quoteIdentifier($this->getPrefix().'banners',true);

	    $sql = "
	       SELECT
	           bannerid,
	           htmltemplate
	       FROM
	           {$table}
	       WHERE
	           storagetype = 'html' AND
	           autohtml = 't'
	    ";
	    $aBanners = $this->oDBH->getAssoc($sql);
	    if (PEAR::isError($aBanners)) {
	        return $this->_logErrorAndReturnFalse('Error migrating GoogleAdSense during migration 128: '.$aBanners->getUserInfo());
	    }

	    foreach ($aBanners as $bannerId => $code) {
            if (preg_match('/<script.*?src=".*?googlesyndication\.com/is', $code)) {
                $buffer = "<span>".
                          "<script type='text/javascript'><!--// <![CDATA[\n".
                          "/* openads={url_prefix} bannerid={bannerid} zoneid={zoneid} source={source} */\n".
                          "// ]]> --></script>".
                          $code.
                          "<script type='text/javascript' src='{url_prefix}/ag.php'></script>".
                          "</span>";
                $sql = "
        	       UPDATE {$table}
        	       SET adserver = 'google', htmlcache = '".$this->oDBH->escape($buffer)."'
        	       WHERE bannerid = '{$bannerId}'
                ";
        	    $result = $this->oDBH->exec($sql);
        	    if (PEAR::isError($result)) {
        	        return $this->_logErrorAndReturnFalse('Error migrating GoogleAdSense during migration 128: '.$result->getUserInfo());
        	    }
            }
	    }
	    return true;
	}

	var $aAclsTypes = array(
        'clientip'      => 'Client:Ip',
        'browser'       => 'Client:Useragent',
        'os'            => 'Client:Useragent',
        'useragent'     => 'Client:Useragent',
        'language'      => 'Client:Language',
        'continent'     => 'Geo:Continent',
        'country'       => 'Geo:Country',
        'fips_code'     => 'Geo:Region',
        'region'        => 'Geo:Region',
        'city'          => 'Geo:City',
        'postal_code'   => 'Geo:Postalcode',
        'dma_code'      => 'Geo:Dma',
        'area_code'     => 'Geo:Areacode',
        'org_isp'       => 'Geo:Organisation',
        'netspeed'      => 'Geo:Netspeed',
        'weekday'       => 'Time:Day',
        'domain'        => 'Client:Domain',
        'source'        => 'Site:Source',
        'time'          => 'Time:Hour',
        'date'          => 'Time:Date',
        'referer'       => 'Site:Referingpage',
        'url'           => 'Site:Pageurl'
    );

    var $aPlugins = array();


	function migrateAcls()
	{
	    $tableAcls = $this->oDBH->quoteIdentifier($this->getPrefix()."acls",true);
	    $sql = "SELECT * FROM $tableAcls ORDER BY bannerid, executionorder";
	    $rsAcls = DBC::NewRecordSet($sql);
	    if (!$rsAcls->find()) {
	        return false;
	    }
	    $aInserts = array();
	    $aOffsets = array();
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

	        $aOffsets[$bannerid] = $executionorder;

	        if (isset($aNewAclsData['add'])) {
	            if (!isset($aInserts[$bannerid])) {
	                $aInserts[$bannerid] = array();
	            }
	            $aInserts[$bannerid] = array_merge($aInserts[$bannerid], $aNewAclsData['add']);
	        }
	    }

	    foreach($aUpdates as $update) {
	        $result = $this->oDBH->exec($update);
	        if (PEAR::isError($result)) {
	            return $this->_logErrorAndReturnFalse("Couldn't execute update: $update");
	        }
	    }

	    foreach ($aInserts as $bannerid => $aLimitations) {
            $this->_log("WARNING! Found region geotargeting limitations that are NOT COMPATIBLE with new targeting format!");
            $this->_log("WARNING! Upgrade will proceed, but delivery limitations may NOT be preserved...");
	        foreach ($aLimitations as $aValues) {
    	        $aValues['bannerid'] = $bannerid;
    	        $aValues['executionorder'] = ++$aOffsets[$bannerid];
                $insert = OA_DB_Sql::sqlForInsert('acls', $aValues);
                $result = $this->oDBH->exec($insert);
                if (PEAR::isError($result)) {
                    return $this->_logErrorAndReturnFalse("Couldn't execute insert: $insert");
                }
                $this->_log("WARNING! Upgraded incompatible region geotargeting limitation. After upgrade, you should check limitations for Banner ID: $bannerid.");
	        }
	        $this->_log("WARNING! Upgrade of non-compatible region geotargeting limitations is complete.");
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
        if (isset($this->aPlugins[$sType])) {
            return $this->aPlugins[$sType];
        }

        list($package, $name) = explode(':', $sType);
        $className = 'Upgrade_DeliveryLimitations_' . ucfirst($package) . '_' . ucfirst($name);
        $this->aPlugins[$sType] = new $className();
        return $this->aPlugins[$sType];
    }
}

?>