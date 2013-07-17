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
 * @package    OpenXDll
 * @author     David Keen <david.keen@openx.org>
 *
 */

require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/VariableInfo.php';
require_once MAX_PATH . '/lib/max/Dal/Admin/Affiliates.php';

class OA_Dll_Variable extends OA_Dll
{
    const ERROR_UNKNOWN_ID = 'Unknown variableId Error';
    const ERROR_DELETE = 'Error deleting variable';
    const ERROR_INVALID_DATA_TYPE = 'Invalid data type';
    const ERROR_INVALID_PURPOSE = 'Invalid purpose';

    /**
     * Performs data validation for a variable. The method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @param OA_Dll_VariableInfo &$oVariableInfo
     *
     * @return boolean  Returns false if fields are not valid and true if valid.
     *
     */
    private function validate(&$oVariableInfo)
    {
        if (isset($oVariableInfo->variableId)) {
            // When modifying a variable, check correct field types are used and the variableId exists.
            if (!$this->checkStructureRequiredIntegerField($oVariableInfo, 'variableId') ||
                !$this->checkIdExistence('variables', $oVariableInfo->variableId) ||
                !$this->checkStructureNotRequiredStringField($oVariableInfo, 'variableName', 250)) {

                return false;
            }
        } else {
            // Adding a variable.
            if (!$this->checkStructureRequiredIntegerField($oVariableInfo, 'trackerId') ||
                !$this->checkIdExistence('trackers', $oVariableInfo->trackerId) ||
                !$this->checkStructureRequiredStringField($oVariableInfo, 'variableName', 250)) {

                return false;
            }
        }

        if (!$this->checkStructureNotRequiredStringField($oVariableInfo, 'description', 250) ||
            !$this->checkStructureNotRequiredStringField($oVariableInfo, 'dataType') ||
            !$this->checkDataType($oVariableInfo) ||
            !$this->checkStructureNotRequiredStringField($oVariableInfo, 'purpose') ||
            !$this->checkPurpose($oVariableInfo) ||
            !$this->checkStructureNotRequiredBooleanField($oVariableInfo, 'rejectIfEmpty') ||
            !$this->checkStructureNotRequiredBooleanField($oVariableInfo, 'isUnique') ||
            !$this->checkStructureNotRequiredIntegerField($oVariableInfo, 'uniqueWindow') ||
            !$this->checkStructureNotRequiredStringField($oVariableInfo, 'variableCode', 255) ||
            !$this->checkStructureNotRequiredBooleanField($oVariableInfo, 'hidden')) {

            return false;
        }
        return true;
    }

    private function checkDataType($oStructure)
    {
        $fieldName = 'dataType';
        $aValidDataTypes = array('numeric', 'string', 'date');

        if (isset($oStructure->$fieldName) && !in_array($oStructure->$fieldName, $aValidDataTypes)) {
            $this->raiseError(self::ERROR_INVALID_DATA_TYPE);
            return false;
        }
        return true;
    }

    private function checkPurpose($oStructure)
    {
        $fieldName = 'purpose';
        $aValidPurposes = array('basket_value', 'num_items', 'post_code');

        if (isset($oStructure->$fieldName) && !in_array($oStructure->$fieldName, $aValidPurposes)) {
            $this->raiseError(self::ERROR_INVALID_PURPOSE);
            return false;
        }
        return true;
    }


