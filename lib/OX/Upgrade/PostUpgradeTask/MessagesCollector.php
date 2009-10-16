<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: MessagesCollector.php 43350 2009-09-17 12:55:59Z lukasz.wikierski $
*/

/**
 * Class to help collecting messages from Post Upgrade Task,
 * messages are logged to given OA_UpgradeLogger and stored locally,
 * so we don't need to clear OA_UpgradeLogger
 * 
 * @package    OpenXUpgrade
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
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