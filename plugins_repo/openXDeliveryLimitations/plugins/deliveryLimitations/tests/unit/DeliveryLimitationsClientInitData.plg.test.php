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
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Client/Browser.delivery.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Client/initClientData.delivery.php';

Language_Loader::load();

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Browser class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Browser extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     *@todo test case for different user agents
     *
     * A function to set the viewer's useragent information in the
     * $GLOBALS['_MAX']['CLIENT'] global variable, if the option to use
     * phpSniff to extract useragent information is set in the
     * configuration file.
     */
    function test_Plugin_deliveryLimitations_Client_initClientData_Delivery_postInit()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] = str_replace(MAX_PATH,'',dirname(dirname(dirname(dirname(__FILE__))))).'/';
        $http_user_agent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.8) Gecko/20061109 CentOS/1.5.0.8-0.1.el4.centos4 Firefox/1.5.0.8 pango-text';
        $_SERVER['HTTP_USER_AGENT'] = $http_user_agent;

        Plugin_deliveryLimitations_Client_initClientData_Delivery_postInit();
        $this->assertIsA($GLOBALS['_MAX']['CLIENT'], 'array');
        $this->assertIsA($GLOBALS['_MAX']['CLIENT']['wrapper'], \RV\Extension\DeliveryLimitations\ClientDataWrapperInterface::class);
    }

}
?>
