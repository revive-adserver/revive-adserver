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

$GLOBALS['strHome'] = "Domov";
$GLOBALS['strHelp'] = "Pomoč";
$GLOBALS['strStartOver'] = "Začni znova";
$GLOBALS['strShortcuts'] = "Bližnjice";
$GLOBALS['strActions'] = "Dejanja";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "Inventar";
$GLOBALS['strMaintenance'] = "Vzdrževanje";
$GLOBALS['strProbability'] = "Verjetnost prikaza";
$GLOBALS['strInvocationcode'] = "Pozivna koda";
$GLOBALS['strBasicInformation'] = "Osnovne informacije";
$GLOBALS['strAppendTrackerCode'] = "Pripni sledilno kodo";
$GLOBALS['strOverview'] = "Pregled";
$GLOBALS['strSearch'] = "<u>I</u>skanje";
$GLOBALS['strDetails'] = "Podrobnosti";
$GLOBALS['strUpdateSettings'] = "Posodobitvene nastavitve";
$GLOBALS['strCheckForUpdates'] = "Preveri za posodobitve";
$GLOBALS['strWhenCheckingForUpdates'] = "Pri preverjanju za posodobitve";
$GLOBALS['strCompact'] = "Zgoščeno";
$GLOBALS['strUser'] = "Uporabnik";
$GLOBALS['strDuplicate'] = "Podvoji";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "Premakni v";
$GLOBALS['strDelete'] = "Izbriši";
$GLOBALS['strActivate'] = "Aktiviraj";
$GLOBALS['strConvert'] = "Pretvori";
$GLOBALS['strRefresh'] = "Osveži";
$GLOBALS['strSaveChanges'] = "Shrani spremembe";
$GLOBALS['strUp'] = "Gor";
$GLOBALS['strDown'] = "Dol";
$GLOBALS['strSave'] = "Shrani";
$GLOBALS['strCancel'] = "Prekliči";
$GLOBALS['strBack'] = "Nazaj";
$GLOBALS['strPrevious'] = "Predhodnji";
$GLOBALS['strNext'] = "Naslednji";
$GLOBALS['strYes'] = "Da";
$GLOBALS['strNo'] = "Ne";
$GLOBALS['strNone'] = "Nobeden";
$GLOBALS['strCustom'] = "Po meri";
$GLOBALS['strDefault'] = "Privzeto";
$GLOBALS['strUnknown'] = "Unknown";
$GLOBALS['strUnlimited'] = "Neomejeno";
$GLOBALS['strUntitled'] = "Neimenovano";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "Povprečje";
$GLOBALS['strOverall'] = "Celotno";
$GLOBALS['strTotal'] = "Skupno";
$GLOBALS['strFrom'] = "From";
$GLOBALS['strTo'] = "do";
$GLOBALS['strAdd'] = "Dodaj";
$GLOBALS['strLinkedTo'] = "povezan z";
$GLOBALS['strDaysLeft'] = "Preostalo dni";
$GLOBALS['strCheckAllNone'] = "Preveri vse / ničesar";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>R</u>azširi vse";
$GLOBALS['strCollapseAll'] = "<u>P</u>ovrni vse";
$GLOBALS['strShowAll'] = "Prikaži vse";
$GLOBALS['strNoAdminInterface'] = "Administratorski vmesnik je bil izklopljen zaradi vzdrževalnih del. To ne vpliva na dostavo vaših kampanj.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "\\'Od' datum mora biti zgodnješi kot 'Do' datum";
$GLOBALS['strFieldContainsErrors'] = "Naslednja polja vsebujejo napake:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Preden lahko nadaljujete, morate";
$GLOBALS['strFieldFixBeforeContinue2'] = "te napake odpraviti.";
$GLOBALS['strMiscellaneous'] = "Razno";
$GLOBALS['strCollectedAllStats'] = "Vse statistike";
$GLOBALS['strCollectedToday'] = "Danes";
$GLOBALS['strCollectedYesterday'] = "Včeraj";
$GLOBALS['strCollectedThisWeek'] = "Trenutni teden";
$GLOBALS['strCollectedLastWeek'] = "Prejšnji teden";
$GLOBALS['strCollectedThisMonth'] = "Trenutni mesec";
$GLOBALS['strCollectedLastMonth'] = "Prejšnji mesec";
$GLOBALS['strCollectedLast7Days'] = "Zadnjih 7 dni";
$GLOBALS['strCollectedSpecificDates'] = "Izbrani datumi";
$GLOBALS['strValue'] = "Vrednost";
$GLOBALS['strWarning'] = "Opozorilo";
$GLOBALS['strNotice'] = "Obvestilo";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Nadzorna plošča ne more biti prikazana";
$GLOBALS['strNoCheckForUpdates'] = "Nadzorna plošča trenutno ne more biti prikazana, ker imate<br/>onemogočeno nastavitev Preveri za posodobitve.";
$GLOBALS['strEnableCheckForUpdates'] = "Prosimo omogočite nastavite <a href='account-settings-update.php'>preveri za posodobitve</a> na strani<br/><a href='account-settings-update.php'>posodobitvene nastavitve</a> .";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "koda";
$GLOBALS['strDashboardSystemMessage'] = "Sistemsko sporočilo";
$GLOBALS['strDashboardErrorHelp'] = "Če se ta napaka ponovi, jo prosimo podrobno opišite in objavite na <a href='http://forum.openx.org/'>OpenX forumu</a>.";

// Priority
$GLOBALS['strPriority'] = "Prioriteta";
$GLOBALS['strPriorityLevel'] = "Prednostna raven";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Pogodbeni oglasi";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Preostali oglasi";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Prilagoditev";

// Properties
$GLOBALS['strName'] = "Ime";
$GLOBALS['strSize'] = "Velikost";
$GLOBALS['strWidth'] = "Širina";
$GLOBALS['strHeight'] = "Višina";
$GLOBALS['strTarget'] = "Cilj";
$GLOBALS['strLanguage'] = "Jezik";
$GLOBALS['strDescription'] = "Opis";
$GLOBALS['strVariables'] = "Spremenljivke";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Komentarji";

