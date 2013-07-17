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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once 'MDB2.php';


/**
 * Generic lock type
 */
define('OA_DB_ADVISORYLOCK_GENERIC',      '0');

/**
 * Maintenance lock type
 */
define('OA_DB_ADVISORYLOCK_MAINTENANCE',  '1');

/**
 * Distributed lock type
 */
define('OA_DB_ADVISORYLOCK_DISTRIBUTED',  '2');


/**
 * An abstract class defining the interface for using advisory locks inside Openads.
 *
 * @package    OpenXDB
 * @subpackage AdvisoryLock
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_DB_AdvisoryLock
{
    /**
     * An instance of the OA_DB class.
     *
     * @var OA_DB
     */
    var $oDbh;

    /**
     * The lock ID
     *
     * @access protected
     * @var string
     */
    var $_sId;

    /**
     * The class constructor method.
     *
     * @return OA_DB_AdvisoryLock
     */
    function OA_DB_AdvisoryLock()
    {
        $this->oDbh =& OA_DB::singleton();
    }

    /**
     * A factory method which returns the currently supported best advisory lock
     * instance.
     *
     * @return OA_DB_AdvisoryLock Reference to an OA_DB_AdvisoryLock object.
     */
    function &factory($sType = null)
    {
        if (is_null($sType)) {

            $oDbh =& OA_DB::singleton();

            if (PEAR::isError($oDbh)) {
                OA::debug('Error connecting to database to obtain locking object. Native error follows:', PEAR_LOG_ERR);
                OA::debug($oDbh, PEAR_LOG_ERR);
                OA::debug('Will re-try connection...', PEAR_LOG_ERR);
                $retryCount = 0;
                while (PEAR::isError($oDbh) && $retryCount < 6) {
                    $retryCount++;
                    sleep(10);
                    OA::debug('Re-try connection attempt #' . $retryCount, PEAR_LOG_ERR);
                    $oDbh =& OA_DB::singleton();
                }
                if (PEAR::isError($oDbh)) {
                    OA::debug('Failed in re-try attempts to connect to database. Aborting.', PEAR_LOG_CRIT);
                    exit();
                }
            }

            $aDsn  = MDB2::parseDSN($oDbh->getDSN());
            $sType = $aDsn['phptype'];

        }

        include_once(MAX_PATH.'/lib/OA/DB/AdvisoryLock/'.$sType.'.php');
        $sClass = "OA_DB_AdvisoryLock_".$sType;

        $oLock = new $sClass();

        if (!$oLock->_isLockingSupported()) {
            // Fallback to file based locking if the current class won't work
            $oLock =& OA_DB_AdvisoryLock::factory('file');
        }

        return $oLock;
    }

    /**
     * A method to acquire an advisory lock.
     *
     * @param string $sType Lock type.
     * @param int $iWaitTime Wait time.
     * @return bool True if lock was correctly acquired.
     */
    function get($sType = OA_DB_ADVISORYLOCK_GENERIC, $iWaitTime = 0)
    {
        // Release previous lock, if any
        $this->release();

        // Generate new id
        $this->_sId = $this->_getId($sType);

        return $this->_getLock($iWaitTime);
    }

    /**
     * A method to release a previously acquired lock.
     *
     * @return bool True if lock was correctly released.
     */
    function release()
    {
        if (!empty($this->_sId)) {
            return $this->_releaseLock();
        }

        return false;
    }

    /**
     * A method to check if the lock id matches.
     *
     * @param string $sType Lock type.
     * @return bool True if locks match.
     */
    function hasSameId($sType)
    {
        return $this->_getId($sType) == $this->_sId;
    }

    /**
     * A private method to ensure that the class implementation of advisory
     * locks is supported.
     *
     * Note: PostgreSQL has advisory locks in-core since 8.2, we may need to
     * check the DB version or other things.
     *
     * @return boolean True if the current class will work
     */
    function _isLockingSupported() {
        return true;
    }

    /**
     * A private method to acquire an advisory lock.
     *
     * @param int $iWaitTime Wait time.
     * @return bool True if lock was correctly acquired.
     */
    function _getLock($iWaitTime)
    {
        OA::debug('Base class cannot be used directly, use the factory method instead', PEAR_LOG_ERR);
        return false;
    }

    /**
     * A private method to release a previously acquired lock.
     *
     * @return bool True if the lock was correctly released.
     */
    function _releaseLock()
    {
        OA::debug('Base class cannot be used directly, use the factory method instead', PEAR_LOG_ERR);
        return false;
    }

    /**
     * A method to generate a lock id.
     *
     * @access protected
     *
     * @param string The lock name.
     * @return string The lock id.
     */
    function _getId($sName)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $sId = sha1($this->oDbh->getDsn().'/'.$aConf['table']['prefix']);

        return "OA_{$sName}.{$sId}";
    }
}

?>