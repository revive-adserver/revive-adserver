<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once 'bid-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';


/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
//build account form
$accountForm = buildAccountForm($aAccount);

if ($accountForm->validate()) {
    //process submitted values
    processForm($aAccount, $accountForm);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($aAccount, $accountForm);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildAccountForm($aAccount)
{
    $form = new OA_Admin_UI_Component_Form("account_form", "POST", $_SERVER['PHP_SELF']);
    $form->forceClientValidation(true);
    
    $form->addElement('hidden', 'accountid', $aAccount['accountid']);

    //section: company and contact
    $form->addElement('header', 'header_comp_cont', 'Company & Contacts');
    $form->addElement('text', 'company_name', 'Company name');
    $form->addElement('text', 'company_reg_no', 'Company reg. number');
    
    $contact['name'] = $form->createElement('text', 'contact', "", array('class' => 'medium'));
    $contact['phone'] = $form->createElement('text', 'company_phone', 'Phone', array('class' => 'small'));
    $form->addGroup($contact, 'g_contact', $GLOBALS['strContact'], "&nbsp;");
    $form->addElement('text', 'email', $GLOBALS['strEMail']);
    
    //section: address
    $form->addElement('header', 'header_address', $GLOBALS['strAddress']);
    $address['address1'] = $form->createElement('text', 'address1', "", array('id' => 'address1', 'class' => 'large'));
    $address['address1']->setSize(35);
    $address['address2'] = $form->createElement('text', 'address2', "", array('class' => 'large'));
    $address['address2']->setSize(35);
    $form->addGroup($address, 'g_address', 'Street address', "<br>");
    
    $cityZip['city'] = $form->createElement('text', 'city', "", array('class' => 'medium'));
    $cityZip['phone'] = $form->createElement('text', 'zip', 'Postal Code', array('class' => 'x-small'));
    $form->addGroup($cityZip, 'g_zip', $GLOBALS['strCity'], "&nbsp;");

    //TODO DEV: get countries here 
    $countries = array();
    $countyCountry['county'] = $form->createElement('select', 'county', "", $countries, array('class' => 'medium'));
    $countyCountry['country'] = $form->createElement('text', 'county', 'County', array('class' => 'small'));
    $form->addGroup($countyCountry, 'g_country', $GLOBALS['strCountry'], "&nbsp;");
    
    //TODO DEV: this section is not final yet - product does not know how we wil pay
    //probably should be hidden when implementation starts - created for future reference
    //section: payment
    $form->addElement('header', 'header_payment', 'Payment');
    $payMethods = array('PayPal');
    $form->addElement('select', 'payment_method', "Payment Method", $payMethods, array('class' => 'small'));
    $form->addElement('text', 'pay_email', $GLOBALS['strEMail']);
    $form->addElement('advcheckbox', 'vat_reg', 'Vat registered', 'Yes, I\'m VAT registered', null, array("t", "f"));    
    $form->addElement('text', 'vat_no', 'VAT number', array('class' => 'small'));
    
    
    
    
    //we want submit to be the last element in its own separate section
    $form->addElement('controls', 'form-controls');
    $submitLabel = (!empty($aAccount['account_id']))  ? 'Update account data' : 'Create account';    
    $form->addElement('submit', 'submit', $submitLabel);

    //Form validation rules
    $translation = new OA_Translation();
    $form->addRule('company_name', $translation->translate($GLOBALS['strXRequiredField'], array('Company name')),
        'required');
    
    $form->addRule('company_reg_no', $translation->translate($GLOBALS['strXRequiredField'], array('Company reg. number')),
        'required');

    //$contactRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strContact'])); 
    //$form->addRule('contact', $contactRequiredMsg, 'required');
    $emailRequiredMsg = $translation->translate($GLOBALS['strXRequiredField'], array($GLOBALS['strEMail']));
    $form->addRule('email', $emailRequiredMsg, 'required');
    $form->addRule('email', $GLOBALS['strEmailField'], 'email');
    
    //set form  values 
    $form->setDefaults($aAccount);
    return $form;
}    


/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
function processForm($aAccount, $form) 
{
    $aFields = $form->exportValues();
    
    if (empty($aAccount['account_id'])) {
        //save new and regsiter
    } 
    else {
        //update
    }
}

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
function displayPage($aAccount, $form)
{
    //header
    phpAds_PageHeader("bid-account-edit",'','../../');
        
    //get template and display form
    $oTpl = new OA_Plugin_Template('bid-account-edit.html','bidService');

    $oTpl->assign('newAccount',  empty($aAccount['accountid']));
    $oTpl->assign('accountid',  $aAccount['accountid']);
    $oTpl->assign('form', $form->serialize());
    $oTpl->display();
    
    //footer
    phpAds_PageFooter();
}   



?>