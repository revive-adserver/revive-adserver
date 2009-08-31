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
$Id$
*/

// Installer translation strings
$GLOBALS['strInstall']				= "התקן";
$GLOBALS['strChooseInstallLanguage']		= "בחר �?ת שפת ההתקנה";
$GLOBALS['strLanguageSelection']		= "בחירת שפה";
$GLOBALS['strDatabaseSettings']			= "קביעות בסיס נתוני�?";
$GLOBALS['strAdminSettings']			= "קביעות מנהל";
$GLOBALS['strAdvancedSettings']			= "קביעות מתקדמות";
$GLOBALS['strOtherSettings']			= "קביעות �?חרות";

$GLOBALS['strWarning']				= "�?זהרה";
$GLOBALS['strFatalError']			= "קרתה שגי�?ה גורלית";
$GLOBALS['strUpdateError']			= "חלה שגי�?ה בזמן העדכון";
$GLOBALS['strUpdateDatabaseError']	= "מסיבות ל�? ברורות עדכון בסיס הנתוני�? ל�? הצליח. הררך המומלצת להמשיך הי�? ללחוץ <b>נסה עדכון מחדש</b> כדי לנסות ולתקן בעיות �?פשריות. �?�? �?תה בטוח שבעיות �?לו ל�? יכולות לפגוע בתפקוד ".MAX_PRODUCT_NAME." �?תה יכול ללחוץ <b>התעל�? משגי�?ות</b> כדי להמשיך. התעלמות משגי�?ות �?לו �?פשר שתיור בעיה חמורה וזה ל�? מומלץ!";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME." כבר מותקנת במערכת זו. �?�? �?תה רוצה לעצב �?ותה לך ל<a href='settings-index.php'>קיבעות ממשק</a>";
$GLOBALS['strCouldNotConnectToDB']		= "ל�? יכול להתחבר לבסיס הנתוני�?, �?נ�? בדוק מחדש �?ת הקביעות שרשמת.";
$GLOBALS['strCreateTableTestFailed']		= "לש�? המשתמש שרשמת �?ין מספיק הרש�?ה ליצירת �?ו עדכון מבנה בסיס הנתוני�?, �?נ�? צור קשר ע�? ה�?חר�?י בשרת.";
$GLOBALS['strUpdateTableTestFailed']		= "לש�? המשתמש שרשמת �?ין די הרש�?ה לעדכון בסיס הנתוני�?. �?נ�? צור קשר ע�? ה�?חר�?י�?.";
$GLOBALS['strTablePrefixInvalid']		= "קידומת הטבל�?ות מכילה �?ותיות פסולות.";
$GLOBALS['strTableInUse']			= "בסיס הנתוני�? שרשמת נמצ�? כבר בשימוש של ".MAX_PRODUCT_NAME.", �?נ�? בחר בקידומת טבל�?ות �?חרת, �?ו קר�? �?ת המדריך לגבי הור�?ות שדרוג.";
$GLOBALS['strTableWrongType']		= "סוג הטבלה שבחרת �?ינו נתמך בהתקנת ".$phpAds_dbmsname."שלך";
$GLOBALS['strMayNotFunction']			= "לפני ש�?תה ממשיך, �?נ�? תקן �?ת הבעיה ה�?פשריות ה�?לו:";
$GLOBALS['strFixProblemsBefore']		= "הפריט(י�?) הב�?(י�?) דורשי�? תיקון לפני שניתן יהיה להתקין �?ת ".MAX_PRODUCT_NAME.". �?�? יש לך ש�?לה לגבי שי�?ה זו, �?נ�? קר�? �?ת ה<i>מדריך ל�?דמיניסטרטור</i>, הנמצ�? בחבילה שהורדת.";
$GLOBALS['strFixProblemsAfter']			= "�?�? �?ין ב�?פשרותך לתקן �?ת הבעיה שהוצגה מעלה, נ�? צור שר ע�? ה�?חר�?י של השרת שעליו �?תה מנסה להתקין �?ת ".MAX_PRODUCT_NAME.". �?פשר שהו�? יוכל לעזור לך �?ו לכוון לפתרון.";
$GLOBALS['strIgnoreWarnings']			= "התעל�? מ�?ז�?רות";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME." נדרש PHP 4.0 �?ו גירסה גבוהה יותר לש�? תפקוד נכון. �?תה משתמש כעת בגירסה {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "קונפיגורצית  PHP של המשתנה <B>register_globals</B> צריכה להיות מופעלת.";
$GLOBALS['strWarningMagicQuotesGPC']		= "קונפיגורצית  PHP של המשתנה  <B>magic_quotes_gpc</B>  צריכה להיות מופעלת.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "קונפיגורצית  PHP של המשתנה  <B>magic_quotes_runtime</B>  צריכה להיות מופעלת.";
$GLOBALS['strWarningFileUploads']		= "קונפיגורצית  PHP של המשתנה  <B>file_uploads</B>  צריכה להיות מופעלת.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME." זיהה שהקובץ <b>config.inc.php</b> מוגן מכתיבה.<br> ל�? תוכל להמשיך עד שתשנה �?ת �?ישור הגישה לקובץ זה. <br>קר�? �?ת התיעוד המצורף �?�? �?ינך יודע כיצד לעשות ז�?ת.";
$GLOBALS['strCantUpdateDB']  			= "ל�? ניתן לעדכן �?ת בסיס הנתוני�? כעתץ �?�? החלטת להמשיך, כל הב�?נרי�? הקיימי�?, סטטיסטיקה ומפרסמי�? ימחקו.";
$GLOBALS['strIgnoreErrors']			= "התעל�? משגי�?ות";
$GLOBALS['strRetryUpdate']			= "נסה עדכון מחדש";
$GLOBALS['strTableNames']			= "שמות הטבל�?ות";
$GLOBALS['strTablesPrefix']			= "קידומת של טבל�?ות";
$GLOBALS['strTablesType']			= "סוגי הטבל�?ות";

