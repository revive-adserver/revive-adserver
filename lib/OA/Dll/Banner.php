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
require_once MAX_PATH . '/lib/OA/Dll/BannerInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/TargetingInfo.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Banner.php';
require_once MAX_PATH . '/lib/OA/Creative/File.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';


/**
 * The OA_Dll_Banner class extends the OA_Dll class.
 *
 */

class OA_Dll_Banner extends OA_Dll
{
    /**
     * @var OA_Creative_File
     */
    var $oImage;
    /**
     * @var OA_Creative_File
     */
    var $oBackupImage;

    /**
     * This method sets BannerInfo from a data array.
     *
     * @access private
     *
     * @param OA_Dll_BannerInfo &$oBanner
     * @param array $bannerData
     *
     * @return boolean
     */
    function _setBannerDataFromArray(&$oBanner, $bannerData)
    {
        $bannerData['htmlTemplate']     = $bannerData['htmltemplate'];
        $bannerData['imageURL']         = $bannerData['imageurl'];
        $bannerData['storageType']      = $bannerData['storagetype'];
        $bannerData['bannerName']       = $bannerData['description'];
        $bannerData['campaignId']       = $bannerData['campaignid'];
        $bannerData['bannerId']         = $bannerData['bannerid'];
        $bannerData['bannerText']       = $bannerData['bannertext'];
        $bannerData['sessionCapping']   = $bannerData['session_capping'];

        $oBanner->readDataFromArray($bannerData);
        return  true;
    }

    function _validateImage($aImage, &$oImage)
    {
        if (empty($aImage['filename'])) {
            $this->raiseError("Image filename empty");
            return false;
        }
        if (empty($aImage['content'])) {
            $this->raiseError("Image content empty");
            return false;
        }
        $oImage = OA_Creative_File::factoryString($aImage['filename'], $aImage['content']);
        if (PEAR::isError($oImage)) {
            $this->raiseError($oImage->getMessage());
            return false;
        }
        return true;
    }

    /**
     * This method performs data validation for a banner, for example to check
     * that an email address is an email address. Where necessary, the method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @access private
     *
     * @param OA_Dll_BannerInfo &$oBanner  Banner object.
     *
     * @return boolean  Returns false if fields are not valid and true if valid.
     *
     */
    function _validate(&$oBanner)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Clean up
        $this->oImage = null;
        $this->oBackupImage = null;

        if (isset($oBanner->bannerId)) {
            // When modifying a banner, check correct field types are used and the bannerID exists.
            if (!$this->checkStructureNotRequiredIntegerField($oBanner, 'campaignId') ||
                !$this->checkStructureRequiredIntegerField($oBanner, 'bannerId') ||
                !$this->checkIdExistence('banners', $oBanner->bannerId)) {
                return false;
            }
        } else {
            // When adding a banner, check that the required field 'campaignId' is correct.
            if (!$this->checkStructureRequiredIntegerField($oBanner, 'campaignId')) {
                return false;
            }
        }

        if (isset($oBanner->campaignId) &&
            !$this->checkIdExistence('campaigns', $oBanner->campaignId)) {
            return false;
        }

        // Prepare list of allowed storage types from allowed banners list
        $aAllowedBanners = $aConf['allowedBanners'];
        $aAllowedBanners['txt'] = $aAllowedBanners['text'];
        unset($aAllowedBanners['text']);
        foreach($aAllowedBanners as $type => $allowed) {
            if (!$allowed) {
                unset($aAllowedBanners[$type]);
            }
        }

        // Check that storage type is allowed
        if (!isset($oBanner->bannerId)) {
            if (!isset($oBanner->storageType) || empty($aAllowedBanners[$oBanner->storageType])) {
                $storageTypes = array_keys($aAllowedBanners);
                $this->raiseError('Field \'storageType\' must be one of the enum: '.join(', ', $storageTypes));
                return false;
            }
            $contentType = '';
        } else {
            $doBanners = OA_Dal::staticGetDO('banners', $oBanner->bannerId);
            $oBanner->storageType = $doBanners->storagetype;
            $contentType = $doBanners->contenttype;
        }