// User access
$GLOBALS['strWorkingAs'] = "Deluje kot";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Deluje kot";
$GLOBALS['strSwitchTo'] = "Preklopi na";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s za...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "Dodaj uporabnika";
$GLOBALS['strLinkUser_Key'] = "Dodaj <u>u</u>porabnika";
$GLOBALS['strUsernameToLink'] = "Uporabniško ime uporabnika za dodajanje";
$GLOBALS['strNewUserWillBeCreated'] = "Ustvarjen bo nov uporabnik";
$GLOBALS['strToLinkProvideEmail'] = "Za dodajanje uporabnika vpišite njegov e-poštni naslov";
$GLOBALS['strToLinkProvideUsername'] = "Za dodajanje uporabnika vpišite njegovo uporabniško ime";
$GLOBALS['strUserLinkedToAccount'] = "Uporabnik je bil dodan računu";
$GLOBALS['strUserAccountUpdated'] = "Račun uporabnika je bil posodobljen";
$GLOBALS['strUserUnlinkedFromAccount'] = "Uporabnik je bil odstranjen iz računa";
$GLOBALS['strUserWasDeleted'] = "Uporabnik je bil izbrisan";
$GLOBALS['strUserNotLinkedWithAccount'] = "Naveden uporabnik ni povezan z računom";
$GLOBALS['strCantDeleteOneAdminUser'] = "Ne morete izbrisati uporabnika. Vsaj en uporabnik mora biti povezan z administratorskim računom.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "uporabniško ime";
$GLOBALS['strLinkUserHelpEmail'] = "e-poštni naslov";
$GLOBALS['strLastLoggedIn'] = "Zadnja prijava";
$GLOBALS['strDateLinked'] = "Datum povezave";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Uporabnikov dostop";
$GLOBALS['strAdminAccess'] = "Administratorski dostop";
$GLOBALS['strUserProperties'] = "Lastnosti uporabnika";
$GLOBALS['strPermissions'] = "Dovoljenja";
$GLOBALS['strAuthentification'] = "Preverjanje pristnosti";
$GLOBALS['strWelcomeTo'] = "Dobrodošli v";
$GLOBALS['strEnterUsername'] = "Vnesite svoje uporabniško ime in geslo";
$GLOBALS['strEnterBoth'] = "Prosimo, vnesite svoje uporabniško ime in geslo";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Napaka piškotka seje. Prosimo, prijavite se znova";
$GLOBALS['strLogin'] = "Prijava";
$GLOBALS['strLogout'] = "Odjava";
$GLOBALS['strUsername'] = "Uporabniško ime";
$GLOBALS['strPassword'] = "Geslo";
$GLOBALS['strPasswordRepeat'] = "Ponovite geslo";
$GLOBALS['strAccessDenied'] = "Dostop zavrnjen";
$GLOBALS['strUsernameOrPasswordWrong'] = "Uporabniško ime in/ali geslo se ne ujemata. Prosimo, poizkusite znova.";
$GLOBALS['strPasswordWrong'] = "Geslo ni pravilno";
$GLOBALS['strNotAdmin'] = "Vaš račun nima dovolj zahtevanih dovoljenj za uporabo te funkcije. Za uporabo se lahko prijavite pod drugim računom. Kliknite <a href='logout.php'>tukaj</a> za prijavo kot drug uporabnik.";
$GLOBALS['strDuplicateClientName'] = "Uporabniško ime že obstaja. Prosimo, izberite drugo.";
$GLOBALS['strInvalidPassword'] = "Novo geslo je neveljavno. Prosimo, izberite drugo.";
$GLOBALS['strInvalidEmail'] = "Prosimo, vnesite veljaven naslov elektronske pošte.";
$GLOBALS['strNotSamePasswords'] = "Gesli se ne ujemata";
$GLOBALS['strRepeatPassword'] = "Ponovite geslo";
$GLOBALS['strDeadLink'] = "Vaša povezava je neveljavna.";
$GLOBALS['strNoPlacement'] = "Izbrana kampanja ne obstaja. Poizkusite s to <a href='{link}'>povezavo</a> ";
$GLOBALS['strNoAdvertiser'] = "Izbran oglaševalec ne obstaja. poizkusite s to <a href='{link}'>povezavo</a>";

// General advertising
$GLOBALS['strRequests'] = "Zahtev";
$GLOBALS['strImpressions'] = "Učinkov";
$GLOBALS['strClicks'] = "Klikov";
$GLOBALS['strConversions'] = "Pretvorb";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Celotnih klikov";
$GLOBALS['strTotalConversions'] = "Celotnih pretvorb";
$GLOBALS['strDateTime'] = "Datum Ura";
$GLOBALS['strTrackerID'] = "ID sledilnika";
$GLOBALS['strTrackerName'] = "Ime sledilnika";
$GLOBALS['strTrackerImageTag'] = "Zaznamek slike";
$GLOBALS['strTrackerJsTag'] = "Zaznamek JavaScript";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "Pasice";
$GLOBALS['strCampaigns'] = "Kampanje";
$GLOBALS['strCampaignID'] = "ID kampanje";
$GLOBALS['strCampaignName'] = "Ime kampanje";
$GLOBALS['strCountry'] = "Država";
$GLOBALS['strStatsAction'] = "Dejanje";
$GLOBALS['strWindowDelay'] = "Zamik okna";
$GLOBALS['strStatsVariables'] = "Spremenljivke";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Mesečni zakup";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Datum";
$GLOBALS['strDay'] = "Dan";
$GLOBALS['strDays'] = "Dni";
$GLOBALS['strWeek'] = "Teden";
$GLOBALS['strWeeks'] = "Tednov";
$GLOBALS['strSingleMonth'] = "Mesec";
$GLOBALS['strMonths'] = "Mesecev";
$GLOBALS['strDayOfWeek'] = "Dan v tednu";


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

$GLOBALS['strHour'] = "Ura";
$GLOBALS['strSeconds'] = "sekund";
$GLOBALS['strMinutes'] = "minut";
$GLOBALS['strHours'] = "ur";

// Advertiser
$GLOBALS['strClient'] = "Oglaševalec";
$GLOBALS['strClients'] = "Oglaševalci";
$GLOBALS['strClientsAndCampaigns'] = "Oglaševalci & Kampanje";
$GLOBALS['strAddClient'] = "Dodaj novega oglaševalca";
$GLOBALS['strClientProperties'] = "Lastnosti oglaševalca";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "Trenutno ni definiranih nobenih oglaševalcev. Če želite ustvariti novo kampanjo, <a href='advertiser-edit.php'>morate najprej dodati novega</a> oglaševalca.";
$GLOBALS['strConfirmDeleteClient'] = "Ste prepričani, da želite izbrisati tega oglaševalca?";
$GLOBALS['strConfirmDeleteClients'] = "Ste prepričani, da želite izbrisati izbrane oglaševalce?";
$GLOBALS['strHideInactive'] = "Skrij neaktivne";
$GLOBALS['strInactiveAdvertisersHidden'] = "skriti neaktivni oglaševalci";
$GLOBALS['strAdvertiserSignup'] = "Prijava za oglaševalca";
$GLOBALS['strAdvertiserCampaigns'] = "Oglaševalčeve kampanje";

// Advertisers properties
$GLOBALS['strContact'] = "Kontakt";
$GLOBALS['strContactName'] = "Ime stika";
$GLOBALS['strEMail'] = "E-pošta";
$GLOBALS['strSendAdvertisingReport'] = "E-pošta za dostavo poročila o kampanji";
$GLOBALS['strNoDaysBetweenReports'] = "Število dni med dostavo poročil";
$GLOBALS['strSendDeactivationWarning'] = "Pošlji e-pošto, ko se kampanja samodejno aktivira/deaktivira";
$GLOBALS['strAllowClientModifyBanner'] = "Dovoli temu uporabniku spremembo lastnih pasic";
$GLOBALS['strAllowClientDisableBanner'] = "Dovoli temu uporabniku deaktivacijo lastnih pasic";
$GLOBALS['strAllowClientActivateBanner'] = "Dovoli temu uporabniku aktivacijo lastnih pasic";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Prikaži samo eno pasico tega oglaševalca na spletni strani";
$GLOBALS['strAllowAuditTrailAccess'] = "Dovoli temu uporabniku dostop do pregledne poti";

