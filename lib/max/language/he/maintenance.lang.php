<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

// Main strings
$GLOBALS['strChooseSection']			= "בחר מחלקה";


// Priority
$GLOBALS['strRecalculatePriority']		= "שקלל קדימויות";
$GLOBALS['strHighPriorityCampaigns']		= "מערכות פרסום בקדימות גבוהה";
$GLOBALS['strAdViewsAssigned']			= "הוקצו חשיפות";
$GLOBALS['strLowPriorityCampaigns']		= "מערכות פרסום בקדימות נמוכה";
$GLOBALS['strPredictedAdViews']			= "חשיפות צפויות";
$GLOBALS['strPriorityDaysRunning']		= "קיימים כעת {days} ימים קבילים לסטטיסטיקה, היכן ש-phpAdsNew יכולה לבסס הערכה יומית. ";
$GLOBALS['strPriorityBasedLastWeek']		= "הערכה מבוססת על נתונים מהשבוע שעבר והנוכחי.  ";
$GLOBALS['strPriorityBasedLastDays']		= "הערכה מבוססת על נתונים מהימים האחרונים.  ";
$GLOBALS['strPriorityBasedYesterday']		= "הערכה מבוססת על נתונים מאתמול.  ";
$GLOBALS['strPriorityNoData']			= "אין מספיק נתונים כדי ליצור הערכה אמינה לגבי מספר החשיפות ששרת פרסומות זה יפיק היום. יישום קדימויות יתבסס על סטטיסטיקות בזמן אמת בלבד.  ";
$GLOBALS['strPriorityEnoughAdViews']		= "צריכה להיות חשיפה מספקת כדי לספק את מטרת מערכות הפרסום בקדימות גבוהה.  ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "לא ברור אם יהיו מספיק חשיפות היום כדי לספק את המטרה במערכות הפרסום בעלות הקדימות הגבוהה. עקב כך כל מערכות הפרסום בעלות קדימות נמוכה משותקות כעת זמנית. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "רענן זיכרון-מטמון באנרים";
$GLOBALS['strBannerCacheExplaination']		= "זיכרון-מטמון של הבאנרים מכיל כעת העתק של קוד HTML  המשמש לתצוגה של הבאנר. על ידי שימוש בזיכרון זה ניתן להאיץ את ההפצה של הבאנרים כי קוד ה-HTML לא דורש הפקה מחודשת בכל פעם שבאנר צריך להיחשף.<br /> מכיוון שזיכרון הבאנר כולל קוד מוטבע של ה-URLs למיקום ה-".$phpAds_productname." והבאנרים שלו, הזיכרון צריך להתעדכן בכל פעם שה-".$phpAds_productname." מועבר למיקום אחר על השרת. ";







// Cache
$GLOBALS['strCache']			= "זיכרון-מטמון תפוצה";
$GLOBALS['strAge']				= "גיל";
$GLOBALS['strRebuildDeliveryCache']			= "רענן זיכרון-מטמון תפוצה";
$GLOBALS['strDeliveryCacheExplaination']		= "
	זיכרון-מטמון תפוצה משמש להמהרת התפוצה של הבאנרים. המטמון כולל העתק של כל הבאנרים המקושרים לאיזור, מה שחוסך קריאות נוספות לבסיס הנתונים כאשר הבאנרים נקראים לתצוגה ממשית. המטמון מתחדש בכל פעם שחל שינוי לאיזור או לאחד מהבאנרים שבתוכו, ויש אפשרות שהוא ייהפך למיושן. מכאן שהוא נבנה מחדש כל שעה, אך ניתן להפעיל זאת גם ידנית.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
נעשה כעת שימוש בזכרון משותף	לאיחסון זכרון מטמון (cache).
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	בסיס הנתונים משמשמ בעת לאיחסון מטמון הפקת הבנארים (cache).
";
$GLOBALS['strDeliveryCacheFiles']		= "
מטמון הפקת הבנארים (cache) מאוחסן כעת על כמה קבצים בשרת שלך.
";





// Storage
$GLOBALS['strStorage']				= "איחסון";
$GLOBALS['strMoveToDirectory']			= "העבר את התמונות השמורות בתוך בסיס הנתונים אל תוך התיקייה.";
$GLOBALS['strStorageExplaination']		= "הבאנרים בשימוש מקומי מאוחסנים בתוך בסיס הנתונים או בתיקייה על השרת. אם אתה שומר את הבאנרים בתוך תיקייה יפחת העומס על בסיס הנתונים ואף המהירות תואץ. ";





// Storage
$GLOBALS['strStatisticsExplaination']		= " הפעלת תצורת <i>סטטיסטיקה קומפקטית</i>, אך הסטטיסטיקה הישנה שלך היא עדיין בתצורה טקסטואלית. האם אתה רוצה להמיר את הסטטיסטיקה המילולית לתצורה הקומפקטית? ";




