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

require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/common.php';
require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/commonAdmin.php';

require_once MAX_PATH . '/lib/OA.php';
require_once LIB_PATH . '/Extension/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';



/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 */
class Plugins_BannerTypeHTML_vastOverlayBannerTypeHtml_vastOverlayHtml extends Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastBase
{

    /**
     * Return description of banner type
     * for the dropdown selection on the banner-edit screen
     *
     * @return string A string describing the type of plugin.
     */
    function getOptionDescription()
    {
        return $this->translate('OpenX VAST Overlay Video Ad');
    }

    
    function addVastOverlayFormatsRadioButton($form, $bannerRow, &$overlayFormatValue, &$overlayFormatJs )
    {
        $form->addElement('header', 'vast_overlay_format_header', "Overlay format");
        $overlayFormatToHandler = array(
            VAST_OVERLAY_FORMAT_TEXT => 'phpAds_formOverlayIsTextMode();',
            VAST_OVERLAY_FORMAT_SWF => 'phpAds_formOverlayIsSwfMode();',
            VAST_OVERLAY_FORMAT_IMAGE => 'phpAds_formOverlayIsImageMode();',
            VAST_OVERLAY_FORMAT_HTML => 'phpAds_formOverlayIsHtmlMode();',
        );
        $overlayFormatValue = VAST_OVERLAY_FORMAT_TEXT;
        $overlayFormatOptionToRunOnPageLoad = $overlayFormatToHandler[$overlayFormatValue];

        if ( empty( $bannerRow['vast_overlay_format'] ) ){
            // cover migration of old overlay banners
            $bannerRow['vast_overlay_format'] = $overlayFormatValue;    
        }
        
        if ( $bannerRow['vast_overlay_format'] ){
            $overlayFormatValue  = $bannerRow['vast_overlay_format'];
            $overlayFormatOptionToRunOnPageLoad = $overlayFormatToHandler[$overlayFormatValue];
        }
        
        if ( getVideoOverlaySetting( 'isVastOverlayAsTextEnabled' ) ) {
            $overlayFormats[] = $form->createElement('radio', 'vast_overlay_format', '',
                "Text Overlay",
                VAST_OVERLAY_FORMAT_TEXT, array('id' => 'vast-overlay-format-text',
                    'onClick' => $overlayFormatToHandler[VAST_OVERLAY_FORMAT_TEXT] ));            
        }
        
        if ( getVideoOverlaySetting( 'isVastOverlayAsSwfEnabled' ) ) { 
            $overlayFormats[] = $form->createElement('radio', 'vast_overlay_format', '',
                "Swf Overlay",
                VAST_OVERLAY_FORMAT_SWF, array('id' => 'vast-overlay-format-swf',
                    'onClick' => $overlayFormatToHandler[VAST_OVERLAY_FORMAT_SWF] ));            
        }
        
        if ( getVideoOverlaySetting( 'isVastOverlayAsImageEnabled' ) ) {
            $overlayFormats[] = $form->createElement('radio', 'vast_overlay_format', '',
                "Image Overlay",
                VAST_OVERLAY_FORMAT_IMAGE, array('id' => 'vast-overlay-format-image',
                    'onClick' => $overlayFormatToHandler[VAST_OVERLAY_FORMAT_IMAGE] ));            
        }        
        
        if ( getVideoOverlaySetting( 'isVastOverlayAsHtmlEnabled' ) ) {
            $overlayFormats[] = $form->createElement('radio', 'vast_overlay_format', '',
                "Html Overlay",
                VAST_OVERLAY_FORMAT_HTML, array('id' => 'vast-overlay-format-html',
                    'onClick' => $overlayFormatToHandler[VAST_OVERLAY_FORMAT_HTML] ));            
        }   

        $form->setDefaults(array('vast_overlay_format' => $overlayFormatValue));
        $form->addGroup($overlayFormats, 'overlayFormat', 'Format of the video overlay', "<br/>");
        
        $overlayFormatJs = <<<OVERLAY_FORMAT_JS
            <script type="text/javascript">

            function phpAds_formOverlayIsTextMode()
            {
                //alert( "phpAds_formOverlayIsTextMode" );
                $("#div-overlay-format-text").show('slow');
                $("#div-overlay-format-html").hide('fast');
                $("#div-overlay-format-image").hide('fast');
                $("#div-overlay-format-swf").hide('fast');
                $("#div-overlay-size").hide('fast');
                
            }
            function phpAds_formOverlayIsHtmlMode()
            {
                //alert( "phpAds_formOverlayIsHtmlMode" );
                $("#div-overlay-format-html").show('slow');
                $("#div-overlay-format-text").hide('fast');
                $("#div-overlay-format-image").hide('fast');
                $("#div-overlay-format-swf").hide('fast');
                $("#div-overlay-size").show('fast');
            }
            function phpAds_formOverlayIsSwfMode()
            {
                //alert( "phpAds_formOverlayIsSwfMode" );
                $("#div-overlay-format-swf").show('slow');
                $("#div-overlay-format-text").hide('fast');
                $("#div-overlay-format-image").hide('fast');
                $("#div-overlay-format-html").hide('fast');
                $("#div-overlay-size").show('slow');
            }
            
            function phpAds_formOverlayIsImageMode()
            {
                //alert( "phpAds_formOverlayIsImageMode" );
                $("#div-overlay-format-image").show('slow');
                $("#div-overlay-format-text").hide('fast');
                $("#div-overlay-format-html").hide('fast');
                $("#div-overlay-format-swf").hide('fast');
                $("#div-overlay-size").show('slow');
            }   
            ${overlayFormatOptionToRunOnPageLoad}

            </script>
OVERLAY_FORMAT_JS;
        
    }
    
