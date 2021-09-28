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

/* @TODO REMOVE ME!

if (!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/remotehost.php'])) {
    // Required by PHP5.1.2
    require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';
}

// Initialize the client info to enable client targeting options
MAX_remotehostProxyLookup();
MAX_remotehostReverseLookup();
MAX_remotehostSetGeoInfo();

/**
 * @todo I believe the following is unnecessary with the "MAX_remotehostSetGeoInfo()" above
 * However the isAllowed() methods for the Geo-Plugins will have to be updated
 */
/*
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
*/

function MAX_AclAdjust($acl, $action)
{
    $count = count($acl ?? []);
    if (!empty($action['new']) && !empty($_REQUEST['type'])) {
        // Initialise this plugin to see if there is a default comparison
        list($package, $name) = explode(':', $_REQUEST['type']);
        $deliveryLimitationPlugin = OX_Component::factory('deliveryLimitations', ucfirst($package), ucfirst($name));
        $defaultComparison = $deliveryLimitationPlugin->defaultComparison;

        $acl[$count] = [
            'comparison' => $defaultComparison,
            'data' => '',
            'executionorder' => $count,
            'logical' => isset($acl[$count - 1]) ? $acl[$count - 1]['logical'] : '',
            'type' => $_REQUEST['type']
        ];
    }
    if (!empty($action['del'])) {
        $idx = key($action['del']);
        unset($acl[$idx]);
        for ($i = $idx + 1; $i < $count; $i++) {
            $acl[$i]['executionorder']--;
        }
    }
    if (!empty($action['down'])) {
        $idx = key($action['down']);
        $acl[$idx]['executionorder']++;
        $acl[$idx + 1]['executionorder']--;
    }

    if (!empty($action['up'])) {
        $idx = key($action['up']);
        $acl[$idx]['executionorder']--;
        $acl[$idx - 1]['executionorder']++;
    }

    if (!empty($action['clear']) && $action['clear'] == 'true') {
        $acl = [];
    }

    if (!empty($acl)) {
        // ReIndex the acl array
        $copy = [];
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
    global $session;

    $mysqlInUse = false;
    if ($GLOBALS['_MAX']['CONF']['database']['type'] == 'mysql' || $GLOBALS['_MAX']['CONF']['database']['type'] == 'mysqli') {
        $mysqlInUse = true;
    }

    $oDbh = OA_DB::singleton();

    if ($page === false) {
        $page = basename($_SERVER['SCRIPT_NAME']);
    }

    switch ($page) {
        case 'banner-acl.php':
            $table = 'banners';
            $aclsTable = 'acls';
            $fieldId = 'bannerid';
            break;

        case 'channel-acl.php':
            $table = 'channel';
            $aclsTable = 'acls_channel';
            $fieldId = 'channelid';
            break;

        default:
            return false;
    }

    $aclsObjectId = $aEntities[$fieldId];
    $sLimitation = OA_aclGetSLimitationFromAAcls($acls);

    $doTable = OA_Dal::factoryDO($table);
    $doTable->$fieldId = $aclsObjectId;
    $doTable->find(true);

    if ($sLimitation == $doTable->compiledlimitation) {
        return true; // No changes to the ACL
    }

    if ($mysqlInUse) {
        // Store the original ACLS table info, in case of data truncation
        $originalAcls = [];
        $doAcls = OA_Dal::factoryDO($aclsTable);
        $doAcls->whereAdd($fieldId . ' = ' . $aclsObjectId);
        $doAcls->find();
        while ($doAcls->fetch()) {
            $originalAcls[] = $doAcls->toArray();
        }
    }

    // Delete the current master delivery rule data from the DB
    if (MAX_AclDeleteValues($aclsTable, $fieldId, $aclsObjectId) === false) {
        $session['aclsDbError'] = true;
        return false;
    }
    // Add the new master delivery rule data to the DB
    if (MAX_AclAddValues($acls, $aclsTable, $fieldId, $aclsObjectId) === false) {
        $session['aclsDbError'] = true;
        return false;
    }
    // As per the comment in the MAX_AclAddValues() function, re-calculate
    // $sLimitation using the potentially processed $acls data
    $sLimitation = OA_aclGetSLimitationFromAAcls($acls);
    // Update the compiled delivery rule data in the DB
    if (MAX_UpdateCompiledRules($doTable, $acls, $sLimitation) === false) {
        $session['aclsDbError'] = true;
        return false;
    }

    if ($mysqlInUse) {
        // Check for truncation issues by comparing the original supplied
        // $acls value with what is now in the banners or channels table -
        // although truncation can happen in the acls or acls_channel table,
        // the compiled form is the longer, and truncation there will happen
        // first
        $aclsObjectId = $aEntities[$fieldId];
        $sLimitation = OA_aclGetSLimitationFromAAcls($acls);

        $doTable = OA_Dal::factoryDO($table);
        $doTable->$fieldId = $aclsObjectId;
        $found = $doTable->find(true);

        if ($sLimitation != $doTable->compiledlimitation) {
            // Delete the current master delivery rule data from the DB
            if (MAX_AclDeleteValues($aclsTable, $fieldId, $aclsObjectId) === false) {
                $session['aclsDbError'] = true;
                return false;
            }
            // Add the old, original master delivery rule data to the DB
            if (MAX_AclAddValues($originalAcls, $aclsTable, $fieldId, $aclsObjectId) === false) {
                $session['aclsDbError'] = true;
                return false;
            }
            // As per the comment in the MAX_AclAddValues() function, re-calculate
            // $sLimitation using the potentially processed $acls data
            $sLimitation = OA_aclGetSLimitationFromAAcls($originalAcls);
            // Update the compiled delivery rule data in the DB
            if (MAX_UpdateCompiledRules($doTable, $originalAcls, $sLimitation) === false) {
                $session['aclsDbError'] = true;
                return false;
            }
            // Set the data truncation flag so that a warning will show, and
            // return
            $session['aclsTruncation'] = true;
            return false;
        }
    }

    // When a channel limitation changes - All banners with this channel must be re-learnt
    if ($page == 'channel-acl.php') {
        $affected_ads = [];
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
        if (PEAR::isError($res)) {
            return $res;
        }
        while ($row = $res->fetchRow()) {
            $doBanners = OA_Dal::staticGetDO('banners', $row['bannerid']);
            if ($doBanners->bannerid == $row['bannerid']) {
                $doBanners->acls_updated = OA::getNowUTC();
                $doBanners->update();
            }
        }
    }
    return true;
}

function MAX_AclDeleteValues($aclsTable, $fieldId, $aclsObjectId)
{
    $doAcls = OA_Dal::factoryDO($aclsTable);
    $doAcls->whereAdd($fieldId . ' = ' . $aclsObjectId);
    return $doAcls->delete(true);
}

function MAX_AclAddValues($acls, $aclsTable, $fieldId, $aclsObjectId)
{
    if (!empty($acls)) {
        foreach ($acls as $index => $acl) {
            $deliveryLimitationPlugin = &OA_aclGetComponentFromRow($acl);

            $doAcls = OA_Dal::factoryDO($aclsTable);
            $doAcls->$fieldId = $aclsObjectId;
            $doAcls->logical = $acl['logical'];
            $doAcls->type = $acl['type'];
            $doAcls->comparison = $acl['comparison'];
            $doAcls->data = $deliveryLimitationPlugin->getData();
            $doAcls->executionorder = $acl['executionorder'];
            $id = $doAcls->insert();
            if (!$id) {
                return false;
            }
            // It's possible that ACLS data is processed by the delivery rule
            // plugin, which may result in the already caluclated $sLimitation
            // value from the raw ACLS data being incorrect post-processing.
            // So, update the original $acls array with the new, processed
            // data, before moving on to the next one, so that $sLimitation can
            // be re-calculated later
            $acls[$index]['data'] = $doAcls->data;
        }
    }
    return true;
}

function MAX_UpdateCompiledRules($doTable, $acls, $sLimitation)
{
    $doTable->acl_plugins = MAX_AclGetPlugins($acls);
    $doTable->compiledlimitation = $sLimitation;
    $doTable->acls_updated = OA::getNowUTC();
    return $doTable->update();
}

function MAX_AclGetCompiled($aAcls)
{
    if (empty($aAcls)) {
        return "true";
    } else {
        ksort($aAcls);
        $compiledAcls = [];
        foreach ($aAcls as $acl) {
            $deliveryLimitationPlugin = OA_aclGetComponentFromRow($acl);
            if ($deliveryLimitationPlugin) {
                $compiled = $deliveryLimitationPlugin->compile();
                if (!empty($compiledAcls)) {
                    $compiledAcls[] = $acl['logical'];
                }
                $compiledAcls[] = $compiled;
            }
            unset($deliveryLimitationPlugin);
        }
        return implode(' ', $compiledAcls);
    }
}

function MAX_AclGetPlugins($acls)
{
    if (empty($acls)) {
        return '';
    }
    $acl_plugins = [];
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
function MAX_AclValidate($page, $aParams)
{
    // Use prepared statements to improve performance when rebuilding in bulk
    static $statements = [];

    $var = 'channel-acl.php' === $page ? 'channelid' : 'bannerid';

    if (!isset($statements[$page])) {
        $oDbh = OA_DB::singleton();
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        switch ($page) {
            case 'banner-acl.php':
                $qTable = $oDbh->quoteIdentifier($prefix . 'banners', true);
                $qAclsTable = $oDbh->quoteIdentifier($prefix . 'acls', true);
                $qId = $oDbh->quoteIdentifier('bannerid', true);
                break;
            case 'channel-acl.php':
                $qTable = $oDbh->quoteIdentifier($prefix . 'channel', true);
                $qAclsTable = $oDbh->quoteIdentifier($prefix . 'acls_channel', true);
                $qId = $oDbh->quoteIdentifier('channelid', true);
                break;
        }

        $statements[$page] = [
            $oDbh->prepare("SELECT compiledlimitation, acl_plugins FROM {$qTable} WHERE {$qId} = :{$var}"),
            $oDbh->prepare("SELECT * FROM {$qAclsTable} WHERE {$qId} = :{$var} ORDER BY executionorder"),
        ];
    }

    // Keep only the parameter we need
    $aParams = [$var => $aParams[$var] ?? null];

    /** @var MDB2_Statement_Common $oStmt */
    /** @var MDB2_Statement_Common $oStmtAcl */
    list($oStmt, $oStmtAcl) = $statements[$page];

    /** @var MDB2_Result_Common $oResult */
    $oResult = $oStmt->execute($aParams);

    if (PEAR::isError($oResult)) {
        return false;
    }

    $aData = $oResult->fetchRow();

    $compiledLimitation = $aData['compiledlimitation'];
    $aclPlugins = $aData['acl_plugins'];

    $oResult = $oStmtAcl->execute($aParams);

    if (PEAR::isError($oResult)) {
        return false;
    }

    $aAcls = [];

    /** @var array $aData */
    while ($aData = $oResult->fetchRow()) {
        $deliveryLimitationPlugin = OA_aclGetComponentFromRow($aData);
        if ($deliveryLimitationPlugin) {
            $deliveryLimitationPlugin->init($aData);
            if ($deliveryLimitationPlugin->isAllowed($page)) {
                $aAcls[$aData['executionorder']] = $aData;
            }
        }
    }

    $newCompiledLimitation = MAX_AclGetCompiled($aAcls);
    $newAclPlugins = MAX_AclGetPlugins($aAcls);

    if (($newCompiledLimitation == $compiledLimitation) && ($newAclPlugins == $aclPlugins)) {
        return true;
    } elseif (($compiledLimitation === 'true' || $compiledLimitation === '') && ($newCompiledLimitation === 'true' && empty($newAclPlugins))) {
        return true;
    } else {
        return false;
    }
}

function MAX_AclCopy($page, $from, $to)
{
    $oDbh = OA_DB::singleton();
    $conf = &$GLOBALS['_MAX']['CONF'];
    $table = modifyTableName('acls');
    switch ($page) {
        case 'channel-acl.php':
            echo "Not implemented";
            break;
        default:
            // Delete old limitations
            $query = "
                DELETE FROM
                      {$table}
                WHERE
                    bannerid = " . $oDbh->quote($to, 'integer');
            $res = $oDbh->exec($query);
            if (PEAR::isError($res)) {
                return $res;
            }

            // Copy ACLs
            $query = "
                INSERT INTO {$table} (bannerid, logical, type, comparison, data, executionorder)
                    SELECT
                        " . $oDbh->quote($to, 'integer') . ", logical, type, comparison, data, executionorder
                    FROM
                        {$table}
                    WHERE
                        bannerid= " . $oDbh->quote($from, 'integer') . "
                    ORDER BY executionorder
            ";
            $res = $oDbh->exec($query);
            if (PEAR::isError($res)) {
                return $res;
            }

            // Copy compiledlimitation
            $doBannersFrom = OA_Dal::staticGetDO('banners', $from);
            $doBannersTo = OA_Dal::staticGetDO('banners', $to);
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
function OA_aclGetComponentFromRow($row)
{
    $oPlugin = OA_aclGetComponentFromType($row['type']);
    if (!$oPlugin) {
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
    $dbh = OA_DB::singleton();
    $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
    $qTable = $dbh->quoteIdentifier($prefix . $objectTable, true);
    $qAclsTable = $dbh->quoteIdentifier($prefix . $aclsTable, true);
    $qIdColumn = $dbh->quoteIdentifier($idColumn, true);
    $result = $dbh->exec("UPDATE {$qTable} SET compiledlimitation = '', acl_plugins = '' WHERE NOT EXISTS(SELECT 1 FROM $qAclsTable a WHERE a.{$qIdColumn} = {$qTable}.{$qIdColumn})");
    if (PEAR::isError($result)) {
        return $result;
    }

    $dalAcls = &OA_Dal::factoryDAL('acls');
    $rsAcls = $dalAcls->getRsAcls($aclsTable, $idColumn);
    if (PEAR::isError($rsAcls)) {
        return $rsAcls;
    }
    $result = $rsAcls->find();
    if (PEAR::isError($result)) {
        return $result;
    }

    // Init variable to store limitation types to be upgraded
    $aUpgradeByType = [];
    // Init array to store all banner ACLs
    $aAcls = [];

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
            $aEntities = [$idColumn => $row[$idColumn]];
            OA_aclRecompile($aAcls, $aEntities, $page);
            $aAcls = [];
        }
    } while ($result);

    return true;
}

function OA_aclRecompileBanners($upgrade = false)
{
    $conf = &$GLOBALS['_MAX']['CONF'];
    return OA_aclRecompileAclsForTable('acls', 'bannerid', 'banner-acl.php', $conf['table']['banners'], $upgrade);
}

function OA_aclRecompileChannels($upgrade = false)
{
    $conf = &$GLOBALS['_MAX']['CONF'];
    return OA_aclRecompileAclsForTable('acls_channel', 'channelid', 'channel-acl.php', $conf['table']['channel'], $upgrade);
}

/**
 * A function to rebuild compiled limitations.
 *
 * @param array $aAcls
 * @param array $aParams
 * @param string $page
 *
 * @return bool
 */
function OA_aclRecompile($aAcls, $aParams, $page)
{
    // Use prepared statements to improve performance when rebuilding in bulk
    static $statements = [];

    if (!isset($statements[$page])) {
        $oDbh = OA_DB::singleton();
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        switch ($page) {
            case 'banner-acl.php':
                $qTable = $oDbh->quoteIdentifier($prefix . 'banners', true);
                $qId = $oDbh->quoteIdentifier('bannerid', true);
                $var = "bannerid";
                break;
            case 'channel-acl.php':
                $qTable = $oDbh->quoteIdentifier($prefix . 'channel', true);
                $qId = $oDbh->quoteIdentifier('channelid', true);
                $var = "channelid";
                break;
        }

        $statements[$page] = $oDbh->prepare("UPDATE {$qTable} SET compiledlimitation = :compiledlimitation, acl_plugins = :acl_plugins WHERE {$qId} = :{$var}");
    }

    /** @var MDB2_Statement_Common $stmt */
    $stmt = $statements[$page];

    $aParams['compiledlimitation'] = MAX_AclGetCompiled($aAcls);
    $aParams['acl_plugins'] = MAX_AclGetPlugins($aAcls);

    return (bool)$stmt->execute($aParams);
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

    $result = OA_aclRecompileChannels($upgrade);
    if (PEAR::isError($result)) {
        return $result;
    }

    $result = OA_aclRecompileBanners($upgrade);
    if (PEAR::isError($result)) {
        return $result;
    }

    // Enable audit if needed
    $GLOBALS['_MAX']['CONF']['audit'] = $audit;

    return true;
}

function MAX_aclAStripslashed($aArray)
{
    foreach ($aArray as $key => $item) {
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
    return $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table'][$table], true);
}



/**
 * Do check on all ACL inputs values
 *
 * @param array $aAcls
 * @return boolean array of strings with errors messages if inputs aren't correct, true if is correct
 */
function OX_AclCheckInputsFields($aAcls, $page)
{
    $aErrors = [];
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
    if (count($aErrors) > 0) {
        return $aErrors;
    }
    return true;
}
