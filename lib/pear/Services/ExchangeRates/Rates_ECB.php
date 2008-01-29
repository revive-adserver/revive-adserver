<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at                              |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Marshall Roch <marshall@exclupen.com>                        |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * Exchange rate driver - European Central Bank
 *
 * The reference rates are based on the regular daily concertation
 * procedure between central banks within and outside the European System
 * of Central Banks, which normally takes place at 2.15 p.m. ECB time (CET).
 * The reference exchange rates are published both by electronic market
 * information providers and on the ECB's website shortly after the
 * concertation procedure has been completed.
 *
 * @link http://www.ecb.int/stats/eurofxref/eurofxref-xml.html About the feed
 * @link http://www.ecb.int/copy/copy01.htm IMPORTANT COPYRIGHT INFORMATION
 *
 * @author Marshall Roch <marshall@exclupen.com>
 * @copyright Copyright 2003 Marshall Roch
 * @license http://www.php.net/license/2_02.txt PHP License 2.0
 * @package Services_ExchangeRates
 */

/**
 * Include common functions to handle cache and fetch the file from the server
 */
require_once 'Services/ExchangeRates/Common.php';

/**
 * European Central Bank Exchange Rate Driver
 *
 * @package Services_ExchangeRates
 */
class Services_ExchangeRates_Rates_ECB extends Services_ExchangeRates_Common {

   /**
    * URL of XML feed
    * @access private
    * @var string
    */
    var $_feedXMLUrl = 'http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml';

   /**
    * Downloads exchange rates in terms of the Euro from the European Central Bank. This
    * information is updated daily, and is cached by default for 1 hour.
    *
    * Returns a multi-dimensional array containing:
    * 'rates' => associative array of currency codes to exchange rates
    * 'source' => URL of feed
    * 'date' => date feed last updated, pulled from the feed (more reliable than file mod time)
    *
    * @link http://www.ecb.int/stats/eurofxref/ HTML version
    * @link http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml XML version
    *
    * @param int Length of time to cache (in seconds)
    * @return array Multi-dimensional array
    */
    function retrieve($cacheLength, $cacheDir) {

        // IMPORTANT: defines Euro mapping.  Without this, you can't convert
        // to or from the Euro!
        $return['rates'] = array('EUR' => 1.0);

        $return['source'] = $this->_feedXMLUrl;

        // retrieve the feed from the server or cache
        $root = $this->retrieveXML($this->_feedXMLUrl, $cacheLength, $cacheDir);

        // set date published
        $return['date'] = $root->children[5]->children[1]->attributes['time'];

        // get down to array of exchange rates
        $xrates = $root->children[5]->children[1]->children;

        // loop through and put them into an array
        foreach ($xrates as $rateinfo) {
            if ($rateinfo->name == 'Cube') {
            	$return['rates'][$rateinfo->attributes['currency']] = $rateinfo->attributes['rate'];
            }
        }

        return $return;

    }

}

?>
