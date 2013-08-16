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

/**
 * @package    OpenXDll
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


// Required permission class
require_once MAX_PATH . '/lib/OA/Permission.php';

// Required parent class
require_once MAX_PATH . '/lib/OA/BaseObjectWithErrors.php';
require_once MAX_PATH . '/lib/pear/Date.php';


// Standard statuses
define('OA_ENTITY_STATUS_RUNNING',                0);
define('OA_ENTITY_STATUS_PAUSED',                 1);
define('OA_ENTITY_STATUS_AWAITING',               2);
define('OA_ENTITY_STATUS_EXPIRED',                3);
define('OA_ENTITY_STATUS_INACTIVE',               4);

// Special status which has always to be used when the entity is inactive for a remote reason
define('OA_ENTITY_STATUS_PENDING',               10);

// Advertiser signup statuses
define('OA_ENTITY_STATUS_APPROVAL',              21);
define('OA_ENTITY_STATUS_REJECTED',              22);


/**
 *
 * Base class for all Domain Logical Layer classes.
 *
 */
class OA_Dll extends OA_BaseObjectWithErrors
{
    var $aAllowTraffickerAndAbovePerm = array(
        OA_ACCOUNT_MANAGER,
        OA_ACCOUNT_TRAFFICKER
    );
    var $aAllowAdvertiserAndAbovePerm = array(
        OA_ACCOUNT_MANAGER,
        OA_ACCOUNT_ADVERTISER
    );

    /**
     * Email Address Validation.
     *
	 * @access public
	 *
     * @param string $emailAddress  Email Address
     *
     * @return boolean  Returns true if email is valid and false in other case.
     */
    function checkEmail($emailAddress)
    {
        if (!eregi('^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$', $emailAddress)) {
	        $this->raiseError('Email is not valid');
	        return false;
        }
        return true;
    }

    /**
     * Checks required string field in structure.
     *
	 * @access public
	 *
     * @param structure &$oStructure  Structure to check
     * @param string $fieldName       Field name in structure to check
     * @param integer $maxLength      Max length of the field. If -1 -
     *                                  there is no maximum length
     *
     * @return boolean  Returns true when field exists and length is valid and
     * false in other case.
     */
    function checkStructureRequiredStringField(&$oStructure, $fieldName, $maxLength = -1)
    {
        if (!isset($oStructure->$fieldName)) {
            $this->raiseError('Field \''. $fieldName .'\' in structure does not exists');
            return false;
        }

        if (empty($oStructure->$fieldName))
        {
            $this->raiseError('Data \''. $fieldName .'\' in structure is empty');
            return false;
        }

        if (!$this->checkStructureNotRequiredStringField($oStructure, $fieldName, $maxLength)) {
            return false;
        }

        return true;
    }

    /**
     * Checks not required string field in structure.
     *
	 * @access public
	 *
     * @param structure &$oStructure  Structure to check
     * @param string $fieldName       Field name in structure to check
     * @param integer $maxLength      Max length of the field. If -1 -
     *                                 there is no maximum length
     *
     * @return boolean  Returns true when field exists and length is valid.
     *          Also returns true when field doesn't exist and false in other case.
     */
    function checkStructureNotRequiredStringField(&$oStructure, $fieldName, $maxLength = -1)
    {
        if (isset($oStructure->$fieldName)) {
            if (!is_string($oStructure->$fieldName)) {
                $this->raiseError('Field \''. $fieldName .'\' is not string');
                return false;
            }
            if ($maxLength != -1 and strlen($oStructure->$fieldName) > $maxLength) {
                $this->raiseError('Exceed Maximum length of field \''. $fieldName .'\'');
                return false;
            }
        }

        return true;
    }

    /**
     * Checks required integer field in structure.
     *
	 * @access public
	 *
     * @param structure &$oStructure  Structure to check
     * @param string $fieldName       Field name in structure to check
     *
     * @return boolean  Returns true when field exists and is integer, and false in other case.
     */
    function checkStructureRequiredIntegerField(&$oStructure, $fieldName)
    {
        if (!isset($oStructure->$fieldName)) {
            $this->raiseError('Field \''. $fieldName .'\' in structure does not exists');
            return false;
        }

        if (!$this->checkStructureNotRequiredIntegerField($oStructure, $fieldName)) {
            return false;
        }

        return true;
    }

