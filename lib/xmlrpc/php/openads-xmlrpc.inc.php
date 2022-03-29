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

if (!@include('XML/RPC.php')) {
    die("Error: cannot load the PEAR XML_RPC class");
}

/**
 * A library class to provide XML-RPC routines  to display ads on pages on
 * a web server where OpenX is not installed but is installed on a remote server.
 *
 * For use with OpenX PHP-based XML-RPC invocation tags.
 *
 * @package    OpenX
 * @subpackage ExternalLibrary
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_XmlRpc
{
    var $host;
    var $path;
    var $port;
    var $ssl;
    var $timeout;

    var $debug = false;

    /**
     * PHP5 style constructor
     *
     * @param string $host    The hostname to connect to
     * @param string $path    The path to the axmlrpc.php file
     * @param int    $port    The port number, 0 to use standard ports which are
                              port 80 for HTTP and port 443 for HTTPS.
     * @param bool   $ssl     True to connect using an SSL connection
     * @param int    $timeout The timeout period to wait for the response
     */
    function __construct($host, $path, $port = 0, $ssl = false, $timeout = 15)
    {
        $this->host = $host;
        $this->path = $path;
        $this->port = $port;
        $this->ssl  = $ssl;
        $this->timeout = $timeout;
    }

    /**
     * This method retrieves a banner from a remote OpenX installation using XML-RPC.
     *
     * @param string $what       The "what" parameter, see docs for more info
     * @param int    $campaignid The campaign id to fetch banners from, 0 means any campaign
     * @param string $target     The HTML <a href> target
     * @param string $source     The "source" parameter, see docs for more info
     * @param bool   $withText   Wheter or not to show the text under a banner
     * @param array  $context    The "context" parameter, see docs for more info
     *
     * @return array
     */
    function view($what = '', $campaignid = 0, $target = '', $source = '', $withText = false, $context = array(), $charset = '')
    {
        global $XML_RPC_String, $XML_RPC_Boolean;
        global $XML_RPC_Array, $XML_RPC_Struct;
        global $XML_RPC_Int;

        // Prepare variables:
        $aServerVars = array(
            'remote_addr'       => 'REMOTE_ADDR',
            'remote_host'       => 'REMOTE_HOST',

            // Declare headers used for ACLs:
            'request_uri'       => 'REQUEST_URI',
            'https'             => 'HTTPS',
            'server_name'       => 'SERVER_NAME',
            'http_host'         => 'HTTP_HOST',
            'accept_language'   => 'HTTP_ACCEPT_LANGUAGE',
            'referer'           => 'HTTP_REFERER',
            'user_agent'        => 'HTTP_USER_AGENT',

            // Declase headers used for proxy lookup:
            'via'               => 'HTTP_VIA',
            'forwarded'         => 'HTTP_FORWARDED',
            'forwarded_for'     => 'HTTP_FORWARDED_FOR',
            'x_forwarded'       => 'HTTP_X_FORWARDED',
            'x_forwarded_for'   => 'HTTP_X_FORWARDED_FOR',
            'client_ip'         => 'HTTP_CLIENT_IP'
        );

        // Create the environment array:
        $aRemoteInfo = array();
        foreach ($aServerVars as $xmlVar => $varName) {
            if (isset($_SERVER[$varName])) {
                $aRemoteInfo[$xmlVar] = $_SERVER[$varName];
            }
        }

        // Add cookies:
        $aRemoteInfo['cookies'] = $_COOKIE;

        // Encode the context:
        XML_RPC_Client::setAutoBase64(true);
        $xmlContext = array();
        foreach ($context as $contextValue) {
            $xmlContext[] = XML_RPC_encode($contextValue);
        }

        // Create the XML-RPC message:
        $message = new XML_RPC_Message('openads.view', array(
            XML_RPC_encode($aRemoteInfo),
            new XML_RPC_Value($what,       $XML_RPC_String),
            new XML_RPC_Value($campaignid, $XML_RPC_Int),
            new XML_RPC_Value($target,     $XML_RPC_String),
            new XML_RPC_Value($source,     $XML_RPC_String),
            new XML_RPC_Value($withText,   $XML_RPC_Boolean),
            new XML_RPC_Value($xmlContext,    $XML_RPC_Array)
        ));

        // Create an XML-RPC client to communicate with the XML-RPC server:
        $client = new XML_RPC_Client($this->path, $this->host, $this->port);

        // Send the XML-RPC message to the server:
        $response = $client->send($message, $this->timeout, $this->ssl ? 'https' : 'http');

        // Check if the response is OK?
        if ($response && $response->faultCode() == 0) {
            $response = XML_RPC_decode($response->value());

            if (isset($response['cookies']) && is_array($response['cookies'])) {
                foreach ($response['cookies'] as $cookieName => $cookieValue) {
                    setcookie($cookieName, $cookieValue[0], (int)$cookieValue[1]);
                }
            }

            unset($response['cookies']);

            return $this->_convertEncoding($response, $charset);
        }

        return array(
            'html'       => '',
            'bannerid'   => 0,
            'campaignid' => 0
        );
    }

    function spc($what, $target = '', $source = '', $withtext = 0, $block = 0, $blockcampaign = 0, $charset = '')
    {
        global $XML_RPC_String, $XML_RPC_Boolean;
        global $XML_RPC_Array, $XML_RPC_Struct;
        global $XML_RPC_Int;

        // Prepare variables
        $aServerVars = array(
            'remote_addr'       => 'REMOTE_ADDR',
            'remote_host'       => 'REMOTE_HOST',

            // Headers used for ACLs
            'request_uri'       => 'REQUEST_URI',
            'https'             => 'HTTPS',
            'server_name'       => 'SERVER_NAME',
            'http_host'         => 'HTTP_HOST',
            'accept_language'   => 'HTTP_ACCEPT_LANGUAGE',
            'referer'           => 'HTTP_REFERER',
            'user_agent'        => 'HTTP_USER_AGENT',

            // Headers used for proxy lookup
            'via'               => 'HTTP_VIA',
            'forwarded'         => 'HTTP_FORWARDED',
            'forwarded_for'     => 'HTTP_FORWARDED_FOR',
            'x_forwarded'       => 'HTTP_X_FORWARDED',
            'x_forwarded_for'   => 'HTTP_X_FORWARDED_FOR',
            'client_ip'         => 'HTTP_CLIENT_IP'
        );

        // Create environment array
        $aRemoteInfo = array();
        foreach ($aServerVars as $xmlVar => $varName) {
            if (isset($_SERVER[$varName])) {
                $aRemoteInfo[$xmlVar] = $_SERVER[$varName];
            }
        }

        // Add cookies
        $aRemoteInfo['cookies'] = $_COOKIE;

        // If an array of zones was passed into $what, then serialise this for the XML-RPC call
        if (is_array($what)) {
            $what = http_build_query($what);
        }

        XML_RPC_Client::setAutoBase64(true);
        // Create the XML-RPC message
        $message = new XML_RPC_Message('openads.spc', array(
            XML_RPC_encode($aRemoteInfo),
            new XML_RPC_Value($what,          $XML_RPC_String),
            new XML_RPC_Value($target,        $XML_RPC_String),
            new XML_RPC_Value($source,        $XML_RPC_String),
            new XML_RPC_Value($withtext,      $XML_RPC_Boolean),
            new XML_RPC_Value($block,         $XML_RPC_Boolean),
            new XML_RPC_Value($blockcampaign, $XML_RPC_Boolean),
        ));

        // Create an XML-RPC client to talk to the XML-RPC server
        $client = new XML_RPC_Client($this->path, $this->host, $this->port);

        // Send the XML-RPC message to the server
        $response = $client->send($message, $this->timeout, $this->ssl ? 'https' : 'http');

        // Was the response OK?
        if ($response && $response->faultCode() == 0) {
            $response = XML_RPC_decode($response->value());

            if (isset($response['cookies']) && is_array($response['cookies'])) {
                foreach ($response['cookies'] as $cookieName => $cookieValue) {
                    setcookie($cookieName, $cookieValue[0], $cookieValue[1]);
                }
            }

            unset($response['cookies']);

            return $this->_convertEncoding($response, $charset);
        }

        return array(
            'html'       => '',
            'bannerid'   => 0,
            'campaignid' => 0
        );
    }

    /**
     * A function to convert a string from one encoding to another using any available extensions
     * returns the string unchanged if no suitable libraries are available
     *
     * The function will recursively walk arrays.
     *
     * @param string|array $content The string to be converted, or an array
     * @param string $toEncoding The destination encoding
     * @param string $fromEncoding The source encoding (if known)
     * @param string $aExtensions An array of engines to be used, currently supported are intl, iconv, mbstrng, xml.
     * @return string|array The converted string
     */
    function _convertEncoding($content, $toEncoding, $fromEncoding = 'UTF-8', $aExtensions = null)
    {

        // Sanity check :)
        if (($toEncoding == $fromEncoding) || empty($toEncoding)) {
            return $content;
        }

        // Default extensions, sorted by accuracy and speed.
        $aExtensions = $aExtensions ?? ['intl', 'iconv', 'mbstring', 'xml'];

        // Walk arrays
        if (is_array($content)) {
            foreach ($content as $key => $value) {
                $content[$key] = MAX_commonConvertEncoding($value, $toEncoding, $fromEncoding, $aExtensions);
            }

            return $content;
        }

        // Uppercase charsets
        $toEncoding = strtoupper($toEncoding);
        $fromEncoding = strtoupper($fromEncoding);

        // Charset mapping
        $aMap = [
            'intl' => [
                // Use unambiguous aliases
                'WINDOWS-1251' => 'CP1251',
                'WINDOWS-1255' => 'CP1255',
            ],
            'mbstring' => [
                'WINDOWS-1255' => 'ISO-8859-8', // Best match to convert hebrew w/ mbstring
            ],
            'xml' => [
                'ISO-8859-15' => 'ISO-8859-1', // Best match
            ],
        ];

        // Start conversion
        $converted = false;
        foreach ($aExtensions as $extension) {
            if (false !== $converted) {
                // Exit early if converted
                break;
            }

            $mappedFromEncoding = isset($aMap[$extension][$fromEncoding]) ? $aMap[$extension][$fromEncoding] : $fromEncoding;
            $mappedToEncoding = isset($aMap[$extension][$toEncoding]) ? $aMap[$extension][$toEncoding] : $toEncoding;

            switch ($extension) {
                case 'iconv':
                    if (function_exists('iconv')) {
                        $converted = @iconv($mappedFromEncoding, $mappedToEncoding, $content);
                    }

                    break;

                case 'intl':
                    if (class_exists('UConverter')) {
                        $converted = Uconverter::transcode($content, $mappedToEncoding, $mappedFromEncoding);
                    }

                    break;

                case 'mbstring':
                    if (function_exists('mb_convert_encoding')) {
                        $converted = @mb_convert_encoding($content, $mappedToEncoding, $mappedFromEncoding);
                    }

                    break;

                case 'xml':
                    if (function_exists('utf8_encode')) {
                        // Does this actually help us at all? it can only convert between UTF8 and ISO-8859-1
                        if ($mappedToEncoding == 'UTF-8' && $mappedFromEncoding == 'ISO-8859-1') {
                            $converted = @utf8_encode($content);
                        } elseif ($mappedToEncoding == 'ISO-8859-1' && $mappedFromEncoding == 'UTF-8') {
                            $converted = @utf8_decode($content);
                        }
                    }

                    break;
            }

            return $converted ?: $content;
        }
    }
}

?>
