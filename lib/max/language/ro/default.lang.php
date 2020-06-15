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

$GLOBALS['strHome'] = "Home";
$GLOBALS['strHelp'] = "Ajutor";
$GLOBALS['strStartOver'] = "Începe din nou";
$GLOBALS['strShortcuts'] = "Scurtături";
$GLOBALS['strActions'] = "Acţiune";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "Inventar";
$GLOBALS['strMaintenance'] = "Întreţinere";
$GLOBALS['strProbability'] = "Probabilitate";
$GLOBALS['strInvocationcode'] = "Cod Reclame";
$GLOBALS['strBasicInformation'] = "Informaţii de Bază";
$GLOBALS['strAppendTrackerCode'] = "Alătură cod pentru contor";
$GLOBALS['strOverview'] = "Ansamblu";
$GLOBALS['strSearch'] = "<u>C</u>aută";
$GLOBALS['strDetails'] = "Detalii";
$GLOBALS['strUpdateSettings'] = "Setări Actualizare";
$GLOBALS['strCheckForUpdates'] = "Verifică pentru Actualizări";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "Compact";
$GLOBALS['strUser'] = "Utilizator";
$GLOBALS['strDuplicate'] = "Creează duplicat";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "Mută la";
$GLOBALS['strDelete'] = "Şterge";
$GLOBALS['strActivate'] = "Activează";
$GLOBALS['strConvert'] = "Converteşte";
$GLOBALS['strRefresh'] = "Reîmprospătare";
$GLOBALS['strSaveChanges'] = "Salvează Schimbări";
$GLOBALS['strUp'] = "Sus";
$GLOBALS['strDown'] = "Jos";
$GLOBALS['strSave'] = "Salvează";
$GLOBALS['strCancel'] = "Anulează";
$GLOBALS['strBack'] = "Înapoi";
$GLOBALS['strPrevious'] = "Înapoi";
$GLOBALS['strNext'] = "Înainte";
$GLOBALS['strYes'] = "Da";
$GLOBALS['strNo'] = "Nu";
$GLOBALS['strNone'] = "Gol";
$GLOBALS['strCustom'] = "Personalizat";
$GLOBALS['strDefault'] = "Implicit";
$GLOBALS['strUnknown'] = "Unknown";
$GLOBALS['strUnlimited'] = "Nelimitat";
$GLOBALS['strUntitled'] = "Fără titlu";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "Medie";
$GLOBALS['strOverall'] = "Per Total";
$GLOBALS['strTotal'] = "Total";
$GLOBALS['strFrom'] = "From";
$GLOBALS['strTo'] = "la";
$GLOBALS['strAdd'] = "Adaugă";
$GLOBALS['strLinkedTo'] = "asociat către";
$GLOBALS['strDaysLeft'] = "Zile rămase";
$GLOBALS['strCheckAllNone'] = "Bifează toate / nici una";
$GLOBALS['strKiloByte'] = "KO";
$GLOBALS['strExpandAll'] = "<u>D</u>eschide toate";
$GLOBALS['strCollapseAll'] = "<u>Î</u>nchide toate";
$GLOBALS['strShowAll'] = "Arată Toate";
$GLOBALS['strNoAdminInterface'] = "Panoul administratorului a fost oprit pentru întreţinere. Acest lucru nu afectează distribuţia reclamelor tale.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "Data 'De La' trebuie să fie mai mică decât data 'La'";
$GLOBALS['strFieldContainsErrors'] = "Următoarele câmpuri conţin erori:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Înainte de a continua trebuie să";
$GLOBALS['strFieldFixBeforeContinue2'] = "pentru a corecta aceste erori.";
$GLOBALS['strMiscellaneous'] = "Diverse";
$GLOBALS['strCollectedAllStats'] = "Toate statisticile";
$GLOBALS['strCollectedToday'] = "Astăzi";
$GLOBALS['strCollectedYesterday'] = "Ieri";
$GLOBALS['strCollectedThisWeek'] = "Săptămâna curentă";
$GLOBALS['strCollectedLastWeek'] = "Ultima săptămână";
$GLOBALS['strCollectedThisMonth'] = "Luna curentă";
$GLOBALS['strCollectedLastMonth'] = "Ultima lună";
$GLOBALS['strCollectedLast7Days'] = "Ultimele 7 zile";
$GLOBALS['strCollectedSpecificDates'] = "Date specificate";
$GLOBALS['strValue'] = "Valoare";
$GLOBALS['strWarning'] = "Avertisment";
$GLOBALS['strNotice'] = "Atenţionare";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "The dashboard can not be displayed";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "cod";
$GLOBALS['strDashboardSystemMessage'] = "Mesaj al sistemului";
$GLOBALS['strDashboardErrorHelp'] = "Daca această eroare se va repeta te rugăm să descrii problema detaliat şi să o postezi în <a href='http://forum.openx.org/'>forumul OpenX</a>.";

// Priority
$GLOBALS['strPriority'] = "Prioritate";
$GLOBALS['strPriorityLevel'] = "Nivel prioritate";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Limitare";

// Properties
$GLOBALS['strName'] = "Nume";
$GLOBALS['strSize'] = "Dimensiune";
$GLOBALS['strWidth'] = "Lăţime";
$GLOBALS['strHeight'] = "Înălţime";
$GLOBALS['strTarget'] = "Ţintă";
$GLOBALS['strLanguage'] = "Limba";
$GLOBALS['strDescription'] = "Descriere";
$GLOBALS['strVariables'] = "Variabile";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Comentarii";

