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

    function OA_Admin_SectionPermissionChecker($aPermissions = array())
    {
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