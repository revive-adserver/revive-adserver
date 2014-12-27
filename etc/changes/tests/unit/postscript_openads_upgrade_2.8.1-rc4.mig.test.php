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

require_once MAX_PATH . '/etc/changes/postscript_openads_upgrade_2.8.1-rc4.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';


/**
 * A class for testing adding campaign_ecpm_enabled preference
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_postscript_2_8_1_RC4Test extends MigrationTest
{
    function setUp()
    {
        parent::setUp();
        $this->assertTrue($this->initDatabase(606, array(
            'banners',
            'ad_zone_assoc',
        )));
    }

    function testExecute()
    {
        Mock::generatePartial(
            'OA_UpgradeLogger',
            $mockLogger = 'OA_UpgradeLogger'.rand(),
            array('logOnly', 'logError', 'log')
        );

        $oLogger = new $mockLogger($this);
        $oLogger->setReturnValue('logOnly', true);
        $oLogger->setReturnValue('logError', true);
        $oLogger->setReturnValue('log', true);

        Mock::generatePartial(
            'OA_Upgrade',
            $mockUpgrade = 'OA_Upgrade'.rand(),
            array('addPostUpgradeTask')
        );
        $mockUpgrade = new $mockUpgrade($this);
        $mockUpgrade->setReturnValue('addPostUpgradeTask', true);
        $mockUpgrade->oLogger = $oLogger;
        $mockUpgrade->oDBUpgrader = new OA_DB_Upgrade($oLogger);
        $mockUpgrade->oDBUpgrader->oTable = &$this->oaTable;

        $prefix = $this->oaTable->getPrefix();
        $oDbh = $this->oaTable->oDbh;

        // Create a regular banner
        $sql = "INSERT INTO ".$oDbh->quoteIdentifier($prefix.'banners', true)." (
            bannerid,
            contenttype,
            storagetype,
            acls_updated
        ) VALUES (
            1,
            'html',
            'html',
            NOW()
        )
        ";
        $this->assertTrue($oDbh->exec($sql));

        // Create a text banner
        $sql = "INSERT INTO ".$oDbh->quoteIdentifier($prefix.'banners', true)." (
            bannerid,
            contenttype,
            storagetype,
            acls_updated
        ) VALUES (
            2,
            'txt',
            'txt',
            NOW()
        )
        ";
        $this->assertTrue($oDbh->exec($sql));

        // Create a text banner
        $sql = "INSERT INTO ".$oDbh->quoteIdentifier($prefix.'banners', true)." (
            bannerid,
            contenttype,
            storagetype,
            acls_updated
        ) VALUES (
            3,
            'txt',
            'txt',
            NOW()
        )
        ";
        $this->assertTrue($oDbh->exec($sql));

        // Link only the html banner to zone 0
        $sql = "INSERT INTO ".$oDbh->quoteIdentifier($prefix.'ad_zone_assoc', true)." (
            ad_id,
            zone_id,
            link_type
        ) VALUES (
            1,
            0,
            ".MAX_AD_ZONE_LINK_DIRECT."
        )
        ";
        $this->assertTrue($oDbh->exec($sql));

        // Verify that only 1 banner is direct-selectable
        $sql = "SELECT COUNT(*) FROM  ".$oDbh->quoteIdentifier($prefix.'ad_zone_assoc', true)." WHERE zone_id = 0";
        $this->assertEqual($oDbh->query($sql)->fetchOne(), 1);

        // Run the upgrade
        $postscript = new OA_UpgradePostscript_2_8_1_rc4();
        $ret = $postscript->execute(array(&$mockUpgrade));
        $this->assertTrue($ret);

        // Verify that the banners are direct-selectable
        $sql = "SELECT COUNT(*) FROM  ".$oDbh->quoteIdentifier($prefix.'ad_zone_assoc', true)." WHERE zone_id = 0";
        $this->assertEqual($oDbh->query($sql)->fetchOne(), 3);
    }
}