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
 */
class OX_Maintenance_Priority_Zone
{
    public $id;
    public $active = true;
    public $availableImpressions = 0;
    public $averageImpressions = 0;
    public $aAdverts = [];
    public $aOperationIntId = [];

    /**
     * The constructor method.
     *
     * @param array $aZone associative array of values to be assigned to
     *              object, array keys reflect database field names
     */
    public function __construct($aZone = [])
    {
        $this->id = (int)$aZone['zoneid'];
    }

    /**
     * A method to add Advert objects to the Zone.
     *
     * @param Advert $oAdvert The Advert object to add.
     * @return void
     */
    public function addAdvert($oAdvert)
    {
        $this->aAdverts[$oAdvert->id] = $oAdvert;
    }
}
