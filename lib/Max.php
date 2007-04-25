<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once 'Log.php';
require_once 'PEAR.php';

/**
 * The main Openads class.
 *
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Demian Turner <demian@m3.net>
 */
class MAX
{

    /**
     * Hacked from Seagull's Base::logMessage method.
     *
     * Note that the method can be safely called by simply omitting the deprecated
     * parameters (but doesn't have to be).
     *
     * @static
     * @param mixed $message     Either a string or a PEAR_Error object.
     * @param string $file       Deprecated.
     * @param integer $line      Deprecated.
     * @param integer $priority  The priority of the message. One of:
     *                           PEAR_LOG_EMERG, PEAR_LOG_ALERT, PEAR_LOG_CRIT
     *                           PEAR_LOG_ERR, PEAR_LOG_WARNING, PEAR_LOG_NOTICE
     *                           PEAR_LOG_INFO, PEAR_LOG_DEBUG
     * @return boolean           True on success or false on failure.
     * @author Demian Turner <demian@m3.net>
     * @author Andrew Hill <andrew@m3.net>
     * @author Gilles Laborderie <gillesl@users.sourceforge.net>
     * @author Horde Group <http://www.horde.org>
     */
    function debug($message, $file = null, $line = null, $priority = PEAR_LOG_INFO)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        // Logging is not activated
        if ($conf['log']['enabled'] == false) {
            return;
        }
        // Deal with the fact that logMessage may be called using the
        // deprecated method signature, or the new one
        if (is_int($file)) {
            $priority =& $file;
        }
        // Priority is under logging threshold level
        if (defined($conf['log']['priority'])) {
            $conf['log']['priority'] = constant($conf['log']['priority']);
        }
        if ($priority > $conf['log']['priority']) {
            return;
        }
        // Grab DSN if we are logging to a database
        $dsn = ($conf['log']['type'] == 'sql') ? Base::getDsn() :'';
        // Instantiate a logger object based on logging options
        $logger = &Log::singleton($conf['log']['type'],
                                  MAX_PATH . '/var/' . $conf['log']['name'],
                                  $conf['log']['ident'],
                                  array($conf['log']['paramsUsername'],
                                        $conf['log']['paramsPassword'],
                                        'dsn' => $dsn,
                                        'mode' => octdec($conf['log']['fileMode']),
                                  ));
        // If log message is an error object, extract info
        if (PEAR::isError($message)) {
            $userinfo = $message->getUserInfo();
            $message = $message->getMessage();
            if (!empty($userinfo)) {
                if (is_array($userinfo)) {
                    $userinfo = implode(', ', $userinfo);
                }
            $message .= ' : ' . $userinfo;
            }
        }
        // Obtain backtrace information, if supported by PHP
        // TODO: Consider replacing version_compare with function_exists
        if (version_compare(phpversion(), '4.3.0') >= 0) {
            $bt = debug_backtrace();
            if ($conf['log']['methodNames']) {
                // XXX: Why show exactly four calls up the stack?
                $errorBt = $bt[4];
                if (isset($errorBt['class']) && $errorBt['type'] && isset($errorBt['function'])) {
                    $callInfo = $errorBt['class'] . $errorBt['type'] . $errorBt['function'] . ': ';
                    $message = $callInfo . $message;
                }
            }
            // Show entire stack, line-by-line
            if ($conf['log']['lineNumbers']) {
                foreach($bt as $errorBt) {
                    if (isset($errorBt['file']) && isset($errorBt['line'])) {
                        $message .=  "\n" . str_repeat(' ', 20 + strlen($conf['log']['ident']) + strlen($logger->priorityToString($priority)));
                        $message .= 'on line ' . $errorBt['line'] . ' of "' . $errorBt['file'] . '"';
                    }
                }
            }
        }
        // Log the message
        return $logger->log($message, $priority);
    }



    /**
     * Originally phpAds_sendMail() function.
     */
    function sendMail($email, $readable, $subject, $contents)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
    	global $phpAds_CharSet;
    	// Build To header
    	if (!get_cfg_var('SMTP')) {
    		$param_to = '"'.$readable.'" <'.$email.'>';
    	} else {
    		$param_to = $email;
    	}
    	// Build additional headers
    	$param_headers = "Content-Transfer-Encoding: 8bit\r\n";
    	if (isset($phpAds_CharSet)) {
    		$param_headers .= "Content-Type: text/plain; charset=".$phpAds_CharSet."\r\n";
    	}
    	if (get_cfg_var('SMTP')) {
    		$param_headers .= 'To: "'.$readable.'" <'.$email.">\r\n";
    	}
    	$param_headers .= 'From: "'.$conf['email']['admin_name'].'" <'.$conf['email']['admin'].'>'."\r\n";
    	// Use only \n as header separator when qmail is used
    	if ($conf['qmail_patch']) {
    		$param_headers = str_replace("\r", '', $param_headers);
    	}
    	// Add \r to linebreaks in the contents for MS Exchange compatibility
    	$contents = str_replace("\n", "\r\n", $contents);
    	return (@mail($param_to, $subject, $contents, $param_headers));
    }

    /*-------------------------------------------------------*/
    /* Get list order status                                 */
    /*-------------------------------------------------------*/

    // Manage Orderdirection
    function getOrderDirection($ThisOrderDirection)
    {
        return MAX::phpAds_getOrderDirection($ThisOrderDirection);
    }

    function phpAds_getOrderDirection($ThisOrderDirection)
    {
    	$sqlOrderDirection = '';
    	switch ($ThisOrderDirection) {
    		case 'down':
    			$sqlOrderDirection .= ' DESC';
    			break;
    		case 'up':
    			$sqlOrderDirection .= ' ASC';
    			break;
    		default:
    			$sqlOrderDirection .= ' ASC';
    	}
    	return $sqlOrderDirection;
    }

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
        $conf = $GLOBALS['_MAX']['CONF'];
        // If fatal
        if ($behaviour == PEAR_ERROR_DIE) {
            // Log fatal message here as execution will stop
            $errorType = MAX::errorConstantToString($type);
            if (!is_string($message)) $message = print_r($message, true);
            MAX::debug($type . ' :: ' . $message, null, null, PEAR_LOG_EMERG);
            exit();
        }
        $error = PEAR::raiseError($message, $type, $behaviour);
        return $error;
    }

    /**
     * A method to construct URLs based on the Openads installation details.
     *
     * @param integer $type The URL type. One of:
     *                  - MAX_URL_ADMIN for admin pages;
     *                  - MAX_URL_IMAGE for Openads images (i.e. in /admin/images).
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
            $path = $conf['webpath']['admin'] . '/images';
        } else {
            return null;
        }
        // Add a trailing slash to the path, so that there will
        // be at least one slash in the path (after the hostname,
        // in the event that virtual hosts are used, and delivery
        // happens from the root of virtual hosts)
        $path .= '/';
        // Modify the admin URL for different SSL port if required
        if ($conf['max']['sslPort'] != 443) {
            if ($GLOBALS['_MAX']['HTTP'] == 'https://') {
                $path = preg_replace('#/#', ':' . $conf['max']['sslPort'] . '/', $path);
            }
        }
        // Return the URL
        return $GLOBALS['_MAX']['HTTP'] . $path . $file;
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
    MAX::debug('PEAR' . " :: $message : $debugInfo", PEAR_LOG_ERR);

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
    // Send the error to the screen
    echo MAX::errorObjToString($oError, $msg);
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
