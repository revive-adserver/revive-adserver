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

require_once MAX_PATH . '/lib/max/Plugin.php';

class Plugins_TestOfPlugins_Reports_oxStandard_LiveCampaignDeliveryReport extends UnitTestCase
{
    public $oPlugin;

    public function setUp()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = str_replace(
            'reports/oxReportsStandard/tests/unit',
            '',
            dirname(str_replace(MAX_PATH, '', __FILE__)),
        );
        $this->oPlugin = &OX_Component::factory('reports', 'oxReportsStandard', 'liveCampaignDeliveryReport');
    }

    public function test_calculateTodaysPercentDifferenceWithoutPriorHourImpressions()
    {
        $result = $this->oPlugin->_calculateTodaysPercentDifference(0, 0, 0, 1, 0, 100);
        $this->assertFalse($result);
    }

    public function test_calculateTodaysPercentDifferenceWithPriorHourImpressions()
    {
        $result = $this->oPlugin->_calculateTodaysPercentDifference(10, 30, 15, 2, 50, 100);
        $this->assertEqual(-10, $result);
    }
}
