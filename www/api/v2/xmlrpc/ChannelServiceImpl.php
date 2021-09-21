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
 * @package    OpenX
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v2/common/BaseServiceImpl.php';

// Channel Dll class
require_once MAX_PATH . '/lib/OA/Dll/Channel.php';

/**
 * The ChannelServiceImpl class extends the BaseServiceImpl class to enable
 * you to add, modify, delete and search the channel object.
 *
 */
class ChannelServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_Channel $_dllChannel
     */
    public $_dllChannel;

    /**
     *
     * The ChannelServiceImpl method is the constructor for the ChannelServiceImpl class.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_dllChannel = new OA_Dll_Channel();
    }

    /**
     * This method checks if an action is valid and either returns a result
     * or an error, as appropriate.
     *
     * @access private
     *
     * @param boolean $result
     * @return boolean
     */
    public function _validateResult($result)
    {
        if ($result) {
            return true;
        } else {
            $this->raiseError($this->_dllChannel->getLastError());
            return false;
        }
    }

    /**
     * The addChannel method creates a channel and updates the
     * channel object with the channel ID.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_ChannelInfo &$oChannel <br />
     *          <b>Required properties:</b> agencyId, channelName<br />
     *          <b>Optional properties:</b> websiteId, description, comments<br />
     *
     * @return boolean
     */
    public function addChannel($sessionId, &$oChannel)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllChannel->modify($oChannel));
        } else {
            return false;
        }
    }

    /**
     * The modifyChannel method checks if a channel ID exists and
     * modifies the details for the channel if it exists or returns an error
     * message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_ChannelInfo &$oChannel <br />
     *          <b>Required properties:</b> channelId<br />
     *          <b>Optional properties:</b> channelName, description, comments<br />
     *
     * @return boolean
     */
    public function modifyChannel($sessionId, &$oChannel)
    {
        if ($this->verifySession($sessionId)) {
            if (isset($oChannel->channelId)) {
                return $this->_validateResult($this->_dllChannel->modify($oChannel));
            } else {
                $this->raiseError("Field 'channelId' in structure does not exists");
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * The deleteChannel method checks if a channel exists and deletes
     * the channel or returns an error message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $channelId
     *
     * @return boolean
     */
    public function deleteChannel($sessionId, $channelId)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllChannel->delete($channelId));
        } else {
            return false;
        }
    }

    /**
     * The getChannel method returns the channel details for a specified channel.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $channelId
     * @param OA_Dll_ChannelInfo &$oChannel
     *
     * @return boolean
     */
    public function getChannel($sessionId, $channelId, &$oChannel)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllChannel->getChannel($channelId, $oChannel)
            );
        } else {
            return false;
        }
    }

    /**
     * The getChannelListBywebsiteId method returns a list of channels.
     *
     * @access public
     *
     * @param string $sessionId
     * @param string $websiteId
     * @param array &$aChannelList  Array of OA_Dll_ChannelInfo classes
     *
     * @return boolean
     */
    public function getChannelListByWebsiteId($sessionId, $websiteId, &$aChannelList)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllChannel->getChannelList(null, $websiteId, $aChannelList)
            );
        } else {
            return false;
        }
    }

    /**
     * The getChannelListByAgencyId method returns a list of channels.
     *
     * @access public
     *
     * @param string $sessionId
     * @param string $AgencyId
     * @param array &$aChannelList  Array of OA_Dll_ChannelInfo classes
     *
     * @return boolean
     */
    public function getChannelListByAgencyId($sessionId, $agencyId, &$aChannelList)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult(
                $this->_dllChannel->getChannelList($agencyId, null, $aChannelList)
            );
        } else {
            return false;
        }
    }

    /**
     * This method return targeting limitations for channel
     * or returns an error message,.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $channelId
     * @param array &$aTargeting
     *
     * @return boolean
     */
    public function getChannelTargeting($sessionId, $channelId, &$aTargeting)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllChannel->getChannelTargeting(
                $channelId,
                $aTargeting
            ));
        } else {
            return false;
        }
    }


    /**
     * This method set targeting limitations for channel
     * or returns an error message.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $channelId
     * @param array &$aTargeting
     *
     * @return boolean
     */
    public function setChannelTargeting($sessionId, $channelId, &$aTargeting)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllChannel->setChannelTargeting(
                $channelId,
                $aTargeting
            ));
        } else {
            return false;
        }
    }
}
