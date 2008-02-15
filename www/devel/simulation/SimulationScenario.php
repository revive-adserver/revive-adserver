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

require_once MAX_PATH . '/lib/max/SqlBuilder.php';
require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/Delivery/querystring.php';
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table/Core.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/tests/testClasses/OATestData_MDB2Schema.php';

/**
 * A class for simulating maintenance/delivery scenarios
 *
 * @package
 * @subpackage
 * @author
 */
class SimulationScenario
{
    var $requestFile = '';
    var $requestData = '';
    var $totalDelivery = 0;
    var $totalRequests = 0;
    var $aDelivered = array();
    var $aFailed = array();
    var $scenarioConfig = '';
    var $tablePrefix = '';
    var $oServiceLocator;
    var $oCoreTables;
    var $oDbh;
    var $profileOn = true;
    var $aProfile = array();
    var $adSelectCallback;
    var $aVarDump;

    /**
     * The constructor method.
     */
    function SimulationScenario()
    {

    }

    /**
     * initialisation
     *
     * load the 'requestset' config file
     * do not load the dataset yet - allow child scenario to choose
     *
     * @param string $filename - name of scenario's dataset and config
     * @param string $dbname database name
     */
    function init($filename)
    {
        $GLOBALS['_MAX']['CONF']['table']['prefix']    = '';

        // assign the inputs
        $this->requestFile = SCENARIOS_REQUESTSETS.$filename.'.php';
        // load the request data
        $this->loadRequestset();

        // tweak some conf vals
        $GLOBALS['_MAX']['COOKIE']['newViewerId'] = '';
        $_COOKIE = $HTTP_COOKIE_VARS = array();

		// get service locator instance
		$this->oServiceLocator =& OA_ServiceLocator::instance();

        // start with a clean set of tables
        OA_DB_Table_Core::destroy();
        $this->oCoreTables = &OA_DB_Table_Core::singleton();

        // get the database handler
        $this->oDbh = &OA_DB::singleton();

        // fake the date/time
        $this->setDateTime();

    }

    /**
     * create a new set of openads tables this is called by the child class it
     * might not want them!
     *
     */
    function newTables()
    {
        if ($this->oDbh)
        {
            $this->oCoreTables->dropAllTables();
            $this->oCoreTables->createAllTables();
        }
        else
        {
            $this->reportResult(false, 'could not create new tables, invalid db object', $this->oDbh);
        }
    }

    /**
     * execute a set of ad requests
     *
     * @param int $iteration : the id of the current iteration (*hour*)
     */
    function makeRequests($iteration)
    {
        $aIteration = $this->scenarioConfig['aIterations'][$iteration];
        $requestObjs = count($aIteration['request_objects']);

        $this->printHeading('Starting requests; date: ' . $this->_getDateTimeString(), 3);

		if (!empty($aIteration['precise_requests']))
		{
			if (!is_array($aIteration['precise_requests']))
			{
				$aIteration['precise_requests'] = array();

				for ($i = 1; $i <= $requestObjs; $i++)
				{
					if (!empty($aIteration['request_objects'][$i]->requests))
					{
						for ($k = 0; $k < $aIteration['request_objects'][$i]->requests; $k++)
							array_push($aIteration['precise_requests'], $i);
					}
				}
			}

			$precise_requests = $aIteration['precise_requests'];

			$aIteration['max_requests'] = count($aIteration['precise_requests']);
		}
		else
			$aIteration['precise_requests'] = false;

        $k = 0;
        for($i=1;$i<=$aIteration['max_requests'];$i++)
        {
			if ($aIteration['precise_requests'])
			{
				$k = array_shift($precise_requests);
			}
            elseif ($aIteration['shuffle_requests'])
            {
                $k = rand(1, $requestObjs);
            }
            else
            {
                $k = ($k==$requestObjs ? 1 : $k+1 );
            }

            $this->_init_delivery();

            // these params somehow end up as globals rather than passed through as params
            // so set them up here
            $GLOBALS['loc'] = $aIteration['request_objects'][$k]->loc;
            $GLOBALS['referer'] = $aIteration['request_objects'][$k]->referer;

            // actually make the request
            $result = $this->_makeRequest($aIteration['request_objects'][$k]);

            // turn on output buffering
            ob_start();

            // if an ad has been served
            if ($result && is_array($result) && array_key_exists('bannerid',$result))
            {
                //var_dump($result);
                // is a beacon present in the html
                $URL = $this->_getBeaconURL($result['bannerid'], $result['html']);

                // make the logging beacon request
                $this->_logBeacon($URL);
            }

            // turn off output buffering
            ob_end_clean();

            // manipulate user cookies that are required by delivery engine
            $this->_simulateCookies();

            // log what happened in this iteration
            $this->_recordDelivery($iteration, $result['bannerid'], $aIteration['request_objects'][$k]->what);
        }
        if ($this->profileOn)
        {
            $this->show_profile();
        }

        // add up the delivery stats for this interval and store to data_summary_ad_zone table
        $this->_summariseInterval($iteration, $i-1);

        $this->printHeading('End requests; date: ' . $this->_getDateTimeString(), 3);

        // increment the fake date/time by an hour
        $this->_incDateTimeByOneHour();
    }

