<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']				= "התקן";
$GLOBALS['strChooseInstallLanguage']		= "בחר את שפת ההתקנה";
$GLOBALS['strLanguageSelection']		= "בחירת שפה";
$GLOBALS['strDatabaseSettings']			= "קביעות בסיס נתונים";
$GLOBALS['strAdminSettings']			= "קביעות מנהל";
$GLOBALS['strAdvancedSettings']			= "קביעות מתקדמות";
$GLOBALS['strOtherSettings']			= "קביעות אחרות";

$GLOBALS['strWarning']				= "אזהרה";
$GLOBALS['strFatalError']			= "קרתה שגיאה גורלית";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." כבר מותקנת במערכת זו. אם אתה רוצה לעצב אותה לך ל<a href='settings-index.php'>קיבעות ממשק</a>";
$GLOBALS['strCouldNotConnectToDB']		= "לא יכול להתחבר לבסיס הנתונים, אנא בדוק מחדש את הקביעות שרשמת.";
$GLOBALS['strCreateTableTestFailed']		= "לשם המשתמש שרשמת אין מספיק הרשאה ליצירת או עדכון מבנה בסיס הנתונים, אנא צור קשר עם האחראי בשרת.";
$GLOBALS['strUpdateTableTestFailed']		= "לשם המשתמש שרשמת אין די הרשאה לעדכון בסיס הנתונים. אנא צור קשר עם האחראים.";
$GLOBALS['strTablePrefixInvalid']		= "קידומת הטבלאות מכילה אותיות פסולות.";
$GLOBALS['strTableInUse']			= "בסיס הנתונים שרשמת נמצא כבר בשימוש של ".$phpAds_productname.", אנא בחר בקידומת טבלאות אחרת, או קרא את המדריך לגבי הוראות שדרוג.";
$GLOBALS['strMayNotFunction']			= "לפני שאתה ממשיך, אנא תקן את הבעיה האפשריות האלו:";
$GLOBALS['strIgnoreWarnings']			= "התעלם מאזארות";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." נדרש PHP 4.0 או גירסה גבוהה יותר לשם תפקוד נכון. אתה משתמש כעת בגירסה {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "קונפיגורצית  PHP של המשתנה <B>register_globals</B> צריכה להיות מופעלת.";
$GLOBALS['strWarningMagicQuotesGPC']		= "קונפיגורצית  PHP של המשתנה  <B>magic_quotes_gpc</B>  צריכה להיות מופעלת.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "קונפיגורצית  PHP של המשתנה  <B>magic_quotes_runtime</B>  צריכה להיות מופעלת.";
$GLOBALS['strWarningFileUploads']		= "קונפיגורצית  PHP של המשתנה  <B>file_uploads</B>  צריכה להיות מופעלת.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." זיהה שהקובץ <b>config.inc.php</b> מוגן מכתיבה.<br> לא תוכל להמשיך עד שתשנה את אישור הגישה לקובץ זה. <br>קרא את התיעוד המצורף אם אינך יודע כיצד לעשות זאת.";
$GLOBALS['strCantUpdateDB']  			= "לא ניתן לעדכן את בסיס הנתונים כעתץ אם החלטת להמשיך, כל הבאנרים הקיימים, סטטיסטיקה ומפרסמים ימחקו.";
$GLOBALS['strTableNames']			= "שמות הטבלאות";
$GLOBALS['strTablesPrefix']			= "קידומת של טבלאות";
$GLOBALS['strTablesType']			= "סוגי הטבלאות";

