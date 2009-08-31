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
$GLOBALS['strAdminstration'] 				= "Inventaris";
$GLOBALS['strMaintenance']				= "Onderhoud";
$GLOBALS['strProbability']				= "Waarschijnlijkheid";
$GLOBALS['strInvocationcode']				= "Invocatiecode";
$GLOBALS['strBasicInformation'] 			= "Standaard informatie";
$GLOBALS['strContractInformation'] 			= "Contract informatie";
$GLOBALS['strLoginInformation'] 			= "Aanmeldingsgegevens";
$GLOBALS['strOverview']					= "Overzicht";
$GLOBALS['strSearch']					= "<u>Z</u>oeken";
$GLOBALS['strHistory']					= "Geschiedenis";
$GLOBALS['strPreferences'] 				= "Voorkeuren";
$GLOBALS['strDetails']					= "Details";
$GLOBALS['strCompact']					= "Compact";
$GLOBALS['strVerbose']					= "Uitgebreid";
$GLOBALS['strUser']					= "Gebruiker";
$GLOBALS['strEdit']					= "Wijzig";
$GLOBALS['strCreate']					= "Creëer";
$GLOBALS['strDuplicate']				= "Dubbel";
$GLOBALS['strMoveTo']					= "Verplaatst naar";
$GLOBALS['strDelete'] 					= "Verwijder";
$GLOBALS['strActivate'] 				= "Activeer";
$GLOBALS['strDeActivate'] 				= "Deactiveer";
$GLOBALS['strConvert']					= "Converteer";
$GLOBALS['strRefresh']					= "Vernieuwen";
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
$GLOBALS['strLinkedTo'] 				= "gelinkt naar";
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
$GLOBALS['strMiscellaneous']				= "Diversen";


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
$GLOBALS['strEnterUsername']				= "Vul uw gebruikersnaam en wachtwoord in om uw te kunnen aanmelden";
$GLOBALS['strEnterBoth']				= "Vul zowel uw gebruikersnaam als  uw wachtwoord in";
$GLOBALS['strEnableCookies']				= "Je moet cookies accepteren voor het gebruik van  ". MAX_PRODUCT_NAME ."";
$GLOBALS['strLogin'] 					= "Aanmelden";
$GLOBALS['strLogout'] 					= "Afmelden";
$GLOBALS['strUsername'] 				= "Gebruikersnaam";
$GLOBALS['strPassword'] 				= "Wachtwoord";
$GLOBALS['strAccessDenied'] 				= "Toegang geweigerd";
$GLOBALS['strPasswordWrong'] 				= "Het wachtwoord is niet correct";
$GLOBALS['strNotAdmin'] 				= "U heeft waarschijnlijk niet genoeg privileges";
$GLOBALS['strDuplicateClientName']			= "De gebruikersnaam die u wenst is al reeds in gebruik, gelieve een andere gebruikersnaam te gebruiken";
$GLOBALS['strInvalidPassword']				= "Het nieuwe wachtwoord is niet geldig, voer een ander wachtwoord in.";
$GLOBALS['strNotSamePasswords']				= "De twee wachtwoorden die u ingevoerd heeft zijn niet hetzelfde";
$GLOBALS['strRepeatPassword']				= "Herhaal het wachtwoord";
$GLOBALS['strOldPassword']				= "Oud wachtwoord";
$GLOBALS['strNewPassword']				= "Nieuw wachtwoord";


// General advertising
$GLOBALS['strImpressions'] 					= "AdViews";
$GLOBALS['strClicks'] 					= "AdClicks";
$GLOBALS['strCTR'] 					= "CTR";
$GLOBALS['strCTRShort'] 				= "CTR";
$GLOBALS['strTotalViews'] 				= "Totaal AdViews";
$GLOBALS['strTotalClicks'] 				= "Totaal AdClicks";
$GLOBALS['strViewCredits'] 				= "Adview krediet";
$GLOBALS['strClickCredits']				= "Adclick krediet";


// Time and date related
$GLOBALS['strDate'] 					= "Datum";
$GLOBALS['strToday'] 					= "Vandaag";
$GLOBALS['strDay']					= "Dagen";
$GLOBALS['strDays']					= "Dagen";
$GLOBALS['strLast7Days']				= "Laatste 7 dagen";
$GLOBALS['strWeek'] 					= "Weken";
$GLOBALS['strWeeks'] 					= "Weken";
$GLOBALS['strMonths'] 					= "Maanden";
$GLOBALS['strThisMonth'] 				= "Deze maand";
$GLOBALS['strMonth'][0] = "januari";
$GLOBALS['strMonth'][1] = "februari";
$GLOBALS['strMonth'][2] = "maart";
$GLOBALS['strMonth'][3] = "april";
$GLOBALS['strMonth'][4] = "mei";
$GLOBALS['strMonth'][5] = "juni";
$GLOBALS['strMonth'][6] = "juli";
$GLOBALS['strMonth'][7] = "augustus";
$GLOBALS['strMonth'][8] = "september";
$GLOBALS['strMonth'][9] = "oktober";
$GLOBALS['strMonth'][10] = "november";
$GLOBALS['strMonth'][11] = "december";

