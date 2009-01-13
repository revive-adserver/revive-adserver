<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * Table Definition for tracker_append
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Tracker_append extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'tracker_append';                  // table name
    public $tracker_append_id;               // INT(11) => openads_int => 129 
    public $tracker_id;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $rank;                            // INT(11) => openads_int => 129 
    public $tagcode;                         // TEXT() => openads_text => 162 
    public $paused;                          // ENUM('t','f') => openads_enum => 130 
    public $autotrack;                       // ENUM('t','f') => openads_enum => 130 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Tracker_append',$k,$v); }

    var $defaultValues = array(
                'tracker_id' => 0,
                'rank' => 0,
                'tagcode' => '',
                'paused' => 'f',
                'autotrack' => 'f',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>