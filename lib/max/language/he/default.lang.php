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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "rtl";
$GLOBALS['phpAds_TextAlignRight'] 		= "left";
$GLOBALS['phpAds_TextAlignLeft']  		= "right";

$GLOBALS['phpAds_DecimalPoint']			= '.';
$GLOBALS['phpAds_ThousandsSeperator']		= ',';


// Date & time configuration
$GLOBALS['date_format']				= "%d/%m/%Y";
$GLOBALS['time_format']				= "%H:%M:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%m/%Y";
$GLOBALS['day_format']				= "%d/%m";
$GLOBALS['week_format']				= "%W/%Y";
$GLOBALS['weekiso_format']			= "%V/%G";


/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome'] 				= "ר�?שי";
$GLOBALS['strHelp']				= "עזרה";
$GLOBALS['strNavigation'] 			= "ניווט";
$GLOBALS['strShortcuts'] 			= "קיצורי�?";
$GLOBALS['strAdminstration'] 			= "מל�?י";
$GLOBALS['strMaintenance']			= "תחזוקה";
$GLOBALS['strProbability']			= "סיכויי�?";
$GLOBALS['strInvocationcode']			= "קוד תצוגה";
$GLOBALS['strBasicInformation'] 		= "מידע בסיסי";
$GLOBALS['strContractInformation'] 		= "מידע התקשרות";
$GLOBALS['strLoginInformation'] 		= "מידע התחברות";
$GLOBALS['strOverview']				= "סקירה כללית";
$GLOBALS['strSearch']				= "חפ<u>ש</u>";
$GLOBALS['strHistory']				= "היסטוריה";
$GLOBALS['strPreferences'] 			= "קדימויות";
$GLOBALS['strDetails']				= "פרטי�?";
$GLOBALS['strCompact']				= "קומפקטי";
$GLOBALS['strVerbose']				= "מפורט";
$GLOBALS['strUser']				= "משתמש";
$GLOBALS['strEdit']				= "ערוך";
$GLOBALS['strCreate']				= "צור";
$GLOBALS['strDuplicate']			= "שכפל";
$GLOBALS['strMoveTo']				= "העבר ל";
$GLOBALS['strDelete'] 				= "מחק";
$GLOBALS['strActivate']				= "הפעל";
$GLOBALS['strDeActivate'] 			= "שתק";
$GLOBALS['strConvert']				= "המר";
$GLOBALS['strRefresh']				= "רענן";
$GLOBALS['strSaveChanges']		 	= "שמור שינויי�?";
$GLOBALS['strUp'] 				= "למעלה";
$GLOBALS['strDown'] 				= "למטה";
$GLOBALS['strSave'] 				= "שמור";
$GLOBALS['strCancel']				= "בטל";
$GLOBALS['strPrevious'] 			= "קוד�?";
$GLOBALS['strPrevious_Key'] 			= "<u>ק</u>וד�?";
$GLOBALS['strNext'] 				= "הב�?";
$GLOBALS['strNext_Key'] 				= "ה<u>ב</u>�?";
$GLOBALS['strYes']				= "כן";
$GLOBALS['strNo']				= "ל�?";
$GLOBALS['strNone'] 				= "�?ף �?חד";
$GLOBALS['strCustom']				= "לפי מידה";
$GLOBALS['strDefault'] 				= "ברירת מחדל";
$GLOBALS['strOther']				= "�?חר";
$GLOBALS['strUnknown']				= "ל�? ידוע";
$GLOBALS['strUnlimited'] 			= "לל�? הגבלה";
$GLOBALS['strUntitled']				= "לל�? ש�?";
$GLOBALS['strAll'] 				= "הכל";
$GLOBALS['strAvg'] 				= "ממצ.";
$GLOBALS['strAverage']				= "ממוצע";
$GLOBALS['strOverall'] 				= "כללי";
$GLOBALS['strTotal'] 				= "סך הכל";
$GLOBALS['strActive'] 				= "פעיל";
$GLOBALS['strFrom']				= "מ";
$GLOBALS['strTo']				= "ל";
$GLOBALS['strLinkedTo'] 			= "מקושר ל";
$GLOBALS['strDaysLeft'] 			= "ימי�? שנותרו";
$GLOBALS['strCheckAllNone']			= "סמן הכל/ �?ו כלו�?";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "<u>פ</u>רוש הכל";
$GLOBALS['strCollapseAll']			= "<u>מ</u>כונס הכל";
$GLOBALS['strShowAll']				= "הצג הכל";
$GLOBALS['strNoAdminInteface']			= "השירות �?ינו פעיל...";
$GLOBALS['strFilterBySource']			= "סנן לפי מקור";
$GLOBALS['strFieldContainsErrors']		= "השדות הב�?י�? מכילי�? שגי�?ות:";
$GLOBALS['strFieldFixBeforeContinue1']		= "לפני שתמשיך עליך";
$GLOBALS['strFieldFixBeforeContinue2']		= "לתקן שגי�?ות �?לו.";
$GLOBALS['strDelimiter']			= "תוח�?";
$GLOBALS['strMiscellaneous']		= "שונות";
$GLOBALS['strCollectedAll']			= "כל הסטטיסטיקה שנ�?ספה";
$GLOBALS['strCollectedToday']		= "סטטיסטיקה להיו�? בלבד";
$GLOBALS['strCollected7Days']		= "סטטיסטיקה ל-7 הימי�? ה�?חרוני�?";
$GLOBALS['strCollectedMonth']		= "סטטיסטיקה לחודש זה בלבד";





// Properties
$GLOBALS['strName']				= "ש�?";
$GLOBALS['strSize']				= "גודל";
$GLOBALS['strWidth'] 				= "רוחב";
$GLOBALS['strHeight'] 				= "גובה";
$GLOBALS['strURL2']				= "URL";
$GLOBALS['strTarget']				= "חלון מטרה";
$GLOBALS['strLanguage'] 			= "שפה";
$GLOBALS['strDescription'] 			= "תי�?ור";
$GLOBALS['strID']				= "ID";