$GLOBALS['strInstallWelcome']			= "ברוכי�? הב�?י�? ל".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "לפני השימוש ב-".MAX_PRODUCT_NAME." יש לעצב �?ת תפקודי התוכנה ויצור בסיס נתוני�?.<br>לחץ <b>המשך</b> להתקדמות.";
$GLOBALS['strInstallSuccess']			= "<b>ההתקנה של ".MAX_PRODUCT_NAME." הסתיימה ברגע זה.</b><br><br>כדי ש- ".MAX_PRODUCT_NAME." תתפקד נכון עליך ג�? לווד�? שקובץ התחזוקה ירוץ כל שעה. מידע נוסף �?ודות נוש�? זה ניתן למצו�? בתיעוד המצורף. <br><br>לחץ <b>המשך</b> כדי להגיע לעמוד העיצוב/קינפוג, היכן שתוכל לקבוע נתוני�? נוספי�?. �?נ�? �?ל תשכח לנעול �?ת הקובץ <B> config.inc.php</B> ברגע שסיימת, כדי למנוע פגיעות והטרדות בשרת.";
$GLOBALS['strUpdateSuccess']			= "<b>העדכון של ".MAX_PRODUCT_NAME." הסתיי�? בהצלחה.</b><br><br>כדי ש-".MAX_PRODUCT_NAME." תתפקד נכון עליך ג�? להבטיח שקובץ התחזוקה ירוץ כל שעה (עד עתה הו�? נדרש לרוץ פע�? ביו�?) מידע נוסף בנוש�? זה ניתן למצו�? בתיעוד המצורף. <br><br>לחץ <b>המשך</b> כדי להגיע לעמוד ממשק ההנהלה. �?נ�? �?ל תשכח לנעול �?ת הקובץ  <B>config.inc.php</B> למניעת בעיות �?בטחה.";
$GLOBALS['strInstallNotSuccessful']		= "<b>ההתקנה של ".MAX_PRODUCT_NAME."ל�? הצליחה</b><br><br>חלקי�? מסוימי�? מתהליך ההתקנה ל�? הושלמו. �?פשר שבעיות �?לו הן זמניות בלבד, במקרה זה פשוט לחץ <b>המשך</b> ותחזור לשלב הר�?שון של תהליך ההתקנה. �?�? �?תה רוצה לדעת יותר מה �?ומרות הודעות השגי�?ה מטה, וכיתד לפתור �?ותן, �?נ�? היוועץ בתיעוד המצורף.";
$GLOBALS['strErrorOccured']			= "השגי�?ה הב�?ה קרתה:";
$GLOBALS['strErrorInstallDatabase']		= "מבנה בסיס הנתוני�? ל�? יכל להיווצר.";
$GLOBALS['strErrorInstallConfig']		= "קובץ הקונפיגורציה �?ו בסיס הנתוני�? ל�? יכלו להתעדכן.";
$GLOBALS['strErrorInstallDbConnect']		= "ל�? ניתן היה להתחבר לבסיס הנתוני�?.";

