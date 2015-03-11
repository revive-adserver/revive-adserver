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

class Dummy_Plugins_DeliveryLimitations extends Plugins_DeliveryLimitations
{
    function getName()
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
     function Plugins_DeliveryLimitations_TestCase()
    {
        parent::__construct();
    }

    function testCompile()
    {
        $oPlugin = new Dummy_Plugins_DeliveryLimitations();
        $oPlugin->init(array('data' => 'Mozilla', 'comparison' => '==', 'group' => 'group', 'component' => 'component'));
        $this->assertEqual('MAX_checkGroup_component(\'Mozilla\', \'==\')', $oPlugin->compile());
        $oPlugin->init(array('data' => 'Mozil\\la', 'comparison' => '==', 'group' => 'group', 'component' => 'component'));
        $this->assertEqual('MAX_checkGroup_component(\'Mozil\\\\la\', \'==\')', $oPlugin->compile());
    }
}