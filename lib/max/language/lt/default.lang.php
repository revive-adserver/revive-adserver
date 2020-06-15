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

$GLOBALS['strHome'] = "Namai";
$GLOBALS['strHelp'] = "Pagalba";
$GLOBALS['strStartOver'] = "Pradėti nuo";
$GLOBALS['strShortcuts'] = "Nuorodos";
$GLOBALS['strActions'] = "Veiksmas";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "Inventorius";
$GLOBALS['strMaintenance'] = "Aptarnavimas";
$GLOBALS['strProbability'] = "Galimybės";
$GLOBALS['strInvocationcode'] = "Nuorodos kodas";
$GLOBALS['strBasicInformation'] = "Pradinė informacija";
$GLOBALS['strAppendTrackerCode'] = "Append Tracker Code";
$GLOBALS['strOverview'] = "Bendra peržiūra";
$GLOBALS['strSearch'] = "<u>P</u>aieška";
$GLOBALS['strDetails'] = "Detalus apibūdinimas";
$GLOBALS['strUpdateSettings'] = "Update Settings";
$GLOBALS['strCheckForUpdates'] = "Ieškoti atnaujinimų";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "Glaustai";
$GLOBALS['strUser'] = "Vartotojas";
$GLOBALS['strDuplicate'] = "Kopijuoti";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "Prekelti į";
$GLOBALS['strDelete'] = "Ištrinti";
$GLOBALS['strActivate'] = "Aktyvuoti";
$GLOBALS['strConvert'] = "Konvertuoti";
$GLOBALS['strRefresh'] = "Atnaujinti";
$GLOBALS['strSaveChanges'] = "Išsaugoti pasikeitimus";
$GLOBALS['strUp'] = "Į viršų";
$GLOBALS['strDown'] = "Žemyn";
$GLOBALS['strSave'] = "Išsaugoti";
$GLOBALS['strCancel'] = "Atšaukti";
$GLOBALS['strBack'] = "Atgal";
$GLOBALS['strPrevious'] = "Ankstesnis";
$GLOBALS['strNext'] = "Kitas";
$GLOBALS['strYes'] = "Taip";
$GLOBALS['strNo'] = "Ne";
$GLOBALS['strNone'] = "Nė vienas";
$GLOBALS['strCustom'] = "Įprastas";
$GLOBALS['strDefault'] = "Pagrindinis";
$GLOBALS['strUnknown'] = "Unknown";
$GLOBALS['strUnlimited'] = "Neribotas";
$GLOBALS['strUntitled'] = "Be pavadinimo";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "Vidurkis";
$GLOBALS['strOverall'] = "Iš viso";
$GLOBALS['strTotal'] = "Viso";
$GLOBALS['strFrom'] = "From";
$GLOBALS['strTo'] = "skirta (kam)";
$GLOBALS['strAdd'] = "Add";
$GLOBALS['strLinkedTo'] = "Priskirta (kam)";
$GLOBALS['strDaysLeft'] = "Liko dienų";
$GLOBALS['strCheckAllNone'] = "Patikrinti visus/ nė vieno";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>P</u>adidinti visus";
$GLOBALS['strCollapseAll'] = "<u>P</u>anaikinti visus";
$GLOBALS['strShowAll'] = "Rodyti visus";
$GLOBALS['strNoAdminInterface'] = "Administratoriaus ekranas buvo išjuntas dėl techninio aptarnavimo darbų. Tai nei kiek nepaveikė Jūsų kampanijų pristatymo";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'From' date must be earlier then 'To' date";
$GLOBALS['strFieldContainsErrors'] = "Pastarieji laukai turi klaidų:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Jei norite tęsti pirmiausia turite";
$GLOBALS['strFieldFixBeforeContinue2'] = "ištaisyti šias klaidas";
$GLOBALS['strMiscellaneous'] = "Įvairus";
$GLOBALS['strCollectedAllStats'] = "Visa statistika";
$GLOBALS['strCollectedToday'] = "Šiandien";
$GLOBALS['strCollectedYesterday'] = "Vakar";
$GLOBALS['strCollectedThisWeek'] = "Šią savaitę";
$GLOBALS['strCollectedLastWeek'] = "Praėjusią savaitę";
$GLOBALS['strCollectedThisMonth'] = "Šį mėnesį";
$GLOBALS['strCollectedLastMonth'] = "Praėjusį mėnesį";
$GLOBALS['strCollectedLast7Days'] = "Paskutinias septynias dienas";
$GLOBALS['strCollectedSpecificDates'] = "Specifinės datos";
$GLOBALS['strValue'] = "Vertė";
$GLOBALS['strWarning'] = "Perspėjimas";
$GLOBALS['strNotice'] = "Įspėjimas";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "The dashboard can not be displayed";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "System message";
$GLOBALS['strDashboardErrorHelp'] = "If this error repeats please describe your problem in detail and post it on <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Pirmenybė";
$GLOBALS['strPriorityLevel'] = "Pirmumo lygmuo";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Capping";

// Properties
$GLOBALS['strName'] = "Vardas";
$GLOBALS['strSize'] = "Dydis";
$GLOBALS['strWidth'] = "Plotis";
$GLOBALS['strHeight'] = "A";
$GLOBALS['strTarget'] = "Taikinys";
$GLOBALS['strLanguage'] = "Kalba";
$GLOBALS['strDescription'] = "Aprašymas";
$GLOBALS['strVariables'] = "Kintamieji";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Komentarai";

