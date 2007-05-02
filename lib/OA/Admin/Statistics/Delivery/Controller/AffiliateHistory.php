<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
$Id$
*/

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonHistory.php';

/**
 * The class to display the delivery statistcs for the page:
 *
 * Statistics -> Publishers & Zones -> Publisher History
 *
 * @package    OpenadsAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Delivery_Controller_AffiliateHistory extends OA_Admin_Statistics_Delivery_CommonHistory
{

    /**
     * The final "child" implementation of the PHP5-style constructor.
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function __construct($aParams)
    {
        $this->showDaySpanSelector = true;
        parent::__construct($aParams);
    }

    /**
     * PHP4-style constructor
     *
     * @param array $aParams An array of parameters. The array should
     *                       be indexed by the name of object variables,
     *                       with the values that those variables should
     *                       be set to. For example, the parameter:
     *                       $aParams = array('foo' => 'bar')
     *                       would result in $this->foo = bar.
     */
    function OA_Admin_Statistics_Delivery_Controller_AffiliateHistory($aParams)
    {
        $this->__construct($aParams);
    }

    /**
     * The final "child" implementation of the parental abstract method.
     *
     * @see OA_Admin_Statistics_Common::start()
     */
    function start()
    {
        // Get parameters
        $publisherId = $this->_getId('publisher');

        // Entry page for affiliates
        if (phpAds_isAllowed(MAX_AffiliateIsReallyAffiliate)) {
            $this->showPublisherWelcome();
        }

        // Security check
        phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
        $this->_checkAccess(array('publisher' => $publisherId));

        // Add standard page parameters
        $this->aPageParams = array('affiliateid' => $publisherId,
                                  'entity'    => 'affiliate',
                                  'breakdown' => 'history',
                                  'statsBreakdown' => MAX_getStoredValue('statsBreakdown', 'history'));

        // HTML Framework
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            $this->pageId = '2.4.1';
            $this->aPageSections = array('2.4.1', '2.4.2', '2.4.3');
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $this->pageId = '1.1';
            $this->aPageSections[] = '1.1';
            if (phpAds_isAllowed(MAX_AffiliateViewZoneStats)) {
                $this->aPageSections[] = '1.2';
            }
            $this->aPageSections[] = '1.3';
        }

        $this->_addBreadcrumbs('publisher', $publisherId);

        // Add context
        $this->pageContext = array('publishers', $publisherId);

        // Add shortcuts
        if (!phpAds_isUser(phpAds_Affiliate)) {
            $this->_addShortcut(
                $GLOBALS['strAffiliateProperties'],
                'affiliate-edit.php?affiliateid='.$publisherId,
                'images/icon-affiliate.gif'
            );
        }

        $aParams = array();
        $aParams['publisher_id'] = $publisherId;

        // Limit by advertiser
        $advertiserId = (int)MAX_getValue('clientid', '');
        if (!empty($advertiserId)) {
            $aParams['advertiser_id'] = $advertiserId;
        }

        $this->prepare($aParams, 'stats.php?entity=affiliate&breakdown=daily');
    }

}

?>