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

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

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
$GLOBALS['strStartOver'] = "התחל מחדש";
$GLOBALS['strShortcuts'] = "קיצורים";
$GLOBALS['strActions'] = "פעולות";
$GLOBALS['strAndXMore'] = "ועוד %s";
$GLOBALS['strAdminstration'] = "מלאי";
$GLOBALS['strMaintenance'] = "תחזוקה";
$GLOBALS['strProbability'] = "סיכויים";
$GLOBALS['strInvocationcode'] = "קוד תצוגה";
$GLOBALS['strBasicInformation'] = "מידע בסיסי";
$GLOBALS['strAppendTrackerCode'] = "הוסף קוד מעקב";
$GLOBALS['strOverview'] = "סקירה כללית";
$GLOBALS['strSearch'] = "חפ<u>ש</u>";
$GLOBALS['strDetails'] = "פרטים";
$GLOBALS['strUpdateSettings'] = "עדכן אפשרויות";
$GLOBALS['strCheckForUpdates'] = "בדוק עדכונים";
$GLOBALS['strWhenCheckingForUpdates'] = "כשבודקים לעדכונים";
$GLOBALS['strCompact'] = "קומפקטי";
$GLOBALS['strUser'] = "משתמש";
$GLOBALS['strDuplicate'] = "שכפל";
$GLOBALS['strCopyOf'] = "העתק ל";
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
$GLOBALS['strBack'] = "אחורה";
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
$GLOBALS['strAll'] = "הכל";
$GLOBALS['strAverage'] = "ממוצע";
$GLOBALS['strOverall'] = "כללי";
$GLOBALS['strTotal'] = "סך הכל";
$GLOBALS['strFrom'] = "מ";
$GLOBALS['strTo'] = "ל";
$GLOBALS['strAdd'] = "הוסף";
$GLOBALS['strLinkedTo'] = "מקושר ל";
$GLOBALS['strDaysLeft'] = "ימים נותרו";
$GLOBALS['strCheckAllNone'] = "בחר הכל";
$GLOBALS['strKiloByte'] = "ק\"ב";
$GLOBALS['strExpandAll'] = "פתח הכל";
$GLOBALS['strCollapseAll'] = "סגור הכל";
$GLOBALS['strShowAll'] = "הצג הכל";
$GLOBALS['strNoAdminInterface'] = "המסך  הניהול כובה לצורכי תחזוקה.  הגדרה זו אינה משפיעה על המשלוח של הקמפיינים שלך.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'מ' צריך להיות לפני 'עד'.";
$GLOBALS['strFieldContainsErrors'] = "הקבצים הבאים מכילים שגיאות:";
$GLOBALS['strFieldFixBeforeContinue1'] = "לפני שאתה ממשיך אתה צריך ";
$GLOBALS['strFieldFixBeforeContinue2'] = "לתקן שגיאות אילו.";
$GLOBALS['strMiscellaneous'] = "שונות";
$GLOBALS['strCollectedAllStats'] = "כל הסטטיסטיקה";
$GLOBALS['strCollectedToday'] = "היום";
$GLOBALS['strCollectedYesterday'] = "אתמול";
$GLOBALS['strCollectedThisWeek'] = "השבוע";
$GLOBALS['strCollectedLastWeek'] = "שבוע שעבר";
$GLOBALS['strCollectedThisMonth'] = "החודש";
$GLOBALS['strCollectedLastMonth'] = "חודש שעבר";
$GLOBALS['strCollectedLast7Days'] = "7 ימים אחרונים";
$GLOBALS['strCollectedSpecificDates'] = "תאריכים מסויימים";
$GLOBALS['strValue'] = "ערך";
$GLOBALS['strWarning'] = "אזהרה";
$GLOBALS['strNotice'] = "הערה";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "לא ניתן להציג את לוח המחוונים";
$GLOBALS['strNoCheckForUpdates'] = "אין אפשרות להציג את לוח המחוונים על מנת לאפשר אופרות זו <br /> יש לסמן עדכונים בהגדרות.";
$GLOBALS['strEnableCheckForUpdates'] = "אנא הפעל את ההגדרה <a href='account-settings-update.php' target='_top'> לסמן בדוק אם קיימים עדכונים</a> על <br/> <a href='account-settings-update.php' target='_top'> לעדכן את הגדרות</a> בדף.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "קוד";
$GLOBALS['strDashboardSystemMessage'] = "הודעת מערכת";
$GLOBALS['strDashboardErrorHelp'] = "אם שגיאה זו חוזררת אנא תאר את הבעיה שלך בפירוט, ניתן לדווח את זה בכתובת <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "קדימויות";
$GLOBALS['strPriorityLevel'] = "רמת קידמות";
$GLOBALS['strOverrideAds'] = "לעקוף את קמפיין פרסומי";
$GLOBALS['strHighAds'] = "חוזה לקמפיין פרסומי";
$GLOBALS['strECPMAds'] = "eCPM קמפיין פרסומי";
$GLOBALS['strLowAds'] = "שריד קמפיין פרסומי";
$GLOBALS['strLimitations'] = "כללי משלוח";
$GLOBALS['strNoLimitations'] = "אין חוקים למשלוח";
$GLOBALS['strCapping'] = "מיצוי";

// Properties
$GLOBALS['strName'] = "שם";
$GLOBALS['strSize'] = "גודל";
$GLOBALS['strWidth'] = "רוחב";
$GLOBALS['strHeight'] = "גובה";
$GLOBALS['strTarget'] = "חלון מטרה";
$GLOBALS['strLanguage'] = "שפה";
$GLOBALS['strDescription'] = "תיאור";
$GLOBALS['strVariables'] = "משתנים";
$GLOBALS['strID'] = "מזהה";
$GLOBALS['strComments'] = "הערות";

// User access
$GLOBALS['strWorkingAs'] = "עובד כ";
$GLOBALS['strWorkingAs_Key'] = "<u>ע</u>ובד כ";
$GLOBALS['strWorkingAs'] = "עובד כ";
$GLOBALS['strSwitchTo'] = "עבור ל";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "השתמש בתיבת החיפוש כדי לחפש חשבונות";
$GLOBALS['strWorkingFor'] = "%s עבור...";
$GLOBALS['strNoAccountWithXInNameFound'] = "לא נמצאו חשבונות בשם \"%s\".";
$GLOBALS['strRecentlyUsed'] = "בשימוש לאחרונה";
$GLOBALS['strLinkUser'] = "הוסף משתמש";
$GLOBALS['strLinkUser_Key'] = "הוסף <u>מ</u>שתמש";
$GLOBALS['strUsernameToLink'] = "שם משתמש למשתמש החדש";
$GLOBALS['strNewUserWillBeCreated'] = "משתמש חדש יווצר";
$GLOBALS['strToLinkProvideEmail'] = "כדי להוסיף משתמש, הקש כתובת דוא''ל";
$GLOBALS['strToLinkProvideUsername'] = "כדי להוסיף משתמש, אנא הקש שם משתמש";
$GLOBALS['strUserAccountUpdated'] = "חשבון משתמש עודכן.";
$GLOBALS['strUserWasDeleted'] = "המשתמש נמחק.";
$GLOBALS['strUserNotLinkedWithAccount'] = "משתמש זה לא מקושר לחשבון בזה.";
$GLOBALS['strLinkUserHelp'] = "בכדי להוסיף <b>משתמש קיים</b>, הקלד את %1\$s ולחץ על %2\$s <br /> כדי להוסיף <b>משתמש חדש</b>, הקלד את %1\$s הרצוי ולחץ על %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "שם משתמש";
$GLOBALS['strLinkUserHelpEmail'] = "דוא''ל";
$GLOBALS['strLastLoggedIn'] = "התחברות אחרונה:";
$GLOBALS['strDateLinked'] = "תאריך מקושר:";