        // Check that image is provided when storagetype is sql or web
        if ($oBanner->storageType == 'sql' || $oBanner->storageType == 'web') {
            if (isset($oBanner->aImage)) {
                if (!$this->_validateImage($oBanner->aImage, $this->oImage)) {
                    return false;
                }
                $contentType = $this->oImage->contentType;
            } elseif (!isset($oBanner->bannerId)) {
                $this->raiseError('Field \'aImage\' must not be empty');
                return false;
            }
            if ($contentType == 'swf') {
                if (isset($oBanner->aBackupImage)) {
                    // Get backup image
                    if (!$this->_validateImage($oBanner->aBackupImage, $this->oBackupImage)) {
                        return false;
                    }
                }
            } else {
                // Remove backup gif
                $oBanner->aBackupImage = array(
                    'filename' => null,
                    'content' =>  ''
                );
            }
        }

        if (!$this->checkStructureNotRequiredStringField($oBanner,  'bannerName', 255) ||
            !$this->checkStructureNotRequiredStringField($oBanner,  'imageURL', 255) ||
            !$this->checkStructureNotRequiredStringField($oBanner,  'htmlTemplate') ||
            !$this->checkStructureNotRequiredIntegerField($oBanner, 'width') ||
            !$this->checkStructureNotRequiredIntegerField($oBanner, 'height') ||
            !$this->checkStructureNotRequiredIntegerField($oBanner, 'weight') ||
            !$this->checkStructureNotRequiredStringField($oBanner,  'target') ||
            !$this->checkStructureNotRequiredStringField($oBanner,  'url') ||
            !$this->checkStructureNotRequiredStringField($oBanner,  'bannerText') ||
            !$this->checkStructureNotRequiredBooleanField($oBanner, 'active') ||
            !$this->checkStructureNotRequiredStringField($oBanner,  'adserver')||
            !$this->checkStructureNotRequiredIntegerField($oBanner, 'capping') ||
            !$this->checkStructureNotRequiredIntegerField($oBanner, 'sessionCapping') ||
            !$this->checkStructureNotRequiredIntegerField($oBanner, 'block') ||
            !$this->checkStructureNotRequiredStringField($oBanner,  'comments') ||
            !$this->checkStructureNotRequiredStringField($oBanner,  'alt')
            ) {
            return false;
        }

