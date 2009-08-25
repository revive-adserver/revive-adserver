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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * An entity class used to represent zones for the MPE.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Demain Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class OX_Maintenance_Priority_Zone
{

    var $id;
    var $availableImpressions = 0;
    var $averageImpressions   = 0;
    var $aAdverts             = array();
    var $aOperationIntId      = array();

    /**
     * The constructor method.
     *
     * @param array $aZone associative array of values to be assigned to
     *              object, array keys reflect database field names
     */
    function OX_Maintenance_Priority_Zone($aZone = array())
    {
        $this->id = (int)$aZone['zoneid'];
    }

    /**
     * A method to add Advert objects to the Zone.
     *
     * @param Advert $oAdvert The Advert object to add.
     * @return void
     */
    function addAdvert($oAdvert)
    {
        $this->aAdverts[$oAdvert->id] = $oAdvert;
    }

}

?>