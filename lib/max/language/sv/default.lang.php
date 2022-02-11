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

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['day_format'] = "%d-%m";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Hem";
$GLOBALS['strHelp'] = "Hjälp";
$GLOBALS['strStartOver'] = "Börja om";
$GLOBALS['strShortcuts'] = "Genvägar";
$GLOBALS['strActions'] = "Handling";
$GLOBALS['strAndXMore'] = "och %s fler";
$GLOBALS['strAdminstration'] = "Lager";
$GLOBALS['strMaintenance'] = "Underhåll";
$GLOBALS['strProbability'] = "Sannolikhet";
$GLOBALS['strInvocationcode'] = "Publiceringskod";
$GLOBALS['strBasicInformation'] = "Grundläggande Information";
$GLOBALS['strAppendTrackerCode'] = "Hämta spårningskod";
$GLOBALS['strOverview'] = "Översikt";
$GLOBALS['strSearch'] = "<u>S</u>ök";
$GLOBALS['strDetails'] = "Detaljer";
$GLOBALS['strUpdateSettings'] = "Uppdatera inställningar";
$GLOBALS['strCheckForUpdates'] = "Sök efter uppdateringar";
$GLOBALS['strWhenCheckingForUpdates'] = "Vid kontroll av uppdateringar";
$GLOBALS['strCompact'] = "Kompakt";
$GLOBALS['strUser'] = "Användare";
$GLOBALS['strDuplicate'] = "Duplicera";
$GLOBALS['strCopyOf'] = "Kopia av";
$GLOBALS['strMoveTo'] = "Flytta till";
$GLOBALS['strDelete'] = "Radera";
$GLOBALS['strActivate'] = "Aktivera";
$GLOBALS['strConvert'] = "Konvertera";
$GLOBALS['strRefresh'] = "Uppdatera";
$GLOBALS['strSaveChanges'] = "Spara ändringar";
$GLOBALS['strUp'] = "Upp";
$GLOBALS['strDown'] = "Ner";
$GLOBALS['strSave'] = "Spara";
$GLOBALS['strCancel'] = "Avbryt";
$GLOBALS['strBack'] = "Tillbaka";
$GLOBALS['strPrevious'] = "Föregående";
$GLOBALS['strNext'] = "Nästa";
$GLOBALS['strYes'] = "Ja";
$GLOBALS['strNo'] = "Nej";
$GLOBALS['strNone'] = "Inga";
$GLOBALS['strCustom'] = "Anpassad";
$GLOBALS['strDefault'] = "Standard";
$GLOBALS['strUnknown'] = "Okänd";
$GLOBALS['strUnlimited'] = "Obegränsad";
$GLOBALS['strUntitled'] = "Namnlös";
$GLOBALS['strAll'] = "alla";
$GLOBALS['strAverage'] = "Genomsnitt";
$GLOBALS['strOverall'] = "Total";
$GLOBALS['strTotal'] = "Totalt";
$GLOBALS['strFrom'] = "Från";
$GLOBALS['strTo'] = "till";
$GLOBALS['strAdd'] = "Lägg till";
$GLOBALS['strLinkedTo'] = "länkad till";
$GLOBALS['strDaysLeft'] = "Dagar kvar";
$GLOBALS['strCheckAllNone'] = "Markera alla / avmarkera alla";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>E</u>xpandera alla";
$GLOBALS['strCollapseAll'] = "<u>K</u>ollapsa alla";
$GLOBALS['strShowAll'] = "Visa alla";
$GLOBALS['strNoAdminInterface'] = "Administrationen har stängts av pga underhåll. Detta påverkar inte leveranser av era kampanjer.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'Från'-datum måste vara tidigare än 'till'-datum";
$GLOBALS['strFieldContainsErrors'] = "Följande fält innehåller fel:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Innan du kan fortsätta måste du";
$GLOBALS['strFieldFixBeforeContinue2'] = "åtgärda dessa fel.";
$GLOBALS['strMiscellaneous'] = "Diverse";
$GLOBALS['strCollectedAllStats'] = "All statistik";
$GLOBALS['strCollectedToday'] = "Idag";
$GLOBALS['strCollectedYesterday'] = "Igår";
$GLOBALS['strCollectedThisWeek'] = "Denna vecka";
$GLOBALS['strCollectedLastWeek'] = "Förra veckan";
$GLOBALS['strCollectedThisMonth'] = "Denna månad";
$GLOBALS['strCollectedLastMonth'] = "Förra månaden";
$GLOBALS['strCollectedLast7Days'] = "Senaste 7 dagarna";
$GLOBALS['strCollectedSpecificDates'] = "Specifika datum";
$GLOBALS['strValue'] = "Värde";
$GLOBALS['strWarning'] = "Varning";
$GLOBALS['strNotice'] = "Viktigt information";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Instrumentpanelen kan inte visas";
$GLOBALS['strNoCheckForUpdates'] = "Instrumentpanelen kan inte visas om inte<br /> kontrollen för uppdatering är aktiverad.";
$GLOBALS['strEnableCheckForUpdates'] = "Vänligen aktivera inställningen <a href='account-settings-update.php' target='_top'> Sök efter uppdateringar</a> på <br/> <a href='account-settings-update.php' target='_top'> uppdatera inställningar</a> sidan.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "kod";
$GLOBALS['strDashboardSystemMessage'] = "Systemmeddelande";
$GLOBALS['strDashboardErrorHelp'] = "Om felet upprepas vänligen beskriv ditt problem i detalj och lägg upp den på <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Prioritering";
$GLOBALS['strPriorityLevel'] = "Prioriteringsnivå";
$GLOBALS['strOverrideAds'] = "Åsidosätt Kampanjannonser";
$GLOBALS['strHighAds'] = "Kontrakt Kampanjannonser";
$GLOBALS['strECPMAds'] = "eCPM Kampanjannonser";
$GLOBALS['strLowAds'] = "Återstående Kampanjannonser";
$GLOBALS['strLimitations'] = "Leveransregler";
$GLOBALS['strNoLimitations'] = "Inga leveransregler";
$GLOBALS['strCapping'] = "Taksättning";

// Properties
$GLOBALS['strName'] = "Namn";
$GLOBALS['strSize'] = "Storlek";
$GLOBALS['strWidth'] = "Bredd";
$GLOBALS['strHeight'] = "Höjd";
$GLOBALS['strTarget'] = "Mål";
$GLOBALS['strLanguage'] = "Språk";
$GLOBALS['strDescription'] = "Beskrivning";
$GLOBALS['strVariables'] = "Variabler";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Kommentarer";

