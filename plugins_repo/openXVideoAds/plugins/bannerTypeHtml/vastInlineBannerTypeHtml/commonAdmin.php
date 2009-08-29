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


class Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastBase extends Plugins_BannerTypeHTML
{

    /**
     * Return the media (content) type
     *
     */
    function getContentType()
    {
        return 'html';
    }

    /**
     * return the storage type
     *
     */
    function getStorageType()
    {
        return 'html';
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
    function preprocessForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        /*
        $actualBannerId = $bannerid;

        $vastElements = array();

        if ( $actualBannerId ){

           $vastElements = $this->fetchBannersJoined($actualBannerId);
        }*/

        //$aVariables['htmltemplate'] = $this->_buildHtmlTemplate($aVariables);
        //$aVariables['comments']     = $this->translate('Demonstration OpenX Banner Type ID %s', array($aFields['bannerid']));

        // Determine everything about the files delivery and format simply from the format of the url
        $aDelivery = array();  
        
        processNewUploadedFile( $aFields, $aVariables );
       
        combineVideoUrl( $aFields );
        
        $aVastVariables = array();

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
        $aVastVariables['vast_companion_banner_id'] = $aFields['vast_companion_banner_id'];
        $aVastVariables['vast_overlay_height'] = $aFields['vast_overlay_height'];
        $aVastVariables['vast_overlay_width'] = $aFields['vast_overlay_width'];
        
        $aVastVariables['vast_video_clickthrough_url'] = $aFields['vast_video_clickthrough_url'];        
       
        $aVastVariables['vast_overlay_text_title'] = $aFields['vast_overlay_text_title']; 
        $aVastVariables['vast_overlay_text_description'] = $aFields['vast_overlay_text_description'];
        $aVastVariables['vast_overlay_text_call'] = $aFields['vast_overlay_text_call'];
        
        $aVastVariables['vast_overlay_format'] = $aFields['vast_overlay_format'];
        $aVastVariables['vast_overlay_action'] = $aFields['vast_overlay_action'];

        $aVastVariables['vast_creative_type'] = $aFields['vast_creative_type'];

        
        // We serialise all the data into an array which is part of the ox_banners table.
        // This is used by the deliveryEngine for serving ads and is faster then all joins
        // plus it gives us automatic caching
        $aVariables['parameters'] = serialize($aVastVariables);

        //$check = unserialize( $aVariables['parameters'] );
        
        ///$aVariables['filename'] = $aFields['filename'];

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
    function processForm($insert, $bannerid, $aFields)
    {
        $doBanners = OA_Dal::factoryDO('banner_vast_element');
        $rowId = $aFields['banner_vast_element_id'];
        $doBanners->vast_element_type               = $aFields['vast_element_type'];
        $doBanners->vast_video_id                   = $aFields['vast_video_id'];
        $doBanners->vast_video_duration             = $aFields['vast_video_duration'];
        $doBanners->vast_video_delivery             = $aFields['vast_video_delivery'];
        $doBanners->vast_video_type                 = $aFields['vast_video_type'];
        $doBanners->vast_video_bitrate              = $aFields['vast_video_bitrate'];
        $doBanners->vast_video_height               = $aFields['vast_video_height'];
        $doBanners->vast_video_width                = $aFields['vast_video_width'];
        $doBanners->vast_video_outgoing_filename    = $aFields['vast_video_outgoing_filename'];
        $doBanners->vast_video_clickthrough_url     = $aFields['vast_video_clickthrough_url'];
        $doBanners->vast_overlay_height             = $aFields['vast_overlay_height'];
        $doBanners->vast_overlay_width              = $aFields['vast_overlay_width'];
        $doBanners->vast_overlay_action             = $aFields['vast_overlay_action'];
        $doBanners->vast_overlay_format             = $aFields['vast_overlay_format'];
        $doBanners->vast_overlay_text_title         = $aFields['vast_overlay_text_title'];
        $doBanners->vast_overlay_text_description   = $aFields['vast_overlay_text_description'];
        $doBanners->vast_overlay_text_call          = $aFields['vast_overlay_text_call'];
        $doBanners->vast_companion_banner_id        = $aFields['vast_companion_banner_id'];
        $doBanners->vast_creative_type       = $aFields['vast_creative_type'];
        
        if ( !$insert && ($rowId == 'banner_vast_element_id') ){
            // If the mode was update, but we dont have a valid pk value for $rowId
            // it probably because the user removed the plugin, cleaned out the table
            // and then reinstalled  - we therefore need to do an insert NOT an update
            $insert = true;
        }

        if ($insert)
        {
            $doBanners->banner_vast_element_id = $bannerid;
            $doBanners->banner_id            = $bannerid;
            return $doBanners->insert();
        }
        else
        {
            $doBanners->whereAdd('banner_vast_element_id='. (int)$rowId, 'AND');
            return $doBanners->update(DB_DATAOBJECT_WHEREADD_ONLY);
        }
    }


    function getExtendedBannerInfo($banner){
        $actualBannerId = $banner['bannerid'];
        $vastElements = array();
        if ( $actualBannerId ){
            $vastElements = $this->fetchBannersJoined($actualBannerId);
            // For now assume 1:1 relationship
            if ( isset($vastElements[0]) ){
                $elementRow = $vastElements[0];
                $banner = array_merge( $banner, $elementRow );
            }
            
            $aDeliveryFieldsNotUsed = array();
            parseVideoUrl( $banner, $aDeliveryFieldsNotUsed, $banner );
        }
        return $banner;
    }

    function fetchBannersJoined($bannerId, $fetchmode=MDB2_FETCHMODE_ORDERED)
    {
        debugDump( "BANNER ID ", $bannerId );

        $aConf  = $GLOBALS['_MAX']['CONF']['table'];
        $oDbh   = OA_DB::singleton();
        $tblB   = $oDbh->quoteIdentifier($aConf['prefix'].'banners',true);
        $tblD   = $oDbh->quoteIdentifier($aConf['prefix'].'banner_vast_element');
        $query  = "SELECT d.* FROM ".$tblB." b"
                     ." LEFT JOIN ".$tblD." d ON b.bannerid = d.banner_id"
                     ." WHERE b.ext_bannertype = '".$this->getComponentIdentifier()."'"
                     ." AND b.bannerid = ".(int)$bannerId;
        debugDump( "BANNER JOIN IS ", $query );
        $joinedResult = $oDbh->queryAll($query, null, MDB2_FETCHMODE_ASSOC, false, false, true );
        debugDump( "JOINED FIELDS", $joinedResult );
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
    function validateForm(&$form)
    {
        return true;
    }

    function getPossibleCompanions()
    {
        phpAds_registerGlobal('campaignid');
        $aParams = array( 'placement_id' => $campaignid );
        $possibleCompanions = Admin_DA::_getEntities('ad', $aParams, true);
        debugDump( 'possibleCompanions', $possibleCompanions );
        $selectableCompanions = array( 0 => 'none' );
        foreach( $possibleCompanions as $currentCompanion ){
            // Only allow linking to banners that are not of type "vast"
            if ( strpos( $currentCompanion['ext_bannertype'], 'vast' ) === false ){
                $strNameToDisplay = $currentCompanion['name'] . " (" . $currentCompanion['width'] . "x" . $currentCompanion['height'] . " )";
                $selectableCompanions[$currentCompanion['ad_id'] ] = $strNameToDisplay;
            }
        }
        return $selectableCompanions;
    }
}

/// Outside of the class

function addVastParametersToForm(&$form, &$bannerRow, $isNewBanner)
{
    $form->addElement('html', 'video_status_info1', '<span style="font-size:100%;">These fields define the Video Ad that will be served to the VAST-compliant video player.</span>' );
    $form->addElement('hidden', 'banner_vast_element_id', "banner_vast_element_id");
    $form->addElement('hidden', 'vast_element_type', "singlerow");
    
    // Users are confused by the use of the Id thinking its a number
    // changed this to "description" in the GUI
    if ( false ){
         $form->addElement('text', 'vast_video_id', "Your internal video description");
    }
    
    addVastVideoUrlFields($form, $bannerRow, $isNewBanner);
         
    $vastVideoType = getVastVideoTypes();
    $formElementVideoType = $form->addElement('select', 'vast_video_type', "Video type", $vastVideoType );

    $advancedUser = false;
    if ( $advancedUser ){
        // Bitrate of encoded video in Kbps
        $form->addElement('text', 'vast_video_bitrate', "vast_video_bitrate");

        // Pixel dimensions of video
        $form->addElement('text', 'vast_video_width', "vast_video_width");
        $form->addElement('text', 'vast_video_height', "vast_video_height");
    }
    else {
        // hide these for now - the player ignores them anyway - atm
        $form->addElement('hidden', 'vast_video_bitrate', "vast_video_bitrate");
        $form->addElement('hidden', 'vast_video_width', "vast_video_width");
        $form->addElement('hidden', 'vast_video_height', "vast_video_height");
    }

    if ( $isNewBanner ){
        $bannerRow['vast_video_bitrate'] = '400';
        $bannerRow['vast_video_width'] = '640';
        $bannerRow['vast_video_height'] = '480';
    }
    
    $form->addElement('text', 'vast_video_duration', "Video duration in seconds");
    $form->addElement('text', 'vast_video_clickthrough_url', "Video click-through url");
    
    $sampleUrlMp4NetConnection = "rtmp://cp67126.edgefcs.net/ondemand/";
    $sampleUrlMp4Filename = "mediapm/ovp/content/demo/video/elephants_dream/elephants_dream_768x428_24.0fps_608kbps.mp4";
    
    $sampleUrlFlvNetConnection = "rtmp://cp67126.edgefcs.net/ondemand/";
    $sampleUrlFlvFilename = "mediapm/ovp/content/test/video/Akamai_10_Year_F8_512K";

    $sampleUrlHttpMp4Filename = "http://marketing.openx.org/video-ads-sample/OpenX-Ad-Sample-Koi-Fish.flv";
    $sampleUrlHttpFlvFilename = "http://marketing.openx.org/video-ads-sample/OpenX-Ad-Sample-Koi-Fish.mp4";
    
    $form->addElement('html', 'video_status_info_rtmp_mp4', "<span style=\"font-size:90%;\">** <strong>Rtmp mp4 video example</strong>, try using:  
    <br/>Net connection url:<strong>$sampleUrlMp4NetConnection</strong><br/>Outgoing filename:<strong>$sampleUrlMp4Filename</strong>
    
    </span>" );

    $form->addElement('html', 'video_status_info_rtmp_flv', "<span style=\"font-size:90%;\">** <strong>Rtmp flv video example</strong>, try using: 
    <br/>Net connection url:<strong>$sampleUrlFlvNetConnection</strong><br/>Outgoing filename:<strong>$sampleUrlFlvFilename</strong>
    </span>" ); 
    
    $form->addElement('html', 'video_status_info_http_mp4', "<span style=\"font-size:90%;\">** <strong>Http mp4 video example</strong>, try using: 
    <br/>Filename:<strong>$sampleUrlHttpMp4Filename</strong>
    </span>" );   
      
     $form->addElement('html', 'video_status_info_http_flv', "<span style=\"font-size:90%;\">** <strong>Http flv video example</strong>, try using: 
    <br/>Filename:<strong>$sampleUrlHttpFlvFilename</strong>
    </span>" );      
    
    $enableDefaultValues = true;
    if ( $isNewBanner && $enableDefaultValues ) {
        $bannerRow['vast_video_outgoing_filename'] = '';
        $bannerRow['vast_video_duration'] = '30';
        $bannerRow['vast_overlay_width'] = '600';
        $bannerRow['vast_overlay_height'] = '40';
        $bannerRow['vast_video_delivery'] = 'streaming';
        $bannerRow['vast_video_type'] = 'video/x-mp4';
    }
}

function addVastCompanionsToForm( &$form, $selectableCompanions)
{
    // ----- Now the Companion status
    $form->addElement('header', 'companion_status', "Companion banners");
    $form->addElement('html', 'companion_help', 'To associate a companion banner to this video ad, select a banner from the companion banner dropdown. This banner will appear for the duration of the video ad. <br/>
    					You will need to specify where this companion banner appears on the page while setting up your video ad in the video player plugin configuration; please read the documentation for more information.');
    $form->addElement('select','vast_companion_banner_id','Companion banner', $selectableCompanions);
    $form->addElement('html', 'video_status_info4', '<span style="font-size:80%;">***Only one companion from the current campaign supported</span>' );
}

function addVastHardcodedDimensionsToForm(&$form, &$bannerRow, $dimension)
{
        // $form->setDefaults( $defaultFormValues ); will make these values the default.
        $bannerRow['width'] = $dimension;
        $bannerRow['height'] = $dimension;
        $form->addElement('hidden', 'width' );
        $form->addElement('hidden', 'height');
}

function addVastVideoUrlFields(&$form, &$bannerRow, $isNewBanner){

        define( 'VAST_VIDEO_URL_STREAMING_FORMAT', 'streaming' );
        define( 'VAST_VIDEO_URL_PROGRESSIVE_FORMAT', 'progressive' );
        
        $urlFormatMode = VAST_VIDEO_URL_STREAMING_FORMAT;
        
        
        $videoUrlFormatOptionToRunOnPageLoad = "phpAds_formRtmpStreamingVideoUrlMode()";

        if ( $bannerRow['vast_video_delivery'] == 'streaming' ){

            //click to page
            $urlFormatMode  = VAST_VIDEO_URL_STREAMING_FORMAT;
            $videoUrlFormatOptionToRunOnPageLoad = " phpAds_formRtmpStreamingVideoUrlMode();";
        }
        elseif ( $bannerRow['vast_video_delivery'] == 'progressive' ) {
            
            // click to video
            $urlFormatMode  = VAST_VIDEO_URL_PROGRESSIVE_FORMAT;
            $videoUrlFormatOptionToRunOnPageLoad = " phpAds_formHttpProgressiveVideoUrlMode();";
        }

        $videoUrlFomatOptionJs = <<<VIDEO_FORMAT_OPTION_JS
            <script type="text/javascript">

            function phpAds_formRtmpStreamingVideoUrlMode()
            {

                $("#vast_video_delivery").attr('value', 'streaming');
                $("label[for=vast_net_connection_url]").show('slow'); 
                $("#vast_net_connection_url").show('slow'); 
                                       
            }
            function phpAds_formHttpProgressiveVideoUrlMode()
            {

                // clear the value
                $("#vast_net_connection_url").attr('value', '');
                
                $("#vast_video_delivery").attr('value', 'progressive'); 
                
                $("label[for=vast_net_connection_url]").hide('slow'); 
                $("#vast_net_connection_url").hide('slow');
               
            }

            ${videoUrlFormatOptionToRunOnPageLoad};

            </script>
VIDEO_FORMAT_OPTION_JS;

        $videoUrlFormats[] = $form->createElement('radio', 'vast_video_delivery', '',
            "streaming (RTMP)",
            VAST_VIDEO_URL_STREAMING_FORMAT, array('id' => 'video-url-format-streaming',
                'onClick' => 'phpAds_formRtmpStreamingVideoUrlMode();' ));

        $videoUrlFormats[] = $form->createElement('radio', 'vast_video_delivery', '',
            "progressive / pseudo-streaming (HTTP)",
            VAST_VIDEO_URL_PROGRESSIVE_FORMAT, array('id' => 'video-url-format-progressive',
                'onClick' => 'phpAds_formHttpProgressiveVideoUrlMode();' ));


        $form->setDefaults(array('vast_video_delivery' => $urlFormatMode));


        $form->addGroup($videoUrlFormats, 'VideoFormatAction', 'Video delivery mechanism', "<br/>");

        $form->addElement('text', 'vast_net_connection_url', "Video net connection url" );
        $form->addElement('text', 'vast_video_filename', "Video filename");
        
        // vast_video_outgoing_filename is used in the db - but presented as vast_net_connection_url and vast_video_filename
        //$form->addElement('text', 'vast_video_outgoing_filename', "Video outgoing filename");

        $form->addElement('html', 'jsForVideoFormat', $videoUrlFomatOptionJs );
        
}

function processNewUploadedFile( &$aFields, &$aVariables ){

    $incomingFieldName = null;
    
    // Deal with any files that are uploaded - 
    // cant use the default banners handler for this upload field because this field 
    // is on all versions of the of the overlay form (ie. for text and html)
    // so "empty filename supplied error" appear when creating a text/html overlay
    //
    if ( $aFields['vast_overlay_format'] == VAST_OVERLAY_FORMAT_IMAGE ){
    
         if (!empty($_FILES['vast_upload_file_image'])){
            $incomingFieldName = 'vast_upload_file_image';
         }
    }

    if ( $aFields['vast_overlay_format'] == VAST_OVERLAY_FORMAT_SWF ){
    
        if (!empty($_FILES['vast_upload_file_swf'])){    
            $incomingFieldName = 'vast_upload_file_swf'; 
        }
    }
    
    if ( $incomingFieldName ){
        
        $oFile = OA_Creative_File::factoryUploadedFile( $incomingFieldName );
        
        checkForErrorFileUploaded($oFile);
        $oFile->store('web'); // store file on webserver
        $aFile = $oFile->getFileDetails();
    
        if (!empty($aFile)) {
            
            // using $aVariables here - as this is an attribute of the base class banner row
            $aVariables['filename']  = $aFile['filename'];
            
            $aFields['vast_creative_type']           = $aFile['contenttype'];
            $aFields['vast_overlay_width']           = $aFile['width'];
            $aFields['vast_overlay_height']          = $aFile['height'];
            $aFields['vast_swf_plugin_version']      = $aFile['pluginversion'];
        }
    }    
}
