<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  			= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 			= "right";
$GLOBALS['phpAds_TextAlignLeft']  			= "left";

$GLOBALS['phpAds_DecimalPoint']				= '.';
$GLOBALS['phpAds_ThousandsSeperator']			= ',';


// Date & time configuration
$GLOBALS['date_format'] 				= "%d-%m-%Y";
$GLOBALS['time_format'] 				= "%H:%i:%S";
$GLOBALS['minute_format']				= "%H:%M";
$GLOBALS['month_format']				= "%m-%Y";
$GLOBALS['day_format']					= "%m-%d";
$GLOBALS['week_format']					= "%W-%Y";
$GLOBALS['weekiso_format']				= "%V-%G";



/*********************************************************/
/* Translations                                          */
/*********************************************************/

$GLOBALS['strHome'] 					= "Hoofdpagina";
$GLOBALS['strHelp']					= "Help";
$GLOBALS['strNavigation'] 				= "Navigatie";
$GLOBALS['strShortcuts'] 				= "Snelkoppelingen";
$GLOBALS['strAdminstration'] 				= "Voorraadbeheer";
$GLOBALS['strMaintenance']				= "Onderhoud";
$GLOBALS['strProbability']				= "Waarschijnlijkheid";
$GLOBALS['strInvocationcode']				= "Invocatiecode";
$GLOBALS['strBasicInformation'] 			= "Standaard informatie";
$GLOBALS['strContractInformation'] 			= "Contract informatie";
$GLOBALS['strLoginInformation'] 			= "Inlog gegevens";
$GLOBALS['strOverview']					= "Overzicht";
$GLOBALS['strSearch']					= "Zoeken";
$GLOBALS['strHistory']					= "Geschiedenis";
$GLOBALS['strPreferences'] 				= "Voorkeuren";
$GLOBALS['strDetails']					= "Details";
$GLOBALS['strCompact']					= "Compact";
$GLOBALS['strVerbose']					= "Uitgebreid";
$GLOBALS['strUser']					= "Gebruiker";
$GLOBALS['strEdit']					= "Wijzig";
$GLOBALS['strCreate']					= "Maak";
$GLOBALS['strDuplicate']				= "Dupliceer";
$GLOBALS['strMoveTo']					= "Verplaats naar";
$GLOBALS['strDelete'] 					= "Verwijder";
$GLOBALS['strActivate'] 				= "Activeer";
$GLOBALS['strDeActivate'] 				= "Deactiveer";
$GLOBALS['strConvert']					= "Converteer";
$GLOBALS['strRefresh']					= "Verversen";
$GLOBALS['strSaveChanges']		 		= "Bewaar veranderingen";
$GLOBALS['strUp'] 					= "Omhoog";
$GLOBALS['strDown'] 					= "Omlaag";
$GLOBALS['strSave'] 					= "Bewaren";
$GLOBALS['strCancel']					= "Annuleer";
$GLOBALS['strPrevious'] 				= "Vorige";
$GLOBALS['strNext'] 					= "Volgende";
$GLOBALS['strYes']					= "Ja";
$GLOBALS['strNo']					= "Nee";
$GLOBALS['strNone'] 					= "Geen";
$GLOBALS['strCustom']					= "Anders";
$GLOBALS['strDefault'] 					= "Standaard";
$GLOBALS['strOther']					= "Andere";
$GLOBALS['strUnknown']					= "Onbekend";
$GLOBALS['strUnlimited'] 				= "Onbegrensd";
$GLOBALS['strUntitled']					= "Naamloos";
$GLOBALS['strAll'] 					= "alle";
$GLOBALS['strAvg'] 					= "Gem.";
$GLOBALS['strAverage']					= "Gemiddelde";
$GLOBALS['strOverall'] 					= "Algemeen";
$GLOBALS['strTotal'] 					= "Totaal";
$GLOBALS['strFrom']					= "Van";
$GLOBALS['strActive'] 					= "actief";
$GLOBALS['strTo']					= "tot";
$GLOBALS['strLinkedTo'] 				= "gelinked met";
$GLOBALS['strDaysLeft'] 				= "Dagen te gaan";
$GLOBALS['strCheckAllNone']				= "Selecteer alle / geen";
$GLOBALS['strKiloByte']					= "KB";
$GLOBALS['strExpandAll']				= "Alles uitklappen";
$GLOBALS['strCollapseAll']				= "Alles inklappen";
$GLOBALS['strShowAll']					= "Toon alles";
$GLOBALS['strNoAdminInteface']				= "Deze dienst is momenteel niet beschikbaar...";
$GLOBALS['strFilterBySource']				= "filter op bron";