// User access
$GLOBALS['strWorkingAs'] = "Dirbama kaip";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Dirbama kaip";
$GLOBALS['strSwitchTo'] = "Switch to";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s skirta...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "Add user";
$GLOBALS['strLinkUser_Key'] = "Susieti <u>v</u>artotojus";
$GLOBALS['strUsernameToLink'] = "Username of user to add";
$GLOBALS['strNewUserWillBeCreated'] = "Naujas vartotojas sukurtas";
$GLOBALS['strToLinkProvideEmail'] = "To add user, provide user's email";
$GLOBALS['strToLinkProvideUsername'] = "To add user, provide username";
$GLOBALS['strUserLinkedToAccount'] = "User has been added to account";
$GLOBALS['strUserAccountUpdated'] = "Atnaujinta vartotojo sąskaita";
$GLOBALS['strUserUnlinkedFromAccount'] = "User has been removed from account";
$GLOBALS['strUserWasDeleted'] = "User has been deleted";
$GLOBALS['strUserNotLinkedWithAccount'] = "Toks vartotojas nesusietas su sąskaita";
$GLOBALS['strCantDeleteOneAdminUser'] = "Jūs negalite ištrinti vartotojo. Bent vienas vartotojas turi būti susietas su administratoriaus sąskaita";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Vartotojo vardas";
$GLOBALS['strLinkUserHelpEmail'] = "El. pašto adresas";
$GLOBALS['strLastLoggedIn'] = "Last logged in";
$GLOBALS['strDateLinked'] = "Date linked";

// Login & Permissions
$GLOBALS['strUserAccess'] = "vartotojo priėjimas";
$GLOBALS['strAdminAccess'] = "Administratoriaus priėjimas";
$GLOBALS['strUserProperties'] = "Vartotojo ypatybės";
$GLOBALS['strPermissions'] = "Leidimai";
$GLOBALS['strAuthentification'] = "Autorizacija";
$GLOBALS['strWelcomeTo'] = "Sveiki atvykę į";
$GLOBALS['strEnterUsername'] = "Įveskite savo vartotojo vardą ir slaptažodį, jei norite prisijungti";
$GLOBALS['strEnterBoth'] = "Prašome įvesti abu savo vartotojo vardus ir slaptažodžius ";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Sesijos cookie klaida, prašome prisijungti dar kartą";
$GLOBALS['strLogin'] = "Prisijungti";
$GLOBALS['strLogout'] = "išsiregistruoti";
$GLOBALS['strUsername'] = "Vartotojo vardas";
$GLOBALS['strPassword'] = "Slaptažodis";
$GLOBALS['strPasswordRepeat'] = "Pakartokite slaptažodį";
$GLOBALS['strAccessDenied'] = "Priėjimas uždraustas";
$GLOBALS['strUsernameOrPasswordWrong'] = "Vartotojo vardas ir slaptažodis neteisingai įvesti. Prašome bandyti iš naujo. ";
$GLOBALS['strPasswordWrong'] = "Jūsų slaptažodis neteisingas. ";
$GLOBALS['strNotAdmin'] = "Jūsų sąskaita neturi visų reikiamų leidimų šiai savybei naudoti, Jūs galite prisijungti į kitą sąskaitą norėdami ją panaudoti. Spauskite <a href='logout.php'>čia</a> norėdami prisijungti prie kitos sąskaitos.";
$GLOBALS['strDuplicateClientName'] = "Vartotojo vardas, kurį pateikėte jau egzistuoja, prašome naudoti kitokį vartotojo vardą. ";
$GLOBALS['strInvalidPassword'] = "Naujasis slaptažodis, kurį pateikėte jau egzistuoja, prašome naudoti kitokį slaptažodį. ";
$GLOBALS['strInvalidEmail'] = "El. paštas neteisingai suformatuotas, prašome įvesti teisingą el. pašto adresą.";
$GLOBALS['strNotSamePasswords'] = "Du slaptažodžiai, kuriuos įvedėte nėra vienodi";
$GLOBALS['strRepeatPassword'] = "Pakartokite slaptažodį";
$GLOBALS['strDeadLink'] = "Your link is invalid.";
$GLOBALS['strNoPlacement'] = "Selected campaign does not exist. Try this <a href='{link}'>link</a> instead";
$GLOBALS['strNoAdvertiser'] = "Selected advertiser does not exist. Try this <a href='{link}'>link</a> instead";

// General advertising
$GLOBALS['strRequests'] = "Prašymai";
$GLOBALS['strImpressions'] = "Įspūdis";
$GLOBALS['strClicks'] = "Paspaudimai";
$GLOBALS['strConversions'] = "Konvertavimas";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Viso paspaudimų";
$GLOBALS['strTotalConversions'] = "Viso konvertavimų";
$GLOBALS['strDateTime'] = "Data Laikas";
$GLOBALS['strTrackerID'] = "Agento ID";
$GLOBALS['strTrackerName'] = "Agento vardas";
$GLOBALS['strTrackerImageTag'] = "Image Tag";
$GLOBALS['strTrackerJsTag'] = "Javascript Tag";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "Baneriai";
$GLOBALS['strCampaigns'] = "Kampanija";
$GLOBALS['strCampaignID'] = "Kampanijos ID";
$GLOBALS['strCampaignName'] = "Kampanijos pavadinimas";
$GLOBALS['strCountry'] = "Šalis";
$GLOBALS['strStatsAction'] = "Veiksmas";
$GLOBALS['strWindowDelay'] = "Lango atidėjimas";
$GLOBALS['strStatsVariables'] = "Kintamieji";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Mėnesinis nuomos terminas";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Data";
$GLOBALS['strDay'] = "Diena";
$GLOBALS['strDays'] = "Dienos";
$GLOBALS['strWeek'] = "Savaitė";
$GLOBALS['strWeeks'] = "Savaitės";
$GLOBALS['strSingleMonth'] = "Mėnesis";
$GLOBALS['strMonths'] = "Mėnesiai";
$GLOBALS['strDayOfWeek'] = "Savaitės diena";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Sunday';
$GLOBALS['strDayFullNames'][1] = 'Monday';
$GLOBALS['strDayFullNames'][2] = 'Tuesday';
$GLOBALS['strDayFullNames'][3] = 'Wednesday';
$GLOBALS['strDayFullNames'][4] = 'Thursday';
$GLOBALS['strDayFullNames'][5] = 'Friday';
$GLOBALS['strDayFullNames'][6] = 'Saturday';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'Su';
$GLOBALS['strDayShortCuts'][1] = 'Mo';
$GLOBALS['strDayShortCuts'][2] = 'Tu';
$GLOBALS['strDayShortCuts'][3] = 'We';
$GLOBALS['strDayShortCuts'][4] = 'Th';
$GLOBALS['strDayShortCuts'][5] = 'Fr';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "Valanda";
$GLOBALS['strSeconds'] = "Sekundės";
$GLOBALS['strMinutes'] = "Minutės";
$GLOBALS['strHours'] = "Valandos";

