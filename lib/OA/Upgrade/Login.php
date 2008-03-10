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

require_once MAX_PATH . '/lib/OA/Auth.php';

/**
 * A class to deal with login and auto-login features during install/upgrade
 */
class OA_Upgrade_Login
{
    /**
     * Check administrator login during the upgrade steps
     *
     * @return boolean True if login succeded
     */
    function checkLogin()
    {
        if (empty($_COOKIE['oat']) || $_COOKIE['oat'] != OA_UPGRADE_UPGRADE) {
            return true;
        }

        // Clean up session
        $GLOBALS['session'] = array();

        // Detection needs to happen every time to make sure that database parameters are
        $oUpgrader = new OA_Upgrade();
        $openadsDetected = $oUpgrader->detectOpenads(true) ||
            $oUpgrader->existing_installation_status == OA_STATUS_CURRENT_VERSION;

        // Sequentially check, to avoid useless work
        if (!$openadsDetected) {
            if (!($panDetected = $oUpgrader->detectPAN(true))) {
                if (!($maxDetected = $oUpgrader->detectMAX(true))) {
                    if (!($max01Detected = $oUpgrader->detectMAX01(true))) {
                        // No upgrade-able version detected, return
                        return false;
                    }
                }
            }
        }

        phpAds_SessionStart();
        phpAds_SessionDataFetch();

        $oPlugin = &OA_Auth::staticGetAuthPlugin('internal');

        if ($oPlugin->suppliedCredentials()) {
            // The new Users, Account, Permissions & Preference feature was introduced in OpenX 2.5.46-dev
            $newLogin = $openadsDetected && version_compare($oUpgrader->versionInitialApplication, '2.5.46-dev', '>=') == -1;

            if ($newLogin) {
                OA_Upgrade_Login::_checkLoginNew();
            } else {
                if ($openadsDetected || $maxDetected) {
                    OA_Upgrade_Login::_checkLoginOld('preference', true);
                } elseif ($max01Detected) {
                    OA_Upgrade_Login::_checkLoginOld('config', true);
                } elseif ($panDetected) {
                    OA_Upgrade_Login::_checkLoginOld('config', false);
                } else {
                    return false;
                }
            }

            phpAds_SessionDataStore();
        }

        return OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isUserLinkedToAdmin();
    }

    function autoLogin()
    {
        $oPlugin = &OA_Auth::staticGetAuthPlugin();

        phpAds_SessionStart();

        // No auto-login if auth is external
        if (empty($oPlugin) || $oPlugin->package != 'internal') {
            phpAds_SessionDataDestroy();
            return;
        }

        $doUser = OA_Dal::factoryDO('users');

        if (!empty($_COOKIE['oat']) && $_COOKIE['oat'] == OA_UPGRADE_UPGRADE) {
            // Upgrading, fetch the record using the username of the logged in user
            $doUser->username = OA_Permission::getUsername();
        } else {
            // Installing, fetch the user linked to the admin account
            $doAUA = OA_Dal::factoryDO('account_user_assoc');
            $doAUA->account_id = OA_Dal_ApplicationVariables::get('admin_account_id');
            $doUser->joinAdd($doAUA);
        }

        $doUser->find();
        if ($doUser->fetch()) {
            phpAds_SessionDataRegister(OA_Auth::getSessionData($doUser));
            phpAds_SessionDataStore();
        }
    }

    function _checkLoginNew()
    {
        $oPlugin = &OA_Auth::staticGetAuthPlugin('internal');

        $aCredentials = $oPlugin->getCredentials(false);

        if (!PEAR::isError($aCredentials)) {
            $doUser = $oPlugin->checkPassword($aCredentials['username'], $aCredentials['password']);

            if ($doUser) {
                phpAds_SessionDataRegister(OA_Auth::getSessionData($doUser));
            }
        }
    }

    function _checkLoginOld($tableName, $agencySupport)
    {
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        $oDbh = OA_DB::singleton();
        if (!PEAR::isError($oDbh)) {
            $tblPreferences = $oDbh->quoteIdentifier($prefix.$tableName, true);

            $query = "SELECT admin, admin_pw FROM {$tblPreferences}";

            if ($agencySupport) {
                $query .= " WHERE agencyid = 0";
            }
            $aPref = $oDbh->queryRow($query, null, MDB2_FETCHMODE_ASSOC);

            if (is_array($aPref)) {
                $oPlugin = &OA_Auth::staticGetAuthPlugin('internal');
                $aCredentials = $oPlugin->getCredentials(false);

                if (!PEAR::isError($aCredentials)) {
                    if (strtolower($aPref['admin']) == strtolower($aCredentials['username']) &&
                        $aPref['admin_pw'] == md5($aCredentials['password']))
                    {
                        $doUser = OA_Dal::factoryDO('users');
                        $doUser->username = $aPref['admin'];

                        $aSession = OA_Auth::getSessionData($doUser, true);
                        $aSession['user']->aAccount['account_type'] = OA_ACCOUNT_ADMIN;

                        phpAds_SessionDataRegister($aSession);
                    }
                }
            }
        }
    }
}

?>