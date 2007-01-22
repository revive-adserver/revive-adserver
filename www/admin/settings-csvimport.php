<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';;
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics/AdServer/mysql.php';


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client + phpAds_Affiliate);

$errormessage = array();

//define errors and informations
define('MAX_ERROR_RECORD_LENGTH_TOO_BIG',       $GLOBALS['strRecordLengthTooBig']);
define('MAX_ERROR_RECORD_NON_INT',              $GLOBALS['strRecordNonInt']);
define('MAX_ERROR_RECORD_WAS_NOT_INSERTED',     $GLOBALS['strRecordWasNotInserted']);
define('MAX_ERROR_WRONG_COLUMN_PART1',          $GLOBALS['strWrongColumnPart1']);
define('MAX_ERROR_WRONG_COLUMN_PART2',          $GLOBALS['strWrongColumnPart2']);
define('MAX_ERROR_MISSING_COLUMN_PART1',        $GLOBALS['strMissingColumnPart1']);
define('MAX_ERROR_MISSING_COLUMN_PART2',        $GLOBALS['strMissingColumnPart2']);
define('MAX_ERROR_YOU_HAVE_NO_TRACKERS',        $GLOBALS['strYouHaveNoTrackers']);
define('MAX_ERROR_YOU_HAVE_NO_CAMPAIGNS',       $GLOBALS['strYouHaveNoCampaigns']);
define('MAX_ERROR_YOU_HAVE_NO_BANNERS',         $GLOBALS['strYouHaveNoBanners']);
define('MAX_ERROR_YOU_HAVE_NO_ZONES',           $GLOBALS['strYouHaveNoZones']);
define('MAX_ERROR_NO_BANNERS_DROPDOWN',         $GLOBALS['strNoBannersDropdown']);
define('MAX_ERROR_NO_ZONES_DROPDOWN',           $GLOBALS['strNoZonesDropdown']);
define('MAX_ERROR_INSERT_ERROR_PART1',          $GLOBALS['strInsertErrorPart1']);
define('MAX_ERROR_INSERT_ERROR_PART2',          $GLOBALS['strInsertErrorPart2']);
define('MAX_ERROR_DUPLICATED_VALUE',            $GLOBALS['strDuplicatedValue']);
define('MAX_INFO_INSERT_CORRECT',               $GLOBALS['strInsertCorrect']);
define('MAX_INFO_REUPLOAD_CSV_FILE',            $GLOBALS['strReuploadCsvFile']);
define('MAX_INFO_CONFIRM_UPLOAD',               $GLOBALS['strConfirmUpload']);
define('MAX_INFO_IMPRESSION',                   $GLOBALS['strView']);
define('MAX_INFO_CLICK',                        $GLOBALS['strClick']);
define('MAX_INFO_ARRIVAL',                      $GLOBALS['strArrival']);
define('MAX_INFO_MANUAL',                       $GLOBALS['strManual']);
define('MAX_INFO_CSV_TEMPLATE_SETTINGS',        $GLOBALS['strCSVTemplateSettings']);
define('MAX_INFO_COUNTRY',                      $GLOBALS['strIncludeCountryInfo']);
define('MAX_INFO_BROWSER',                      $GLOBALS['strIncludeBrowserInfo']);
define('MAX_INFO_OS',                           $GLOBALS['strIncludeOSInfo']);
define('MAX_INFO_SAMPLE_ROW',                   $GLOBALS['strIncludeSampleRow']);
define('MAX_INFO_CSV_TEMPLATE_ADVANCED',        $GLOBALS['strCSVTemplateAdvanced']);
define('MAX_INFO_CSV_TEMPLATE_INC_VARIABLES',   $GLOBALS['strCSVTemplateIncVariables']);
define('MAX_INFO_LOADED_RECORDS',               $GLOBALS['strLoadedRecords']);
define('MAX_INFO_BROKEN_RECORDS',               $GLOBALS['strBrokenRecords']);
define('MAX_ERROR_WRONG_DATE_FORMAT',           $GLOBALS['strWrongDateFormat']);

// setting default values for select fields if exist
if(isset($_POST['clients']) && $_POST['clients'] != '') {
    $GLOBALS['_MAX']['PREF']['clients'] =$_POST['clients'];
}
if(isset($_POST['campaigns']) && $_POST['campaigns'] != '') {
    $GLOBALS['_MAX']['PREF']['campaigns'] =$_POST['campaigns'];
}
if(isset($_POST['banners']) && $_POST['banners'] != '') {
    $GLOBALS['_MAX']['PREF']['banners'] =$_POST['banners'];
}
if(isset($_POST['zones']) && $_POST['zones'] != '') {
    $GLOBALS['_MAX']['PREF']['zones'] =$_POST['zones'];
}
if(isset($_POST['tracker']) && $_POST['tracker'] != '') {
    $GLOBALS['_MAX']['PREF']['tracker'] =$_POST['tracker'];
}
if(isset($_POST['connection_status']) && $_POST['connection_status'] != '') {
    $GLOBALS['_MAX']['PREF']['connection_status'] = $_POST['connection_status'];
}
if(isset($_POST['connection_action']) && $_POST['connection_action'] != '') {
    $GLOBALS['_MAX']['PREF']['connection_action'] = $_POST['connection_action'];
}

//creating conversion type list
$defaultConversionTypeList[MAX_CONNECTION_MANUAL] = MAX_INFO_MANUAL;
$defaultConversionTypeList[MAX_CONNECTION_AD_IMPRESSION] = MAX_INFO_IMPRESSION;
$defaultConversionTypeList[MAX_CONNECTION_AD_CLICK] = MAX_INFO_CLICK;
$defaultConversionTypeList[MAX_CONNECTION_AD_ARRIVAL] = MAX_INFO_ARRIVAL;

