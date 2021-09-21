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
 *
 */

// Require the following classes:
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/ChannelInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/TargetingInfo.php';
require_once MAX_PATH . '/lib/OA/Auth.php';
require_once MAX_PATH . '/lib/RV/Admin/Languages.php';


/**
 * The OA_Dll_Channel class extends the OA_Dll class.
 *
 */

class OA_Dll_Channel extends OA_Dll
{
    /**
     * This method sets the ChannelInfo from a data array.
     *
     * @access private
     *
     * @param OA_Dll_ChannelInfo &$oChannel
     * @param array $channelData
     *
     * @return boolean
     */
    public function _setChannelDataFromArray(&$oChannel, $channelData)
    {
        $channelData['channelId'] = $channelData['channelid'];
        $channelData['agencyId'] = $channelData['agencyid'];
        $channelData['websiteId'] = $channelData['affiliateid'];
        $channelData['channelName'] = $channelData['name'];
        $channelData['description'] = $channelData['description'];
        $channelData['comments'] = $channelData['comments'];

        $oChannel->readDataFromArray($channelData);
        return  true;
    }

    /**
     * This method performs data validation for a channel. The method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @access private
     *
     * @param OA_Dll_ChannelInfo &$oChannel
     *
     * @return boolean  Returns false if fields are not valid and true if valid.
     *
     */
    public function _validate(&$oChannel)
    {
        if (isset($oChannel->channelId)) {

            // If modifying, check the channelId is valid.
            if (!$this->checkStructureRequiredIntegerField($oChannel, 'channelId') ||
                !$this->checkIdExistence('channel', $oChannel->channelId)) {
                return false;
            }

            // Check the name is valid
            if (!$this->checkStructureNotRequiredStringField($oChannel, 'channelName', 255)) {
                return false;
            }
        } else {
            // Adding
            // Check the agencyId is valid
            if (!$this->checkStructureNotRequiredIntegerField($oChannel, 'agencyId') ||
                !$this->checkIdExistence('agency', $oChannel->agencyId)) {
                return false;
            }

            // Check the websiteId is valid (may be 0)
            if (isset($oChannel->websiteId) && $oChannel->websiteId != 0) {
                if (!$this->checkStructureNotRequiredIntegerField($oChannel, 'websiteId') ||
                    !$this->checkIdExistence('affiliates', $oChannel->websiteId)) {
                    return false;
                }
            }

            // Check the name is valid
            if (!$this->checkStructureRequiredStringField($oChannel, 'channelName', 255)) {
                return false;
            }
        }


        if (!$this->checkStructureNotRequiredStringField($oChannel, 'description', 255) ||
            !$this->checkStructureNotRequiredStringField($oChannel, 'comments')) {
            return false;
        }

        return true;
    }

