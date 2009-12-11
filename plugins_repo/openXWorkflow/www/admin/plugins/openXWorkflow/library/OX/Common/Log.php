<?php

/**
 * A common facility for logging events related to the application. This class is 
 * responsible for resolving and using one common directory in which log files are stored.
 * 
 * Note: The current implementation assumes that VAR_PATH is defined and pointing
 * to the application's 'var' directory.
 */
class OX_Common_Log
{
    /**
     * A log for exceptions and other unexpected errors.
     */
    const LOG_ERROR = 'error';
    
    /**
     * A log for non-error information.
     */
    const LOG_INFO = 'info';
    
    /**
     * A log for debugging information.
     */
    const LOG_DEBUG = 'debug';
    
    /**
     * Default log used when no log is specified in a call to the log() method.
     */
    const LOG_DEFAULT = self::LOG_INFO;
    
    /**
     * A common array of all logs, key: log name (see constants above).
     */
    private static $logs;

    private static $logDirName = 'log';

    /**
     * Logs an error message to the specified log.
     */
    public static function error($exceptionOrMessage, $logName = self::LOG_ERROR)
    {
        self::log($exceptionOrMessage, Zend_Log::ERR, $logName);
    }


    /**
     * Logs a warning message to the specified log.
     */
    public static function warn($exceptionOrMessage, $logName = self::LOG_DEFAULT)
    {
        self::log($exceptionOrMessage, Zend_Log::WARN, $logName);
    }


    /**
     * Logs an info message to the specified log.
     */
    public static function info($exceptionOrMessage, $logName = self::LOG_INFO)
    {
        self::log($exceptionOrMessage, Zend_Log::INFO, $logName);
    }


    /**
     * Logs a debug message to the specified log.
     */
    public static function debug($exceptionOrMessage, $logName = self::LOG_DEBUG)
    {
        self::log($exceptionOrMessage, Zend_Log::DEBUG, $logName);
    }


    /**
     * Dumps the provided variable to the specified log with the specified logging priority.
     */
    public static function dump($variable, $priority = Zend_Log::DEBUG, $logName = self::LOG_DEBUG)
    {
        self::log(var_export($variable, true), $priority, $logName);
    }

    public static function backtrace($priority = Zend_Log::DEBUG, $logName = self::LOG_DEBUG)
    {
        $bt = debug_backtrace();
        $log = '';

        $commonPrefix = $bt[0]['file'];
        $lines = count($bt);
        for ($i = 1; $i < $lines; $i++) {
            $str = $bt[$i]['file'];
            if (strlen($str) > 0) {
                $commonPrefix = self::commonPrefix($commonPrefix, $bt[$i]['file']);
            }
        }
        $commonPrefixLen = strlen($commonPrefix);
        
        foreach ($bt as $line) {
            $log .= "\n  # " . substr($line['file'], $commonPrefixLen) . ':' . $line['line'] . ' ' . $line['class'] . '->' . $line['function'] . '()';
        }
        self::log('bt:' . $log, $priority, $logName);
    }

    private static function commonPrefix($s1, $s2)
    {
        $l = min(strlen($s1), strlen($s2));
        
        for($i = 0; $i < $l; $i++) {
            if (substr($s1, $i, 1) != substr($s2, $i, 1)) {
                return substr($s1, 0, $i); 
            }
        }
        
        return strlen($s1) < strlen($s2) ? $s1 : $s2;
    }
    
    /**
     * Logs the provided message to the specified log with the specified logging priority.
     */
    public static function log($exceptionOrMessage, $priority = Zend_Log::DEBUG, 
            $logName = self::LOG_DEFAULT)
    {
        self::getLog($logName)->log($exceptionOrMessage, $priority);
    }


    /**
     * Returns a Zend_Logger corresponding to the provided log name.
     * 
     * @return Zend_Log
     */
    public static function getLog($logName)
    {
        if (!isset(self::$logs[$logName])) {
            $log = new Zend_Log();
            $log->addWriter(new Zend_Log_Writer_Stream(VAR_PATH . '/' . self::$logDirName . '/' . $logName . '.log'));
            self::$logs[$logName] = $log;
        }
        
        return self::$logs[$logName];
    }
}
