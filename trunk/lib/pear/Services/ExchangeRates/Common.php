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
 * @author Marshall Roch <marshall@exclupen.com>
 * @copyright Copyright 2003 Marshall Roch
 * @license http://www.php.net/license/2_02.txt PHP License 2.0
 * @package Services_ExchangeRates
 */

/**
 * Cache_Lite is needed to cache the feeds
 */
require_once 'Cache/Lite.php';

/**
 * Common functions for data retrieval
 *
 * Provides base functions to retrieve and cache data feeds in different
 * formats.
 *
 * @package Services_ExchangeRates
 */
class Services_ExchangeRates_Common {

   /**
    * Retrieves data from cache, if it's there.  If it is, but it's expired,
    * it performs a conditional GET to see if the data is updated.  If it
    * isn't, it down updates the modification time of the cache file and
    * returns the data.  If the cache is not there, or the remote file has been
    * modified, it is downloaded and cached.
    *
    * @param string URL of remote file to retrieve
    * @param int Length of time to cache file locally before asking the server
    *            if it changed.
    * @return string File contents
    */
    function retrieveFile($url, $cacheLength, $cacheDir) {

        $cacheID = md5($url);

        $cache = new Cache_Lite(array("cacheDir" => $cacheDir,
                                      "lifeTime" => $cacheLength));

        if ($data = $cache->get($cacheID)) {
            return $data;
        } else {
            // we need to perform a request, so include HTTP_Request
            include_once 'HTTP/Request.php';

            // HTTP_Request has moronic redirect "handling", turn that off (Alexey Borzov)
            $req =& new HTTP_Request($url, array('allowRedirects' => false));

            // if $cache->get($cacheID) found the file, but it was expired,
            // $cache->_file will exist
            if (isset($cache->_file) && file_exists($cache->_file)) {
                $req->addHeader('If-Modified-Since', gmdate("D, d M Y H:i:s", filemtime($cache->_file)) ." GMT");
            }

            $req->sendRequest();

            if (!($req->getResponseCode() == 304)) {
                // data is changed, so save it to cache
                $data = $req->getResponseBody();
                $cache->save($data, $cacheID);
                return $data;
            } else {
                // retrieve the data, since the first time we did this failed
                if ($data = $cache->get($cacheID, 'default', true)) {
                    return $data;
                }
            }
        }

        Services_ExchangeRates::raiseError("Unable to retrieve file ${url} (unknown reason)", SERVICES_EXCHANGERATES_ERROR_RETRIEVAL_FAILED);
        return false;

    }

   /**
    * Downloads XML file or returns it from cache
    *
    * @param string URL of XML file
    * @param int Length of time to cache
    * @return object XML_Tree object
    */
    function retrieveXML($url, $cacheLength, $cacheDir) {
        include_once 'XML/Tree.php';

        if ($data = $this->retrieveFile($url, $cacheLength, $cacheDir)) {

            $tree = new XML_Tree();
            $root =& $tree->getTreeFromString($data);

            return $root;
        }

        return false;
    }

}

?>