// Properties
$GLOBALS['strName']					= "Naam";
$GLOBALS['strSize']					= "Afmetingen";
$GLOBALS['strWidth'] 					= "Breedte";
$GLOBALS['strHeight'] 					= "Hoogte";
$GLOBALS['strURL2']					= "URL";
$GLOBALS['strTarget']					= "Target";
$GLOBALS['strLanguage'] 				= "Taal";
$GLOBALS['strDescription'] 				= "Beschrijving";
$GLOBALS['strID']				 	= "ID";


// Login & Permissions
$GLOBALS['strAuthentification'] 			= "Authenticatie";
$GLOBALS['strWelcomeTo']				= "Welkom bij";
$GLOBALS['strEnterUsername']				= "Vul uw gebruikersnaam en wachtwoord in om in te loggen";
$GLOBALS['strEnterBoth']					= "Vul zowel uw gebruikersnaam en uw wachtwoord in";
$GLOBALS['strEnableCookies']				= "U dient cookies aan te zetten in uw browser voordat u ".$phpAds_productname." kunt gebruiken";
$GLOBALS['strLogin'] 					= "Inloggen";
$GLOBALS['strLogout'] 					= "Uitloggen";
$GLOBALS['strUsername'] 				= "Gebruikersnaam";
$GLOBALS['strPassword'] 				= "Wachtwoord";
$GLOBALS['strAccessDenied'] 				= "Toegang geweigerd";
$GLOBALS['strPasswordWrong'] 				= "Het wachtwoord is niet correct";
$GLOBALS['strNotAdmin'] 				= "U heeft waarschijnlijk niet genoeg privileges";
$GLOBALS['strDuplicateClientName']			= "De gebruikersnaam die u gekozen heeft bestaat al, kies een andere gebruikersnaam.";


// General advertising
$GLOBALS['strViews'] 					= "AdViews";
$GLOBALS['strClicks'] 					= "AdClicks";
$GLOBALS['strCTR'] 					= "Click-Through Ratio";
$GLOBALS['strCTRShort'] 				= "CTR";
$GLOBALS['strTotalViews'] 				= "Totaal AdViews";
$GLOBALS['strTotalClicks'] 				= "Totaal AdClicks";
$GLOBALS['strViewCredits'] 				= "Adview krediet";
$GLOBALS['strClickCredits']				= "Adclick krediet";


// Time and date related
$GLOBALS['strDate'] 					= "Datum";
$GLOBALS['strToday'] 					= "Vandaag";
$GLOBALS['strDay']					= "Dag";
$GLOBALS['strDays']					= "Dagen";
$GLOBALS['strLast7Days']				= "Laatste 7 dagen";
$GLOBALS['strWeek'] 					= "Week";
$GLOBALS['strWeeks'] 					= "Weken";
$GLOBALS['strMonths'] 					= "Maanden";
$GLOBALS['strThisMonth'] 				= "Deze maand";
$GLOBALS['strMonth'] 					= array("januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december");
$GLOBALS['strDayShortCuts'] 				= array("zo","ma","di","wo","do","vr","za");
$GLOBALS['strHour']					= "Uur";
$GLOBALS['strSeconds']					= "seconden";
$GLOBALS['strMinutes']					= "minuten";
$GLOBALS['strHours']					= "uren";
$GLOBALS['strTimes']					= "keer";


