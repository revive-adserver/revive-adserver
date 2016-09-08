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

require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';

/**
 * An abstract class defining the interface for using advisory locks inside Openads.
 *
 * @package    OpenXDB
 * @subpackage AdvisoryLock
 */
class OA_DB_AdvisoryLock_mysqli extends OA_DB_AdvisoryLock
{
    /**
     * A private method to acquire an advisory lock.
     *
     * @param int $iWaitTime Wait time.
     * @return bool True if lock was correctly acquired.
     */
    function _getLock($iWaitTime)
    {
        // Acquire lock
        $iAcquired = $this->oDbh->extended->getOne(
            "SELECT GET_LOCK('$this->_sId', $iWaitTime)",
            'integer'
        );

        return !PEAR::isError($iAcquired) && !empty($iAcquired);
    }

    /**
     * A private method to release a previously acquired lock.
     *
     * @return bool True if the lock was correctly released.
     */
    function _releaseLock()
    {
        // Relase lock
        $iReleased = $this->oDbh->extended->getOne(
            "SELECT RELEASE_LOCK('$this->_sId')",
            'integer'
        );

        return !PEAR::isError($iReleased) && !empty($iReleased);
    }
}

?>
