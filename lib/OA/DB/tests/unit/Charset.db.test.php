<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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
$Id$
*/

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB/Charset.php';

/**
 * A class for testing the OA_DB_Charset class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_DB_Charset extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_DB_Charset()
    {
        $this->UnitTestCase();
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