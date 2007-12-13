<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
 * A class for managing preferences within Openads.
 *
 * @package    Openads
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Preference
{

    /**
     * A static method to load the current account's preferences from the
     * database and store them in the global array $GLOBALS['_MAX']['PREF'].
     *
     * @static
     */
    function loadPreferences()
    {
        // Get the type of the current accout
        $currentAccountType = OA_Permission::getAccountType();
        // Is a user logged in?
        if (is_null($currentAccountType)) {
            OA_Preference::_unsetPreferences();
            return;
        }
        // Get all of the preference types that exist
        $doPreferences = OA_Dal::factoryDO('preferences');
        $aPreferenceTypes = $doPreferences->getAll(array(), true);
        // Are there any preference types in the system?
        if (empty($aPreferenceTypes)) {
            OA_Preference::_unsetPreferences();
            return;
        }
        // Get the admin account's ID, as this will be required
        $doAccount = OA_Dal::factoryDO('accounts');
        $doAccount->account_type = OA_ACCOUNT_ADMIN;
        $doAccount->find();
        if ($doAccount->getRowCount() != 1) {
            OA_Preference::_unsetPreferences();
            return;
        }
        $doAccount->fetch();
        $aAdminAccount = $doAccount->toArray();
        $adminAccountId = $aAdminAccount['account_id'];
        // Get the admin account's preferences, as these are always required
        $aAdminPreferenceValues = OA_Preference::_getPreferenceValues($adminAccountId);
        if (empty($aAdminPreferenceValues)) {
            OA_Preference::_unsetPreferences();
            return;
        }
        // Prepare an array to store the preferences that should
        // eventually be set in the global array
        $aPreferences = array();
        // Put the admin account's preferences into the temporary
        // storage array for preferences
        OA_Preference::_setPreferences($aPreferences, $aPreferenceTypes, $aAdminPreferenceValues);
        // Is the current account NOT the admin account?
        if ($currentAccountType != OA_ACCOUNT_ADMIN) {
            // Is the current account not a manager account?
            if ($currentAccountType == OA_ACCOUNT_MANAGER) {
                // This is a manager account
                $managerAccountId = OA_Permission::getAccountId();
                if ($managerAccountId == 0) {
                    OA_Preference::_unsetPreferences();
                    return;
                }
                // Get the manager account's preference values
                $aManagerPreferenceValues = OA_Preference::_getPreferenceValues($managerAccountId);
                // Merge the preference values into the temporary
                // storage array for preferences
                OA_Preference::_setPreferences($aPreferences, $aPreferenceTypes, $aManagerPreferenceValues);
            } else {
                // This must be an advertiser or trafficker account, so
                // need to locate the manager account that "owns" this account
                $owningAgencyId = OA_Permission::getAgencyId();
                if ($owningAgencyId == 0) {
                    OA_Preference::_unsetPreferences();
                    return;
                }
                $doAgency = OA_Dal::factoryDO('agency');
                $doAgency->agency_id = $owningAgencyId;
                $doAgency->find();
                if ($doAgency->getRowCount() != 1) {
                    OA_Preference::_unsetPreferences();
                    return;
                }
                $aManagerAccountId = $doAgency->getAll(array('account_id'), false, true);
                $managerAccountId = $aManagerAccountId[0];
                // Get the manager account's preference values
                $aManagerPreferenceValues = OA_Preference::_getPreferenceValues($managerAccountId);
                // Merge the preference values into the temporary
                // storage array for preferences
                OA_Preference::_setPreferences($aPreferences, $aPreferenceTypes, $aManagerPreferenceValues);
                // Get the current account's ID
                $currentAccountId = OA_Permission::getAccountId();
                if ($currentAccountId == 0) {
                    OA_Preference::_unsetPreferences();
                    return;
                }
                // Get the current account's preference values
                $aCurrentPreferenceValues = OA_Preference::_getPreferenceValues($currentAccountId);
                // Merge the preference values into the temporary
                // storage array for preferences
                OA_Preference::_setPreferences($aPreferences, $aPreferenceTypes, $aCurrentPreferenceValues);
            }
        }
        // Store the preferences!
        $GLOBALS['_MAX']['PREF'] = $aPreferences;
    }

    /**
     * A private static method to unset preferences.
     *
     * @static
     * @access private
     */
    function _unsetPreferences()
    {
        unset($GLOBALS['_MAX']['PREF']);
    }

    /**
     * A private static method to retrieve the preference values stored in the database
     * for a given account ID.
     *
     * @static
     * @access private
     * @param integer $accountId The account ID to retrieve the preference values for.
     * @return array An array of arrays, with each sub-array containing the keys
     *               "account_id" (matching $accountId), "preference_id" and "value".
     */
    function _getPreferenceValues($accountId)
    {
        $doAccount_Preference_Assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_Preference_Assoc->account_id = $accountId;
        $aPreferenceValues = $doAccount_Preference_Assoc->getAll();
        return $aPreferenceValues;
    }

    /**
     * A private static method to iterate over an array of preference values, and store them
     * into another array (which may, or may not, already contain preference values).
     *
     * @static
     * @access private
     * @param array $aPreferences      A reference to an array in which preference values
     *                                 will be stored. The format of the array after storing
     *                                 preference values will be:
     *      array(
     *          'preference_name' => array(
     *              'account_type' => ACCOUNT_TYPE_CONSTANT,
     *              'value'        => 'Preference Value'
     *          ),
     *          .
     *          .
     *          .
     *      )
     *
     * @param array $aPreferenceTypes  An array of arrays, indexed by "preference_id",
     *                                 with each sub-array containing the keys
     *                                 "preference_id", "preference_name" and
     *                                 "account_type". This array should be, essentially,
     *                                 the contents of the "preferences" table.
     * @param array $aPreferenceValues An array of arrays, with each sub-array containing
     *                                 the keys "preference_id" and "value". This array
     *                                 should be the preference values from the
     *                                 "account_preference_assoc" table that match the
     *                                 appropriate account for which the preference
     *                                 values should be stored in $aPreferences.
     */
    function _setPreferences(&$aPreferences, $aPreferenceTypes, $aPreferenceValues)
    {
        // Loop over each preference value
        foreach ($aPreferenceValues as $aPreferenceValue) {
            // Is the preference_id value for the preference value valid?
            if (isset($aPreferenceTypes[$aPreferenceValue['preference_id']])) {
                // This is a valid preference value, so store it
                $aPreferences[$aPreferenceTypes[$aPreferenceValue['preference_id']]['preference_name']] =
                    array(
                        account_type => $aPreferenceTypes[$aPreferenceValue['preference_id']]['account_type'],
                        value        => $aPreferenceValue['value']
                    );
            }
        }

    }

}

?>