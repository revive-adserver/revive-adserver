<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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
$Id$
*/
require_once MAX_PATH . '/lib/OX/Admin/UI/Wizard.php';
require_once MAX_PATH . '/lib/OX/Dal/Market/MarketPluginTools.php';

/**
 * @package OX_Admin_UI
 * @subpackage Install
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_Install_Wizard
    extends OX_Admin_UI_Wizard  
{
    public function __construct($oInstallStatus, $currentStepId = null)
    {
        $oStorage = OX_Admin_UI_Install_InstallUtils::getSessionStorage();        
        $aSteps = $this->initSteps($oInstallStatus, $oStorage);
        
        $aParams = array(
                'steps' => $aSteps['steps'],      
                'stepsMetadata' => $aSteps['meta'],
                'current' => $currentStepId,
        ); 
        
        parent::__construct('install', $aParams, $oStorage);
    }
    
    
    /**
     * Builds step array. Uses information from InstallStatus (eg. if it's upgrade
     * or install) and also storage properties 'isMarketStepVisible', 'isLoginStepVisible'
     *
     * @param OX_Admin_UI_Install_InstallStatus $oStatus
     * @param OX_Admin_UI_Storage $oStorage
     * @return array array('steps' => $aSteps, 'meta' => $aMeta);
     */
    protected function initSteps($oStatus, $oStorage)
    {
        $aMeta = array();
        
        if ($oStatus->isRecovery()) {
            $aSteps = array(
                'recovery' => 'Recovery',
                'finish' => 'Finish' 
            );
        }
        if ($oStatus->isInstall()) {
            $aSteps = array(
                'welcome' => 'Welcome',
                'register' => 'Registration',
                'database' => 'Database', 
                'configuration' => 'Configuration', 
                'finish' => 'Finish' 
            );
            $aMeta = array(
                'finish' => array('secured' => true) 
            );
        }
        else if ($oStatus->isUpgrade()) {
            $aSteps = array(
                'welcome' => 'Welcome',
                'login' => 'Administrator Login',
                'register' => 'Registration',
                'database' => 'Database', 
                'configuration' => 'Configuration', 
                'finish' => 'Finish' 
            );

            $aMeta = array(
                'welcome' => array('secured' => false),
                'login' => array('secured' => false),
                'register' => array('secured' => true),
                'database' => array('secured' => true), 
                'configuration' => array('secured' => true),
                'finish' => array('secured' => true) 
            );

            
            //hide steps which are not required
            if (!$oStorage->get('isMarketStepVisible')) {
                unset($aSteps['register']);
                unset($aMeta['register']);
            }
            if (!$oStorage->get('isLoginStepVisible')) {
                unset($aSteps['login']); 
                unset($aMeta['login']);
            }
            if (!$oStorage->get('isConfigStepVisible')) {
                unset($aSteps['configuration']); 
                unset($aMeta['configuration']);
            }
        }
        else if ($oStatus->isUpToDate()) {
                $aSteps = array(
                    'uptodate' => 'Up To Date'
                );
        }

        return array('steps' => $aSteps, 'meta' => $aMeta);
    }
}

?>