// Advertiser
$GLOBALS['strClient'] 					= "Adverteerder";
$GLOBALS['strClients'] 					= "Adverteerders";
$GLOBALS['strClientsAndCampaigns']			= "Adverteerders & Campagnes";
$GLOBALS['strAddClient'] 				= "Voeg een adverteerder toe";
$GLOBALS['strTotalClients'] 				= "Totaal aantal adverteerders";
$GLOBALS['strClientProperties']				= "Adverteerder eigenschappen";
$GLOBALS['strClientHistory']				= "Adverteerder geschiedenis";
$GLOBALS['strNoClients']				= "Er zijn momenteel geen adverteerders gedefinieerd";
$GLOBALS['strConfirmDeleteClient'] 			= "Weet u zeker dat u deze adverteerder wilt verwijderen?";
$GLOBALS['strConfirmResetClientStats']			= "Weet u zeker dat u de statistieken wilt wissen voor deze adverteerder?";
$GLOBALS['strHideInactiveAdvertisers']			= "Verberg niet-actieve adverteerders";
$GLOBALS['strInactiveAdvertisersHidden']		= "niet-actieve adverteerder(s) verborgen";


// Advertisers properties
$GLOBALS['strContact'] 					= "Contactpersoon";
$GLOBALS['strEMail'] 					= "E-mail";
$GLOBALS['strSendAdvertisingReport']			= "Stuur een advertentie rapport per e-mail";
$GLOBALS['strNoDaysBetweenReports']			= "Aantal dagen tussen rapporten";
$GLOBALS['strSendDeactivationWarning'] 		 	= "Stuur een waarschuwing wanneer de campagne gedeactiveerd wordt";
$GLOBALS['strAllowClientModifyInfo'] 			= "Deze gebruiker kan zijn eigen instellingen wijzigen";
$GLOBALS['strAllowClientModifyBanner'] 			= "Deze gebruiker kan zijn eigen banners wijzigen";
$GLOBALS['strAllowClientAddBanner'] 			= "Deze gebruiker kan zijn eigen banners toevoegen";
$GLOBALS['strAllowClientDisableBanner'] 		= "Deze gebruiker kan zijn eigen banners deactiveren";
$GLOBALS['strAllowClientActivateBanner'] 		= "Deze gebruiker kan zijn eigen banners activeren";


// Campaign
$GLOBALS['strCampaign']					= "Campagne";
$GLOBALS['strCampaigns']				= "Campagnes";
$GLOBALS['strTotalCampaigns'] 				= "Totaal aantal campagnes";
$GLOBALS['strActiveCampaigns'] 				= "Actieve campagnes";
$GLOBALS['strAddCampaign'] 				= "Voeg een campagne toe";
$GLOBALS['strCreateNewCampaign']			= "Maak nieuwe campagne";
$GLOBALS['strModifyCampaign']				= "Wijzig campagne";
$GLOBALS['strMoveToNewCampaign']			= "Verplaats naar een nieuwe campagne";
$GLOBALS['strBannersWithoutCampaign']			= "Banners zonder campagne";
$GLOBALS['strDeleteAllCampaigns']			= "Verwijder alle campagnes";
$GLOBALS['strCampaignStats']				= "Campagne statistieken";
$GLOBALS['strCampaignProperties']			= "Campagne eigenschappen";
$GLOBALS['strCampaignOverview']				= "Campagne overzicht";
$GLOBALS['strCampaignHistory']				= "Campagne geschiedenis";
$GLOBALS['strNoCampaigns']				= "Er zijn momenteel geen campagnes gedefinieerd";
$GLOBALS['strConfirmDeleteCampaign']			= "Weet u zeker dat u deze campagne wilt verwijderen?";
$GLOBALS['strConfirmResetCampaignStats']		= "Weet u zeker dat u de statistieken wilt wissen voor deze campagne?";
$GLOBALS['strHideInactiveCampaigns']			= "Verberg niet-actieve campagnes";
$GLOBALS['strInactiveCampaignsHidden']			= "niet-actieve campagne(s) verborgen";


// Campaign properties
$GLOBALS['strDontExpire']				= "Deze campagne niet laten vervallen op een specifieke datum";
$GLOBALS['strActivateNow'] 				= "Deze campagne direct activeren";
$GLOBALS['strLow']					= "Low";
$GLOBALS['strHigh']					= "High";
$GLOBALS['strExpirationDate']				= "Vervaldatum";
$GLOBALS['strActivationDate']				= "Activeringsdatum";
$GLOBALS['strViewsPurchased'] 				= "Gekochte AdViews";
$GLOBALS['strClicksPurchased'] 				= "Gekochte AdClicks";
$GLOBALS['strCampaignWeight']				= "Campagne gewicht";
$GLOBALS['strHighPriority']				= "Toon de banners in deze campagne met hoge prioriteit.<br>
							   Indien u deze optie gebruikt zal ".$phpAds_productname." proberen om het 
							   aantal AdViews gelijkmatig over de dag de verspreiden.";
