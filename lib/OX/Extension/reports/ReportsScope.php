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

require_once LIB_PATH . '/Extension/reports/Reports.php';

/**
 * Plugins_ReportsScope is an abstract class that extends the interface defined
 * in {@link Plugins_Reports} to add methods for reports that are based on an
 * Admin_UI_OrganisationScope advertiser/publisher limitation object.
 *
 * @abstract
 * @package    OpenXPlugin
 * @subpackage Reports
 */
class Plugins_ReportsScope extends Plugins_Reports
{
    /**
     * A local copy of the advertiser/publisher limitation object.
     *
     * @var Admin_UI_OrganisationScope
     */
    public $_oScope;

    /**
     * A private method to get the required sub-heading parameters for the reports
     * for a given advertiser/publisher limitation scope.
     *
     * @return array An array of parameters that can be used in the
     *               {@link Plugins_Reports::_getReportParametersForDisplay()} method.
     */
    public function _getDisplayableParametersFromScope()
    {
        $aParams = [];
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
        $key = MAX_Plugin_Translation::translate('Website', $this->module);
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
                $aParams[$key] = MAX_Plugin_Translation::translate('All Websites', $this->module);
            }
        }
        return $aParams;
    }
}
