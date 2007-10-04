<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id:$
*/

/**
 * @package    OpenadsDll
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */

// Required permission class
require_once MAX_PATH . '/lib/max/Permission.php';

// Required parent class
require_once MAX_PATH . '/lib/OA/BaseObjectWithErrors.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 *
 * Base class for all Domain Logical Layer classes.
 *
 */
class OA_Dll extends OA_BaseObjectWithErrors
{

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
            (($oStartDate->format("%Y-%m-%d") != OA_Dal::noDateValue()) &&
            ($oEndDate->format("%Y-%m-%d") != OA_Dal::noDateValue())) &&
            $oStartDate->after($oEndDate)) {

        	$this->raiseError('The start date is after the end date');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Checks if username is still available and if it is allowed to use.
     *
	 * @access public
	 *
     * @param string $oldUsername
     * @param string $newUsername
     *
     * @return boolean  True if allowed
     */
    function checkUniqueUserName($oldUsername, $newUsername)
    {
        if (!isset($newUsername) || strlen($newUsername) == 0) {
            return true;
        }
        if (!MAX_Permission::isUsernameAllowed($oldUsername, $newUsername)) {
        	$this->raiseError('Username must be unique');
	        return false;
        }

        return true;
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
        }

        $doObject = OA_Dal::factoryDO($table);
        $object = $doObject->get($id);
        if (!$object) {
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
	 *
	 * @return boolean  True if has access
	 */
    function checkPermissions($permissions, $table = '', $id = null, $allowed = null) {
        $is_error = false;

        if (isset($permissions) && !MAX_Permission::hasAccess($permissions)) {
            $is_error = true;
        }

        if (isset($id) && !MAX_Permission::hasAccessToObject($table, $id)) {
            $is_error = true;
        }

        if (isset($allowed) && !MAX_Permission::isAllowed($allowed)) {
            $is_error = true;
        }

        if ($is_error) {
            $this->raiseError('Access forbidden');
            return false;
        } else {
            return true;
        }
    }

}

?>