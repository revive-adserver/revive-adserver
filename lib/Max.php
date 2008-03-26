<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA.php';

/**
 * The main OpenX class.
 *
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Demian Turner <demian@m3.net>
 */
class MAX
{

    /**
     * Converts error code constants into equivalent strings.
     *
     * @access public
     * @param integer $errorCode The error code.
     * @return string Text representing the error code.
     */
    function errorConstantToString($errorCode)
    {
        $aErrorCodes = array(
            MAX_ERROR_INVALIDARGS           => 'invalid arguments',
            MAX_ERROR_INVALIDCONFIG         => 'invalid config',
            MAX_ERROR_NODATA                => 'no data',
            MAX_ERROR_NOCLASS               => 'no class',
            MAX_ERROR_NOMETHOD              => 'no method',
            MAX_ERROR_NOAFFECTEDROWS        => 'no affected rows',
            MAX_ERROR_NOTSUPPORTED          => 'not supported',
            MAX_ERROR_INVALIDCALL           => 'invalid call',
            MAX_ERROR_INVALIDAUTH           => 'invalid auth',
            MAX_ERROR_EMAILFAILURE          => 'email failure',
            MAX_ERROR_DBFAILURE             => 'db failure',
            MAX_ERROR_DBTRANSACTIONFAILURE  => 'db transaction failure',
            MAX_ERROR_BANNEDUSER            => 'banned user',
            MAX_ERROR_NOFILE                => 'no file',
            MAX_ERROR_INVALIDFILEPERMS      => 'invalid file perms',
            MAX_ERROR_INVALIDSESSION        => 'invalid session',
            MAX_ERROR_INVALIDPOST           => 'invalid post',
            MAX_ERROR_INVALIDTRANSLATION    => 'invalid translation',
            MAX_ERROR_FILEUNWRITABLE        => 'file unwritable',
            MAX_ERROR_INVALIDREQUEST        => 'invalid request',
            MAX_ERROR_INVALIDTYPE           => 'invalid type',
        );
        if (in_array($errorCode, array_keys($aErrorCodes))) {
            return strtoupper($aErrorCodes[$errorCode]);
        } else {
            return 'PEAR';
        }
    }

    /**
     * A method to convert PEAR_Error objects to strings.
     *
     * @static
     * @param PEAR_Error $oError A {@link PEAR_Error} object
     */
    function errorObjToString($oError, $additionalInfo = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $message = $oError->getMessage();
        $debugInfo = $oError->getDebugInfo();
        $backtrace = $oError->getBacktrace();
        $level = $oError->getCode();
        $errorType = MAX::errorConstantToString($level);
        $img = MAX::constructURL(MAX_URL_IMAGE, 'errormessage.gif');
        // Message
        $output = <<<EOF
<br />
<div class="errormessage">
    <img class="errormessage" src="$img" align="absmiddle">
    <span class='tab-r'>$errorType Error</span>
    <br />
    <br />$message
    <br /><pre>$debugInfo</pre>
    $additionalInfo
</div>
<br />
<br />
EOF;
        return $output;
    }

    /**
     * A method to invoke errors.
     *
     * @static
     * @param mixed $message A string error message, or a {@link PEAR_Error} object.
     * @param integer $type A custom message code - see the {@link setupConstants()} function.
     * @param integer $behaviour Optional behaviour (i.e. PEAR_ERROR_DIE to halt on this error).
     * @return PEAR_Error $error A (@link PEAR_Error} object.
     */
    function raiseError($message, $type = null, $behaviour = null)
    {
        // If fatal
        if ($behaviour == PEAR_ERROR_DIE) {
            // Log fatal message here as execution will stop
            $errorType = MAX::errorConstantToString($type);
            if (!is_string($message)) $message = print_r($message, true);
            OA::debug($type . ' :: ' . $message, PEAR_LOG_EMERG);
            exit();
        }
        $error = PEAR::raiseError($message, $type, $behaviour);
        return $error;
    }