    function addVastOverlayActionRadioButton($form, $bannerRow, &$overlayClickModeValue, &$overlayOptionJs)
    {
        $overlayActionToClickHandler = array(
            VAST_OVERLAY_CLICK_TO_PAGE => 'phpAds_formClickToWebPageMode();',
            VAST_OVERLAY_CLICK_TO_VIDEO => 'phpAds_formClickToVideoMode();',
        );  
        
        $overlayClickModeValue = VAST_OVERLAY_CLICK_TO_PAGE;
        $overlayOptionToRunOnPageLoad = $overlayActionToClickHandler[$overlayClickModeValue];

        // (For backward compatabilty / migration) 
        // we now store the vast_overlay_action explicitely
        // and do not need to derive it from the parameters stored against the banner
        if ( $bannerRow['url'] ){
            $bannerRow['vast_overlay_action'] = VAST_OVERLAY_CLICK_TO_PAGE;   
        }
        if ( empty( $bannerRow['vast_overlay_action'] ) ){
            // cover migration of old overlay banners
            $bannerRow['vast_overlay_action'] = $overlayClickModeValue;    
        }
        if ( $bannerRow['vast_overlay_action'] ){
            $overlayClickModeValue  = $bannerRow['vast_overlay_action'];
            $overlayOptionToRunOnPageLoad = $overlayActionToClickHandler[$overlayClickModeValue];
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

        $overlayClickActions[] = $form->createElement('radio', 'vast_overlay_action', '',
            "Open a page",
            VAST_OVERLAY_CLICK_TO_PAGE, array('id' => 'overlay-action-open',
                'onClick' => $overlayActionToClickHandler[VAST_OVERLAY_CLICK_TO_PAGE] ));

        $overlayClickActions[] = $form->createElement('radio', 'vast_overlay_action', '',
            "Play a video",
            VAST_OVERLAY_CLICK_TO_VIDEO, array('id' => 'overlay-action-play',
                'onClick' => $overlayActionToClickHandler[VAST_OVERLAY_CLICK_TO_VIDEO] ));

        $form->setDefaults(array('vast_overlay_action' => $overlayClickModeValue));
        $form->addGroup($overlayClickActions, 'overlayClickAction', 'When the user clicks the overlay', "<br/>");
    }

    function addVastOverlayAsHtml($form, $bannerRow)
    {
        $form->addElement('header', 'overlay_html_header', "Overlay HTML");
        $form->addDecorator ( 'overlay_html_header', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-format-html') ) );
        $form->addElement('html', 'overlay_html_info1', '<span style="font-size:100%;">This html overlay appears on top of the video as it plays</span>' );
        $htmlG['textarea'] = $form->createElement('textarea', 'htmltemplate', null,
            array(
                'class' =>'code', 'cols'=>'45', 'rows'=>'10', 'wrap'=>'off',
                'dir' => 'ltr', 'style'=>'width:550px;'
            )
        );
        $form->addGroup($htmlG, 'overlay_html_group', null, array("<br>", ""), false);
    }
    
    function addVastOverlayAsText($form, $bannerRow){
        
        $form->addElement('header', 'overlay_text_header', "Overlay Text");
        $form->addDecorator( 'overlay_text_header', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-format-text') ) );
        
        $form->addElement('html', 'overlay_text_info1', '<span style="font-size:100%;">This text overlay appears on top of the video as it plays</span>' );
        $form->addElement('text', 'vast_overlay_text_title', 'Title');
        $form->addElement('textarea', 'vast_overlay_text_description', 'Description',
            array(
                'class' =>'code', 'cols'=>'45', 'rows'=>'2', 'wrap'=>'off',
                'dir' => 'ltr', 'style'=>'width:550px;'
            )
        );
        
        $form->addElement('text', 'vast_overlay_text_call', 'Call to action'); 
    }  

    function addVastOverlayAsSwf($form, $aBanner)
    {
        $form->addElement('header', 'overlay_swf_header', "Overlay Swf");
        $form->addDecorator ( 'overlay_swf_header', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-format-swf') ) );
        $form->addElement('html', 'overlay_swf_info1', '<span style="font-size:100%;">This swf overlay appears on top of the video as it plays</span>' );
        $this->addVastFileUploadGroup( $form, $aBanner, false, 'vast_upload_file_swf' );
    } 
    
    function addVastOverlayAsImage($form, $aBanner){
        
        $form->addElement('header', 'overlay_image_header', "Overlay Image");
        $form->addDecorator ( 'overlay_image_header', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-format-image') ) );
        $form->addElement('html', 'overlay_image_info1', '<span style="font-size:100%;">This image overlay appears on top of the video as it plays</span>' );
        //$form->addElement('text', 'filename', 'filename'); 
        $this->addVastFileUploadGroup( $form, $aBanner, false, 'vast_upload_file_image' );
    } 
    
    function addVastFileUploadGroup($form, $aBanner, $allowSwfFiles, $fileFieldName )
    {
        $imageName = _getContentTypeIconImageName($aBanner['vast_creative_type']);
        $size = _getBannerSizeText($type, $aBanner['filename']);

        addUploadGroup($form, $aBanner,
            array(
                'uploadName' => $fileFieldName,
                'radioName' => 'replaceimage',
                'imageName'  => $imageName,
                'fileName'  => $aBanner['filename'],
                'fileSize'  => $size,
                'newLabel'  => $GLOBALS['strNewBannerFile'],
                'updateLabel'  => $GLOBALS['strUploadOrKeep'],
                'handleSWF' => $allowSwfFiles
              )
        );
    }
    
    function addVastOverlaySize($form, $bannerRow)
    {
        // this is done to trick the htmlforms into closing the </div> tag from the previous form
        // gave up trying to not have a header line here - would be handy to have a html banner url
        $form->addElement('header', 'overlay_size_header', "");
        $form->addDecorator ( 'overlay_size_header', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-size') ) );
        
        $vastSizeGroup['vast_overlay_width'] = $form->createElement('text', 'vast_overlay_width', 'width');
        $vastSizeGroup['vast_overlay_height'] = $form->createElement('text', 'vast_overlay_height', 'height');
        
        $form->addGroup($vastSizeGroup, 'overlay_size_group', $GLOBALS['strSize'], "&nbsp;", false);
    }
    
    
    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     * @param array $bannerRow
     */
    function buildForm(&$form, &$bannerRow)
    {
    	$selectableCompanions = $this->getPossibleCompanions();

    	$bannerRow = $this->getExtendedBannerInfo($bannerRow);
    	$isNewBanner = false;
    	if ( !isset( $bannerRow['banner_vast_element_id']) ){
    	    $isNewBanner = true;
    	}
        //parent::buildForm($form, $bannerId);
        $header = $form->createElement('header', 'header_txt', "Create an Overlay Video Ad");
        $header->setAttribute('icon', 'icon-banner-text.gif');
        $form->addElement($header);
        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());
        
        addVastHardcodedDimensionsToForm($form, $bannerRow, VAST_OVERLAY_DIMENSIONS);

        $overlayFormatValue = null;
        $overlayClickModeValue = null;
        
        $overlayFormatJs = null;
        $overlayOptionJs = null;
        
        $this->addVastOverlayFormatsRadioButton($form, $bannerRow, $overlayFormatValue, $overlayFormatJs );

        $this->addVastOverlayAsText($form, $bannerRow);
        $this->addVastOverlayAsHtml($form, $bannerRow);
        $this->addVastOverlayAsSwf($form, $bannerRow);
        $this->addVastOverlayAsImage($form, $bannerRow);

        
        $this->addVastOverlaySize($form, $bannerRow);
        
        $form->addElement('text', 'vast_creative_type', 'Vast creative type');
        
        $this->addVastOverlayActionRadioButton( $form, $bannerRow, $overlayClickModeValue, $overlayOptionJs );

        $form->addElement('header', 'video_status1', "When the user clicks the above overlay, the browser will open the following url");
        $form->addDecorator ( 'video_status1', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-action-open' ) ) );
        
        $form->addElement('text', 'url', 'Landing page URL');
        
        // Need to just open page in a new window - OXPL-344
        //$form->addElement('text', 'target', $GLOBALS['strTarget']);

        $form->addElement('header', 'video_status2', "When the user clicks the above overlay, this video will play");
        $form->addDecorator ( 'video_status2', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-action-play') ) );

        addVastParametersToForm($form, $bannerRow, $isNewBanner);


        addVastCompanionsToForm($form, $selectableCompanions);

        $form->addElement('html', 'jsForOverlayFormat', $overlayFormatJs );
        $form->addElement('html', 'jsForOverlayAction', $overlayOptionJs );
    }
}