//creating conversion status list
$defaultConversionStatusList[MAX_CONNECTION_STATUS_APPROVED] = $GLOBALS[$GLOBALS['_MAX']['STATUSES'][MAX_CONNECTION_STATUS_APPROVED]];
$defaultConversionStatusList[MAX_CONNECTION_STATUS_IGNORE] = $GLOBALS[$GLOBALS['_MAX']['STATUSES'][MAX_CONNECTION_STATUS_IGNORE]];
$defaultConversionStatusList[MAX_CONNECTION_STATUS_PENDING] = $GLOBALS[$GLOBALS['_MAX']['STATUSES'][MAX_CONNECTION_STATUS_PENDING]];
$defaultConversionStatusList[MAX_CONNECTION_STATUS_ONHOLD] = $GLOBALS[$GLOBALS['_MAX']['STATUSES'][MAX_CONNECTION_STATUS_ONHOLD]];
$defaultConversionStatusList[MAX_CONNECTION_STATUS_DISAPPROVED] = $GLOBALS[$GLOBALS['_MAX']['STATUSES'][MAX_CONNECTION_STATUS_DISAPPROVED]];
$defaultConversionStatusList[MAX_CONNECTION_STATUS_DUPLICATE] = $GLOBALS[$GLOBALS['_MAX']['STATUSES'][MAX_CONNECTION_STATUS_DUPLICATE]];


/**
 * Function creates file stream to download
 * @param string $stream  data for file
 * @param string $filename
 * @param string $mimetype
 * @return boolean 
 */
function downloadStream($stream, $filename, $mimetype) {
    $status = 0;
    $size = strlen($stream);
    if ($size > 0) {
        if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
            ini_set( 'zlib.output_compression','Off' );
        }

        header ('Content-type: ' . $mimetype);
        header ('Content-Disposition: attachment; filename="' . $filename . '"');
        header ('Expires: '.gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y"))).' GMT');
        header ('Accept-Ranges: bytes');
        header ("Cache-control: private");                 
        header ('Pragma: private');

        if(isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=",$_SERVER['HTTP_RANGE']);
            //if yes, download missing part
            str_replace($range, "-", $range);
            $size2 = $size-1;
            $new_length = $size2-$range;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range$size2/$size");
        } else { 
            $size2=$size-1;
            header("Content-Range: bytes 0-$size2/$size");
            header("Content-Length: ".$size);
        }
  
        // Dump the content.
        echo $stream;
        $status = 1;
    }
    return($status);
}


/**
 * Function checks if value is of correct type
 * @param string $value  for testing
 * @param string $pattern
 * @return string 'ok' / error message 
 */
function validateCsvData($value, $pattern) {
    $recordType = explode("(", $pattern);
    $recordType = $recordType[0];

    switch($recordType) {
    case 'varchar';
        $recordType = 'string';
        break;
    case 'bigint';
        $recordType = 'numeric';
        break;
    case 'datetime';
        $recordType = 'datetime';
        break;
    case 'int';
        $recordType = 'numeric';
        break;
    case 'text';
        $recordType = 'string';
        break;
    case 'char';
        $recordType = 'string';
        break;
    default;
        $recordType = 'string';
        break;
    }
    if($recordType == 'string') {
        preg_match('/\((.*?)\)/', $pattern, $res);
        if($res[1] != '' && strlen($value) > $res[1]) {
            return MAX_ERROR_RECORD_LENGTH_TOO_BIG;
        }

        if(is_string($value)) {
            return 'ok';
        }
    }

    if($recordType == 'datetime')
    {
            return 'datetime';
    }

    if($recordType == 'numeric') {
        preg_match('/\((.*?)\)/', $pattern, $res);

        if($res[1] != '' && strlen($value) > $res[1]) {
            return MAX_ERROR_RECORD_LENGTH_TOO_BIG;
        }

        if(is_numeric(trim($value))) {
            return 'ok';
        } else {
            return MAX_ERROR_RECORD_NON_INT;            
        }
    }
    
    return 'ok';    
}


/**
 * check if value have duplicated entires
 * @param string $variableName name of field 
 * @param string $value compared value
 * @param array $out array to compare with
 * @return bool 
 */
function isDuplicated($trackerId, $variableName, $value, &$out) {
    //check if variable should be unique 
    if (!isset($GLOBALS['unique_variables'])) {
        $GLOBALS['unique_variables'] = array();
        $res_variables = phpAds_dbQuery('SELECT is_unique, name FROM variables WHERE trackerid='.$trackerId);
        while ($row = phpAds_dbFetchArray($res_variables)) {
            $GLOBALS['unique_variables'][$row['name']] = $row['is_unique'];
        }
    }
    
    if($GLOBALS['unique_variables'][$variableName] == 0) {
        return 0;
    }
    
    //check for duplicates in current result array
    foreach($out as $keyNum=>$record) {
        if($record['dynamic'][$variableName]['value'] == $value) {
            $duplicatedCount++;
        }
    }
    
    if($duplicatedCount > 1) {
        return 1;
    }
    return 0;
}

// Register input variables
phpAds_registerGlobal(
    'clients', 
    'campaigns',
    'banners',
    'zones',
    'tracker',
    'connection_status',
    'connection_action');

//Set default values if exists
if (isset($clients)) {
    $GLOBALS['clients_defVal'] = $clients;
}
if (isset($campaigns)) {
    $GLOBALS['campaigns_defVal'] = $campaigns;
}
if (isset($banners)) {
    $GLOBALS['banners_defVal'] = $banners;
}
if (isset($zones)) {
    $GLOBALS['zones_defVal'] = $zones;
}
if (isset($tracker)) {
    $GLOBALS['tracker_defVal'] = $tracker;
}

if (isset($connection_status)) {
    $GLOBALS['connection_status_defVal'] = $connection_status;
} else {
    $GLOBALS['connection_status_defVal'] = MAX_CONNECTION_STATUS_APPROVED;
}
if (isset($connection_action)) {
    $GLOBALS['connection_action_defVal'] = $connection_action;
} else {
    $GLOBALS['connection_action_defVal'] = MAX_CONNECTION_MANUAL;
}
    
$GLOBALS['include_sample_defVal'] = true;

// set required fields
$requiredFields['tracker_date_time'] = '0';
$requiredFields['ad_id'] = '0';
$requiredFields['zone_id'] = '0';

