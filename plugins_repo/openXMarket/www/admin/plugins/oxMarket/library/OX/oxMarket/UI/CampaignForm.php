<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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


/**
 * 
 */
class OX_oxMarket_UI_CampaignForm
    extends OA_Admin_UI_Component_Form
{
    /**
     * OX translation class
     *
     * @var Plugins_admin_oxMarket_oxMarket
     */
    protected $oMarketComponent;      
    
    /**
     * Builds SSO login form for installer
     * @param OX_Translation $oTranslation  instance
     */
    public function __construct(Plugins_admin_oxMarket_oxMarket $oMarketComponent, $aCampaign)
    {
        global $pref;
        parent::__construct('marketcampaignform', 'POST', $_SERVER['SCRIPT_NAME']);
        $this->forceClientValidation(true);
        $this->oMarketComponent = $oMarketComponent;         

        $this->addElement('hidden', 'campaignid', $aCampaign['campaignid']);
        $this->addElement('hidden', 'clientid', $aCampaign['clientid']);

        //campaign inactive note (if any)
        if (isset($aCampaign['status']) && $aCampaign['status'] != OA_ENTITY_STATUS_RUNNING) {
            $aReasons = $this->getCampaignInactiveReasons($aCampaign);
            $this->addElement('custom', 'campaign-inactive-note', null, array ('inactiveReason' => $aReasons), false);
        }

        //form sections
        $isNewCampaign = empty($aCampaign['campaignid']);
    
        $this->buildBasicInformationFormSection($aCampaign, $isNewCampaign);
        $this->buildDateFormSection($aCampaign, $isNewCampaign);
        $this->buildImpressionsFormSection($aCampaign, $isNewCampaign, $remnantEcpmEnabled, $contractEcpmEnabled);
        $this->buildHighPriorityFormSection($aCampaign, $isNewCampaign);
    
        //form controls
        $this->addElement('controls', 'form-controls');
        $this->addElement('submit', 'submit', $GLOBALS['strSaveChanges']);
    
        $this->populateForm($aCampaign);
    }


    protected function buildBasicInformationFormSection($aCampaign, $isNewCampaign)
    {
        $this->addElement('header', 'h_basic_info', $GLOBALS['strBasicInformation']);
        $this->addElement('text', 'campaignname', $GLOBALS['strName']);
        
        $this->addRequiredRule('campaignname', $GLOBALS['strName']);
    }
    
    
    protected function buildDateFormSection($aCampaign, $isNewCampaign)
    {
        $this->addElement('header', 'h_date', $GLOBALS['strDate']);
    
        //activation date
        $actDateGroup['radioNow'] = $this->createElement('radio', 'startSet', null, $GLOBALS['strActivateNow'], 'f', array ('id' => 'startSet_immediate'));
        $actDateGroup['radioSpecific'] = $this->createElement('radio', 'startSet', null, $GLOBALS['strSetSpecificDate'], 't', array ('id' => 'startSet_specific'));
    
        $specificStartDateGroup['date'] = $this->createElement('text', 'start', null, array ('id' => 'start', 'class' => 'small'));
        $specificStartDateGroup['cal_img'] = $this->createElement ('html', 'start_button', "<a href='#' id='start_button'><img src='".OX::assetPath () . "/images/icon-calendar.gif' align= 'absmiddle' /></a>");
        $specificStartDateGroup['note'] = $this->createElement('html', 'activation_note', "<br><br>".$GLOBALS['strActivationDateComment']);
        $actDateGroup['specificDate'] = $this->createElement('group', 'g_specificStartDate', null, $specificStartDateGroup, null, false);
        $this->addDecorator('g_specificStartDate', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'specificStartDateSpan', 'style' => 'display:none')));
    
        $this->addGroup($actDateGroup, 'act_date', $GLOBALS['strActivationDate'], array ("<BR>", ''));
    
        //expiriation date
        $expDateGroup['radioNever'] = $this->createElement('radio', 'endSet', null, $GLOBALS['strDontExpire'], 'f', array ('id' => 'endSet_immediate'));
        $expDateGroup['radioSpecific'] = $this->createElement('radio', 'endSet', null, $GLOBALS['strSetSpecificDate'], 't', array ('id' => 'endSet_specific'));
        $specificEndDateGroup['date'] = $this->createElement('text', 'end', null, array ('id' => 'end', 'class' => 'small'));
        $specificEndDateGroup['cal_img'] = $this->createElement('html', 'end_button',    "<a href='#' id='end_button'><img src='".OX::assetPath () . "/images/icon-calendar.gif' align='absmiddle' /></a>");
        $specificEndDateGroup['note'] = $this->createElement('html', 'expiration_note', "<br><br>".$GLOBALS['strExpirationDateComment']);
        $expDateGroup['specificDate'] = $this->createElement('group', 'g_specificEndDate', null, $specificEndDateGroup, null, false);
        $this->addDecorator('g_specificEndDate', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'specificEndDateSpan', 'style' => 'display:none')));
    
        $this->addGroup($expDateGroup, 'exp_date', $GLOBALS['strExpirationDate'], array ("<BR>", '', ''));
    }
    
    
    protected function buildImpressionsFormSection($aCampaign, $isNewCampaign, $remnantEcpmEnabled, $contractEcpmEnabled)
    {
        global $conf;
    
        $this->addElement('header', 'h_pricing', $GLOBALS['strImpressionGoal'] );
    
        //impr
        $imprCount['impressions'] = $this->createElement('text', 'impressions', null, array ('id' => 'impressions', 'class' => 'small' ));
        $imprCount['checkbox'] = $this->createElement('advcheckbox', 'impr_unlimited', null, $GLOBALS['strUnlimited'], array ('id' => 'impr_unlimited' ), array ("f", "t" ));
        $imprCount['note'] = $this->createElement('custom', 'campaign-remaining-impr', null, array ('impressionsRemaining' => $aCampaign['impressionsRemaining'] ), false );
    
        $this->addGroup($imprCount, 'g_impr_booked', $GLOBALS['strImpressions'] );
    }    
    
    
    protected function buildHighPriorityFormSection($aCampaign, $isNewCampaign)
    {
        global $conf;
    
        //priority section
        $this->addElement('header', 'h_high_priority', $GLOBALS['strPriorityInformation'] );
    
        //high - dropdown
        for($i = 10; $i >= 1; $i --) {
            $aHighPriorities[$i] = $i;
        }
        $highPriorityGroup['select'] = $this->createElement('select', 'high_priority_value', null, $aHighPriorities, array ('class' => 'x-small' ));
    
        //high - limit per day
        $aManualDel['text'] = $this->createElement('text', 'target_value', ' - ' .$GLOBALS['strTargetLimitImpressionsTo'], 
            array ('id' => 'target_value' ));
        $aManualDel['perDayNote'] = $this->createElement('html', null, $GLOBALS['strTargetPerDay'] );
    
        $highPriorityGroup['high-distr'] = $this->createElement('group', 'high_distribution_man', null, $aManualDel, null, false );
        $this->addDecorator('high_distribution_man', 'tag', array ('tag' => 'span', 'attributes' => array ('id' => 'high_distribution_span', 'style' => 'display:none' )) );
    
        $this->addGroup($highPriorityGroup, 'g_high_priority', $GLOBALS['strPriorityLevel'], null, false );
    }
    
    
    protected function getCampaignInactiveReasons($aCampaign)
    {
        $aReasons = array ();
    
        if (($aCampaign['impressions'] != -1) && ($aCampaign['impressionsRemaining'] <= 0)) {
            $aReasons[] = $GLOBALS['strNoMoreImpressions'];
        }
        if (($aCampaign['clicks'] != -1) && ($aCampaign['clicksRemainging'] <= 0)) {
            $aReasons[] = $GLOBALS['strNoMoreClicks'];
        }
        if (($aCampaign['conversions'] != -1) & ($aCampaign['conversionsRemaining'] <= 0)) {
            $aReasons[] = $GLOBALS['strNoMoreConversions'];
        }
        if (strtotime($aCampaign['activate_date'].' 00:00:00') > time()) {
            $aReasons[] = $GLOBALS['strBeforeActivate'];
        }
        if (strtotime($aCampaign['expire_date'].' 23:59:59') < time()) {
            $aReasons[] = $GLOBALS['strAfterExpire'];
        }
    
        if (($aCampaign['priority'] == 0 || $aCampaign['priority'] == - 1) && $aCampaign['weight'] == 0) {
            $aReasons[] = $GLOBALS['strWeightIsNull'];
        }
        if (($aCampaign['priority'] > 0) && ($aCampaign['target_value'] == 0 || $aCampaign['target_value'] == '-') &&
            ($aCampaign['impressions'] == -1) && ($aCampaign['clicks'] == -1) && ($aCampaign['conversions'] == -1)
        ) {
            $aReasons[] = $GLOBALS['strTargetIsNull'];
        }

    
        return $aReasons;
    }
    
    
    protected function addRequiredRule($fieldName, $fieldLabel)
    {
        $this->addRule($fieldName, $this->getRequiredFieldMessage($fieldLabel), 'required');
    }

    
    protected function getRequiredFieldMessage($fieldLabel)
    {
        $oTranslation = new OX_Translation();
        return $oTranslation->translate('XRequiredField', array($fieldLabel));
    }
    

    public function populateForm($aCampaign) 
    {
        //set form values
        $this->setDefaults($aCampaign);
        $this->setDefaults (array(
            'impressions' => !isset($aCampaign['impressions']) || $aCampaign['impressions'] == '' || $aCampaign['impressions'] < 0 ? '-' : $aCampaign['impressions']
       ));
    
        if (!empty($aCampaign['activate_date'])) {
            $oDate = new Date($aCampaign['activate_date']);
            $startDateSet = 't';
            $startDateStr = $oDate->format('%d %B %Y ');
        } else {
            $startDateSet = 'f';
            $startDateStr = '';
        }
    
        if (!empty($aCampaign['expire_date'])) {
            $oDate = new Date($aCampaign['expire_date']);
            $endDateSet = 't';
            $endDateStr = $oDate->format('%d %B %Y ');
        } else {
            $endDateSet = 'f';
            $endDateStr = '';
        }
    
        $this->setDefaults(array(
            'impr_unlimited' => (isset($aCampaign["impressions"]) && $aCampaign["impressions"] >= 0 ? 'f' : 't'),
            'startSet' => $startDateSet,
            'endSet' => $endDateSet,
            'start' => $startDateStr,
            'end' => $endDateStr,
            'high_priority_value' => $aCampaign['priority'] > '0' ? $aCampaign['priority'] : 5,
            'target_value' => !empty($aCampaign['target_value']) ? $aCampaign['target_value'] : '-',
       ));        
    }
    
    
    public function populateCampaign()
    {
        $aFields = $this->exportValues();

        //translate submitted values
        //-- dates
        if (!empty($aFields['start'])) {
            $oDate = new Date(date('Y-m-d 00:00:00', strtotime($aFields['start'])));
            $oDate->toUTC();
            $activate = $oDate->getDate();
        } else {
            $activate = null;
        }
        if (!empty($aFields['end'])) {
            $oDate = new Date(date('Y-m-d 23:59:59', strtotime($aFields['end'])));
            $oDate->toUTC();
            $expire = $oDate->getDate();
        } else {
            $expire = null;
        }

        //-- impressions
        if ((!empty($aFields['impr_unlimited']) && $aFields['impr_unlimited'] == 't')) {
            $aFields['impressions'] = -1;
        } else if (empty($aFields['impressions']) || $aFields['impressions'] == '-') {
            $aFields['impressions'] = 0;
        }        
        $aFields['priority'] = (isset($aFields['high_priority_value']) ? $aFields['high_priority_value'] : 5);

        // Daily targets need to be set only if the campaign doesn't have both expiration and lifetime targets
        $aFields['target_value'] = isset($aFields['target_value']) && ($aFields['target_value'] != '-')
            ? $aFields['target_value'] : 0;
        
        $hasExpiration = !empty($expire);
        $hasLifetimeTargets = $aFields['impressions'] != -1;
        $target_impression = 0;
        if (!$hasExpiration || !$hasLifetimeTargets) { 
            $target_impression = $aFields['target_value'];  
        }
        
        //populate campaign array
        $aCampaign = array();
        $aCampaign['clientid'] = $aFields['clientid'];
        $aCampaign['campaignid'] = $aFields['campaignid'];
        $aCampaign['campaignname'] = $aFields['campaignname'];
        $aCampaign['impressions'] = $aFields['impressions'];
        $aCampaign['clicks'] = -1;
        $aCampaign['conversions'] = -1;
        $aCampaign['priority'] = $aFields['priority'];
        $aCampaign['weight'] = 0;
        $aCampaign['target_impression'] = $target_impression;
        $aCampaign['target_click'] = 0;
        $aCampaign['target_conversion'] = 0;
        $aCampaign['anonymous'] = 'f';
        $aCampaign['companion'] = 0;
        $aCampaign['revenue'] = null;
        $aCampaign['ecpm'] = null;
        $aCampaign['revenue_type'] = null;
        $aCampaign['activate_time'] = isset($activate) ? $activate : null;
        $aCampaign['expire_time'] = isset($expire) ? $expire : null;
        $aCampaign['block'] = 0;
        $aCampaign['capping'] = 0;
        $aCampaign['session_capping'] = 0;        
        
        
        return $aCampaign;
    }
}