// Login & Permissions
$GLOBALS['strUserAccess'] = "גישת משתמש";
$GLOBALS['strAdminAccess'] = "גישת מנהל";
$GLOBALS['strUserProperties'] = "מאפייני משתמש";
$GLOBALS['strPermissions'] = "הרשאות";
$GLOBALS['strAuthentification'] = "אימות";
$GLOBALS['strWelcomeTo'] = "ברוכים הבאים ל";
$GLOBALS['strEnterUsername'] = "נא להכניס שם וסיסמא כדי להיכנס";
$GLOBALS['strEnterBoth'] = "אנא הזן את שם המשתמש והסיסמא";
$GLOBALS['strEnableCookies'] = "עליך לאפשר קוקיס (cookies) לפני השימוש ב-{$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "אירעה שגיאת עוגיה. עליך להתחבר מחדש.";
$GLOBALS['strLogin'] = "התחבר";
$GLOBALS['strLogout'] = "התנתק";
$GLOBALS['strUsername'] = "שם משתמש";
$GLOBALS['strPassword'] = "סיסמא";
$GLOBALS['strPasswordRepeat'] = "סיסמא שוב";
$GLOBALS['strAccessDenied'] = "גישה לא מאושרת";
$GLOBALS['strUsernameOrPasswordWrong'] = "שם משתמש או סיסמא שגויים.";
$GLOBALS['strPasswordWrong'] = "הסיסמא לא נכונה.";
$GLOBALS['strNotAdmin'] = "איך לך הרשאה מספקת";
$GLOBALS['strDuplicateClientName'] = "שם המשתמש שבחרת כבר קיים, נא לבחור שם אחר.";
$GLOBALS['strInvalidPassword'] = "סיסמא פסולה";
$GLOBALS['strInvalidEmail'] = "כתובת דוא''ל לא חוקית.";
$GLOBALS['strNotSamePasswords'] = "סיסמאות אינן תואמות";
$GLOBALS['strRepeatPassword'] = "חזור על הסיסמא";
$GLOBALS['strDeadLink'] = "הקישור שלך אינו חוקי.";
$GLOBALS['strNoPlacement'] = "הקמפיין שנבחר אינו קיים. נסה את <a href='{link}'> הקישור</a> במקומו";
$GLOBALS['strNoAdvertiser'] = "המפרסם שנבחר אינו קיים. נסה את <a href='{link}'> הקישור</a> במקומו";

// General advertising
$GLOBALS['strRequests'] = "בקשות";
$GLOBALS['strImpressions'] = "חשיפות";
$GLOBALS['strClicks'] = "הקלקות";
$GLOBALS['strConversions'] = "המרות";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "יחס חשיפה-הקלקה";
$GLOBALS['strTotalClicks'] = "סך הכל הקלקות";
$GLOBALS['strTotalConversions'] = "סך הכל המרות";
$GLOBALS['strDateTime'] = "תאריך ושעה";
$GLOBALS['strTrackerID'] = "מזהה רכיב המעקב";
$GLOBALS['strTrackerName'] = "שם רכיב המעקב";
$GLOBALS['strTrackerImageTag'] = "תג התמונה";
$GLOBALS['strTrackerJsTag'] = "תג Javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "תמיד להציג קוד המצורפות, גם אם ללא המרה נרשם על-ידי המעקב?";
$GLOBALS['strBanners'] = "באנרים";
$GLOBALS['strCampaigns'] = "קמפיינים";
$GLOBALS['strCampaignID'] = "מס' קמפיין";
$GLOBALS['strCampaignName'] = "שם קמפיין";
$GLOBALS['strCountry'] = "מדינה";
$GLOBALS['strStatsAction'] = "פעולה";
$GLOBALS['strWindowDelay'] = "תצוגת חלון";
$GLOBALS['strStatsVariables'] = "משתנים";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "עלות לקליק(CPC)";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "שכירות";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "תאריך";
$GLOBALS['strDay'] = "יום";
$GLOBALS['strDays'] = "ימים";
$GLOBALS['strWeek'] = "שבוע";
$GLOBALS['strWeeks'] = "שבועות";
$GLOBALS['strSingleMonth'] = "חודש";
$GLOBALS['strMonths'] = "חודשים";
$GLOBALS['strDayOfWeek'] = "יו םבשבוע";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'ראשון';
$GLOBALS['strDayFullNames'][1] = 'שני';
$GLOBALS['strDayFullNames'][2] = 'שלישי';
$GLOBALS['strDayFullNames'][3] = 'רביעי';
$GLOBALS['strDayFullNames'][4] = 'חמישי';
$GLOBALS['strDayFullNames'][5] = 'שישי';
$GLOBALS['strDayFullNames'][6] = 'שבת';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'א';
$GLOBALS['strDayShortCuts'][1] = 'ב';
$GLOBALS['strDayShortCuts'][2] = 'ג';
$GLOBALS['strDayShortCuts'][3] = 'ד';
$GLOBALS['strDayShortCuts'][4] = 'ה';
$GLOBALS['strDayShortCuts'][5] = 'ו';
$GLOBALS['strDayShortCuts'][6] = 'ש';

$GLOBALS['strHour'] = "שעה";
$GLOBALS['strSeconds'] = "שניות";
$GLOBALS['strMinutes'] = "דקות";
$GLOBALS['strHours'] = "שעות";

// Advertiser
$GLOBALS['strClient'] = "מפרסם";
$GLOBALS['strClients'] = "מפרסמים";
$GLOBALS['strClientsAndCampaigns'] = "מפרסמים ומערכות";
$GLOBALS['strAddClient'] = "הוסף מפרסם חדש";
$GLOBALS['strClientProperties'] = "נתוני מפרסם";
$GLOBALS['strClientHistory'] = "נתונים סטטיסטיים של המפרסם";
$GLOBALS['strNoClients'] = "כיום יש אין המפרסמים מוגדרים. כדי ליצור קמפיין, קודם יש <a href='advertiser-edit.php'> להוסיף מפרסם חדש</a>.";
$GLOBALS['strConfirmDeleteClient'] = "האם באמת למחוק מפרסם זה";
$GLOBALS['strConfirmDeleteClients'] = "האם אתה באמת רוצה למחוק את המפרסמים הנבחרים?";
$GLOBALS['strHideInactive'] = "הסתר לא פעיל";
$GLOBALS['strInactiveAdvertisersHidden'] = "מפרסם לא פעיל מוסתר";
$GLOBALS['strAdvertiserSignup'] = "הרשמת מפרסם";
$GLOBALS['strAdvertiserCampaigns'] = "קמפיינים של מפרסם";

// Advertisers properties
$GLOBALS['strContact'] = "קשר";
$GLOBALS['strContactName'] = "שם";
$GLOBALS['strEMail'] = "דוא''ל";
$GLOBALS['strSendAdvertisingReport'] = "שלח דיווח פרסום ב-e-mail";
$GLOBALS['strNoDaysBetweenReports'] = "מספר ימים בין דוחות";
$GLOBALS['strSendDeactivationWarning'] = "שלח אזהרה אם התעמולה לא פעילה";
$GLOBALS['strAllowClientModifyBanner'] = "אפשר למשתמש זה לשנות את הבאנרים שלו";
$GLOBALS['strAllowClientDisableBanner'] = "אפשר למשתמש זה לשתק באנרים בעצמו";
$GLOBALS['strAllowClientActivateBanner'] = "אפשר למשתמש זה להפעיל באנרים בעצמו";
$GLOBALS['strAdvertiserLimitation'] = "הצג רק באנר אחד ממפרסם זה בדף אינטרנט";
$GLOBALS['strAllowAuditTrailAccess'] = "אפשר למשתמש זה לגשת לדוח ביקורת";

