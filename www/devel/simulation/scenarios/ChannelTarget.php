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

require_once SIM_PATH . 'SimulationScenario.php';

/**
 * A class for simulating maintenance/delivery scenarios
 *
 * @package
 * @subpackage
 */
class ChannelTarget extends SimulationScenario
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        $this->init("ChannelTarget");
    }

    function run()
    {
        $this->newTables();
        $this->loadDataset('ChannelTarget.xml');
        $this->printPrecis();

        for($i=1;$i<=$this->scenarioConfig['iterations'];$i++)
        {
            // MAX_checkSite_Pageurl uses $GLOBALS['loc'] instead of source
            // therefore I had to bodge the scenario class to set the $GLOBAL
            // really not sure if this is correct anymore!!
            if ($i==1)
            {
                // all requests in first iteration will fail to be delivered
                $GLOBALS['loc'] = 'www.nowhere.com';
            }
            else
            {
                // all requests after first iteration will be delivered
                $GLOBALS['loc'] = 'www.example.com';
            }
            $this->makeRequests($i);
            $this->runPriority();
            //$this->runMaintenance();
        }
        $this->printPostSummary();
        $this->printSummaryData();
    }
}

?>