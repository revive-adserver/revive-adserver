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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  			= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 			= "right";
$GLOBALS['phpAds_TextAlignLeft']  			= "left";

$GLOBALS['phpAds_DecimalPoint']				= ',';
$GLOBALS['phpAds_ThousandsSeperator']			= '.';


// Date & time configuration
$GLOBALS['date_format'] 				= "%d-%m-%Y";
$GLOBALS['time_format'] 				= "%H:%M:%S";
$GLOBALS['minute_format']				= "%H:%M";
$GLOBALS['month_format']				= "%m-%Y";
$GLOBALS['day_format']					= "%m-%d";
$GLOBALS['week_format']					= "%W-%Y";
$GLOBALS['weekiso_format']				= "%V-%G";



/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

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
$GLOBALS['strSearch']					= "<u>Z</u>oeken";
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
$GLOBALS['strPrevious_Key'] 				= "Vo<u>r</u>ige";
$GLOBALS['strNext'] 					= "Volgende";
$GLOBALS['strNext_Key'] 				= "Vol<u>g</u>ende";
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
$GLOBALS['strExpandAll']				= "Alles <u>u</u>itklappen";
$GLOBALS['strCollapseAll']				= "Alles <u>i</u>nklappen";
$GLOBALS['strShowAll']					= "Toon alles";
$GLOBALS['strNoAdminInterface']				= "Deze dienst is momenteel niet beschikbaar...";
$GLOBALS['strFilterBySource']				= "filter op bron";
$GLOBALS['strFieldContainsErrors']			= "De volgende velden bevatten fouten:";
$GLOBALS['strFieldFixBeforeContinue1']			= "Voordat u verder kunt gaan dient u";
$GLOBALS['strFieldFixBeforeContinue2']			= "deze fouten te corrigeren.";
$GLOBALS['strDelimiter']				= "Scheidingsteken";
$GLOBALS['strMiscellaneous']				= "Overig";


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
$GLOBALS['strEnterBoth']				= "Vul zowel uw gebruikersnaam en uw wachtwoord in";
$GLOBALS['strEnableCookies']				= "U dient cookies aan te zetten in uw browser voordat u ".$phpAds_productname." kunt gebruiken";
$GLOBALS['strLogin'] 					= "Inloggen";
$GLOBALS['strLogout'] 					= "Uitloggen";
$GLOBALS['strUsername'] 				= "Gebruikersnaam";
$GLOBALS['strPassword'] 				= "Wachtwoord";
$GLOBALS['strAccessDenied'] 				= "Toegang geweigerd";
$GLOBALS['strPasswordWrong'] 				= "Het wachtwoord is niet correct";
$GLOBALS['strNotAdmin'] 				= "U heeft waarschijnlijk niet genoeg privileges";
$GLOBALS['strDuplicateClientName']			= "De gebruikersnaam die u gekozen heeft bestaat al, kies een andere gebruikersnaam.";
$GLOBALS['strInvalidPassword']				= "Het nieuwe wachtwoord is niet geldig, voer een ander wachtwoord in.";
$GLOBALS['strNotSamePasswords']				= "De twee wachtwoorden die u ingevoerd heeft zijn niet hetzelfde";
$GLOBALS['strRepeatPassword']				= "Herhaal het wachtwoord";
$GLOBALS['strOldPassword']				= "Oud wachtwoord";
$GLOBALS['strNewPassword']				= "Nieuw wachtwoord";


