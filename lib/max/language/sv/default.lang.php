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
$GLOBALS['phpAds_TextDirection'] = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft'] = "left";
$GLOBALS['phpAds_CharSet'] = "UTF-8";

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "%d-%m-%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%d-%m";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

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
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s för...";
$GLOBALS['strNoAccountWithXInNameFound'] = "Inga konton med ”%s” i namnet hittas";
$GLOBALS['strRecentlyUsed'] = "Senast använda";
$GLOBALS['strLinkUser'] = "Lägg till användare";
$GLOBALS['strLinkUser_Key'] = "Lägg till <u>a</u>nvändare";
$GLOBALS['strUsernameToLink'] = "Användarnamnet för användaren att lägga till";
$GLOBALS['strNewUserWillBeCreated'] = "Ny användare kommer att skapas";
$GLOBALS['strToLinkProvideEmail'] = "För att lägga till användare, ange användares e-post";
$GLOBALS['strToLinkProvideUsername'] = "För att lägga till användare, ange användarnamn";
$GLOBALS['strUserLinkedToAccount'] = "Användare har lagts till konto";
$GLOBALS['strUserAccountUpdated'] = "Konto uppdaterat";
$GLOBALS['strUserUnlinkedFromAccount'] = "Användaren har tagits bort från konto";
$GLOBALS['strUserWasDeleted'] = "Användaren har tagits bort";
$GLOBALS['strUserNotLinkedWithAccount'] = "Sådan användare är inte kopplad till konto";
$GLOBALS['strCantDeleteOneAdminUser'] = "You can't delete a user. At least one user needs to be linked with admin account.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
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
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Session cookie error, please log in again";
$GLOBALS['strLogin'] = "Logga in";
$GLOBALS['strLogout'] = "Logga ut";
$GLOBALS['strUsername'] = "Användarnamn";
$GLOBALS['strPassword'] = "Lösenord";
$GLOBALS['strPasswordRepeat'] = "Upprepa lösenord";
$GLOBALS['strAccessDenied'] = "Åtkomst nekad";
$GLOBALS['strUsernameOrPasswordWrong'] = "Användarnamnet och/eller lösenordet var inkorrekt. Vänligen försök igen.";
$GLOBALS['strPasswordWrong'] = "Lösenordet är inkorrekt";
$GLOBALS['strNotAdmin'] = "Your account does not have the required permissions to use this feature, you can log into another account to use it.";
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
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Totala klick";
$GLOBALS['strTotalConversions'] = "Totala konverteringar";
$GLOBALS['strDateTime'] = "Datum Tid";
$GLOBALS['strTrackerID'] = "Spårnings ID";
$GLOBALS['strTrackerName'] = "Spårningsnamn";
$GLOBALS['strTrackerImageTag'] = "Bildtagg";
$GLOBALS['strTrackerJsTag'] = "JavaScript-tagg";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
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
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Månadsavgift";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Datum";
$GLOBALS['strDay'] = "Dag";
$GLOBALS['strDays'] = "Dagar";
$GLOBALS['strWeek'] = "Vecka";
$GLOBALS['strWeeks'] = "Veckor";
$GLOBALS['strSingleMonth'] = "Månad";
$GLOBALS['strMonths'] = "Månader";
$GLOBALS['strDayOfWeek'] = "Dag av vecka";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Söndag';
$GLOBALS['strDayFullNames'][1] = 'Måndag';
$GLOBALS['strDayFullNames'][2] = 'Tisdag';
$GLOBALS['strDayFullNames'][3] = 'Onsdag';
$GLOBALS['strDayFullNames'][4] = 'Torsdag';
$GLOBALS['strDayFullNames'][5] = 'Fredag';
$GLOBALS['strDayFullNames'][6] = 'Lördag';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
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
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "Det finns inga annonsörer inlagda. För att skapa en kampanj, <a href='advertiser-edit.php'>lägg till en annonsör</a> först.";
$GLOBALS['strConfirmDeleteClient'] = "Vill du verkligen radera den här annonsören?";
$GLOBALS['strConfirmDeleteClients'] = "Vill du verkligen radera den här annonsören?";
$GLOBALS['strHideInactive'] = "Dölj inaktiva";
$GLOBALS['strInactiveAdvertisersHidden'] = "dolda inaktiva annonsörer";
$GLOBALS['strAdvertiserSignup'] = "Advertiser Sign Up";
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
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Display only one banner from this advertiser on a web page";
$GLOBALS['strAllowAuditTrailAccess'] = "Låt den här användaren få åtkomst till revisionsspårning";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

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
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Vill du verkligen radera den här kampanjen?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Vill du verkligen radera den här kampanjen?";
$GLOBALS['strShowParentAdvertisers'] = "Visa överordnade annonsörer";
$GLOBALS['strHideParentAdvertisers'] = "Dölj överordnade annonsörer";
$GLOBALS['strHideInactiveCampaigns'] = "Dölj inaktiva kampanjer";
$GLOBALS['strInactiveCampaignsHidden'] = "inaktiva kampanjer dolda";
$GLOBALS['strPriorityInformation'] = "Prioritet i förhållande till andra kampanjer";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Kampanj";
$GLOBALS['strHiddenAd'] = "Annons";
$GLOBALS['strHiddenAdvertiser'] = "Annonsör";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strHiddenWebsite'] = "Webbsida";
$GLOBALS['strHiddenZone'] = "Zon";
$GLOBALS['strCampaignDelivery'] = "Kampanjen leverans";
$GLOBALS['strCompanionPositioning'] = "Kompanjonpositionering";
$GLOBALS['strSelectUnselectAll'] = "Markera / avmarkera alla";
$GLOBALS['strCampaignsOfAdvertiser'] = "av"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Beräknad för alla kampanjer";
$GLOBALS['strCalculatedForThisCampaign'] = "Beräknad för denna kampanj";
$GLOBALS['strLinkingZonesProblem'] = "Ett problemet uppstod när zonen skulle länkas";
$GLOBALS['strUnlinkingZonesProblem'] = "Ett problem uppstod när zonen skulle avlänkas";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Sök";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "Inga webbsidor eller zoner";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
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
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Kontakt";
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
$GLOBALS['strPricing'] = "Prissättning";
$GLOBALS['strPricingModel'] = "Prismodell";
$GLOBALS['strSelectPricingModel'] = "--Välj modell--";
$GLOBALS['strRatePrice'] = "Rate / Price";
$GLOBALS['strMinimumImpressions'] = "Lägsta antal dagliga visningar";
$GLOBALS['strLimit'] = "Gräns";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
$GLOBALS['strWhyDisabled'] = "why is it disabled?";
$GLOBALS['strBackToCampaigns'] = "Back to campaigns";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Kakor";

