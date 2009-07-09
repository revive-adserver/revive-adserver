<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/max/Admin_DA.php';

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';

/**
 * The default data set class to be used for integration-style cross-unit
 * testing.
 *
 * @package    Max
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @static
 */
class DefaultData
{

    /**
     * A method to insert the default data into the database.
     *
     * The default data are:
     *
     *  - Test Advertiser 1
     *    - Placement 11
     *      - High Priority
     *      - Daily target of 120 impressions (5 per
     *        hour assuming even delivery each hour)
     *        - Advertisement 111
     *          - Banner Weight 1
     *    - Placement 12
     *      - High Priority
     *      - Runs from 2005-01-01 to 2005-12-31
     *      - Total target of 87,600 (10 per hour
     *        assuming even delivery each hour)
     *        - Advertisement 121
     *          - Banner Weight 2
     *        - Advertisement 122
     *          - Banner Weight 1
     *
     *  - Test Advertiser 2
     *    - Placement 21
     *    - Placement 22
     *
     *  - Test Publisher 1
     *    - Zone 11
     *    - Zone 12
     *
     *  - Test Publisher 2
     *    - Zone 21
     *    - Zone 22
     *
     * - Advertisement 111 is linked to Zone 11
     * - Advertisement 121 is linked to Zone 21
     * - Advertisement 122 is linked to Zone 21 AND Zone 22
     *
     * @static
     * @access public
     * @TODO Complete the specification of the default data and the implementation
     *       of the creation thereof.
     */
    function insertDefaultData()
    {
        $oDbh = &OA_DB::singleton();
        // Set now
        $oServiceLocator = &OA_ServiceLocator::instance();
        $oldNow = $oServiceLocator->get('now');
        $oServiceLocator->register('now', new Date('2005-03-01'));
        // Add a default agency
        $agencyID = Admin_DA::addAgency(
            array(
                'name'     => 'Test Agency',
                'contact'  => 'Contact Name',
                'username' => 'agency',
                'email'    => 'agency@example.com',
                'active'   => 1,
            )
        );
        // Add two advertisers for the agency
        $advertiserOneID = Admin_DA::addAdvertiser(
            array(
                'agencyid'       => $agencyID,
                'clientname'     => 'Test Advertiser 1',
                'contact'        => 'Contact Name 1',
                'clientusername' => 'advertiser1',
                'email'          => 'advertiser1@example.com'
            )
        );
        $advertiserTwoID = Admin_DA::addAdvertiser(
            array(
                'agencyid'       => $agencyID,
                'clientname'     => 'Test Advertiser 2',
                'contact'        => 'Contact Name 2',
                'clientusername' => 'advertiser2',
                'email'          => 'advertiser2@example.com'
            )
        );
        // Add the advertiser's placements (campaigns) & advertisements
        $campaignOneOneID = Admin_DA::addPlacement(
            array(
                'campaignname'      => 'Campaign 11 - Manual Daily Target of 120',
                'clientid'          => $advertiserOneID,
                'views'             => -1,
                'clicks'            => -1,
                'conversions'       => -1,
                'status'            => OA_ENTITY_STATUS_RUNNING,
                'priority'          => 2,
                'target_impression' => 120,
                'target_click'      => -1,
                'target_conversion' => -1
            )
        );
        $adOneOneOneID = Admin_DA::addAd(
            array(
                'campaignid'         => $campaignOneOneID,
                'description'        => 'Advertisement 111',
                'active'             => 't',
                'weight'             => 1,
                'htmltemplate'       => '',
                'url'                => '',
                'bannertext'         => '',
                'compiledlimitation' => '',
                'append'             => ''
            )
        );
        $campaignOneTwoID = Admin_DA::addPlacement(
            array(
                'campaignname'      => 'Campaign 22 - Auto Distribution of 87,600 Impressions',
                'clientid'          => $advertiserOneID,
                'views'             => 87600,
                'clicks'            => -1,
                'conversions'       => -1,
                'status'            => OA_ENTITY_STATUS_RUNNING,
                'priority'          => 2,
                'target_impression' => -1,
                'target_click'      => -1,
                'target_conversion' => -1,
                'activate_time'     => '2005-01-01 00:00:00',
                'expire_time'       => '2005-12-31 23:59:59',
            )
        );
        $adOneTwoOneID = Admin_DA::addAd(
            array(
                'campaignid'         => $campaignOneTwoID,
                'description'        => 'Advertisement 121',
                'active'             => 't',
                'weight'             => 2,
                'htmltemplate'       => '',
                'url'                => '',
                'bannertext'         => '',
                'compiledlimitation' => '',
                'append'             => ''
            )
        );
        $adOneTwoTwoID = Admin_DA::addAd(
            array(
                'campaignid'         => $campaignOneTwoID,
                'description'        => 'Advertisement 122',
                'active'             => 't',
                'weight'             => 1,
                'htmltemplate'       => '',
                'url'                => '',
                'bannertext'         => '',
                'compiledlimitation' => '',
                'append'             => ''
            )
        );

        // Add two publishers for the agency
        $publisherOneID = Admin_DA::addPublisher(
            array(
                'agencyid' => $agencyID,
                'name'     => 'Test Publisher 1',
                'contact'  => 'Contact Name 1',
                'username' => 'publisher1',
                'email'    => 'publisher1@example.com'
            )
        );
        $publisherTwoID = Admin_DA::addPublisher(
            array(
                'agencyid' => $agencyID,
                'name'     => 'Test Publisher 1',
                'contact'  => 'Contact Name 1',
                'username' => 'publisher1',
                'email'    => 'publisher1@example.com'
            )
        );
        // Add the publisher's zones
        $zoneOneOneID = Admin_DA::addZone(
            array(
                'affiliateid'  => $publisherOneID,
                'zonename'     => 'Zone 11',
                'type'         => 0,
                'category'     => '',
                'ad_selection' => '',
                'chain'        => '',
                'prepend'      => '',
                'append'       => '',
                'what'         => ''
            )
        );
        $zoneOneTwoID = Admin_DA::addZone(
            array(
                'affiliateid'  => $publisherOneID,
                'zonename'     => 'Zone 12',
                'type'         => 0,
                'category'     => '',
                'ad_selection' => '',
                'chain'        => '',
                'prepend'      => '',
                'append'       => '',
                'what'         => ''
            )
        );
        $zoneTwoOneID = Admin_DA::addZone(
            array(
                'affiliateid'  => $publisherOneID,
                'zonename'     => 'Zone 21',
                'type'         => 0,
                'category'     => '',
                'ad_selection' => '',
                'chain'        => '',
                'prepend'      => '',
                'append'       => '',
                'what'         => ''
            )
        );
        $zoneTwoTwoID = Admin_DA::addZone(
            array(
                'affiliateid'  => $publisherOneID,
                'zonename'     => 'Zone 22',
                'type'         => 0,
                'category'     => '',
                'ad_selection' => '',
                'chain'        => '',
                'prepend'      => '',
                'append'       => '',
                'what'         => ''
            )
        );
        // Link the ads to the zones
        Admin_DA::addAdZone(
            array(
                'ad_id'     => $adOneOneOneID,
                'zone_id'   => $zoneOneOneID,
                'link_type' => 1
            )
        );
        Admin_DA::addAdZone(
            array(
                'ad_id'     => $adOneTwoOneID,
                'zone_id'   => $zoneTwoOneID,
                'link_type' => 1
            )
        );
        Admin_DA::addAdZone(
            array(
                'ad_id'     => $adOneTwoTwoID,
                'zone_id'   => $zoneTwoOneID,
                'link_type' => 1
            )
        );
        Admin_DA::addAdZone(
            array(
                'ad_id'     => $adOneTwoTwoID,
                'zone_id'   => $zoneTwoTwoID,
                'link_type' => 1
            )
        );
        // Restore "now"
        if ($oldNow) {
            $oServiceLocator->register('now', $oldNow);
        } else {
            $oServiceLocator->remove('now');
        }
    }

}

?>
