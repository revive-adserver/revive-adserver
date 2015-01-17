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

require_once MAX_PATH . '/lib/max/Delivery/querystring.php';

/**
 * A class for testing the ad.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 */
class Test_DeliveryQuerystring extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /** TODO: test breaking on zoneid assert, chris to check function
     *
     * Populate variables from a specially encoded string.  This is used because
     * in a click URL, a parameter could possibly be another URL.
     *
     * The resulting values are set into the $_GET, and $_REQUEST globals
     */
    function test_MAX_querystringConvertParams()
    {
        $tmpGet     = $_GET;
        $tmpPost    = $_POST;
        $tmpCookie  = $_COOKIE;
        $tmpRequest = $_REQUEST;

        $zoneid     = 123;
        $campaignid = 456;
        $bannerid   = 789;
        $loc        = "http://www.example.com/page.html?name1=value1&name2=value2";
        $referer    = "http://www.example.com/referer.php?name3=value3&name4=value4";
        $dest       = "http://www.example.com/landing.php?name5=value5&nam._e6=v.__[]alue6";

        $_COOKIE    = array();
        $_GET       = array();
        $_POST      = array();
        $_REQUEST   = array();
        $this->sendMessage('test_MAX_querystring');
        $_SERVER['QUERY_STRING'] = "zoneid={$zoneid}&campaignid={$campaignid}&bannerid={$bannerid}&loc=".urlencode($loc).'&referer='.urlencode($referer).'&maxdest=' . $dest;
        MAX_querystringConvertParams();
        $this->assertEqual($_GET['zoneid'], $zoneid);
        $this->assertEqual($_GET['campaignid'], $campaignid);
        $this->assertEqual($_GET['bannerid'], $bannerid);
        $this->assertEqual($_GET['loc'], $loc);
        $this->assertEqual($_GET['referer'], $referer);
        $this->assertEqual($_GET['oadest'], $dest);

        $_COOKIE    = array();
        $_GET       = array();
        $_POST      = array();
        $_REQUEST   = array();
        $this->sendMessage('test_MAX_querystring');
        $del = $GLOBALS['_MAX']['CONF']['delivery']['ctDelimiter'];
        $_SERVER['QUERY_STRING'] = 'oaparams='.strlen($del)."{$del}zoneid={$zoneid}{$del}campaignid={$campaignid}{$del}bannerid={$bannerid}{$del}loc=".urlencode($loc)."{$del}referer=".urlencode($referer)."{$del}oadest={$dest}";
        MAX_querystringConvertParams();
        $this->assertEqual($_GET['zoneid'], $zoneid);
        $this->assertEqual($_GET['campaignid'], $campaignid);
        $this->assertEqual($_GET['bannerid'], $bannerid);
        $this->assertEqual($_GET['loc'], $loc);
        $this->assertEqual($_GET['referer'], $referer);
        $this->assertEqual($_GET['oadest'], $dest);

        $_COOKIE    = $tmpCookie;
        $_GET       = $tmpGet;
        $_POST      = $tmpPost;
        $_REQUEST   = $tmpRequest;
    }
}

?>