// Tracker
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strTrackers'] = "Tracker";
$GLOBALS['strTrackerPreferences'] = "Tracker Preferences";
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
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Adress";

// Banners (General)
$GLOBALS['strBanner'] = "Annons";
$GLOBALS['strBanners'] = "Banners";
$GLOBALS['strAddBanner'] = "Lägg till ny annons";
$GLOBALS['strAddBanner_Key'] = "Lägg till <u>n</u>y annons";
$GLOBALS['strBannerToCampaign'] = "Din kampanj";
$GLOBALS['strShowBanner'] = "Visa annonser";
$GLOBALS['strBannerProperties'] = "Annonsegenskaper";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "Det finns för närvarande inga annonser definierade till den här kampanjen.";
$GLOBALS['strNoBannersAddCampaign'] = "There are currently no banners defined, because there are no campaigns. To create a banner, <a href='campaign-edit.php?clientid=%s'>add a new campaign</a> first.";
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
$GLOBALS['strBannerPreferences'] = "Banner Preferences";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Default Banners";
$GLOBALS['strDefaultBannerUrl'] = "Default Image URL";
$GLOBALS['strDefaultBannerDestination'] = "Default Destination URL";
$GLOBALS['strAllowedBannerTypes'] = "Allowed Banner Types";
$GLOBALS['strTypeSqlAllow'] = "Allow SQL Local Banners";
$GLOBALS['strTypeWebAllow'] = "Allow Webserver Local Banners";
$GLOBALS['strTypeUrlAllow'] = "Allow External Banners";
$GLOBALS['strTypeHtmlAllow'] = "Allow HTML Banners";
$GLOBALS['strTypeTxtAllow'] = "Allow Text Ads";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Vänligen välj annonstyp";
$GLOBALS['strMySQLBanner'] = "Ladda upp en lokal annons till databasen";
$GLOBALS['strWebBanner'] = "Ladda upp en lokal annons till webbservern";
$GLOBALS['strURLBanner'] = "Länka en extern annons";
$GLOBALS['strHTMLBanner'] = "Skapa en HTML annons";
$GLOBALS['strTextBanner'] = "Skapa en textannons";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Vill du behålla <br />befintlig bild, eller vill du<br />ladda upp ny bild?";
$GLOBALS['strNewBannerFile'] = "Välj vilken bild du vill <br />använda för den här annonsen<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Välj den säkerhets bild du <br />vill använda i fall vissa webbläsare <br />inte stödjer rich media<br /><br />";
$GLOBALS['strNewBannerURL'] = "Bild URL (inkl. http://)";
$GLOBALS['strURL'] = "Destinations URL (inkl. http://)";
$GLOBALS['strKeyword'] = "Nyckelord";
$GLOBALS['strTextBelow'] = "Text under bild";
$GLOBALS['strWeight'] = "Vikt";
$GLOBALS['strAlt'] = "Alt text";
$GLOBALS['strStatusText'] = "Statustext";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Bannervikt";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Generisk HTML banner";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Generisk";
$GLOBALS['strBackToBanners'] = "Tillbaka till banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Använd WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Leveransinställningar";
$GLOBALS['strACL'] = "Leveransinställningar";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
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
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Begränsa annonsvisningar till:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Begränsa kampanjvisningar till:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
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
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
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
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
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

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Half Banner (234 x 60)";
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
$GLOBALS['strAdvanced'] = "Avancerat";
$GLOBALS['strChainSettings'] = "Kedjeinställningar";
$GLOBALS['strZoneNoDelivery'] = "Om inga annonser från den här zonen <br />kan levereras, försök att...";
$GLOBALS['strZoneStopDelivery'] = "Stoppa leverans och visa inga annonser";
$GLOBALS['strZoneOtherZone'] = "Visa den valda zonen istället";
$GLOBALS['strZoneAppend'] = "Lägg alltid till följande HTML-kod till annonser som visas på den här zonen";
$GLOBALS['strAppendSettings'] = "Append and prepend settings";
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
$GLOBALS['strWithXBanners'] = "%d banner(s)";
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
$GLOBALS['strConnTypeLead'] = "Lead";
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
$GLOBALS['strBreakdownByDow'] = "Dag av vecka";
$GLOBALS['strBreakdownByHour'] = "Timme";
$GLOBALS['strItemsPerPage'] = "Objekt per sida";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Visa <u>G</u>raf för statistiken";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xportera statistik till Excel";
$GLOBALS['strGDnotEnabled'] = "Du måste ha GD aktiverat i PHP för att visa grafer. <br />Vänligen besök <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> för mer information, inklusive hur man installerar GD på servern.";
$GLOBALS['strStatsArea'] = "Område";