$GLOBALS['strLowPriority']				= "Toon de banners in deze campagne met lage prioriteit.<br>
							   Deze campagne wordt gebruikt om de overgebleven AdViews te tonen, 
							   welke niet gebruikt worden door hoge prioriteit campagnes.";
$GLOBALS['strTargetLimitAdviews']			= "Limiteer het aantal AdViews tot";
$GLOBALS['strTargetPerDay']				= "per dag.";
$GLOBALS['strPriorityAutoTargeting']			= "Gekochte AdViews en vervaldatum zijn ingesteld.\n De limiet wordt elke dag bijgesteld.";



// Banners (General)
$GLOBALS['strBanner'] 					= "Banner";
$GLOBALS['strBanners'] 					= "Banners";
$GLOBALS['strAddBanner'] 				= "Voeg een banner toe";
$GLOBALS['strModifyBanner'] 				= "Wijzig banner";
$GLOBALS['strActiveBanners'] 				= "Actieve banners";
$GLOBALS['strTotalBanners'] 				= "Totaal banners";
$GLOBALS['strShowBanner']				= "Toon banner";
$GLOBALS['strShowAllBanners']	 			= "Toon alle banners";
$GLOBALS['strShowBannersNoAdClicks']			= "Toon banners zonder AdClicks";
$GLOBALS['strShowBannersNoAdViews']			= "Toon banners zonder AdViews";
$GLOBALS['strDeleteAllBanners']	 			= "Verwijder alle banners";
$GLOBALS['strActivateAllBanners']			= "Activeer alle banners";
$GLOBALS['strDeactivateAllBanners']			= "Deactiveer alle banners";
$GLOBALS['strBannerOverview']				= "Banner overzicht";
$GLOBALS['strBannerProperties']				= "Banner eigenschappen";
$GLOBALS['strBannerHistory']				= "Banner geschiedenis";
$GLOBALS['strBannerNoStats'] 				= "Geen statistieken voor deze banner!";
$GLOBALS['strNoBanners'] 				= "Er zijn momenteel geen banner gedefinieerd";
$GLOBALS['strConfirmDeleteBanner']			= "Weet u zeker dat u deze banner wilt verwijderen?";
$GLOBALS['strConfirmDeleteAllBanners']			= "Weet u zeker dat u alle banners die bij deze campagne horen wilt vewijderen?";
$GLOBALS['strConfirmResetBannerStats']			= "Weet u zeker dat u de statistieken wilt wissen voor deze banner?";
$GLOBALS['strShowParentCampaigns']			= "Toon bovenliggende campagnes";
$GLOBALS['strHideParentCampaigns']			= "Verberg bovenliggende campagnes";
$GLOBALS['strHideInactiveBanners']			= "Verberg niet-actieve banners";
$GLOBALS['strInactiveBannersHidden']		= "niet-actieve banner(s) verborgen";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 				= "Kies het banner type";
$GLOBALS['strMySQLBanner'] 				= "Lokale banner (SQL)";
$GLOBALS['strWebBanner'] 				= "Lokale banner (Webserver)";
$GLOBALS['strURLBanner'] 				= "Externe banner";
$GLOBALS['strHTMLBanner'] 				= "HTML banner";
$GLOBALS['strTextBanner'] 				= "Tekst advertentie";
$GLOBALS['strAutoChangeHTML']				= "Verander HTML om AdClicks te volgen";
$GLOBALS['strUploadOrKeep']				= "Wilt u uw bestaande afbeelding <br>houden, of wilt u een <br>nieuwe afbeelding uploaden?";
$GLOBALS['strNewBannerFile'] 				= "Selecteer de afbeelding die u <br>wilt gebruiken voor deze banner<br><br>";
$GLOBALS['strNewBannerURL'] 				= "Afbeelding URL (incl. http://)";
$GLOBALS['strURL'] 					= "Doel URL (incl. http://)";
$GLOBALS['strHTML'] 					= "HTML";
$GLOBALS['strTextBelow']				= "Tekst onder banner";
$GLOBALS['strKeyword'] 					= "Sleutelwoorden";
$GLOBALS['strWeight'] 					= "Gewicht";
$GLOBALS['strAlt'] 					= "Alternative tekst";
$GLOBALS['strStatusText']				= "Status tekst";
$GLOBALS['strBannerWeight']				= "Banner gewicht";


