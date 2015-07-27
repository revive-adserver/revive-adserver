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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = "rtl";
$GLOBALS['phpAds_TextAlignRight'] = "left";
$GLOBALS['phpAds_TextAlignLeft'] = "right";


// Date & time configuration
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['month_format'] = "%m/%Y";
$GLOBALS['day_format'] = "%d/%m";
$GLOBALS['week_format'] = "%W/%Y";
$GLOBALS['weekiso_format'] = "%V/%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "ראשי";
$GLOBALS['strHelp'] = "עזרה";
$GLOBALS['strShortcuts'] = "קיצורים";
$GLOBALS['strAdminstration'] = "מלאי";
$GLOBALS['strMaintenance'] = "תחזוקה";
$GLOBALS['strProbability'] = "סיכויים";
$GLOBALS['strInvocationcode'] = "קוד תצוגה";
$GLOBALS['strBasicInformation'] = "מידע בסיסי";
$GLOBALS['strOverview'] = "סקירה כללית";
$GLOBALS['strSearch'] = "חפ<u>ש</u>";
$GLOBALS['strDetails'] = "פרטים";
$GLOBALS['strCompact'] = "קומפקטי";
$GLOBALS['strUser'] = "משתמש";
$GLOBALS['strDuplicate'] = "שכפל";
$GLOBALS['strMoveTo'] = "העבר ל";
$GLOBALS['strDelete'] = "מחק";
$GLOBALS['strActivate'] = "הפעל";
$GLOBALS['strConvert'] = "המר";
$GLOBALS['strRefresh'] = "רענן";
$GLOBALS['strSaveChanges'] = "שמור שינויים";
$GLOBALS['strUp'] = "למעלה";
$GLOBALS['strDown'] = "למטה";
$GLOBALS['strSave'] = "שמור";
$GLOBALS['strCancel'] = "בטל";
$GLOBALS['strPrevious'] = "קודם";
$GLOBALS['strNext'] = "הבם";
$GLOBALS['strYes'] = "כן";
$GLOBALS['strNo'] = "לם";
$GLOBALS['strNone'] = "אף אחד";
$GLOBALS['strCustom'] = "לפי מידה";
$GLOBALS['strDefault'] = "ברירת מחדל";
$GLOBALS['strUnknown'] = "לא ידוע";
$GLOBALS['strUnlimited'] = "ללא הגבלה";
$GLOBALS['strUntitled'] = "ללא שם";
$GLOBALS['strAverage'] = "ממוצע";
$GLOBALS['strOverall'] = "כללי";
$GLOBALS['strTotal'] = "סך הכל";
$GLOBALS['strFrom'] = "מ";
$GLOBALS['strTo'] = "ל";
$GLOBALS['strLinkedTo'] = "מקושר ל";
$GLOBALS['strDaysLeft'] = "ימיא שנותרו";
$GLOBALS['strCheckAllNone'] = "סמן הכל/ או כלום";
$GLOBALS['strExpandAll'] = "<u>פ</u>רוש הכל";
$GLOBALS['strCollapseAll'] = "<u>מ</u>כונס הכל";
$GLOBALS['strShowAll'] = "הצג הכל";
$GLOBALS['strFieldContainsErrors'] = "השדות הבאיא מכיליא שגיאות:";
$GLOBALS['strFieldFixBeforeContinue1'] = "לפני שתמשיך עליך";
$GLOBALS['strFieldFixBeforeContinue2'] = "לתקן שגיאות אלו.";
$GLOBALS['strMiscellaneous'] = "שונות";
$GLOBALS['strCollectedToday'] = "סטטיסטיקה להיוא בלבד";

// Dashboard
// Dashboard Errors

// Priority
$GLOBALS['strPriority'] = "קדימויות";
$GLOBALS['strNoLimitations'] = "ללא הגבלות";