// Advertiser
$GLOBALS['strClient'] = "Reklamos skelbėjas";
$GLOBALS['strClients'] = "Reklamos skelbėjai";
$GLOBALS['strClientsAndCampaigns'] = "Reklamos skelbėjai ir kampanijos";
$GLOBALS['strAddClient'] = "Pridėti naują reklamos skelbėją";
$GLOBALS['strClientProperties'] = "Advertiser Properties";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "There are currently no advertisers defined. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteClient'] = "Ar tikrai norite ištrinti šį reklamos skelbėją?";
$GLOBALS['strConfirmDeleteClients'] = "Ar tikrai norite ištrinti šį reklamos skelbėją?";
$GLOBALS['strHideInactive'] = "Hide inactive";
$GLOBALS['strInactiveAdvertisersHidden'] = "Neaktyvus reklamos skelbėjai paslėpti.";
$GLOBALS['strAdvertiserSignup'] = "Prisijunti reklamuotojui";
$GLOBALS['strAdvertiserCampaigns'] = "Reklamos skelbėjai ir kampanijos";

// Advertisers properties
$GLOBALS['strContact'] = "Kontaktai";
$GLOBALS['strContactName'] = "Kontaktinis vardas";
$GLOBALS['strEMail'] = "El. paštas";
$GLOBALS['strSendAdvertisingReport'] = "El. pranešimų atsiuntimo ataskaitų kampanija";
$GLOBALS['strNoDaysBetweenReports'] = "Dienų skaičius tarp atsiuntimo ataskaitų kampanijos";
$GLOBALS['strSendDeactivationWarning'] = "Siųsti el. pranešimą, kai kampanija automatiškai aktyvuoja/ išjungta";
$GLOBALS['strAllowClientModifyBanner'] = "Leisti šiam vartotojui keisti savo pačio banerius";
$GLOBALS['strAllowClientDisableBanner'] = "Leisti šiam vartotojui išjungti savo pačio banerius";
$GLOBALS['strAllowClientActivateBanner'] = "Leisti šiam vartotojui aktyvuoti savo pačio banerius";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Rodyti tik banerį ";
$GLOBALS['strAllowAuditTrailAccess'] = "Allow this user to access the audit trail";

// Campaign
$GLOBALS['strCampaign'] = "Kampanija";
$GLOBALS['strCampaigns'] = "Kampanija";
$GLOBALS['strAddCampaign'] = "pridėti naują kampaniją";
$GLOBALS['strAddCampaign_Key'] = "Pridėti <u>n</u>ają kampaniją";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Linked Campaigns";
$GLOBALS['strCampaignProperties'] = "Campaign Properties";
$GLOBALS['strCampaignOverview'] = "Kampanijos peržiūra";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "There are currently no campaigns defined for this advertiser.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Ar tikrai norite ištrinti šią kampaniją?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Ar tikrai norite ištrinti šią kampaniją?";
$GLOBALS['strShowParentAdvertisers'] = "Rodyti pagrindinius reklamos skleidėjus";
$GLOBALS['strHideParentAdvertisers'] = "Slėpti pagrindinius reklamos skleidėjus";
$GLOBALS['strHideInactiveCampaigns'] = "Paslėpti neaktyvias reklamos kampanijas";
$GLOBALS['strInactiveCampaignsHidden'] = "Neaktyvios reklamos kampanijos paslėptos";
$GLOBALS['strPriorityInformation'] = "Priority in relation to other campaigns";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Kampanija";
$GLOBALS['strHiddenAd'] = "Reklama";
$GLOBALS['strHiddenAdvertiser'] = "Reklamos skelbėjas";
$GLOBALS['strHiddenTracker'] = "Agentas";
$GLOBALS['strHiddenWebsite'] = "Internetinis puslapis";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Kampanijos vietos pasirinkimas";
$GLOBALS['strSelectUnselectAll'] = "Pažymėti/ Nuimti žymėjimą visiems";
$GLOBALS['strCampaignsOfAdvertiser'] = "of"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculated for all campaigns";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculated for this campaign";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Search";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "No websites and zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Linked";
$GLOBALS['strAvailable'] = "Available";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