    /**
     * This method modifies an existing channel. Undefined fields do not changed
     * and defined fields with a NULL value also remain unchanged.
     *
     * @access public
     *
     * @param OA_Dll_ChannelInfo &$oChannel <br />
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> channelName<br />
     *          <b>Optional properties:</b> agencyId, websiteId, description, comments<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> channelId<br />
     *          <b>Optional properties:</b> channelName, description, comments<br />
     *
     * @return boolean  True if the operation was successful
     *
     */
    public function modify(&$oChannel)
    {
        if (!isset($oChannel->channelId)) {
            // Add
            $oChannel->setDefaultForAdd();

            // Check permission for the website.
            if (isset($oChannel->websiteId) && $oChannel->websiteId != 0) {
                if (!$this->checkPermissions(
                    [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
                    'affiliates',
                    $oChannel->websiteId
                )) {
                    return false;
                }
            }
        } else {
            if (!$this->checkPermissions(
                [OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER],
                'channel',
                $oChannel->channelId
            )) {
                return false;
            }
        }

        // Prepare the dataobject array.
        $channelData = (array) $oChannel;
        $channelData['agencyid'] = $oChannel->agencyId;
        $channelData['name'] = $oChannel->channelName;
        $channelData['description'] = $oChannel->description;
        $channelData['affiliateid'] = $oChannel->websiteId;
        $channelData['compiledlimitation'] = $oChannel->compiledLimitation;
        $channelData['acl_plugins'] = $oChannel->aclPlugins;

        if ($this->_validate($oChannel)) {
            $doChannel = OA_Dal::factoryDO('channel');
            if (!isset($oChannel->channelId)) {
                $doChannel->setFrom($channelData);
                $oChannel->channelId = $doChannel->insert();
            } else {
                $doChannel->get($oChannel->channelId);
                $doChannel->setFrom($channelData);
                $doChannel->update();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method deletes an existing channel.
     *
     * @access public
     *
     * @param integer $channelId  The ID of the channel to delete
     *
     * @return boolean  True if the operation was successful
     *
     */
    public function delete($channelId)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        if (!$this->checkIdExistence('channel', $channelId)) {
            return false;
        }

        $doChannel = OA_Dal::factoryDO('channel');
        $doChannel->channelid = $channelId;
        $result = $doChannel->delete();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns ChannelInfo for a specified channel.
     *
     * @access public
     *
     * @param int $channelId
     * @param OA_Dll_ChannelInfo &$oChannel
     *
     * @return boolean
     */
    public function getChannel($channelId, &$oChannel)
    {
        if ($this->checkIdExistence('channel', $channelId)) {
            if (!$this->checkPermissions(null, 'channel', $channelId)) {
                return false;
            }
            $doChannel = OA_Dal::factoryDO('channel');
            $doChannel->get($channelId);
            $channelData = $doChannel->toArray();

            $oChannel = new OA_Dll_ChannelInfo();

            $this->_setChannelDataFromArray($oChannel, $channelData);
            return true;
        } else {
            $this->raiseError('Unknown channelId Error');
            return false;
        }
    }

    /**
     * This method returns a list of channels linked to
     * either agency or publisher.
     *
     * @access public
     *
     * @param integer $agencyId
     * @param integer $websiteId
     * @param array &$aChannelList
     *
     * @return boolean
     */
    public function getChannelList($agencyId, $websiteId, &$aChannelList)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        $aChannelList = [];

        $doChannel = OA_Dal::factoryDO('channel');
        if (isset($agencyId)) {
            if (!$this->checkIdExistence('agency', $agencyId)) {
                return false;
            } else {
                $doChannel->agencyid = $agencyId;
            }
        }
        if (isset($websiteId)) {
            if (!$this->checkIdExistence('affiliates', $websiteId)) {
                return false;
            } else {
                $doChannel->affiliateid = $websiteId;
            }
        }
        $doChannel->find();

        while ($doChannel->fetch()) {
            $channelData = $doChannel->toArray();

            $oChannel = new OA_Dll_ChannelInfo();
            $this->_setChannelDataFromArray($oChannel, $channelData);

            $aChannelList[] = $oChannel;
        }
        return true;
    }

    /**
     * This method returns the list of limitations linked to this channel
     *
     * @access public
     *
     * @param integer $channelId
     * @param array &$aTargetingList
     *
     * @return boolean
     */
    public function getChannelTargeting($channelId, &$aTargetingList)
    {
        if ($this->checkIdExistence('channel', $channelId)) {
            if (!$this->checkPermissions(null, 'channel', $channelId)) {
                return false;
            }
            $aTargetingList = [];

            $doChannelTargeting = OA_Dal::factoryDO('acls_channel');
            $doChannelTargeting->channelid = $channelId;
            $doChannelTargeting->find();

            while ($doChannelTargeting->fetch()) {
                $channelTargetingData = $doChannelTargeting->toArray();

                $oChannelTargeting = new OA_Dll_TargetingInfo();
                $this->_setChannelDataFromArray($oChannelTargeting, $channelTargetingData);

                $aTargetingList[$channelTargetingData['executionorder']] = $oChannelTargeting;
            }

            return true;
        } else {
            $this->raiseError('Unknown channelId Error');
            return false;
        }
    }

    /**
     * This method try to check the limitation
     *
     * @access public
     *
     * @param OA_Dll_TargetingInfo $oTargeting
     *
     * @return boolean
     */
    public function _validateTargeting($oTargeting)
    {
        if (!isset($oTargeting->data)) {
            $this->raiseError('Field \'data\' in structure does not exists');
            return false;
        }

        if (!$this->checkStructureRequiredStringField($oTargeting, 'logical', 255) ||
            !$this->checkStructureRequiredStringField($oTargeting, 'type', 255) ||
            !$this->checkStructureRequiredStringField($oTargeting, 'comparison', 255) ||
            !$this->checkStructureNotRequiredStringField($oTargeting, 'data', 255)) {
            return false;
        }

        // Check that each of the specified targeting plugins are available
        $oPlugin = OX_Component::factoryByComponentIdentifier($oTargeting->type);
        if ($oPlugin === false) {
            $this->raiseError('Unknown targeting plugin: ' . $oTargeting->type);
            return false;
        }

        return true;
    }

    /**
     * This method set the list of limitations for this channel,
     * overrides existing limitations.
     *
     * @access public
     *
     * @param integer $channelId
     * @param array &$aTargetingList
     *
     * @return boolean
     */
    public function setChannelTargeting($channelId, &$aTargeting)
    {
        if ($this->checkIdExistence('channel', $channelId)) {
            if (!$this->checkPermissions(null, 'channel', $channelId)) {
                return false;
            }

            foreach ($aTargeting as $executionOrder => $oTargeting) {

                // Prepend "deliveryLimitations:" to any component-identifiers
                // (for 2.6 backwards compatibility)
                if (substr($oTargeting->type, 0, 20) != 'deliveryLimitations:') {
                    $aTargeting[$executionOrder]->type = 'deliveryLimitations:' .
                        $aTargeting[$executionOrder]->type;
                }

                if (!$this->_validateTargeting($oTargeting)) {
                    return false;
                }
            }

            $doChannelTargeting = OA_Dal::factoryDO('acls_channel');
            $doChannelTargeting->channelid = $channelId;
            $doChannelTargeting->find();
            $doChannelTargeting->delete();

            // Create the new targeting options
            $executionOrder = 0;
            $aAcls = [];
            foreach ($aTargeting as $oTargeting) {
                $channelTargetingData = $oTargeting->toArray();
                $doAclChannel = OA_Dal::factoryDO('acls_channel');
                $doAclChannel->setFrom($channelTargetingData);
                $doAclChannel->channelid = $channelId;
                $doAclChannel->executionorder = $executionOrder;
                $doAclChannel->insert();
                $aAcls[$executionOrder] = $doAclChannel->toArray();
                $executionOrder++;
            }

            // Recompile the channel's compiledlimitations
            $doChannel = OA_Dal::factoryDO('channel');
            $doChannel->get($channelId);
            // typo?
            $doChannel->compiledlimitation = OA_aclGetSLimitationFromAAcls($aAcls);
            $doChannel->acl_plugins = MAX_AclGetPlugins($aAcls);
            $doChannel->acls_updated = gmdate(OA_DATETIME_FORMAT);
            $doChannel->update();

            return true;
        } else {
            $this->raiseError('Unknown channelId Error');
            return false;
        }
    }
}
