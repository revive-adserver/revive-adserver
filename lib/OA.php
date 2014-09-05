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

###START_STRIP_DELIVERY
require_once MAX_PATH . '/lib/pear/Log.php';
require_once MAX_PATH . '/lib/pear/PEAR.php';
require_once MAX_PATH . '/lib/OX/Admin/Timezones.php';

/**
 * this is a method to capture select queries and write them to a logfile
 * for analysis purposes
 * to trigger set $GLOBALS['_MAX']['CONF']['debug']['logSQL'] = 1
 *
 * @param mdb2 connecction $oDbh
 */
function logSQL($oDbh, $scope, $message, $context)
{
    // don't log 'explain' queries or we spiral out of control
    // don't log queries against temporary tables (cos the tables won't exist to use for explain)
    if ((substr_count($message, 'EXPLAIN')==0) && (substr_count($message, 'tmp_')==0))
    {
        $log = fopen(MAX_PATH."/var/sql.log", 'a');

        $aStatements = $oDbh->options['log_statements'];

        foreach ($aStatements AS $statement)
        {
            $i = strpos($message, strtoupper($statement));
            if ($i > -1)
            {
                $query = $message;
                if ($i > 0)
                {
                    if (strpos($message,'PREPARE MDB2_STATEMENT')<0)
                    {
                        $query = substr($query,$i, strlen($query)-1);
                    }
                }
                $query = preg_replace('/[\s\t\n]+/',' ',$query);
                $query = str_replace('\n','',$query);
                $query = stripslashes($query);
                fwrite($log, "[".trim($scope)."] ".trim($query)."; \n");
            }
        }
        fclose($log);
    }
}