// User access
$GLOBALS['strWorkingAs'] = "Lucrezi ca";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Lucrezi ca";
$GLOBALS['strSwitchTo'] = "Schimbă către";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s pentru...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "Adaugă utilizator";
$GLOBALS['strLinkUser_Key'] = "Adaugă <u>u</u>tilizator";
$GLOBALS['strUsernameToLink'] = "Numele de utilizator de adăugat";
$GLOBALS['strNewUserWillBeCreated'] = "Va fi creat un utilizator nou";
$GLOBALS['strToLinkProvideEmail'] = "Pentru a adăuga utilizatorul, introdu adresa de e-mail a acestuia";
$GLOBALS['strToLinkProvideUsername'] = "Pentru a adăuga utilizatorul, introdu numele de utilizator";
$GLOBALS['strUserLinkedToAccount'] = "Utilizatorul a fost adăugat contului";
$GLOBALS['strUserAccountUpdated'] = "Contul utilizatorului a fost actualizat";
$GLOBALS['strUserUnlinkedFromAccount'] = "Utilizatorul a fost şters din cont";
$GLOBALS['strUserWasDeleted'] = "Utilizatorul a fost şters";
$GLOBALS['strUserNotLinkedWithAccount'] = "Acest utilizator nu este asociat cu contul";
$GLOBALS['strCantDeleteOneAdminUser'] = "Nu poţi şterge un utilizator. Cel puţin un utilizator trebuie să fie asociat cu contul de administrator.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "utilizator";
$GLOBALS['strLinkUserHelpEmail'] = "adresa de email";
$GLOBALS['strLastLoggedIn'] = "Ultima autentificare";
$GLOBALS['strDateLinked'] = "Data asocierii";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Acces Utilizator";
$GLOBALS['strAdminAccess'] = "Acces Administrator";
$GLOBALS['strUserProperties'] = "Proprietăţi Utilizator";
$GLOBALS['strPermissions'] = "Permisiuni";
$GLOBALS['strAuthentification'] = "Autentificare";
$GLOBALS['strWelcomeTo'] = "Bine ai venit la";
$GLOBALS['strEnterUsername'] = "Introdu utilizatorul şi parola pentru autentificare";
$GLOBALS['strEnterBoth'] = "Te rugăm să introduci atât utilizatorul cât şi parola";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Eroare pentru cookie-ul de sesiune, te rugăm să te autentifici din nou";
$GLOBALS['strLogin'] = "Autentificare";
$GLOBALS['strLogout'] = "Ieşire";
$GLOBALS['strUsername'] = "Utilizator";
$GLOBALS['strPassword'] = "Parola";
$GLOBALS['strPasswordRepeat'] = "Repetă Parola";
$GLOBALS['strAccessDenied'] = "Acces respins";
$GLOBALS['strUsernameOrPasswordWrong'] = "Utilizatorul şi/sau parola nu au fost corecte. Te rugăm să încerci din nou.";
$GLOBALS['strPasswordWrong'] = "Parola nu este corectă.";
$GLOBALS['strNotAdmin'] = "Contul tău nu are drepturi suficiente pentru a utiliza această facilitate, te poţi autentifica cu alt cont pentru a o folosi. Click <a href='logout.php'>aici</a> pentru a te autentifica ca alt utilizator.";
$GLOBALS['strDuplicateClientName'] = "Utilizatorul pe care l-ai introdus există deja, te rugăm să foloseşti un alt utilizator.";
$GLOBALS['strInvalidPassword'] = "Parola nouă este incorectă, te rugăm să introduci o altă parolă.";
$GLOBALS['strInvalidEmail'] = "Emailul este într-un format incorect, te rugăm să introduci o adresa de email corectă.";
$GLOBALS['strNotSamePasswords'] = "Cele doua parole pe care le-ai introdus nu sunt la fel.";
$GLOBALS['strRepeatPassword'] = "Repetă Parola";
$GLOBALS['strDeadLink'] = "Link-ul tău este invalid.";
$GLOBALS['strNoPlacement'] = "Campania aleasă nu există. Încearcă acest <a href='{link}'>link</a> în loc";
$GLOBALS['strNoAdvertiser'] = "Advertiserul ales nu există. Încearcă acest <a href='{link}'>link</a> în loc";

// General advertising
$GLOBALS['strRequests'] = "Cereri";
$GLOBALS['strImpressions'] = "Vizualizări";
$GLOBALS['strClicks'] = "Click-uri";
$GLOBALS['strConversions'] = "Conversii";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Total Click-uri";
$GLOBALS['strTotalConversions'] = "Total Conversii";
$GLOBALS['strDateTime'] = "Data Ora";
$GLOBALS['strTrackerID'] = "ID Contor";
$GLOBALS['strTrackerName'] = "Nume Contor";
$GLOBALS['strTrackerImageTag'] = "Tag Imagine";
$GLOBALS['strTrackerJsTag'] = "Tag Javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "Bannere";
$GLOBALS['strCampaigns'] = "Campanii";
$GLOBALS['strCampaignID'] = "ID Campanie";
$GLOBALS['strCampaignName'] = "Nume Campanie";
$GLOBALS['strCountry'] = "Ţara";
$GLOBALS['strStatsAction'] = "Acţiune";
$GLOBALS['strWindowDelay'] = "Întârziere fereastră";
$GLOBALS['strStatsVariables'] = "Variabile";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Chirie Lunară";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Data";
$GLOBALS['strDay'] = "Ziua";
$GLOBALS['strDays'] = "Zile";
$GLOBALS['strWeek'] = "Săptămână";
$GLOBALS['strWeeks'] = "Săptămâni";
$GLOBALS['strSingleMonth'] = "Luna";
$GLOBALS['strMonths'] = "Luni";
$GLOBALS['strDayOfWeek'] = "Ziua din săptămână";


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

$GLOBALS['strHour'] = "Ora";
$GLOBALS['strSeconds'] = "secunde";
$GLOBALS['strMinutes'] = "minute";
$GLOBALS['strHours'] = "ore";

// Advertiser
$GLOBALS['strClient'] = "Advertiser";
$GLOBALS['strClients'] = "Advertiseri";
$GLOBALS['strClientsAndCampaigns'] = "Advertiseri & Campanii";
$GLOBALS['strAddClient'] = "Adaugă un nou advertiser";
$GLOBALS['strClientProperties'] = "Proprietăţi advertiser";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "Momentan nu este nici un advertiser definit. Pentru a crea o campanie, <a href='advertiser-edit.php'>adaugă un advertiser</a> mai întâi.";
$GLOBALS['strConfirmDeleteClient'] = "Eşti sigur că vrei să ştergi acest advertiser?";
$GLOBALS['strConfirmDeleteClients'] = "Eşti sigur că vrei să ştergi acest advertiser?";
$GLOBALS['strHideInactive'] = "Ascunde inactivi";
$GLOBALS['strInactiveAdvertisersHidden'] = "advertiserii inactivi ascunşi";
$GLOBALS['strAdvertiserSignup'] = "Înscriere Advertiser";
$GLOBALS['strAdvertiserCampaigns'] = "Advertiseri & Campanii";

