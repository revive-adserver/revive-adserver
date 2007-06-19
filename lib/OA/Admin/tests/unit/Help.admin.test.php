<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id: DaySpan.admin.test.php 6351 2007-05-10 13:55:39Z andrew.hill@openads.org $
*/

require_once MAX_PATH . '/lib/OA/Admin/Help.php';
require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';
/**
 * A class for testing the OA_Admin_Help class.
 *
 * @package    OpenadsAdmin
 * @subpackage TestSuite
 * @author     Marek Bedkowski <marek@bedkowski.pl>
 * 
 */
class Test_OA_Admin_Help extends UnitTestCase
{

    var $sessionUserTypeSave = -1;
    var $sRequestUriBackup = '';

    /**
     * Simpletest hook called automatically at the beginning of the test
     * 
     * Its job:
     *    1. Save user_type, REQUEST_URI if present
     *    2. Add __tester_entry__ to aHelpPages array
     *    3. Add __tester_subentry__ to aHelpPages array
     *    4. Add test mappings for amin/affiliate/agency/client to navi2help array
     *    
     */
    function setUp()
    {
        global $session;

        // save original usertype if needed
        if (isset($session['usertype'])) $this->sessionUserTypeSave = $session['usertype'];
        if (isset($_SERVER['REQUEST_URI'])) $this->sRequestUriBackup = $_SERVER['REQUEST_URI'];

        // define tester entries in apropriate arrays
        if (empty($GLOBALS['aHelpPages'])) $GLOBALS['aHelpPages'] = array('elements' => array());

        $GLOBALS['aHelpPages']['elements']['__tester_entry__'] = array(
            'link'     => '__tester_entry__.html',
            'id'       => 2000,
            'itemId'   => 1000,
            'name'     => 'Tester',
            'anchors'  => array(),
            'elements' => array(),
        );

        $GLOBALS['aHelpPages']['elements']['__tester_entry__']['elements']['__tester_subentry__'] = array(
    	    'link'     => '__tester_subentry__.html',
    	    'id'       => 3000,
    	    'itemId'   => 1500,
    	    'name'     => 'Tester subentry',
    	    'anchors'  => array(
    	        'Local banner',
    	        'External banner',
    	        'Html banner',
    	        'Text ads',        
    	    ),
    	    'rotate' => array(
    	        'constraint_type' => OPENADS_HELP_PAGES_ROTATE_CONSTRAINT_ANCHOR,
    	        '_test_rotate_var' => array(
    	            'url'  => 1,
    	            'sql'  => 0,
    	            'html' => 2,
    	            'txt'  => 3,
    	            '__default' => 0
    	        ),
    	    ),
    	);
		
        $GLOBALS['navi2help']['admin']['222']     = array('__tester_entry__', 1);
        $GLOBALS['navi2help']['admin']['2222']    = array('__tester_entry__.__tester_subentry__', 1);
        $GLOBALS['navi2help']['admin']['333']     = array(
            '__tester_entry__.__tester_subentry__',
            'use_file' => array(
                'tester_0.php' => array('__tester_entry__.__tester_subentry__'),
                'tester_1.php' => array('__tester_entry__.__tester_subentry__', 1),
                'tester_2.php' => array('__tester_entry__.__tester_subentry__', 2),
            )
        );

        $GLOBALS['navi2help']['client']['222']    = array('__tester_entry__', 2);
        $GLOBALS['navi2help']['client']['2222']    = array('__tester_entry__.__tester_subentry__', 2);

        $GLOBALS['navi2help']['affiliate']['222'] = array('__tester_entry__', 3);
        $GLOBALS['navi2help']['affiliate']['2222'] = array('__tester_entry__.__tester_subentry__', 3);

        $GLOBALS['navi2help']['agency']['222']    = array('__tester_entry__');
        $GLOBALS['navi2help']['agency']['2222']    = array('__tester_entry__.__tester_subentry__');

    }