// Campaign
$GLOBALS['strCampaign'] = "קמפיין";
$GLOBALS['strCampaigns'] = "קמפיינים";
$GLOBALS['strAddCampaign'] = "הוסף קמפיין";
$GLOBALS['strAddCampaign_Key'] = "הוסף קמפיין <u>ח</u>דש";
$GLOBALS['strCampaignForAdvertiser'] = "עבור המפרסם";
$GLOBALS['strLinkedCampaigns'] = "קמפיינים מקושרים";
$GLOBALS['strCampaignProperties'] = "מאפייני קמפיין";
$GLOBALS['strCampaignOverview'] = "קמפיין מבט כולל";
$GLOBALS['strCampaignHistory'] = "סטטיסטיקת קמפיין";
$GLOBALS['strNoCampaigns'] = "אין כעת אף קמפיין מוגדר";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "יש כרגע אין קמפיינים מוגדרים, כי אין מפרסמים. כדי ליצור קמפיין, יש <a href='advertiser-edit.php'> להוסיף מפרסם חדש </a> קודם.";
$GLOBALS['strConfirmDeleteCampaign'] = "האם אתה באמת רוצה למחוק קמפיין זה?";
$GLOBALS['strConfirmDeleteCampaigns'] = "האם אתה באמת מעוניין למחוק את הקמפיינים שנבחרו?";
$GLOBALS['strShowParentAdvertisers'] = "הצג את הורי המפרסמים";
$GLOBALS['strHideParentAdvertisers'] = "להסתיר את הורי המפרסמים";
$GLOBALS['strHideInactiveCampaigns'] = "הסתר קמפיינים לא פעילים";
$GLOBALS['strInactiveCampaignsHidden'] = "קמפיין לא פעיל מוסתר";
$GLOBALS['strPriorityInformation'] = "עדיפות ביחס לקמפיינים אחרים";
$GLOBALS['strECPMInformation'] = "עדיפויות eCPM";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM מחושב באופן אוטומטי בהתבסס על ביצועים של הקמפיין הזה. <br /> זה ישמש לקבוע סדרי עדיפויות לשרידי קמפיינים אחד לשני.";
$GLOBALS['strEcpmMinImpsDescription'] = "הגדר את המיניום הרצוי לבסיס חישוב eCPM של הקמפיין הזה.";
$GLOBALS['strHiddenCampaign'] = "קמפיין";
$GLOBALS['strHiddenAd'] = "פירסומת";
$GLOBALS['strHiddenAdvertiser'] = "מפרסם";
$GLOBALS['strHiddenTracker'] = "עוקב";
$GLOBALS['strHiddenWebsite'] = "אתר אינטרנט";
$GLOBALS['strHiddenZone'] = "איזור";
$GLOBALS['strCampaignDelivery'] = "משלוח קמפיין";
$GLOBALS['strCompanionPositioning'] = "מיקום מלווה";
$GLOBALS['strSelectUnselectAll'] = "בחר / בטל בחירה של הכל";
$GLOBALS['strCampaignsOfAdvertiser'] = "of"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "מחושב עבור כל הקמפיינים";
$GLOBALS['strCalculatedForThisCampaign'] = "מחושב עבור קמפיין זה ";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "האזור(ים) קושרו";
$GLOBALS['strZonesUnlinked'] = "האזור(ים) נותקו";
$GLOBALS['strZonesSearch'] = "חיפוש";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "No websites and zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "לקשר";
$GLOBALS['strToUnlink'] = "לנתק קישור";
$GLOBALS['strLinked'] = "מקושר";
$GLOBALS['strAvailable'] = "פעיל";
$GLOBALS['strShowing'] = "מציג";
$GLOBALS['strEditZone'] = "ערוך איזור";
$GLOBALS['strEditWebsite'] = "ערוך אתר";


// Campaign properties
$GLOBALS['strDontExpire'] = "אל תפסיק קמפיין זה בתאריך מסוים";
$GLOBALS['strActivateNow'] = "הפעל קמפיין זה מיידית";
$GLOBALS['strSetSpecificDate'] = "קבע תאריך מסויים";
$GLOBALS['strLow'] = "נמוכה";
$GLOBALS['strHigh'] = "גבוהה";
$GLOBALS['strExpirationDate'] = "תאריך תפוגה";
$GLOBALS['strExpirationDateComment'] = "הקמפיין יסתיים בסוף יום זה";
$GLOBALS['strActivationDate'] = "תאריך הפעלה";
$GLOBALS['strActivationDateComment'] = "הקמפיין יתחיל בתחילתו של יום זה ";
$GLOBALS['strImpressionsRemaining'] = "חשיפות נותרו";
$GLOBALS['strClicksRemaining'] = "קליקים שנותרו";
$GLOBALS['strConversionsRemaining'] = "המרות שנותרו";
$GLOBALS['strImpressionsBooked'] = "חשיפות שהוזמנו";
$GLOBALS['strClicksBooked'] = "קליקים שהוזמנו";
$GLOBALS['strConversionsBooked'] = "המרות שהוזמנו";
$GLOBALS['strCampaignWeight'] = "משקל מערכת הפרסום";
$GLOBALS['strAnonymous'] = "הסתר מפרסמים ואתרים של קמפיין זה .";
$GLOBALS['strTargetPerDay'] = "ליום.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "The type of this campaign has been set to Remnant,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "This campaign uses eCPM optimisation
but the 'revenue' is set to zero or it has not been specified.
This will cause the campaign to be deactivated
and its banners won't be delivered until the
revenue has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "The type of this campaign has been set to Override,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget'] = "The type of this campaign has been set to Contract,
but Limit per day is not specified.
This will cause the campaign to be deactivated and
its banners won't be delivered until a valid Limit per day has been set.

Are you sure you want to continue?";
$GLOBALS['strCampaignStatusPending'] = "ממתינים";
$GLOBALS['strCampaignStatusInactive'] = "לא פעיל ";
$GLOBALS['strCampaignStatusRunning'] = "פעיל";
$GLOBALS['strCampaignStatusPaused'] = "מושהה";
$GLOBALS['strCampaignStatusAwaiting'] = "מחכה";
$GLOBALS['strCampaignStatusExpired'] = "הושלם";
$GLOBALS['strCampaignStatusApproval'] = "מחכה לאישור ֲ»";
$GLOBALS['strCampaignStatusRejected'] = "נידחה";
$GLOBALS['strCampaignStatusAdded'] = "נוסף";
$GLOBALS['strCampaignStatusStarted'] = "הותחל";
$GLOBALS['strCampaignStatusRestarted'] = "הותחל מחדש";
$GLOBALS['strCampaignStatusDeleted'] = "נמחק";
$GLOBALS['strCampaignType'] = "סוג קמפיין";
$GLOBALS['strType'] = "סוג";
$GLOBALS['strContract'] = "Contract";
$GLOBALS['strOverride'] = "לדרוס";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Contract";
$GLOBALS['strStandardContractInfo'] = "Contract campaigns are for smoothly delivering the impressions
    required to achieve a specified time-critical performance requirement. That is, Contract campaigns are for when
    an advertiser has paid specifically to have a given number of impressions, clicks and/or conversions to be
    achieved either between two dates, or per day.";
