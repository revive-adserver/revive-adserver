<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.8                                                                |
| ==========                                                                |
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
$Id: settings.lang.php 62345 2010-09-14 21:16:38Z chris.nutting $
*/

// Installer translation strings
$GLOBALS['strInstall']				= "התקן";
$GLOBALS['strChooseInstallLanguage']		= "בחר את שפת ההתקנה";
$GLOBALS['strLanguageSelection']		= "בחירת שפה";
$GLOBALS['strDatabaseSettings']			= "קביעות בסיס נתונים";
$GLOBALS['strAdminSettings']			= "קביעות מנהל";
$GLOBALS['strAdvancedSettings']			= "קביעות מתקדמות";
$GLOBALS['strOtherSettings']			= "קביעות �?חרות";

$GLOBALS['strWarning']				= "�?זהרה";
$GLOBALS['strFatalError']			= "קרתה שגיאה גורלית";
$GLOBALS['strUpdateError']			= "חלה שגיאה בזמן העדכון";
$GLOBALS['strUpdateDatabaseError']	= "מסיבות לא ברורות עדכון בסיס הנתונים לא הצליח. הררך המומלצת להמשיך היא ללחוץ <b>נסה עדכון מחדש</b> כדי לנסות ולתקן בעיותאפשריות. �?�? אתה בטוח שבעיות �?לו לא יכולות לפגוע בתפקוד ".MAX_PRODUCT_NAME." אתה יכול ללחוץ <b>התעלם משגיםות</b> כדי להמשיך. התעלמות משגיםות �?לואפשר שתיור בעיה חמורה וזה לא מומלץ!";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME." כבר מותקנת במערכת זו. �?�? אתה רוצה לעצב �?ותה לך ל<a href='settings-index.php'>קיבעות ממשק</a>";
$GLOBALS['strCouldNotConnectToDB']		= "לא יכול להתחבר לבסיס הנתונים, �?נ�? בדוק מחדש את הקביעות שרשמת.";
$GLOBALS['strCreateTableTestFailed']		= "לש�? המשתמש שרשמת �?ין מספיק הרש�?ה ליצירת �?ו עדכון מבנה בסיס הנתונים, �?נ�? צור קשר עם ה�?חר�?י בשרת.";
$GLOBALS['strUpdateTableTestFailed']		= "לש�? המשתמש שרשמת �?ין די הרש�?ה לעדכון בסיס הנתונים. �?נ�? צור קשר עם ה�?חר�?ים.";
$GLOBALS['strTablePrefixInvalid']		= "קידומת הטבלאות מכילה �?ותיות פסולות.";
$GLOBALS['strTableInUse']			= "בסיס הנתונים שרשמת נמצ�? כבר בשימוש של ".MAX_PRODUCT_NAME.", �?נ�? בחר בקידומת טבלאות �?חרת, �?ו קר�? את המדריך לגבי הור�?ות שדרוג.";
$GLOBALS['strTableWrongType']		= "סוג הטבלה שבחרת אינו נתמך בהתקנת ".$phpAds_dbmsname."שלך";
$GLOBALS['strMayNotFunction']			= "לפני שאתה ממשיך, �?נ�? תקן את הבעיה ה�?פשריות ה�?לו:";
$GLOBALS['strFixProblemsBefore']		= "הפריט(ים) הב�?(ים) דורשים תיקון לפני שניתן יהיה להתקין את ".MAX_PRODUCT_NAME.". �?�? יש לך ש�?לה לגבי שיםה זו, �?נ�? קר�? את ה<i>מדריך לאדמיניסטרטור</i>, הנמצ�? בחבילה שהורדת.";
$GLOBALS['strFixProblemsAfter']			= "�?�? �?ין ב�?פשרותך לתקן את הבעיה שהוצגה מעלה, נ�? צור שר עם ה�?חר�?י של השרת שעליו אתה מנסה להתקין את ".MAX_PRODUCT_NAME.".אפשר שהו�? יוכל לעזור לך �?ו לכוון לפתרון.";
$GLOBALS['strIgnoreWarnings']			= "התעלם מ�?ז�?רות";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME." נדרש PHP 4.0 �?ו גירסה גבוהה יותר לש�? תפקוד נכון. אתה משתמש כעת בגירסה {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "קונפיגורצית  PHP של המשתנה <B>register_globals</B> צריכה להיות מופעלת.";
$GLOBALS['strWarningMagicQuotesGPC']		= "קונפיגורצית  PHP של המשתנה  <B>magic_quotes_gpc</B>  צריכה להיות מופעלת.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "קונפיגורצית  PHP של המשתנה  <B>magic_quotes_runtime</B>  צריכה להיות מופעלת.";
$GLOBALS['strWarningFileUploads']		= "קונפיגורצית  PHP של המשתנה  <B>file_uploads</B>  צריכה להיות מופעלת.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME." זיהה שהקובץ <b>config.inc.php</b> מוגן מכתיבה.<br> לא תוכל להמשיך עד שתשנה את �?ישור הגישה לקובץ זה. <br>קר�? את התיעוד המצורף �?�? �?ינך יודע כיצד לעשות זאת.";
$GLOBALS['strCantUpdateDB']  			= "לא ניתן לעדכן את בסיס הנתונים כעתץ �?�? החלטת להמשיך, כל הבאנרים הקיימים, סטטיסטיקה ומפרסמים ימחקו.";
$GLOBALS['strIgnoreErrors']			= "התעלם משגיםות";
$GLOBALS['strRetryUpdate']			= "נסה עדכון מחדש";
$GLOBALS['strTableNames']			= "שמות הטבלאות";
$GLOBALS['strTablesPrefix']			= "קידומת של טבלאות";
$GLOBALS['strTablesType']			= "סוגי הטבלאות";