// Banner (swf)
$GLOBALS['strCheckSWF']					= "Controleer op vaste links in het Flash bestand";
$GLOBALS['strConvertSWFLinks']				= "Converteer Flash links";
$GLOBALS['strConvertSWF']				= "<br>Het Flash bestand dat u zojuist upgeload heeft bevat vaste links. Pas als deze vaste ".
							  "links geconverteerd zijn zal ".$phpAds_productname." AdClicks kunnen volgen voor deze banner. ".
							  "Hieronder vindt u een lijst met alle links welke in het Flash bestand aanwezig zijn. ".
							  "Indien u de links wilt converteren, klik dan op <b>Converteer</b>, klik anders op ".
							  "<b>Annuleer</b>.<br><br>".
							  "Notitie: Als u klikt op <b>Converteer</b> zal het Flash bestand ".
						  	  "welke u zojuist geupload heeft veranderd worden. <br>Bewaar het orginele bestand goed. ".
							  "Ongeacht in welke versie de banner gemaakt is, het geconverteerde bestand ".
							  "zal alleen goed te zien zijn met de Flash 4 player (of hoger).<br><br>";
$GLOBALS['strCompressSWF']				= "Comprimeer SWF bestand voor versneld downloaden (Flash 6 speler verplicht)";


// Banner (network)
$GLOBALS['strBannerNetwork']				= "Banner netwerk";
$GLOBALS['strChooseNetwork']				= "Kies het banner netwerk dat u wilt gebruiken";
$GLOBALS['strMoreInformation']				= "Meer informatie...";
$GLOBALS['strRichMedia']				= "Richmedia";
$GLOBALS['strTrackAdClicks']				= "Volg AdClicks";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 				= "Leveringsopties";
$GLOBALS['strACL'] 					= "Levering";
$GLOBALS['strACLAdd'] 					= "Voeg nieuwe beperking toe";
$GLOBALS['strNoLimitations']				= "Geen beperkingen";
$GLOBALS['strApplyLimitationsTo']			= "Pas beperking toe op";
$GLOBALS['strRemoveAllLimitations']			= "Verwijder alle beperkingen";
$GLOBALS['strEqualTo']					= "is gelijk aan";
$GLOBALS['strDifferentFrom']				= "is verschillend van";
$GLOBALS['strAND']					= "EN";  // logical operator
$GLOBALS['strOR']					= "OF"; // logical operator
$GLOBALS['strOnlyDisplayWhen']				= "Toon deze banner alleen wanneer:";
$GLOBALS['strWeekDay'] 					= "Weekdag";
$GLOBALS['strTime'] 					= "Tijd";
$GLOBALS['strUserAgent']				= "Useragent";
$GLOBALS['strDomain'] 					= "Domein";
$GLOBALS['strClientIP'] 				= "IP adres";
$GLOBALS['strSource'] 					= "Bronpagina";
$GLOBALS['strBrowser'] 						= "Browser";
$GLOBALS['strOS'] 							= "OS";
$GLOBALS['strCountry'] 						= "Land";
$GLOBALS['strContinent'] 					= "Continent";
$GLOBALS['strDeliveryLimitations']			= "Leveringsbeperkingen";
$GLOBALS['strDeliveryCapping']				= "Leveringsplafond";
$GLOBALS['strTimeCapping']				= "Zodra deze banner eenmaal<br> getoond is, toon deze niet nog<br> een keer gedurende:";
$GLOBALS['strImpressionCapping']			= "Toon deze banner niet meer dan:";


