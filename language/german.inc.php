<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* Translations by Repsak (kasper@manson-valley.de)						*/
/*                 René Friedrich (rene.friedrich@web.de)				*/
/*				   silicon (silicon@ins.at)								*/
/*				                                                        */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

global $client;

// Set translation strings
$GLOBALS['strHome'] = "Home";
$GLOBALS['date_format'] = "%d.%m.%Y";
$GLOBALS['time_format'] = "%H:%i:%S";
$GLOBALS['strMySQLError'] = "MySQL-Fehler:";
$GLOBALS['strAdminstration'] = "Adminstration";
$GLOBALS['strAddClient'] = "Neuen Kunden hinzuf&uuml;gen";
$GLOBALS['strModifyClient'] = "Kunden-Daten &auml;ndern";
$GLOBALS['strDeleteClient'] = "Kunden l&ouml;schen";
$GLOBALS['strViewClientStats'] = "Kundenstatistik ansehen";
$GLOBALS['strClientName'] = "Kunde";
$GLOBALS['strContact'] = "Kontakt";
$GLOBALS['strEMail'] = "E-Mail";
$GLOBALS['strViews'] = "AdViews";
$GLOBALS['strClicks'] = "AdClicks";
$GLOBALS['strTotalViews'] = "Summe der AdViews";
$GLOBALS['strTotalClicks'] = "Summe der AdClicks";
$GLOBALS['strCTR'] = "Klickrate (CTR)";
$GLOBALS['strTotalClients'] = "Kunden insgesamt";
$GLOBALS['strActiveClients'] = "Aktive Kunden";
$GLOBALS['strActiveBanners'] = "Aktive Banner";
$GLOBALS['strLogout'] = "Logout";
$GLOBALS['strCreditStats'] = "Statistiken kreditieren";
$GLOBALS['strViewCredits'] = "AdView Guthaben";
$GLOBALS['strClickCredits'] = "AdClick Guthaben";
$GLOBALS['strPrevious'] = "Vorhergehender";
$GLOBALS['strNext'] = "N&auml;chster";
$GLOBALS['strNone'] = "Keiner";
$GLOBALS['strViewsPurchased'] = "Gekaufte AdViews";
$GLOBALS['strClicksPurchased'] = "Gekaufte AdClicks";
$GLOBALS['strDaysPurchased'] = "Gekaufte AdDays";
$GLOBALS['strHTML'] = "HTML";
$GLOBALS['strAddSep'] = "Bitte entweder die Felder oben oder das Feld unten ausf&uuml;llen!";
$GLOBALS['strTextBelow'] = "Bildunterschrift";
$GLOBALS['strSubmit'] = "Fertigstellen";
$GLOBALS['strUsername'] = "Benutzername";
$GLOBALS['strPassword'] = "Passwort";
$GLOBALS['strBannerAdmin'] = "Banner Adminstration f&uuml;r";
$GLOBALS['strBannerAdminAcl'] = "Banner ACL Adminstration f&uuml;r";
$GLOBALS['strNoBanners'] = "Keine Banner gefunden";
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strCurrentBanner'] = "Aktuelles Banner";
$GLOBALS['strDelete'] = "L&ouml;schen";
$GLOBALS['strAddBanner'] = "Neues Banner hinzuf&uuml;gen";
$GLOBALS['strModifyBanner'] = "Banner bearbeiten";
$GLOBALS['strModifyBannerAcl'] = "Banner ACL bearbeiten";
$GLOBALS['strURL'] = "Klick-URL (inkl. http://)";
$GLOBALS['strKeyword'] = "Schl&uuml;sselwort";
$GLOBALS['strWeight'] = "Gewicht";
$GLOBALS['strAlt'] = "Alt-Text";
$GLOBALS['strAccessDenied'] = "Zugriff verweigert";
$GLOBALS['strPasswordWrong'] = "Falsche Passworteingabe";
$GLOBALS['strNotAdmin'] = "Sie haben nicht die entsprechende Berechtigung.";
$GLOBALS['strClientAdded'] = "Der Benutzer wurde hinzugef&uuml;gt.";
$GLOBALS['strClientModified'] = "Der Benutzer wurde ge&auml;ndert.";
$GLOBALS['strClientDeleted'] = "Der Benutzer wurde gel&ouml;scht.";
$GLOBALS['strBannerAdmin'] = "Banner-Adminstration";
$GLOBALS['strBannerAdded'] = "Das Banner wurde hinzugef&uuml;gt.";
$GLOBALS['strBannerModified'] = "Das Banner wurde ge&auml;ndert";
$GLOBALS['strBannerDeleted'] = "Das Banner wurde gel&ouml;scht";
$GLOBALS['strBannerChanged'] = "Das Banner wurde ge&auml;ndert";
$GLOBALS['strStats'] = "Statistiken";
$GLOBALS['strDailyStats'] = "T&auml;gliche Statistik";
$GLOBALS['strDetailStats'] = "Detaillierte Statistik";
$GLOBALS['strCreditStats'] = "Statistiken kreditieren";
$GLOBALS['strActive'] = "aktiv";
$GLOBALS['strActivate'] = "Aktivieren";
$GLOBALS['strDeActivate'] = "Deaktivieren";
$GLOBALS['strAuthentification'] = "Authentifizierung";
$GLOBALS['strGo'] = "Ok";
$GLOBALS['strLinkedTo'] = "Klick-URL";
$GLOBALS['strBannerID'] = "Banner-ID";
$GLOBALS['strClientID'] = "Kunden-ID";
$GLOBALS['strMailSubject'] = "Banner-Report";
$GLOBALS['strMailSubjectDeleted'] = "Deaktiviertes Banner";
$GLOBALS['strMailHeader'] = "Guten Tag, ".$client["contact"].",\n\n";
$GLOBALS['strMailBannerStats'] = "Hiermit senden wir Ihnen die Banner-Statistik fuer ".$client["clientname"].":";
$GLOBALS['strMailFooter'] = "Mit freundlichen Gruessen\n\n   $phpAds_admin_fullname";
$GLOBALS['strLogMailSent'] = "[phpAds] Statistik erfolgreich verschickt.";
$GLOBALS['strLogErrorClients'] = "[phpAds] Beim Versuch, den Benutzer in der Datenbank zu finden, ist ein Fehler aufgetreten.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] Beim Versuch, die Banner in der Datenbank zu finden, ist ein Fehler aufgetreten.";
$GLOBALS['strLogErrorViews'] = "[phpAds] Beim Versuch, die AdViews in der Datenbank zu finden, ist ein Fehler aufgetreten.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] Beim Versuch, die AdClicks in der Datenbank zu finden, ist ein Fehler aufgetreten.";
$GLOBALS['strLogErrorDisactivate'] = "[phpAds] Beim Versuch ein Banner zu deaktivieren, ist ein Fehler aufgetreten.";
$GLOBALS['strRatio'] = "Klickrate";
$GLOBALS['strChooseBanner'] = "Bitte einen Bannertyp ausw&auml;hlen.";
$GLOBALS['strMySQLBanner'] = "Bild lokal verwalten";
$GLOBALS['strURLBanner'] = "Bild &uuml;ber URL verwalten";
$GLOBALS['strHTMLBanner'] = "HTML-Banner";
$GLOBALS['strNewBannerFile'] = "Bild-Datei";
$GLOBALS['strNewBannerURL'] = "Bild-URL (inkl. http://)";
$GLOBALS['strWidth'] = "Breite";
$GLOBALS['strHeight'] = "H&ouml;he";
$GLOBALS['strTotalViews7Days'] = "Summe der AdViews der letzten 7 Tage";
$GLOBALS['strTotalClicks7Days'] = "Summe der AdClicks der letzten 7 Tage";
$GLOBALS['strAvgViews7Days'] = "AdViews pro Tag (Durchschnitt der letzten 7 Tage)";
$GLOBALS['strAvgClicks7Days'] = "AdClicks pro Tag (Durchschnitt der letzten 7 Tage)";
$GLOBALS['strTopTenHosts'] = "Top 10 anfordernde IP-Adressen";
$GLOBALS['strConfirmDeleteClient'] = "Möchten Sie diesen Kunden wirklich löschen?";
$GLOBALS['strClientIP'] = "Kunden-IP";
$GLOBALS['strUserAgent'] = "RegExp f&uuml;r Browser";
$GLOBALS['strWeekDay'] = "Wochentag (0 - 6)";
$GLOBALS['strDomain'] = "Domain (ohne Punkt)";
$GLOBALS['strSource'] = "Quelle";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strAllow'] = "Erlauben";
$GLOBALS['strDeny'] = "Verweigern";
$GLOBALS['strResetStats'] = "Statistik zur&uuml;cksetzen";
$GLOBALS['strConfirmResetStats'] = "Wollen Sie wirklich die Statistik dieses Kunden zurücksetzen ?";
$GLOBALS['strExpiration'] = "Ablaufdatum";
$GLOBALS['strNoExpiration'] = "Kein Ablaufdatum festgesetzt";
$GLOBALS['strDaysLeft'] = "Verbleibende Tage";
$GLOBALS['strEstimated'] = "Gesch&auml;tztes Ablaufdatum";
$GLOBALS['strConfirm'] = "Sind Sie sicher?";
$GLOBALS['strBannerNoStats'] = "Keine Statistikdaten f&uuml;r diesen Banner gespeichert!";
$GLOBALS['strWeek'] = "Kalenderwoche";
$GLOBALS['strWeeklyStats'] = "Wochen&uuml;bersicht";
$GLOBALS['strWeekDay'] = "Wochentag";
$GLOBALS['strDate'] = "Datum";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strDayShortCuts'] = array("So","Mo","Di","Mi","Do","Fr","Sa");
$GLOBALS['strShowWeeks'] = "Anzahl der anzuzeigenden Wochen (max.)";
$GLOBALS['strAll'] = "Alle";
$GLOBALS['strAvg'] = "&Oslash;";
$GLOBALS['strHourly'] = "Tageszeitliche Verteilung der Zugriffe";
$GLOBALS['strTotal'] = "Gesamt";
$GLOBALS['strUnlimited'] = "Unbegrenzt";
$GLOBALS['strUp'] = "Vor";
$GLOBALS['strDown'] = "Zur&uuml;ck";
$GLOBALS['strSave'] = "Speichern";
$GLOBALS['strSaved'] = "wurde gespeichert";
$GLOBALS['strDeleted'] = "wurde gel&ouml;scht";
$GLOBALS['strMovedUp'] = "wurde vorgesetzt";
$GLOBALS['strMovedDown'] = "wurde zur&uuml;ckgesetzt";
$GLOBALS['strUpdated'] = "wurde ge&auml;ndert";
$GLOBALS['strACL'] = "Zugriffsregeln (ACL)";
$GLOBALS['strNoMoveUp'] = "Erste Zeile kann nicht vorgesetzt werden.";
$GLOBALS['strACLAdd'] = "Neue Regel hinzuf&uuml;gen:";
$GLOBALS['strACLExist'] = "Bestehende Regeln:";
$GLOBALS['strLogin'] = "Login";
$GLOBALS['strPreferences'] = "Einstellungen";
$GLOBALS['strAllowClientModifyInfo'] = "Kunde darf eigene Daten &auml;ndern";
$GLOBALS['strAllowClientModifyBanner'] = "Kunde darf eigene Banner &auml;ndern";
$GLOBALS['strAllowClientAddBanner'] = "Kunde darf eigene Banner hinzuf&uuml;gen";
$GLOBALS['strLanguage'] = "Sprache";
$GLOBALS['strDefault'] = "Voreinstellung";
$GLOBALS['strErrorViews'] = "Sie m&uuml;ssen eine Anzahl der AdViews angeben oder die Unbegrenzt-Checkbox aktivieren.";
$GLOBALS['strErrorNegViews'] = "Negative AdViews sind nicht erlaubt.";
$GLOBALS['strErrorClicks'] =  "Sie m&uuml;ssen eine Anzahl der AdClicks angeben oder die Unbegrenzt-Checkbox aktivieren.";
$GLOBALS['strErrorNegClicks'] = "Negative AdClicks sind nicht erlaubt.";
$GLOBALS['strErrorDays'] = "Sie m&uuml;ssen eine Anzahl der AdDays angeben oder die Unbegrenzt-Checkbox aktivieren.";
$GLOBALS['strErrorNegDays'] = "Negative AdDays sind nicht erlaubt !";
$GLOBALS['strTrackerImage'] = "Tracker-Bild:";

