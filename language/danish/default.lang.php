<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This file contributed by Lars Petersen (lp@coder.dk) and             */
/*                          Søren Eskildsen (benzon@fald.dk)            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft']  = "left";


// Set translation strings
$GLOBALS['strHome'] = "Hjem";
$GLOBALS['date_format'] = "%d/%m-%Y";
$GLOBALS['time_format'] = "%H:%i:%S";
$GLOBALS['strMySQLError'] = "MySQL-fejl:";
$GLOBALS['strAdminstration'] = "Administration";
$GLOBALS['strAddClient'] = "Tilføj ny klient";
$GLOBALS['strModifyClient'] = "Ret klient";
$GLOBALS['strDeleteClient'] = "Slet klient";
$GLOBALS['strViewClientStats'] = "Vis klients statistik";
$GLOBALS['strClientName'] = "Klient";
$GLOBALS['strContact'] = "Kontakt";
$GLOBALS['strEMail'] = "EMail";
$GLOBALS['strViews'] = "Visninger";
$GLOBALS['strClicks'] = "Klik";
$GLOBALS['strTotalViews'] = "Totale visninger";
$GLOBALS['strTotalClicks'] = "Totale klik";
$GLOBALS['strCTR'] = "Click-Through Ratio";
$GLOBALS['strTotalClients'] = "Totale klienter";
$GLOBALS['strActiveClients'] = "Aktive klienter";
$GLOBALS['strActiveBanners'] = "Aktive bannere";
$GLOBALS['strLogout'] = "Log ud";
$GLOBALS['strCreditStats'] = "Kredit Stats";
$GLOBALS['strViewCredits'] = "Visnings kredit";
$GLOBALS['strClickCredits'] = "Klik kredit";
$GLOBALS['strPrevious'] = "Forrige";
$GLOBALS['strNext'] = "Næste";
$GLOBALS['strNone'] = "Ingen";
$GLOBALS['strViewsPurchased'] = "Visninger købt";
$GLOBALS['strClicksPurchased'] = "Klik købt";
$GLOBALS['strDaysPurchased'] = "Bannerdage købt";
$GLOBALS['strHTML'] = "HTML";
$GLOBALS['strAddSep'] = "Udfyld ENTEN feltet over ELLER feltet under!";
$GLOBALS['strTextBelow'] = "Tekst under billede";
$GLOBALS['strSubmit'] = "Gem banner";
$GLOBALS['strUsername'] = "Brugernavn";
$GLOBALS['strPassword'] = "Adgangskode";
$GLOBALS['strBannerAdmin'] = "Banner administration for";
$GLOBALS['strNoBanners'] = "Ingen bannere fundet";
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strCurrentBanner'] = "Aktuelle banner";
$GLOBALS['strDelete'] = "Slet";
$GLOBALS['strAddBanner'] = "Tilføj nyt banner";
$GLOBALS['strModifyBanner'] = "Ret banner";
$GLOBALS['strURL'] = "Link til URL (inkl. http://)";
$GLOBALS['strKeyword'] = "Nøgleord";
$GLOBALS['strWeight'] = "Vægt";
$GLOBALS['strAlt'] = "Alt-Tekst";
$GLOBALS['strAccessDenied'] = "Adgang nægtet";
$GLOBALS['strPasswordWrong'] = "Kodeordet er forkert";
$GLOBALS['strNotAdmin'] = "Du har ikke de rigtige rettigheder";
$GLOBALS['strClientAdded'] = "Klienten er tilføjet.";
$GLOBALS['strClientModified'] = "Klienten er rettet.";
$GLOBALS['strClientDeleted'] = "Klienten er slettet.";
$GLOBALS['strBannerAdmin'] = "Banner Administration";
$GLOBALS['strBannerAdded'] = "Banneret er tilføjet.";
$GLOBALS['strBannerModified'] = "Banneret er rettet.";
$GLOBALS['strBannerDeleted'] = "Banneret er slettet";
$GLOBALS['strBannerChanged'] = "Banneret er rettet";
$GLOBALS['strStats'] = "Statistik";
$GLOBALS['strDailyStats'] = "Daglig statistik";
$GLOBALS['strDetailStats'] = "Detaljeret statistik";
$GLOBALS['strCreditStats'] = "Kredit statistik";
$GLOBALS['strActive'] = "aktiv";
$GLOBALS['strActivate'] = "Aktivér";
$GLOBALS['strDeActivate'] = "Deaktivér";
$GLOBALS['strAuthentification'] = "Adgangskontrol";
$GLOBALS['strGo'] = "Videre";
$GLOBALS['strLinkedTo'] = "linker til";
$GLOBALS['strBannerID'] = "Banner-ID";
$GLOBALS['strClientID'] = "Klient ID";
$GLOBALS['strMailSubject'] = "Banner Rapport";
$GLOBALS['strMailSubjectDeleted'] = "Deaktiverede Bannere";
$GLOBALS['strMailHeader'] = "Kære {contact},\n";
$GLOBALS['strMailBannerStats'] = "Herunder finder du banner statistikken for {clientname}:";
$GLOBALS['strMailFooter'] = "Med venlig hilsen,\n   {adminfullname}";
$GLOBALS['strLogMailSent'] = "[phpAds] Statistik sendt.";
$GLOBALS['strLogErrorClients'] = "[phpAds] En fejl opstod ved hentning af klienterne fra databasen.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] En fejl opstod ved hentning af bannere fra databasen.";
$GLOBALS['strLogErrorViews'] = "[phpAds] En fejl opstod ved hentning af bannervisninger fra databasen.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] En fejl opstod ved hentning af bannerklik fra databasen.";
$GLOBALS['strLogErrorDisactivate'] = "[phpAds] En fejl opstod ved deaktiveringen af et banner.";
$GLOBALS['strRatio'] = "Click-Through Ratio";
$GLOBALS['strChooseBanner'] = "Vælg venligst en bannertype.";
$GLOBALS['strMySQLBanner'] = "Banner gemt i databasen";
$GLOBALS['strWebBanner'] = "Banner gemt på webserveren";
$GLOBALS['strURLBanner'] = "Banner refereres fra en URL";
$GLOBALS['strHTMLBanner'] = "HTML banner";
$GLOBALS['strNewBannerFile'] = "Ny banner fil";
$GLOBALS['strNewBannerURL'] = "Ny banner URL (inkl. http://)";
$GLOBALS['strWidth'] = "Bredde";
$GLOBALS['strHeight'] = "Højde";
$GLOBALS['strTotalViews7Days'] = "Totale visninger de sidste 7 dage";
$GLOBALS['strTotalClicks7Days'] = "Totale klik de sidste 7 dage";
$GLOBALS['strAvgViews7Days'] = "Gennemsnitlige visninger de sidste 7 dage";
$GLOBALS['strAvgClicks7Days'] = "Gennemsnitlige klik de sidste 7 dage";
$GLOBALS['strTopTenHosts'] = "Top 10 referencer";
$GLOBALS['strClientIP'] = "Klient IP";
$GLOBALS['strUserAgent'] = "User agent regexp";
$GLOBALS['strWeekDay'] = "Ugedag (0 - 6)";
$GLOBALS['strDomain'] = "Domæne (ekskl. punktum)";
$GLOBALS['strSource'] = "Kilde";
$GLOBALS['strTime'] = "Tid";
$GLOBALS['strAllow'] = "Tillad";
$GLOBALS['strDeny'] = "Nægt";
$GLOBALS['strResetStats'] = "Nulstil statistik";
$GLOBALS['strExpiration'] = "Udløber";
$GLOBALS['strNoExpiration'] = "Ingen udløbsdato sat";
$GLOBALS['strDaysLeft'] = "Dage tilbage";
$GLOBALS['strEstimated'] = "Estimeret udløbsdato";
$GLOBALS['strConfirm'] = "Er du sikker ?";
$GLOBALS['strBannerNoStats'] = "Ingen statistik er tilgængelig for dette banner!";
$GLOBALS['strWeek'] = "Uge";
$GLOBALS['strWeeklyStats'] = "Ugentlig statistik";
$GLOBALS['strWeekDay'] = "Ugedag";
$GLOBALS['strDate'] = "Dato";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strDayShortCuts'] = array("Sø","Ma","Ti","On","To","Fr","Lø");
$GLOBALS['strShowWeeks'] = "Max. uger at vise";
$GLOBALS['strAll'] = "alle";
$GLOBALS['strAvg'] = "Gennemsnit";
$GLOBALS['strHourly'] = "Visninger/klik pr. time";
$GLOBALS['strTotal'] = "Total";
$GLOBALS['strUnlimited'] = "Uendelig";
$GLOBALS['strSave'] = "Gem";
$GLOBALS['strUp'] = "Op";
$GLOBALS['strDown'] = "Ned";
$GLOBALS['strSaved'] = "var gemt!";
$GLOBALS['strDeleted'] = "var slettet!";
$GLOBALS['strMovedUp'] = "blev flyttet op";
$GLOBALS['strMovedDown'] = "blev flyttet ned";
$GLOBALS['strUpdated'] = "blev opdateret";
$GLOBALS['strLogin'] = "Log ind";
$GLOBALS['strPreferences'] = "Præferencer";
$GLOBALS['strAllowClientModifyInfo'] = "Tillad denne bruger at rette i sin egen klientinformation";
$GLOBALS['strAllowClientModifyBanner'] = "Tillad denne bruger at rette i sine egne bannere";
$GLOBALS['strAllowClientAddBanner'] = "Tillad denne bruger at tilføje egne bannere";
$GLOBALS['strLanguage'] = "Sprog";
$GLOBALS['strDefault'] = "Standard";
$GLOBALS['strErrorViews'] = "Du skal indtaste antallet af visninger eller vælge uendelig !";
$GLOBALS['strErrorNegViews'] = "Negative visninger er ikke tilladt";
$GLOBALS['strErrorClicks'] =  "Du skal indtaste antallet af klik eller vælge uendelig !";
$GLOBALS['strErrorNegClicks'] = "Negative klik er ikke tilladt";
$GLOBALS['strErrorDays'] = "Du skal indtaste antallet af dage eller vælge uendeligt !";
$GLOBALS['strErrorNegDays'] = "Negative dage er ikke tilladt";
$GLOBALS['strTrackerImage'] = "Tracker billede:";

// New strings for version 2
$GLOBALS['strNavigation'] 				= "Navigation";
$GLOBALS['strShortcuts'] 				= "Genveje";
$GLOBALS['strDescription'] 				= "Beskrivelse";
$GLOBALS['strClients'] 					= "Klienter";
$GLOBALS['strID']				 		= "ID";
$GLOBALS['strOverall'] 					= "I alt";
$GLOBALS['strTotalBanners'] 			= "Totale bannere";
$GLOBALS['strToday'] 					= "I dag";
$GLOBALS['strThisWeek'] 				= "Denne uge";
$GLOBALS['strThisMonth'] 				= "Denne måned";
$GLOBALS['strBasicInformation'] 		= "Grundlæggende information";
$GLOBALS['strContractInformation'] 		= "Kontrakt information";
$GLOBALS['strLoginInformation'] 		= "Log ind information";
$GLOBALS['strPermissions'] 				= "Tilladelser";
$GLOBALS['strGeneralSettings']			= "Generelle indstillinger";
$GLOBALS['strSaveChanges']		 		= "Gem ændringer";
$GLOBALS['strCompact']					= "Kompakt";
$GLOBALS['strVerbose']					= "Detaljeret";
$GLOBALS['strOrderBy']					= "sortér efter";
$GLOBALS['strShowAllBanners']	 		= "Vis alle bannere";
$GLOBALS['strShowBannersNoAdClicks']	= "Vis bannere uden klik";
$GLOBALS['strShowBannersNoAdViews']		= "Vis bannere uden visninger";
$GLOBALS['strShowAllClients'] 			= "Vis alle klienter";
$GLOBALS['strShowClientsActive'] 		= "Vis klienter med aktive bannere";
$GLOBALS['strShowClientsInactive']		= "Vis klienter med inaktive bannere";
$GLOBALS['strSize']						= "Størrelse";

$GLOBALS['strMonth'] 					= array("Januar","Februar","Marts","April","Maj","Juni","Juli", "August", "September", "Oktober", "November", "December");
$GLOBALS['strDontExpire']				= "Lad ikke denne kampagne udløbe på en specifik dag";
$GLOBALS['strActivateNow'] 				= "Aktivér denne kampagne med det samme";
$GLOBALS['strExpirationDate']			= "Udløbsdato";
$GLOBALS['strActivationDate']			= "Aktiveringsdato";

$GLOBALS['strMailClientDeactivated'] 	= "De følgende bannere er blevet deaktiveret fordi";
$GLOBALS['strMailNothingLeft'] 			= "Hvis du vil blive ved med at have reklamer på vores website, skal du være velkommen til at kontakte os.\nVi vil være glade for at høre fra dig.";
$GLOBALS['strClientDeactivated']		= "Kampagnen er ikke aktiv fordi";
$GLOBALS['strBeforeActivate']			= "aktiveringsdatoen er ikke nået";
$GLOBALS['strAfterExpire']				= "udløbsdatoen er nået";
$GLOBALS['strNoMoreClicks']				= "antallet er købte bannerklik er nået";
$GLOBALS['strNoMoreViews']				= "antallet af bannervisninger er nået";

$GLOBALS['strBanners'] 					= "Bannere";
$GLOBALS['strCampaigns']				= "Kampagner";
$GLOBALS['strCampaign']					= "Kampagne";
$GLOBALS['strModifyCampaign']			= "Ret kampagne";
$GLOBALS['strName']						= "Navn";
$GLOBALS['strBannersWithoutCampaign']	= "Bannere uden kampagne";
$GLOBALS['strMoveToNewCampaign']		= "Flyt til ny kampagne";
$GLOBALS['strCreateNewCampaign']		= "Lav ny kampagne";
$GLOBALS['strEditCampaign']				= "Ret kampagne";
$GLOBALS['strEdit']						= "Ret";
$GLOBALS['strCreate']					= "Lav";
$GLOBALS['strUntitled']					= "Ikke navngivet";

$GLOBALS['strTotalCampaigns'] 			= "Totale kampagner";
$GLOBALS['strActiveCampaigns'] 			= "Aktive kampagner";

$GLOBALS['strLinkedTo']					= "linker til";
$GLOBALS['strSendAdvertisingReport']	= "Send banner rapport via e-mail";
$GLOBALS['strNoDaysBetweenReports']		= "Antal dage mellem rapporter";
$GLOBALS['strSendDeactivationWarning']  = "Send advarsel når en kampagne er deaktiveret";

$GLOBALS['strWarnClientTxt']			= "Antallet af bannerklik eller -visninger der er tilbage for dine bannere er ved at være under {limit}. \nDine bannere vil blive deaktiveret når der ikke er flere klik eller visninger tilbage.";
$GLOBALS['strViewsClicksLow']			= "Antallet af Bannervisninger/-klik er lavt";

$GLOBALS['strDays']						= "Dage";
$GLOBALS['strHistory']					= "Historie";
$GLOBALS['strAverage']					= "Gennemsnit";
$GLOBALS['strDuplicateClientName']		= "Brugernavnet du angav eksisterer allerede, angiv et andet.";
$GLOBALS['strAllowClientDisableBanner'] = "Tillad denne bruger at deaktivere sine egne bannere";
$GLOBALS['strAllowClientActivateBanner'] = "Tillad denne bruger at aktivere sine egne bannere";

$GLOBALS['strGenerateBannercode']		= "Generér bannerkode";
$GLOBALS['strChooseInvocationType']		= "Vælg typen af bannerkald";
$GLOBALS['strGenerate']					= "Generér";
$GLOBALS['strParameters']				= "Parametre";
$GLOBALS['strUniqueidentifier']			= "Unik ID";
$GLOBALS['strFrameSize']				= "Rammestørrelse";
$GLOBALS['strBannercode']				= "Bannerkode";

$GLOBALS['strSearch']					= "Søg";
$GLOBALS['strNoMatchesFound']			= "Der blev ikke fundet noget på denne søgning";

$GLOBALS['strNoViewLoggedInInterval']   = "Der er ingen visninger i denne periode for denne rapport";
$GLOBALS['strNoClickLoggedInInterval']  = "Der er ingen klik i denne periode for denne rapport";
$GLOBALS['strMailReportPeriod']			= "Denne rapport indeholder statestikker for {startdate} ind til {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "Denne rapport indeholder alle statestikker ind til {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "Der er ingen statestik for denne Kampange";
$GLOBALS['strFrom']						= "Fra";
$GLOBALS['strTo']						= "til";
$GLOBALS['strMaintenance']				= "Vedligeholdelse";
$GLOBALS['strCampaignStats']			= "Kampange statistik";
$GLOBALS['strClientStats']				= "Klient statistik";
$GLOBALS['strErrorOccurred']			= "Der skete en fejl";
$GLOBALS['strAdReportSent']				= "Banner rapport sendt";

$GLOBALS['strAutoChangeHTML']			= "Skift HTML for at logge klik";

$GLOBALS['strZones']					= "Zoner";
$GLOBALS['strAddZone']					= "Opret zone";
$GLOBALS['strModifyZone']				= "Ændre zone";
$GLOBALS['strAddNewZone']				= "Opret ny Zone";

$GLOBALS['strOverview']					= "Overskue";
$GLOBALS['strEqualTo']					= "er ligmed";
$GLOBALS['strDifferentFrom']			= "er forskælig fra";
$GLOBALS['strAND']						= "OG";  // logical operator
$GLOBALS['strOR']						= "ELLER"; // logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Vis kun banner når:";

$GLOBALS['strStatusText']				= "Status Tekst";

$GLOBALS['strConfirmDeleteClient'] 		= "Vil du virkelig slette denne klient?";
$GLOBALS['strConfirmDeleteCampaign']	= "Vil du virkelig slette denne kampagne?";
$GLOBALS['strConfirmDeleteBanner']		= "Vil du virkelig slette dette banner?";
$GLOBALS['strConfirmDeleteZone']		= "Do you really want to delete this zone?";
$GLOBALS['strConfirmDeleteAffiliate']	= "Do you really want to delete this affiliate?";

$GLOBALS['strConfirmResetStats']		= "Vil du virkelig nulstille alle statistikker?";
$GLOBALS['strConfirmResetCampaignStats']= "Vil du virkelig nulstille statistikken for denne kampagne?";
$GLOBALS['strConfirmResetClientStats']	= "Er du sikker på at du vil nulstille statistikken for denne klient?";
$GLOBALS['strConfirmResetBannerStats']	= "Er du sikker på at du vil nulstille statistikken for dette banner?";

$GLOBALS['strClientsAndCampaigns']		= "Klienter & Kampanger";
$GLOBALS['strCampaignOverview']			= "Kampange overview";
$GLOBALS['strReports']					= "Rapporter";
$GLOBALS['strShowBanner']				= "Vis banner";

$GLOBALS['strIncludedBanners']			= "Linkede bannere";
$GLOBALS['strProbability']				= "Sandsynlighed";
$GLOBALS['strInvocationcode']			= "Kaldekode";
$GLOBALS['strSelectZoneType']			= "Vær venlig af vælge vilke type linkning af bannere";
$GLOBALS['strBannerSelection']			= "Banner valg";
$GLOBALS['strInteractive']				= "Interaktiv";
$GLOBALS['strRawQueryString']			= "Rå querystring";

$GLOBALS['strBannerWeight']				= "Banner vægt";
$GLOBALS['strCampaignWeight']			= "Kampange vægt";

$GLOBALS['strZoneCacheOn']				= "Zone caching er tændt";
$GLOBALS['strZoneCacheOff']				= "Zone caching er slukket";
$GLOBALS['strCachedZones']				= "Cachede zoner";
$GLOBALS['strSizeOfCache']				= "Størelse på cache";
$GLOBALS['strAverageAge']				= "Gennemsnits alder";
$GLOBALS['strRebuildZoneCache']			= "Genopbyg zone cache";
$GLOBALS['strKiloByte']					= "KB";
$GLOBALS['strSeconds']					= "Sekunder";
$GLOBALS['strExpired']					= "Udløbet";

$GLOBALS['strModifyBannerAcl'] 			= "Vis begrænsninger";
$GLOBALS['strACL'] 						= "Begrænsning";
$GLOBALS['strNoMoveUp'] 				= "Kan ikke flytte først række op";
$GLOBALS['strACLAdd'] 					= "Tilføj ny begrænsning";
$GLOBALS['strNoLimitations']			= "Ingen begrænsninger";

$GLOBALS['strLinkedZones']				= "Linkede Zoner";
$GLOBALS['strNoZonesToLink']			= "Der er ingen zoner til rådighed som dette banner kan linkes til";
$GLOBALS['strNoZones']					= "There are currently no zones defined";
$GLOBALS['strNoClients']				= "There are currently no clients defined";
$GLOBALS['strNoStats']					= "There are currently no statistics available";
$GLOBALS['strNoAffiliates']				= "There are currently no affiliates defined";

$GLOBALS['strCustom']					= "Specielt";

$GLOBALS['strSettings'] 				= "Settings";

$GLOBALS['strAffiliates']				= "Affiliates";
$GLOBALS['strAffiliatesAndZones']		= "Affiliates & Zones";
$GLOBALS['strAddAffiliate']				= "Create affiliate";
$GLOBALS['strModifyAffiliate']			= "Modify affiliate";
$GLOBALS['strAddNewAffiliate']			= "Add new affiliate";

$GLOBALS['strCheckAllNone']				= "Check all / none";

$GLOBALS['strAllowAffiliateModifyInfo'] = "Allow this user to modify his own affiliate information";
$GLOBALS['strAllowAffiliateModifyZones'] = "Allow this user to modify his own zones";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Allow this user to link banners to his own zones";
$GLOBALS['strAllowAffiliateAddZone'] = "Allow this user to define new zones";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Allow this user to delete existing zones";

$GLOBALS['strPriority']					= "Priority";
$GLOBALS['strHighPriority']				= "Show banners in this campaign with high priority.<br>
										   If you use this option phpAdsNew will try to distribute the 
										   number of AdViews evenly over the course of the day.";
$GLOBALS['strLowPriority']				= "Show banner in this campaign with low priority.<br>
										   This campaign is used to show the left over AdViews which 
										   aren't used by high priority campaigns.";
$GLOBALS['strTargetLimitAdviews']		= "Limit the number of AdViews to";
$GLOBALS['strTargetPerDay']				= "per day.";
$GLOBALS['strRecalculatePriority']		= "Recalculate priority";

$GLOBALS['strProperties']				= "Properties";
$GLOBALS['strAffiliateProperties']		= "Affiliate properties";
$GLOBALS['strBannerOverview']			= "Banner overview";
$GLOBALS['strBannerProperties']			= "Banner properties";
$GLOBALS['strCampaignProperties']		= "Campaign properties";
$GLOBALS['strClientProperties']			= "Client properties";
$GLOBALS['strZoneOverview']				= "Zone overview";
$GLOBALS['strZoneProperties']			= "Zone properties";
$GLOBALS['strAffiliateOverview']		= "Affiliate overview";
$GLOBALS['strLinkedBannersOverview']	= "Linked banners overview";

$GLOBALS['strGlobalHistory']			= "Global history";
$GLOBALS['strBannerHistory']			= "Banner history";
$GLOBALS['strCampaignHistory']			= "Campaign history";
$GLOBALS['strClientHistory']			= "Client history";
$GLOBALS['strAffiliateHistory']			= "Affiliate history";
$GLOBALS['strZoneHistory']				= "Zone history";
$GLOBALS['strLinkedBannerHistory']		= "Linked banner history";

$GLOBALS['strMoveTo']					= "Move to";
$GLOBALS['strDuplicate']				= "Duplicate";

$GLOBALS['strMainSettings']				= "Main settings";
$GLOBALS['strAdminSettings']			= "Administration settings";

$GLOBALS['strApplyLimitationsTo']		= "Apply limitations to";
$GLOBALS['strWholeCampaign']			= "Whole campaign";
$GLOBALS['strZonesWithoutAffiliate']	= "Zones without affiliate";
$GLOBALS['strMoveToNewAffiliate']		= "Move to new affiliate";

$GLOBALS['strNoBannersToLink']			= "There are currently no banners available which can be linked to this zone";
$GLOBALS['strNoLinkedBanners']			= "There are no banners available which are linked to this zone";

$GLOBALS['strAdviewsLimit']				= "AdViews limit";

$GLOBALS['strTotalThisPeriod']			= "Total this period";
$GLOBALS['strAverageThisPeriod']		= "Average this period";
$GLOBALS['strLast7Days']				= "Last 7 days";
$GLOBALS['strDistribution']				= "Distribution";
$GLOBALS['strOther']					= "Other";
$GLOBALS['strUnknown']					= "Unknown";

$GLOBALS['strWelcomeTo']				= "Welcome to";
$GLOBALS['strEnterUsername']			= "Enter your username and password to log in";

$GLOBALS['strBannerNetwork']			= "Banner network";
$GLOBALS['strMoreInformation']			= "More information...";
$GLOBALS['strChooseNetwork']			= "Choose the banner network you want to use";
$GLOBALS['strRichMedia']				= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "Track AdClicks";
$GLOBALS['strYes']						= "Yes";
$GLOBALS['strNo']						= "No";
$GLOBALS['strUploadOrKeep']				= "Do you wish to keep your <br>existing image, or do you <br>want to upload another?";
$GLOBALS['strCheckSWF']					= "Check for hard-coded links inside the Flash file";
$GLOBALS['strURL2']						= "URL";
$GLOBALS['strTarget']					= "Target";
$GLOBALS['strConvert']					= "Convert";
$GLOBALS['strCancel']					= "Cancel";

$GLOBALS['strConvertSWFLinks']			= "Convert Flash links";
$GLOBALS['strConvertSWF']				= "<br>The Flash file you just uploaded contains hard-coded urls. phpAdsNew won't be ".
										  "able to track the number of AdClicks for this banner unless you convert these ".
										  "hard-coded urls. Below you will find a list of all urls inside the Flash file. ".
										  "If you want to convert the urls, simply click <b>Convert</b>, otherwise click ".
										  "<b>Cancel</b>.<br><br>".
										  "Please note: if you click <b>Convert</b> the Flash file ".
									  	  "you just uploaded will be physically altered. <br>Please keep a backup of the ".
										  "original file. Regardless of in which version this banner was created, the resulting ".
										  "file will need the Flash 4 player (or higher) to display correctly.<br><br>";

?>