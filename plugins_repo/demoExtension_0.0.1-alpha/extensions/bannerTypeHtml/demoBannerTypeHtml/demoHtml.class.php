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
require_once MAX_PATH . '/plugins/bannerTypeHtml/bannerTypeHtml.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @abstract
 */
class Plugins_BannerTypeHTML_demoBannerTypeHtml_demoHtml extends Plugins_BannerTypeHTML
{
    /**
     * Return description of banner type
     * for the dropdown selection on the banner-edit screen
     *
     * @return string A string describing the type of plugin.
     */
    function getOptionDescription()
    {
        return 'Demonstration Plugin HTML Banner Type';
    }

    /**
     * Append type-specific form elements to the base form
     *
     * @param object form
     * @param integer bannerId
     */
    function buildForm(&$form, $bannerId)
    {
        parent::buildForm($form, $bannerId);

        /**
         * Uncomment the following lines IF
         * you have completed the steps to make this plugin data-aware
        */
        /*
        $form->addElement('text', 'demofield', 'Demo Field');
        $form->addRule("demofield", 'Please enter http://www.openx.org', 'regex', '/^http:\/\/www\.openx\.org$/');
        */
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

    /**
     * This method is executed BEFORE
     * the core banners table is written to
     *
     * @param boolean $insert
     * @param integer $bannerid
     * @param array $aFields
     * @param array $aVariables
     * @return boolean
     */
    function preprocessForm($insert, $bannerid, &$aFields, &$aVariables)
    {
        $aVariables['htmltemplate'] = $this->_buildHtmlTemplate($aVariables);
        $aVariables['comments']     = 'Demonstration OpenX Banner Type ID '.$aFields['bannerid'];
        return true;
    }

    /**
     * This method is executed AFTER
     * the core banners table is written to
     *
     * @param boolean $insert
     * @param integer $bannerid
     * @param array $aFields
     * @return boolean
     */
    function processForm($insert, $bannerid, $aFields)
    {
        /**
         * Uncomment the following lines IF
         * you have completed the steps to make this plugin data-aware
        */
        /*
        $doBanners = OA_Dal::factoryDO('banners_demo');
        if ($insert)
        {
            $doBanners->bannerid      = $bannerid;
            $doBanners->demofield     = $aFields['description'];
            return $doBanners->insert();
        }
        else
        {
            $doBanners->demofield     = $aFields['description'];
            $doBanners->whereAdd('bannerid='.$bannerid, 'AND');
            return $doBanners->update(DB_DATAOBJECT_WHEREADD_ONLY);
        }
        */
        return true;
    }

    /**
     * You will need to compile your HTML for insertion
     * into the core banners table
     *
     * @param array $aFields
     * @return string
     */
    function _buildHtmlTemplate($aFields)
    {
        $result = '<div>Demonstration OpenX Banner Type ID '.$aFields['bannerid'].'</div>';
        return $result;
    }


}

?>
