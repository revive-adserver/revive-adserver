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

require_once MAX_PATH . '/lib/OA/Central/M2M.php';


/**
 * OAP binding to the dashboard OAC API
 *
 */
class OA_Central_Dashboard extends OA_Central_M2M
{
    /**
     * A method to retrieve the data needed to draw the Community Statistics
     * graph widget
     *
     * @return mixed
     */
    function getCommunityStats()
    {
        $aResult = $this->oMapper->getCommunityStats();

        if (PEAR::isError($aResult)) {
            return false;
        }

        $aStats = array(
            0 => array_slice($aResult['impressions'], 0, 7),
            1 => array_slice($aResult['clicks'], 0, 7)
        );

        return $aStats;
    }
}

?>
