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

require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/common.php';
require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/commonAdmin.php';
require_once MAX_PATH . '/lib/OA.php';
require_once LIB_PATH . '/Extension/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';

/**
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 */
class Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastInlineHtml extends Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastBase
{

    /**
     * Return description of banner type
     * for the dropdown selection on the banner-edit screen
     *
     * @return string A string describing the type of plugin.
     */
    function getOptionDescription()
    {
        return $this->translate('OpenX VAST Inline Video Banner (pre/mid/post-roll)');
    }

    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     * @param integer bannerId
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
        $header = $form->createElement('header', 'header_txt', "Create a inline video banner (pre/mid/post-roll)");
        $header->setAttribute('icon', 'icon-banner-text.gif');
        $form->addElement($header);
        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());
        addVastHardcodedDimensionsToForm($form, $bannerRow, VAST_INLINE_DIMENSIONS);
        $form->addElement('header', 'video_status', "VAST video parameters"); 
              
        $isVideoUploadSupported = false;
        if ($isVideoUploadSupported){
            addUploadGroup($form, $row,
                array(
                    'uploadName' => 'uploadalt',
                    'radioName' => 'replacealtimage',
                    'imageName'  => $altImageName,
                    'fileSize'  => $altSize,
                    'fileName'  => $row['alt_filename'],
                    'newLabel'  => "select incomming video file",
                    'updateLabel'  => "select replacement video file",
                    'handleSWF' => false
                  )
            );
        }
        addVastParametersToForm($form, $bannerRow, $isNewBanner);
        addVastCompanionsToForm($form, $selectableCompanions);
    }

    function onEnable()
    {
        $oSettings  = new OA_Admin_Settings();
        $oSettings->settingChange('allowedBanners','video','1');
        $oSettings->writeConfigChange();
        return true;
    }
}
