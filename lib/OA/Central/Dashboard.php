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