// Advertisers properties
$GLOBALS['strContact'] = "Contact";
$GLOBALS['strContactName'] = "Nume de Contact";
$GLOBALS['strEMail'] = "Email";
$GLOBALS['strSendAdvertisingReport'] = "Trimite e-mail cu rapoartele de desfăşurare a campaniei";
$GLOBALS['strNoDaysBetweenReports'] = "Număr de zile între rapoartele de desfăşurare a campaniei";
$GLOBALS['strSendDeactivationWarning'] = "Trimite e-mail atunci când o campanie este activată/dezactivată în mod automat";
$GLOBALS['strAllowClientModifyBanner'] = "Permite acestui utilizator să-şi modifice propriile bannere";
$GLOBALS['strAllowClientDisableBanner'] = "Permite acestui utilizator să-şi dezactiveze propriile bannere";
$GLOBALS['strAllowClientActivateBanner'] = "Permite acestui utilizator să-şi activeze propriile bannere";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Afişează doar un banner al acestui advertiser pe o pagină web";
$GLOBALS['strAllowAuditTrailAccess'] = "Permite acestui utilizator să acceseze Urmărirea Bilanţului";

// Campaign
$GLOBALS['strCampaign'] = "Campanie";
$GLOBALS['strCampaigns'] = "Campanii";
$GLOBALS['strAddCampaign'] = "Adaugă campanie nouă";
$GLOBALS['strAddCampaign_Key'] = "Adaugă campanie <u>n</u>ouă";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Campanii asociate";
$GLOBALS['strCampaignProperties'] = "Proprietăţi campanie";
$GLOBALS['strCampaignOverview'] = "Vizualizare Campanie";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "Momentan nu este definită nici o campanie activă";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Eşti sigur că vrei să ştergi aceasta campanie?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Eşti sigur că vrei să ştergi aceasta campanie?";
$GLOBALS['strShowParentAdvertisers'] = "Arată advertiseri părinte";
$GLOBALS['strHideParentAdvertisers'] = "Ascunde advertiseri părinte";
$GLOBALS['strHideInactiveCampaigns'] = "Ascunde campaniile inactive";
$GLOBALS['strInactiveCampaignsHidden'] = "campanii inactive ascunse";
$GLOBALS['strPriorityInformation'] = "Prioritate în relaţie cu alte campanii";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Campanie";
$GLOBALS['strHiddenAd'] = "Reclamă";
$GLOBALS['strHiddenAdvertiser'] = "Advertiser";
$GLOBALS['strHiddenTracker'] = "Contor";
$GLOBALS['strHiddenWebsite'] = "Website";
$GLOBALS['strHiddenZone'] = "Zonă";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Poziţionare campanie";
$GLOBALS['strSelectUnselectAll'] = "Selectează / Deselectează Toate";
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
$GLOBALS['strAvailable'] = "Disponibil";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


