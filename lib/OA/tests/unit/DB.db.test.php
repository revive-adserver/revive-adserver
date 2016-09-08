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
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the OA_DB class.
 *
 * @package    OpenXDB
 * @subpackage TestSuite
 */
class Test_OA_DB extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Tests that the database type is setup in the config .ini file.
     */
    function testDbTypeDefined()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($aConf['database']['type']);
        $this->assertNotEqual($aConf['database']['type'], '');
    }

    /**
     * Tests that the database host is setup in the config .ini file.
     */
    function testDbHostDefined()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($aConf['database']['host']);
        $this->assertNotEqual($aConf['database']['host'], '');
    }

    /**
     * Tests that the database port is setup in the config .ini file.
     */
    function testDbPortDefined()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($aConf['database']['port']);
        $this->assertNotEqual($aConf['database']['port'], '');
    }

    /**
     * Tests that the database user is setup in the config .ini file.
     */
    function testDbUserDefined()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($aConf['database']['username']);
        $this->assertNotEqual($aConf['database']['username'], '');
    }

    /**
     * Tests that the database password is setup in the config .ini file.
     */
    function testDbPasswordDefined()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($aConf['database']['password']);
    }

    /**
     * Tests that the database name is setup in the config .ini file.
     */
    function testDbNameDefined()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($aConf['database']['name']);
        $this->assertNotEqual($aConf['database']['name'], '');
    }

    /**
     * Tests that the OpenX table prefix is setup in the config .ini file.
     */
    function testDbPrefixDefined()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->assertNotNull($aConf['table']['prefix']);
    }

    /**
     * Tests that the database connection can be made, without using the
     * Dal class - that is, that the details specified above are okay.
     */
    function testDbConnection()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $dbConnection = MDB2::singleton(
            strtolower($aConf['database']['type']) . '://' .
            $aConf['database']['username'] . ':' .  $aConf['database']['password'] .
            '@' . $aConf['database']['host'] . ':' . $aConf['database']['port'] . '/' .
            $aConf['database']['name']
        );
        $this->assertTrue($dbConnection);
    }

    /**
     * Tests that the singleton() method only ever returns one
     * database connection.
     */
    function testSingletonDbConnection()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $firstConnection  =& OA_DB::singleton();
        $secondConnection =& OA_DB::singleton();
        $this->assertIdentical($firstConnection, $secondConnection);
        $this->assertReference($firstConnection, $secondConnection);
        TestEnv::restoreConfig();
    }

    function testSingleton()
    {
        $oDbh = OA_DB::singleton();
        $this->assertNotNull($oDbh);
        $this->assertFalse(PEAR::isError($oDbh));

        $dsn = "mysql://scott:tiger@non-existent-host:666/non-existent-database";
        RV::disableErrorHandling();
        $oDbh =& OA_DB::singleton($dsn);
        RV::enableErrorHandling();
        $this->assertNotNull($oDbh);
        $this->assertTrue(PEAR::isError($oDbh));
    }


    function testGetSequenceName()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];
        $prefix = $conf['table']['prefix'] = 'ox_';

        $oDbh = &OA_DB::singleton();

        if ($oDbh->dbsyntax == 'pgsql') {
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'x', 'a'),
                'ox_x_a_seq');
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxyy', 'a'),
                'ox_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx_a_seq');
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'x', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaabb'),
                'ox_x_aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa_seq');
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'xxxxxxxxxxxxxxxxxxxxxxxxxxy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaab'),
                'ox_xxxxxxxxxxxxxxxxxxxxxxxxxx_aaaaaaaaaaaaaaaaaaaaaaaaaaaaa_seq');

            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'x', 'a', false),
                'ox_x_a');
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxyy', 'a', false),
                'ox_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx_a');
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'x', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaabb', false),
                'ox_x_aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'xxxxxxxxxxxxxxxxxxxxxxxxxxy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaab', false),
                'ox_xxxxxxxxxxxxxxxxxxxxxxxxxx_aaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        } else {
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'x', 'a'), 'x');
            $this->assertEqual(OA_DB::getSequenceName($oDbh, 'x', 'a', false), 'x');
        }

        TestEnv::restoreConfig();
    }

    /**
     *  Method to tests function validateDatabaseName in MDB2 Manager modules
     */
    function testValidateDatabaseName()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh  = &OA_DB::singleton();

        RV::disableErrorHandling();
        if ($aConf['database']['type'] == 'mysql' || $aConf['database']['type'] == 'mysqli') {
            $result = $oDbh->manager->validateDatabaseName('test white space ');
            $this->assertTrue(PEAR::isError($result));
            $result = $oDbh->manager->validateDatabaseName('special'.chr(255).'char');
            $this->assertTrue(PEAR::isError($result));
            $result = $oDbh->manager->validateDatabaseName('characters/that are not allowed in filenames.');
            $this->assertTrue(PEAR::isError($result));
            $result = $oDbh->manager->validateDatabaseName('abcdefghij1234567890123456789012345678901234567890123456789012345'); //65 chars
            $this->assertTrue(PEAR::isError($result));
            $this->assertTrue ($oDbh->manager->validateDatabaseName('abcdefghij123456789012345678901234567890123456789012345678901234')); //64 chars
        }
        if ($aConf['database']['type'] == 'pgsql') {
            $result = $oDbh->manager->validateDatabaseName('abcdefghij123456789012345678901234567890123456789012345678901234'); //64 chars
            $this->assertTrue(PEAR::isError($result));
            $this->assertTrue($oDbh->manager->validateDatabaseName('abcdefghij12345678901234567890123456789012345678901234567890123')); //63 chars
            $result = $oDbh->manager->validateDatabaseName('1 is first character alfabetic');
            $this->assertTrue(PEAR::isError($result));
            $this->assertTrue($oDbh->manager->validateDatabaseName('properName'));
        }
        RV::enableErrorHandling();
    }

    /**
     *  Method to test function validateDatabaseName in MDB2 Manager modules
     */
    function testValidateTableName()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        RV::disableErrorHandling();

        $vals = array(
                        0,
                        32, // chr(32) ox_32_ _test
                        33, // chr(33) ox_33_!_test
                        34, // chr(34) ox_34_"_test
                        35, // chr(35) ox_35_#_test
                        37, // chr(37) ox_37_%_test
                        38, // chr(38) ox_38_&_test
                        39, // chr(39) ox_39_'_test
                        40, // chr(40) ox_40_(_test
                        41, // chr(41) ox_41_)_test
                        42, // chr(42) ox_42_*_test
                        43, // chr(43) ox_43_+_test
                        44, // chr(44) ox_44_,_test
                        45, // chr(45) ox_45_-_test
                        46, // chr(46) ox_46_._test
                        47, // chr(47) ox_47_/_test
                        58, // chr(58) ox_58_:_test
                        59, // chr(59) ox_59_;_test
                        60, // chr(60) ox_60_<_test
                        61, // chr(61) ox_61_=_test
                        62, // chr(62) ox_62_>_test
                        63, // chr(63) ox_63_?_test
                        64, // chr(64) ox_64_@_test
                        91, // chr(91) ox_91_[_test
                        92, // chr(92) ox_92_\_test
                        93, // chr(93) ox_93_]_test
                        94, // chr(94) ox_94_^_test
                        96, // chr(96) ox_96_`_test
                        123,// chr(123) ox_123_{_test
                        124,// chr(124) ox_124_|_test
                        125,// chr(125) ox_125_}_test
                        126,// chr(126) ox_126_~_test
                        156,// chr(156) ox_156_£_test
                        255,
                    );

        //$pattern = '';
        foreach ($vals as $i)
        {
            //$pattern.= '\\x'.dechex($i);
            $result = OA_DB::validateTableName('o'.chr($i).'_table');
            $this->assertTrue(PEAR::isError($result), 'chr('.$i.') /'.dechex($i));
        }

        if ($aConf['database']['type'] == 'mysql' || $aConf['database']['type'] == 'mysqli')
        {
            $result = OA_DB::validateTableName('abcdefghij1234567890123456789012345678901234567890123456789012345'); //65 chars
            $this->assertTrue(PEAR::isError($result));
            $this->assertTrue (OA_DB::validateTableName('abcdefghij123456789012345678901234567890123456789012345678901234')); //64 chars

            $this->assertTrue(OA_DB::validateTableName('aBcDeFgHiJkLmNoPqRsTuVwXyZ_$1234567890'));

            $result = OA_DB::validateTableName('2_$');
            $this->assertFalse(PEAR::isError($result));
            $result = OA_DB::validateTableName('$_2');
            $this->assertFalse(PEAR::isError($result));
            $result = OA_DB::validateTableName('_$2');
            $this->assertFalse(PEAR::isError($result));
        }

        if ($aConf['database']['type'] == 'pgsql')
        {

            $result = OA_DB::validateTableName('abcdefghij123456789012345678901234567890123456789012345678901234'); //64 chars
            $this->assertTrue(PEAR::isError($result));

            $this->assertTrue(OA_DB::validateTableName('abcdefghij12345678901234567890123456789012345678901234567890123')); //63 chars

            $result = OA_DB::validateTableName('0x_table');
            $this->assertTrue(PEAR::isError($result));

            $result = OA_DB::validateTableName(' x_table');
            $this->assertTrue(PEAR::isError($result));

            $this->assertTrue(OA_DB::validateTableName('aBcDeFgHiJkLmNoPqRsTuVwXyZ_$1234567890'));

            $result = OA_DB::validateTableName('2_$');
            $this->assertTrue(PEAR::isError($result));
            $result = OA_DB::validateTableName('$_2');
            $this->assertTrue(PEAR::isError($result));
            $result = OA_DB::validateTableName('_$2');
            $this->assertFalse(PEAR::isError($result));
        }
        RV::enableErrorHandling();
    }

}

?>