// Campaign
$GLOBALS['strCampaign'] = "Kampanja";
$GLOBALS['strCampaigns'] = "Kampanje";
$GLOBALS['strAddCampaign'] = "Dodaj novo kampanjo";
$GLOBALS['strAddCampaign_Key'] = "Dodaj <u>n</u>ovo kampanjo";
$GLOBALS['strCampaignForAdvertiser'] = "za oglaševalca";
$GLOBALS['strLinkedCampaigns'] = "Kampanje z povezavami";
$GLOBALS['strCampaignProperties'] = "Lastnosti kampanje";
$GLOBALS['strCampaignOverview'] = "Pregled kampanje";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "Trenutni ni definiranih kampanj za tega oglaševalca";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Ste prepričani, da želite izbrisati to kampanjo?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Ste prepričani, da želite izbrisati izbrane kampanje?";
$GLOBALS['strShowParentAdvertisers'] = "Prikaži izvorne oglaševalce";
$GLOBALS['strHideParentAdvertisers'] = "Skrij izvorne oglaševalce";
$GLOBALS['strHideInactiveCampaigns'] = "Skrij neaktivne kampanje";
$GLOBALS['strInactiveCampaignsHidden'] = "skrite neaktivne kampanje";
$GLOBALS['strPriorityInformation'] = "Prioriteta v razmerju z ostalimi kampanjami";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Kampanja";
$GLOBALS['strHiddenAd'] = "Oglas";
$GLOBALS['strHiddenAdvertiser'] = "Oglaševalec";
$GLOBALS['strHiddenTracker'] = "Sledilnik";
$GLOBALS['strHiddenWebsite'] = "Spletna stran";
$GLOBALS['strHiddenZone'] = "Področje";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Spremljevalni položaj";
$GLOBALS['strSelectUnselectAll'] = "Izberi / Odizberi vse";
$GLOBALS['strCampaignsOfAdvertiser'] = "od"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Preračunano za vse kampanje";
$GLOBALS['strCalculatedForThisCampaign'] = "Preračunano za to kampanjo";
$GLOBALS['strLinkingZonesProblem'] = "Prišlo je do težave pri povezovanju področij";
$GLOBALS['strUnlinkingZonesProblem'] = "Prišlo je do težave pri odstranjevanju povezav področij";
$GLOBALS['strZonesLinked'] = "področje(a) z povezavo";
$GLOBALS['strZonesUnlinked'] = "področje(a) brez povezav";
$GLOBALS['strZonesSearch'] = "Iskanje";
$GLOBALS['strZonesSearchTitle'] = "Išči področja in spletne strani po imenih";
$GLOBALS['strNoWebsitesAndZones'] = "Ni spletnih stranih in področij";
$GLOBALS['strNoWebsitesAndZonesText'] = "z \"%s\" v imenu";
$GLOBALS['strToLink'] = "za povezovanje";
$GLOBALS['strToUnlink'] = "za odstranitev povezave";
$GLOBALS['strLinked'] = "Povezani";
$GLOBALS['strAvailable'] = "Dosegljivi";
$GLOBALS['strShowing'] = "Prikazovanje";
$GLOBALS['strEditZone'] = "Uredi področje";
$GLOBALS['strEditWebsite'] = "Uredi spletno stran";


