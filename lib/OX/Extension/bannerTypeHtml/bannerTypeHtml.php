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

require_once MAX_PATH . '/lib/OA.php';
require_once LIB_PATH . '/Plugin/Component.php';

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @abstract
 */
class Plugins_BannerTypeHTML extends OX_Component
{
    function getStorageType()
    {
        return 'html';
    }

    /**
     * Return the media (content) type
     *
     */
    function getContentType()
    {
        return 'html';
    }

    /**
     * Return type of plugin
     *
     * @return string A string describing the type of plugin.
     */
    function getOptionDescription()
    {
        return 'Generic HTML Banner';
    }

    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     * @param integer banner id
     */
    function buildForm(&$form, &$row)
    {
        $form->setAttribute("onSubmit", "return max_formValidateHtml(this.banner)");
        $header = $form->createElement('header', 'header_html', $GLOBALS['strHTMLBanner']." -  banner code");
        $header->setAttribute('icon', 'icon-banner-html.gif');
        $form->addElement($header);

        $adPlugins = OX_Component::getComponents('3rdPartyServers');
        $adPluginsNames = OX_Component::callOnComponents($adPlugins, 'getName');
        $adPluginsList = array();
        $adPluginsList[''] = $GLOBALS['strAdserverTypeGeneric'];
        $adPluginsList['none'] = $GLOBALS['strDoNotAlterHtml'];
        foreach($adPluginsNames as $adPluginKey => $adPluginName) {
            $adPluginsList[$adPluginKey] = $adPluginName;
        }

        $htmlG['textarea'] =  $form->createElement('textarea', 'htmltemplate', null,
            array(
                'class' =>'code', 'cols'=>'45', 'rows'=>'10', 'wrap'=>'off',
                'dir' => 'ltr', 'style'=>'width:550px;'
            ));
        $aSelectAttributes = array('id'=>'adserver', 'style' => 'margin-left: 15px;width:230px');
        $htmlG['select'] = HTML_QuickForm::createElement('select', 'adserver', $GLOBALS['strAlterHTML'], $adPluginsList, $aSelectAttributes);
        $form->addGroup($htmlG, 'html_banner_g', null, array("<br>", ""), false);

        $form->addElement('header', 'header_b_links', "Banner link");
        $form->addElement('text', 'url', $GLOBALS['strURL']);
        $form->addElement('text', 'target', $GLOBALS['strTarget']);

        $form->addElement('header', 'header_b_display', 'Banner display');
        $sizeG['width'] = $form->createElement('text', 'width', $GLOBALS['strWidth'].":");
        $sizeG['width']->setSize(5);
        $sizeG['height'] = $form->createElement('text', 'height', $GLOBALS['strHeight'].":");
        $sizeG['height']->setSize(5);

        if (!empty($row['bannerid'])) {
            $sizeG['height']->setAttribute('onChange', 'oa_sizeChangeUpdateMessage("warning_change_banner_size");');
            $sizeG['width']->setAttribute('onChange', 'oa_sizeChangeUpdateMessage("warning_change_banner_size");');
        }
        $form->addGroup($sizeG, 'size', $GLOBALS['strSize'], "&nbsp;", false);

        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());

        //validation rules
        $translation = new OX_Translation();
        $widthRequiredRule = array($translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strWidth'])), 'required');
        $heightRequiredRule = array($translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strHeight'])), 'required');
        $numericRule = array($GLOBALS['strNumericField'] , 'numeric');

        $form->addGroupRule('size', array(
            'width' => array($widthRequiredRule, $numericRule),
            'height' => array($heightRequiredRule, $numericRule)));
    }

    function preprocessForm($insert, $bannerid, $aFields)
    {
        return true;
    }

    function processForm($insert, $bannerid, $aFields)
    {
        return true;
    }

    function validateForm(&$form)
    {
        return true;
    }

    function buildHtmlTemplate($aFields)
    {

    }

    /**
     * Modify the generated banner cache.
     *
     * @param string $buffer the banner cache.
     * @param array $noScript
     * @param array $banner
     * @return string
     */
    function getBannerCache($buffer, &$noScript, $banner)
    {
        return $buffer;
    }
}

?>
