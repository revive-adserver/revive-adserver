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

$file = '/lib/max/Delivery/common.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

require_once MAX_PATH . '/lib/max/Delivery/cookie.php';
require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';
require_once MAX_PATH . '/lib/max/Delivery/log.php';

/**
 * @package    MaxDelivery
 * @subpackage common
 *
 * This library defines functions that need to be available to
 * all delivery engine scripts
 *
 */

/**
 * A function that can be used to get the delivery URL,
 * or the delivery URL prefix (sans-file) if no filname
 * is passed in.
 *
 * @param string $file Optional delivery file name.
 * @return string The delivery URL.
 */
function MAX_commonGetDeliveryUrl($file = null)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($GLOBALS['_MAX']['SSL_REQUEST']) {
        $url = MAX_commonConstructSecureDeliveryUrl($file);
    } else {
        $url = MAX_commonConstructDeliveryUrl($file);
    }
    return $url;
}

/**
 * A function to generate the URL for delivery scripts.
 *
 * @param string $file The file name of the delivery script.
 * @return string The URL to the delivery script.
 */
function MAX_commonConstructDeliveryUrl($file)
{
        $conf = $GLOBALS['_MAX']['CONF'];
        return 'http://' . $conf['webpath']['delivery'] . '/' . $file;
}

/**
 * A function to generate the secure URL for delivery scripts.
 *
 * @param string $file The file name of the delivery script.
 * @return string The URL to the delivery script.
 */
function MAX_commonConstructSecureDeliveryUrl($file)
{
        $conf = $GLOBALS['_MAX']['CONF'];
        if ($conf['openads']['sslPort'] != 443) {
            // Fix the delivery host
            $path = preg_replace('#/#', ':' . $conf['openads']['sslPort'] . '/', $conf['webpath']['deliverySSL'], 1);
        } else {
            $path = $conf['webpath']['deliverySSL'];
        }
        return 'https://' . $path . '/' . $file;
}

/**
 * A function to generate the URL for delivery scripts without a protocol.
 *
 * @param string $file The file name of the delivery script.
 * @param boolean $ssl Use the SSL delivery path (true) or not. Default is false.
 * @return string The parital URL to the delivery script (i.e. without
 *                an 'http:' or 'https:' prefix).
 */
function MAX_commonConstructPartialDeliveryUrl($file, $ssl = false)
{
        $conf = $GLOBALS['_MAX']['CONF'];
        if ($ssl) {
            return '//' . $conf['webpath']['deliverySSL'] . '/' . $file;
        } else {
            return '//' . $conf['webpath']['delivery'] . '/' . $file;
        }
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
function MAX_commonRemoveSpecialChars(&$var)
{
    static $magicQuotes;
    if (!isset($magicQuotes)) {
        $magicQuotes = get_magic_quotes_gpc();
    }
    if (isset($var)) {
        if (!is_array($var)) {
            if ($magicQuotes) {
                $var = stripslashes($var);
            }
            $var = strip_tags($var);
            $var = str_replace(array("\n", "\r"), array('', ''), $var);
            $var = trim($var);
        } else {
            array_walk($var, 'MAX_commonRemoveSpecialChars');
        }
    }
}

/**
 * A function to convert a string from one encoding to another using any available extensions
 * returns the string unchanged if no suitable libraries are available
 *
 * The function will recursively walk arrays.
 *
 * @param mixed  $content The string to be converted, or an array
 * @param string $toEncoding The destination encoding
 * @param string $fromEncoding The source encoding (if known)
 * @param string $aExtensions An array of engines to be used, currently supported are iconv, mbstrng, xml.
 * @return string The converted string
 */
function MAX_commonConvertEncoding($content, $toEncoding, $fromEncoding = 'UTF-8', $aExtensions = null) {
    // Sanity check :)
    if (($toEncoding == $fromEncoding) || empty($toEncoding)) {
        return $content;
    }
    // Default extensions
    if (!isset($aExtensions) || !is_array($aExtensions)) {
        $aExtensions = array('iconv', 'mbstring', 'xml');
    }
    // Walk arrays
    if (is_array($content)) {
        foreach ($content as $key => $value) {
            $content[$key] = MAX_commonConvertEncoding($value, $toEncoding, $fromEncoding, $aExtensions);
        }
        return $content;
    } else {
        // Uppercase charsets
        $toEncoding   = strtoupper($toEncoding);
        $fromEncoding = strtoupper($fromEncoding);

        // Charset mapping
        $aMap = array();
        $aMap['mbstring']['WINDOWS-1255'] = 'ISO-8859-8'; // Best match to convert hebrew w/ mbstring
        $aMap['xml']['ISO-8859-15'] = 'ISO-8859-1'; // Best match
        // Start conversion
        $converted = false;
        foreach ($aExtensions as $extension) {
            $mappedFromEncoding = isset($aMap[$extension][$fromEncoding]) ? $aMap[$extension][$fromEncoding] : $fromEncoding;
            $mappedToEncoding   = isset($aMap[$extension][$toEncoding])   ? $aMap[$extension][$toEncoding]   : $toEncoding;
            switch ($extension) {
                case 'iconv':
                    if (function_exists('iconv')) {
                        $converted = @iconv($mappedFromEncoding, $mappedToEncoding, $content);
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
                            $converted = utf8_encode($content);
                        } elseif ($mappedToEncoding == 'ISO-8859-1' && $mappedFromEncoding == 'UTF-8') {
                            $converted = utf8_decode($content);
                        }
                    }
                    break;
            }
        }
        return $converted ? $converted : $content;
    }
}

