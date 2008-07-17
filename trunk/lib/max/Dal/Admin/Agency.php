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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';

class MAX_Dal_Admin_Agency extends MAX_Dal_Common
{
    var $table = 'agency';

    var $orderListName = array(
        'name' => 'name',
        'id'   => 'agencyid'
    );

    /**
     * If the agency has set the logout URL in a database, returns this URL
     * (trimmed).
     * Otherwise, returns 'index.php'.
     *
     * @param string $agencyId
     * @return string Url for redirection after logout.
     */
    function getLogoutUrl($agencyId)
    {
        $doAgency = null;
        if ($agencyId) {
            $doAgency = OA_Dal::staticGetDO('agency', $agencyId);
        }
        if ($doAgency && !empty($doAgency->logout_url)) {
            return trim($doAgency->logout_url);
        }
        return MAX::constructURL(MAX_URL_ADMIN, 'index.php');
    }

    /**
     * A method to retrieve a list of all manager account details.
     *
     * @param string  $listorder      The column name to sort the agency names by.
     *                                Either "name" or "id".
     * @param string  $orderdirection The sort oder for the sort column. Either
     *                                "up" or "down".
     * @return array An appropritately ordered array containing the manager account
     *               details (name, agency ID and account ID).
     */
    function getAllManagers($listorder, $orderdirection)
    {
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->addListOrderBy($listorder, $orderdirection);
        return $doAgency->getAll(array('name', 'agencyid', 'account_id'), $indexWitkPk = true, $flatten = false);
    }

}

?>