// Login & Permissions
$GLOBALS['strAuthentification'] 		= "�?ימות";
$GLOBALS['strWelcomeTo']			= "ברוכי�? הב�?י�? ל";
$GLOBALS['strEnterUsername']			= "נ�? להכניס ש�? וסיסמ�? כדי להיכנס";
$GLOBALS['strEnterBoth']			= "�?נ�? הזן �?ת ש�? המשתמש והסיסמ�?";
$GLOBALS['strEnableCookies']			= "עליך ל�?פשר קוקיס (cookies) לפני השימוש ב-".MAX_PRODUCT_NAME;
$GLOBALS['strLogin'] 				= "התחבר";
$GLOBALS['strLogout'] 				= "התנתק";
$GLOBALS['strUsername'] 			= "ש�? משתמש";
$GLOBALS['strPassword']				= "סיסמ�?";
$GLOBALS['strAccessDenied']			= "גישה ל�? מ�?ושרת";
$GLOBALS['strPasswordWrong']			= "הסיסמ�? �?ינה נכונה";
$GLOBALS['strNotAdmin']				= "�?יך לך הרש�?ה מספקת";
$GLOBALS['strDuplicateClientName']		= "ש�? המשתמש שבחרת כבר קיי�?, נ�? לבחור ש�? �?חר.";
$GLOBALS['strInvalidPassword']			= "סיסמ�? פסולה";
$GLOBALS['strNotSamePasswords']			= "סיסמ�?ות �?ינן תו�?מות";
$GLOBALS['strRepeatPassword']			= "חזור על הסיסמ�?";
$GLOBALS['strOldPassword']			= "סיסמ�? קודמת";
$GLOBALS['strNewPassword']			= "סיסמ�? חדשה";



// General advertising
$GLOBALS['strImpressions'] 			=
$GLOBALS['strViews'] 				= "חשיפות";
$GLOBALS['strClicks']				= "הקלקות";
$GLOBALS['strCTRShort'] 			= "CTR";
$GLOBALS['strCTR'] 				= "יחס חשיפה-הקלקה";
$GLOBALS['strTotalViews'] 			= "סך הכל חשיפות";
$GLOBALS['strTotalClicks'] 			= "סך הכל הקלקות";
$GLOBALS['strViewCredits'] 			= "�?שר�?י חשיפות";
$GLOBALS['strClickCredits'] 			= "�?שר�?י הקלקות";


// Time and date related
$GLOBALS['strDate'] 				= "ת�?ריך";
$GLOBALS['strToday'] 				= "היו�?";
$GLOBALS['strDay']				= "יו�?";
$GLOBALS['strDays']				= "ימי�?";
$GLOBALS['strLast7Days']			= "7 ימי�? �?חרוני�?";
$GLOBALS['strWeek'] 				= "שבוע";
$GLOBALS['strWeeks']				= "שבועות";
$GLOBALS['strMonths']				= "חודשי�?";
$GLOBALS['strThisMonth'] 			= "החודש";
$GLOBALS['strMonth'] 				= array("ינו�?ר","פברו�?ר","מרץ","�?פריל","מ�?י","יוני","יולי", "�?וגוסט", "ספטמבר", "�?וקטובר", "נובמבר", "דצמבר");
$GLOBALS['strDayShortCuts'] 			= array("ר","שני","של","רב","חמ","שי","שב");
$GLOBALS['strHour']				= "שעה";
$GLOBALS['strSeconds']				= "שניות";
$GLOBALS['strMinutes']				= "דקות";
$GLOBALS['strHours']				= "שעות";
$GLOBALS['strTimes']				= "פעמי�?";


// Advertiser
$GLOBALS['strClient']				= "מפרס�?";
$GLOBALS['strClients'] 				= "מפרסמי�?";
$GLOBALS['strClientsAndCampaigns']		= "מפרסמי�? ומערכות";
$GLOBALS['strAddClient'] 			= "הוסף מפרס�? חדש";
$GLOBALS['strAddClient_Key'] 		= "הוסף מפרס�? <u>ח</u>דש";
$GLOBALS['strTotalClients'] 			= "סך הכל מפרסמי�?";
$GLOBALS['strClientProperties']			= "נתוני מפרס�?";
$GLOBALS['strClientHistory']			= "היסטורית מפרס�?";
$GLOBALS['strNoClients']			= "�?ין כרגע �?ף מפרס�?";
$GLOBALS['strConfirmDeleteClient'] 		= "ה�?�? ב�?מת למחוק מפרס�? זה?";
$GLOBALS['strConfirmResetClientStats']		= "ה�?�? ב�?מת למחוק �?ת כל הסטטיסטיקה של מפרס�? זה?";
$GLOBALS['strHideInactiveAdvertisers']		= "הסתר מפרס�? ל�? פעיל";
$GLOBALS['strInactiveAdvertisersHidden']	= "מפרס�? ל�? פעיל מוסתר";




// Advertisers properties
$GLOBALS['strContact'] 				= "קשר";
$GLOBALS['strEMail'] 				= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "שלח דיווח פירסו�? ב-e-mail";
$GLOBALS['strNoDaysBetweenReports']		= "מספר ימי�? בין דוחות";
$GLOBALS['strSendDeactivationWarning']  	= "שלח �?זהרה �?�? התעמולה ל�? פעילה";
$GLOBALS['strAllowClientModifyInfo'] 		= "�?פשר למשתמש זה לשנות �?ת קביעותיו";
$GLOBALS['strAllowClientModifyBanner'] 		= "�?פשר למשתמש זה לשנות �?ת הב�?נרי�? שלו";
$GLOBALS['strAllowClientAddBanner'] 		= "�?פשר למשתמש זה להעלות ב�?נרי�? בעצמו";
$GLOBALS['strAllowClientDisableBanner'] 	= "�?פשר למשתמש זה לשתק ב�?נרי�? בעצמו";
$GLOBALS['strAllowClientActivateBanner'] 	= "�?פשר למשתמש זה להפעיל ב�?נרי�? בעצמו";