$GLOBALS['strInstallWelcome']			= "ברוכים הבאים".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "לפני השימוש ב-".MAX_PRODUCT_NAME." יש לעצב את תפקודי התוכנה ויצור בסיס נתונים.<br>לחץ <b>המשך</b> להתקדמות.";
$GLOBALS['strInstallSuccess']			= "<b>ההתקנה של ".MAX_PRODUCT_NAME." הסתיימה ברגע זה.</b><br><br>כדי ש- ".MAX_PRODUCT_NAME." תתפקד נכון עליך ג�? לווד�? שקובץ התחזוקה ירוץ כל שעה. מידע נוסף �?ודות נוש�? זה ניתן למצו�? בתיעוד המצורף. <br><br>לחץ <b>המשך</b> כדי להגיע לעמוד העיצוב/קינפוג, היכן שתוכל לקבוע נתונים נוספים. �?נ�? �?ל תשכח לנעול את הקובץ <B> config.inc.php</B> ברגע שסיימת, כדי למנוע פגיעות והטרדות בשרת.";
$GLOBALS['strUpdateSuccess']			= "<b>העדכון של ".MAX_PRODUCT_NAME." הסתיים בהצלחה.</b><br><br>כדי ש-".MAX_PRODUCT_NAME." תתפקד נכון עליך ג�? להבטיח שקובץ התחזוקה ירוץ כל שעה (עד עתה הו�? נדרש לרוץ פעם ביו�?) מידע נוסף בנוש�? זה ניתן למצו�? בתיעוד המצורף. <br><br>לחץ <b>המשך</b> כדי להגיע לעמוד ממשק ההנהלה. �?נ�? �?ל תשכח לנעול את הקובץ  <B>config.inc.php</B> למניעת בעיות �?בטחה.";
$GLOBALS['strInstallNotSuccessful']		= "<b>ההתקנה של ".MAX_PRODUCT_NAME."לא הצליחה</b><br><br>חלקים מסוימים מתהליך ההתקנה לא הושלמו.אפשר שבעיות �?לו הן זמניות בלבד, במקרה זה פשוט לחץ <b>המשך</b> ותחזור לשלב הר�?שון של תהליך ההתקנה. �?�? אתה רוצה לדעת יותר מה �?ומרות הודעות השגיאה מטה, וכיתד לפתור �?ותן, �?נ�? היוועץ בתיעוד המצורף.";
$GLOBALS['strErrorOccured']			= "השגיאה הב�?ה קרתה:";
$GLOBALS['strErrorInstallDatabase']		= "מבנה בסיס הנתונים לא יכל להיווצר.";
$GLOBALS['strErrorInstallConfig']		= "קובץ הקונפיגורציה �?ו בסיס הנתונים לא יכלו להתעדכן.";
$GLOBALS['strErrorInstallDbConnect']		= "לא ניתן היה להתחבר לבסיס הנתונים.";

