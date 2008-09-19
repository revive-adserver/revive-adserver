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

        $form->addElement ( 'header', 'h_marketplace', $this->translate("Enable Marketplace"));

        //TODO externalize intro strings
        $form->addElement('static', 'enableIntro', null, $this->translate("You could possibly earn more if this campaign takes part in MarkePlace."));
        $form->addElement('advcheckbox', 'is_enabled', null, $this->translate("Yes, allow this campaign to be challenged by MarketPlace"), array('id' => 'enable_mktplace'), array("f", "t"));

        $form->addElement ( 'header', 'h_floor_price', $this->translate("Floor Price"));
        $form->addElement('static', 'priceIntro', null, $this->translate("Define the minimum price (floor) to ensure that marketplace never delivers less profitable ad than you would serve otherwise."));
        $form->addElement('text', 'floor_price', $this->translate("Campaign floor price"), array('class' => 'x-small', 'id' => 'floor_price'));
        $form->addElement('plugin-script', 'campaign-script', 'oxThorium');


        //Form validation rules
        $form->addRule('floor_price', $this->translate("", array('Campaign floor price')),
            'min', 0.001);
        $form->addRule('floor_price', $this->translate("Must be a decimal with maximum %s decimal places", array('2')),
            'decimalplaces', 2);


        $form->setDefaults($aFields);
    }


    function processForm(&$aFields)
    {
        $oExt_thorium_campaign_pref = OA_Dal::factoryDO('ext_thorium_campaign_pref');
        $oExt_thorium_campaign_pref->campaignid = $aFields['campaignid'];
        $recordExist = false;
        if ($oExt_thorium_campaign_pref->find()) {
            $oExt_thorium_campaign_pref->fetch();
            $recordExist = true;
        }
        $oExt_thorium_campaign_pref->is_enabled = $aFields['is_enabled'] == 't' ? 1 : 0;
        $oExt_thorium_campaign_pref->floor_price = $aFields['floor_price'];
        if ($recordExist) {
            $oExt_thorium_campaign_pref->update();
        } else {
            $oExt_thorium_campaign_pref->insert();
        }
        // invalidate campaign-thorium delivery cache
        //MAX_cacheInvalidateGetCampaignThoriumInfo($aFields['campaignid']);
    }

    function setCurrentMenuItem($item)
    {
        switch($item) {
        case 'bid-overview':
        case 'bid-payment-edit':
        case 'bid-payment-history':
        case 'bid-stats':
            setCurrentLeftMenuSubItem($item);
            break;
        }
    }

    function addSubMenu()
    {
        addLeftMenuSubItem('bid-overview', 'Overview', 'plugins/oxThorium/bid-overview.php');
        addLeftMenuSubItem('bid-payment-edit', 'Payment Details', 'plugins/oxThorium/bid-payment-edit.php');
//        addLeftMenuSubItem('bid-payment-history', 'Payment History', 'plugins/oxThorium/bid-history.php');
        addLeftMenuSubItem('bid-stats', 'Statistics', 'plugins/oxThorium/bid-stats.php');
    }
}

?>
