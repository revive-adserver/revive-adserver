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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/Common.php';

require_once LIB_PATH . '/Admin/Redirect.php';

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