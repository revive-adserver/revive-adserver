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

// Invocation Types
$GLOBALS['strInvocationRemote']			= "קריאה מרחוק";
$GLOBALS['strInvocationJS']			= "קריאה מרחוק לקוד Javascript";
$GLOBALS['strInvocationIframes']		= "קריאה מרחוק למסגרות";
$GLOBALS['strInvocationXmlRpc']			= "קריאה מרחוק בשימוש עם XML-RPC";
$GLOBALS['strInvocationCombined']		= "קריאה מרחוק משולבת";
$GLOBALS['strInvocationPopUp']			= "קופץ";
$GLOBALS['strInvocationAdLayer']		= "על-שכבתי או צף DHTML";
$GLOBALS['strInvocationLocal']			= "מקומי";


// Other
$GLOBALS['strCopyToClipboard']			= "העתק לזיכרון";


// Measures
$GLOBALS['strAbbrPixels']			= "פיקסלים";
$GLOBALS['strAbbrSeconds']			= "שניות";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "בחירת באנר";
$GLOBALS['strInvocationClientID']		= "מפרסם או קמפיין";
$GLOBALS['strInvocationTarget']			= "חלון מטרה";
$GLOBALS['strInvocationSource']			= "מקור";
$GLOBALS['strInvocationWithText']		= "הצג כיתוב מתחת לבנר";
$GLOBALS['strInvocationDontShowAgain']		= "אל תציג באנר זה פעם נוספת באותו העמוד";
$GLOBALS['strInvocationDontShowAgainCampaign']		= "אל תציד באנר מאותו הקמפיין שוב באותו העמוד";
$GLOBALS['strInvocationTemplate'] 		= "שמור את הבאנר בתוך משתנה כדי שאפשר יהיה לשלבו בתבנית עמוד (Template)";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "רענן אחרי";
$GLOBALS['strIframeResizeToBanner']		= "התאם גודל מסגרת למידות הבאנר";
$GLOBALS['strIframeMakeTransparent']		= "רקע מסגרת שקוף";
$GLOBALS['strIframeIncludeNetscape4']		= "בכל קוד התאמה עבור שכבת ilayer של Netscape 4 ";


// PopUp
$GLOBALS['strPopUpStyle']			= "סוג קופץ";
$GLOBALS['strPopUpStylePopUp']			= "קופץ מעל";
$GLOBALS['strPopUpStylePopUnder']		= "קופץ מתחת";
$GLOBALS['strPopUpCreateInstance']		= "האירוע שבו יקפוץ החלון";
$GLOBALS['strPopUpImmediately']			= "מיידית";
$GLOBALS['strPopUpOnClose']			= "כאשר העמוד נסגר";
$GLOBALS['strPopUpAfterSec']			= "לאחר";
$GLOBALS['strAutoCloseAfter']			= "יסגר אוטומטית אחרי";
$GLOBALS['strPopUpTop']				= "מיקום התחלתי (עליון)";
$GLOBALS['strPopUpLeft']			= "מיקום התחלתי (שמאל)";
$GLOBALS['strWindowOptions']		= "אופציות חלון";
$GLOBALS['strShowToolbars']			= "כלים";
$GLOBALS['strShowLocation']			= "מיקום";
$GLOBALS['strShowMenubar']			= "תפריט";
$GLOBALS['strShowStatus']			= "סטטוס";
$GLOBALS['strWindowResizable']		= "שינוי גודל";
$GLOBALS['strShowScrollbars']		= "גוללים";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "שפת אירוח";


// AdLayer
$GLOBALS['strAdLayerStyle']			= "סגנון";

$GLOBALS['strAlignment']			= "יישור";
$GLOBALS['strHAlignment']			= "יישור אופקי";
$GLOBALS['strLeft']				= "שמאל";
$GLOBALS['strCenter']				= "מרכז";
$GLOBALS['strRight']				= "ימין";

$GLOBALS['strVAlignment']			= "יישור אנכי";
$GLOBALS['strTop']				= "עליון";
$GLOBALS['strMiddle']				= "אמצע";
$GLOBALS['strBottom']				= "תחתון";

$GLOBALS['strAutoCollapseAfter']		= "קפל אוטומטית אחרי";
$GLOBALS['strCloseText']			= "כיתוב להוראת סגירה";
$GLOBALS['strClose']				= "[סגור]";
$GLOBALS['strBannerPadding']			= "דיפון באנר";

$GLOBALS['strHShift']				= "הסטה אופקית";
$GLOBALS['strVShift']				= "הסטה אנכית";

$GLOBALS['strShowCloseButton']			= "הצג לחצן סגירה";
$GLOBALS['strBackgroundColor']			= "צבע רקע";
$GLOBALS['strBorderColor']			= "צבע מסגרת";

$GLOBALS['strDirection']			= "כיוון";
$GLOBALS['strLeftToRight']			= "משמאל לימין";
$GLOBALS['strRightToLeft']			= "מימין לשמאל";
$GLOBALS['strLooping']				= "חוזר על עצמו";
$GLOBALS['strAlwaysActive']			= "פעיל תמידית";
$GLOBALS['strSpeed']				= "מהירות";
$GLOBALS['strPause']				= "אתנח";
$GLOBALS['strLimited']				= "מוגבל";
$GLOBALS['strLeftMargin']			= "שוליים שמאליים";
$GLOBALS['strRightMargin']			= "שוליים ימניים";
$GLOBALS['strTransparentBackground']		= "רקע שקוף";

$GLOBALS['strSmoothMovement']		= "תנועה חלקה";
$GLOBALS['strHideNotMoving']		= "הסתר את הבאנר כאשר הסמן אינו בתנועה";
$GLOBALS['strHideDelay']			= "השהייה לפני שהבאנר נעלם";
$GLOBALS['strHideTransparancy']		= "שקיפות הבאנר הנעלם";


$GLOBALS['strAdLayerStyleName']	= array(
	'geocities'		=> "סטייל Geocities",
	'simple'		=> "פשוט",
	'cursor'		=> "תחת העכבר",
	'floater'		=> "מצוף"
);

?>