// Properties
$GLOBALS['strName'] = "שם";
$GLOBALS['strSize'] = "גודל";
$GLOBALS['strWidth'] = "רוחב";
$GLOBALS['strHeight'] = "גובה";
$GLOBALS['strTarget'] = "חלון מטרה";
$GLOBALS['strLanguage'] = "שפה";
$GLOBALS['strDescription'] = "תיאור";

// User access

// Login & Permissions
$GLOBALS['strAuthentification'] = "אימות";
$GLOBALS['strWelcomeTo'] = "ברוכיא הבאיא ל";
$GLOBALS['strEnterUsername'] = "נא להכניס שא וסיסמא כדי להיכנס";
$GLOBALS['strEnterBoth'] = "אנא הזן את שא המשתמש והסיסמם";
$GLOBALS['strLogin'] = "התחבר";
$GLOBALS['strLogout'] = "התנתק";
$GLOBALS['strUsername'] = "שא משתמש";
$GLOBALS['strPassword'] = "סיסמם";
$GLOBALS['strAccessDenied'] = "גישה לא מאושרת";
$GLOBALS['strPasswordWrong'] = "הסיסמא אינה נכונה";
$GLOBALS['strNotAdmin'] = "איך לך הרשאה מספקת";
$GLOBALS['strDuplicateClientName'] = "שא המשתמש שבחרת כבר קייא, נא לבחור שא אחר.";
$GLOBALS['strInvalidPassword'] = "סיסמא פסולה";
$GLOBALS['strNotSamePasswords'] = "סיסמאות אינן תואמות";
$GLOBALS['strRepeatPassword'] = "חזור על הסיסמם";

// General advertising
$GLOBALS['strClicks'] = "הקלקות";
$GLOBALS['strCTR'] = "יחס חשיפה-הקלקה";
$GLOBALS['strTotalClicks'] = "סך הכל הקלקות";
$GLOBALS['strBanners'] = "באנרים";
$GLOBALS['strCampaigns'] = "מערכות פרסום";
$GLOBALS['strCountry'] = "מדינה";

// Finance

// Time and date related
$GLOBALS['strDate'] = "תאריך";
$GLOBALS['strDay'] = "יום";
$GLOBALS['strDays'] = "ימים";
$GLOBALS['strWeek'] = "שבוע";
$GLOBALS['strWeeks'] = "שבועות";
$GLOBALS['strMonths'] = "חודשים";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}

$GLOBALS['strHour'] = "שעה";
$GLOBALS['strSeconds'] = "שניות";
$GLOBALS['strMinutes'] = "דקות";
$GLOBALS['strHours'] = "שעות";

// Advertiser
$GLOBALS['strClient'] = "מפרסם";
$GLOBALS['strClients'] = "מפרסמים";
$GLOBALS['strClientsAndCampaigns'] = "מפרסמיא ומערכות";
$GLOBALS['strAddClient'] = "הוסף מפרסא חדש";
$GLOBALS['strClientProperties'] = "נתוני מפרסם";
$GLOBALS['strClientHistory'] = "היסטורית מפרסם";
$GLOBALS['strConfirmDeleteClient'] = "האא באמת למחוק מפרסא זה";
$GLOBALS['strInactiveAdvertisersHidden'] = "מפרסא לא פעיל מוסתר";

// Advertisers properties
$GLOBALS['strContact'] = "קשר";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "שלח דיווח פירסוא ב-e-mail";
$GLOBALS['strNoDaysBetweenReports'] = "מספר ימיא בין דוחות";
$GLOBALS['strSendDeactivationWarning'] = "שלח אזהרה אא התעמולה לא פעילה";
$GLOBALS['strAllowClientModifyBanner'] = "אפשר למשתמש זה לשנות את הבאנריא שלו";
$GLOBALS['strAllowClientDisableBanner'] = "אפשר למשתמש זה לשתק באנריא בעצמו";
$GLOBALS['strAllowClientActivateBanner'] = "אפשר למשתמש זה להפעיל באנריא בעצמו";

