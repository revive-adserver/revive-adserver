<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/lib/max/other/lib-db.inc.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Acls.php';
if(!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/remotehost.php'])) {
    // Required by PHP5.1.2
    require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';
}

// Initialize the client info to enable client targeting options
MAX_remotehostProxyLookup();
MAX_remotehostReverseLookup();
MAX_remotehostSetClientInfo();
MAX_remotehostSetGeoInfo();

/**
 * @todo I believe the following is unnecessary with the "MAX_remotehostSetGeoInfo()" above
 * However the isAllowed() methods for the Geo-Plugins will have to be updated
 */

// Register the geotargeting information if necessary
if (!isset($GLOBALS['_MAX']['GEO_DATA'])) {
    $oGeoPlugin = MAX_Plugin::factoryPluginByModuleConfig('geotargeting');
    // Get geotargeting info
    if ($oGeoPlugin) {
    	// Set the geotargeting IP to the fixed test address
        // (IP Address used to determine which (if any) MaxMind databases are installed)
    	$GLOBALS['_MAX']['GEO_IP'] = '24.24.24.24';
    	// Get the geotargeting config
    	$geoTargetingType = $oGeoPlugin->name;
    	// Look up the Geotargeting data
        $GLOBALS['_MAX']['GEO_DATA'] = $oGeoPlugin->getInfo();
    }
}

function MAX_AclAdjust($acl, $action)
{
    $count = count($acl);
    if (!empty($action['new']) && !empty($_REQUEST['type'])) {
        // Initialise this plugin to see if there is a default comparison
        list($package, $name) = explode(':', $_REQUEST['type']);
        $deliveryLimitationPlugin = MAX_Plugin::factory('deliveryLimitations', ucfirst($package), ucfirst($name));
        $defaultComparison = $deliveryLimitationPlugin->defaultComparison;

        $acl[$count] = array(
            'comparison' => $defaultComparison,
            'data' => '',
            'executionorder' => $count,
            'logical' => isset($acl[$count - 1]) ? $acl[$count - 1]['logical']:'',
            'type' => $_REQUEST['type']
        );
    }
    if (!empty($action['del'])) {
        $idx = key($action['del']);
        unset($acl[$idx]);
        for ($i = $idx+1; $i<$count; $i++) {
            $acl[$i]['executionorder']--;
        }
    }
    if (!empty($action['down'])) {
        $idx = key($action['down']);
        $acl[$idx]['executionorder']++;
        $acl[$idx+1]['executionorder']--;
    }

    if (!empty($action['up'])) {
        $idx = key($action['up']);
        $acl[$idx]['executionorder']--;
        $acl[$idx-1]['executionorder']++;
    }

    if (!empty($action['clear']) && $action['clear'] == 'true') {
        $acl = array();
    }

    if (!empty($acl)) {
        // ReIndex the acl array
        $copy = array();
        foreach ($acl as $idx => $value) {
            $copy[$value['executionorder']] = $value;
        }
        ksort($copy);
        $acl = $copy;
    }
    return $acl;
}


/**
 * Converts the list of acls array descriptions of limitations to the
 * compiled versionof the limitations.
 *
 * @param array $acls
 * @return string
 */
function OA_aclGetSLimitationFromAAcls($acls)
{
    $sLimitation = MAX_AclGetCompiled($acls);
    // TODO: it should be done inside plugins instead, there is no need to slash the data
    $sLimitation = (!get_magic_quotes_runtime()) ? stripslashes($sLimitation) : $sLimitation;
    return $sLimitation;
}

