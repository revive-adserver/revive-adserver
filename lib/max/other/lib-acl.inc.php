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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/lib-banner.inc.php';
require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Acls.php';
if(!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/remotehost.php'])) {
    // Required by PHP5.1.2
    require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';
}

// Initialize the client info to enable client targeting options
MAX_remotehostProxyLookup();
MAX_remotehostReverseLookup();
//MAX_remotehostSetClientInfo();  // moved to plugin
MAX_remotehostSetGeoInfo();

/**
 * @todo I believe the following is unnecessary with the "MAX_remotehostSetGeoInfo()" above
 * However the isAllowed() methods for the Geo-Plugins will have to be updated
 */

// Register the geotargeting information if necessary
if (!isset($GLOBALS['_MAX']['GEO_DATA']) && (!empty($conf['geotargeting']['type']) && $conf['geotargeting']['type'] != 'none')) {
    $oGeoComponent = OX_Component::factoryByComponentIdentifier($conf['geotargeting']['type']);
    // Get geotargeting info
    if ($oGeoComponent) {
    	// Set the geotargeting IP to the fixed test address
        // (IP Address used to determine which (if any) MaxMind databases are installed)
    	$GLOBALS['_MAX']['GEO_IP'] = '24.24.24.24';
    	// Get the geotargeting config
    	$geoTargetingType = $oGeoPlugin->name;
    	// Look up the Geotargeting data
        $GLOBALS['_MAX']['GEO_DATA'] = $oGeoComponent->getGeoInfo();
    }
}