/**
 * This function sends content-type headers to the clients browser
 * It therefore must be called within an output buffer or before any script output
 *
 * @param string $type The content type tp be sent
 * @param string $charset Optional character set to send with the header
 */
function MAX_commonSendContentTypeHeader($type = 'text/html', $charset = null)
{
    $header = 'Content-type: ' . $type;
    if (!empty($charset) && preg_match('/^[a-zA-Z0-9_-]+$/D', $charset)) {
        $header .= '; charset=' . $charset;
    }

    MAX_header($header);
}

/**
 * This function sends the anti-caching headers when called
 *
 */
function MAX_commonSetNoCacheHeaders()
{
    MAX_header('Pragma: no-cache');
    MAX_header('Cache-Control: no-cache, no-store, must-revalidate');
    MAX_header('Expires: 0');

    // Also send default CORS headers
    MAX_header('Access-Control-Allow-Origin: *');
}

/**
 * Recursively add slashes to the values in an array.
*
 * @param array Input array.
 * @return array Output array with values slashed.
 */
function MAX_commonAddslashesRecursive($a)
{
    if (is_array($a)) {
        reset($a);
        while (list($k,$v) = each($a)) {
            $a[$k] = MAX_commonAddslashesRecursive($v);
        }
        reset ($a);
        return ($a);
    } else {
        return is_null($a) ? null : addslashes($a);
    }
}

/**
 * This function takes an array of variable names
 * and makes them available in the global scope
 *
 * $_POST values take precedence over $_GET values
 *
 */
function MAX_commonRegisterGlobalsArray($args = array())
{
    static $magic_quotes_gpc;
    if (!isset($magic_quotes_gpc)) {
        $magic_quotes_gpc = ini_get('magic_quotes_gpc');
    }

    $found = false;
    foreach($args as $key) {
        if (isset($_GET[$key])) {
            $value = $_GET[$key];
            $found = true;
        }
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
            $found = true;
        }
        if ($found) {
            if (!$magic_quotes_gpc) {
                if (!is_array($value)) {
                    $value = addslashes($value);
                } else {
                    $value = MAX_commonAddslashesRecursive($value);
                }
            }
            $GLOBALS[$key] = $value;
            $found = false;
        }
    }
}

/**
 * This function takes the "source" value and normalises it
 * and encrypts it if necessary
 *
 * @param string The value from the source parameter
 * @return string Encrypted source
 */
function MAX_commonDeriveSource($source)
{
    return MAX_commonEncrypt(trim(urldecode($source)));
}

