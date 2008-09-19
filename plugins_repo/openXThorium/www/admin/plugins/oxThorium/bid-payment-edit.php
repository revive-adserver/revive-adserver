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
$Id: bid-account-edit.php 24004 2008-08-11 15:34:24Z radek.maciaszek@openx.org $
*/

require_once 'bid-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';

/*-------------------------------------------------------*/
/* MAIN REQUEST PROCESSING                               */
/*-------------------------------------------------------*/
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADMIN);

$paymentForm = buildPaymentForm($aAccount);

if ($paymentForm->validate()) {
    //process submitted values
    processForm($aAccount, $paymentForm);
}
else { //either validation failed or form was not submitted, display the form
    displayPage($aAccount, $paymentForm);
}

/*-------------------------------------------------------*/
/* Build form                                            */
/*-------------------------------------------------------*/
function buildPaymentForm($aAccount)
{
    $obj = OX_Component::factory('admin', 'oxThorium');

    $form = new OA_Admin_UI_Component_Form("paymentForm", "POST", $_SERVER['PHP_SELF']);
    $form->forceClientValidation(true);

    $form->addElement('hidden', 'accountid', $aAccount['accountid']);

    //section: company and contact
    $form->addElement('header', 'header_comp_cont', 'Company & Contacts');
    $form->addElement('text', 'company_name', 'Company name');
    $aHasTax[] = $form->createElement('radio', 'hasTaxId', $obj->translate('No'), null, 0, array('checked' => 'checked'));
    $aHasTax[] = $form->createElement('radio', 'hasTaxId', $obj->translate('Yes'), null, 1);
    $form->addGroup($aHasTax, 'hasTaxId', 'Registered for tax?');
    $form->addElement('text', 'company_reg_no', 'Company reg. number');

    $form->addElement('text', 'contact', $obj->translate('First Name'));
    $form->addElement('text', 'contact', $obj->translate('Last Name'));
    $form->addElement('text', 'company_phone', 'Phone', array('class' => 'small'));
    $form->addElement('text', 'email', $obj->translate('Email'));
    $form->addElement('text', 'email_confirm', $obj->translate('Confirm Email'));

    //section: address
    $form->addElement('header', 'header_address', $obj->translate('Street Address'));
    $address['address1'] = $form->createElement('text', 'address1', "", array('id' => 'address1', 'class' => 'large'));
    $address['address1']->setSize(35);
    $address['address2'] = $form->createElement('text', 'address2', "", array('id' => 'address2', 'class' => 'large'));
    $address['address2']->setSize(35);
    $address['address3'] = $form->createElement('text', 'address3', "", array('class' => 'large'));
    $address['address3']->setSize(35);
    $form->addGroup($address, 'g_address', $obj->translate('Address'), "<br>");

    $cityZip['city'] = $form->createElement('text', 'city', "", array('class' => 'medium'));
    $cityZip['phone'] = $form->createElement('text', 'zip', $obj->translate('Zip Code'), array('class' => 'x-small'));
    $form->addGroup($cityZip, 'g_zip', $obj->translate('City'), "&nbsp;");

    //TODO DEV: get countries here
    $countries = array();
    $form->addElement('select', 'country', $obj->translate('Country'), $countries, array('class' => 'medium'));

    //TODO DEV: this section is not final yet - product does not know how we wil pay
    //probably should be hidden when implementation starts - created for future reference
    //section: payment
//    $form->addElement('header', 'header_payment', 'Payment');
//    $payMethods = array('PayPal');
//    $form->addElement('select', 'payment_method', "Payment Method", $payMethods, array('class' => 'small'));
//    $form->addElement('text', 'pay_email', $obj->translate('Email'));
//    $form->addElement('advcheckbox', 'vat_reg', 'Vat registered', 'Yes, I\'m VAT registered', null, array("t", "f"));
//    $form->addElement('text', 'vat_no', 'VAT number', array('class' => 'small'));

    //we want submit to be the last element in its own separate section
    $form->addElement('controls', 'form-controls');
    $form->addElement('submit', 'submit', 'Save payment details');

    //Form validation rules
    $form->addRule('company_name', $obj->translate('%s is required', array('Company name')),
        'required');
    $form->addGroupRule('hasTaxId', $obj->translate('%s is required', array('Registered for tax')),
        'required');
    $form->addRule('company_reg_no', $obj->translate('%s is required', array('Company reg. number')),
        'required');
    $form->addRule('country', $obj->translate('%s is required', array($obj->translate('Country'))),
        'required');
    $aAddress1Rules = array(array($obj->translate('%s is required', array($obj->translate('Address'))), 'required'));
    $form->addGroupRule('g_address', array($aAddress1Rules, array(), array()));
    $form->addGroupRule('g_zip',
        array(
            array(array($obj->translate('%s is required', array($obj->translate('City'))), 'required')),
            array(array($obj->translate('%s is required', array($obj->translate('Zip Code'))), 'required')),
        )
    );
    $form->addRule('company_phone', $obj->translate('%s is required', array($obj->translate('Phone'))),
        'required');

    $emailRequiredMsg = $obj->translate('%s is required', array($obj->translate('Email')));
    $confirmEmailRequiredMsg = $obj->translate('%s is required', array($obj->translate('Confirm Email')));
    $form->addRule('email', $emailRequiredMsg, 'required');
    $form->addRule('email', $obj->translate('Please enter a valid email'), 'email');
    $form->addRule('email_confirm', $confirmEmailRequiredMsg, 'required');
    $form->addRule('email_confirm', $obj->translate('Please enter a valid email'), 'email');
    $form->addRule('email_confirm', $obj->translate('Email addresses must match'), 'equal', array('email', $form->getElementValue('email')));

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
    // menu
    $obj = OX_Component::factory('admin', 'oxThorium');
    $obj->setCurrentMenuItem('bid-payment-edit');
    $obj->addSubMenu();

    //header
    phpAds_PageHeader("openx-market",'','../../');

    //get template and display form
    $oTpl = new OA_Plugin_Template('bid-payment-edit.html','bidService');

    $oTpl->assign('form', $form->serialize());
    $oTpl->display();

    //footer
    phpAds_PageFooter();
}



?>