// User access
$GLOBALS['strWorkingAs'] = "Arbetar som";
$GLOBALS['strWorkingAs_Key'] = "<u>A</u>rbetar som";
$GLOBALS['strWorkingAs'] = "Arbetar som";
$GLOBALS['strSwitchTo'] = "Byt till";
$GLOBALS['strWorkingFor'] = "%s för...";
$GLOBALS['strNoAccountWithXInNameFound'] = "Inga konton med ”%s” i namnet hittas";
$GLOBALS['strRecentlyUsed'] = "Senast använda";
$GLOBALS['strLinkUser'] = "Lägg till användare";
$GLOBALS['strLinkUser_Key'] = "Lägg till <u>a</u>nvändare";
$GLOBALS['strUsernameToLink'] = "Användarnamnet för användaren att lägga till";
$GLOBALS['strNewUserWillBeCreated'] = "Ny användare kommer att skapas";
$GLOBALS['strToLinkProvideEmail'] = "För att lägga till användare, ange användares e-post";
$GLOBALS['strToLinkProvideUsername'] = "För att lägga till användare, ange användarnamn";
$GLOBALS['strUserAccountUpdated'] = "Konto uppdaterat";
$GLOBALS['strUserWasDeleted'] = "Användaren har tagits bort";
$GLOBALS['strUserNotLinkedWithAccount'] = "Sådan användare är inte kopplad till konto";
$GLOBALS['strLinkUserHelpUser'] = "Användarnamn";
$GLOBALS['strLinkUserHelpEmail'] = "e-postadress";
$GLOBALS['strLastLoggedIn'] = "Senast inloggad";
$GLOBALS['strDateLinked'] = "Datum kopplade";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Användaråtkomst";
$GLOBALS['strAdminAccess'] = "Administratörsåtkomst";
$GLOBALS['strUserProperties'] = "Banneregenskaper";
$GLOBALS['strPermissions'] = "Behörigheter";
$GLOBALS['strAuthentification'] = "Autentisering";
$GLOBALS['strWelcomeTo'] = "Välkommen till";
$GLOBALS['strEnterUsername'] = "Ange ditt användarnamn och lösenord för att logga in";
$GLOBALS['strEnterBoth'] = "Vänligen ange både användarnamn och lösenord";
$GLOBALS['strEnableCookies'] = "Du måste aktivera cookies innan du kan använda {$PRODUCT_NAME}";
$GLOBALS['strLogin'] = "Logga in";
$GLOBALS['strLogout'] = "Logga ut";
$GLOBALS['strUsername'] = "Användarnamn";
$GLOBALS['strPassword'] = "Lösenord";
$GLOBALS['strPasswordRepeat'] = "Upprepa lösenord";
$GLOBALS['strAccessDenied'] = "Åtkomst nekad";
$GLOBALS['strUsernameOrPasswordWrong'] = "Användarnamnet och/eller lösenordet var inkorrekt. Vänligen försök igen.";
$GLOBALS['strPasswordWrong'] = "Lösenordet är inkorrekt";
$GLOBALS['strDuplicateClientName'] = "Användarnamnet du angav finns redan, vänligen ange ett annat användarnamn.";
$GLOBALS['strInvalidPassword'] = "Lösenordet är ej giltigt, vänligen använd ett annat lösenord.";
$GLOBALS['strInvalidEmail'] = "Epostadressen har ett ogiltigt format, använd en korrekt epostadress.";
$GLOBALS['strNotSamePasswords'] = "De två lösenorden du angav är inte identiska";
$GLOBALS['strRepeatPassword'] = "Upprepa lösenord";
$GLOBALS['strDeadLink'] = "Din länk är ogiltig.";
$GLOBALS['strNoPlacement'] = "Vald kampanj existerar ej. Prova denna <a href='{link}'>länk</a> istället.";
$GLOBALS['strNoAdvertiser'] = "Vald annonsör existerar ej. Prova denna <a href='{link}'>länk</a> istället.";

// General advertising
$GLOBALS['strRequests'] = "Begäran";
$GLOBALS['strImpressions'] = "Visningar";
$GLOBALS['strClicks'] = "Klick";
$GLOBALS['strConversions'] = "Konverteringar";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Totala klick";
$GLOBALS['strTotalConversions'] = "Totala konverteringar";
$GLOBALS['strDateTime'] = "Datum Tid";
$GLOBALS['strTrackerID'] = "Spårnings ID";
$GLOBALS['strTrackerName'] = "Spårningsnamn";
$GLOBALS['strTrackerImageTag'] = "Bildtagg";
$GLOBALS['strTrackerJsTag'] = "JavaScript-tagg";
$GLOBALS['strBanners'] = "Banners";
$GLOBALS['strCampaigns'] = "Kampanj";
$GLOBALS['strCampaignID'] = "Kampanj ID";
$GLOBALS['strCampaignName'] = "Kampanjnamn";
$GLOBALS['strCountry'] = "Land";
$GLOBALS['strStatsAction'] = "Handling";
$GLOBALS['strWindowDelay'] = "Fönsterdröjsmål";
$GLOBALS['strStatsVariables'] = "Variabler";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceMT'] = "Månadsavgift";
$GLOBALS['strFinanceCTR'] = "CTR";

// Time and date related
$GLOBALS['strDate'] = "Datum";
$GLOBALS['strDay'] = "Dag";
$GLOBALS['strDays'] = "Dagar";
$GLOBALS['strWeek'] = "Vecka";
$GLOBALS['strWeeks'] = "Veckor";
$GLOBALS['strSingleMonth'] = "Månad";
$GLOBALS['strMonths'] = "Månader";
$GLOBALS['strDayOfWeek'] = "Dag i veckan";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'Söndag';
$GLOBALS['strDayFullNames'][1] = 'Måndag';
$GLOBALS['strDayFullNames'][2] = 'Tisdag';
$GLOBALS['strDayFullNames'][3] = 'Onsdag';
$GLOBALS['strDayFullNames'][4] = 'Torsdag';
$GLOBALS['strDayFullNames'][5] = 'Fredag';
$GLOBALS['strDayFullNames'][6] = 'Lördag';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'Sö';
$GLOBALS['strDayShortCuts'][1] = 'Må';
$GLOBALS['strDayShortCuts'][2] = 'Tis';
$GLOBALS['strDayShortCuts'][3] = 'Ons';
$GLOBALS['strDayShortCuts'][4] = 'Tor';
$GLOBALS['strDayShortCuts'][5] = 'Fre';
$GLOBALS['strDayShortCuts'][6] = 'Lör';

