<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
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
$Id: migration_tables_core_601.mig.test.php 25650 2008-09-12 17:43:39Z andrew.hill $
*/

require_once MAX_PATH . '/etc/changes/migration_tables_core_603.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #540.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Migration_601Test extends MigrationTest
{
    function setUp()
	{
	    parent::setUp();
	    $this->host = $_SERVER['HTTP_HOST'];
	    $_SERVER['HTTP_HOST'] = 'test1';

		$GLOBALS['_MAX']['CONF']['webpath']['delivery'] = getHostName();
        if (file_exists(MAX_PATH . '/var/' . getHostName() . '.conf.php')) {
            unlink(MAX_PATH . '/var/' . getHostName() . '.conf.php');
        }
		$this->createConfigIfNotExists();
	}

	function tearDown()
	{
        if (file_exists(MAX_PATH.'/var/'.getHostName().'.conf.php'))
        {
            @unlink(MAX_PATH.'/var/'.getHostName().'.conf.php');
        }
	    $_SERVER['HTTP_HOST'] = $this->host;

        TestEnv::restoreConfig();

	    parent::tearDown();
	}

    function testMigrate603()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(602, array('acls', 'acls_channel', 'banners'));

        $tblAcls  = $this->oDbh->quoteIdentifier($prefix.'acls', true);
        $tblAclsChannel  = $this->oDbh->quoteIdentifier($prefix.'acls_channel', true);
        $tblBanners  = $this->oDbh->quoteIdentifier($prefix.'banners', true);

        // Setup some ACL records, some fields which will be changed, some fields that won't be recognised and should therefore be left unchanged
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Client:Browser', '==', 'test', 0)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Site:Source', '==', 'test', 1)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'Geo:Country', '==', 'test', 2)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Time:Day', '==', 'test', 3)");
        $this->oDbh->exec("INSERT INTO {$tblAcls} (bannerid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'Dummy:Dummy', '==', 'test', 4)");

        // Same entries for the acls_channel table
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Client:Browser', '==', 'test', 0)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Site:Source', '==', 'test', 1)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'Geo:Country', '==', 'test', 2)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'Time:Day', '==', 'test', 3)");
        $this->oDbh->exec("INSERT INTO {$tblAclsChannel} (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'or', 'Dummy:Dummy', '==', 'test', 4)");

        // Some entries for the ext_bannertype migration too...
        $this->oDbh->exec("INSERT INTO {$tblBanners} (bannerid, storagetype) VALUES (1, 'html')");
        $this->oDbh->exec("INSERT INTO {$tblBanners} (bannerid, storagetype) VALUES (2, 'txt')");
        $this->oDbh->exec("INSERT INTO {$tblBanners} (bannerid, storagetype) VALUES (3, 'web')");
        $this->oDbh->exec("INSERT INTO {$tblBanners} (bannerid, storagetype) VALUES (4, 'sql')");

        // Setup some fake config items
        // Geotargeting
        $GLOBALS['_MAX']['CONF']['geotargeting']['type'] = 'GeoIP';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipCountryLocation'] = '/path/to/geoipCountryLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipRegionLocation'] = '/path/to/geoipRegionLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipCityLocation'] = '/path/to/geoipCityLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipAreaLocation'] = '/path/to/geoipAreaLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipDmaLocation'] = '/path/to/geoipDmaLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipOrgLocation'] = '/path/to/geoipOrgLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipIspLocation'] = '/path/to/geoipIspLocation.dat';
        $GLOBALS['_MAX']['CONF']['geotargeting']['geoipNetspeedLocation'] = '/path/to/geoipNetspeedLocation.dat';

        $GLOBALS['_MAX']['CONF']['allowedTags']['adlayer'] = 'true';

        // Migrate!
        $this->upgradeToVersion(603);

        $aAcls = $this->oDbh->queryAll("SELECT bannerid, logical, type, comparison, data, executionorder FROM {$tblAcls} ORDER BY bannerid, executionorder");
        $aExpectedAcls = array(
            array('bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 0, 'logical' => 'and', 'type' => 'deliveryLimitations:Client:Browser'),
            array('bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 1, 'logical' => 'and', 'type' => 'deliveryLimitations:Site:Source'),
            array('bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 2, 'logical' => 'or',  'type' => 'deliveryLimitations:Geo:Country'),
            array('bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 3, 'logical' => 'and', 'type' => 'deliveryLimitations:Time:Day'),
            array('bannerid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 4, 'logical' => 'or',  'type' => 'Dummy:Dummy'),
        );
        $this->assertEqual($aAcls, $aExpectedAcls);

        $aAclsChannel = $this->oDbh->queryAll("SELECT channelid, logical, type, comparison, data, executionorder FROM {$tblAclsChannel} ORDER BY channelid, executionorder");
        $aExpectedAclsChannel = array(
            array('channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 0, 'logical' => 'and', 'type' => 'deliveryLimitations:Client:Browser'),
            array('channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 1, 'logical' => 'and', 'type' => 'deliveryLimitations:Site:Source'),
            array('channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 2, 'logical' => 'or',  'type' => 'deliveryLimitations:Geo:Country'),
            array('channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 3, 'logical' => 'and', 'type' => 'deliveryLimitations:Time:Day'),
            array('channelid' => 1, 'comparison' => '==', 'data' => 'test', 'executionorder' => 4, 'logical' => 'or',  'type' => 'Dummy:Dummy'),
        );
        $this->assertEqual($aAclsChannel, $aExpectedAclsChannel);

        $aBanners = $this->oDbh->queryAll("SELECT bannerid, storagetype, ext_bannertype FROM {$tblBanners} ORDER BY bannerid");
        $aExpectedBanners = array(
            array('bannerid' => 1, 'storagetype' => 'html', 'ext_bannertype' => 'bannerTypeHtml:oxHtml:genericHtml'),
            array('bannerid' => 2, 'storagetype' => 'txt',  'ext_bannertype' => 'bannerTypeText:oxText:genericText'),
            array('bannerid' => 3, 'storagetype' => 'web',  'ext_bannertype' => null),
            array('bannerid' => 4, 'storagetype' => 'sql',  'ext_bannertype' => null),
        );
        $this->assertEqual($aBanners, $aExpectedBanners);

        $aConf = parse_ini_file(MAX_PATH . '/var/' . getHostName() . '.conf.php', true);
        $oxMaxMindGeoIP = array(
            'geoipCountryLocation' => '/path/to/geoipCountryLocation.dat',
            'geoipRegionLocation' => '/path/to/geoipRegionLocation.dat',
            'geoipCityLocation' => '/path/to/geoipCityLocation.dat',
            'geoipAreaLocation' => '/path/to/geoipAreaLocation.dat',
            'geoipDmaLocation' => '/path/to/geoipDmaLocation.dat',
            'geoipOrgLocation' => '/path/to/geoipOrgLocation.dat',
            'geoipIspLocation' => '/path/to/geoipIspLocation.dat',
            'geoipNetspeedLocation' => '/path/to/geoipNetspeedLocation.dat',
        );

        $this->assertEqual($oxMaxMindGeoIP, $aConf['oxMaxMindGeoIP']);

        $this->assertEqual($aConf['geotargeting']['type'], 'geoTargeting:oxMaxMindGeoIP:oxMaxMindGeoIP');
    }
    /**
     * This method creates config if it doesn't exist so test won't fail
     *
     */
    function createConfigIfNotExists()
    {
        if (!(file_exists(MAX_PATH.'/var/'.getHostName().'.conf.php'))) {
        	$oConfig = new OA_Upgrade_Config();
        	$oConfig->putNewConfigFile();
        	$oConfig->writeConfig(true);
        }
    }

    /**
     * Checks if $testArray exists in $section in global config file
     *
     * @param string $testSection
     * @param array $testArray
     */
    function checkGlobalConfigConsists($testSection, $testArray)
    {
        $host = getHostName();
    	$configPath = MAX_PATH . "/var/$host.conf.php";
    	if ($this->assertTrue(file_exists($configPath), "File: '$configPath' should exist!")) {
            $aContents = parse_ini_file($configPath, true);
            foreach($testArray as $key => $val) {
            	$this->assertEqual($aContents[$testSection][$key], $val);
            }
        }
    }
}