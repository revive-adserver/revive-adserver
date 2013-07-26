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

require_once MAX_PATH . '/lib/OA.php';

require_once 'XML/RPC.php';


/**
 * A class which extends PEAR::XML_RPC to improve client HTTPS support
 *
 * Note: Proxy support is currently disabled to keep things simple
 *
 * @package    OpenX
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_XML_RPC_Client extends XML_RPC_Client
{
    var $hasCurl = false;
    var $hasOpenssl = false;
    var $verifyPeer;
    var $caFile;

    function OA_XML_RPC_Client($path, $server, $port = 0,
                            $proxy = '', $proxy_port = 0,
                            $proxy_user = '', $proxy_pass = '')
    {
        if ($aExtensions = OA::getAvailableSSLExtensions()) {
            $this->hasCurl    = in_array('curl', $aExtensions);
            $this->hasOpenssl = in_array('openssl', $aExtensions);
        }

        $this->verifyPeer = false;
        $this->caFile     = MAX_PATH . '/etc/curl-ca-bundle.crt';
        parent::XML_RPC_Client($path, $server, $port);
    }

    function canUseSSL()
    {
        return $this->hasCurl || $this->hasOpenssl;
    }

    function _sendHttpGenerate(&$msg, $username = '', $password = '')
    {
        // Pre-emptive BC hacks for fools calling sendPayloadHTTP10() directly
        if ($username != $this->username) {
            $this->setCredentials($username, $password);
        }

        // Only create the payload if it was not created previously
        if (empty($msg->payload)) {
            $msg->createPayload();
        }
        $this->createHeaders($msg);

        $this->headers = str_replace(': PEAR XML_RPC', ': Openads XML_RPC', $this->headers);
    }

    function _sendHttpOpenSsl($msg, $server, $port, $timeout = 0,
                               $username = '', $password = '')
    {
        if (!empty($timeout)) {
            // Set timeout
            $old_timeout = ini_get('default_socket_timeout');
            ini_set('default_socket_timeout', $timeout);
        }

        $this->_sendHttpGenerate($msg, $username, $password);

        $context = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => preg_replace('/^.*?\r\n/', '', $this->headers),
                'content' => $msg->payload
            ),
            'ssl' => array(
                'verify_peer' => $this->verifyPeer,
                'cafile'      => $this->caFile
            )
        ));

        $protocol = $this->protocol == 'ssl://' ? 'https://' : 'http://';

        $fp = @fopen("{$protocol}{$this->server}:{$port}{$this->path}", 'rb', false, $context);

        if (!empty($timeout)) {
            // Restore timeout
            ini_set('default_socket_timeout', $old_timeout);
        }

        if (!$fp) {
            $this->raiseError('Connection to RPC server '
                              . $server . ':' . $port
                              . ' failed. ' . $this->errstr,
                              XML_RPC_ERROR_CONNECTION_FAILED);
            return 0;
        }

        $resp = $msg->parseResponseFile($fp);

        $meta = stream_get_meta_data($fp);
        if ($meta['timed_out']) {
            fclose($fp);
            $this->errstr = 'RPC server did not send response before timeout.';
            $this->raiseError($this->errstr, XML_RPC_ERROR_CONNECTION_FAILED);
            return 0;
        }

        fclose($fp);
        return $resp;
    }

    function _sendHttpCurl($msg, $server, $port, $timeout = 0,
                               $username = '', $password = '')
    {
        $this->_sendHttpGenerate($msg, $username, $password);

        $protocol = $this->protocol == 'ssl://' ? 'https://' : 'http://';

        $ch = curl_init("{$protocol}{$this->server}:{$port}{$this->path}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER,         true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  $this->headers."\r\n\r\n".$msg->payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $this->verifyPeer);
        curl_setopt($ch, CURLOPT_CAINFO,         $this->caFile);

        if (!empty($timeout)) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        }

        $buffer = @curl_exec($ch);
        $status = curl_errno($ch);

        @curl_close($ch);

        if ($status != CURLE_OK) {
            if ($status == CURLE_OPERATION_TIMEOUTED) {
                $this->errstr = 'RPC server did not send response before timeout.';
                $this->raiseError($this->errstr, XML_RPC_ERROR_CONNECTION_FAILED);
            } else {
                $this->raiseError('Connection to RPC server '
                                  . $server . ':' . $port
                                  . ' failed. ' . $this->errstr,
                                  XML_RPC_ERROR_CONNECTION_FAILED);
            }

            return 0;
        }

        $resp = $msg->parseResponse($buffer);

        return $resp;
    }

    function sendPayloadHTTP10($msg, $server, $port, $timeout = 0,
                               $username = '', $password = '')
    {
        if ($this->hasCurl || $this->hasOpenssl) {
            $args   = func_get_args();
            $method = $this->hasCurl ? '_sendHttpCurl' : '_sendHttpOpenSsl';
            return call_user_func_array(array(&$this, $method), $args);
        }

        return parent::sendPayloadHTTP10($msg, $server, $port, $timeout, $username, $password);
    }
}

?>
