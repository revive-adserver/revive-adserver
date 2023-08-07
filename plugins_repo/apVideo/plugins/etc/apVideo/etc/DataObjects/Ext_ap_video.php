<?php
/**
 * Table Definition for ext_ap_video
 */
require_once MAX_PATH . '/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Ext_ap_video extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ext_ap_video';                    // table name
    public $ad_id;                           // MEDIUMINT(9) => openads_mediumint => 129
    public $alt_media;                       // TEXT() => openads_text => 162
    public $impression_trackers;             // TEXT() => openads_text => 162

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Ext_ap_video', $k, $v);
    }

    public $defaultValues = [
                'alt_media' => '',
                'impression_trackers' => '',
                ];

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    public function sequenceKey()
    {
        return [false, false, false];
    }
}
