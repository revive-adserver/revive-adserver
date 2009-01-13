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
 * Table Definition for userlog
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Userlog extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'userlog';                         // table name
    public $userlogid;                       // MEDIUMINT(9) => openads_mediumint => 129 
    public $timestamp;                       // INT(11) => openads_int => 129 
    public $usertype;                        // TINYINT(4) => openads_tinyint => 129 
    public $userid;                          // MEDIUMINT(9) => openads_mediumint => 129 
    public $action;                          // MEDIUMINT(9) => openads_mediumint => 129 
    public $object;                          // MEDIUMINT(9) => openads_mediumint => 1 
    public $details;                         // MEDIUMTEXT() => openads_mediumtext => 34 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Userlog',$k,$v); }

    var $defaultValues = array(
                'timestamp' => 0,
                'usertype' => 0,
                'userid' => 0,
                'action' => 0,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>