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

require_once LIB_PATH . '/Plugin/Component.php';

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @abstract
 */
class Plugins_BannerTypeText extends OX_Component
{
    /**
     * Return the media (content) type
     *
     */
    function getContentType()
    {
        return 'text';
    }

    /**
     * return the storage type
     *
     */
    function getStorageType()
    {
        return 'txt';
    }

    /**
     * Return type of plugin
     *
     * @return string A string describing the type of plugin.
     */
    function getOptionDescription()
    {
        return 'Generic Text Banner';
    }

    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     */
    function buildForm(&$form, &$row)
    {
        $header = $form->createElement('header', 'header_txt', $GLOBALS['strTextBanner']." -  banner text");
        $header->setAttribute('icon', 'icon-banner-text.gif');
        $form->addElement($header);

        $textG['textarea'] =  $form->createElement('textarea', 'bannertext', null,
            array(
                'class' =>'code', 'cols'=>'45', 'rows'=>'10', 'wrap'=>'off',
                'dir' => 'ltr', 'style'=>'width:550px;'
            ));
        $form->addGroup($textG, 'text_banner_g', null, array("<br>", ""), false);

        $form->addElement('header', 'header_b_links', "Banner link");
        $form->addElement('text', 'url', $GLOBALS['strURL']);
        $form->addElement('text', 'target', $GLOBALS['strTarget']);

        $form->addElement('header', 'header_b_display', 'Banner display');
        $form->addElement('text', 'statustext', $GLOBALS['strStatusText']);

        $form->addElement('hidden', 'ext_bannertype', $this->getComponentIdentifier());

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
}

?>
