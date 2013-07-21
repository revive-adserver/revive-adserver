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
// TODO: This variable has been added to demonstrate that clicking on
// links from error messages could bring the already entered e-mail address
// to the new form. Feel free to keep it or remove, depending on the
// implementation strategy.
phpAds_registerGlobalUnslashed ('email');



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.1.3.4.7.3");
// TODO: The path here should probably start with the advertiser's data
// Not sure if we need to include the campaign and banner in the path though.
// We'll need to clarify this with the Product team.
echo "<img src='" . OX::assetPath() . "/images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>Edit AdSense Account</b><br /><br /><br />";
phpAds_ShowSections(array("4.1.3.4.7.3"));


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('adsense-edit.html');

$oTpl->assign('fields', array(
    array(
        'title'     => 'AdSense Account Information',
        'fields'    => array(
            array(
                'name'      => 'name',
                'label'     => 'Name',
                'value'     => ''
            ),
            array(
                'name'      => 'email',
                'label'     => 'Email',
                'value'     => $email
            ),
            array(
                'name'      => 'phone5digits',
                'label'     => 'Last 5 digits of phone number',
                'value'     => ''
            ),
            array(
                'name'      => 'postalcode',
                'label'     => 'Postal Code',
                'value'     => ''
            )
        )
    )
));

//var_dump($oTpl);
//die();
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
