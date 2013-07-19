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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "database";

// Prepare an array for storing error messages
$aErrormessage = array();

// FORM IS NOW DISABLED
// If the settings page is a submission, deal with the form data
/*if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    // Database Server Settings
    $aElements += array(
        'database_type'     => array('database' => 'type'),
        'database_host'     => array('database' => 'host'),
        'database_socket'   => array('database' => 'socket'),
        'database_port'     => array('database' => 'port'),
        'database_username' => array('database' => 'username'),
        'database_password' => array('database' => 'password'),
        'database_name'     => array('database' => 'name'),
        'database_protocol' => array('database' => 'protocol'),
        'table_prefix'      => array('table'    => 'prefix'),
    );
    // Database Optimision Settings
    $aElements += array(
        'database_persistent' => array(
            'database' => 'persistent',
            'bool'     => true
        )
    );
    // Set the database type, as can never be submitted by the form
    $database_type = $GLOBALS['_MAX']['CONF']['database']['type'];
    // Test the database connectivity
    phpAds_registerGlobal(
        'database_host',
        'database_protocol',
        'database_localsocket',
        'database_socket',
        'database_port',
        'database_username',
        'database_password',
        'database_name',
        'table_prefix'
    );

    //  if database socket is null set to empty so it's updated by processSettingsFromForm()
    $database_socket = (is_null($database_socket)) ? '' : $database_socket;

    $aDsn = array();
    $aDsn['database']['type']     = $database_type;
    $aDsn['database']['host']     = $database_host;
    $aDsn['database']['socket']   = $database_socket;
    $aDsn['database']['port']     = $database_port;
    $aDsn['database']['username'] = $database_username;
    $aDsn['database']['password'] = $database_password;
    $aDsn['database']['name']     = $database_name;
    $database_protocol            = ($database_localsocket ? 'unix' : 'tcp');
    $aDsn['database']['protocol'] = $database_protocol;
    $aDsn['table']['prefix']      = $table_prefix;

    // first try connecting to database using the connection class
    $oDbh = OA_DB::singleton(OA_DB::getDsn($aDsn));
    if (!($connected = (!PEAR::isError($oDbh))))
    {
        $aErrormessage[0][] = $strCantConnectToDb;
    }
    else
    {
        // then try connecting to database using the delivery engine function
        $conf = & $GLOBALS['_MAX']['CONF'];
        $conf['TEST_DB_LINK'] = $aDsn['database'];
        require_once(MAX_PATH.'/lib/OA/Dal/Delivery/'.$database_type.'.php');
        if (!($connected = OA_Dal_Delivery_connect('TEST_DB_LINK')))
        {
            $aErrormessage[0][] = $strCantConnectToDbDelivery;
        }
        unset($conf['TEST_DB_LINK']);
    }
    // if we managed to connect using both methods, go ahead and save the db connection details
    if ($connected)
    {
        // Create a new settings object, and save the settings!
        $oSettings = new OA_Admin_Settings();
        $result = $oSettings->processSettingsFromForm($aElements);
        if ($result) {
            // Queue confirmation message
            $setPref = $oOptions->getSettingsPreferences($prefSection);
            $title = $setPref[$prefSection]['name'];
            $translation = new OX_Translation ();
            $translated_message = $translation->translate($GLOBALS['strXSettingsHaveBeenUpdated'],
                array(htmlspecialchars($title)));
            //$GLOBALS['_MAX']['CONF'] = parseIniFile();
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
             // The settings configuration file was written correctly,
            OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
        }
        // Could not write the settings configuration file, store this
        // error message and continue
        $aErrormessage[0][] = $strUnableToWriteConfig;
    }
}*/

// Set the correct section of the settings pages and display the drop-down menu
$setPref = $oOptions->getSettingsPreferences($prefSection);
$title = $setPref[$prefSection]['name'];

// Display the settings page's header and sections
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-settings-index', $oHeaderModel);

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$oSettings = array (
    array (
        'text'  => $strDatabaseServer,
        'items' => array (
            array (
                'type'       => 'select',
                'name'       => 'database_type',
                'text'       => $strDbType,
                'items'      => array($GLOBALS['_MAX']['CONF']['database']['type'] => $GLOBALS['_MAX']['CONF']['database']['type']),
                'disabled'   => true,
            ),
            array (
                'type'       => 'break'
            ),
            array (
                    'type'    => 'checkbox',
                    'name'    => 'database_localsocket',
                    'text'    => $strDbLocal,
                    'onclick' => 'toggleSocketInput(this);',
                    'disabled'   => true,
            ),
            array (
                    'type'    => 'hidden',
                    'name'    => 'database_protocol',
            ),
            array (
                'type'       => 'break'
            ),
            array (
                    'type'    => 'text',
                    'name'    => 'database_socket',
                    'text'    => $strDbSocket,
                    'disabled'   => true,
            ),
            array (
                'type'       => 'break'
            ),
            array (
                'type'       => 'text',
                'name'       => 'database_host',
                'text'       => $strDbHost,
                'disabled'   => true,
            ),
            array (
                'type'       => 'break'
            ),
            array (
                'type'       => 'text',
                'name'       => 'database_port',
                'text'       => $strDbPort,
                'check'      => 'wholeNumber',
                'disabled'   => true,
            ),
            array (
                'type'       => 'break'
            ),
            array (
                'type'       => 'text',
                'name'       => 'database_username',
                'text'       => $strDbUser,
                'disabled'   => true,
            ),
            array (
                'type'       => 'break'
            ),
            array (
                'type'       => 'password',
                'name'       => 'database_password',
                'text'       => $strDbPassword,
                'disabled'   => true,
            ),
            array (
                'type'       => 'break'
            ),
            array (
                'type'       => 'text',
                'name'       => 'database_name',
                'text'       => $strDbName,
                'value'     => stripslashes($GLOBALS['_MAX']['CONF']['database']['name']),
                'decode'    => true,
                'disabled'   => true,
            )
        )
    ),
    array (
        'text'  => $strAdvancedSettings,
        'items' => array (
            array (
                'type'      => 'select',
                'name'      => 'table_type',
                'text'      => $strTablesType,
                'items'      => array($GLOBALS['_MAX']['CONF']['table']['type'] => $GLOBALS['_MAX']['CONF']['table']['type']),
                'disabled'   => true,

            ),
            array (
                'type'      => 'break'
            ),
            array (
                'type'      => 'text',
                'name'      => 'table_prefix',
                'text'      => $strTablesPrefix,
                'maxlength' => '7',
                'value'     => stripslashes($GLOBALS['_MAX']['CONF']['table']['prefix']),
                'decode'    => true,
                'disabled'   => true,
            )
        )
    ),
    array (
        'text'  => $strDatabaseOptimalisations,
        'items' => array (
            array (
                'type'      => 'checkbox',
                'name'      => 'database_persistent',
                'text'      => $strPersistentConnections,
                'disabled'   => true,
            )
        ),
    ),
);
$oOptions->oTpl->assign('formIsDisabled', true);
$oOptions->show($oSettings, $aErrormessage, true);

// Display the page footer
phpAds_PageFooter();

?>