$GLOBALS['strInstallWelcome']			= "ברוכים הבאים ל".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "לפני השימוש ב-".$phpAds_productname." יש לעצב את תפקודי התוכנה ויצור בסיס נתונים.<br>לחץ <b>המשך</b> להתקדמות.";
$GLOBALS['strInstallSuccess']			= "<b>ההתקנה של ".$phpAds_productname." הסתיימה ברגע זה.</b><br><br>כדי ש- ".$phpAds_productname." תתפקד נכון עליך גם לוודא שקובץ התחזוקה ירוץ כל שעה. מידע נוסף אודות נושא זה ניתן למצוא בתיעוד המצורף. <br><br>לחץ <b>המשך</b> כדי להגיע לעמוד העיצוב/קינפוג, היכן שתוכל לקבוע נתונים נוספים. אנא אל תשכח לנעול את הקובץ <B> config.inc.php</B> ברגע שסיימת, כדי למנוע פגיעות והטרדות בשרת.";
$GLOBALS['strUpdateSuccess']			= "<b>העשכון של ".$phpAds_productname." הסתיים בהצלחה.</b><br><br>כדי ש-".$phpAds_productname." תתפקד נכון עליך גם tלהבטיח שקובץ התחזוקה ירוץ כל שעה (עד עתה הוא נדרש לרוץ פעם ביום) מידע נוסף בנושא זה ניתן למצוא בתיעוד המצורף. <br><br>לחץ <b>המשך</b> כדי להגיע לעמוד ממשק ההנהלה. אנא אל תשכח לנעול את הקובץ  <B>config.inc.php</B> למניעת בעיות אבטחה.";
$GLOBALS['strInstallNotSuccessful']		= "<b>ההתקנה של ".$phpAds_productname."לא הצליחה</b><br><br>חלקים מסוימים מתהליך ההתקנה לא הושלמו. אפשר שבעיות אלו הן זמניות בלבד, במקרה זה פשוט לחץ <b>המשך</b> ותחזור לשלב הראשון של תהליך ההתקנה. אם אתה רוצה לדעת יותר מה אומרות הודעות השגיאה מטה, וכיתד לפתור אותן, אנא היוועץ בתיעוד המצורף.";
$GLOBALS['strErrorOccured']			= "השגיאה הבאה קרתה:";
$GLOBALS['strErrorInstallDatabase']		= "מבנה בסיס הנתונים לא יכל להיווצר.";
$GLOBALS['strErrorInstallConfig']		= "קובץ הקונפיגורציה או בסיס הנתונים לא יכלו להתעדכן.";
$GLOBALS['strErrorInstallDbConnect']		= "לא ניתן היה להתחבר לבסיס הנתונים.";

$GLOBALS['strUrlPrefix']			= "קידומת URL";

$GLOBALS['strProceed']				= "המשך &gt;";
$GLOBALS['strRepeatPassword']			= "חזור על הסיסמא";
$GLOBALS['strNotSamePasswords']			= "סיסמאות אינן תואמות";
$GLOBALS['strInvalidUserPwd']			= "שם משתמש או סיסמא פסולים";

$GLOBALS['strUpgrade']				= "עדכון";
$GLOBALS['strSystemUpToDate']			= "המערכת שלך מוכנה ומעודנת, לא נדרש עדכון ברגע זה. <br>לחץ על <b>המשך</b> כדי להגיע לעמוד הבית.";
$GLOBALS['strSystemNeedsUpgrade']		= "מבנה בסיס הנתונים וקובץ הקוניגורציה זקוקים לעדכון כדי שהמערכת תתפקד נכונה.<br>אנא התאזר בסבלנות כיוון שתהליך העשכון יכול לקחת כמה דקות.";
$GLOBALS['strSystemUpgradeBusy']		= "תהליך עדכון המערכת בעיצומו, אנא המתן...";
$GLOBALS['strSystemRebuildingCache']		= "בונה את זכרון המטמון מחדש, אנא המתן...";
$GLOBALS['strServiceUnavalable']		= "השירות אינו אפשרי זמנית. תהליך עדכון המערכת בעיצומו";

$GLOBALS['strConfigNotWritable']		= "קובץ ה-<B>config.inc.php</B> אינו ניתן לכתיבה.";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "בחר מחלקה";
$GLOBALS['strDayFullNames'] 			= array("ראשון","שני","שלישי","רביעי","חמישי","שישי","שבת");
$GLOBALS['strEditConfigNotPossible']    	= "לא ניתן לשנות קביעות אלו כיוון שקובץ הקונפיגורציה נעול מסיבות בטיחותיות.<br> "."אם ברצונך לערוך שינויים, עליך לשחרר קובץ זה מנעילה";
$GLOBALS['strEditConfigPossible']		= "ניתן לערוך את כל הקביעות כיוון שקובץ הקונפיגורציה אינו נעול.<br>למניעת מחדל בטיחותי אנא נעל את הקובץ <B> config.inc.php</B>.";



