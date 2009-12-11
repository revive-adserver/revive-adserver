<?php

class OX_UI_View_Helper_WizardSteps 
    extends OX_UI_View_Helper_WithViewScript
{
    /**
     * Renders wizard steps progress. Given param should be an associative array 
     * of stepId => stepName entries. 
     * eg. * ('step1'=> 'Welcome!', 'step2' => 'Do sth', 'step3' => 'Done')
     *
     * @param array $aSteps
     */    
    public static function wizardSteps($aSteps, $currentStepId)
    {
        $aWizardSteps = array();
        $stepCount = count($aSteps);
        $i = 0;
        foreach ($aSteps as $stepId => $stepName) {
            $currentReached = $currentReached ? $currentReached : $stepId == $currentStepId;
            $current = $stepId == $currentStepId;

            if ($current && $i > 0) {
                $aWizardSteps[$i-1]['beforeCurrent'] = true;   
            }
            
            $aStep = array(
                'id' => $stepId, 
                'name' => $stepName, 
                'current' => $current,
                'done' => !$currentReached,
                'beforeCurrent' => false //this will be updated when current is reached
            );
            
            $aWizardSteps[] = $aStep;
            $i++;
        }
        
        
        
        return parent::renderViewScript("wizard-steps.html", 
            array (
                'aSteps' => $aWizardSteps 
            ));
    }
}