    /**
     * execute bits of init_delivery.php that we need
     */
    function _init_delivery()
    {
        // initialises vars, increments capping cookies, sets time
        //require '../init-delivery.php';

        // Set common delivery parameters in the global scope
        MAX_commonInitVariables();
        // tweak the time set in MAX_commonInitVariables
        $GLOBALS['_MAX']['NOW'] = $this->_getDateTimestamp();

        // Unpack the packed capping cookies
        MAX_cookieUnpackCapping();
        /**
        before REAL ad selection and beacon logging starts
        cookies will be read and cap val incremented
        simulation will not be able to read them
        so need to manually manipulate them
        discard the _MAX cookies
        normally done in UnpackCapping func by *unsetting* the cookie
        **/
        foreach ($_COOKIE AS $k => $v)
        {
            if (substr($k, 0, 1)=='_')
            {
                unset($_COOKIE[$k]);
            }
        }
        // clear the cookie cache
        //var_dump($GLOBALS['_MAX']['COOKIE']['CACHE']);
        $GLOBALS['_MAX']['COOKIE']['CACHE'] = '';
    }

    /**
     * after REAL ad selection and beacon logging
     * cookies will have been sent
     * simulation will not be able to read them
     * and doesn't send them properly anyway
     * so
     * need to manually manipulate the global cookies array
     *
     */
    function _simulateCookies()
    {
        //var_dump($_COOKIE);
        // ok, user is not a new viewer any more
        unset($GLOBALS['_MAX']['COOKIE']['newViewerId']);

        // capping cookies would normally be created as
        // _MAXCAP => array(adId=>intval)
        // but because they are not sent for real
        // they get saved as "_MAXCAP[1]" => intval
        // need _MAXCAP array (and MAXCAP array ?)
        // _MAXCAP array will be unpacked
        // before next request and used to
        // increment MAXCAP array
        foreach ($_COOKIE AS $k => $v)
        {
            if (substr($k, 0, 1)=='_')
            {
                if (substr($k, strlen($k)-1, 1)==']')
                {
                    $idx  = substr($k, strpos($k, '[')+1, 1);
                    $name = substr($k, 1, strpos($k, '[')-1);
                    if (!array_key_exists($name, $_COOKIE))
                    {
                        $_COOKIE[$name] = array();
                    }
                    if (!array_key_exists($idx, $_COOKIE[$name]))
                    {
                        $_COOKIE[$name][$idx] = 0;
                    }
                    $_COOKIE['_'.$name][$idx] = $v;
                }
            }
        }
    }
    /**
     * make a request via adSelect function
     *
     * @param stdClass object $oRequest
     * @return array of ad info
     */
    function _makeRequest($oRequest)
    {
        if ($this->profileOn)
        {
            $start = microtime_float();
        }
        $adSelect = MAX_adSelect(
                            $oRequest->what,
                            '',
                            $oRequest->target,
                            $oRequest->source,
                            $oRequest->withText,
                            $oRequest->context,
                            $oRequest->richMedia,
                            $oRequest->ct0,
                            $oRequest->loc,
                            $oRequest->referer
                           );
        if ($this->adSelectCallback)
        {
            call_user_method($this->adSelectCallback, $this);
        }
        if ($this->profileOn)
        {
            $this->aProfile[] = array('bannerid'=>$adSelect['bannerid'],
                                    'lapsed'=>sprintf("%.11f",microtime_float() - $start));
        }
        return $adSelect;
    }

