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
$GLOBALS['strCopyToClipboard'] = "拷貝到粘貼板";
$GLOBALS['strCopy'] = "拷貝";
$GLOBALS['strChooseTypeOfInvocation'] = "請選擇生成的公告形式";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "請選擇生成的公告形式";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "秒";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "選擇廣告";
$GLOBALS['strInvocationCampaignID'] = "項目";
$GLOBALS['strInvocationTarget'] = "目標Frame";
$GLOBALS['strInvocationSource'] = "來源";
$GLOBALS['strInvocationWithText'] = "廣告現顯示的文字";
$GLOBALS['strInvocationDontShowAgain'] = "同一頁不重複顯示相同廣告";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "同一頁不顯示相同項目";
$GLOBALS['strInvocationTemplate'] = "保存廣告變量作為將來使用的模板";
$GLOBALS['strInvocationBannerID'] = "廣告ID";
$GLOBALS['strInvocationComments'] = "包括注釋";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "於此之後刷新";
$GLOBALS['strIframeResizeToBanner'] = "按照廣告尺寸重新設置iframe大小";
$GLOBALS['strIframeMakeTransparent'] = "iframe透明";
$GLOBALS['strIframeIncludeNetscape4'] = "兼容Netscape4或更高版本";
$GLOBALS['strIframeGoogleClickTracking'] = "Include code to track Google AdSense clicks";

// PopUp
$GLOBALS['strPopUpStyle'] = "Pop-up type";
$GLOBALS['strPopUpStylePopUp'] = "Pop-up";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Instance when the pop-up is created";
$GLOBALS['strPopUpImmediately'] = "Immediately";
$GLOBALS['strPopUpOnClose'] = "When the page is closed";
$GLOBALS['strPopUpAfterSec'] = "After";
$GLOBALS['strAutoCloseAfter'] = "Automatically close after";
$GLOBALS['strPopUpTop'] = "Initial position (top)";
$GLOBALS['strPopUpLeft'] = "Initial position (left)";
$GLOBALS['strWindowOptions'] = "Window options";
$GLOBALS['strShowToolbars'] = "Toolbars";
$GLOBALS['strShowLocation'] = "Location";
$GLOBALS['strShowMenubar'] = "Menubar";
$GLOBALS['strShowStatus'] = "狀態";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Host Language";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "支持第三方廣告跟蹤伺服器";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "插入Cache-Busting代碼";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strImgWithAppendWarning'] = "跟蹤器帶有附加代碼，這些附加代碼必須在JavaScript標籤中才可運行。";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