/**
 * This function takes a normalised source value, and encrypts it
 * if the $conf['delivery']['obfuscate'] variable is set
 *
 * @param string $string
 * @return string Encrypted source
 */
function MAX_commonEncrypt($string)
{
    $convert = '';
    if (isset($string) && substr($string,1,4) != 'obfs' && $GLOBALS['_MAX']['CONF']['delivery']['obfuscate']) {
        $strLen = strlen($string);
        for ($i=0; $i < $strLen; $i++) {
            $dec = ord(substr($string,$i,1));
            if (strlen($dec) == 2) {
                $dec = 0 . $dec;
            }
            $dec = 324 - $dec;
            $convert .= $dec;
        }
        $convert = '{obfs:' . $convert . '}';
        return ($convert);
    } else {
        return $string;
    }
}

/**
 * This method decrypts the source value if it has been previously
 * encrypted, otherwise returns the string unchanged
 *
 * @param string $string
 * @return string Decrypted source value
 */
function MAX_commonDecrypt($string)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $convert = '';
    if (isset($string) && substr($string,1,4) == 'obfs' && $conf['delivery']['obfuscate']) {
        $strLen = strlen($string);
        for ($i=6; $i < $strLen-1; $i = $i+3) {
            $dec = substr($string,$i,3);
            $dec = 324 - $dec;
            $dec = chr($dec);
            $convert .= $dec;
        }
        return ($convert);
    } else {
        return($string);
    }
}

/**
 * This function takes the parameters passed into the delivery script
 * Normalises them, and sets them into the global scope
 * Parameters specific to individual scripts are dealt with individually
 */
function MAX_commonInitVariables()
{
    MAX_commonRegisterGlobalsArray(array('context', 'source', 'target', 'withText', 'withtext', 'ct0', 'what', 'loc', 'referer', 'zoneid', 'campaignid', 'bannerid', 'clientid', 'charset'));
    global $context, $source, $target, $withText, $withtext, $ct0, $what, $loc, $referer, $zoneid, $campaignid, $bannerid, $clientid, $charset;

    if (isset($withText) && !isset($withtext))  $withtext = $withText;
    $withtext   = (isset($withtext) && is_numeric($withtext) ? $withtext : 0  );
    $ct0        = (isset($ct0)          ? $ct0          : ''        );
    $context    = (isset($context)      ? $context      : array()   );

    $target     = (isset($target)  && (!empty($target))  && (!strpos($target , chr(32))) ? $target       : ''  );
    $charset    = (isset($charset) && (!empty($charset)) && (!strpos($charset, chr(32))) ? $charset      : 'UTF-8'  );

    $bannerid   = (isset($bannerid)     && is_numeric($bannerid)    ? $bannerid     : ''        );
    $campaignid = (isset($campaignid)   && is_numeric($campaignid)  ? $campaignid   : ''        );
    $clientid   = (isset($clientid)     && is_numeric($clientid)    ? $clientid     : ''        );
    $zoneid     = (isset($zoneid)       && is_numeric($zoneid)      ? $zoneid       : ''        );

    if (!isset($what))
    {
        if (!empty($bannerid)) {
            $what = 'bannerid:'.$bannerid;
        } elseif (!empty($campaignid)) {
            $what = 'campaignid:'.$campaignid;
        } elseif (!empty($zoneid)) {
            $what = 'zone:'.$zoneid;
        } else {
            $what = '';
        }
    }
    elseif (preg_match('/^([a-z]+):(\d+)$/', $what, $matches))
    {
        switch ($matches[1])
        {
            case 'zoneid':
            case 'zone':
                $zoneid     = $matches[2];
                break;
            case 'bannerid':
                $bannerid   = $matches[2];
                break;
            case 'campaignid':
                $campaignid = $matches[2];
                break;
            case 'clientid':
                $clientid   = $matches[2];
                break;
        }
    }

    // 2.0 backwards compatibility - clientid parameter was used to fetch a campaign
    if (!isset($clientid)) $clientid = '';
    if (empty($campaignid))  $campaignid = $clientid;

    $source = MAX_commonDeriveSource($source);

    if (!empty($loc)) {
        $loc = stripslashes($loc);
    } elseif (!empty($_SERVER['HTTP_REFERER'])) {
        $loc = $_SERVER['HTTP_REFERER'];
    } else {
        $loc = '';
    }

    // Set real referer - Only valid if passed in
    if (!empty($referer)) {
        $_SERVER['HTTP_REFERER'] = stripslashes($referer);
    } else {
        if (isset($_SERVER['HTTP_REFERER'])) unset($_SERVER['HTTP_REFERER']);
    }

    $GLOBALS['_MAX']['COOKIE']['LIMITATIONS']['arrCappingCookieNames'] = array(
        $GLOBALS['_MAX']['CONF']['var']['blockAd'],
        $GLOBALS['_MAX']['CONF']['var']['capAd'],
        $GLOBALS['_MAX']['CONF']['var']['sessionCapAd'],
        $GLOBALS['_MAX']['CONF']['var']['blockCampaign'],
        $GLOBALS['_MAX']['CONF']['var']['capCampaign'],
        $GLOBALS['_MAX']['CONF']['var']['sessionCapCampaign'],
        $GLOBALS['_MAX']['CONF']['var']['blockZone'],
        $GLOBALS['_MAX']['CONF']['var']['capZone'],
        $GLOBALS['_MAX']['CONF']['var']['sessionCapZone'],
        $GLOBALS['_MAX']['CONF']['var']['lastClick'],
        $GLOBALS['_MAX']['CONF']['var']['lastView'],
        $GLOBALS['_MAX']['CONF']['var']['blockLoggingClick'],
    );

    if (strtolower($charset) == 'unicode') { $charset = 'utf-8'; }
}