// Database
$GLOBALS['strDatabaseSettings']			= "קביעות בסיס נתונים";
$GLOBALS['strDatabaseServer']			= "שרת בסיס הנתונים";
$GLOBALS['strDbHost']				= "השרת המארח";
$GLOBALS['strDbUser']				= "שם המשתמש בבסיס הנתונים";
$GLOBALS['strDbPassword']			= "הסיסמא של בסיס הנתונים";
$GLOBALS['strDbName']				= "השם של בסיס הנתונים";

$GLOBALS['strDatabaseOptimalisations']		= "ייטוב בסיס הנתונים";
$GLOBALS['strPersistentConnections']		= " השתמש בחיבור רציף (בסיס הנתונים תפוס יותר)";
$GLOBALS['strInsertDelayed']			= " השתמש בהשחלת נתון מושהת (בסיס הנתונים פחות רגיש לנפילה ושגיאות)";
$GLOBALS['strCompatibilityMode']		= " השתמש בתאימות בסיס נתונים";
$GLOBALS['strCantConnectToDb']			= " לא מסוגל להתחבר לבסיס הנתונים";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "קביעות שליפה והפצה של באנרים";

$GLOBALS['strAllowedInvocationTypes']		= "סוגי קריאה מותרים";
$GLOBALS['strAllowRemoteInvocation']		= " אפשר קריאה מרוחקת";
$GLOBALS['strAllowRemoteJavascript']		= " אפשר קריאה מרוחקת עם קוד Javascript";
$GLOBALS['strAllowRemoteFrames']		= " אפשר קריאה מרוחקת לקוד מסגרות";
$GLOBALS['strAllowRemoteXMLRPC']		= " אפשר קריאה מרוחקת עם קוד XML-RPC";
$GLOBALS['strAllowLocalmode']			= " אפשר הפעלה מקומית";
$GLOBALS['strAllowInterstitial']		= " אפשר באנרים צפים";
$GLOBALS['strAllowPopups']			= " אפשר באנרים קופצים";

$GLOBALS['strUseAcl']				= " השתמש בהגבלות תצוגה";
$GLOBALS['strGeotrackingType']			= "סוג מאגר מעקב";
$GLOBALS['strGeotrackingLocation'] 		= "מיקום מאגר מעקב";

$GLOBALS['strKeywordRetrieval']			= "שליפה לפי מילות מפתח";
$GLOBALS['strBannerRetrieval']			= " שיטת שליפת הבאנרים";
$GLOBALS['strRetrieveRandom']			= " שליפה אקראית (ברירת מחדל)";
$GLOBALS['strRetrieveNormalSeq']		= " שליפה סדרתית רגילה";
$GLOBALS['strWeightSeq']			= " שליפה סדרתית מבוסס משקל";
$GLOBALS['strFullSeq']				= " שליפה סדרתית מלאה";
$GLOBALS['strUseConditionalKeys']		= " השתמש במילות תנאי";
$GLOBALS['strUseMultipleKeys']			= " השתמש בריבוי מילות מפתח";

$GLOBALS['strZonesSettings']			= "שליפה אזורית";
$GLOBALS['strZoneCache']			= " זכרון מטמון אזורי. (יאיץ תצוגה של באנרים מבוססי אזור.)";
$GLOBALS['strZoneCacheLimit']			= " הזמן שבין עדכוני זכרון מטמון (בשניות)";
$GLOBALS['strZoneCacheLimitErr']		= " הזמן שבין עדכוני זכרון מטמון חייב להיות מספר חיובי";

$GLOBALS['strP3PSettings']			= "פוליסות פרטיות מסוג P3P";
$GLOBALS['strUseP3P']				= " השתמש בפוליסות P3P";
$GLOBALS['strP3PCompactPolicy']			= "פוליסת P3P קומפקטית";
$GLOBALS['strP3PPolicyLocation']		= "מיקום פוליסת ה-P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "קביעות באנרים";

