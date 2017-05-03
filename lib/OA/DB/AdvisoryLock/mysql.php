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
class OA_DB_AdvisoryLock_mysql extends OA_DB_AdvisoryLock
{
    /**
     * A private method to acquire an advisory lock.
     *
     * @param int $iWaitTime Wait time.
     * @return bool True if lock was correctly acquired.
     */
    public function _getLock($iWaitTime)
    {
        // Acquire lock
        $iAcquired = $this->oDbh->extended->getOne(
            "SELECT GET_LOCK(?, ?)",
            'integer',
            array(
                $this->_sId,
                $iWaitTime
            ),
            array(
                'text',
                'integer'
            )
        );

        return !PEAR::isError($iAcquired) && !empty($iAcquired);
    }

    /**
     * A private method to release a previously acquired lock.
     *
     * @return bool True if the lock was correctly released.
     */
    public function _releaseLock()
    {
        // Relase lock
        $iReleased = $this->oDbh->extended->getOne(
            "SELECT RELEASE_LOCK(?)",
            'integer',
            array(
                $this->_sId
            ),
            array(
                'text'
            )
        );

        return !PEAR::isError($iReleased) && !empty($iReleased);
    }

    /**
     * {@inheritdoc}
     */
    public function _getId($sName)
    {
        // Recent MySQL versions limit lock names to 64 chars
        return substr(parent::_getId($sName), 0, 64);
    }
}