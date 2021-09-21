<?php
/*
 *    Copyright (c) 2009 Bouncing Minds - Option 3 Ventures Limited
 *
 *    This file is part of the Regions plug-in for Flowplayer.
 *
 *    The Regions plug-in is free software: you can redistribute it
 *    and/or modify it under the terms of the GNU General Public License
 *    as published by the Free Software Foundation, either version 3 of
 *    the License, or (at your option) any later version.
 *
 *    The Regions plug-in is distributed in the hope that it will be
 *    useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with the plug-in.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once LIB_PATH . '/Extension/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/common.php';

abstract class Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastBase extends Plugins_BannerTypeHTML
{
    abstract public function getBannerShortName();
    abstract public function getZoneToLinkShortName();
    abstract public function getHelpAdTypeDescription();
    private $requiredElement = [];

    /**
     * Return the media (content) type
     */
    public function getContentType()
    {
        return 'html';
    }

    /**
     * return the storage type
     *
     */
    public function getStorageType()
    {
        return 'html';
    }



    private $validationFailed = false;

    public function buildForm(&$form, &$bannerRow)
    {
        if ($form->isSubmitted()) {
            $form->addElement('html', 'video_form_error', VideoAdsHelper::getWarningMessage('Validation failed!'));
        }
    }
    /**
     * This method is executed BEFORE the core banners table is written to
     *
     * @param boolean $insert
     * @param integer $bannerid
     * @param array $aFields
     * @param array $aVariables
     * @return boolean
     */
    public function preprocessForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        combineVideoUrl($aFields);
        $aVastVariables = [];
        $aVastVariables['banner_vast_element_id'] = $aFields['banner_vast_element_id'];
        $aVastVariables['vast_element_type'] = 'singlerow'; //$aFields['vast_element_type'];
        $aVastVariables['vast_video_id'] = $aFields['vast_video_id'];
        $aVastVariables['vast_video_duration'] = $aFields['vast_video_duration'];
        $aVastVariables['vast_video_delivery'] = $aFields['vast_video_delivery'];
        $aVastVariables['vast_video_type'] = $aFields['vast_video_type'];
        $aVastVariables['vast_video_bitrate'] = $aFields['vast_video_bitrate'];
        $aVastVariables['vast_video_height'] = $aFields['vast_video_height'];
        $aVastVariables['vast_video_width'] = $aFields['vast_video_width'];
        $aVastVariables['vast_video_outgoing_filename'] = $aFields['vast_video_outgoing_filename'];
        $aVastVariables['vast_video_clickthrough_url'] = $aFields['vast_video_clickthrough_url'];
        $aVastVariables['vast_overlay_height'] = $aFields['vast_overlay_height'];
        $aVastVariables['vast_overlay_width'] = $aFields['vast_overlay_width'];
        $aVastVariables['vast_overlay_text_title'] = $aFields['vast_overlay_text_title'];
        $aVastVariables['vast_overlay_text_description'] = $aFields['vast_overlay_text_description'];
        $aVastVariables['vast_overlay_text_call'] = $aFields['vast_overlay_text_call'];
        $aVastVariables['vast_overlay_format'] = $aFields['vast_overlay_format'];
        $aVastVariables['vast_overlay_action'] = $aFields['vast_overlay_action'];
        $aVastVariables['vast_companion_banner_id'] = $aFields['vast_companion_banner_id'];
        $aVastVariables['vast_creative_type'] = $aFields['vast_creative_type'];
        $aVastVariables['vast_thirdparty_impression'] = $aFields['vast_thirdparty_impression'];

        // We serialise all the data into an array which is part of the ox_banners table.
        // This is used by the deliveryEngine for serving ads and is faster then all joins
        // plus it gives us automatic caching
        $aVariables['parameters'] = serialize($aVastVariables);

        // attach the parameters to the nomal array to be stored as per normal DataObject technique
        $aVariables = array_merge($aVariables, $aVastVariables);
        return true;
    }

    /**
     * This method is executed AFTER the core banners table is written to
     *
     * @param boolean $insert
     * @param integer $bannerid
     * @param array $aFields
     * @return boolean
     */
    public function processForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        $doBanners = OA_Dal::factoryDO('banner_vast_element');
        $rowId = $aFields['banner_vast_element_id'];
        $doBanners->vast_element_type = $aFields['vast_element_type'];
        $doBanners->vast_video_id = $aFields['vast_video_id'];
        $doBanners->vast_video_duration = $aFields['vast_video_duration'];
        $doBanners->vast_video_delivery = $aFields['vast_video_delivery'];
        $doBanners->vast_video_type = $aFields['vast_video_type'];
        $doBanners->vast_video_bitrate = $aFields['vast_video_bitrate'];
        $doBanners->vast_video_height = $aFields['vast_video_height'];
        $doBanners->vast_video_width = $aFields['vast_video_width'];
        $doBanners->vast_video_outgoing_filename = $aFields['vast_video_outgoing_filename'];
        $doBanners->vast_video_clickthrough_url = $aFields['vast_video_clickthrough_url'];
        $doBanners->vast_overlay_height = $aFields['vast_overlay_height'];
        $doBanners->vast_overlay_width = $aFields['vast_overlay_width'];
        $doBanners->vast_overlay_action = $aFields['vast_overlay_action'];
        $doBanners->vast_overlay_format = $aFields['vast_overlay_format'];
        $doBanners->vast_overlay_text_title = $aFields['vast_overlay_text_title'];
        $doBanners->vast_overlay_text_description = $aFields['vast_overlay_text_description'];
        $doBanners->vast_overlay_text_call = $aFields['vast_overlay_text_call'];
        $doBanners->vast_companion_banner_id = $aFields['vast_companion_banner_id'];
        $doBanners->vast_creative_type = $aFields['vast_creative_type'];
        $doBanners->vast_thirdparty_impression = $aFields['vast_thirdparty_impression'];

        if (!$insert && ($rowId == 'banner_vast_element_id')) {
            // If the mode was update, but we dont have a valid pk value for $rowId
            // it probably because the user removed the plugin, cleaned out the table
            // and then reinstalled  - we therefore need to do an insert NOT an update
            $insert = true;
        }

        if ($insert) {
            $doBanners->banner_vast_element_id = $bannerid;
            $doBanners->banner_id = $bannerid;
            return $doBanners->insert();
        } else {
            $doBanners->whereAdd('banner_vast_element_id=' . (int)$rowId, 'AND');
            return $doBanners->update(DB_DATAOBJECT_WHEREADD_ONLY);
        }
    }


    public function getExtendedBannerInfo($banner)
    {
        $actualBannerId = $banner['bannerid'];
        $vastElements = [];
        if ($actualBannerId) {
            $vastElements = $this->fetchBannersJoined($actualBannerId);
            // For now assume 1:1 relationship
            if (isset($vastElements[0])) {
                $elementRow = $vastElements[0];
                $banner = array_merge($banner, $elementRow);
            }

            $aDeliveryFieldsNotUsed = [];
            parseVideoUrl($banner, $aDeliveryFieldsNotUsed, $banner);
        }
        return $banner;
    }

    public function fetchBannersJoined($bannerId, $fetchmode = MDB2_FETCHMODE_ORDERED)
    {
        $aConf = $GLOBALS['_MAX']['CONF']['table'];
        $oDbh = OA_DB::singleton();
        $tblB = $oDbh->quoteIdentifier($aConf['prefix'] . 'banners', true);
        $tblD = $oDbh->quoteIdentifier($aConf['prefix'] . 'banner_vast_element');
        $query = "SELECT d.* FROM " . $tblB . " b"
                     . " LEFT JOIN " . $tblD . " d ON b.bannerid = d.banner_id"
                     . " WHERE b.ext_bannertype = '" . $this->getComponentIdentifier() . "'"
                     . " AND b.bannerid = " . (int)$bannerId;
        $joinedResult = $oDbh->queryAll($query, null, MDB2_FETCHMODE_ASSOC, false, false, true);
        return $joinedResult;
    }

    /**
     * Custom validation method
     * This is executed AFTER form submit
     * Main validation is handled by adding rules to the form in buildForm()
     * which are processed prior to this method being called
     *
     * @param object $form
     * @return boolean
     */
    public function validateForm(&$form)
    {
        if ($form->isSubmitted()) {
            $errors = [];
            foreach ($this->requiredElement as $requiredElement) {
                $fieldName = $requiredElement[0];
                $fieldNameWhenRequired = $requiredElement[1];
                $fieldValueWhenRequired = $requiredElement[2];
                $fieldValueWhenRequiredSubmittedValue = $form->getSubmitValue($fieldNameWhenRequired);
                if ($fieldValueWhenRequiredSubmittedValue == $fieldValueWhenRequired) {
                    $submittedValue = $form->getSubmitValue($fieldName);
                    if (empty($submittedValue)) {
                        $errors[] = $this->getFieldLabel($fieldName);
                    }
                }
            }

            if (count($errors) == 0) {
                if ($form->getSubmitValue('vast_video_type') != 'video/webm' || $form->getSubmitValue('vast_video_delivery') == 'progressive') {
                    $form->removeElement('video_form_error');
                    return true;
                } else {
                    $errorString = 'WEBM video type is not compatible with streaming delivery';
                }
            } else {
                $errorString = 'Please provide values for all required fields: <ul><li>';
                $errorString .= implode('</li><li>', $errors);
                $errorString .= '</li></ul>';
            }

            $form->getElement('video_form_error')->setText(VideoAdsHelper::getErrorMessage($errorString));
            return false;
        }

        return true;
    }

    public function getPossibleCompanions($aBannerRow)
    {
        $aParams = [ 'placement_id' => $aBannerRow['campaignid'] ];
        $possibleCompanions = Admin_DA::_getEntities('ad', $aParams, true);
        $selectableCompanions = [ 0 => 'none' ];
        foreach ($possibleCompanions as $currentCompanion) {
            // Only allow linking to banners that are not of type "vast"
            if (strpos($currentCompanion['ext_bannertype'], 'vast') === false) {
                $strNameToDisplay = $currentCompanion['name'] . " (" . $currentCompanion['width'] . "x" . $currentCompanion['height'] . " )";
                $selectableCompanions[$currentCompanion['ad_id'] ] = $strNameToDisplay;
            }
        }
        return $selectableCompanions;
    }


    public function getAllFieldsLabels()
    {
        $labels = [
            'vast_video_type' => "Video type",
            'vast_video_duration' => "Video duration in seconds",
            'vast_net_connection_url' => "RTMP server URL",
            'vast_video_filename' => 'Video filename',
            'vast_video_filename_http' => 'Video URL', // not submitted in the form itself, but string is displayed to
            'vast_video_delivery' => 'Video delivery method',
        ];
        return $labels;
    }

    public function getFieldLabel($fieldName)
    {
        $labels = $this->getAllFieldsLabels();
        return $labels[$fieldName];
    }

    /**
     * Set a given form field "required". We can't use the required feature of quickform,
     * because this form is JS based, and depending on the selection, fields might not be required.
     *
     *  This function is used to define which fields are required ($element)
     *  and when they are required: when $fieldNameWhenRequired == $fieldValueWhenRequired
     *
     * @param $form
     * @param $element array of info that is being passed to QuickForm->addElement
     * @param $fieldNameWhenRequired string
     * @param $fieldValueWhenRequired string
     */
    public function addFormRequiredElement(&$form, $element, $fieldNameWhenRequired = null, $fieldValueWhenRequired = null)
    {
        // add the red star in the name
        $element[2] = $this->getLabelWithRequiredStar($element[2]);

        // we do not add the element as "required" in the form, as we need to test which fields
        // are required depending on overlay types, video delivery types, etc.
        call_user_func_array([$form, 'addElement'], $element);

        $fieldName = $element[1];
        $this->setElementIsRequired($fieldName, $fieldNameWhenRequired, $fieldValueWhenRequired);
    }

    public function getLabelWithRequiredStar($label)
    {
        return $label . ' <font color="red">*</font>';
    }
    public function setElementIsRequired($fieldName, $fieldNameWhenRequired, $fieldValueWhenRequired)
    {
        $this->requiredElement[] = [ $fieldName, $fieldNameWhenRequired, $fieldValueWhenRequired];
    }

    public function addVastParametersToForm(&$form, &$bannerRow, $isNewBanner)
    {
        $form->addElement('hidden', 'banner_vast_element_id', "banner_vast_element_id");
        $form->addElement('hidden', 'vast_element_type', "singlerow");

        $this->addVastVideoUrlFields($form, $bannerRow, $isNewBanner);

        $advancedUser = false;
        if ($advancedUser) {
            // Bitrate of encoded video in Kbps
            $form->addElement('text', 'vast_video_bitrate', "vast_video_bitrate");
            // Pixel dimensions of video
            $form->addElement('text', 'vast_video_width', "vast_video_width");
            $form->addElement('text', 'vast_video_height', "vast_video_height");
        } else {
            // hide these for now - the player ignores them anyway - atm
            $form->addElement('hidden', 'vast_video_bitrate', "vast_video_bitrate");
            $form->addElement('hidden', 'vast_video_width', "vast_video_width");
            $form->addElement('hidden', 'vast_video_height', "vast_video_height");
        }

        if ($isNewBanner) {
            $bannerRow['vast_video_bitrate'] = '400';
            $bannerRow['vast_video_width'] = '640';
            $bannerRow['vast_video_height'] = '480';
        }
    }

    public function addThirdPartyImpressionTracking(&$form)
    {
        $form->addElement('header', 'thirdpartyimp_title', 'Third party impression tracking');
        $form->addElement('html', 'thirdpartyimp_help', '
        	When a video ad is displayed, Revive Adserver will record the ad impression.
        	You can also specify a URL to a third party 1x1 transparent pixel.
        	The URL can contain any of the supported <a href="http://documentation.revive-adserver.com/display/DOCS/Magic+Macros" target="_blank">magic macros</a>.
        					');

        $form->addElement(
            'text',
            'vast_thirdparty_impression',
            'Impression tracking beacon URL <br>(incl. http://)'
        );
    }


    public function addVastCompanionsToForm(&$form, $selectableCompanions)
    {
        $form->addElement('header', 'companion_status', "Companion banner");
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignid = $GLOBALS['campaignid'];
        $doCampaigns->find();
        $doCampaigns->fetch();
        if (OX_Util_Utils::getCampaignType($doCampaigns->priority) == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL) {
            $form->addElement(
                'html',
                'companion_help_contract',
                '<br/><b>Note:</b> Revive Adserver currently doesn\'t support the display of a companion banner for "Contract" campaigns.
                             <br/>If you wish to display a companion banner, please select a "Remnant" or "Override" campaign.'
            );

            return;
        }
        $helpLinkPlayer = VideoAdsHelper::getHelpLinkVideoPlayerConfig();

        $form->addElement('html', 'companion_help', 'To associate a companion banner to this video ad, select a banner from the companion banner dropdown. This banner will appear for the duration of the video ad. <br/>
        					You will need to specify where this companion banner appears on the page while setting up your video ad in the video player plugin configuration. <a href="' . $helpLinkPlayer . '" target="_blank">Learn more</a>
        					');

        $form->addElement('select', 'vast_companion_banner_id', 'Companion banner', $selectableCompanions);
    }


    public function addVastHardcodedDimensionsToForm(&$form, &$bannerRow, $dimension)
    {
        $bannerRow['width'] = $dimension;
        $bannerRow['height'] = $dimension;
        $form->addElement('hidden', 'width');
        $form->addElement('hidden', 'height');
    }

    public function addIntroductionInlineHelp(&$form)
    {
        $helpString = $this->getHelpAdTypeDescription();
        $crossdomainUrl = MAX_commonConstructDeliveryUrl('crossdomain.xml');
        // because flash apps look at http://domain/crossdomain.xml, we need to construct this URL and keep only the hostname
        $crossdomainUrl = parse_url($crossdomainUrl);
        $crossdomainUrl = $crossdomainUrl['scheme'] . '://' . $crossdomainUrl['host'] . '/crossdomain.xml';

        $helpString .= "<br/><br/>To setup your " . $this->getBannerShortName() . ", you will need to:
        <ul style='list-style-type:decimal;padding-left:20px;padding-top:5px'>
        <li>Enter the information about your ad in the form below.</li>
        <li><a href='" . VideoAdsHelper::getHelpLinkOpenXPlugin() . "' target='_blank'>Link this " . $this->getBannerShortName() . " to the desired zone.</a> The zone must be of the type \"" . $this->getZoneToLinkShortName() . "\".</li>
        <li><a href='" . VideoAdsHelper::getHelpLinkVideoPlayerConfig() . "' target='_blank'>Include the zone in the ad schedule of the video player plugin configuration in your webpage.</a></li>
        <li>See the <a href='" . VideoAdsHelper::getLinkCrossdomainExample() . "' target='_blank'>details on how to ensure that Flash-based video players can load ads from " . PRODUCT_NAME . ".</a></li>
    	</ul>";
        $form->addElement('html', 'video_status_info1', '<span style="font-size:100%;">' . $helpString . '</span>');
    }

    public function addVastVideoUrlFields(&$form, &$bannerRow, $isNewBanner)
    {
        $vastVideoDelivery = $form->getSubmitValue('vast_video_delivery');
        if (empty($vastVideoDelivery)
            && !empty($bannerRow['vast_video_delivery'])) {
            $vastVideoDelivery = $bannerRow['vast_video_delivery'];
        }

        if ($vastVideoDelivery == 'progressive') {
            $urlFormatMode = VAST_VIDEO_URL_PROGRESSIVE_FORMAT;
            $videoUrlFormatOptionToRunOnPageLoad = " phpAds_formHttpProgressiveVideoUrlMode();";
        } else {
            $urlFormatMode = VAST_VIDEO_URL_STREAMING_FORMAT;
            $videoUrlFormatOptionToRunOnPageLoad = " phpAds_formRtmpStreamingVideoUrlMode();";
        }

        $httpVideoUrlString = $this->getLabelWithRequiredStar($this->getFieldLabel('vast_video_filename_http'));
        $videoFilenameString = $this->getLabelWithRequiredStar($this->getFieldLabel('vast_video_filename'));

        $videoUrlFomatOptionJs = <<<VIDEO_FORMAT_OPTION_JS
            <script type="text/javascript">
            function phpAds_formRtmpStreamingVideoUrlMode()
            {
                $("#vast_video_delivery").attr('value', 'streaming');
                $("label[for=vast_net_connection_url]").show();
                $("#vast_net_connection_url").show();
                $("label[for=vast_video_filename]").html('${videoFilenameString}');
            }
            function phpAds_formHttpProgressiveVideoUrlMode()
            {
                $("#vast_net_connection_url").attr('value', '');
                $("#vast_video_delivery").attr('value', 'progressive');
                $("label[for=vast_net_connection_url]").hide();
                $("#vast_net_connection_url").hide();
                $("label[for=vast_video_filename]").html('${httpVideoUrlString}');
            }
            $(document).ready( function(){
                ${videoUrlFormatOptionToRunOnPageLoad};
            });
            </script>
VIDEO_FORMAT_OPTION_JS;

        $videoUrlFormats[] = $form->createElement(
            'radio',
            'vast_video_delivery',
            '',
            'streaming (RTMP)',
            VAST_VIDEO_URL_STREAMING_FORMAT,
            ['id' => 'video-url-format-streaming', 'onClick' => 'phpAds_formRtmpStreamingVideoUrlMode();' ]
        );

        $videoUrlFormats[] = $form->createElement(
            'radio',
            'vast_video_delivery',
            '',
            'progressive (HTTP)',
            VAST_VIDEO_URL_PROGRESSIVE_FORMAT,
            ['id' => 'video-url-format-progressive', 'onClick' => 'phpAds_formHttpProgressiveVideoUrlMode();' ]
        );
        $this->setElementIsRequired('vast_video_delivery', 'vast_overlay_action', VAST_OVERLAY_CLICK_TO_VIDEO);
        $form->addGroup($videoUrlFormats, 'VideoFormatAction', $this->getLabelWithRequiredStar($this->getFieldLabel('vast_video_delivery')), "<br/>");
        $this->addFormRequiredElement(
            $form,
            ['text', 'vast_net_connection_url', $this->getFieldLabel('vast_net_connection_url')],
            'vast_video_delivery',
            VAST_VIDEO_URL_STREAMING_FORMAT
        );
        $this->addFormRequiredElement(
            $form,
            ['text', 'vast_video_filename', $this->getFieldLabel('vast_video_filename')],
            'vast_overlay_action',
            VAST_OVERLAY_CLICK_TO_VIDEO
        );
        $form->addElement('html', 'jsForVideoFormat', $videoUrlFomatOptionJs);

        $vastVideoType = getVastVideoTypes();
        // adding empty SELECT entry to ensure users make a decision and select the right Video type
        $vastVideoType = array_merge([ '' => ''], $vastVideoType);

        $this->addFormRequiredElement(
            $form,
            ['select', 'vast_video_type', $this->getFieldLabel('vast_video_type'), $vastVideoType],
            'vast_overlay_action',
            VAST_OVERLAY_CLICK_TO_VIDEO
        );
        $this->addFormRequiredElement(
            $form,
            ['text', 'vast_video_duration', $this->getFieldLabel('vast_video_duration')],
            'vast_overlay_action',
            VAST_OVERLAY_CLICK_TO_VIDEO
        );
        $form->addElement('text', 'vast_video_clickthrough_url', "Destination URL (incl. http://) <br />when user clicks on the video");
    }
}