$GLOBALS['strAllowedBannerTypes']		= "סוגי באנרים מותרים";
$GLOBALS['strTypeSqlAllow']			= " אפשר באנרים מקומיים (SQL)";
$GLOBALS['strTypeWebAllow']			= " אפשר באנרים מקומיים (Webserver)";
$GLOBALS['strTypeUrlAllow']			= " אפשר באנרים חיצוניים";
$GLOBALS['strTypeHtmlAllow']			= " אפשר באנרים מקוד HTML";
$GLOBALS['strTypeTxtAllow']			= " אפשר באנרים טקסטואליים";

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

$GLOBALS['strDefaultBanners']			= "באנרים כברירת מחדל חלופית";
$GLOBALS['strDefaultBannerUrl']			= "כתובת URL של באנר חלופי";
$GLOBALS['strDefaultBannerTarget']		= "כתובת URL כמטרה חלופית";

$GLOBALS['strTypeHtmlSettings']			= "אופציות באנר HTML";
$GLOBALS['strTypeHtmlAuto']			= " שנה את הקוד אוטומטית כדי לאפשר מעקב אחר הקלקות.";
$GLOBALS['strTypeHtmlPhp']			= " אפשר יישום ביטויי PHP מתוך באנרים מסוג HTML ";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "קביעות סטטיסטיקה";

$GLOBALS['strStatisticsFormat']			= "תצורת סטטיסטיקה";
$GLOBALS['strLogBeacon']			= " השתמש באתתים לתיעוד חשיפות";
$GLOBALS['strCompactStats']			= " השתמש בסטטיסטיקה קומפקטית";
$GLOBALS['strLogAdviews']			= " תעד חשיפות";
$GLOBALS['strBlockAdviews']			= " הגנה מפני כפל-רישום חשיפה (בשניות)";
$GLOBALS['strLogAdclicks']			= " תעד הקלקות";
$GLOBALS['strBlockAdclicks']			= " הגנה מפני כפל-רישום הקלקה (בשניות)";

$GLOBALS['strEmailWarnings']			= "אתראה באימייל";
$GLOBALS['strAdminEmailHeaders']		= "כותרת המכתב שישקף את השולח של הדוח היומי.";
$GLOBALS['strWarnLimit']			= "סף התראה (מינימום נותר)";
$GLOBALS['strWarnLimitErr']			= "סף אתראה חייב להיות מספר חיובי";
$GLOBALS['strWarnAdmin']			= " שלח התראת מנהל";
$GLOBALS['strWarnClient']			= " שלח התראת מפרסם";
$GLOBALS['strQmailPatch']			= " אפשר טלאי qmail ";

$GLOBALS['strRemoteHosts']			= "שרתים מרוחקים";
$GLOBALS['strIgnoreHosts']			= " התעלם משרתים";
$GLOBALS['strReverseLookup']			= " כתובת גולש (Reverse DNS Lookup)";
$GLOBALS['strProxyLookup']			= " כתובת שרת ביניים (Proxy)";

$GLOBALS['strAutoCleanTables']			= "דילול בסיס הנתונים";
$GLOBALS['strAutoCleanStats']			= "דילול סטטיסטיקה";
$GLOBALS['strAutoCleanUserlog']			= "דילול תיעוד מתמש";
$GLOBALS['strAutoCleanStatsWeeks']		= "גיל מירבי של סטטיסטיקה <br>(3 שבועות מינימום)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "גיל מירבי של תיעוד משתמש <br>(3 שבועות מינימום)";
$GLOBALS['strAutoCleanErr']			= "גיל מירבי חייב ליהות 3 שבועות לפחות";
$GLOBALS['strAutoCleanVacuum']			= "בצע ניקיון כללי אוטומטית כל לילה"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "קביעות מינהלה";

$GLOBALS['strLoginCredentials']			= "הרשאות התחברות";
$GLOBALS['strAdminUsername']			= "שם המשתמש - מנהל";
$GLOBALS['strOldPassword']			= "סיסמא קודמת";
$GLOBALS['strNewPassword']			= "סיסמא חדשה";
$GLOBALS['strInvalidUsername']			= "שם משתמש פסול";
$GLOBALS['strInvalidPassword']			= "סיסמא פסולה";

