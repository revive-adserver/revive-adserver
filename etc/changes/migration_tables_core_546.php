<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_546 extends Migration
{

    var $aPrefOld = array();
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
        if ($this->_getOldPreferencesAdmin())
        {
            $this->_filterOutDeprecatedPreferencesAdmin();
            $this->_mapOldPrefsToSettingsAdmin();
            $this->_mapOldPrefsToPrefsAdmin();
            $this->_movePreferencesAdmin();
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
	    $aConf = & $GLOBALS['_MAX']['CONF'];
	    $tblAccounts = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['accounts'],true);
        $tblPrefsNew = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['preferences'],true);
        $tblAccPrefs = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['account_preference_assoc'],true);

	    $query = "SELECT account_id
	               FROM {$tblAccounts}
	               WHERE account_type = 'ADMIN'";
	    $accountId = $this->oDBH->queryOne($query);

	    if (PEAR::isError($accountId))
	    {
	        $this->_logError('Failed to retrieve admin account record id for '.$key);
	    }

	    $queryPref = "INSERT INTO
    	               {$tblPrefsNew}
    	               (preference_name, account_type)
    	               VALUES
    	               ('%s','%s')";

	    $queryAssoc = "INSERT INTO
    	               {$tblAccPrefs}
    	               (account_id, preference_id, value)
    	               VALUES
    	               (%s, %s,'%s')";

        foreach ($this->aPrefMap as $key => $aVal)
        {
            $queryP = sprintf($queryPref, $key, $aVal['level']);

    	    $result = $this->oDBH->Exec($queryP);

    	    if (PEAR::isError($result))
    	    {
    	        $this->_logError('Failed to insert admin preference record for '.$key);
    	    }

    	    $prefId = $this->oDBH->lastInsertID($tblPrefsNew, 'preference_id');

    	    if (PEAR::isError($prefId))
    	    {
    	        $this->_logError('Failed to retrieve admin preference record id for '.$key);
    	    }

            $queryA = sprintf($queryAssoc, $accountId, $prefId, $aVal['value']);

    	    $result = $this->oDBH->Exec($queryA);

    	    if (PEAR::isError($result))
    	    {
    	        $this->_logError('Failed to insert admin account preference assoc record for '.$key);
    	    }

        }
	    return true;
	}


    function _getOldPreferencesAdmin()
    {
	    $aConf = & $GLOBALS['_MAX']['CONF'];
	    $tblPrefsOld = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['preference'],true);

	    $query = "SELECT *
	               FROM {$tblPrefsOld}
	               WHERE agencyid = 0";
	    $aResult = $this->oDBH->queryAll($query);

	    if (PEAR::isError($aResult))
	    {
	        $this->_logErrorAndReturnFalse($aResult);
	    }
	    if (!is_array(($aResult)))
	    {
	        $this->_logError('Failed to retrieve old admin preference record');
	    }
        $this->aPrefOld = $aResult[0];
        return true;
    }


    function _mapOldPrefsToSettingsAdmin()
    {
        foreach ($this->aConfMap AS $section => $aPairs)
        {
            foreach ($aPairs AS $nameNew => $nameOld)
            {

                $this->aConfNew[$section][$nameNew] = $this->aPrefOld[$nameOld];
                unset($this->aPrefOld[$nameOld]);
            }
        }
        return true;
    }

    function _mapOldPrefsToPrefsAdmin()
    {

        foreach ($this->aPrefMap AS $newName => $aVal)
        {
            $this->aPrefMap[$newName]['value'] = $this->aPrefOld[$aVal['name']];
            unset($this->aPrefOld[$oldName]);
        }

        // only elements left should be the gui_columns that have serialized array values
        foreach ($this->aPrefOld AS $oldName => $val)
        {
            $newName = substr($oldName,1);
            $aVal = unserialize($val);
            if (is_array($aVal))
            {
                $this->aPrefMap[$newName]            = array('value'=>$aVal['show'],'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
                $this->aPrefMap[$newName.'_label']   = array('value'=>$aVal['label'],'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
                $this->aPrefMap[$newName.'_rank']    = array('value'=>$aVal['rank'],'name'=>$oldName,'level'=>OA_ACCOUNT_MANAGER);
            }
        }
        return true;
    }

    function _filterOutDeprecatedPreferencesAdmin()
    {
        foreach ($this->aPrefDep as $name)
        {
            unset($this->aPrefOld[$name]);
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