    /**
     * find a logging beacon url
     *
     * @param int $bannerId - if null then delivery failed
     * @package string $html
     */
    function _getBeaconURL($bannerId, $html)
    {
        $beaconURL = '';
        if ($bannerId)
        {
            $pattern   = "<img src=\'http:\/\/[\w\W\s]+\/lg.php\?(?P<bURL>[\&\;\=\w]+)";
               $i = preg_match_all('/'.$pattern.'/', $html, $aMatch);
               if ($i)
               {
                $beaconURL  = $aMatch['bURL'][0];
               }
        }
        return $beaconURL;
    }

    /**
     * merge the url params with global $_REQUEST
     * call the lg.php script
     *
     * @param int $bannerId - if null then delivery failed
     * @package string $html
     */
    function _logBeacon($beaconURL)
    {
        if ($beaconURL)
        {
            $requestSave    = $_REQUEST;
            $getSave        = $_GET;
            $_GET           = array();
            $request        = MAX_querystringParseStr($beaconURL, &$aRequest, '&amp;');
            $_REQUEST       = $aRequest;
            chdir(MAX_PATH . '/www/delivery');
            include('./lg.php');
            chdir(SIM_PATH);
            $_REQUEST       = $requestSave;
            $_GET           = $getSave;
           }
           else
           {
            MAX_cookieFlush();
           }
    }

    /**
     * increment the success or failure values in arrays
     * increment the totalDelivery value
     * increment the totalRequests value
     *
     * @param int $iteration
     * @param int $bannerId - if null then delivery failed
     */
    function _recordDelivery($iteration, $bannerId, $what='')
    {
        if (!isset($this->aDelivered[$iteration]))
            $this->aDelivered[$iteration] = array();
        if (!isset($this->aFailed[$iteration]))
            $this->aFailed[$iteration] = array();

        if ($bannerId)
        {
            $array = &$this->aDelivered[$iteration];
            $this->totalDelivery++;
        }
        else
        {
            $array = &$this->aFailed[$iteration];
            $bannerId = 0;
        }

        if (preg_match('/zone(?:id)?:(\d+)/', $what, $m))
            $zoneId = (int)$m[1];
        else
            $zoneId = 0;

        if (!isset($array[$bannerId][$zoneId]))
            $array[$bannerId][$zoneId] = 0;

        $array[$bannerId][$zoneId]++;

        $this->totalRequests++;
    }