// Publisher
$GLOBALS['strAffiliate']				= "Uitgever";
$GLOBALS['strAffiliates']				= "Uitgevers";
$GLOBALS['strAffiliatesAndZones']			= "Uitgevers & Zones";
$GLOBALS['strAddNewAffiliate']				= "Voeg een uitgever toe";
$GLOBALS['strAddAffiliate']				= "Maak uitgever";
$GLOBALS['strAffiliateProperties']			= "Uitgever eigenschappen";
$GLOBALS['strAffiliateOverview']			= "Uitgever overzicht";
$GLOBALS['strAffiliateHistory']				= "Uitgever geschiendenis";
$GLOBALS['strZonesWithoutAffiliate']			= "Zones zonder uitgever";
$GLOBALS['strMoveToNewAffiliate']			= "Verplaats naar een nieuwe uitgever";
$GLOBALS['strNoAffiliates']				= "Er zijn momenteel geen uitgevers gedefinieerd";
$GLOBALS['strConfirmDeleteAffiliate']			= "Weet u zeker dat u deze uitgever wilt wissen?";
$GLOBALS['strMakePublisherPublic']			= "Maak de zones die eigendom zijn van de uitgever publiekelijk toegankelijk";


// Publisher (properties)
$GLOBALS['strAllowAffiliateModifyInfo'] 		= "Deze gebruiker kan zijn eigen affiliate informatie wijzigen";
$GLOBALS['strAllowAffiliateModifyZones'] 		= "Deze gebruiker kan zijn eigen zones wijzigen";
$GLOBALS['strAllowAffiliateLinkBanners'] 		= "Deze gebruiker kan banners koppelen aan zijn eigen zones";
$GLOBALS['strAllowAffiliateAddZone'] 			= "Deze gebruiker kan nieuwe zones definieeren";
$GLOBALS['strAllowAffiliateDeleteZone'] 		= "Deze gebruiker kan bestaande zones verwijderen";


// Zone
$GLOBALS['strZone']					= "Zone";
$GLOBALS['strZones']					= "Zones";
$GLOBALS['strAddNewZone']				= "Voeg een zone toe";
$GLOBALS['strAddZone']					= "Maak zone";
$GLOBALS['strModifyZone']				= "Wijzig zone";
$GLOBALS['strLinkedZones']				= "Gekoppelde zones";
$GLOBALS['strZoneOverview']				= "Zone overzicht";
$GLOBALS['strZoneProperties']				= "Zone eigenschappen";
$GLOBALS['strZoneHistory']				= "Zone geschiendenis";
$GLOBALS['strNoZones']					= "Er zijn momenteel geen zones gedefinieerd";
$GLOBALS['strConfirmDeleteZone']			= "Weet u zeker dat u deze zone wilt wissen?";
$GLOBALS['strZoneType']					= "Zone type";
$GLOBALS['strBannerButtonRectangle']			= "Banner, Button of Rectangle";
$GLOBALS['strInterstitial']				= "Interstitial of Floating DHTML";
$GLOBALS['strPopup']					= "Popup";
$GLOBALS['strTextAdZone']				= "Tekst advertentie";
$GLOBALS['strShowMatchingBanners']			= "Toon geschikte banners";
$GLOBALS['strHideMatchingBanners']			= "Verberg geschikte banners";