//fields to remove and default to empty
    $fieldsBlank = array(
        "viewer_session_id", 
        "creative_id", 
        "tracker_ip_address", 
        "connection_ip_address", 
        "tracker_language", 
        "connection_language", 
        "tracker_host_name", 
        "connection_host_name", 
        "tracker_https", 
        "connection_https", 
        "tracker_domain", 
        "connection_domain", 
        "tracker_page", 
        "connection_page", 
        "tracker_query", 
        "connection_query", 
        "tracker_referer", 
        "connection_referer", 
        "tracker_search_term", 
        "connection_search_term",
        "tracker_country",
        "tracker_os",
        "tracker_browser",
        "connection_user_agent",
        "tracker_user_agent",
        "server_raw_tracker_impression_id",
        "viewer_id");

if(isset($GLOBALS['tracker_defVal']) && $GLOBALS['tracker_defVal'] != '') {  
    //prepare csv template data 
    $query = "SHOW COLUMNS FROM data_intermediate_ad_connection";
    $res_columns = phpAds_dbQuery($query) or phpAds_sqlDie();
  
    while ($row_columns = phpAds_dbFetchArray($res_columns)) {
        $columns[$row_columns['Field']] = $row_columns['Type'];
    }        

    // remove inside_window field - this will be forced to 1
    if(isset($columns['inside_window'])) {
        unset($columns['inside_window']);
    }
    //remove autoincrement field
    if(isset($columns['data_intermediate_ad_connection_id'])) {
        unset($columns['data_intermediate_ad_connection_id']);
    }
    //remove connection_date_time field - defaults to tracker_date_time's value
    if(isset($columns['connection_date_time'])) {
        unset($columns['connection_date_time']);
    }
    //remove updated field - defaults to 'now'
    if(isset($columns['updated'])) {
        unset($columns['updated']);
    }
    //remove server_raw_ip field - defaults to 'offline'
    if(isset($columns['server_raw_ip'])) {
        unset($columns['server_raw_ip']);
    }
    //remove tracker_id field - defaults to $tracker
    if(isset($columns['tracker_id'])) {
        unset($columns['tracker_id']);
    }
    //remove connection_status field - defaults to $connection_status
    if(isset($columns['connection_status'])) {
        unset($columns['connection_status']);
    }
    //remove connection_action field - defaults to $connection_action
    if(isset($columns['connection_action'])) {
        unset($columns['connection_action']);
    }
   
    // use array to remove unwanted vars
    foreach ($fieldsBlank as $val) {    
        //remove said fields
        if(isset($columns[$val])) {
            unset($columns[$val]);
        }        
    }
   
    // if advanced template set, include all fields in CSV template
    if ($_POST['advanced_template']) {
        foreach ($columns as $col) {     
            $templateFieldNames[] = key($columns);
            next($columns);
        }
    } else { // else only include required fields
        foreach($requiredFields as $requiredField) {
            $templateFieldNames[] = key($requiredFields);
            next($requiredFields);
        }
    }
    
    //load additional fields
    $query = "SELECT name,datatype
              FROM variables 
              WHERE trackerid = " . $GLOBALS['tracker_defVal'];

    $res_columns = phpAds_dbQuery($query) or phpAds_sqlDie();

    while ($row_columns = phpAds_dbFetchArray($res_columns)) {
        if ($row_columns['datatype'] == ''){
            $row_columns['datatype'] = 'string';
        }
        $columns[$row_columns['name']]             = $row_columns['datatype'];    
        $columns_static[$row_columns['name']]     = $row_columns['datatype']; 
        
        // include variables in CSV template if specified
        if ($_POST['include_variables']) {
            $templateFieldNames[] = $row_columns['name'];
        }
    }
    
    // build output stream for CSV file
    foreach($templateFieldNames as $name) {
        $stream .= '"'. $name . '"' . ",";
    }
}

