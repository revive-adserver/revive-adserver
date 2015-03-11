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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/**
 * A class for testing DAL Agency methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class MAX_Dal_Admin_AgencyTest extends DalUnitTestCase
{
    var $dalAgency;

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function setUp()
    {
        $this->dalAgency = OA_Dal::factoryDAL('agency');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testGetLogoutUrl()
    {
        // Insert an agency without a logout url
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->logout_url = '';
        $agencyId = DataGenerator::generateOne($doAgency);

        $path = 'serveraddress';
        $GLOBALS['_MAX']['CONF']['webpath']['admin'] = $path;
        $GLOBALS['_MAX']['CONF']['openads']['sslPort'] = 443;
        $GLOBALS['_MAX']['HTTP'] = 'http://';
        $expected = 'http://'.$path.'/index.php';
        $this->assertEqual($this->dalAgency->getLogoutUrl($agencyId), $expected);

        // Insert an agency with a logout url
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->logout_url = 'http://example.com';
        $agencyId = DataGenerator::generateOne($doAgency);

        $expected = 'http://example.com';
        $this->assertEqual($this->dalAgency->getLogoutUrl($agencyId), $expected);

    }
}
?>