$GLOBALS['strBasicInformation']			= "מידע בסיסי";
$GLOBALS['strAdminFullName']			= "השם המלא של המנהל";
$GLOBALS['strAdminEmail']			= "כתובת האימייל של המנהל";
$GLOBALS['strCompanyName']			= "שם החברה/איגוד";

$GLOBALS['strAdminCheckUpdates']		= "בדוק עדכונים";
$GLOBALS['strAdminCheckEveryLogin']		= "בכל התחברות";
$GLOBALS['strAdminCheckDaily']			= "יומית";
$GLOBALS['strAdminCheckWeekly']			= "שבועית";
$GLOBALS['strAdminCheckMonthly']		= "חודשית";
$GLOBALS['strAdminCheckNever']			= "אף פעם";

$GLOBALS['strAdminNovice']			= " פעולות המחיקה של המנהל דורשות אישור כמשנה זהירות";
$GLOBALS['strUserlogEmail']			= " תעד את כל האימייל היוצא";
$GLOBALS['strUserlogPriority']			= " תעד את שקלולי הקדימויות כל שעה";
$GLOBALS['strUserlogAutoClean']			= " תעד ניקוי אוטומטי של בסיס הנתונים";


// User interface settings
$GLOBALS['strGuiSettings']			= "קביעות ממשק משתמש";

$GLOBALS['strGeneralSettings']			= "קביעות כלליות";
$GLOBALS['strAppName']				= "שם היישום שיוצג";
$GLOBALS['strMyHeader']				= "כותרת העמוד שלי נמצאת בכתובת:";
$GLOBALS['strMyFooter']				= "תחתית העמוד שלי נמצאת בכתובת:";
$GLOBALS['strGzipContentCompression']		= "השתמש בדחיסת-תכולה GZIP";

$GLOBALS['strClientInterface']			= "ממשק מפרסם";
$GLOBALS['strClientWelcomeEnabled']		= "אפשר הודעת מילות הקדמה בהתחברות המפרסם";
$GLOBALS['strClientWelcomeText']		= "הודעת הקדמה/ברכת ברוכים הבאים...<br>(אפשרי שימוש בתגי HTML)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "ברירת מחדל ממשקית";

$GLOBALS['strInventory']			= "מצאי";
$GLOBALS['strShowCampaignInfo']			= " הצג מידע נוסף עבור קמפיין בעמוד <i>סקירת קמפיין</i>";
$GLOBALS['strShowBannerInfo']			= " הצג מידע נוסף עבור באנר בעמוד <i>סקירת באנרים</i>";
$GLOBALS['strShowCampaignPreview']		= " תצוגה מקדמת של כל הבאנרים בעמוד <i>סקירת באנרים</i>";
$GLOBALS['strShowBannerHTML']			= " הצג באנר ממשי במקום קוד רגיל של  HTML, במצב תצוגת באנרים מסוג HTML";
$GLOBALS['strShowBannerPreview']		= " תצוגה מקדימה של באנרים בכותרת העמוד העוסק בבאנרים";
$GLOBALS['strHideInactive']			= " הסתר פרטים לא פעילים בכל עמודי תצוגה מקדימה";
$GLOBALS['strGUIShowMatchingBanners']		= " הצג באנרים תואמים בעמודי <i>באנרים מקושרים</i>";
$GLOBALS['strGUIShowParentCampaigns']		= " הראה קמפיין-אב בעמודי <i>באנרים מקושרים</i>";
$GLOBALS['strGUILinkCompactLimit']		= " הסתר קמפיינים לא קשורים או באנרים, בעמודי <i>באנר מקושר</i>, כאשר יש יותר מ-";

$GLOBALS['strStatisticsDefaults'] 		= "סטטיסטיקה";
$GLOBALS['strBeginOfWeek']			= "השבוע מתחיל ביום";
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
$GLOBALS['strMainBackColor']			= "צבע רקע ראשי";
$GLOBALS['strOverrideGD']			= "אכוף תמונה בתצורת GD";
$GLOBALS['strTimeZone']				= "איזור זמן";

?>