//save array into db
if (isset($_POST['submitCommit'])) {

    phpAds_registerGlobal('out');
    $insertArray = unserialize(base64_decode($GLOBALS['out']));
    
    $clearToTest = array('connection_country'=>true,
                         'connection_browser'=>true,
                         'connection_os'=>true
                        );
    
    // load list of all variables
    $query = "
        SELECT
            variableid,
            name,
            purpose
        FROM
            variables
        WHERE trackerid = $tracker
    ";
    $res_variables = phpAds_dbQuery($query);  
    
    while ($row_variables = phpAds_dbFetchArray($res_variables)) {
        $variablesArray[$row_variables['name']]     = array(
            'id' => $row_variables['variableid'],
            'basket_value' => $row_variables['purpose'] == 'basket_value',
            'num_items' => $row_variables['purpose'] == 'num_items'
        );
    }
    
    $updateArray = array();
    
    foreach($insertArray as $record) {
        $tmp_conversion = array(
            'day'            => date('Y-m-d', strtotime($record['static']['tracker_date_time']['value'])),
            'hour'            => date('H', strtotime($record['static']['tracker_date_time']['value'])),
            'ad_id'            => $record['static']['ad_id']['value'],
            'zone_id'        => $record['static']['zone_id']['value'],
            'basket_value'    => 0,
            'num_items'        => 0,
            'data_intermediate_ad_connection_id' => 0
        );
                
        foreach($record as $key=>$value) {
            unset($sql);
            unset($sqlNames);
            unset($sqlValues);       
            
            //static(field type) - insert into ad_connection, dynamic - ad_variable_value 
            if($key == 'static') {                            
                $sql = 'INSERT INTO data_intermediate_ad_connection ';

                foreach($value as $key1=>$value1) {
                    if (isset($clearToTest[$key1])) {
                        unset($clearToTest[$key1]);
                    }
                    if ($key1 == 'tracker_date_time') {
                        $connection_date_time = $value1['value'];
                    }
                    $sqlNames  .= $key1 . ', ';
                    $sqlValues .= '\'' . mysql_escape_string($value1['value']) . '\'' . ', ';
                }
                $sqlNames  .= 'updated, ';
                $sqlValues .= '\'' . date('Y-m-d H:i:s') . '\'' . ', ';
                $sqlNames  .= 'connection_date_time, ';
                $sqlValues .= '\'' . $connection_date_time . '\'' . ', ';
                $sqlNames  .= 'server_raw_ip, ';
                $sqlValues .= '\'' . 'offline' . '\'' . ', ';
                $sqlNames  .= 'tracker_id, ';
                $sqlValues .= '\'' . $GLOBALS['_MAX']['PREF']['tracker'] . '\'' . ', ';
                $sqlNames  .= 'connection_status, ';
                $sqlValues .= '\'' . $GLOBALS['_MAX']['PREF']['connection_status'] . '\'' . ', ';
                $sqlNames  .= 'connection_action, ';
                $sqlValues .= '\'' . $GLOBALS['_MAX']['PREF']['connection_action'] . '\'' . ', ';
                $sqlNames  .= 'inside_window, ';
                $sqlValues .= '\'1\', ';
                
                // set clear options
                foreach($fieldsBlank as $blankV) {
                    $sqlNames  .= $blankV.', ';
                    $sqlValues .= '\'' . '' . '\'' . ', ';                    
                }
                
                // test whether to clear user info options
                foreach($clearToTest as $clearK=>$clearV) {
                    $sqlNames  .= $clearK.', ';
                    $sqlValues .= '\'' . '' . '\'' . ', ';                    
                }
                 
                $sqlNames = substr(trim($sqlNames), 0, strlen($sqlNames) -2 );        
                $sqlValues = substr(trim($sqlValues), 0, strlen($sqlValues) -2 );        
                $sql .= '(' . $sqlNames .')' . ' VALUES ' . '(' . $sqlValues . ')';
                
                if(!phpAds_dbQuery($sql)) {
                    $uploadError[] = MAX_ERROR_RECORD_WAS_NOT_INSERTED . "<br />\n<small>Query: {$sql}\n" . mysql_error() . "</small>\n</br />";
                } 

                $tmp_conversion['data_intermediate_ad_connection_id'] = phpAds_dbInsertID();
            }
            else if($key == 'dynamic') {                            
                foreach($value as $key1=>$value1) {
                    if ($variablesArray[$key1]['basket_value']) {
                        $tmp_conversion['basket_value'] += $value1['value'];
                    } elseif ($variablesArray[$key1]['num_items']) {
                        $tmp_conversion['num_items'] += $value1['value'];
                    }
                    $sql  = 'INSERT INTO data_intermediate_ad_variable_value ';
                    $sql .= '(data_intermediate_ad_connection_id, tracker_variable_id, value) VALUES ';
                    $sql .= '(\'' . $tmp_conversion['data_intermediate_ad_connection_id'] . '\', '; 
                    $sql .= '\'' . $variablesArray[$key1]['id'] . '\', ';
                    $sql .= '\'' . mysql_escape_string($value1['value']) . '\') ';
                    if(!phpAds_dbQuery($sql)) {
                        $uploadError[] = MAX_ERROR_RECORD_WAS_NOT_INSERTED . "<br />\n<small>Query: {$sql}\n" . mysql_error() . "</small>\n</br />";
                    } 
                }               
            }
        }
    
        $t = $tmp_conversion;
        if (!isset($updateArray[$t['day']][$t['hour']][$t['ad_id']][$t['zone_id']])) {
            $updateArray[$t['day']][$t['hour']][$t['ad_id']][$t['zone_id']] = array(
                'conversions' => 0,
                'basket_value' => 0,
                'num_items' => 0
            );
        }
        
        $updateArray[$t['day']][$t['hour']][$t['ad_id']][$t['zone_id']]['conversions']++;
        $updateArray[$t['day']][$t['hour']][$t['ad_id']][$t['zone_id']]['basket_value'] += $tmp_conversion['basket_value'];
        $updateArray[$t['day']][$t['hour']][$t['ad_id']][$t['zone_id']]['num_items'] += $tmp_conversion['num_items'];
    }

    // Get DAL instances
    $oServiceLocator = &ServiceLocator::instance();
    $oDal = &$oServiceLocator->get('MAX_Dal_Maintenance_Statistics_AdServer_mysql');
    if (!$oDal) {
        $oDal = & new MAX_Dal_Maintenance_Statistics_AdServer_mysql;
    }

    // Correctly deal with the arrivals plugin
    if ($GLOBALS['_MAX']['PREF']['connection_action'] == MAX_CONNECTION_AD_ARRIVAL) {
        $data_intermediate_table = 'data_intermediate_ad_arrival';
        $data_summary_table = 'data_summary_ad_arrival_hourly';

        // Run serviceLocator register functions
        $plugins = &MAX_Plugin::getPlugins('Maintenance');
        foreach($plugins as $plugin) {
            if ($plugin->getHook() == MSE_PLUGIN_HOOK_AdServer_saveSummary) {
                $plugin->serviceLocatorRegister();

                // Make sure it is the arrival plugin
                if ($oServiceLocator->get('financeSummaryTable') == $data_summary_table) {
                    break;
                } else {
                    $plugin->serviceLocatorRemove();
                }
            }
        }

    } else {
        $plugin = null;
        $data_intermediate_table = 'data_intermediate_ad';
        $data_summary_table = 'data_summary_ad_hourly';
    }
    
    $aAdIds = array();
    $aZoneIds = array();

    $optInt = MAX_OperationInterval::getOperationInterval();

    ksort($updateArray);
    foreach ($updateArray as $day => $aHours) {
        foreach ($aHours as $hour => $aAds) {
            $oConnectionDate = new Date("{$day} {$hour}:00:00");
            $optIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oConnectionDate);
            $optIntDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oConnectionDate);    
                
            foreach ($aAds as $ad_id => $aZones) {
                // Save distinct ad_id
                $aAdIds[$ad_id] = true;
                
                foreach ($aZones as $zone_id => $aValue) {
                    // Save distinct zone_id
                    $aZoneIds[$zone_id] = true;
                    
                    // Update intermediate table
                    $res = phpAds_dbQuery("
                        UPDATE
                            {$data_intermediate_table}
                        SET
                            conversions = conversions + {$aValue['conversions']},
                            total_basket_value = total_basket_value + {$aValue['basket_value']},
                            total_num_items = total_num_items + {$aValue['num_items']},
                            updated = '".(date('Y:m:d H:i:s'))."'
                        WHERE
                            day = '{$day}' AND
                            ad_id = {$ad_id} AND
                            zone_id = {$zone_id} AND
                            creative_id = 0 AND
                            operation_interval_id = {$optIntID}
                        ") or phpAds_sqlDie();
                    
                    if (!phpAds_dbAffectedRows($res)) {
                        $res = phpAds_dbQuery("
                            INSERT INTO {$data_intermediate_table} (
                                day,
                                hour,
                                ad_id,
                                zone_id,
                                creative_id,
                                conversions,
                                total_basket_value,
                                total_num_items,
                                operation_interval,
                                operation_interval_id,
                                interval_start,
                                interval_end,
                                updated
                            ) VALUES (
                                '{$day}',
                                {$hour},
                                {$ad_id},
                                {$zone_id},
                                0,
                                {$aValue['conversions']},
                                {$aValue['basket_value']},
                                {$aValue['num_items']},
                                {$optInt},
                                {$optIntID},
                                '".$optIntDates['start']->format('%Y-%m-%d %H:%M:%S')."',
                                '".$optIntDates['end']->format('%Y-%m-%d %H:%M:%S')."',
                                '".(date('Y:m:d H:i:s'))."'
                            )
                            ") or phpAds_sqlDie();
                    }
                    
                    // Update summary table
                    $res = phpAds_dbQuery("
                        UPDATE
                            {$data_summary_table}
                        SET
                            conversions = conversions + {$aValue['conversions']},
                            total_basket_value = total_basket_value + {$aValue['basket_value']},
                            total_num_items = total_num_items + {$aValue['num_items']},
                            updated = '".(date('Y:m:d H:i:s'))."'
                        WHERE
                            day = '{$day}' AND
                            hour = {$hour} AND
                            ad_id = {$ad_id} AND
                            zone_id = {$zone_id} AND
                            creative_id = 0
                        ") or phpAds_sqlDie();
                    
                    if (!phpAds_dbAffectedRows($res)) {
                        $res = phpAds_dbQuery("
                            INSERT INTO {$data_summary_table} (
                                day,
                                hour,
                                ad_id,
                                zone_id,
                                creative_id,
                                conversions,
                                total_basket_value,
                                total_num_items,
                                updated
                            ) VALUES (
                                '{$day}',
                                {$hour},
                                {$ad_id},
                                {$zone_id},
                                0,
                                {$aValue['conversions']},
                                {$aValue['basket_value']},
                                {$aValue['num_items']},
                                '".(date('Y:m:d H:i:s'))."'
                            )
                            ") or phpAds_sqlDie();
                    }
                }
            }
        }
    }
    
    // Update finance info
    $aDates = array_keys($updateArray);
    
    if (count($aDates)) {
        $oStartDate = new Date(reset($aDates).' 00:00:00');
        $oEndDate = new Date(end($aDates).' 23:59:59');

        $aAdIds = array_keys($aAdIds);
        $aZoneIds = array_keys($aZoneIds);
    
        // Get the finance information for the ads found
        $aAdFinanceInfo = $oDal->_getAdFinanceInfo($aAdIds);
        // Update the recently summarised data with basic financial information
        if ($aAdFinanceInfo !== false) {
            $oDal->_updateAdsWithFinanceInfo($aAdFinanceInfo, $oStartDate, $oEndDate, $data_summary_table);
        }

        // Get the finance information for the zones found
        $aZoneFinanceInfo = $oDal->_getZoneFinanceInfo($aZoneIds);
        // Update the recently summarised data with basic financial information
        if ($aZoneFinanceInfo !== false) {
            $oDal->_updateZonesWithFinanceInfo($aZoneFinanceInfo, $oStartDate, $oEndDate, $data_summary_table);
        }
    }

    if (!is_null($plugin)) {
        $plugin->serviceLocatorRemove();
    }
    
    $flagUploaded = 1; 
}


//creating CSV template
if(isset($_POST['submitDisabled']) || isset($_POST['submitCreateTemplate'])) {

    if(isset($_POST['submitCreateTemplate'])) {
        $clientName = phpAds_getClientDetails($_POST['clients']);
        $clientName = str_replace(' ', '_', $clientName['clientname']);
        $campaignName = phpAds_getCampaignDetails($_POST['campaigns']);
        $campaignName = str_replace(' ', '_', $campaignName['campaignname']);
        $trackerName = phpAds_getTrackerDetails($_POST['tracker']);
        $trackerName = str_replace(' ', '_', $trackerName['trackername']);
        
        $csvFileName = $clientName . "__" . $trackerName . "__" . $campaignName . "__template";
        if(strlen($csvFileName) > 30) {
            $csvFileName = substr($csvFileName, 0, 30);
        }
        $csvFileName .= ".csv";
        
        // add appropriate sample values if required
        if($_POST['include_sample'] == true) {
            $stream .= "\n"; // new line
            foreach ($columns as $col => $datatype) {
                // tracker column values
                if (in_array($col, $templateFieldNames)) { // if field included in template
                    switch ($col) {
                    case 'tracker_date_time' :
                        $stream .= '"2006-10-16 11:43:00",';
                        break;
                    case 'ad_id' :
                        $stream .= $_POST['banners'].',';
                        break;
                    case 'zone_id' :
                        $stream .= $_POST['zones'].',';
                        break;                    
                    case 'tracker_channel' :
                        $stream .= '"buy tickets",';
                        break;
                    case 'connection_channel' :
                        $stream .= '"baltic cruise",';
                        break;
                    case 'connection_country' :
                        $stream .= '"GB",';
                        break;
                    case 'connection_os' :
                        $stream .= '"xp",';
                        break;
                    case 'connection_browser' :
                        $stream .= '"firefox",';
                        break;
                    case 'connection_action' :
                        $stream .= '1,';
                        break;
                    case 'connection_window' :
                        $stream .= '2592000,';
                        break;
                    case 'connection_status' :
                        $stream .= '4,';
                        break;
                    case 'comments' :
                        $stream .= '"Blah blah",';
                        break;
                    // tracker variable values (set sample value according to data type)
                    default :
                        switch ($datatype) {
                        case 'numeric' :
                            $stream .= '123,';
                            break;
                        case 'string' :
                            $stream .= '"Nokia N90",';
                            break;
                        case 'date' :
                            $stream .= '"2006-10-16",';
                            break;
                        default :
                            break;
                        }
                    }
                }
            }
        }
        
        downloadStream($stream,$csvFileName,'text/csv');
        die();
    }

    if(isset($_FILES['uploadedfile']) && !empty($_POST['start_upload'])) {
        $fp = fopen($_FILES['uploadedfile']['tmp_name'], "r");
        if($fp) {
            while( $temp = fgetcsv($fp, 10000, ',', '"') ) {
                  $line[] = $temp;
            }

            //splitting on static and user added fields
            foreach($line[0] as $key=>$value)
            {  
                if(trim($columns_static[$value]) == '') {
                    $status[$key]['status'] ='static';
                    $status[$key]['name']   = $value;
                } else { 
                    $status[$key]['status'] = 'dynamic'; 
                    $status[$key]['name']   = $value;
                } 
            }
            
            //check for required fields
            foreach($status as $record)
                if($requiredFields[$record['name']] == '0')
                    $requiredFields[$record['name']] = 1;
            foreach($requiredFields as $key=>$value)
                if($value == '0') {
                  $uploadError[] = MAX_ERROR_MISSING_COLUMN_PART1 . 
                                   $key . MAX_ERROR_MISSING_COLUMN_PART2;
                }

            //check if loaded fields are allowed for selected tracker
            foreach($status as $record) {
                // exceptions to the rule: Country / OS / Browser
                $columnException = array (
                "connection_country" => 1,
                "connection_os" => 1,
                "connection_browser" => 1
                );
                if($columns[$record['name']] == '' && trim($record['name']) != '' && empty($columnException[$record['name']])) {
                    $uploadError[] = MAX_ERROR_WRONG_COLUMN_PART1 . 
                                     $record['name'] . MAX_ERROR_WRONG_COLUMN_PART2;
                }
            }

            //preparing records for display and split CVS data to static and user added fields
            unset($line[0]);
            $i=0;            
            foreach($line as $recK=>$record) {
                foreach($record as $key=>$value)
                { 
                    $value = trim($value);

                    //special rules for chosen fields 
                    if($status[$key]['name'] == 'updated')
                        $value = date('d/m/Y H:i'); 

                    if($status[$key]['name'] == 'server_raw_ip')
                        $value = 'offline';
                    
                    if($status[$key]['status']=='static' && trim($status[$key]['name']) != '') {
                        $out[$i]['static'][$status[$key]['name']]['value'] = $value;
                        $out[$i]['static'][$status[$key]['name']]['validate'] = validateCsvData($value,$columns[$status[$key]['name']]); 
                        if($out[$i]['static'][$status[$key]['name']]['validate'] != 'ok') {

                            //if field type datetime not valid try to reformat date
                            if($out[$i]['static'][$status[$key]['name']]['validate'] == 'datetime') {
                                  if($tmpVal = date( "Y-m-d H:i:s", strtotime($value))) {
                                      $out[$i]['static'][$status[$key]['name']]['value'] = $tmpVal;
                                      $out[$i]['static'][$status[$key]['name']]['validate'] = 'ok';
                                  }
                                  else {
                                      $out[$i]['static'][$status[$key]['name']]['validate'] = MAX_ERROR_WRONG_DATE_FORMAT;
                                      $brokenRecordsCount[] = 1;
                                  }
                               
                            } else {
                                $brokenRecordsCount[] = 1;
                            } 
                        }
                    }
                    else if($status[$key]['status']=='dynamic' && trim($status[$key]['name']) != '') {  
                        $out[$i]['dynamic'][$status[$key]['name']]['value'] = $value;
                        if(isDuplicated($tracker, $status[$key]['name'], $value, &$out) == 0) {
                            $out[$i]['dynamic'][$status[$key]['name']]['validate'] = validateCsvData($value,$columns[$status[$key]['name']]); 
                        } else {
                            $out[$i]['dynamic'][$status[$key]['name']]['validate'] = MAX_ERROR_DUPLICATED_VALUE; 
                        }
                        if($out[$i]['dynamic'][$status[$key]['name']]['validate'] != 'ok') {
                            $brokenRecordsCount[] = 1; 
                        }
                    }
                }
                $i++;                        
            } //foreach end
        } //if($fp) end
    } 
}


phpAds_PrepareHelp();
if (phpAds_isUser(phpAds_Admin)) {
    phpAds_PageHeader("5.1");
    phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
} elseif (phpAds_isUser(phpAds_Agency)) {
    phpAds_PageHeader("5.1");
    phpAds_ShowSections(array("5.1", "5.3", "5.2"));
} else {
    phpAds_PageHeader("4.1");
    phpAds_ShowSections(array("4.1"));
}
phpAds_SettingsSelection("csvimport");

$admin_settings = phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency);

// ensure that any relevant dropdowns are reset depending on which field has changed
if (isset($_POST['field_changed']) && $_POST['field_changed'] != '') {
    switch($_POST['field_changed']) {
    case 'clients' :
        $reset_banners = true;
        $reset_zones = true;
    case 'campaigns' : 
        $reset_zones = true;
    default :
        break;
    }
}

//prepare data for select fields
//clients
$res_clients = phpAds_dbQuery(
    "SELECT clientid, clientname".
    " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
    " WHERE agencyid=".phpAds_getUserID().
    phpAds_getClientListOrder ($listorder, $orderdirection)
) or phpAds_sqlDie();
unset($clients);
while ($row_clients = phpAds_dbFetchArray($res_clients)) {
    $clients[$row_clients['clientid']]     = $row_clients['clientname'];
}

//campaigns
$query = "SELECT campaignid, campaignname".
         " FROM ".$conf['table']['prefix'].$conf['table']['campaigns'];
if (isset($_POST['clients']) && $_POST['clients'] != '') {
    $query .= " WHERE clientid=".$_POST['clients'];
} else {
    reset($clients);
    $query .= " WHERE clientid=".key($clients);
}
$query .= phpAds_getCampaignListOrder ($listorder, $orderdirection);
$res_campaigns = phpAds_dbQuery($query) or phpAds_sqlDie();
unset($campaigns);
while ($row_campaigns = phpAds_dbFetchArray($res_campaigns)) {
    $campaigns[$row_campaigns['campaignid']] = $row_campaigns['campaignname'];
}

//banners
$query = "SELECT bannerid, description".
         " FROM ".$conf['table']['prefix'].$conf['table']['banners'];
if (isset($_POST['campaigns']) && $_POST['campaigns'] != '' && !$reset_banners) {
    $query .= " WHERE campaignid=".$_POST['campaigns'];
} else {
    reset($campaigns);
    $query .= " WHERE campaignid=".key($campaigns);
}
$query .= phpAds_getBannerListOrder ($listorder, $orderdirection);
if (count($campaigns)) { // prevent db error if no campaigns
    $res_banners = phpAds_dbQuery($query) or phpAds_sqlDie();
}
unset($banners);
while ($row_banners = phpAds_dbFetchArray($res_banners)) {
    $banners[$row_banners['bannerid']]     = $row_banners['description'] == '' ? $strUntitled : $row_banners['description'];
}

//zones
$query = "SELECT zoneid, zonename".
         " FROM ".$conf['table']['prefix'].$conf['table']['zones']." a,"
         .$conf['table']['prefix'].$conf['table']['ad_zone_assoc']." b";
if (isset($_POST['banners']) && $_POST['banners'] != '' && !$reset_zones) {
    $query .= " WHERE a.zoneid = b.zone_id
                AND b.ad_id=".$_POST['banners'];
} else {
    reset($banners);
    $query .= " WHERE a.zoneid = b.zone_id
                AND b.ad_id=".key($banners);
}
$query .= phpAds_getZoneListOrder ($listorder, $orderdirection);
if (count($banners)) { // prevent db error if no banners
    $res_zones = phpAds_dbQuery($query) or phpAds_sqlDie();
}
unset($zones);
while ($row_zones = phpAds_dbFetchArray($res_zones)) {
    $zones[$row_zones['zoneid']] = $row_zones['zonename'] == '' ? $strUntitled : $row_zones['zonename'];
}

//trackers
$query = "SELECT trackerid,trackername".
         " FROM ".$conf['table']['prefix'].$conf['table']['trackers'];
if (isset($_POST['clients']) && $_POST['clients'] != '') {
    $query .= " WHERE clientid=".$_POST['clients'];
} else {
    reset($clients);
    $query .= " WHERE clientid=".key($clients);
}
$query .= phpAds_getTrackerListOrder ($listorder, $orderdirection);
$res_trackers = phpAds_dbQuery($query) or phpAds_sqlDie();
unset($trackers);
while ($row_trackers = phpAds_dbFetchArray($res_trackers)) {
    $trackers[$row_trackers['trackerid']]     = $row_trackers['trackername'];
}

$connection_status = $GLOBALS['connection_status_defVal'];
$connection_action = $GLOBALS['connection_action_defVal'];
$include_sample = $GLOBALS['include_sample_defVal'];

// set error message if no banners/zones
if (count($banners)==0) {
    $banners[0] = MAX_ERROR_NO_BANNERS_DROPDOWN;
    $zones[0] = MAX_ERROR_NO_ZONES_DROPDOWN;
    $errormessage[0] = MAX_ERROR_YOU_HAVE_NO_BANNERS;
    $disable_upload = true;
} else if (count($zones)==0) {
    $zones[0] = MAX_ERROR_NO_ZONES_DROPDOWN;
    $errormessage[0] = MAX_ERROR_YOU_HAVE_NO_ZONES;
    $disable_upload = true;
}

// set tracker name for display
$trackername = $_POST['tracker'] ? $trackers[$_POST['tracker']] : $trackers[key($trackers)];

if(count($trackers)==0) {
    $settings = array (
         array (
            'text'  => $strUploadConversions,
            'items' => array (
                array (
                    'type'  => 'select',
                    'name'  => 'clients',
                    'text'  => $strChooseAdvertiser,
                    'items' => $clients,
                    'visible' => $admin_settings
                ),
            )
        )
    );
    $errormessage[0] = MAX_ERROR_YOU_HAVE_NO_TRACKERS;
    $var = phpAds_ShowSettings($settings, $errormessage, $disableSubmit=1);
} elseif (count($campaigns)==0) {
    $settings = array (
         array (
            'text'  => $strUploadConversions,
            'items' => array (
                array (
                    'type'  => 'select',
                    'name'  => 'clients',
                    'text'  => $strChooseAdvertiser,
                    'items' => $clients,
                    'visible' => $admin_settings
                ),
            )
        )
    );
    $errormessage[0] = MAX_ERROR_YOU_HAVE_NO_CAMPAIGNS;
    $var = phpAds_ShowSettings($settings, $errormessage, $disableSubmit=1);
} else {
    $settings = array (
         array (
            'text'  => $strUploadConversions,
            'items' => array (
                array (
                    'type'  => 'select',
                    'name'  => 'clients',
                    'text'  => $strChooseAdvertiser,
                    'items' => $clients,
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'break',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'select',
                    'name'  => 'tracker',
                    'text'  => $strChooseTracker,
                    'items' => $trackers,
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'break',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'select',
                    'name'  => 'connection_status',
                    'text'  => $strDefaultConversionStatus,
                    'items' => $defaultConversionStatusList,
                    'visible' => $admin_settings,
                    'reload'  => 'no'
                ),
                array (
                    'type'  => 'break',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'select',
                    'name'  => 'connection_action',
                    'text'  => $strDefaultConversionType,
                    'items' => $defaultConversionTypeList,
                    'visible' => $admin_settings,
                    'reload'  => 'no'
                ),
                array (
                    'type'  => 'break',
                    'size' => 'wide',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'break',
                    'size' => 'empty',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'break',
                    'size' => 'empty',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'plaintext',
                    'text' => MAX_INFO_CSV_TEMPLATE_SETTINGS,
                    'font' => 'bold',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'break',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'plaintext',
                    'text' => '<b>Tracker</b>: '.$trackername,
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'break',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'select',
                    'name'  => 'campaigns',
                    'text'  => $strChooseCampaign,
                    'items' => $campaigns,
                    'visible' => $admin_settings
                ),                
                array (
                    'type'  => 'break',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'select',
                    'name'  => 'banners',
                    'text'  => $strChooseCampaignBanner,
                    'items' => $banners,
                    'visible' => $admin_settings
                ),                
                array (
                    'type'  => 'break',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'select',
                    'name'  => 'zones',
                    'text'  => $strChooseZone,
                    'items' => $zones,
                    'visible' => $admin_settings
                ),                
                array (
                    'type'  => 'break',
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'checkbox',
                    'name'  => 'advanced_template',
                    'text'  => MAX_INFO_CSV_TEMPLATE_ADVANCED,
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'checkbox',
                    'name'  => 'include_variables',
                    'text'  => MAX_INFO_CSV_TEMPLATE_INC_VARIABLES,
                    'visible' => $admin_settings
                ),
                array (
                    'type'  => 'checkbox',
                    'name'  => 'include_sample',
                    'text'  => MAX_INFO_SAMPLE_ROW,
                    'visible' => $admin_settings
                ),
            )
        )
    );

    if(isset($_FILES['uploadedfile']) && $_FILES['uploadedfile']['size'] > 0  && !empty($_POST['start_upload'])) {

        //show errors
        if(isset($uploadError) && count($uploadError) > 0) {
            foreach($uploadError as $record) {
                echo $record;
            }
        } else {
            //show basic information
            echo "<strong>" . MAX_INFO_LOADED_RECORDS . "</strong>: " . count($out) . '<br />';
            echo "<strong>" . MAX_INFO_BROKEN_RECORDS . "</strong>: " .count($brokenRecordsCount) . '<br />';
            
            echo '<br /><br />';

            //display table header
            echo '<table border="0" cellpadding="0" cellspacing="0"> <thead><tr>';
            foreach($out as $record) {
                foreach($record as $key=>$value) {
                    foreach($value as $key1=>$value1) {
                        echo '<td align="center" style="padding-left: 15px;padding-right: 15px;" >' . $key1 . ' ' . '</td>';
                    }
                }
                echo '</thead><tr>';
                break;
            }
            $i=0;
            //display table data
            foreach($out as $record) {
                foreach($record as $key=>$value) {
                    foreach($value as $key1=>$value1) {
                        echo '<td height="25" style="padding-left: 15px;padding-right: 15px;" align="left"';
                        if($value1['validate'] != 'ok') {
                            echo ' bgcolor="pink"';
                        }
                        echo '>';
                        if($value1['validate'] == 'ok') {
                            echo '<font color="#333333">';
                        }
                        echo $value1['value'];
                        if($value1['validate'] != 'ok') {
                            echo '<br> <font class="csverror">' . $value1['validate'] . '</font>';
                        }
                        if($value1['validate'] == 'ok') {
                            echo '</font>';
                        }
                        echo '</td>';
                    }
                }
                echo '</tr>';
                echo "<tr height='1'>
                          <td colspan='100' height='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
                      </tr>";
                echo "<tr ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
                $i++;
            }

            echo '</tr> </table>';

            echo '<form method="post" action="?">';
            echo '<input type="hidden" name="out" value="'. base64_encode(serialize($out)) .'">';
            echo '<input type="hidden" name="clients" value="'.$_POST['clients'].'">';
            echo '<input type="hidden" name="campaigns" value="'.$_POST['campaigns'].'">'; 
            echo '<input type="hidden" name="banners" value="'.$_POST['banners'].'">'; 
            echo '<input type="hidden" name="tracker" value="'.$_POST['tracker'].'">';
            echo '<input type="hidden" name="connection_status" value="'.$_POST['connection_status'].'">';
            echo '<input type="hidden" name="connection_action" value="'.$_POST['connection_action'].'">';
            echo '<input type="hidden" name="submitCommit" value="1">';
            echo '<table border="0"><tr>';
            echo '<td> <br> <input type="submit" name="submit1" value="'.MAX_INFO_CONFIRM_UPLOAD.'"> </td>';
            echo '</tr></table>';
            echo '</form>';

            echo '<form method="post" action="?">';
            echo '<input type="hidden" name="clients" value="'.$_POST['clients'].'">';
            echo '<input type="hidden" name="campaigns" value="'.$_POST['campaigns'].'">';
            echo '<input type="hidden" name="banners" value="'.$_POST['banners'].'">';
            echo '<input type="hidden" name="tracker" value="'.$_POST['tracker'].'">';
            echo '<input type="hidden" name="connection_status" value="'.$_POST['connection_status'].'">';
            echo '<input type="hidden" name="connection_action" value="'.$_POST['connection_action'].'">';
            echo '<table border="0"><tr>';
            echo '<td> <br> <input type="submit" name="" value="'.MAX_INFO_REUPLOAD_CSV_FILE.'"> </td>';
            echo '</tr></table>';
        } //endif (showErros)

    } else {
  
        $conf['max']['installed']=0;

        if(isset($flagUploaded) && $flagUploaded == 1) {
            if(isset($uploadError) && count($uploadError) > 0) {
                echo MAX_ERROR_INSERT_ERROR_PART1 . count($uploadError) . MAX_ERROR_INSERT_ERROR_PART2;
            } else {
                echo MAX_INFO_INSERT_CORRECT;
            }
        }    

        //show errors
        if(isset($uploadError) && count($uploadError) > 0) {
            foreach($uploadError as $record) {
                echo $record;
            }
        } else { 
            $var = phpAds_ShowSettings($settings, $errormessage, $disableSubmit=1);
            if ($disable_upload) {
                echo '<script language="javascript">document.settingsform.submitCreateTemplate.disabled=true;</script>';
            }
        }
    }
}  //end if

phpAds_PageFooter();

?>