// Campaign
$GLOBALS['strCampaign']				= "מערכה";
$GLOBALS['strCampaigns']			= "מערכות פרסו�?";
$GLOBALS['strTotalCampaigns'] 			= "סך הכל מערכות";
$GLOBALS['strActiveCampaigns'] 			= "מערכות פעילות";
$GLOBALS['strAddCampaign'] 			= "הוסף קמפיין";
$GLOBALS['strAddCampaign_Key'] 		= "הוסף קמפיין <u>ח</u>דש";
$GLOBALS['strCreateNewCampaign']		= "צור קמפיין חדשה";
$GLOBALS['strModifyCampaign']			= "שנה קמפיין";
$GLOBALS['strMoveToNewCampaign']		= "העבר למערכת חדשה";
$GLOBALS['strBannersWithoutCampaign']		= "ב�?נרי�? לל�? קמפיין";
$GLOBALS['strDeleteAllCampaigns']		= "מחק �?ת כל מערכות הפרסו�?";
$GLOBALS['strCampaignStats']			= "סטטיסטיקת קמפיין";
$GLOBALS['strCampaignProperties']		= "תכונות קמפיין";
$GLOBALS['strCampaignOverview']			= "סקירת קמפיין";
$GLOBALS['strCampaignHistory']			= "היסטורית קמפיין";
$GLOBALS['strNoCampaigns']			= "�?ין כעת �?ף קמפיין מוגדר";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "�?�? ב�?מת למחוק �?ת כל מערכות הפרסו�? של מפרס�? זה?";
$GLOBALS['strConfirmDeleteCampaign']		= "ה�?�? ב�?מת למחוק �?ת מערכת הפרסו�? הזו?";
$GLOBALS['strHideInactiveCampaigns']		= "הסתר קמפיין ל�? פעיל";
$GLOBALS['strInactiveCampaignsHidden']		= "קמפיין ל�? פעיל מוסתר";




// Campaign properties
$GLOBALS['strDontExpire']			= "�?ל תפסיק קמפיין זה בת�?ריך מסוי�?";
$GLOBALS['strActivateNow'] 			= "הפעל קמפיין זה מיידית";
$GLOBALS['strLow']				= "נמוכה";
$GLOBALS['strHigh']				= "גבוהה";
$GLOBALS['strExpirationDate']			= "ת�?ריך תפוגה";
$GLOBALS['strActivationDate']			= "ת�?ריך הפעלה";
$GLOBALS['strViewsPurchased'] 			= "חשיפות שנותרו";
$GLOBALS['strClicksPurchased'] 			= "הקלקות שנותרו";
$GLOBALS['strCampaignWeight']			= "משקל מערכת הפרסו�?";
$GLOBALS['strHighPriority']			= "הצג ב�?נרי�? מקמפיין זה בקדימות גבוהה.<br>�?�? תבחר �?ופציה זו, phpAdsNew תנסה להפיץ �?ת מספר החשיפות בצורה שווה ל�?ורך היו�?.";
$GLOBALS['strLowPriority']			= "הצג ב�?נרי�? מקמפיין זה בקדימות נמוכה.<br>קמפיין זה הו�? למטרת התצוגה של הב�?נרי�? שנותרו ול�? בשימוש במערכות הפרסו�? בעלות קדימות גבוהה.";
$GLOBALS['strTargetLimitAdviews']		= "הגבל �?ת מספר החשיפות ל";
$GLOBALS['strTargetPerDay']			= "ליו�?.";
$GLOBALS['strPriorityAutoTargeting']		= "פזר �?ת ש�?רית החשיפות בצורה שווה במשך הימי�? שנותרו. מספר החשיפות הנדרשות יעודכן בהת�?�? בכל יו�?.";
$GLOBALS['strCampaignWarningNoWeight'] = "הקדימות של קמפיין זה נקבע לנמוכה, \n�?ך המשקל נקבע ל�?פס �?ו של�? נקבע כלל. \nזה יגרו�? לקמפיין להיות ל�? פעיל \nוהב�?נרי�? שלו ל�? יונפקו\nעד �?שר המשקל ייקבע לערך תקף. \n\nה�?�? �?תה רוצה להשמיך?";
$GLOBALS['strCampaignWarningNoTarget'] = "הקדימות של קמפיין זה נקבעה כגבוהה,\n�?ך מספר המטרה של חשיפות ל�? נקבע.\n זה יגרו�? לקמפיין להיות ל�? פעיל\nוב�?נרי�? ל�? יונפקו עד שמספר מטרה תקף ייקבע.\n ה�?פ �?תה בטוח רושצה להשמיך?";