// Expiration
$GLOBALS['strNoExpiration'] = "Inget utgångsdatum angivet";
$GLOBALS['strEstimated'] = "Estimerad utgångsdatum";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
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
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Gå tillbaks till rapportlistan";
$GLOBALS['strCharset'] = "Teckenuppsättning";
$GLOBALS['strAutoDetect'] = "Identifiera automatiskt";
$GLOBALS['strCacheBusterComment'] = "  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *";
$GLOBALS['strSSLBackupComment'] = "
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";
$GLOBALS['strSSLDeliveryComment'] = "
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "Database connection error.";
$GLOBALS['strErrorCantConnectToDatabase'] = "A fatal error occurred %1\$s can't connect to the database. Because
                                                   of this it isn't possible to use the administrator interface. The delivery
                                                   of banners might also be affected. Possible reasons for the problem are:
                                                   <ul>
                                                     <li>The database server isn't functioning at the moment</li>
                                                     <li>The location of the database server has changed</li>
                                                     <li>The username or password used to contact the database server are not correct</li>
                                                     <li>PHP has not loaded the <i>%2\$s</i> extension</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "Inga matchningar hittades";
$GLOBALS['strErrorOccurred'] = "Ett fel inträffade";
$GLOBALS['strErrorDBPlain'] = "Ett fel inträffande vid läsning från databasen";
$GLOBALS['strErrorDBSerious'] = "Ett allvarligt problem med databasen har upptäckts";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Databasen är förmodligen korrupt och behöver lagas. För mer info om hur man fixar korrupta tabeller, vänligen läs kapitlet <i>Felsökning</i> i <i>Administrationsguide</i>";
$GLOBALS['strErrorDBContact'] = "Vänligen kontakta serveradministratören och meddela problemet.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "Det var inte möjligt att länka bannern till den här zonen pga:";
$GLOBALS['strUnableToLinkBanner'] = "Kan inte länka bannern:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Error updating zone:";
$GLOBALS['strUnableToChangeZone'] = "Kan inte genomföra denna ändring därför att:";
$GLOBALS['strDatesConflict'] = "datumen i konflikt med:";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
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
$GLOBALS['strSirMadam'] = "Herr/fru";
$GLOBALS['strMailSubject'] = "Rapport för annonsör";
$GLOBALS['strMailHeader'] = "Bäste {contact},";
$GLOBALS['strMailBannerStats'] = "Nedan finner du bannerstatistik för {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanjen aktiverad";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanjen avaktiverad";
$GLOBALS['strMailBannerActivated'] = "Din kampanj nedan har aktiverats pga
kampanjens aktiveringsdatum har nåtts.";
$GLOBALS['strMailBannerDeactivated'] = "Din kampanj nedan har avaktiverats p.g.a";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Denna kampanj är för närvarande inte aktiv p.g.a";
$GLOBALS['strBeforeActivate'] = "aktiveringsdatumet har inte nåtts";
$GLOBALS['strAfterExpire'] = "utgångsdatumet har nåtts";
$GLOBALS['strNoMoreImpressions'] = "det finns inga fler visningar";
$GLOBALS['strNoMoreClicks'] = "det finns inga fler klick";
$GLOBALS['strNoMoreConversions'] = "det finns inga fler försäljningar";
$GLOBALS['strWeightIsNull'] = "dess vikt är satt till noll";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "No Impressions were logged during the span of this report";
$GLOBALS['strNoClickLoggedInInterval'] = "No Clicks were logged during the span of this report";
$GLOBALS['strNoConversionLoggedInInterval'] = "No Conversions were logged during the span of this report";
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
$GLOBALS['strUserPreferences'] = "User Preferences";
$GLOBALS['strChangePassword'] = "Change Password";
$GLOBALS['strChangeEmail'] = "Change E-mail";
$GLOBALS['strCurrentPassword'] = "Current Password";
$GLOBALS['strChooseNewPassword'] = "Choose a new password";
$GLOBALS['strReenterNewPassword'] = "Re-enter new password";
$GLOBALS['strNameLanguage'] = "Name & Language";
$GLOBALS['strAccountPreferences'] = "Account Preferences";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Kampanj e-postrapporteringsinställningar";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "System administrator email Warnings";
$GLOBALS['strAgencyEmailWarnings'] = "Account email Warnings";
$GLOBALS['strAdveEmailWarnings'] = "Advertiser email Warnings";
$GLOBALS['strFullName'] = "Full Name";
$GLOBALS['strEmailAddress'] = "Email address";
$GLOBALS['strUserDetails'] = "User Details";
$GLOBALS['strUserInterfacePreferences'] = "User Interface Preferences";
$GLOBALS['strPluginPreferences'] = "Tilläggsinställningar";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strNumberOfItems'] = "Antal artiklar";
$GLOBALS['strRevenueCPC'] = "Revenue CPC";
$GLOBALS['strERPM'] = "CPM";
$GLOBALS['strERPC'] = "CPC";
$GLOBALS['strERPS'] = "CPM";
$GLOBALS['strEIPM'] = "CPM";
$GLOBALS['strEIPC'] = "CPC";
$GLOBALS['strEIPS'] = "CPM";
$GLOBALS['strECPM'] = "CPM";
$GLOBALS['strECPC'] = "CPC";
$GLOBALS['strECPS'] = "CPM";
$GLOBALS['strPendingConversions'] = "Pending conversions";
$GLOBALS['strImpressionSR'] = "Visningar";
$GLOBALS['strClickSR'] = "Click SR";