    /**
     * A method to construct URLs based on the OpenX installation details.
     *
     * @param integer $type The URL type. One of:
     *                  - MAX_URL_ADMIN for admin pages;
     *                  - MAX_URL_IMAGE for OpenX images (i.e. in /admin/images).
     * @param string $file An optional file name.
     * @return string The URL to the file.
     */
    function constructURL($type, $file = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Prepare the base URL
        if ($type == MAX_URL_ADMIN) {
            $path = $conf['webpath']['admin'];
        } elseif ($type == MAX_URL_IMAGE) {
            $path = $conf['webpath']['admin'] . $conf['webpath']['adminAssetsVersionSegment'] . '/images';
        } else {
            return null;
        }
        // Add a trailing slash to the path, so that there will
        // be at least one slash in the path (after the hostname,
        // in the event that virtual hosts are used, and delivery
        // happens from the root of virtual hosts)
        $path .= '/';
        // Modify the admin URL for different SSL port if required
        if ($conf['openads']['sslPort'] != 443) {
            if ($GLOBALS['_MAX']['HTTP'] == 'https://') {
                $path = preg_replace('#/#', ':' . $conf['openads']['sslPort'] . '/', $path);
            }
        }
        // Return the URL
        return $GLOBALS['_MAX']['HTTP'] . $path . $file;
    }
    
    /**
     * A method to construct URLs for static assets, such as images, CSS and JavaScripts
     * based on OpenX installation and configuration details.
     *
     * @param string $asset a relative path to the asset, optional
     * @return the URL to the asset. If asset was not provided, 
     * 			the path does not contain a trailing slash.
     */
    function assetPath($asset = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pathWithSuffix = $conf['webpath']['adminAssetsVersionSegment'];
        
    	if ($asset != null)
    	{
    		return $pathWithSuffix . "/" . $asset;
    	}
    	else
    	{
	    	return $pathWithSuffix;
    	}
    }
}

/**
 * A callback function that sets the default PEAR Error behaviour.
 *
 * @static
 * @param PEAR_Error $oError A {@link PEAR_Error} object
 */
function pearErrorHandler($oError)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    // Log message
    $message = $oError->getMessage();
    $debugInfo = $oError->getDebugInfo();
    OA::debug('PEAR' . " :: $message : $debugInfo", PEAR_LOG_ERR);

    // If sesssion debug, send error info to screen
    $msg = '';
    if (empty($conf['debug']['production'])) {
        $GLOBALS['_MAX']['ERRORS'][] = $oError;
    }

    // Add backtrace info
    if (!empty($conf['debug']['showBacktrace'])) {
        $msg .= 'PEAR backtrace: <div onClick="if (this.style.height) {this.style.height = null;this.style.width = null;} else {this.style.height = \'8px\'; this.style.width=\'8px\'}"';
        $msg .= 'style="float:left; cursor: pointer; border: 1px dashed #FF0000; background-color: #EFEFEF; height: 8px; width: 8px; overflow: hidden; margin-bottom: 2px;">';
        $msg .= '<pre wrap style="margin: 5px; background-color: #EFEFEF">';

        ob_start();
        print_r($oError->getBacktrace());
        $msg .= ob_get_clean();

        $msg .= '<hr></pre></div>';
        $msg .= '<div style="clear:both"></div>';
    }
    if (defined('TEST_ENVIRONMENT_RUNNING')) {
        // It's a test, stop execution
        echo $message;
        exit(1);
    } elseif (defined('OA_WEBSERVICES_API_XMLRPC')) {
        // It's an XML-RPC response
        $oResponse = new XML_RPC_Response('', 99999, $message);
        echo $oResponse->serialize();
        exit;
    } else {
        // Send the error to the screen
        echo MAX::errorObjToString($oError, $msg);
    }
}

// Set PEAR error handler
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'pearErrorHandler');

/*-------------------------------------------------------*/
/* Old lib-statistics code, general html transform fns   */
/*-------------------------------------------------------*/

// Define defaults
$clientCache = array();
$campaignCache = array();
$bannerCache = array();
$zoneCache = array();
$affiliateCache = array();

?>