/**
 * Display a 1x1 pixel gif.  Include the appropriate image headers
 */
function MAX_commonDisplay1x1()
{
    MAX_header('Content-Type: image/gif');
    // 1 x 1 gif
    echo "GIF89a\001\0\001\0\200\0\0\377\377\377\0\0\0!\371\004\0\0\0\0\0,\0\0\0\0\001\0\001\0\0\002\002D\001\0;";
}

function MAX_commonGetTimeNow()
{
    if (!isset($GLOBALS['_MAX']['NOW'])) {
        $GLOBALS['_MAX']['NOW'] = time();
    }
    return $GLOBALS['_MAX']['NOW'];
}

/**
 * Returns a random number of length $length
 * @param length can be 32 max
 * @return string
 */
function MAX_getRandomNumber($length = 10)
{
    return substr(md5(uniqid(time(), true)), 0, $length);
}

/**
 * send a header (for real)
 */
function MAX_header($value)
{
    ###START_STRIP_DELIVERY
    if(empty($GLOBALS['is_simulation']) && !defined('TEST_ENVIRONMENT_RUNNING')) {
    ###END_STRIP_DELIVERY
        header($value);
    ###START_STRIP_DELIVERY
    } else {
        if (empty($GLOBALS['_HEADERS']) || !is_array($GLOBALS['_HEADERS'])) {
            $GLOBALS['_HEADERS'] = array();
        }
        $GLOBALS['_HEADERS'][] = $value;
    }
    ###END_STRIP_DELIVERY
}

/**
 * Redirect to provided URL
 * This function makes sure that user receives correct headers when
 * redirecting to destination URL
 *
 * @param string $url
 */
function MAX_redirect($url)
{
    if (!preg_match('/^(?:javascript|data):/i', $url)) {
        $host = @parse_url($url, PHP_URL_HOST);
        if (function_exists('idn_to_ascii')) {
            $idn = idn_to_ascii($host);
            if ($host != $idn) {
                $url = preg_replace('#^(.*?://)'.preg_quote($host, '#').'#', '$1'.$idn, $url);
            }
        }
        header('Location: '.$url);
        MAX_sendStatusCode(302);
    }
}

/**
 * Send a status code as described in ticket
 * Thanks to Tobias Schwarz for reporting this and sending this code.
 *
 * @param int $iStatusCode  Status code to send
 */
