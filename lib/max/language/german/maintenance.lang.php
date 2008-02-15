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

// German
// Main strings
$GLOBALS['strChooseSection']			= "Auswahlbereich";


// Priority
$GLOBALS['strRecalculatePriority']		= "Rekalkulieren der Priorit&auml;ten";
$GLOBALS['strHighPriorityCampaigns']		= "Kampagnen mit hoher Priorit&auml;t";
$GLOBALS['strAdViewsAssigned']		= "Festgelegte AdViews";
$GLOBALS['strLowPriorityCampaigns']		= " Kampagnen mit geringer Priorit&auml;t ";
$GLOBALS['strPredictedAdViews']		= "Prognostizierte AdViews";
$GLOBALS['strPriorityDaysRunning']		= "Die Prognose f&uuml;r die t&auml;gliche Bannerauslieferung basiert auf Statistiken von {days} Tagen. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Die Prognose basiert auf den Daten dieser und der vergangenen Woche. ";
$GLOBALS['strPriorityBasedLastDays']		= "Die Prognose basiert auf den Daten der letzten Tage. ";
$GLOBALS['strPriorityBasedYesterday']		= "Die Prognose basiert auf den Daten von gestern. ";
$GLOBALS['strPriorityNoData']			= "F&uuml;r eine zuverl&auml;ssige Prognose &uuml;ber die heute m&ouml;gliche Anzahl von AdViews stehen nicht ausreichend Daten zur Verf&uuml;gung. Die Festlegung der Priorit&auml;ten wird daher nur auf in Echtzeit erstellte Statistiken gest&uuml;tzt sein. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Es werden ausreichend AdViews zur Verf&uuml;gung stehen, um die Kampagnen mit hoher Priorit&auml;t bedienen zu k&ouml;nnen. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Es ist ungewi&szlig;, ob ausreichend AdViews zur Verf&uuml;gung stehen werden, um die Anforderungen durch Kampagnen mit hoher Priorit&auml;t befriedigen zu k&ouml;nnen.";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Bannercache erneuern";
$GLOBALS['strBannerCacheExplaination']		= "
	Im Bannercache werden Kopien der HTML-Codes, die f&uuml;r die Bannerdarstellung notwendig sind, vorgehalten. Durch den Bannercache wird die Auslieferung beschleunigt,
	denn der HTML-Code mu&szlig; nicht bei jeder Auslieferung neu generiert werden. Weil im
Bannercache die URL als Direktadressierung, verkn&uuml;pft mit dem Standort von ".$phpAds_productname." nebst dem Banner vorliegt, mu&szlig; der Bannercache aktualisiert werden, wenn sein
	Standort verschoben wird.";


// Cache
$GLOBALS['strCache']			= "Cache f&uuml;r Bannerauslieferung";
$GLOBALS['strAge']				= "Alter";
$GLOBALS['strRebuildDeliveryCache']			= "Cache wird erneuert";
$GLOBALS['strDeliveryCacheExplaination']		= "
	Der Cache f&uuml;r die Bannerauslieferung wird zur Beschleunigung der Bannerauslieferung ben&ouml;tigt. Im Cache sind Kopien von jedem Banner, der mit der Zone verbunden (verlinkt) ist. Dadurch, das die aktuellen Banner im Cache vorgehalten sind,  wird eine Reihe von Datenbankabfragen gespart. Der Cache wird jedesmal bei &Auml;nderungen der Zone oder dem verkn&uuml;pften Banner erneuert. Um dennoch einer &Uuml;beralterung vorzubeugen, wird der Cache st&uuml;ndlich automatisch erneuert. Der Vorgang kann zus&auml;tzlich manuell angesto&szlig;en werden.";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Der gemeinsam genutzte Speicher wird vom Cache f&uuml;r Bannerauslieferung benutzt.";
$GLOBALS['strDeliveryCacheDatabase']		= "
	Die Datenbank wird zur Zeit vom Cache f&uuml;r Bannerauslieferung benutzt.";
$GLOBALS['strDeliveryCacheFiles']		= "
	Der Cache f&uuml;r Bannerauslieferung wird zur Zeit in mehrere Dateien gespeichert.";


// Storage
$GLOBALS['strStorage']				= "Speicher";
$GLOBALS['strMoveToDirectory']		= "Bilder aus der Datenbank in ein Verzeichnis verschieben ";
$GLOBALS['strStorageExplaination']		= "
	Bilddateien f&uuml;r lokale Banner werden in der Datenbank oder in einem lokalen Verzeichnis gespeichert.
	Das Speichern in einem lokalen Verzeichnis anstelle in der Datenbank vermindert die Ladezeit.";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Sie haben als Darstellung <i>kompakte Statistiken</i> gew&auml;hlt, &auml;ltere Statistiken sind im detaillierten Format.
	Sollen diese (&auml;lteren) detaillierten Statistiken in das kompakte Format konvertiert werden?";


