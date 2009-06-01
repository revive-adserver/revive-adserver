<?php 
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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

        $aVastVariables = array();
        
        $aVastVariables['banner_vast_element_id'] = $aFields['banner_vast_element_id'];
        $aVastVariables['vast_element_type'] = 'singlerow'; //$aFields['vast_element_type'];
        $aVastVariables['vast_video_id'] = $aFields['vast_video_id'];
        $aVastVariables['vast_video_duration'] = $aFields['vast_video_duration'];
        $aVastVariables['vast_video_delivery'] = $aFields['vast_video_delivery'];

        // auto choose the vast_video_type for the user
        if ( strpos( $aFields['vast_video_outgoing_filename'], '/mp4:' ) ){
            $aFields['vast_video_type'] = 'video/x-mp4';
        }
        else if ( strpos( $aFields['vast_video_outgoing_filename'], '/flv:' ) ){
            $aFields['vast_video_type'] = 'video/x-flv';
        }        
        
        $aVastVariables['vast_video_type'] = $aFields['vast_video_type'];
        $aVastVariables['vast_video_bitrate'] = $aFields['vast_video_bitrate'];
        $aVastVariables['vast_video_height'] = $aFields['vast_video_height'];
        $aVastVariables['vast_video_width'] = $aFields['vast_video_width'];
        $aVastVariables['vast_video_outgoing_filename'] = $aFields['vast_video_outgoing_filename'];
        $aVastVariables['vast_companion_banner_id'] = $aFields['vast_companion_banner_id'];
        $aVastVariables['vast_net_connection_url'] = $aFields['vast_net_connection_url'];
        $aVastVariables['vast_overlay_height'] = $aFields['vast_overlay_height'];
        $aVastVariables['vast_overlay_width'] = $aFields['vast_overlay_width'];
        
        // We serialise all the data into an array which is part of the ox_banners table. 
        // This is used by the deliveryEngine for serving ads and is faster then all joins
        // plus it gives us automatic caching 
        $aVariables['parameters'] = serialize($aVastVariables);
                
        //$check = unserialize( $aVariables['parameters'] );

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
        $doBanners->vast_companion_banner_id        = $aFields['vast_companion_banner_id'];
        $doBanners->vast_net_connection_url         = $aFields['vast_net_connection_url'];
        $doBanners->vast_overlay_height             = $aFields['vast_overlay_height'];
        $doBanners->vast_overlay_width              = $aFields['vast_overlay_width'];
        
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
            $doBanners->whereAdd('banner_vast_element_id='.$rowId, 'AND');
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
                     ." AND b.bannerid = $bannerId";
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
    $form->addElement('html', 'video_status_info1', '<span style="font-size:100%;">These fields are served to the VAST-compliant video player</span>' ); 
    $form->addElement('hidden', 'banner_vast_element_id', "banner_vast_element_id"); 
    $form->addElement('hidden', 'vast_element_type', "singlerow");        
    $form->addElement('text', 'vast_video_id', "Your internal video id");   
    $vastDeliveryOptions = array( 'streaming' =>  'streaming', 
                                  'progressive' => 'progressive',
                                );
    $formElementDeliveryType = $form->addElement('select', 'vast_video_delivery', "Video delivery", $vastDeliveryOptions );  
    $formElementDeliveryType->setAttribute( 'disabled', false );
    $vastVideoType = getVastVideoTypes();        
    $formElementVideoType = $form->addElement('select', 'vast_video_type', "Video type", $vastVideoType );
    $formElementVideoType->setAttribute( 'disabled', false );
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

    $showNetConnectionUrl = false;
    if ( $showNetConnectionUrl ){
        $form->addElement('text', 'vast_net_connection_url', "Video net connection url");
        // $form->addElement('html', 'video_status_info4', '<span style="font-size:80%;">**<strong>outgoing video filename</strong> format should be: rtmp://cdn-domain/path-to-cdn-account/mp4:filename.mp4</span>' ); 
    }
    
    $form->addElement('text', 'vast_video_outgoing_filename', "Outgoing video filename");
    $form->addElement('html', 'video_filename_format_info', "<span style=\"font-size:80%;\">(Must be an rtmp URL to an mp4 file. Use the format: rtmp://cdn-domain/path-to-cdn-account/mp4:filename.mp4)</span>" );
    $form->addElement('text', 'vast_video_duration', "Video duration in seconds");
    $form->addElement('html', 'video_status_info2', '<span style="font-size:80%;">*video upload and transcode not yet supported</span>' );
    $sampleUrl = "rtmp://ne7c0nwbit.rtmphost.com/VideoPlayer/mp4:ads/30secs/bigger_badminton_600.mp4";
    $form->addElement('html', 'video_status_info3', "<span style=\"font-size:80%;\">**<strong>Outgoing video filename</strong> only supports rtmp URLs to mp4 files currently. For a sample filename, try using: <strong>$sampleUrl</strong></span>" );   
 
    $enableDefaultValues = true;
    if ( $isNewBanner && $enableDefaultValues ){
        $bannerRow['vast_video_outgoing_filename'] = '';
        $bannerRow['vast_video_duration'] = '30';
        $bannerRow['vast_overlay_width'] = '600';
        $bannerRow['vast_overlay_height'] = '400';
        $bannerRow['vast_video_delivery'] = 'streaming';
        $bannerRow['vast_video_type'] = 'video/x-mp4';        
    }
}

function addVastCompanionsToForm( &$form, $selectableCompanions)
{
    // ----- Now the Companion status
    $form->addElement('header', 'companion_status', "Companion banners");        
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