function MAX_AclSave($acls, $aEntities, $page = false)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $oDbh =& OA_DB::singleton();
    if ($page === false) {
        $page = basename($_SERVER['PHP_SELF']);
    }

    if ('banner-acl.php' == $page) {
        $table = 'banners';
        $aclsTable = 'acls';
        $fieldId = 'bannerid';
    }
    else if ('channel-acl.php' == $page) {
        $table = 'channel';
        $aclsTable = 'acls_channel';
        $fieldId = 'channelid';
    }
    else {
        return false;
    }
    $aclsObjectId = $aEntities[$fieldId];

    $sLimitation = OA_aclGetSLimitationFromAAcls($acls);

    $rsAcls = OA_DB_Sql::selectWhereOne($table, $fieldId, $aclsObjectId, array('compiledlimitation'));
    $rsAcls->fetch();

    if ($sLimitation == $rsAcls->get('compiledlimitation')) {
        return true; // No changes to the ACL
    }

    OA_DB_Sql::deleteWhereOne($aclsTable, $fieldId, $aclsObjectId);

    if (!empty($acls)) {
        foreach ($acls as $acl) {
            $deliveryLimitationPlugin = &OA_aclGetPluginFromRow($acl);
            $sql = OA_DB_Sql::sqlForInsert($aclsTable, array(
                $fieldId => $aclsObjectId,
                'logical' => $acl['logical'],
                'type' => $acl['type'],
                'data' => $deliveryLimitationPlugin->getData(),
                'comparison' => $acl['comparison'],
                'executionorder' => $acl['executionorder']
            ));
            $result = $oDbh->exec($sql);
            if (PEAR::isError($result)) {
                return $result;
            }
        }
    }

    $result = OA_DB_Sql::updateWhereOne($table, $fieldId, $aclsObjectId, array(
        'acl_plugins' => MAX_AclGetPlugins($acls),
        'acls_updated' => ($now = OA::getNow()),
        'compiledlimitation' => $sLimitation
    ));
    if (PEAR::isError($result)) {
        return $result;
    }

    // When a channel limitation changes - All banners with this channel must be re-learnt
    if ($page == 'channel-acl.php') {
        $affected_ads = array();

        $query = "
            SELECT
                DISTINCT(bannerid)
            FROM
                {$conf['table']['prefix']}{$conf['table']['acls']}
            WHERE
                type = 'Site:Channel'
              AND (data = '{$aclsObjectId}' OR data LIKE '%,{$aclsObjectId}' OR data LIKE '%,{$aclsObjectId},%' OR data LIKE '{$aclsObjectId},%')
        ";
        $res = $oDbh->query($query);
        if (PEAR::isError($res)) {
            return $res;
        }
        while ($row = $res->fetchRow()) {
            $affected_ads[] = $row['bannerid'];
        }
        if (!empty($affected_ads)) {
            $query = "
                UPDATE
                    {$conf['table']['prefix']}{$conf['table']['banners']}
                SET
                    acls_updated = '{$now}'
                WHERE
                    bannerid IN (" . $oDbh->escape(implode(',', $affected_ads)) . ")
            ";
            $res = $oDb->exec($query);
            if (PEAR::isError($res)) {
                return $res;
            }
        }
    }
    return true;
}

function MAX_AclGetCompiled($aAcls) {
    if (empty($aAcls)) {
        return "true";
    } else {
        ksort($aAcls);
        foreach ($aAcls as $acl) {
            $deliveryLimitationPlugin = &OA_aclGetPluginFromRow($acl);
            $compiled = $deliveryLimitationPlugin->compile();
            if (!empty($compiledAcls)) {
                $compiledAcls[] = $acl['logical'];
            }
            $compiledAcls[] = $compiled;
        }
        return implode(' ', $compiledAcls);
    }
}

function MAX_AclGetPlugins($acls) {
    if (empty($acls)) {
        return '';
    }
    $acl_plugins = array();
    ksort($acls);
    foreach ($acls as $acl) {
        if (!in_array($acl['type'], $acl_plugins)) {
            $acl_plugins[] = $acl['type'];
        }
    }
    return implode(',', $acl_plugins);
}

/**
 * A function to test if the delivery limitations stored in the database
 * are valid - that is, have the values stored in the acls or acls_channel
 * tables been correctly compiled into the form required to be stored in
 * the banners or channels table?
 *
 * @param string $page Either "banner-acl.php" if testing a banner limitation,
 *                     or "channel-acl.php" if testing a channel limitation.
 * @param array  $aParams An array, containing either the "bannerid" if testing
 *                        a banner limitation, or the "channelid" if testing a
 *                        channel limitation.
 * @return boolean True if the limitations are correctly compiled, false otherwise.
 */
