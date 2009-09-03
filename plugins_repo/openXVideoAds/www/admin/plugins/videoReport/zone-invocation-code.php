<?php
require_once '../../../../init.php';
require_once '../../config.php';
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';
require_once MAX_PATH . '/plugins/bannerTypeHtml/vastInlineBannerTypeHtml/commonAdmin.php';

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);

phpAds_PageHeader("zone-invocation",'','../../');
VideoAdsHelper::displayWarningMessage("
<b>Note:	Zone invocation codes are not used for Video Ads.</b> <br/>
		Instead, you must include the zone in the Ad Schedule of the video player plugin configuration in your webpage. <br/>
		Please refer to the <a href='".VideoAdsHelper::getHelpLinkVideoPlayerConfig()."' target='_blank'>Video Ads Plugin User Guide</a> for instructions.
		");
phpAds_PageFooter();
