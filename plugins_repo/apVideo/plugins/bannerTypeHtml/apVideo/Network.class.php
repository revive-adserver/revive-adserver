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

require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/common.php';
require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/commonAdmin.php';
require_once MAX_PATH . '/lib/OA.php';
require_once LIB_PATH . '/Extension/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';


class Plugins_BannerTypeHTML_apVideo_Network extends Plugins_BannerTypeHTML_vastInlineBannerTypeHtml_vastBase
{
    public function getBannerShortName()
    {
        return $this->translate('Inline Network Video Ad');
    }

    public function getZoneToLinkShortName()
    {
        return $this->translate('Inline Video Ad');
    }

    public function getHelpAdTypeDescription()
    {
        return $this->translate('An Inline Network Video Ad will return a video ad from a 3rd party ad network.');
    }

    public function getOptionDescription()
    {
        return $this->translate($this->getBannerShortName());
    }

    public function preprocessForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        // Do nothing here
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

        $bannerRow = $this->getExtendedBannerInfo($bannerRow);

        $header = $form->createElement('header', 'header_txt', $this->translate("Create an Inline Network Video Ad"));

        $header->setAttribute('icon', 'icon-banner-text.gif');
        $form->addElement($header);

        $this->addIntroductionInlineHelp($form);
        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());

        $this->addVastHardcodedDimensionsToForm($form, $bannerRow, VAST_INLINE_DIMENSIONS);

        $form->addElement('header', 'header_url', $this->translate("Banner Details"));
        $form->addElement('text', 'bannertext', $this->translate('Ad Network VAST URL'));

        $form->addRule('bannertext', $this->translate("URL is required"), 'required');
        $form->addRule('bannertext', $this->translate("URL is not valid"), 'regex', '#^https?://#');
    }
}