    /**
     * This method modifies an existing variable. Undefined fields do not changed
     * and defined fields with a NULL value also remain unchanged.
     *
     * @param OA_Dll_VariableInfo &$oVariableInfo <br />
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> variableName, trackerId<br />
     *          <b>Optional properties:</b> description, dataType, purpose, rejectIfEmpty, isUnique, uniqueWindow, variableCode, hidden<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> variableId<br />
     *          <b>Optional properties:</b> variableName, description, dataType, purpose, rejectIfEmpty, isUnique, uniqueWindow, variableCode, hidden<br />
     *
     * @return boolean  True if the operation was successful
     *
     */
    public function modify(&$oVariableInfo)
    {
        if (!isset($oVariableInfo->variableId)) {
            // Add
            $oVariableInfo->setDefaultForAdd();

            // Check permission for the tracker.
            if (isset($oVariableInfo->trackerId)) {
                if (!$this->checkPermissions(
                        array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
                        'trackers', $oVariableInfo->trackerId)) {
                    return false;
                }
                // We need the trackerId so we can set the variableCode correctly.
                $trackerId = $oVariableInfo->trackerId;
            }
        } else {
            // Modify
            if (!$this->checkIdExistence('variables', $oVariableInfo->variableId)) {
                $this->raiseError(self::ERROR_UNKNOWN_ID);
                return false;
            }
            if (!$this->checkPermissions(array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
                'variables', $oVariableInfo->variableId)) {
                return false;
            }
            $doVariable = OA_Dal::staticGetDO('variables', $oVariableInfo->variableId);
            $trackerId = $doVariable->trackerid;
        }

        if ($this->validate($oVariableInfo)) {
            // We need the tracker to set the variablecode properly.
            $doTracker = OA_Dal::staticGetDO('trackers', $trackerId);

            $aVariableData = $oVariableInfo->getDataObjectArray();
            $doVariable = OA_Dal::factoryDO('variables');

            if (!isset($oVariableInfo->variableId)) {
                // Add
                $doVariable->setFrom($aVariableData);

                // Set the variableCode based on tracker variable method
                $doVariable->setCode($doTracker->variablemethod);
                $oVariableInfo->variableId = $doVariable->insert();
            } else {
                // Modify
                $doVariable->get($oVariableInfo->variableId);
                $doVariable->setFrom($aVariableData);
    
                // Set the variableCode based on tracker variable method
                $doVariable->setCode($doTracker->variablemethod);
                $doVariable->update();
            }

            // Hide this variable to certain websites
            // Confusingly, we do this by making it visible to the other websites.
            if (!empty($oVariableInfo->hiddenWebsites)) {

                // If hidden to websites, the hidden flag must be set.
                $oVariableInfo->hidden = true;

                // First clear any existing rows
                $this->clearVisibleWebsites($oVariableInfo->variableId);

                $aLinkedWebsites = $this->getLinkedWebsites($trackerId);
                foreach ($aLinkedWebsites as $websiteId) {
                    if (!in_array($websiteId, $oVariableInfo->hiddenWebsites)) {
                        $this->addVisibleWebsite($oVariableInfo->variableId, $websiteId);
                    }
                }
            }

            if ($oVariableInfo->isUnique) {
                // set the is_unique value for all OTHER tracker variables to false
                $this->updateOtherVariablesIsUniqueValue($oVariableInfo->variableId, $trackerId);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes an existing variable.
     *
     * @param integer $variableId  The ID of the tracker to delete
     * @return boolean  True if the operation was successful
     */
    public function delete($variableId)
    {
        if (!$this->checkIdExistence('variables', $variableId)) {
            $this->raiseError(self::ERROR_UNKNOWN_ID);
            return false;
        }

        if (!$this->checkPermissions(
            array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
            'variables', $variableId)) {

            return false;
        }

        $doVariable = OA_Dal::factoryDO('variables');
        $doVariable->variableid = $variableId;
        $result = $doVariable->delete();

        if ($result) {
            return true;
        } else {
            $this->raiseError(self::ERROR_DELETE);
            return false;
        }
    }

    /**
     * Gets variable info
     *
     * @param int $variableId
     * @param OA_Dll_TrackerInfo $oVariableInfo
     * @return boolean
     */
    public function getVariable($variableId, &$oVariableInfo)
    {
        if ($this->checkIdExistence('variables', $variableId)) {
            if (!$this->checkPermissions(null, 'variables', $variableId)) {
                return false;
            }
            $doVariable = OA_Dal::factoryDO('variables');
            $doVariable->get($variableId);
            $aVariableData = $doVariable->toArray();

            $oVariableInfo = new OA_Dll_VariableInfo();

            $oVariableInfo->setVariableDataFromArray($aVariableData);
            return true;

        } else {

            $this->raiseError(self::ERROR_UNKNOWN_ID);
            return false;
        }
    }

    /**
     * Sets all other tracker variables is_unique value to 0.
     * Eg, if variable ID 3 is passed, then all OTHER variables for the tracker
     * (apart from variable ID 3) will have is_unique set to 0.
     *
     * @param int $variableId the variable ID to NOT set to 0.
     * @param int $trackerId the tracker ID to update variables on.
     */
    private function updateOtherVariablesIsUniqueValue($variableId, $trackerId)
    {
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->is_unique = 0;
        $doVariables->whereAdd("trackerid = {$trackerId}");
        $doVariables->whereAdd("variableid != {$variableId}");
        $doVariables->update(DB_DATAOBJECT_WHEREADD_ONLY);
    }

    /**
     * Gets all the websites that have zones with campaigns for a given tracker.
     *
     * @param int $trackerId the tracker ID to return websites for.
     * @return array array of publisher (affiliate/site) IDs
     */
    private function getLinkedWebsites($trackerId)
    {
        $dalAffiliates = new MAX_Dal_Admin_Affiliates();
        $rsLinkedWebsites = $dalAffiliates->getPublishersByTracker($trackerId);
        $rsLinkedWebsites->find();
        $aWebsites = array();
        while ($rsLinkedWebsites->fetch() && $row = $rsLinkedWebsites->toArray()) {
            $aWebsites[] = $row['affiliateid'];
        }

        return $aWebsites;
    }

    /**
     * Make a variable visible to the given website.
     *
     * @param int $variableId
     * @param int $websiteId
     */
    private function addVisibleWebsite($variableId, $websiteId)
    {
        $doVariable_publisher = OA_Dal::factoryDO('variable_publisher');
        $doVariable_publisher->variable_id = $variableId;
        $doVariable_publisher->publisher_id = $websiteId;

        if (!$doVariable_publisher->find()) {
            $doVariable_publisher->visible = 1;
            $doVariable_publisher->insert();
        }
    }

    /**
     * Deletes all rows in the variable_publisher table for a given variableId
     *
     * @param int $variableId the variable ID
     */
    private function clearVisibleWebsites($variableId)
    {
        $doVariable_publisher = OA_Dal::factoryDO('variable_publisher');
        $doVariable_publisher->variable_id = $variableId;
        $doVariable_publisher->delete();
    }

}

?>
