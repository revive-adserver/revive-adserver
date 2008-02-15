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

/**
 * A UI menu related methods
 *
 * @package    OpenXAdmin
 */
class OA_Admin_Menu
{
    /**
     * Gets list of other publishers and set a menu page context variable with them
     * Can be easily reused across inventory->publishers pages
     * 
     * TODO: Consider reading page name from automatically instead of passing it as a parameter
     *
     * @static 
     * @param integer $affiliateid  Affiliate ID
     * @param string $pageName  
     * @param string $sortPageName
     */
    function setPublisherPageContext($affiliateid, $pageName, $sortPageName = 'affiliate-index.php')
    {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = OA_Permission::getAgencyId();
        if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $doAffiliates->affiliateid = $affiliateid;
        }
        $doAffiliates->addSessionListOrderBy($sortPageName);
        $doAffiliates->find();
        while ($doAffiliates->fetch()) {
            phpAds_PageContext(
                phpAds_buildAffiliateName ($doAffiliates->affiliateid, $doAffiliates->name),
                "$pageName?affiliateid=".$doAffiliates->affiliateid,
                $affiliateid == $doAffiliates->affiliateid
            );
        }
    }

    /**
     * Gets list of other advertisers and set a menu page context variable with them
     * Can be easily reused across inventory->advertisers pages
     * 
     * TODO: Consider reading page name from automatically instead of passing it as a parameter
     *
     * @static 
     * @param integer $clientid  Advertiser ID
     * @param string $pageName  
     * @param string $sortPageName
     */
    function setAdvertiserPageContext($clientid, $pageName, $sortPageName = 'advertiser-index.php')
    {
        $doClients = OA_Dal::factoryDO('clients');
        $doClients->agencyid = OA_Permission::getEntityId();
        $doClients->addSessionListOrderBy($sortPageName);
        $doClients->find();

		while ($doClients->fetch()) {
			phpAds_PageContext(
				phpAds_buildName ($doClients->clientid, $doClients->clientname),
				"$pageName?clientid=".$doClients->clientid,
				$clientid == $doClients->clientid
			);
		}
    }
    
    function setAgencyPageContext($agencyid, $pageName)
    {
        $doAgency = OA_Dal::factoryDO('agency');
    	$doAgency->find();
    	while ($doAgency->fetch()) {
    		phpAds_PageContext(
    			phpAds_buildName ($doAgency->agencyid, $doAgency->name),
    			"$pageName?agencyid=".$doAgency->agencyid,
    			$agencyid == $doAgency->agencyid
    		);
    	}
    }

}

?>