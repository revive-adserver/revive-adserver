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
                        'language'                          => array('name'=>'language','level'=>OA_ACCOUNT_TRAFFICKER),
                        'ui_week_start_day'                 => array('name'=>'begin_of_week','level'=>''),
                        'ui_percentage_decimals'            => array('name'=>'percentage_decimals','level'=>''),
                        'warn_admin'                        => array('name'=>'warn_admin','level'=>OA_ACCOUNT_ADMIN),
                        'warn_email_manager'                => array('name'=>'warn_agency','level'=>OA_ACCOUNT_MANAGER),
                        'warn_email_advertiser'             => array('name'=>'warn_client','level'=>OA_ACCOUNT_ADVERTISER),
                        'warn_email_admin_impression_limit' => array('name'=>'warn_limit','level'=>OA_ACCOUNT_MANAGER),
                        'warn_email_admin_day_limit'        => array('name'=>'warn_limit_days','level'=>OA_ACCOUNT_MANAGER),
                        'ui_novice_user'                    => array('name'=>'admin_novice','level'=>''),
                        'default_banner_weight'             => array('name'=>'default_banner_weight','level'=>OA_ACCOUNT_ADVERTISER),
                        'default_campaign_weight'           => array('name'=>'default_campaign_weight','level'=>OA_ACCOUNT_ADVERTISER),
                        'default_banner_image_url'          => array('name'=>'default_banner_url','level'=>OA_ACCOUNT_TRAFFICKER),
                        'default_banner_destination_url'    => array('name'=>'default_banner_destination','level'=>OA_ACCOUNT_TRAFFICKER),
                        'ui_show_campaign_info'             => array('name'=>'gui_show_campaign_info','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_campaign_preview'          => array('name'=>'gui_show_campaign_preview','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_banner_info'               => array('name'=>'gui_show_banner_info','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_banner_preview'            => array('name'=>'gui_show_banner_preview','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_banner_html'               => array('name'=>'gui_show_banner_html','level'=>OA_ACCOUNT_ADVERTISER),
                        'ui_show_matching_banners'          => array('name'=>'gui_show_matching','level'=>OA_ACCOUNT_TRAFFICKER),
                        'ui_show_matching_banners_parents'  => array('name'=>'gui_show_parents','level'=>OA_ACCOUNT_TRAFFICKER),
                        'ui_hide_inactive'                  => array('name'=>'gui_hide_inactive','level'=>''),
                        'tracker_default_status'            => array('name'=>'default_tracker_status','level'=>''),
                        'tracker_default_type'              => array('name'=>'default_tracker_type','level'=>''),
                        'tracker_link_campaigns'            => array('name'=>'default_tracker_linkcampaigns','level'=>''),
                        );

    var $aPrefDep = array(
                        'agencyid',
                        'config_version',
                        'company_name',
                        'override_gd_imageformat',
                        'banner_html_auto',
                        'admin',
                        'admin_pw',
                        'admin_fullname',
                        'admin_email',
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
                        'maintenance_timestamp',
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
                        'maintenance_cron_timestamp',
                        );

    var $tblAccounts;
    var $tblPrefsNew;
    var $tblAccPrefs;
	var $tblPrefsOld;
    var $tblAgency;

    function Migration_546()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveTable__preference';
		$this->aTaskList_destructive[] = 'afterRemoveTable__preference';
    }



	function beforeRemoveTable__preference()
	{
		return $this->migratePreferencesAdmin() && $this->beforeRemoveTable('preference');
	}

	function afterRemoveTable__preference()
	{
		return $this->afterRemoveTable('preference');
	}


	function migratePreferencesAdmin()
	{
	    $aConf = & $GLOBALS['_MAX']['CONF'];
	    $this->tblAgency   = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['agency'],true);
	    $this->tblAccounts = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['accounts'],true);
        $this->tblPrefsOld = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['preference'],true);
        $this->tblPrefsNew = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['preferences'],true);
        $this->tblAccPrefs = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['account_preference_assoc'],true);

        // fetch the admin's current prefs
        $aPrefOldAdmin = $this->_getOldPreferencesAdmin();
        if (!empty($aPrefOldAdmin))
        {
            // remove the old prefs being deprecated
            $this->_filterOutDeprecatedPreferences($aPrefOldAdmin);
            // remove the old prefs being migrated to settings
            $this->_mapOldPrefsToSettings($aPrefOldAdmin);
            // map the old prefs being migrated to new prefs
            $this->_mapOldPrefsToPrefs($aPrefOldAdmin);
            // use map to migrate admin prefs and settings
            $this->_movePreferencesAdmin();
            // migrate agency prefs
            $this->_movePreferencesAgency($aPrefOldAdmin);
            // write settings to conf file
            $this->_writeSettings();
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
	        $this->_logError('Failed to retrieve admin account record id for '.$key);
	    }
        return $this->_insertPreferencesAdmin($accountId, $this->aPrefMap);
	}

	function _movePreferencesAgency()
	{
	    $query = "SELECT *
	               FROM {$this->tblPrefsOld}
	               WHERE agencyid > 0";
	    $aPrefOldAgency = $this->oDBH->queryAll($query);

	    if (PEAR::isError($aResult))
	    {
	        return $this->_logErrorAndReturnFalse($aResult);
	    }
	    if (empty($aPrefOldAgency))
	    {
	        return true;
	    }

	    // compare each agency pref value with admin value
	    // store diffs as acct/pref assocs
        foreach ($this->aPrefMap AS $newName => $aPrefNew)
        {
            foreach ($aPrefOldAgency AS $k => $aPrefOld)
    	    {
    	        $oldName  = $aPrefNew['name'];
    	        $oldValue = $aPrefOld[$oldName];
                $aVal     = unserialize($oldValue);
                if (is_array($aVal))
                {
                    if (strpos($newName,'_label') > 0)
                    {
                        $oldValue = $aVal['label'];
                    }
                    else if (strpos($newName,'_rank') > 0)
                    {
                        $oldValue = $aVal['rank'];
                    }
                    else
                    {
                        $oldValue = $aVal['show'];
                    }
                }
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
    	        continue;
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
	        $this->_logError('Failed to insert preference record for '.$key);
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
	        $this->_logErrorAndReturnFalse($aResult);
	    }
	    if (!is_array(($aResult)))
	    {
	        $this->_logError('Failed to retrieve old preference record(s)');
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
            $this->aPrefMap[$newName]['value'] = $aPrefOld[$aVal['name']];
            unset($aPrefOld[$oldName]);
        }

        // only elements left should be the gui_columns that have serialized array values
        foreach ($aPrefOld AS $oldName => $val)
        {
            $aVal = unserialize($val);
            if (is_array($aVal))
            {
                $newName = substr($oldName,1);
                $this->aPrefMap[$newName]            = array('value'=>$aVal['show'],'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
                $this->aPrefMap[$newName.'_label']   = array('value'=>$aVal['label'],'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
                $this->aPrefMap[$newName.'_rank']    = array('value'=>$aVal['rank'],'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
/*                $this->aPrefMap[$newName]            = array('value'=>$aVal['show'],'name'=>$oldName.'__show','level'=>OA_ACCOUNT_MANAGER);
                $this->aPrefMap[$newName.'_label']   = array('value'=>$aVal['label'],'name'=>$oldName.'__label','level'=>OA_ACCOUNT_MANAGER);
                $this->aPrefMap[$newName.'_rank']    = array('value'=>$aVal['rank'],'name'=>$oldName.'__rank','level'=>OA_ACCOUNT_MANAGER);
*/            }
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
        $oConfiguration->writeConfig();
    }

}

?>