// Campaign properties
$GLOBALS['strDontExpire'] = "Don't expire";
$GLOBALS['strActivateNow'] = "Start immediately";
$GLOBALS['strSetSpecificDate'] = "Set specific date";
$GLOBALS['strLow'] = "Žemas";
$GLOBALS['strHigh'] = "Aukštas";
$GLOBALS['strExpirationDate'] = "Pasibaigimo data";
$GLOBALS['strExpirationDateComment'] = "Kampanija baigsis šios dienos pabaigoje";
$GLOBALS['strActivationDate'] = "Pradžios data";
$GLOBALS['strActivationDateComment'] = "Kampanija prasidės šios dienos pradžioje";
$GLOBALS['strImpressionsRemaining'] = "Likę įspūdžiai";
$GLOBALS['strClicksRemaining'] = "Likę paspaudimai";
$GLOBALS['strConversionsRemaining'] = "Likę konvertavimai";
$GLOBALS['strImpressionsBooked'] = "Užsakyti įspūdžiai";
$GLOBALS['strClicksBooked'] = "Užsakyti paspaudimai";
$GLOBALS['strConversionsBooked'] = "Užsakyti konvertavimai";
$GLOBALS['strCampaignWeight'] = "Set the campaign weight";
$GLOBALS['strAnonymous'] = "Slėpti šios kampanijos internetinius puslapius ir reklamos skleidėjus.";
$GLOBALS['strTargetPerDay'] = "per dieną.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "The type of this campaign has been set to Remnant,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
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
$GLOBALS['strCampaignStatusPending'] = "Laukiantis";
$GLOBALS['strCampaignStatusInactive'] = "Aktyvus";
$GLOBALS['strCampaignStatusRunning'] = "Procesas";
$GLOBALS['strCampaignStatusPaused'] = "Laikinai sustabdytas";
$GLOBALS['strCampaignStatusAwaiting'] = "Laukiantis";
$GLOBALS['strCampaignStatusExpired'] = "Baigtas";
$GLOBALS['strCampaignStatusApproval'] = "Laukiama patvirtinimo »";
$GLOBALS['strCampaignStatusRejected'] = "Atmestas";
$GLOBALS['strCampaignStatusAdded'] = "Pridėtas";
$GLOBALS['strCampaignStatusStarted'] = "Pradėtas";
$GLOBALS['strCampaignStatusRestarted'] = "Atnaujintas";
$GLOBALS['strCampaignStatusDeleted'] = "Ištrinti";
$GLOBALS['strCampaignType'] = "Kampanijos pavadinimas";
$GLOBALS['strType'] = "Tipas";
$GLOBALS['strContract'] = "Kontaktai";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Kontaktai";
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
$GLOBALS['strPricing'] = "Pricing";
$GLOBALS['strPricingModel'] = "Pricing model";
$GLOBALS['strSelectPricingModel'] = "-- select model --";
$GLOBALS['strRatePrice'] = "Rate / Price";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
$GLOBALS['strWhyDisabled'] = "why is it disabled?";
$GLOBALS['strBackToCampaigns'] = "Back to campaigns";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Agentas";
$GLOBALS['strTrackers'] = "Agentas";
$GLOBALS['strTrackerPreferences'] = "Agento pirmenybės";
$GLOBALS['strAddTracker'] = "Pridėti naują agentą";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "Ar tikrai norite ištrinti šį agentą?";
$GLOBALS['strConfirmDeleteTracker'] = "Ar tikrai norite ištrinti šį agentą?";
$GLOBALS['strTrackerProperties'] = "Vartotojo ypatybės";
$GLOBALS['strDefaultStatus'] = "Pagrindinis statusas";
$GLOBALS['strStatus'] = "Statusas";
$GLOBALS['strLinkedTrackers'] = "Susieti agentai";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Konvertavimo langas";
$GLOBALS['strUniqueWindow'] = "Unikalus langas";
$GLOBALS['strClick'] = "Paspaudimas";
$GLOBALS['strView'] = "Vaizdas";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Conversion Type";
$GLOBALS['strLinkCampaignsByDefault'] = "Sujungti naujai sukurtas kampanijas";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "Baneris";
$GLOBALS['strBanners'] = "Baneriai";
$GLOBALS['strAddBanner'] = "Pridėti naują banerį";
$GLOBALS['strAddBanner_Key'] = "Pridėti <u>n</u>aują banerį";
$GLOBALS['strBannerToCampaign'] = "Jūsų kampanija";
$GLOBALS['strShowBanner'] = "Rodyti banerius";
$GLOBALS['strBannerProperties'] = "Vartotojo ypatybės";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "There are currently no banners defined for this campaign.";
$GLOBALS['strNoBannersAddCampaign'] = "There are currently no banners defined, because there are no campaigns. To create a banner, <a href='campaign-edit.php?clientid=%s'>add a new campaign</a> first.";
$GLOBALS['strNoBannersAddAdvertiser'] = "There are currently no banners defined, because there are no advertisers. To create a banner, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteBanner'] = "Ar tikrai norite ištrinti šį banerį?";
$GLOBALS['strConfirmDeleteBanners'] = "Ar tikrai norite ištrinti šį banerį?";
$GLOBALS['strShowParentCampaigns'] = "Rodyti pagrindines kampanijas";
$GLOBALS['strHideParentCampaigns'] = "Slėpti pagrindines kampanijas";
$GLOBALS['strHideInactiveBanners'] = "Slėpti neaktyvius banerius";
$GLOBALS['strInactiveBannersHidden'] = "Neaktyvūs baneriai paslėpti";
$GLOBALS['strWarningMissing'] = "Įspėjimas, tikriausiai trūksta";
$GLOBALS['strWarningMissingClosing'] = " closing tag '>'";
$GLOBALS['strWarningMissingOpening'] = " opening tag '<'";
$GLOBALS['strSubmitAnyway'] = "Tvirtinti bet kokiu atveju";
$GLOBALS['strBannersOfCampaign'] = "in"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Pirmenybė baneriui";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Pagrindiniai baneriai";
$GLOBALS['strDefaultBannerUrl'] = "Pagrindiniai vaizdų URL";
$GLOBALS['strDefaultBannerDestination'] = "Pagrindinė URL paskyrimo vieta";
$GLOBALS['strAllowedBannerTypes'] = "Leidžiami banerio tipai";
$GLOBALS['strTypeSqlAllow'] = "Leisti SQL vietinius banerius";
$GLOBALS['strTypeWebAllow'] = "Įgalinti internetinio serverio vietinius banerius";
$GLOBALS['strTypeUrlAllow'] = "Įgalinti išorinius banerius";
$GLOBALS['strTypeHtmlAllow'] = "Įgalinti HTML banerius";
$GLOBALS['strTypeTxtAllow'] = "Įgalinti teksto Ads";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Prašome pasirinkti kitą naberio tipą";
$GLOBALS['strMySQLBanner'] = "Upload a local banner to the database";
$GLOBALS['strWebBanner'] = "Upload a local banner to the webserver";
$GLOBALS['strURLBanner'] = "Link an external banner";
$GLOBALS['strHTMLBanner'] = "Create an HTML banner";
$GLOBALS['strTextBanner'] = "Create a Text banner";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Ar pageidaujate išsaugoti Jūsų <br />jau esantį paveikslėlį, ar Jūs norite <br /> įkelti kitą?";
$GLOBALS['strNewBannerFile'] = "Pasirinkite norimą paveikslėlį <br />, kurį naudosite šiam baneriui  <br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Pasirinkite atsarginį paveikslėlį, kurį Jūs <br />norite naudoti tuo atveju, jei naršyklės<br />nepalaiko rich media<br /><br />";
$GLOBALS['strNewBannerURL'] = "Vaizdo URL (incl. http://)";
$GLOBALS['strURL'] = "Galutinio tikslo URL (incl. http://)";
$GLOBALS['strKeyword'] = "Raktiniai žodžiai";
$GLOBALS['strTextBelow'] = "Tekstas po nuotrauka";
$GLOBALS['strWeight'] = "Svoris";
$GLOBALS['strAlt'] = "Visas tekstas";
$GLOBALS['strStatusText'] = "Teksto statusas";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Banerio svoris";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Bendras HTML baneris";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Bendras";
$GLOBALS['strSwfTransparency'] = "Leisti skaidrų foną";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Ieškoti sunkiai u-koduotų internetinių puslapių Flash failo viduje";
$GLOBALS['strConvertSWFLinks'] = "Pakeisti Flash saitus";
$GLOBALS['strHardcodedLinks'] = "Sunkiai užkoduoti saitai";
$GLOBALS['strConvertSWF'] = "<br />The Flash file you just uploaded contains hard-coded urls. {$PRODUCT_NAME} won't be able to track the number of Clicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br /><br />Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br />Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br /><br />";
$GLOBALS['strCompressSWF'] = "Suspausti SWF failą, tam kad būtų pagreitintas atsiuntimas (Flash 6 player reikalaujamas)";
$GLOBALS['strOverwriteSource'] = "Perrašyti šaltinio parametrus";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Delivery Options";
$GLOBALS['strACL'] = "Delivery Options";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "yra lygus";
$GLOBALS['strDifferentFrom'] = "skiriasi nuo";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "didesnis už";
$GLOBALS['strLessThan'] = "mažesnis už";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "IR";                          // logical operator
$GLOBALS['strOR'] = "AR";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Šį banerį rodyti tik";
$GLOBALS['strWeekDays'] = "Savaitės dienos";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Pirminis";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Perstatyti vaizdo skaitiklius po:";
$GLOBALS['strDeliveryCappingTotal'] = "viso";
$GLOBALS['strDeliveryCappingSession'] = "per sesiją";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Sumažinti banerių rodymų dydį iki: ";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Sumažinti kampanijų rodymų dydį iki:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Sumažinti zonų rodymų dydį iki:";