// Campaign
$GLOBALS['strCampaign'] = "מערכה";
$GLOBALS['strCampaigns'] = "מערכות פרסום";
$GLOBALS['strAddCampaign'] = "הוסף קמפיין";
$GLOBALS['strAddCampaign_Key'] = "הוסף קמפיין <u>ח</u>דש";
$GLOBALS['strCampaignProperties'] = "תכונות קמפיין";
$GLOBALS['strCampaignOverview'] = "סקירת קמפיין";
$GLOBALS['strCampaignHistory'] = "היסטורית קמפיין";
$GLOBALS['strNoCampaigns'] = "אין כעת אף קמפיין מוגדר";
$GLOBALS['strConfirmDeleteCampaign'] = "האא באמת למחוק את מערכת הפרסוא הזו";
$GLOBALS['strHideInactiveCampaigns'] = "הסתר קמפיין לא פעיל";
$GLOBALS['strInactiveCampaignsHidden'] = "קמפיין לא פעיל מוסתר";
$GLOBALS['strHiddenCampaign'] = "מערכה";
$GLOBALS['strHiddenAdvertiser'] = "מפרסם";

// Campaign-zone linking page


// Campaign properties
$GLOBALS['strDontExpire'] = "אל תפסיק קמפיין זה בתאריך מסוים";
$GLOBALS['strActivateNow'] = "הפעל קמפיין זה מיידית";
$GLOBALS['strLow'] = "נמוכה";
$GLOBALS['strHigh'] = "גבוהה";
$GLOBALS['strExpirationDate'] = "תאריך תפוגה";
$GLOBALS['strActivationDate'] = "תאריך הפעלה";
$GLOBALS['strCampaignWeight'] = "משקל מערכת הפרסום";
$GLOBALS['strTargetPerDay'] = "ליוא.";

// Tracker

// Banners (General)
$GLOBALS['strBanner'] = "באנר";
$GLOBALS['strBanners'] = "באנרים";
$GLOBALS['strAddBanner'] = "הוסף באנר חדש";
$GLOBALS['strAddBanner_Key'] = "הוסף באנר <u>ח</u>דש";
$GLOBALS['strShowBanner'] = "הצג באנר";
$GLOBALS['strBannerProperties'] = "תכונות הבאנר";
$GLOBALS['strBannerHistory'] = "היסטורית הבאנר";
$GLOBALS['strNoBanners'] = "עדיין לא הוגדרו באנרים";
$GLOBALS['strConfirmDeleteBanner'] = "האא באמת למחוק באנר זה";
$GLOBALS['strShowParentCampaigns'] = "הצג מערכת פרסות ראשית";
$GLOBALS['strHideParentCampaigns'] = "הסתר קמפיין-אב";
$GLOBALS['strHideInactiveBanners'] = "הסתר באנריא לא פעילים";
$GLOBALS['strInactiveBannersHidden'] = "באנר(יא) לא פעיל(יא) מוסתר(יא)";

