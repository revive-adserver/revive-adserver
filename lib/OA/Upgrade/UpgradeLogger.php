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

/**
 * OpenXUpgrade Class
 *
 */
class OA_UpgradeLogger
{
    public $aErrors = [];
    public $aMessages = [];
    public $warningExists = false;
    public $errorExists = false;
    public $logFile;

    /**
     * @var array
     */
    private $logBuffer = [];

    /**
     * php5 class constructor
     *
     * simpletest throws a BadGroupTest error
     * Redefining already defined constructor for class Openads_DB_Upgrade
     * when both constructors are present
     *
     */
//    function __construct()
//    {
//    }

    /**
     * php4 class constructor
     *
     * @return boolean
     */
    public function __construct()
    {
        //this->__construct();
        $this->logFile = MAX_PATH . "/var/install.log";
    }

    public function setLogFile($logfile)
    {
        $this->logFile = MAX_PATH . "/var/{$logfile}";
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }
        $this->_logWrite(date('Y-m-d h:i:s'));
    }

    /**
     * check for a Pear error
     * log the error
     * returns true if pear error, false if not
     *
     * @param mixed $result
     * @param string $message
     * @return boolean
     */
    public function isPearError($result, $message = 'omg it all went PEAR shaped!')
    {
        if (PEAR::isError($result)) {
            $this->logError($message . ' ' . $result->getUserInfo());
            return true;
        }
        return false;
    }

    public function logClear()
    {
        $this->aMessages = [];
        $this->aErrors = [];
        $this->errorExists = false;
        $this->warningExists = false;
    }

    /**
     * write a message to the logfile
     *
     * @param string $message
     */
    public function log($message)
    {
        $this->aMessages[] = $message;
        $this->_logWrite($message);
    }

    public function logOnly($message)
    {
        $this->_logWrite($message);
    }

    /**
     * write a warning to the log file
     *
     * @param string $message
     */
    public function logWarning($message)
    {
        $this->aMessages[] = "#> {$message}";
        $this->_logWrite("#> {$message}");
        $this->warningExists = true;
    }

    /**
     * write an error to the log file
     *
     * @param string $message
     */
    public function logError($message)
    {
        $this->log("#! {$message}");
        $this->errorExists = true;
    }

    /**
     * Writes an error message to the log file if $message is not empty.
     *
     * @param string $message
     */
    public function logErrorUnlessEmpty($message)
    {
        if (!empty($message)) {
            $this->logError($message);
        }
    }

    public function _logWrite($message)
    {
        if (empty($this->logFile)) {
            $this->logBuffer[] = $message;
        } else {
            $log = fopen($this->logFile, 'a');
            if (!$log) {
                return;
            }
            if (count($this->logBuffer)) {
                $message = join("\n", $this->logBuffer);
                $this->logBuffer = [];
            }
            fwrite($log, "{$message}\n");
            fclose($log);
        }
    }

    public function getLogfilesList()
    {
        $aFiles = [];
        $dh = opendir(MAX_PATH . '/var');
        if ($dh) {
            while (false !== ($file = readdir($dh))) {
                $aMatches = [];
                if (preg_match('/openads_upgrade_[\w\W\d]+\.log/', $file, $aMatches)) {
                    $aFiles[] = basename($file);
                }
            }
        }
        closedir($dh);
        return $aFiles;
    }

    public function deleteLogFile()
    {
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }
    }
}