function MAX_AclValidate($page, $aParams) {
    $conf =& $GLOBALS['_MAX']['CONF'];
    $oDbh = &OA_DB::singleton();

    if (PEAR::isError($oDbh)) {
        return false;
    }

    switch($page) {
        case 'banner-acl.php':
            $doEntityTable = OA_Dal::factoryDO('banners');
            $doEntityTable->bannerid = $aParams['bannerid'];
            $doAclTable = OA_Dal::factoryDO('acls');
            $doAclTable->bannerid = $aParams['bannerid'];
        break;
        case 'channel-acl.php':
            $doEntityTable = OA_Dal::factoryDO('channel');
            $doEntityTable->channelid = $aParams['channelid'];
            $doAclTable = OA_Dal::factoryDO('acls_channel');
            $doAclTable->channelid = $aParams['channelid'];
        break;
    }

    $doEntityTable->find();
    $doEntityTable->fetch();
    $aData = $doEntityTable->toArray();
    $compiledLimitation = stripslashes($aData['compiledlimitation']);
    $acl_plugins        = $aData['acl_plugins'];

    $aAcls = array();
    $doAclTable->orderBy('executionorder');
    $doAclTable->find();
    while ($doAclTable->fetch()) {
        $aData = $doAclTable->toArray();
        list($package, $name) = explode(':', $aData['type']);
        $deliveryLimitationPlugin = MAX_Plugin::factory('deliveryLimitations', ucfirst($package), ucfirst($name));
        $deliveryLimitationPlugin->init($aData);
        if ($deliveryLimitationPlugin->isAllowed($page)) {
            $aAcls[$aData['executionorder']] = $aData;
        }
    }

    $newCompiledLimitation = stripslashes(MAX_AclGetCompiled($aAcls));
    $newAclPlugins         = MAX_AclGetPlugins($aAcls);

    if (($newCompiledLimitation == $compiledLimitation) && ($newAclPlugins == $acl_plugins)) {
        return true;
    } elseif (($compiledLimitation === 'true' || $compiledLimitation === '') && ($newCompiledLimitation === 'true' && empty($newAclPlugins))) {
        return true;
    } else {
        return false;
    }
}

function MAX_AclCopy($page, $from, $to) {
    $oDbh = &OA_DB::singleton();
    $conf =& $GLOBALS['_MAX']['CONF'];

    switch ($page) {
        case 'channel-acl.php' :
            echo "Not implemented";
            break;
        default:
            // Delete old limitations
            $query = "
                DELETE FROM
                      {$conf['table']['prefix']}{$conf['table']['acls']}
                WHERE
                    bannerid = ". $oDbh->quote($to, 'integer');
            $res = $oDbh->exec($query);
            if (PEAR::isError($res)) {
                return $res;
            }

            // Copy ACLs
            $query = "
                INSERT INTO {$conf['table']['prefix']}{$conf['table']['acls']}
                    SELECT
                        ". $oDbh->quote($to, 'integer') .", logical, type, comparison, data, executionorder
                    FROM
                        {$conf['table']['prefix']}{$conf['table']['acls']}
                    WHERE
                        bannerid= ". $oDbh->quote($from, 'integer') ."
                    ORDER BY executionorder
            ";
            $res = $oDbh->exec($query);
            if (PEAR::isError($res)) {
                return $res;
            }

            // Copy compiledlimitation
            $doBannersFrom = OA_Dal::staticGetDO('banners', $from);
            $doBannersTo = OA_DAL::staticGetDO('banners', $to);
            $doBannersTo->compiledlimitation = $doBannersFrom->compiledlimitation;
            $doBannersTo->acl_plugins = $doBannersFrom->acl_plugins;
            $doBannersTo->block = $doBannersFrom->block;
            $doBannersTo->capping = $doBannersFrom->capping;
            $doBannersTo->session_capping = $doBannersFrom->session_capping;
            return $doBannersTo->update();
    }
}