/**
 * The core OpenX class, providing handy methods that are useful everywhere!
 *
 * @package    OpenX
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA
{

    /**
     * A method to log debugging messages to the location configured by the user.
     *
     * Note: If the global variable $currentTimezone is set, where the array
     * is the result of OX_Admin_Timezones::getTimezone(), called BEFORE any
     * timezone information has been set (i.e. before the init script has been
     * called), then this method will ensure that all debug messages are logged
     * in the SERVER TIME ZONE, rather than the time zone that the software
     * happens to be running in (i.e. the current manager timezone, or UTC for
     * maintenance).
     *
     * @static
     * @param mixed $message     Either a string or a PEAR_Error object.
     * @param integer $priority  The priority of the message. One of:
     *                           PEAR_LOG_EMERG, PEAR_LOG_ALERT, PEAR_LOG_CRIT
     *                           PEAR_LOG_ERR, PEAR_LOG_WARNING, PEAR_LOG_NOTICE
     *                           PEAR_LOG_INFO, PEAR_LOG_DEBUG
     * @return boolean           True on success or false on failure.
     *
     * @TODO Logging to anything other than a file is probably broken - test!
     */
    static function debug($message = null, $priority = PEAR_LOG_INFO)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        global $tempDebugPrefix;
        // Logging is not activated
        if ($aConf['log']['enabled'] == false) {
            unset($GLOBALS['tempDebugPrefix']);
            return true;
        }
        // Is this a "no message" log?
        if (is_null($message) && $aConf['log']['type'] == 'file') {
            // Set the priority to the highest level, so it is always logged
            $priority = PEAR_LOG_EMERG;
        }
        // Deal with the config file containing the log level by
        // name or by number
        $priorityLevel = is_numeric($aConf['log']['priority']) ? $aConf['log']['priority'] :
            @constant($aConf['log']['priority']);
        if (is_null($priorityLevel)) {
            $priorityLevel = $aConf['log']['priority'];
        }
        if ($priority > $priorityLevel) {
            unset($GLOBALS['tempDebugPrefix']);
            return true;
        }
        // Grab DSN if we are logging to a database
        $dsn = ($aConf['log']['type'] == 'sql') ? Base::getDsn() : '';
        // Instantiate a logger object based on logging options
        $aLoggerConf = array(
            $aConf['log']['paramsUsername'],
            $aConf['log']['paramsPassword'],
            'dsn'        => $dsn,
            'mode'       => octdec($aConf['log']['fileMode']),
            'timeFormat' => '%b %d %H:%M:%S %z'
        );
        if (is_null($message) && $aConf['log']['type'] == 'file') {
            $aLoggerConf['lineFormat'] = '%4$s';
        } else if ($aConf['log']['type'] == 'file') {
            $aLoggerConf['lineFormat'] = '%1$s %2$s [%3$9s]  %4$s';
        }
        $ident = (!empty($GLOBALS['_MAX']['LOG_IDENT'])) ? $GLOBALS['_MAX']['LOG_IDENT'] : $aConf['log']['ident'];
        if (($ident == $aConf['log']['ident'] . '-delivery') && empty($aConf['deliveryLog']['enabled'])) {
            unset($GLOBALS['tempDebugPrefix']);
            return true;
        }
        if ($ident == $aConf['log']['ident'] . '-delivery') {
            $logFile = $aConf['deliveryLog']['name'];
            list($micro_seconds, $seconds) = explode(" ", microtime());
            $message = (round(1000 *((float)$micro_seconds + (float)$seconds))) - $GLOBALS['_MAX']['NOW_ms'] . 'ms ' . $message;
        } else {
            $logFile = $aConf['log']['name'];
        }

        $ident .= (!empty($GLOBALS['_MAX']['thread_id'])) ? '-' . $GLOBALS['_MAX']['thread_id'] : '';

        $oLogger = Log::singleton(
            $aConf['log']['type'],
            MAX_PATH . '/var/' . $logFile,
            $ident,
            $aLoggerConf
        );
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
        // Obtain backtrace information
        $aBacktrace = debug_backtrace();
        if ($aConf['log']['methodNames']) {
            // Show from four calls up the stack, to avoid the
            // showing the PEAR error call info itself
            $aErrorBacktrace = $aBacktrace[4];
            if (isset($aErrorBacktrace['class']) && $aErrorBacktrace['type'] && isset($aErrorBacktrace['function'])) {
                $callInfo = $aErrorBacktrace['class'] . $aErrorBacktrace['type'] . $aErrorBacktrace['function'] . ': ';
                $message = $callInfo . $message;
            }
        }
        // Show entire stack, line-by-line
        if ($aConf['log']['lineNumbers']) {
            foreach($aBacktrace as $aErrorBacktrace) {
                if (isset($aErrorBacktrace['file']) && isset($aErrorBacktrace['line'])) {
                    $message .=  "\n" . str_repeat(' ', 20 + strlen($aConf['log']['ident']) + strlen($oLogger->priorityToString($priority)));
                    $message .= 'on line ' . $aErrorBacktrace['line'] . ' of "' . $aErrorBacktrace['file'] . '"';
                }
            }
        }
        // Log messages in the local server timezone, if possible
        global $serverTimezone;
        if (!empty($serverTimezone)) {
            $currentTimezone = OX_Admin_Timezones::getTimezone();
            OA_setTimeZone($serverTimezone);
        }
        // Log the message
        if (is_null($message) && $aConf['log']['type'] == 'file') {
            $message = ' ';
        } else if (!is_null($tempDebugPrefix) && $aConf['log']['type'] == 'file') {
            $message = $tempDebugPrefix . $message;
        }
        $result = $oLogger->log(htmlspecialchars($message), $priority);
        // Restore the timezone
        if (!empty($currentTimezone)) {
            OA_setTimeZone($currentTimezone);
        }
        unset($GLOBALS['tempDebugPrefix']);
        return $result;
    }

    static function switchLogIdent($name = 'debug')
    {
        if ($name == 'debug') {
            $GLOBALS['_MAX']['LOG_IDENT'] = $GLOBALS['_MAX']['CONF']['log']['ident'];
        } else {
            $GLOBALS['_MAX']['LOG_IDENT'] = $GLOBALS['_MAX']['CONF']['log']['ident'] . '-' . $name;
        }
    }

    /**
     * A method to temporarily set the debug message prefix string. The string
     * is un-set when debug() is called.
     *
     * @param string $prefix The prefix to add to a message logged when the
     *                       debug() method is next called, in the event that
     *                       the logging is to a file.
     */
    static function setTempDebugPrefix($prefix)
    {
        global $tempDebugPrefix;
        $tempDebugPrefix = $prefix;
    }


    static function logMem($msg='', $peak=false)
    {
        /*if (isset($aConf['debug']['logmem']) && $aConf['debug']['logmem'])
        {*/
            $aConf = $GLOBALS['_MAX']['CONF'];
            $oLogger = &Log::singleton(
                $aConf['log']['type'],
                MAX_PATH . '/var/memory.log',
                $aConf['log']['ident'],
                array()
            );
            $pid = getmypid();
            //$msg.= ' MEMORY USAGE (% KB PID ): ' . `ps --pid $pid --no-headers -o%mem,rss,pid`;
            $mem = `ps --pid $pid --no-headers -orss`;
            $mem = round((memory_get_usage()/1048576),2). ' / ps '.$mem;
            $msg = '['.rtrim($mem,chr(10)).']('.$msg.')';
            $aLast = array_pop(debug_backtrace());
            if ($aLast['function']=='logMem')
            {
                $msg.= str_replace(MAX_PATH,'',$aLast['file'].' -> line '.$aLast['line']);
            }
            else
            {
                $msg.= $aLast['class'] . $aLast['type'] . $aLast['function'] . ': ';
            }
            $oLogger->log($msg, PEAR_LOG_INFO);
            if ($peak)
            {
                $peak = memory_get_peak_usage()/1048576;
                $oLogger->log('PEAK: '.$peak, PEAR_LOG_INFO);
            }
        //}
    }

    static function logMemPeak($msg='')
    {
        OA::logMem($msg, true);
    }

    /**
     * A method to obtain the current date/time, offset if required by the
     * user configured timezone.
     *
     * @static
     * @param string $format A PHP date() compatible formatting string, if
     *                       required. Default is "Y-m-d H:i:s".
     * @return string An appropriately formatted date/time string, representing
     *                the "current" date/time, offset if required.
     */
    static function getNow($format = null)
    {
        if (is_null($format)) {
            $format = 'Y-m-d H:i:s';
        }
        return date($format);
    }

    /**
     * A method to obtain the current date/time in UTC
     *
     * @static
     * @param string $format A PHP date() compatible formatting string, if
     *                       required. Default is "Y-m-d H:i:s".
     * @return string An appropriately formatted date/time string, representing
     *                the "current" date/time, offset if required.
     */
    static function getNowUTC($format = null)
    {
        if (is_null($format)) {
            $format = 'Y-m-d H:i:s';
        }
        return gmdate($format);
    }

    /**
     * A method to detect the available SSL enabling extensions
     *
     * @return mixed An array of the available extensions, or false if none is present
     */
    static function getAvailableSSLExtensions()
    {
        $aResult = array();

        if (extension_loaded('curl')) {
            $aCurl = curl_version();
            if (!empty($aCurl['ssl_version'])) {
                $aResult[] = 'curl';
            }
        }
        if (extension_loaded('openssl')) {
            $aResult[] = 'openssl';
        }

        return count($aResult) ? $aResult : false;
    }

    /**
     * A method to strip unwanted ending tags from an OpenX version string.
     *
     * @static
     * @param string $version The original version string.
     * @param array  $aAllow  An array of allowed tags
     * @return string The stripped version string.
     */
    static function stripVersion($version, $aAllow = null)
    {
        $allow = is_null($aAllow) ? '' : '|'.join('|', $aAllow);
        return preg_replace('/^v?(\d+.\d+.\d+(?:-(?:beta(?:-rc\d+)?|rc\d+'.$allow.'))?).*$/i', '$1', $version);
    }

    /**
     * A method to temporarily disable PEAR error handling by
     * pushing a null error handler onto the top of the stack.
     *
     * @static
     */
    static function disableErrorHandling()
    {
        PEAR::pushErrorHandling(null);
    }

    /**
     * A method to re-enable PEAR error handling by popping
     * a null error handler off the top of the stack.
     *
     * @static
     */
    static function enableErrorHandling()
    {
        // Ensure this method only acts when a null error handler exists
        $stack = &$GLOBALS['_PEAR_error_handler_stack'];
        list($mode, $options) = $stack[sizeof($stack) - 1];
        if (is_null($mode) && is_null($options)) {
            PEAR::popErrorHandling();
        }
    }

    /**
     * Returns the option from config or the default value if that option
     * do not exist.
     *
     * @param string $section  Section name
     * @param string $name     Option name
     * @param string $default  Default value to return if the option we
     *                         are looking for do not exist.
     * @return string
     */
    static function getConfigOption($section, $name, $default = null)
    {
        if (isset($GLOBALS['_MAX']['CONF'][$section][$name])) {
            return $GLOBALS['_MAX']['CONF'][$section][$name];
        }
        return $default;
    }
}
###END_STRIP_DELIVERY

?>