$GLOBALS['strDayShortCuts'][0] = "zo";
$GLOBALS['strDayShortCuts'][1] = "ma";
$GLOBALS['strDayShortCuts'][2] = "di";
$GLOBALS['strDayShortCuts'][3] = "wo";
$GLOBALS['strDayShortCuts'][4] = "do";
$GLOBALS['strDayShortCuts'][5] = "vr";
$GLOBALS['strDayShortCuts'][6] = "za";

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
$GLOBALS['strNoClients']				= "Er zijn momenteel geen adverteerders beschikbaar. Om een campagne aan te maken, <a href='advertiser-edit.php'>voeg eerst een nieuwe adverteerder toe</a>.";
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
$GLOBALS['strLow']					= "Laag";
$GLOBALS['strHigh']					= "Hoog";
$GLOBALS['strExpirationDate']				= "Vervaldatum";
$GLOBALS['strActivationDate']				= "Activeringsdatum";
$GLOBALS['strImpressionsPurchased'] 				= "Gekochte AdViews";
$GLOBALS['strClicksPurchased'] 				= "Gekochte AdClicks";
$GLOBALS['strCampaignWeight']				= "Campagne gewicht";
$GLOBALS['strHighPriority']				= "Toon de banners in deze campagne met hoge prioriteit.<br />Indien u deze optie gebruikt zal ".MAX_PRODUCT_NAME." proberen om het aantal AdViews gelijkmatig over de dag de verspreiden.";
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
$GLOBALS['strConvertSWF']				= "<br />Het Flash bestand dat u zojuist upgeload heeft bevat vaste links. Pas als deze vaste links geconverteerd zijn zal ". MAX_PRODUCT_NAME ." AdClicks kunnen volgen voor deze banner. Hieronder vindt u een lijst met alle links welke in het Flash bestand aanwezig zijn. Indien u de links wilt converteren, klik dan op <b>Converteer</b>, klik anders op <b>Annuleer</b>.<br /><br />Notitie: Als u klikt op <b>Converteer</b> zal het Flash bestand welke u zojuist geupload heeft veranderd worden. <br />Bewaar het orginele bestand goed. Ongeacht in welke versie de banner gemaakt is, het geconverteerde bestand zal alleen goed te zien zijn met de Flash 4 player (of hoger).<br /><br />";
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
$GLOBALS['strSource'] 					= "Bron";
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
$GLOBALS['strAffiliate']				= "Website";
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
$GLOBALS['strNoAffiliates']				= "Er zijn momenteel geen websites beschikbaar. Om een zone aan te maken, <a href='affiliate-edit.php'>voeg eerst een nieuwe website toe</a> .";
$GLOBALS['strConfirmDeleteAffiliate']			= "Weet u zeker dat u deze uitgever wilt wissen?";
$GLOBALS['strMakePublisherPublic']			= "Maak de zones die eigendom zijn van de uitgever publiekelijk toegankelijk";


