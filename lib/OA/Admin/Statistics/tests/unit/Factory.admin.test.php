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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Factory.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';

Language_Loader::load();

/**
 * A class for testing the OA_Admin_Statistics_Factory class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 */
class Test_OA_Admin_Statistics_Factory extends UnitTestCase
{

    /**
     * An array to store the different possible $controllerType values
     * accepted by the factory method, and the associated expected class
     * types the factory should return.
     *
     * @var unknown_type
     */
    var $testTypesDelivery = array(
        'advertiser-affiliates'         => 'OA_Admin_Statistics_Delivery_Controller_AdvertiserAffiliates',
        'advertiser-affiliate-history'  => 'OA_Admin_Statistics_Delivery_Controller_AdvertiserAffiliateHistory',
        'advertiser-campaigns'          => 'OA_Admin_Statistics_Delivery_Controller_AdvertiserCampaigns',
        //'advertiser-daily'              => 'OA_Admin_Statistics_Delivery_Controller_AdvertiserDaily',
        'advertiser-history'            => 'OA_Admin_Statistics_Delivery_Controller_AdvertiserHistory',
        'advertiser-zone-history'       => 'OA_Admin_Statistics_Delivery_Controller_AdvertiserZoneHistory',

        'affiliate-banner-history'      => 'OA_Admin_Statistics_Delivery_Controller_AffiliateBannerHistory',
        'affiliate-campaigns'           => 'OA_Admin_Statistics_Delivery_Controller_AffiliateCampaigns',
        'affiliate-campaign-history'    => 'OA_Admin_Statistics_Delivery_Controller_AffiliateCampaignHistory',
        //'affiliate-daily'               => 'OA_Admin_Statistics_Delivery_Controller_AffiliateDaily',
        'affiliate-history'             => 'OA_Admin_Statistics_Delivery_Controller_AffiliateHistory',
        'affiliate-zones'               => 'OA_Admin_Statistics_Delivery_Controller_AffiliateZones',

        'banner-affiliates'             => 'OA_Admin_Statistics_Delivery_Controller_BannerAffiliates',
        'banner-affiliate-history'      => 'OA_Admin_Statistics_Delivery_Controller_BannerAffiliateHistory',
        //'banner-daily'                  => 'OA_Admin_Statistics_Delivery_Controller_BannerDaily',
        'banner-history'                => 'OA_Admin_Statistics_Delivery_Controller_BannerHistory',
        'banner-zone-history'           => 'OA_Admin_Statistics_Delivery_Controller_BannerZoneHistory',

        'campaign-affiliates'           => 'OA_Admin_Statistics_Delivery_Controller_CampaignAffiliates',
        'campaign-affiliate-history'    => 'OA_Admin_Statistics_Delivery_Controller_CampaignAffiliateHistory',
        'campaign-banners'              => 'OA_Admin_Statistics_Delivery_Controller_CampaignBanners',
        //'campaign-daily'                => 'OA_Admin_Statistics_Delivery_Controller_CampaignDaily',
        'campaign-history'              => 'OA_Admin_Statistics_Delivery_Controller_CampaignHistory',
        'campaign-zone-history'         => 'OA_Admin_Statistics_Delivery_Controller_CampaignZoneHistory',

        'global-advertiser'             => 'OA_Admin_Statistics_Delivery_Controller_GlobalAdvertiser',
        'global-affiliates'             => 'OA_Admin_Statistics_Delivery_Controller_GlobalAffiliates',
        //'global-daily'                  => 'OA_Admin_Statistics_Delivery_Controller_GlobalDaily',
        'global-history'                => 'OA_Admin_Statistics_Delivery_Controller_GlobalHistory',

        'zone-banner-history'           => 'OA_Admin_Statistics_Delivery_Controller_ZoneBannerHistory',
        'zone-campaigns'                => 'OA_Admin_Statistics_Delivery_Controller_ZoneCampaigns',
        'zone-campaign-history'         => 'OA_Admin_Statistics_Delivery_Controller_ZoneCampaignHistory',
        //'zone-daily'                    => 'OA_Admin_Statistics_Delivery_Controller_ZoneDaily',
        'zone-history'                  => 'OA_Admin_Statistics_Delivery_Controller_ZoneHistory'
    );

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function test_getControllerClass()
    {
        $expectPath = '/Statistics/Delivery/Controller/';
        foreach ($this->testTypesDelivery as $controllerType => $expectedClassName)
        {
            $aType = explode('-',$controllerType);
            $expectFile= '';
            foreach ($aType AS $string)
            {
                $expectFile.= ucfirst($string);
            }
            OA_Admin_Statistics_Factory::_getControllerClass($controllerType, $class, $file);
            $this->assertEqual($class, $expectedClassName);
            $this->assertPattern("(\/Statistics\/Delivery\/Controller\/{$expectFile}\.php)",$file);
        }
    }

    function test_instantiateController()
    {
        $file = MAX_PATH.'/lib/OA/Admin/Statistics/Delivery/Common.php';
        $aParams = array();
        $class = 'OA_Admin_Statistics_Delivery_Common';
        $oObject =& OA_Admin_Statistics_Factory::_instantiateController($file, $class, $aParams);
        $this->assertIsA($oObject, $class);
        $this->assertEqual(count($oObject->aPlugins),2);
        $this->assertTrue(isset($oObject->aPlugins['default']));
        $this->assertTrue(isset($oObject->aPlugins['affiliates']));

        $file = MAX_PATH.'/lib/OA/Admin/Statistics/tests/data/TestStatisticsController.php';
        $aParams = array();
        $class = 'OA_Admin_Statistics_Test';
        $oObject =& OA_Admin_Statistics_Factory::_instantiateController($file, $class, $aParams);
        $this->assertIsA($oObject, $class);

        // Disable default error handling
        PEAR::pushErrorHandling(null);

        // Test _instantiateController for not existing controller
        $file = MAX_PATH.'/lib/OA/Admin/Statistics/tests/data/TestNotExists.php';
        $aParams = array();
        $class = 'OA_Admin_Statistics_Test';
        $oObject =& OA_Admin_Statistics_Factory::_instantiateController($file, $class, $aParams);
        $this->assertTrue(PEAR::isError($oObject));
        $this->assertEqual($oObject->getMessage(), 'OA_Admin_Statistics_Factory::_instantiateController() Unable to locate '.basename($file));

        // Test _instantiateController for not existing class
        $file = MAX_PATH.'/lib/OA/Admin/Statistics/tests/data/TestStatisticsController.php';
        $aParams = array();
        $class = 'OA_Admin_not_exists';
        $oObject =& OA_Admin_Statistics_Factory::_instantiateController($file, $class, $aParams);
        $this->assertTrue(PEAR::isError($oObject));
        $this->assertEqual($oObject->getMessage(), 'OA_Admin_Statistics_Factory::_instantiateController() Class '.$class.' doesn\'t exist');

        // Restore default error handling
        PEAR::popErrorHandling();
    }

    /**
     *
     * PROBLEM: if any of the classes use database in their constructor this test will fail
     * the test layer has no database
     *
     * A method to test that the correct class is returned for appropriate
     * $controllerType input values
     */
    function test_GetController()
    {
        /*foreach ($this->testTypes as $controllerType => $expectedClassName) {
            $oController =& OA_Admin_Statistics_Factory::getController($controllerType);
            $this->assertTrue(is_a($oController, $expectedClassName));
        }*/
    }




}

?>
