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
require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitations.php';
Language_Loader::load();

class Dummy_Plugins_DeliveryLimitations extends Plugins_DeliveryLimitations
{
    public function getName()
    {
        return 'bla';
    }
}

/**
 * A class for testing the Plugins_DeliveryLimitations class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_DeliveryLimitations_Test extends UnitTestCase
{
    public function Plugins_DeliveryLimitations_TestCase()
    {
        parent::__construct();
    }

    public function testCompile()
    {
        $oPlugin = new Dummy_Plugins_DeliveryLimitations();
        $oPlugin->init(['data' => 'Mozilla', 'comparison' => '==', 'group' => 'group', 'component' => 'component']);
        $this->assertEqual('MAX_checkGroup_component(\'Mozilla\', \'==\')', $oPlugin->compile());
        $oPlugin->init(['data' => 'Mozil\\la', 'comparison' => '==', 'group' => 'group', 'component' => 'component']);
        $this->assertEqual('MAX_checkGroup_component(\'Mozil\\\\la\', \'==\')', $oPlugin->compile());
    }
}