// Banners (General)
$GLOBALS['strBanner'] 				= "ב�?נר";
$GLOBALS['strBanners'] 				= "ב�?נרי�?";
$GLOBALS['strAddBanner'] 			= "הוסף ב�?נר חדש";
$GLOBALS['strAddBanner_Key'] 			= "הוסף ב�?נר <u>ח</u>דש";
$GLOBALS['strModifyBanner'] 			= "שנה ב�?נר";
$GLOBALS['strActiveBanners'] 			= "ב�?נרי�? פעילי�?";
$GLOBALS['strTotalBanners'] 			= "סך הכל ב�?נרי�?";
$GLOBALS['strShowBanner']			= "הצג ב�?נר";
$GLOBALS['strShowAllBanners']	 		= "הצג �?ת כל הב�?נרי�?";
$GLOBALS['strShowBannersNoAdClicks']		= "הר�?ה ב�?נרי�? לל�? הקלקות";
$GLOBALS['strShowBannersNoAdViews']		= "הר�?ה ב�?נרי�? לל�? חשיפות";
$GLOBALS['strDeleteAllBanners']	 		= "מחק �?ת כל הב�?נרי�?";
$GLOBALS['strActivateAllBanners']		= "הפעל �?ת כל הב�?נרי�?";
$GLOBALS['strDeactivateAllBanners']		= "שתק �?ת כל הב�?נרי�?";
$GLOBALS['strBannerOverview']			= "סקירת ב�?נרי�?";
$GLOBALS['strBannerProperties']			= "תכונות הב�?נר";
$GLOBALS['strBannerHistory']			= "היסטורית הב�?נר";
$GLOBALS['strBannerNoStats'] 			= "�?ין סטטיסטיקה עבור ב�?נר זה";
$GLOBALS['strNoBanners']			= "עדיין ל�? הוגדרו ב�?נרי�?";
$GLOBALS['strConfirmDeleteBanner']		= "ה�?�? ב�?מת למחוק ב�?נר זה?";
$GLOBALS['strConfirmDeleteAllBanners']		= "ה�?�? ב�?מת למחוק �?ת כל הב�?נרי�? בקמפיין זה?";
$GLOBALS['strConfirmResetBannerStats']		= "ה�?�? ב�?מת למחוק �?ת כל הסטטיסטיקה עבור ב�?נר זה?";
$GLOBALS['strShowParentCampaigns']		= "הצג מערכת פרסות ר�?שית";
$GLOBALS['strHideParentCampaigns']		= "הסתר קמפיין-�?ב";
$GLOBALS['strHideInactiveBanners']		= "הסתר ב�?נרי�? ל�? פעילי�?";
$GLOBALS['strInactiveBannersHidden']		= "ב�?נר(י�?) ל�? פעיל(י�?) מוסתר(י�?)";
$GLOBALS['strAppendOthers']				= "הוסף �?חרי�?";
$GLOBALS['strAppendTextAdNotPossible']	= "�?ין �?פשרות להוסיף ב�?נרי�? �?חרי�? לב�?רי�? טקסטו�?ליי�?.";





// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= "�?נ�? בחר �?ת סוג הב�?נר";
$GLOBALS['strMySQLBanner'] 			= "ב�?נר מקומי (SQL)";
$GLOBALS['strWebBanner'] 			= "ב�?נר מקומי(על השרת)";
$GLOBALS['strURLBanner'] 			= "ב�?נר חיצוני";
$GLOBALS['strHTMLBanner'] 			= "ב�?נר קוד HTML";
$GLOBALS['strTextBanner'] 			= "Text ad";
$GLOBALS['strAutoChangeHTML']			= "שנה  קוד HTML של הב�?נר על מנת ל�?פשר מעקב הקלקות";
$GLOBALS['strUploadOrKeep']			= "ה�?�? �?תה רוצה להש�?יר<br>�?ת הגרפיקה הקיימת �?ו<br>להעלות חדשה?";
$GLOBALS['strNewBannerFile'] 			= "בחר �?ת הגרפיקה שברצונך<br>להשתמש בב�?נר זה<br><br>";
$GLOBALS['strNewBannerURL'] 			= "כתובת (URL) הגרפיקה (כולל http://)";
$GLOBALS['strURL'] 				= "כתובת (URL) הפניית הקלקה (כולל http://)";
$GLOBALS['strHTML'] 				= "HTML";
$GLOBALS['strTextBelow'] 			= "כיתוב שמתחת לב�?נר";
$GLOBALS['strKeyword'] 				= "מילות מפתח";
$GLOBALS['strWeight'] 				= "משקל";
$GLOBALS['strAlt'] 				= "כיתוב חלופי";
$GLOBALS['strStatusText']			= "כיתוב בשורת הסטטוס";
$GLOBALS['strBannerWeight']			= "משקל הב�?נר";



// Banner (swf)
$GLOBALS['strCheckSWF']				= "בדוק �?�? יש כתובת �?תר מוטבעת בתוך קובץ הפל�?ש";
$GLOBALS['strConvertSWFLinks']			= "המר �?ת הלינקי�? שבקובץ הפל�?ש";
$GLOBALS['strHardcodedLinks']			= "קישורי�? טמוני�? בקוד";
$GLOBALS['strConvertSWF']			= "<br>קובץ ה-Flash שזה עתה העלת מכיל כתובת הפניית הקלקה מובנית.<br>התוכנה ל�? תוכל לעקוב �?חר מספר ההקלקות �?ל�? �?�? כתובת זו תומר.<br> למטה תוכל למצו�? רשימה של כתובות ש�?ותרו בתוך הקובץ. <br>�?�? �?תה רוצה להמיר �?ת הכתובות לחץ על <B>המר</B>, �?ו לחץ על <B>בטל</B><br><br>"."שי�? לב: �?�? �?תה לוחץ על <B>המר</B>, קובץ הפל�?ש שזה עכשיו העלת ישונה בצורה פיזית. <br>�?נ�? שמור לך עותק מקורי שלו כגיבוי.<br> ל�? משנה ב�?יזו גירסה פל�?ש זה נעשה, <br>לתצוגה  נכונה שלו תספיק גירסת נגן Flash 4 (�?ו גבוהה יותר).<br><br> ";
$GLOBALS['strCompressSWF']			= "<DIV DIR = \"RTL\" align = \"LEFT\">סמן לדחיסת קובץ SWF לטעינת עמוד מהירה יותר (דרושה גירסת נגן Flash 6) </DIV>";
$GLOBALS['strOverwriteSource']		= "רמוס פרמטרי�? של המקור";




