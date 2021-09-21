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
class OA_DB_AdvisoryLock_file extends OA_DB_AdvisoryLock
{
    /**
     * @var null
     */
    public $sPath;
    /**
     * @var null
     */
    public $rFile;
    /**
     * Enter description here...
     *
     * @var string
     */
    private $_sPath;
    private $_rFile;

    /**
     * A private method to acquire an advisory lock.
     *
     * @param int $iWaitTime Wait time.
     * @return bool True if lock was correctly acquired.
     */
    public function _getLock($iWaitTime)
    {
        $this->_sPath = MAX_PATH . '/var/cache/' . $this->_sId . '.lock';

        if ($this->_rFile = @fopen($this->_sPath, 'w+')) {
            $bLock = @flock($this->_rFile, LOCK_EX | LOCK_NB);
            while (!$bLock && $iWaitTime > 0) {
                // TODO: Emulate waittime - don't know if it's really needed
                break;
            }
            return $bLock;
        }

        return false;
    }

    /**
     * A private method to release a previously acquired lock.
     *
     * @return bool True if the lock was correctly released.
     */
    public function _releaseLock()
    {
        if (!empty($this->_rFile)) {
            $bLock = @flock($this->_rFile, LOCK_UN);
            @fclose($this->_rFile);
            @unlink($this->_sPath);
            $this->sPath = null;
            $this->rFile = null;

            return $bLock;
        }

        return false;
    }
}
