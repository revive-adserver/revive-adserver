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

require_once MAX_PATH . '/lib/OX/Admin/UI/SessionStorage.php';

/**
 * @package OX_Admin_UI
 */
class OX_Admin_UI_Wizard
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


    /*
     * An array of $stepId => array entries. Metadata is an addiotional information
     * stored about step. This is not step data, this might eg. info if
     * step should be secure etc.
     *
     * @var array
     */
    private $aMetadata;

    /**
     * Current step id
     *
     * @var string
     */
    private $currentStepId;


    /**
     * A holder for wizard data
     *
     * @var OX_Admin_UI_Storage
     */
    private $oStorage;


    /**
     * Creates wizard object
     *
     * @param string $id identifier used by wizard internally when storing/retrieving its data
     * @param string $aOptions options array recognizes 'steps', 'current' and 'stepsMetadata' parameters atm.
     * @param OX_Admin_UI_Storage $oStorage optional storage to be used by wizard if not specified will use OX_Admin_UI_SessionStorage by default
     */
    public function __construct($id, $aOptions = null, $oStorage = null)
    {
        $this->id  = "OX_UI_Install_Wizard-".$id;
        if (isset($aOptions['steps'])) {
            if (!is_array($aOptions['steps']) || empty($aOptions['steps'])) {
                throw new Exception('Please provide an array of steps');
            }

            $this->setSteps($aOptions['steps']);
            if (isset($aOptions['current'])) {
                $this->setCurrentStep($aOptions['current']);
            }
            else {
                $this->setCurrentStep($this->aStepIds[0]);
            }

            if (isset($aOptions['stepsMetadata'])) {
                $this->aMetadata = $aOptions['stepsMetadata'];
            }

        }
        if (empty($oStorage)) {
            $oStorage = new OX_Admin_UI_SessionStorage();
        }
        $this->oStorage = $oStorage;
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
            throw new Exception('Please provide an array of steps');
        }

        $this->aStepIds = array_keys($aSteps);
        $this->aSteps = $aSteps;
        $this->setCurrentStep($this->aStepIds[0]);
    }


    /**
     * Return wizard steps
     *
     * @return array of stepId => $stepName entries
     */
    public function getSteps()
    {
        return $this->aSteps;
    }


    /**
     * Sets the current step id
     *
     * @param string $stepId
     */
    public function setCurrentStep($stepId)
    {
        if (!in_array($stepId, $this->aStepIds)) {
            throw new Exception('Unable to set current step. Unknown step: '.$stepId);
        }
        $this->currentStepId = $stepId;
    }


    /**
     * Gets the current step id
     *
     * @param string  $stepId
     */
    public function getCurrentStep()
    {
        return $this->currentStepId;
    }


    public function getFirstStep()
    {
        return !empty($this->aStepIds) ? $this->aStepIds[0] : null;
    }


    public function getLastStep()
    {
        return !empty($this->aStepIds)
            ? $this->aStepIds[count($this->aStepIds) - 1]
            : null;
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
        $aStepData = $storage['stepData'];


        return !empty($aStepData) && isset($aStepData[$stepId]) ? $aStepData[$stepId] : null;
    }


    public function setStepData($aData, $stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        $storage = $this->getWizardData();

        $aStepData = $storage['stepData'];
        $aStepData = !empty($aStepData) ? $aStepData : array();
        $aStepData[$stepId] = $aData;
        $storage['stepData'] = $aStepData;

        $this->setWizardData($storage);
    }


    /**
     * Retrieves wizard step metdatada information (if any)
     *
     * @param string $stepId
     * @return mixed step metadata
     */
    public function getStepMeta($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;

        return isset($this->aMetadata[$stepId]) ? $this->aMetadata[$stepId] : null;
    }


    public function setStepMeta($aData, $stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;

        $this->aMetadata[$stepId] = $aData;
    }


    /**
     * Marks step internally as completed. If $stepid is not given marks current
     * step as completed.
     *
     * Please note that this assumes wizard steps have been marked consecutively
     * as completed.
     * Wizard itself does not ensure continuity of the completed steps, ie. does
     * not check if previous steps have been marked as completed already.
     *
     * @param string $stepId step id
     */
    public function markStepAsCompleted($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        $storage = $this->getWizardData();

        $aCompleted = $storage['completedSteps'];
        $aCompleted = !empty($aCompleted) ? $aCompleted : array();
        $aCompleted[$stepId] = true;
        $storage['completedSteps'] = $aCompleted;

        $this->setWizardData($storage);
    }


    /**
     * Checks if step is marked as completed. If $stepid is not given marks current
     * step as completed.
     *
     * Please note that this assumes wizard steps have been marked consecutively
     * as completed.
     * Wizard itself does not ensure continuity of the completed steps, ie. does
     * not check if previous steps have been marked as completed already.
     *
     * @param unknown_type $stepId
     * @return unknown
     */
    public function isStepCompleted($stepId = null)
    {
        $stepId = empty($stepId) ? $this->currentStepId : $stepId;
        $storage = $this->getWizardData();
        $aCompleted = $storage['completedSteps'];

        return !empty($aCompleted) && $aCompleted[$stepId] === true;
    }


    /**
     * Returns the id of the last step marked as completed. Starts at last step and
     * goes backward.
     *
     * Please note that this assumes wizard steps have been marked consecutively
     * as completed.
     * Wizard itself does not ensure continuity of the completed steps, ie. does
     * not check if previous steps have been marked as completed already.
     *
     * @return string stepId or null if not step marked as completed found
     */
    public function getLastCompletedStep()
    {
        $stepId = empty($this->currentStepId) ? $this->currentStepId : $this->getLastStep();

        $lastCompleted = null;
        while($stepId != null) {
            $completed = $this->isStepCompleted($stepId);
            if ($completed) {
                $lastCompleted = $stepId;
                break;
            }
            $stepId = $this->getPreviousStep($stepId);
        }

        return $lastCompleted;
    }


    public function isStep($stepId)
    {
        return in_array($stepId, $this->aStepIds);
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
        if (!$this->isStep($stepId)) {
            return false;
        }

        $prevStep = $this->getPreviousStep($stepId);

        return $prevStep == null || $this->isStepCompleted($prevStep);
    }

    /**
     * Resets the wizard into a pristine form. That means all step data and wizard
     * progres is discarded
     */
    public function reset()
    {
        $storage = $this->getWizardData();
        $storage['completedSteps'] = null;
        $storage['stepData'] = null;
        $this->setWizardData($storage);
    }


    protected function getWizardData()
    {
        $oStorage = $this->getStorage();
        $wizardData = $oStorage->get($this->id);
        if (empty($wizardData)) {
            $wizardData = array();
            $this->setWizardData($wizardData);
        }

        return $wizardData;
    }


    protected function setWizardData($wizardData)
    {
        $this->getStorage()->set($this->id, $wizardData);
    }


    /**
     * @return OX_Admin_UI_Storage
     */
    protected function getStorage()
    {
        return $this->oStorage;
    }

}

?>