        return true;
    }

    /**
     * This method performs data validation for statistics methods(bannerId, date).
     *
     * @access private
     *
     * @param integer  $bannerId
     * @param date     $oStartDate
     * @param date     $oEndDate
     *
     * @return boolean
     *
     */
    function _validateForStatistics($bannerId, $oStartDate, $oEndDate)
    {
        if (!$this->checkIdExistence('banners', $bannerId) ||
            !$this->checkDateOrder($oStartDate, $oEndDate)) {
            return false;
        }

        return true;
    }

    /**
     * This function calls a method in the OA_Dll class which checks permissions.
     *
     * @access public
     *
     * @param integer $advertiserId  Banner ID
     *
     * @return boolean  False if access is denied and true if allowed.
     */
    function checkStatisticsPermissions($bannerId)
    {
       if (!$this->checkPermissions(
            array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER),
            'banners', $bannerId)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * This method modifies an existing banner. Undefined fields do not change
     * and defined fields with a NULL value also remain unchanged.
     *
     * @access public
     *
     * @param OA_Dll_BannerInfo &$oBanner <br />
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> campaignId<br />
     *          <b>Optional properties:</b> bannerName, storageType, imageURL, htmlTemplate, width, height, weight, url, alt<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> bannerId<br />
     *          <b>Optional properties:</b> campaignId, bannerName, storageType, imageURL, htmlTemplate, width, height, weight, url, altText<br />
     *
     * @return boolean  True if the operation was successful
     *
     */
    function modify(&$oBanner)
    {
        if (!isset($oBanner->bannerId)) {
            // Add
            $oBanner->setDefaultForAdd();
            if (!$this->checkPermissions($this->aAllowAdvertiserAndAbovePerm,
                 'campaigns', $oBanner->campaignId, OA_PERM_BANNER_EDIT)) {

                return false;
            }
        } else {
            // Edit
            if (!$this->checkPermissions($this->aAllowAdvertiserAndAbovePerm,
                 'banners', $oBanner->bannerId, OA_PERM_BANNER_EDIT)) {

                return false;
            }
        }

        $bannerData =  (array) $oBanner;

        // Name
        $bannerData['bannerid']     = $oBanner->bannerId;
        $bannerData['campaignid']   = $oBanner->campaignId;
        $bannerData['description']  = $oBanner->bannerName;
        $bannerData['storagetype']  = $oBanner->storageType;
        $bannerData['imageurl']     = $oBanner->imageURL;
        $bannerData['htmltemplate'] = $oBanner->htmlTemplate;
        $bannerData['alt']          = $oBanner->alt;

        $bannerData['capping']          = $oBanner->capping > 0
                                        ? $oBanner->capping
                                        : 0;
        $bannerData['session_capping']  = $oBanner->sessionCapping > 0
                                        ? $oBanner->sessionCapping
                                        : 0;
        $bannerData['block']            = $oBanner->block > 0
                                        ? $oBanner->block
                                        : 0;

        if ($this->_validate($oBanner)) {
            $bannerData['storagetype'] = $oBanner->storageType;

            // Set iframe friendliness only for new html banners
            if (!isset($oBanner->bannerId)) {
                $bannerData['iframe_friendly'] = $bannerData['storagetype'] === 'html';
            }

            switch($bannerData['storagetype']) {
                case 'html':
                    $bannerData['contenttype']    = $bannerData['storagetype'];
                    $bannerData['bannertext']     = $oBanner->bannerText;
                    $bannerData['ext_bannertype'] = 'bannerTypeHtml:oxHtml:genericHtml';
                    break;
                case 'txt':
                    $bannerData['contenttype']    = $bannerData['storagetype'];
                    $bannerData['bannertext']     = $oBanner->bannerText;
                    $bannerData['ext_bannertype'] = 'bannerTypeText:oxText:genericText';
                    break;
                case 'sql':
                case 'web':
                    if (!empty($oBanner->aImage)) {
                        // Hardcoded link conversion
                        $bannerData['parameters'] = '';
                        if ($this->oImage->contentType == 'swf' && !empty($oBanner->aImage['editswf'])) {
                            $aLinks = array_keys($this->oImage->hardcodedLinks);
                            list($result, $params) = phpAds_SWFConvert($this->oImage->content, true, $aLinks);
                            if ($result != $this->oImage->content) {
                                $this->oImage->content = $result;
                                $bannerData['parameters'] = array('swf' => array());
                                foreach ($params as $key) {
                                    $bannerData['parameters']['swf'][$key] = array(
                                        'link' => $this->oImage->hardcodedLinks[$key][0],
                                        'tar'  => $this->oImage->hardcodedLinks[$key][1]
                                    );
                                }
                                $bannerData['parameters'] = serialize($bannerData['parameters']);
                                $bannerData['url']        = $this->oImage->hardcodedLinks[1][0];
                                $bannerData['target']     = $this->oImage->hardcodedLinks[1][1];
                            }
                        }
                        $this->oImage->store($bannerData['storagetype']);
                        $bannerData['contenttype'] = $this->oImage->contentType;
                        $bannerData['filename']   = $this->oImage->fileName;
                        $bannerData['width']      = $this->oImage->width;
                        $bannerData['height']     = $this->oImage->height;
                    }
                    if (!empty($oBanner->aBackupImage)) {
                        if (isset($this->oBackupImage)) {
                            $this->oBackupImage->store($bannerData['storagetype']);
                            $bannerData['alt_contenttype'] = $this->oBackupImage->contentType;
                            $bannerData['alt_filename']   = $this->oBackupImage->fileName;
                        } elseif (!isset($oBanner->aBackupImage['filename'])) {
                            $bannerData['alt_contenttype'] = '';
                            $bannerData['alt_filename']   = '';
                        }
                    }
                    break;
                case 'url':
                    $bannerData['contenttype'] = OA_Creative_File::staticGetContentTypeByExtension($oBanner->imageURL);
                    break;
            }

            $doBanner = OA_Dal::factoryDO('banners');
            if (!isset($bannerData['bannerId'])) {
                $doBanner->setFrom($bannerData);
                $oBanner->bannerId = $doBanner->insert();
            } else {
                $doBanner->get($bannerData['bannerId']);
                $doBanner->setFrom($bannerData);
                $doBanner->update();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method deletes an existing banner.
     *
     * @access public
     *
     * @param integer $bannerId  The ID of the banner to delete.
     *
     * @return boolean  True if the operation was successful
     *
     */
    function delete($bannerId)
    {
        if (!$this->checkPermissions(
            array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER),
            'banners', $bannerId)) {
            return false;
        }

       if (isset($bannerId)) {
            $doBanner = OA_Dal::factoryDO('banners');
            $doBanner->bannerid = $bannerId;
            $result = $doBanner->delete();
        } else {
            $result = false;
        }

        if ($result) {
            return true;
        } else {
            $this->raiseError('Unknown bannerId Error');
            return false;
        }
    }

    /**
     * This method returns BannerInfo for a specified banner.
     *
     * @access public
     *
     * @param int $bannerId
     * @param OA_Dll_BannerInfo &$oBanner
     *
     * @return boolean
     */
    function getBanner($bannerId, &$oBanner)
    {
        if ($this->checkIdExistence('banners', $bannerId)) {
            if (!$this->checkPermissions(null, 'banners', $bannerId, null, $operationAccessType = OA_Permission::OPERATION_VIEW)) {
                return false;
            }
            $doBanner = OA_Dal::factoryDO('banners');
            $doBanner->get($bannerId);
            $bannerData = $doBanner->toArray();

            $oBanner = new OA_Dll_BannerInfo();

            $this->_setBannerDataFromArray($oBanner, $bannerData);
            return true;

        } else {

            $this->raiseError('Unknown bannerId Error');
            return false;
        }
    }


    function getBannerTargeting($bannerId, &$aBannerList)
    {
        if ($this->checkIdExistence('banners', $bannerId)) {
            if (!$this->checkPermissions(null, 'banners', $bannerId)) {
                return false;
            }
            $aBannerList = array();

            $doBannerTargeting = OA_Dal::factoryDO('acls');
            $doBannerTargeting->bannerid = $bannerId;
            $doBannerTargeting->find();

            while ($doBannerTargeting->fetch()) {
                $bannerTargetingData = $doBannerTargeting->toArray();

                $oBannerTargeting = new OA_Dll_TargetingInfo();
                $this->_setBannerDataFromArray($oBannerTargeting, $bannerTargetingData);

                $aBannerList[$bannerTargetingData['executionorder']] = $oBannerTargeting;
            }

            return true;

        } else {

            $this->raiseError('Unknown bannerId Error');
            return false;
        }
    }

    function _validateTargeting($oTargeting)
    {
        if (!isset($oTargeting->data)) {
            $this->raiseError('Field \'data\' in structure does not exists');
            return false;
        }

        if (!$this->checkStructureRequiredStringField($oTargeting,  'logical', 255) ||
            !$this->checkStructureRequiredStringField($oTargeting,  'type', 255) ||
            !$this->checkStructureRequiredStringField($oTargeting,  'comparison', 255) ||
            !$this->checkStructureNotRequiredStringField($oTargeting,  'data')) {

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

    function setBannerTargeting($bannerId, &$aTargeting)
    {
        if ($this->checkIdExistence('banners', $bannerId)) {
            if (!$this->checkPermissions(null, 'banners', $bannerId)) {
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

            $aTargetingArray = array();
            foreach ($aTargeting as $oTargeting) {
                $aTargetingArray[] = $oTargeting->toArray();
            }

            $res = OX_AclCheckInputsFields($aTargetingArray, false);
            if ($res !== true) {
                $this->raiseError($res[0]);
                return false;
            }

            $doBannerTargeting = OA_Dal::factoryDO('acls');
            $doBannerTargeting->bannerid = $bannerId;
            $doBannerTargeting->find();
            $doBannerTargeting->delete();

            // Create the new targeting options
            $executionOrder = 0;
            $aAcls = array();
            foreach ($aTargetingArray as $bannerTargetingData) {
                $doAcl = OA_Dal::factoryDO('acls');
                $doAcl->setFrom($bannerTargetingData);
                $doAcl->bannerid = $bannerId;
                $doAcl->executionorder = $executionOrder;
                $doAcl->insert();
                $aAcls[$executionOrder] = $doAcl->toArray();
                $executionOrder++;
            }

            // Recompile the banner's compiledlimitations
            $doBanner = OA_Dal::factoryDO('banners');
            $doBanner->get($bannerId);
            $doBanner->compiledlimitation = OA_aclGetSLimitationFromAAcls($aAcls);
            $doBanner->acl_plugins = MAX_AclGetPlugins($aAcls);
            $doBanner->acls_updated = gmdate(OA_DATETIME_FORMAT);
            $doBanner->update();

            return true;
        } else {
            $this->raiseError('Unknown bannerId Error');
            return false;
        }
    }

    /**
     * This method returns a list of banners for a specified campaign.
     *
     * @access public
     *
     * @param int $campaignId
     * @param array &$aBannerList
     *
     * @return boolean
     */
    function getBannerListByCampaignId($campaignId, &$aBannerList)
    {
        $aBannerList = array();

        if (!$this->checkIdExistence('campaigns', $campaignId)) {
                return false;
        }

        if (!$this->checkPermissions(null, 'campaigns', $campaignId)) {
            return false;
        }

        $doBanner = OA_Dal::factoryDO('banners');
        $doBanner->campaignid = $campaignId;
        $doBanner->find();

        while ($doBanner->fetch()) {
            $bannerData = $doBanner->toArray();

            $oBanner = new OA_Dll_BannerInfo();
            $this->_setBannerDataFromArray($oBanner, $bannerData);

            $aBannerList[] = $oBanner;
        }
        return true;
    }

    /**
     * This method returns daily statistics for a banner for a specified period.
     *
     * @access public
     *
     * @param integer $bannerId The ID of the banner to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>day date</b> The day
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    function getBannerDailyStatistics($bannerId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($bannerId)) {
            return false;
        }

        if ($this->_validateForStatistics($bannerId, $oStartDate, $oEndDate)) {
            $dalBanner = new OA_Dal_Statistics_Banner();
            $rsStatisticsData = $dalBanner->getBannerDailyStatistics($bannerId, $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns publisher statistics for a banner for a specified period.
     *
     * @access public
     *
     * @param integer $bannerId The ID of the banner to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    function getBannerPublisherStatistics($bannerId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($bannerId)) {
            return false;
        }

        if ($this->_validateForStatistics($bannerId, $oStartDate, $oEndDate)) {
            $dalBanner = new OA_Dal_Statistics_Banner();
            $rsStatisticsData = $dalBanner->getBannerPublisherStatistics($bannerId, $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }

    /**
     * This method returns zone statistics for a banner for a specified period.
     *
     * @access public
     *
     * @param integer $bannerId The ID of the banner to view statistics for
     * @param date $oStartDate The date from which to get statistics (inclusive)
     * @param date $oEndDate The date to which to get statistics (inclusive)
     * @param bool $localTZ Should stats be using the manager TZ or UTC?
     * @param array &$rsStatisticsData The data returned by the function
     *   <ul>
     *   <li><b>publisherID integer</b> The ID of the publisher
     *   <li><b>publisherName string (255)</b> The name of the publisher
     *   <li><b>zoneID integer</b> The ID of the zone
     *   <li><b>zoneName string (255)</b> The name of the zone
     *   <li><b>requests integer</b> The number of requests for the day
     *   <li><b>impressions integer</b> The number of impressions for the day
     *   <li><b>clicks integer</b> The number of clicks for the day
     *   <li><b>revenue decimal</b> The revenue earned for the day
     *   </ul>
     *
     * @return boolean  True if the operation was successful and false if not.
     *
     */
    function getBannerZoneStatistics($bannerId, $oStartDate, $oEndDate, $localTZ, &$rsStatisticsData)
    {
        if (!$this->checkStatisticsPermissions($bannerId)) {
            return false;
        }

        if ($this->_validateForStatistics($bannerId, $oStartDate, $oEndDate)) {
            $dalBanner = new OA_Dal_Statistics_Banner();
            $rsStatisticsData = $dalBanner->getBannerZoneStatistics($bannerId, $oStartDate, $oEndDate, $localTZ);

            return true;
        } else {
            return false;
        }
    }


}

?>