// Campaign properties
$GLOBALS['strDontExpire'] = "Nu dezactiva";
$GLOBALS['strActivateNow'] = "Activează imediat";
$GLOBALS['strSetSpecificDate'] = "Set specific date";
$GLOBALS['strLow'] = "Scăzută";
$GLOBALS['strHigh'] = "Mare";
$GLOBALS['strExpirationDate'] = "Dată Sfârşit";
$GLOBALS['strExpirationDateComment'] = "Campania se va încheia la sfârşitul acestei zile";
$GLOBALS['strActivationDate'] = "Dată Început";
$GLOBALS['strActivationDateComment'] = "Campania se va derula la începutul acestei zile";
$GLOBALS['strImpressionsRemaining'] = "Vizualizări Disponibile";
$GLOBALS['strClicksRemaining'] = "Click-uri Disponibile";
$GLOBALS['strConversionsRemaining'] = "Conversii Disponibile";
$GLOBALS['strImpressionsBooked'] = "Vizualizări Rezervate";
$GLOBALS['strClicksBooked'] = "Click-uri Rezervate";
$GLOBALS['strConversionsBooked'] = "Conversii Rezervate";
$GLOBALS['strCampaignWeight'] = "Stabileşte importanţa campaniei";
$GLOBALS['strAnonymous'] = "Ascunde advertiser-ul şi site-urile pentru această campanie";
$GLOBALS['strTargetPerDay'] = "pe zi.";
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
$GLOBALS['strCampaignStatusPending'] = "Aşteptare Aprobare";
$GLOBALS['strCampaignStatusInactive'] = "activ";
$GLOBALS['strCampaignStatusRunning'] = "Se execută";
$GLOBALS['strCampaignStatusPaused'] = "În Pauză";
$GLOBALS['strCampaignStatusAwaiting'] = "În Aşteptare";
$GLOBALS['strCampaignStatusExpired'] = "Finalizat";
$GLOBALS['strCampaignStatusApproval'] = "Aşteaptă aprobarea »";
$GLOBALS['strCampaignStatusRejected'] = "Respins";
$GLOBALS['strCampaignStatusAdded'] = "Adăugat";
$GLOBALS['strCampaignStatusStarted'] = "Început";
$GLOBALS['strCampaignStatusRestarted'] = "Reînceput";
$GLOBALS['strCampaignStatusDeleted'] = "Şters";
$GLOBALS['strCampaignType'] = "Nume Campanie";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strContract'] = "Contact";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Contact";
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
$GLOBALS['strBackToCampaigns'] = "Înapoi la campanii";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Contor";
$GLOBALS['strTrackers'] = "Contoare";
$GLOBALS['strTrackerPreferences'] = "Preferinţe Contor";
$GLOBALS['strAddTracker'] = "Adaugă contor nou";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "Nu a fost definit nici un contor";
$GLOBALS['strConfirmDeleteTrackers'] = "Eşti sigur că vrei să ştergi acest contor?";
$GLOBALS['strConfirmDeleteTracker'] = "Eşti sigur că vrei să ştergi acest contor?";
$GLOBALS['strTrackerProperties'] = "Proprietăţi contor";
$GLOBALS['strDefaultStatus'] = "Stare Implicită";
$GLOBALS['strStatus'] = "Stare";
$GLOBALS['strLinkedTrackers'] = "Contoare Asociate";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Fereastră conversie";
$GLOBALS['strUniqueWindow'] = "Fereastră Unici";
$GLOBALS['strClick'] = "Click";
$GLOBALS['strView'] = "Vizualizare";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Tip Conversie";
$GLOBALS['strLinkCampaignsByDefault'] = "Asociază campaniile noi în mod implicit";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strBanners'] = "Bannere";
$GLOBALS['strAddBanner'] = "Adaugă banner nou";
$GLOBALS['strAddBanner_Key'] = "Adaugă banner <u>n</u>ou";
$GLOBALS['strBannerToCampaign'] = "Campania ta";
$GLOBALS['strShowBanner'] = "Arată banner";
$GLOBALS['strBannerProperties'] = "Proprietăţi banner";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "Momentan nu este definit nici un banner";
$GLOBALS['strNoBannersAddCampaign'] = "Momentan nu este nici un website definit. Pentru a crea o zonă, <a href='affiliate-edit.php'>adaugă un website nou</a> mai întâi.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Momentan nu este nici un website definit. Pentru a crea o zonă, <a href='affiliate-edit.php'>adaugă un website nou</a> mai întâi.";
$GLOBALS['strConfirmDeleteBanner'] = "Eşti sigur că vrei să ştergi acest banner?";
$GLOBALS['strConfirmDeleteBanners'] = "Eşti sigur că vrei să ştergi acest banner?";
$GLOBALS['strShowParentCampaigns'] = "Arată campaniile părinte";
$GLOBALS['strHideParentCampaigns'] = "Ascunde campaniile părinte";
$GLOBALS['strHideInactiveBanners'] = "Ascunde bannere inactive";
$GLOBALS['strInactiveBannersHidden'] = "bannere inactive ascunse";
$GLOBALS['strWarningMissing'] = "Atenţie, probabil lipseşte_";
$GLOBALS['strWarningMissingClosing'] = "tag închidere \">\"";
$GLOBALS['strWarningMissingOpening'] = "tag deschidere \"<\"";
$GLOBALS['strSubmitAnyway'] = "Trimite Astfel";
$GLOBALS['strBannersOfCampaign'] = "în"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Preferinţe Banner";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Bannere Implicite";
$GLOBALS['strDefaultBannerUrl'] = "URL Imagine Implicită";
$GLOBALS['strDefaultBannerDestination'] = "URL Destinaţie Implicită";
$GLOBALS['strAllowedBannerTypes'] = "Tipuri de Banner Permise";
$GLOBALS['strTypeSqlAllow'] = "Permite Bannere Locale în SQL";
$GLOBALS['strTypeWebAllow'] = "Permite Bannere Locale pe Webserver";
$GLOBALS['strTypeUrlAllow'] = "Permite Bannere Externe";
$GLOBALS['strTypeHtmlAllow'] = "Permite Bannere HTML";
$GLOBALS['strTypeTxtAllow'] = "Permite Reclame Text";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Te rugăm să alegi tipul banner-ului";
$GLOBALS['strMySQLBanner'] = "Upload a local banner to the database";
$GLOBALS['strWebBanner'] = "Upload a local banner to the webserver";
$GLOBALS['strURLBanner'] = "Link an external banner";
$GLOBALS['strHTMLBanner'] = "Create an HTML banner";
$GLOBALS['strTextBanner'] = "Create a Text banner";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Doreşti să-ţi păstrezi <br />imaginea existentă, sau <br /> doreşti să încarci alta?";
$GLOBALS['strNewBannerFile'] = "Alegea imaginea pe care doreşti <br />s-o foloseşti pentru acest banner<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Alegea o imagine de backup pe care <br />doreşti s-o foloseşti in cazul browser-elor<br />care nu suportă formate îmbogăţite<br /><br />";
$GLOBALS['strNewBannerURL'] = "URL Imagine (incl. http://)";
$GLOBALS['strURL'] = "URL Destinaţie (incl. http://)";
$GLOBALS['strKeyword'] = "Cuvinte Cheie";
$GLOBALS['strTextBelow'] = "Text sub imagine";
$GLOBALS['strWeight'] = "Importanţă";
$GLOBALS['strAlt'] = "Alt text";
$GLOBALS['strStatusText'] = "Text status";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Importanţă banner";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Banner HTML generic";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Generic";
$GLOBALS['strSwfTransparency'] = "Permite fundal transparent";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Caută link-urile ascunse din interiorul fişierelor Flash";
$GLOBALS['strConvertSWFLinks'] = "Converteşte link-urile Flash";
$GLOBALS['strHardcodedLinks'] = "Link-uri Codate-Puternic";
$GLOBALS['strConvertSWF'] = "<br />The Flash file you just uploaded contains hard-coded urls. {$PRODUCT_NAME} won't be able to track the number of Clicks for this banner unless you convert these hard-coded urls. Below you will find a list of all urls inside the Flash file. If you want to convert the urls, simply click <b>Convert</b>, otherwise click <b>Cancel</b>.<br /><br />Please note: if you click <b>Convert</b> the Flash file you just uploaded will be physically altered. <br />Please keep a backup of the original file. Regardless of in which version this banner was created, the resulting file will need the Flash 4 player (or higher) to display correctly.<br /><br />";
$GLOBALS['strCompressSWF'] = "Compresează fişierul SWF pentru descărcare mai rapidă (necesită Flash Player 6)";
$GLOBALS['strOverwriteSource'] = "Înlocuieşte parametrul sursă";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Opţiuni livrare";
$GLOBALS['strACL'] = "Opţiuni livrare";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "este egal cu";
$GLOBALS['strDifferentFrom'] = "este diferit de";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "este mai mare decât";
$GLOBALS['strLessThan'] = "este mai mic decât";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "ŞI";                          // logical operator
$GLOBALS['strOR'] = "SAU";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Afişează acest banner doar când:";
$GLOBALS['strWeekDays'] = "Zile din săptămână";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Sursa";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Resetează contoare vizualizări după:";
$GLOBALS['strDeliveryCappingTotal'] = "în total";
$GLOBALS['strDeliveryCappingSession'] = "pe sesiune";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Limitează vizualizări banner la:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Limitează vizualizări campanie la:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Limitează vizualizări zonă la:";

