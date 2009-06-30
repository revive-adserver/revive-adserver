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

    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     * @param array $bannerRow
     */
    function buildForm(&$form, &$bannerRow)
    {
    	$selectableCompanions = $this->getPossibleCompanions();

    	// for some bizarre reason $bannerid is all the fields
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
        $form->addElement('header', 'header_b_links', "Overlay HTML");
        $form->addElement('html', 'overlay_info1', '<span style="font-size:100%;">This html overlay appears on top of the video as it plays</span>' );
        $htmlG['textarea'] = $form->createElement('textarea', 'htmltemplate', null,
            array(
                'class' =>'code', 'cols'=>'45', 'rows'=>'10', 'wrap'=>'off',
                'dir' => 'ltr', 'style'=>'width:550px;'
            ));
        $form->addGroup($htmlG, 'html_banner_g', null, array("<br>", ""), false);
        $htmlSizeG['vast_overlay_width'] = $form->createElement('text', 'vast_overlay_width', 'width');
        $htmlSizeG['vast_overlay_height'] = $form->createElement('text', 'vast_overlay_height', 'height');
        $form->addGroup($htmlSizeG, 'html_size', $GLOBALS['strSize'], "&nbsp;", false);

        define( 'VAST_OVERLAY_CLICK_TO_PAGE', 1 );
        define( 'VAST_OVERLAY_CLICK_TO_VIDEO', 2 );

        $overlayClickModeValue = VAST_OVERLAY_CLICK_TO_PAGE;
        $overlayOptionToRunOnPageLoad = "phpAds_formClickToVideoMode()";

        if ( $bannerRow['url'] ){

            //click to page
            $overlayClickModeValue  = VAST_OVERLAY_CLICK_TO_PAGE;
            $overlayOptionToRunOnPageLoad = " phpAds_formClickToWebPageMode();";
        }
        else {
            // click to video
            $overlayClickModeValue  = VAST_OVERLAY_CLICK_TO_VIDEO;
            $overlayOptionToRunOnPageLoad = " phpAds_formClickToVideoMode();";
        }


        $overlayOptionJs = <<<OVERLAY_OPTION_JS
            <script type="text/javascript">

            function phpAds_formClickToWebPageMode()
            {

                $("#div-overlay-action-open").show('slow');
                $("#div-overlay-action-play").hide('slow');

                // clear the value
                $("#vast_video_outgoing_filename").attr('value', '');


            }
            function phpAds_formClickToVideoMode()
            {

                // clear the value
                $("#url").attr('value', '');

                $("#div-overlay-action-open").hide('slow');
                $("#div-overlay-action-play").show('slow');

            }

            ${overlayOptionToRunOnPageLoad}

            </script>
OVERLAY_OPTION_JS;


        $form->addElement('header', 'overlay_click_action', "Overlay click action");

        //zone type group
        $overlayClickActions[] = $form->createElement('radio', 'overlay-action', '',
            "Open a page",
            VAST_OVERLAY_CLICK_TO_PAGE, array('id' => 'overlay-action-open',
                'onClick' => 'phpAds_formClickToWebPageMode();' ));

        $overlayClickActions[] = $form->createElement('radio', 'overlay-action', '',
            "Play a video",
            VAST_OVERLAY_CLICK_TO_VIDEO, array('id' => 'overlay-action-play',
                'onClick' => 'phpAds_formClickToVideoMode();' ));


        $form->setDefaults(array('overlay-action' => $overlayClickModeValue));


        $form->addGroup($overlayClickActions, 'overlayClickAction', 'When the user clicks the overlay', "<br/>");

        $form->addElement('header', 'video_status1', "When the user clicks the above overlay, the browser will open the following url");

        $form->addElement('text', 'url', 'Landing page URL');
        
        // Need to just open page in a new window - OXPL-344
        //$form->addElement('text', 'target', $GLOBALS['strTarget']);

        $form->addDecorator ( 'video_status1', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-action-open' ) ) );

        $form->addElement('header', 'video_status2', "When the user clicks the above overlay, this video will play");

        $form->addDecorator ( 'video_status2', 'tag', array ( 'tag' => 'div', 'attributes' => array ('id' => 'div-overlay-action-play') ) );

        addVastParametersToForm($form, $bannerRow, $isNewBanner);


        addVastCompanionsToForm($form, $selectableCompanions);

        $form->addElement('html', 'jsFor1', $overlayOptionJs );
    }
}