$GLOBALS['strUrlPrefix']			= "קידומת URL";

$GLOBALS['strProceed']				= "המשך >";
$GLOBALS['strInvalidUserPwd']			= "ש�? משתמש �?ו סיסמ�? פסולי�?";

$GLOBALS['strUpgrade']				= "עדכון";
$GLOBALS['strSystemUpToDate']			= "המערכת שלך מוכנה ומעודנת, ל�? נדרש עדכון ברגע זה. <br>לחץ על <b>המשך</b> כדי להגיע לעמוד הבית.";
$GLOBALS['strSystemNeedsUpgrade']		= "מבנה בסיס הנתוני�? וקובץ הקונפיגורציה זקוקי�? לעדכון כדי שהמערכת תתפקד נכונה.<br>�?נ�? הת�?זר בסבלנות כיוון שתהליך העדכון יכול לקחת כמה דקות.";
$GLOBALS['strSystemUpgradeBusy']		= "תהליך עדכון המערכת בעיצומו, �?נ�? המתן...";
$GLOBALS['strSystemRebuildingCache']		= "בונה �?ת זכרון המטמון מחדש, �?נ�? המתן...";
$GLOBALS['strServiceUnavalable']		= "השירות �?ינו �?פשרי זמנית. תהליך עדכון המערכת בעיצומו";

$GLOBALS['strConfigNotWritable']		= "קובץ ה-<B>config.inc.php</B> �?ינו ניתן לכתיבה.";






/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "בחר מחלקה";
$GLOBALS['strDayFullNames'] 			= array("ר�?שון","שני","שלישי","רביעי","חמישי","שישי","שבת");
$GLOBALS['strEditConfigNotPossible']    	= "ל�? ניתן לשנות קביעות �?לו כיוון שקובץ הקונפיגורציה נעול מסיבות בטיחותיות.<br> "."�?�? ברצונך לערוך שינויי�?, עליך לשחרר קובץ זה מנעילה";
$GLOBALS['strEditConfigPossible']		= "ניתן לערוך �?ת כל הקביעות כיוון שקובץ הקונפיגורציה �?ינו נעול.<br>למניעת מחדל בטיחותי �?נ�? נעל �?ת הקובץ <B> config.inc.php</B>.";
;



// Database
$GLOBALS['strDatabaseSettings']			= "קביעות בסיס נתוני�?";
$GLOBALS['strDatabaseServer']			= "שרת בסיס הנתוני�?";
$GLOBALS['strDbLocal']				= "התחבר לשרת המקומי ב�?מצעות מעברי�? (sockets)";
$GLOBALS['strDbHost']				= "השרת המ�?רח";
$GLOBALS['strDbPort']				= "מספר המבו�? של בסיס הנתוני�? (port)";
$GLOBALS['strDbUser']				= "ש�? המשתמש בבסיס הנתוני�?";
$GLOBALS['strDbPassword']			= "הסיסמ�? של בסיס הנתוני�?";
$GLOBALS['strDbName']				= "הש�? של בסיס הנתוני�?";

$GLOBALS['strDatabaseOptimalisations']		= "ייטוב בסיס הנתוני�?";
$GLOBALS['strPersistentConnections']		= " השתמש בחיבור רציף (בסיס הנתוני�? תפוס יותר)";
$GLOBALS['strInsertDelayed']			= " השתמש בהשחלת נתון מושהת (בסיס הנתוני�? פחות רגיש לנפילה ושגי�?ות)";
$GLOBALS['strCompatibilityMode']		= " השתמש בת�?ימות בסיס נתוני�?";
$GLOBALS['strCantConnectToDb']			= " ל�? מסוגל להתחבר לבסיס הנתוני�?";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "קביעות שליפה והפצה של ב�?נרי�?";

