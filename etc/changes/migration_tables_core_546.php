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

class Migration_546 extends Migration
{

    /**
     * An array to store new setting configuration file items that
     * have been migrated from old preference values that need to
     * be added to the configuration file.
     *
     * @var array
     */
    var $aConfNew = array();

    /**
     * An array of arrays. Defines sections and keys in the main
     * OpenX configuration file, and the old style preference
     * names that are the source of the data for these values
     * during the migration of preferences to settings.
     *
     * @var array
     */
    var $aConfMap = array(
        'email'          => array(
            'headers'               => 'admin_email_headers',
            'logOutgoing'           => 'userlog_email',
            'qmailPatch'            => 'qmail_patch',
            'fromName'              => 'admin_fullname',
            'fromAddress'           => 'admin_email',
            'fromCompany'           => 'company_name'
        ),
        'delivery'       => array(
            'clicktracking'         => 'gui_invocation_3rdparty_default'
        ),
        'sync'           => array(
            'checkForUpdates'       => 'updates_enabled'
        ),
        'allowedTags'    => array(
            'adviewnocookies'       => 'allow_invocation_plain_nocookies',
            'adjs'                  => 'allow_invocation_js',
            'adframe'               => 'allow_invocation_frame',
            'xmlrpc'                => 'allow_invocation_xmlrpc',
            'local'                 => 'allow_invocation_local',
            'adlayer'               => 'allow_invocation_interstitial',
            'popup'                 => 'allow_invocation_popup',
            'adview'                => 'allow_invocation_plain'
        ),
        'allowedBanners' => array(
            'sql'                   => 'type_sql_allow',
            'url'                   => 'type_url_allow',
            'web'                   => 'type_web_allow',
            'html'                  => 'type_html_allow',
            'txt'                   => 'type_txt_allow'
        ),
        'ui'             => array(
            'headerFilePath'        => 'my_header',
            'footerFilePath'        => 'my_footer',
            'logoFilePath'          => 'my_logo',
            'applicationName'       => 'name',
            'gzipCompression'       => 'content_gzip_compression',
            'headerBackgroundColor' => 'gui_header_background_color',
            'headerForegroundColor' => 'gui_header_foreground_color',
            'headerActiveTabColor'  => 'gui_header_active_tab_color',
            'headerTextColor'       => 'gui_header_text_color'
         )
    );

