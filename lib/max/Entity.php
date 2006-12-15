<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: Entities.php 5678 2006-10-11 16:52:44Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';

/**
 * An abstract entity class for all other entity classes to inherit from.
 *
 * @abstract
 * @package    MaxEntity
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Entity
{

    /**
     * A private method to abort script execution when an attempt is made
     * to instantiate the entity with incorrect parameters.
     *
     * @access private
     */
    function _abort()
    {
            $error = 'Unable to instantiate ' . __CLASS__ . ' object, aborting execution.';
            MAX::debug($error, PEAR_LOG_EMERG);
            exit();
    }

}

?>
