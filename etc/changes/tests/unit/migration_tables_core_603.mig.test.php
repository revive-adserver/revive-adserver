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

require_once MAX_PATH . '/etc/changes/migration_tables_core_603.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';

/**
 * Test for migration class #603
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_603Test extends MigrationTest
{

    function setUp()
    {
        // Tests in this class need to use the "real" configuration
        // file writing method, not the one reserved for the test
        // environment...
        $GLOBALS['override_TEST_ENVIRONMENT_RUNNING'] = true;
    }

    function tearDown()
    {
        // Resume normal service with regards to the configuration file writer...
        unset($GLOBALS['override_TEST_ENVIRONMENT_RUNNING']);
    }

    function testMigrateGeoSettings()
    {
        $oMigration = new Migration_603();

        // Check with just ModGeoIP
        $aConf = array('geotargeting' => array('type' => 'ModGeoIP'));
        $oConf = new stdClass();
        $oConf->aConf = $aConf;

        $oMigration->migrateGeoSettings($oConf);
        $aExpected = array('geotargeting' => array('type' => 'geoTargeting:oxMaxMindModGeoIP:oxMaxMindModGeoIP'));
        $this->assertEqual($oConf->aConf, $aExpected);

        // Check with GeoIP and no databases set
        $aConf = array('geotargeting' => array('type' => 'GeoIP'));
        $oConf->aConf = $aConf;
        $oMigration->migrateGeoSettings($oConf);
        $aExpected = array('geotargeting' => array('type' => 'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP'), 'oxMaxMindGeoIP' => array());
        $this->assertEqual($oConf->aConf, $aExpected);

        // Check with GeoIP with some databases set...
        $aConf = array('geotargeting' => array('type' => 'GeoIP', 'geoipCountryLocation' => '/path/to/geoipCountryLocation.dat'));
        $oConf->aConf = $aConf;
        $oMigration->migrateGeoSettings($oConf);
        $aExpected = array(
            'geotargeting' => array(
                'type' => 'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP'),
                'oxMaxMindGeoIP' => array('geoipCountryLocation' => '/path/to/geoipCountryLocation.dat'
            )
        );
        $this->assertEqual($oConf->aConf, $aExpected);
    }

    function testMigrateCasSettings()
    {
        $oMigration = new Migration_603();
        $oConf = new stdClass();

        // Check with "internal"
        $aConf = array('authentication' => array('type' => 'internal'),'oacSSO' => array('host' => 'test'));
        $oConf->aConf = $aConf;

        $oMigration->migrateCasSettings($oConf);
        $aExpected = array('authentication' => array('type' => 'internal'));
        $this->assertEqual($oConf->aConf, $aExpected);

        // Check with "none"
        $aConf = array('authentication' => array('type' => 'none'),'oacSSO' => array('host' => 'test'));
        $oConf->aConf = $aConf;

        $oMigration->migrateCasSettings($oConf);
        $aExpected = array('authentication' => array('type' => 'none'));
        $this->assertEqual($oConf->aConf, $aExpected);

        // Check with "cas"
        $aConf = array('authentication' => array('type' => 'cas'), 'oacSSO' => array('host' => 'test'));
        $oConf->aConf = $aConf;

        $oMigration->migrateCasSettings($oConf);
        $aExpected = array('authentication' => array('type' => 'authentication:oxAuthCAS:oxAuthCAS'),'oxAuthCAS' => array('host' => 'test'));
        $this->assertEqual($oConf->aConf, $aExpected);

    }

    function testMigrateTagSettings()
    {
        $oMigration = new Migration_603();
        $oConf = new stdClass();

        // Test with no allowed
        $aConf = array('allowedTags' => array());
        $oConf->aConf = $aConf;

        $oMigration->migrateTagSettings($oConf);
        $aExpected = array();
        $this->assertEqual($oConf->aConf, $aExpected);

        // Test with one allowed
        // Test with no allowed
        $aConf = array('allowedTags' => array('adframe' => '1'));
        $oConf->aConf = $aConf;

        $oMigration->migrateTagSettings($oConf);
        $aExpected = array('oxInvocationTags' => array('isAllowedAdframe' => 1));
        $this->assertEqual($oConf->aConf, $aExpected);

        // Test with all allowed
        $aConf = array('allowedTags' => array(
            'adjs'          => 'true',
            'adlayer'       => 'true',
            'adviewnocookies'=>'true',
            'local'         => 'true',
            'popup'         => 'false',
            'adframe'       => 'true',
            'adview'        => 'false',
            'xmlrpc'        => 'false',
        ));
        $oConf->aConf = $aConf;

        $oMigration->migrateTagSettings($oConf);
        $aExpected = array('oxInvocationTags' => array(
            'isAllowedAdjs'             => 'true',
            'isAllowedAdlayer'          => 'true',
            'isAllowedAdviewnocookies'  => 'true',
            'isAllowedLocal'            => 'true',
            'isAllowedPopup'            => 'false',
            'isAllowedAdframe'          => 'true',
            'isAllowedAdview'           => 'false',
            'isAllowedXmlrpc'           => 'false',
        ));

        $this->assertEqual($oConf->aConf, $aExpected);

    }

}

?>