// Campaign properties
$GLOBALS['strDontExpire'] = "Ne poteči";
$GLOBALS['strActivateNow'] = "Takoj začni";
$GLOBALS['strSetSpecificDate'] = "Nastavi določen datum";
$GLOBALS['strLow'] = "Nizek";
$GLOBALS['strHigh'] = "Visok";
$GLOBALS['strExpirationDate'] = "Datum zaključka";
$GLOBALS['strExpirationDateComment'] = "Kampanja se bo končala ob koncu tega dneva";
$GLOBALS['strActivationDate'] = "Datum začetka";
$GLOBALS['strActivationDateComment'] = "Kampanja se bo pričela ob začetku tega dneva";
$GLOBALS['strImpressionsRemaining'] = "Preostalih učinkov";
$GLOBALS['strClicksRemaining'] = "Preostalih klikov";
$GLOBALS['strConversionsRemaining'] = "Preostalih pretvorb";
$GLOBALS['strImpressionsBooked'] = "Rezerviranih učinkov";
$GLOBALS['strClicksBooked'] = "Rezerviranih klikov";
$GLOBALS['strConversionsBooked'] = "Rezerviranih pretvorb";
$GLOBALS['strCampaignWeight'] = "Nastavi kampanjsko vrednost";
$GLOBALS['strAnonymous'] = "Skrij oglaševalca in spletne strani te kampanje";
$GLOBALS['strTargetPerDay'] = "na dan.";
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
$GLOBALS['strCampaignStatusPending'] = "V teku";
$GLOBALS['strCampaignStatusInactive'] = "Neaktiven";
$GLOBALS['strCampaignStatusRunning'] = "V teku";
$GLOBALS['strCampaignStatusPaused'] = "Premor";
$GLOBALS['strCampaignStatusAwaiting'] = "V pričakovanju";
$GLOBALS['strCampaignStatusExpired'] = "Končano";
$GLOBALS['strCampaignStatusApproval'] = "Čakam na odobritev »";
$GLOBALS['strCampaignStatusRejected'] = "Zavrnjeno";
$GLOBALS['strCampaignStatusAdded'] = "Dodano";
$GLOBALS['strCampaignStatusStarted'] = "Zagnano";
$GLOBALS['strCampaignStatusRestarted'] = "Znova zagnano";
$GLOBALS['strCampaignStatusDeleted'] = "Izbrisano";
$GLOBALS['strCampaignType'] = "Tip kampanje";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strContract'] = "Pogodba";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Pogodba";
$GLOBALS['strStandardContractInfo'] = "Ta kampanja ima dnevne omejitve in bo enakomerno dostavljana do zaključnega datuma ali nastavljene omejitve";
$GLOBALS['strRemnant'] = "Ostanek";
$GLOBALS['strRemnantInfo'] = "To je standardna kampanja, ki jo lahko omejite z zaključnim datumom ali določenimi ostalimi omejitvami";
$GLOBALS['strECPMInfo'] = "This is a standard campaign which can be constrained with either an end date or a specific limit. Based on current settings it will be prioritised using eCPM.";
$GLOBALS['strPricing'] = "Cenitev";
$GLOBALS['strPricingModel'] = "Cenitveni model";
$GLOBALS['strSelectPricingModel'] = "\\-- izberite model --";
$GLOBALS['strRatePrice'] = "Razmerje / Cena";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Omejitev";
$GLOBALS['strLowExclusiveDisabled'] = "Te kampanje ne morete spremeniti v Preostalo ali Eksluzivno, saj je nastavljen zaključni datum ali omejitev ogledov/klikov/pretvorb. <br>Če bi želeli spremeniti tip, morate odstraniti zaključni datum ali ostale omejitve";
$GLOBALS['strCannotSetBothDateAndLimit'] = "Za Eksluzivno in Preostalo kampanjo ne morete nastaviti zaključnega datuma in omejitev.<br>Če morate nastaviti zaključni datum in omejitve ogledov/klikov/pretvorb, prosimo uporabite neeksluzivno pogodbeno kampanjo.";
$GLOBALS['strWhyDisabled'] = "zakaj je onemogočeno?";
$GLOBALS['strBackToCampaigns'] = "Vrnitev na kampanje";
$GLOBALS['strCampaignBanners'] = "Pasice kampanje";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Sledilnik";
$GLOBALS['strTrackers'] = "Sledilniki";
$GLOBALS['strTrackerPreferences'] = "Preference sledilnika";
$GLOBALS['strAddTracker'] = "Dodaj nov sledilnik";
$GLOBALS['strTrackerForAdvertiser'] = "za oglaševalca";
$GLOBALS['strNoTrackers'] = "Trenutno ni definiranih nobenih sledilnikov";
$GLOBALS['strConfirmDeleteTrackers'] = "Ste prepričani, da želite izbrisati izbrane sledilnike?";
$GLOBALS['strConfirmDeleteTracker'] = "Ste prepričani, da želite izbrisati ta sledilnik?";
$GLOBALS['strTrackerProperties'] = "Lastnosti sledilnika";
$GLOBALS['strDefaultStatus'] = "Privzeto stanje";
$GLOBALS['strStatus'] = "Stanje";
$GLOBALS['strLinkedTrackers'] = "Sledilniki s povezavo";
$GLOBALS['strTrackerInformation'] = "Podatki o sledilniku";
$GLOBALS['strConversionWindow'] = "Pretvorbeno okno";
$GLOBALS['strUniqueWindow'] = "Edinstveno okno";
$GLOBALS['strClick'] = "Klik";
$GLOBALS['strView'] = "Pogled";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Tip pretvorbe";
$GLOBALS['strLinkCampaignsByDefault'] = "Privzeto nastavi povezave pri novih kampanjah";
$GLOBALS['strBackToTrackers'] = "Nazaj k sledilnikom";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "Pasica";
$GLOBALS['strBanners'] = "Pasice";
$GLOBALS['strAddBanner'] = "Dodaj novo pasico";
$GLOBALS['strAddBanner_Key'] = "Dodaj <u>n</u>ovo pasico";
$GLOBALS['strBannerToCampaign'] = "v kampanjo";
$GLOBALS['strShowBanner'] = "Prikaži pasico";
$GLOBALS['strBannerProperties'] = "Lastnosti pasice";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "Trenutno ni nobene definirane pasice za to kampanjo";
$GLOBALS['strNoBannersAddCampaign'] = "Trenutno ni definiranih nobenih pasic, ker ni kampanj. Za ustvaritev pasice, <a href='campaign-edit.php?clientid=%s'>dodajte novo kampanjo</a> najprej.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Treutno ni definiranih nobenih pasic, ker ni oglaševalcev. Za ustvaritev pasice, <a href='advertiser-edit.php'>dodajte novega oglaševalca</a> najprej.";
$GLOBALS['strConfirmDeleteBanner'] = "Ste prepričani, da želite izbrisati to pasico?";
$GLOBALS['strConfirmDeleteBanners'] = "Ste prepričani, da želite izbrisati izbrane pasice?";
$GLOBALS['strShowParentCampaigns'] = "Prikaži izvorne kampanje";
$GLOBALS['strHideParentCampaigns'] = "Skrij izvorne kampanje";
$GLOBALS['strHideInactiveBanners'] = "Skrij neaktivne pasice";
$GLOBALS['strInactiveBannersHidden'] = "skrite neaktivne pasice";
$GLOBALS['strWarningMissing'] = "Opozorilo, morda manjka";
$GLOBALS['strWarningMissingClosing'] = "zapiram zaznamek '>'";
$GLOBALS['strWarningMissingOpening'] = " odpiram zaznamek \"<\"";
$GLOBALS['strSubmitAnyway'] = "Vseeno predloži";
$GLOBALS['strBannersOfCampaign'] = "v"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Preference pasice";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Privzete pasice";
$GLOBALS['strDefaultBannerUrl'] = "URL privzete slike";
$GLOBALS['strDefaultBannerDestination'] = "URL privzetega naslova";
$GLOBALS['strAllowedBannerTypes'] = "Dovoli tip pasic";
$GLOBALS['strTypeSqlAllow'] = "Dovoli SQL lokalne pasice";
$GLOBALS['strTypeWebAllow'] = "Dovoli WebServer lokalne pasice";
$GLOBALS['strTypeUrlAllow'] = "Dovoli zunanje pasice";
$GLOBALS['strTypeHtmlAllow'] = "Dovoli HTML pasice";
$GLOBALS['strTypeTxtAllow'] = "Dovoli besedilne oglase";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Prosimo, izberite tip pasice";
$GLOBALS['strMySQLBanner'] = "Naloži lokalno pasico v podatkovno bazo";
$GLOBALS['strWebBanner'] = "Naloži lokalno pasico v spletni strežnik";
$GLOBALS['strURLBanner'] = "Poveži zunanjo pasico";
$GLOBALS['strHTMLBanner'] = "Ustvari HTML pasico";
$GLOBALS['strTextBanner'] = "Ustvari besedilno pasico";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Ali želite obdržati <br />obstoječo sliko, ali pa <br />nastaviti drugo?";
$GLOBALS['strNewBannerFile'] = "Izberite sliko, ki jo želite <br />uporabiti za to pasico<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Izberite arhivsko sliko, ki jo želite <br />uporabiti v primeru, če brskalnik<br />ne podpira obogatenih medijskih vsebin<br /><br />";
$GLOBALS['strNewBannerURL'] = "URL slike (vključno z http://)";
$GLOBALS['strURL'] = "URL cilja (vključno z http://)";
$GLOBALS['strKeyword'] = "Ključne besede";
$GLOBALS['strTextBelow'] = "Besedilo pod sliko";
$GLOBALS['strWeight'] = "Vrednost";
$GLOBALS['strAlt'] = "Drugotno besedilo";
$GLOBALS['strStatusText'] = "Besedilo stanja";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Vrednost pasice";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Generična HTML pasica";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Splošno";
$GLOBALS['strSwfTransparency'] = "Dovoli prozorno ozadje";
$GLOBALS['strBackToBanners'] = "Vrnitev na pasice";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Preveri za hard-code povezave v FLASH datoteki";
$GLOBALS['strConvertSWFLinks'] = "Pretvori FLASH povezave";
$GLOBALS['strHardcodedLinks'] = "Implementirane povezave (hard-coded links)";
$GLOBALS['strConvertSWF'] = "<br />The Flash file you just uploaded contains hard-coded urls. {$PRODUCT_NAME} won't be able to track the number of Clicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br /><br />Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br />Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br /><br />";
$GLOBALS['strCompressSWF'] = "Stisni SWF datoteko za hitrejši prenos (zahtevan Flash player 6)";
$GLOBALS['strOverwriteSource'] = "Prepiši izvirni parameter";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Možnosti dostave";
$GLOBALS['strACL'] = "Možnosti dostave";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "je enak";
$GLOBALS['strDifferentFrom'] = "je različen od";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "je večji kot";
$GLOBALS['strLessThan'] = "je manj kot";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "IN";                          // logical operator
$GLOBALS['strOR'] = "ALI";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "To pasico prikaži samo ko:";
$GLOBALS['strWeekDays'] = "Delavniki";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Vir";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Ponastavi števce po:";
$GLOBALS['strDeliveryCappingTotal'] = "celotnih";
$GLOBALS['strDeliveryCappingSession'] = "na sejo";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Omeji prikazov pasice na:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Omeji prikazov kampanje na:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Omeji prikazov področja na:";

// Website
$GLOBALS['strAffiliate'] = "Spletna stran";
$GLOBALS['strAffiliates'] = "Spletne strani";
$GLOBALS['strAffiliatesAndZones'] = "Spletne strani & Področja";
$GLOBALS['strAddNewAffiliate'] = "Dodaj novo spletno stran";
$GLOBALS['strAffiliateProperties'] = "Lastnosti spletne strani";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "Trenutno ni definiranih nobenih spletnih strani. Če želite ustvariti novo področje, morate najprej dodati novo <a href='affiliate-edit.php'>spletno stran</a>.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Ste prepričani, da želite izbrisati to spletno stran?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Ste prepričani, da želite izbrisati izbrane spletne strani?";
$GLOBALS['strInactiveAffiliatesHidden'] = "skrite neaktivne spletne strani";
$GLOBALS['strShowParentAffiliates'] = "Prikaži izvorne spletne strani";
$GLOBALS['strHideParentAffiliates'] = "Skrij izvorne spletne strani";

