<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/max/Delivery/querystring.php';

/**
 * A class for testing the ad.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class Test_DeliveryQuerystring extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        $this->UnitTestCase();
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
        $dest       = "http://www.example.com/landing.php?name5=value5&name6=value6";

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