$GLOBALS['strHour'] = "Timme";
$GLOBALS['strSeconds'] = "sekunder";
$GLOBALS['strMinutes'] = "minuter";
$GLOBALS['strHours'] = "timmar";

// Advertiser
$GLOBALS['strClient'] = "Annonsör";
$GLOBALS['strClients'] = "Annonsörer";
$GLOBALS['strClientsAndCampaigns'] = "Annonsörer & kampanjer";
$GLOBALS['strAddClient'] = "Lägg till ny annonsör";
$GLOBALS['strClientProperties'] = "Annonsöregenskaper";
$GLOBALS['strNoClients'] = "Det finns inga annonsörer inlagda. För att skapa en kampanj, <a href='advertiser-edit.php'>lägg till en annonsör</a> först.";
$GLOBALS['strConfirmDeleteClient'] = "Vill du verkligen radera den här annonsören?";
$GLOBALS['strConfirmDeleteClients'] = "Vill du verkligen radera den här annonsören?";
$GLOBALS['strHideInactive'] = "Dölj inaktiva";
$GLOBALS['strInactiveAdvertisersHidden'] = "dolda inaktiva annonsörer";
$GLOBALS['strAdvertiserCampaigns'] = "Annonsörer & kampanjer";

// Advertisers properties
$GLOBALS['strContact'] = "Kontakt";
$GLOBALS['strContactName'] = "Kontaktens namn";
$GLOBALS['strEMail'] = "Epost";
$GLOBALS['strSendAdvertisingReport'] = "Eposta leveransrapport för kampanj";
$GLOBALS['strNoDaysBetweenReports'] = "Antal dagar mellan leveransrapport för kampanj";
$GLOBALS['strSendDeactivationWarning'] = "Eposta när en kampanj automatiskt aktiveras/avaktiveras";
$GLOBALS['strAllowClientModifyBanner'] = "Tillåt användaren att redigera egna annonser";
$GLOBALS['strAllowClientDisableBanner'] = "Tillåt användaren att avaktivera egna annonser";
$GLOBALS['strAllowClientActivateBanner'] = "Tillåt användaren att aktivera egna annonser";
$GLOBALS['strAllowAuditTrailAccess'] = "Låt den här användaren få åtkomst till revisionsspårning";

// Campaign
$GLOBALS['strCampaign'] = "Kampanj";
$GLOBALS['strCampaigns'] = "Kampanj";
$GLOBALS['strAddCampaign'] = "Lägg till ny kampanj";
$GLOBALS['strAddCampaign_Key'] = "Lägg till <u>n</u>y kampanj";
$GLOBALS['strCampaignForAdvertiser'] = "för annonsören";
$GLOBALS['strLinkedCampaigns'] = "Länkade kampanjer";
$GLOBALS['strCampaignProperties'] = "Kampanjegenskaper";
$GLOBALS['strCampaignOverview'] = "Kampanjöversikt";
$GLOBALS['strCampaignHistory'] = "Kampanjstatistik";
$GLOBALS['strNoCampaigns'] = "Det finns för närvarande inga kampanjer definierade för denna annonsör.";
$GLOBALS['strConfirmDeleteCampaign'] = "Vill du verkligen radera den här kampanjen?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Vill du verkligen radera den här kampanjen?";
$GLOBALS['strShowParentAdvertisers'] = "Visa överordnade annonsörer";
$GLOBALS['strHideParentAdvertisers'] = "Dölj överordnade annonsörer";
$GLOBALS['strHideInactiveCampaigns'] = "Dölj inaktiva kampanjer";
$GLOBALS['strInactiveCampaignsHidden'] = "inaktiva kampanjer dolda";
$GLOBALS['strPriorityInformation'] = "Prioritet i förhållande till andra kampanjer";
$GLOBALS['strHiddenCampaign'] = "Kampanj";
$GLOBALS['strHiddenAd'] = "Annons";
$GLOBALS['strHiddenAdvertiser'] = "Annonsör";
$GLOBALS['strHiddenWebsite'] = "Webbsida";
$GLOBALS['strHiddenZone'] = "Zon";
$GLOBALS['strCampaignDelivery'] = "Kampanjen leverans";
$GLOBALS['strCompanionPositioning'] = "Kompanjonpositionering";
$GLOBALS['strSelectUnselectAll'] = "Markera / avmarkera alla";
$GLOBALS['strCampaignsOfAdvertiser'] = "av"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Beräknad för alla kampanjer";
$GLOBALS['strCalculatedForThisCampaign'] = "Beräknad för denna kampanj";
$GLOBALS['strLinkingZonesProblem'] = "Ett problemet uppstod när zonen skulle länkas";
$GLOBALS['strUnlinkingZonesProblem'] = "Ett problem uppstod när zonen skulle avlänkas";
$GLOBALS['strZonesSearch'] = "Sök";
$GLOBALS['strNoWebsitesAndZones'] = "Inga webbsidor eller zoner";
$GLOBALS['strLinked'] = "Länkad";
$GLOBALS['strAvailable'] = "Tillgängligt";
$GLOBALS['strShowing'] = "Visar";
$GLOBALS['strEditZone'] = "Redigera zon";
$GLOBALS['strEditWebsite'] = "Redigera webbplats";


// Campaign properties
$GLOBALS['strDontExpire'] = "Inte förfalla/utgå";
$GLOBALS['strActivateNow'] = "Börja omedelbart";
$GLOBALS['strSetSpecificDate'] = "Specifikt datum";
$GLOBALS['strLow'] = "Låg";
$GLOBALS['strHigh'] = "Hög";
$GLOBALS['strExpirationDate'] = "Slutdatum";
$GLOBALS['strExpirationDateComment'] = "Kampanjen avslutas i slutet av denna dag";
$GLOBALS['strActivationDate'] = "Startdatum";
$GLOBALS['strActivationDateComment'] = "Kampanjen påbörjas vid början av denna dag";
$GLOBALS['strImpressionsRemaining'] = "Återstående visningar";
$GLOBALS['strClicksRemaining'] = "Återstående klick";
$GLOBALS['strConversionsRemaining'] = "Återstående konverteringar";
$GLOBALS['strImpressionsBooked'] = "Bokade visningar";
$GLOBALS['strClicksBooked'] = "Bokade klick";
$GLOBALS['strConversionsBooked'] = "Bokade konverteringar";
$GLOBALS['strCampaignWeight'] = "Kampanj vikt";
$GLOBALS['strAnonymous'] = "Dölj kampanjens annonsörer och sajter.";
$GLOBALS['strTargetPerDay'] = "per dag.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Kampanjens prioriteringar är satta till låg,
men vikten är satt till noll eller har inte
specificerats. Kampanjen kommer att
avaktiveras och dess banners kommer ej att levereras
tills vikten sätts till giltigt nummer.

