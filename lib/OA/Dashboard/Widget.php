<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * The base class to implement a dashboard widget
 *
 */
class OA_Dashboard_Widget
{
    /**
     * The user permissions mask, defaults to admin + agencies + publishers
     *
     * @var int
     */
    var $accessList;

    /**
     * The class constructor
     *
     * @return OA_Dashboard_Widget
     */
    function OA_Dashboard_Widget()
    {
        $this->checkAccess();
    }

    /**
     * A method to check for permissions to display the widget
     *
     */
    function checkAccess()
    {
        if (is_null($this->accessList)) {
            $this->accessList = phpAds_Admin|phpAds_Agency|phpAds_Affiliate;
        }

        MAX_Permission::checkAccess($this->accessList);
    }

    /**
     * A method to launch and display the widget
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     */
    function display($aParams)
    {
    }
}

?>