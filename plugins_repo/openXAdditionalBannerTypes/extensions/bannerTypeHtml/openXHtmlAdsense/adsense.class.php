<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA.php';
require_once OX_EXTENSIONS_PATH . '/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @abstract
 */
class Plugins_BannerTypeHTML_openXHtmlAdsense_adsense extends Plugins_BannerTypeHTML
{
    /**
     * Return type of plugin
     *
     * @return string A string describing the type of plugin.
     */
    function getOptionDescription()
    {
        return 'Google Adsense HTML Banner';
    }

    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     * @param integer banner id
     */
    function buildForm(&$form, &$row)
    {
        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());

        $bannerId = $row['bannerid'];
        if ($bannerId)
        {
            $doBanners = OA_Dal::factoryDO('banners_ox_adsense');
            $doBanners->bannerid = $bannerId;
            $doBanners->find(true);
            $row['gas_publisher_id'] = $doBanners->gas_publisher_id;
            $row['gas_ad_type'] = $doBanners->gas_ad_type;
            $row['gas_ad_subtype'] = $doBanners->gas_ad_subtype;
            if ($row['gas_ad_type'] && $row['gas_ad_subtype'])
            {
                $selected = $row['gas_ad_type'].'.'.$row['gas_ad_subtype'].'.'.$row['width'].'.'.$row['height'];
            }
        }
        $form->setAttribute("onSubmit", "return max_formValidateHtml(this.banner)");
        $header = $form->createElement('header', 'header_html', $GLOBALS['strHTMLBanner']." -  banner code");
        $header->setAttribute('icon', 'icon-banner-html.gif');
        $form->addElement($header);

        $form->addElement('text', 'gas_publisher_id','Google Adsense Publisher Id', $GLOBALS['strHTMLBanner']);

        $form->addElement('header', 'header_b_display', 'Banner display');

        $adTypeList['text.button.125.125']           =   'Text Button 125 x 125';
        $adTypeList['text.banner.468.60']            =   'Text Banner 468 x 60';
        $adTypeList['text.halfbanner.234.60']        =   'Text Half Banner 234 x 60';
        $adTypeList['text.vertbanner.120.240']       =   'Text Vertical Banner 120 x 240';
        $adTypeList['text.leaderboard.728.90']       =   'Text Leaderboard 728 x 90';
        $adTypeList['text.skyscraper.120.600']       =   'Text Skyscraper 120 x 600';
        $adTypeList['text.wideskyscraper.160.600']   =   'Text Wide Skyscraper 160 x 600';
        $adTypeList['text.smallrectangle.180.150']   =   'Text Small Rectangle 180 x 150';
        $adTypeList['text.mediumrectangle.300.250']  =   'Text Medium Rectangle 300 x 250';
        $adTypeList['text.largerectangle.336.280']   =   'Text Large Rectangle 336 x 280';
        $adTypeList['text.square.250.250']           =   'Text Square 250 x 250';
        $adTypeList['text.smallsquare.200.200']      =   'Text Small Square 200 x 200';

        $form->addElement('select', 'gas_type', 'Ad Format', $adTypeList);

        $form->setDefaults(array('gas_type'=>$selected));
    }

    function validateForm(&$form)
    {
        return true;
        //$oForm->gas_publisher_id
    }

    /**
     * collate the adsense-specific data
     * @todo colours, format
     *
     * @param unknown_type $insert
     * @param unknown_type $bannerid
     * @param unknown_type $aFields
     * @param unknown_type $aVariables
     * @return unknown
     */
    function preprocessForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        $aAdType = explode('.',$aFields['gas_type']);
        $aFields['gas_ad_type']         = $aAdType[0];
        $aFields['gas_ad_subtype']      = $aAdType[1];
        $aVariables['width']            = $aAdType[2];
        $aVariables['height']           = $aAdType[3];
        $aVariables['htmltemplate']     = $this->buildHtmlTemplate(
                                                                    array(
                                                                          'gas_publisher_id'=> $aFields['gas_publisher_id'],
                                                                          'height' => $aVariables['height'],
                                                                          'width' => $aVariables['width'],
                                                                         )
                                                                  );
        // Attempt to enable click tracking of this banner, this will silently
        // and gracefully fail if the google "3rdpartyserver" isn't installed
        $aVariables['autohtml'] = 't';
        $aVariables['adserver'] = 'google';
        return true;
    }

    function processForm($insert, $bannerid, $aFields)
    {
        $doBanners = OA_Dal::factoryDO('banners_ox_adsense');
        if ($insert)
        {
            $doBanners->bannerid            = $bannerid;
            $doBanners->gas_publisher_id    = $aFields['gas_publisher_id'];
            $doBanners->gas_ad_type         = $aFields['gas_ad_type'];
            $doBanners->gas_ad_subtype      = $aFields['gas_ad_subtype'];
            return $doBanners->insert();
        }
        else
        {
            $doBanners->gas_publisher_id    = $aFields['gas_publisher_id'];
            $doBanners->gas_ad_type         = $aFields['gas_ad_type'];
            $doBanners->gas_ad_subtype      = $aFields['gas_ad_subtype'];
            $doBanners->whereAdd('bannerid='.$bannerid, 'AND');
            return $doBanners->update(DB_DATAOBJECT_WHEREADD_ONLY);
        }
    }

    function buildHtmlTemplate($aFields)
    {
        $adFormat = $aFields['width'] . 'x' . $aFields['height'] . '_as';
        $result = '<script type="text/javascript"><!--// <![CDATA[
/* openads={url_prefix} bannerid={bannerid} zoneid={zoneid} source={source} */
// ]]> --></script><script type="text/javascript"><!--
google_ad_client = "'.$aFields['gas_publisher_id'].'";
google_ad_width = '.$aFields['width'].';
google_ad_height = '.$aFields['height'].';
google_ad_format = "' . $adFormat . '";
google_ad_channel ="";
google_color_border = "0066cc";
google_color_bg = "FFFFFF";
google_color_link = "000000";
google_color_url = "666666";
google_color_text = "333333";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
        return $result;
    }

    function selectAllAdsenseBanners()
    {

/*SELECT b.bannerid, b.subtype, b.description, b.width, b.height, g.gas_publisher_id, g.gas_ad_type, g.gas_ad_subtype, b.htmltemplate
FROM ox_banners b
LEFT JOIN ox_banners_ox_adsense g ON  g.bannerid = b.bannerid*/
    }
}

?>