Vill du fortsätta?";
$GLOBALS['strCampaignWarningNoTarget'] = "Kampanjens prioritet är satt till hög,
men målantal för visningar är inte angivet.
Detta gör att kampanjen blir avaktiverad och
dess banners kommer inte att levereras tills
giltigt målantal anges

Är du säker på att du vill fortsätta?";
$GLOBALS['strCampaignStatusPending'] = "Pågående";
$GLOBALS['strCampaignStatusInactive'] = "aktiv";
$GLOBALS['strCampaignStatusRunning'] = "Körs";
$GLOBALS['strCampaignStatusPaused'] = "Pause";
$GLOBALS['strCampaignStatusAwaiting'] = "Väntar";
$GLOBALS['strCampaignStatusExpired'] = "Avslutad";
$GLOBALS['strCampaignStatusApproval'] = "Väntar på godkännande »";
$GLOBALS['strCampaignStatusRejected'] = "Avvisad";
$GLOBALS['strCampaignStatusAdded'] = "Tillagd";
$GLOBALS['strCampaignStatusStarted'] = "Startad";
$GLOBALS['strCampaignStatusRestarted'] = "Starta om";
$GLOBALS['strCampaignStatusDeleted'] = "Radera";
$GLOBALS['strCampaignType'] = "Kampanjnamn";
$GLOBALS['strType'] = "Typ";
$GLOBALS['strContract'] = "Kontakt";
$GLOBALS['strOverride'] = "Åsidosätt";
$GLOBALS['strStandardContract'] = "Kontakt";
$GLOBALS['strRemnant'] = "Kvarleva";
$GLOBALS['strPricing'] = "Prissättning";
$GLOBALS['strPricingModel'] = "Prismodell";
$GLOBALS['strSelectPricingModel'] = "--Välj modell--";
$GLOBALS['strMinimumImpressions'] = "Lägsta antal dagliga visningar";
$GLOBALS['strLimit'] = "Gräns";
$GLOBALS['strCookies'] = "Kakor";

// Tracker
$GLOBALS['strTrackers'] = "Tracker";
$GLOBALS['strAddTracker'] = "Lägg till ny spårning";
$GLOBALS['strTrackerForAdvertiser'] = "för annonsören";
$GLOBALS['strNoTrackers'] = "Det finns för närvarande inga spårare definierade för denna annonsör";
$GLOBALS['strConfirmDeleteTrackers'] = "Will du verkligen kasta denna tracker?";
$GLOBALS['strConfirmDeleteTracker'] = "Vill du verkligen radera denna spårare?";
$GLOBALS['strTrackerProperties'] = "Spårningsegenskaper";
$GLOBALS['strDefaultStatus'] = "Standard status";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strLinkedTrackers'] = "Länkad spårning";
$GLOBALS['strTrackerInformation'] = "Spårningsinformation";
$GLOBALS['strConversionWindow'] = "Konverteringsfönster";
$GLOBALS['strUniqueWindow'] = "Unikt fönster";
$GLOBALS['strClick'] = "Klicka";
$GLOBALS['strView'] = "Visa";
$GLOBALS['strArrival'] = "Ankomst";
$GLOBALS['strManual'] = "Manuell";
$GLOBALS['strImpression'] = "Visningar";
$GLOBALS['strConversionType'] = "Konversionstyp";
$GLOBALS['strLinkCampaignsByDefault'] = "Länka nyskapade kampanjer som standard";
$GLOBALS['strIPAddress'] = "IP Adress";

// Banners (General)
$GLOBALS['strBanner'] = "Annons";
$GLOBALS['strBanners'] = "Banners";
$GLOBALS['strAddBanner'] = "Lägg till ny annons";
$GLOBALS['strAddBanner_Key'] = "Lägg till <u>n</u>y annons";
$GLOBALS['strBannerToCampaign'] = "Din kampanj";
$GLOBALS['strShowBanner'] = "Visa annonser";
$GLOBALS['strBannerProperties'] = "Annonsegenskaper";
$GLOBALS['strNoBanners'] = "Det finns för närvarande inga annonser definierade till den här kampanjen.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Det finns inga sajter inlagda. För att skapa en zon, <a href='affiliate-edit.php'>lägg till ny sajt</a> först.";
$GLOBALS['strConfirmDeleteBanner'] = "Vill du verkligen radera den här annonsen?";
$GLOBALS['strConfirmDeleteBanners'] = "Vill du verkligen radera den här bannern?";
$GLOBALS['strShowParentCampaigns'] = "Visa överordnade kampanjer";
$GLOBALS['strHideParentCampaigns'] = "Dölj överordnade kampanjer";
$GLOBALS['strHideInactiveBanners'] = "Dölj inaktiva annonser";
$GLOBALS['strInactiveBannersHidden'] = "inaktiva annonser dolda";
$GLOBALS['strWarningMissing'] = "Varning, förmodligen saknas _";
$GLOBALS['strWarningMissingClosing'] = "_ avslutande tag \">\"";
$GLOBALS['strWarningMissingOpening'] = "_ öppningstag \"<\"";
$GLOBALS['strSubmitAnyway'] = "Skicka ändå";
$GLOBALS['strBannersOfCampaign'] = "i"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Vänligen välj annonstyp";
$GLOBALS['strMySQLBanner'] = "Ladda upp en lokal annons till databasen";
$GLOBALS['strWebBanner'] = "Ladda upp en lokal annons till webbservern";
$GLOBALS['strURLBanner'] = "Länka en extern annons";
$GLOBALS['strHTMLBanner'] = "Skapa en HTML annons";
$GLOBALS['strTextBanner'] = "Skapa en textannons";
$GLOBALS['strUploadOrKeep'] = "Vill du behålla <br />befintlig bild, eller vill du<br />ladda upp ny bild?";
$GLOBALS['strNewBannerFile'] = "Välj vilken bild du vill <br />använda för den här annonsen<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Välj den säkerhets bild du <br />vill använda i fall vissa webbläsare <br />inte stödjer rich media<br /><br />";
$GLOBALS['strNewBannerURL'] = "Bild URL (inkl. http://)";
$GLOBALS['strURL'] = "Destinations URL (inkl. http://)";
$GLOBALS['strKeyword'] = "Nyckelord";
$GLOBALS['strTextBelow'] = "Text under bild";
$GLOBALS['strWeight'] = "Vikt";
$GLOBALS['strStatusText'] = "Statustext";
$GLOBALS['strBannerWeight'] = "Bannervikt";
$GLOBALS['strAdserverTypeGeneric'] = "Generisk HTML banner";
$GLOBALS['strGenericOutputAdServer'] = "Generisk";
$GLOBALS['strBackToBanners'] = "Tillbaka till banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Använd WYSIWYG HTML Editor";