$GLOBALS['strAllowedInvocationTypes']		= "סוגי קרי�?ה מותרי�?";
$GLOBALS['strAllowRemoteInvocation']		= " �?פשר קרי�?ה מרוחקת";
$GLOBALS['strAllowRemoteJavascript']		= " �?פשר קרי�?ה מרוחקת ע�? קוד Javascript";
$GLOBALS['strAllowRemoteFrames']		= " �?פשר קרי�?ה מרוחקת לקוד מסגרות";
$GLOBALS['strAllowRemoteXMLRPC']		= " �?פשר קרי�?ה מרוחקת ע�? קוד XML-RPC";
$GLOBALS['strAllowLocalmode']			= " �?פשר הפעלה מקומית";
$GLOBALS['strAllowInterstitial']		= " �?פשר ב�?נרי�? צפי�?";
$GLOBALS['strAllowPopups']			= " �?פשר ב�?נרי�? קופצי�?";

$GLOBALS['strUseAcl']				= " השתמש בהגבלות תצוגה";

$GLOBALS['strDeliverySettings']			= "קביעות תפוצה";
$GLOBALS['strCacheType']				= "סוג מטמון התפוצה";
$GLOBALS['strCacheFiles']				= "קבצי�?";
$GLOBALS['strCacheDatabase']			= "בסיס נתוני�?";
$GLOBALS['strCacheShmop']				= "זכרון משותף/Shmop";
$GLOBALS['strCacheSysvshm']				= "זכרון משותף/Sysvshm";
$GLOBALS['strExperimental']				= "נסיוני";

$GLOBALS['strKeywordRetrieval']			= "שליפה לפי מילות מפתח";
$GLOBALS['strBannerRetrieval']			= " שיטת שליפת הב�?נרי�?";
$GLOBALS['strRetrieveRandom']			= " שליפה �?קר�?ית (ברירת מחדל)";
$GLOBALS['strRetrieveNormalSeq']		= " שליפה סדרתית רגילה";
$GLOBALS['strWeightSeq']			= " שליפה סדרתית מבוסס משקל";
$GLOBALS['strFullSeq']				= " שליפה סדרתית מל�?ה";
$GLOBALS['strUseConditionalKeys']		= " השתמש במילות תנ�?י";
$GLOBALS['strUseMultipleKeys']			= " השתמש בריבוי מילות מפתח";

$GLOBALS['strZonesSettings']			= "שליפה �?זורית";
$GLOBALS['strZoneCache']			= " זכרון מטמון �?זורי. (י�?יץ תצוגה של ב�?נרי�? מבוססי �?זור.)";
$GLOBALS['strZoneCacheLimit']			= " הזמן שבין עדכוני זכרון מטמון (בשניות)";
$GLOBALS['strZoneCacheLimitErr']		= " הזמן שבין עדכוני זכרון מטמון חייב להיות מספר חיובי";

$GLOBALS['strP3PSettings']			= "פוליסות פרטיות מסוג P3P";
$GLOBALS['strUseP3P']				= " השתמש בפוליסות P3P";
$GLOBALS['strP3PCompactPolicy']			= "פוליסת P3P קומפקטית";
$GLOBALS['strP3PPolicyLocation']		= "מיקו�? פוליסת ה-P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "קביעות ב�?נרי�?";

$GLOBALS['strAllowedBannerTypes']		= "סוגי ב�?נרי�? מותרי�?";
$GLOBALS['strTypeSqlAllow']			= " �?פשר ב�?נרי�? מקומיי�? (SQL)";
$GLOBALS['strTypeWebAllow']			= " �?פשר ב�?נרי�? מקומיי�? (Webserver)";
$GLOBALS['strTypeUrlAllow']			= " �?פשר ב�?נרי�? חיצוניי�?";
$GLOBALS['strTypeHtmlAllow']			= " �?פשר ב�?נרי�? מקוד HTML";
$GLOBALS['strTypeTxtAllow']			= " �?פשר ב�?נרי�? טקסטו�?ליי�?";