// General advertising
$GLOBALS['strImpressions'] 					= "AdViews";
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
$GLOBALS['strAddClient_Key'] 				= "<u>V</u>oeg een adverteerder toe";
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
$GLOBALS['strAddCampaign_Key'] 				= "<u>V</u>oeg een campagne toe";
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
$GLOBALS['strImpressionsPurchased'] 				= "Gekochte AdViews";
$GLOBALS['strClicksPurchased'] 				= "Gekochte AdClicks";
$GLOBALS['strCampaignWeight']				= "Campagne gewicht";
$GLOBALS['strHighPriority']				= "Toon de banners in deze campagne met hoge prioriteit.<br />Indien u deze optie gebruikt zal ".$phpAds_productname." proberen om het aantal AdViews gelijkmatig over de dag de verspreiden.";
$GLOBALS['strLowPriority']				= "Toon de banners in deze campagne met lage prioriteit.<br />Deze campagne wordt gebruikt om de overgebleven AdViews te tonen, welke niet gebruikt worden door hoge prioriteit campagnes.";
$GLOBALS['strTargetLimitAdviews']			= "Limiteer het aantal AdViews tot";
$GLOBALS['strTargetPerDay']				= "per dag.";
$GLOBALS['strPriorityAutoTargeting']			= "Gekochte AdViews en vervaldatum zijn ingesteld.\n De limiet wordt elke dag bijgesteld.";
$GLOBALS['strCampaignWarningNoWeight'] 			= "De prioriteit van deze campagne is laag, \nterwijl het gewicht op nul is gezet of niet \ngespecificeerd is. Dit zal er voor zorgen dat de campagne \ngedeactiveerd wordt en de banners zullen niet getoond \nworden totdat het gewicht aangepast is. \n\nWeet u zeker dat u door wilt gaan?";
$GLOBALS['strCampaignWarningNoTarget'] 			= "De prioriteit van deze campagne is hoog, \nmaar u heeft het aantal AdViews niet gelimiteerd tot een. \nbepaald aantal. Dit zal er voor zorgen dat de campagne \n gedeactiveerd wordt en de banner zullen niet getoond \nworden totdat u het aantal AdViews gelimiteerd heeft \n\nWeet u zeker dat u door wilt gaan?";