// Banner (advanced)

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Leveransinställningar";
$GLOBALS['strACL'] = "Leveransinställningar";
$GLOBALS['strEqualTo'] = "är lika med";
$GLOBALS['strDifferentFrom'] = "skiljer sig från";
$GLOBALS['strLaterThan'] = "är senare än";
$GLOBALS['strLaterThanOrEqual'] = "är senare än eller lika med";
$GLOBALS['strEarlierThan'] = "är tidigare än";
$GLOBALS['strEarlierThanOrEqual'] = "är tidigare än eller lika med";
$GLOBALS['strContains'] = "innehåller";
$GLOBALS['strNotContains'] = "innehåller inte";
$GLOBALS['strGreaterThan'] = "är större än";
$GLOBALS['strLessThan'] = "är mindre än";
$GLOBALS['strGreaterOrEqualTo'] = "är större eller lika med";
$GLOBALS['strLessOrEqualTo'] = "är mindre eller lika med";
$GLOBALS['strAND'] = "OCH";                          // logical operator
$GLOBALS['strOR'] = "ELLER";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Visa endast den här annonsen när:";
$GLOBALS['strWeekDays'] = "Veckodagar";
$GLOBALS['strTime'] = "Tid";
$GLOBALS['strDomain'] = "Domän";
$GLOBALS['strSource'] = "Källa";
$GLOBALS['strBrowser'] = "Webbläsare";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Leveransregler";

$GLOBALS['strDeliveryCappingReset'] = "Återställ visningsräknare efter:";
$GLOBALS['strDeliveryCappingTotal'] = "totalt";
$GLOBALS['strDeliveryCappingSession'] = "per session";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['limit'] = "Begränsa annonsvisningar till:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['limit'] = "Begränsa kampanjvisningar till:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['limit'] = "Begränsa zonvisningar till:";

// Website
$GLOBALS['strAffiliate'] = "Webbsida";
$GLOBALS['strAffiliates'] = "Webbsidor";
$GLOBALS['strAffiliatesAndZones'] = "Webbsidor & Zoner";
$GLOBALS['strAddNewAffiliate'] = "Lägg till ny webbsida";
$GLOBALS['strAffiliateProperties'] = "Egenskaper för webbsida";
$GLOBALS['strAffiliateHistory'] = "Webbsida Statistik";
$GLOBALS['strNoAffiliates'] = "Det finns inga webbsidor inlagda. För att skapa en zon, <a href='affiliate-edit.php'>lägg till ny webbsida</a> först.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Vill du verkligen radera den här webbsidan?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Vill du verkligen radera den här sajten?";
$GLOBALS['strInactiveAffiliatesHidden'] = "inaktiva webbsidor dolda";
$GLOBALS['strShowParentAffiliates'] = "Visa överordnade webbsidor";
$GLOBALS['strHideParentAffiliates'] = "Dölj överordnade webbsidor";

// Website (properties)
$GLOBALS['strWebsite'] = "Webbsida";
$GLOBALS['strWebsiteURL'] = "Webbadress";
$GLOBALS['strAllowAffiliateModifyZones'] = "Tillåt användaren att modifiera egna zoner";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Tillåt användaren att länka annonser till egna zoner";
$GLOBALS['strAllowAffiliateAddZone'] = "Tillåt användaren att skapa nya zoner";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Tillåt användaren att radera befintliga zoner";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Tillåt användaren att generera publiceringskoder";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Postnummer";
$GLOBALS['strCountry'] = "Land";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Webbsajter & zoner";

// Zone
$GLOBALS['strZone'] = "Zon";
$GLOBALS['strZones'] = "Zoner";
$GLOBALS['strAddNewZone'] = "Lägg till ny zon";
$GLOBALS['strAddNewZone_Key'] = "Lägg till <u>n</u>y zon";
$GLOBALS['strZoneToWebsite'] = "INga webbsajter";
$GLOBALS['strLinkedZones'] = "Länkade zoner";
$GLOBALS['strAvailableZones'] = "Tillgängliga Zoner";
$GLOBALS['strZoneProperties'] = "Zonegenskaper";
$GLOBALS['strZoneHistory'] = "Zonhistorik";
$GLOBALS['strNoZones'] = "Det finns för närvarande inga zoner definierade för denna webbsida";
$GLOBALS['strNoZonesAddWebsite'] = "Det finns inga sajter inlagda. För att skapa en zon, <a href='affiliate-edit.php'>lägg till ny sajt</a> först.";
$GLOBALS['strConfirmDeleteZone'] = "Vill du verkligen radera den här zonen?";
$GLOBALS['strConfirmDeleteZones'] = "Vill du verkligen radera den här zonen?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Det finns kampanjer som fortfarande är länkade till den här zonen, om du tar bort dessa kommer de inte att kunna köras och du betalas inte för dem.";
$GLOBALS['strZoneType'] = "Zontyp";
$GLOBALS['strBannerButtonRectangle'] = "Annons, Knapp eller Rektangel";
$GLOBALS['strInterstitial'] = "Inledande eller flytande DHTML";
$GLOBALS['strPopup'] = "Pop-upp";
$GLOBALS['strTextAdZone'] = "Textannons";
$GLOBALS['strEmailAdZone'] = "Epost/Nyhetsbrev zon";
$GLOBALS['strShowMatchingBanners'] = "Visa matchande annonser";
$GLOBALS['strHideMatchingBanners'] = "Dölj matchande annonser";
$GLOBALS['strBannerLinkedAds'] = "Annonser länkade till zonen";
$GLOBALS['strCampaignLinkedAds'] = "Kampanjer länkade till zonen";
$GLOBALS['strInactiveZonesHidden'] = "inaktiva zoner dolda";
$GLOBALS['strWarnChangeZoneType'] = "Om du ändrar zontyp till text eller epost kommer alla annonser/kampanjer att kopplas bort på grund av restriktioner i dessa zontyper
<ul>
<li>Textzoner kan bara länkas till textannonser</li>
<li>Epost kampanjer kan endast ha en aktiv annons åt gången</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Om du ändrar zonstorleken avlänkas alla annonser som inte matchar den nya storleken och alla annonser från länkade kampanjer med samma storlek läggs till';
$GLOBALS['strWarnChangeBannerSize'] = 'Om du ändrar bannerstorleken kommer du att koppla bort den här bannern från några zoner som inte är den nya storleken, och om bannerns <strong>kampanj</strong> är länkad till en zon med den nya storleken, kommer den här bannern automatiskt att länkas';
$GLOBALS['strWarnBannerReadonly'] = 'Denna banner är skrivskyddad eftersom en förlängning har inaktiverats. Kontakta din systemadministratör för mer information.';
$GLOBALS['strZonesOfWebsite'] = 'i'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Tillbaka till zoner";