// Advanced zone settings
$GLOBALS['strAdvanced']					= "Geavanceerd";
$GLOBALS['strChains']					= "Kettingen";
$GLOBALS['strChainSettings']				= "Ketting instellingen";
$GLOBALS['strZoneNoDelivery']				= "Indien er geen banners van deze<br>zone geleverd kunnen worden, probeer...";
$GLOBALS['strZoneStopDelivery']				= "Stop levering en toon geen banner";
$GLOBALS['strZoneOtherZone']				= "Toon de geselecteerde zone";
$GLOBALS['strZoneUseKeywords']				= "Selecteer een banner met de volgende sleutelwoorden";
$GLOBALS['strZoneAppend']				= "Voeg de volgende popup<br> of interstitial code altijd toe<br> aan deze zone";
$GLOBALS['strAppendSettings']				= "Invoeg instellingen";
$GLOBALS['strZonePrependHTML']				= "Voeg de volgende HTML code altijd toe voor de HTML code die getoond wordt door deze zone";
$GLOBALS['strZoneAppendHTML']				= "Voeg de volgende HTML code altijd toe na de HTML code die getoond wordt door deze zone";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']				= "Kies de manier van banners koppelen";
$GLOBALS['strBannerSelection']				= "Banner selectie";
$GLOBALS['strCampaignSelection']			= "Campagne selectie";
$GLOBALS['strInteractive']				= "Interactief";
$GLOBALS['strRawQueryString']				= "Sleutelwoorden";
$GLOBALS['strIncludedBanners']				= "Gekoppelde banners";
$GLOBALS['strLinkedBannersOverview']			= "Gekoppelde banner overzicht";
$GLOBALS['strLinkedBannerHistory']			= "Gekoppelde banner geschiedenis";
$GLOBALS['strNoZonesToLink']				= "Er zijn geen zones aanwezig waar deze banner aan gekoppeld kan worden";
$GLOBALS['strNoBannersToLink']				= "Er zijn momenteel geen banners beschikbaar welke gekoppeld kunnen worden aan deze zone";
$GLOBALS['strNoLinkedBanners']				= "Er zijn banners beschikbaar welke gekoppeld zijn aan deze zone";
$GLOBALS['strMatchingBanners']				= "{count} geschikte banners";
$GLOBALS['strNoCampaignsToLink']			= "Er zijn momenteel geen campagnes beschikbaar welke gekoppeld kunnen worden aan deze zone";
$GLOBALS['strNoZonesToLinkToCampaign']  		= "Er zijn geen zones aanwezig waar deze campagne aan gekoppeld kan worden";
$GLOBALS['strSelectBannerToLink']			= "Selecteer de banner welke u wilt koppelen aan deze zone:";
$GLOBALS['strSelectCampaignToLink']			= "Selecteer de campagne welke u wilt koppelen aan deze zone:";


// Statistics
$GLOBALS['strStats'] 					= "Statistieken";
$GLOBALS['strNoStats']					= "Er zijn momenteel geen statistieken beschikbaar";
$GLOBALS['strConfirmResetStats']			= "Weet u zeker dat u alle statistieken wilt wissen?";
$GLOBALS['strGlobalHistory']				= "Globale geschiedenis";
$GLOBALS['strDailyHistory']				= "Dagelijkse geschiedenis";
$GLOBALS['strDailyStats'] 				= "Dagelijkse statistieken";
$GLOBALS['strWeeklyHistory']				= "Weeklijkse geschiedenis";
$GLOBALS['strMonthlyHistory']				= "Maandelijkse geschiedenis";
$GLOBALS['strCreditStats'] 				= "Krediet statistieken";
$GLOBALS['strDetailStats'] 				= "Gedetailleerde statistieken";
$GLOBALS['strTotalThisPeriod']				= "Totaal deze periode";
$GLOBALS['strAverageThisPeriod']			= "Gemiddelde deze periode";
$GLOBALS['strDistribution']				= "Verdeling";
$GLOBALS['strResetStats'] 				= "Wis Statistieken";
$GLOBALS['strSourceStats']				= "Bron statistieken";
$GLOBALS['strSelectSource']				= "Selecteer de bron die u wilt bekijken:";


// Hosts
$GLOBALS['strHosts']					= "Hosts";
$GLOBALS['strTopTenHosts'] 				= "Top tien hosts";


// Expiration
$GLOBALS['strExpired']					= "Vervallen";
$GLOBALS['strExpiration'] 				= "Vervaldatum";
$GLOBALS['strNoExpiration'] 				= "Geen vervaldatum ingesteld";
$GLOBALS['strEstimated'] 				= "Geschatte vervaldatum";


// Reports
$GLOBALS['strReports']					= "Rapportage";
$GLOBALS['strSelectReport']				= "Selecteer de rapportage welke u wilt genereren";


// Userlog
$GLOBALS['strUserLog']					= "Gebruikers log";
$GLOBALS['strUserLogDetails']				= "Gebruikers log details";
$GLOBALS['strDeleteLog']				= "Verwijder log";
$GLOBALS['strAction']					= "Actie";
$GLOBALS['strNoActionsLogged']				= "Er zijn geen acties vastgelegd";