// Banner (network)
$GLOBALS['strBannerNetwork']			= "תבנית HTML";
$GLOBALS['strChooseNetwork']			= "בחר בתבנית ש�?תה רוצה להשתמש בה.";
$GLOBALS['strMoreInformation']			= "עוד מידע...";
$GLOBALS['strRichMedia']			= "מדיה עשירה";
$GLOBALS['strTrackAdClicks']			= "עקוב �?חר הקלקות ";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "�?ופציות תפוצה";
$GLOBALS['strACL'] 				= "תפוצה";
$GLOBALS['strACLAdd'] 				= "הוסף הגבלה חדשה";
$GLOBALS['strACLAdd_Key'] 				= "הוסף הגבלה <u>ח</u>דשה";
$GLOBALS['strNoLimitations']			= "לל�? הגבלות";
$GLOBALS['strApplyLimitationsTo']		= "הענק הגבלה ל";
$GLOBALS['strRemoveAllLimitations']		= "הסר �?ת כל המגבלות";
$GLOBALS['strEqualTo']				= "שווה ל";
$GLOBALS['strDifferentFrom']			= "שונה מ";
$GLOBALS['strLaterThan']				= "מ�?וחר יותר מ";
$GLOBALS['strLaterThanOrEqual']			= "מ�?וחר יותר �?ו שווה ל";
$GLOBALS['strEarlierThan']				= "מוקד�? יותר מ";
$GLOBALS['strEarlierThanOrEqual']		= "מוקד�? יותר �?ו שווה ל";
$GLOBALS['strContains']					= "מכיל";
$GLOBALS['strNotContains']				= "�?ינו מכיל";
$GLOBALS['strAND']				= "ו";  						// logical operator
$GLOBALS['strOR']				= "�?ו"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "הצג ב�?נר זה רק כש:";
$GLOBALS['strWeekDay'] 				= "יו�? בשבוע";
$GLOBALS['strTime'] 				= "שעה";
$GLOBALS['strUserAgent'] 			= "מוביל השירות";
$GLOBALS['strDomain'] 				= "ש�? מתחש�? (Domain)";
$GLOBALS['strClientIP'] 			= "תגית IP";
$GLOBALS['strSource'] 				= "צמוד לתוכן מקור";
$GLOBALS['strBrowser'] 				= "דפדפן";
$GLOBALS['strOS'] 				= "מערכת הפעלה";
$GLOBALS['strCountry'] 				= "מדינה";
$GLOBALS['strContinent'] 			= "יבשת";
$GLOBALS['strUSState']					= "מדינה ב�?רה\"ב";
$GLOBALS['strReferer'] 					= "עמוד הפנייה";
$GLOBALS['strDeliveryLimitations']		= "הגבלות תפוצה";
$GLOBALS['strDeliveryCapping']			= "היקף תפוצה";
$GLOBALS['strTimeCapping']			= "ברגע שב�?נר זה הוצג, �?ל תציג �?ותו שוב ל�?ותו משתמש במשך:";
$GLOBALS['strImpressionCapping']		= "�?ל תציג ב�?נר זה ל�?ותו משתמש יותר מ:";




/// Publisher
$GLOBALS['strAffiliate']			= "מפיץ";
$GLOBALS['strAffiliates']			= "מפיצי�?";
$GLOBALS['strAffiliatesAndZones']		= "מפיצי�? ו�?יזורי�?";
$GLOBALS['strAddNewAffiliate']			= "הוסף �?תר הפצה חדש";
$GLOBALS['strAddNewAffiliate_Key']			= "הוסף מפיץ <u>ח</u>דש";
$GLOBALS['strAddAffiliate']			= "צור מפיץ";
$GLOBALS['strAffiliateProperties']		= "תכונות המפיץ";
$GLOBALS['strAffiliateOverview']		= "סקירת מפיץ";
$GLOBALS['strAffiliateHistory']			= "היסטורית מפיץ";
$GLOBALS['strZonesWithoutAffiliate']		= "�?זורי�? לל�? מפיץ";
$GLOBALS['strMoveToNewAffiliate']		= "העבר למפיץ חדש";
$GLOBALS['strNoAffiliates']			= "ל�? מוגדרי�? כעת שו�? מפיצי�?.";
$GLOBALS['strConfirmDeleteAffiliate']		= "ה�?�? ב�?מת למחוק מפיץ זה?";
$GLOBALS['strMakePublisherPublic']		= "�?פשר ל�?זורי�? השייכי�? למפיץ זה להיות זמיני�? לכל";



// Publisher (properties)
$GLOBALS['strWebsite']						= "�?תר";
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "�?פשר למשתמש זה לשנות �?ת קביעותיו";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "�?פשר למשתמש זה לשנות �?זורי�?";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "�?פשר למשתמש זה לקשר ב�?נרי�? ל�?זורי�? שלו";
$GLOBALS['strAllowAffiliateAddZone'] 		= "�?פשר למשתמש זה להגדיר �?זורי�? חדשי�?";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "�?פשר למשתמש זה למחוק �?זורי�?";




