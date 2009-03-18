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
$Id$
*/

/**
 * @package    OpenX
 * @author     Heiko Weber <heiko@wecos.de>
 *
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
    var $_dllChannel;

    /**
     *
     * The ChannelServiceImpl method is the constructor for the ChannelServiceImpl class.
     */
    function __construct()
    {
        $this->BaseServiceImpl();
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
    function _validateResult($result)
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
    function addChannel($sessionId, &$oChannel)
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
    function modifyChannel($sessionId, &$oChannel)
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
    function deleteChannel($sessionId, $channelId)
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
    function getChannel($sessionId, $channelId, &$oChannel)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllChannel->getChannel($channelId, $oChannel));
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
    function getChannelListByWebsiteId($sessionId, $websiteId, &$aChannelList)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllChannel->getChannelList(null, $websiteId, $aChannelList));
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
    function getChannelListByAgencyId($sessionId, $agencyId, &$aChannelList)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllChannel->getChannelList($agencyId, null, $aChannelList));
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
    function getChannelTargeting($sessionId, $channelId, &$aTargeting)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllChannel->getChannelTargeting(
                $channelId, $aTargeting));
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
    function setChannelTargeting($sessionId, $channelId, &$aTargeting)
    {
        if ($this->verifySession($sessionId)) {
            return $this->_validateResult($this->_dllChannel->setChannelTargeting(
                $channelId, $aTargeting));
        } else {
            return false;
        }
    }
}


