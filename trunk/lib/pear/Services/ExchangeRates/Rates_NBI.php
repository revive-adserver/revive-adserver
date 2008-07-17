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
// | Author: Simon Brüchner <powtac@gmx.de>			                      |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * Exchange rate driver - National Bank of Israel
 *
 * The Excange Rates of the National Bank of Israel are updated daily.
 *
 * @link 	http://www.bankisrael.gov.il/eng.shearim/
 *
 * @author 	Simon Brüchner <powtac@gmx.de>	
 * @copyright Copyright 2003 Simon Brüchner
 * @license http://www.php.net/license/2_02.txt PHP License 2.0
 * @package Services_ExchangeRates
 */
 
/**
 * Include common functions to handle cache and fetch the file from the server
 */
require_once 'Services/ExchangeRates/Common.php';

/**
 * National Bank of Israel Currency Exchange Rates Driver
 *
 * @package Services_ExchangeRates
 */
class Services_ExchangeRates_Rates_NBI extends Services_ExchangeRates_Common {

   /**
    * URL of XML feed
    * @access private
    * @var string
    */
    var $_feedXMLUrl = 'http://www.bankisrael.gov.il/heb.shearim/currency.php';
       
   /**
    * Downloads exchange rates in terms of the ILS (New Israeli Shequel) from 
    * the National Bank of Israel. This information is updated daily, 
    * and is cached by default for 1 hour.
    *
    * Returns a multi-dimensional array containing:
    * 'rates' => associative array of currency codes to exchange rates
    * 'source' => URL of feed
    * 'date' => date feed last updated, pulled from the feed (more reliable than file mod time)
    *
    * @link http://www.bankisrael.gov.il/eng.shearim/ HTML version
    * @link http://www.bankisrael.gov.il/heb.shearim/currency.php XML version
    *
    * @param int Length of time to cache (in seconds)
    * @return array Multi-dimensional array
    */
    function retrieve($cacheLength, $cacheDir) {
    
        // IMPORTANT: defines ILS mapping.  Without this, you can't convert 
        // to or from ILS!
        $return['rates'] = array('ILS' => 1.0);
    
        $return['source'] = $this->_feedXMLUrl;
        
        // retrieve the feed from the server or cache
        $root = $this->retrieveXML($this->_feedXMLUrl, $cacheLength, $cacheDir);
   	
        // set date published
        $return['date'] = $root->children[0]->content;
        
        // get down to array of exchange rates
        $xrates = $root->children;
        
        // loop through and put them into an array
        foreach ($xrates as $rateinfo) {
        	if ($rateinfo->children[4]->content != 0) {
            	$return['rates'][$rateinfo->children[2]->content] = 
            		1 / $rateinfo->children[4]->content 
            		* $rateinfo->children[1]->content;
        	}
        }
        
        return $return; 
    }
}
?>