// Short names
$GLOBALS['strRevenue_short'] = "Rev.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Items";
$GLOBALS['strRevenueCPC_short'] = "Rev. CPC";
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
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Klick";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Allmänna inställningar";
$GLOBALS['strGeneralSettings'] = "Allmänna inställningar";
$GLOBALS['strMainSettings'] = "Huvudsakliga inställningar";
$GLOBALS['strPlugins'] = "Tillägg";
$GLOBALS['strChooseSection'] = 'Välj sektion';

// Product Updates
$GLOBALS['strProductUpdates'] = "Produktuppdateringar";
$GLOBALS['strViewPastUpdates'] = "Handhåll gångna uppdateringar och backups";
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
$GLOBALS['strSwitchAccount'] = "Switch to this account";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "aktiv";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Leveransregeluppsättningar";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "INga webbsajter";
$GLOBALS['strNoChannels'] = "Det finns för närvarande inga leveransregeluppsättningar definierade";
$GLOBALS['strNoChannelsAddWebsite'] = "Det finns för närvarande inga leveransregeluppsättningar definierade, eftersom det inte finns några webbplatser. För att skapa en leveransregeluppsättning, först <a href='affiliate-edit.php'>lägg till en ny webbplats</a>.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Leveransinställningar";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
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
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Nummer";
$GLOBALS['strString'] = "Tråd";
$GLOBALS['strTrackFollowingVars'] = "Spåra följande variabler";
$GLOBALS['strAddVariable'] = "Lägg till variabel";
$GLOBALS['strNoVarsToTrack'] = "Inga variabler finns att spåra";
$GLOBALS['strVariableRejectEmpty'] = "Avslå om tom?";
$GLOBALS['strTrackingSettings'] = "Inställningar för spårning";
$GLOBALS['strTrackerType'] = "Spårningstyp";
$GLOBALS['strTrackerTypeJS'] = "Spåra variabler för JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "Track JavaScript variables (backwards compatible, escaping needed)";
$GLOBALS['strTrackerTypeDOM'] = "Track HTML elements using DOM";
$GLOBALS['strTrackerTypeCustom'] = "Custom JS code";
$GLOBALS['strVariableCode'] = "Javascript tracking code";

