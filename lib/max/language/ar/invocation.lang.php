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
$GLOBALS['strCopyToClipboard'] = "نسخ الى الحافظة";
$GLOBALS['strCopy'] = "نسخ";
$GLOBALS['strChooseTypeOfInvocation'] = "الرجاء اختيار نوع البنر";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "الرجاء اختيار نوع البنر";

// Measures
$GLOBALS['strAbbrPixels'] = "بكسل";
$GLOBALS['strAbbrSeconds'] = "sec";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "اختيار البنر";
$GLOBALS['strInvocationCampaignID'] = "الحملة الإعلانية";
$GLOBALS['strInvocationTarget'] = "وجهة الرابط";
$GLOBALS['strInvocationSource'] = "المصدر";
$GLOBALS['strInvocationWithText'] = "عرض نص تحت البنر";
$GLOBALS['strInvocationDontShowAgain'] = "لا تقم بعرض البنر مرة ثانية في نفس الصفحة";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Don't show a banner from the same campaign again on the same page";
$GLOBALS['strInvocationTemplate'] = "Store the banner inside a variable so it can be used in a template";
$GLOBALS['strInvocationBannerID'] = "Banner ID";
$GLOBALS['strInvocationComments'] = "إرفاق التعليقات";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "إعادة العرض بعد";
$GLOBALS['strIframeResizeToBanner'] = "تعديل حجم الاطار ليتناسب مع حجم الاعلان";
$GLOBALS['strIframeMakeTransparent'] = "Make the iframe transparent";
$GLOBALS['strIframeIncludeNetscape4'] = "Include Netscape 4 compatible ilayer";
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
$GLOBALS['strShowStatus'] = "الحالة";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Host Language";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Support 3rd Party Server Clicktracking";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insert Cache-Busting code";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "تحذير";
$GLOBALS['strImgWithAppendWarning'] = "This tracker has appended code, appended code will <strong>only</strong> work with JavaScript tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
