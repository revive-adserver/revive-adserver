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

require_once MAX_PATH . '/lib/OA/Maintenance/Status.php';

/**
 * A class for performing a unit test of the Maintenance Status functions
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OA_Maintenenace_Status extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oNow = new Date('2008-04-01 12:30:00');
        $oServiceLocator->register('now', $oNow);

        parent::__construct();
    }

    /**
     * A method to get a new instance of OA_Maintenance_Status
     *
     * @return OA_Maintenance_Status
     */
    function &getInstance()
    {
        $oMaintStatus = new OA_Maintenance_Status();
        return $oMaintStatus;
    }

    /**
     * A method to get the "now" date class, eventually subtracting
     * some time
     *
     * @param int $subtractSeconds
     * @return Date
     */
    function &getDate($subtractSeconds = 0)
    {
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oNow = new Date($oServiceLocator->get('now'));
        if ($subtractSeconds) {
            $oNow->subtractSeconds($subtractSeconds);
        }
        return $oNow;
    }

    /**
     * A helper method to set applicationvariables
     *
     * @param Date $oScheduledDate
     * @param Date $oDate
     */
    function setVariables($oScheduledDate, $oDate)
    {
        if (isset($oScheduledDate)) {
            OA_Dal_ApplicationVariables::set('maintenance_cron_timestamp', $oScheduledDate->getDate(DATE_FORMAT_UNIXTIME));
        } else {
            OA_Dal_ApplicationVariables::delete('maintenance_cron_timestamp');
        }
        if (isset($oDate)) {
            OA_Dal_ApplicationVariables::set('maintenance_timestamp', $oDate->getDate(DATE_FORMAT_UNIXTIME));
        } else {
            OA_Dal_ApplicationVariables::delete('maintenance_timestamp');
        }
    }

    /**
     * A helper method to assert "Running" properties
     *
     * @param bool $isScheduledMaintenanceRunning
     * @param bool $isAutoMaintenanceRunning
     */
    function check($isScheduledMaintenanceRunning, $isAutoMaintenanceRunning)
    {
        $aBt = debug_backtrace();

        $oMaintStatus = $this->getInstance();
        $this->assertEqual($oMaintStatus->isScheduledMaintenanceRunning, (bool)$isScheduledMaintenanceRunning,
            ($isScheduledMaintenanceRunning ? 'True' : 'False')." was expected for scheduled mainteanance on line {$aBt[0]['line']}");
        $this->assertEqual($oMaintStatus->isAutoMaintenanceRunning, (bool)$isAutoMaintenanceRunning,
            ($isAutoMaintenanceRunning ? 'True' : 'False')." was expected for automatic mainteanance on line {$aBt[0]['line']}");
    }

    function testAutoEnabled()
    {
        $GLOBALS['_MAX']['CONF']['maintenance']['autoMaintenance'] = false;
        $oMaintStatus = $this->getInstance();
        $this->assertFalse($oMaintStatus->isAutoMaintenanceEnabled);

        $GLOBALS['_MAX']['CONF']['maintenance']['autoMaintenance'] = true;
        $oMaintStatus = $this->getInstance();
        $this->assertTrue($oMaintStatus->isAutoMaintenanceEnabled);
    }

    function testConstructor()
    {
        $this->setVariables(null, null);
        $this->check(false, false);

        // Check 1 day ago
        $this->setVariables(null, $this->getDate(86400));
        $this->check(false, false);
        $this->setVariables($this->getDate(86400), null);
        $this->check(false, false);
        $this->setVariables($this->getDate(86400), $this->getDate(86400));
        $this->check(false, false);

        // Check 1 hour ago
        $this->setVariables(null, $this->getDate(3600));
        $this->check(false, false);
        $this->setVariables($this->getDate(3600), null);
        $this->check(false, false);
        $this->setVariables($this->getDate(3600), $this->getDate(3600));
        $this->check(false, false);

        // Check 31  mins ago
        $this->setVariables(null, $this->getDate(1860));
        $this->check(false, false);
        $this->setVariables($this->getDate(1860), null);
        $this->check(false, false);
        $this->setVariables($this->getDate(1860), $this->getDate(1860));
        $this->check(false, false);

        // Check 30 mins ago
        $this->setVariables(null, $this->getDate(1800));
        $this->check(false, true);
        $this->setVariables($this->getDate(1800), null);
        $this->check(true, false);
        $this->setVariables($this->getDate(1800), $this->getDate(1800));
        $this->check(true, false);

        // Check 29  mins ago
        $this->setVariables(null, $this->getDate(1740));
        $this->check(false, true);
        $this->setVariables($this->getDate(1740), null);
        $this->check(true, false);
        $this->setVariables($this->getDate(1740), $this->getDate(1740));
        $this->check(true, false);

        // Check now
        $this->setVariables(null, $this->getDate());
        $this->check(false, true);
        $this->setVariables($this->getDate(), null);
        $this->check(true, false);
        $this->setVariables($this->getDate(), $this->getDate());
        $this->check(true, false);

        // Check future
        $this->setVariables(null, $this->getDate(-1));
        $this->check(false, true);
        $this->setVariables($this->getDate(-1), null);
        $this->check(true, false);
        $this->setVariables($this->getDate(-1), $this->getDate(1));
        $this->check(true, false);
    }
}

?>
