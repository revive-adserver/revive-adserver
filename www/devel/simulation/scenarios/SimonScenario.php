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

require_once MAX_PATH . '/simulation/SimulationScenario.php';

/**
 * A class for simulating maintenance/delivery scenarios
 *
 * @package
 * @subpackage
 */
class SimonScenario extends SimulationScenario
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        $this->init("SimonScenario");
    }

    function run()
    {
        $this->newTables();
        $this->loadDataset('SimonScenario');
        $this->printPrecis();
        for($i=1;$i<=$this->scenarioConfig['iterations'];$i++)
        {
            $this->printHeading('Started iteration: '. $i, 3);
            $this->runPriority();
            $this->makeRequests($i);
            $this->printHeading('Ended iteration: '. $i, 3);
        }
        $this->runMaintenance();
        $this->printPostSummary();
        $this->printSummaryData();
    }

}

?>