$GLOBALS['strTypeWebSettings']			= "קונפיגורציית ב�?נר מקומי (השרת)";
$GLOBALS['strTypeWebMode']			= "שיטת �?יחסון";
$GLOBALS['strTypeWebModeLocal']			= "תיקייה מקומית";
$GLOBALS['strTypeWebModeFtp']			= "שרת FTP חיצוני";
$GLOBALS['strTypeWebDir']			= "תיקייה מקומית";
$GLOBALS['strTypeWebFtp']			= "שרת ב�?נרי�? בתצורת FTP";
$GLOBALS['strTypeWebUrl']			= "כתובת URL ציבורית";
$GLOBALS['strTypeFTPHost']			= "מ�?רח FTP";
$GLOBALS['strTypeFTPDirectory']			= "תיקיית FTP";
$GLOBALS['strTypeFTPUsername']			= "ש�? משתמש";
$GLOBALS['strTypeFTPPassword']			= "סיסמ�?";

$GLOBALS['strTypeFTPErrorDir']			= "תיקיית השרת �?ינה קיימת";
$GLOBALS['strTypeFTPErrorConnect']		= "ל�? ניתן היה להתחבר לשרת ה-FTP, ש�? המשתמש �?ו הסיסמ�? שגויי�?";
$GLOBALS['strTypeFTPErrorHost']			= "ש�? שרת ה-FTP �?ינו נכון";
$GLOBALS['strTypeFTPErrorDir']			= "תקיית המ�?רח �?ינה קיימת";
$GLOBALS['strTypeFTPErrorConnect']		= "ל�? ניתן להתחבר לשרת ה-FTP, ש�? המשתמש �?ו הסיסמ�? שגויי�?";
$GLOBALS['strTypeFTPErrorHost']			= "ש�? השרת המ�?רח �?ת ה-FTP שגוי";
$GLOBALS['strTypeDirError']				= "התיקייה המקומית �?ינה קיימת";



$GLOBALS['strDefaultBanners']			= "ב�?נרי�? כברירת מחדל חלופית";
$GLOBALS['strDefaultBannerUrl']			= "כתובת URL של ב�?נר חלופי";
$GLOBALS['strDefaultBannerTarget']		= "כתובת URL כמטרה חלופית";

$GLOBALS['strTypeHtmlSettings']			= "�?ופציות ב�?נר HTML";
$GLOBALS['strTypeHtmlAuto']			= " שנה �?ת הקוד �?וטומטית כדי ל�?פשר מעקב �?חר הקלקות.";
$GLOBALS['strTypeHtmlPhp']			= " �?פשר יישו�? ביטויי PHP מתוך ב�?נרי�? מסוג HTML ";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "מידע ספקית ומעקב גי�?וגרפי (Geotargeting)";
$GLOBALS['strRemoteHosts']			= "שרתי�? מרוחקי�?";

$GLOBALS['strReverseLookup']			= "נסה לקבוע �?ת ספקית השירות של המבקר �?�? הנתון ל�? מגיע מהשרת";
$GLOBALS['strProxyLookup']				= "נסה לקבוע �?ת כתובת ה-IP ה�?מיתית של המבקר �?�? הו�? משתמש במ�?גר ביניי�? (proxy).";

$GLOBALS['strGeotargeting']				= "Geotargeting - מיקוד גי�?וגרפי";
$GLOBALS['strGeotrackingType']			= "סוג מ�?גר מעקב";
$GLOBALS['strGeotrackingLocation'] 		= "מיקו�? מ�?גר מעקב";
$GLOBALS['strGeotrackingLocationError'] = "מ�?גר הנתוני�? של מעקב גי�?וגרפי �?ינו נמצ�? במיקו�? שנמסר";
$GLOBALS['strGeoStoreCookie']			= "שמור �?ת התוצ�?ה בקוקי (cookie) להתיחסות עתידית";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "קביעות סטטיסטיקה";

$GLOBALS['strStatisticsFormat']			= "תצורת סטטיסטיקה";
$GLOBALS['strCompactStats']			= " השתמש בסטטיסטיקה קומפקטית";
$GLOBALS['strLogAdviews']			= " תעד חשיפות";
$GLOBALS['strLogAdclicks']				= "תעד הקלקה בכל פע�? שהמבקר לוחץ על ב�?נר";
$GLOBALS['strLogSource']				= "תעד �?ת נתוני המקור המוגדרי�? בזמן החשיפה";
$GLOBALS['strGeoLogStats']				= "תעד בסטטיסטיקה �?ת ה�?רץ ממנה מגיע המבקר";
$GLOBALS['strLogHostnameOrIP']			= "תעד �?ת ספקית השירות �?ו כתובת ה-IP של המבקר";
$GLOBALS['strLogIPOnly']				= "תעד �?ת כתובת ה-IP של המבקר �?פילו �?�? ש�? הספקית ידוע";
$GLOBALS['strLogIP']					= "תעד �?ת כתובת ה-IP של המבקר";
$GLOBALS['strLogBeacon']			= " השתמש ב�?תתי�? לתיעוד חשיפות";


