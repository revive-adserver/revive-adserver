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
class OA_Admin_SectionPermissionChecker implements OA_Admin_Menu_IChecker
{
    public $aPermissions; //list of permissions user must have for the checker to be satisfied (only on of the list is required)

    public function __construct($aPermissions = [])
    {
        if (!is_array($aPermissions)) {
            $aPermissions = [$aPermissions];
        }
        $this->aPermissions = $aPermissions;
    }


    public function check($oSection)
    {
        $aPermissions = $this->_getAcceptedPermissions();

        //no required permissions, we can show the section
        if (empty($aPermissions)) {
            return true;
        }

        $hasRequiredPermission = false;
        foreach ($aPermissions as $i => $aPermission) {
            $hasRequiredPermission = OA_Permission::hasPermission($aPermission);
            if ($hasRequiredPermission) {
                break;
            }
        }

        return $hasRequiredPermission;
    }


    public function _getAcceptedPermissions()
    {
        return $this->aPermissions;
    }
}
