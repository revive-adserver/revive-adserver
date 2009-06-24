<?php
require_once '../../../../init.php';
require_once '../../config.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);

// TEMPLATE
phpAds_PageHeader("zone-invocation",'','../../');
echo "<div class='errormessage' style='width:700px;'><img class='errormessage' src='" . OX::assetPath() . "/images/icon-warning.gif' align='absmiddle'>";
echo "<span class='tab-r'>
		Note: 
		Zone invocation codes are not used for Video Ads. <br/>
		Instead, you must configure the invocation of the video ad in the HTML from which you call the video player. <br/>
		Please refer to the <a href='http://www.openx.org/docs/2.8/userguide/banners+video+ads' target='_blank'>Video Plugin User Guide</a> for instructions.
		</span>
		</div>";
phpAds_PageFooter();
