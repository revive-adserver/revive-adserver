<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';

/**
 * An abstract class defining the interface for using advisory locks inside Openads.
 *
 * @package    OpenXDB
 * @subpackage AdvisoryLock
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_DB_AdvisoryLock_file extends OA_DB_AdvisoryLock
{
    /**
     * Enter description here...
     *
     * @var string
     */
    var $_sPath;
    var $_rFile;

    /**
     * A private method to acquire an advisory lock.
     *
     * @param int $iWaitTime Wait time.
     * @return bool True if lock was correctly acquired.
     */
    function _getLock($iWaitTime)
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
    function _releaseLock()
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

?>