// Website
$GLOBALS['strAffiliate'] = "Website";
$GLOBALS['strAffiliates'] = "Website-uri";
$GLOBALS['strAffiliatesAndZones'] = "Website-uri & Zone";
$GLOBALS['strAddNewAffiliate'] = "Adaugă site nou";
$GLOBALS['strAffiliateProperties'] = "Proprietăţi website";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "Momentan nu este nici un website definit. Pentru a crea o zonă, <a href='affiliate-edit.php'>adaugă un website nou</a> mai întâi.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Eşti sigur că vrei să ştergi acest website?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Eşti sigur că vrei să ştergi acest website?";
$GLOBALS['strInactiveAffiliatesHidden'] = "website-uri inactive ascunse";
$GLOBALS['strShowParentAffiliates'] = "Arată website-uri părinte";
$GLOBALS['strHideParentAffiliates'] = "Ascunde website-uri părinte";

// Website (properties)
$GLOBALS['strWebsite'] = "Website";
$GLOBALS['strWebsiteURL'] = "URL Website";
$GLOBALS['strAllowAffiliateModifyZones'] = "Permite acestui utilizator să-şi modifice propriile zone";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Permite acestui utilizator să asocieze bannere către propriile zone";
$GLOBALS['strAllowAffiliateAddZone'] = "Permite acestui utilizator să definească zone noi";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Permite acestui utilizator să şteargă zone existente";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permite acestui utilizator să genereze codul pentru reclame";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Cod poştal";
$GLOBALS['strCountry'] = "Ţara";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Website-uri & Zone";