// Advanced zone settings
$GLOBALS['strAdvanced'] = "Avancerat";
$GLOBALS['strChainSettings'] = "Kedjeinställningar";
$GLOBALS['strZoneNoDelivery'] = "Om inga annonser från den här zonen <br />kan levereras, försök att...";
$GLOBALS['strZoneStopDelivery'] = "Stoppa leverans och visa inga annonser";
$GLOBALS['strZoneOtherZone'] = "Visa den valda zonen istället";
$GLOBALS['strZoneAppend'] = "Lägg alltid till följande HTML-kod till annonser som visas på den här zonen";
$GLOBALS['strZonePrependHTML'] = "Lägg alltid till följande HTML-kod till texannonser som visas på den här zonen";
$GLOBALS['strZoneAppendNoBanner'] = "Bifoga även om ingen banner levereras";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML-kod";
$GLOBALS['strZoneAppendZoneSelection'] = "Pop-upp eller inledande";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Alla banners länkade till den här zonen är f.n. inaktiva. <br /> Den här zonkedjan kommer att följas:";
$GLOBALS['strZoneProbNullPri'] = "Det finns inga aktiva banners länkade till den här zonen.";
$GLOBALS['strZoneProbListChainLoop'] = "Följande zonkedja skulle orsaka en cirkulär loop. Leverans för den här zonen är stoppad.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Vänligen välj vad som ska länkas till den här zonen.";
$GLOBALS['strLinkedBanners'] = "Länka individuella banners";
$GLOBALS['strCampaignDefaults'] = "Länka banners utifrån överordnad kampanj";
$GLOBALS['strLinkedCategories'] = "Länka banners utifrån kategori";
$GLOBALS['strRawQueryString'] = "Sökord";
$GLOBALS['strIncludedBanners'] = "Länkade banners";
$GLOBALS['strMatchingBanners'] = "{count} matchande banners";
$GLOBALS['strNoCampaignsToLink'] = "Det finns inga kampanjer tillgängliga som kan länkas till den här zonen";
$GLOBALS['strNoTrackersToLink'] = "Det finns ingen spårning tillgänglig som kan länkas till den här kampanjen";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Det finns inga zoner tillgängliga som den här kampanjen kan länkas till";
$GLOBALS['strSelectBannerToLink'] = "Välj den banner du vill länka till den här zonen:";
$GLOBALS['strSelectCampaignToLink'] = "Välj den kampanj du vill länka till den här zonen:";
$GLOBALS['strSelectAdvertiser'] = "Välj annonsör";
$GLOBALS['strSelectPlacement'] = "Välj kampanj";
$GLOBALS['strSelectAd'] = "Välj banner";
$GLOBALS['strSelectPublisher'] = "Välj webbplats";
$GLOBALS['strSelectZone'] = "Välj Zon";
$GLOBALS['strStatusPending'] = "Pågående";
$GLOBALS['strStatusApproved'] = "Godkänd";
$GLOBALS['strStatusDisapproved'] = "Ej godkänd";
$GLOBALS['strStatusDuplicate'] = "Duplicera";
$GLOBALS['strStatusOnHold'] = "Pausad";
$GLOBALS['strStatusIgnore'] = "Ignorera";
$GLOBALS['strConnectionType'] = "Typ";
$GLOBALS['strConnTypeSale'] = "Rea";
$GLOBALS['strConnTypeSignUp'] = "Registrera dig";
$GLOBALS['strShortcutEditStatuses'] = "Redigera statusar";
$GLOBALS['strShortcutShowStatuses'] = "Visa statusar";

// Statistics
$GLOBALS['strStats'] = "Statistik";
$GLOBALS['strNoStats'] = "Det finns ingen statistik tillgänglig";
$GLOBALS['strNoStatsForPeriod'] = "Det finns ingen statistik tillgänglig för perioden %s till %s";
$GLOBALS['strGlobalHistory'] = "Global statistik";
$GLOBALS['strDailyHistory'] = "Daglig statistik";
$GLOBALS['strDailyStats'] = "Daglig statistik";
$GLOBALS['strWeeklyHistory'] = "Veckostatistik";
$GLOBALS['strMonthlyHistory'] = "Månadsstatistik";
$GLOBALS['strTotalThisPeriod'] = "Totalt den här perioden";
$GLOBALS['strPublisherDistribution'] = "Webbsajtdistribution";
$GLOBALS['strCampaignDistribution'] = "Kampanjdistribution";
$GLOBALS['strViewBreakdown'] = "Visa efter";
$GLOBALS['strBreakdownByDay'] = "Dag";
$GLOBALS['strBreakdownByWeek'] = "Vecka";
$GLOBALS['strBreakdownByMonth'] = "Månad";
$GLOBALS['strBreakdownByDow'] = "Dag i veckan";
$GLOBALS['strBreakdownByHour'] = "Timme";
$GLOBALS['strItemsPerPage'] = "Objekt per sida";
$GLOBALS['strShowGraphOfStatistics'] = "Visa <u>G</u>raf för statistiken";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xportera statistik till Excel";
$GLOBALS['strGDnotEnabled'] = "Du måste ha GD aktiverat i PHP för att visa grafer. <br />Vänligen besök <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> för mer information, inklusive hur man installerar GD på servern.";
$GLOBALS['strStatsArea'] = "Område";

