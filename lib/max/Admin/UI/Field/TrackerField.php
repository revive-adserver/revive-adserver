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
$Id: TrackerField.php 4568 2006-04-04 12:40:13Z roh@m3.net $
*/

require_once MAX_PATH . '/lib/max/Dal/Reporting.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';


class Admin_UI_TrackerField extends Admin_UI_Field
{
    function display()
    {
        $dal = new MAX_Dal_Reporting();

        echo "
        <select name='{$this->_name}' tabindex='".($this->_tabIndex++)."'>";

        $aTrackers = $dal->phpAds_getTrackerArray();
        foreach ($aTrackers as $trackerId => $aTracker) {
            echo "
            <option value='$trackerId'>$aTracker</option>";
        }
        echo "
        </select>";
    }
}

?>