$GLOBALS['strUrlPrefix']			= "קידומת URL";

$GLOBALS['strProceed']				= "המשך >";
$GLOBALS['strInvalidUserPwd']			= "ש�? משתמש �?ו סיסמ�? פסולים";

$GLOBALS['strUpgrade']				= "עדכון";
$GLOBALS['strSystemUpToDate']			= "המערכת שלך מוכנה ומעודנת, לא נדרש עדכון ברגע זה. <br>לחץ על <b>המשך</b> כדי להגיע לעמוד הבית.";
$GLOBALS['strSystemNeedsUpgrade']		= "מבנה בסיס הנתונים וקובץ הקונפיגורציה זקוקים לעדכון כדי שהמערכת תתפקד נכונה.<br>�?נ�? הת�?זר בסבלנות כיוון שתהליך העדכון יכול לקחת כמה דקות.";
$GLOBALS['strSystemUpgradeBusy']		= "תהליך עדכון המערכת בעיצומו, �?נ�? המתן...";
$GLOBALS['strSystemRebuildingCache']		= "בונה את זכרון המטמון מחדש, �?נ�? המתן...";
$GLOBALS['strServiceUnavalable']		= "השירות אינואפשרי זמנית. תהליך עדכון המערכת בעיצומו";

$GLOBALS['strConfigNotWritable']		= "קובץ ה-<B>config.inc.php</B> אינו ניתן לכתיבה.";






/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "בחר מחלקה";
$GLOBALS['strDayFullNames'] 			= array("ראשון","שני","שלישי","רביעי","חמישי","שישי","שבת");
$GLOBALS['strEditConfigNotPossible']    	= "לא ניתן לשנות קביעות אלו כיוון שקובץ הקונפיגורציה נעול מסיבות בטיחותיות.<br>. ברצונך לערוך שינויים, עליך לשחרר קובץ זה מנעילה";
$GLOBALS['strEditConfigPossible']		= "ניתן לערוך את כל הקביעות כיוון שקובץ הקונפיגורציה אינו נעול.<br>למניעת מחדל בטיחותי אנא נעל את הקובץ <B> config.inc.php</B>.";
;



// Database
$GLOBALS['strDatabaseSettings']			= "קביעות בסיס נתונים";
$GLOBALS['strDatabaseServer']			= "שרת בסיס הנתונים";
$GLOBALS['strDbLocal']				= "התחבר לשרת המקומי באמצעות מעברים (sockets)";
$GLOBALS['strDbHost']				= "השרת המארח";
$GLOBALS['strDbPort']				= "מספר המבואה של בסיס הנתונים (port)";
$GLOBALS['strDbUser']				= "שם המשתמש בבסיס הנתונים";
$GLOBALS['strDbPassword']			= "הסיסמא של בסיס הנתונים";
$GLOBALS['strDbName']				= "השם של בסיס הנתונים";

$GLOBALS['strDatabaseOptimalisations']		= "ייטוב בסיס הנתונים";
$GLOBALS['strPersistentConnections']		= " השתמש בחיבור רציף (בסיס הנתונים תפוס יותר)";
$GLOBALS['strInsertDelayed']			= " השתמש בהשחלת נתון מושהת (בסיס הנתונים פחות רגיש לנפילה ושגיםות)";
$GLOBALS['strCompatibilityMode']		= " השתמש בתאימות בסיס נתונים";
$GLOBALS['strCantConnectToDb']			= " לא מסוגל להתחבר לבסיס הנתונים";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "קביעות שליפה והפצה של באנרים";

