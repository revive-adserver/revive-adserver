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
$Id: market-info.php 31111 2009-01-20 13:41:50Z bernard.lange $
*/

require_once 'market-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

    $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
    if (!$oMarketComponent->isSplashAlreadyShown()) {
        $oMarketComponent->setSplashAlreadyShown();
    }

    $pageUrl = 'http'.((isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) ? 's' : '').'://';
    $pageUrl .= getHostNameWithPort().$_SERVER['REQUEST_URI'];
    
    //header
    phpAds_PageHeader("openx-market",'','../../');

    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-info');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }
    $content = $aContentKeys['content']; 
    $iframeHeight = isset($aContentKeys['iframe-height']) 
        ? $aContentKeys['iframe-height'] 
        : 380;
    $submitLabel = isset($aContentKeys['submit-field-label']) 
        ? $aContentKeys['submit-field-label'] 
        : 'Get Started';
    $submitLabelRegistered = isset($aContentKeys['submit-field-label']) 
        ? $aContentKeys['submit-field-label-registered'] 
        : 'Continue';
    $trackerFrame = isset($aContentKeys['tracker-iframe']) 
        ? $aContentKeys['tracker-iframe'] 
        : '';
    
    //get template and display form
    $oTpl = new OA_Plugin_Template('market-info.html','openXMarket');
    $oTpl->assign('welcomeURL', $oMarketComponent->getConfigValue('marketWelcomeUrl'));
    $oTpl->assign('pubconsoleHost', $oMarketComponent->getConfigValue('marketHost'));
    $oTpl->assign('isRegistered', $oMarketComponent->isRegistered());
    $oTpl->assign('pageUrl', urlencode($pageUrl));
    $oTpl->assign('submitLabel', $submitLabel);
    $oTpl->assign('submitLabelRegistered', $submitLabelRegistered);
    $oTpl->assign('iframeHeight', $iframeHeight);
    $oTpl->assign('trackerFrame', $trackerFrame);
    $oTpl->assign('content', $content);
    
    $oTpl->display();

    //footer
    phpAds_PageFooter();
?>