$GLOBALS['strIgnoreHosts']				= "�?ל תתעד סטטיסטיקה ממבקרי�? המשתמשי�? ב�?חד ממספרי ה-IP �?ו שמות המ�?רחי�? הב�?י�?";
$GLOBALS['strBlockAdviews']				= "�?ל תתעד חשיפות �?�? המבקר כבר נחשף לב�?נר הזה במהלך מספר השניות הנקוב.";
$GLOBALS['strBlockAdclicks']			= "�?ל תתעד הקלקות �?�? המבקר כבר לחץ על �?ותו הב�?נר במהלך מספר השניות הנקוב";


$GLOBALS['strPreventLogging']			= "מנע התחברות";
$GLOBALS['strEmailWarnings']			= "�?תר�?ה ב�?ימייל";
$GLOBALS['strAdminEmailHeaders']		= "הוסף �?ת הכותרת הב�?ה לכל �?ימייל שישלח על ידי ".MAX_PRODUCT_NAME;
$GLOBALS['strWarnLimit']				= "שלח �?תר�?ה כ�?שר מספר החשיפות הנותר הינו פחות מהנקוב כ�?ן";

$GLOBALS['strWarnAdmin']			= " שלח התר�?ת מנהל בכל פע�? שקמפין מסויי�? לפני סיומו";
$GLOBALS['strWarnClient']			= " שלח התר�?ת מפרס�? בכל פע�? שהקמפין שלו לפני סיו�?";
$GLOBALS['strQmailPatch']			= " �?פשר טל�?י qmail ";

$GLOBALS['strAutoCleanTables']			= " דילול בסיס הנתוני�?";
$GLOBALS['strAutoCleanStats']			= " דילול סטטיסטיקה";
$GLOBALS['strAutoCleanUserlog']			= " דילול תיעוד משתמש";
$GLOBALS['strAutoCleanStatsWeeks']		= " גיל מירבי של סטטיסטיקה <br>(3 שבועות מינימו�?)";
$GLOBALS['strAutoCleanUserlogWeeks']		= " גיל מירבי של תיעוד משתמש <br>(3 שבועות מינימו�?)";
$GLOBALS['strAutoCleanErr']			= " גיל מירבי חייב ליהות 3 שבועות לפחות";
$GLOBALS['strAutoCleanVacuum']			= " בצע ניקיון כללי �?וטומטית כל לילה"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "קביעות מינהלה";

$GLOBALS['strLoginCredentials']			= "הרש�?ות התחברות";
$GLOBALS['strAdminUsername']			= "ש�? המשתמש - מנהל";
$GLOBALS['strInvalidUsername']			= "ש�? משתמש פסול";

$GLOBALS['strBasicInformation']			= "מידע בסיסי";
$GLOBALS['strAdminFullName']			= "הש�? המל�? של המנהל";
$GLOBALS['strAdminEmail']			= "כתובת ה�?ימייל של המנהל";
$GLOBALS['strCompanyName']			= "ש�? החברה/�?יגוד";

$GLOBALS['strAdminCheckUpdates']		= "בדוק עדכוני�?";
$GLOBALS['strAdminCheckEveryLogin']		= "בכל התחברות";
$GLOBALS['strAdminCheckDaily']			= "יומית";
$GLOBALS['strAdminCheckWeekly']			= "שבועית";
$GLOBALS['strAdminCheckMonthly']		= "חודשית";
$GLOBALS['strAdminCheckNever']			= "�?ף פע�?";

$GLOBALS['strAdminNovice']			= " פעולות המחיקה של המנהל דורשות �?ישור כמשנה זהירות";
$GLOBALS['strUserlogEmail']			= " תעד �?ת כל ה�?ימייל היוצ�?";
$GLOBALS['strUserlogPriority']			= " תעד �?ת שקלולי הקדימויות כל שעה";
$GLOBALS['strUserlogAutoClean']			= " תעד ניקוי �?וטומטי של בסיס הנתוני�?";


