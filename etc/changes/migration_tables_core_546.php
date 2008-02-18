<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_546 extends Migration
{


    var $aConfNew = array();

    var $aConfMap = array(
                          'email'           => array(
                                                    'headers'           => 'admin_email_headers',
                                                    'logOutgoing'       => 'userlog_email',
                                                    'qmailPatch'        => 'qmail_patch',
                                                    'fromName'          => 'admin_fullname',
                                                    'fromAddress'       => 'admin_email'
                                               ),
                          'delivery'        => array(
                                                    'clicktracking'     => 'gui_invocation_3rdparty_default',
                                                    ),
                          'sync'            => array(
                                                    'checkForUpdates'   => 'updates_enabled',
                                                    ),
                          'allowedTags'     => array(
                                                    'adviewnocookies'   => 'allow_invocation_plain_nocookies',
                                                    'adjs'              => 'allow_invocation_js',
                                                    'adframe'           => 'allow_invocation_frame',
                                                    'xmlrpc'            => 'allow_invocation_xmlrpc',
                                                    'local'             => 'allow_invocation_local',
                                                    'adlayer'           => 'allow_invocation_interstitial',
                                                    'popup'             => 'allow_invocation_popup',
                                                    'adview'            => 'allow_invocation_plain',
                                                    ),
                          'allowedBanners'  => array(
                                                    'sql'               => 'type_sql_allow',
                                                    'url'               => 'type_url_allow',
                                                    'web'               => 'type_web_allow',
                                                    'html'              => 'type_html_allow',
                                                    'txt'               => 'type_txt_allow',
                                                    ),
                          'ui'              => array(
                                                    'headerFilePath'        => 'my_header',
                                                    'footerFilePath'        => 'my_footer',
                                                    'logoFilePath'          => 'my_logo',
                                                    'applicationName'       => 'name',
                                                    'gzipCompression'       => 'content_gzip_compression',
                                                    'headerBackgroundColor' => 'gui_header_background_color',
                                                    'headerForegroundColor' => 'gui_header_foreground_color',
                                                    'headerActiveTabColor'  => 'gui_header_active_tab_color',
                                                    'headerTextColor'       => 'gui_header_text_color',
                                                     ),
                          );


    var $aPrefMap = array(
                        'language'                          => array('name'=>'language','value'=>'','level'=>OA_ACCOUNT_TRAFFICKER),
                        'company_name'                      => array('name'=>'company_name','value'=>'','level'=>OA_ACCOUNT_MANAGER),
                        'ui_week_start_day'                 => array('name'=>'begin_of_week','value'=>'','level'=>''),
                        'ui_percentage_decimals'            => array('name'=>'percentage_decimals','value'=>'','level'=>''),
                        'warn_admin'                        => array('name'=>'warn_admin','value'=>'','level'=>OA_ACCOUNT_ADMIN),
                        'warn_email_manager'                => array('name'=>'warn_agency','value'=>'','level'=>OA_ACCOUNT_MANAGER),
                        'warn_email_advertiser'             => array('name'=>'warn_client','value'=>'','level'=>OA_ACCOUNT_ADVERTISER),
                        'warn_email_admin_impression_limit' => array('name'=>'warn_limit','value'=>'','level'=>OA_ACCOUNT_MANAGER),
                        'warn_email_admin_day_limit'        => array('name'=>'warn_limit_days','value'=>'','level'=>OA_ACCOUNT_MANAGER),
                        'ui_novice_user'                    => array('name'=>'admin_novice','value'=>'f','level'=>''),
                        'default_banner_weight'             => array('name'=>'default_banner_weight','value'=>'1','level'=>OA_ACCOUNT_ADVERTISER),
                        'default_campaign_weight'           => array('name'=>'default_campaign_weight','value'=>'1','level'=>OA_ACCOUNT_ADVERTISER),
                        'default_banner_image_url'          => array('name'=>'default_banner_url','value'=>'','level'=>OA_ACCOUNT_TRAFFICKER),
                        'default_banner_destination_url'    => array('name'=>'default_banner_destination','value'=>'','level'=>OA_ACCOUNT_TRAFFICKER),
                        'ui_show_campaign_info'             => array('name'=>'gui_show_campaign_info','value'=>'','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_campaign_preview'          => array('name'=>'gui_show_campaign_preview','value'=>'','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_banner_info'               => array('name'=>'gui_show_banner_info','value'=>'','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_banner_preview'            => array('name'=>'gui_show_banner_preview','value'=>'','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_banner_html'               => array('name'=>'gui_show_banner_html','value'=>'','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_matching_banners'          => array('name'=>'gui_show_matching','value'=>'','level'=>OA_ACCOUNT_TRAFFICKER),
                        'ui_show_matching_banners_parents'  => array('name'=>'gui_show_parents','value'=>'','level'=>OA_ACCOUNT_TRAFFICKER),
                        'ui_hide_inactive'                  => array('name'=>'gui_hide_inactive','value'=>'','level'=>''),
                        'tracker_default_status'            => array('name'=>'default_tracker_status','value'=>'','level'=>''),
                        'tracker_default_type'              => array('name'=>'default_tracker_type','value'=>'','level'=>''),
                        'tracker_link_campaigns'            => array('name'=>'default_tracker_linkcampaigns','value'=>'','level'=>''),
                        );

    var $aAppVar = array(
                        'maintenance_timestamp',
                        'maintenance_cron_timestamp',
                        );

    var $aPrefDep = array(
                        'agencyid',
                        'config_version',
                        'override_gd_imageformat',
                        'banner_html_auto',
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
                        );

    var $tblAccounts;
    var $tblPrefsNew;
    var $tblAccPrefs;
	var $tblPrefsOld;
    var $tblAgency;
    var $tblAppVars;

    function Migration_546()
    {
        //$this->__construct();

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
	    $this->tblAgency    = $this->_getQuotedTableName('agency');
        $this->tblPrefsOld  = $this->_getQuotedTableName('preference');
        $this->tblAppVars   = $this->_getQuotedTableName('application_variable');
	    $this->tblAccounts  = $this->_getQuotedTableName('accounts');
	    $this->tblPrefsNew  = $this->_getQuotedTableName('preferences');
	    $this->tblAccPrefs  = $this->_getQuotedTableName('account_preference_assoc');

        // fetch the admin's current prefs
        $aPrefOldAdmin = $this->_getOldPreferencesAdmin();
        if (!empty($aPrefOldAdmin))
        {
            // remove from array: the old prefs being deprecated
            $this->_filterOutDeprecatedPreferences($aPrefOldAdmin);
            // remove from array: the old prefs being migrated to settings
            $this->_mapOldPrefsToSettings($aPrefOldAdmin);
            // map the old prefs being migrated to new prefs
            $this->_mapOldPrefsToPrefs($aPrefOldAdmin);
            if (!$this->_writeSettings())
            {
                return false;
            }
            if (!$this->_moveAppVars($aPrefOldAdmin))
            {
                return false;
            }
            // use map to migrate admin prefs and settings
            if (!$this->_movePreferencesAdmin($aPrefOldAdmin))
            {
                return false;
            }
            // migrate agency prefs
            $this->_movePreferencesAgency($aPrefOldAdmin);
            return true;
        }
        return false;
	}

	/**
	 * Migrate language from affiliates
	 * preferences.language = preference.language
 	 * Migrate language/logout_url from agency
 	 * Migrate language from clients
 	 * Migrate timezone (is it needed?)
 	 * preferences.timezone = ['timezone'] location
 	 * Migrate old preference table values to new preferences table	 *
	 * @return boolean
	 */
	function _movePreferencesAdmin()
	{
	    $query = "SELECT account_id
	               FROM {$this->tblAccounts}
	               WHERE account_type = 'ADMIN'";
	    $accountId = $this->oDBH->queryOne($query);

	    if (PEAR::isError($accountId))
	    {
	        $this->_logError('Failed to retrieve admin account id');
	        return false;
	    }
        if (!$this->_insertPreferencesAdmin($accountId, $this->aPrefMap))
        {
            return false;
        }
        return true;
	}

	function _moveAppVars($aPrefOldAdmin)
	{
	    foreach ($this->aAppVar AS $name)
	    {
	        $value = (isset($aPrefOldAdmin[$name]) ? $aPrefOldAdmin[$name] : 0 );
	        if (!$this->_insertApplicationVariable($name, $value))
	        {
	            return false;
	        }
	    }
	    return true;
	}

	function _movePreferencesAgency()
	{
	    $query = "SELECT *
	               FROM {$this->tblPrefsOld}
	               WHERE agencyid > 0";
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

	function _insertPreferencesAdmin($accountId, $aPrefMap)
	{
        foreach ($aPrefMap as $newName => $aVal)
        {
            if (!$this->_insertPreferencesRecord($newName, $aVal['level']))
            {
                $this->_logError('Failed to insert preferences record for '.$newName);
            }
            $prefId = $this->_getPreferencesId($newName);
    	    if (!$prefId)
    	    {
    	        return false;
    	    }
            $this->_insertAccountPreferencesAssoc($accountId, $prefId, $aVal['value']);
        }
	    return true;
	}

	function _insertPreferencesRecord($prefName, $accountType)
	{
	    $prefName = $this->oDBH->quote($prefName);
	    $accountType = $this->oDBH->quote($accountType);
	    $query = "INSERT INTO
	               {$this->tblPrefsNew}
	               (preference_name, account_type)
	               VALUES
	               ({$prefName},{$accountType})";

  	    $result = $this->oDBH->Exec($query);

	    if (PEAR::isError($result))
	    {
	        $this->_logError('Failed to insert preference record for '.$prefName);
	        return false;
	    }
	    return true;
    }

	function _insertAccountPreferencesAssoc($accountId, $preferenceId, $value)
	{
	    $value = $this->oDBH->quote($value);
	    $query = "INSERT INTO
	               {$this->tblAccPrefs}
	               (account_id, preference_id, value)
	               VALUES
	               ({$accountId}, {$preferenceId}, {$value})";

	    $result = $this->oDBH->Exec($query);

	    if (PEAR::isError($result))
	    {
	        $this->_logError('Failed to insert assoc record for account id '.$accountId.' : preference id '.$preferenceId);
	        return false;
	    }
	    return true;
	}

	function _insertApplicationVariable($name, $value=0)
	{
	    $name = $this->oDBH->quote($name);
	    $value = $this->oDBH->quote($value);
	    $query = "INSERT INTO
	               {$this->tblAppVars}
	               (name, value)
	               VALUES
	               ({$name},{$value})";

  	    $result = $this->oDBH->Exec($query);

	    if (PEAR::isError($result))
	    {
	        $this->_logError('Failed to insert application variable for '.$name);
	        return false;
	    }
	    return true;
    }

	function _getPreferencesId($prefName)
	{
	    $prefName = $this->oDBH->quote($prefName);
	    $query = "SELECT * FROM
	               {$this->tblPrefsNew}
                    WHERE preference_name = {$prefName}";

	    $prefId = $this->oDBH->queryOne($query);

	    if (PEAR::isError($prefId))
	    {
	        $this->_logError('Failed to retrieve preference id for '.$prefName);
	        return false;
	    }
	    return $prefId;
	}

    function _getOldPreferencesAdmin()
    {
        $aResult = $this->_getOldPreferences(true);
	    if (PEAR::isError($aResult))
	    {
	        return $this->_logErrorAndReturnFalse($aResult);
	    }
	    if (!is_array(($aResult)))
	    {
	        $this->_logError('Failed to retrieve old preference record(s)');
	        return false;
	    }
        return $aResult[0];
    }

    function _getOldPreferences($admin=true)
    {
	    $query = "SELECT *
	               FROM {$this->tblPrefsOld}";
	    if ($admin)
	    {
	        $query.= " WHERE agencyid = 0";
	    }
	    return $this->oDBH->queryAll($query);
    }

    function _mapOldPrefsToSettings(&$aPrefOld)
    {
        foreach ($this->aConfMap AS $section => $aPairs)
        {
            foreach ($aPairs AS $nameNew => $nameOld)
            {

                $this->aConfNew[$section][$nameNew] = $aPrefOld[$nameOld];
                unset($aPrefOld[$nameOld]);
            }
        }
        return true;
    }

    function _mapOldPrefsToPrefs(&$aPrefOld)
    {

        foreach ($this->aPrefMap AS $newName => $aVal)
        {
            $this->aPrefMap[$newName]['value'] = ( is_null($aPrefOld[$aVal['name']]) ? '' : $aPrefOld[$aVal['name']]);
            unset($aPrefOld[$aVal['name']]);
        }

        // only elements left should be the gui_columns that have serialized array values
        foreach ($aPrefOld AS $oldName => $val)
        {
            $aVal = unserialize($val);
            if (is_array($aVal))
            {
                $newName = substr($oldName,1);
                if (array_key_exists('1', $aVal))
                {
                    $valShow  = $aVal[1]['show'];
                    $valLabel = $aVal[1]['label'];
                    $valRank  = $aVal[1]['rank'];
                }
                else
                {
                    $valShow  = 'f';
                    $valLabel = '';
                    $valRank  = 0;
                }
                $this->aPrefMap[$newName]            = array('value'=>$valShow ,'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
                $this->aPrefMap[$newName.'_label']   = array('value'=>$valLabel,'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
                $this->aPrefMap[$newName.'_rank']    = array('value'=>$valRank ,'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
            }
        }
        return true;
    }

    function _filterOutDeprecatedPreferences(&$aPrefOld)
    {
        foreach ($this->aPrefDep as $name)
        {
            unset($aPrefOld[$name]);
        }
        return true;
    }

    function _writeSettings()
    {
        $oConfiguration = & new OA_Upgrade_Config();
        foreach ($this->aConfMap AS $section => $aPair)
        {
            $name = key($aPair);
            $value = $this->aConfNew[$section][$name];
            $oConfiguration->setValue($section,$name,$value);
        }
        return $oConfiguration->writeConfig();
    }

}

?>