$GLOBALS['strAllowedInvocationTypes']		= "סוגי קריםה מותרים";
$GLOBALS['strAllowRemoteInvocation']		= " אפשר קריםה מרוחקת";
$GLOBALS['strAllowRemoteJavascript']		= "אפשר קריםה מרוחקת עם קוד Javascript";
$GLOBALS['strAllowRemoteFrames']		= "אפשר קריםה מרוחקת לקוד מסגרות";
$GLOBALS['strAllowRemoteXMLRPC']		= "אפשר קריםה מרוחקת עם קוד XML-RPC";
$GLOBALS['strAllowLocalmode']			= "אפשר הפעלה מקומית";
$GLOBALS['strAllowInterstitial']		= "אפשר באנרים צפים";
$GLOBALS['strAllowPopups']			= "אפשר באנרים קופצים";

$GLOBALS['strUseAcl']				= " השתמש בהגבלות תצוגה";

$GLOBALS['strDeliverySettings']			= "קביעות תפוצה";
$GLOBALS['strCacheType']				= "סוג מטמון התפוצה";
$GLOBALS['strCacheFiles']				= "קבצים";
$GLOBALS['strCacheDatabase']			= "בסיס נתונים";
$GLOBALS['strCacheShmop']				= "זכרון משותף/Shmop";
$GLOBALS['strCacheSysvshm']				= "זכרון משותף/Sysvshm";
$GLOBALS['strExperimental']				= "נסיוני";

$GLOBALS['strKeywordRetrieval']			= "שליפה לפי מילות מפתח";
$GLOBALS['strBannerRetrieval']			= " שיטת שליפת הבאנרים";
$GLOBALS['strRetrieveRandom']			= " שליפה אקראית (ברירת מחדל)";
$GLOBALS['strRetrieveNormalSeq']		= " שליפה סדרתית רגילה";
$GLOBALS['strWeightSeq']			= " שליפה סדרתית מבוסס משקל";
$GLOBALS['strFullSeq']				= " שליפה סדרתית מלאה";
$GLOBALS['strUseConditionalKeys']		= " השתמש במילות תאי";
$GLOBALS['strUseMultipleKeys']			= " השתמש בריבוי מילות מפתח";

$GLOBALS['strZonesSettings']			= "שליפה אזורית";
$GLOBALS['strZoneCache']			= " זכרון מטמון אזורי. (יםיץ תצוגה של באנרים מבוססי אזור.)";
$GLOBALS['strZoneCacheLimit']			= " הזמן שבין עדכוני זכרון מטמון (בשניות)";
$GLOBALS['strZoneCacheLimitErr']		= " הזמן שבין עדכוני זכרון מטמון חייב להיות מספר חיובי";

$GLOBALS['strP3PSettings']			= "פוליסות פרטיות מסוג P3P";
$GLOBALS['strUseP3P']				= " השתמש בפוליסות P3P";
$GLOBALS['strP3PCompactPolicy']			= "פוליסת P3P קומפקטית";
$GLOBALS['strP3PPolicyLocation']		= "מיקום פוליסת ה-P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "קביעות באנרים";

$GLOBALS['strAllowedBannerTypes']		= "סוגי באנרים מותרים";
$GLOBALS['strTypeSqlAllow']			= "אפשר באנרים מקומיים (SQL)";
$GLOBALS['strTypeWebAllow']			= "אפשר באנרים מקומיים (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "אפשר באנרים חיצוניים";
$GLOBALS['strTypeHtmlAllow']			= "אפשר באנרים מקוד HTML";
$GLOBALS['strTypeTxtAllow']			= "אפשר באנרים טקסטואליים";

