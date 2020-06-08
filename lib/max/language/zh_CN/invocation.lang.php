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

// Other
$GLOBALS['strCopyToClipboard'] = "复制到剪贴板";
$GLOBALS['strCopy'] = "复制";
$GLOBALS['strChooseTypeOfInvocation'] = "请选择调用方式";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "请选择调用方式";

// Measures
$GLOBALS['strAbbrPixels'] = "像素";
$GLOBALS['strAbbrSeconds'] = "秒";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "素材选择";
$GLOBALS['strInvocationCampaignID'] = "项目";
$GLOBALS['strInvocationTarget'] = "目标窗口";
$GLOBALS['strInvocationSource'] = "来源";
$GLOBALS['strInvocationWithText'] = "在素材下方显示文字";
$GLOBALS['strInvocationDontShowAgain'] = "禁止在同一个页面上重复投放相同的素材";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "禁止在同一个页面上重复投放属于同一项目的素材";
$GLOBALS['strInvocationTemplate'] = "Store the banner inside a variable so it can be used in a template";
$GLOBALS['strInvocationBannerID'] = "Banner ID";
$GLOBALS['strInvocationComments'] = "包含注释";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Refresh after";
$GLOBALS['strIframeResizeToBanner'] = "调整 iframe大小以适应Banner尺寸";
$GLOBALS['strIframeMakeTransparent'] = "Make the iframe transparent";
$GLOBALS['strIframeIncludeNetscape4'] = "Include Netscape 4 compatible ilayer";
$GLOBALS['strIframeGoogleClickTracking'] = "Include code to track Google AdSense clicks";

// PopUp
$GLOBALS['strPopUpStyle'] = "Pop-up type";
$GLOBALS['strPopUpStylePopUp'] = "Pop-up";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Instance when the pop-up is created";
$GLOBALS['strPopUpImmediately'] = "立刻";
$GLOBALS['strPopUpOnClose'] = "当页面关闭时";
$GLOBALS['strPopUpAfterSec'] = "After";
$GLOBALS['strAutoCloseAfter'] = "Automatically close after";
$GLOBALS['strPopUpTop'] = "初始位置 (顶部)";
$GLOBALS['strPopUpLeft'] = "初始位置 (左侧)";
$GLOBALS['strWindowOptions'] = "Window options";
$GLOBALS['strShowToolbars'] = "工具栏";
$GLOBALS['strShowLocation'] = "Location";
$GLOBALS['strShowMenubar'] = "Menubar";
$GLOBALS['strShowStatus'] = "状态";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Host Language";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "支持第三方点击率统计工具";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "包含 Cache Buster 参数";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strImgWithAppendWarning'] = "This tracker has appended code, appended code will <strong>only</strong> work with JavaScript tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