    /**
     * Automatic Simpletest hoook called when test is finished
     * 
     * Perform cleanup 
     * Unset previously added entries in navi2help aHelpPages array
     * Restore user_type and REQUEST_URI to their initial values
     * 
     */
    function tearDown()
    {

        global $session;

        // get rid of test entries
        unset($GLOBALS['aHelpPages']['elements']['__tester_entry__']);
        unset($GLOBALS['navi2help']['admin']['222']);
        unset($GLOBALS['navi2help']['admin']['2222']);
        unset($GLOBALS['navi2help']['admin']['333']);

        unset($GLOBALS['navi2help']['client']['222']);
        unset($GLOBALS['navi2help']['client']['2222']);

        unset($GLOBALS['navi2help']['affiliate']['222']);
        unset($GLOBALS['navi2help']['affiliate']['2222']);

        unset($GLOBALS['navi2help']['agency']['222']);
        unset($GLOBALS['navi2help']['agency']['2222']);

        // restore user type if needed
        if ($this->sessionUserTypeSave != -1) $session['usertype'] = $this->sessionUserTypeSave;
        
        if (strlen($this->sRequestUriBackup)) $_SERVER['REQUEST_URI'] = $this->sRequestUriBackup;
    }

    /**
     * Test aquiring doc link using link property
     * 
     * Tests for all types of users allowed to access UI if 
     * links are generate properly (using OA_HELP_LINK_BUILD_USING_LINK method)
     * 
     * This test uses navi2help mapping in order to obtain documentation paths
     *
     * @see OA_Admin_Help::getDocLinkFromPhpAdsNavId
     *  
     */
    function testGetDocLinkFromPhpAdsNavIdUsingLinkProperty()
    {

        global $session;

        $iBuildTypeBackup = $GLOBALS['OA_HELP_LINK_BUILD_TYPE'];
        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_LINK;

        // get sample entry of main element for admin
        $session['usertype'] = phpAds_Admin;
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_entry__.html';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of subelement for admin
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html#docs_1';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('2222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of main element for client
        $session['usertype'] = phpAds_Client;
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_entry__.html';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of subelement for client
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html#docs_2';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('2222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of main element for affiliate
        $session['usertype'] = phpAds_Affiliate;
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_entry__.html';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of subelement for affiliate
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html#docs_3';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('2222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of main element for agency
        $session['usertype'] = phpAds_Agency;
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_entry__.html';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of subelement for agency
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('2222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get non-existent URL - should point to the documenation base URL
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/index.html';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222244');
        $this->assertEqual($sLink, $sExpectedLink);

        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = $iBuildTypeBackup;

    }

    /**
     * Test link generation using Id's 
     * 
     * This method tests if for all types of users that are allowed in the UI 
     * links using OA_HELP_LINK_BUILD_USING_ID method are generated properly
     * 
     * This test uses navi2help mapping in order to obtain documentation paths
     * 
     * @see OA_Admin_Help::getDocLinkFromPhpAdsNavId
     * 
     */
    function testGetDocLinkFromPhpAdsNavIdUsingIdProperty()
    {

        global $session;

        $iBuildTypeBackup = $GLOBALS['OA_HELP_LINK_BUILD_TYPE'];
        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_ID;

        // get sample entry of main element for admin
        $session['usertype'] = phpAds_Admin;
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1000/2000/';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of subelement for admin
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/#docs_1';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('2222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of main element for client
        $session['usertype'] = phpAds_Client;
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1000/2000/';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of subelement for client
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/#docs_2';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('2222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of main element for affiliate
        $session['usertype'] = phpAds_Affiliate;
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1000/2000/';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of subelement for affiliate
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/#docs_3';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('2222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of main element for agency
        $session['usertype'] = phpAds_Agency;
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1000/2000/';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('222');
        $this->assertEqual($sLink, $sExpectedLink);

        // get sample entry of subelement for agency
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('2222');
        $this->assertEqual($sLink, $sExpectedLink);

        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = $iBuildTypeBackup;

    }

