<?php
/**
 * Table Definition for banner_vast_element
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Banner_vast_element extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'banner_vast_element';             // table name
    public $banner_vast_element_id;          // MEDIUMINT(9) => openads_mediumint => 129 
    public $banner_id;                       // MEDIUMINT(9) => openads_mediumint => 129 
    public $vast_element_type;               // VARCHAR(16) => openads_varchar => 130 
    public $vast_video_id;                   // VARCHAR(100) => openads_varchar => 2 
    public $vast_video_duration;             // MEDIUMINT(9) => openads_mediumint => 1 
    public $vast_video_delivery;             // VARCHAR(20) => openads_varchar => 2 
    public $vast_video_type;                 // VARCHAR(20) => openads_varchar => 2 
    public $vast_video_bitrate;              // VARCHAR(20) => openads_varchar => 2 
    public $vast_video_height;               // MEDIUMINT(9) => openads_mediumint => 1 
    public $vast_video_width;                // MEDIUMINT(9) => openads_mediumint => 1 
    public $vast_video_outgoing_filename;    // TEXT() => openads_text => 34 
    public $vast_companion_banner_id;        // MEDIUMINT(9) => openads_mediumint => 1 
    public $vast_overlay_height;             // MEDIUMINT(9) => openads_mediumint => 1 
    public $vast_overlay_width;              // MEDIUMINT(9) => openads_mediumint => 1 
    public $vast_video_clickthrough_url;     // TEXT() => openads_text => 34 
    public $vast_overlay_action;             // VARCHAR(20) => openads_varchar => 2 
    public $vast_overlay_format;             // VARCHAR(20) => openads_varchar => 2 
    public $vast_overlay_text_title;         // TEXT() => openads_text => 34 
    public $vast_overlay_text_description;    // TEXT() => openads_text => 34 
    public $vast_overlay_text_call;          // TEXT() => openads_text => 34 
    public $vast_creative_type;              // VARCHAR(20) => openads_varchar => 2 
    public $vast_thirdparty_impression;      // TEXT() => openads_text => 162 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Banner_vast_element',$k,$v); }

    var $defaultValues = array(
                'vast_element_type' => '',
                'vast_thirdparty_impression' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>