// New strings for version 2
$GLOBALS['strNavigation'] 			= "Navigation";
$GLOBALS['strShortcuts'] 				= "Shortcuts"; ### Don't know any translation for this, so I just leaved it - Repsak
$GLOBALS['strDescription'] 			= "Beschreibung";
$GLOBALS['strClients'] 				= "Kunden";
$GLOBALS['strID']				 		= "ID";
$GLOBALS['strOverall'] 				= "Gesamt";
$GLOBALS['strTotalBanners'] 			= "Banner insgesamt";
$GLOBALS['strToday'] 					= "Heute";
$GLOBALS['strThisWeek'] 				= "Diese Woche";
$GLOBALS['strThisMonth'] 				= "Diesen Monat";
$GLOBALS['strBasicInformation'] 		= "Allgemeine Informationen";
$GLOBALS['strContractInformation'] 	= "Vertrags-Informationen";
$GLOBALS['strLoginInformation'] 		= "Login-Informationen";
$GLOBALS['strPermissions'] 			= "Zugriffsrechte";
$GLOBALS['strGeneralSettings']		= "Allgemeine Einstellungen";
$GLOBALS['strSaveChanges']		 	= "&Auml;nderungen speichern";
$GLOBALS['strCompact']				= "Kompakt";
$GLOBALS['strVerbose']				= "Detailliert";
$GLOBALS['strOrderBy']				= "geordnet nach";
$GLOBALS['strShowAllBanners']	 		= "Alle Banner anzeigen";
$GLOBALS['strShowBannersNoAdClicks']	= "Banner ohne AdClicks anzeigen";
$GLOBALS['strShowBannersNoAdViews']	= "Banner ohne AdViews anzeigen";
$GLOBALS['strShowAllClients'] 		= "Alle Kunden anzeigen";
$GLOBALS['strShowClientsActive'] 		= "Kunden mit aktiven Banner anzeigen";
$GLOBALS['strShowClientsInactive']	= "Kunden mit inaktiven Banner anzeigen";
$GLOBALS['strSize']					= "Gr&ouml;&szlig;e";