function MAX_AclAdjust($acl, $action)
{
    $count = count($acl);
    if (!empty($action['new']) && !empty($_REQUEST['type'])) {
        // Initialise this plugin to see if there is a default comparison
        list($package, $name) = explode(':', $_REQUEST['type']);
        $deliveryLimitationPlugin = OX_Component::factory('deliveryLimitations', ucfirst($package), ucfirst($name));
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
    return MAX_AclGetCompiled($acls);
}

function MAX_AclSave($acls, $aEntities, $page = false)
{
    //$conf = $GLOBALS['_MAX']['CONF'];
    $oDbh =& OA_DB::singleton();

    if ($page === false) {
        $page = basename($_SERVER['SCRIPT_NAME']);
    }

    switch ($page) {
        case 'banner-acl.php' :
        case 'market-campaign-acl.php' : {
            $table      = 'banners';
            $aclsTable  = 'acls';
            $fieldId    = 'bannerid';

            break;
        }

        case 'channel-acl.php': {
            $table      = 'channel';
            $aclsTable  = 'acls_channel';
            $fieldId    = 'channelid';

            break;
        }

        default: {
            return false;
        }
    }


    $aclsObjectId = $aEntities[$fieldId];
    $sLimitation = OA_aclGetSLimitationFromAAcls($acls);

    $doTable = OA_Dal::factoryDO($table);
    $doTable->$fieldId = $aclsObjectId;
    $found = $doTable->find(true);

    if ($sLimitation == $doTable->compiledlimitation)
    {
        return true; // No changes to the ACL
    }

    $doAcls = OA_Dal::factoryDO($aclsTable);
    $doAcls->whereAdd($fieldId.' = '.$aclsObjectId);
    $doAcls->delete(true);

    if (!empty($acls))
    {
        foreach ($acls as $acl)
        {
            $deliveryLimitationPlugin =& OA_aclGetComponentFromRow($acl);

            $doAcls = OA_Dal::factoryDO($aclsTable);
            $doAcls->$fieldId   = $aclsObjectId;
            $doAcls->logical    = $acl['logical'];
            $doAcls->type       = $acl['type'];
            $doAcls->comparison = $acl['comparison'];
            $doAcls->data       = $deliveryLimitationPlugin->getData();
            $doAcls->executionorder = $acl['executionorder'];
            $id = $doAcls->insert();
            if (!$id)
            {
                return false;
            }
        }
    }
    $doTable->acl_plugins = MAX_AclGetPlugins($acls);
    $doTable->compiledlimitation = $sLimitation;
    $doTable->acls_updated = OA::getNowUTC();
    $doTable->update();

    // When a channel limitation changes - All banners with this channel must be re-learnt
    if ($page == 'channel-acl.php') {
        $affected_ads = array();
        $table = modifyTableName('acls');
        $query = "
            SELECT
                DISTINCT(bannerid)
            FROM
                {$table}
            WHERE
                type = 'deliveryLimitations:Site:Channel'
              AND (data = '{$aclsObjectId}' OR data LIKE '%,{$aclsObjectId}' OR data LIKE '%,{$aclsObjectId},%' OR data LIKE '{$aclsObjectId},%')
        ";
        $res = $oDbh->query($query);
        if (PEAR::isError($res))
        {
            return $res;
        }
        while ($row = $res->fetchRow())
        {
            $doBanners = OA_Dal::staticGetDO('banners', $row['bannerid']);
            if ($doBanners->bannerid == $row['bannerid'])
            {
                $doBanners->acls_updated = OA::getNowUTC();
                $doBanners->update();
            }
        }
    }
    return true;
}

function MAX_AclGetCompiled($aAcls)
{
    if (empty($aAcls))
    {
        return "true";
    }
    else
    {
        ksort($aAcls);
        $compiledAcls = array();
        foreach ($aAcls as $acl)
        {
            $deliveryLimitationPlugin =& OA_aclGetComponentFromRow($acl);
            if ($deliveryLimitationPlugin)
            {
                $compiled = $deliveryLimitationPlugin->compile();
                if (!empty($compiledAcls))
                {
                    $compiledAcls[] = $acl['logical'];
                }
                $compiledAcls[] = $compiled;
            }
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
    $oDbh =& OA_DB::singleton();

    if (PEAR::isError($oDbh)) {
        return false;
    }

    switch($page) {
        case 'banner-acl.php':
        case 'market-campaign-acl.php':
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
    $compiledLimitation = $aData['compiledlimitation'];
    $acl_plugins        = $aData['acl_plugins'];

    $aAcls = array();
    $doAclTable->orderBy('executionorder');
    $doAclTable->find();
    while ($doAclTable->fetch()) {
        $aData = $doAclTable->toArray();
        $deliveryLimitationPlugin = OA_aclGetComponentFromRow($aData);
        if ($deliveryLimitationPlugin) {
            $deliveryLimitationPlugin->init($aData);
            if ($deliveryLimitationPlugin->isAllowed($page)) {
                $aAcls[$aData['executionorder']] = $aData;
            }
        }
    }

    $newCompiledLimitation = MAX_AclGetCompiled($aAcls);
    $newAclPlugins         = MAX_AclGetPlugins($aAcls);

    if (($newCompiledLimitation == $compiledLimitation) && ($newAclPlugins == $acl_plugins)) {
        return true;
    }
    elseif (($compiledLimitation === 'true' || $compiledLimitation === '') && ($newCompiledLimitation === 'true' && empty($newAclPlugins))) {
        return true;
    }
    else {
        return false;
    }
}

function MAX_AclCopy($page, $from, $to) {
    $oDbh =& OA_DB::singleton();
    $conf =& $GLOBALS['_MAX']['CONF'];
    $table = modifyTableName('acls');
    switch ($page) {
        case 'channel-acl.php' :
            echo "Not implemented";
            break;
        default:
            // Delete old limitations
            $query = "
                DELETE FROM
                      {$table}
                WHERE
                    bannerid = ". $oDbh->quote($to, 'integer');
            $res = $oDbh->exec($query);
            if (PEAR::isError($res)) {
                return $res;
            }

            // Copy ACLs
            $query = "
                INSERT INTO {$table} (bannerid, logical, type, comparison, data, executionorder)
                    SELECT
                        ". $oDbh->quote($to, 'integer') .", logical, type, comparison, data, executionorder
                    FROM
                        {$table}
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
function &OA_aclGetComponentFromType($type)
{
    $aComponentIdentifier = OX_Component::parseComponentIdentifier($type);
    if (count($aComponentIdentifier) == 2) {
        array_unshift($aComponentIdentifier, 'deliveryLimitations');
    }
    list($extension, $group, $name) = $aComponentIdentifier;

    return OX_Component::factory($extension, $group, $name);
}

/**
 * Creates a delivery limitation plugin from the row which describes it in the
 * database and returns the reference to it.
 *
 * @param array $row
 */
function &OA_aclGetComponentFromRow($row)
{
    $oPlugin =& OA_aclGetComponentFromType($row['type']);
    if (!$oPlugin)
    {
        return false;
    }
    $oPlugin->init($row);
    return $oPlugin;
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
    $dbh =& OA_DB::singleton();
    $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
    $table = $dbh->quoteIdentifier($prefix.$objectTable, true);
    $result = $dbh->exec("UPDATE {$table} SET compiledlimitation = '', acl_plugins = ''");
    if (PEAR::isError($result)) {
        return $result;
    }

    $dalAcls =& OA_Dal::factoryDAL('acls');
    $rsAcls = $dalAcls->getRsAcls($aclsTable, $idColumn);
    if (PEAR::isError($rsAcls)) {
        return $rsAcls;
    }
    $result = $rsAcls->find();
    if (PEAR::isError($result)) {
        return $result;
    }

    // Init variable to store limitation types to be upgraded
    $aUpgradeByType = array();
    // Init array to store all banner ACLs
    $aAcls = array();

    // Fetch first row
    if (!$rsAcls->fetch()) {
        // No rows, exit
        return true;
    }

    do {
        $row = $rsAcls->toArray();
        if (!isset($aUpgradeByType[$row['type']])) {
            // Plugin not loaded yet
            $oPlugin = OA_aclGetComponentFromRow($row);
            if ($oPlugin) {
                // Upgrade requested or plugin allowed
                $aUpgradeByType[$row['type']] = $upgrade || $oPlugin->isAllowed($page);
                unset($oPlugin);
            } else {
                $aUpgradeByType[$row['type']] = false;
            }
        }
        if ($aUpgradeByType[$row['type']]) {
            $aAcls[$row['executionorder']] = $row;
        }
        // Fetch next record
        $result = $rsAcls->fetch();
        // Was this the last one? Is the next record linked to another entity?
        if (!$result || $row[$idColumn] != $rsAcls->get($idColumn)) {
            // Yes, we need to save!
            $aEntities = array($idColumn => $row[$idColumn]);
            MAX_AclSave($aAcls, $aEntities, $page);
            $aAcls = array();
        }
    } while ($result);

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
    // Disable audit
    $audit = $GLOBALS['_MAX']['CONF']['audit'];
    $GLOBALS['_MAX']['CONF']['audit'] = false;

    $result = OA_aclRecompileBanners($upgrade);
    if (PEAR::isError($result)) {
        return $result;
    }
    $result = OA_aclRecompileCampaigns($upgrade);
    if (PEAR::isError($result)) {
        return $result;
    }

    // Enable audit if needed
    $GLOBALS['_MAX']['CONF']['audit'] = $audit;

    return true;
}

function MAX_aclAStripslashed($aArray)
{
    foreach ($aArray AS $key => $item) {
        if (is_array($item)) {
            $aArray[$key] = MAX_aclAStripslashed($item);
        } else {
            $aArray[$key] = stripslashes($item);
        }
    }
    return $aArray;
}

function modifyTableName($table)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $oDbh = OA_DB::singleton();
    return $oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table'][$table], true);
}



/**
 * Do check on all ACL inputs values
 *
 * @param array $aAcls
 * @return boolean array of strings with errors messages if inputs aren't correct, true if is correct
 */
function OX_AclCheckInputsFields($aAcls, $page){
    $aErrors = array();
    foreach ($aAcls as $aclId => $acl) {
        if ($deliveryLimitationPlugin = OA_aclGetComponentFromRow($acl)) {
            $deliveryLimitationPlugin->init($acl);
            if ($deliveryLimitationPlugin->isAllowed($page)) {
                $checkResult = $deliveryLimitationPlugin->checkComparison($acl);
                if ($checkResult !== true) {
                    $aErrors[] = $checkResult;
                }
                $checkResult = $deliveryLimitationPlugin->checkInputData($acl);
                if ($checkResult !== true) {
                    $aErrors[] = $checkResult;
                }
            }
        }
    }
    if (count($aErrors)>0) {
        return $aErrors;
    }
    return true;
}

?>