    /**
     * Tests if links based on documentation paths are generated properly
     * 
     * This test checks if links generation based on raw paths
     * to aHelpPages works fine using OA_HELP_LINK_BUILD_USING_LINK method
     * 
     * @see OA_Admin_Help::getDocPageUrl
     * 
     */
    function testGetDocPageUrlUsingLinkProperty()
    {

        $iBuildTypeBackup = $GLOBALS['OA_HELP_LINK_BUILD_TYPE'];
        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_LINK;

        // get base url only
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__');
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_entry__.html';
        $this->assertEqual($sLink, $sExpectedLink);

        // get base url only
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentry__');
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html';
        $this->assertEqual($sLink, $sExpectedLink);

        // get partial path properly - should return root document
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentryyyyyyyyyyyyyy__');
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/index.html';
        $this->assertEqual($sLink, $sExpectedLink);

        // get URL with an anchor after #
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentry__', 1);
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html#docs_1';
        $this->assertEqual($sLink, $sExpectedLink);

        // get URL with anchor based on external var #1
        $sExternalVar = 'url';
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentry__', -1, array('test_rotate_var' => $sExternalVar));
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html#docs_1';
        $this->assertEqual($sLink, $sExpectedLink);

        // get URL with anchor based on external var #2
        $sExternalVar = 'txt';
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentry__', -1, array('test_rotate_var' => $sExternalVar));
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html#docs_3';
        $this->assertEqual($sLink, $sExpectedLink);

        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = $iBuildTypeBackup;

    }    

    /**
     * Tests if links based on documentation paths are generated properly
     * 
     * This test checks if links generation based on raw paths
     * to aHelpPages works fine using OA_HELP_LINK_BUILD_USING_ID method
     * 
     * @see OA_Admin_Help::getDocPageUrl
     * 
     */
    function testGetDocPageUrlUsingIdProperty()
    {

        $iBuildTypeBackup = $GLOBALS['OA_HELP_LINK_BUILD_TYPE'];
        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_ID;

        // get main entry url
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__');
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1000/2000/';
        $this->assertEqual($sLink, $sExpectedLink);

        // get base url only
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentry__');
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/';
        $this->assertEqual($sLink, $sExpectedLink);

        // get URL with an anchor after #
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentry__', 1);
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/#docs_1';
        $this->assertEqual($sLink, $sExpectedLink);

        // get URL with anchor based on external var #1
        $sExternalVar = 'url';
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentry__', -1, array('test_rotate_var' => $sExternalVar));
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/#docs_1';
        $this->assertEqual($sLink, $sExpectedLink);

        // get URL with anchor based on external var #2
        $sExternalVar = 'txt';
        $sLink = OA_Admin_Help::getDocPageUrl('__tester_entry__.__tester_subentry__', -1, array('test_rotate_var' => $sExternalVar));
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/#docs_3';
        $this->assertEqual($sLink, $sExpectedLink);

		$GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = $iBuildTypeBackup;

    }
    
    /**
     * This test checks if paths mapped using "use_file" have proper links genearted
     * 
     * 
     * 
     */
    function testUseFile()
    {

        global $session;

        $iBuildTypeBackup = $GLOBALS['OA_HELP_LINK_BUILD_TYPE'];
        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_ID;

        // get sample entry of main element for affiliate
        $session['usertype'] = phpAds_Admin;
        $_SERVER['REQUEST_URI'] = '/path/to/tester_0.php';
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('333');
        $this->assertEqual($sLink, $sExpectedLink);

        $_SERVER['REQUEST_URI'] = '/path/to/tester_1.php';
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/#docs_1';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('333');
        $this->assertEqual($sLink, $sExpectedLink);

        $_SERVER['REQUEST_URI'] = 'tester_2.php';
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/1500/3000/#docs_2';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('333');
        $this->assertEqual($sLink, $sExpectedLink);


        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_LINK;

        // get sample entry of main element for affiliate
        $session['usertype'] = phpAds_Admin;
        $_SERVER['REQUEST_URI'] = '/path/to/tester_0.php';
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('333');
        $this->assertEqual($sLink, $sExpectedLink);

        $_SERVER['REQUEST_URI'] = 'tester_1.php';
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html#docs_1';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('333');
        $this->assertEqual($sLink, $sExpectedLink);

        $_SERVER['REQUEST_URI'] = '/path/to/tester_2.php';
        $sExpectedLink = rtrim(OA_DOCUMENTATION_BASE_URL, '/') . '/__tester_subentry__.html#docs_2';
        $sLink = OA_Admin_Help::getDocLinkFromPhpAdsNavId('333');
        $this->assertEqual($sLink, $sExpectedLink);        

        $GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = $iBuildTypeBackup;
        	
    }

}

?>