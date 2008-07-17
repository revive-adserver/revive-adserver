<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * Table Definition for plugins_channel_delivery_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Plugins_channel_delivery_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'plugins_channel_delivery_assoc';    // table name
    public $rule_id;                         // INT(10) => openads_int => 129 
    public $domain_id;                       // INT(10) => openads_int => 129 
    public $rule_order;                      // TINYINT(4) => openads_tinyint => 129 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Plugins_channel_delivery_assoc',$k,$v); }

    var $defaultValues = array(
                'rule_id' => 0,
                'domain_id' => 0,
                'rule_order' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

/**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    function sequenceKey() {
        return array(false, false, false);
    }

?>