// Product Updates
$GLOBALS['strSearchingUpdates']		= "Suche nach neuen Updates. Bitte warten...";
$GLOBALS['strAvailableUpdates']			= "Vorhandene Updates";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']		= "Eine neue Version von ".$phpAds_productname." ist verf&uuml;gbar.                 \\n\\nWerden weitere Informationen dazu gew&uuml;nscht?";
$GLOBALS['strUpdateAlertSecurity']	= "Eine neue Version von ".$phpAds_productname." ist verf&uuml;gbar.                 \\n\\n
Eine kurzfristige Aktualisierung  Ihres Systems \\n
wird empfohlen, da in der neuen Version eine oder \\n
mehrere Sicherheitselemente &uuml;berarbeitet wurden.";

$GLOBALS['strUpdateServerDown']			= "
    Aus unbekannten Gr&uuml;nden ist es nicht m&ouml;glich, nach Informationen <br />
	zu neuen Updates zu pr&uuml;fen. Versuchen Sie es sp&auml;ter noch einmal.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Ihre Version von ".$phpAds_productname." ist aktuell. Ein Update ist nicht erforderlich.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Eine neue Version von ".$phpAds_productname." ist verf&uuml;gbar.</b><br />
	Eine Aktualisierung wird empfohlen, da einige vorhandenen Probleme behoben und neue Leistungsmerkmale integriert wurden. Weitergehende Information finden sich in der beigef&uuml;gten Dokumentation.";

$GLOBALS['strSecurityUpdate']			= "
	<b>Die schnellstm&ouml;gliche Durchf&uuml;hrung des Updates wird empfohlen, da eine Reihe von Sicherheitsproblemen behoben wurden.</b>
Ihre Version von ".$phpAds_productname." ist gegen illegale Angriffe m&ouml;glicherweise nicht ausreichend gesichert. Weitergehende Information finden sich in der beigef&uuml;gten Dokumentation.";


$GLOBALS['strNotAbleToCheck']			= "
	Auf Ihrem Server ist die XML-Erweiterung nicht verf&uuml;gbar. ".$phpAds_productname." kann nicht pr&uuml;fen, ob eine neuere Version vorliegt.";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	Informationen &uuml;ber neue Versionen befinden sich auf unserer Webseite.";

$GLOBALS['strClickToVisitWebsite']		= "	Zu unserer Webseite ";

$GLOBALS['strCurrentlyUsing'] 			= "Sie nutzen derzeit";
$GLOBALS['strRunningOn']				= "laufend auf";
$GLOBALS['strAndPlain']				= "und";



// Stats conversion
$GLOBALS['strConverting']			= "Konvertierung";
$GLOBALS['strConvertingStats']			= "Statistiken werden konvertiert...";
$GLOBALS['strConvertStats']			= "Statistiken konvertieren";
$GLOBALS['strConvertAdViews']			= "AdViews sind konvertiert,";
$GLOBALS['strConvertAdClicks']			= "AdClicks sind konvertiert...";
$GLOBALS['strConvertAdConversions']			= "AdConversions werden konvertiert...";
$GLOBALS['strConvertNothing']			= "Nichts zu konvertieren...";
$GLOBALS['strConvertFinished']			= "Fertig...";


$GLOBALS['strConvertExplaination']		= "
	F&uuml;r die statistische Auswertung verwenden Sie kompakte Darstellung. Es liegen <br />
	noch &auml;ltere Statistiken in detailliertem Format vor. Solange diese detaillierten Statistiken <br />
	nicht in das kompakte Format konvertiert sind, k&ouml;nnen sie auf dieser Seite nicht angezeigt<br />
	werden. Eine Sicherung der Datenbank vor dem Konvertierungslauf wird empfohlen!  <br />
	Wollen Sie die detaillierten Statistiken in das kompakte Format umwandeln? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Alle verbliebene Statistiken im detaillierten Format werden in das kompakte umgewandelt. <br />
	Die Dauer des Vorganges ist abh&auml;ngig von der Anzahl protokollierten Vorg&auml;nge. Es kann <br />
	einige Minuten dauern. Bitte warten Sie bis zum Ende des Konvertierungslauf, bevor Sie <br />
	andere Seiten aufrufen. Unten wird ein Protokoll der vorgenommenen Datenbankmodifikationen angezeigt. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Der Konvertierungslauf war erfolgreich.  Die Daten stehen nun wieder zur
	Verf&uuml;gung. Nachfolgend ist ein Protokoll aller vorgenommenen Datenbankmodifikationen.<br />
";

?>
