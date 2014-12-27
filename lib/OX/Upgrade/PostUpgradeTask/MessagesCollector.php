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
 * Class to help collecting messages from Post Upgrade Task,
 * messages are logged to given OA_UpgradeLogger and stored locally,
 * so we don't need to clear OA_UpgradeLogger
 *
 * @package    OpenXUpgrade
 */
class OX_Upgrade_PostUpgradeTask_MessagesCollector
{
    /**
     * @var array
     */
    protected $aInfos;

    /**
     * @var array
     */
    protected $aErrors;

    /**
     * @var OA_UpgradeLogger
     */
    protected $oUpgradeLogger;


    /**
     * Constructor
     *
     * @param OA_UpgradeLogger $oUpgradeLogger
     */
    public function __construct(OA_UpgradeLogger &$oUpgradeLogger)
    {
        $this->aMessages = array();
        $this->aErrors   = array();
        $this->oUpgradeLogger = $oUpgradeLogger;
    }


    /**
     * Log info message
     *
     * @param string $message
     */
    public function logInfo($message)
    {
        $this->aInfos[] = $message;
        $this->oUpgradeLogger->logOnly($message);
    }


    /**
     * Log error message
     *
     * @param string $message
     */
    public function logError($message)
    {
        $this->aErrors[] = $message;
        $this->oUpgradeLogger->logError($message);
    }


    /**
     * Get all error messages
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->aErrors;
    }


    /**
     * Get all info messages
     *
     * @return array
     */
    public function getInfos()
    {
        return $this->aInfos;
    }


    /**
     * Check if there was errors logged
     *
     * @return bool
     */
    public function wasErrors()
    {
        return count($this->aErrors)>0;
    }
}