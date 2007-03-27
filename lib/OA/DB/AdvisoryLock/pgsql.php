<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
 * @package    OpenadsDB
 * @subpackage Table
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class OA_DB_AdvisoryLock_pgsql extends OA_DB_AdvisoryLock
{
    /**
     * A private method to acquire an advisory lock.
     *
     * @param int $sType Lock type.
     * @param int $iWaitTime Wait time.
     * @return boolean True if lock was correctly acquired.
     */
    function _getLock($iType, $iWaitTime)
    {
        $aParams = unserialize($this->_sId);

        // Acquire lock
        $iAcquired = $this->oDbh->extended->GetOne(
            "SELECT pg_try_advisory_lock(?, ?)",
            'boolean',
            $aParams
        );

        return !PEAR::isError($iAcquired) && $iAcquired;
    }

    /**
     * A private method to release a previously acquired lock.
     *
     * @return void
     */
    function _releaseLock()
    {
        $aParams = unserialize($this->_sId);

        // Relase lock
        $rc = $this->oDbh->extended->execParam(
            "SELECT pg_advisory_unlock(?, ?)",
            $aParams
        );
    }

    /**
     * A method to check if PostgreSQL supports advisory locks.
     *
     * @return boolean
     */
    function _isLockingSupported()
    {
        $sVersion = $this->oDbh->extended->getOne("SELECT VERSION()");
        $sVersion = preg_replace('/^.*?(\d+\.\d+(\.\d+)?).*$/', '$1', $sVersion);

        return (bool)version_compare($sVersion, '8.2', '>=');
    }

    function _getId($sName)
    {
        if (isset($GLOBALS['_MAX']['PREF'])) {
            $pref = $GLOBALS['_MAX']['PREF'];
        } else {
            // TODO: We need to load the instance id from the database
            $pref = array('instance_id' => sha1(''));
        }

        // PostgreSQL needs two int4, we generate them using crc32
        $sId = array(
            crc32($pref['instance_id']),
            crc32($sName)
        );

        return serialize($sId);
    }
}

?>