// Password recovery
$GLOBALS['strForgotPassword'] = "Glömt ditt lösenord?";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "Email måste fyllas i";
$GLOBALS['strPwdRecWrongId'] = "Fel ID";
$GLOBALS['strPwdRecEnterEmail'] = "Skriv in din mailadress nedan";
$GLOBALS['strPwdRecEnterPassword'] = "Skriv ditt nya lösenord nedan";
$GLOBALS['strProceed'] = "Gå vidare >";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to reset your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return to the main login page.</a>";

$GLOBALS['strPwdRecEmailPwdRecovery'] = "Reset Your %s Password";
$GLOBALS['strPwdRecEmailBody'] = "Dear {name},

You, or someone pretending to be you, recently requested that your {$PRODUCT_NAME} password be reset.

If this request was made by you, then you can reset the password for your username '{username}' by
clicking on the following link:

{reset_link}

If you submitted the password reset request by mistake, or if you didn't make a request at all, simply
ignore this email. No changes have been made to your password and the password reset link will expire
automatically.

If you continue to receive these password reset mails, then it may indicate that someone is attempting
to gain access to your username. In that case, please contact the support team or system administrator
for your {$PRODUCT_NAME} system, and notify them of the situation.

{admin_signature}";
$GLOBALS['strPwdRecEmailSincerely'] = "Sincerely,";

