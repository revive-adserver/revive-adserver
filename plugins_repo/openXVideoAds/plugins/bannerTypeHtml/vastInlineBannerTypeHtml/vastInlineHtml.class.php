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
class Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastInlineHtml extends Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastBase
{
    public function getBannerShortName()
    {
        return 'Inline Video Ad';
    }

    public function getZoneToLinkShortName()
    {
        return $this->getBannerShortName();
    }

    /**
     * Return description of banner type
     * for the dropdown selection on the banner-edit screen
     *
     * @return string A string describing the type of plugin.
     */
    public function getOptionDescription()
    {
        return $this->translate($this->getBannerShortName() . ' (pre/mid/post-roll)');
    }

    public function getHelpAdTypeDescription()
    {
        return 'An ' . $this->getBannerShortName() . ' is a video ad that can be presented before, in the middle of, or after the video content and takes over the full view of the video. ';
    }

    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     * @param integer bannerId
     */
    public function buildForm(&$form, &$bannerRow)
    {
        parent::buildForm($form, $bannerRow);
        $selectableCompanions = $this->getPossibleCompanions($bannerRow);
        // for some bizarre reason $bannerid is all the fields
        $bannerRow = $this->getExtendedBannerInfo($bannerRow);
        $isNewBanner = false;
        if (!isset($bannerRow['banner_vast_element_id'])) {
            $isNewBanner = true;
        }

        $header = $form->createElement('header', 'header_txt', "Create an Inline Video Ad (pre/mid/post-roll)");
        $header->setAttribute('icon', 'icon-banner-text.gif');
        $form->addElement($header);
        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());

        $this->addIntroductionInlineHelp($form);
        $this->addVastHardcodedDimensionsToForm($form, $bannerRow, VAST_INLINE_DIMENSIONS);

        $isVideoUploadSupported = false;
        if ($isVideoUploadSupported) {
            addUploadGroup(
                $form,
                $row,
                [
                    'uploadName' => 'uploadalt',
                    'radioName' => 'replacealtimage',
                    'imageName' => $altImageName,
                    'fileSize' => $altSize,
                    'fileName' => $row['alt_filename'],
                    'newLabel' => "select incomming video file",
                    'updateLabel' => "select replacement video file",
                  ]
            );
        }
        $this->addVastParametersToForm($form, $bannerRow, $isNewBanner);
        $this->setElementIsRequired('vast_video_delivery', 'ext_bannertype', $this->getComponentIdentifier());
        $this->setElementIsRequired('vast_video_filename', 'ext_bannertype', $this->getComponentIdentifier());
        $this->setElementIsRequired('vast_video_type', 'ext_bannertype', $this->getComponentIdentifier());
        $this->setElementIsRequired('vast_video_duration', 'ext_bannertype', $this->getComponentIdentifier());

        $this->addThirdPartyImpressionTracking($form);
        $this->addVastCompanionsToForm($form, $selectableCompanions);
    }

    public function onEnable()
    {
        $oSettings = new OA_Admin_Settings();
        $oSettings->settingChange('allowedBanners', 'video', '1');
        $oSettings->writeConfigChange();
        return true;
    }
}