// User interface settings
$GLOBALS['strGuiSettings']			= "קביעות ממשק משתמש";

$GLOBALS['strGeneralSettings']			= "קביעות כלליות";
$GLOBALS['strAppName']				= "ש�? היישו�? שיוצג";
$GLOBALS['strMyHeader']				= "כותרת העמוד שלי נמצ�?ת בכתובת:";
$GLOBALS['strMyHeaderError']		= "כותרת העמוד ל�? נמצ�?ה במיקו�? שנרש�?";
$GLOBALS['strMyFooter']				= "תחתית העמוד שלי נמצ�?ת בכתובת:";
$GLOBALS['strMyFooterError']		= "תחתית העמוד ל�? נמצ�?ה במיקו�? שנרש�?";
$GLOBALS['strGzipContentCompression']		= "השתמש בדחיסת-תכולה GZIP";

$GLOBALS['strClientInterface']			= "ממשק מפרס�?";
$GLOBALS['strClientWelcomeEnabled']		= "�?פשר הודעת מילות הקדמה בהתחברות המפרס�?";
$GLOBALS['strClientWelcomeText']		= "הודעת הקדמה/ברכת ברוכי�? הב�?י�?...<br>(�?פשרי שימוש בתגי HTML)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "ברירת מחדל ממשקית";

$GLOBALS['strInventory']			= "מצ�?י";
$GLOBALS['strShowCampaignInfo']			= " הצג מידע נוסף עבור קמפיין בעמוד <i>סקירת קמפיין</i>";
$GLOBALS['strShowBannerInfo']			= " הצג מידע נוסף עבור ב�?נר בעמוד <i>סקירת ב�?נרי�?</i>";
$GLOBALS['strShowCampaignPreview']		= " תצוגה מקדמת של כל הב�?נרי�? בעמוד <i>סקירת ב�?נרי�?</i>";
$GLOBALS['strShowBannerHTML']			= " הצג ב�?נר ממשי במקו�? קוד רגיל של  HTML, במצב תצוגת ב�?נרי�? מסוג HTML";
$GLOBALS['strShowBannerPreview']		= " תצוגה מקדימה של ב�?נרי�? בכותרת העמוד העוסק בב�?נרי�?";
$GLOBALS['strHideInactive']			= " הסתר פרטי�? ל�? פעילי�? בכל עמודי תצוגה מקדימה";
$GLOBALS['strGUIShowMatchingBanners']		= " הצג ב�?נרי�? תו�?מי�? בעמודי <i>ב�?נרי�? מקושרי�?</i>";
$GLOBALS['strGUIShowParentCampaigns']		= " הר�?ה קמפיין-�?ב בעמודי <i>ב�?נרי�? מקושרי�?</i>";
$GLOBALS['strGUILinkCompactLimit']		= " הסתר קמפייני�? ל�? קשורי�? �?ו ב�?נרי�?, בעמודי <i>ב�?נר מקושר</i>, כ�?שר יש יותר מ-";

$GLOBALS['strStatisticsDefaults'] 		= "סטטיסטיקה";
$GLOBALS['strBeginOfWeek']			= "השבוע מתחיל ביו�?";
$GLOBALS['strPercentageDecimals']		= "נקודה עשרונית";

$GLOBALS['strWeightDefaults']			= "משקל התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultBannerWeight']		= "משקל ב�?נר התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultCampaignWeight']		= "משקל קמפיין התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultBannerWErr']		= "משקל התחלתי של ב�?נר צריך להיות מספר חיובי";
$GLOBALS['strDefaultCampaignWErr']		= "משקל קמפיין התחלתי חייב להיות מספר חיובי";


// Not used at the moment
$GLOBALS['strTableBorderColor']			= "צבע המסגרת של הטבלה";
$GLOBALS['strTableBackColor']			= "צבע הרקע של הטבלה";
$GLOBALS['strTableBackColorAlt']		= "צבע הרקע  של הטבלה(חלופי)";
$GLOBALS['strMainBackColor']			= "צבע רקע ר�?שי";
$GLOBALS['strOverrideGD']			= "�?כוף תמונה בתצורת GD";
$GLOBALS['strTimeZone']				= "�?יזור זמן";


?>