/**
 * Extracts the package and name of the plugin from its type, creates a plugin
 * object and returns the reference to it.
 *
 * @param string $type
 * @return Plugins_DeliveryLimitations
 */
function &OA_aclGetPluginFromType($type)
{
    list($package, $name) = explode(':', $type);
    return MAX_Plugin::factory('deliveryLimitations', ucfirst($package), ucfirst($name));
}

/**
 * Creates a delivery limitation plugin from the row which describes it in the
 * database and returns the reference to it.
 *
 * @param array $row
 */
function &OA_aclGetPluginFromRow($row)
{
    $plugin = &OA_aclGetPluginFromType($row['type']);
    $plugin->init($row);
    return $plugin;
}


/**
 * Recompiles all acls definitions for one of the type: banners or channel.
 *
 * @param string $aclsTable 'acls' or 'acls_channel'.
 * @param string $idColumn 'bannerid' or 'channelid'.
 * @param string $page 'banner-acl.php' or 'channel-acl.php'.
 * @param string $objectTable 'banners' or 'channel'
 * @return boolean True on success, PEAR::Error on failure.
 */
function OA_aclRecompileAclsForTable($aclsTable, $idColumn, $page, $objectTable, $upgrade = false)
{
    $dbh = &OA_DB::singleton();
    $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

    $result = $dbh->exec("UPDATE $prefix$objectTable SET compiledlimitation = 'true', acl_plugins = ''");
    if (PEAR::isError($result)) {
        return $result;
    }

    $dalAcls = &OA_Dal::factoryDAL('acls');
    $rsAcls = $dalAcls->getRsAcls($aclsTable);
    if (PEAR::isError($rsAcls)) {
        return $rsAcls;
    }
    $result = $rsAcls->find();
    if (PEAR::isError($result)) {
        return $result;
    }

    $aAcls = array();
    while ($rsAcls->fetch()) {
        $row = $rsAcls->toArray();
        $deliveryLimitationPlugin = &OA_aclGetPluginFromRow($row);
        if ($upgrade || $deliveryLimitationPlugin->isAllowed($page)) {
            $aAcls[$row[$idColumn]][$row['executionorder']] = $row;
        }
    }
    // OK so we've updated all the data values, now the hard part, we need to recompile limitations for all banners
    foreach ($aAcls as $id => $acl) {
        $aEntities = array($idColumn => $id);
        MAX_AclSave($acl, $aEntities, $page);
    }
    return true;
}

function OA_aclRecompileBanners($upgrade = false)
{
    $conf =& $GLOBALS['_MAX']['CONF'];

    return
        OA_aclRecompileAclsForTable('acls', 'bannerid', 'banner-acl.php', $conf['table']['banners'], $upgrade);
}

function OA_aclRecompileCampaigns($upgrade = false)
{
    $conf =& $GLOBALS['_MAX']['CONF'];

    return
        OA_aclRecompileAclsForTable('acls_channel', 'channelid', 'channel-acl.php', $conf['table']['channel'], $upgrade);
}

/**
 * This function iterates over all the ACLs in the system, and recompiles the compiledlimitation
 * string across all banners and channels
 *
 * @return boolean True on success, PEAR::Error on failure.
 */
function MAX_AclReCompileAll($upgrade = false)
{
    $result = OA_aclRecompileBanners($upgrade);
    if (PEAR::isError($result)) {
        return $result;
    }
    $result = OA_aclRecompileCampaigns($upgrade);
    if (PEAR::isError($result)) {
        return $result;
    }
    return true;
}

function MAX_aclAStripslashed($aArray)
{
    if (get_magic_quotes_runtime() == 1) {
        return $aArray;
    }

    foreach ($aArray AS $key => $item) {
        if (is_array($item)) {
            $aArray[$key] = MAX_aclAStripslashed($item);
        } else {
            $aArray[$key] = stripslashes($item);
        }
    }
    return $aArray;
}
?>
