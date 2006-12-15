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
$Id: ChannelTargetTwoAds_nohistory.php 6300 2006-12-14 11:15:05Z monique.szpak@m3.net $
*/

require_once MAX_PATH . '/simulation/SimulationScenario.php';

/**
 * A class for simulating maintenance/delivery scenarios
 *
 * @package
 * @subpackage
 * @author
 */
class ChannelTargetTwoAds_nohistory extends SimulationScenario
{

    /**
     * The constructor method.
     */
    function ChannelTargetTwoAds_nohistory()
    {
        $this->init("v03.30-alpha_ChannelTarget_2ads");
    }

    function run()
    {
        $this->newTables();
        $this->loadDataset();

        $this->printPrecis();

        for($i=1;$i<=$this->scenarioConfig['iterations'];$i++)
        {
            $this->makeRequests($i);
            $this->runPriority();
        }
        $this->printPostSummary();
        $this->printSummaryData();
    }

}

?>