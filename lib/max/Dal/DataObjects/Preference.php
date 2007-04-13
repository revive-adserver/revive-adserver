<?php
/**
 * Table Definition for preference
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Preference extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'preference';                      // table name
    public $agencyid;                        // int(9)  not_null primary_key
    public $config_version;                  // real(9)  not_null
    public $my_header;                       // string(255)  
    public $my_footer;                       // string(255)  
    public $my_logo;                         // string(255)  
    public $language;                        // string(32)  
    public $name;                            // string(32)  
    public $company_name;                    // string(255)  
    public $override_gd_imageformat;         // string(4)  
    public $begin_of_week;                   // int(2)  
    public $percentage_decimals;             // int(2)  
    public $type_sql_allow;                  // string(1)  enum
    public $type_url_allow;                  // string(1)  enum
    public $type_web_allow;                  // string(1)  enum
    public $type_html_allow;                 // string(1)  enum
    public $type_txt_allow;                  // string(1)  enum
    public $banner_html_auto;                // string(1)  enum
    public $admin;                           // string(64)  
    public $admin_pw;                        // string(64)  
    public $admin_fullname;                  // string(255)  
    public $admin_email;                     // string(64)  
    public $warn_admin;                      // string(1)  enum
    public $warn_agency;                     // string(1)  enum
    public $warn_client;                     // string(1)  enum
    public $warn_limit;                      // int(9)  not_null
    public $admin_email_headers;             // string(64)  
    public $admin_novice;                    // string(1)  enum
    public $default_banner_weight;           // int(4)  
    public $default_campaign_weight;         // int(4)  
    public $default_banner_url;              // string(255)  
    public $default_banner_destination;      // string(255)  
    public $client_welcome;                  // string(1)  enum
    public $client_welcome_msg;              // blob(65535)  blob
    public $publisher_welcome;               // string(1)  enum
    public $publisher_welcome_msg;           // blob(65535)  blob
    public $content_gzip_compression;        // string(1)  enum
    public $userlog_email;                   // string(1)  enum
    public $gui_show_campaign_info;          // string(1)  enum
    public $gui_show_campaign_preview;       // string(1)  enum
    public $gui_campaign_anonymous;          // string(1)  enum
    public $gui_show_banner_info;            // string(1)  enum
    public $gui_show_banner_preview;         // string(1)  enum
    public $gui_show_banner_html;            // string(1)  enum
    public $gui_show_matching;               // string(1)  enum
    public $gui_show_parents;                // string(1)  enum
    public $gui_hide_inactive;               // string(1)  enum
    public $gui_link_compact_limit;          // int(11)  
    public $gui_header_background_color;     // string(7)  
    public $gui_header_foreground_color;     // string(7)  
    public $gui_header_active_tab_color;     // string(7)  
    public $gui_header_text_color;           // string(7)  
    public $gui_invocation_3rdparty_default;    // int(6)  
    public $qmail_patch;                     // string(1)  enum
    public $updates_enabled;                 // string(1)  enum
    public $updates_cache;                   // blob(65535)  blob
    public $updates_timestamp;               // int(11)  
    public $updates_last_seen;               // real(9)  
    public $allow_invocation_plain;          // string(1)  enum
    public $allow_invocation_plain_nocookies;    // string(1)  enum
    public $allow_invocation_js;             // string(1)  enum
    public $allow_invocation_frame;          // string(1)  enum
    public $allow_invocation_xmlrpc;         // string(1)  enum
    public $allow_invocation_local;          // string(1)  enum
    public $allow_invocation_interstitial;    // string(1)  enum
    public $allow_invocation_popup;          // string(1)  enum
    public $allow_invocation_clickonly;      // string(1)  enum
    public $auto_clean_tables;               // string(1)  enum
    public $auto_clean_tables_interval;      // int(2)  
    public $auto_clean_userlog;              // string(1)  enum
    public $auto_clean_userlog_interval;     // int(2)  
    public $auto_clean_tables_vacuum;        // string(1)  enum
    public $autotarget_factor;               // real(12)  
    public $maintenance_timestamp;           // int(11)  
    public $compact_stats;                   // string(1)  enum
    public $statslastday;                    // date(10)  not_null binary
    public $statslasthour;                   // int(4)  not_null
    public $default_tracker_status;          // int(4)  not_null
    public $default_tracker_type;            // int(10)  unsigned
    public $default_tracker_linkcampaigns;    // string(1)  not_null enum
    public $publisher_agreement;             // string(1)  enum
    public $publisher_agreement_text;        // blob(65535)  blob
    public $publisher_payment_modes;         // blob(65535)  blob
    public $publisher_currencies;            // blob(65535)  blob
    public $publisher_categories;            // blob(65535)  blob
    public $publisher_help_files;            // blob(65535)  blob
    public $publisher_default_tax_id;        // string(1)  enum
    public $publisher_default_approved;      // string(1)  enum
    public $more_reports;                    // string(1)  
    public $gui_column_id;                   // blob(65535)  blob
    public $gui_column_requests;             // blob(65535)  blob
    public $gui_column_impressions;          // blob(65535)  blob
    public $gui_column_clicks;               // blob(65535)  blob
    public $gui_column_ctr;                  // blob(65535)  blob
    public $gui_column_conversions;          // blob(65535)  blob
    public $gui_column_conversions_pending;    // blob(65535)  blob
    public $gui_column_sr_views;             // blob(65535)  blob
    public $gui_column_sr_clicks;            // blob(65535)  blob
    public $gui_column_revenue;              // blob(65535)  blob
    public $gui_column_cost;                 // blob(65535)  blob
    public $gui_column_bv;                   // blob(65535)  blob
    public $gui_column_num_items;            // blob(65535)  blob
    public $gui_column_revcpc;               // blob(65535)  blob
    public $gui_column_costcpc;              // blob(65535)  blob
    public $gui_column_technology_cost;      // blob(65535)  blob
    public $gui_column_income;               // blob(65535)  blob
    public $gui_column_income_margin;        // blob(65535)  blob
    public $gui_column_profit;               // blob(65535)  blob
    public $gui_column_margin;               // blob(65535)  blob
    public $gui_column_erpm;                 // blob(65535)  blob
    public $gui_column_erpc;                 // blob(65535)  blob
    public $gui_column_erps;                 // blob(65535)  blob
    public $gui_column_eipm;                 // blob(65535)  blob
    public $gui_column_eipc;                 // blob(65535)  blob
    public $gui_column_eips;                 // blob(65535)  blob
    public $gui_column_ecpm;                 // blob(65535)  blob
    public $gui_column_ecpc;                 // blob(65535)  blob
    public $gui_column_ecps;                 // blob(65535)  blob
    public $gui_column_epps;                 // blob(65535)  blob
    public $instance_id;                     // string(64)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preference',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    function sequenceKey() {
        return array(false, false, false);
    }
}