    /**
     * Checks not required integer field in structure.
     *
	 * @access public
	 *
     * @param structure &$oStructure  Structure to check
     * @param string $fieldName       Field name in structure to check
     *
     * @return boolean  Returns true when field exists and is integer.
     *                      Also returns true when field doesn't exist, and returns false in other case.
     */
    function checkStructureNotRequiredIntegerField(&$oStructure, $fieldName)
    {
        if (isset($oStructure->$fieldName)) {
            if (!is_integer($oStructure->$fieldName)) {
                $this->raiseError('Field \''.$fieldName.'\' is not integer');
                return false;
            }
        }
        return true;
    }

    /**
     * Checks required double field in structure.
     *
	 * @access public
	 *
     * @param structure &$oStructure  Structure to check
     * @param string $fieldName       Field name in structure to check
     *
     * @return boolean  Returns true when field exists and is double, and false in other case.
     */
    function checkStructureRequiredDoubleField(&$oStructure, $fieldName)
    {
        if (!isset($oStructure->$fieldName)) {
            $this->raiseError('Field \''. $fieldName .'\' in structure does not exists');
            return false;
        }

        if (!$this->checkStructureNotRequiredDoubleField($oStructure, $fieldName)) {
            return false;
        }

        return true;
    }

    /**
     * Checks not required double field in structure.
     *
	 * @access public
	 *
     * @param structure &$oStructure  Structure to check
     * @param string $fieldName       Field name in structure to check
     *
     * @return boolean  Returns true when field exists and is a double.
     *                  Also returns true when field doesn't exist, and returns false in other case.
     */
    function checkStructureNotRequiredDoubleField(&$oStructure, $fieldName)
    {
        if (isset($oStructure->$fieldName)) {
            if (!is_double($oStructure->$fieldName)) {
                $this->raiseError('Field \''.$fieldName.'\' is not double ' . gettype($fieldName));
                return false;
            }
        }
        return true;
    }

    /**
     * Checks required boolean field in structure.
     *
     * @param structure &$oStructure  Structure to check
     * @param string $fieldName       Field name in structure to check
     *
     * @return boolean  Returns true when field exists and it is boolean.
     *                      And returns false in other case.
     */
    function checkStructureRequiredBooleanField(&$oStructure, $fieldName)
    {
        if (!isset($oStructure->$fieldName)) {
            $this->raiseError('Field \''. $fieldName .'\' in structure does not exists');
            return false;
        }

        if (!$this->checkStructureNotRequiredIntegerField($oStructure, $fieldName)) {
            return false;
        }

        return true;
    }

    /**
     * Checks not required boolean field in structure.
     *
     * @param structure &$oStructure  Structure to check
     * @param string $fieldName       Field name in structure to check
     *
     * @return boolean  Returns true when field exists and it is boolean.
     *                      Also returns true when field doesn't exists.
     *                      And returns false in other case.
     */
    function checkStructureNotRequiredBooleanField(&$oStructure, $fieldName)
    {
        if (isset($oStructure->$fieldName)) {
            if (!is_bool($oStructure->$fieldName)) {
                $this->raiseError('Field \''.$fieldName.'\' is not boolean');
                return false;
            }
        }
        return true;
    }

