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

// Installer translation strings
$GLOBALS['strInstall'] = "התקן";
$GLOBALS['strDatabaseSettings'] = "קביעות בסיס נתוני�?";
$GLOBALS['strAdminSettings'] = "קביעות מנהל";
$GLOBALS['strAdvancedSettings'] = "קביעות מתקדמות";
$GLOBALS['strWarning'] = "�?זהרה";
$GLOBALS['strTablesType'] = "סוגי הטבל�?ות";



$GLOBALS['strInstallSuccess'] = "<b>ההתקנה של {$PRODUCT_NAME} הסתיימה ברגע זה.</b><br><br>כדי ש- {$PRODUCT_NAME} תתפקד נכון עליך ג�? לווד�? שקובץ התחזוקה ירוץ כל שעה. מידע נוסף �?ודות נוש�? זה ניתן למצו�? בתיעוד המצורף. <br><br>לחץ <b>המשך</b> כדי להגיע לעמוד העיצוב/קינפוג, היכן שתוכל לקבוע נתוני�? נוספי�?. �?נ�? �?ל תשכח לנעול �?ת הקובץ <B> config.inc.php</B> ברגע שסיימת, כדי למנוע פגיעות והטרדות בשרת.";
$GLOBALS['strInstallNotSuccessful'] = "<b>ההתקנה של {$PRODUCT_NAME}ל�? הצליחה</b><br><br>חלקי�? מסוימי�? מתהליך ההתקנה ל�? הושלמו. �?פשר שבעיות �?לו הן זמניות בלבד, במקרה זה פשוט לחץ <b>המשך</b> ותחזור לשלב הר�?שון של תהליך ההתקנה. �?�? �?תה רוצה לדעת יותר מה �?ומרות הודעות השגי�?ה מטה, וכיתד לפתור �?ותן, �?נ�? היוועץ בתיעוד המצורף.";
$GLOBALS['strErrorOccured'] = "השגי�?ה הב�?ה קרתה:";
$GLOBALS['strErrorInstallDatabase'] = "מבנה בסיס הנתוני�? ל�? יכל להיווצר.";
$GLOBALS['strErrorInstallDbConnect'] = "ל�? ניתן היה להתחבר לבסיס הנתוני�?.";




$GLOBALS['strInvalidUserPwd'] = "ש�? משתמש �?ו סיסמ�? פסולי�?";

$GLOBALS['strUpgrade'] = "עדכון";
$GLOBALS['strSystemUpToDate'] = "המערכת שלך מוכנה ומעודנת, ל�? נדרש עדכון ברגע זה. <br>לחץ על <b>המשך</b> כדי להגיע לעמוד הבית.";
$GLOBALS['strSystemNeedsUpgrade'] = "מבנה בסיס הנתוני�? וקובץ הקונפיגורציה זקוקי�? לעדכון כדי שהמערכת תתפקד נכונה.<br>�?נ�? הת�?זר בסבלנות כיוון שתהליך העדכון יכול לקחת כמה דקות.";
$GLOBALS['strSystemUpgradeBusy'] = "תהליך עדכון המערכת בעיצומו, �?נ�? המתן...";
$GLOBALS['strSystemRebuildingCache'] = "בונה �?ת זכרון המטמון מחדש, �?נ�? המתן...";
$GLOBALS['strServiceUnavalable'] = "השירות �?ינו �?פשרי זמנית. תהליך עדכון המערכת בעיצומו";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "בחר מחלקה";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "קביעות מינהלה";
$GLOBALS['strLoginCredentials'] = "הרש�?ות התחברות";
$GLOBALS['strAdminUsername'] = "ש�? המשתמש - מנהל";
$GLOBALS['strInvalidUsername'] = "ש�? משתמש פסול";
$GLOBALS['strBasicInformation'] = "מידע בסיסי";
$GLOBALS['strAdminFullName'] = "הש�? המל�? של המנהל";
$GLOBALS['strAdminEmail'] = "כתובת ה�?ימייל של המנהל";
$GLOBALS['strCompanyName'] = "ש�? החברה/�?יגוד";
$GLOBALS['strAdminCheckUpdates'] = "בדוק עדכוני�?";
$GLOBALS['strAdminCheckEveryLogin'] = "בכל התחברות";
$GLOBALS['strAdminCheckDaily'] = "יומית";
$GLOBALS['strAdminCheckWeekly'] = "שבועית";
$GLOBALS['strAdminCheckMonthly'] = "חודשית";
$GLOBALS['strAdminCheckNever'] = "�?ף פע�?";
$GLOBALS['strUserlogEmail'] = " תעד �?ת כל ה�?ימייל היוצ�?";