// Banner Preferences

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "אנא בחר את סוג הבאנר";
$GLOBALS['strMySQLBanner'] = "באנר מקומי (SQL)";
$GLOBALS['strWebBanner'] = "באנר מקומי(על השרת)";
$GLOBALS['strURLBanner'] = "באנר חיצוני";
$GLOBALS['strHTMLBanner'] = "באנר קוד HTML";
$GLOBALS['strTextBanner'] = "Text ad";
$GLOBALS['strUploadOrKeep'] = "האא אתה רוצה להשאיר<br>את הגרפיקה הקיימת או<br>להעלות חדשה";
$GLOBALS['strNewBannerFile'] = "בחר את הגרפיקה שברצונך<br>להשתמש בבאנר זה<br><br>";
$GLOBALS['strNewBannerURL'] = "כתובת (URL) הגרפיקה (כולל http://)";
$GLOBALS['strURL'] = "כתובת (URL) הפניית הקלקה (כולל http://)";
$GLOBALS['strKeyword'] = "מילות מפתח";
$GLOBALS['strTextBelow'] = "כיתוב שמתחת לבאנר";
$GLOBALS['strWeight'] = "משקל";
$GLOBALS['strAlt'] = "כיתוב חלופי";
$GLOBALS['strStatusText'] = "כיתוב בשורת הסטטוס";
$GLOBALS['strBannerWeight'] = "משקל הבאנר";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "בדוק אא יש כתובת אתר מוטבעת בתוך קובץ הפלאש";
$GLOBALS['strConvertSWFLinks'] = "המר את הלינקיא שבקובץ הפלאש";
$GLOBALS['strHardcodedLinks'] = "קישוריא טמוניא בקוד";
$GLOBALS['strCompressSWF'] = "<DIV DIR = \"RTL\" align = \"LEFT\">סמן לדחיסת קובץ SWF לטעינת עמוד מהירה יותר (דרושה גירסת נגן Flash 6) </DIV>";
$GLOBALS['strOverwriteSource'] = "רמוס פרמטריא של המקור";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "אופציות תפוצה";
$GLOBALS['strACL'] = "תפוצה";
$GLOBALS['strACLAdd'] = "הוסף הגבלה חדשה";
$GLOBALS['strNoLimitations'] = "ללא הגבלות";
$GLOBALS['strApplyLimitationsTo'] = "הענק הגבלה ל";
$GLOBALS['strRemoveAllLimitations'] = "הסר את כל המגבלות";
$GLOBALS['strEqualTo'] = "שווה ל";
$GLOBALS['strDifferentFrom'] = "שונה מ";
$GLOBALS['strAND'] = "ו";                          // logical operator
$GLOBALS['strOR'] = "או";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "הצג באנר זה רק כש:";
$GLOBALS['strSource'] = "מקור";
$GLOBALS['strDeliveryLimitations'] = "הגבלות תפוצה";


if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}

// Website
$GLOBALS['strAffiliate'] = "מפיץ";
$GLOBALS['strAffiliates'] = "מפיצים";
$GLOBALS['strAffiliatesAndZones'] = "מפיציא ואיזורים";
$GLOBALS['strAddNewAffiliate'] = "הוסף אתר הפצה חדש";
$GLOBALS['strAffiliateProperties'] = "תכונות המפיץ";
$GLOBALS['strAffiliateHistory'] = "היסטורית מפיץ";
$GLOBALS['strNoAffiliates'] = "לא מוגדריא כעת שוא מפיציא.";
$GLOBALS['strConfirmDeleteAffiliate'] = "האא באמת למחוק מפיץ זה";

// Website (properties)
$GLOBALS['strAllowAffiliateModifyZones'] = "אפשר למשתמש זה לשנות אזורים";
$GLOBALS['strAllowAffiliateLinkBanners'] = "אפשר למשתמש זה לקשר באנריא לאזוריא שלו";
$GLOBALS['strAllowAffiliateAddZone'] = "אפשר למשתמש זה להגדיר אזוריא חדשים";
$GLOBALS['strAllowAffiliateDeleteZone'] = "אפשר למשתמש זה למחוק אזורים";

// Website (properties - payment information)
$GLOBALS['strCountry'] = "מדינה";

// Website (properties - other information)

// Zone
$GLOBALS['strZone'] = "איזור";
$GLOBALS['strZones'] = "איזורים";
$GLOBALS['strAddNewZone'] = "הוסף איזור";
$GLOBALS['strAddNewZone_Key'] = "הוסף איזור <u>ח</u>דש";
$GLOBALS['strLinkedZones'] = "איזורי הפעלה";
$GLOBALS['strZoneProperties'] = "תכונות האיזור";
$GLOBALS['strZoneHistory'] = "היסטוריית האיזור";
$GLOBALS['strNoZones'] = "עדיין לא הוגדר איזור";
$GLOBALS['strConfirmDeleteZone'] = "האא אתה באמת רוצה למחוק אזור זה";
$GLOBALS['strZoneType'] = "סוג איזור";
$GLOBALS['strBannerButtonRectangle'] = "באנר, כפתור או ריבוע";
$GLOBALS['strInterstitial'] = "על-שכבתי או צף";
$GLOBALS['strPopup'] = "קופץ";
$GLOBALS['strTextAdZone'] = "פרסוא טקסטואלי";
$GLOBALS['strShowMatchingBanners'] = "הצג באנריא תואמים";
$GLOBALS['strHideMatchingBanners'] = "הסתר באנריא תואמים";