// Audit
$GLOBALS['strAdditionalItems'] = "and additional items";
$GLOBALS['strFor'] = "for";
$GLOBALS['strHas'] = "har";
$GLOBALS['strBinaryData'] = "Binary data";
$GLOBALS['strAuditTrailDisabled'] = "Revisionsspårning har inaktiverats av systemadministratören. Inga ytterligare händelser loggas och visas i listan över revisionsspår.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "No user activity has been recorded during the timeframe you have selected.";
$GLOBALS['strAuditTrail'] = "Auditlista";
$GLOBALS['strAuditTrailSetup'] = "Konfigurera revisionsspårning idag";
$GLOBALS['strAuditTrailGoTo'] = "Gå till revisionsspårningssidan";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Revisionsspårning gör så att du kan se vem som gjorde vad och när. Eller för att uttrycka det på ett annat sätt håller det koll på systemändringar inom {$PRODUCT_NAME}</li>
        <li>Du ser detta meddelande, eftersom du inte har aktiverat revisionsspårning</li>
        <li>Intresserad av att lära sig mer? Läs <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help'> Dokumentation för revisionsspårning</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Go to Campaigns page";
$GLOBALS['strCampaignSetUp'] = "Skapa en kampanj idag";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>There is no campaign activity to display.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Inga kampanjer har startat eller slutförts under den tidsram du har valt";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>För att visa kampanjer som har startats eller slutförts under den tidsram du har valt måste revisionsspårning aktiveras</li>
        <li>Du ser detta meddelande eftersom du inte aktiverade revisionsspårning</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktivera revisionsspårning för att börja visa kampanjer";

$GLOBALS['strUnsavedChanges'] = "You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "Du arbetar nu som <b>%s</b>";
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
$GLOBALS['strWebsiteHasBeenDuplicated'] = "Website <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

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

$GLOBALS['strChannelHasBeenAdded'] = "Delivery rule set <a href='%s'>%s</a> has been added. <a href='%s'>Set the delivery rules.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Delivery rule set <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for the delivery rule set <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Delivery rule set <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "Alla valda leveransregeluppsättningar har raderats";
$GLOBALS['strChannelHasBeenDuplicated'] = "Delivery rule set <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Your <b>%s</b> preferences has been updated";
$GLOBALS['strEmailChanged'] = "Your E-mail has been changed";
$GLOBALS['strPasswordChanged'] = "Your password has been changed";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strTZPreferencesWarning'] = "However, campaign activation and expiry were not updated, nor time-based banner delivery rules.<br />You will need to update them manually if you wish them to use the new timezone";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "No worksheet was selected for report";
$GLOBALS['strReportErrorUnknownCode'] = "Unknown error code #";

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "h";
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";
$GLOBALS['keyList'] = "l";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "n";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['keyWorkingAs'] = "w";