$GLOBALS['strMonth'] 				= ("Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "July", "August", "September", "Oktober", "November", "Dezember");
$GLOBALS['strDontExpire']			= "Diesen Kunden nicht an einem Ablaufdatum deaktivieren";
$GLOBALS['strActivateNow'] 			= "Kunden sofort aktivieren";
$GLOBALS['strExpirationDate']		= "Ablaufdatum";
$GLOBALS['strActivationDate']		= "Aktivierungsdatum";

$GLOBALS['strMailClientDeactivated'] 	= "Ihr Banner wurden deaktiviert, weil";
$GLOBALS['strMailNothingLeft'] 			= "Sollten Sie weiterhin auf unserer Website Werbung schalten möchten, dann kontaktieren Sie uns. Wir freuen uns darauf wieder von Ihnen zu hören.";
$GLOBALS['strClientDeactivated']	= "Dieser Kunde ist zur Zeit nicht aktiviert, weil";
$GLOBALS['strBeforeActivate']		= "das Aktivierungsdatum noch nicht erreicht wurde";
$GLOBALS['strAfterExpire']			= "das Ablaufdatum erreicht wurde";
$GLOBALS['strNoMoreClicks']			= "die Zahl der gekauften AdClicks erreicht wurde";
$GLOBALS['strNoMoreViews']			= "die Zahl der gekauften AdViews erreicht wurde";
?>