// Website
$GLOBALS['strAffiliate'] = "Internetinis puslapis";
$GLOBALS['strAffiliates'] = "Internetiniai puslapiai";
$GLOBALS['strAffiliatesAndZones'] = "Internetiniai puslapiai ir zonos";
$GLOBALS['strAddNewAffiliate'] = "Pridėti naują internetinį puslapį";
$GLOBALS['strAffiliateProperties'] = "Website Properties";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "There are currently no websites defined. To create a zone, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Ar tikrai norite ištrinti šį internetinį puslapį?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Ar tikrai norite ištrinti šį internetinį puslapį?";
$GLOBALS['strInactiveAffiliatesHidden'] = "Neaktyvūs internetiniai puslapiai paslėpti";
$GLOBALS['strShowParentAffiliates'] = "Rodyti pagrindinius (pirminius) internetinius puslapius";
$GLOBALS['strHideParentAffiliates'] = "Slėpti pagrindinius (pirminius) internetinius puslapius";

// Website (properties)
$GLOBALS['strWebsite'] = "Internetinis puslapis";
$GLOBALS['strWebsiteURL'] = "Website URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "Leisti šiam vartotojui redaguoti savo zonas";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Leisti šiam vartotojui susieti su savo zonomis banerius";
$GLOBALS['strAllowAffiliateAddZone'] = "Leisti šiam vartotojui kurti naujas zonas";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Leisti šiam vartotojui ištrinti jau sukurtas savo zonas";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Leisti šiam vartotojui generuoti aktyvizacijos kodą";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Pašto indeksas";
$GLOBALS['strCountry'] = "Šalis";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Internetiniai puslapiai ir zonos";

// Zone
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strZones'] = "Zonos";
$GLOBALS['strAddNewZone'] = "Pridėti naują zoną";
$GLOBALS['strAddNewZone_Key'] = "Pridėti <u>n</u>aują zoną";
$GLOBALS['strZoneToWebsite'] = "Visi internetiniai puslapiai";
$GLOBALS['strLinkedZones'] = "Linked Zones";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "Vartotojo ypatybės";
$GLOBALS['strZoneHistory'] = "Zone History";
$GLOBALS['strNoZones'] = "There are currently no zones defined for this website.";
$GLOBALS['strNoZonesAddWebsite'] = "There are currently no zones defined, because there are no websites. To create a zone, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strConfirmDeleteZone'] = "Ar tikrai norite ištrinti šią zoną";
$GLOBALS['strConfirmDeleteZones'] = "Ar tikrai norite ištrinti šią zoną";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Už kampanijas prijungtas prie šios zonos sumokėta, jei ištrinsite jas, nebegalėsite jų paleisti ir jums už jas nebus sumokėta.";
$GLOBALS['strZoneType'] = "Zonos tipas";
$GLOBALS['strBannerButtonRectangle'] = "Baneris, mygtukas ir stačiakampis";
$GLOBALS['strInterstitial'] = "Interstitial or Floating DHTML";
$GLOBALS['strPopup'] = "Popup";
$GLOBALS['strTextAdZone'] = "Text ad";
$GLOBALS['strEmailAdZone'] = "El. pašto/ informacinio biuletenio zona";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Rodyti sutampančius banerius";
$GLOBALS['strHideMatchingBanners'] = "Slėpti sutampančius banerius";
$GLOBALS['strBannerLinkedAds'] = "Baneriai susieti su zona";
$GLOBALS['strCampaignLinkedAds'] = "Kampanijos susietos su zona";
$GLOBALS['strInactiveZonesHidden'] = "neaktyvios zonos palsėptos";
$GLOBALS['strWarnChangeZoneType'] = "Keičiant zonos tipą į tekstinį ar elektroninį paštą atsies visus banerius/kampanijas dėl šių zonos tipų pažeidimų                                                 <ul>
                                                    <li>Tekstinės zonos gali būti priskirtos tik teksto ads</li>
                                                    <li>Elektroninio pašto zonos gali turėti tik vieną aktyvų banerį vienu metu</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Zonos pakeitimas  gali lemti tai, kad baneriai, kurie nėra naujojo dydžio bus nebesusieti su zona, ir gali pridėti kampanijų banerius, kurie atitinka šį dydį';