// Database Settings
$GLOBALS['strDatabaseSettings'] = "קביעות בסיס נתוני�?";
$GLOBALS['strDatabaseServer'] = "שרת בסיס הנתוני�?";
$GLOBALS['strDbLocal'] = "התחבר לשרת המקומי ב�?מצעות מעברי�? (sockets)";
$GLOBALS['strDbHost'] = "השרת המ�?רח";
$GLOBALS['strDbPort'] = "מספר המבו�? של בסיס הנתוני�? (port)";
$GLOBALS['strDbUser'] = "ש�? המשתמש בבסיס הנתוני�?";
$GLOBALS['strDbPassword'] = "הסיסמ�? של בסיס הנתוני�?";
$GLOBALS['strDbName'] = "הש�? של בסיס הנתוני�?";
$GLOBALS['strDatabaseOptimalisations'] = "ייטוב בסיס הנתוני�?";
$GLOBALS['strPersistentConnections'] = " השתמש בחיבור רציף (בסיס הנתוני�? תפוס יותר)";
$GLOBALS['strCantConnectToDb'] = " ל�? מסוגל להתחבר לבסיס הנתוני�?";



// Email Settings
$GLOBALS['strQmailPatch'] = " �?פשר טל�?י qmail ";

// Audit Trail Settings

// Debug Logging Settings

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "קביעות תפוצה";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strTypeWebSettings'] = "קונפיגורציית ב�?נר מקומי (השרת)";
$GLOBALS['strTypeWebMode'] = "שיטת �?יחסון";
$GLOBALS['strTypeWebModeLocal'] = "תיקייה מקומית";
$GLOBALS['strTypeDirError'] = "התיקייה המקומית �?ינה קיימת";
$GLOBALS['strTypeWebModeFtp'] = "שרת FTP חיצוני";
$GLOBALS['strTypeWebDir'] = "תיקייה מקומית";
$GLOBALS['strTypeFTPHost'] = "מ�?רח FTP";
$GLOBALS['strTypeFTPDirectory'] = "תיקיית FTP";
$GLOBALS['strTypeFTPUsername'] = "ש�? משתמש";
$GLOBALS['strTypeFTPPassword'] = "סיסמ�?";
$GLOBALS['strTypeFTPErrorDir'] = "תקיית המ�?רח �?ינה קיימת";
$GLOBALS['strTypeFTPErrorConnect'] = "ל�? ניתן להתחבר לשרת ה-FTP, ש�? המשתמש �?ו הסיסמ�? שגויי�?";
$GLOBALS['strTypeFTPErrorHost'] = "ש�? השרת המ�?רח �?ת ה-FTP שגוי";



$GLOBALS['strP3PSettings'] = "פוליסות פרטיות מסוג P3P";
$GLOBALS['strUseP3P'] = " השתמש בפוליסות P3P";
$GLOBALS['strP3PCompactPolicy'] = "פוליסת P3P קומפקטית";
$GLOBALS['strP3PPolicyLocation'] = "מיקו�? פוליסת ה-P3P";

// General Settings

// Geotargeting Settings
$GLOBALS['strGeotargeting'] = "Geotargeting - מיקוד גי�?וגרפי";

// Interface Settings
$GLOBALS['strInventory'] = "מצ�?י";
$GLOBALS['strShowCampaignInfo'] = " הצג מידע נוסף עבור קמפיין בעמוד <i>סקירת קמפיין</i>";
$GLOBALS['strShowBannerInfo'] = " הצג מידע נוסף עבור ב�?נר בעמוד <i>סקירת ב�?נרי�?</i>";
$GLOBALS['strShowCampaignPreview'] = " תצוגה מקדמת של כל הב�?נרי�? בעמוד <i>סקירת ב�?נרי�?</i>";
$GLOBALS['strShowBannerHTML'] = " הצג ב�?נר ממשי במקו�? קוד רגיל של  HTML, במצב תצוגת ב�?נרי�? מסוג HTML";
$GLOBALS['strShowBannerPreview'] = " תצוגה מקדימה של ב�?נרי�? בכותרת העמוד העוסק בב�?נרי�?";
$GLOBALS['strHideInactive'] = " הסתר פרטי�? ל�? פעילי�? בכל עמודי תצוגה מקדימה";
$GLOBALS['strGUIShowMatchingBanners'] = " הצג ב�?נרי�? תו�?מי�? בעמודי <i>ב�?נרי�? מקושרי�?</i>";
$GLOBALS['strGUIShowParentCampaigns'] = " הר�?ה קמפיין-�?ב בעמודי <i>ב�?נרי�? מקושרי�?</i>";
$GLOBALS['strStatisticsDefaults'] = "סטטיסטיקה";
$GLOBALS['strBeginOfWeek'] = "השבוע מתחיל ביו�?";
$GLOBALS['strPercentageDecimals'] = "נקודה עשרונית";
$GLOBALS['strWeightDefaults'] = "משקל התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultBannerWeight'] = "משקל ב�?נר התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultCampaignWeight'] = "משקל קמפיין התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultBannerWErr'] = "משקל התחלתי של ב�?נר צריך להיות מספר חיובי";
$GLOBALS['strDefaultCampaignWErr'] = "משקל קמפיין התחלתי חייב להיות מספר חיובי";


