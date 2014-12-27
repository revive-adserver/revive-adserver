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
 * A holder class for install status based on the results returned by OA_Upgrade
 *
 * @package OX_Admin_UI
 * @subpackage Install
 */
class OX_Admin_UI_Install_InstallStatus
{
    /**
     * @var boolean
     */
    private $isRecovery = false;

    /**
     * @var boolean
     */
    private $isInstall = false;

    /**
     * @var boolean
     */
    private $isUpgrade = false;

    /**
     * @var boolean
     */
    private $isUpToDate = false;


    public function __construct($oUpgrader)
    {
        if ($oUpgrader->isRecoveryRequired()) {
             $this->isRecovery = true;
        }
        else {
            if ($oUpgrader->isFreshInstall()) {
                $this->isInstall = true;
            }
            else {
                PEAR::pushErrorHandling ( null );
                $oUpgrader->canUpgradeOrInstall();
                PEAR::popErrorHandling ();
                if ($oUpgrader->existing_installation_status == OA_STATUS_CURRENT_VERSION) {
                    $this->isUpToDate = true;
                }
                else {
                    $this->isUpgrade = true;
                }
            }
        }
    }


    /**
     * @return boolean
     */
    public function isInstall()
    {
        return $this->isInstall;
    }


    /**
     * @return boolean
     */
    public function isRecovery()
    {
        return $this->isRecovery;
    }


    /**
     * @return boolean
     */
    public function isUpgrade()
    {
        return $this->isUpgrade;
    }


    /**
     * @return boolean
     */
    public function isUpToDate()
    {
        return $this->isUpToDate;
    }
}

?>