// Zone
$GLOBALS['strZone']				= "�?יזור";
$GLOBALS['strZones']				= "�?יזורי�?";
$GLOBALS['strAddNewZone']			= "הוסף �?יזור";
$GLOBALS['strAddNewZone_Key']			= "הוסף �?יזור <u>ח</u>דש";
$GLOBALS['strAddZone']				= "צור �?יזור הפעלה";
$GLOBALS['strModifyZone']			= "שנה �?יזור";
$GLOBALS['strLinkedZones']			= "�?יזורי הפעלה";
$GLOBALS['strZoneOverview']			= "סקירת �?יזורי הפעלה";
$GLOBALS['strZoneProperties']			= "תכונות ה�?יזור";
$GLOBALS['strZoneHistory']			= "היסטוריית ה�?יזור";
$GLOBALS['strNoZones']				= "עדיין ל�? הוגדר �?יזור";
$GLOBALS['strConfirmDeleteZone']		= "ה�?�? �?תה ב�?מת רוצה למחוק �?זור זה?";
$GLOBALS['strZoneType']				= "סוג �?יזור";
$GLOBALS['strBannerButtonRectangle']		= "ב�?נר, כפתור �?ו ריבוע";
$GLOBALS['strInterstitial']			= "על-שכבתי �?ו צף";
$GLOBALS['strPopup']				= "קופץ";
$GLOBALS['strTextAdZone']			= "פרסו�? טקסטו�?לי";
$GLOBALS['strShowMatchingBanners']		= "הצג ב�?נרי�? תו�?מי�?";
$GLOBALS['strHideMatchingBanners']		= "הסתר ב�?נרי�? תו�?מי�?";



// Advanced zone settings
$GLOBALS['strAdvanced']				= "מתקד�?";
$GLOBALS['strChains']				= "שרשר�?ות";
$GLOBALS['strChainSettings']			= "קביעת שרשרת";
$GLOBALS['strZoneNoDelivery']			= "�?�? �?ף ב�?נר מ�?זור זה<br>זמין לחשיפה, נסה...";
$GLOBALS['strZoneStopDelivery']			= "חדל מחשיפה ו�?ל תציג ב�?נר";
$GLOBALS['strZoneOtherZone']			= "הצג מ�?זור המסומן כ�?ן במקומו";
$GLOBALS['strZoneUseKeywords']			= "בחר בב�?נר תוך שימוש במילות מפתח המצוינות מטה.";
$GLOBALS['strZoneAppend']			= "תמיד צרף לקוד הב�?נר מהסוג הקופץ �?ו הצף הב�?, עבור ב�?נרי�? המוצגי�? מ�?זור זה.";
$GLOBALS['strAppendSettings']			= "צרף ומזג קביעות";
$GLOBALS['strZonePrependHTML']			= "הקד�? תמיד  קוד HTML לפרסו�? טקסטו�?לי המוצג ב�?זור זה";
$GLOBALS['strZoneAppendHTML']			= "הוסף תמיד  קוד HTML לפרסו�? טקסטו�?לי המוצג ב�?זור זה";
$GLOBALS['strZoneAppendType']			= "צרף סוג";
$GLOBALS['strZoneAppendHTMLCode']		= "קוד HTML";
$GLOBALS['strZoneAppendZoneSelection']	= "קופץ or צף";
$GLOBALS['strZoneAppendSelectZone']		= "צרף תמיד �?ת הקופץ �?ו הצף לב�?נרי�? המוצגי�? ב�?יזור זה";



// Zone probability
$GLOBALS['strZoneProbListChain']		= "כל הב�?נרי�? המקושרי�? ל�?יזור הנבחר �?ינ�? פעילי�? כעת.<br>זו שרשרת ה�?יזור שתעקוב:";
$GLOBALS['strZoneProbNullPri']			= "כל הב�?נרי�? המקושרי�? ל�?יזור זה �?ינ�? פעילי�?.";
$GLOBALS['strZoneProbListChainLoop']	= "מעקב �?חר שרשרת ה�?יזור תגרו�? ללו�?ה �?ינסופית. הפצה מ�?יזור זה נעצרה";



// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "�?נ�? בחר �?ת סוג הב�?נרי�? המקושרי�?";
$GLOBALS['strBannerSelection']			= "בחירה לפי ב�?נרי�?";
$GLOBALS['strCampaignSelection']		= "בחירה לפי קמפיין";
$GLOBALS['strInteractive']			= "ל�? פעיל";
$GLOBALS['strRawQueryString']			= "בחירה לפי מילת מפתח";
$GLOBALS['strIncludedBanners']			= "ב�?נרי�? מקושרי�?";
$GLOBALS['strLinkedBannersOverview']		= "סקירת ב�?נרי�? מקושרי�?";
$GLOBALS['strLinkedBannerHistory']		= "הסטורית ב�?נרי�? מקושרי�?";
$GLOBALS['strNoZonesToLink']			= "�?ין �?יזורי�? קבילי�? �?ליה�? ניתן לקשר ב�?נר זה.";
$GLOBALS['strNoBannersToLink']			= "�?ין כעת ב�?נרי�? הניתני�? לקישור ל�?זור זה.";
$GLOBALS['strNoLinkedBanners']			= "�?ין כעת ב�?נרי�? המקושרי�? ל�?זור זה";
$GLOBALS['strMatchingBanners']			= "{count} ב�?נרי�? תו�?מי�?";
$GLOBALS['strNoCampaignsToLink']		= "�?ין כעת מערכות פרסו�? הניתנות לקישור ל�?זור זה.";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "�?ין כעת �?זורי�? הניתני�? לקישור לקמפיין זה.";
$GLOBALS['strSelectBannerToLink']		= "בחר �?ת הב�?נר ש�?תה רוצה לקשר ל�?זור זה:";
$GLOBALS['strSelectCampaignToLink']		= "בחר �?ת המערכת הפרסו�? ש�?תה רוצה לקשר ל�?זור זה:";