    /**
     * Checks whether end date is after start date.
     *
	 * @access public
	 *
     * @param date $oStartDate  Pear::Date object with Start Date
     * @param date $oEndDate    Pear::Date object with End Date
     *
     * @return boolean  Returns false when start date
     *                      is after end date and true in other case.
     */
    function checkDateOrder($oStartDate, $oEndDate)
    {
        if ((isset($oStartDate) && isset($oEndDate)) &&
            (($oStartDate->format("%Y-%m-%d") != '0000-00-00') &&
            ($oEndDate->format("%Y-%m-%d") != '0000-00-00')) &&
            $oStartDate->after($oEndDate)) {

        	$this->raiseError('The start date is after the end date');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Checks if record for object exists in database.
     *
	 * @access public
	 *
     * @param string $table  Table name in database
     * @param integer $id    Id of the row in database
     *
     * @return boolean  True if exists
     */
    function checkIdExistence($table, $id)
    {
        switch ($table) {
            default:
                $tableId = $table;
                break;
            case 'accounts' :
                $tableId = 'account';
                break;
            case 'affiliates' :
                $tableId = 'publisher';
                break;
            case 'clients' :
                $tableId = 'advertiser';
                break;
            case 'banners' :
                $tableId = 'banner';
                break;
            case 'zones' :
                $tableId = 'zone';
                break;
            case 'campaigns' :
                $tableId = 'campaign';
                break;
            case 'users' :
                $tableId = 'user';
                break;
            case 'trackers' :
                $tableId = 'tracker';
                break;
            case 'variables' :
                $tableId = 'variable';
                break;
        }

        $doObject = OA_Dal::factoryDO($table);
        if (empty($id) || !($object= $doObject->get($id))) {
	        $this->raiseError('Unknown '.$tableId.'Id Error');
	        return false;
        } else {
            return true;
        }

    }

    /**
     * Username Password validation.
     *
	 * @access public
	 *
     * @param string $username
     * @param string $password
     *
     * @return boolean  True if allowed
     */
    function validateUsernamePassword($username, $password)
    {
        if (isset($username) && (strlen($username) == 0)) {
        	$this->raiseError('Username is fewer than 1 character');
	        return false;
        }

        if (!isset($username) && (strlen($password) > 0)) {
        	$this->raiseError('Username is null and the password is not');
	        return false;
        }

        if (strpos($password,'\\')) {
        	$this->raiseError('Passwords cannot contain "\\"');
	        return false;
        } else

        return true;

    }

	/**
	 * Checks if user has access to specific area (for example admin or agency area)
	 * Permissions are defined in www/admin/lib-permissions.inc.php file
	 *
	 * @access public
	 *
	 * @param integer $permissions
	 * @param string $table  Table name
	 * @param integer $id  Id (or empty if new is created)
	 * @param unknown $allowed  check allowed
	 * @param OA_Permission Does the current call require only a subset of the permissions?
	 * 						If set to null, equivalent to asking permission to do everything on the object
	 *
	 * @return boolean  True if has access
	 */
    function checkPermissions($permissions, $table = '', $id = null, $allowed = null, $operationAccessType = OA_Permission::OPERATION_ALL) {
        $isError = false;
        if (isset($permissions) && !OA_Permission::isAccount($permissions)) {
            if (!OA_Permission::attemptToSwitchToAccount($permissions)) {
                $isError = true;
            }
        }

        // Should this check also be part of checkPermissions?
        if (!empty($id) && !$this->checkIdExistence($table, $id)) {
            return false;
        }
        if (isset($id) && !OA_Permission::hasAccessToObject($table, $id, $operationAccessType)) {
            if (!OA_Permission::attemptToSwitchForAccess($table, $id)) {
                $isError = true;
            }
        }
        if (isset($allowed)) {
            if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER) && !OA_Permission::hasPermission($allowed)) {
                $isError = true;
            }
        }
        if ($isError) {
            $this->raiseError('Access forbidden');
            return false;
        } else {
            // Set system timezone and return
            OA_setTimeZoneLocal();
            return true;
        }
    }

    function getDefaultAgencyId()
    {
        return OA_Permission::getAgencyId();
    }

    function checkAgencyPermissions($agencyId)
    {
        if (!empty($agencyId)) {
            if (!$this->checkIdExistence('agency', $agencyId)) {
                return false;
            }
            if ($this->checkPermissions(OA_ACCOUNT_MANAGER, 'agency', $agencyId)) {
                return true;
            } elseif ($this->checkPermissions(array(OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER))) {
                return $agencyId == $this->getDefaultAgencyId();
            }
            $this->raiseError('Wrong AgencyId');
            return false;
        }

        return true;
    }

}

?>
