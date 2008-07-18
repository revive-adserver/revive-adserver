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

require_once MAX_PATH . '/lib/pear/Log.php';
require_once MAX_PATH . '/lib/pear/PEAR.php';

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
     * Note: If the global variable $aCurrentTimezone is set, where the array
     * is the result of OA_Admin_Timezones::getTimezone(), called BEFORE any
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
    function debug($message = null, $priority = PEAR_LOG_INFO)
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
        $oLogger = &Log::singleton(
            $aConf['log']['type'],
            MAX_PATH . '/var/' . $aConf['log']['name'],
            $aConf['log']['ident'],
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
        // Obtain backtrace information, if supported by PHP
        if (version_compare(phpversion(), '4.3.0') >= 0) {
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
        }
        // Log messages in the local server timezone, if possible
        global $aServerTimezone;
        if (!empty($aServerTimezone)) {
            // Ensure that class exists, we may be running from the
            // delivery engine, when it is running-auto maintenance
            // (inclusion of class okay, as will now be in
            // post-delivery mode)
            if (!class_exists('OA_Admin_Timezones')) {
                require_once MAX_PATH . '/lib/OA/Admin/Timezones.php';
            }
            $aCurrentTimezone = OA_Admin_Timezones::getTimezone();
            OA_setTimeZone($aServerTimezone['tz']);
        }
        // Log the message
        if (is_null($message) && $aConf['log']['type'] == 'file') {
            $message = ' ';
        } else if (!is_null($tempDebugPrefix) && $aConf['log']['type'] == 'file') {
            $message = $tempDebugPrefix . $message;
        }
        $result = $oLogger->log($message, $priority);
        // Restore the timezone
        if (!empty($aCurrentTimezone)) {
            OA_setTimeZone($aCurrentTimezone['tz']);
        }
        unset($GLOBALS['tempDebugPrefix']);
        return $result;
    }

    function switchLogFile($name='debug')
    {
        $newLog = $name.'.log';
/*        if ($name <> 'debug')
        {
            $newLog = $name.OA::getNow('Y_m_d_h_i_s').'.log';
        }
*/        $oldLog = $GLOBALS['_MAX']['CONF']['log']['name'];
        if ($newLog != $oldLog)
        {
            OA::debug('Switching to logfile '.$newLog, PEAR_LOG_INFO);
            $GLOBALS['_MAX']['CONF']['log']['name'] = $newLog;
        }
        return $oldLog;
    }

    /**
     * A method to temporarily set the debug message prefix string. The string
     * is un-set when debug() is called.
     *
     * @param string $prefix The prefix to add to a message logged when the
     *                       debug() method is next called, in the event that
     *                       the logging is to a file.
     */
    function setTempDebugPrefix($prefix)
    {
        global $tempDebugPrefix;
        $tempDebugPrefix = $prefix;
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
    function getNow($format = null)
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
    function getNowUTC($format = null)
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
    function getAvailableSSLExtensions()
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
    function stripVersion($version, $aAllow = null)
    {
        $allow = is_null($aAllow) ? '' : '|'.join('|', $aAllow);
        return preg_replace('/^v?(\d+.\d+.\d+(?:-(?:beta(?:-rc\d+)?|rc\d+'.$allow.'))?).*$/', '$1', $version);
    }

    /**
     * A method to temporarily disable PEAR error handling by
     * pushing a null error handler onto the top of the stack.
     *
     * @static
     */
    function disableErrorHandling()
    {
        PEAR::pushErrorHandling(null);
    }

    /**
     * A method to re-enable PEAR error handling by popping
     * a null error handler off the top of the stack.
     *
     * @static
     */
    function enableErrorHandling()
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
    function getConfigOption($section, $name, $default = null)
    {
        if (isset($GLOBALS['_MAX']['CONF'][$section][$name])) {
            return $GLOBALS['_MAX']['CONF'][$section][$name];
        }
        return $default;
    }
}

?>