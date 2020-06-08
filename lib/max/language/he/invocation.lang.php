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
$GLOBALS['strCopyToClipboard'] = "העתק לזיכרון";
$GLOBALS['strCopy'] = "copy";
$GLOBALS['strChooseTypeOfInvocation'] = "Please choose the type of invocation";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "נא לבחור בסוג קוד הקריאה";

// Measures
$GLOBALS['strAbbrPixels'] = "פיקסלים";
$GLOBALS['strAbbrSeconds'] = "שניות";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "בחירת באנר";
$GLOBALS['strInvocationCampaignID'] = "קמפיין";
$GLOBALS['strInvocationTarget'] = "חלון מטרה";
$GLOBALS['strInvocationSource'] = "מקור";
$GLOBALS['strInvocationWithText'] = "הצג כיתוב מתחת לבנר";
$GLOBALS['strInvocationDontShowAgain'] = "אל תציג באנר זה פעם נוספת באותו העמוד";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "אל תציד באנר מאותו הקמפיין שוב באותו העמוד";
$GLOBALS['strInvocationTemplate'] = "שמור את הבאנר בתוך משתנה כדי שאפשר יהיה לשלבו בתבנית עמוד (Template)";
$GLOBALS['strInvocationBannerID'] = "Banner ID";
$GLOBALS['strInvocationComments'] = "Include comments";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "רענן אחרי";
$GLOBALS['strIframeResizeToBanner'] = "התאם גודל מסגרת למידות הבאנר";
$GLOBALS['strIframeMakeTransparent'] = "רקע מסגרת שקוף";
$GLOBALS['strIframeIncludeNetscape4'] = "בכל קוד התאמה עבור שכבת ilayer של Netscape 4 ";
$GLOBALS['strIframeGoogleClickTracking'] = "Include code to track Google AdSense clicks";

// PopUp
$GLOBALS['strPopUpStyle'] = "סוג קופץ";
$GLOBALS['strPopUpStylePopUp'] = "קופץ מעל";
$GLOBALS['strPopUpStylePopUnder'] = "קופץ מתחת";
$GLOBALS['strPopUpCreateInstance'] = "האירוע שבו יקפוץ החלון";
$GLOBALS['strPopUpImmediately'] = "מיידית";
$GLOBALS['strPopUpOnClose'] = "כאשר העמוד נסגר";
$GLOBALS['strPopUpAfterSec'] = "לאחר";
$GLOBALS['strAutoCloseAfter'] = "יסגר אוטומטית אחרי";
$GLOBALS['strPopUpTop'] = "מיקום התחלתי (עליון)";
$GLOBALS['strPopUpLeft'] = "מיקום התחלתי (שמאל)";
$GLOBALS['strWindowOptions'] = "אופציות חלון";
$GLOBALS['strShowToolbars'] = "כלים";
$GLOBALS['strShowLocation'] = "מיקום";
$GLOBALS['strShowMenubar'] = "תפריט";
$GLOBALS['strShowStatus'] = "סטטוס";
$GLOBALS['strWindowResizable'] = "שינוי גודל";
$GLOBALS['strShowScrollbars'] = "גוללים";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "שפת אירוח";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Support 3rd Party Server Clicktracking";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insert Cache-Busting code";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "אזהרה";
$GLOBALS['strImgWithAppendWarning'] = "This tracker has appended code, appended code will <strong>only</strong> work with JavaScript tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