// Statistics
$GLOBALS['strStats'] 				= "סטטיסטיקה";
$GLOBALS['strNoStats']				= "ל�? קיימת סטטיסטיקה עדיין.";
$GLOBALS['strConfirmResetStats']		= "ה�?�? ב�?מת �?תה רוצה למחוק �?ת כל הסטטיסטיקה?";
$GLOBALS['strGlobalHistory']			= "היסטוריה כללית";
$GLOBALS['strDailyHistory']			= "היסטוריה יומית";
$GLOBALS['strDailyStats'] 			= "סטטיסטיקה יומית";
$GLOBALS['strWeeklyHistory']			= "היסטוריה שבועית";
$GLOBALS['strMonthlyHistory']			= "היסטוריה חודשית";
$GLOBALS['strCreditStats'] 			= "סטטיסטיקת �?שר�?י";
$GLOBALS['strDetailStats'] 			= "סטטיסטיקה מפורטת";
$GLOBALS['strTotalThisPeriod']			= "סך הכל לתקופה זו";
$GLOBALS['strAverageThisPeriod']		= "ממוצע לתקופה זו";
$GLOBALS['strDistribution']			= "הפצה";
$GLOBALS['strResetStats'] 			= "�?פס סטטיסטיקה";
$GLOBALS['strSourceStats']			= "סטטיסטיקת מקור";
$GLOBALS['strSelectSource']			= "בחר �?ת המקור שברצונך לצפות בו:";
$GLOBALS['strSizeDistribution']		= "Distribution by size";
$GLOBALS['strCountryDistribution']	= "Distribution by country";
$GLOBALS['strEffectivity']			= "�?פקטיביות";
$GLOBALS['strTargetStats']			= "סטטיסטיקה מכוונת";
$GLOBALS['strCampaignTarget']		= "מטרה";
$GLOBALS['strTargetRatio']			= "יחס מטרה";
$GLOBALS['strTargetModifiedDay']	= "המטרות שונות במשך היו�?, מכ�?ן שהכוונה �?ינה מדויקת";
$GLOBALS['strTargetModifiedWeek']	= "המטרות שונו במשך השבוע, ההכוונה ל�? תיהיה מדויקת";
$GLOBALS['strTargetModifiedMonth']	= "המטרות שונו במהלך החודש, מכ�?ן שההכוונה ל�? תיהיה מדויקת";
$GLOBALS['strNoTargetStats']		= "�?י�? כרגע סטטיסטיקה �?ודות כיוון";




// Hosts
$GLOBALS['strHosts']				= "שרתי�?";
$GLOBALS['strTopTenHosts'] 			= "עשרת השרתי�? המתעניני�? ביותר";
$GLOBALS['strTopCountries'] 		= "ה�?רצות המובילות בביקוש";
$GLOBALS['strRecentHosts'] 			= "השרתי�? ה�?חרוני�? ביותר בביקוש";


// Expiration
$GLOBALS['strExpired']				= "פג תוקף";
$GLOBALS['strExpiration'] 			= "תפוגה";
$GLOBALS['strNoExpiration'] 			= "ל�? נקבע ת�?ריך תפוגה";
$GLOBALS['strEstimated'] 			= "תפוגה משוכרעת";


// Reports
$GLOBALS['strReports']				= "דוחות";
$GLOBALS['strSelectReport']			= "בחר �?ת הדוח שברצונך לחולל";


// Userlog
$GLOBALS['strUserLog']				= "יומן משתמש";
$GLOBALS['strUserLogDetails']			= "פרטי יומן משתמש";
$GLOBALS['strDeleteLog']			= "מחק יומן";
$GLOBALS['strAction']				= "פעולה";
$GLOBALS['strNoActionsLogged']			= "ל�? נרשמה שו�? פעולה";



// Code generation
$GLOBALS['strGenerateBannercode']		= "בחירה ישירה";
$GLOBALS['strChooseInvocationType']		= "נ�? לבחור בסוג קוד הקרי�?ה";
$GLOBALS['strGenerate']				= "ייצר קוד";
$GLOBALS['strParameters']			= "פרמטרי�?";
$GLOBALS['strFrameSize']			= "גודל מסגרת";
$GLOBALS['strBannercode']			= "קוד ב�?נר";
$GLOBALS['strOptional']				= "�?ופציה";