// Zone
$GLOBALS['strZone'] = "Zonă";
$GLOBALS['strZones'] = "Zone";
$GLOBALS['strAddNewZone'] = "Adaugă zonă nouă";
$GLOBALS['strAddNewZone_Key'] = "Adaugă zonă <u>n</u>ouă";
$GLOBALS['strZoneToWebsite'] = "Nici un website";
$GLOBALS['strLinkedZones'] = "Zone asociate";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "Proprietăţi zonă";
$GLOBALS['strZoneHistory'] = "Istoric zonă";
$GLOBALS['strNoZones'] = "Momentan nu este definită nici o zonă";
$GLOBALS['strNoZonesAddWebsite'] = "Momentan nu este nici un website definit. Pentru a crea o zonă, <a href='affiliate-edit.php'>adaugă un website nou</a> mai întâi.";
$GLOBALS['strConfirmDeleteZone'] = "Eşti sigur că vrei să ştergi această zonă?";
$GLOBALS['strConfirmDeleteZones'] = "Eşti sigur că vrei să ştergi această zonă?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Încă sunt campanii asociate acestei zone, dacă o ştergi acestea nu vor mai putea fi livrate şi nu vei fi plătit pentru ele.";
$GLOBALS['strZoneType'] = "Tipul zonei";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Buton sau Dreptunghi";
$GLOBALS['strInterstitial'] = "Interstiţial sau DHTML Plutitor";
$GLOBALS['strPopup'] = "Popup";
$GLOBALS['strTextAdZone'] = "Reclamă Text";
$GLOBALS['strEmailAdZone'] = "Zonă Email/Newsletter";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Arată bannere care se potrivesc";
$GLOBALS['strHideMatchingBanners'] = "Ascunde bannere care se potrivesc";
$GLOBALS['strBannerLinkedAds'] = "Bannere asociate acestei zone";
$GLOBALS['strCampaignLinkedAds'] = "Campanii asociate acestei zone";
$GLOBALS['strInactiveZonesHidden'] = "zone inactive ascunse";
$GLOBALS['strWarnChangeZoneType'] = "Schimbând tipul zonei la text sau email va duce la dezasocierea tuturor bannerelor/campaniilor din cauza restricţiilor acestor tipuri de zonă
<ul>
<li>Zonele text pot fi asociate doar reclamelor de tip text</li>
<li>Campaniile zonei email pot avea doar un banner activ la un moment dat</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Schimbând dimensiunea zonei va duce la dezasocierea oricarui banner ce nu corespunde noii dimensiuni, şi va adăuga oricare banner din campaniile asociate care au dimensiunea nouă';
$GLOBALS['strWarnChangeBannerSize'] = 'Modificând dimensiunea banner-ului, va duce la ştergerea asocierii dintre orice zonă care nu corespunde noii dimensiuni, şi dacă <strong>campania</strong> acestui banner este asociată unei zone de noua dimensiune, acest banner va fi asociat în mod automat';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'în'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Buton 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Buton 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Banner pe Jumătate (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Buton Pătrat (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Dreptunghi (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Pop-up Pătrat (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Banner Vertical (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Dreptunghi Mediu (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Dreptunghi Mare (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Dreptunghi Vertical (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Skyscraper Wide (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Avansat";
$GLOBALS['strChainSettings'] = "Setări lanţ";
$GLOBALS['strZoneNoDelivery'] = "Dacă nici un banner din această zonă <br />nu poate fi afişat, încearcă să...";
$GLOBALS['strZoneStopDelivery'] = "Opreşte distribuirea şi nu mai arăta nici un banner";
$GLOBALS['strZoneOtherZone'] = "Afişează zona aleasă în schimb";
$GLOBALS['strZoneAppend'] = "Lipeşte întotdeauna următorul cod HTML bannerelor afişate de această zonă";
$GLOBALS['strAppendSettings'] = "Setări pentru lipire şi prelipire";
$GLOBALS['strZonePrependHTML'] = "Prelipeşte întotdeauna codul HTML reclamelor text afişate de această zonă";
$GLOBALS['strZoneAppendNoBanner'] = "Lipeşte dacă nu este afişat nici un banner";
$GLOBALS['strZoneAppendHTMLCode'] = "Cod HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup sau interstiţial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Toate bannerele asociate acestei zone nu sunt active momentan. <br /> Acesta este lanţul zonei ce va fi urmat:";
$GLOBALS['strZoneProbNullPri'] = "Nu există nici un banner activat asociat acestei zone.";
$GLOBALS['strZoneProbListChainLoop'] = "Urmărind lanţul zonei va cauza o repetare circulară. Distribuţia acestei zone a fost oprită.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Te rugăm să alegi ce doreşti să asociezi acestei zone";
$GLOBALS['strLinkedBanners'] = "Asociază bannere individuale";
$GLOBALS['strCampaignDefaults'] = "Asociază bannere după campania părinte";
$GLOBALS['strLinkedCategories'] = "Asociază bannere după categorie";
$GLOBALS['strWithXBanners'] = "%d banner(e)";
$GLOBALS['strRawQueryString'] = "Cuvânt cheie";
$GLOBALS['strIncludedBanners'] = "Bannere asociate";
$GLOBALS['strMatchingBanners'] = "{count} bannere ce se potriviesc";
$GLOBALS['strNoCampaignsToLink'] = "Momentan nu există nici o campanie care să poată fi asociată acestei zone";
$GLOBALS['strNoTrackersToLink'] = "Momentan nu este disponibil nici un urmăritor care să poată fi asociat acestei campanii";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Nu există nici o zonă disponibilă căreia să-i poată fi asociată această campanie";
$GLOBALS['strSelectBannerToLink'] = "Alege bannerul pe care doreşti să-l asociezi acestei zone:";
$GLOBALS['strSelectCampaignToLink'] = "Alege campania pe care doreşti s-o asociezi acestei zone:";
$GLOBALS['strSelectAdvertiser'] = "Alege Advertiser";
$GLOBALS['strSelectPlacement'] = "Alege Campanie";
$GLOBALS['strSelectAd'] = "Alege Banner";
$GLOBALS['strSelectPublisher'] = "Alege Website";
$GLOBALS['strSelectZone'] = "Alege Zonă";
$GLOBALS['strStatusPending'] = "Aşteptare Aprobare";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Creează duplicat";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Tip";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Editează statusuri";
$GLOBALS['strShortcutShowStatuses'] = "Arată statusuri";

// Statistics
$GLOBALS['strStats'] = "Statistici";
$GLOBALS['strNoStats'] = "Momentan statisticile nu sunt disponibile";
$GLOBALS['strNoStatsForPeriod'] = "Momentan nu sunt disponibile statistici pentru perioada de la %s la %s";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Total pentru această perioadă";
$GLOBALS['strPublisherDistribution'] = "Distribuţie website";
$GLOBALS['strCampaignDistribution'] = "Distribuţie campanie";
$GLOBALS['strViewBreakdown'] = "Vizualizare după";
$GLOBALS['strBreakdownByDay'] = "Ziua";
$GLOBALS['strBreakdownByWeek'] = "Săptămână";
$GLOBALS['strBreakdownByMonth'] = "Luna";
$GLOBALS['strBreakdownByDow'] = "Ziua din săptămână";
$GLOBALS['strBreakdownByHour'] = "Ora";
$GLOBALS['strItemsPerPage'] = "Înregistrări pe pagină";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Arată <u>G</u>raficul pentru Statistici";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xportă Statisticile în Excel";
$GLOBALS['strGDnotEnabled'] = "Trebuie să ai GD activat în PHP pentru afişarea graficelor. <br />Te rugăm să citeşti la <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> pentru mai multe informaţii, inclusiv instrucţiuni de instalare pe serverul tău.";
$GLOBALS['strStatsArea'] = "Suprafaţă";

// Expiration
$GLOBALS['strNoExpiration'] = "Nu a fost setată nici o dată de expirare";
$GLOBALS['strEstimated'] = "Dată estimată pentru expirare";
$GLOBALS['strNoExpirationEstimation'] = "Nici o dată de expirare estimată încă";
$GLOBALS['strDaysAgo'] = "zile în urmă";
$GLOBALS['strCampaignStop'] = "Stop campanie";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Perioadă";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Toţi advertiserii";
$GLOBALS['strAnonAdvertisers'] = "Advertiseri anonimi";
$GLOBALS['strAllPublishers'] = "Toate website-urile";
$GLOBALS['strAnonPublishers'] = "Website-uri anonime";
$GLOBALS['strAllAvailZones'] = "Toate zonele disponibile";

// Userlog
$GLOBALS['strUserLog'] = "Jurnal utilizator";
$GLOBALS['strUserLogDetails'] = "Detalii jurnal utilizator";
$GLOBALS['strDeleteLog'] = "Şterge jurnal";
$GLOBALS['strAction'] = "Acţiune";
$GLOBALS['strNoActionsLogged'] = "Nici o acţiune nu a fost înregistrată";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Selecţie directă";
$GLOBALS['strChooseInvocationType'] = "Te rugăm să alegi tipul de cod pentru banner";
$GLOBALS['strGenerate'] = "Generează";
$GLOBALS['strParameters'] = "Setări tag";
$GLOBALS['strFrameSize'] = "Dimensiune frame";
$GLOBALS['strBannercode'] = "Cod banner";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Întoarce-te la lista de rapoarte";
$GLOBALS['strCharset'] = "Set caractere";
$GLOBALS['strAutoDetect'] = "Auto-detectează";
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
$GLOBALS['strNoMatchesFound'] = "Nu a fost găsită nici o potrivire";
$GLOBALS['strErrorOccurred'] = "A intervenit o eroare";
$GLOBALS['strErrorDBPlain'] = "A intervenit o eroare în timpul accesării bazei de date";
$GLOBALS['strErrorDBSerious'] = "A fost detectată o problemă gravă a bazei de date";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Tabela din baza de date este posibil să fie coruptă şi are nevoie de reparaţii. Pentru mai multe informaţii despre repararea tabelelor corupte te rugăm să citeşti capitolul <i>Troubleshooting</i> din <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Te rugăm să contactezi administratorul acestui server şi să-i aduci la cunoştinţă această problemă.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "Nu a fost posibilă asocierea banner-ului cu această zonă deoarece:";
$GLOBALS['strUnableToLinkBanner'] = "Nu se poate asocia acest banner:_";
$GLOBALS['strErrorEditingCampaignRevenue'] = "format număr incorect în câmpul de Informaţii Venituri";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Eroare la actualizarea zonei:";
$GLOBALS['strUnableToChangeZone'] = "Nu pot aplica această schimbare deoarece:";
$GLOBALS['strDatesConflict'] = "datele intră în conflict cu:";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Unele statistici au fost înregistrate într-un fus de orar incompatibil UTC şi s-ar putea să nu fie afişate într-un fus orar corect.";
$GLOBALS['strWarningInaccurateReadMore'] = "Citeşte mai multe despre acest lucru";
$GLOBALS['strWarningInaccurateReport'] = "Unele statistici din acest raport au fost înregistrate într-un fus de orar incompatibil UTC şi s-ar putea să nu fie afişate într-un fus orar corect.";

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
$GLOBALS['strSirMadam'] = "Domnul/Doamna";
$GLOBALS['strMailSubject'] = "Raport advertiser";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Mai jos vei găsi statisticile banner-ului pentru {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campanie activată";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campanie dezactivată";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Campania de mai jos a fost dezactivată deoarece";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Această nu este activă momentan deoarece";
$GLOBALS['strBeforeActivate'] = "data activării nu a fost atinsă încă";
$GLOBALS['strAfterExpire'] = "data expirării nu a fost atinsă încă";
$GLOBALS['strNoMoreImpressions'] = "nu au mai rămas Vizualizări";
$GLOBALS['strNoMoreClicks'] = "nu au mai rămas Click-uri";
$GLOBALS['strNoMoreConversions'] = "nu au mai rămas Vânzări";
$GLOBALS['strWeightIsNull'] = "importanţa sa este setată pe zero";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "Nici o Vizualizare nu a fost înregistrată în timpul efectuării acestui raport";
$GLOBALS['strNoClickLoggedInInterval'] = "Nici un Click nu a fost înregistrat în timpul efectuării acestui raport";
$GLOBALS['strNoConversionLoggedInInterval'] = "Nici o Conversie nu a fost înregistrată în timpul efectuării acestui raport";
$GLOBALS['strMailReportPeriod'] = "Acest raport include statistici începând din {startdate} până la {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Acest raport include toate statisticile până la {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Nu sunt statistici disponibile pentru această campanie";
$GLOBALS['strImpendingCampaignExpiry'] = "În aşteptarea expirării campaniei";
$GLOBALS['strYourCampaign'] = "Campania ta";
$GLOBALS['strTheCampiaignBelongingTo'] = "Campania îi aparţine lui";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} de mai jos are termenul de sfârşit pe {date}. ";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} de mai jos are mai puţin de {limit} vizualizări rămase. ";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Prioritate";
$GLOBALS['strSourceEdit'] = "Editează Sursele";

// Preferences
$GLOBALS['strPreferences'] = "Preferinţe";
$GLOBALS['strUserPreferences'] = "Preferinţe Utilizator";
$GLOBALS['strChangePassword'] = "Schimbă Parola";
$GLOBALS['strChangeEmail'] = "Schimbă Email";
$GLOBALS['strCurrentPassword'] = "Parola actuală";
$GLOBALS['strChooseNewPassword'] = "Alege o parolă nouă";
$GLOBALS['strReenterNewPassword'] = "Reintrodu parola nouă";
$GLOBALS['strNameLanguage'] = "Nume & Limba";
$GLOBALS['strAccountPreferences'] = "Preferinţe Cont";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferinţe Rapoarte prin e-mail ale Campaniei";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "Avertizări e-mail administrator";
$GLOBALS['strAgencyEmailWarnings'] = "Avertizări e-mail agenţie";
$GLOBALS['strAdveEmailWarnings'] = "Avertizări e-mail advertiser";
$GLOBALS['strFullName'] = "Numele Complet";
$GLOBALS['strEmailAddress'] = "Adresa de E-mail";
$GLOBALS['strUserDetails'] = "Detalii Utilizator";
$GLOBALS['strUserInterfacePreferences'] = "Preferinţe Interfaţă Utilizator";
$GLOBALS['strPluginPreferences'] = "Preferinţe de Bază";
$GLOBALS['strColumnName'] = "Nume Coloană";
$GLOBALS['strShowColumn'] = "Afişează Coloană";
$GLOBALS['strCustomColumnName'] = "Nume Personalizat al Coloanei";
$GLOBALS['strColumnRank'] = "Loc Coloană";

// Long names
$GLOBALS['strRevenue'] = "Venit";
$GLOBALS['strNumberOfItems'] = "Număr de înregistrări";
$GLOBALS['strRevenueCPC'] = "Venituri CPC";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "Conversii în aşteptare";
$GLOBALS['strImpressionSR'] = "SR Vizualizare";
$GLOBALS['strClickSR'] = "SR Click";

// Short names
$GLOBALS['strRevenue_short'] = "Ven.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Itemi";
$GLOBALS['strRevenueCPC_short'] = "Ven. CPC";
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
$GLOBALS['strRequests_short'] = "Cer.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Click-uri";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Conv. aşteptare";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "SR Click";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Setări Globale";
$GLOBALS['strGeneralSettings'] = "Setări Generale";
$GLOBALS['strMainSettings'] = "Setări Principale";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Alege Secţiune';

// Product Updates
$GLOBALS['strProductUpdates'] = "Actualizări Produs";
$GLOBALS['strViewPastUpdates'] = "Gestionează Actualizările Anterioare şi Copiile de Siguranţă";
$GLOBALS['strFromVersion'] = "De La Versiunea";
$GLOBALS['strToVersion'] = "La Versiunea";
$GLOBALS['strToggleDataBackupDetails'] = "Schimbă detaliile backup-ului datelor";
$GLOBALS['strClickViewBackupDetails'] = "fă click pentru a vizualiza detaliile backup-ului";
$GLOBALS['strClickHideBackupDetails'] = "fă click pentru a ascunde detaliile backup-ului";
$GLOBALS['strShowBackupDetails'] = "Afişează detaliile backup-ului datelor";
$GLOBALS['strHideBackupDetails'] = "Ascunde detaliile backup-ului datelor";
$GLOBALS['strBackupDeleteConfirm'] = "Chiar vrei să ştergi toate backup-urile create înainte de acest upgrade?";
$GLOBALS['strDeleteArtifacts'] = "Şterge Artefacte";
$GLOBALS['strArtifacts'] = "Artefacte";
$GLOBALS['strBackupDbTables'] = "Fă Backup la tabelele bazei de date";
$GLOBALS['strLogFiles'] = "Fişiere jurnal";
$GLOBALS['strConfigBackups'] = "Backup-uri Conf";
$GLOBALS['strUpdatedDbVersionStamp'] = "Ştampilă versiune a bazei de date actualizate";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "UPGRADE COMPLET";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "UPGRADE EŞUAT";

// Agency
$GLOBALS['strAgencyManagement'] = "Organizare Cont";
$GLOBALS['strAgency'] = "Cont";
$GLOBALS['strAddAgency'] = "Adaugă un cont nou";
$GLOBALS['strAddAgency_Key'] = "Adaugă cont <u>n</u>ou";
$GLOBALS['strTotalAgencies'] = "Total conturi";
$GLOBALS['strAgencyProperties'] = "Proprietăţi cont";
$GLOBALS['strNoAgencies'] = "Momentan nu este definit nici un cont";
$GLOBALS['strConfirmDeleteAgency'] = "Eşti sigur că vrei să ştergi acest cont?";
$GLOBALS['strHideInactiveAgencies'] = "Ascunde conturi inactive";
$GLOBALS['strInactiveAgenciesHidden'] = "conturi inactive ascunse";
$GLOBALS['strSwitchAccount'] = "Schimbă pe acest cont";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "Nici un website";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Opţiuni livrare";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'în'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Nume Variabilă";
$GLOBALS['strVariableDescription'] = "Descriere";
$GLOBALS['strVariableDataType'] = "Tip Dată";
$GLOBALS['strVariablePurpose'] = "Scop";
$GLOBALS['strGeneric'] = "Generic";
$GLOBALS['strBasketValue'] = "Valoare coş";
$GLOBALS['strNumItems'] = "Număr de înregistrări";
$GLOBALS['strVariableIsUnique'] = "Previne conversiile duplicat?";
$GLOBALS['strNumber'] = "Număr";
$GLOBALS['strString'] = "String";
$GLOBALS['strTrackFollowingVars'] = "Contorizează următoarea variabilă";
$GLOBALS['strAddVariable'] = "Adaugă Variabilă";
$GLOBALS['strNoVarsToTrack'] = "Nu există Variabile pentru contorizare.";
$GLOBALS['strVariableRejectEmpty'] = "Respinge dacă este gol?";
$GLOBALS['strTrackingSettings'] = "Setări contorizare";
$GLOBALS['strTrackerType'] = "Tip contor";
$GLOBALS['strTrackerTypeJS'] = "Contorizează variabile Javascript";
$GLOBALS['strTrackerTypeDefault'] = "Contorizează variabile Javascript (compatibil şi cu versiunile anterior, are nevoie de escaping)";
$GLOBALS['strTrackerTypeDOM'] = "Contorizează elementele HTML folosind DOM";
$GLOBALS['strTrackerTypeCustom'] = "Cod JS personalizat";
$GLOBALS['strVariableCode'] = "Cod Javascript de contorizare";

// Password recovery
$GLOBALS['strForgotPassword'] = "Ţi-ai uitat parola?";
$GLOBALS['strPasswordRecovery'] = "Recuperare parolă";
$GLOBALS['strEmailRequired'] = "Email este un câmp obligatoriu";
$GLOBALS['strPwdRecWrongId'] = "ID greşit";
$GLOBALS['strPwdRecEnterEmail'] = "Scrie adresa de email mai jos";
$GLOBALS['strPwdRecEnterPassword'] = "Scrie noua parolă mai jos";
$GLOBALS['strPwdRecResetLink'] = "Link pentru resetare parolă";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s recuperare parolă";
$GLOBALS['strProceed'] = "Înaintează >";
$GLOBALS['strNotifyPageMessage'] = "A fost trimis un e-mail către tine, ce conţine o adresă (legătură) de accesat ce-ţi va permite să-ţi resetezi parola şi să te autentifici.<br />Te rugăm să aştepţi câteva minute pentru ca e-mail-ul să ajungă la timp.<br />Dacă nu primeşti e-mail-ul, te rugăm să verifici în dosarul spam.<br /><a href='index.php'>Întoarce-te la pagina principală de autentificare.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "şi facilităţi suplimentare";
$GLOBALS['strFor'] = "pentru";
$GLOBALS['strHas'] = "are";
$GLOBALS['strBinaryData'] = "Date binare";
$GLOBALS['strAuditTrailDisabled'] = "Urmărirea Bilanţului a fost dezactivată de către administrator. Nici un eveniment viitor nu a fost reţinut şi afişat în lista de Urmărire a Bilanţului.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Nu a fost înregistrată nici o activitate a utilizatorului în intervalul de timp pe care l-ai ales.";
$GLOBALS['strAuditTrail'] = "Urmărirea Bilanţului";
$GLOBALS['strAuditTrailSetup'] = "Setează astăzi Urmărirea Bilanţului";
$GLOBALS['strAuditTrailGoTo'] = "Du-te la pagina de Urmărire a Bilanţului";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Du-te la pagina de Campanii";
$GLOBALS['strCampaignSetUp'] = "Setează o Campanie astăzi";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Nu există activitate a campaniei pentru a fi afişată.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Nici o campanie nu a început sau s-a terminat în intervalul de timp pe care l-ai selectat.";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activează Urmărirea Bilanţului pentru a începe vizualizarea Campaniilor";

$GLOBALS['strUnsavedChanges'] = "Nu ai salvat schimbările din această pagină, asigură-te că vei apăsa \"Salvează Shimbări\" când ai terminat";
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
