<?php


class OX_Workflow_UI_WizardManager 
{
    /**
     * Wizard id
     *
     * @var string
     */
    private $id;
    
    /**
     * An array of $stepId entries
     *
     * @var array
     */
    private $aStepIds;
    
    /*
     * An array of $stepId => $stepName entries
     * @var array
     */
    private $aSteps;
    
    /**
     * Current step id
     *
     * @var string
     */
    private $currentStepId;
    
    public function __construct($id, $aOptions = null)
    {
        $this->id  = "OX_Workflow_UI_WizardManager-".$id;
        if ($aOptions) {        
            if (isset($aOptions['steps'])) {
                if (!is_array($aOptions['steps']) || empty($aOptions['steps'])) {
                    throw new Zend_Exception('Please provide an array of steps');
                }
                
                $this->setSteps($aOptions['steps']);
                if (isset($aOptions['current'])) {
                    $this->setCurrentStep($aOptions['current']);
                }
                else {
                    $this->setCurrentStep($this->aStepIds[0]);
                }
            }
        }        
    }
    
    /**
     * Set the wizard steps. Given param should be an associative array of stepId => stepName entries. 
     * eg. * ('step1'=> 'Welcome!', 'step2' => 'Do sth', 'step3' => 'Done')
     *
     * @param array $aSteps
     */
    public function setSteps($aSteps)
    {
        if (!is_array($aSteps) || empty($aSteps)) {
            throw new Zend_Exception('Please provide an array of steps');
        }
        
        $this->aStepIds = array_keys($aSteps);
        $this->aSteps = $aSteps;
        $this->setCurrentStep($this->aStepIds[0]);
    }
    
    
    public function getSteps()
    {
        return $this->aSteps;    
    }
    
    
    public function setCurrentStep($stepId)
    {
        if (!in_array($stepId, $this->aStepIds)) {
            throw new Zend_Exception('Unable to set current step. Unknown step: '.$stepId);                        
        }
        $this->currentStepId = $stepId;
    }
    
    
    public function setStepData($aData, $step = null)
    {
        $step = empty($step) ? $this->currentStepId : $step;
        $storage = $this->getWizardData();
        
        $aStepData = $storage->stepData;
        $aStepData = !empty($aStepData) ? $aStepData : array();
        $aStepData[$step] = $aData;
        $storage->stepData = $aStepData;
//        var_dumpp($storage->stepData);
    }
    
    
    public function getFirstStep()
    {
        return !empty($this->aStepIds) ? $this->aStepIds[0] : null; 
    }
    
    
    public function getNextStep($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        
        $idx = array_search($stepId, $this->aStepIds);
        
        if ($idx === false || $idx == count($this->aStepIds) - 1) {
            return null;
        }
        
        return $this->aStepIds[$idx + 1];
    }
    
    
    public function getPreviousStep($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        
        $idx = array_search($stepId, $this->aStepIds);
        
        if ($idx === false || $idx == 0) {
            return null;
        }
        
        return $this->aStepIds[$idx - 1];
    }
    
    
    public function getStepName($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        
        return $this->aStepNames[$stepId];
    }
    
    
    public function getStepData($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        
        $storage = $this->getWizardData();
        $aStepData = $storage->stepData;
         
        
        return !empty($aStepData) && isset($aStepData[$stepId]) ? $aStepData[$stepId] : null;
    }
    
    
    public function markStepAsCompleted($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        $storage = $this->getWizardData();
        
        $aCompleted = $storage->completedSteps;
        $aCompleted = !empty($aCompleted) ? $aCompleted : array();
        $aCompleted[$stepId] = true;
        $storage->completedSteps = $aCompleted;
    }
        
    
    public function isStepCompleted($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        $storage = $this->getWizardData();
        $aCompleted = $storage->completedSteps;
        
        return !empty($aCompleted) && $aCompleted[$stepId] === true;    
    }
    
    
    /**
     * Indicates whether step is reachable.
     * Default implementation assumes that previous step has been makred as completed
     * with 'markStepAsCompleted' function. Also, first step is always reachable
     * by default.
     *
     * @param string $stepId
     * @return boolean
     */
    public function checkStepReachable($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        $storage = $this->getWizardData();
        
        $aCompleted = $storage->completedSteps;
        $prevStep = $this->getPreviousStep($stepId);
        
        return $prevStep == null || $this->isStepCompleted($prevStep); 
    }    
    
    
    protected function getWizardData()
    {
        $sessionStore = new Zend_Session_Namespace($this->id);
        return $sessionStore;
    }
    
    
    /**
     * Resets the wizard into a pristine form. That means all step data and wizard
     * progres is discarded 
     */
    public function reset()
    {
        $storage = $this->getWizardData();
        $storage->completedSteps = null;
        $storage->stepData = null;
    }
    
}

?>