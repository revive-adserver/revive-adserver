<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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


require_once MAX_PATH.'/lib/OA/Upgrade/Upgrade.php';
require_once MAX_PATH.'/lib/OA/Upgrade/VersionController.php';
require_once MAX_PATH.'/lib/OA/Upgrade/DB_Upgrade.php';
require_once MAX_PATH.'/lib/OA/Upgrade/UpgradePackageParser.php';
require_once MAX_PATH.'/lib/OA/Dal/DataGenerator.php';

// change visibility of _rollbackPutAdmin method
class OA_UpgradeRollbackTest extends OA_Upgrade {
    public function _rollbackPutAdmin(){ parent::_rollbackPutAdmin(); }
}


/**
 * A class for testing the OpenX Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class Test_OA_Upgrade extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Upgrade()
    {
        $this->UnitTestCase();
    }

    function test_versionCompare()
    {
        $aFiles[] = '2.3.32-beta-rc2';
        $aFiles[] = '2.3.32-beta-rc5';
        $aFiles[] = '2.3.32-beta-rc10';
        $aFiles[] = '2.3.32-beta-rc21';
        $aFiles[] = '2.3.32-beta';
        $aFiles[] = '2.3.32';
        $aFiles[] = '2.3.33-dev';
        $aFiles[] = '2.3.33-alpha';
        $aFiles[] = '2.3.33-beta-rc1';
        $aFiles[] = '2.3.33-beta-rc2';
        $aFiles[] = '2.3.33-beta';
        $aFiles[] = '2.3.33';
        $aFiles[] = '2.4.0-dev';
        $aFiles[] = '2.4.0-alpha';
        $aFiles[] = '2.4.0-beta';
        $aFiles[] = '2.4.0';
        $aFiles[] = '2.4.1-dev';
        $aFiles[] = '2.4.1-alpha';
        $aFiles[] = '2.4.1-beta-rc1';
        $aFiles[] = '2.4.1-beta-rc2';
        $aFiles[] = '2.4.1-beta';
        //$aFiles[] = '2.4.1-rc1';  // THIS FAILS
        $aFiles[] = '2.4.1-RC1';
        $aFiles[] = '2.4.1';
        $aFiles[] = '2.5.5';
        $aFiles[] = '2.5.50-dev';
        $aFiles[] = '2.5.50-beta-rc1';
        $aFiles[] = '2.5.50';
        $aFiles[] = '2.5.51-beta-rc1';

        $count = count($aFiles);

        for ($prevIdx=0;$prevIdx<$count;$prevIdx++)
        {
            for ($curIdx=0;$curIdx<$count;$curIdx++)
            {
                $result  = version_compare($aFiles[$prevIdx],$aFiles[$curIdx]);
                if ($prevIdx < $curIdx)
                {
                    $this->assertTrue($result<0,'should upgrade: prev : '.$aFiles[$prevIdx].' / curr: '.$aFiles[$curIdx]);
                }
                else if ($prevIdx > $curIdx)
                {
                    $this->assertTrue($result>0, 'should not upgrade: prev : '.$aFiles[$prevIdx].' / curr: '.$aFiles[$curIdx]);
                }
                else if ($curIdx == $prevIdx)
                {
                    $this->assertTrue($result==0,'should be current: prev : '.$aFiles[$prevIdx].' / curr: '.$aFiles[$curIdx]);
                }
            }
        }
    }

    function _writeUpgradePackagesArray()
    {
        global $readPath, $writeFile;
        $readPath = MAX_PATH.'/lib/OA/Upgrade/tests/data/changes';
        $writeFile = MAX_PATH.'/var/openads_upgrade_array.txt';
        include MAX_PATH.'/scripts/upgrade/buildPackagesArray.php';
        $this->assertTrue(file_exists($writeFile),'array file was not written');
        return $aVersions;
    }

//    function _readUpgradePackagesArray()
//    {
//        global $readPath, $writeFile;
//
//        $this->assertTrue(file_exists($writeFile),'array file not found');
//        $array = file_get_contents($writeFile);
//        $aVersions = unserialize($array);
//        $this->assertIsA($aVersions,'array','aVersions is not an array');
//        return $aVersions;
//    }

    function test_writeUpgradePackagesArray()
    {
        $aVersions = $this->_writeUpgradePackagesArray();

        $this->assertEqual(count($aVersions),1,'');
        $this->assertEqual(count($aVersions[2]),2,'');
        $this->assertEqual(count($aVersions[2][3]),2,'');

        $this->assertEqual(count($aVersions[2][3][32]),2,'');
        $this->assertEqual(count($aVersions[2][3][32]['-beta']),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta']['file'],'openads_upgrade_2.3.32-beta.xml','');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc']),4,'');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc'][2]),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta-rc'][2]['file'],'openads_upgrade_2.3.32-beta-rc2.xml','');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc'][5]),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta-rc'][5]['file'],'openads_upgrade_2.3.32-beta-rc5.xml','');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc'][10]),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta-rc'][10]['file'],'openads_upgrade_2.3.32-beta-rc10.xml','');
        $this->assertEqual(count($aVersions[2][3][32]['-beta-rc'][21]),1,'');
        $this->assertEqual($aVersions[2][3][32]['-beta-rc'][21]['file'],'openads_upgrade_2.3.32-beta-rc21.xml','');

        $this->assertEqual(count($aVersions[2][3][33]),2,'');
        $this->assertEqual(count($aVersions[2][3][33]['-beta']),1,'');
        $this->assertEqual($aVersions[2][3][33]['-beta']['file'],'openads_upgrade_2.3.33-beta.xml','');
        $this->assertEqual(count($aVersions[2][3][33]['-beta-rc']),2,'');
        $this->assertEqual($aVersions[2][3][33]['-beta-rc'][1]['file'],'openads_upgrade_2.3.33-beta-rc1.xml','');
        $this->assertEqual($aVersions[2][3][33]['-beta-rc'][2]['file'],'openads_upgrade_2.3.33-beta-rc2.xml','');

        $this->assertEqual(count($aVersions[2][4]),2,'');
        $this->assertEqual(count($aVersions[2][4][0]),1,'');
        $this->assertEqual($aVersions[2][4][0]['file'],'openads_upgrade_2.4.0.xml','');
        $this->assertEqual(count($aVersions[2][4][1]),2,'');
        $this->assertEqual(count($aVersions[2][4][1]['-rc']),2,'');
        $this->assertEqual($aVersions[2][4][1]['-rc'][1]['file'],'openads_upgrade_2.4.1-rc1.xml','');
        $this->assertEqual($aVersions[2][4][1]['-rc'][5]['file'],'openads_upgrade_2.4.1-rc5.xml','');
        $this->assertEqual($aVersions[2][4][1]['file'],'openads_upgrade_2.4.1.xml','');
    }

    /**
     * the given version is tested against an array of available upgrade versions
     * only relevant upgrade versions should be returned
     * they MUST be returned in order
     *
     */
    function test_getUpgradePackagesList()
    {
        global $writePath, $writeFile;

        $oUpgrade  = new OA_Upgrade();

        $aVersions = $oUpgrade->_readUpgradePackagesArray($writePath.$writeFile);

        $verPrev = '2.3.32-beta-rc1';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),12,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc2.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc5.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[10],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[11],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc2';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),11,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc5.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[10],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc3';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),11,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc5.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[10],'openads_upgrade_2.4.1.xml');


        $verPrev = '2.3.32-beta-rc4';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),11,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc5.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[10],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc5';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc6';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1.xml');


        $verPrev = '2.3.32-beta-rc7';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc8';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc9';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),10,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc10.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[9],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc10';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),9,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc20';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),9,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta-rc21.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[8],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta-rc21';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),8,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.32-beta.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[7],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.32-beta';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),7,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.33-beta-rc1.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[6],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.33-beta-rc1';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),6,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.33-beta-rc2.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[5],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.33-beta-rc2';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),5,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.3.33-beta.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[4],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.3.33-beta';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),4,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.4.0.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[3],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.4.0';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),3,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.4.1-rc1.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[2],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.4.1-rc1';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),2,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.4.1-rc5.xml');
        $this->assertEqual($aFiles[1],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.4.1-rc5';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),1,$verPrev);
        $this->assertEqual($aFiles[0],'openads_upgrade_2.4.1.xml');

        $verPrev = '2.4.1';
        $aFiles = $oUpgrade->getUpgradePackageList($verPrev, $aVersions);
        $this->assertEqual(count($aFiles),0,$verPrev);

        if (file_exists($writeFile))
        {
            unlink($writeFile);
        }
    }

    function test_runScript()
    {
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->upgradePath = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        $this->assertTrue($oUpgrade->runScript('prescript_openads_upgrade_1_to_2.php'));
    }

    function test_doBackups_and_pickupNoBackupsFile()
    {
        $oUpgrade  = new OA_Upgrade();
        if (file_exists($oUpgrade->nobackupsFile))
        {
            unlink($oUpgrade->nobackupsFile);
        }
        copy(MAX_PATH.'/lib/OA/Upgrade/tests/data/NOBACKUPS', $oUpgrade->nobackupsFile);

        $this->assertFalse($oUpgrade->_doBackups(), 'nobackups file wrongly detected');

        $this->assertTrue($oUpgrade->_pickupNoBackupsFile(), 'failed to pickup up nobackups file');
        $this->assertFalse(file_exists($oUpgrade->nobackupsFile),'nobackups file not removed');
    }

    function test_writeRecoveryFile()
    {
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->_pickupRecoveryFile();

        Mock::generatePartial(
            'OA_DB_UpgradeAuditor',
            $mockAuditor = 'OA_DB_UpgradeAuditor'.rand(),
            array('logAuditAction')
        );

        $oUpgrade->oAuditor->oDBAuditor = new $mockAuditor($this);

        for ($i=1; $i<4; $i++)
        {
            $oUpgrade->oAuditor->oDBAuditor->auditId = $i;
            $oUpgrade->package_file = "openads_upgrade_0.0.0{$i}-beta";
            $this->assertTrue($oUpgrade->_writeRecoveryFile(),'failed to write recovery file');
        }
    }

    function test_seekRecoveryFile()
    {
        $oUpgrade  = new OA_Upgrade();

        $oUpgrade->_pickupRecoveryFile();
        $this->test_writeRecoveryFile();
        $aResult = $oUpgrade->seekRecoveryFile();
        $this->assertIsA($aResult,'array','failed to find recovery file');

        for ($i=1; $i<4; $i++)
        {
            $this->assertEqual($aResult[$i-1]['auditId'],$i,'error in recovery array: auditId');
            $this->assertEqual($aResult[$i-1]['package'],"openads_upgrade_0.0.0{$i}-beta",'error in recovery array: package');
            $this->assertTrue(isset($aResult[$i-1]['updated']),'error in recovery array: updated');
        }
    }

    function test_pickupRecoveryFile()
    {
        $oUpgrade  = new OA_Upgrade();
        $this->assertTrue($oUpgrade->_pickupRecoveryFile(),'failed to remove recovery file');
        $oUpgrade->_pickupRecoveryFile();
    }

    function test_getOriginalApplicationVersion()
    {
        $oUpgrade  = new OA_Upgrade();

        Mock::generatePartial(
            'OA_UpgradeAuditor',
            $mockAuditor = 'OA_UpgradeAuditor'.rand(),
            array('queryAuditByUpgradeId',"getUpgradeActionId")
        );
        $oUpgrade->oAuditor = new $mockAuditor($this);

        $oUpgrade->oAuditor->setReturnValueAt(0,'getUpgradeActionId',1);
        $this->assertTrue($oUpgrade->_writeRecoveryFile(),'failed to write recovery file');

        $oUpgrade->oAuditor->setReturnValueAt(1,'getUpgradeActionId',2);
        $this->assertTrue($oUpgrade->_writeRecoveryFile(),'failed to write recovery file');

        $oUpgrade->oAuditor->setReturnValueAt(2,'getUpgradeActionId',3);
        $this->assertTrue($oUpgrade->_writeRecoveryFile(),'failed to write recovery file');

        $aAudit = array(0 => array('upgrade_action_id'=>1,
                        'upgrade_name'=>'openads_upgrade_2.0.11_to_2.3.0',
                        'version_to'=>'2.3.0',
                        'version_from'=>'2.0.11'
                       ));
        $oUpgrade->oAuditor->setReturnValue('queryAuditByUpgradeId', $aAudit);

        $this->assertEqual($oUpgrade->getOriginalApplicationVersion(),'2.0.11');

        $oUpgrade->_pickupRecoveryFile();
    }

    function testGetPostUpgradeTasks()
    {
        // create upgrade file
        $oUpgrade  = new OA_Upgrade();
        $oUpgrade->addPostUpgradeTask('Test_1');
        $oUpgrade->addPostUpgradeTask('Test_2');
        $oUpgrade->addPostUpgradeTask('Test_3');
        $this->assertTrue($oUpgrade->_writePostUpgradeTasksFile());
        
        $result = $oUpgrade->getPostUpgradeTasks();
        $this->assertEqual($result, array('Test_1', 'Test_2', 'Test_3'));
        
        // clean upgrade file
        $this->assertTrue($oUpgrade->pickupPostUpgradeTasksFile());
    }
    
    
    function testRunPostUpgradeTask()
    {
        $oUpgrade = new OA_Upgrade();
        $oUpgrade->upgradePath = MAX_PATH.'/lib/OA/Upgrade/tests/data/';
        Mock::generatePartial(
            'OA_UpgradeLogger',
            $mockLogger = 'OA_UpgradeLoggerMock'.rand(),
            array('logError', 'logOnly')
        );
        
        
        $file = $oUpgrade->upgradePath.'tasks/openads_upgrade_task_Test_1.php';
        $oLogger1 = new $mockLogger();
        $oLogger1->expectOnce('logError', array('Error from Test_1'));
        $oLogger1->expectAt(0, 'logOnly', array('attempting to include file '.$file));
        $oLogger1->expectAt(1, 'logOnly', array('Message from Test_1'));
        $oLogger1->expectAt(2, 'logOnly', array('executed file '.$file));
        $oLogger1->expectCallCount('logOnly', 3);
        $oUpgrade->oLogger = $oLogger1;
        $result = $oUpgrade->runPostUpgradeTask('Test_1');
        $expected = array(
            'task' => 'Test_1',
            'file' => $file,
            'result' => 'Result from Test_1',
            'errors' => array('Error from Test_1')); 
        $this->assertEqual($result, $expected);
        
        $file = $oUpgrade->upgradePath.'tasks/openads_upgrade_task_Test_2.php';
        $oLogger2 = new $mockLogger();
        $oLogger2->expectNever('logError');
        $oLogger2->expectAt(0, 'logOnly', array('attempting to include file '.$file));
        $oLogger2->expectAt(1, 'logOnly', array('Message from Test_2'));
        $oLogger2->expectAt(2, 'logOnly', array('executed file '.$file));
        $oLogger2->expectCallCount('logOnly', 3);
        $oUpgrade->oLogger = $oLogger2;
        $result = $oUpgrade->runPostUpgradeTask('Test_2');
        $expected = array(
            'task' => 'Test_2',
            'file' => $file,
            'result' => 'Result from Test_2',
            'errors' => array()); 
        $this->assertEqual($result, $expected);
        
        $file = $oUpgrade->upgradePath.'tasks/openads_upgrade_task_Test_3.php';
        $oLogger3 = new $mockLogger();
        $oLogger3->expectOnce('logError', array('Error from Test_3'));
        $oLogger3->expectAt(0, 'logOnly', array('attempting to include file '.$file));
        $oLogger3->expectAt(1, 'logOnly', array('executed file '.$file));
        $oLogger3->expectCallCount('logOnly', 2);
        $oUpgrade->oLogger = $oLogger3;
        $result = $oUpgrade->runPostUpgradeTask('Test_3');
        $expected = array(
            'task' => 'Test_3',
            'file' => $oUpgrade->upgradePath.'tasks/openads_upgrade_task_Test_3.php',
            'result' => null,
            'errors' => array('Error from Test_3')); 
        $this->assertEqual($result, $expected);
    }

    function test_createEmptyVarFile()
    {
        $oUpgrade  = new OA_Upgrade();
        $this->assertTrue($oUpgrade->_createEmptyVarFile('TESTEMPTYVARFILE'),'TESTEMPTYVARFILE');
        $this->assertTrue(file_exists(MAX_PATH.'/var/TESTEMPTYVARFILE'),'');
        if (file_exists(MAX_PATH.'/var/TESTEMPTYVARFILE'))
        {
            @unlink(MAX_PATH.'/var/TESTEMPTYVARFILE');
        }
    }

    function test_parseUpgradePackageFile()
    {
        $oUpgrade  = new OA_Upgrade();

        $aExpected = array();
        $aExpected['db_pkgs'] = array();
        $aExpected['name'] ='Openads';
        $aExpected['creationDate'] ='2007-01-01';
        $aExpected['author'] ='Test Author';

        Mock::generatePartial(
            'OA_UpgradePackageParser',
            $mockParser = 'OA_UpgradePackageParser'.rand(),
            array('setInputFile', 'parse')
        );

        $oUpgrade->oParser = new $mockParser($this);
        $oUpgrade->oParser->setReturnValue('setInputFile', true);
        $oUpgrade->oParser->expectOnce('setInputFile');
        $oUpgrade->oParser->setReturnValue('parse', $aExpected);
        $oUpgrade->oParser->expectOnce('parse');

        $this->assertTrue($oUpgrade->_parseUpgradePackageFile('test_file'),'upgrade package parse method failed');

        $oUpgrade->oParser->tally();

    }

    function test_upgradeSchemasPass()
    {
        $oUpgrade  = new OA_Upgrade();

        Mock::generatePartial(
            'OA_Version_Controller',
            $mockVersioner = 'OA_Version_Controller'.rand(),
            array('getSchemaVersion', 'putSchemaVersion')
        );

        $oUpgrade->oVersioner = new $mockVersioner($this);
        $oUpgrade->oVersioner->setReturnValue('getSchemaVersion', 1);
        $oUpgrade->oVersioner->expectOnce('getSchemaVersion');
        $oUpgrade->oVersioner->setReturnValue('putSchemaVersion', null);
        $oUpgrade->oVersioner->expectOnce('putSchemaVersion');

        Mock::generatePartial(
            'OA_DB_Upgrade',
            $mockDBUpgrade = 'OA_DB_Upgrade'.rand(),
            array('upgrade','init')
        );

        $oUpgrade->oDBUpgrader = new $mockDBUpgrade($this);
        $oUpgrade->oDBUpgrader->setReturnValue('upgrade', true);
        $oUpgrade->oDBUpgrader->expectCallCount('upgrade',2);
        $oUpgrade->oDBUpgrader->setReturnValue('init', true);
        $oUpgrade->oDBUpgrader->expectCallCount('init',2);


        Mock::generatePartial(
            'OA_DB_UpgradeAuditor',
            $mockAuditor = 'OA_DB_UpgradeAuditor'.rand(),
            array('logAuditAction')
        );

        $oUpgrade->oAuditor->oDBAuditor = new $mockAuditor($this);
        $oUpgrade->oAuditor->oDBAuditor->setReturnValue('logAuditAction', true);

        $oUpgrade->aDBPackages = array(0=>array('version'=>'2','schema'=>'test_tables','files'=>''));

        $this->assertTrue($oUpgrade->upgradeSchemas(),'schema upgrade method failed');
        $this->assertEqual($oUpgrade->versionInitialSchema['test_tables'],1,'error setting initial schema version');

        $oUpgrade->oDBUpgrader->tally();
        $oUpgrade->oVersioner->tally();
    }

    function test_upgradeSchemasFail()
    {
        $oUpgrade  = new OA_Upgrade();

        Mock::generatePartial(
            'OA_Version_Controller',
            $mockVersioner = 'OA_Version_Controller'.rand(),
            array('getSchemaVersion', 'putSchemaVersion')
        );

        $oUpgrade->oVersioner = new $mockVersioner($this);
        $oUpgrade->oVersioner->setReturnValueAt(0, 'getSchemaVersion', 1);
        $oUpgrade->oVersioner->expectCallCount('getSchemaVersion', 1);
        $oUpgrade->oVersioner->setReturnValue('putSchemaVersion', null);
        $oUpgrade->oVersioner->expectCallCount('putSchemaVersion', 0);

        Mock::generatePartial(
            'OA_DB_Upgrade',
            $mockDBUpgrade = 'OA_DB_Upgrade'.rand(),
            array('init','upgrade', 'rollback', 'prepPrescript', 'prepPostcript', 'prepRollback')
        );

        $oUpgrade->oDBUpgrader = new $mockDBUpgrade($this);
        $oUpgrade->oDBUpgrader->setReturnValue('init', true);
        $oUpgrade->oDBUpgrader->expectCallCount('init', 1);
        $oUpgrade->oDBUpgrader->setReturnValue('prepPrescript', true);
        $oUpgrade->oDBUpgrader->expectCallCount('prepPrescript', 0);
        $oUpgrade->oDBUpgrader->setReturnValue('upgrade', false);
        $oUpgrade->oDBUpgrader->expectCallCount('upgrade', 1);

        Mock::generatePartial(
            'OA_DB_UpgradeAuditor',
            $mockAuditor = 'OA_DB_UpgradeAuditor'.rand(),
            array('logAuditAction')
        );

        $oUpgrade->oAuditor->oDBAuditor = new $mockAuditor($this);
        $oUpgrade->oAuditor->oDBAuditor->setReturnValue('logAuditAction', true);

        $oUpgrade->aDBPackages = array(0=>array('version'=>'2','schema'=>'test_tables','files'=>''));

        $this->assertFalse($oUpgrade->upgradeSchemas(),'schema upgrade method failed (testing failure.  it was supposed to fail and it didn\'t)');

        $this->assertEqual($oUpgrade->versionInitialSchema['test_tables'],1,'error setting initial schema version');

        $oUpgrade->oDBUpgrader->tally();
        $oUpgrade->oVersioner->tally();
    }

    function test_upgradeExecute()
    {

    }

    function test_upgrade()
    {

    }

    function test_recoverUpgrade()
    {

    }
    
    function testPutAdmin()
    {
        $oUpgrade  = new OA_Upgrade();
        
        // Prepare test data
        $aAdmin = array(
            'email'    => 'email@test.org',
            'name'     => 'testadmin',
            'pword'    => 'testpass',
            'language' => 'es',
        );
        $aPrefs = array( 
            'timezone' => 'Europe/Madrid'
        );
        
        // there shouldn't be admin account
        $adminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');
        $this->assertNull($adminAccountId);

        // create admin
        $result = $oUpgrade->putAdmin($aAdmin, $aPrefs);
        $this->assertTrue($result);
        
        // admin account is set
        $adminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');
        $this->assertNotNull($adminAccountId);
        
        $doAccount = OA_Dal::factoryDO('accounts');
        $doAccount->get($adminAccountId);
        $this->assertEqual($doAccount->account_type, OA_ACCOUNT_ADMIN);
        $this->assertEqual($doAccount->account_name, 'Administrator account');
        
        // user exists
        $doUser =  OA_Dal::factoryDO('users');
        $doUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doUserAssoc->account_id = $adminAccountId;
        $doUser->joinAdd($doUserAssoc);
        $doUser->find();
        $this->assertTrue($doUser->fetch());
        $this->assertEqual($doUser->contact_name, 'Administrator');
        $this->assertEqual($doUser->email_address, $aAdmin['email']);
        $this->assertEqual($doUser->username, $aAdmin['name']);
        $this->assertEqual($doUser->password, md5($aAdmin['pword']));
        $this->assertEqual($doUser->language, $aAdmin['language']); 
        
        // agency was created
        $doAgency = OA_Dal::factoryDO('agency');
        $doAccount = OA_Dal::factoryDO('accounts');
        $doAccount->account_id = $doUser->default_account_id;
        $doAgency->joinAdd($doAccount);
        $doAgency->find();
        $this->assertTrue($doAgency->fetch());
        $this->assertEqual($doAgency->name, 'Default manager');
        $this->assertEqual($doAgency->email, $aAdmin['email']);
        $this->assertEqual($doAgency->active, 1);
        
        // Default preferences + custom timezone are set 
        $oPreferences = new OA_Preferences();
        $aDefPrefs = $oPreferences->getPreferenceDefaults();
        $aExpected = array();
        foreach ($aDefPrefs as $name => $values)
        {
            $aExpected[$name] = $values['default'];
        }
        $aExpected['timezone'] = $aPrefs['timezone'];
        $aExpected['language'] = 'en'; //added by get admin account preferences
        
        $aAdminPreferences = OA_Preferences::loadAdminAccountPreferences(true);
        $this->assertEqual($aExpected, $aAdminPreferences);
        
        // trunkate tables
        DataGenerator::cleanUp(array('account_preference_assoc', 'preferences',
            'account_user_assoc', 'users', 'agency', 'accounts'));
        // remove admin_account_id from application variables
        OA_Dal_ApplicationVariables::delete('admin_account_id');
    }
    
    
    function test_rollbackPutAdmin()
    {        
        $oUpgrade  = new OA_UpgradeRollbackTest();
        
        // Call putAdmin method
        $aAdmin = array(
            'email'    => 'email@test.org',
            'name'     => 'testadmin',
            'pword'    => 'testpass',
            'language' => 'es',
        );
        $aPrefs = array( 
            'timezone' => 'Europe/Madrid'
        );
        $oUpgrade->putAdmin($aAdmin, $aPrefs);
        
        // call rollback method
        $oUpgrade->_rollbackPutAdmin();
        
        // check tables
        $doPreferencesAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $this->assertEqual($doPreferencesAssoc->getAll(), array());
        $doPreferences = OA_Dal::factoryDO('preferences');
        $this->assertEqual($doPreferences->getAll(), array());
        $doUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $this->assertEqual($doUserAssoc->getAll(), array());
        $doUser = OA_Dal::factoryDO('users');
        $this->assertEqual($doUser->getAll(), array());
        $doAgency = OA_Dal::factoryDO('agency');
        $this->assertEqual($doAgency->getAll(), array());
        $doAccount = OA_Dal::factoryDO('accounts');
        $this->assertEqual($doAccount->getAll(), array());
        // admin_account_id in appliation variables should be deleted
        $this->assertNull(OA_Dal_ApplicationVariables::get('admin_account_id'));
    }
    
    
    function testCanUpgradeOrInstall()
    {
        // run once upgrade or install
        $oUpgrade  = new OA_Upgrade();
        $firstResult = $oUpgrade->canUpgradeOrInstall();
        $existing_installation_status = $oUpgrade->existing_installation_status;
        $aPackageList = $oUpgrade->aPackageList;
        $aMessages = $oUpgrade->getMessages();
        $oUpgrade->oLogger->logClear();
        $oUpgrade->aPackageList = array();
        $oUpgrade->existing_installation_status = 235234;
        
        // run another one and check values
        $this->assertEqual($oUpgrade->canUpgradeOrInstall(), $firstResult);
        $this->assertEqual($oUpgrade->existing_installation_status, $existing_installation_status);
        $this->assertEqual($oUpgrade->aPackageList, $aPackageList);
        $this->assertEqual($oUpgrade->getMessages(), $aMessages);
    }

}

?>
