<?php
/**
 * Table Definition for banners
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Banners extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'banners';                         // table name
    public $bannerid;                        // MEDIUMINT(9) => openads_mediumint => 129 
    public $campaignid;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $contenttype;                     // ENUM('gif','jpeg','png','html','swf','dcr','rpm','mov','txt') => openads_enum => 130 
    public $pluginversion;                   // MEDIUMINT(9) => openads_mediumint => 129 
    public $storagetype;                     // ENUM('sql','web','url','html','network','txt') => openads_enum => 130 
    public $filename;                        // VARCHAR(255) => openads_varchar => 130 
    public $imageurl;                        // VARCHAR(255) => openads_varchar => 130 
    public $htmltemplate;                    // TEXT() => openads_text => 162 
    public $htmlcache;                       // TEXT() => openads_text => 162 
    public $width;                           // SMALLINT(6) => openads_smallint => 129 
    public $height;                          // SMALLINT(6) => openads_smallint => 129 
    public $weight;                          // TINYINT(4) => openads_tinyint => 129 
    public $seq;                             // TINYINT(4) => openads_tinyint => 129 
    public $target;                          // VARCHAR(16) => openads_varchar => 130 
    public $url;                             // TEXT() => openads_text => 162 
    public $alt;                             // VARCHAR(255) => openads_varchar => 130 
    public $statustext;                      // VARCHAR(255) => openads_varchar => 130 
    public $bannertext;                      // TEXT() => openads_text => 162 
    public $description;                     // VARCHAR(255) => openads_varchar => 130 
    public $adserver;                        // VARCHAR(50) => openads_varchar => 130 
    public $block;                           // INT(11) => openads_int => 129 
    public $capping;                         // INT(11) => openads_int => 129 
    public $session_capping;                 // INT(11) => openads_int => 129 
    public $compiledlimitation;              // TEXT() => openads_text => 162 
    public $acl_plugins;                     // TEXT() => openads_text => 34 
    public $append;                          // TEXT() => openads_text => 162 
    public $appendtype;                      // TINYINT(4) => openads_tinyint => 129 
    public $bannertype;                      // TINYINT(4) => openads_tinyint => 129 
    public $alt_filename;                    // VARCHAR(255) => openads_varchar => 130 
    public $alt_imageurl;                    // VARCHAR(255) => openads_varchar => 130 
    public $alt_contenttype;                 // ENUM('gif','jpeg','png') => openads_enum => 130 
    public $comments;                        // TEXT() => openads_text => 34 
    public $updated;                         // DATETIME() => openads_datetime => 142 
    public $acls_updated;                    // DATETIME() => openads_datetime => 142 
    public $keyword;                         // VARCHAR(255) => openads_varchar => 130 
    public $transparent;                     // TINYINT(1) => openads_tinyint => 145 
    public $parameters;                      // TEXT() => openads_text => 34 
    public $an_banner_id;                    // INT(11) => openads_int => 1 
    public $as_banner_id;                    // INT(11) => openads_int => 1 
    public $status;                          // INT(11) => openads_int => 129 
    public $ad_direct_status;                // TINYINT(4) => openads_tinyint => 129 
    public $ad_direct_rejection_reason_id;    // TINYINT(4) => openads_tinyint => 129 
    public $ext_bannertype;                  // VARCHAR(255) => openads_varchar => 2 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Banners',$k,$v); }

    var $defaultValues = array(
                'campaignid' => 0,
                'contenttype' => 'gif',
                'pluginversion' => 0,
                'storagetype' => 'sql',
                'filename' => '',
                'imageurl' => '',
                'htmltemplate' => '',
                'htmlcache' => '',
                'width' => 0,
                'height' => 0,
                'weight' => 1,
                'seq' => 0,
                'target' => '',
                'url' => '',
                'alt' => '',
                'statustext' => '',
                'bannertext' => '',
                'description' => '',
                'adserver' => '',
                'block' => 0,
                'capping' => 0,
                'session_capping' => 0,
                'compiledlimitation' => '',
                'append' => '',
                'appendtype' => 0,
                'bannertype' => 0,
                'alt_filename' => '',
                'alt_imageurl' => '',
                'alt_contenttype' => 'gif',
                'updated' => '%DATE_TIME%',
                'acls_updated' => '%NO_DATE_TIME%',
                'keyword' => '',
                'transparent' => 0,
                'status' => 0,
                'ad_direct_status' => 0,
                'ad_direct_rejection_reason_id' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>