// Banners (General)
$GLOBALS['strBanner'] 					= "Banner";
$GLOBALS['strBanners'] 					= "Banners";
$GLOBALS['strAddBanner'] 				= "Voeg een banner toe";
$GLOBALS['strAddBanner_Key'] 				= "<u>V</u>oeg een banner toe";
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
$GLOBALS['strInactiveBannersHidden']			= "niet-actieve banner(s) verborgen";
$GLOBALS['strAppendOthers']				= "Voeg andere toe";
$GLOBALS['strAppendTextAdNotPossible']			= "Het is niet mogelijk om andere banners toe te voegen aan tekst advertenties.";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 				= "Kies het banner type";
$GLOBALS['strMySQLBanner'] 				= "Lokale banner (SQL)";
$GLOBALS['strWebBanner'] 				= "Lokale banner (Webserver)";
$GLOBALS['strURLBanner'] 				= "Externe banner";
$GLOBALS['strHTMLBanner'] 				= "HTML banner";
$GLOBALS['strTextBanner'] 				= "Tekst advertentie";
$GLOBALS['strAutoChangeHTML']				= "Verander HTML om AdClicks te volgen";
$GLOBALS['strUploadOrKeep']				= "Wilt u uw bestaande afbeelding <br />houden, of wilt u een <br />nieuwe afbeelding uploaden?";
$GLOBALS['strNewBannerFile'] 				= "Selecteer de afbeelding die u <br />wilt gebruiken voor deze banner<br /><br />";
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
$GLOBALS['strHardcodedLinks']				= "Vaste links";
$GLOBALS['strConvertSWFLinks']				= "Converteer Flash links";
$GLOBALS['strConvertSWF']				= "<br />Het Flash bestand dat u zojuist upgeload heeft bevat vaste links. Pas als deze vaste links geconverteerd zijn zal ".$phpAds_productname." AdClicks kunnen volgen voor deze banner. Hieronder vindt u een lijst met alle links welke in het Flash bestand aanwezig zijn. Indien u de links wilt converteren, klik dan op <b>Converteer</b>, klik anders op <b>Annuleer</b>.<br /><br />Notitie: Als u klikt op <b>Converteer</b> zal het Flash bestand welke u zojuist geupload heeft veranderd worden. <br />Bewaar het orginele bestand goed. Ongeacht in welke versie de banner gemaakt is, het geconverteerde bestand zal alleen goed te zien zijn met de Flash 4 player (of hoger).<br /><br />";
$GLOBALS['strCompressSWF']				= "Comprimeer SWF bestand voor versneld downloaden (Flash 6 speler verplicht)";
$GLOBALS['strOverwriteSource']				= "Overschrijft de bron parameter";


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
$GLOBALS['strACLAdd_Key'] 				= "<u>V</u>oeg nieuwe beperking toe";
$GLOBALS['strNoLimitations']				= "Geen beperkingen";
$GLOBALS['strApplyLimitationsTo']			= "Pas beperking toe op";
$GLOBALS['strRemoveAllLimitations']			= "Verwijder alle beperkingen";
$GLOBALS['strEqualTo']					= "is gelijk aan";
$GLOBALS['strDifferentFrom']				= "is verschillend van";
$GLOBALS['strLaterThan']				= "is later dan";
$GLOBALS['strLaterThanOrEqual']				= "is later dan of gelijk aan";
$GLOBALS['strEarlierThan']				= "is vroeger dan";
$GLOBALS['strEarlierThanOrEqual']			= "is vroeger dan of gelijk aan";
$GLOBALS['strContains']					= "bevat";
$GLOBALS['strNotContains']				= "bevat niet";
$GLOBALS['strAND']					= "EN";  // logical operator
$GLOBALS['strOR']					= "OF"; // logical operator
$GLOBALS['strOnlyDisplayWhen']				= "Toon deze banner alleen wanneer:";
$GLOBALS['strWeekDay'] 					= "Weekdag";
$GLOBALS['strTime'] 					= "Tijd";
$GLOBALS['strUserAgent']				= "Useragent";
$GLOBALS['strDomain'] 					= "Domein";
$GLOBALS['strClientIP'] 				= "IP adres";
$GLOBALS['strSource'] 					= "Bronpagina";
$GLOBALS['strBrowser'] 					= "Browser";
$GLOBALS['strOS'] 					= "OS";
$GLOBALS['strCountry'] 					= "Land";
$GLOBALS['strContinent'] 				= "Continent";
$GLOBALS['strReferer'] 					= "Verwijzende pagina";
$GLOBALS['strDeliveryLimitations']			= "Leveringsbeperkingen";
$GLOBALS['strDeliveryCapping']				= "Leveringsplafond";
$GLOBALS['strTimeCapping']				= "Zodra deze banner eenmaal<br /> getoond is, toon deze niet nog<br /> een keer gedurende:";
$GLOBALS['strImpressionCapping']			= "Toon deze banner niet meer dan:";


// Publisher
$GLOBALS['strAffiliate']				= "Uitgever";
$GLOBALS['strAffiliates']				= "Uitgevers";
$GLOBALS['strAffiliatesAndZones']			= "Uitgevers & Zones";
$GLOBALS['strAddNewAffiliate']				= "Voeg een uitgever toe";
$GLOBALS['strAddNewAffiliate_Key']			= "<u>V</u>oeg een uitgever toe";
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
$GLOBALS['strWebsite']					= "Website";
$GLOBALS['strAllowAffiliateModifyInfo'] 		= "Deze gebruiker kan zijn eigen affiliate informatie wijzigen";
$GLOBALS['strAllowAffiliateModifyZones'] 		= "Deze gebruiker kan zijn eigen zones wijzigen";
$GLOBALS['strAllowAffiliateLinkBanners'] 		= "Deze gebruiker kan banners koppelen aan zijn eigen zones";
$GLOBALS['strAllowAffiliateAddZone'] 			= "Deze gebruiker kan nieuwe zones definieeren";
$GLOBALS['strAllowAffiliateDeleteZone'] 		= "Deze gebruiker kan bestaande zones verwijderen";


