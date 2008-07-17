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
 * United Nations country codes driver
 *
 * Retrieves the ISO 3166 country codes in XML format from the United 
 * Nations Economic Commission for Europe.  This file is cached for 1 month
 * by default, since it hardly ever changes.
 *
 * @link http://www.unece.org/etrades/unedocs/repository/codelists/xml/CountryCodeList.xml
 * @package Services_ExchangeRates
 */
class Services_ExchangeRates_Countries_UN extends Services_ExchangeRates_Common {

   /**
    * URL of XML feed
    * @var string
    */
    var $feedUrl = 'http://www.unece.org/etrades/unedocs/repository/codelists/xml/CountryCodeList.xml';
      
   /**
    * Retrieves currency codes and their associated names (e.g. USD => US Dollar)
    * from the UN or the cache.  The default cache length is 1 month.
    *
    * @param int Optionally override default 1 month cache length (in seconds)
    * @return array Array of currency codes to currency names
    */   
    function retrieve($cacheLength, $cacheDir) {
        
        // retrieve the feed from the server or cache
        $root = $this->retrieveXML($this->feedUrl, $cacheLength, $cacheDir);
    
        foreach($root->children as $curr) {
            // Filter out blank or unwanted elements
            if ($curr->name == "Country") {
                // loop through and put them into an array
                $countries[$curr->children[0]->content] = $curr->children[1]->content;
            }
        }

        return $countries; 
        
    }

}

?>
