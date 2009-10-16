<?php
//echo "<pre>";
//debug_print_backtrace();
//echo "</pre>";


/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Http
 * @subpackage Client_Adapter
 * @version    $Id: mergeCopyTarget55204.tmp 42386 2009-08-31 11:23:39Z lukasz.wikierski $
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

require_once 'Zend/Uri/Http.php';
require_once 'Zend/Http/Client/Adapter/Interface.php';
require_once 'Zend/Http/Client/Adapter/Exception.php';

/**
 * An adapter class for Zend_Http_Client based on the curl extension.
 * Curl requires libcurl. See for full requirements the PHP manual: http://php.net/curl
 *
 * @category   Zend
 * @package    Zend_Http
 * @subpackage Client_Adapter
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Http_Client_Adapter_Curl implements Zend_Http_Client_Adapter_Interface
{
    /**
     * The curl session handle
     *
     * @var resource|null
     */
    protected $curl = null;

    /**
     * What host/port are we connected to?
     *
     * @var array
     */
    protected $connected_to = array(null, null);

    /**
     * Parameters array
     *
     * @var array
     */
    protected $config = array();

    /**
     * Response gotten from server
     *
     * @var string
     */
    protected $response = null;

    /**
     * Adapter constructor, currently empty. Config is set using setConfig()
     * @throws Zend_Http_Client_Adapter_Exception
     */
    public function __construct()
    {
        if (extension_loaded('curl') === false) {
            throw new Zend_Http_Client_Adapter_Exception('cURL extension has to be loaded to use this Zend_Http_Client adapter.');
        }
    }

    /**
     * Set the configuration array for the adapter
     *
     * @throws Zend_Http_Client_Adapter_Exception
     * @param array $config
     */
    public function setConfig($config = array())
    {
        if (! is_array($config)) {
            throw new Zend_Http_Client_Adapter_Exception('Http Adapter configuration expects an array, ' . gettype($config) . ' recieved.');
        }

        foreach ($config as $k => $v) {
            $this->config[strtolower($k)] = $v;
        }
    }

    /**
     * Direct setter for cURL adapter related options.
     * 
     * @param  string|int $option
     * @param  mixed $value
     * @return Zend_Http_Adapter_Curl
     */
    public function setCurlOption($option, $value)
    {
        if(!isset($this->config['curloptions'])) {
            $this->config['curloptions'] = array();
        }
        $this->config['curloptions'][$option] = $value;
        return $this;
    }

    /**
     * Initialize curl
     *
     * @param string  $host
     * @param int     $port
     * @param boolean $secure
     */
    public function connect($host, $port = 80, $secure = false)
    {
        // If we're already connected, disconnect first
        if ($this->curl) $this->close();

        // If we are connected to a different server or port, disconnect first
        if ($this->curl && is_array($this->connected_to) &&
            ($this->connected_to[0] != $host || $this->connected_to[1] != $port))
        $this->close();

        // Do the actual connection
        $this->curl = curl_init();
        if ($port != 80) {
            curl_setopt($this->curl, CURLOPT_PORT, intval($port));
        }

        // Set timeout
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->config['timeout']);

        // Set Max redirects
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, $this->config['maxredirects']);

        if (! $this->curl) {
            $this->close();
            throw new Zend_Http_Client_Adapter_Exception('Unable to Connect to ' .
            $host . ':' . $port);
        }

        if($secure == true) {
            // Behave the same like Zend_Http_Adapter_Socket on SSL options.
            if($this->config['sslcert'] != null) {
                curl_setopt($this->curl, CURLOPT_SSLCERT, $this->config['sslcert']);
            }
            if($this->config['sslpassphrase'] !== null) {
                curl_setopt($this->curl, CURLOPT_SSLCERTPASSWD, $this->config['sslpassphrase']);
            }
        }

        // Update connected_to
        $this->connected_to = array($host, $port);
    }

    /**
     * Send request to the remote server
     *
     * @param  string        $method
     * @param  Zend_Uri_Http $uri
     * @param  float         $http_ver
     * @param  array         $headers
     * @param  string        $body
     * @return string        $request
     */
    public function write($method, $uri, $http_ver = '1.1', $headers = array(), $body = '')
    {
        $invalidOverwritableCurlOptions = array(
            CURLOPT_HTTPGET, CURLOPT_POST, CURLOPT_PUT, CURLOPT_CUSTOMREQUEST, CURLOPT_HEADER,
            CURLOPT_RETURNTRANSFER, CURLOPT_HTTPHEADER, CURLOPT_POSTFIELDS, CURLOPT_INFILE,
            CURLOPT_INFILESIZE, CURLOPT_PORT, CURLOPT_MAXREDIRS, CURLOPT_TIMEOUT,
            CURL_HTTP_VERSION_1_1, CURL_HTTP_VERSION_1_0
        );

        // set URL
        curl_setopt($this->curl, CURLOPT_URL, $uri->__toString());
        // Make sure we're properly connected
        if (! $this->curl)
            throw new Zend_Http_Client_Adapter_Exception("Trying to write but we are not connected");

        if ($this->connected_to[0] != $uri->getHost() || $this->connected_to[1] != $uri->getPort())
            throw new Zend_Http_Client_Adapter_Exception("Trying to write but we are connected to the wrong host");

        // ensure correct curl call
        $curlValue = true;
        if ($method == Zend_Http_Client::GET) {
            $curlMethod = CURLOPT_HTTPGET;
        } elseif ($method == Zend_Http_Client::POST) {
            $curlMethod = CURLOPT_POST;
        } elseif($method == Zend_Http_Client::PUT) {
            // There are two different types of PUT request, either a Raw Data string has been set
            // or CURLOPT_INFILE and CURLOPT_INFILESIZE are used.
            if(isset($this->config['curloptions'][CURLOPT_INFILE])) {
                if(!isset($this->config['curloptions'][CURLOPT_INFILESIZE])) {
                    throw new Zend_Http_Client_Exception("Cannot set a file-handle for cURL option CURLOPT_INFILE without also setting its size in CURLOPT_INFILESIZE.");
                }
                // Now we will probably already have Content-Length set, so that we have to delete it
                // from $headers at this point:
                foreach($headers AS $k => $header) {
                    if(stristr($header, "Content-Length:") !== false) {
                        unset($headers[$k]);
                    }
                }
                $curlMethod = CURLOPT_PUT;
            } else {
                $curlMethod = CURLOPT_CUSTOMREQUEST;
                $curlValue = "PUT";
            }
        } elseif($method == Zend_Http_Client::DELETE) {
            $curlMethod = CURLOPT_CUSTOMREQUEST;
            $curlValue = "DELETE";
        } elseif($method == Zend_Http_Client::OPTIONS) {
            $curlMethod = CURLOPT_CUSTOMREQUEST;
            $curlValue = "OPTIONS";
        } elseif($method == Zend_Http_Client::TRACE) {
            $curlMethod = CURLOPT_CUSTOMREQUEST;
            $curlValue = "TRACE";
        } else {
            // For now, through an exception for unsupported request methods
            throw new Zend_Http_Client_Adapter_Exception("Method currently not supported");
        }

        // get http version to use
        $curlHttp = ($http_ver = 1.1) ? CURL_HTTP_VERSION_1_1 : CURL_HTTP_VERSION_1_0;

        curl_setopt($this->curl, $curlMethod, $curlValue);
        curl_setopt($this->curl, $curlHttp, true);

        // ensure headers are also returned
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        // ensure actual response is returned
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        // set additional headers
        $headers['Accept'] = "";
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

        /**
         * Make sure POSTFIELDS is set after $curlMethod is set:
         * @link http://de2.php.net/manual/en/function.curl-setopt.php#81161
         */
        if ($method == Zend_Http_Client::POST) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $body);
        } else if($curlMethod == CURLOPT_PUT) {
            // this covers a PUT by file-handle:
            // Make the setting of this options explicit (rather than setting it through the loop following a bit lower)
            // to group common functionality together.
            curl_setopt($this->curl, CURLOPT_INFILE, $this->config['curloptions'][CURLOPT_INFILE]);
            curl_setopt($this->curl, CURLOPT_INFILESIZE, $this->config['curloptions'][CURLOPT_INFILESIZE]);
            unset($this->config['curloptions'][CURLOPT_INFILE]);
            unset($this->config['curloptions'][CURLOPT_INFILESIZE]);
        } else if($method == Zend_Http_Client::PUT) {
            // This is a PUT by a setRawData string, not by file-handle
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $body);
        }

        // set additional curl options
        if(isset($this->config['curloptions'])) {
            foreach((array)$this->config['curloptions'] AS $k => $v) {
                if(!in_array($k, $invalidOverwritableCurlOptions)) {
                    if(curl_setopt($this->curl, $k, $v) == false) {
                        throw new Zend_Http_Client_Exception(sprintf("Unknown or erroreous cURL option '%s' set", $k));
                    }
                }
            }
        }

        // send the request
        $this->response = curl_exec($this->curl);

        $request = curl_getinfo($this->curl, CURLINFO_HEADER_OUT);
        $request .= $body;

        if(empty($this->response)) {
            throw new Zend_Http_Client_Exception("Error in cURL request: ".curl_error($this->curl));
        }

        // cURL automatically decodes chunked-messages, this means we have to disallow the Zend_Http_Response to do it again
        if(stripos($this->response, "Transfer-Encoding: chunked\r\n")) {
            $this->response = str_ireplace("Transfer-Encoding: chunked\r\n", '', $this->response);
        }
        // TODO: Probably the pattern for multiple handshake requests is always the same, several HTTP codes in the response. Use that information?
        // cURL automactically handles Expect: 100-continue; and its responses. Delete the HTTP 100 CONTINUE from a response
        // because it messes up Zend_Http_Response parsing
        if(stripos($this->response, "HTTP/1.1 100 Continue\r\n\r\n") !== false) {
            $this->response = str_ireplace("HTTP/1.1 100 Continue\r\n\r\n", '', $this->response);
        }
        // cURL automatically handles Proxy rewrites, remove the "HTTP/1.0 200 Connection established" string:
        if(stripos($this->response, "HTTP/1.0 200 Connection established\r\n\r\n") !== false) {
            $this->response = str_ireplace("HTTP/1.0 200 Connection established\r\n\r\n", '', $this->response);
        }

        return $request;
    }

    /**
     * Return read response from server
     *
     * @return string
     */
    public function read()
    {
        return $this->response;
    }

    /**
     * Close the connection to the server
     *
     */
    public function close()
    {
        curl_close($this->curl);
        $this->curl = null;
        $this->connected_to = array(null, null);
    }

    /**
     * Destructor: make sure curl is disconnected
     *
     */
    public function __destruct()
    {
        if ($this->curl) $this->close();
    }
}