// Expiration
$GLOBALS['strNoExpiration'] = "Inget utgångsdatum angivet";
$GLOBALS['strEstimated'] = "Estimerad utgångsdatum";
$GLOBALS['strDaysAgo'] = "dagar sedan";
$GLOBALS['strCampaignStop'] = "Kampanjhistorik";

// Reports
$GLOBALS['strAdvancedReports'] = "Avancerade rapporter";
$GLOBALS['strStartDate'] = "Startdatum";
$GLOBALS['strEndDate'] = "Slutdatum";
$GLOBALS['strPeriod'] = "Period";
$GLOBALS['strLimitations'] = "Leveransregler";
$GLOBALS['strWorksheets'] = "Kalkylblad";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Alla annonsörer";
$GLOBALS['strAnonAdvertisers'] = "Anonym annonsör";
$GLOBALS['strAllPublishers'] = "Alla webbsajter";
$GLOBALS['strAnonPublishers'] = "Anonyma webbsajter";
$GLOBALS['strAllAvailZones'] = "Alla tillgängliga zoner";

// Userlog
$GLOBALS['strUserLog'] = "Användarlogg";
$GLOBALS['strUserLogDetails'] = "Användarloggdetaljer";
$GLOBALS['strDeleteLog'] = "Radera logg";
$GLOBALS['strAction'] = "Handling";
$GLOBALS['strNoActionsLogged'] = "Inga händelser är loggade";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Direktval";
$GLOBALS['strChooseInvocationType'] = "Vänligen välj typ av bannerpublicering";
$GLOBALS['strGenerate'] = "Generera";
$GLOBALS['strParameters'] = "Taginställningar";
$GLOBALS['strFrameSize'] = "Ramstorlek";
$GLOBALS['strBannercode'] = "Bannerkod";
$GLOBALS['strBackToTheList'] = "Gå tillbaks till rapportlistan";
$GLOBALS['strCharset'] = "Teckenuppsättning";
$GLOBALS['strAutoDetect'] = "Identifiera automatiskt";

// Errors
$GLOBALS['strNoMatchesFound'] = "Inga matchningar hittades";
$GLOBALS['strErrorOccurred'] = "Ett fel inträffade";
$GLOBALS['strErrorDBPlain'] = "Ett fel inträffande vid läsning från databasen";
$GLOBALS['strErrorDBSerious'] = "Ett allvarligt problem med databasen har upptäckts";
$GLOBALS['strErrorDBNoDataPlain'] = "Pga problem med databasen kunde inte {$PRODUCT_NAME} hämta eller lagra data.";
$GLOBALS['strErrorDBNoDataSerious'] = "Pga allvarligt problem med databasen kunde inte {$PRODUCT_NAME} hämta data.";
$GLOBALS['strErrorDBCorrupt'] = "Databasen är förmodligen korrupt och behöver lagas. För mer info om hur man fixar korrupta tabeller, vänligen läs kapitlet <i>Felsökning</i> i <i>Administrationsguide</i>";
$GLOBALS['strErrorDBContact'] = "Vänligen kontakta serveradministratören och meddela problemet.";
$GLOBALS['strErrorDBSubmitBug'] = "Om detta problem kan återskapas så kan det skapats av en bugg i {$PRODUCT_NAME}. Vänligen rapportera följande information till skaparna av {$PRODUCT_NAME}. Försök också beskriva handlingarna som ledde till detta fel så tydligt som möjligt.";
$GLOBALS['strErrorLinkingBanner'] = "Det var inte möjligt att länka bannern till den här zonen pga:";
$GLOBALS['strUnableToLinkBanner'] = "Kan inte länka bannern:";
$GLOBALS['strUnableToChangeZone'] = "Kan inte genomföra denna ändring därför att:";
$GLOBALS['strDatesConflict'] = "datumen i konflikt med:";
$GLOBALS['strEmailNoDates'] = "Kampanjer för emailzoner måste ha ett start och ett slutdatum";

//Validation

// Email
$GLOBALS['strSirMadam'] = "Herr/fru";
$GLOBALS['strMailSubject'] = "Rapport för annonsör";
$GLOBALS['strMailHeader'] = "Bäste {contact},";
$GLOBALS['strMailBannerStats'] = "Nedan finner du bannerstatistik för {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanjen aktiverad";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanjen avaktiverad";
$GLOBALS['strMailBannerActivated'] = "Din kampanj nedan har aktiverats pga
kampanjens aktiveringsdatum har nåtts.";
$GLOBALS['strMailBannerDeactivated'] = "Din kampanj nedan har avaktiverats p.g.a";
$GLOBALS['strClientDeactivated'] = "Denna kampanj är för närvarande inte aktiv p.g.a";
$GLOBALS['strBeforeActivate'] = "aktiveringsdatumet har inte nåtts";
$GLOBALS['strAfterExpire'] = "utgångsdatumet har nåtts";
$GLOBALS['strNoMoreImpressions'] = "det finns inga fler visningar";
$GLOBALS['strNoMoreClicks'] = "det finns inga fler klick";
$GLOBALS['strNoMoreConversions'] = "det finns inga fler försäljningar";
$GLOBALS['strWeightIsNull'] = "dess vikt är satt till noll";
$GLOBALS['strMailReportPeriod'] = "Rapporten innehåller statistik från {startdate} upp till {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Denna rapport innehåller alla statistik upp till {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Det finns ingen statistik tillgänglig för denna kampanj";
$GLOBALS['strImpendingCampaignExpiry'] = "Kommande utgång av kampanj";
$GLOBALS['strYourCampaign'] = "Din kampanj";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampanjen tillhör";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} som visas nedan avslutas {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} som visas nedan har färre än {limit} visningar kvar.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Som ett resultat av det kommer kampanjen snart att avaktiveras automatiskt och då kommer
följande banners i kampanjen också att avaktiveras:";

// Priority
$GLOBALS['strPriority'] = "Prioritering";
$GLOBALS['strSourceEdit'] = "Editera källor";

// Preferences
$GLOBALS['strPreferences'] = "Inställningar";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Kampanj e-postrapporteringsinställningar";
$GLOBALS['strPluginPreferences'] = "Tilläggsinställningar";

