<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_546 extends Migration
{

    var $aPrefOld = array();
    var $aPrefNew = array();
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
                        'language'                          => 'language',
                        'ui_week_start_day'                 => 'begin_of_week',
                        'ui_percentage_decimals'            => 'percentage_decimals',
                        'warn_admin'                        => 'warn_admin',
                        'warn_email_manager'                => 'warn_agency',
                        'warn_email_advertiser'             => 'warn_client',
                        'warn_email_admin_impression_limit' => 'warn_limit',
                        'warn_email_admin_day_limit'        => 'warn_limit_days',
                        'ui_novice_user'                    => 'admin_novice',
                        'default_banner_weight'             => 'default_banner_weight',
                        'default_campaign_weight'           => 'default_campaign_weight',
                        'default_banner_image_url'          => 'default_banner_url',
                        'default_banner_destination_url'    => 'default_banner_destination',
                        'ui_show_campaign_info'             => 'gui_show_campaign_info',
                        'ui_show_campaign_preview'          => 'gui_show_campaign_preview',
                        'ui_show_banner_info'               => 'gui_show_banner_info',
                        'ui_show_banner_preview'            => 'gui_show_banner_preview',
                        'ui_show_banner_html'               => 'gui_show_banner_html',
                        'ui_show_matching_banners'          => 'gui_show_matching',
                        'ui_show_matching_banners_parents'  => 'gui_show_parents',
                        'ui_hide_inactive'                  => 'gui_hide_inactive',
                        'tracker_default_status'            => 'default_tracker_status',
                        'tracker_default_type'              => 'default_tracker_type',
                        'tracker_link_campaigns'            => 'default_tracker_linkcampaigns',
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
    	               ('%s','ADMIN')";

	    $queryAssoc = "INSERT INTO
    	               {$tblAccPrefs}
    	               (account_id, preference_id, value)
    	               VALUES
    	               (%s,%s,'%s')";

        foreach ($this->aPrefNew as $key => $val)
        {
            $queryP = sprintf($queryPref, $key, $name);

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

            $queryA = sprintf($queryAssoc, $accountId, $prefId, $val);

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

        foreach ($this->aPrefMap AS $newName => $oldName)
        {
            $this->aPrefNew[$newName] = $this->aPrefOld[$oldName];
            unset($this->aPrefOld[$oldName]);
        }

        // only elements left should be the gui_columns that have serialized array values
        foreach ($this->aPrefOld AS $key => $val)
        {
            $name = substr($key,1);
            $this->aPrefNew[$name]            = 't';
            $this->aPrefNew[$name.'_label']   = '';
            $this->aPrefNew[$name.'_rank']    = 0;

            $aVal = unserialize($val);
            if (is_array($aVal))
            {
                $this->aPrefNew[$name]            = $aVal['show'];
                $this->aPrefNew[$name.'_label']   = $aVal['label'];
                $this->aPrefNew[$name.'_rank']    = $aVal['rank'];
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