$GLOBALS['strWarnChangeBannerSize'] = 'Banerio dydžio keitimas atsies šį banerį nuo visų zonų, kurios nėra tokio dydžio koks jis dabar, o jei šio banerio <strong>kampanija</strong>susieta su naujo dydžio zona, tai šis baners bus susietas automatiškai';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'in'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

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
$GLOBALS['strAdvanced'] = "Papildomi nustatymai";
$GLOBALS['strChainSettings'] = "Grandinės nustatymai";
$GLOBALS['strZoneNoDelivery'] = "Jei šioje zonoje nėra banerių <br />, tai negali būti pristatyta, pabandykite...";
$GLOBALS['strZoneStopDelivery'] = "Sustabdyti pristatymą ir nerodyti banerio";
$GLOBALS['strZoneOtherZone'] = "Rodyti pasirinktą zoną vietoj to";
$GLOBALS['strZoneAppend'] = "Visada pridėti HTML kodą baneriams rodomiems šioje zonoje";
$GLOBALS['strAppendSettings'] = "Papildyti ir pridėti nustatymų";
$GLOBALS['strZonePrependHTML'] = "Visada įkelti HTML kodus rodomam tekstui šioje zonoje";
$GLOBALS['strZoneAppendNoBanner'] = "Pridėti net ir tuo atveju jei baneris nepristatytas";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML kodas";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup ir interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Visi baneriai priskirti pasirinktai zonai šiuo metu yra neaktyvūs. <br/> Šios zonos grandinė bus tokia:";
$GLOBALS['strZoneProbNullPri'] = "Prie šios zonos nėra priskirtų banerių. ";
$GLOBALS['strZoneProbListChainLoop'] = "Sekant zonos grandinę galimas uždaras ciklas. Atsiuntimas šioje zonoje sustabdytas. ";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Prašome pasirinkti ką norite susieti su šia zona";
$GLOBALS['strLinkedBanners'] = "Susieti individualius banerius";
$GLOBALS['strCampaignDefaults'] = "Susieti  banerius su pagrindine kampanija";
$GLOBALS['strLinkedCategories'] = "Susieti banerius pagal kategorijas";
$GLOBALS['strWithXBanners'] = "baneris";
$GLOBALS['strRawQueryString'] = "Raktinis žodis";
$GLOBALS['strIncludedBanners'] = "Linked Banners";
$GLOBALS['strMatchingBanners'] = "{skaičiuoti} sutampantys baneriai";
$GLOBALS['strNoCampaignsToLink'] = "Nėra galimų kampanijų su kuriomis galėtų būti susietos su šia zona";
$GLOBALS['strNoTrackersToLink'] = "Šiuo metu nėra galimų agentų, kurie galėtų būti susieti su šia kampanija";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Nėra galimų zonų su kuriomis galėtų būti susieta ši kampanija";
$GLOBALS['strSelectBannerToLink'] = "Pasirinkite banerį, kurį norėtumėte susieti su šia zona:";
$GLOBALS['strSelectCampaignToLink'] = "Pasirinkite kampaniją, kurią norėtumėte susieti su šia zona:";
$GLOBALS['strSelectAdvertiser'] = "Pasirinkite reklamuotoją";
$GLOBALS['strSelectPlacement'] = "Pasirinkite kampaniją";
$GLOBALS['strSelectAd'] = "Pasirinkite banerį";
$GLOBALS['strSelectPublisher'] = "Pasirinkite internetinį puslapį";
$GLOBALS['strSelectZone'] = "Pasirinkite zoną";
$GLOBALS['strStatusPending'] = "Laukiantis";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Kopijuoti";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Tipas";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Redaguoti statusus";
$GLOBALS['strShortcutShowStatuses'] = "Rodyti statusus";

// Statistics
$GLOBALS['strStats'] = "Statistika";
$GLOBALS['strNoStats'] = "Šiuo metu nėra jokio prieinamos statistikos";
$GLOBALS['strNoStatsForPeriod'] = "Šiuo metu nėra  statistikos nuo %s iki %s ";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Viso per šį periodą";
$GLOBALS['strPublisherDistribution'] = "Website Distribution";
$GLOBALS['strCampaignDistribution'] = "Campaign Distribution";
$GLOBALS['strViewBreakdown'] = "Rodyti pagal";
$GLOBALS['strBreakdownByDay'] = "Diena";
$GLOBALS['strBreakdownByWeek'] = "Savaitė";
$GLOBALS['strBreakdownByMonth'] = "Mėnesis";
$GLOBALS['strBreakdownByDow'] = "Savaitės diena";
$GLOBALS['strBreakdownByHour'] = "Valanda";
$GLOBALS['strItemsPerPage'] = "Gaminiai per puslapį";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Rodyti <u>G</u>rafas statistikos";
$GLOBALS['strExportStatisticsToExcel'] = "<u>Į</u>kelti statistiką į Excel failą";
$GLOBALS['strGDnotEnabled'] = "Jūs turite įgalinti GD veikimą pagal PHP. <br />Čia rasite <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> daugiau informacijos, įskaitant ir tai, kaip  įdiegti GD į jūsų serverį.";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "Nėra galiojimo pasibaigimo nustatytos datos";
$GLOBALS['strEstimated'] = "Estimated expiration date";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "days ago";
$GLOBALS['strCampaignStop'] = "Kampanijos pavadinimas";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Periodas";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Visi reklamuotojai";
$GLOBALS['strAnonAdvertisers'] = "Anonimiški reklamos skleidėjai";
$GLOBALS['strAllPublishers'] = "Visi internetiniai puslapiai";
$GLOBALS['strAnonPublishers'] = "Anonimiški internetiniai puslapiai";
$GLOBALS['strAllAvailZones'] = "Visos galimos zonos";

