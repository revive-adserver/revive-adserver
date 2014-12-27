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

require_once MAX_PATH . '/lib/Max.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB/Distributed.php';
require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once OX_PATH . '/lib/OX.php';
require_once LIB_PATH . '/OperationInterval.php';
require_once LIB_PATH . '/Plugin/Component.php';
require_once OX_PATH . '/lib/pear/Date.php';


/**
 * A library class for providing automatic maintenance process methods.
 *
 * @static
 * @package    OpenXMaintenance
 * @subpackage Statistics
 */
class OX_Maintenance_Distributed
{

    /**
     * A method to run distributed maintenance.
     */
    function run()
    {
        if (empty($GLOBALS['_MAX']['CONF']['lb']['enabled'])) {
            OA::debug('Distributed stats disabled, not running Maintenance Distributed Engine', PEAR_LOG_INFO);
            return;
        }

        if (!empty($GLOBALS['_MAX']['CONF']['rawDatabase'])) {
            $GLOBALS['_MAX']['CONF']['database'] = $GLOBALS['_MAX']['CONF']['rawDatabase'] +
                $GLOBALS['_MAX']['CONF']['database'];

            OA::debug('rawDatabase functionality is being used, switching settings', PEAR_LOG_INFO);
        }

        $oLock =& OA_DB_AdvisoryLock::factory();
        if (!$oLock->get(OA_DB_ADVISORYLOCK_DISTRIBUTED))
        {
            OA::debug('Maintenance Distributed Engine Already Running', PEAR_LOG_INFO);
            return;
        }

        OA::debug('Running Maintenance Distributed Engine', PEAR_LOG_INFO);

        // Attempt to increase PHP memory
        OX_increaseMemoryLimit(OX_getMinimumRequiredMemory('maintenance'));

        // Ensure the current time is registered with the OA_ServiceLocator
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oNow =& $oServiceLocator->get('now');
        if (!$oNow) {
            // Record the current time, and register with the OA_ServiceLocator
            $oNow = new Date();
            $oServiceLocator->register('now', $oNow);
        }
        OA::debug(' - Current time is ' . $oNow->format('%Y-%m-%d %H:%M:%S') . ' ' . $oNow->tz->getShortName(), PEAR_LOG_DEBUG);

        // Get the components of the deliveryLog extension
        $aBuckets = OX_Component::getComponents('deliveryLog');

        // Copy buckets' records with "interval_start" up to and including previous OI start,
        // and then prune the data processed
        $aPreviousOperationIntervalDates =
            OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oNow);
        OA::debug(' - Will process data for all operation intervals before and up to start', PEAR_LOG_DEBUG);
        OA::debug('   time of ' . $aPreviousOperationIntervalDates['start']->format('%Y-%m-%d %H:%M:%S') . ' ' . $aPreviousOperationIntervalDates['start']->tz->getShortName(), PEAR_LOG_DEBUG);
        foreach ($aBuckets as $sBucketName => $oBucketClass) {
            if ($oBucketClass->testStatisticsMigration($oBucketClass->getStatisticsMigration())){
                $oBucketClass->processBucket($aPreviousOperationIntervalDates['start']);
                $oBucketClass->pruneBucket($aPreviousOperationIntervalDates['start']);
            } else {
                OA::debug('  - Skipping '.$sBucketName, PEAR_LOG_DEBUG);
            }
        }

        $oLock->release();

        OA::debug('Maintenance Distributed Engine Completed', PEAR_LOG_INFO);
    }
}

?>