$GLOBALS['strTypeWebSettings']			= "קונפיגורציית באנר מקומי (השרת)";
$GLOBALS['strTypeWebMode']			= "שיטת איחסון";
$GLOBALS['strTypeWebModeLocal']			= "תיקייה מקומית";
$GLOBALS['strTypeWebModeFtp']			= "שרת FTP חיצוני";
$GLOBALS['strTypeWebDir']			= "תיקייה מקומית";
$GLOBALS['strTypeWebFtp']			= "שרת באנרים בתצורת FTP";
$GLOBALS['strTypeWebUrl']			= "כתובת URL ציבורית";
$GLOBALS['strTypeFTPHost']			= "מארח FTP";
$GLOBALS['strTypeFTPDirectory']			= "תיקיית FTP";
$GLOBALS['strTypeFTPUsername']			= "שם משתמש";
$GLOBALS['strTypeFTPPassword']			= "סיסמא";

$GLOBALS['strTypeFTPErrorDir']			= "תיקיית השרת אינה קיימת";
$GLOBALS['strTypeFTPErrorConnect']		= "לא ניתן היה להתחבר לשרת ה-FTP, ש�? המשתמש �?ו הסיסמ�? שגויים";
$GLOBALS['strTypeFTPErrorHost']			= "ש�? שרת ה-FTP אינו נכון";
$GLOBALS['strTypeFTPErrorDir']			= "תקיית המ�?רח �?ינה קיימת";
$GLOBALS['strTypeFTPErrorConnect']		= "לא ניתן להתחבר לשרת ה-FTP, ש�? המשתמש �?ו הסיסמ�? שגויים";
$GLOBALS['strTypeFTPErrorHost']			= "ש�? השרת המ�?רח את ה-FTP שגוי";
$GLOBALS['strTypeDirError']				= "התיקייה המקומית �?ינה קיימת";



$GLOBALS['strDefaultBanners']			= "באנרים כברירת מחדל חלופית";
$GLOBALS['strDefaultBannerUrl']			= "כתובת URL של באנר חלופי";
$GLOBALS['strDefaultBannerTarget']		= "כתובת URL כמטרה חלופית";

$GLOBALS['strTypeHtmlSettings']			= "אופציות באנר HTML";
$GLOBALS['strTypeHtmlAuto']			= " שנה את הקוד אוטומטית כדי לאפשר מעקב אחר הקלקות.";
$GLOBALS['strTypeHtmlPhp']			= "אפשר יישום ביטויי PHP מתוך באנרים מסוג HTML ";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "מידע ספקית ומעקב גיםוגרפי (Geotargeting)";
$GLOBALS['strRemoteHosts']			= "שרתים מרוחקים";

$GLOBALS['strReverseLookup']			= "נסה לקבוע את ספקית השירות של המבקר �?�? הנתון לא מגיע מהשרת";
$GLOBALS['strProxyLookup']				= "נסה לקבוע את כתובת ה-IP ה�?מיתית של המבקר �?�? הו�? משתמש במ�?גר ביניים (proxy).";

$GLOBALS['strGeotargeting']				= "Geotargeting - מיקוד גיםוגרפי";
$GLOBALS['strGeotrackingType']			= "סוג מ�?גר מעקב";
$GLOBALS['strGeotrackingLocation'] 		= "מיקו�? מ�?גר מעקב";
$GLOBALS['strGeotrackingLocationError'] = "מ�?גר הנתונים של מעקב גיםוגרפי אינו נמצ�? במיקו�? שנמסר";
$GLOBALS['strGeoStoreCookie']			= "שמור את התוצ�?ה בקוקי (cookie) להתיחסות עתידית";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "קביעות סטטיסטיקה";

$GLOBALS['strStatisticsFormat']			= "תצורת סטטיסטיקה";
$GLOBALS['strCompactStats']			= " השתמש בסטטיסטיקה קומפקטית";
$GLOBALS['strLogAdviews']			= " תעד חשיפות";
$GLOBALS['strLogAdclicks']				= "תעד הקלקה בכל פעם שהמבקר לוחץ על באנר";
$GLOBALS['strLogSource']				= "תעד את נתוני המקור המוגדרים בזמן החשיפה";
$GLOBALS['strGeoLogStats']				= "תעד בסטטיסטיקה את ה�?רץ ממנה מגיע המבקר";
$GLOBALS['strLogHostnameOrIP']			= "תעד את ספקית השירות �?ו כתובת ה-IP של המבקר";
$GLOBALS['strLogIPOnly']				= "תעד את כתובת ה-IP של המבקר �?פילו �?�? ש�? הספקית ידוע";
$GLOBALS['strLogIP']					= "תעד את כתובת ה-IP של המבקר";
$GLOBALS['strLogBeacon']			= " השתמש באתתים לתיעוד חשיפות";


