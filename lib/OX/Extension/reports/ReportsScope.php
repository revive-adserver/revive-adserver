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

require_once LIB_PATH . '/Extension/reports/Reports.php';

/**
 * Plugins_ReportsScope is an abstract class that extends the interface defined
 * in {@link Plugins_Reports} to add methods for reports that are based on an
 * Admin_UI_OrganisationScope advertiser/publisher limitation object.
 *
 * @abstract
 * @package    OpenXPlugin
 * @subpackage Reports
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Plugins_ReportsScope extends Plugins_Reports
{

    /**
     * A local copy of the advertiser/publisher limitation object.
     *
     * @var Admin_UI_OrganisationScope
     */
    var $_oScope;

    /**
     * A private method to get the required sub-heading parameters for the reports
     * for a given advertiser/publisher limitation scope.
     *
     * @return array An array of parameters that can be used in the
     *               {@link Plugins_Reports::_getReportParametersForDisplay()} method.
     */
    function _getDisplayableParametersFromScope()
    {
        $aParams = array();
        $key = MAX_Plugin_Translation::translate('Advertiser', $this->module);
        $advertiserId = $this->_oScope->getAdvertiserId();
        if (!empty($advertiserId)) {
            // Get the name of the advertiser
            $doClients = OA_Dal::factoryDO('clients');
            $doClients->clientid = $advertiserId;
            $doClients->find();
            if ($doClients->fetch()) {
                $aAdvertiser = $doClients->toArray();
                $aParams[$key] = $aAdvertiser['clientname'];
            }
        } else {
            if ($this->_oScope->getAnonymous()) {
                $aParams[$key] = MAX_Plugin_Translation::translate('Anonymous Advertisers', $this->module);
            } else {
                $aParams[$key] = MAX_Plugin_Translation::translate('All Advertisers', $this->module);
            }
        }
        $key = MAX_Plugin_Translation::translate('Publisher', $this->module);
        $publisherId = $this->_oScope->getPublisherId();
        if (!empty($publisherId)) {
            $doAffiliates = OA_Dal::factoryDO('affiliates');
            $doAffiliates->affiliateid = $publisherId;
            $doAffiliates->find();
            if ($doAffiliates->fetch()) {
                $aPublisher = $doAffiliates->toArray();
                $aParams[$key] = $aPublisher['name'];
            }
        } else {
            if ($this->_oScope->getAnonymous()) {
                $aParams[$key] = MAX_Plugin_Translation::translate('Anonymous Publishers', $this->module);
            } else {
                $aParams[$key] = MAX_Plugin_Translation::translate('All Publishers', $this->module);
            }
        }
        return $aParams;
    }

}

?>