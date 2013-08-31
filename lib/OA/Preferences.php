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

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';


/**
 * A class for managing preferences within Openads.
 *
 * @package    OpenX
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Preferences
{

    /**
     * A static method to load the current account's preferences from the
     * database and store them in the global array $GLOBALS['_MAX']['PREF'].
     *
     * @static
     * @param boolean $loadExtraInfo An optional parameter, when set to true,
     *                               the array of preferences is loaded as
     *                               an array of arrays, indexed by preference
     *                               key, containing the preference "value" and
     *                               "account_type" information. When not set,
     *                               the preferences are loaded as a
     *                               one-dimensional array of values, indexed
     *                               by preference key.
     * @param boolean $return        An optional parameter, when set to true,
     *                               returns the preferences instead of setting
     *                               them into $GLOBALS['_MAX']['PREF'].
     * @param boolean $parentOnly    An optional parameter, when set to true,
     *                               only loads those preferences that are
     *                               inherited from parent accounts, not preferences
     *                               at the current account level. If the current
     *                               account is the admin account, and this option
     *                               is true, no preferences will be loaded!
     * @param boolean $loadAdminOnly An optional parameter, when set to true, loads
     *                               the admin preferences only, EVEN IF NO ACCUONT
     *                               IS LOGGED IN. If set to true, REQUIRES that the
     *                               $parentOnly parameter is false. Should only
     *                               ever be set when called from
     *                               OA_Preferences::loadAdminAccountPreferences().
     * @param integer $accountId     An optional account ID, when set, the preferences
     *                               for this account will be loaded, provided there
     *                               is no currently logged in account.
     * @return mixed The array of preferences if $return is true, otherwise null.
     */
    function loadPreferences($loadExtraInfo = false, $return = false, $parentOnly = false, $loadAdminOnly = false, $accountId = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Ensure $parentOnly and $loadAdminOnly are correctly set
        if ($parentOnly && $loadAdminOnly) {
            // Cannot both be true!
            OA_Preferences::_unsetPreferences();
            return;
        }
        // Only worry about the current account type and if a user is logged
        // in if $loadAdminOnly == false
        if ($loadAdminOnly == false) {
            // Get the type of the current accout
            $currentAccountType = OA_Permission::getAccountType();
            // If no user logged in, and we are supposed to load a specific account's
            // preferences, load the account type of that specific account
            if (empty($currentAccountType) && is_numeric($accountId)) {
                // Get the account type for the specified account
                $doAccounts = OA_Dal::factoryDO('accounts');
                $doAccounts->account_id = $accountId;
                $doAccounts->find();
                if ($doAccounts->getRowCount() > 0) {
                    $aCurrentAccountType = $doAccounts->getAll(array('account_type'), false, true);
                    $currentAccountType = $aCurrentAccountType[0];
                }
            }
            // If (still) no user logged in or invalid specific account, return
            if (is_null($currentAccountType) || $currentAccountType == false) {
                OA_Preferences::_unsetPreferences();
                return;
            }
        }
        // Get all of the preference types that exist
        $doPreferences = OA_Dal::factoryDO('preferences');
        $aPreferenceTypes = $doPreferences->getAll(array(), true);
        // Are there any preference types in the system?
        if (empty($aPreferenceTypes)) {
            OA_Preferences::_unsetPreferences();
            return;
        }
        // Get the admin account's ID, as this will be required
        $adminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');
        // Get the admin account's preferences, as these are always required
        $aAdminPreferenceValues = OA_Preferences::_getPreferenceValues($adminAccountId);
        if (empty($aAdminPreferenceValues)) {
            OA_Preferences::_unsetPreferences();
            return;
        }
        // Prepare an array to store the preferences that should
        // eventually be set in the global array
        $aPreferences = array();
        // Put the admin account's preferences into the temporary
        // storage array for preferences
        if ($loadAdminOnly == true || !($currentAccountType == OA_ACCOUNT_ADMIN && $parentOnly)) {
            OA_Preferences::_setPreferences($aPreferences, $aPreferenceTypes, $aAdminPreferenceValues, $loadExtraInfo);
        }
        // Is the current account NOT the admin account?
        if ($loadAdminOnly == false && $currentAccountType != OA_ACCOUNT_ADMIN) {
            // Is the current account not a manager account?
            if ($currentAccountType == OA_ACCOUNT_MANAGER) {
                // This is a manager account
                if (!$parentOnly) {
                    // Locate the owning manager account ID
                    if (!is_numeric($accountId)) {
                        $managerAccountId = OA_Permission::getAccountId();
                    } else {
                        $managerAccountId = $accountId;
                    }
                    if ($managerAccountId == 0) {
                        OA_Preferences::_unsetPreferences();
                        return;
                    }
                    // Get the manager account's preference values
                    $aManagerPreferenceValues = OA_Preferences::_getPreferenceValues($managerAccountId);
                    // Merge the preference values into the temporary
                    // storage array for preferences
                    OA_Preferences::_setPreferences($aPreferences, $aPreferenceTypes, $aManagerPreferenceValues, $loadExtraInfo);
                }
            } else {
                // This must be an advertiser or trafficker account, so
                // need to locate the manager account that "owns" this account
                if (!is_numeric($accountId)) {
                    $owningAgencyId = OA_Permission::getAgencyId();
                } else {
                    $owningAgencyId = 0;
                    if ($currentAccountType == OA_ACCOUNT_ADVERTISER) {
                        $doClients = OA_Dal::factoryDO('clients');
                        $doClients->account_id = $accountId;
                        $doClients->find();
                        if ($doClients->getRowCount() == 1) {
                            $aOwningAgencyId = $doClients->getAll(array('agencyid'), false, true);
                            $owningAgencyId = $aOwningAgencyId[0];
                        }
                    } else if ($currentAccountType == OA_ACCOUNT_TRAFFICKER) {
                        $doAffiliates = OA_Dal::factoryDO('affiliates');
                        $doAffiliates->account_id = $accountId;
                        $doAffiliates->find();
                        if ($doAffiliates->getRowCount() == 1) {
                            $aOwningAgencyId = $doAffiliates->getAll(array('agencyid'), false, true);
                            $owningAgencyId = $aOwningAgencyId[0];
                        }
                    }
                }
                if ($owningAgencyId == 0) {
                    OA_Preferences::_unsetPreferences();
                    return;
                }
                $doAgency = OA_Dal::factoryDO('agency');
                $doAgency->agencyid = $owningAgencyId;
                $doAgency->find();
                if ($doAgency->getRowCount() == 1) {
                    // The manager account "owning" the advertiser or
                    // trafficker account has some preferences that
                    // override the admin account preferences
                    $aManagerAccountId = $doAgency->getAll(array('account_id'), false, true);
                    $managerAccountId = $aManagerAccountId[0];
                    // Get the manager account's preference values
                    $aManagerPreferenceValues = OA_Preferences::_getPreferenceValues($managerAccountId);
                    // Merge the preference values into the temporary
                    // storage array for preferences
                    OA_Preferences::_setPreferences($aPreferences, $aPreferenceTypes, $aManagerPreferenceValues, $loadExtraInfo);
                }
                if (!$parentOnly) {
                    // Get the current account's ID
                    if (!is_numeric($accountId)) {
                        $currentAccountId = OA_Permission::getAccountId();
                    } else {
                        $currentAccountId = $accountId;
                    }
                    if ($currentAccountId <= 0) {
                        OA_Preferences::_unsetPreferences();
                        return;
                    }
                    // Get the current account's preference values
                    $aCurrentPreferenceValues = OA_Preferences::_getPreferenceValues($currentAccountId);
                    // Merge the preference values into the temporary
                    // storage array for preferences
                    OA_Preferences::_setPreferences($aPreferences, $aPreferenceTypes, $aCurrentPreferenceValues, $loadExtraInfo);
                }
            }
        }

        // Set the initial (default) language to conf value or english
        $aPreferences['language'] = (!empty($aConf['max']['language'])) ? $aConf['max']['language'] : 'en';

        // Add user preferences (currently language) to the prefs array
        if ($userId = OA_Permission::getUserId()) {
            $doUser = OA_Dal::factoryDO('users');
            $doUser->get('user_id', $userId);
            if (!empty($doUser->language)) {
                $aPreferences['language'] = $doUser->language;
            }
        }

        // Return or store the preferences
        if ($return) {
            return $aPreferences;
        } else {
            $GLOBALS['_MAX']['PREF'] = $aPreferences;
        }
    }

    /**
     * This method is a simplification of loadPreferences()
     * It is created mostly because of the performance reasons.
     * The method loads given preferences in given account only.
     *
     * It doesn't take into account any preferences cascading so
     * before using this method be sure that the performance you are
     * looking for can't cascade (this is often the case for the preferences
     * which are available only in given accounts).
     *
     * This method uses by default static in-memory caching to improve
     * the speed of reading in the preferences - this is helpful in maintenance
     * where admin preferences can be read in many places and many times.
     *
     */
    function loadPreferencesByNameAndAccount($accountId, $aPreferencesNames, $accountType, $useCache = true)
    {
        $aPrefs = OA_Preferences::cachePreferences($accountId, $aPreferencesNames);
        if (count($aPrefs) == count($aPreferencesNames)) {
            return $aPrefs;
        }
        $aPrefsIds = OA_Preferences::getCachedPreferencesIds($aPreferencesNames, $accountType);
        $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_preference_assoc->account_id = $accountId;
        $doAccount_preference_assoc->whereInAdd('preference_id', $aPrefsIds);
        $doAccount_preference_assoc->find();
        $aPrefs = array();
        $prefsIdsFlip = array_flip($aPrefsIds);
        while($doAccount_preference_assoc->fetch()) {
            $aPrefs[$prefsIdsFlip[$doAccount_preference_assoc->preference_id]] = $doAccount_preference_assoc->value;
        }
        OA_Preferences::cachePreferences($accountId, $aPrefs);
        return $aPrefs;
    }

    /**
     * Returns preferences ids for correspodnding preferences names.
     * This method is handy when many requests to different accounts for
     * the same preferences are made. Next time the same preferences for
     * the same account are checked the cached preferences ids may be used.
     *
     * This is useful esepcially in MPE which checks various preferences
     * for many accounts.
     *
     * @param array $aPrefNames  Array containing preference names
     * @param string $accountType  Account type
     * @return array  Array which contains preferences ids (preference_name => preference_id)
     */
    function getCachedPreferencesIds($aPrefNames, $accountType)
    {
        // keep preferences ids in static memory cache
        static $aPrefIdsCache;
        $aPrefFound = array();
        $aPrefNotFound = array();
        foreach ($aPrefNames as $prefName) {
            if (isset($aPrefIdsCache[$accountType][$prefName])) {
                $aPrefFound[$prefName] = $aPrefIdsCache[$accountType][$prefName];
            } else {
                $aPrefNotFound[$prefName] = $prefName;
            }
        }
        if (!empty($aPrefNotFound)) {
            // read in any leftover preferences ids, needs to be done in the same method due
            // to static variables limitations
            $aPrefs = OA_Preferences::getPreferenceIds($aPrefNotFound, $accountType);
            if (is_array($aPrefs)) {
                foreach ($aPrefs as $prefName => $prefId) {
                    $aPrefIdsCache[$accountType][$prefName] = $prefId;
                    $aPrefFound[$prefName] = $prefId;
                }
            }
        }
        return $aPrefFound;
    }

    /**
     * Gets ids of preferences from database
     *
     * Returns array:
     * preference_id => preference_name
     *
     * @param array $aPrefNames  Contains (as values) preferences names
     * @param string $accountType  Account type
     * @return array  Array which contains preference ids
     */
    function getPreferenceIds($aPrefNames, $accountType)
    {
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->account_type = $accountType;
        $doPreferences->whereInAdd('preference_name', $aPrefNames);
        return $doPreferences->getAll(array('preference_id'), 'preference_name');
    }

    /**
     * Caches preferences for given accountId in static variable.
     * Useful especially in maintenance which reads often same preferences
     * in various places
     *
     * Note that not all preferences which are requested in $aPreferences may be
     * stored in cache. In that case only stored preferences are returned.
     *
     * @param int $accountId  Account id
     * @param array $aPreferences  Array of preferences to look for (or sto store)
     * @param boolean $readOnly  If true the existing preferences are returned, if false
     *                           the method replaces cached preferences with $aPreferences
     * @return array  Cached preferences
     */
    function cachePreferences($accountId, $aPreferences, $readOnly = true, $cleanCache = false)
    {
        static $aCache = array();
        if ($cleanCache) {
            $aCache = array();
            return $aCache;
        }

        if ($readOnly) {
            // Just read cache - read and write needs to be done in the same method due to
            //                   static variables limitations
            $prefsFound = array();
            foreach ($aPreferences as $prefName) {
                if (isset($aCache[$accountId][$prefName])) {
                    $prefsFound[$prefName] = $aCache[$accountId][$prefName];
                }
            }
            return $prefsFound;
        } else {
            // Set the cache
            foreach ($aPreferences as $prefName => $prefValue) {
                $aCache[$accountId][$prefName] = $prefValue;
            }
            return $aPreferences;
        }
    }

    /**
     * A static method to load the admin account's preferences from the
     * database and store them in the global array $GLOBALS['_MAX']['PREF'].
     *
     * Intended to be used to load "default" preferences in situations where
     * there is no currently logged in account - that is, in certain cases
     * in the delivery engine, for example!
     *
     * @static
     * @param boolean $return An optional parameter, when set to true,
     *                        returns the preferences instead of setting
     *                        them into $GLOBALS['_MAX']['PREF'].
     * @return mixed The array of preferences if $return is true, otherwise null.
     */
    function loadAdminAccountPreferences($return = false)
    {
        if ($return) {
            // Return the admin account's preferences
            $aPrefs = OA_Preferences::loadPreferences(false, true, false, true);
            return $aPrefs;
        } else {
            // Load the admin account's preferences
            OA_Preferences::loadPreferences(false, false, false, true);
        }
    }

    /**
     * A static method to load the preferences from the database and store them
     * in the global array $GLOBALS['_MAX']['PREF'] for a given account ID.
     *
     * Intended to be used to load account preferences in situations where
     * there is no currently logged in account - that is, in certain cases
     * in the maintenance engine, for example!
     *
     * @static
     * @param integer $accountId The account ID to load the preferences of.
     * @param boolean $return    An optional parameter, when set to true,
     *                           returns the preferences instead of setting
     *                           them into $GLOBALS['_MAX']['PREF'].
     * @return mixed The array of preferences if $return is true, otherwise null.
     */
    function loadAccountPreferences($accountId, $return = false)
    {
        if ($return) {
            // Return the account's preferences
            $aPrefs = OA_Preferences::loadPreferences(false, true, false, false, $accountId);
            return $aPrefs;
        } else {
            // Load the account's preferences
            OA_Preferences::loadPreferences(false, false, false, false, $accountId);
        }
    }

    /**
     * A static method for processing preference values from a UI form, and
     * updating the preference values in the database.
     *
     * @static
     * @param array $aElementNames An array of HTML form element names, which
     *                             are also the preference value names.
     * @param array $aCheckboxes   An array of the above HTML form element
     *                             names which are checkboxes, as these will not
     *                             be set in the form POST if unchecked, and
     *                             so need to be treated differently.
     * @return boolean True on success, false otherwise.
     */
    function processPreferencesFromForm($aElementNames, $aCheckboxes)
    {
        phpAds_registerGlobalUnslashed('token');
        if (!phpAds_SessionValidateToken($GLOBALS['token'])) { return false; }

        // Get all of the preference types that exist
        $aPreferenceTypes = array();
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->find();
        if ($doPreferences->getRowCount() < 1) {
            return false;
        }
        while ($doPreferences->fetch()) {
            $aPreference = $doPreferences->toArray();
            $aPreferenceTypes[$aPreference['preference_name']] = array(
                'preference_id' => $aPreference['preference_id'],
                'account_type'  => $aPreference['account_type']
            );
        }
        // Are there any preference types in the system?
        if (empty($aPreferenceTypes)) {
            return false;
        }
        // Get the type of the current accout
        $currentAccountType = OA_Permission::getAccountType();
        // Get the current account's ID
        $currentAccountId = OA_Permission::getAccountId();
        // Get the parent account preferences
        $aParentPreferences = OA_Preferences::loadPreferences(false, true, true);
        // Prepare the preference values that should be saved or deleted
        $aSavePreferences = array();
        $aDeletePreferences = array();
        foreach ($aElementNames as $preferenceName) {
            // Ensure that the current account has permission to process
            // the preference type
            $access = OA_Preferences::hasAccess($currentAccountType, $aPreferenceTypes[$preferenceName]['account_type']);
            if ($access == false) {
                // Don't process this value
                continue;
            }
            // Register the HTML element value
            phpAds_registerGlobalUnslashed($preferenceName);
            // Is the HTML element value a checkbox, and unset?
            if (isset($aCheckboxes[$preferenceName]) && !isset($GLOBALS[$preferenceName])) {
                // Set the value of the element to the false string ""
                $GLOBALS[$preferenceName] = '';
            } else if (isset($aCheckboxes[$preferenceName]) && $GLOBALS[$preferenceName]) {
                // Set the value of the element to the true string "1"
                $GLOBALS[$preferenceName] = '1';
            }
            // Was the HTML element value set?
            if (isset($GLOBALS[$preferenceName])) {
                // Is the preference value different from the parent value?
                if (!isset($aParentPreferences[$preferenceName]) ||
                           $GLOBALS[$preferenceName] != $aParentPreferences[$preferenceName]) {
                    // The preference value is different from the parent, so it
                    // needs to be stored
                    $aSavePreferences[$preferenceName] = $GLOBALS[$preferenceName];
                } else if ($currentAccountType != OA_ACCOUNT_ADMIN) {
                    // The preference value is not different from the parent, so
                    // it should be deleted if not the admin account (in case it
                    // exists for the account, and so would not inherit correctly
                    // if the admin account changes preferences)
                    $aDeletePreferences[$preferenceName] = $GLOBALS[$preferenceName];
                }
            }
        }
        // Save the required preferences
        foreach ($aSavePreferences as $preferenceName => $preferenceValue) {
            $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
            $doAccount_preference_assoc->account_id = $currentAccountId;
            $doAccount_preference_assoc->preference_id = $aPreferenceTypes[$preferenceName]['preference_id'];
            $doAccount_preference_assoc->find();
            if ($doAccount_preference_assoc->getRowCount() != 1) {
                // Insert the preference
                $doAccount_preference_assoc->value = $preferenceValue;
                $result = $doAccount_preference_assoc->insert();
                if ($result === false) {
                    return false;
                }
            } else {
                // Update the preference
                $doAccount_preference_assoc->fetch();
                $doAccount_preference_assoc->value = $preferenceValue;
                $result = $doAccount_preference_assoc->update();
                if ($result === false) {
                    return false;
                }
            }
        }
        // Delete the required preferences
        foreach ($aDeletePreferences as $preferenceName => $preferenceValue) {
            $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
            $doAccount_preference_assoc->account_id = $currentAccountId;
            $doAccount_preference_assoc->preference_id = $aPreferenceTypes[$preferenceName]['preference_id'];
            $doAccount_preference_assoc->find();
            if ($doAccount_preference_assoc->getRowCount() == 1) {
                // Delete the preference
                $result = $doAccount_preference_assoc->delete();
                if ($result === false) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * A method to test if a given current account level has access to utilise and/or
     * process a given preference level.
     *
     * @param string $currentAccount  The current acccount level.
     * @param string $preferenceLevel The preference level, or null or the empty string
     *                                if there is no preference level.
     * @return boolean True if the current account can access/process the preference
     *                 level, false otherwise.
     */
    function hasAccess($currentAccount, $preferenceLevel) {
        // If there is no preference level, any account can use/process
        if (is_null($preferenceLevel) || $preferenceLevel == '') {
            return true;
        }
        // If the current account is admin, all preferences can be used/processed
        if ($currentAccount == OA_ACCOUNT_ADMIN) {
            return true;
        }
        // If the current account if a manager, all preferences other than the
        // admin preferences can be used/processed
        if ($currentAccount == OA_ACCOUNT_MANAGER) {
            if ($preferenceLevel == OA_ACCOUNT_ADMIN) {
                return false;
            }
            return true;
        }
        // If the current account is an advertiser or trafficker, then only
        // their types of preferences can be used/processed
        if ($currentAccount == OA_ACCOUNT_ADVERTISER && $preferenceLevel == OA_ACCOUNT_ADVERTISER) {
            return true;
        }
        if ($currentAccount == OA_ACCOUNT_TRAFFICKER && $preferenceLevel == OA_ACCOUNT_TRAFFICKER) {
            return true;
        }
        return false;
    }

    /**
     * A method to disable all of the supplied columns from being displayed
     * by *any* user in the system, should they have set those columns to
     * be displayed.
     *
     * Can only be called by the admin account.
     *
     * @param array $aColumns An array of the "primary" statistics column
     *                        names (i.e. less the "_label" and "_rank" suffixes)
     *                        that need to be disabled.
     */
    function disableStatisticsColumns($aColumns)
    {
        // Ensure that this method is only ever called by the admin account
        $currentAccountType = OA_Permission::getAccountType();
        if ($currentAccountType != OA_ACCOUNT_ADMIN) {
            return;
        }
        // Disable the required columns
        foreach ($aColumns as $preference) {
            // Obtain the preference ID value for the column
            $doPreferences = OA_Dal::factoryDO('preferences');
            $doPreferences->preference_name = $preference;
            $doPreferences->find();
            if ($doPreferences->getRowCount() != 1) {
                // Could not locate the statistics column in the preferences
                // table, so suspect that it does not exist, go to next column
                continue;
            }
            $doPreferences->fetch();
            $aColumnPreference = $doPreferences->toArray();
            $columnPreferenceId = $aColumnPreference['preference_id'];
            // Update any instances of this preference ID so that
            // the column is disabled, but without making any other
            // changes to custom rank values or column names
            $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
            $doAccount_preference_assoc->preference_id = $columnPreferenceId;
            $doAccount_preference_assoc->find();
            while ($doAccount_preference_assoc->fetch()) {
                $doAccount_preference_assoc->value = 0;
                $doAccount_preference_assoc->update();
            }
        }
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
     *                                 preference values will be one of two formats, depending
     *                                 on the value of the $aPreferences parameter. When false,
     *                                 the array will be:
     *
     *      array(
     *          'preference_name' => 'Preference Value',
     *          .
     *          .
     *          .
     *      )
     *
     *                                 When true, the array will be:
     *
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
     * @param boolean $loadExtraInfo   See the $aPreferences parameter.
     */
    function _setPreferences(&$aPreferences, $aPreferenceTypes, $aPreferenceValues, $loadExtraInfo)
    {
        // Loop over each preference value
        foreach ($aPreferenceValues as $aPreferenceValue) {
            // Is the preference_id value for the preference value valid?
            if (isset($aPreferenceTypes[$aPreferenceValue['preference_id']])) {
                // This is a valid preference value, so store it
                if (!$loadExtraInfo) {
                    $aPreferences[$aPreferenceTypes[$aPreferenceValue['preference_id']]['preference_name']] =
                        $aPreferenceValue['value'];
                } else {
                    $aPreferences[$aPreferenceTypes[$aPreferenceValue['preference_id']]['preference_name']] =
                        array(
                            'account_type' => $aPreferenceTypes[$aPreferenceValue['preference_id']]['account_type'],
                            'value'        => $aPreferenceValue['value']
                        );
                }
            }
        }
        // If extra information is being loaded, ensure all preference types are set
        if ($loadExtraInfo) {
            foreach ($aPreferenceTypes as $aPreferenceType) {
                if (!isset($aPreferences[$aPreferenceType['preference_name']])) {
                    $aPreferences[$aPreferenceType['preference_name']]['account_type'] = $aPreferenceType['account_type'];
                }
            }
        }
    }

    /**
     * A static method which returns defaults and account_types for the supported preferences
     *
     * @static
     *
     * @return array A preferences array, with the following format:
     *
     *      array(
     *          'preference_name' => array(
     *              'account_type' => OA_ACCOUNT_MANAGER,
     *              'default'      => 'foo'
     *          ),
     *          ...
     *      )
     */
    function getPreferenceDefaults()
    {
        $aPrefs = array(
            'default_banner_image_url'                      => array('account_type' => OA_ACCOUNT_TRAFFICKER,   'default' => ''),
            'default_banner_destination_url'                => array('account_type' => OA_ACCOUNT_TRAFFICKER,   'default' => ''),
            'default_banner_weight'                         => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => 1),
            'default_campaign_weight'                       => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => 1),
            'warn_email_admin'                              => array('account_type' => OA_ACCOUNT_ADMIN,        'default' => true),
            'warn_email_admin_impression_limit'             => array('account_type' => OA_ACCOUNT_ADMIN,        'default' => 100),
            'warn_email_admin_day_limit'                    => array('account_type' => OA_ACCOUNT_ADMIN,        'default' => 1),
            'campaign_ecpm_enabled'                         => array('account_type' => OA_ACCOUNT_MANAGER,      'default' => false),
            'contract_ecpm_enabled'                         => array('account_type' => OA_ACCOUNT_MANAGER,      'default' => false),
            'warn_email_manager'                            => array('account_type' => OA_ACCOUNT_MANAGER,      'default' => true),
            'warn_email_manager_impression_limit'           => array('account_type' => OA_ACCOUNT_MANAGER,      'default' => 100),
            'warn_email_manager_day_limit'                  => array('account_type' => OA_ACCOUNT_MANAGER,      'default' => 1),
            'warn_email_advertiser'                         => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => true),
            'warn_email_advertiser_impression_limit'        => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => 100),
            'warn_email_advertiser_day_limit'               => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => 1),
            'timezone'                                      => array('account_type' => OA_ACCOUNT_MANAGER,      'default' => ''),
            'tracker_default_status'                        => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => MAX_CONNECTION_STATUS_APPROVED),
            'tracker_default_type'                          => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => MAX_CONNECTION_TYPE_SALE),
            'tracker_link_campaigns'                        => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => false),
            'ui_show_campaign_info'                         => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => true),
            'ui_show_banner_info'                           => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => true),
            'ui_show_campaign_preview'                      => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => false),
            'ui_show_banner_html'                           => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => false),
            'ui_show_banner_preview'                        => array('account_type' => OA_ACCOUNT_ADVERTISER,   'default' => true),
            'ui_hide_inactive'                              => array('account_type' => null,                    'default' => false),
            'ui_show_matching_banners'                      => array('account_type' => OA_ACCOUNT_TRAFFICKER,   'default' => true),
            'ui_show_matching_banners_parents'              => array('account_type' => OA_ACCOUNT_TRAFFICKER,   'default' => false),
            'ui_show_entity_id'                             => array('account_type' => null,                    'default' => false),
            'ui_novice_user'                                => array('account_type' => null,                    'default' => true),
            'ui_week_start_day'                             => array('account_type' => null,                    'default' => 1),
            'ui_percentage_decimals'                        => array('account_type' => null,                    'default' => 2),
        );

        require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery/Affiliates.php';
        require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery/Default.php';

        $aStatisticsFieldsDelivery['affiliates'] = new OA_StatisticsFieldsDelivery_Affiliates();
        $aStatisticsFieldsDelivery['default'] = new OA_StatisticsFieldsDelivery_Default();

        foreach ($aStatisticsFieldsDelivery as $obj) {
            foreach (array_keys($obj->getVisibilitySettings()) as $prefName) {
                $aPrefs[$prefName]          = array('account_type' => OA_ACCOUNT_MANAGER, 'default' => false);
                $aPrefs[$prefName.'_label'] = array('account_type' => OA_ACCOUNT_MANAGER, 'default' => '');
                $aPrefs[$prefName.'_rank']  = array('account_type' => OA_ACCOUNT_MANAGER, 'default' => 0);
            }
        }

        $aDefaultColumns = array(
            'ui_column_impressions',
            'ui_column_clicks',
            'ui_column_ctr',
            'ui_column_revenue',
            'ui_column_ecpm',
        );

        $rank = 1;
        foreach ($aDefaultColumns as $prefName) {
            if (isset($aPrefs[$prefName])) {
                $aPrefs[$prefName]['default']         = true;
                $aPrefs[$prefName.'_rank']['default'] = $rank++;
            }
        }

        return $aPrefs;
    }

}

?>