$GLOBALS['strRemnant'] = "Remnant";
$GLOBALS['strRemnantInfo'] = "The default campaign type. Remnant campaigns have lots of different
    delivery options, and you should ideally always have at least one Remnant campaign linked to every zone, to ensure
    that there is always something to show. Use Remnant campaigns to display house banners, ad-network banners, or even
    direct advertising that has been sold, but where there is not a time-critical performance requirement for the
    campaign to adhere to.";
$GLOBALS['strECPMInfo'] = "This is a standard campaign which can be constrained with either an end date or a specific limit. Based on current settings it will be prioritised using eCPM.";
$GLOBALS['strPricing'] = "תימחור";
$GLOBALS['strPricingModel'] = "מודל תימחור";
$GLOBALS['strSelectPricingModel'] = "-- select model --";
$GLOBALS['strRatePrice'] = "Rate / Price";
$GLOBALS['strMinimumImpressions'] = "מינימום חשיפות יומיות";
$GLOBALS['strLimit'] = "הגבל";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
$GLOBALS['strWhyDisabled'] = "למה זה מנוטרל?";
$GLOBALS['strBackToCampaigns'] = "חזרה לקמפיינים";
$GLOBALS['strCampaignBanners'] = "באנרים של הקמפיין";
$GLOBALS['strCookies'] = "עוגיות";

// Tracker
$GLOBALS['strTracker'] = "עוקב";
$GLOBALS['strTrackers'] = "Trackers";
$GLOBALS['strTrackerPreferences'] = "Tracker Preferences";
$GLOBALS['strAddTracker'] = "Add new tracker";
$GLOBALS['strTrackerForAdvertiser'] = "עבור המפרסם";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "Do you really want to delete all selected trackers?";
$GLOBALS['strConfirmDeleteTracker'] = "Do you really want to delete this tracker?";
$GLOBALS['strTrackerProperties'] = "Tracker Properties";
$GLOBALS['strDefaultStatus'] = "Default Status";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strLinkedTrackers'] = "Linked Trackers";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Conversion window";
$GLOBALS['strUniqueWindow'] = "Unique window";
$GLOBALS['strClick'] = "Click";
$GLOBALS['strView'] = "View";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Conversion Type";
$GLOBALS['strLinkCampaignsByDefault'] = "Link newly created campaigns by default";
$GLOBALS['strBackToTrackers'] = "Back to trackers";

// Banners (General)
$GLOBALS['strBanner'] = "באנר";
$GLOBALS['strBanners'] = "באנרים";
$GLOBALS['strAddBanner'] = "הוסף באנר חדש";
$GLOBALS['strAddBanner_Key'] = "הוסף באנר <u>ח</u>דש";
$GLOBALS['strBannerToCampaign'] = "לקמפיין";
$GLOBALS['strShowBanner'] = "הצג באנר";
$GLOBALS['strBannerProperties'] = "מאפייני באנר";
$GLOBALS['strNoBanners'] = "אין באנרים בקמפיין זה.";
$GLOBALS['strNoBannersAddCampaign'] = "כרגע אין באנרים מוגדרים, כי אין קמפיינים. כדי ליצור באנר, <a href='campaign-edit.php?clientid=%s'> להוסיף קמפיין חדש </a> תחילה.";
$GLOBALS['strNoBannersAddAdvertiser'] = "כרגע אין באנרים המוגדרים, כי אין מפרסמים. כדי ליצור באנר, <a href='advertiser-edit.php'> להוסיף מפרסם חדש </a> תחילה.";
$GLOBALS['strConfirmDeleteBanner'] = "מחיקת באנר זה גם תסיר הסטטיסטיקה שלו. \\ N האם אתה באמת רוצה למחוק את באנר הזה?";
$GLOBALS['strConfirmDeleteBanners'] = "מחיקת באנרים אלה גם תסיר הסטטיסטיקה שלהם. \\ N האם אתה באמת רוצה למחוק את הכרזות שנבחרו?";
$GLOBALS['strShowParentCampaigns'] = "הצג קמפיין אב ";
$GLOBALS['strHideParentCampaigns'] = "הסתר קמפיין אב";
$GLOBALS['strHideInactiveBanners'] = "הסתר באנרים לא פעילים";
$GLOBALS['strInactiveBannersHidden'] = "באנרים לא פעילים מוסתרים";
$GLOBALS['strWarningMissing'] = "אזהרה, אולי חסר ";
$GLOBALS['strWarningMissingClosing'] = " closing tag '>'";
$GLOBALS['strWarningMissingOpening'] = " opening tag '<'";
$GLOBALS['strSubmitAnyway'] = "שלח בכל אופן";
$GLOBALS['strBannersOfCampaign'] = "ב"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "העדפות באנרים";
$GLOBALS['strCampaignPreferences'] = "העדפות קמפיין";
$GLOBALS['strDefaultBanners'] = "באנרים ברירת מחדל";
$GLOBALS['strDefaultBannerUrl'] = "כתובת התמונה ברירת מחדל";
$GLOBALS['strDefaultBannerDestination'] = "כתובת ברירת המחדל ליעד";
$GLOBALS['strAllowedBannerTypes'] = "סוגי באנרים מותרים";
$GLOBALS['strTypeSqlAllow'] = "לאפשר באנרי SQL מקומי";
$GLOBALS['strTypeWebAllow'] = "לאפשר שרתי רשת לבאנרים מקומים";
$GLOBALS['strTypeUrlAllow'] = "לאפשר באנרים חיצונים";
$GLOBALS['strTypeHtmlAllow'] = "לאפשר באנרי HTML";
$GLOBALS['strTypeTxtAllow'] = "לאפשר מודעות טקסט";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "אנא בחר את סוג הבאנר";
$GLOBALS['strMySQLBanner'] = "באנר מקומי (SQL)";
$GLOBALS['strWebBanner'] = "באנר מקומי(על השרת)";
$GLOBALS['strURLBanner'] = "באנר חיצוני";
$GLOBALS['strHTMLBanner'] = "באנר קוד HTML";
$GLOBALS['strTextBanner'] = "Text ad";
$GLOBALS['strAlterHTML'] = "שנה את ה-HTML כדי להפעיל מעקב לחיצה עבור:";
$GLOBALS['strIframeFriendly'] = "באנר כזה יכול להיות מוצג בבטחה בתוך iframe (נ.ב. הוא לא ניתן להרחבה)";
$GLOBALS['strUploadOrKeep'] = "האם אתה רוצה להשאיר<br>את הגרפיקה הקיימת או<br>להעלות חדשה";
$GLOBALS['strNewBannerFile'] = "בחר את הגרפיקה שברצונך<br>להשתמש בבאנר זה<br><br>";
$GLOBALS['strNewBannerFileAlt'] = "בחר תמונת רקע <br /> שתרצה להציגבמידה והדפדפן <br /> לא תומך המדיה עשירה <br /><br />";
$GLOBALS['strNewBannerURL'] = "כתובת (URL) הגרפיקה (כולל http://)";
$GLOBALS['strURL'] = "כתובת (URL) הפניית הקלקה (כולל http://)";
$GLOBALS['strKeyword'] = "מילות מפתח";
$GLOBALS['strTextBelow'] = "כיתוב שמתחת לבאנר";
$GLOBALS['strWeight'] = "משקל";
$GLOBALS['strAlt'] = "כיתוב חלופי";
$GLOBALS['strStatusText'] = "כיתוב בשורת הסטטוס";
$GLOBALS['strBannerWeight'] = "משקל הבאנר";
$GLOBALS['strAdserverTypeGeneric'] = "באנר HTML כללי";
$GLOBALS['strDoNotAlterHtml'] = "אל תשנה את ה-HTML";
$GLOBALS['strGenericOutputAdServer'] = "כללי";
$GLOBALS['strBackToBanners'] = "לחזור באנרים";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "תמיד להוסיף HTML לפני הבאנר:";
$GLOBALS['strBannerAppendHTML'] = "תמיד להוסיף HTML אחרי הבאנר:";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "אופציות תפוצה";
$GLOBALS['strACL'] = "אופציות תפוצה";
$GLOBALS['strACLAdd'] = "להוסיף כלל משלוח";
$GLOBALS['strApplyLimitationsTo'] = "להחיל כללי משלוח ל";
$GLOBALS['strAllBannersInCampaign'] = "כל באנרים בקמפיין זה ";
$GLOBALS['strRemoveAllLimitations'] = "להסיר את כל כללי המשלוח";
$GLOBALS['strEqualTo'] = "שווה ל";
$GLOBALS['strDifferentFrom'] = "שונה מ";
$GLOBALS['strLaterThan'] = "אחרי ";
$GLOBALS['strLaterThanOrEqual'] = "אחרי או בתאריך";
$GLOBALS['strEarlierThan'] = "לפני";
$GLOBALS['strEarlierThanOrEqual'] = "לפני או בתאריך";
$GLOBALS['strContains'] = "מכיל";
$GLOBALS['strNotContains'] = "לא מכיל";
$GLOBALS['strGreaterThan'] = "גדול מ";
$GLOBALS['strLessThan'] = "קטן מ";
$GLOBALS['strGreaterOrEqualTo'] = "גדול או שווה ל";
$GLOBALS['strLessOrEqualTo'] = "פחות או שווה ל";
$GLOBALS['strAND'] = "ו";                          // logical operator
$GLOBALS['strOR'] = "או";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "הצג באנר זה רק כש:";
$GLOBALS['strWeekDays'] = "ימים בשבוע";
$GLOBALS['strTime'] = "זמן";
$GLOBALS['strDomain'] = "דומיין";
$GLOBALS['strSource'] = "מקור";
$GLOBALS['strBrowser'] = "בראוזר";
$GLOBALS['strOS'] = "מערכת הפעלה";
$GLOBALS['strDeliveryLimitations'] = "כללי משלוח";

