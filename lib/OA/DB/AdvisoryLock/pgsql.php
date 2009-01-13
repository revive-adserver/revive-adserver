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
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

/**
 * An abstract class defining the interface for using advisory locks inside Openads.
 *
 * @package    OpenXDB
 * @subpackage AdvisoryLock
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_DB_AdvisoryLock_pgsql extends OA_DB_AdvisoryLock
{
    /**
     * A private method to acquire an advisory lock.
     *
     * @param int $iWaitTime Wait time.
     * @return bool True if lock was correctly acquired.
     */
    function _getLock($iWaitTime)
    {
        $aParams = unserialize($this->_sId);

        // Acquire lock
        $bAcquired = $this->oDbh->extended->getOne(
            "SELECT pg_try_advisory_lock(?::int4, ?::int4)",
            'boolean',
            $aParams
        );
        while (!$bAcquired && $iWaitTime > 0) {
            // TODO: Emulate waittime - don't know if it's really needed
            break;
        }

        return !PEAR::isError($bAcquired) && !empty($bAcquired);
    }

    /**
     * A private method to release a previously acquired lock.
     *
     * @return bool True if the lock was correctly released.
     */
    function _releaseLock()
    {
        $aParams = unserialize($this->_sId);

        // Relase lock
        $bReleased = $this->oDbh->extended->getOne(
            "SELECT pg_advisory_unlock(?::int4, ?::int4)",
            'boolean',
            $aParams
        );

        return !PEAR::isError($bReleased) && !empty($bReleased);
    }

    /**
     * A method to check if PostgreSQL supports advisory locks.
     *
     * @return bool True if the connected database supports advisory locks.
     */
    function _isLockingSupported()
    {
        $sVersion = $this->oDbh->extended->getOne("SELECT VERSION()");
        $sVersion = preg_replace('/^.*?(\d+\.\d+(\.\d+)?).*$/', '$1', $sVersion);

        return (bool)version_compare($sVersion, '8.2', '>=');
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
        $platformHash = OA_Dal_ApplicationVariables::get('platform_hash');

        // PostgreSQL needs two int4, we generate them using crc32
        $sId = array(
            crc32($platformHash) & 0x7FFFFFFF,
            crc32($sName) & 0x7FFFFFFF
        );

        return serialize($sId);
    }
}

?>