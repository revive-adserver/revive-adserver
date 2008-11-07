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

require_once MAX_PATH . '/lib/max/Plugin.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Client/Browser.delivery.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/etc/Client/etc/postscript_install_Client.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Browser class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Browser extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Client_Browser()
    {
        $this->UnitTestCase();
    }


    function test_postscript_install_Client()
    {
        $oSettings  = new OA_Admin_Settings();
        $oSettings->settingChange('logging','sniff','1');
        $oSettings->writeConfigChange();
        $this->assertTrue($GLOBALS['_MAX']['CONF']['logging']['sniff']);
        $oPostInstall = new postscript_install_Client();
        $oPostInstall->execute();
        $this->assertNull($GLOBALS['_MAX']['CONF']['logging']['sniff']);
        $this->assertTrue($GLOBALS['_MAX']['CONF']['Client']['sniff']);
    }

    function testMAX_checkClient_Browser()
    {
        $GLOBALS['_MAX']['CLIENT']['browser'] = 'FF';
        $this->assertFalse(MAX_checkClient_Browser('LX,LI', '=~'));
        $this->assertTrue(MAX_checkClient_Browser('LX,FF', '=~'));
    }

    /**
     *@todo test case for different user agents
     *
     * A function to set the viewer's useragent information in the
     * $GLOBALS['_MAX']['CLIENT'] global variable, if the option to use
     * phpSniff to extract useragent information is set in the
     * configuration file.
     */
    function test_MAX_remotehostSetClientInfo()
    {
        $GLOBALS['_MAX']['CONF']['pluginPaths']['extensions'] = str_replace(MAX_PATH,'',dirname(dirname(dirname(dirname(__FILE__))))).'/';
        $GLOBALS['_MAX']['CONF']['logging']['sniff'] = true;
        $http_user_agent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.8)' .
                           ' Gecko/20061109 CentOS/1.5.0.8-0.1.el4.centos4 Firefox/1.5.0.8 pango-text';
        $_SERVER['HTTP_USER_AGENT'] = $http_user_agent;
        MAX_remotehostSetClientInfo();
        $this->assertIsA($GLOBALS['_MAX']['CLIENT'], 'array');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['browser'], 'fx');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['cookies'], 'Unknown');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['gecko'], '20061109');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['gecko_ver'], '1.8.0.8');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['javascript'], '1.5');
        // Not testing the language result from phpSniff, as always seems to
        // add en-us when testing via the web browser...
        // $this->assertEqual($GLOBALS['_MAX']['CLIENT']['language'], 'en-us,en');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['long_name'], 'firefox');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['maj_ver'], '1');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['min_ver'], '.5.0.8');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['os'], 'linux');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['platform'], '*nix');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['ss_cookies'], 'Unknown');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['st_cookies'], 'Unknown');
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['ua'], strtolower($http_user_agent));
        $this->assertEqual($GLOBALS['_MAX']['CLIENT']['version'], '1.5.0.8');
    }

}
?>