$GLOBALS['strDeliveryCappingReset'] = "איפוס מוני תצוגה לאחר:";
$GLOBALS['strDeliveryCappingTotal'] = "בסך הכל";
$GLOBALS['strDeliveryCappingSession'] = "בכל סשן";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['limit'] = "להגביל צפיית באנרים ל:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['limit'] = "להגביל צפיית קמפיין ל:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['limit'] = "להגביל צפיית באיזורים ל:";

// Website
$GLOBALS['strAffiliate'] = "אתר אינטרנט";
$GLOBALS['strAffiliates'] = "מפיצים";
$GLOBALS['strAffiliatesAndZones'] = "מפיצים ואיזורים";
$GLOBALS['strAddNewAffiliate'] = "הוסף אתר  חדש";
$GLOBALS['strAffiliateProperties'] = "תכונות האתר";
$GLOBALS['strAffiliateHistory'] = "סטטיסטיקה לאתר";
$GLOBALS['strNoAffiliates'] = "לא מוגדרים כעת שום אתרים.";
$GLOBALS['strConfirmDeleteAffiliate'] = "האם באמת למחוק אתר זה";
$GLOBALS['strConfirmDeleteAffiliates'] = "האם אתה באמת מעוניין למחוק את האתרים שנבחרו?";
$GLOBALS['strInactiveAffiliatesHidden'] = "אתרים לא פעילים מוסתרים";
$GLOBALS['strShowParentAffiliates'] = "הצג אתרי אב";
$GLOBALS['strHideParentAffiliates'] = "הסתר אתרי אב";

// Website (properties)
$GLOBALS['strWebsite'] = "אתר אינטרנט";
$GLOBALS['strWebsiteURL'] = "כתובת אתר";
$GLOBALS['strAllowAffiliateModifyZones'] = "אפשר למשתמש זה לשנות אזורים";
$GLOBALS['strAllowAffiliateLinkBanners'] = "אפשר למשתמש זה לקשר באנרים לאזורים שלו";
$GLOBALS['strAllowAffiliateAddZone'] = "אפשר למשתמש זה להגדיר אזורים חדשים";
$GLOBALS['strAllowAffiliateDeleteZone'] = "אפשר למשתמש זה למחוק אזורים";
$GLOBALS['strAllowAffiliateGenerateCode'] = "לאפשר למשתמש זה להפיק קוד להפעלה";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "מיקוד";
$GLOBALS['strCountry'] = "מדינה";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "אזורים באתר";

// Zone
$GLOBALS['strZone'] = "איזור";
$GLOBALS['strZones'] = "איזורים";
$GLOBALS['strAddNewZone'] = "הוסף איזור";
$GLOBALS['strAddNewZone_Key'] = "הוסף איזור <u>ח</u>דש";
$GLOBALS['strZoneToWebsite'] = "לאתר";
$GLOBALS['strLinkedZones'] = "איזורי הפעלה";
$GLOBALS['strAvailableZones'] = "איזורים זמינים";
$GLOBALS['strLinkingNotSuccess'] = "קישור לא הצליח, נסה שוב לקשר";
$GLOBALS['strZoneProperties'] = "תכונות האיזור";
$GLOBALS['strZoneHistory'] = "היסטוריית האיזור";
$GLOBALS['strNoZones'] = "עדיין לא הוגדר איזור";
$GLOBALS['strNoZonesAddWebsite'] = "Tכאן כרגע אין אזורים המוגדרים, כי אין אתרים. כדי ליצור אזור, <a href='affiliate-edit.php'> להוסיף חדש
</a> האתר תחילה.";
$GLOBALS['strConfirmDeleteZone'] = "האם אתה באמת רוצה למחוק אזור זה";
$GLOBALS['strConfirmDeleteZones'] = "האם אתה באמת מעוניין למחוק את האיזורים שנבחרו?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "יש קמפיינים עדיין מקושרים לאזור זה, אם תמחק אותו אלה לא יוכלו לרוץ ואתה לא תשולם
עבורם.";
$GLOBALS['strZoneType'] = "סוג איזור";
$GLOBALS['strBannerButtonRectangle'] = "באנר, כפתור או ריבוע";
$GLOBALS['strInterstitial'] = "על-שכבתי או צף";
$GLOBALS['strPopup'] = "קופץ";
$GLOBALS['strTextAdZone'] = "פרסוא טקסטואלי";
$GLOBALS['strEmailAdZone'] = "אזור עבור דוא\"ל/ניוזלטרים";
$GLOBALS['strZoneVideoInstream'] = "מודעת וידאו מוטמעת";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "הצג באנרים תואמים";
$GLOBALS['strHideMatchingBanners'] = "הסתר באנרים תואמים";
$GLOBALS['strBannerLinkedAds'] = "באנרים מקושרים לאיזור";
$GLOBALS['strCampaignLinkedAds'] = "קמפיינים מקושרים לאיזור";
$GLOBALS['strInactiveZonesHidden'] = "איזורים לא פעילים מוסתרים";
$GLOBALS['strWarnChangeZoneType'] = "Changing the zone type to text or email will unlink all banners/campaigns due to restrictions of these zone types
                                                <ul>
                                                    <li>Text zones can only be linked to text ads</li>
                                                    <li>Email zone campaigns can only have one active banner at a time</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Changing the zone size will unlink any banners that are not the new size, and will add any banners from linked campaigns which are the new size';
