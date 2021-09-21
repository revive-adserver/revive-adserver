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

/**
 * Table Definition for acls_channel
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Acls_channel extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'acls_channel';                    // table name
    public $channelid;                       // MEDIUMINT(9) => openads_mediumint => 129
    public $logical;                         // VARCHAR(3) => openads_varchar => 130
    public $type;                            // VARCHAR(255) => openads_varchar => 130
    public $comparison;                      // CHAR(2) => openads_char => 130
    public $data;                            // TEXT() => openads_text => 162
    public $executionorder;                  // INT(10) => openads_int => 129

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Acls_channel', $k, $v);
    }

    public $defaultValues = [
        'channelid' => 0,
        'logical' => 'and',
        'type' => '',
        'comparison' => '==',
        'data' => '',
        'executionorder' => 0,
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

    /**
     * Duplicate a channels acls
     *
     * @param int $origChannelId    channel id of acls to copy
     * @param int $newChannelId     channel id to assign copy of original
     *                              channel acls
     * @return boolean              true on success or if no acls exist else
     *                              false  is returned
     */
    public function duplicate($origChannelId, $newChannelId)
    {
        $this->channelid = $origChannelId;
        if ($this->find()) {
            while ($this->fetch()) {
                //  copy the current acl, change the channel id, and insert
                $oNewChannelAcl = clone($this);
                $oNewChannelAcl->channelid = $newChannelId;
                $result = $oNewChannelAcl->insert();

                if (PEAR::isError($result)) {
                    return false;
                }
            }
        }
        return true;
    }
}
