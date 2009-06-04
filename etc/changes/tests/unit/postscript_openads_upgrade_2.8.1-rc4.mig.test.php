<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
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
$Id: postscript_openads_upgrade_2.7.26-beta-rc5.mig.test.php 30820 2009-01-13 19:02:17Z andrew.hill $
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
 * @author     Matteo Beccati <matteo.beccati@openx.org>
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