$GLOBALS['strWarnChangeBannerSize'] = 'Changing the banner size will unlink this banner from any zones that are not the new size, and if this banner\'s <strong>campaign</strong> is linked to a zone of the new size, this banner will be automatically linked';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'ב'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB גורד שחקים (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB חצי באנר (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Square Button (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Square Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Vertical Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Large Rectangle (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "מתקדם";
$GLOBALS['strChainSettings'] = "קביעת שרשרת";
$GLOBALS['strZoneNoDelivery'] = "אם אף באנר מאזור זה<br>זמין לחשיפה, נסה...";
$GLOBALS['strZoneStopDelivery'] = "חדל מחשיפה ואל תציג באנר";
$GLOBALS['strZoneOtherZone'] = "הצג מאזור המסומן כאן במקומו";
$GLOBALS['strZoneAppend'] = "תמיד צרף לקוד הבאנר מהסוג הקופץ או הצף הבא, עבור באנרים המוצגים מאזור זה.";
$GLOBALS['strAppendSettings'] = "צרף ומזג קביעות";
$GLOBALS['strZonePrependHTML'] = "הקדא תמיד  קוד HTML לפרסום טקסטואלי המוצג באזור זה";
$GLOBALS['strZoneAppendNoBanner'] = "Prepend/Append גם אם אין באנר באזור";
$GLOBALS['strZoneAppendHTMLCode'] = "קוד HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "קופץ או צף";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "כל הבאנרים המקושרים לאיזור הנבחר אינא פעילים כעת.<br>זו שרשרת האיזור שתעקוב:";
$GLOBALS['strZoneProbNullPri'] = "כל הבאנרים המקושרים לאיזור זה אינא פעיליא.";
$GLOBALS['strZoneProbListChainLoop'] = "מעקב אחר שרשרת האיזור תגרוא ללואה אינסופית. הפצה מאיזור זה נעצרה";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "אנא בחר את סוג הבאנרים המקושרים";
$GLOBALS['strLinkedBanners'] = "קשר באנרים ספציפיים";
$GLOBALS['strCampaignDefaults'] = "קשר באנרים לפי קמפיין אב";
$GLOBALS['strLinkedCategories'] = "קשר באנרים לפי קטגוריה";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
$GLOBALS['strRawQueryString'] = "בחירה לפי מילת מפתח";
$GLOBALS['strIncludedBanners'] = "באנרים מקושרים";
$GLOBALS['strMatchingBanners'] = "{count} באנרים תואמים";
$GLOBALS['strNoCampaignsToLink'] = "אין כעת מערכות פרסוא הניתנות לקישור לאזור זה.";
$GLOBALS['strNoTrackersToLink'] = "There are currently no trackers available which can be linked to this campaign";
$GLOBALS['strNoZonesToLinkToCampaign'] = "אין כעת אזורים הניתנים לקישור לקמפיין זה.";
$GLOBALS['strSelectBannerToLink'] = "בחר את הבאנר שאתה רוצה לקשר לאזור זה:";
$GLOBALS['strSelectCampaignToLink'] = "בחר את המערכת הפרסוא שאתה רוצה לקשר לאזור זה:";
$GLOBALS['strSelectAdvertiser'] = "בחר מפרסם";
$GLOBALS['strSelectPlacement'] = "בחר קמפיין";
$GLOBALS['strSelectAd'] = "בחר באנר";
$GLOBALS['strSelectPublisher'] = "בחר אתר אינטרנט";
$GLOBALS['strSelectZone'] = "בחר איזור";
$GLOBALS['strStatusPending'] = "ממתינים";
$GLOBALS['strStatusApproved'] = "אישור";
$GLOBALS['strStatusDisapproved'] = "לא אושר";
$GLOBALS['strStatusDuplicate'] = "שכפל";
$GLOBALS['strStatusOnHold'] = "בהמתנה";
$GLOBALS['strStatusIgnore'] = "התעלם";
$GLOBALS['strConnectionType'] = "סוג";
$GLOBALS['strConnTypeSale'] = "מכירה";
$GLOBALS['strConnTypeLead'] = "ליד";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Edit statuses";
$GLOBALS['strShortcutShowStatuses'] = "Show statuses";

// Statistics
$GLOBALS['strStats'] = "סטטיסטיקה";
$GLOBALS['strNoStats'] = "לא קיימת סטטיסטיקה עדיין.";
$GLOBALS['strNoStatsForPeriod'] = "כרגע אין סטטיסטיקות זמינות לתקופה של% ל% s";
$GLOBALS['strTotalThisPeriod'] = "סך הכל לתקופה זו";
$GLOBALS['strPublisherDistribution'] = "היתפלגות אתר ";
$GLOBALS['strCampaignDistribution'] = "היתפלגות קמפיין";
$GLOBALS['strViewBreakdown'] = "View by";
$GLOBALS['strBreakdownByDay'] = "יום";
$GLOBALS['strBreakdownByWeek'] = "שבוע";
$GLOBALS['strBreakdownByMonth'] = "חודש";
$GLOBALS['strBreakdownByDow'] = "יו םבשבוע";
$GLOBALS['strBreakdownByHour'] = "שעה";
$GLOBALS['strItemsPerPage'] = "פריטים לעמוד";
$GLOBALS['strShowGraphOfStatistics'] = "Show <u>G</u>raph of Statistics";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xport Statistics to Excel";
$GLOBALS['strGDnotEnabled'] = "You must have GD enabled in PHP to display graphs. <br />Please see <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for more information, including how to install GD on your server.";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "לא נקבע תאריך תפוגה";
$GLOBALS['strEstimated'] = "תפוגה משוערת";
$GLOBALS['strNoExpirationEstimation'] = "אין תפוגה משוערת עדיין";
$GLOBALS['strDaysAgo'] = "ימים שעברו";
$GLOBALS['strCampaignStop'] = "קמפיין נעצר";

// Reports
$GLOBALS['strAdvancedReports'] = "דו''חות מתקדמים";
$GLOBALS['strStartDate'] = "התחלה";
$GLOBALS['strEndDate'] = "סוף";
$GLOBALS['strPeriod'] = "נקודה";
$GLOBALS['strLimitations'] = "כללי משלוח";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "כל המפרסמים";
$GLOBALS['strAnonAdvertisers'] = "Anonymous advertisers";
$GLOBALS['strAllPublishers'] = "כל האתרים";
$GLOBALS['strAnonPublishers'] = "Anonymous websites";
$GLOBALS['strAllAvailZones'] = "כל האזורים הזמינים";

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
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Go back to report list";
$GLOBALS['strCharset'] = "Character set";
$GLOBALS['strAutoDetect'] = "זיהוי אוטומטי";
$GLOBALS['strCacheBusterComment'] = "  * להחליף את כל המופעים של {random} עם * מספר אקראי שנוצר (או חותמת זמן).   *";

// Errors
$GLOBALS['strNoMatchesFound'] = "לא נמצאו תוצאות";
$GLOBALS['strErrorOccurred'] = "אירעה שגיאה";
$GLOBALS['strErrorDBPlain'] = "ארעה שגיאה בגישה לבסיס הנתונים";
$GLOBALS['strErrorDBSerious'] = "ארעה שגיאה חמורה בבסיס הנתונים";
$GLOBALS['strErrorDBNoDataPlain'] = "עקב בעיה עם מסד הנתונים {$PRODUCT_NAME} לא הצלחתי לאחזר או לאחסן נתונים. ";
$GLOBALS['strErrorDBNoDataSerious'] = "עקב בעיה חמורה בבסיס הנתוניא, {$PRODUCT_NAME} לא יכלה להשיג מידע.";
$GLOBALS['strErrorDBCorrupt'] = "טבלאות בסיס הנתוניא כנראה קרסו ודורשות תיקון. מידע נוסף בדבר תיקון טבלאות שקרסו ניתן למצוא בפרק <i>Troubleshooting</i> של ה<i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "אנא צור קשר עא האחראי של שרת זה והודיע לו לגבי הבעיה.";
$GLOBALS['strErrorDBSubmitBug'] = "אא הבעיה נשנית, אפשר שמדובר בבאג ב-{$PRODUCT_NAME}. אנא דווח את המידע הבא ליוצריא של {$PRODUCT_NAME}. כמו כן נסה לתאר בצורה ברורה ככל האפשר את הפעולות שהובילו לקריסה זו.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "It was not possible to link this banner to this zone because:";
$GLOBALS['strUnableToLinkBanner'] = "Cannot link this banner: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Error updating zone:";
$GLOBALS['strDatesConflict'] = "Dates of the campaign you are trying to link overlap with the dates of a campaign already linked ";
$GLOBALS['strWarningInaccurateStats'] = "Some of these statistics were logged in a non-UTC timezone, and may not be displayed in the correct timezone.";
$GLOBALS['strWarningInaccurateReadMore'] = "Read more about this";
$GLOBALS['strWarningInaccurateReport'] = "Some of the statistics in this report were logged in a non-UTC timezone, and may not be displayed in the correct timezone";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "denotes required field";
$GLOBALS['strFormContainsErrors'] = "Form contains errors, please correct the marked fields below.";
$GLOBALS['strXRequiredField'] = "%s is required";
$GLOBALS['strEmailField'] = "Please enter a valid email";
$GLOBALS['strNumericField'] = "Please enter a number (only digits allowed)";
$GLOBALS['strGreaterThanZeroField'] = "Must be greater than 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s must be greater than 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s must be a positive whole number";
$GLOBALS['strInvalidWebsiteURL'] = "Invalid Website URL";

// Email
$GLOBALS['strSirMadam'] = "א.נ.";
$GLOBALS['strMailSubject'] = "דוח מפרסם";
$GLOBALS['strMailHeader'] = "שלום {contact},";
$GLOBALS['strMailBannerStats'] = "בהמשך תמצא את הסטטיסטיקה עבור הבאנרים של {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campaign activated";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campaign deactivated";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Your campaign shown below has been deactivated because";
$GLOBALS['strMailFooter'] = "בתודה,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "קמפיין זה אינו פעילה כעת משוא ש";
$GLOBALS['strBeforeActivate'] = "תאריך ההתחלה טרם הגיע";
$GLOBALS['strAfterExpire'] = "תאריך התפוגה הגיע ";
$GLOBALS['strNoMoreImpressions'] = "לא נותרו חשיפות ";
$GLOBALS['strNoMoreClicks'] = "לא נותרו הקלקות";
$GLOBALS['strNoMoreConversions'] = "לא נותרו מכירות";
$GLOBALS['strWeightIsNull'] = "משקלו נקבע לאפס";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "לא נרשמו חשיפות לאורך תקופת דוח זה.";
$GLOBALS['strNoClickLoggedInInterval'] = "לא נרשמו הקלקות לאורך תקופת דוח זה.";
$GLOBALS['strNoConversionLoggedInInterval'] = "No Conversions were logged during the span of this report";
$GLOBALS['strMailReportPeriod'] = "דוח זה כולל סטטיסטיקה מ{startdate} עד ל{enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "דוח זה כולל את כל הסטטיסטיקה עד ל{enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "אין בנמצא סטטיסטיקה לקמפיין זה.";
$GLOBALS['strImpendingCampaignExpiry'] = "Impending campaign expiration";
$GLOBALS['strYourCampaign'] = "הקמפיין שלך";
$GLOBALS['strTheCampiaignBelongingTo'] = "הקמפיין המשתייך אל";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} shown below is due to end on {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} shown below has less than {limit} impressions remaining.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "קדימויות";
$GLOBALS['strSourceEdit'] = "ערוך מקורות";

// Preferences
$GLOBALS['strPreferences'] = "העדפות";
$GLOBALS['strUserPreferences'] = "העדפות משתמש";
$GLOBALS['strChangePassword'] = "שינוי סיסמא";
$GLOBALS['strChangeEmail'] = "Change E-mail";
$GLOBALS['strCurrentPassword'] = "סיסמא נוכחית";
$GLOBALS['strChooseNewPassword'] = "בחר סיסמא חדשה";
$GLOBALS['strReenterNewPassword'] = "הקש שוב סיסמא חדשה";
$GLOBALS['strNameLanguage'] = "שם ושפה";
$GLOBALS['strAccountPreferences'] = "העדפות חשבון";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Campaign email Reports Preferences";
$GLOBALS['strTimezonePreferences'] = "אזור זמן";
$GLOBALS['strAdminEmailWarnings'] = "System administrator email Warnings";
$GLOBALS['strAgencyEmailWarnings'] = "Account email Warnings";
$GLOBALS['strAdveEmailWarnings'] = "Advertiser email Warnings";
$GLOBALS['strFullName'] = "שם מלא";
$GLOBALS['strEmailAddress'] = "דוא''ל";
$GLOBALS['strUserDetails'] = "פרטי משתמש";
$GLOBALS['strUserInterfacePreferences'] = "העדפות ממשק משתמש";
$GLOBALS['strPluginPreferences'] = "העדפות תוספים";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strRevenueCPC'] = "Revenue CPC";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "eCPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "Pending conversions";
$GLOBALS['strImpressionSR'] = "Impression SR";
$GLOBALS['strClickSR'] = "Click SR";

// Short names
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Items";
$GLOBALS['strRevenueCPC_short'] = "Rev. CPC";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strID_short'] = "מזהה";
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "חשיפות";
$GLOBALS['strClicks_short'] = "הקלקות";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "המרות";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "הגדרות";
$GLOBALS['strGlobalSettings'] = "הגדרות כלליות";
$GLOBALS['strGeneralSettings'] = "קביעות כלליות";
$GLOBALS['strMainSettings'] = "קביעות ראשיות";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "עידכוני התוכנה";
$GLOBALS['strViewPastUpdates'] = "Manage Past Updates and Backups";
$GLOBALS['strFromVersion'] = "From Version";
$GLOBALS['strToVersion'] = "To Version";
$GLOBALS['strToggleDataBackupDetails'] = "Toggle data backup details";
$GLOBALS['strClickViewBackupDetails'] = "click to view backup details";
$GLOBALS['strClickHideBackupDetails'] = "click to hide backup details";
$GLOBALS['strShowBackupDetails'] = "Show data backup details";
$GLOBALS['strHideBackupDetails'] = "Hide data backup details";
$GLOBALS['strBackupDeleteConfirm'] = "Do you really want to delete all backups created from this upgrade?";
$GLOBALS['strDeleteArtifacts'] = "Delete Artifacts";
$GLOBALS['strArtifacts'] = "Artifacts";
$GLOBALS['strBackupDbTables'] = "Backup database tables";
$GLOBALS['strLogFiles'] = "Log files";
$GLOBALS['strConfigBackups'] = "Conf backups";
$GLOBALS['strUpdatedDbVersionStamp'] = "Updated database version stamp";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "UPGRADE COMPLETE";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "UPGRADE FAILED";

// Agency
$GLOBALS['strAgencyManagement'] = "Account Management";
$GLOBALS['strAgency'] = "Account";
$GLOBALS['strAddAgency'] = "Add new account";
$GLOBALS['strAddAgency_Key'] = "Add <u>n</u>ew account";
$GLOBALS['strTotalAgencies'] = "Total accounts";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "There are currently no accounts defined";
$GLOBALS['strConfirmDeleteAgency'] = "Do you really want to delete this account?";
$GLOBALS['strHideInactiveAgencies'] = "Hide inactive accounts";
$GLOBALS['strInactiveAgenciesHidden'] = "inactive account(s) hidden";
$GLOBALS['strSwitchAccount'] = "Switch to this account";
$GLOBALS['strAgencyStatusInactive'] = "לא פעיל ";

// Channels
$GLOBALS['strChannelToWebsite'] = "לאתר";
$GLOBALS['strChannelLimitations'] = "אופציות תפוצה";
$GLOBALS['strChannelsOfWebsite'] = 'ב'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableDescription'] = "תיאור";
$GLOBALS['strVariableDataType'] = "סוג נתונים";
$GLOBALS['strVariablePurpose'] = "Purpose";
$GLOBALS['strGeneric'] = "כללי";
$GLOBALS['strBasketValue'] = "Basket value";
$GLOBALS['strNumItems'] = "Number of items";
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Number";
$GLOBALS['strString'] = "String";
$GLOBALS['strTrackFollowingVars'] = "Track the following variable";
$GLOBALS['strAddVariable'] = "Add Variable";
$GLOBALS['strNoVarsToTrack'] = "No Variables to track.";
$GLOBALS['strVariableRejectEmpty'] = "Reject if empty?";
$GLOBALS['strTrackingSettings'] = "Tracking settings";
$GLOBALS['strTrackerType'] = "Tracker type";
$GLOBALS['strTrackerTypeJS'] = "Track JavaScript variables";
$GLOBALS['strTrackerTypeDefault'] = "Track JavaScript variables (backwards compatible, escaping needed)";
$GLOBALS['strTrackerTypeDOM'] = "Track HTML elements using DOM";
$GLOBALS['strTrackerTypeCustom'] = "Custom JS code";
$GLOBALS['strVariableCode'] = "Javascript tracking code";

// Password recovery
$GLOBALS['strForgotPassword'] = "שכחת סיסמא?";
$GLOBALS['strEmailRequired'] = "דוא''ל הוא שדה חובה";
$GLOBALS['strPwdRecEnterEmail'] = "Enter your email address below";
$GLOBALS['strPwdRecEnterPassword'] = "Enter your new password below";
$GLOBALS['strProceed'] = "Proceed >";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strAdditionalItems'] = "and additional items";
$GLOBALS['strFor'] = "for";
$GLOBALS['strHas'] = "has";
$GLOBALS['strBinaryData'] = "Binary data";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail has been disabled by the system administrator. No further events are logged and shown in Audit Trail list.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "No user activity has been recorded during the timeframe you have selected.";
$GLOBALS['strAuditTrail'] = "Audit Trail";
$GLOBALS['strAuditTrailSetup'] = "Setup the Audit Trail today";
$GLOBALS['strAuditTrailGoTo'] = "Go to Audit Trail page";

// Widget - Campaign
$GLOBALS['strCampaignSetUp'] = "Set up a Campaign today";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>There is no campaign activity to display.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "No campaigns have started or finished during the timeframe you have selected";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activate Audit Trail to start viewing Campaigns";

$GLOBALS['strUnsavedChanges'] = "You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "You are now working as <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "You don't have access to that page. You have been re-directed.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Advertiser <a href='%s'>%s</a> has been added, <a href='%s'>add a campaign</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Advertiser <a href='%s'>%s</a> has been updated";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Advertiser <b>%s</b> has been deleted";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "All selected advertisers have been deleted";

$GLOBALS['strTrackerHasBeenAdded'] = "Tracker <a href='%s'>%s</a> has been added";
$GLOBALS['strTrackerHasBeenUpdated'] = "Tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Variables of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Linked campaigns of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Append tracker code of tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> has been deleted";
$GLOBALS['strTrackersHaveBeenDeleted'] = "All selected trackers have been deleted";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Tracker <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Campaign <a href='%s'>%s</a> has been added, <a href='%s'>add a banner</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Campaign <a href='%s'>%s</a> has been updated";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Linked trackers of campaign <a href='%s'>%s</a> have been updated";
$GLOBALS['strCampaignHasBeenDeleted'] = "Campaign <b>%s</b> has been deleted";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "All selected campaigns have been deleted";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Campaign <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "Campaign <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "Banner <a href='%s'>%s</a> has been added";
$GLOBALS['strBannerHasBeenUpdated'] = "Banner <a href='%s'>%s</a> has been updated";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Advanced settings for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Delivery options for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Delivery options for banner <a href='%s'>%s</a> have been applied to %d banners";
$GLOBALS['strBannerHasBeenDeleted'] = "Banner <b>%s</b> has been deleted";
$GLOBALS['strBannersHaveBeenDeleted'] = "All selected banners have been deleted";
$GLOBALS['strBannerHasBeenDuplicated'] = "Banner <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "Banner <b>%s</b> has been moved to campaign <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "Banner <a href='%s'>%s</a> has been activated";
$GLOBALS['strBannerHasBeenDeactivated'] = "Banner <a href='%s'>%s</a> has been deactivated";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> zone(s) linked";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zone(s) unlinked";

$GLOBALS['strWebsiteHasBeenAdded'] = "Website <a href='%s'>%s</a> has been added, <a href='%s'>add a zone</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Website <a href='%s'>%s</a> has been updated";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Website <b>%s</b> has been deleted";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "All selected website have been deleted";

$GLOBALS['strZoneHasBeenAdded'] = "Zone <a href='%s'>%s</a> has been added";
$GLOBALS['strZoneHasBeenUpdated'] = "Zone <a href='%s'>%s</a> has been updated";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Advanced settings for zone <a href='%s'>%s</a> have been updated";
$GLOBALS['strZoneHasBeenDeleted'] = "Zone <b>%s</b> has been deleted";
$GLOBALS['strZonesHaveBeenDeleted'] = "All selected zone have been deleted";
$GLOBALS['strZoneHasBeenDuplicated'] = "Zone <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "Zone <b>%s</b> has been moved to website <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Banner has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "Campaign has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Banner has been unlinked from zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "Campaign has been unlinked from zone <a href='%s'>%s</a>";


$GLOBALS['strUserPreferencesUpdated'] = "Your <b>%s</b> preferences has been updated";
$GLOBALS['strEmailChanged'] = "Your E-mail has been changed";
$GLOBALS['strPasswordChanged'] = "Your password has been changed";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> have been updated";

// Report error messages
$GLOBALS['strReportErrorUnknownCode'] = "Unknown error code #";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "ח";
$GLOBALS['keyCollapseAll'] = "מ";
$GLOBALS['keyExpandAll'] = "פ";
$GLOBALS['keyAddNew'] = "ח";
$GLOBALS['keyNext'] = "ח";
$GLOBALS['keyPrevious'] = "ק";
$GLOBALS['keyLinkUser'] = "u";