// Product Updates
$GLOBALS['strSearchingUpdates']			= "מחפש עדכונים. אנא המתן...";
$GLOBALS['strAvailableUpdates']			= "עדכונים זמינים";
$GLOBALS['strDownloadZip']			= "הורד (.zip)";
$GLOBALS['strDownloadGZip']			= "הורד (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "גירסה חדשה של ".$phpAds_productname." יצאה לאור.                 \\n\\nהאם אתה רוצה מידע נוסף \\nאודות העדכון?";
$GLOBALS['strUpdateAlertSecurity']		= "גירסה חדשה של ".$phpAds_productname." יצאה לאור.                 \\n\\nמומלץ מאוד לעדכן \\nבהזדמנות הקרובה ביותר, כיוון שגירסה זו \\nמכילה תיקוניים בטיחוטיים.";

$GLOBALS['strUpdateServerDown']			= "מסיבה בלתי ידועה לא ניתן להשיג<br />מידע על עדכונים אפשריים. אנא נסה שוב מאוחר יותר.";

$GLOBALS['strNoNewVersionAvailable']		= "הגירסה שלך של ".$phpAds_productname." מעודכנת. אין כעת עידכונים חדשים";

$GLOBALS['strNewVersionAvailable']		= "<b>גירסה חדשה של ".$phpAds_productname."יצאה לאור.</b><br /> מומלץ להתקין גירסה זו, כיוון שהי  עשויה לתקן כמה בעיות קיימות ותוסיף תכונות חדשות. למידע נוסף אודות השדרוג אנא קרא את התיועד הכלול בקבצים מטה. ";

$GLOBALS['strSecurityUpdate']			= "<b>מומלץ ביותר להתקין את העדכון הזה בהקדם האפשרי, כיוון שהוא מכיל מספר תיקוני אבטחה.</b><br /> הגירסה של ".$phpAds_productname.", בה אתה משתמש כעת, אפשר שהיא פגיעה להתקפות מסוימות ואולי אינה מוגנת. למידע נוסף אודות העדכון אנא קרא את התיועד הכלול בקבצים מטה. ";



$GLOBALS['strNotAbleToCheck']			= "
	<b>כיוון שהרחבת ה-XML אינה קיימת על השרת שלך, ".$phpAds_productname." אינה יכולה לבדוק את יצאה גירסה חדשה.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	אתה מריץ כעת ".$phpAds_productname." ".$phpAds_version_readable.". 
	אם אתה רוצה לדעת האם קיימת גירסה חדשה, אנא בקר באתר שלנו.
";

$GLOBALS['strClickToVisitWebsite']		= "
	לחץ כאן כדי לבקר באתר שלנו";
$GLOBALS['strCurrentlyUsing'] 			= "אתה משתמש כעת";
$GLOBALS['strRunningOn']				= "רץ על";
$GLOBALS['strAndPlain']					= "ו";	

// Stats conversion
$GLOBALS['strConverting']			= "ממיר";
$GLOBALS['strConvertingStats']			= "ממיר סטטיסטיקה...";
$GLOBALS['strConvertStats']			= "המר סטטיסטיקה";
$GLOBALS['strConvertAdViews']			= "חשיפות הומרו,";
$GLOBALS['strConvertAdClicks']			= "הקלקות הומרו...";
$GLOBALS['strConvertNothing']			= "אין מה להמיר...";
$GLOBALS['strConvertFinished']			= "תם ונשלם...";

$GLOBALS['strConvertExplaination']		= "אתה משתמש כעת בתצורה הקומפקטית לשמירת סטטיסטיקה, אך<br /> נותרו סטטיסטיקות בתצורת מלל. כל עוד תצורות המלל אינן מומרות<br />לתצורה קומפקטית, לא ייעשה בהן שימוש בזמן צפיה בעמושים אלה.<br />לפני ההמרת הסטטיסטיקה, דאג לגיבוי של בסיס הנתונים!<br />האם אתה רוצה להמיר את הסטטיסטיקה הטקסטואלית לתצורה הקומפקטית החדשה?<br />";

$GLOBALS['strConvertingExplaination']		= "כל הסטטיסטיקה הטקסטואלית שנותרה מומרת כעת לתצורה קומפקטית.<br />תלוי בכמות החשיפות השמורה בתצורה הקושמת, זה יכול<br />לקחת כמה דקות. אנא המתן עד שתהליך ההמרה התסיים לפני שתעבור לעמודים אחרים.<br />למטה תוכל לראות יומן של כל השינויים שנעשו לבסיס הנתונים<br />. ";

$GLOBALS['strConvertFinishedExplaination']  	= "המרת הסטטיסטיקה הטקסטואלית שנותרה עברה בהצלחה<br /> והנתנוים צריכים להיות שמישים שוב. למטה תוכל לראות יומן של כל השינויים שנעשו בבסיס הנתונים.<br /> ";


?>