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
 * @author     Heiko Weber <heiko@wecos.de>
 *
 * The channel XML-RPC service enables XML-RPC communication with the channel object.
 *
 */

require_once '../../../../init.php';
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';
require_once MAX_PATH . '/www/api/v2/common/BaseChannelService.php';
require_once MAX_PATH . '/www/api/v2/common/XmlRpcUtils.php';
require_once MAX_PATH . '/lib/OA/Dll/Channel.php';

/**
 * The ChannelXmlRpcService class extends the BaseChannelService class.
 *
 */
class ChannelXmlRpcService extends BaseChannelService
{

    /**
     * Adds details for a new channel to the channel
     * object and returns either the channel ID or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function addChannel(&$oParams)
    {
        $sessionId          = null;
        $oChannelInfo       = new OA_Dll_ChannelInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oChannelInfo, $oParams, 1,
                array('agencyId', 'websiteId', 'channelName', 'description',
                'comments'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oChannelServiceImp->addChannel($sessionId, $oChannelInfo)) {
            return XmlRpcUtils::integerTypeResponse($oChannelInfo->channelId);
        } else {
            return XmlRpcUtils::generateError($this->_oChannelServiceImp->getLastError());
        }
    }

    /**
     * The modifyChannel method either changes the details for an existing channel
     * or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function modifyChannel(&$oParams)
    {
        $sessionId          = null;
        $oChannelInfo       = new OA_Dll_ChannelInfo();
        $oResponseWithError = null;

        if (!XmlRpcUtils::getRequiredScalarValue($sessionId, $oParams, 0,
                $oResponseWithError) ||
            !XmlRpcUtils::getStructureScalarFields($oChannelInfo, $oParams, 1,
                 array('channelId', 'channelName', 'description', 'comments'),
                 $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oChannelServiceImp->modifyChannel($sessionId, $oChannelInfo)) {
            return XmlRpcUtils::booleanTypeResponse(true);
        } else {
            return XmlRpcUtils::generateError($this->_oChannelServiceImp->getLastError());
        }
    }

    /**
     * The deleteChannel method either deletes an existing channel from the
     * channel object or returns an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function deleteChannel(&$oParams)
    {
        $oResponseWithError = null;

        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$channelId),
            array(true, true), $oParams, $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oChannelServiceImp->deleteChannel($sessionId, $channelId)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oChannelServiceImp->getLastError());
        }
    }

    /**
     * The getChannel method returns either information about a channel or
     * an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function getChannel(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$channelId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $oChannel = null;
        if ($this->_oChannelServiceImp->getChannel($sessionId,
                $channelId, $oChannel)) {

            return XmlRpcUtils::getEntityResponse($oChannel);
        } else {

            return XmlRpcUtils::generateError($this->_oChannelServiceImp->getLastError());
        }
    }

    /**
     * The getChannelListByAgencyId method returns either a
     * list of channels or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function getChannelListByAgencyId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$agencyId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aChannelList = null;
        if ($this->_oChannelServiceImp->getChannelListByAgencyId($sessionId, $agencyId, $aChannelList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aChannelList);
        } else {

            return XmlRpcUtils::generateError($this->_oChannelServiceImp->getLastError());
        }
    }

    /**
     * Returns either a list of channels or an error message.
     *
     * @access public
     *
     * @param XML_RPC_Message &$oParams
     *
     * @return generated result (data or error)
     */
    public function getChannelListByWebsiteId(&$oParams) {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(
                array(&$sessionId, &$websiteId),
                array(true, true), $oParams, $oResponseWithError)) {
           return $oResponseWithError;
        }

        $aChannelList = null;
        if ($this->_oChannelServiceImp->getChannelListBywebsiteId($sessionId, $websiteId, $aChannelList)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aChannelList);
        } else {

            return XmlRpcUtils::generateError($this->_oChannelServiceImp->getLastError());
        }
    }

    /**
     * This method return targeting limitations for channel.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (array or error)
     */
    public function getChannelTargeting(&$oParams)
    {
        $oResponseWithError = null;
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$channelId),
            array(true, true), $oParams, $oResponseWithError)) {

            return $oResponseWithError;
        }

        $aTargeting = null;
        if ($this->_oChannelServiceImp->getChannelTargeting($sessionId,
            $channelId, $aTargeting)) {

            return XmlRpcUtils::getArrayOfEntityResponse($aTargeting);

        } else {

            return XmlRpcUtils::generateError($this->_oChannelServiceImp->getLastError());
        }
    }

    /**
     * This method sets targeting limitations for a channel.
     * It overrides existing limitations.
     *
     * @access public
     *
     * @param  XML_RPC_Message &$oParams
     *
     * @return generated result (boolean or error)
     */
    public function setChannelTargeting(&$oParams)
    {
        $oResponseWithError = null;
        $aTargeting = array();
        if (!XmlRpcUtils::getScalarValues(array(&$sessionId, &$channelId),
            array(true, true), $oParams, $oResponseWithError) ||
            !XmlRpcUtils::getArrayOfStructuresScalarFields($aTargeting,
                'OA_Dll_TargetingInfo', $oParams, 2, array('logical', 'type',
                    'comparison', 'data'), $oResponseWithError)) {

            return $oResponseWithError;
        }

        if ($this->_oChannelServiceImp->setChannelTargeting($sessionId,
            $channelId, $aTargeting)) {

            return XmlRpcUtils::booleanTypeResponse(true);

        } else {

            return XmlRpcUtils::generateError($this->_oChannelServiceImp->getLastError());
        }
    }
}
