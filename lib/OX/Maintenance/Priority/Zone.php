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
    var $active               = true;
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