// Userlog
$GLOBALS['strUserLog'] = "Vartotojo registracija";
$GLOBALS['strUserLogDetails'] = "Vartotojo registracijos detalės";
$GLOBALS['strDeleteLog'] = "Ištrinit regitraciją";
$GLOBALS['strAction'] = "Veiksmas";
$GLOBALS['strNoActionsLogged'] = "Nėra jokių registruotų veiksmų";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Tiesioginis pasirinkimas";
$GLOBALS['strChooseInvocationType'] = "Prašome pasirinkti banerio aktyvizacijos tipą";
$GLOBALS['strGenerate'] = "Generuoti";
$GLOBALS['strParameters'] = "Tag nustatymai";
$GLOBALS['strFrameSize'] = "Rėmelių dydis";
$GLOBALS['strBannercode'] = "Banerio kodas";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Grįžti į ataskaitų sąrašą";
$GLOBALS['strCharset'] = "Ženklų nustatymus";
$GLOBALS['strAutoDetect'] = "Auto radimas";
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

$GLOBALS['strThirdPartyComment'] = "
  * Don't forget to replace the '{clickurl}' text with
  * the click tracking URL if this ad is to be delivered through a 3rd
  * party (non-Max) adserver.
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
$GLOBALS['strNoMatchesFound'] = "Jokių atitikmenų nerasta";
$GLOBALS['strErrorOccurred'] = "Atsirado klaida";
$GLOBALS['strErrorDBPlain'] = "Atsirado klaida priėjimu prie duomenų bazės metu";
$GLOBALS['strErrorDBSerious'] = "Rasta rimta duomenų bazės problema";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Duomenų bazės lentelė greičiausiai yra sugadinta ir turi būti pataisyta. Daugiau informacijos apie sugadintų lenteliu taisymą prašome skaityti skyrių <i>Troubleshooting</i> iš <i>Administratoriaus gido</i>.";
$GLOBALS['strErrorDBContact'] = "Prašome susisiekti su šio serverio administratoriumi ir ptanešti jam ar jai apie šią problemą. ";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "Neįmanoma ssieti šį banerį su šia zona, nes:";
$GLOBALS['strUnableToLinkBanner'] = "Negalima susieti šio banerio:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Error updating zone:";
$GLOBALS['strUnableToChangeZone'] = "Neįmanoma patvirtinti šių pasikeitimų, nes:";
$GLOBALS['strDatesConflict'] = "datos prieštarauja su:";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Kai kurios iš šių statistikų buvo prijungtos  prie ne ne-UTC laiko zonos, ir gali būti rodomos neteisingu laiko zonos laiku. ";
$GLOBALS['strWarningInaccurateReadMore'] = "Skaitykite daugiau apie tai";
$GLOBALS['strWarningInaccurateReport'] = "Dalis  šios ataskaitos statistikos buvo priregistruoti į ne-UTC laiko zoną, ir gali būti rodoma neteisingoje laiko zonoje ";

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
$GLOBALS['strSirMadam'] = "Pone/Madam";
$GLOBALS['strMailSubject'] = "Reklamos skleidėjo ataskaita";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Žemiau rasite banerio statistiką, skirtą {klientvardas}: ";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanija aktyvuota";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanija deaktyvuota";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Jūsų kampanija, rodoma žemiau, buvo deaktyvuota, nes";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Ši kampanija šiuo metu neaktyvi, nes";
$GLOBALS['strBeforeActivate'] = "aktyvacijos data dar neatėjo";
$GLOBALS['strAfterExpire'] = "atėjo galiojimo pasibaigimo data";
$GLOBALS['strNoMoreImpressions'] = "nėra likusių spaudinių";
$GLOBALS['strNoMoreClicks'] = "nėra likusių paspaudimų";
$GLOBALS['strNoMoreConversions'] = "nėra likusių išpardavimų";
$GLOBALS['strWeightIsNull'] = "nustatytas nulinis svoris";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "Jokių spaudinių nerasta per šios ataskaitos trukmę (laiką)";
$GLOBALS['strNoClickLoggedInInterval'] = "Jokių paspaudimų nerasta per šios ataskaitos trukmę (laiką)";
$GLOBALS['strNoConversionLoggedInInterval'] = "Jokių konversijų nerasta per šios ataskaitos trukmę (laiką)";
$GLOBALS['strMailReportPeriod'] = "Ataskaitoje yra statistinių duomenų nuo {pradžia} iki {pabaiga}.";
$GLOBALS['strMailReportPeriodAll'] = "Ataskaitoje yra statistinių duomenų iki {pabaigos data}.";
$GLOBALS['strNoStatsForCampaign'] = "Nėra jokių statistinių duomenų šiai kampanijai";
$GLOBALS['strImpendingCampaignExpiry'] = "Artėja kampanijos pasibaigimo data";
$GLOBALS['strYourCampaign'] = "Jūsų kampanija";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampanija priklauso";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{klientovardas} rodomas žemiau baigiasi {data}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{klientovardas} rodomas žemiau turi spaudos limitą, kurios dydis yra {limitodydis}.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Pirmenybė";
$GLOBALS['strSourceEdit'] = "Koreguoti šaltinius";

