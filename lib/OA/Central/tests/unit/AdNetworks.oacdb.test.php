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

require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the OA_Central_AdNetworks class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Central_AdNetworks extends UnitTestCase
{
    /**
     * @var array
     */
    var $aCleanupTables = array('clients','campaigns','banners', 'affiliates', 'ad_zone_assoc', 'zones');

    /**
     * @var OA_PermanentCache
     */
    var $oCache;

    /**
     * The constructor method.
     */
    function Test_OA_Central_AdNetworks()
    {
        $this->UnitTestCase();

        $GLOBALS['_MAX']['PREF'] = array(
            'language'    => 'en',
            'admin_name'  => 'Foo Bar',
            'admin_email' => 'foo@example.com'
        );

        $this->oCache = new OA_PermanentCache();

        // PartialMock of OA_Central_AdNetworks
        Mock::generatePartial(
            'OA_Central_AdNetworks',
            'PartialMockOA_Central_AdNetworks',
            array('retrievePermanentCache')
        );
    }

    function _setUpAppVars()
    {
        OA_Dal_ApplicationVariables::set('platform_hash', sha1('foo'));
        OA_Dal_ApplicationVariables::set('sso_admin', 'foo');
        OA_Dal_ApplicationVariables::set('sso_passwd', md5('bar'));
    }

    function _mockSendReference(&$oAdNetworks, &$reference)
    {
        $oAdNetworks->oMapper->oRpc->oXml->setReturnReference('send', $reference);
    }

    function _mockSendExpect(&$oAdNetworks, $args)
    {
        $oAdNetworks->oMapper->oRpc->oXml->expect('send', $args);
    }
    /**
     * Create a new OA_Central_AdNetworks instance with a mocked Rpc class
     *
     * @return OA_Central_AdNetworks
     */
    function _newInstance()
    {
        Mock::generatePartial(
            'OA_XML_RPC_Client',
            $oXmlRpc = 'OA_XML_RPC_Client_'.md5(uniqid('', true)),
            array('send')
        );

        $oAdNetworks = new OA_Central_AdNetworks();
        $oAdNetworks->oMapper->oRpc->oXml = new $oXmlRpc();

        return $oAdNetworks;
    }

    /**
     * A method to test the getCategoriesFlatWithParentInfo() method.
     *
     */
    function testGetCategoriesFlatWithParentInfo() {
        $aCategories = array(
            10 => array(
                'name' => 'Music',
                'subcategories' => array(
                    21 => 'Pop',
                    22 => 'Rock'
                )
            )
        );
        $aExpected = array (
            10 => array( 'name' => 'Music', 'parent' => null),
            21 => array( 'name' => 'Pop', 'parent' => 10),
            22 => array( 'name' => 'Rock', 'parent' => 10)
        );

        $oAdNetworksPartialMock = new PartialMockOA_Central_AdNetworks($this);
        $oAdNetworksPartialMock->setReturnValue('retrievePermanentCache', $aCategories);

        $aResult = $oAdNetworksPartialMock->getCategoriesFlatWithParentInfo();
        ksort($aExpected);
        ksort($aResult);
        $this->assertEqual($aResult, $aExpected);
    }

    /**
     * A method to test the getCategoriesByIds() method.
     *
     */
    function testGetCategoriesByIds() {
        $aCategories = array(
            10 => array(
                'name' => 'Music',
                'subcategories' => array(
                    21 => 'Pop',
                    22 => 'Rock'
                )
            ),
            30 => array(
                'name' => 'Sport',
                'subcategories' => array(
                    41 => 'Football',
                    42 => 'Rugby'
                )
            )
        );
        $aCategoriesFlat = array (
            10 => array( 'name' => 'Music', 'parent' => null),
            21 => array( 'name' => 'Pop', 'parent' => 10),
            22 => array( 'name' => 'Rock', 'parent' => 10),
            30 => array( 'name' => 'Sport', 'parent' => null),
            41 => array( 'name' => 'Football', 'parent' => 30),
            42 => array( 'name' => 'Rugby', 'parent' => 30)
        );
        $aExpected = array (
            10 => array(
                'name' => 'Music',
                'subcategories' => array(
                    22 => 'Rock'
                )
            ),
            30 => array(
                'name' => 'Sport'
            )
        );

        $oAdNetworksPartialMock = new PartialMockOA_Central_AdNetworks($this);
        $oAdNetworksPartialMock->setReturnValue('retrievePermanentCache', $aCategories);

        $aResult = $oAdNetworksPartialMock->getCategoriesByIds(array(22,30));
        ksort($aExpected);
        ksort($aResult);
        $this->assertEqual($aResult, $aExpected);

        $aResult = $oAdNetworksPartialMock->getCategoriesByIds();
        ksort($aResult);
        $this->assertEqual($aResult, $aCategories);
    }

    /**
     * A method to test the getSubCategoriesIds() method.
     *
     */
    function testGetSubCategoriesIds()
    {
        $aCategories = array(
            10 => array(
                'name' => 'Music',
                'subcategories' => array(
                    21 => 'Pop',
                    22 => 'Rock'
                )
            )
        );
        $aExpected = array (21, 22);

        $oAdNetworksPartialMock = new PartialMockOA_Central_AdNetworks($this);
        $oAdNetworksPartialMock->setReturnValue('retrievePermanentCache', $aCategories);

        $aResult = $oAdNetworksPartialMock->getSubCategoriesIds(10);
        ksort($aExpected);
        ksort($aResult);
        $this->assertEqual($aResult, $aExpected);
    }

}

?>