function MAX_sendStatusCode($iStatusCode) {
    $aConf = $GLOBALS['_MAX']['CONF'];

	$arr = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => '[Unused]',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported'
	);
	if (isset($arr[$iStatusCode])) {
	    $text = $iStatusCode . ' ' . $arr[$iStatusCode];

        // Using header('Status: foo') with CGI sapis appears to be deprecated but PHP-CGI seems to discard
        // the Reason-Phrase and some webservers do not add a default one. Some bad spiders do not cope
        // with that, that's why we added the cgiForceStatusHeader confgiuration directive. If enabled
        // with CGI sapis, OpenX will use a "Status: NNN Reason" header, which seems to fix the behaviour
        // on the tested webserver (Apache 1.3, running php-cgi)
	    if (!empty($aConf['delivery']['cgiForceStatusHeader']) && strpos(php_sapi_name(), 'cgi') !== 0) {
	       MAX_header('Status: ' . $text);
	    } else {
	       MAX_header($_SERVER["SERVER_PROTOCOL"] .' ' . $text);
	    }
	}
}

function MAX_commonPackContext($context = array())
{
    $include = array();
    $exclude = array();
    foreach ($context as $idx => $value) {
        reset($value);
        list($key, $value) = each($value);
        list($item,$id) = explode(':', $value);
        switch ($item) {
            case 'campaignid':  $value = 'c:' . $id; break;
            case 'clientid':    $value = 'a:' . $id; break;
            case 'bannerid':    $value = 'b:' . $id; break;
            case 'companionid': $value = 'p:' . $id; break;
        }
        // Set value as key to avoid duplicates
        switch ($key) {
            case '!=': $exclude[$value] = true; break;
            case '==': $include[$value] = true; break;
        }
    }
    $exclude = array_keys($exclude);
    $include = array_keys($include);
    return base64_encode(implode('#', $exclude) . '|' . implode('#', $include));
}

function MAX_commonUnpackContext($context = '')
{
    //return unserialize(base64_decode($context));
    list($exclude,$include) = explode('|', base64_decode($context));
    return array_merge(_convertContextArray('!=', explode('#', $exclude)), _convertContextArray('==', explode('#', $include)));
}

function MAX_commonCompressInt($int)
{
    return base_convert($int, 10, 36);
}

function MAX_commonUnCompressInt($string)
{
    return base_convert($string, 36, 10);
}


function _convertContextArray($key, $array)
{
    $unpacked = array();
    foreach ($array as $value) {
        if (empty($value)) { continue; }
        list($item, $id) = explode(':', $value);
        switch ($item) {
            case 'c': $unpacked[] = array($key => 'campaignid:' . $id); break;
            case 'a': $unpacked[] = array($key => 'clientid:'   . $id); break;
            case 'b': $unpacked[] = array($key => 'bannerid:'   . $id); break;
            case 'p': $unpacked[] = array($key => 'companionid:'.$id); break;
        }
    }
    return $unpacked;
}

/**
 * This function implements the hook mechanism in the delivery engine
 * It allows for a series of registered (stackable) hooks to be executed sequentially
 * Or it allows a single
 *
 * @param string $hookName      The name of the hook to be executed
 * @param array $aParams        An (optional) array of parameters to be passed to the component-hook(s)
 * @param string $functionName  Optional functionName to execute, if this is not passed in, then all components
 *                              which are registered at this hook will be executed sequentially
 * @return mixed                If a functionName was passed in, then the return value from executing the
 *                              function gets returned, otherwise (stackable hooks) true
 */
