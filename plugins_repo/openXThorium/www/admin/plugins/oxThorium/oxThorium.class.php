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

require_once LIB_PATH.'/Plugin/Component.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
/**
 *
 * @package    openXThorium
 * @subpackage oxThorium
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @abstract
 */
class Plugins_admin_oxThorium_oxThorium extends OX_Component
{

    function afterPricingFormSection(&$form, $campaign, $newCampaign)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $aFields = array(
            'is_enabled' => 'f',
            'floor_price' => (float) $aConf['oxThorium']['defaultFloorPrice'],
        );
        $dboExt_thorium_campaign_pref = OA_Dal::factoryDO('ext_thorium_campaign_pref');
        if ($dboExt_thorium_campaign_pref->get($campaign['campaignid'])) {
            $aFields = array(
                'is_enabled' => $dboExt_thorium_campaign_pref->is_enabled ? 't' : 'f',
                'floor_price' => (float) $dboExt_thorium_campaign_pref->floor_price,
            );
        }

        $form->addElement ( 'header', 'h_marketplace', 'Enable Marketplace' );

        $form->addElement('advcheckbox', 'is_enabled', null, 'Yes, allow this campaign to be challenged by MarketPlace', null, array("f", "t"));

        $form->addElement ( 'header', 'h_floor_price', 'Floor Price' );

        $form->addElement('text', 'floor_price', 'Campaign floor price', array('class' => 'x-small', 'style' => "margin-left: 5px;"));

        //Form validation rules
        /*$translation = new OA_Translation();
        $requiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array('Campaign floor price'));
        $form->addRule('floor_price', $requiredMsg, 'required');*/

        $form->setDefaults($aFields);

    }

}

?>