// Website (properties)
$GLOBALS['strWebsite'] = "Spletna stran";
$GLOBALS['strWebsiteURL'] = "URL spletne strani";
$GLOBALS['strAllowAffiliateModifyZones'] = "Dovoli temu uporabniku spreminjanje lastnih področij";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Dovoli temu uporabniku povezavo pasic k lastnim področjem";
$GLOBALS['strAllowAffiliateAddZone'] = "Dovoli temu uporabniku določitev novih področij";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Dovoli temu uporabniku izbris obstoječih področij";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Dovoli temu uporabniku ustvariti pozivno kodo";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Poštna številka";
$GLOBALS['strCountry'] = "Država";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Področja spletne strani";

// Zone
$GLOBALS['strZone'] = "Področje";
$GLOBALS['strZones'] = "Področja";
$GLOBALS['strAddNewZone'] = "Dodaj novo področje";
$GLOBALS['strAddNewZone_Key'] = "Dodaj <u>n</u>ovo področje";
$GLOBALS['strZoneToWebsite'] = "k spletni strani";
$GLOBALS['strLinkedZones'] = "Področja z povezavami";
$GLOBALS['strAvailableZones'] = "Razpoložljivih področij";
$GLOBALS['strLinkingNotSuccess'] = "Povezovanje ni bilo uspešno, prosimo, poizkusite znova";
$GLOBALS['strZoneProperties'] = "Lastnosti področja";
$GLOBALS['strZoneHistory'] = "Zgodovina področja";
$GLOBALS['strNoZones'] = "Trenutno ni definiranih nobenih področij za to spletno stran";
$GLOBALS['strNoZonesAddWebsite'] = "Trenutno ni definiranih nobenih področij, ker ni spletnih strani. Za ustvaritev področja, <a href='affiliate-edit.php'>dodajte spletno stran</a> najprej.";
$GLOBALS['strConfirmDeleteZone'] = "Ste prepričani, da želite izbrisati to področje?";
$GLOBALS['strConfirmDeleteZones'] = "Ste prepričani, da želite izbrisati izbrana področja?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Nekatere kampanje so še vedno povezane v to področje. Če jih boste izbrisali, ne boste zanje dobili plačila.";
$GLOBALS['strZoneType'] = "Tip področja";
$GLOBALS['strBannerButtonRectangle'] = "Pasica, gumb ali pravokotnik";
$GLOBALS['strInterstitial'] = "Vmesen ali lebdeč DHTML";
$GLOBALS['strPopup'] = "Prikazujoč (pop-up)";
$GLOBALS['strTextAdZone'] = "Tekstovni oglas";
$GLOBALS['strEmailAdZone'] = "E-poštno/Newsletter področje";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Prikaži ujemajoče pasice";
$GLOBALS['strHideMatchingBanners'] = "Skrij ujemajoče pasice";
$GLOBALS['strBannerLinkedAds'] = "Pasice povezujoče v področje";
$GLOBALS['strCampaignLinkedAds'] = "Kampanje povezujoče v področje";
$GLOBALS['strInactiveZonesHidden'] = "skrita neaktivna področja";
$GLOBALS['strWarnChangeZoneType'] = "Spreminjanje tipa področja v besedilno ali e-poštno bo odstranilo vse povezave pasic/kampanj zaradi omejitev teh tipov področij
<ul>
<li>Besedilna področja so lahko v povezavi z samo besedilnimi oglasi</li>
<li>E-poštne področne kampanje imajo naenkrat lahko samo eno aktivno pasico</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Spreminjanje področja bo odstranilo vse povezave pasic, ki niso nove velikosti, in bo dodalo pasice iz povezujočih kampanj, ki so nove velikosti';
$GLOBALS['strWarnChangeBannerSize'] = 'Spreminjanje vrednosti pasice bo prekinilo povezavo z vsemi področji, ki niso te vrednosti, in če je <strong>kampanja</strong> pasice povezana s področjem nove vrednosti, bo ta pasica samodejno povezana.';
$GLOBALS['strWarnBannerReadonly'] = 'Ker so razširitve onemogočene, je ta pasica samo read-only.  Kontaktirajte svojega administratorja za več informacij.';
$GLOBALS['strZonesOfWebsite'] = 'v'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB pasica (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB nebotičnik (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB velika pasica (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB gumb 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB gumb 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB polovična pasica (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB mikro črta (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB kvadratni gumb (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB pravokotnik (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB kvadratni pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB navpična pasica (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB srednji pravokotnik (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB veliki pravokotnik (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB navpični pravokotnik (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB širok nebotičnik (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Napredno";
$GLOBALS['strChainSettings'] = "Verižne nastavitve";
$GLOBALS['strZoneNoDelivery'] = "Če iz tega področja ni dostavljena nobena pasica, <br />poizkusite...";
$GLOBALS['strZoneStopDelivery'] = "Ustavi dostavo in ne prikaži pasice";
$GLOBALS['strZoneOtherZone'] = "Prikaži izbrano področje";
$GLOBALS['strZoneAppend'] = "Vedno pripni naslednjo HTML kodo v prikazane pasice tega področja";
$GLOBALS['strAppendSettings'] = "Pripni in omogoči nastavitve";
$GLOBALS['strZonePrependHTML'] = "Vedno omogoči HTML kodo v besedilnih oglasih prikazanih s tega področja";
$GLOBALS['strZoneAppendNoBanner'] = "Pripni, tudi če pasica ni dostavljena";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML zbirnik";
$GLOBALS['strZoneAppendZoneSelection'] = "Prikazujoč (pop-up) ali vmesen";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Vse pasice povezujoče v izbrano področje trenutno niso aktivne. <br />Postopek v področju si bo sledil po naslednjih korakih:";
$GLOBALS['strZoneProbNullPri'] = "Ni aktivnih pasic povezujočih v to področje.";
$GLOBALS['strZoneProbListChainLoop'] = "Sledenje področnim korakom bi povzročilo nepretrgano zanko. Dostava za to področje je ustavljena.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Prosimo, izberite kaj se naj povezuje na to področje";
$GLOBALS['strLinkedBanners'] = "Poveži posamezne pasice";
$GLOBALS['strCampaignDefaults'] = "Poveži pasice po izvorni kampanji";
$GLOBALS['strLinkedCategories'] = "Poveži pasice po kategoriji";
$GLOBALS['strWithXBanners'] = "%d oglas(i)";
$GLOBALS['strRawQueryString'] = "Ključna beseda";
$GLOBALS['strIncludedBanners'] = "Pasice s povezavo";
$GLOBALS['strMatchingBanners'] = "{count} ujemajočih pasic";
$GLOBALS['strNoCampaignsToLink'] = "Na voljo ni nobenih kampanj, s katerimi bi lahko povezali to področje";
$GLOBALS['strNoTrackersToLink'] = "Na voljo ni nobenih sledilnikov, s katerimi bi lahko povezali to kampanjo";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Na voljo ni nobenih področij, s katerimi bi lahko povezali to kampanjo";
$GLOBALS['strSelectBannerToLink'] = "Izberite pasico, ki bi jo želeli povezati na to področje:";
$GLOBALS['strSelectCampaignToLink'] = "Izberite kampanjo, ki bi jo želeli povezati na to področje:";
$GLOBALS['strSelectAdvertiser'] = "Izberite oglaševalca";
$GLOBALS['strSelectPlacement'] = "Izberite kampanjo";
$GLOBALS['strSelectAd'] = "Izberite pasico";
$GLOBALS['strSelectPublisher'] = "Izberite spletno stran";
$GLOBALS['strSelectZone'] = "Izberite področje";
$GLOBALS['strStatusPending'] = "V teku";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Podvoji";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Tip";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Uredi statuse";
$GLOBALS['strShortcutShowStatuses'] = "Prikaži statuse";

// Statistics
$GLOBALS['strStats'] = "Statistika";
$GLOBALS['strNoStats'] = "Trenutno ni na voljo nobenih statističnih podatkov";
$GLOBALS['strNoStatsForPeriod'] = "Trenutno ni na voljo nobenih statističnih podatkov za obdobje od %s do %s";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Vseh za to obdobje";
$GLOBALS['strPublisherDistribution'] = "Razporeditev spletne strani";
$GLOBALS['strCampaignDistribution'] = "Razporeditev kampanje";
$GLOBALS['strViewBreakdown'] = "Pogled po";
$GLOBALS['strBreakdownByDay'] = "Dan";
$GLOBALS['strBreakdownByWeek'] = "Teden";
$GLOBALS['strBreakdownByMonth'] = "Mesec";
$GLOBALS['strBreakdownByDow'] = "Dan v tednu";
$GLOBALS['strBreakdownByHour'] = "Ura";
$GLOBALS['strItemsPerPage'] = "Postavk po strani";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Prikaži <u>G</u>raf statistike";
$GLOBALS['strExportStatisticsToExcel'] = "<u>I</u>zvozi statistiko v Excel-ovo datoteko";
$GLOBALS['strGDnotEnabled'] = "V PHP-ju morate imeti omogočen GD za prikaz grafov. <br />Obiščite <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> za več informacij.";
$GLOBALS['strStatsArea'] = "Površina";

// Expiration
$GLOBALS['strNoExpiration'] = "Datum izteka ni nastavljen";
$GLOBALS['strEstimated'] = "Predviden iztek";
$GLOBALS['strNoExpirationEstimation'] = "Iztek roka še ni presojen";
$GLOBALS['strDaysAgo'] = "dnevi";
$GLOBALS['strCampaignStop'] = "Ustavitev kampanje";

// Reports
$GLOBALS['strAdvancedReports'] = "Naprednejša poročila";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Obdobje";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Vsi oglaševalci";
$GLOBALS['strAnonAdvertisers'] = "Anonimni oglaševalci";
$GLOBALS['strAllPublishers'] = "Vse spletne strani";
$GLOBALS['strAnonPublishers'] = "Anonimne spletne strani";
$GLOBALS['strAllAvailZones'] = "Vsa razpoložljiva področja";

// Userlog
$GLOBALS['strUserLog'] = "Uporabniški dnevnik";
$GLOBALS['strUserLogDetails'] = "Podrobnosti uporabniškega dnevnika";
$GLOBALS['strDeleteLog'] = "Izbriši dnevnik";
$GLOBALS['strAction'] = "Dejanje";
$GLOBALS['strNoActionsLogged'] = "Nobeno dejanje ni zabeleženo";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Neposredna izbira";
$GLOBALS['strChooseInvocationType'] = "Prosimo, izberite tip poziva pasici";
$GLOBALS['strGenerate'] = "Ustvari";
$GLOBALS['strParameters'] = "Nastavitve zaznamka";
$GLOBALS['strFrameSize'] = "Velikost okvirja";
$GLOBALS['strBannercode'] = "Koda pasice";
$GLOBALS['strTrackercode'] = "Pripni naslednji niz v posamezen Javascript sledilnik ogledov";
$GLOBALS['strBackToTheList'] = "Vrnitev na zapisni seznam";
$GLOBALS['strCharset'] = "Postavitev znakov";
$GLOBALS['strAutoDetect'] = "Samodejno prepoznaj";
$GLOBALS['strCacheBusterComment'] = "* Zamenjaj vse primere {random} z * naključno ustvarjenim številom (ali časovnim žigom). *";
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
$GLOBALS['strNoMatchesFound'] = "Ni zadetkov";
$GLOBALS['strErrorOccurred'] = "Prišlo je do napake";
$GLOBALS['strErrorDBPlain'] = "Prišlo je do napake pri dostopanju do podatkovne baze.";
$GLOBALS['strErrorDBSerious'] = "Odkrit je bil resen problem pri podatkovni bazi.";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Podatkovna baza je najverjetneje pokvarjena in potrebuje popravilo. Za več informacij o popravilu baz si prosimo preberite poglavje <i>Tehnične motnje</i> v <i>Administratorskem vodiču</i>.";
$GLOBALS['strErrorDBContact'] = "Prosimo, obvestite administratorja o problemu na tej strani.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "Povezava pasice s tem področjem je bila neizvedljiva zaradi:";
$GLOBALS['strUnableToLinkBanner'] = "Ne morem vzpostaviti povezave s to pasico:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "napačna oblika številk v polju Informacije o dohodkih";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Napaka pri posodabljanju področja:";
$GLOBALS['strUnableToChangeZone'] = "Ne morem prilagoditi te spremembe zaradi:";
$GLOBALS['strDatesConflict'] = "datumi so v navzkrižju z:";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Nekatere od teh statistik so bile zabeležene v napačnem časovnem področju, zato morda ne bodo pravilno prikazane";
$GLOBALS['strWarningInaccurateReadMore'] = "Preberite več o tem";
$GLOBALS['strWarningInaccurateReport'] = "Nekatere od statistik v tem poročilu so bile zabeležene v napačnem časovnem področju, zato morda ne bodo pravilno prikazane";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "označite zahtevano polje";
$GLOBALS['strFormContainsErrors'] = "Obrazec vsebuje napake. Prosimo popravite spodaj označena polja.";
$GLOBALS['strXRequiredField'] = "%s je zahtevan";
$GLOBALS['strEmailField'] = "Prosimo, vnesite veljaven e-poštni naslov";
$GLOBALS['strNumericField'] = "Prosimo, vnesite številko";
$GLOBALS['strGreaterThanZeroField'] = "Mora biti več kot 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s mora biti več kot 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s mora biti pozitivno celo število";
$GLOBALS['strInvalidWebsiteURL'] = "Napačen URL spletne strani";

// Email
$GLOBALS['strSirMadam'] = "Gospod/Gospa";
$GLOBALS['strMailSubject'] = "Poročilo oglaševalca";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Spodaj boste našli statistične podatke o pasici za {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampanja aktivirana";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampanja deaktivirana";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Vaša kampanja (prikazana spodaj) je bila deaktivirana zaradi";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Ta kampanja trenutno ni aktivna, ker";
$GLOBALS['strBeforeActivate'] = "aktivacijski datum še ni bil dosežen";
$GLOBALS['strAfterExpire'] = "datum izteka roka je bil dosežen";
$GLOBALS['strNoMoreImpressions'] = "na voljo ni več ogledov";
$GLOBALS['strNoMoreClicks'] = "na voljo ni več klikov";
$GLOBALS['strNoMoreConversions'] = "no voljo ni več prometa";
$GLOBALS['strWeightIsNull'] = "vrednost je nastavljena na nič";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "dnevna omejitev je nastavljena na nič - navesti morate datum zaključka in omejitev ali nastaviti dnevno omejitev";
$GLOBALS['strNoViewLoggedInInterval'] = "Zabeleženih je bilo 0 ogledov med trajanjem tega poročila";
$GLOBALS['strNoClickLoggedInInterval'] = "Zabeleženih je bilo 0 klikov med trajanjem tega poročila";
$GLOBALS['strNoConversionLoggedInInterval'] = "Zabeleženih je bilo 0 pretvorb med trajanjem tega poročila";
$GLOBALS['strMailReportPeriod'] = "To poročilo vsebuje statistične podatke od {startdate} do {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "To poročilo vsebuje vse statistične podatke vse do {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Na voljo ni nobenih statističnih podatkov za to kampanjo.";
$GLOBALS['strImpendingCampaignExpiry'] = "Kampanja se približuje svojemu izteku";
$GLOBALS['strYourCampaign'] = "Vaša kampanja";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampanja pripada";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} prikazan spodaj se približuje zaključku na dan {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} prikazan spodaj ima manj kot {limit} učinkov še na voljo.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Prioriteta";
$GLOBALS['strSourceEdit'] = "Uredi vire";

// Preferences
$GLOBALS['strPreferences'] = "Možnosti";
$GLOBALS['strUserPreferences'] = "Uporabniške nastavitve";
$GLOBALS['strChangePassword'] = "Spremeni geslo";
$GLOBALS['strChangeEmail'] = "Spremeni e-pošto";
$GLOBALS['strCurrentPassword'] = "Trenutno geslo";
$GLOBALS['strChooseNewPassword'] = "Izberite novo geslo";
$GLOBALS['strReenterNewPassword'] = "Ponovno vnesite novo geslo";
$GLOBALS['strNameLanguage'] = "Ime & Jezik";
$GLOBALS['strAccountPreferences'] = "Preference računa";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preference kampanjskih e-poštnih sporočil";
$GLOBALS['strTimezonePreferences'] = "Preference časovnega področja";
$GLOBALS['strAdminEmailWarnings'] = "Administratorska e-poštna opozorila";
$GLOBALS['strAgencyEmailWarnings'] = "Agencijska e-poštna opozorila";
$GLOBALS['strAdveEmailWarnings'] = "Oglaševalčeva e-poštna opozorila";
$GLOBALS['strFullName'] = "Polno ime";
$GLOBALS['strEmailAddress'] = "E-poštni naslov";
$GLOBALS['strUserDetails'] = "Podrobnosti o uporabniku";
$GLOBALS['strUserInterfacePreferences'] = "Preference uporabniškega vmesnika";
$GLOBALS['strPluginPreferences'] = "Preference vtičnika";
$GLOBALS['strColumnName'] = "Ime stolpca";
$GLOBALS['strShowColumn'] = "Prikaži stolpec";
$GLOBALS['strCustomColumnName'] = "Ime stolpca po meri";
$GLOBALS['strColumnRank'] = "Niz stolpca";

// Long names
$GLOBALS['strRevenue'] = "Dohodek";
$GLOBALS['strNumberOfItems'] = "Število predmetov";
$GLOBALS['strRevenueCPC'] = "CPC dohodek";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "Pretvorb v teku";
$GLOBALS['strImpressionSR'] = "SR ogledov";
$GLOBALS['strClickSR'] = "SR klikov";

// Short names
$GLOBALS['strRevenue_short'] = "Doh.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Štev. postavk";
$GLOBALS['strRevenueCPC_short'] = "CPC doh.";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Zah.";
$GLOBALS['strImpressions_short'] = "Ogled.";
$GLOBALS['strClicks_short'] = "Klikov";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Pretv.";
$GLOBALS['strPendingConversions_short'] = "Pretv. v teku";
$GLOBALS['strImpressionSR_short'] = "SR ogled.";
$GLOBALS['strClickSR_short'] = "SR klikov";

// Global Settings
$GLOBALS['strConfiguration'] = "Konfiguracija";
$GLOBALS['strGlobalSettings'] = "Globalne nastavitve";
$GLOBALS['strGeneralSettings'] = "Splošne nastavitve";
$GLOBALS['strMainSettings'] = "Glavne nastavitve";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Izberi oddelek';

// Product Updates
$GLOBALS['strProductUpdates'] = "Posodobitve izdelka";
$GLOBALS['strViewPastUpdates'] = "Upravljaj z zadnjimi posodobitvami in arhivi";
$GLOBALS['strFromVersion'] = "Iz različice";
$GLOBALS['strToVersion'] = "V različico";
$GLOBALS['strToggleDataBackupDetails'] = "Preglej podrobnosti varnostne kopije podatkov";
$GLOBALS['strClickViewBackupDetails'] = "klikni za pregled podrobnosti varnostne kopije";
$GLOBALS['strClickHideBackupDetails'] = "klikni za prikritje podrobnosti varnostne kopije";
$GLOBALS['strShowBackupDetails'] = "Prikaži podrobnosti varnostne kopije podatkov";
$GLOBALS['strHideBackupDetails'] = "Skrij podrobnosti varnostne kopije podatkov";
$GLOBALS['strBackupDeleteConfirm'] = "Ste prepričani, da želite izbrisati vse varnostne kopije ustvarjene v tej posodobitvi?";
$GLOBALS['strDeleteArtifacts'] = "Izbriši artefakte";
$GLOBALS['strArtifacts'] = "Artifakti";
$GLOBALS['strBackupDbTables'] = "Ustvari varnostno kopijo tabel podatkovne baze";
$GLOBALS['strLogFiles'] = "Datoteke beležke";
$GLOBALS['strConfigBackups'] = "Varnostne kopije konfiguracij";
$GLOBALS['strUpdatedDbVersionStamp'] = "Posodobljena različica žiga podatkovne baze";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "POSODOBITEV DOKONČANA";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "POSODOBITEV NEUSPEŠNA";

// Agency
$GLOBALS['strAgencyManagement'] = "Upravljanje z računi";
$GLOBALS['strAgency'] = "Račun";
$GLOBALS['strAddAgency'] = "Dodaj nov račun";
$GLOBALS['strAddAgency_Key'] = "Dodaj <u>n</u>ov račun";
$GLOBALS['strTotalAgencies'] = "Vseh računov";
$GLOBALS['strAgencyProperties'] = "Lastnosti računa";
$GLOBALS['strNoAgencies'] = "Trenutno ni definiranih nobenih računov";
$GLOBALS['strConfirmDeleteAgency'] = "Ste prepričani, da želite izbrisati ta račun?";
$GLOBALS['strHideInactiveAgencies'] = "Skrij neaktivne račune";
$GLOBALS['strInactiveAgenciesHidden'] = "skriti neaktivni računi";
$GLOBALS['strSwitchAccount'] = "Preklopi na ta račun";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "k spletni strani";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Možnosti dostave";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'v'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Ime spremenljivke";
$GLOBALS['strVariableDescription'] = "Opis";
$GLOBALS['strVariableDataType'] = "Tip podatka";
$GLOBALS['strVariablePurpose'] = "Namen";
$GLOBALS['strGeneric'] = "Splošno";
$GLOBALS['strBasketValue'] = "Vrednost košarice";
$GLOBALS['strNumItems'] = "Število predmetov";
$GLOBALS['strVariableIsUnique'] = "Izvedi pretvorbe?";
$GLOBALS['strNumber'] = "Število";
$GLOBALS['strString'] = "Niz";
$GLOBALS['strTrackFollowingVars'] = "Sledi naslednji spremenljivki";
$GLOBALS['strAddVariable'] = "Dodaj spremenljivko";
$GLOBALS['strNoVarsToTrack'] = "Ni spremenljivk za sledenje.";
$GLOBALS['strVariableRejectEmpty'] = "Zavrni, če je prazno?";
$GLOBALS['strTrackingSettings'] = "Sledilne nastavitve";
$GLOBALS['strTrackerType'] = "Tip sledilnika";
$GLOBALS['strTrackerTypeJS'] = "Sledi spremenljivkam JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "Sledi spremenljivkam JavaScript (združljiv z povratno funkcijo)";
$GLOBALS['strTrackerTypeDOM'] = "Sledi elementom HTML z uporabo DOM-a";
$GLOBALS['strTrackerTypeCustom'] = "JS koda po meri";
$GLOBALS['strVariableCode'] = "JavaScript sledilna koda";

// Password recovery
$GLOBALS['strForgotPassword'] = "Ste pozabili svoje geslo?";
$GLOBALS['strPasswordRecovery'] = "Povrnitev gesla";
$GLOBALS['strEmailRequired'] = "Polje za vnos e-pošte je potrebno obvezno izpolniti";
$GLOBALS['strPwdRecWrongId'] = "Napačen ID";
$GLOBALS['strPwdRecEnterEmail'] = "Spodaj vpišite naslov svoje elektronske pošte";
$GLOBALS['strPwdRecEnterPassword'] = "Spodaj vpišite vaše novo geslo";
$GLOBALS['strPwdRecResetLink'] = "Povezava na ponastavitev gesla";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s ponastavitev gesla";
$GLOBALS['strProceed'] = "Nadaljuj >";
$GLOBALS['strNotifyPageMessage'] = "Poslano vam je bilo elektronsko sporočilo z povezavo, ki vam bo omogočila ponastavitev gesla in prijavo v sistem.<br />Prosimo, počakajte nekaj minut, da se sporočilo dostavi.<br />Če ga niste prejeli, preverite mapo z nezaželjeno pošto.<br /><a href='index.php'>Vrnitev na prijavno stran.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "in dodatnih postavk";
$GLOBALS['strFor'] = "za";
$GLOBALS['strHas'] = "ima";
$GLOBALS['strBinaryData'] = "Binarni podatki";
$GLOBALS['strAuditTrailDisabled'] = "Administrator je onemogočil Pregledno pot. Noben nadaljni dogodek ne bo več zabeležen in prikazan.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Nobena uporabniško dejanje ni bilo zabeleženo med časovnim okvirjem, ki ste ga izbrali.";
$GLOBALS['strAuditTrail'] = "Pregledna pot (audit trail)";
$GLOBALS['strAuditTrailSetup'] = "Nastavite Pregledno pot danes";
$GLOBALS['strAuditTrailGoTo'] = "Pojdite na stran Pregledne poti";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Pojdite na stran kampanje";
$GLOBALS['strCampaignSetUp'] = "Ustvari novo kampanjo danes";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Nobena kampanja ni aktivna za prikaz.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Nobena kampanja se ni začela ali končala v časovnem okvirju, ki ste ga določili";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktiviraj Pregledno pot za ogled Kampanj";

$GLOBALS['strUnsavedChanges'] = "Na tej strani imate neshranjene spremembe. Ko boste končali, kliknite na \"Shrani spremebe\"";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "Zdaj delujte kot <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "Nimate dostopa do te strani. Bili ste preusmerjeni.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Oglaševalec <a href='%s'>%s</a> je bil dodan, <a href='%s'>dodaj kampanjo</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Oglaševalec <a href='%s'>%s</a> je bil posodobljen";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Oglaševalec <b>%s</b> je bil izbrisan";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "Vsi izbrani oglaševalci so bili izbrisani";

$GLOBALS['strTrackerHasBeenAdded'] = "Sledilnik <a href='%s'>%s</a> je bil dodan";
$GLOBALS['strTrackerHasBeenUpdated'] = "Sledilnik <a href='%s'>%s</a> je bil posodobljen";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Spremenljivke sledilnika <a href='%s'>%s</a> so bile posodobljene";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Povezane kampanje sledilnika <a href='%s'>%s</a> so bile posodobljene";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Pripet sledilni niz sledilnika <a href='%s'>%s</a> je bil posodobljen";
$GLOBALS['strTrackerHasBeenDeleted'] = "Sledilnik <b>%s</b> je bil izbrisan";
$GLOBALS['strTrackersHaveBeenDeleted'] = "Vsi izbrani sledilniki so bili izbrisani";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Sledilnik <a href='%s'>%s</a> je bil kopiran v <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Sledilnik <b>%s</b> je bil premaknjen k oglaševalcu <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Kampanja <a href='%s'>%s</a> je bila dodana, <a href='%s'>dodaj pasico</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Kampanja <a href='%s'>%s</a> je bila posodobljena";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Povezani sledilniki kampanje <a href='%s'>%s</a> so bili posodobljeni";
$GLOBALS['strCampaignHasBeenDeleted'] = "Kampanja <b>%s</b> je bila izbrisana";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "Vse izbrane kampanje so bile izbrisane";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Kampanja <a href='%s'>%s</a> je bila kopirana v <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "Kampanja <b>%s</b> je bila premaknjena k oglaševalcu <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "Pasica <a href='%s'>%s</a> je bila dodana";
$GLOBALS['strBannerHasBeenUpdated'] = "Pasica <a href='%s'>%s</a> je bila posodobljena";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Naprednejše nastavitve pasice <a href='%s'>%s</a> so bile posodobljene";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Dostavne možnosti pasice <a href='%s'>%s</a> so bile posodobljene";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Delivery options for banner <a href='%s'>%s</a> have been applied to %d banners";
$GLOBALS['strBannerHasBeenDeleted'] = "Pasica <b>%s</b> je bila izbrisana";
$GLOBALS['strBannersHaveBeenDeleted'] = "Vse izbrane pasice so bile izbrisane";
$GLOBALS['strBannerHasBeenDuplicated'] = "Pasica <a href='%s'>%s</a> je bila kopirana v <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "Pasica <b>%s</b> je bila premaknjena v kampanjo <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "Pasica <a href='%s'>%s</a> je bila aktivirana";
$GLOBALS['strBannerHasBeenDeactivated'] = "Pasica <a href='%s'>%s</a> je bila deaktivirana";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> področje(ij) povezana(ih)";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> področje(ij) brez povezave";

$GLOBALS['strWebsiteHasBeenAdded'] = "Spletna stran <a href='%s'>%s</a> je bila dodana, <a href='%s'>dodaj področje</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Spletna stran <a href='%s'>%s</a> je bila posodobljena";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Spletna stran <b>%s</b> je bila izbrisana";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "Vse izbrane spletne strani so bile izbrisane";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "Website <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strZoneHasBeenAdded'] = "Področje <a href='%s'>%s</a> je bilo dodano";
$GLOBALS['strZoneHasBeenUpdated'] = "Področje <a href='%s'>%s</a> je bilo posodobljeno";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Naprednejše nastavitve področja <a href='%s'>%s</a> so bile posodobljene";
$GLOBALS['strZoneHasBeenDeleted'] = "Področje <b>%s</b> je bilo izbrisano";
$GLOBALS['strZonesHaveBeenDeleted'] = "Vsa izbrana področja so bila izbrisana";
$GLOBALS['strZoneHasBeenDuplicated'] = "Področje <a href='%s'>%s</a> je bilo kopirano v <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "Področje <b>%s</b> je bilo premaknjeno v spletno stran <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Pasica je bila povezana v področje <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "Kampanja je bila povezana v področje <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Pasica več ni povezana v področje <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "Kampanja več ni povezana v področje <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenAdded'] = "Delivery rule set <a href='%s'>%s</a> has been added. <a href='%s'>Set the delivery rules.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Delivery rule set <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for the delivery rule set <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Delivery rule set <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected delivery rule sets have been deleted";
$GLOBALS['strChannelHasBeenDuplicated'] = "Delivery rule set <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Vaše <b>%s</b> preference so bile posodobljene";
$GLOBALS['strEmailChanged'] = "Vaš e-poštni naslov je bil spremenjen";
$GLOBALS['strPasswordChanged'] = "Vaše geslo je bilo spremenjeno";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> so posodobljene";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> so posodobljene";
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
