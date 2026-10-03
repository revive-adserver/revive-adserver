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

require_once MAX_PATH . '/lib/OA/Admin/UI/model/InventoryPageHeaderModelBuilder.php';

class Test_OA_Admin_UI_InventoryPageHeaderModelBuilder extends UnitTestCase
{
    private $originalGlobals = [];

    public function setUp()
    {
        foreach (['strChannel', 'strAddNewChannel', 'strChannelToWebsite', 'strAgency', 'strAddAgency'] as $name) {
            $this->originalGlobals[$name] = [
                'exists' => array_key_exists($name, $GLOBALS),
                'value' => $GLOBALS[$name] ?? null,
            ];
            $GLOBALS[$name] = $name;
        }
    }

    public function tearDown()
    {
        foreach ($this->originalGlobals as $name => $original) {
            if ($original['exists']) {
                $GLOBALS[$name] = $original['value'];
            } else {
                unset($GLOBALS[$name]);
            }
        }
    }

    public function testNewChannelHeadersUseAddIcons()
    {
        $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();

        $channelHeader = $builder->buildEntityHeader([['name' => '']], 'channel', 'edit-new');
        $globalChannelHeader = $builder->buildEntityHeader([['name' => '']], 'global-channel', 'edit-new');

        $this->assertEqual($channelHeader->getIconClass(), 'iconTargetingChannelAddLarge');
        $this->assertEqual($globalChannelHeader->getIconClass(), 'iconTargetingChannelAddLarge');
    }

    public function testNewAgencyHeaderUsesAddIcon()
    {
        $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
        $agencyHeader = $builder->buildEntityHeader([['name' => '']], 'agency', 'edit-new');

        $this->assertEqual($agencyHeader->getIconClass(), 'iconManagerAddLarge');
    }
}
