<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once MAX_PATH . '/etc/changes/UserMigration.php';

class Migration_546 extends Migration
{

    function Migration_546()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveTable__preference';
		$this->aTaskList_destructive[] = 'afterRemoveTable__preference';
    }



	function beforeRemoveTable__preference()
	{
		return $this->migratePreferences() && $this->beforeRemoveTable('preference');
	}

	function afterRemoveTable__preference()
	{
		return $this->afterRemoveTable('preference');
	}



	function migratePreferences()
	{
	    // Migrate old preference table values to new preferences table

        // Migrate old preference table values to config file


	    // Migrate language from affiliates

	    // preferences.language = preference.language


	    // Migrate language/logout_url from agency


	    // Migrate language from clients


	    // Migrate timezone (is it needed?)

	    // preferences.timezone = ['timezone'] location



	    $aConf = & $GLOBALS['_MAX']['CONF'];
	    $tblPrefsOld = $this->oDBH->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['preference'],true);

	    $query = "SELECT *
	               FROM {$tblPrefsOld}
	               WHERE agencyid = 0";
	    $aResult = $this->oDBH->queryAll($query);

	    if (PEAR::isError($aResult))
	    {
	        // log error
	        return false;
	    }
	    if (!isset($aResult[0]))
	    {
	        // log error
	        return false;
	    }

        $aPrefOld = $aResult[0];

        unset($aPrefOld['agencyid']);
        unset($aPrefOld['config_version']);
        $aConfNew['ui']['headerFilePath']	 =	$aPrefOld['my_header']; unset($aPrefOld['my_header']);
        $aConfNew['ui']['footerFilePath']	 =	$aPrefOld['my_footer']; unset($aPrefOld['my_footer']);
        $aConfNew['ui']['logoFilePath']	 =	$aPrefOld['my_logo']; unset($aPrefOld['my_logo']);
        $aPrefNew['language']	         =	$aPrefOld['language']; unset($aPrefOld['language']);
        $aConfNew['ui']['applicationName']	 =	$aPrefOld['name']; unset($aPrefOld['name']);
        unset($aPrefOld['company_name']);
        unset($aPrefOld['override_gd_imageformat']);
        $aPrefNew['ui_week_start_day']	 =	$aPrefOld['begin_of_week']; unset($aPrefOld['begin_of_week']);
        $aPrefNew['ui_percentage_decimals']	 =	$aPrefOld['percentage_decimals']; unset($aPrefOld['percentage_decimals']);
        $aConfNew['allowedBanners']['sql']	 =	$aPrefOld['type_sql_allow']; unset($aPrefOld['type_sql_allow']);
        $aConfNew['allowedBanners']['url']	 =	$aPrefOld['type_url_allow']; unset($aPrefOld['type_url_allow']);
        $aConfNew['allowedBanners']['web']	 =	$aPrefOld['type_web_allow']; unset($aPrefOld['type_web_allow']);
        $aConfNew['allowedBanners']['html']	 =	$aPrefOld['type_html_allow']; unset($aPrefOld['type_html_allow']);
        $aConfNew['allowedBanners']['txt']	 =	$aPrefOld['type_txt_allow']; unset($aPrefOld['type_txt_allow']);
        unset($aPrefOld['banner_html_auto']);
        $aUsers['username']	 =	$aPrefOld['admin']; unset($aPrefOld['admin']);
        $aUsers['password']	 =	$aPrefOld['admin_pw']; unset($aPrefOld['admin_pw']);
        $aUsers['contact_name']	 =	$aPrefOld['admin_fullname']; unset($aPrefOld['admin_fullname']);
        $aUsers['email_address']	 =	$aPrefOld['admin_email']; unset($aPrefOld['admin_email']);
        $aPrefNew['warn_admin']	 =	$aPrefOld['warn_admin']; unset($aPrefOld['warn_admin']);
        $aPrefNew['warn_email_manager']	 =	$aPrefOld['warn_agency']; unset($aPrefOld['warn_agency']);
        $aPrefNew['warn_email_advertiser']	 =	$aPrefOld['warn_client']; unset($aPrefOld['warn_client']);
        $aPrefNew['warn_email_admin_impression_limit']	 =	$aPrefOld['warn_limit']; unset($aPrefOld['warn_limit']);
        $aConfNew['email']['headers']	 =	$aPrefOld['admin_email_headers']; unset($aPrefOld['admin_email_headers']);
        $aPrefNew['ui_novice_user']	 =	$aPrefOld['admin_novice']; unset($aPrefOld['admin_novice']);
        $aPrefNew['default_banner_weight']	 =	$aPrefOld['default_banner_weight']; unset($aPrefOld['default_banner_weight']);
        $aPrefNew['default_campaign_weight']	 =	$aPrefOld['default_campaign_weight']; unset($aPrefOld['default_campaign_weight']);
        $aPrefNew['default_banner_image_url']	 =	$aPrefOld['default_banner_url']; unset($aPrefOld['default_banner_url']);
        $aPrefNew['default_banner_destination_url']	 =	$aPrefOld['default_banner_destination']; unset($aPrefOld['default_banner_destination']);
        unset($aPrefOld['client_welcome']);
        unset($aPrefOld['client_welcome_msg']);
        unset($aPrefOld['publisher_welcome']);
        unset($aPrefOld['publisher_welcome_msg']);
        $aConfNew['ui']['gzipCompression']	 =	$aPrefOld['content_gzip_compression']; unset($aPrefOld['content_gzip_compression']);
        $aConfNew['email']['logOutgoing']	 =	$aPrefOld['userlog_email']; unset($aPrefOld['userlog_email']);
        $aPrefNew['ui_show_campaign_info']	 =	$aPrefOld['gui_show_campaign_info']; unset($aPrefOld['gui_show_campaign_info']);
        $aPrefNew['ui_show_campaign_preview']	 =	$aPrefOld['gui_show_campaign_preview']; unset($aPrefOld['gui_show_campaign_preview']);
        unset($aPrefOld['gui_campaign_anonymous']);
        $aPrefNew['ui_show_banner_info']	 =	$aPrefOld['gui_show_banner_info']; unset($aPrefOld['gui_show_banner_info']);
        $aPrefNew['ui_show_banner_preview']	 =	$aPrefOld['gui_show_banner_preview']; unset($aPrefOld['gui_show_banner_preview']);
        $aPrefNew['ui_show_banner_html']	 =	$aPrefOld['gui_show_banner_html']; unset($aPrefOld['gui_show_banner_html']);
        $aPrefNew['ui_show_matching_banners']	 =	$aPrefOld['gui_show_matching']; unset($aPrefOld['gui_show_matching']);
        $aPrefNew['ui_show_matching_banners_parents']	 =	$aPrefOld['gui_show_parents']; unset($aPrefOld['gui_show_parents']);
        $aPrefNew['ui_hide_inactive']	 =	$aPrefOld['gui_hide_inactive']; unset($aPrefOld['gui_hide_inactive']);
        unset($aPrefOld['gui_link_compact_limit']);
        $aConfNew['ui']['headerBackgroundColor']	 =	$aPrefOld['gui_header_background_color']; unset($aPrefOld['gui_header_background_color']);
        $aConfNew['ui']['headerForegroundColor']	 =	$aPrefOld['gui_header_foreground_color']; unset($aPrefOld['gui_header_foreground_color']);
        $aConfNew['ui']['headerActiveTabColor']	 =	$aPrefOld['gui_header_active_tab_color']; unset($aPrefOld['gui_header_active_tab_color']);
        $aConfNew['ui']['headerTextColor']	 =	$aPrefOld['gui_header_text_color']; unset($aPrefOld['gui_header_text_color']);
        $aConfNew['delivery']['clicktracking']	 =	$aPrefOld['gui_invocation_3rdparty_default']; unset($aPrefOld['gui_invocation_3rdparty_default']);
        $aConfNew['email']['qmailPatch']	 =	$aPrefOld['qmail_patch']; unset($aPrefOld['qmail_patch']);
        $aConfNew['sync']['checkForUpdates']	 =	$aPrefOld['updates_enabled']; unset($aPrefOld['updates_enabled']);
        unset($aPrefOld['updates_cache']);
        unset($aPrefOld['updates_timestamp']);
        unset($aPrefOld['updates_last_seen']);
        $aConfNew['allowedTags']['adview']	 =	$aPrefOld['allow_invocation_plain']; unset($aPrefOld['allow_invocation_plain']);
        $aConfNew['allowedTags']['adviewnocookies']	 =	$aPrefOld['allow_invocation_plain_nocookies']; unset($aPrefOld['allow_invocation_plain_nocookies']);
        $aConfNew['allowedTags']['adjs']	 =	$aPrefOld['allow_invocation_js']; unset($aPrefOld['allow_invocation_js']);
        $aConfNew['allowedTags']['adframe']	 =	$aPrefOld['allow_invocation_frame']; unset($aPrefOld['allow_invocation_frame']);
        $aConfNew['allowedTags']['xmlrpc']	 =	$aPrefOld['allow_invocation_xmlrpc']; unset($aPrefOld['allow_invocation_xmlrpc']);
        $aConfNew['allowedTags']['local']	 =	$aPrefOld['allow_invocation_local']; unset($aPrefOld['allow_invocation_local']);
        $aConfNew['allowedTags']['adlayer']	 =	$aPrefOld['allow_invocation_interstitial']; unset($aPrefOld['allow_invocation_interstitial']);
        $aConfNew['allowedTags']['popup']	 =	$aPrefOld['allow_invocation_popup']; unset($aPrefOld['allow_invocation_popup']);
        unset($aPrefOld['allow_invocation_clickonly']);
        unset($aPrefOld['auto_clean_tables']);
        unset($aPrefOld['auto_clean_tables_interval']);
        unset($aPrefOld['auto_clean_userlog']);
        unset($aPrefOld['auto_clean_userlog_interval']);
        unset($aPrefOld['auto_clean_tables_vacuum']);
        unset($aPrefOld['autotarget_factor']);
        unset($aPrefOld['maintenance_timestamp']);
        unset($aPrefOld['compact_stats']);
        unset($aPrefOld['statslastday']);
        unset($aPrefOld['statslasthour']);
        $aPrefNew['tracker_default_status']	 =	$aPrefOld['default_tracker_status']; unset($aPrefOld['default_tracker_status']);
        $aPrefNew['tracker_default_type']	 =	$aPrefOld['default_tracker_type']; unset($aPrefOld['default_tracker_type']);
        $aPrefNew['tracker_link_campaigns']	 =	$aPrefOld['default_tracker_linkcampaigns']; unset($aPrefOld['default_tracker_linkcampaigns']);
        unset($aPrefOld['publisher_agreement']);
        unset($aPrefOld['publisher_agreement_text']);
        unset($aPrefOld['publisher_payment_modes']);
        unset($aPrefOld['publisher_currencies']);
        unset($aPrefOld['publisher_categories']);
        unset($aPrefOld['publisher_help_files']);
        unset($aPrefOld['publisher_default_tax_id']);
        unset($aPrefOld['publisher_default_approved']);
        unset($aPrefOld['more_reports']);
        unset($aPrefOld['maintenance_cron_timestamp']);
        $aPrefNew['warn_email_admin_day_limit']	 =	$aPrefOld['warn_limit_days']; unset($aPrefOld['warn_limit_days']);

        foreach ($aPrefOld AS $key => $val)
        {
            $name = substr($key,1);
            $aPrefNew[$name]            = 't';
            $aPrefNew[$name.'_label']   = '';
            $aPrefNew[$name.'_rank']	= 0;

            $aVal = unserialize($val);
            if (is_array($aVal))
            {
                $aPrefNew[$name]            = $aVal['show'];
                $aPrefNew[$name.'_label']   = $aVal['label'];
                $aPrefNew[$name.'_rank']	= $aVal['rank'];
            }
        }
	    return true;
	}


}

?>