<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
class OA_DB_AdvisoryLock_mysql extends OA_DB_AdvisoryLock
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
            "SELECT GET_LOCK(?, ?)",
            'integer',
            array(
                $this->_sId,
                $iWaitTime
            )
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
            "SELECT RELEASE_LOCK(?)",
            'integer',
            array(
                $this->_sId
            )
        );

        return !PEAR::isError($iReleased) && !empty($iReleased);
    }
}

?>