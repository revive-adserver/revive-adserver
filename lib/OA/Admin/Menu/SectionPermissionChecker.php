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

require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

/**
 * An acceptor that takes into account permissions that are required to access the section.
 * - if the list of required permissions associated this acceptor is sempty, section gets accepted
 * - if the list is not empty current user must have at least one of the permissions required by this acceptor
 *
 */
class OA_Admin_SectionPermissionChecker
    implements OA_Admin_Menu_IChecker
{
    var $aPermissions; //list of permissions user must have for the checker to be satisfied (only on of the list is required)

    function __construct($aPermissions = array())
    {
        if (!is_array($aPermissions)) {
            $aPermissions = array($aPermissions);
        }
        $this->aPermissions = $aPermissions;
    }


    function check($oSection)
    {
        $aPermissions = $this->_getAcceptedPermissions();

        //no required permissions, we can show the section
        if (empty ($aPermissions)) {
            return true;
		}

        $hasRequiredPermission = false;
        for($i = 0; $i < count ( $aPermissions ); $i ++) {
            $hasRequiredPermission = OA_Permission::hasPermission ( $aPermissions [$i] );
            if ($hasRequiredPermission) {
                break;
            }
        }

        return $hasRequiredPermission;
	}


    function _getAcceptedPermissions()
    {
        return $this->aPermissions;
    }
}
?>