// CSV Import Settings

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "סוגי קרי�?ה מותרי�?";

// Banner Delivery Settings

// Banner Logging Settings
$GLOBALS['strReverseLookup'] = "נסה לקבוע �?ת ספקית השירות של המבקר �?�? הנתון ל�? מגיע מהשרת";
$GLOBALS['strProxyLookup'] = "נסה לקבוע �?ת כתובת ה-IP ה�?מיתית של המבקר �?�? הו�? משתמש במ�?גר ביניי�? (proxy).";
$GLOBALS['strPreventLogging'] = "מנע התחברות";
$GLOBALS['strIgnoreHosts'] = "�?ל תתעד סטטיסטיקה ממבקרי�? המשתמשי�? ב�?חד ממספרי ה-IP �?ו שמות המ�?רחי�? הב�?י�?";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strAdminEmailHeaders'] = "הוסף �?ת הכותרת הב�?ה לכל �?ימייל שישלח על ידי {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "שלח �?תר�?ה כ�?שר מספר החשיפות הנותר הינו פחות מהנקוב כ�?ן";
$GLOBALS['strWarnAdmin'] = " שלח התר�?ת מנהל בכל פע�? שקמפין מסויי�? לפני סיומו";
$GLOBALS['strWarnClient'] = " שלח התר�?ת מפרס�? בכל פע�? שהקמפין שלו לפני סיו�?";

// UI Settings
$GLOBALS['strGuiSettings'] = "קביעות ממשק משתמש";
$GLOBALS['strGeneralSettings'] = "קביעות כלליות";
$GLOBALS['strAppName'] = "ש�? היישו�? שיוצג";
$GLOBALS['strMyHeader'] = "כותרת העמוד שלי נמצ�?ת בכתובת:";
$GLOBALS['strMyHeaderError'] = "כותרת העמוד ל�? נמצ�?ה במיקו�? שנרש�?";
$GLOBALS['strMyFooter'] = "תחתית העמוד שלי נמצ�?ת בכתובת:";
$GLOBALS['strMyFooterError'] = "תחתית העמוד ל�? נמצ�?ה במיקו�? שנרש�?";


$GLOBALS['strGzipContentCompression'] = "השתמש בדחיסת-תכולה GZIP";
$GLOBALS['strClientInterface'] = "ממשק מפרס�?";
$GLOBALS['strClientWelcomeEnabled'] = "�?פשר הודעת מילות הקדמה בהתחברות המפרס�?";
$GLOBALS['strClientWelcomeText'] = "הודעת הקדמה/ברכת ברוכי�? הב�?י�?...<br>(�?פשרי שימוש בתגי HTML)";


// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strExperimental'] = "נסיוני";
$GLOBALS['strKeywordRetrieval'] = "שליפה לפי מילות מפתח";
$GLOBALS['strBannerRetrieval'] = " שיטת שליפת הב�?נרי�?";
$GLOBALS['strRetrieveRandom'] = " שליפה �?קר�?ית (ברירת מחדל)";
$GLOBALS['strRetrieveNormalSeq'] = " שליפה סדרתית רגילה";
$GLOBALS['strWeightSeq'] = " שליפה סדרתית מבוסס משקל";
$GLOBALS['strFullSeq'] = " שליפה סדרתית מל�?ה";
$GLOBALS['strUseConditionalKeys'] = " השתמש במילות תנ�?י";
$GLOBALS['strUseMultipleKeys'] = " השתמש בריבוי מילות מפתח";

$GLOBALS['strTableBorderColor'] = "צבע המסגרת של הטבלה";
$GLOBALS['strTableBackColor'] = "צבע הרקע של הטבלה";
$GLOBALS['strTableBackColorAlt'] = "צבע הרקע  של הטבלה(חלופי)";
$GLOBALS['strMainBackColor'] = "צבע רקע ר�?שי";
$GLOBALS['strOverrideGD'] = "�?כוף תמונה בתצורת GD";
$GLOBALS['strTimeZone'] = "�?יזור זמן";
