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
require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/common.php';
require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/commonAdmin.php';
require_once MAX_PATH . '/lib/OA.php';
require_once LIB_PATH . '/Extension/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';

/**
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 */
class Plugins_BannerTypeHTML_vastOverlayBannerTypeHtml_vastOverlayHtml extends Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastBase
{
    public const URL_FLASH_HELP_HTML_SUPPORTED = 'http://livedocs.adobe.com/flash/9.0/ActionScriptLangRefV3/flash/text/TextField.html#htmlText';

    public function getBannerShortName()
    {
        return 'Overlay Video Ad';
    }

    public function getZoneToLinkShortName()
    {
        return $this->getBannerShortName();
    }

    public function getHelpAdTypeDescription()
    {
        return 'An ' . $this->getBannerShortName() . ' is an ad that runs on top of video content during video play. When clicked, an overlay can initiate a video or open a page in a new window.';
    }

    /**
     * Return description of banner type for the dropdown selection on the banner-edit screen
     *
     * @return string A string describing the type of plugin.
     */
    public function getOptionDescription()
    {
        return $this->translate($this->getBannerShortName());
    }

    public function preprocessForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        $this->processNewUploadedFile($aFields, $aVariables);
        parent::preprocessForm($insert, $bannerid, $aFields, $aVariables);
    }

    public function addVastOverlayFormatsRadioButton($form, $bannerRow, &$overlayFormatValue, &$overlayFormatJs)
    {
        $overlayFormatToHandler = [
            VAST_OVERLAY_FORMAT_IMAGE => 'phpAds_formOverlayIsImageMode();',
            VAST_OVERLAY_FORMAT_TEXT => 'phpAds_formOverlayIsTextMode();',
            VAST_OVERLAY_FORMAT_HTML => 'phpAds_formOverlayIsHtmlMode();',
        ];
        $overlayFormatValue = VAST_OVERLAY_FORMAT_IMAGE;
        $overlayFormatOptionToRunOnPageLoad = $overlayFormatToHandler[$overlayFormatValue];

        if (empty($bannerRow['vast_overlay_format'])) {
            // cover migration of old overlay banners
            $bannerRow['vast_overlay_format'] = $overlayFormatValue;
        }

        if ($bannerRow['vast_overlay_format']) {
            $overlayFormatValue = $bannerRow['vast_overlay_format'];
            $overlayFormatOptionToRunOnPageLoad = $overlayFormatToHandler[$overlayFormatValue];
        }

        if (getVideoOverlaySetting('isVastOverlayAsImageEnabled')) {
            $overlayFormats[] = $form->createElement(
                'radio',
                'vast_overlay_format',
                '',
                "Image Overlay",
                VAST_OVERLAY_FORMAT_IMAGE,
                ['id' => 'vast-overlay-format-image',
                    'onClick' => $overlayFormatToHandler[VAST_OVERLAY_FORMAT_IMAGE] ]
            );
        }

        if (getVideoOverlaySetting('isVastOverlayAsTextEnabled')) {
            $overlayFormats[] = $form->createElement(
                'radio',
                'vast_overlay_format',
                '',
                "Text Overlay",
                VAST_OVERLAY_FORMAT_TEXT,
                ['id' => 'vast-overlay-format-text',
                    'onClick' => $overlayFormatToHandler[VAST_OVERLAY_FORMAT_TEXT] ]
            );
        }
        if (getVideoOverlaySetting('isVastOverlayAsHtmlEnabled')) {
            $overlayFormats[] = $form->createElement(
                'radio',
                'vast_overlay_format',
                '',
                "Html Overlay",
                VAST_OVERLAY_FORMAT_HTML,
                ['id' => 'vast-overlay-format-html',
                    'onClick' => $overlayFormatToHandler[VAST_OVERLAY_FORMAT_HTML] ]
            );
        }

        $form->setDefaults(['vast_overlay_format' => $overlayFormatValue]);
        $form->addGroup($overlayFormats, 'overlayFormat', 'Select the type of Overlay to create', "<br/>");

        $overlayFormatJs = <<<OVERLAY_FORMAT_JS
            <script type="text/javascript">

            function phpAds_formOverlayIsTextMode()
            {
                //alert( "phpAds_formOverlayIsTextMode" );
                $("#div-overlay-format-text").show('slow');
                $("#div-overlay-format-html").hide('fast');
                $("#div-overlay-format-image").hide('fast');
                $("#div-overlay-size").hide('fast');

            }
            function phpAds_formOverlayIsHtmlMode()
            {
                //alert( "phpAds_formOverlayIsHtmlMode" );
                $("#div-overlay-format-html").show('slow');
                $("#div-overlay-format-text").hide('fast');
                $("#div-overlay-format-image").hide('fast');
                $("#div-overlay-size").show('fast');
            }

            function phpAds_formOverlayIsImageMode()
            {
                //alert( "phpAds_formOverlayIsImageMode" );
                $("#div-overlay-format-image").show('slow');
                $("#div-overlay-format-text").hide('fast');
                $("#div-overlay-format-html").hide('fast');
                $("#div-overlay-size").show('slow');
            }
            ${overlayFormatOptionToRunOnPageLoad}

            </script>
OVERLAY_FORMAT_JS;
    }

    public function addVastOverlayActionRadioButton($form, $bannerRow, &$overlayClickModeValue, &$overlayOptionJs)
    {
        $overlayActionToClickHandler = [
            VAST_OVERLAY_CLICK_TO_PAGE => 'phpAds_formClickToWebPageMode();',
            VAST_OVERLAY_CLICK_TO_VIDEO => 'phpAds_formClickToVideoMode();',
        ];

        $overlayClickModeValue = VAST_OVERLAY_CLICK_TO_PAGE;

        $overlayClickModeValue = $form->getSubmitValue('vast_overlay_action');
        if (empty($overlayClickModeValue)
            && !empty($bannerRow['vast_overlay_action'])) {
            $overlayClickModeValue = $bannerRow['vast_overlay_action'];
        }
        $overlayOptionToRunOnPageLoad = $overlayActionToClickHandler[$overlayClickModeValue];

        // (For backward compatabilty / migration)
        // we now store the vast_overlay_action explicitely
        // and do not need to derive it from the parameters stored against the banner
        if ($bannerRow['url']) {
            $bannerRow['vast_overlay_action'] = VAST_OVERLAY_CLICK_TO_PAGE;
        }
        if (empty($bannerRow['vast_overlay_action'])) {
            // cover migration of old overlay banners
            $bannerRow['vast_overlay_action'] = $overlayClickModeValue;
        }
        $overlayOptionJs = <<<OVERLAY_OPTION_JS
            <script type="text/javascript">
            function phpAds_formClickToWebPageMode()
            {
                //alert( "phpAds_formClickToWebPageMode" );
                $("#vast_video_outgoing_filename").attr('value', '');
                $("#vast_net_connection_url").attr('value', '');
                $("#vast_video_filename").attr('value', '');
                $("#div-overlay-action-open").show('slow');
                $("#div-overlay-action-play").hide('slow');
				$('input[name=vast_video_delivery]').attr('checked',false);
            }
            function phpAds_formClickToVideoMode()
            {
                //alert( "phpAds_formClickToWebPageMode" );
                $("#url").attr('value', '');
                $("#div-overlay-action-open").hide('slow');
                $("#div-overlay-action-play").show('slow');

            }

            ${overlayOptionToRunOnPageLoad}

            </script>
OVERLAY_OPTION_JS;


        $form->addElement('header', 'overlay_click_action_header', "Overlay click action");

        $overlayClickActions[] = $form->createElement(
            'radio',
            'vast_overlay_action',
            '',
            "Open a page in a new window",
            VAST_OVERLAY_CLICK_TO_PAGE,
            ['id' => 'overlay-action-open',
                'onClick' => $overlayActionToClickHandler[VAST_OVERLAY_CLICK_TO_PAGE] ]
        );

        $overlayClickActions[] = $form->createElement(
            'radio',
            'vast_overlay_action',
            '',
            "Play a video",
            VAST_OVERLAY_CLICK_TO_VIDEO,
            ['id' => 'overlay-action-play',
                'onClick' => $overlayActionToClickHandler[VAST_OVERLAY_CLICK_TO_VIDEO] ]
        );

        $form->setDefaults(['vast_overlay_action' => $overlayClickModeValue]);
        $form->addGroup($overlayClickActions, 'overlayClickAction', 'When the user clicks the overlay', "<br/>");
    }

    public function addVastOverlayAsHtml($form, $bannerRow)
    {
        $form->addElement('header', 'overlay_html_header', "Overlay HTML");
        $form->addDecorator('overlay_html_header', 'tag', [ 'tag' => 'div', 'attributes' => ['id' => 'div-overlay-format-html'] ]);

        $supportedTags = [
            'br',
            'b',
            'font color="#hexadecimalColorOnly" face="" size=""',
            'i',
            'li',
            'u'
        ];
        foreach ($supportedTags as &$supportedTag) {
            $supportedTag = '&lt;' . $supportedTag . '&gt;';
        }
        $supportedTagString = implode(', ', $supportedTags);
        $form->addElement(
            'html',
            'overlay_html_info1',
            'The following HTML tags are supported: <code>' . $supportedTagString . '</code>. If you need to display an image in your Overlay Ad, we recommend using the Image Overlay instead.
        	<br/>All links <code>&lt;a href=""&gt</code> will be ignored: the flash player will automatically add a click layer on top of the overlay, that will initiate a video or open a page in a new window.
        	<br/>For more information about the supported HTML tags, read the <a href="' . self::URL_FLASH_HELP_HTML_SUPPORTED . '" target="_blank">Adobe ActionScript documentation</a>.

        	'
        );
        $htmlG['textarea'] = $form->createElement(
            'textarea',
            'htmltemplate',
            null,
            [ 'class' => 'code', 'cols' => '45', 'rows' => '10', 'wrap' => 'off', 'dir' => 'ltr', 'style' => 'width:550px;']
        );
        $form->addGroup($htmlG, 'overlay_html_group', null, ["<br>", ""], false);
    }

    public function addVastOverlayAsText($form, $bannerRow)
    {
        $form->addElement('header', 'overlay_text_header', "Overlay Text");
        $form->addElement(
            'html',
            'overlay_text_info',
            'A text overlay contains a title, up to two lines of description and a call to action (e.g., display URL). '
        );
        $form->addDecorator('overlay_text_header', 'tag', [ 'tag' => 'div', 'attributes' => ['id' => 'div-overlay-format-text'] ]);
        $form->addElement('text', 'vast_overlay_text_title', 'Title');
        $form->addElement(
            'textarea',
            'vast_overlay_text_description',
            'Description',
            [ 'class' => 'large', 'cols' => '45', 'rows' => '2', 'wrap' => 'off', 'dir' => 'ltr', 'style' => 'height:50px' ]
        );

        $form->addElement('text', 'vast_overlay_text_call', 'Call to action');
    }

    public function addVastOverlayAsImage($form, $aBanner)
    {
        $form->addElement('header', 'overlay_image_header', "Overlay Image");
        $form->addDecorator('overlay_image_header', 'tag', [ 'tag' => 'div', 'attributes' => ['id' => 'div-overlay-format-image'] ]);
        //$form->addElement('text', 'filename', 'filename');
        $this->addVastFileUploadGroup($form, $aBanner, VAST_OVERLAY_FORMAT_IMAGE . '_upload');
    }

    public function addVastFileUploadGroup($form, $aBanner, $fileFieldName)
    {
        $imageName = null;
        $size = null;
        $filename = null;
        if ($fileFieldName == $aBanner['vast_overlay_format'] . '_upload') {
            $imageName = _getContentTypeIconImageName($aBanner['vast_creative_type']);
            $size = _getBannerSizeText($type, $aBanner['filename']);
            $filename = $aBanner['filename'];
        }

        if (!empty($aBanner['vast_overlay_width'])
            && !empty($aBanner['vast_overlay_height'])) {
            $form->addElement('hidden', 'vast_overlay_width', $aBanner['vast_overlay_width']);
            $form->addElement('hidden', 'vast_overlay_height', $aBanner['vast_overlay_height']);
        }
        addUploadGroup(
            $form,
            $aBanner,
            [
                'uploadName' => $fileFieldName,
                'radioName' => 'replaceimage',
                'imageName' => $imageName,
                'fileName' => $filename,
                'fileSize' => $size,
                'newLabel' => $GLOBALS['strNewBannerFile'],
                'updateLabel' => $GLOBALS['strUploadOrKeep'],
              ]
        );
    }

    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     * @param array $bannerRow
     */
    public function buildForm(&$form, &$bannerRow)
    {
        parent::buildForm($form, $bannerRow);

        $selectableCompanions = $this->getPossibleCompanions($bannerRow);

        $bannerRow = $this->getExtendedBannerInfo($bannerRow);
        $isNewBanner = false;
        if (!isset($bannerRow['banner_vast_element_id'])) {
            $isNewBanner = true;
        }
        //parent::buildForm($form, $bannerId);
        $header = $form->createElement('header', 'header_txt', "Create an Overlay Video Ad");


        $header->setAttribute('icon', 'icon-banner-text.gif');
        $form->addElement($header);

        $this->addIntroductionInlineHelp($form);
        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());

        $this->addVastHardcodedDimensionsToForm($form, $bannerRow, VAST_OVERLAY_DIMENSIONS);

        $overlayFormatValue = null;
        $overlayClickModeValue = null;

        $overlayFormatJs = null;
        $overlayOptionJs = null;

        $this->addVastOverlayFormatsRadioButton($form, $bannerRow, $overlayFormatValue, $overlayFormatJs);

        $this->addVastOverlayAsImage($form, $bannerRow);
        $this->addVastOverlayAsText($form, $bannerRow);
        $this->addVastOverlayAsHtml($form, $bannerRow);

        $this->addVastOverlayActionRadioButton($form, $bannerRow, $overlayClickModeValue, $overlayOptionJs);

        $form->addElement('header', 'video_status1', "When the user clicks the above overlay, the browser will open a page in a new window");
        $form->addDecorator('video_status1', 'tag', [ 'tag' => 'div', 'attributes' => ['id' => 'div-overlay-action-open' ] ]);
        $this->addFormRequiredElement($form, ['text', 'url', $this->getFieldLabel('url')], 'vast_overlay_action', VAST_OVERLAY_CLICK_TO_PAGE);
        // Need to just open page in a new window - OXPL-344
        //$form->addElement('text', 'target', $GLOBALS['strTarget']);

        $form->addElement('header', 'video_status2', "When the user clicks the above overlay, the following video ad will play");
        $form->addDecorator('video_status2', 'tag', [ 'tag' => 'div', 'attributes' => ['id' => 'div-overlay-action-play'] ]);

        $this->addVastParametersToForm($form, $bannerRow, $isNewBanner);
        $this->addThirdPartyImpressionTracking($form);
        $this->addVastCompanionsToForm($form, $selectableCompanions);

        $form->addElement('html', 'jsForOverlayFormat', $overlayFormatJs);
        $form->addElement('html', 'jsForOverlayAction', $overlayOptionJs);
    }

    public function getFieldLabel($fieldName)
    {
        $labels = [
            'url' => $GLOBALS['strURL'],

        ];
        if (isset($labels[$fieldName])) {
            return $labels[$fieldName];
        }
        return parent::getFieldLabel($fieldName);
    }

    public function processNewUploadedFile(&$aFields, &$aVariables)
    {
        $incomingFieldName = null;
        // Deal with any files that are uploaded -
        // cant use the default banners handler for this upload field because this field
        // is on all versions of the of the overlay form (ie. for text and html)
        // so "empty filename supplied error" appear when creating a text/html overlay
        switch ($aFields['vast_overlay_format']) {
            case VAST_OVERLAY_FORMAT_IMAGE:
                $incomingFieldName = VAST_OVERLAY_FORMAT_IMAGE . '_upload';
            break;
        }
        if (empty($_FILES[$incomingFieldName]['name'])) {
            return;
        }
        $oFile = OA_Creative_File::factoryUploadedFile($incomingFieldName);
        checkForErrorFileUploaded($oFile);
        $oFile->store('web'); // store file on webserver
        $aFile = $oFile->getFileDetails();

        if (!empty($aFile)) {
            // using $aVariables here - as this is an attribute of the base class banner row
            $aVariables['filename'] = $aFile['filename'];
            $aFields['vast_creative_type'] = $aFile['contenttype'];
            $aFields['vast_overlay_width'] = $aFile['width'];
            $aFields['vast_overlay_height'] = $aFile['height'];
        }
    }
}