$GLOBALS['strIgnoreHosts']				= "�?ל תתעד סטטיסטיקה ממבקרים המשתמשים ב�?חד ממספרי ה-IP �?ו שמות המ�?רחים הב�?ים";
$GLOBALS['strBlockAdviews']				= "�?ל תתעד חשיפות �?�? המבקר כבר נחשף לבאנר הזה במהלך מספר השניות הנקוב.";
$GLOBALS['strBlockAdclicks']			= "�?ל תתעד הקלקות �?�? המבקר כבר לחץ על �?ותו הבאנר במהלך מספר השניות הנקוב";


$GLOBALS['strPreventLogging']			= "מנע התחברות";
$GLOBALS['strEmailWarnings']			= "אתר�?ה ב�?ימייל";
$GLOBALS['strAdminEmailHeaders']		= "הוסף את הכותרת הב�?ה לכל �?ימייל שישלח על ידי ".MAX_PRODUCT_NAME;
$GLOBALS['strWarnLimit']				= "שלח אתר�?ה כ�?שר מספר החשיפות הנותר הינו פחות מהנקוב כ�?ן";

$GLOBALS['strWarnAdmin']			= " שלח התראת מנהל בכל פעם שקמפין מסויים לפני סיומו";
$GLOBALS['strWarnClient']			= " שלח התראת מפרס�? בכל פעם שהקמפין שלו לפני סיו�?";
$GLOBALS['strQmailPatch']			= "אפשר טלאי qmail ";

$GLOBALS['strAutoCleanTables']			= " דילול בסיס הנתונים";
$GLOBALS['strAutoCleanStats']			= " דילול סטטיסטיקה";
$GLOBALS['strAutoCleanUserlog']			= " דילול תיעוד משתמש";
$GLOBALS['strAutoCleanStatsWeeks']		= " גיל מירבי של סטטיסטיקה <br>(3 שבועות מינימו�?)";
$GLOBALS['strAutoCleanUserlogWeeks']		= " גיל מירבי של תיעוד משתמש <br>(3 שבועות מינימו�?)";
$GLOBALS['strAutoCleanErr']			= " גיל מירבי חייב ליהות 3 שבועות לפחות";
$GLOBALS['strAutoCleanVacuum']			= " בצע ניקיון כללי �?וטומטית כל לילה"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "קביעות מינהלה";

$GLOBALS['strLoginCredentials']			= "הרשאות התחברות";
$GLOBALS['strAdminUsername']			= "שם המשתמש - מנהל";
$GLOBALS['strInvalidUsername']			= "שם משתמש פסול";

$GLOBALS['strBasicInformation']			= "מידע בסיסי";
$GLOBALS['strAdminFullName']			= "הש�? המלא של המנהל";
$GLOBALS['strAdminEmail']			= "כתובת ה�?ימייל של המנהל";
$GLOBALS['strCompanyName']			= "ש�? החברה/�?יגוד";

$GLOBALS['strAdminCheckUpdates']		= "בדוק עדכונים";
$GLOBALS['strAdminCheckEveryLogin']		= "בכל התחברות";
$GLOBALS['strAdminCheckDaily']			= "יומית";
$GLOBALS['strAdminCheckWeekly']			= "שבועית";
$GLOBALS['strAdminCheckMonthly']		= "חודשית";
$GLOBALS['strAdminCheckNever']			= "�?ף פעם";

$GLOBALS['strAdminNovice']			= " פעולות המחיקה של המנהל דורשות �?ישור כמשנה זהירות";
$GLOBALS['strUserlogEmail']			= " תעד את כל ה�?ימייל היוצ�?";
$GLOBALS['strUserlogPriority']			= " תעד את שקלולי הקדימויות כל שעה";
$GLOBALS['strUserlogAutoClean']			= " תעד ניקוי אוטומטי של בסיס הנתונים";