// Errors
$GLOBALS['strMySQLError'] 			= "SQL Error:";
$GLOBALS['strLogErrorClients'] 			= "[phpAds] An error occurred while trying to fetch the advertisers from the database.";
$GLOBALS['strLogErrorBanners'] 			= "[phpAds] An error occurred while trying to fetch the banners from the database.";
$GLOBALS['strLogErrorViews'] 			= "[phpAds] An error occurred while trying to fetch the adviews from the database.";
$GLOBALS['strLogErrorClicks'] 			= "[phpAds] An error occurred while trying to fetch the adclicks from the database.";
$GLOBALS['strErrorViews'] 			= "You must enter the number of views or select the unlimited box !";
$GLOBALS['strErrorNegViews'] 			= "Negative views are not allowed";
$GLOBALS['strErrorClicks'] 			= "You must enter the number of clicks or select the unlimited box !";
$GLOBALS['strErrorNegClicks'] 			= "Negative clicks are not allowed";
$GLOBALS['strNoMatchesFound']			= "No matches were found";
$GLOBALS['strErrorOccurred']			= "An error occurred";
$GLOBALS['strErrorUploadSecurity']		= "�?ובחנה �?פשרות לבעיית בטיחות, העל�?ה עוכבה!";
$GLOBALS['strErrorUploadBasedir']		= "�?ין גישה לקובץ שהועלה, כנר�?ה עקב מיצוב \"safemode\" �?ו הגבלות \"open_basedir\"";
$GLOBALS['strErrorUploadUnknown']		= "�?ין גישה לקובץ שהועלה,  עקב סיבה ל�? ידועה. �?נ�? בדוק �?ת קונפיגורציית ה-PHP";
$GLOBALS['strErrorStoreLocal']			= "�?רעה שגי�?ה בעת הנסיון לשמור �?ת הב�?נר בתיקייה המקומית. �?פשר שזה עקב קונפיגורציה שגויה של קביעות בתיב התיקייה.";
$GLOBALS['strErrorStoreFTP']			= "�?רעה שגי�?ה בעת נסיון להעלות �?ת הב�?נר לשרת FTP. �?פשר שהשרת ל�? זמין, �?ו קונפיגורציה שגויה של קביעות שרת ה-FTP";
$GLOBALS['strErrorDBPlain']				= "�?רעה שגי�?ה בגישה לבסיס הנתוני�?";
$GLOBALS['strErrorDBSerious']			= "�?רעה שגי�?ה חמורה בבסיס הנתוני�?";
$GLOBALS['strErrorDBNoDataPlain']		= "עקב בעיה בבבסיס הנתוני�? ".MAX_PRODUCT_NAME." ל�? יכלה להשיג מידע. ";
$GLOBALS['strErrorDBNoDataSerious']		= "עקב בעיה חמורה בבסיס הנתוני�?, ".MAX_PRODUCT_NAME." ל�? יכלה להשיג מידע.";
$GLOBALS['strErrorDBCorrupt']			= "טבל�?ות בסיס הנתוני�? כנר�?ה קרסו ודורשות תיקון. מידע נוסף בדבר תיקון טבל�?ות שקרסו ניתן למצו�? בפרק <i>Troubleshooting</i> של ה<i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']			= "�?נ�? צור קשר ע�? ה�?חר�?י של שרת זה והודיע לו לגבי הבעיה.";
$GLOBALS['strErrorDBSubmitBug']			= "�?�? הבעיה נשנית, �?פשר שמדובר בב�?ג ב-".MAX_PRODUCT_NAME.". �?נ�? דווח �?ת המידע הב�? ליוצרי�? של ".MAX_PRODUCT_NAME.". כמו כן נסה לת�?ר בצורה ברורה ככל ה�?פשר �?ת הפעולות שהובילו לקריסה זו.";
$GLOBALS['strMaintenanceNotActive']		= "תסריט התחזוקה ל�? רץ ב-24 השעות ה�?חרונות. \\nכדי ש".MAX_PRODUCT_NAME." תוכל לתפקד נכונה, הו�? צריך לרוץ\\nכל שעה. \\n\\n�?נ�? קר�? �?ת מדריך ה�?חר�?י (Administrator guide) למידע נוסף עבור\\nהגדרות התחזוקה.";




// E-mail
$GLOBALS['strMailSubject'] 			= "דוח מפרס�?";
$GLOBALS['strAdReportSent']			= "נשלח דוח מפרס�?";
$GLOBALS['strMailSubjectDeleted'] 		= "ב�?נרי�? שהושתקו";
$GLOBALS['strMailHeader'] 			= "{contact} היקר,\n";
$GLOBALS['strMailBannerStats'] 			= "בהמשך תמצ�? �?ת הסטטיסטיקה עבור הב�?נרי�? של {clientname}:";
$GLOBALS['strMailFooter'] 			= "ברגשי כבוד,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "הב�?נרי�? הב�?י�? נפסלו/שותקו עקב";
$GLOBALS['strMailNothingLeft'] 			= "�?�? �?תה רוצה להמשיך לפרס�? ב�?תר שלנו, �?נ�? צור עמנו קשר.\nנשמח לשמוע ממך.";
$GLOBALS['strClientDeactivated']		= "קמפיין זה �?ינו פעילה כעת משו�? ש";
$GLOBALS['strBeforeActivate']			= "ת�?ריך ההתחלה עדיין ל�? הגיעt";
$GLOBALS['strAfterExpire']			= "ת�?ריך התפוגה הגיע.";
$GLOBALS['strNoMoreClicks']			= "ל�? נותרו הקלקות";
$GLOBALS['strNoMoreViews']			= "ל�? נותרו חשיפות";
$GLOBALS['strWeightIsNull']			= "משקלו נקבע ל�?פס";
$GLOBALS['strWarnClientTxt']			= "כמות החשיפות �?ו הקלקות שנותרה לב�?נרי�? שלך מתחילה להגיע �?ל מתחת ל{limit}. \nהב�?נרי�? שלך יופסקו כ�?שר תושג כמות החשיפה �?ו ההקלקה.";
$GLOBALS['strViewsClicksLow']			= "מספר חשיפות/הקלקות נמוך";
$GLOBALS['strNoViewLoggedInInterval']   	= "ל�? נרשמו חשיפות ל�?ורך תקופת דוח זה.";
$GLOBALS['strNoClickLoggedInInterval']  	= "ל�? נרשמו הקלקות ל�?ורך תקופת דוח זה.";
$GLOBALS['strMailReportPeriod']			= "דוח זה כולל סטטיסטיקה מ{startdate} עד ל{enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "דוח זה כולל �?ת כל הסטטיסטיקה עד ל{enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "�?ין בנמצ�? סטטיסטיקה לקמפיין זה.";







// Priority
$GLOBALS['strPriority']				= "קדימויות";



// Settings
$GLOBALS['strSettings'] 			= "קביעות";
$GLOBALS['strGeneralSettings']			= "קביעות כלליות";
$GLOBALS['strMainSettings']			= "קביעות ר�?שיות";
$GLOBALS['strAdminSettings']			= "קביעות מנהלה";



// Product Updates
$GLOBALS['strProductUpdates']			= "עידכוני התוכנה";







/*-------------------------------------------------------*/
/* Keyboard shortcut assignments                         */
/*-------------------------------------------------------*/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']			= 'h';
$GLOBALS['keyUp']			= 'u';
$GLOBALS['keyNextItem']		= '.';
$GLOBALS['keyPreviousItem']	= ',';
$GLOBALS['keyList']			= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']		= 'ח';
$GLOBALS['keyCollapseAll']	= 'מ';
$GLOBALS['keyExpandAll']	= 'פ';
$GLOBALS['keyAddNew']		= 'ח';
$GLOBALS['keyNext']			= 'ב';
$GLOBALS['keyPrevious']		= 'ק';

?>