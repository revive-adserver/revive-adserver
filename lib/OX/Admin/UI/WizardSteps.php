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

/**
 * @package OX_Admin_UI
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_UI_WizardSteps 
{
    /**
     * Renders wizard steps progress. Given param should be an associative array 
     * of stepId => stepName entries. 
     * eg. * ('step1'=> 'Welcome!', 'step2' => 'Do sth', 'step3' => 'Done')
     *
     * @param array $aSteps
     */    
    public static function wizardSteps($aParams, &$smarty)
    {
        $currentStepId = $aParams['current']; 
        $aSteps = $aParams['steps'];
        $addStepNo = isset($aParams['addStepNumber']) ? $aParams['addStepNumber'] : true;
    
        $aWizardSteps = array();
        $stepCount = count($aSteps);
        $i = 0;
        if ($aSteps) {
            foreach ($aSteps as $stepId => $stepName) {
                $currentReached = $currentReached ? $currentReached : $stepId == $currentStepId;
                $current = $stepId == $currentStepId;
    
                if ($current && $i > 0) {
                    $aWizardSteps[$i-1]['beforeCurrent'] = true;   
                }
                
                $aStep = array(
                    'id' => $stepId, 
                    'name' => $addStepNo ? ($i+1).'. '.$stepName : $stepName, 
                    'current' => $current,
                    'done' => !$currentReached,
                    'beforeCurrent' => false //this will be updated when current is reached
                );
                
                $aWizardSteps[] = $aStep;
                $i++;
            }
        }
        
        $smarty->assign('_aSteps', $aWizardSteps);
        $result = $smarty->fetch(MAX_PATH . '/www/admin/templates/wizard-steps.html');
        $smarty->clear_assign('_aSteps'); 
        
        return $result; 
    }
}