// User interface settings
$GLOBALS['strGuiSettings']			= "קביעות ממשק משתמש";

$GLOBALS['strGeneralSettings']			= "קביעות כלליות";
$GLOBALS['strAppName']				= "ש�? היישו�? שיוצג";
$GLOBALS['strMyHeader']				= "כותרת העמוד שלי נמצאת בכתובת:";
$GLOBALS['strMyHeaderError']		= "כותרת העמוד לא נמצ�?ה במיקו�? שנרש�?";
$GLOBALS['strMyFooter']				= "תחתית העמוד שלי נמצאת בכתובת:";
$GLOBALS['strMyFooterError']		= "תחתית העמוד לא נמצ�?ה במיקו�? שנרש�?";
$GLOBALS['strGzipContentCompression']		= "השתמש בדחיסת-תכולה GZIP";

$GLOBALS['strClientInterface']			= "ממשק מפרס�?";
$GLOBALS['strClientWelcomeEnabled']		= "�?פשר הודעת מילות הקדמה בהתחברות המפרס�?";
$GLOBALS['strClientWelcomeText']		= "הודעת הקדמה/ברכת ברוכים הב�?ים...<br>(�?פשרי שימוש בתגי HTML)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "ברירת מחדל ממשקית";

$GLOBALS['strInventory']			= "מצאי";
$GLOBALS['strShowCampaignInfo']			= " הצג מידע נוסף עבור קמפיין בעמוד <i>סקירת קמפיין</i>";
$GLOBALS['strShowBannerInfo']			= " הצג מידע נוסף עבור באנר בעמוד <i>סקירת באנרים</i>";
$GLOBALS['strShowCampaignPreview']		= " תצוגה מקדמת של כל הבאנרים בעמוד <i>סקירת באנרים</i>";
$GLOBALS['strShowBannerHTML']			= " הצג באנר ממשי במקו�? קוד רגיל של  HTML, במצב תצוגת באנרים מסוג HTML";
$GLOBALS['strShowBannerPreview']		= " תצוגה מקדימה של באנרים בכותרת העמוד העוסק בבאנרים";
$GLOBALS['strHideInactive']			= " הסתר פרטים לא פעילים בכל עמודי תצוגה מקדימה";
$GLOBALS['strGUIShowMatchingBanners']		= " הצג באנרים תואמים בעמודי <i>באנרים מקושרים</i>";
$GLOBALS['strGUIShowParentCampaigns']		= " הראה קמפיין-אב בעמודי <i>באנרים מקושרים</i>";
$GLOBALS['strGUILinkCompactLimit']		= " הסתר קמפיינים לא קשורים �?ו באנרים, בעמודי <i>באנר מקושר</i>, כ�?שר יש יותר מ-";

$GLOBALS['strStatisticsDefaults'] 		= "סטטיסטיקה";
$GLOBALS['strBeginOfWeek']			= "השבוע מתחיל ביו�?";
$GLOBALS['strPercentageDecimals']		= "נקודה עשרונית";

$GLOBALS['strWeightDefaults']			= "משקל התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultBannerWeight']		= "משקל באנר התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultCampaignWeight']		= "משקל קמפיין התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultBannerWErr']		= "משקל התחלתי של באנר צריך להיות מספר חיובי";
$GLOBALS['strDefaultCampaignWErr']		= "משקל קמפיין התחלתי חייב להיות מספר חיובי";


// Not used at the moment
$GLOBALS['strTableBorderColor']			= "צבע המסגרת של הטבלה";
$GLOBALS['strTableBackColor']			= "צבע הרקע של הטבלה";
$GLOBALS['strTableBackColorAlt']		= "צבע הרקע  של הטבלה(חלופי)";
$GLOBALS['strMainBackColor']			= "צבע רקע ר�?שי";
$GLOBALS['strOverrideGD']			= "�?כוף תמונה בתצורת GD";
$GLOBALS['strTimeZone']				= "�?יזור זמן";


?>