// Publisher (properties)
$GLOBALS['strWebsite']					= "Website";
$GLOBALS['strAllowAffiliateModifyInfo'] 		= "Deze gebruiker kan zijn eigen instellingen wijzigen";
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
$GLOBALS['strLogErrorClients'] 				= "Er is een fout opgetreden. De adverteerders konden niet worden opgevraagd vanuit de database.";
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
$GLOBALS['strErrorDBNoDataPlain']			= "Wegens het probleem kon ". MAX_PRODUCT_NAME ." geen gegevens ophalen of versturen. ";
$GLOBALS['strErrorDBNoDataSerious']			= "Wegens het ernstige problem kon ". MAX_PRODUCT_NAME ."  geen gegevens ophalen";
$GLOBALS['strErrorDBCorrupt']				= "De database tabel is waarschijnlijk beschadigd en moet gerepareerd worden. Voor meer informatie over het repareren van beschadigde tabellen lees het hoofdstuk <i>Troubleshooting</i> van de <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']				= "Neem a.u.b. contact op met de beheerder van deze server en breng hem op de hoogte van uw probleem.";
$GLOBALS['strErrorDBSubmitBug']				= "Indien dit probleem te reproduceren is, dan is het mogelijk dat het veroorzaakt wordt door een fout in ". MAX_PRODUCT_NAME .". Reporteer de volgende gegevens aan de makers van ". MAX_PRODUCT_NAME .". Probeer tevens de actie die deze fout tot gevolg hebben zo duidelijk mogelijk te omschrijven.";
$GLOBALS['strMaintenanceNotActive']			= "Het onderhoudsscript heeft niet gedraaid in de laatste 24 uur. \nHet script moet elk uur gedraaid worden ander zal ". MAX_PRODUCT_NAME ." niet \ncorrect functioneren.\n\nLees a.u.b. de Administrator guide voor meer informatie \n over het instellen van het onderhoudsscript.";


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



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strStartOver'] = "Start over";
$GLOBALS['strTrackerVariables'] = "Tracker-variabelen";
$GLOBALS['strLogoutURL'] = "URL om te worden afgemeld. <br />Laat leeg voor standaard";
$GLOBALS['strAppendTrackerCode'] = "Append tracker-code";
$GLOBALS['strStatusDuplicate'] = "Dubbel";
$GLOBALS['strPriorityOptimisation'] = "Diversen";
$GLOBALS['strCollectedAllStats'] = "Alle statistieken";
$GLOBALS['strCollectedToday'] = "Vandaag";
$GLOBALS['strCollectedYesterday'] = "Gisteren";
$GLOBALS['strCollectedThisWeek'] = "Deze week";
$GLOBALS['strCollectedLastWeek'] = "Afgelopen week";
$GLOBALS['strCollectedThisMonth'] = "Deze maand";
$GLOBALS['strCollectedLastMonth'] = "Afgelopen maand";
$GLOBALS['strCollectedLast7Days'] = "Afgelopen 7 dagen";
$GLOBALS['strCollectedSpecificDates'] = "specifieke data";
$GLOBALS['strAdmin'] = "admin";
$GLOBALS['strNotice'] = "Notitie";
$GLOBALS['strPriorityLevel'] = "Prioriteitslevel ";
$GLOBALS['strPriorityTargeting'] = "Distributie ";
$GLOBALS['strLimitations'] = "Limitaties ";
$GLOBALS['strCapping'] = "Plafonnering ";
$GLOBALS['strVariableDescription'] = "Beschrijving";
$GLOBALS['strVariables'] = "Variabele";
$GLOBALS['strStatsVariables'] = "Variabele";
$GLOBALS['strComments'] = "Reacties";
$GLOBALS['strUsernameOrPasswordWrong'] = "De gebruikersnaam en/of wachtwoord zijn niet juist. Gelieve opnieuw te proberen";
$GLOBALS['strDuplicateAgencyName'] = "De gebruikersnaam die u wenst is al reeds in gebruik, gelieve een andere gebruikersnaam te gebruiken";
$GLOBALS['strRequests'] = "Aanvragen";
$GLOBALS['strConversions'] = "Conversies ";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCNVR'] = "Verkoop ratio";
$GLOBALS['strTotalConversions'] = "Totaal conversies";
$GLOBALS['strConversionCredits'] = "Conversies krediet";
$GLOBALS['strDateTime'] = "Datum tijd";
$GLOBALS['strTrackerID'] = "Tracker-ID";
$GLOBALS['strTrackerName'] = "Tracker naam";
$GLOBALS['strCampaignID'] = "Campagne-ID";
$GLOBALS['strCampaignName'] = "Campagne naam";
$GLOBALS['strStatsAction'] = "Actie";
$GLOBALS['strWindowDelay'] = "Scherm vertraging";
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Maandelijkse opstal";
$GLOBALS['strBreakdownByDay'] = "Dagen";
$GLOBALS['strBreakdownByWeek'] = "Weken";
$GLOBALS['strSingleMonth'] = "Maand";
$GLOBALS['strBreakdownByMonth'] = "Maand";
$GLOBALS['strDayOfWeek'] = "Dag van de week";
$GLOBALS['strBreakdownByDow'] = "Dag van de week";
$GLOBALS['strBreakdownByHour'] = "Uur";
$GLOBALS['strHiddenAdvertiser'] = "Adverteerder";
$GLOBALS['strChars'] = "tekens";
$GLOBALS['strAllowClientViewTargetingStats'] = "Laat deze gebruiker de gerichte statistieken bekijken";
$GLOBALS['strCsvImportConversions'] = "Deze gebruiker kan offline conversies importeren";
$GLOBALS['strHiddenCampaign'] = "Campagne";
$GLOBALS['strLinkedCampaigns'] = "Gelinkte campagnes";
$GLOBALS['strConfirmDeleteAllCampaigns'] = "Weet je zeker dat je alle campagnes van deze adverteerder wilt verwijderen?";
$GLOBALS['strShowParentAdvertisers'] = "Laat huidige adverteerders zien";
$GLOBALS['strHideParentAdvertisers'] = "Verberg huidige adverteerders";
$GLOBALS['strContractDetails'] = "Contract details";
$GLOBALS['strInventoryDetails'] = "Inventaris details";
$GLOBALS['strPriorityInformation'] = "Prioriteit in relatie met andere campagnes";
$GLOBALS['strPriorityHigh'] = "\- Betaalde campagnes";
$GLOBALS['strPriorityLow'] = "Gehuisde en onbetaalde campagnes";
$GLOBALS['strHiddenAd'] = "advertentie";
$GLOBALS['strHiddenTracker'] = "Banner";
$GLOBALS['strTracker'] = "Banner";
$GLOBALS['strHiddenZone'] = "Zone";
$GLOBALS['strSelectUnselectAll'] = "Selecteer/deselecteer alles";
$GLOBALS['strExclusive'] = "Exclusief ";
$GLOBALS['strExpirationDateComment'] = "Campagne zal eindigen op het einde van deze dag";
$GLOBALS['strActivationDateComment'] = "Campagne zal beginnen aan het begin van deze dag";
$GLOBALS['strRevenueInfo'] = "Inkomsten informatie";
$GLOBALS['strImpressionsRemaining'] = "Resterende impressies ";
$GLOBALS['strClicksRemaining'] = "Resterende kliks";
$GLOBALS['strConversionsRemaining'] = "Resterende conversies";
$GLOBALS['strImpressionsBooked'] = "Geboekte impressies";
$GLOBALS['strClicksBooked'] = "Geboekte kliks";
$GLOBALS['strConversionsBooked'] = "geboekte conversies";
$GLOBALS['strOptimise'] = "Optimaliseer ";
$GLOBALS['strAnonymous'] = "Verberg de adverteerder en websites van deze campagne";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "De prioriteit van deze campagne is laag, \nterwijl het gewicht op nul is gezet of niet \ngespecificeerd is. Dit zal er voor zorgen dat de campagne \ngedeactiveerd wordt en de banners zullen niet getoond \nworden totdat het gewicht aangepast is. \n\nWeet u zeker dat u door wilt gaan?";
$GLOBALS['strCampaignWarningExclusiveNoWeight'] = "De prioriteit van deze campagne is laag, \nterwijl het gewicht op nul is gezet of niet \ngespecificeerd is. Dit zal er voor zorgen dat de campagne \ngedeactiveerd wordt en de banners zullen niet getoond \nworden totdat het gewicht aangepast is. \n\nWeet u zeker dat u door wilt gaan?";
$GLOBALS['strTrackerOverview'] = "Banner overzicht";
$GLOBALS['strAddTracker'] = "Voeg nieuwe banner toe";
$GLOBALS['strAddTracker_Key'] = "<u>V</u>oeg een banner toe";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Weet je zeker dat je alle campagnes van deze adverteerder wilt verwijderen?";
$GLOBALS['strConfirmDeleteTracker'] = "Weet u zeker dat u deze banner wilt verwijderen?";
$GLOBALS['strDeleteAllTrackers'] = "Verwijder alle banners";
$GLOBALS['strTrackerProperties'] = "Banner eigenschappen";
$GLOBALS['strLog'] = "Log?";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strUniqueWindow'] = "Uniek scherm";
$GLOBALS['strClick'] = "AdClicks";
$GLOBALS['strView'] = "Bekijk";
$GLOBALS['strUploadOrKeepAlt'] = "Wilt u uw bestaande afbeelding <br />houden, of wilt u een <br />nieuwe afbeelding uploaden?";
$GLOBALS['strGreaterThan'] = "is later dan";
$GLOBALS['strWeekDays'] = "Weekdagen";
$GLOBALS['strCity'] = "Stad";
$GLOBALS['strDeliveryCappingReset'] = "Reset vertoningentellers na:";
$GLOBALS['strDeliveryCappingTotal'] = "in totaal";
$GLOBALS['strDeliveryCappingSession'] = "per sessie";
$GLOBALS['strAffiliateInvocation'] = "Invocatiecode";
$GLOBALS['strInactiveAffiliatesHidden'] = "niet-actieve banner(s) verborgen";
$GLOBALS['strAllowAffiliateZoneStats'] = "Laat deze gebruiker de gerichte statistieken bekijken";
$GLOBALS['strPaymentInformation'] = "Betalingsinformatie ";
$GLOBALS['strAddress'] = "Adres";
$GLOBALS['strPostcode'] = "Postcode";
$GLOBALS['strPhone'] = "Telefoon";
$GLOBALS['strFax'] = "Fax";
$GLOBALS['strAccountContact'] = "Account contact";
$GLOBALS['strPayeeName'] = "Naam betaler";
$GLOBALS['strTaxID'] = "Tax ID";
$GLOBALS['strOtherInformation'] = "Andere informatie";
$GLOBALS['strUniqueUsersMonth'] = "unieke gebruikers/maand";
$GLOBALS['strUniqueViewsMonth'] = "Unieke bekijken/maand";
$GLOBALS['strPageRank'] = "Page rank";
$GLOBALS['strCategory'] = "Categorie";
$GLOBALS['strHelpFile'] = "Help bestanden";
$GLOBALS['strInactiveZonesHidden'] = "niet-actieve banner(s) verborgen";
$GLOBALS['strNoTrackersToLink'] = "Er zijn momenteel geen campagnes beschikbaar welke gekoppeld kunnen worden aan deze zone";
$GLOBALS['strConnTypeSale'] = "Bewaren";
$GLOBALS['strNoTargetingStats'] = "Er zijn momenteel geen statistieken beschikbaar";
$GLOBALS['strNoStatsForPeriod'] = "Er zijn momenteel geen statistieken beschikbaar voor de periode van  %s tot %s";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Er zijn momenteel geen statistieken beschikbaar voor de periode van  %s tot %s";
$GLOBALS['strAllAdvertisers'] = "Totaal aantal adverteerders";
$GLOBALS['strAnonAdvertisers'] = "Anonieme adverteerders";
$GLOBALS['strAllPublishers'] = "Alle websites";
$GLOBALS['strAnonPublishers'] = "Anonieme websites";
$GLOBALS['strAllAvailZones'] = "Alle beschikbare zones";
$GLOBALS['strBackToTheList'] = "Ga terug naar verslaglijst ";
$GLOBALS['strLogErrorConversions'] = "Er is een fout opgetreden. De AdViews konden niet worden opgevraagd vanuit de database.";
$GLOBALS['strEmailNoDates'] = "E-mail zone campagnes moeten een start- en einddatum hebben";
$GLOBALS['strSirMadam'] = "Meneer/mevrouw";
$GLOBALS['strMailBannerActivatedSubject'] = "Campagne {id} activeerd";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campagne {id} geactiveerd";
$GLOBALS['strNoMoreConversions'] = "de gekochte AdClicks gebruikt zijn";
$GLOBALS['strNoConversionLoggedInInterval'] = "Er zijn geen AdViews gelogd gedurende de dagen van dit rapport";
$GLOBALS['strYourCampaign'] = "Uw campagne";
$GLOBALS['strTheCampiaignBelongingTo'] = "De campagne behorend bij";
$GLOBALS['strSourceEdit'] = "Verander bronnen";
$GLOBALS['strAgencyManagement'] = "Account beheer";
$GLOBALS['strAgency'] = "Account";
$GLOBALS['strAddAgency'] = "Voeg nieuw account toe";
$GLOBALS['strAddAgency_Key'] = "<u>V</u>oeg een zone toe";
$GLOBALS['strNoAgencies'] = "Er zijn momenteel geen zones gedefinieerd";
$GLOBALS['strConfirmDeleteAgency'] = "Weet u zeker dat u deze zone wilt wissen?";
$GLOBALS['strInactiveAgenciesHidden'] = "niet-actieve banner(s) verborgen";
$GLOBALS['strNoChannels'] = "Er zijn momenteel geen banner gedefinieerd";
$GLOBALS['strConfirmDeleteChannel'] = "Weet u zeker dat u deze banner wilt verwijderen?";
$GLOBALS['strTrackerType'] = "Tracker naam";
$GLOBALS['strForgotPassword'] = "Wachtwoord vergeten?";
$GLOBALS['strPasswordRecovery'] = "Wachtwoord herstellen";
$GLOBALS['strEmailRequired'] = "E-mail is een verplicht veld";
$GLOBALS['strPwdRecEmailNotFound'] = "E-mail adres is niet gevonden";
$GLOBALS['strPwdRecPasswordSaved'] = "Het nieuwe wachtwoord is ingesteld, ga verder om  <a href='index.php'>in te loggen</a>";
$GLOBALS['strPwdRecWrongId'] = "Verkeerde ID";
$GLOBALS['strPwdRecEnterEmail'] = "Geef uw e-mail adres onderaan";
$GLOBALS['strPwdRecEnterPassword'] = "Geef uw nieuw wachtwoord onderaan";
$GLOBALS['strPwdRecResetLink'] = "Wachtwoord reset link";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s wachtwoord herstelling";
$GLOBALS['strDefaultBannerDestination'] = "Standaard bestemmings URL";
$GLOBALS['strValue'] = "Waarde";
$GLOBALS['strLinkNewUser'] = "Link nieuwe gebruiker";
$GLOBALS['strUserAccess'] = "Gebruikerstoegang";
$GLOBALS['strCampaignStatusRunning'] = "Lopend";
$GLOBALS['strCampaignStatusPaused'] = "Gepauzeerd";
$GLOBALS['strCampaignStatusAwaiting'] = "Wachtend";
$GLOBALS['strCampaignStatusExpired'] = "Voltooid";
$GLOBALS['strCampaignPause'] = "Pauze ";
$GLOBALS['strTrackerPreferences'] = "Banner voorkeuren";
$GLOBALS['strBannerPreferences'] = "Banner voorkeuren";
$GLOBALS['strAdvertiserSetup'] = "Adverteerder aanmelden";
$GLOBALS['strAdvertiserSignup'] = "Adverteerder aanmelden";
$GLOBALS['strSelectPublisher'] = "Selecteer website";
$GLOBALS['strSelectZone'] = "Selecteer zone";
$GLOBALS['strMainPreferences'] = "Algemene voorkeuren";
$GLOBALS['strAccountPreferences'] = "Account voorkeuren";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Campagne e-mail rapporteer voorkeuren";
$GLOBALS['strAdminEmailWarnings'] = "Administrator e-mail waarschuwingen";
$GLOBALS['strAgencyEmailWarnings'] = "Agentschap e-mail waarschuwingen";
$GLOBALS['strAdveEmailWarnings'] = "Adverteerder e-mail waarschuwingen ";
$GLOBALS['strFullName'] = "Volledige naam";
$GLOBALS['strEmailAddress'] = "E-mail adres";
$GLOBALS['strUserDetails'] = "Gebruikersdetails";
$GLOBALS['strLanguageTimezone'] = "Taal en tijdzone";
$GLOBALS['strUserInterfacePreferences'] = "Gebruikersinterface voorkeuren";
$GLOBALS['strUserProperties'] = "Gebruiker eigenschappen";
$GLOBALS['strBack'] = "Terug";
$GLOBALS['strUsernameToLink'] = "gebruikersnaam van toegevoegde gebruiker";
$GLOBALS['strEmailToLink'] = "e-mail van toegevoegde gebruiker";
$GLOBALS['strNewUserWillBeCreated'] = "Nieuwe gebruiker wordt aangemaakt";
$GLOBALS['strPermissions'] = "Permissies ";
$GLOBALS['strContactName'] = "Contactnaam";
$GLOBALS['strPwdRecReset'] = "Wachtwoord reset";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Reset wachtwoord van deze gebruiker";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['strAdSenseAccounts'] = "AdSense accounts";
$GLOBALS['strLinkAdSenseAccount'] = "Link AdSense Account";
$GLOBALS['strCreateAdSenseAccount'] = "Maak AdSense account";
$GLOBALS['strEditAdSenseAccount'] = "Verander AdSense account";
$GLOBALS['strAllowCreateAccounts'] = "Laat deze gebruiker toe nieuwe accounts aan te maken";
$GLOBALS['strErrorWhileCreatingUser'] = "Error tijdens creatie gebruiker: %s";
$GLOBALS['strUserLinkedToAccount'] = "Gebruiker is toegevoegd aan account";
$GLOBALS['strUserAccountUpdated'] = "Gebruikersaccount geupdate";
$GLOBALS['strUserUnlinkedFromAccount'] = "Gebruiker is verwijder van het account";
$GLOBALS['strUserWasDeleted'] = "Gebruiker is verwijderd";
$GLOBALS['strWorkingAs'] = "Aan het werken als";
$GLOBALS['strOverallAdvertisers'] = "Adverteerder(s)";
$GLOBALS['strOverallCampaigns'] = "campagne(s)";
$GLOBALS['strTotalRevenue'] = "Totale opbrengst";
$GLOBALS['strImpression'] = "AdViews";
$GLOBALS['strTrackerImageTag'] = "Afbeelding tag";
$GLOBALS['strTrackerJsTag'] = "Javascript tag";
$GLOBALS['strPeriod'] = "Periode";
$GLOBALS['strLinkUserHelpUser'] = "gebruikersnaam";
$GLOBALS['strLinkUserHelpEmail'] = "E-mail adres";
$GLOBALS['strSessionIDNotMatch'] = "Cookie error voor deze sessie, gelieve nogmaals in te loggen";
$GLOBALS['strPasswordRepeat'] = "Herhaal het wachtwoord";
$GLOBALS['strCampaignStatusRestarted'] = "Herstart ";
$GLOBALS['strUserPreferences'] = "Gebruikersvoorkeuren ";
$GLOBALS['strChangePassword'] = "Verander wachtwoord";
$GLOBALS['strChangeEmail'] = "Verander e-mail";
$GLOBALS['strCurrentPassword'] = "Huidig wachtwoord";
$GLOBALS['strChooseNewPassword'] = "Kies nieuw wachtwoord";
$GLOBALS['strReenterNewPassword'] = "Herhaal nieuw wachtwoord";
$GLOBALS['strNameLanguage'] = "Naam en taal";
$GLOBALS['strNotifyPageMessage'] = "Een e-mail is naar u verzonden, deze bevat een link dat u de mogelijkheid bied om uw wachtwoord te resetten en in te loggen. <br />Gelieve enkele minuten te wachten eer de e-mail aankomt.<br />Indien u geen e-mail ontvangt, gelieve uw spam map na te kijken.<br /><a href='index.php'>Ga terug naar de login pagina.</a>";
$GLOBALS['strRequiredField'] = "Verplicht veld";
$GLOBALS['strLinkUser'] = "Voeg gebruiker toe";
$GLOBALS['strLinkUser_Key'] = "Voeg <u>G</u>ebruiker toe";
$GLOBALS['strLastLoggedIn'] = "Laatst aangemeld";
$GLOBALS['strUnlink'] = "Verwijder";
$GLOBALS['strUnlinkAndDelete'] = "Verwijder en verwijder gebruiker";
$GLOBALS['strUnlinkUser'] = "Verwijder gebruiker";
$GLOBALS['strUnlinkUserConfirmBody'] = "Weet u zeker dat u deze gebruiker wilt verwijderen?";
$GLOBALS['strDeadLink'] = "Deze link is ongeldig";
$GLOBALS['strNoPlacement'] = "Geselecteerde campagne bestaat niet. probeer deze <a href='{link}'>link</a> eens";
$GLOBALS['strNoAdvertiser'] = "Geselecteerde adverteerder bestaat niet. Probeer deze <a href='{link}'>link</a> eens";
$GLOBALS['strAdvertiserSignupLink'] = "Adverteerder aanmelden";
$GLOBALS['strAdvertiserSignupOption'] = "Adverteerder aanmelden";
$GLOBALS['strCampaignStatusDeleted'] = "Verwijder";
$GLOBALS['strTrackers'] = "Banner";
$GLOBALS['strWebsiteURL'] = "Website URL";
$GLOBALS['strTrackerCodeSubject'] = "Append tracker-code";
$GLOBALS['strStatsArea'] = "Gebied";
$GLOBALS['strDaysAgo'] = "Dagen te gaan";
$GLOBALS['strCampaignStop'] = "Campagne geschiedenis";
$GLOBALS['strERPM'] = "CPM";
$GLOBALS['strERPC'] = "CPC";
$GLOBALS['strERPS'] = "CPM";
$GLOBALS['strEIPM'] = "CPM";
$GLOBALS['strEIPC'] = "CPC";
$GLOBALS['strEIPS'] = "CPM";
$GLOBALS['strECPM'] = "CPM";
$GLOBALS['strECPC'] = "CPC";
$GLOBALS['strECPS'] = "CPM";
$GLOBALS['strEPPM'] = "CPM";
$GLOBALS['strEPPC'] = "CPC";
$GLOBALS['strEPPS'] = "CPM";
$GLOBALS['strCheckForUpdates'] = "Controleer voor updates";
$GLOBALS['strFromVersion'] = "Van versie";
$GLOBALS['strToVersion'] = "Naar versie";
$GLOBALS['strInstallation'] = "Installatie";
$GLOBALS['strBackupDeleteConfirm'] = "Weet je zeker dat je alle back-ups wilt verwijderen, die gecreëerd zijn van deze upgrade?";
$GLOBALS['strAgencies'] = "Account";
$GLOBALS['strAccount'] = "Account";
$GLOBALS['strAccountUserAssociation'] = "Account gebruikersgroep";
$GLOBALS['strImage'] = "Afbeelding";
$GLOBALS['strCampaignZoneAssociation'] = "Campagne zonegroep";
$GLOBALS['strAccountPreferenceAssociation'] = "Account voorkeurengroep";
$GLOBALS['strUnsavedChanges'] = "Je hebt onopgeslagen zken op deze pagina, weet zeker dat alle  \"Save Changes\" zijn gedaan";
$GLOBALS['strImpressionSR'] = "AdViews";
$GLOBALS['str_de'] = "Duits";
$GLOBALS['str_en'] = "Engels";
$GLOBALS['str_es'] = "Spaans";
$GLOBALS['str_fa'] = "Perzisch ";
$GLOBALS['str_fr'] = "Frans";
$GLOBALS['str_he'] = "Hebreeuws ";
$GLOBALS['str_hu'] = "Hongaars";
$GLOBALS['str_id'] = "Indonesisch ";
$GLOBALS['str_it'] = "Italiaans";
$GLOBALS['str_ja'] = "Japans";
$GLOBALS['str_ko'] = "Koreaans";
$GLOBALS['str_nl'] = "Nederlands";
$GLOBALS['str_pl'] = "Pools";
$GLOBALS['str_ro'] = "Romeens";
$GLOBALS['str_ru'] = "Russisch ";
$GLOBALS['str_sl'] = "Sloveens ";
$GLOBALS['str_tr'] = "Turks";
$GLOBALS['strGlobalSettings'] = "Algemene instellingen";
$GLOBALS['strMyAccount'] = "Mijn account ";
$GLOBALS['strSwitchTo'] = "Ga naar";
$GLOBALS['strRevenue'] = "Opbrengst";
$GLOBALS['str_ar'] = "Arabisch";
$GLOBALS['str_bg'] = "Hongaars";
$GLOBALS['str_da'] = "Deens";
$GLOBALS['str_el'] = "Grieks";
$GLOBALS['str_hr'] = "Kroaats";
$GLOBALS['str_lt'] = "Litouws ";
$GLOBALS['str_ms'] = "Maleisisch ";
$GLOBALS['str_sk'] = "Slowaaks ";
$GLOBALS['str_sv'] = "Zweeds";
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "Systeem bericht";
$GLOBALS['strDashboardErrorMsg806'] = "Server fout";
$GLOBALS['strActions'] = "Actie";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strNoClientsForBanners'] = "Er zijn momenteel geen adverteerders beschikbaar. Om een campagne aan te maken, <a href='advertiser-edit.php'>voeg eerst een nieuwe adverteerder toe</a>.";
$GLOBALS['strAdvertiserCampaigns'] = "Adverteerders & Campagnes";
$GLOBALS['strCampaignStatusInactive'] = "actief";
$GLOBALS['strCampaignType'] = "Campagne naam";
$GLOBALS['strContract'] = "Contactpersoon";
$GLOBALS['strStandardContract'] = "Contactpersoon";
$GLOBALS['strBannerToCampaign'] = "Uw campagne";
$GLOBALS['strBannersOfCampaign'] = "in";
$GLOBALS['strWebsiteZones'] = "Uitgevers & Zones";
$GLOBALS['strZoneToWebsite'] = "Alle websites";
$GLOBALS['strNoZonesAddWebsite'] = "Er zijn momenteel geen websites beschikbaar. Om een zone aan te maken, <a href='affiliate-edit.php'>voeg eerst een nieuwe website toe</a> .";
$GLOBALS['strZonesOfWebsite'] = "in";
$GLOBALS['strPluginPreferences'] = "Algemene voorkeuren";
$GLOBALS['strERPM_short'] = "CPM";
$GLOBALS['strERPC_short'] = "CPC";
$GLOBALS['strERPS_short'] = "CPM";
$GLOBALS['strEIPM_short'] = "CPM";
$GLOBALS['strEIPC_short'] = "CPC";
$GLOBALS['strEIPS_short'] = "CPM";
$GLOBALS['strECPM_short'] = "CPM";
$GLOBALS['strECPC_short'] = "CPC";
$GLOBALS['strECPS_short'] = "CPM";
$GLOBALS['strEPPM_short'] = "CPM";
$GLOBALS['strEPPC_short'] = "CPC";
$GLOBALS['strEPPS_short'] = "CPM";
$GLOBALS['strChannelToWebsite'] = "Alle websites";
$GLOBALS['strChannelsOfWebsite'] = "in";
$GLOBALS['strConfirmDeleteClients'] = "Weet u zeker dat u deze adverteerder wilt verwijderen?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Weet u zeker dat u deze campagne wilt verwijderen?";
$GLOBALS['strConfirmDeleteTrackers'] = "Weet u zeker dat u deze banner wilt verwijderen?";
$GLOBALS['strNoBannersAddCampaign'] = "Er zijn momenteel geen websites beschikbaar. Om een zone aan te maken, <a href='affiliate-edit.php'>voeg eerst een nieuwe website toe</a> .";
$GLOBALS['strNoBannersAddAdvertiser'] = "Er zijn momenteel geen websites beschikbaar. Om een zone aan te maken, <a href='affiliate-edit.php'>voeg eerst een nieuwe website toe</a> .";
$GLOBALS['strConfirmDeleteBanners'] = "Weet u zeker dat u deze banner wilt verwijderen?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Weet u zeker dat u deze uitgever wilt wissen?";
$GLOBALS['strConfirmDeleteZones'] = "Weet u zeker dat u deze zone wilt wissen?";
$GLOBALS['strActualImpressions'] = "AdViews";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strClicks_short'] = "AdClicks";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strNoChannelsAddWebsite'] = "Er zijn momenteel geen websites beschikbaar. Om een zone aan te maken, <a href='affiliate-edit.php'>voeg eerst een nieuwe website toe</a> .";
$GLOBALS['strConfirmDeleteChannels'] = "Weet u zeker dat u deze banner wilt verwijderen?";
$GLOBALS['strSite'] = "Afmetingen";
$GLOBALS['strHiddenWebsite'] = "Website";
$GLOBALS['strYouHaveNoCampaigns'] = "Adverteerders & Campagnes";
$GLOBALS['strSyncSettings'] = "Synchronisatieinstellingen";
$GLOBALS['strNoAdminInteface'] = "Het administratiescherm is uitgeschakeld voor onderhoudswerkzaamheden. Dit heeft geen effect aan de aflevering van uw campagnes. ";
$GLOBALS['strHideInactiveOverview'] = "Verberg niet actieve items van de overzichtspagina's";
$GLOBALS['strHiddenPublisher'] = "Website";
$GLOBALS['strClickWindow'] = "Klik scherm";
$GLOBALS['strViewWindow'] = "Vertoning scherm";
$GLOBALS['strMoveUp'] = "Ga naar boven";
$GLOBALS['strMoveDown'] = "Ga naar beneden";
$GLOBALS['strRestart'] = "Herstart ";
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingBanner']['limit'] = "Limiteer banner vertoningen tot";
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['limit'] = "Limiteer campagne vertoningen tot:";
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['limit'] = "Limiteer zone vertoningen tot:";
$GLOBALS['strPickCategory'] = "\- haal een categorie op -";
$GLOBALS['strPickCountry'] = "\- haal een land op -";
$GLOBALS['strPickLanguage'] = "\- haal een taal op -";
$GLOBALS['strNoWebsites'] = "Alle websites";
$GLOBALS['strSomeWebsites'] = "Alle websites";
$GLOBALS['strHide'] = "Verberg:";
$GLOBALS['strShow'] = "Laat zien:";
$GLOBALS['strDeliveryBanner'] = "Banner afleveringsinstellingen";
$GLOBALS['strIncovationDefaults'] = "aanroep standaards";
$GLOBALS['strIn'] = "in";
$GLOBALS['strLinkNewUser_Key'] = "Voeg <u>G</u>ebruiker toe";
$GLOBALS['strNoDataToDisplay'] = "Er is geen data om te tonen";
$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Knop 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Knop 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Halve Banner (234 x 60)";
$GLOBALS['strIab']['IAB_LeaderBoard(728x90)*'] = "IAB Leader Board (728 x 90) *";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Vierkante knop (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rechthoekig (180 x 150) *";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Vierkante Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB verticale Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium rechthoekig (300 x 250) *";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Groot rechthoekig  (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Verticaal rechthoekig (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wijde Skyscraper (160 x 600) *";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "Upgrade compleet";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "Upgrade mislukt";
$GLOBALS['phpAds_hlp_my_header'] = "Je moet hier het domein van de header bestanden (vb. /home/login/www/header.htm) geven om een header en/of footer te hebben op elke pagina in de beheerder omgeving. Je kan zowel tekst als html ingeven in deze bestanden (indien je html in een van deze bestanden wenst te gebruiken, gelieve geen tags zoals <body> of <html> te geven).";
$GLOBALS['strReportBug'] = "Meld bug";
$GLOBALS['strSameWindow'] = "Zelfde scherm";
$GLOBALS['strNewWindow'] = "Nieuw scherm";
$GLOBALS['strClick-ThroughRatio'] = "Click-Through Ratio";
$GLOBALS['strImpressionSRShort'] = "AdViews";
$GLOBALS['strClicksShort'] = "AdClicks";
$GLOBALS['strImpressionsShort'] = "AdViews";
$GLOBALS['strVariable'] = "Variabele";
$GLOBALS['strAffiliateExtra'] = "Extra website informatie";
$GLOBALS['strPreference'] = "Voorkeuren";
$GLOBALS['strAccountUserPermissionAssociation'] = "Gebruikersaccount rechten groep";
$GLOBALS['strDeliveryLimitation'] = "Leveringsbeperkingen";
$GLOBALS['str_ID'] = "ID";
$GLOBALS['str_Requests'] = "Aanvragen";
$GLOBALS['str_Impressions'] = "AdViews";
$GLOBALS['str_Clicks'] = "AdClicks";
$GLOBALS['str_CTR'] = "CTR";
?>