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

require_once MAX_PATH . '/lib/max/Delivery/common.php';

/**
 * A class for testing the common.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class test_DeliveryCommon extends UnitTestCase
{
    /** @var int */
    var $original_server_port;

    /**
     * The constructor method.
     */
    function test_DeliveryCommon()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->original_server_port = $_SERVER['SERVER_PORT'];
        $GLOBALS['_MAX']['CONF']['webpath']['delivery']     = 'www.maxstore.net/www/delivery';
        $GLOBALS['_MAX']['CONF']['webpath']['deliverySSL']  = 'secure.maxstore.net/www/delivery';
    }

    function tearDown()
    {
        $_SERVER['SERVER_PORT'] = $this->original_server_port;
    }

    function test_MAX_commonGetDeliveryUrl_Uses_HTTP_Scheme_For_Nonsecure_URLs()
    {
        $_SERVER['SERVER_PORT'] = 80;
        $GLOBALS['_MAX']['CONF']['openads']['sslPort']  = 443;
        $url = MAX_commonGetDeliveryUrl('test.html');
        $this->assertEqual($url, 'http://www.maxstore.net/www/delivery/test.html', "HTTP delivery on standard, non-secure ports only need to generate plain HTTP URLs for delivery, with no explicit port.");
    }

    function test_MAX_commonGetDeliveryUrl_Uses_HTTPS_Scheme_For_Secure_URLs()
    {
        $_SERVER['SERVER_PORT'] = 443;
        $GLOBALS['_MAX']['CONF']['openads']['sslPort']  = 443;
        $url    = MAX_commonGetDeliveryUrl('test.html');
        $this->assertEqual($url, 'https://secure.maxstore.net/www/delivery/test.html', "Delivery requests that come in on the 'secure port' should use HTTPS URLs. %s");
    }

    function test_MAX_commonGetDeliveryUrl_Includes_Nonstandard_Secure_Port_Number()
    {
        $_SERVER['SERVER_PORT'] = 4430;
        $GLOBALS['_MAX']['CONF']['openads']['sslPort']  = 4430;
        $url    = MAX_commonGetDeliveryUrl('test.html');
        $this->assertEqual($url, 'https://secure.maxstore.net:4430/www:4430/delivery/test.html', "A non-standard port number should be explicitly provided in delivery URLs. %s");

    }

	/**
	 * Test1 return a URL
	 * A function to generate the URL for delivery scripts.
	 *
	 * @param string $file The file name of the delivery script.
	 * @return string The URL to the delivery script.
	 */
	function test_MAX_commonConstructDeliveryUrl()
	{
		$this->sendMessage('test_MAX_commonConstructDeliveryUrl');
        $GLOBALS['_MAX']['CONF']['webpath']['delivery'] 	= 'www.maxstore.net/www/delivery';
		$file 	= 'test.html';
		$ret 	= MAX_commonConstructDeliveryUrl($file);
        $this->assertEqual($ret, 'http://www.maxstore.net/www/delivery/test.html');
	}

	/**
	 * Test1 return secure URL
	 * A function to generate the secure URL for delivery scripts.
	 *
	 * @param string $file The file name of the delivery script.
	 * @return string The URL to the delivery script.
	 */
	function test_MAX_commonConstructSecureDeliveryUrl()
	{
		$this->sendMessage('test_MAX_commonConstructSecureDeliveryUrl');
        $GLOBALS['_MAX']['CONF']['webpath']['deliverySSL'] 	= 'secure.maxstore.net/www/delivery';
        $GLOBALS['_MAX']['CONF']['openads']['sslPort'] 			= 444;
		$file = 'test.html';
		$ret 	= MAX_commonConstructSecureDeliveryUrl($file);
        $this->assertEqual($ret, 'https://secure.maxstore.net:444/www:444/delivery/test.html');
	}

	/**
	 * Test1: return unsecure URL
	 * Test2: return secure URL
	 * A function to generate the URL for delivery scripts without a protocol.
	 *
	 * @param string $file The file name of the delivery script.
	 * @param boolean $ssl Use the SSL delivery path (true) or not. Default is false.
	 * @return string The parital URL to the delivery script (i.e. without
	 *                an 'http:' or 'https:' prefix).
	 */
	function test_MAX_commonConstructPartialDeliveryUrl()
	{
		$this->sendMessage('test_MAX_commonConstructPartialDeliveryUrl');
        $GLOBALS['_MAX']['CONF']['webpath']['deliverySSL'] 	= 'secure.maxstore.net/www/delivery';
        $GLOBALS['_MAX']['CONF']['webpath']['delivery'] 	= 'www.maxstore.net/www/delivery';
		$file = 'test.html';
		// Test1
		$ret = MAX_commonConstructPartialDeliveryUrl($file, false);
        $this->assertEqual($ret, '//www.maxstore.net/www/delivery/test.html');
        // Test2
		$ret = MAX_commonConstructPartialDeliveryUrl($file, true);
        $this->assertEqual($ret, '//secure.maxstore.net/www/delivery/test.html');
	}

	/**
	 * Remove an assortment of special characters from a variable or array:
	 * 1.  Strip slashes if magic quotes are turned on.
	 * 2.  Strip out any HTML
	 * 3.  Strip out any CRLF
	 * 4.  Remove any white space
	 *
	 * @access  public
	 * @param   string $var  The variable to process.
	 * @return  string       $var, minus any special quotes.
	 */
	function test_MAX_commonRemoveSpecialChars()
	{
		$this->sendMessage('test_MAX_commonRemoveSpecialChars');
		if (get_magic_quotes_gpc())
		{
			$strIn0	= "Mr O\'Reilly<br />".chr(13).chr(10);
			$strIn1	= "\'Mr Reilly\'\r\n";
		}
		else {
			$strIn0	= "Mr O'Reilly<br />".chr(13).chr(10);
			$strIn1	= "'Mr Reilly'\r\n";
		}

		$strRe0 = "Mr O'Reilly";
		$strRe1 = "'Mr Reilly'";
		$aIn	= array(0 => $strIn0,
						1 => array(0 => $strIn1),
						);
		MAX_commonRemoveSpecialChars($aIn);
		$prn    = var_export($aIn[1][0], true);

        $this->assertEqual($aIn[0], $strRe0);
        $this->assertEqual($aIn[1][0], $strRe1,'test_MAX_commonRemoveSpecialChars');
	}

	/**
	 * TODO: implement as web test
	 * This function sends the anti-caching headers when called
	 *
	 */
	function test_MAX_commonSetNoCacheHeaders()
	{
		$this->sendMessage('test_MAX_commonSetNoCacheHeaders: Not Implemented');
	}

	/**
	 *
	 * This function takes an array of variable names
	 * and makes them available in the global scope
	 *
	 * $_POST values take precedence over $_GET values
	 *
	 */
	function test_MAX_commonRegisterGlobalsArray()
	{
	    $tmpGlobals = $GLOBALS;
	    $_GET['max_test_get']      = '0';
	    $_POST['max_test_get']     = '1';
	    $_GET['max_test_post']     = '0';
	    $_POST['max_test_post']    = '1';
		MAX_commonRegisterGlobalsArray(array('max_test_get', 'max_test_post'));
		$this->assertTrue(array_key_exists('max_test_get', $GLOBALS),'max_test_get exists');
		$this->assertTrue(array_key_exists('max_test_post', $GLOBALS),'max_test_post exists');
		$this->assertTrue($GLOBALS['max_test_get'],'GLOBALS precedence error');
		$this->assertTrue($GLOBALS['max_test_post'],'GLOBALS precedence error');
		$GLOBALS = $tmpGlobals;
	}

	/**
	 * Test1: return urldecoded/decrypted string
	 * Test2: return urldecoded string
	 *
	 * This function takes the "source" value and normalises it
	 * and encrypts it if necessary
	 *
	 * @param string The value from the source parameter
	 * @return string Encrypted source
	 */
	function test_MAX_commonDeriveSource()
	{
        $str = "http://www.somewhere.com/index.php?a=this is a file&b=43589uhhjkh";
	    // Test1: obfuscate (encrypt) and return
	    $source = urlencode($str);
		$GLOBALS['_MAX']['CONF']['delivery']['obfuscate'] = 1;
		$expect = '{obfs:220208208212266277277205205205278209213215223205220223210223278225213215277219214224223204278212220212261227263208220219209292219209292227292222219216223286226263272273271268267207220220218217220}';
        $return = MAX_commonDeriveSource($source);
        $this->assertEqual($return, $expect);
        // Test2: urldecode and return
	    $source = urlencode($str);
		$GLOBALS['_MAX']['CONF']['delivery']['obfuscate'] = 0;
		$expect = $str;
        $return = MAX_commonDeriveSource($source);
        $this->assertEqual($return, $expect);
	}

    /**
     * Test the _MAX_commonEncrypt and _MAX_commonDecrypt functions.
     */
	function test_MAX_commonEncryptDecrypt()
	{
		$this->sendMessage('test_MAX_commonEncryptDecrypt');
		$string = 'Lorem ipsum dolor sit amet ipso facto';
		$GLOBALS['_MAX']['CONF']['delivery']['obfuscate'] = 1;
		$retEnc = MAX_commonEncrypt($string);
        $this->assertNotEqual($retEnc, $string);
		$retDec = MAX_commonDecrypt($retEnc);
        $this->assertNotEqual($retDec, $retEnc);
        $this->assertEqual($retDec, $string);

		$GLOBALS['_MAX']['CONF']['delivery']['obfuscate'] = 0;
		$retDec = MAX_commonDecrypt($string);
        $this->assertEqual($retDec, $string);
	}

    function test_MAX_commonInitVariables()
    {
		$GLOBALS['_MAX']['CONF']['delivery']['obfuscate'] = 1;
        $return = MAX_commonInitVariables();
        global $context, $source, $target, $withText, $withtext, $ct0, $what, $loc, $referer, $zoneid, $campaignid, $bannerid;
        $this->assertEqual($context, array(), '$context');
        $this->assertEqual($source, '{obfs:}', '$source'); // only if conf->obfuscate
        $this->assertEqual($target, '_blank', '$target');
        $this->assertEqual($withText, '', '$withText');
        $this->assertEqual($withtext, '', '$withtext');
        $this->assertEqual($withtext, $withText, '$withtext/$withText');
        $this->assertEqual($ct0, '', '$ct0');
        $this->assertEqual($what, '', '$what');
        $this->assertTrue(in_array($loc, array(stripslashes($loc),$_SERVER['HTTP_REFERER'],'')));
        $this->assertEqual($referer, null, '$referer');
        $this->assertEqual($zoneid, null, '$zoneid');
        $this->assertEqual($campaignid, null, '$campaignid');
        $this->assertEqual($bannerid, null, '$bannerid');
    }

    /**
     * @todo create this as web test as it sends headers
     *
     */
    function test_MAX_commonDisplay1x1()
    {
        $this->assertTrue(true);
    }


}

?>