// Zone
$GLOBALS['strZone']					= "Zone";
$GLOBALS['strZones']					= "Zones";
$GLOBALS['strAddNewZone']				= "Voeg een zone toe";
$GLOBALS['strAddNewZone_Key']				= "<u>V</u>oeg een zone toe";
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
$GLOBALS['strZoneNoDelivery']				= "Indien er geen banners van deze<br />zone geleverd kunnen worden, probeer...";
$GLOBALS['strZoneStopDelivery']				= "Stop levering en toon geen banner";
$GLOBALS['strZoneOtherZone']				= "Toon de geselecteerde zone";
$GLOBALS['strZoneUseKeywords']				= "Selecteer een banner met de volgende sleutelwoorden";
$GLOBALS['strZoneAppend']				= "Voeg altijd de volgende<br /> HTML code altijd toe<br /> aan deze zone";
$GLOBALS['strAppendSettings']				= "Invoeg instellingen";
$GLOBALS['strZonePrependHTML']				= "Voeg de volgende HTML code altijd toe voor de HTML code die getoond wordt door deze zone";
$GLOBALS['strZoneAppendHTML']				= "Voeg de volgende HTML code altijd toe na de HTML code die getoond wordt door deze zone";
$GLOBALS['strZoneAppendType']				= "Toevoeg type";
$GLOBALS['strZoneAppendHTMLCode']			= "HTML code";
$GLOBALS['strZoneAppendZoneSelection']			= "Popup of interstitial";
$GLOBALS['strZoneAppendSelectZone']			= "Voeg altijd de volgende popup of intersitial toe aan banners die getoond worden door deze zone";


// Zone probability
$GLOBALS['strZoneProbListChain']			= "De banners welke gekoppeld zijn aan deze zone zijn niet actief. <br />De volgende ketting wordt daarom gebruikt:";
$GLOBALS['strZoneProbNullPri']				= "De banners welke gekoppeld zijn aan deze zone zijn niet actief.";
$GLOBALS['strZoneProbListChainLoop']			= "De ketting welke gevolgd wordt is aan zichzelf gekoppeld. Het is niet mogelijk om deze zone te tonen";


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
$GLOBALS['strSizeDistribution']				= "Distributie op grootte";
$GLOBALS['strCountryDistribution']			= "Distributie op land";
$GLOBALS['strEffectivity']				= "Effectiviteit";
$GLOBALS['strTargetStats']				= "Doelberekeningen";
$GLOBALS['strCampaignTarget']				= "Doel";
$GLOBALS['strTargetRatio']				= "Doel ratio";
$GLOBALS['strTargetModifiedDay']			= "Er zijn doelen gewijzigd gedurende de dag, hierdoor waren de berekeningen niet accuraat";
$GLOBALS['strTargetModifiedWeek']			= "Er zijn doelen gewijzigd gedurende de week, hierdoor waren de berekeningen niet accuraat";
$GLOBALS['strTargetModifiedMonth']			= "Er zijn doelen gewijzigd gedurende de maand, hierdoor waren de berekeningen neit accuraat";
$GLOBALS['strNoTargetStats']				= "Er zijn momenteen geen gegevens bekend over doelberekeningen";


