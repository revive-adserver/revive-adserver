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
 * A class for testing non standard DataObjects_Channel methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 */
class DataObjects_ChannelTest extends DalUnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    function testDelete()
    {
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->acls_updated = '2007-04-03 19:29:54';
        $channelId = DataGenerator::generateOne($doChannel, true);

        $doAcls = OA_Dal::factoryDO('acls');
        $doAcls->bannerid = 1;
        $doAcls->type = 'Site:Channel';
        $doAcls->data = "$channelId";
        $doAcls->executionorder = 1;
        DataGenerator::generateOne($doAcls, true);

        $doAcls->data = "$channelId, 196";
        $doAcls->executionorder = 2;
        DataGenerator::generateOne($doAcls, true);

        $doChannel->channelid = $channelId;
        $doChannel->delete();

        $doAcls = OA_Dal::factoryDO('acls');
        $this->assertEqual(1, $doAcls->count());
    }

    function testDuplicate()
    {
        $GLOBALS['strCopyOf'] = 'Copy of ';
        //  create test channel
        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->acls_updated = '2007-04-03 19:29:54';
        $channelId = DataGenerator::generateOne($doChannel, true);

        //  create test acls
        $doAcls = OA_Dal::factoryDO('acls_channel');
        $doAcls->channelid = $channelId;
        $doAcls->type = 'Client:Ip';
        $doAcls->comparison = '==';
        $doAcls->data = '127.0.0.1';
        $doAcls->executionorder = 1;
        $doAcls->insert();

        $doAcls = OA_Dal::factoryDO('acls_channel');
        $doAcls->channelid = $channelId;
        $doAcls->type = 'Client:Domain';
        $doAcls->comparison = '==';
        $doAcls->data = 'example.com';
        $doAcls->executionorder = 2;
        $doAcls->insert();

        // duplicate
        $newChannelId = OA_Dal::staticDuplicate('channel', $channelId);

        // retrieve original and duplicate channel
        $doChannel = OA_Dal::staticGetDO('channel', $channelId);
        $doNewChannel = OA_Dal::staticGetDO('channel', $newChannelId);

        // assert they are not equal including primary keys - name column should not match
        $this->assertNotEqualDataObjects($this->stripKeys($doChannel), $this->stripKeys($doNewChannel));

        // assert they are equal excluding primary keys
        $doChannel->name = $doNewChannel->name = null;
        $this->assertEqualDataObjects($this->stripKeys($doChannel), $this->stripKeys($doNewChannel));

        //  retrieve acls for original and duplicate channel
        $doAcls = OA_Dal::factoryDO('acls_channel');
        $doAcls->channelid = $channelId;
        $doAcls->orderBy('executionorder');
        if ($doAcls->find()) {
            while ($doAcls->fetch()) {
                $aAcls[] = clone($doAcls);
            }
        }

        $doNewAcls = OA_Dal::factoryDO('acls_channel');
        $doNewAcls->channelid = $newChannelId;
        $doNewAcls->orderBy('executionorder');
        if ($doNewAcls->find()) {
            while ($doNewAcls->fetch()) {
                $aNewAcls[] = clone($doNewAcls);
            }
        }

        //  iterate through acls ensuring they were properly copied
        if ($this->assertEqual(count($aAcls), count($aNewAcls))) {
            for ($x = 0; $x < count($aAcls); $x++) {
                $this->assertNotEqual($aAcls[$x]->channelid, $aNewAcls[$x]->channelid);
                $this->assertEqualDataObjects($this->stripKeys($aAcls[$x]), $this->stripKeys($aNewAcls[$x]));
            }
        }
    }

}

?>