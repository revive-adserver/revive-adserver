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

/**
 * Password recovery DAL for Openads
 *
 * @package OpenXDal
 */

require_once MAX_PATH.'/lib/OA/Dal.php';
require_once MAX_PATH.'/lib/max/Plugin.php';

class OA_Dal_PasswordRecovery extends OA_Dal
{
    /**
     * Search users with a matching email address
     *
     * @param string e-mail
     * @return array matching users
     */
    function searchMatchingUsers($email)
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->email_address = $email;
        $doUsers->find();

        $users = array();
        while ($doUsers->fetch()) {
            $users[] = $doUsers->toArray();
        }

        return $users;
    }

    /**
     * Generate and save a recovery ID for a user
     *
     * @param int user ID
     * @return array generated recovery ID
     */
    function generateRecoveryId($userId)
    {
        $recoveryId = strtoupper(md5(uniqid('', true)));
        $recoveryId = substr(chunk_split($recoveryId, 8, '-'), -23, 22);

        $doPwdRecovery = OA_Dal::factoryDO('password_recovery');
        $doPwdRecovery->whereAdd('user_id = '.DBC::makeLiteral($userId));
        $doPwdRecovery->delete(true);

        $doPwdRecovery = OA_Dal::factoryDO('password_recovery');
        $doPwdRecovery->user_type   = 'user';
        $doPwdRecovery->user_id     = $userId;
        $doPwdRecovery->recovery_id = $recoveryId;
        $doPwdRecovery->updated     = OA::getNowUTC();

        $doPwdRecovery->insert();

        return $recoveryId;
    }

    /**
     * Check if recovery ID is valid
     *
     * @param string recovery ID
     * @return bool true if recovery ID is valid
     */
    function checkRecoveryId($recoveryId)
    {
        $doPwdRecovery = OA_Dal::factoryDO('password_recovery');
        $doPwdRecovery->recovery_id = $recoveryId;

        return (bool)$doPwdRecovery->count();
    }

    /**
     * Save the new password in the user properties
     *
     * @param string recovery ID
     * @param string new password
     * @return bool Ttrue the new password was correctly saved
     */
    function saveNewPasswordAndLogin($recoveryId, $password)
    {
        $doPwdRecovery = OA_Dal::factoryDO('password_recovery');
        $doPwdRecovery->recovery_id = $recoveryId;
        $doPwdRecoveryClone = clone($doPwdRecovery);
        $doPwdRecovery->find();

        if ($doPwdRecovery->fetch()) {
            $userId = $doPwdRecovery->user_id;
            
            $doPlugin = MAX_Plugin::factory('authentication');
            $doPlugin->changePassword($doUser, $password);
            $doUser = OA_Dal::factoryDO('users');
            $doUser->user_id = $userId;
            $doUser->password = md5($password);
            $doUser->update();

            $doPwdRecoveryClone->delete();

            phpAds_SessionStart();
            $doUser = OA_Dal::staticGetDO('users', $userId);
            phpAds_SessionDataRegister(OA_Auth::getSessionData($doUser));
            phpAds_SessionDataStore();

            return true;
        }

        return false;
    }
}

?>