function OX_Delivery_Common_hook($hookName, $aParams = array(), $functionName = '')
{
    $return = null;
    // When a $functionname is passed in we use that function/component-identifier and execute the hook
    if (!empty($functionName)) {
        // Right now, we're allowing either a plain function to be executed, or a component-identifier
        // we may remove the ability to pass a plain function in the future
        $aParts = explode(':', $functionName);
        if (count($aParts) === 3) {
            $functionName = OX_Delivery_Common_getFunctionFromComponentIdentifier($functionName, $hookName);
        }
        if (function_exists($functionName)) {
            $return = call_user_func_array($functionName, $aParams);
        }
    } else {
        // When no $functionName is passed in, we execute all components which are registered for this hook
        if (!empty($GLOBALS['_MAX']['CONF']['deliveryHooks'][$hookName])) {
            $return = array();
            $hooks = explode('|', $GLOBALS['_MAX']['CONF']['deliveryHooks'][$hookName]);
            foreach ($hooks as $identifier) {
                $functionName = OX_Delivery_Common_getFunctionFromComponentIdentifier($identifier, $hookName);
                if (function_exists($functionName)) {
                    OX_Delivery_logMessage('calling on '.$functionName, 7);
                    $return[$identifier] = call_user_func_array($functionName, $aParams);
                }
            }
        }
    }
    return $return;
}

/**
 * This function get both the expected function name for a component-identifier/hook combination
 * It will also include the appropriate library file so that the function will be available (if possible)
 *
 * @param string $identifier    The component identifer string
 * @param string $hook          The hook being called
 * @return string               The name of the (now included) function to be executed
 */
function OX_Delivery_Common_getFunctionFromComponentIdentifier($identifier, $hook = null)
{
    // Security check
    if (preg_match('/[^a-zA-Z0-9:]/', $identifier)) {
        if (PHP_SAPI === 'cli') {
            exit(1);
        } else {
            MAX_sendStatusCode(400);
            exit;
        }
    }

    $aInfo = explode(':', $identifier);
    $functionName = 'Plugin_' . implode('_', $aInfo) . '_Delivery' . (!empty($hook) ? '_' . $hook : '');

    if (!function_exists($functionName)) {
        // Function doesn't exist, include the generic merged delivery file
        if (!empty($GLOBALS['_MAX']['CONF']['pluginSettings']['useMergedFunctions'])) _includeDeliveryPluginFile('/var/cache/' . OX_getHostName() . '_mergedDeliveryFunctions.php');
        if (!function_exists($functionName)) {
            // Function doesn't exist, include the relevant plugin file
            _includeDeliveryPluginFile($GLOBALS['_MAX']['CONF']['pluginPaths']['plugins'] . '/' . implode('/', $aInfo) . '.delivery.php');
            if (!function_exists($functionName)) {
                // Function or function file doesn't exist, use the "parent" function
                _includeDeliveryPluginFile('/lib/OX/Extension/' . $aInfo[0] .  '/' . $aInfo[0] . 'Delivery.php');
                $functionName = 'Plugin_' . $aInfo[0] . '_delivery';
                if (!empty($hook) && function_exists($functionName . '_' . $hook)) {
                    $functionName .= '_' . $hook;
                }
            }
        }
    }
    return $functionName;
}

/**
 * This function includes a file relative to MAX_PATH, and ensures that it won't be included more than once
 *
 * @param string $fileName  The path/to/file to be included (relative to MAX_PATH)
 */
function _includeDeliveryPluginFile($fileName)
{
    if (!in_array($fileName, array_keys($GLOBALS['_MAX']['FILES']))) {
        $GLOBALS['_MAX']['FILES'][$fileName] = true;
        if (file_exists(MAX_PATH . $fileName)) {
            include MAX_PATH . $fileName;
        }
    }
}

function OX_Delivery_logMessage($message, $priority = 6)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    // Don't even try if the deliveryLog is not enabled...
    if (empty($conf['deliveryLog']['enabled'])) return true;

    // Only log messages above the configured priority level (See lib/pear/Log.php for a description of the levels)
    $priorityLevel = is_numeric($conf['deliveryLog']['priority']) ? $conf['deliveryLog']['priority'] : 6;
    if ($priority > $priorityLevel && empty($_REQUEST[$conf['var']['trace']])) { return true; }

    // Log the error message
    error_log('[' . date('r') . "] {$conf['log']['ident']}-delivery-{$GLOBALS['_MAX']['thread_id']}: {$message}\n", 3, MAX_PATH . '/var/' . $conf['deliveryLog']['name']);

    // Call any plugins registered on the "logMessage" hook
    OX_Delivery_Common_hook('logMessage', array($message, $priority));

    return true;
}

?>