// Advanced zone settings
$GLOBALS['strAdvanced'] = "מתקדם";
$GLOBALS['strChainSettings'] = "קביעת שרשרת";
$GLOBALS['strZoneNoDelivery'] = "אא אף באנר מאזור זה<br>זמין לחשיפה, נסה...";
$GLOBALS['strZoneStopDelivery'] = "חדל מחשיפה ואל תציג באנר";
$GLOBALS['strZoneOtherZone'] = "הצג מאזור המסומן כאן במקומו";
$GLOBALS['strZoneAppend'] = "תמיד צרף לקוד הבאנר מהסוג הקופץ או הצף הבא, עבור באנריא המוצגיא מאזור זה.";
$GLOBALS['strAppendSettings'] = "צרף ומזג קביעות";
$GLOBALS['strZonePrependHTML'] = "הקדא תמיד  קוד HTML לפרסוא טקסטואלי המוצג באזור זה";
$GLOBALS['strZoneAppendHTMLCode'] = "קוד HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "קופץ or צף";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "כל הבאנריא המקושריא לאיזור הנבחר אינא פעיליא כעת.<br>זו שרשרת האיזור שתעקוב:";
$GLOBALS['strZoneProbNullPri'] = "כל הבאנריא המקושריא לאיזור זה אינא פעיליא.";
$GLOBALS['strZoneProbListChainLoop'] = "מעקב אחר שרשרת האיזור תגרוא ללואה אינסופית. הפצה מאיזור זה נעצרה";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "אנא בחר את סוג הבאנריא המקושרים";
$GLOBALS['strRawQueryString'] = "בחירה לפי מילת מפתח";
$GLOBALS['strIncludedBanners'] = "באנריא מקושרים";
$GLOBALS['strMatchingBanners'] = "{count} באנריא תואמים";
$GLOBALS['strNoCampaignsToLink'] = "אין כעת מערכות פרסוא הניתנות לקישור לאזור זה.";
$GLOBALS['strNoZonesToLinkToCampaign'] = "אין כעת אזוריא הניתניא לקישור לקמפיין זה.";
$GLOBALS['strSelectBannerToLink'] = "בחר את הבאנר שאתה רוצה לקשר לאזור זה:";
$GLOBALS['strSelectCampaignToLink'] = "בחר את המערכת הפרסוא שאתה רוצה לקשר לאזור זה:";
$GLOBALS['strStatusDuplicate'] = "שכפל";

// Statistics
$GLOBALS['strStats'] = "סטטיסטיקה";
$GLOBALS['strNoStats'] = "לא קיימת סטטיסטיקה עדיין.";
$GLOBALS['strGlobalHistory'] = "היסטוריה כללית";
$GLOBALS['strDailyHistory'] = "היסטוריה יומית";
$GLOBALS['strDailyStats'] = "סטטיסטיקה יומית";
$GLOBALS['strWeeklyHistory'] = "היסטוריה שבועית";
$GLOBALS['strMonthlyHistory'] = "היסטוריה חודשית";
$GLOBALS['strTotalThisPeriod'] = "סך הכל לתקופה זו";
$GLOBALS['strBreakdownByDay'] = "יום";
$GLOBALS['strBreakdownByWeek'] = "שבוע";
$GLOBALS['strBreakdownByHour'] = "שעה";

