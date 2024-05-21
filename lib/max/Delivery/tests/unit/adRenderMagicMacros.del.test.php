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

require_once MAX_PATH . '/lib/max/Delivery/adRender.php';

/**
 * @package    MaxDelivery
 * @subpackage TestSuite
 *
 */
class Test_DeliveryAdRenderMagicMacros extends UnitTestCase
{
    public function test_noHook()
    {
        // No hook
        unset($GLOBALS['_MAX']['CONF']['deliveryHooks']['addMagicMacros']);

        $mm = ['foo' => 'bar'];
        _adRenderAddPluginMagicMacros($mm, [], '');

        $this->assertEqual($mm, ['foo' => 'bar']);
    }

    public function test_brokenHook()
    {
        $GLOBALS['_MAX']['CONF']['deliveryHooks']['addMagicMacros'] = join('|', [
            'adRender:test:1',
        ]);

        $mm = ['foo' => 'bar'];
        _adRenderAddPluginMagicMacros($mm, [], '');

        $this->assertEqual($mm, ['foo' => 'bar']);
    }

    public function test_brokenAndGoodHooks()
    {
        $GLOBALS['_MAX']['CONF']['deliveryHooks']['addMagicMacros'] = join('|', [
            'adRender:test:1',
            'adRender:test:2',
        ]);

        $mm = ['foo' => 'bar'];
        _adRenderAddPluginMagicMacros($mm, [], '');

        $this->assertEqual($mm, ['foo' => 'bar', 'bar' => 'baz']);
    }

    public function test_TwoGoodHooksOverwrite()
    {
        $GLOBALS['_MAX']['CONF']['deliveryHooks']['addMagicMacros'] = join('|', [
            'adRender:test:3',
            'adRender:test:2',
        ]);

        $mm = ['foo' => 'bar'];
        _adRenderAddPluginMagicMacros($mm, [], '');

        $this->assertEqual($mm, ['foo' => 'bar', 'bar' => 'baz', 'a' => 'b']);
    }
}

function Plugin_adRender_test_1_Delivery_addMagicMacros(array $aBanner, string $code)
{
    return 'broken';
}

function Plugin_adRender_test_2_Delivery_addMagicMacros(array $aBanner, string $code): array
{
    return ['bar' => 'baz'];
}

function Plugin_adRender_test_3_Delivery_addMagicMacros(array $aBanner, string $code): array
{
    return ['bar' => 'bar', 'a' => 'b'];
}