// Code generation
$GLOBALS['strGenerateBannercode']			= "Genereer Bannercode";
$GLOBALS['strChooseInvocationType']			= "Kies het type banner invocatie";
$GLOBALS['strGenerate']					= "Genereer";
$GLOBALS['strParameters']				= "Parameters";
$GLOBALS['strFrameSize']				= "Frame grootte";
$GLOBALS['strBannercode']				= "Bannercode";


// Errors
$GLOBALS['strMySQLError'] 				= "SQL fout:";
$GLOBALS['strLogErrorClients'] 				= "Er is een fout opgetreden. De klanten konden niet worden opgevraagd vanuit de database.";
$GLOBALS['strLogErrorBanners'] 				= "Er is een fout opgetreden. De banners konden niet worden opgevraagd vanuit de database.";
$GLOBALS['strLogErrorViews'] 				= "Er is een fout opgetreden. De AdViews konden niet worden opgevraagd vanuit de database.";
$GLOBALS['strLogErrorClicks'] 				= "Er is een fout opgetreden. De AdClicks konden niet worden opgevraagd vanuit de database.";
$GLOBALS['strErrorViews'] 				= "U moet het aantal AdViews invullen of het vakje 'Onbegrensd' aankruisen!";
$GLOBALS['strErrorNegViews'] 				= "Negatieve AdViews zijn niet toegestaan";
$GLOBALS['strErrorClicks'] 				= "U moet het aantal AdClicks invullen of het vakje 'Onbegrensd' aankruisen!";
$GLOBALS['strErrorNegClicks'] 				= "Negatieve AdClicks zijn niet toegestaan";
$GLOBALS['strNoMatchesFound']				= "Geen objecten gevonden";
$GLOBALS['strErrorOccurred']				= "Er is een fout opgetreden";


// E-mail
$GLOBALS['strMailSubject'] 				= "Advertentierapport";
$GLOBALS['strAdReportSent']				= "Advertentierapport verzonden";
$GLOBALS['strMailSubjectDeleted'] 			= "Gedeactiveerde banners";
$GLOBALS['strMailHeader'] 				= "Geachte {contact},\n";
$GLOBALS['strMailBannerStats'] 				= "Bijgevoegd vind u de banner-statistieken van {clientname}:";
$GLOBALS['strMailFooter'] 				= "Met vriendelijke groet,\n    {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 			= "Uw banner zijn gedeactiveerd omdat";
$GLOBALS['strMailNothingLeft'] 				= "Indien u verder wilt adverteren op onze website, neem dan gerust contact met ons op. We horen graag van u.";
$GLOBALS['strClientDeactivated']			= "Deze campagne is momenteel niet actief omdat";
$GLOBALS['strBeforeActivate']				= "de activeringsdatum bereikt is";
$GLOBALS['strAfterExpire']				= "de vervaldatum bereikt is";
$GLOBALS['strNoMoreClicks']				= "de gekochte AdClicks gebruikt zijn";
$GLOBALS['strNoMoreViews']				= "de gekochte AdViews gebruikt zijn";
$GLOBALS['strWarnClientTxt']				= "Er zijn minder dan {limit} AdClicks of AdViews over voor uw banners. ";
$GLOBALS['strViewsClicksLow']				= "Uw AdViews/AdClicks zijn bijna volledig gebruikt";
$GLOBALS['strNoViewLoggedInInterval']   		= "Er zijn geen AdViews gelogd gedurende de dagen van dit rapport";
$GLOBALS['strNoClickLoggedInInterval']  		= "Er zijn geen AdClicks gelogd gedurende de dagen van dit rapport";
$GLOBALS['strMailReportPeriod']				= "Dit rapport bevat de statistieken van {startdate} tot en met {enddate}.";
$GLOBALS['strMailReportPeriodAll']			= "Dit rapport bevat alle statistieken tot en met {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 			= "Er zijn geen statistieken beschikbaar voor deze campagne";


// Priority
$GLOBALS['strPriority']					= "Prioriteit";


// Settings
$GLOBALS['strSettings'] 				= "Instellingen";
$GLOBALS['strGeneralSettings']				= "Standaard instellingen";
$GLOBALS['strMainSettings']				= "Hoofd instellingen";
$GLOBALS['strAdminSettings']				= "Administratie instellingen";


// Product Updates
$GLOBALS['strProductUpdates']				= "Nieuwe versies";

?>