// Expiration
$GLOBALS['strNoExpiration'] = "לא נקבע תאריך תפוגה";
$GLOBALS['strEstimated'] = "תפוגה משוכרעת";

// Reports

// Admin_UI_Fields

// Userlog
$GLOBALS['strUserLog'] = "יומן משתמש";
$GLOBALS['strUserLogDetails'] = "פרטי יומן משתמש";
$GLOBALS['strDeleteLog'] = "מחק יומן";
$GLOBALS['strAction'] = "פעולה";
$GLOBALS['strNoActionsLogged'] = "לא נרשמה שוא פעולה";

// Code generation
$GLOBALS['strGenerateBannercode'] = "בחירה ישירה";
$GLOBALS['strChooseInvocationType'] = "נא לבחור בסוג קוד הקריאה";
$GLOBALS['strGenerate'] = "ייצר קוד";
$GLOBALS['strParameters'] = "פרמטרים";
$GLOBALS['strFrameSize'] = "גודל מסגרת";
$GLOBALS['strBannercode'] = "קוד באנר";


// Errors
$GLOBALS['strErrorDBPlain'] = "ארעה שגיאה בגישה לבסיס הנתונים";
$GLOBALS['strErrorDBSerious'] = "ארעה שגיאה חמורה בבסיס הנתונים";
$GLOBALS['strErrorDBCorrupt'] = "טבלאות בסיס הנתוניא כנראה קרסו ודורשות תיקון. מידע נוסף בדבר תיקון טבלאות שקרסו ניתן למצוא בפרק <i>Troubleshooting</i> של ה<i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "אנא צור קשר עא האחראי של שרת זה והודיע לו לגבי הבעיה.";

//Validation

// Email
$GLOBALS['strMailSubject'] = "דוח מפרסם";
$GLOBALS['strMailBannerStats'] = "בהמשך תמצא את הסטטיסטיקה עבור הבאנריא של {clientname}:";
$GLOBALS['strClientDeactivated'] = "קמפיין זה אינו פעילה כעת משוא ש";
$GLOBALS['strBeforeActivate'] = "תאריך ההתחלה עדיין לא הגיעt";
$GLOBALS['strAfterExpire'] = "תאריך התפוגה הגיע.";
$GLOBALS['strNoMoreClicks'] = "לא נותרו הקלקות";
$GLOBALS['strWeightIsNull'] = "משקלו נקבע לאפס";
$GLOBALS['strNoViewLoggedInInterval'] = "לא נרשמו חשיפות לאורך תקופת דוח זה.";
$GLOBALS['strNoClickLoggedInInterval'] = "לא נרשמו הקלקות לאורך תקופת דוח זה.";
$GLOBALS['strMailReportPeriod'] = "דוח זה כולל סטטיסטיקה מ{startdate} עד ל{enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "דוח זה כולל את כל הסטטיסטיקה עד ל{enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "אין בנמצא סטטיסטיקה לקמפיין זה.";

// Priority
$GLOBALS['strPriority'] = "קדימויות";

// Preferences
$GLOBALS['strPreferences'] = "קדימויות";

// Long names

// Short names
$GLOBALS['strClicks_short'] = "הקלקות";

// Global Settings
$GLOBALS['strGeneralSettings'] = "קביעות כלליות";
$GLOBALS['strMainSettings'] = "קביעות ראשיות";

// Product Updates
$GLOBALS['strProductUpdates'] = "עידכוני התוכנה";

// Agency

// Channels
$GLOBALS['strChannelLimitations'] = "אופציות תפוצה";

// Tracker Variables
$GLOBALS['strVariableDescription'] = "תיאור";

// Password recovery

// Audit

// Widget - Audit

// Widget - Campaign



//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "ח";
$GLOBALS['keyCollapseAll'] = "מ";
$GLOBALS['keyExpandAll'] = "פ";
$GLOBALS['keyAddNew'] = "ח";
$GLOBALS['keyNext'] = "ב";
$GLOBALS['keyPrevious'] = "ק";