// Long names
$GLOBALS['strNumberOfItems'] = "Antal artiklar";
$GLOBALS['strERPM'] = "CPM";
$GLOBALS['strERPC'] = "CPC";
$GLOBALS['strERPS'] = "CPM";
$GLOBALS['strEIPM'] = "CPM";
$GLOBALS['strEIPC'] = "CPC";
$GLOBALS['strEIPS'] = "CPM";
$GLOBALS['strECPM'] = "CPM";
$GLOBALS['strECPC'] = "CPC";
$GLOBALS['strECPS'] = "CPM";
$GLOBALS['strImpressionSR'] = "Visningar";

// Short names
$GLOBALS['strERPM_short'] = "CPM";
$GLOBALS['strERPC_short'] = "CPC";
$GLOBALS['strERPS_short'] = "CPM";
$GLOBALS['strEIPM_short'] = "CPM";
$GLOBALS['strEIPC_short'] = "CPC";
$GLOBALS['strEIPS_short'] = "CPM";
$GLOBALS['strECPM_short'] = "CPM";
$GLOBALS['strECPC_short'] = "CPC";
$GLOBALS['strECPS_short'] = "CPM";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strClicks_short'] = "Klick";
$GLOBALS['strCTR_short'] = "CTR";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Allmänna inställningar";
$GLOBALS['strGeneralSettings'] = "Allmänna inställningar";
$GLOBALS['strMainSettings'] = "Huvudsakliga inställningar";
$GLOBALS['strPlugins'] = "Tillägg";
$GLOBALS['strChooseSection'] = 'Välj sektion';

// Product Updates
$GLOBALS['strProductUpdates'] = "Produktuppdateringar";
$GLOBALS['strViewPastUpdates'] = "Handhåll gångna uppdateringar och backups";

// Agency
$GLOBALS['strAgencyManagement'] = "Kontohantering";
$GLOBALS['strAgency'] = "Konto";
$GLOBALS['strAddAgency'] = "Lägg till ett nytt konto";
$GLOBALS['strAddAgency_Key'] = "Lägg till <u>n</u>ytt konto";
$GLOBALS['strTotalAgencies'] = "Alla konton";
$GLOBALS['strAgencyProperties'] = "Kontots egenskaper";
$GLOBALS['strNoAgencies'] = "Det finns inga konton definierade";
$GLOBALS['strConfirmDeleteAgency'] = "Vill du verkligen radera detta konto?";
$GLOBALS['strHideInactiveAgencies'] = "Göm inaktiva konton";
$GLOBALS['strInactiveAgenciesHidden'] = "inaktiva konton gömda";
$GLOBALS['strAgencyStatusInactive'] = "aktiv";

// Channels
$GLOBALS['strChannels'] = "Leveransregeluppsättningar";
$GLOBALS['strChannelToWebsite'] = "INga webbsajter";
$GLOBALS['strNoChannels'] = "Det finns för närvarande inga leveransregeluppsättningar definierade";
$GLOBALS['strNoChannelsAddWebsite'] = "Det finns för närvarande inga leveransregeluppsättningar definierade, eftersom det inte finns några webbplatser. För att skapa en leveransregeluppsättning, först <a href='affiliate-edit.php'>lägg till en ny webbplats</a>.";
$GLOBALS['strChannelLimitations'] = "Leveransinställningar";
$GLOBALS['strConfirmDeleteChannels'] = "Vill du verkligen radera den valda leveransregeluppsättningen?";
$GLOBALS['strChannelsOfWebsite'] = 'i'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Namn på variabel";
$GLOBALS['strVariableDescription'] = "Beskrivning";
$GLOBALS['strVariableDataType'] = "Datatyp";
$GLOBALS['strVariablePurpose'] = "Syfte";
$GLOBALS['strGeneric'] = "Generisk";
$GLOBALS['strBasketValue'] = "Värdet på korgen";
$GLOBALS['strNumItems'] = "Antal artiklar";
$GLOBALS['strNumber'] = "Nummer";
$GLOBALS['strString'] = "Tråd";
$GLOBALS['strTrackFollowingVars'] = "Spåra följande variabler";
$GLOBALS['strAddVariable'] = "Lägg till variabel";
$GLOBALS['strNoVarsToTrack'] = "Inga variabler finns att spåra";
$GLOBALS['strVariableRejectEmpty'] = "Avslå om tom?";
$GLOBALS['strTrackingSettings'] = "Inställningar för spårning";
$GLOBALS['strTrackerType'] = "Spårningstyp";
$GLOBALS['strTrackerTypeJS'] = "Spåra variabler för JavaScript";

// Password recovery
$GLOBALS['strForgotPassword'] = "Glömt ditt lösenord?";
$GLOBALS['strEmailRequired'] = "Email måste fyllas i";
$GLOBALS['strPwdRecEnterEmail'] = "Skriv in din mailadress nedan";
$GLOBALS['strPwdRecEnterPassword'] = "Skriv ditt nya lösenord nedan";
$GLOBALS['strProceed'] = "Gå vidare >";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strHas'] = "har";
$GLOBALS['strAuditTrailDisabled'] = "Revisionsspårning har inaktiverats av systemadministratören. Inga ytterligare händelser loggas och visas i listan över revisionsspår.";

// Widget - Audit
$GLOBALS['strAuditTrail'] = "Auditlista";
$GLOBALS['strAuditTrailSetup'] = "Konfigurera revisionsspårning idag";
$GLOBALS['strAuditTrailGoTo'] = "Gå till revisionsspårningssidan";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Revisionsspårning gör så att du kan se vem som gjorde vad och när. Eller för att uttrycka det på ett annat sätt håller det koll på systemändringar inom {$PRODUCT_NAME}</li>
        <li>Du ser detta meddelande, eftersom du inte har aktiverat revisionsspårning</li>
        <li>Intresserad av att lära sig mer? Läs <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help'> Dokumentation för revisionsspårning</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignSetUp'] = "Skapa en kampanj idag";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Inga kampanjer har startat eller slutförts under den tidsram du har valt";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>För att visa kampanjer som har startats eller slutförts under den tidsram du har valt måste revisionsspårning aktiveras</li>
        <li>Du ser detta meddelande eftersom du inte aktiverade revisionsspårning</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktivera revisionsspårning för att börja visa kampanjer";


//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "Du arbetar nu som <b>%s</b>";








$GLOBALS['strChannelsHaveBeenDeleted'] = "Alla valda leveransregeluppsättningar har raderats";


// Report error messages

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
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
