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


require_once MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php';

/**
 * A class for testing the Openads_DB_Upgrade class.
 *
 * @package    OpenX Upgrade
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class Test_OA_phpAdsNew extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_phpAdsNew()
    {
        $this->UnitTestCase();
    }

    function test_init()
    {
        $oPAN = new OA_phpAdsNew();

        $oPAN->init();
        $this->assertFalse($oPAN->detected,'phpAdsNew falsely detected');

        $this->_putPanConfigFile('pan.config.inc.php');
        $oPAN->init();
        $this->assertTrue($oPAN->detected,'failed to detect phpAdsNew');

        if ($GLOBALS['_MAX']['CONF']['database']['type']=='mysql')
        {
            $this->assertEqual($oPAN->engine,'PANENGINE','mysql storage engine not detected');
        }
//      no longer matters if engine type is found
//      the sql statements should be separated so as to ensure that the engine is not used for pgsql
//        else if ($GLOBALS['_MAX']['CONF']['database']['type']=='pgsql')
//        {
//            $this->assertEqual($oPAN->engine,'','engine incorrectly detected for pgsql');
//        }
        $this->assertEqual($oPAN->prefix,'panprefix_','prefix not detected');

    }

    function test_migratePANConfig()
    {
        $oPAN = new OA_phpAdsNew();

        // Test 1
        $this->_putPanConfigFile('pan.config.inc.php');
        $aResult = $oPAN->_migratePANConfig($oPAN->_getPANConfig());
        $this->_deletePanConfigFile();
        $this->assertEqual($aResult['database']['host'],'pan_host','host not set');
        $this->assertEqual($aResult['database']['port'],'9999','port not set');
        $this->assertEqual($aResult['database']['username'],'pan_user','username not set');
        $this->assertEqual($aResult['database']['password'],'pan_password','password not set');
        $this->assertEqual($aResult['database']['name'],'pan_database','database not set');
        $this->assertFalse($aResult['database']['persistent'],'persistent incorrect');

        $this->assertTrue($aResult['ui']['enabled'],'"UI Enabled" incorrect');
        $this->assertFalse($aResult['openads']['requireSSL'], 'requireSSL incorrect');
        $this->assertTrue($aResult['maintenance']['autoMaintenance'], 'autoMaintenance incorrect');
        $this->assertFalse($aResult['logging']['reverseLookup'], 'reverseLookup incorrect');
        $this->assertFalse($aResult['logging']['proxyLookup'],  'proxyLookup incorrect');
        $this->assertTrue($aResult['logging']['adImpressions'],'adImpressions incorrect');
        $this->assertTrue($aResult['logging']['adClicks'],'adClicks incorrect');
//        $this->assertFalse($aResult[''][''] = $phpAds_config['log_beacon'],' incorrect');;
//        $this->assertFalse($aResult[''][''] = $phpAds_config['ignore_hosts'],' incorrect');;
        $this->assertEqual($aResult['logging']['blockAdImpressions'],0, 'blockAdImpressions incorrect');
        $this->assertEqual($aResult['logging']['blockAdClicks'], 0, 'blockAdClicks incorrect');
        $this->assertTrue($aResult['p3p']['policies'],'policies incorrect');
        $this->assertEqual($aResult['p3p']['compactPolicy'],'NOI CUR ADM OUR NOR STA NID', 'compactPolicy incorrect');
        $this->assertEqual($aResult['p3p']['policyLocation'],'pan_p3p_policy_location','policyLocation incorrect');
        $this->assertTrue($aResult['delivery']['acls'],'acls incorrect');

        $aExpections = $this->_getMigrationExpectations();
        foreach ($aExpections as $i => $v)
        {
            $this->_setPanConfigFile($v['source']);
            $aResult = $oPAN->_migratePANConfig($oPAN->_getPANConfig());
            $this->assertEqual($aResult['database']['protocol'] , $v['target']['database']['protocol'], $v['desc'].' protocol'  );
            $this->assertEqual($aResult['database']['host']     , $v['target']['database']['host']    , $v['desc'].' host'      );
            $this->assertEqual($aResult['database']['port']     , $v['target']['database']['port']    , $v['desc'].' port'      );
            $this->assertEqual($aResult['database']['socket']   , $v['target']['database']['socket']  , $v['desc'].' socket'    );
            $this->assertEqual($aResult['database']['type']     , $v['target']['database']['type']    , $v['desc'].' db type'   );
            $this->assertEqual($aResult['table']['type']        , $v['target']['table']['type']       , $v['desc'].' table type');
        }
        $this->_deletePanConfigFile();
    }

    function _putPanConfigFile($fileFrom)
    {
        $fileTo     = MAX_PATH.'/var/config.inc.php';
        $fileFrom   = MAX_PATH.'/lib/OA/Upgrade/tests/data/'.$fileFrom;

        if (file_exists($fileTo))
        {
            unlink($fileTo);
        }
        $this->assertTrue(file_exists($fileFrom),'pan test config source does not exist');
        $this->assertTrue(copy($fileFrom, $fileTo),'failed to copy pan test config file');
        $this->assertTrue(file_exists($fileTo),'pan test config target does not exist');
    }

    function _setPanConfigFile($aParams)
    {
        $fileTo = MAX_PATH.'/var/config.inc.php';
        if (file_exists($fileTo))
        {
            unlink($fileTo);
        }
        if ($fh = fopen($fileTo, 'w'))
        {
            fwrite($fh, "<?php\n");
            if (isset($aParams['dblocal']))
            {
                fwrite($fh, "\$phpAds_config['dblocal']     = {$aParams['dblocal']};\n");
            }
            fwrite($fh, "\$phpAds_config['dbhost']      = '{$aParams['dbhost']}';\n");
            fwrite($fh, "\$phpAds_config['dbport']      = '{$aParams['dbport']}';\n");
            fwrite($fh, "\$phpAds_config['table_type']  = '{$aParams['table_type']}';\n");
            fwrite($fh, "\$phpAds_config['dbuser']      = 'user';\n");
            fwrite($fh, "\$phpAds_config['dbpassword']  = 'pass';\n");
            fwrite($fh, "\$phpAds_config['dbname']      = 'pan';\n");
            fwrite($fh, "\$phpAds_config['ignore_hosts'] = array()\n;");
            fwrite($fh, '?>');
            fclose($fh);
        }
        $this->assertTrue(file_exists($fileTo),'var/config.inc.php does not exist');
    }


    function _deletePanConfigFile()
    {
        $fileTo     = MAX_PATH.'/var/config.inc.php';

        if (file_exists($fileTo))
        {
            unlink($fileTo);
        }
        $this->assertFalse(file_exists($fileTo),'pan test config file not deleted');
    }

    function _getMigrationExpectations()
    {
        $i = -1;
        $aResult[++$i]['desc']                          = 'Test '.$i.' : pan tcp localhost (mysql)';

        $aResult[$i]['source']['dblocal']               = 'false';
        $aResult[$i]['source']['dbhost']                = 'localhost';
        $aResult[$i]['source']['dbport']                = 3306;
        $aResult[$i]['source']['table_type']            = 'MYISAM';

        $aResult[$i]['target']['database']['protocol']  = 'tcp';
        $aResult[$i]['target']['database']['host']      ='localhost';
        $aResult[$i]['target']['database']['port']      = '3306';
        $aResult[$i]['target']['database']['socket']    = '';
        $aResult[$i]['target']['database']['type']      =  'mysql';
        $aResult[$i]['target']['table']['type']         = 'MYISAM';

        $aResult[++$i]['desc']                          = 'Test '.$i.' : pan tcp localhost (pgsql)';

        $aResult[$i]['source']['dblocal']               = 'false';
        $aResult[$i]['source']['dbhost']                = 'localhost';
        $aResult[$i]['source']['dbport']                = 5432;
        $aResult[$i]['source']['table_type']            = '';

        $aResult[$i]['target']['database']['protocol']  = 'tcp';
        $aResult[$i]['target']['database']['host']      ='localhost';
        $aResult[$i]['target']['database']['port']      = '5432';
        $aResult[$i]['target']['database']['socket']    = '';
        $aResult[$i]['target']['database']['type']      =  'pgsql';
        $aResult[$i]['target']['table']['type']         = '';


        $aResult[++$i]['desc']                          = 'Test '.$i.' : pan unix default (pgsql)';

        $aResult[$i]['source']['dblocal']               = 'true';
        $aResult[$i]['source']['dbhost']                = 'localhost';
        $aResult[$i]['source']['dbport']                = 5432;
        $aResult[$i]['source']['table_type']            = '';

        $aResult[$i]['target']['database']['protocol']  = 'unix';
        $aResult[$i]['target']['database']['host']      ='localhost';
        $aResult[$i]['target']['database']['port']      = '5432';
        $aResult[$i]['target']['database']['socket']    = '';
        $aResult[$i]['target']['database']['type']      =  'pgsql';
        $aResult[$i]['target']['table']['type']         = '';

        $aResult[++$i]['desc']                          = 'Test '.$i.' : pan unix default (mysql)';

        $aResult[$i]['source']['dblocal']               = 'true';
        $aResult[$i]['source']['dbhost']                = 'localhost';
        $aResult[$i]['source']['dbport']                = 3306;
        $aResult[$i]['source']['table_type']            = 'MYISAM';

        $aResult[$i]['target']['database']['protocol']  = 'unix';
        $aResult[$i]['target']['database']['host']      ='localhost';
        $aResult[$i]['target']['database']['port']      = '3306';
        $aResult[$i]['target']['database']['socket']    = '';
        $aResult[$i]['target']['database']['type']      =  'mysql';
        $aResult[$i]['target']['table']['type']         = 'MYISAM';

        $aResult[++$i]['desc']                          = 'Test '.$i.' : pan unix custom (mysql)';

        $aResult[$i]['source']['dblocal']               = 'true';
        $aResult[$i]['source']['dbhost']                = ':/var/lib/mysql/mysql.sock';
        $aResult[$i]['source']['dbport']                = 3306;
        $aResult[$i]['source']['table_type']            = 'MYISAM';

        $aResult[$i]['target']['database']['protocol']  = 'unix';
        $aResult[$i]['target']['database']['host']      ='localhost';
        $aResult[$i]['target']['database']['port']      = '3306';
        $aResult[$i]['target']['database']['socket']    = '/var/lib/mysql/mysql.sock';
        $aResult[$i]['target']['database']['type']      =  'mysql';
        $aResult[$i]['target']['table']['type']         = 'MYISAM';

        $aResult[++$i]['desc']                          = 'Test '.$i.' : pan unix custom (pgsql)';

        $aResult[$i]['source']['dblocal']               = 'true';
        $aResult[$i]['source']['dbhost']                = ':/tmp/pgsocket';
        $aResult[$i]['source']['dbport']                = 5432;
        $aResult[$i]['source']['table_type']            = '';

        $aResult[$i]['target']['database']['protocol']  = 'unix';
        $aResult[$i]['target']['database']['host']      ='localhost';
        $aResult[$i]['target']['database']['port']      = '5432';
        $aResult[$i]['target']['database']['socket']    = '/tmp/pgsocket';
        $aResult[$i]['target']['database']['type']      =  'pgsql';
        $aResult[$i]['target']['table']['type']         = '';

        $aResult[++$i]['desc']                          = 'Test '.$i.' : v0.1 tcp localhost (mysql)';

        $aResult[$i]['source']['dbhost']                = 'localhost';
        $aResult[$i]['source']['dbport']                = 3306;
        $aResult[$i]['source']['table_type']            = 'INNODB';

        $aResult[$i]['target']['database']['protocol']  = 'tcp';
        $aResult[$i]['target']['database']['host']      ='localhost';
        $aResult[$i]['target']['database']['port']      = '3306';
        $aResult[$i]['target']['database']['socket']    = '';
        $aResult[$i]['target']['database']['type']      =  'mysql';
        $aResult[$i]['target']['table']['type']         = 'INNODB';

        $aResult[++$i]['desc']                          = 'Test '.$i.' : v0.1 unix localhost (mysql)';

        $aResult[$i]['source']['dbhost']                = 'localhost';
        $aResult[$i]['source']['dbport']                = '/var/lib/mysql/mysql.sock';
        $aResult[$i]['source']['table_type']            = 'INNODB';

        $aResult[$i]['target']['database']['protocol']  = 'unix';
        $aResult[$i]['target']['database']['host']      ='localhost';
        $aResult[$i]['target']['database']['port']      = '3306';
        $aResult[$i]['target']['database']['socket']    = '/var/lib/mysql/mysql.sock';
        $aResult[$i]['target']['database']['type']      =  'mysql';
        $aResult[$i]['target']['table']['type']         = 'INNODB';

        return $aResult;
    }

/* need to mock PAN db installation
    ...but, the dbh is called via static method
    function test_getPANversion()
    {
        $oPAN = new OA_phpAdsNew();

        $this->_putPanConfigFile();

        Mock::generatePartial(
            'MDB2_Driver_Common',
            $mockDbh = 'MDB2_Driver_Common'.rand(),
            array('')
        );

        $oUpgrade->mockDbh = new $mockDbh($this);
        $result = $oPAN->getPANversion();
        $this->_deletePanConfigFile();
    }
*/
}

?>