// Preferences
$GLOBALS['strPreferences'] = "Pirmenybė";
$GLOBALS['strUserPreferences'] = "Vartotojo pirmenybės";
$GLOBALS['strChangePassword'] = "pakeisti slaptažodį";
$GLOBALS['strChangeEmail'] = "Pakeisti el.paštą";
$GLOBALS['strCurrentPassword'] = "Dabartinis slaptažodis";
$GLOBALS['strChooseNewPassword'] = "Pasirinkite naują slaptažodį";
$GLOBALS['strReenterNewPassword'] = "Įveskite dar kartą naują slaptažodį";
$GLOBALS['strNameLanguage'] = "Vardas ir kalba";
$GLOBALS['strAccountPreferences'] = "Sąskaitos pirmenybės";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Kampanijos e. pašto ataskaitų pirmenybės";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "Administratoriaus el. pašto įspėjimai";
$GLOBALS['strAgencyEmailWarnings'] = "Agentūros el. pašto įspėjimai";
$GLOBALS['strAdveEmailWarnings'] = "reklamuotojo el. pašto įspėjimai";
$GLOBALS['strFullName'] = "Pilnas vardas";
$GLOBALS['strEmailAddress'] = "El. pašto adresas";
$GLOBALS['strUserDetails'] = "Vartotojo detalės";
$GLOBALS['strUserInterfacePreferences'] = "Vartotojo sąsajų pirmenybės";
$GLOBALS['strPluginPreferences'] = "Pagrindinės pirmenybės";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strNumberOfItems'] = "Gaminių skaičius";
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
$GLOBALS['strImpressionSR'] = "Įspūdis";
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
$GLOBALS['strClicks_short'] = "Paspaudimai";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Bendri nustatymai";
$GLOBALS['strGeneralSettings'] = "Bendri nustatymai";
$GLOBALS['strMainSettings'] = "Pagrindiniai nustatymai";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Pasirinkti dalį';

// Product Updates
$GLOBALS['strProductUpdates'] = "Prekės atnaujinimas";
$GLOBALS['strViewPastUpdates'] = "Rasti senus atnaujinimus ir Backups";
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
$GLOBALS['strAgencyManagement'] = "Account Management";
$GLOBALS['strAgency'] = "Account";
$GLOBALS['strAddAgency'] = "Add new account";
$GLOBALS['strAddAgency_Key'] = "Pridėti <u>n</u>aują zoną";
$GLOBALS['strTotalAgencies'] = "Total accounts";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "Nerasta jokių zonų";
$GLOBALS['strConfirmDeleteAgency'] = "Ar tikrai norite ištrinti šią zoną";
$GLOBALS['strHideInactiveAgencies'] = "Hide inactive accounts";
$GLOBALS['strInactiveAgenciesHidden'] = "neaktyvios zonos palsėptos";
$GLOBALS['strSwitchAccount'] = "Perjungti į šią sąskaitą";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "Visi internetiniai puslapiai";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Delivery Options";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'in'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Kintamas vardas";
$GLOBALS['strVariableDescription'] = "Aprašymas";
$GLOBALS['strVariableDataType'] = "Duomenų tipas";
$GLOBALS['strVariablePurpose'] = "Tikslas";
$GLOBALS['strGeneric'] = "Bendras";
$GLOBALS['strBasketValue'] = "Krepšelio vertė";
$GLOBALS['strNumItems'] = "Gaminių skaičius";
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Skaičius";
$GLOBALS['strString'] = "Eilė";
$GLOBALS['strTrackFollowingVars'] = "Susekti sekantį kintamąjį";
$GLOBALS['strAddVariable'] = "Pridėti kintamąjį ";
$GLOBALS['strNoVarsToTrack'] = "Nėra kintamųjų, kuriuos būtų galima susekti";
$GLOBALS['strVariableRejectEmpty'] = "Atmesti jei tusčia?";
$GLOBALS['strTrackingSettings'] = "Sekimo nustatymai";
$GLOBALS['strTrackerType'] = "Agento tippas";
$GLOBALS['strTrackerTypeJS'] = "Susekti JavaScript kintamuosius";
$GLOBALS['strTrackerTypeDefault'] = "Susekti JavaScript kintamuosius (priešingus sutaikomus, išėjimo reikalaujamus)";
$GLOBALS['strTrackerTypeDOM'] = "Susekti HTML elementus, naudojantis DOM";
$GLOBALS['strTrackerTypeCustom'] = "Įprastas JS kodas";
$GLOBALS['strVariableCode'] = "Javascript sekimo kodas";

// Password recovery
$GLOBALS['strForgotPassword'] = "Pamiršote savo slaptažodį?";
$GLOBALS['strPasswordRecovery'] = "Slaptažodžio gražinimas";
$GLOBALS['strEmailRequired'] = "Privaloma užpildyti elektroninį lauką";
$GLOBALS['strPwdRecWrongId'] = "Neteisingas ID ";
$GLOBALS['strPwdRecEnterEmail'] = "Įveskite savo elektroninio pašto adresą žemiau";
$GLOBALS['strPwdRecEnterPassword'] = "Įveskite savo slaptažodį žemiau";
$GLOBALS['strPwdRecResetLink'] = "Slaptažodžio pakeitimo nuoroda";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s slaptažodžio grąžinimas";
$GLOBALS['strProceed'] = "Tęskite >";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to re-set your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return the the main login page.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "Pridėti papildomų punktų";
$GLOBALS['strFor'] = "skirta";
$GLOBALS['strHas'] = "turi";
$GLOBALS['strBinaryData'] = "Dvejetainė data";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail naudojimas administrtoriui buvo apribotas. Jokių įvykių Audit Trail sąraše neberegistruojama ir neberodoma. ";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Per laiko tarpą, kurį pasirinkote jokia vartotojo veikla neužfiksuota";
$GLOBALS['strAuditTrail'] = "Audit trail";
$GLOBALS['strAuditTrailSetup'] = "Nustatykite Audit trail šiandien";
$GLOBALS['strAuditTrailGoTo'] = "Eiti į Audit trail puslapį";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Eiti į kampanijos puslapį";
$GLOBALS['strCampaignSetUp'] = "Nustatyti kampaniją šiandien";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li> Nėra jokių įrašų atvaizduoti kampanijos veiklą.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Per laiko tarpą, kurį pasirinkote jokia kampanija neprasidėjo ir nesibaigė";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktyvuokite Audit Trail norėdami pradėti peržiūrėti kampanijas";

$GLOBALS['strUnsavedChanges'] = "You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "You are now working as <b>%s</b>";
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
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected delivery rule sets have been deleted";
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
