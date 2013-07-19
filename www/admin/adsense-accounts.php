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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';

// Register input variables

// TODO: the "info" variable has been introduced only for the sake of prototype
// to show the info box when an account has been linke/created on another page
// and this page was shown as a confirmation of that action. Feel free to keep
// it or remove, depending on the implementation strategy.
phpAds_registerGlobalUnslashed ('info');

// Used to show the screen when google adsense accounts exist.
phpAds_registerGlobalUnslashed ('exist');


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.1.3.4.7");
// TODO: The path here should probably start with the advertiser's data
// Not sure if we need to include the campaign and banner in the path though.
// We'll need to clarify this with the Product team.
echo "<img src='" . OX::assetPath() . "/images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>GoogleAdSense Accounts</b><br /><br /><br />";
phpAds_ShowSections(array("4.1.3.4.7"));


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

// TODO: depending on whether there are any AdSense accounts already linked,
// we display different UI. Set the variable below to "true" if any
// AdSense accounts have already been linked.
$accountsExist = $exist;

if ($accountsExist) {
   $oTpl = new OA_Admin_Template('adsense-accounts.html');

   $oTpl->assign('info', $exist);

   // TODO: an array of the already linked AdSense accounts
   $oTpl->assign('adsenseAccounts', array(
     'aAdsenseAccounts'  => array (
            array  (
               'name' => 'Adsense 1',
               'affiliateCode' => 'Ca-pub-292876283746',
               'status' => 'pending'
            ),

            array  (
               'name' => 'Another Google Adsense Account',
               'affiliateCode' => 'Ca-pri-292876283746',
               'status' => 'approved'
            ),

            array  (
               'name' => 'One more',
               'affiliateCode' => 'bd-pub-292876283746',
               'status' => 'approved'
            ),
         )
     )
   );
}
else
{
   $oTpl = new OA_Admin_Template('adsense-start.html');

   // TODO: fields are the same as in adsense-link.php, it would be a good idea to
   // refactor them to one common place to avoid duplication
   $oTpl->assign('fieldsLink', array(
       array(
           'title'     => 'Existing AdSense Account Identification',
           'fields'    => array(
               array(
                   'name'      => 'email',
                   'label'     => 'Email',
                   'value'     => $email,
                   'id'        => 'adsenseemail',
                   'title'     => 'Provide valid email',
                   'clientValid' => 'required:true,email:true'
               ),
               array(
                   'name'      => 'phone5digits',
                   'label'     => 'Last 5 digits of phone number',
                   'value'     => '',
                   'id'        => 'phonedigits',
                   'title'     => 'Provide last 5 phone digits',
                   'maxlength' => '5',
                   'clientValid' => 'required:true,number:true'
               ),
               array(
                   'name'      => 'postalcode',
                   'label'     => 'Postal Code',
                   'value'     => '',
                   'id'        => 'postcode',
                   'title'     => 'Provide postal code',
                   'clientValid' => 'required:true'
               )
           )
       ),
       array(
           'title'     => 'Name for the AdSense Account in Openads',
           'fields'    => array(
               array(
                   'name'      => 'name',
                   'label'     => 'Name for the AdSense Account in Openads',
                   'value'     => '',
                   'id'        => 'accountname',
                   'title'     => 'Provide name in Openads',
                   'clientValid' => 'required:true'
               )
           )
       )
   ));

   // TODO: fields are the same as in adsense-create.php, it would be a good idea to
   // refactor them to one common place to avoid duplication
   $oTpl->assign('fieldsCreate', array(
       array(
           'title'     => 'Email address for AdSense Account',
           'fields'    => array(
               array(
                   'name'      => 'email',
                   'label'     => 'Email',
                   'value'     => '',
                   'id'        => 'adsenseemail-create',
                   'title'     => 'Provide valid email',
                   'clientValid' => 'required:true,email:true'
               )
           )
       ),
       array(
           'title'     => 'Name for the AdSense Account in Openads',
           'fields'    => array(
               array(
                   'name'      => 'name',
                   'label'     => 'Name for the AdSense Account in Openads',
                   'value'     => '',
                   'id'        => 'accountname-create',
                   'title'     => 'Provide name in Openads',
                   'clientValid' => 'required:true'
               )
           )
       )
   ));

}

//var_dump($oTpl);
//die();
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
