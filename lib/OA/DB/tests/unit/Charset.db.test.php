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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB/Charset.php';

/**
 * A class for testing the OA_DB_Charset class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 */
class Test_OA_DB_Charset extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function testMySQL()
    {
        $oDbh = OA_DB::singleton();
        if ($oDbh->dbsyntax == 'mysql') {
            $oDbc = OA_DB_Charset::factory($oDbh);
            $this->assertTrue($oDbc);

            $aVersion = $oDbh->getServerVersion();
            if (version_compare($aVersion['native'], '4.1.2', '>=')) {
                $this->assertTrue($oDbc->oDbh);
                $this->assertEqual($oDbc->getDatabaseCharset(), 'utf8');
                $this->assertTrue($oDbc->getClientCharset());

                $aCharsets = array('utf8', 'latin1', 'cp1251');
                foreach ($aCharsets as $charset) {
                    $this->assertTrue($oDbc->setClientCharset($charset));
                    $this->assertEqual($oDbc->getClientCharset(), $charset);
                }
            } else {
                $this->assertFalse($oDbc->oDbh);
            }
        }
    }

    function testPgSQL()
    {
        $oDbh = OA_DB::singleton();
        if ($oDbh->dbsyntax == 'pgsql') {
            $oDbc = OA_DB_Charset::factory($oDbh);
            $this->assertTrue($oDbc);

            $this->assertTrue($oDbc->oDbh);
            $this->assertEqual($oDbc->getDatabaseCharset(), 'UTF8');
            $this->assertEqual($oDbc->getClientCharset(), 'UTF8');

            $aCharsets = array('LATIN1', 'UTF8', 'SJIS');
            foreach ($aCharsets as $charset) {
                $this->assertTrue($oDbc->setClientCharset($charset));
                $this->assertEqual($oDbc->getClientCharset(), $charset);
            }
        }
    }
}


?>