    /**
     * An array that defines the new style preferences, and how the old style
     * preferences should be migrated into these preferences. Each entry for
     * a new preference name should be an array of three values:
     * - name:  The old preference name.
     * - value: The preference value to insert for the account.
     * - level: The account access level for the preference.
     *
     * Note that this array does not include any of the new "ui_column_name",
     * "ui_column_name_label" and "ui_column_name_rank" preferences (and,
     * obviously, any of the old style "gui_column_name" values either). These
     * are all handled in the _mapOldPrefsToPrefs() method.
     *
     * @var array
     */
    var $aPrefMap = array(
        'auto_alter_html_banners_for_click_tracking' => array('name' => 'banner_html_auto',              'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'ui_week_start_day'                          => array('name' => 'begin_of_week',                 'value' => '',  'level' => ''),
        'ui_percentage_decimals'                     => array('name' => 'percentage_decimals',           'value' => '',  'level' => ''),
        'warn_email_admin'                           => array('name' => 'warn_admin',                    'value' => '',  'level' => OA_ACCOUNT_ADMIN),
        'warn_email_admin_impression_limit'          => array('name' => 'warn_limit',                    'value' => '',  'level' => OA_ACCOUNT_ADMIN),
        'warn_email_admin_day_limit'                 => array('name' => 'warn_limit_days',               'value' => '',  'level' => OA_ACCOUNT_ADMIN),
        'warn_email_manager'                         => array('name' => 'warn_agency',                   'value' => '',  'level' => OA_ACCOUNT_MANAGER),
        'warn_email_manager_impression_limit'        => array('name' => 'warn_limit',                    'value' => '',  'level' => OA_ACCOUNT_MANAGER),
        'warn_email_manager_day_limit'               => array('name' => 'warn_limit_days',               'value' => '',  'level' => OA_ACCOUNT_MANAGER),
        'warn_email_advertiser'                      => array('name' => 'warn_client',                   'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'warn_email_advertiser_impression_limit'     => array('name' => 'warn_limit',                    'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'warn_email_advertiser_day_limit'            => array('name' => 'warn_limit_days',               'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'ui_novice_user'                             => array('name' => 'admin_novice',                  'value' => 'f', 'level' => ''),
        'default_banner_weight'                      => array('name' => 'default_banner_weight',         'value' => '1', 'level' => OA_ACCOUNT_ADVERTISER),
        'default_campaign_weight'                    => array('name' => 'default_campaign_weight',       'value' => '1', 'level' => OA_ACCOUNT_ADVERTISER),
        'default_banner_image_url'                   => array('name' => 'default_banner_url',            'value' => '',  'level' => OA_ACCOUNT_TRAFFICKER),
        'default_banner_destination_url'             => array('name' => 'default_banner_destination',    'value' => '',  'level' => OA_ACCOUNT_TRAFFICKER),
        'ui_show_campaign_info'                      => array('name' => 'gui_show_campaign_info',        'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'ui_show_campaign_preview'                   => array('name' => 'gui_show_campaign_preview',     'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'ui_show_banner_info'                        => array('name' => 'gui_show_banner_info',          'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'ui_show_banner_preview'                     => array('name' => 'gui_show_banner_preview',       'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'ui_show_banner_html'                        => array('name' => 'gui_show_banner_html',          'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'ui_show_matching_banners'                   => array('name' => 'gui_show_matching',             'value' => '',  'level' => OA_ACCOUNT_TRAFFICKER),
        'ui_show_matching_banners_parents'           => array('name' => 'gui_show_parents',              'value' => '',  'level' => OA_ACCOUNT_TRAFFICKER),
        'ui_hide_inactive'                           => array('name' => 'gui_hide_inactive',             'value' => '',  'level' => ''),
        'tracker_default_status'                     => array('name' => 'default_tracker_status',        'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'tracker_default_type'                       => array('name' => 'default_tracker_type',          'value' => '',  'level' => OA_ACCOUNT_ADVERTISER),
        'tracker_link_campaigns'                     => array('name' => 'default_tracker_linkcampaigns', 'value' => '',  'level' => OA_ACCOUNT_ADVERTISER)
    );

    /**
     * An array containing all known old style preference names that
     * are to be migrated into application variables.
     *
     * @var array
     */
    var $aAppVar = array(
        'maintenance_timestamp',
        'maintenance_cron_timestamp'
    );

    /**
     * An array containing all known old style preference names that
     * have been deprecated - and so should never be migrated.
     *
     * @var array
     */
    var $aPrefDep = array(
        'agencyid',
        'config_version',
        'override_gd_imageformat',
        'admin',
        'admin_pw',
        'client_welcome',
        'client_welcome_msg',
        'publisher_welcome',
        'publisher_welcome_msg',
        'gui_campaign_anonymous',
        'gui_link_compact_limit',
        'updates_cache',
        'updates_timestamp',
        'updates_last_seen',
        'allow_invocation_clickonly',
        'auto_clean_tables',
        'auto_clean_tables_interval',
        'auto_clean_userlog',
        'auto_clean_userlog_interval',
        'auto_clean_tables_vacuum',
        'autotarget_factor',
        'compact_stats',
        'statslastday',
        'statslasthour',
        'publisher_agreement',
        'publisher_agreement_text',
        'publisher_payment_modes',
        'publisher_currencies',
        'publisher_categories',
        'publisher_help_files',
        'publisher_default_tax_id',
        'publisher_default_approved',
        'more_reports',
        'gui_column_epps'
    );

    /**
     * Local store of the accounts table name.
     *
     * @var string
     */
    var $tblAccounts;

    /**
     * Local store of the new preferences table name.
     *
     * @var string
     */
    var $tblPrefsNew;

    /**
     * Local store of the account preferences table name.
     *
     * @var string
     */
    var $tblAccPrefs;

    /**
     * Local store of the old preferences table name.
     *
     * @var string
     */
	var $tblPrefsOld;

    /**
     * Local store of the agency table name.
     *
     * @var string
     */
    var $tblAgency;

    /**
     * Local store of the applpication variables table name.
     *
     * @var string
     */
    var $tblAppVars;

    /**
     * An array to store the result of OA_Preferences::getPreferenceDefaults();
     *
     * @var array
     */
    var $aDefaultPreferences;

    function __construct()
    {
		$this->aTaskList_destructive[] = 'beforeRemoveTable__preference';
		$this->aTaskList_destructive[] = 'afterRemoveTable__preference';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__preference_advertiser';
		$this->aTaskList_destructive[] = 'afterRemoveTable__preference_advertiser';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__preference_publisher';
		$this->aTaskList_destructive[] = 'afterRemoveTable__preference_publisher';
    }

	function beforeRemoveTable__preference()
	{
		return $this->migratePreferences() && $this->beforeRemoveTable('preference');
	}

	function afterRemoveTable__preference()
	{
		return $this->afterRemoveTable('preference_advertiser');
	}

	function beforeRemoveTable__preference_advertiser()
	{
		return $this->beforeRemoveTable('preference');
	}

	function afterRemoveTable__preference_advertiser()
	{
		return $this->afterRemoveTable('preference_advertiser');
	}

	function beforeRemoveTable__preference_publisher()
	{
		return $this->beforeRemoveTable('preference_publisher');
	}

	function afterRemoveTable__preference_publisher()
	{
		return $this->afterRemoveTable('preference_publisher');
	}

	function migratePreferences()
	{
        $this->aDefaultPreferences = $this->_getDefaultPreferences();

        $this->tblAgency    = $this->_getQuotedTableName('agency');
        $this->tblPrefsOld  = $this->_getQuotedTableName('preference');
        $this->tblAppVars   = $this->_getQuotedTableName('application_variable');
	    $this->tblAccounts  = $this->_getQuotedTableName('accounts');
	    $this->tblPrefsNew  = $this->_getQuotedTableName('preferences');
	    $this->tblAccPrefs  = $this->_getQuotedTableName('account_preference_assoc');

        // Fetch the admin's current (old style) preferences
        $aPrefOldAdmin = $this->_getOldPreferencesAdmin();
        if ($aPrefOldAdmin !== false && !empty($aPrefOldAdmin))
        {
            // Remove from array: the old preferences that have been deprecated
            $this->_filterOutDeprecatedPreferences($aPrefOldAdmin);
            // Populate the $this->aConfNew array with preferences that are to
            // be migrated to the settings configuration file, and remove these
            // preferences from the preference array
            $this->_mapOldPrefsToSettings($aPrefOldAdmin);
            // Write ou the new configuration settings file
            if (!$this->_writeSettings())
            {
                return false;
            }
            // Migrate required preferences to application valiables
            if (!$this->_moveAppVars($aPrefOldAdmin))
            {
                return false;
            }
            // Prepare the $this->aPrefMap array ready for the migration of
            // the old preferences to the new preferences for the admin
            // account
            $this->_mapOldPrefsToPrefs($aPrefOldAdmin);
            // Migrate admin preferences to new preferences
            if (!$this->_movePreferencesAdmin())
            {
                return false;
            }



            // Migrate agency preferences to new preferences
            $this->_movePreferencesAgency();
            return true;
        }
        return false;
	}

	/**
	 * A private method to retrieve the admin account's old
	 * style preferences from the database.
	 *
	 * @access private
	 * @return mixed Either an array of the admin account's
	 *               preferences, or false on error.
	 */
    function _getOldPreferencesAdmin()
    {
        $aResult = $this->_getOldPreferences(true);
	    if (PEAR::isError($aResult))
	    {
	        return $this->_logErrorAndReturnFalse($aResult);
	    }
	    if (!is_array(($aResult)))
	    {
	        $this->_logError('Failed to retrieve old admin account preference record(s)');
	        return false;
	    }
        return $aResult[0];
    }

    /**
     * A private method to retrive the old style preferences
     * from the database.
     *
     * @access private
     * @param boolean $admin When true, limit the results from
     *                       the database to only the admin
     *                       user.
     * @return mixed Either an array of arrays, containing the
     *               preferences retrieved, or a PEAR_Error on
     *               error.
     */
    function _getOldPreferences($admin = true)
    {
        $query = "
            SELECT
                *
            FROM
                {$this->tblPrefsOld}";
	    if ($admin)
	    {
	        $query.= " WHERE agencyid = 0";
	    }
	    return $this->oDBH->queryAll($query);
    }

    /**
     * A private method that removes any deprecated preferences
     * from an array of old style preferences that have been
     * retrieved from the database.
     *
	 * @access private
     * @param array $aPrefOld A reference to an array of preferences
     *                        from the database which need to have the
     *                        deprecated preferences removed.
     */
    function _filterOutDeprecatedPreferences(&$aPrefOld)
    {
        foreach ($this->aPrefDep as $name)
        {
            unset($aPrefOld[$name]);
        }
    }

    /**
     * A private method that stores preference values that need to be
     * migrated into the settings (i.e. the configuration file) from
     * an old style preferences array that has been retrieved from the
     * database, and removes these stored preference values from the
     * array passed in.
     *
	 * @access private
     * @param array $aPrefOld A reference to an array of preferences
     *                        from the database which need to have the
     *                        preferences that are to be migrated to
     *                        the settings stored in $this->aConfMap
     *                        and then removed from the array.
     */
    function _mapOldPrefsToSettings(&$aPrefOld)
    {
        foreach ($this->aConfMap AS $section => $aPairs)
        {
            foreach ($aPairs AS $nameNew => $nameOld)
            {
                // Store the preferece in $this->aConfNew
                $this->aConfNew[$section][$nameNew] = $aPrefOld[$nameOld];
                // Remove the preference from the array
                unset($aPrefOld[$nameOld]);
            }
        }
    }

    /**
     * A private method that writes out the new OpenX settings configuration
     * file after migrating over the admin account's preferences that have
     * now been changed into settings.
     *
     * @access private
     * @return boolean True if the config file is successfully written,
     *                 otherwise, false.
     */
    function _writeSettings()
    {
        $oConfiguration = new OA_Upgrade_Config();
        foreach ($this->aConfMap AS $section => $aPairs)
        {
            foreach ($aPairs as $key => $value) {
                $value = $this->aConfNew[$section][$key];
                $oConfiguration->setValue($section, $key, $value);
            }
        }
        return $oConfiguration->writeConfig();
    }

    /**
     * A private method that migrates preference values that need to be
     * migrated into application variables from an old style preferences
     * array that has been retrieved from the database, and removes these
     * stored preference values from the array passed in.
     *
	 * @access private
     * @param array $aPrefOld A reference to an array of preferences
     *                        from the database which need to have the
     *                        preferences that are to be migrated to
     *                        the application variables in the database
     *                        and then removed from the array.
     * @return boolean True on success, false otherwise.
     */
	function _moveAppVars(&$aPrefOldAdmin)
	{
	    foreach ($this->aAppVar AS $name)
	    {
	        $value = (isset($aPrefOldAdmin[$name]) ? $aPrefOldAdmin[$name] : 0 );
	        if (!$this->_insertApplicationVariable($name, $value))
	        {
	            return false;
	        }
	        unset($aPrefOldAdmin[$name]);
	    }
	    return true;
	}

	/**
	 * A private method to insert an application variable into the database
	 *
	 * @access private
	 * @param string $name The name of the application variable to insert.
	 * @param string $value The value of the application variable to insert.
	 * @return boolean True on success, false otherwise.
	 */
	function _insertApplicationVariable($name, $value = 0)
	{
	    $name = $this->oDBH->quote($name);
	    $value = $this->oDBH->quote($value);
	    $query = "
            INSERT INTO
                {$this->tblAppVars}
                (
                    name,
                    value
                )
            VALUES
	           (
	               {$name},
	               {$value}
               )";
  	    $result = $this->oDBH->Exec($query);
	    if (PEAR::isError($result))
	    {
	        $this->_logError("Failed to insert application variable '$name'");
	        return false;
	    }
	    return true;
    }

    /**
     * A private method to prepare the $this->aPrefMap array so that it is
     * ready to be used by the _movePreferencesAdmin() method to migrate an
     * account's preferences from the old style to the new style.
     *
     * (Which account's preferences are being prepared for migration depends
     * on how the $aPrefOld array was prepared.)
     *
     * @param array $aPrefOld An array of preferences from the database, for
     *                        the account that is to be prepared for migration,
     *                        where deprecated and application variable
     *                        preferences have already been removed.
     */
    function _mapOldPrefsToPrefs(&$aPrefOld)
    {
        // Iterate over all of the known (i.e. non-column) preferences
        foreach ($this->aPrefMap AS $newName => $aVal)
        {
            // If the passed in array of preferences has a value set for
            // the old preference name, use that value; otherwise leave the
            // default value that is already specified in the $this->aPrefMap
            if (!is_null($aPrefOld[$aVal['name']])) {
                $this->aPrefMap[$newName]['value'] = $aPrefOld[$aVal['name']];
            }
        }
        // Re-iterate over the values now that they have been set to remove
        // values no longer required
        foreach ($this->aPrefMap AS $newName => $aVal)
        {
            unset($aPrefOld[$aVal['name']]);
        }
        // The only remaining preferences of interest are old style "gui_column_name" entries
        foreach ($aPrefOld AS $oldName => $val)
        {
            if (strpos($oldName, 'gui_column_') === 0) {
                // Prepare the new preference name
                $newName = substr($oldName, 1);
                // Is there a value set for the preference?
                if (isset($val)) {
                    // Yes, extract the values for the preference
                    $aVal = unserialize($val);
                    if (is_array($aVal))
                    {
                        if (array_key_exists('1', $aVal))
                        {
                            if ($aVal[1]['show']) {
                                $valShow  = '1'; // Show
                            } else {
                                $valShow  = '';  // No not show
                            }
                            $valLabel = $aVal[1]['label'];
                            $valRank  = $aVal[1]['rank'];
                        }
                        else
                        {
                            $valShow  = ''; // Do not show
                            $valLabel = ''; // No custom label
                            $valRank  = 0;  // No rank
                        }
                        $this->aPrefMap[$newName]            = array('name' => $oldName, 'value' => $valShow,  'level' => OA_ACCOUNT_MANAGER);
                        $this->aPrefMap[$newName . '_label'] = array('name' => $oldName, 'value' => $valLabel, 'level' => OA_ACCOUNT_MANAGER);
                        $this->aPrefMap[$newName . '_rank']  = array('name' => $oldName, 'value' => $valRank,  'level' => OA_ACCOUNT_MANAGER);
                    }
                }
                // Test that a value has been set for the column preference
                if (!isset($this->aPrefMap[$newName])) {
                    // Add in the default value for the column preference
                    $this->aPrefMap[$newName]            = array('name' => $oldName, 'value' => $this->aDefaultPreferences[$newName]['default'],            'level' => OA_ACCOUNT_MANAGER);
                    $this->aPrefMap[$newName . '_label'] = array('name' => $oldName, 'value' => $this->aDefaultPreferences[$newName . '_label']['default'], 'level' => OA_ACCOUNT_MANAGER);
                    $this->aPrefMap[$newName . '_rank']  = array('name' => $oldName, 'value' => $this->aDefaultPreferences[$newName . '_rank']['default'],  'level' => OA_ACCOUNT_MANAGER);
                }
            }
        }
    }

	/**
	 * A private method to migrate the admin account's old style preferences
	 * into new style preferences.
	 *
	 * @access private
	 * @return boolean True on success, false otherwise.
	 */
	function _movePreferencesAdmin()
	{
	    // Obtain the admin account ID
        $query = "
            SELECT
                account_id
            FROM
                {$this->tblAccounts}
            WHERE
                account_type = 'ADMIN'";
	    $accountId = $this->oDBH->queryOne($query);
	    if (PEAR::isError($accountId) || is_null($accountId))
	    {
	        $this->_logError('Failed to retrieve admin account ID');
	        return false;
	    }
        if (!$this->_insertPreferencesAdmin($accountId, $this->aPrefMap))
        {
            return false;
        }
        return true;
	}

	/**
	 * A private method to migrate account preferences from the old style
	 * to the new.
	 *
	 * @access private
	 * @param integer $accountId The account ID of the account to migrate the
	 *                           preferences for
	 * @param array $aPrefMap The preference map array to use.
	 * @return True on success, false otherwise.
	 */
	function _insertPreferencesAdmin($accountId, $aPrefMap)
	{
	    // Iterate over all the preferences in the preference
        foreach ($aPrefMap as $newName => $aVal)
        {
            // Try to get the preference record - it may already exist
            $prefId = $this->_getPreferencesId($newName);
    	    if (!$prefId)
    	    {
                // Create the preference record
                $this->_insertPreferencesRecord($newName, $aVal['level']);
                // Get the preference ID for the record that needs to be inserted
                $prefId = $this->_getPreferencesId($newName);
        	    if (!$prefId)
        	    {
        	        // Could not create the preference record
        	        return false;
        	    }
    	    }
    	    // Now create the preference value record
            $this->_insertAccountPreferencesAssoc($accountId, $prefId, $aVal['value']);
        }
	    return true;
	}

	/**
	 * A private method to insert the preference table record for the preference
	 * type (i.e. the record for the name of the preference, not the preference
	 * value for the account).
	 *
	 * @access private
	 * @param string $prefName The name of the preference.
	 * @param string $accountType The access level for the preference, eg. '',
	 *                            OA_ACCOUNT_MANAGER, etc.
	 * @return True on success, false otherwise.
	 */
	function _insertPreferencesRecord($prefName, $accountType)
	{
	    $prefName = $this->oDBH->quote($prefName);
	    $accountType = $this->oDBH->quote($accountType);
	    $query = "
            INSERT INTO
                {$this->tblPrefsNew}
                (
                    preference_name,
                    account_type
                )
            VALUES
	           (
	               {$prefName},
	               {$accountType}
               )";
  	    $result = $this->oDBH->Exec($query);
	    if (PEAR::isError($result))
	    {
	        $this->_logError("'Failed to insert the preference record for '$prefName'");
	        return false;
	    }
	    return true;
    }

    /**
     * A private method to get the preference ID for a given preference
     * string (i.e. the ID of the preference, not a preference value).
     *
	 * @access private
     * @param string $prefName The preference name.
     * @return mixed The boolean false on failure, otherwise the integer
     *               ID of the preference.
     */
	function _getPreferencesId($prefName)
	{
	    $prefName = $this->oDBH->quote($prefName);
	    $query = "
            SELECT
                *
            FROM
	           {$this->tblPrefsNew}
            WHERE
                preference_name = {$prefName}";
	    $prefId = $this->oDBH->queryOne($query);
	    if (PEAR::isError($prefId))
	    {
	        $this->_logError('Failed to retrieve preference ID for '.$prefName);
	        return false;
	    }
	    return $prefId;
	}

	/**
	 * A private method to insert an account preference value.
	 *
	 * @param integer $accountId The ID of the account the preference is to be
	 *                           inserted for,
	 * @param integer $preferenceId The ID of the preference.
	 * @param string $value The preference value.
	 * @return True on success, false otherwise.
	 */
	function _insertAccountPreferencesAssoc($accountId, $preferenceId, $value)
	{
	    $value = $this->oDBH->quote($value, 'text');
	    $query = "
            INSERT INTO
	           {$this->tblAccPrefs}
	           (
	               account_id,
	               preference_id,
	               value
               )
           VALUES
	           (
	               {$accountId},
	               {$preferenceId},
	               {$value}
               )";
	    $result = $this->oDBH->Exec($query);
	    if (PEAR::isError($result))
	    {
	        $this->_logError("Failed to insert account/preference association record for
	                         account ID $accountId; preference ID $preferenceId; preference value '$value'");
	        return false;
	    }
	    return true;
	}


	function _movePreferencesAgency()
	{
        $query = "
            SELECT
	           *
            FROM
                {$this->tblPrefsOld}
            WHERE
                agencyid > 0";
	    $aPrefOldAgency = $this->oDBH->queryAll($query);

	    if (PEAR::isError($aPrefOldAgency))
	    {
	        $this->_logError('Failed to retrieve agency preferences: '.$aPrefOldAgency->getUserInfo());
	        return true;
	    }
	    if (empty($aPrefOldAgency))
	    {
	        return true;
	    }

	    // compare each agency pref value with admin value
	    // store diffs as acct/pref assocs
        foreach ($this->aPrefMap AS $newName => $aPrefNew)
        {
            if (substr($newName,0,9) != 'ui_column')
            {
                foreach ($aPrefOldAgency AS $k => $aPrefOld)
        	    {
        	        $oldName  = $aPrefNew['name'];
        	        $oldValue = (is_null($aPrefOld[$oldName]) ? '' : $aPrefOld[$oldName]);
                    if ($oldValue <> $aPrefNew['value'])
                    {

                	    $query = "SELECT account_id
                	               FROM {$this->tblAgency}
                	               WHERE agencyid = {$aPrefOld['agencyid']}";
                	    $accountId = $this->oDBH->queryOne($query);

                	    if (PEAR::isError($accountId))
                	    {
                	        $this->_logError('Failed to retrieve account id for agency '.$aPrefOld['agencyid']);
                	        break;
                	    }
                        $prefId = $this->_getPreferencesId($newName);
                	    if (!$prefId)
                	    {
                	        break;
                	    }
                        $this->_insertAccountPreferencesAssoc($accountId, $prefId, $oldValue);
                    }
                }
            }
        }
	    return true;
	}


    function _getDefaultPreferences()
    {
        return array (
          'default_banner_image_url' =>
          array (
            'account_type' => 'TRAFFICKER',
            'default' => '',
          ),
          'default_banner_destination_url' =>
          array (
            'account_type' => 'TRAFFICKER',
            'default' => '',
          ),
          'auto_alter_html_banners_for_click_tracking' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => true,
          ),
          'default_banner_weight' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => 1,
          ),
          'default_campaign_weight' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => 1,
          ),
          'warn_email_admin' =>
          array (
            'account_type' => 'ADMIN',
            'default' => true,
          ),
          'warn_email_admin_impression_limit' =>
          array (
            'account_type' => 'ADMIN',
            'default' => 100,
          ),
          'warn_email_admin_day_limit' =>
          array (
            'account_type' => 'ADMIN',
            'default' => 1,
          ),
          'warn_email_manager' =>
          array (
            'account_type' => 'MANAGER',
            'default' => true,
          ),
          'warn_email_manager_impression_limit' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 100,
          ),
          'warn_email_manager_day_limit' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 1,
          ),
          'warn_email_advertiser' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => true,
          ),
          'warn_email_advertiser_impression_limit' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => 100,
          ),
          'warn_email_advertiser_day_limit' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => 1,
          ),
          'timezone' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'tracker_default_status' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => 4,
          ),
          'tracker_default_type' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => 1,
          ),
          'tracker_link_campaigns' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => false,
          ),
          'ui_show_campaign_info' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => true,
          ),
          'ui_show_banner_info' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => true,
          ),
          'ui_show_campaign_preview' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => false,
          ),
          'ui_show_banner_html' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => false,
          ),
          'ui_show_banner_preview' =>
          array (
            'account_type' => 'ADVERTISER',
            'default' => true,
          ),
          'ui_hide_inactive' =>
          array (
            'account_type' => NULL,
            'default' => false,
          ),
          'ui_show_matching_banners' =>
          array (
            'account_type' => 'TRAFFICKER',
            'default' => true,
          ),
          'ui_show_matching_banners_parents' =>
          array (
            'account_type' => 'TRAFFICKER',
            'default' => false,
          ),
          'ui_novice_user' =>
          array (
            'account_type' => NULL,
            'default' => true,
          ),
          'ui_week_start_day' =>
          array (
            'account_type' => NULL,
            'default' => 1,
          ),
          'ui_percentage_decimals' =>
          array (
            'account_type' => NULL,
            'default' => 2,
          ),
          'ui_column_id' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_id_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_id_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_requests' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_requests_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_requests_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_impressions' =>
          array (
            'account_type' => 'MANAGER',
            'default' => true,
          ),
          'ui_column_impressions_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_impressions_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 1,
          ),
          'ui_column_clicks' =>
          array (
            'account_type' => 'MANAGER',
            'default' => true,
          ),
          'ui_column_clicks_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_clicks_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 2,
          ),
          'ui_column_ctr' =>
          array (
            'account_type' => 'MANAGER',
            'default' => true,
          ),
          'ui_column_ctr_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_ctr_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 3,
          ),
          'ui_column_conversions' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_conversions_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_conversions_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_conversions_pending' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_conversions_pending_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_conversions_pending_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_sr_views' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_sr_views_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_sr_views_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_sr_clicks' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_sr_clicks_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_sr_clicks_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_revenue' =>
          array (
            'account_type' => 'MANAGER',
            'default' => true,
          ),
          'ui_column_revenue_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_revenue_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 4,
          ),
          'ui_column_cost' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_cost_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_cost_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_bv' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_bv_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_bv_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_num_items' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_num_items_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_num_items_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_revcpc' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_revcpc_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_revcpc_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_costcpc' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_costcpc_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_costcpc_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_technology_cost' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_technology_cost_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_technology_cost_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_income' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_income_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_income_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_income_margin' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_income_margin_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_income_margin_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_profit' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_profit_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_profit_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_margin' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_margin_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_margin_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_erpm' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_erpm_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_erpm_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_erpc' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_erpc_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_erpc_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_erps' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_erps_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_erps_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_eipm' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_eipm_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_eipm_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_eipc' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_eipc_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_eipc_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_eips' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_eips_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_eips_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_ecpm' =>
          array (
            'account_type' => 'MANAGER',
            'default' => true,
          ),
          'ui_column_ecpm_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_ecpm_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 5,
          ),
          'ui_column_ecpc' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_ecpc_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_ecpc_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
          'ui_column_ecps' =>
          array (
            'account_type' => 'MANAGER',
            'default' => false,
          ),
          'ui_column_ecps_label' =>
          array (
            'account_type' => 'MANAGER',
            'default' => '',
          ),
          'ui_column_ecps_rank' =>
          array (
            'account_type' => 'MANAGER',
            'default' => 0,
          ),
        );
    }

}

?>