// Hosts
$GLOBALS['strHosts']					= "Bezoekers";
$GLOBALS['strTopHosts'] 				= "Meest actieve bezoekers";
$GLOBALS['strTopCountries'] 				= "Meest active landen";
$GLOBALS['strRecentHosts'] 				= "Meest recente bezoekers";

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
$GLOBALS['strGenerateBannercode']			= "Directe selectie";
$GLOBALS['strChooseInvocationType']			= "Kies het type banner invocatie";
$GLOBALS['strGenerate']					= "Genereer";
$GLOBALS['strParameters']				= "Parameters";
$GLOBALS['strFrameSize']				= "Frame grootte";
$GLOBALS['strBannercode']				= "Bannercode";
$GLOBALS['strOptional']					= "optioneel";


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
$GLOBALS['strErrorUploadSecurity']			= "Er is een potentieel beveiligingsprobleem gedetecteerd. De operatie is afgebroken!";
$GLOBALS['strErrorUploadBasedir']			= "Het verzonden bestand kon niet worden gelezen. De oorzaak is waarschijnlijk een safemode of open_basedir restrictie";
$GLOBALS['strErrorUploadUnknown']			= "Door een onbekende oorzaak kon het verzonden bestand kon niet worden gelezen. Controleer uw PHP configuratie";
$GLOBALS['strErrorStoreLocal']				= "Er is een fout opgetreden tijdens het bewaren van de banner in een lokale map. Door oorzaak van dit probleem is waarschijnlijk een misconfiguratie van de locatie van de lokale map";
$GLOBALS['strErrorStoreFTP']				= "Er is een fout opgetreden tijdens het overzenden van de banner naar de FTP server. De server is niet bereikbaar, of er is een fout gemaakt tijdens het invullen van de gegevens van de FTP server";
$GLOBALS['strErrorDBPlain']				= "Er is een probleem opgetreden tijdens het benaderen van de database";
$GLOBALS['strErrorDBSerious']				= "Er is een ernstig probleem met de database opgetreden";
$GLOBALS['strErrorDBNoDataPlain']			= "Wegens het probleem kon ".$phpAds_productname." geen gegevens ophalen of versturen. ";
$GLOBALS['strErrorDBNoDataSerious']			= "Wegens het ernstige problem kon ".$phpAds_productname." geen gegevens ophalen";
$GLOBALS['strErrorDBCorrupt']				= "De database tabel is waarschijnlijk beschadigd en moet gerepareerd worden. Voor meer informatie over het repareren van beschadigde tabellen lees het hoofdstuk <i>Troubleshooting</i> van de <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']				= "Neem a.u.b. contact op met de beheerder van deze server en breng hem op de hoogte van uw probleem.";
$GLOBALS['strErrorDBSubmitBug']				= "Indien dit probleem te reproduceren is, dan is het mogelijk dat het veroorzaakt wordt door een fout in ".$phpAds_productname.". Reporteer de volgende gegevens aan de makers van ".$phpAds_productname.". Probeer tevens de actie die deze fout tot gevolg hebben zo duidelijk mogelijk te omschrijven.";
$GLOBALS['strMaintenanceNotActive']			= "Het onderhoudsscript heeft niet gedraaid in de laatste 24 uur. \\nHet script moet elk uur gedraaid worden ander zal ".$phpAds_productname." niet \\ncorrect functioneren.\\n\\nLees a.u.b. de Administrator guide voor meer informatie \\n over het instellen van het onderhoudsscript.";


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
$GLOBALS['strWeightIsNull']				= "het gewicht op nul gezet is";
$GLOBALS['strWarnClientTxt']				= "Er zijn minder dan {limit} AdClicks of AdViews over voor uw banners. ";
$GLOBALS['strImpressionsClicksLow']				= "Uw AdViews/AdClicks zijn bijna volledig gebruikt";
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




/*-------------------------------------------------------*/
/* Keyboard shortcut assignments                         */
/*-------------------------------------------------------*/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']		= 'h';
$GLOBALS['keyUp']		= 'o';
$GLOBALS['keyNextItem']		= '.';
$GLOBALS['keyPreviousItem']	= ',';
$GLOBALS['keyList']		= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']		= 'z';
$GLOBALS['keyCollapseAll']	= 'u';
$GLOBALS['keyExpandAll']	= 'i';
$GLOBALS['keyAddNew']		= 'v';
$GLOBALS['keyNext']		= 'g';
$GLOBALS['keyPrevious']		= 'r';

?>