    /**
     *
     * add up the delivery stats for this interval
     * store to data_summary_ad_zone table
     *
     * @param int $hour
     * @param int $requests
     */
    function _summariseInterval($interval, $requests)
    {
       //$this->printHeading('summary hourly insert: '. $interval);
       $date = $this->_getDateTimeString();
       if (count($this->aFailed[$interval])>0)
       {
            $this->reportResult(false, 'delivery ', $this->aFailed[$interval][0]);
       }
       if (count($this->aDelivered[$interval])==0)
       {
            $this->printMessage('nothing delivered');
            return ;
       }

       $table = $GLOBALS['_MAX']['CONF']['table']['data_raw_ad_impression'];
       $dbh = OA_DB::singleton();
       foreach($this->aDelivered[$interval] as $bannerId => $aZones)
       {
               foreach($aZones as $zoneId => $count)
            {
                for ($i = 0; $i < $count; $i++)
                {
                    $dbh->exec("
                        INSERT INTO $table (date_time, ad_id, zone_id)
                        VALUES ('$date', $bannerId, $zoneId)");
                }
            }
       }

       $query = "SELECT ad_id, zone_id, count(*) as total_impressions FROM {$table}
               WHERE  date_time = '{$date}' GROUP BY zone_id, ad_id";
       $this->printResult($query, 'impression summary');
    }

    /**
     * execute the Priority engine tasks
     */
    function runPriority()
    {
        // Run maintenance before recalculating priorities
        $this->runMaintenance();

        $this->printHeading('Starting updatePriorities; date: ' . $this->_getDateTimeString(), 3);
        $oMaintenancePriority = new OA_Maintenance_Priority_AdServer();
        $oMaintenancePriority->updatePriorities();
        $this->printPriorities();
        $this->printHeading('End updatePriorities; date: ' . $this->_getDateTimeString(), 3);

        // Hack! The TestEnv class doesn't always drop temp tables for some
        // reason, so drop them "by hand", just in case.
        $dbType = strtolower($GLOBALS['_MAX']['CONF']['database']['type']);
        $oTable = &OA_DB_Table_Priority::singleton();
        $oTable->dropTable("tmp_ad_required_impression");
        $oTable->dropTable("tmp_ad_zone_impression");
    }

    /**
     * execute the Maintenance engine tasks
     */
    function runMaintenance()
    {
        $this->printHeading('Starting Maintenance Statistics; date: ' . $this->_getDateTimeString(), 3);
        OA_Maintenance_Statistics::run();
        $this->printHeading('End Maintenance Statistics; date: ' . $this->_getDateTimeString(), 3);
    }

    /**
     * tweak the date
     *
     * @param int $hour
     * @param string $day
     */
    function setDateTime($hour=0, $day='2000-01-01')
    {
        $date = $day.' '.str_pad($hour, 2, '0', STR_PAD_LEFT).':00:00';
        $this->oServiceLocator->register('now', new Date($date));
    }

    /**
     * get the fake date/time
     * initialise if not set
     *
     * @return oDate : object of Date
     */
    function _getDateTimeString()
    {
        $oDate = $this->oServiceLocator->get('now');
        if (!is_a($oDate,'Date'))
        {
            $this->setDateTime();
            $oDate = $this->oServiceLocator->get('now');
        }
        return $oDate->getDate();
    }

    /**
     * get the fake date/time as Unix timestamp
     *
     * @return int : Unix timestamp
     */
    function _getDateTimestamp()
    {
        $oDate = $this->oServiceLocator->get('now');
        return mktime($oDate->hour, $oDate->minute, $oDate->second, $oDate->month, $oDate->day, $oDate->year);
    }

    /**
     * increment the fake date/time by 1 hour
     */
    function _incDateTimeByOneHour()
    {
        $oSpan = new Date_Span();
        $oSpan->hour = 1;
        $oDate = $this->oServiceLocator->get('now');
        $oDate->addSpan($oSpan);
        $this->oServiceLocator->register('now', $oDate);
    }

    /**
     * display the request profile information
     */
    function show_profile()
    {
        $aProfile = $this->aProfile;
        $this->aProfile = array();
        include TPL_PATH.'/table_profile.html';
    }

    /**
     * read the scenario config file
     *
     */
    function loadRequestset()
    {
        if (file_exists($this->requestFile))
        {
            require_once($this->requestFile);
            $this->scenarioConfig = $GLOBALS['_MAX']['CONF']['sim'];
        }
        else
        {
            $this->reportResult(false, 'exists file', getcwd().'/'.$this->requestFile);
            exit();
        }
    }

    function loadDataset($sourceFile="")
    {
        $oTestData = new OA_Test_Data_MDB2Schema();
        $directory = SCENARIOS_DATASETS; //'/www/devel/simulation/scenarios/datasets/';
        if (!$oTestData->init($sourceFile,$directory,false))
        {
            $this->reportResult(false, 'failed to initialise dataset '.$directory.$sourceFile);
            return false;
        }
        if (!$oTestData->generateTestData())
        {
            $this->reportResult(false, 'failed to load dataset '.$directory.$sourceFile);
            return false;
        }
        return true;
    }

    function printResult($query, $title)
    {
        $this->printTable($this->oDbh->query($query), $title);
    }
    /**
     * print out any pre-run summary info you want
     */
    function printPrecis()
    {
//        global $is_simulation;
//        $this->printMessage('is_simulation:'.$is_simulation);
        $this->printMessage($this->scenarioConfig['precis']);
        $this->printWorkingData();
        $this->printPriorities();
        $this->printHeading('Data loaded, starting simulation...', 3);
    }

    /**
     * print out the working data
     *
     */
    function printWorkingData()
    {

        $query = "SELECT z.*, b.*, cam.*, cli.*, aff.* FROM {$this->tablePrefix}ad_zone_assoc AS aza
                JOIN {$this->tablePrefix}zones AS z ON z.zoneid=aza.zone_id
                JOIN {$this->tablePrefix}banners AS b ON b.bannerid=aza.ad_id
                LEFT JOIN {$this->tablePrefix}affiliates AS aff ON aff.affiliateid = z.affiliateid
                LEFT JOIN {$this->tablePrefix}campaigns AS cam ON cam.campaignid=b.campaignid
                LEFT JOIN {$this->tablePrefix}clients AS cli ON cli.clientid = cam.clientid
                ORDER BY aza.zone_id, aza.ad_id";
        $this->printResult($query, 'campaigns');
        $query = "SELECT * FROM {$this->tablePrefix}channel";
        $this->printResult($query, 'channels');
    }

    /**
     * print out the working data
     *
     */
    function printPriorities()
    {

        $query = "SELECT aza.*, dsaza.required_impressions, dsaza.requested_impressions, z.*, b.* FROM {$this->tablePrefix}ad_zone_assoc AS aza
                JOIN {$this->tablePrefix}data_summary_ad_zone_assoc dsaza ON (dsaza.zone_id=aza.zone_id AND dsaza.ad_id=aza.ad_id AND interval_start = '".$this->_getDateTimeString()."')
                JOIN {$this->tablePrefix}zones AS z ON z.zoneid=aza.zone_id
                JOIN {$this->tablePrefix}banners AS b ON b.bannerid=aza.ad_id
                ORDER BY aza.zone_id, aza.ad_id";
        $this->printResult($query, 'priorities');
    }

    /**
     * print out any post-run summary info you want
     */
    function printPostSummary()
    {
        $this->printHeading('Simulation complete, printing summary...', 3);
//        $this->printSummaryData();
        $this->printHeading('Total Requests: '.$this->totalRequests, 4);
        $this->printHeading('Total Delivery: '.$this->totalDelivery, 4);
        $this->printHeading('Total Percentage: '.(round(($this->totalDelivery/$this->totalRequests)*100,2)), 4);
    }

    /**
     * print out some summary data
     *
     */
    function printSummaryData()
    {
       $table = $GLOBALS['_MAX']['CONF']['table']['data_summary_ad_hourly'];
       $query = "SELECT ad_id, SUM( impressions ) AS impressions, ROUND(SUM(impressions) / {$this->totalDelivery} * 100, 2) AS percentage
                FROM {$table} GROUP BY ad_id ORDER BY ad_id";
       $this->printResult($query, '');
       $query = "SELECT * FROM {$table}";
       $this->printResult($query, $table);
    }

/**
 * reporting funcs
 *
 */
    function reportResult($result, $msg, $var='')
    {
        if ($result)
        {
            $this->printMessage('success: '.$msg, print_r($var,true));
        }
        else
        {
            $this->printError('failed: '.$msg, print_r($var,true));
        }
    }

    function printMessage($message, $data='')
    {
        include SIM_TEMPLATES; //MAX_PATH.'/simulation/templates/message.html';
    }

    function printHeading($msg='', $size=5)
    {
        if ($msg)
        {
           echo "<h{$size}>".$msg."</h{$size}>";
        }
    }

    function printError($message, $data='')
    {
        $error   = true;
        include SIM_TEMPLATES; //MAX_PATH.'/simulation/templates/message.html';
    }

    function printTable($dbRes, $title='')
    {
        $printth = true;
        $i = 0;
        include SIM_TEMPLATES; // MAX_PATH.'/simulation/templates/table_simulation.html';
    }
}

/**
 * small class that defines a request
 *
 */
class SimulationRequest
{
    var $what      = "";
    var $target    = "";
    var $source    = "";
    var $withText  = "";
    var $context   = "";
    var $richMedia = "";
    var $ct0       = "";
    var $referer   = "";
    var $loc       = "";

    function SimulationRequest($what='', $target='', $source='',$referer='',$loc='',$ct0='',$withText=false, $context='',$richMedia=true)
    {
        $this->what      = $what;
        $this->target    = $target;
        $this->source    = $source;
        $this->withText  = $withText;
        $this->context   = $context;
        $this->richMedia = $richMedia;
        $this->ct0       = $ct0;
        $this->referer   = $referer;
        $this->loc       = $loc;
    }

}
?>
