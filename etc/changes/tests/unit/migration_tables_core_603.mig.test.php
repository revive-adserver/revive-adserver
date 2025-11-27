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
    public function setUp()
    {
        // Tests in this class need to use the "real" configuration
        // file writing method, not the one reserved for the test
        // environment...
        $GLOBALS['override_TEST_ENVIRONMENT_RUNNING'] = true;
    }

    public function tearDown()
    {
        // Resume normal service with regards to the configuration file writer...
        unset($GLOBALS['override_TEST_ENVIRONMENT_RUNNING']);
    }

    public function testMigrateGeoSettings()
    {
        $oMigration = new Migration_603();

        // Check with just ModGeoIP
        $aConf = ['geotargeting' => ['type' => 'ModGeoIP']];
        $oConf = new stdClass();
        $oConf->aConf = $aConf;

        $oMigration->migrateGeoSettings($oConf);
        $aExpected = ['geotargeting' => ['type' => 'geoTargeting:oxMaxMindModGeoIP:oxMaxMindModGeoIP']];
        $this->assertEqual($oConf->aConf, $aExpected);

        // Check with GeoIP and no databases set
        $aConf = ['geotargeting' => ['type' => 'GeoIP']];
        $oConf->aConf = $aConf;
        $oMigration->migrateGeoSettings($oConf);
        $aExpected = ['geotargeting' => ['type' => 'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP'], 'oxMaxMindGeoIP' => []];
        $this->assertEqual($oConf->aConf, $aExpected);

        // Check with GeoIP with some databases set...
        $aConf = ['geotargeting' => ['type' => 'GeoIP', 'geoipCountryLocation' => '/path/to/geoipCountryLocation.dat']];
        $oConf->aConf = $aConf;
        $oMigration->migrateGeoSettings($oConf);
        $aExpected = [
            'geotargeting' => [
                'type' => 'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP'],
            'oxMaxMindGeoIP' => ['geoipCountryLocation' => '/path/to/geoipCountryLocation.dat',
            ],
        ];
        $this->assertEqual($oConf->aConf, $aExpected);
    }

    public function testMigrateCasSettings()
    {
        $oMigration = new Migration_603();
        $oConf = new stdClass();

        // Check with "internal"
        $aConf = ['authentication' => ['type' => 'internal'], 'oacSSO' => ['host' => 'test']];
        $oConf->aConf = $aConf;

        $oMigration->migrateCasSettings($oConf);
        $aExpected = ['authentication' => ['type' => 'internal']];
        $this->assertEqual($oConf->aConf, $aExpected);

        // Check with "none"
        $aConf = ['authentication' => ['type' => 'none'], 'oacSSO' => ['host' => 'test']];
        $oConf->aConf = $aConf;

        $oMigration->migrateCasSettings($oConf);
        $aExpected = ['authentication' => ['type' => 'none']];
        $this->assertEqual($oConf->aConf, $aExpected);

        // Check with "cas"
        $aConf = ['authentication' => ['type' => 'cas'], 'oacSSO' => ['host' => 'test']];
        $oConf->aConf = $aConf;

        $oMigration->migrateCasSettings($oConf);
        $aExpected = ['authentication' => ['type' => 'authentication:oxAuthCAS:oxAuthCAS'], 'oxAuthCAS' => ['host' => 'test']];
        $this->assertEqual($oConf->aConf, $aExpected);
    }

    public function testMigrateTagSettings()
    {
        $oMigration = new Migration_603();
        $oConf = new stdClass();

        // Test with no allowed
        $aConf = ['allowedTags' => []];
        $oConf->aConf = $aConf;

        $oMigration->migrateTagSettings($oConf);
        $aExpected = [];
        $this->assertEqual($oConf->aConf, $aExpected);

        // Test with one allowed
        // Test with no allowed
        $aConf = ['allowedTags' => ['adframe' => '1']];
        $oConf->aConf = $aConf;

        $oMigration->migrateTagSettings($oConf);
        $aExpected = ['oxInvocationTags' => ['isAllowedAdframe' => 1]];
        $this->assertEqual($oConf->aConf, $aExpected);

        // Test with all allowed
        $aConf = ['allowedTags' => [
            'adjs' => 'true',
            'adlayer' => 'true',
            'adviewnocookies' => 'true',
            'local' => 'true',
            'popup' => 'false',
            'adframe' => 'true',
            'adview' => 'false',
            'xmlrpc' => 'false',
        ]];
        $oConf->aConf = $aConf;

        $oMigration->migrateTagSettings($oConf);
        $aExpected = ['oxInvocationTags' => [
            'isAllowedAdjs' => 'true',
            'isAllowedAsyncStealth' => 'true',
            'isAllowedAdlayer' => 'true',
            'isAllowedAdviewnocookies' => 'true',
            'isAllowedLocal' => 'true',
            'isAllowedPopup' => 'false',
            'isAllowedAdframe' => 'true',
            'isAllowedMarkdown' => 'true',
            'isAllowedAdview' => 'false',
            'isAllowedXmlrpc' => 'false',
        ]];

        $this->assertEqual($oConf->aConf, $aExpected);
    }
}
