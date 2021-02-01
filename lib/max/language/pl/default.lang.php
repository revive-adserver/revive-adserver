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

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m/%Y";
$GLOBALS['day_format'] = "%d/%m";
$GLOBALS['week_format'] = "%W/%Y";
$GLOBALS['weekiso_format'] = "%V/%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Główna";
$GLOBALS['strHelp'] = "Pomoc";
$GLOBALS['strStartOver'] = "Zacznij od początku";
$GLOBALS['strShortcuts'] = "Skróty";
$GLOBALS['strActions'] = "Operacje";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "Inwentarz";
$GLOBALS['strMaintenance'] = "Konserwacja";
$GLOBALS['strProbability'] = "Prawdopodobieństwo";
$GLOBALS['strInvocationcode'] = "Kod wywołujący";
$GLOBALS['strBasicInformation'] = "Podstawowe Informacje";
$GLOBALS['strAppendTrackerCode'] = "Dodaj kod trackera";
$GLOBALS['strOverview'] = "Podgląd";
$GLOBALS['strSearch'] = "<u>S</u>zukaj";
$GLOBALS['strDetails'] = "Szczegóły";
$GLOBALS['strUpdateSettings'] = "Ustawienia aktualizacji";
$GLOBALS['strCheckForUpdates'] = "Sprawdź dostępne aktualizacje";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "Skrócone";
$GLOBALS['strUser'] = "Użytkownik";
$GLOBALS['strDuplicate'] = "Duplikuj";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "Przenieś do";
$GLOBALS['strDelete'] = "Usuń";
$GLOBALS['strActivate'] = "Aktywuj";
$GLOBALS['strConvert'] = "Konwertuj";
$GLOBALS['strRefresh'] = "Odśwież";
$GLOBALS['strSaveChanges'] = "Zapisz zmiany";
$GLOBALS['strUp'] = "Góra";
$GLOBALS['strDown'] = "Dół";
$GLOBALS['strSave'] = "Zapisz";
$GLOBALS['strCancel'] = "Anuluj";
$GLOBALS['strBack'] = "Wstecz";
$GLOBALS['strPrevious'] = "Poprzedni";
$GLOBALS['strNext'] = "Następny";
$GLOBALS['strYes'] = "Tak";
$GLOBALS['strNo'] = "Nie";
$GLOBALS['strNone'] = "Brak";
$GLOBALS['strCustom'] = "Własne";
$GLOBALS['strDefault'] = "Domyślne";
$GLOBALS['strUnknown'] = "Nieznane";
$GLOBALS['strUnlimited'] = "Nieograniczone";
$GLOBALS['strUntitled'] = "Bez tytułu";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "średnio";
$GLOBALS['strOverall'] = "Ogółem";
$GLOBALS['strTotal'] = "Wszystkie";
$GLOBALS['strFrom'] = "Od";
$GLOBALS['strTo'] = "do";
$GLOBALS['strAdd'] = "Dodaj";
$GLOBALS['strLinkedTo'] = "podłączony do";
$GLOBALS['strDaysLeft'] = "Pozostało dni";
$GLOBALS['strCheckAllNone'] = "Zaznacz wszystkie / żaden";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>R</u>ozwiń wszystkie";
$GLOBALS['strCollapseAll'] = "<u>Z</u>wiń wszystkie";
$GLOBALS['strShowAll'] = "Pokaż Wszystkie";
$GLOBALS['strNoAdminInterface'] = "Interfejs admina został wyłączony na czas przeprowadzenia konserwacji. Nie ma to wpływu na obsługę Twoich kampanii.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "Data 'Od' musi być wcześniejsza niż data 'Do'";
$GLOBALS['strFieldContainsErrors'] = "Następujące pola zawierają błędy:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Zanim przejdziesz dalej musisz";
$GLOBALS['strFieldFixBeforeContinue2'] = "skorygować te błędy.";
$GLOBALS['strMiscellaneous'] = "Różne";
$GLOBALS['strCollectedAllStats'] = "Wszystkie statystyki";
$GLOBALS['strCollectedToday'] = "Dziś";
$GLOBALS['strCollectedYesterday'] = "Wczoraj";
$GLOBALS['strCollectedThisWeek'] = "W tym tygodniu";
$GLOBALS['strCollectedLastWeek'] = "W poprzednim tygodniu";
$GLOBALS['strCollectedThisMonth'] = "W tym miesiącu";
$GLOBALS['strCollectedLastMonth'] = "W poprzednim miesiącu";
$GLOBALS['strCollectedLast7Days'] = "W ciągu ostatnich 7 dni";
$GLOBALS['strCollectedSpecificDates'] = "Określone daty";
$GLOBALS['strValue'] = "Wartość";
$GLOBALS['strWarning'] = "Warning";
$GLOBALS['strNotice'] = "Ogłoszenie";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Panel nawigacyjny nie może zostać wyświetlony";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "kod";
$GLOBALS['strDashboardSystemMessage'] = "Wiadomość systemowa";
$GLOBALS['strDashboardErrorHelp'] = "Jeśli błąd będzie się powtarzał proszę opisz problem szczegółowo na <a href='http://forum.openx.org/'>forum OpenX</a>.";

// Priority
$GLOBALS['strPriority'] = "Priorytet";
$GLOBALS['strPriorityLevel'] = "Poziom priorytetu";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Ograniczenia";

// Properties
$GLOBALS['strName'] = "Nazwa";
$GLOBALS['strSize'] = "Rozmiar";
$GLOBALS['strWidth'] = "Szerokość";
$GLOBALS['strHeight'] = "Wysokość";
$GLOBALS['strTarget'] = "Okno docelowe (np. _self)";
$GLOBALS['strLanguage'] = "Język";
$GLOBALS['strDescription'] = "Opis";
$GLOBALS['strVariables'] = "Zmienne";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Komentarze";

// User access
$GLOBALS['strWorkingAs'] = "Działasz jako";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Działasz jako";
$GLOBALS['strSwitchTo'] = "Przełącz na";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s dla...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "Dodaj użytkownika";
$GLOBALS['strLinkUser_Key'] = "Dodaj <u>u</u>żytkownika";
$GLOBALS['strUsernameToLink'] = "Nazwa użytkownika, który ma być dodany";
$GLOBALS['strNewUserWillBeCreated'] = "Utworzony zostanie nowy użytkownik";
$GLOBALS['strToLinkProvideEmail'] = "Aby dodać użytkownika, podaj jego adres e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Aby dodać użytkownika, podaj jego nazwę";
$GLOBALS['strUserLinkedToAccount'] = "Użytkownik został dodany do konta";
$GLOBALS['strUserAccountUpdated'] = "Konto użytkownika zostało aktualizowane";
$GLOBALS['strUserUnlinkedFromAccount'] = "Użytkownik został usunięty z konta";
$GLOBALS['strUserWasDeleted'] = "Użytkownik został usunięty";
$GLOBALS['strUserNotLinkedWithAccount'] = "Podany użytkownik nie jest podłączony do konta";
$GLOBALS['strCantDeleteOneAdminUser'] = "Nie można usunąć użytkownika. Do konta admina musi być podłączony przynajmniej jeden użytkownik.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Nazwa użytkownika";
$GLOBALS['strLinkUserHelpEmail'] = "adres e-mail";
$GLOBALS['strLastLoggedIn'] = "Ostatnio zalogowany";
$GLOBALS['strDateLinked'] = "Data zlinkowania";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Dostęp użytkownika";
$GLOBALS['strAdminAccess'] = "Dostęp Admina";
$GLOBALS['strUserProperties'] = "Właściwości użytkownika";
$GLOBALS['strPermissions'] = "Uprawnienia";
$GLOBALS['strAuthentification'] = "Autoryzacja";
$GLOBALS['strWelcomeTo'] = "Witamy w";
$GLOBALS['strEnterUsername'] = "Wpisz nazwę użytkownika i hasło, aby się zalogować";
$GLOBALS['strEnterBoth'] = "Wpisz zarówno nazwę użytkownika jak i hasło";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Błąd cookie, zaloguj się ponownie";
$GLOBALS['strLogin'] = "Login";
$GLOBALS['strLogout'] = "Wyloguj";
$GLOBALS['strUsername'] = "Nazwa użytkownika";
$GLOBALS['strPassword'] = "Hasło";
$GLOBALS['strPasswordRepeat'] = "Powtórz hasło";
$GLOBALS['strAccessDenied'] = "Dostęp zabroniony";
$GLOBALS['strUsernameOrPasswordWrong'] = "Niepoprawna nazwa użytkownika i/lub hasło. Spróbuj ponownie.";
$GLOBALS['strPasswordWrong'] = "Hasło jest nieprawidłowe";
$GLOBALS['strNotAdmin'] = "Nie masz odpowiednich uprawnień, aby korzystać z tej funkcji. Możesz zalogować się do innego konta, aby jej użyć. Kliknij <a href='logout.php'>tutaj</a>, aby zalogować się jako inny użytkownik.";
$GLOBALS['strDuplicateClientName'] = "Wpisana nazwa użytkownika już istnieje. Podaj inną nazwę.";
$GLOBALS['strInvalidPassword'] = "The new password is invalid, please use a different password.";
$GLOBALS['strInvalidEmail'] = "Format wiadomości jest niepoprawny, wpisz poprawny adres e-mail.";
$GLOBALS['strNotSamePasswords'] = "The two passwords you supplied are not the same";
$GLOBALS['strRepeatPassword'] = "Repeat Password";
$GLOBALS['strDeadLink'] = "Twój link jest nieprawidłowy.";
$GLOBALS['strNoPlacement'] = "Wybrana Kampania nie istnieje. Sprawdź <a href='{link}'>ten link</a>";
$GLOBALS['strNoAdvertiser'] = "Wybrany Reklamodawca nie istnieje. Sprawdź <a href='{link}'>ten link</a>";

// General advertising
$GLOBALS['strRequests'] = "Próby wywołania";
$GLOBALS['strImpressions'] = "Odsłony";
$GLOBALS['strClicks'] = "Kliknięcia";
$GLOBALS['strConversions'] = "Konwersje";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Kliknięcia ogółem";
$GLOBALS['strTotalConversions'] = "Konwersje ogółem";
$GLOBALS['strDateTime'] = "Data Godzina";
$GLOBALS['strTrackerID'] = "ID trackera";
$GLOBALS['strTrackerName'] = "Nazwa trackera";
$GLOBALS['strTrackerImageTag'] = "Znacznik obrazka";
$GLOBALS['strTrackerJsTag'] = "Znacznik Javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "Banery";
$GLOBALS['strCampaigns'] = "Kampanie";
$GLOBALS['strCampaignID'] = "ID kampanii";
$GLOBALS['strCampaignName'] = "Nazwa kampanii";
$GLOBALS['strCountry'] = "Kraj";
$GLOBALS['strStatsAction'] = "Akcja";
$GLOBALS['strWindowDelay'] = "Opóźnienie okna";
$GLOBALS['strStatsVariables'] = "Zmienne";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Użytkowanie miesięczne";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Data";
$GLOBALS['strDay'] = "Dzień";
$GLOBALS['strDays'] = "Dni";
$GLOBALS['strWeek'] = "Tydzień";
$GLOBALS['strWeeks'] = "Tygodni";
$GLOBALS['strSingleMonth'] = "Miesiąc";
$GLOBALS['strMonths'] = "Miesiący";
$GLOBALS['strDayOfWeek'] = "Dzień tygodnia";


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

$GLOBALS['strHour'] = "godzina";
$GLOBALS['strSeconds'] = "sekund";
$GLOBALS['strMinutes'] = "minut";
$GLOBALS['strHours'] = "godzin";

// Advertiser
$GLOBALS['strClient'] = "Reklamodawca";
$GLOBALS['strClients'] = "Reklamodawcy";
$GLOBALS['strClientsAndCampaigns'] = "Reklamodawcy i Kampanie";
$GLOBALS['strAddClient'] = "Dodaj nowego reklamodawcę";
$GLOBALS['strClientProperties'] = "Właściwości reklamodawcy";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "Obecnie nie istnieją żadni określeni reklamodawcy. Aby utworzyć kampanię najpierw <a href='advertiser-edit.php'> dodaj nowego reklamodawcę</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Czy na pewno chcesz usunąć tego reklamodawcę?";
$GLOBALS['strConfirmDeleteClients'] = "Czy na pewno chcesz usunąć wybranych reklamodawców?";
$GLOBALS['strHideInactive'] = "Hide inactive";
$GLOBALS['strInactiveAdvertisersHidden'] = "ukryci reklamodawcy nieaktywni";
$GLOBALS['strAdvertiserSignup'] = "Podpis reklamodawcy";
$GLOBALS['strAdvertiserCampaigns'] = "Kampanie Reklamodawcy";

// Advertisers properties
$GLOBALS['strContact'] = "Kontakt";
$GLOBALS['strContactName'] = "Dane kontaktowe";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Wyślij raport o kampanii na adres e-mail";
$GLOBALS['strNoDaysBetweenReports'] = "Liczba dni między sporządzaniem raportów o kampanii";
$GLOBALS['strSendDeactivationWarning'] = "Wyślij ostrzeżenie, gdy kampania jest automatycznie aktywowana/dezaktywowana";
$GLOBALS['strAllowClientModifyBanner'] = "Zezwól temu użytkownikowi na modyfikację własnych banerów";
$GLOBALS['strAllowClientDisableBanner'] = "Zezwól temu użytkownikowi na dezaktywowanie własnych banerów";
$GLOBALS['strAllowClientActivateBanner'] = "Zezwól temu użytkownikowi na aktywowanie własnych banerów";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Wyświetlaj tylko jeden baner tego reklamodawcy na danej stronie";
$GLOBALS['strAllowAuditTrailAccess'] = "Zezwól temu użytkownikowi na dostęp do audytu";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

// Campaign
$GLOBALS['strCampaign'] = "Kampania";
$GLOBALS['strCampaigns'] = "Kampanie";
$GLOBALS['strAddCampaign'] = "Dodaj nową kampanię";
$GLOBALS['strAddCampaign_Key'] = "Dodaj <u>n</u>ową kampanię";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Kampanie podłączone";
$GLOBALS['strCampaignProperties'] = "Właściwości kampanii";
$GLOBALS['strCampaignOverview'] = "Przegląd kampanii";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "Obecnie brak kampanii zdefiniowanych dla tego reklamodawcy.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "Czy na pewno chcesz usunąć tę kampanię?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Czy na pewno chcesz usunąć wybrane kampanie?";
$GLOBALS['strShowParentAdvertisers'] = "Pokaż głównych reklamodawców";
$GLOBALS['strHideParentAdvertisers'] = "Ukryj głównych reklamodawców";
$GLOBALS['strHideInactiveCampaigns'] = "Ukryj kampanie nieaktywne";
$GLOBALS['strInactiveCampaignsHidden'] = "ukrytenie kampanie aktywne";
$GLOBALS['strPriorityInformation'] = "Pierwszeństwo w stosunku do innych kampanii";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "Kampania";
$GLOBALS['strHiddenAd'] = "Advertisement";
$GLOBALS['strHiddenAdvertiser'] = "Reklamodawca";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strHiddenWebsite'] = "Strona";
$GLOBALS['strHiddenZone'] = "Strefa";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Poyzcjonowanie wzajemne";
$GLOBALS['strSelectUnselectAll'] = "Zaznacz/ odznacz wszystko";
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
$GLOBALS['strNoWebsitesAndZones'] = "Brak stron i stref";
$GLOBALS['strNoWebsitesAndZonesText'] = "z \"%s\" w nazwie";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Linked";
$GLOBALS['strAvailable'] = "Available";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


// Campaign properties
$GLOBALS['strDontExpire'] = "Kampania nie kończy się o określonej dacie";
$GLOBALS['strActivateNow'] = "Rozpocznij natychmiast";
$GLOBALS['strSetSpecificDate'] = "Set specific date";
$GLOBALS['strLow'] = "Niski";
$GLOBALS['strHigh'] = "Wysoki";
$GLOBALS['strExpirationDate'] = "Data zakończenia";
$GLOBALS['strExpirationDateComment'] = "Kampania wygaśnie z końcem dnia";
$GLOBALS['strActivationDate'] = "Data rozpoczęcia";
$GLOBALS['strActivationDateComment'] = "Kampania rozpocznie się z początkiem dnia";
$GLOBALS['strImpressionsRemaining'] = "Pozostałe odsłony";
$GLOBALS['strClicksRemaining'] = "Pozostałe kliknięcia";
$GLOBALS['strConversionsRemaining'] = "Pozostałe konwersje";
$GLOBALS['strImpressionsBooked'] = "Odsłony zarezerwowane";
$GLOBALS['strClicksBooked'] = "Kliknięcia zarezerwowane";
$GLOBALS['strConversionsBooked'] = "Konwersje zarezerwowane";
$GLOBALS['strCampaignWeight'] = "Waga kampanii";
$GLOBALS['strAnonymous'] = "Ukryj reklamodawcę i strony tej kampanii.";
$GLOBALS['strTargetPerDay'] = "dziennie.";
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
$GLOBALS['strCampaignStatusPending'] = "Oczekuje";
$GLOBALS['strCampaignStatusInactive'] = "Nieaktywna";
$GLOBALS['strCampaignStatusRunning'] = "Aktywna";
$GLOBALS['strCampaignStatusPaused'] = "Wstrzymano";
$GLOBALS['strCampaignStatusAwaiting'] = "Oczekuje";
$GLOBALS['strCampaignStatusExpired'] = "Zakończona";
$GLOBALS['strCampaignStatusApproval'] = "Czeka na akceptację »";
$GLOBALS['strCampaignStatusRejected'] = "Odrzucono";
$GLOBALS['strCampaignStatusAdded'] = "Dodana";
$GLOBALS['strCampaignStatusStarted'] = "Rozpoczęta";
$GLOBALS['strCampaignStatusRestarted'] = "Uruchomiona ponownie";
$GLOBALS['strCampaignStatusDeleted'] = "Usunięta";
$GLOBALS['strCampaignType'] = "Typ kampanii";
$GLOBALS['strType'] = "Typ";
$GLOBALS['strContract'] = "Kontrakt";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Kontrakt";
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
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strTrackers'] = "Trackery";
$GLOBALS['strTrackerPreferences'] = "Ustawienia trackera";
$GLOBALS['strAddTracker'] = "Dodaj nowy tracker";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "Obecnie brak trackerów zdefiniowanych dla tego reklamodawcy.";
$GLOBALS['strConfirmDeleteTrackers'] = "Czy na pewno chcesz usunąć wybrane trackery?";
$GLOBALS['strConfirmDeleteTracker'] = "Czy na pewno chcesz usunąć tracker?";
$GLOBALS['strTrackerProperties'] = "Właściwości trackera";
$GLOBALS['strDefaultStatus'] = "Status domyślny";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strLinkedTrackers'] = "Podłączone trackery";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Odstęp między konwersjami";
$GLOBALS['strUniqueWindow'] = "Odstęp między walidacją zmiennych";
$GLOBALS['strClick'] = "Kliknięcie";
$GLOBALS['strView'] = "Widok";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Typ konwersji";
$GLOBALS['strLinkCampaignsByDefault'] = "Podłącz nowo utworzone kampanie w ramach ustawień domyślnych";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "Baner";
$GLOBALS['strBanners'] = "Banery";
$GLOBALS['strAddBanner'] = "Dodaj nowy baner";
$GLOBALS['strAddBanner_Key'] = "Dodaj <u>n</u>owy baner";
$GLOBALS['strBannerToCampaign'] = "Twoja kampania";
$GLOBALS['strShowBanner'] = "Pokaż baner";
$GLOBALS['strBannerProperties'] = "Właściwości banera";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "Obecnie brak stref zdefiniowanych dla tej strony.";
$GLOBALS['strNoBannersAddCampaign'] = "Obecnie nie istnieją żadne zdefiniowane strony internetowe. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strNoBannersAddAdvertiser'] = "Obecnie nie istnieją żadne zdefiniowane strony internetowe. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strConfirmDeleteBanner'] = "Czy na pewno chcesz usunąć ten baner?";
$GLOBALS['strConfirmDeleteBanners'] = "Czy na pewno chcesz usunąć wybrane banery?";
$GLOBALS['strShowParentCampaigns'] = "Pokaż kampanie nadrzędne";
$GLOBALS['strHideParentCampaigns'] = "Ukryj kampanie nadrzędne";
$GLOBALS['strHideInactiveBanners'] = "Ukryj banery nieaktywne";
$GLOBALS['strInactiveBannersHidden'] = "ukryte banery nieaktywne";
$GLOBALS['strWarningMissing'] = "Uwaga, prawdopodobnie brakuje ";
$GLOBALS['strWarningMissingClosing'] = "znacznika zamykającego '>'";
$GLOBALS['strWarningMissingOpening'] = "znacznika otwierającego '<'";
$GLOBALS['strSubmitAnyway'] = "Pomimo to wyślij";
$GLOBALS['strBannersOfCampaign'] = "w"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Ustawienia banera";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Default Banners";
$GLOBALS['strDefaultBannerUrl'] = "Default Image URL";
$GLOBALS['strDefaultBannerDestination'] = "Docelowy adres URL";
$GLOBALS['strAllowedBannerTypes'] = "Allowed Banner Types";
$GLOBALS['strTypeSqlAllow'] = "Allow SQL Local Banners";
$GLOBALS['strTypeWebAllow'] = "Allow Webserver Local Banners";
$GLOBALS['strTypeUrlAllow'] = "Allow External Banners";
$GLOBALS['strTypeHtmlAllow'] = "Allow HTML Banners";
$GLOBALS['strTypeTxtAllow'] = "Allow Text Ads";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Wybierz typ banera";
$GLOBALS['strMySQLBanner'] = "Banner lokalny (SQL)";
$GLOBALS['strWebBanner'] = "Banner lokalny (Webserver)";
$GLOBALS['strURLBanner'] = "Banner zewnętrzny";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Reklama tekstowa";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "Chcesz zatrzymać <br />istniejący obrazek czy też chcesz <br />dodać inny?";
$GLOBALS['strNewBannerFile'] = "Wybierz obrazek, którego chcesz <br />użyć dla tego banera<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Wybierz obrazek, którego chcesz <br />użyć jeśli przeglądarka />nie obsługuje Rich Media<br /><br />";
$GLOBALS['strNewBannerURL'] = "Adres URL obrazka (dodaj http://)";
$GLOBALS['strURL'] = "Docelowy adres URL (dodaj http://)";
$GLOBALS['strKeyword'] = "Słowa kluczowe";
$GLOBALS['strTextBelow'] = "Tekst pod banerem";
$GLOBALS['strWeight'] = "Waga";
$GLOBALS['strAlt'] = "Tekst Alt";
$GLOBALS['strStatusText'] = "Tekst paska statusu";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Waga banera";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Ogólny baner HTML";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Ogólny";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Opcje dostarczania";
$GLOBALS['strACL'] = "Opcje dostarczania";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "jest równy";
$GLOBALS['strDifferentFrom'] = "jest inny niż";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "jest większe niż";
$GLOBALS['strLessThan'] = "jest mniej niż";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "I";                          // logical operator
$GLOBALS['strOR'] = "LUB";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Wyświetlaj ten baner wyłącznie, gdy:";
$GLOBALS['strWeekDays'] = "Dni robocze";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Źródło";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Zresetuj liczniki po:";
$GLOBALS['strDeliveryCappingTotal'] = "ogółem";
$GLOBALS['strDeliveryCappingSession'] = "na sesję";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Ogranicz wyświetlenia banera do:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Ogranicz wyświetlenia kampanii do:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Ogranicz wyświetlenia stref do:";

// Website
$GLOBALS['strAffiliate'] = "Strona";
$GLOBALS['strAffiliates'] = "Strony";
$GLOBALS['strAffiliatesAndZones'] = "Strony i Strefy";
$GLOBALS['strAddNewAffiliate'] = "Dodaj Stronę";
$GLOBALS['strAffiliateProperties'] = "Właściwości Strony";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "Obecnie nie istnieją żadne zdefiniowane strony internetowe. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strConfirmDeleteAffiliate'] = "Czy na pewno chcesz usunąć tę Stronę?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Czy na pewno chcesz usunąć wybrane strony?";
$GLOBALS['strInactiveAffiliatesHidden'] = "ukryte Strony nieaktywne";
$GLOBALS['strShowParentAffiliates'] = "Pokaż Strony nadrzędne";
$GLOBALS['strHideParentAffiliates'] = "Ukryj Strony nadrzędne";

// Website (properties)
$GLOBALS['strWebsite'] = "Strona";
$GLOBALS['strWebsiteURL'] = "Adres URL strony";
$GLOBALS['strAllowAffiliateModifyZones'] = "Zezwól temu użytkownikowi na modyfikację własnych stref";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Zezwól temu użytkownikowi na łączenie banerów z własnymi strefami";
$GLOBALS['strAllowAffiliateAddZone'] = "Zezwól temu użytkownikowi na definiowanie nowych stref";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Zezwól temu użytkownikowi na usuwanie istniejących stref";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Zezwól temu użytkownikowi na generowanie kodu inwokacyjnego";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Kod pocztowy";
$GLOBALS['strCountry'] = "Kraj";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Strefy Strony";

// Zone
$GLOBALS['strZone'] = "Strefa";
$GLOBALS['strZones'] = "Strefy";
$GLOBALS['strAddNewZone'] = "Dodaj strefę";
$GLOBALS['strAddNewZone_Key'] = "Dodaj <u>n</u>ową strefę";
$GLOBALS['strZoneToWebsite'] = "Brak Stron";
$GLOBALS['strLinkedZones'] = "Przyłączone strefy";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "Właściwości strefy";
$GLOBALS['strZoneHistory'] = "Historia strefy";
$GLOBALS['strNoZones'] = "Obecnie brak stref zdefiniowanych dla tej strony.";
$GLOBALS['strNoZonesAddWebsite'] = "Na obecną chwilę nie określeno żadnych stron internetowych. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strConfirmDeleteZone'] = "Czy na pewno chcesz usunąć tę strefę?";
$GLOBALS['strConfirmDeleteZones'] = "Czy na pewno chcesz usunąć wybrane strefy?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Do tej strefy wciąż podłączone są kampanie, jeśli ją usuniesz, kampanie przestaną działać i nie otrzymasz za nie należności.";
$GLOBALS['strZoneType'] = "Typ strefy";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Button lub Prostokąt";
$GLOBALS['strInterstitial'] = "Interstitial lub Floating DHTML";
$GLOBALS['strPopup'] = "Popup";
$GLOBALS['strTextAdZone'] = "Reklama tekstowa";
$GLOBALS['strEmailAdZone'] = "Strefa E-mail/Biuletyn";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "Pokaż pasujące banery";
$GLOBALS['strHideMatchingBanners'] = "Ukryj pasujące banery";
$GLOBALS['strBannerLinkedAds'] = "Banery podłączone do strefy";
$GLOBALS['strCampaignLinkedAds'] = "Kampanie podłączone do strefy";
$GLOBALS['strInactiveZonesHidden'] = "ukryte strefy nieaktywne";
$GLOBALS['strWarnChangeZoneType'] = "Jeżeli zmienisz strefę na typ tekstowy bądź e-mail, wszystkie banery/kampanie zostaną odłączone z racji restrykcji dla tego typu stref
<ul>
<li>Do stref tekstowych podłączyć można wyłącznie reklamy tekstowe</li>
<li>Kampanie w strefie e-mail mogą w danym czasie posiadać tylko jeden aktywny baner</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Modyfikacja rozmiarów strefy spowoduje odłączenie wszystkich banerów, których rozmiary nie odpowiadają nowym parametrom, oraz dodanie wszystkich banerów o odpowiednich rozmiarach z podłączonych kampanii.';
$GLOBALS['strWarnChangeBannerSize'] = 'Modyfikacja rozmiarów banera spowoduje odłączenie go od stref nie obsługujących nowych rozmiarów. Jeśli <strong>kampania</strong> tego banera jest podłączona do strefy z nowymi rozmiarami, podłączenie banera nastąpi automatycznie';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'w'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Duży Baner (468 x 60 )";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Mały przycisk (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Duży przycisk (120 x 90)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Połowa banera (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Kwadratowy przycisk(125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Prostokąt (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Kwadratowy Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Pionowy Baner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Średni prostokąt (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Duży prostokąt (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Pionowy prostokąt (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Szeroki Skyscraper (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Zaawansowane";
$GLOBALS['strChainSettings'] = "Ustawienia łańcucha";
$GLOBALS['strZoneNoDelivery'] = "Jeśli żaden baner z tej strefy <br />nie może być dostarczony...";
$GLOBALS['strZoneStopDelivery'] = "Zaprzestań dostarczania i nie pokazuj banera";
$GLOBALS['strZoneOtherZone'] = "Wyświetl wybraną strefę w zastępstwie";
$GLOBALS['strZoneAppend'] = "Zawsze dodawaj poniższy kod HTML do banerów wyświetlanych przez tę strefę";
$GLOBALS['strAppendSettings'] = "Ustawienia dodawania";
$GLOBALS['strZonePrependHTML'] = "Zawsze dodawaj ten kod HTML przed odnośnikami tekstowymi wyświetlanymi przez tę strefę";
$GLOBALS['strZoneAppendNoBanner'] = "Dodaj, nawet jeśli baner nie jest dostarczany";
$GLOBALS['strZoneAppendHTMLCode'] = "Kod HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup lub interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Wszystkie banery podłączone do tej strefy są obecnie nieaktywne. <br />Tak wygląda łańcuch strefy, według którego będą ustawione:";
$GLOBALS['strZoneProbNullPri'] = "Do tej strefy nie podłączono żadnych aktywnych banerów.";
$GLOBALS['strZoneProbListChainLoop'] = "Postępowanie zgodnie z łańcuchem stref spowodowałoby kołową pętlę. Dostarczanie z tej strefy zostało wstrzymane.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Wybierz pozycje, które mają być podłączone do tej strefy";
$GLOBALS['strLinkedBanners'] = "Podłącz banery indywidualne";
$GLOBALS['strCampaignDefaults'] = "Podłącz banery wg kampanii nadrzędnej";
$GLOBALS['strLinkedCategories'] = "Podłącz banery wg kategorii";
$GLOBALS['strWithXBanners'] = "%d baner(y)";
$GLOBALS['strRawQueryString'] = "Słowo kluczowe";
$GLOBALS['strIncludedBanners'] = "Podłączone banery";
$GLOBALS['strMatchingBanners'] = "{count} pasujących banerów";
$GLOBALS['strNoCampaignsToLink'] = "Obecnie brak kampanii, które można podłączyć do tej strefy";
$GLOBALS['strNoTrackersToLink'] = "Obecnie brak trackerów, które można podłączyć do tej kampanii";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Obecnie brak stref, do których ta kampania mogłaby zostać podłączona";
$GLOBALS['strSelectBannerToLink'] = "Wybierz baner, który chcesz podłączyć do tej strefy:";
$GLOBALS['strSelectCampaignToLink'] = "Wybierz kampanię, którą chcesz podłączyć do tej strefy:";
$GLOBALS['strSelectAdvertiser'] = "Wybierz reklamodawcę";
$GLOBALS['strSelectPlacement'] = "Wybierz kampanię";
$GLOBALS['strSelectAd'] = "Wybierz baner";
$GLOBALS['strSelectPublisher'] = "Wybierz stronę";
$GLOBALS['strSelectZone'] = "Wybierz strefę (obszar)";
$GLOBALS['strStatusPending'] = "Oczekuje";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Duplikuj";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Typ";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Edytuj statusy";
$GLOBALS['strShortcutShowStatuses'] = "Pokaż statusy";

// Statistics
$GLOBALS['strStats'] = "Statystyki";
$GLOBALS['strNoStats'] = "Nie ma obecnie żadnych statystyk";
$GLOBALS['strNoStatsForPeriod'] = "Obecnie brak statystyk za okres od %s do %s";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Ogółem dla tego okresu";
$GLOBALS['strPublisherDistribution'] = "Dystrybucja Stron";
$GLOBALS['strCampaignDistribution'] = "Dystrybucja kampanii";
$GLOBALS['strViewBreakdown'] = "Kryteria podglądu";
$GLOBALS['strBreakdownByDay'] = "Dzień";
$GLOBALS['strBreakdownByWeek'] = "Tydzień";
$GLOBALS['strBreakdownByMonth'] = "Miesiąc";
$GLOBALS['strBreakdownByDow'] = "Dzień tygodnia";
$GLOBALS['strBreakdownByHour'] = "godzina";
$GLOBALS['strItemsPerPage'] = "Pozycji na stronę";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Pokaż <u>W</u>ykres statystyk";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>ksportuj statystyki do arkusza Excel";
$GLOBALS['strGDnotEnabled'] = "Aby wyświetlać wykresy musisz uruchomić GD w PHP. <br />Na tej stronie <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> uzyskasz więcej informacji oraz dowiesz się jak zainstalować GD na swoim serwerze.";
$GLOBALS['strStatsArea'] = "Obszar";

// Expiration
$GLOBALS['strNoExpiration'] = "Bez daty zakończenia";
$GLOBALS['strEstimated'] = "Szacowana data zakończenia";
$GLOBALS['strNoExpirationEstimation'] = "Obecnie bezterminowo";
$GLOBALS['strDaysAgo'] = "dni temu";
$GLOBALS['strCampaignStop'] = "Zatrzymanie kampanii";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Okres";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Wszyscy reklamodawcy";
$GLOBALS['strAnonAdvertisers'] = "Reklamodawcy anonimowi";
$GLOBALS['strAllPublishers'] = "Wszystkie Strony";
$GLOBALS['strAnonPublishers'] = "Strony anonimowe";
$GLOBALS['strAllAvailZones'] = "Wszystkie dostępne strefy";

// Userlog
$GLOBALS['strUserLog'] = "Log użytkownika";
$GLOBALS['strUserLogDetails'] = "Szczegóły logu użytkownika";
$GLOBALS['strDeleteLog'] = "Usuń log";
$GLOBALS['strAction'] = "Akcja";
$GLOBALS['strNoActionsLogged'] = "Żadne działania nie są zalogowane";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Generuj kod banera";
$GLOBALS['strChooseInvocationType'] = "Wybierz typ kodu wywołującego baner";
$GLOBALS['strGenerate'] = "Generuj";
$GLOBALS['strParameters'] = "Atrybuty znacznika";
$GLOBALS['strFrameSize'] = "Rozmiar ramki";
$GLOBALS['strBannercode'] = "Kod banera";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Wróć do listy raportów";
$GLOBALS['strCharset'] = "Zestaw znaków";
$GLOBALS['strAutoDetect'] = "Automatyczne wykrywanie";
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
$GLOBALS['strNoMatchesFound'] = "Nie znaleziono pasujących elementów";
$GLOBALS['strErrorOccurred'] = "Wystąpił błąd";
$GLOBALS['strErrorDBPlain'] = "Wystąpił błąd podczas wywoływania bazy danych";
$GLOBALS['strErrorDBSerious'] = "Wykryto poważny błąd z bazą danych";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Tabela bazy danych jest prawdopodobnie uszkodzona i wymaga naprawienia. Więcej informacji na temat naprawiania uszkodzonych tabel znajdziesz w <i>Przewodniku administratora</i> w rozdziale <i>Rozwiązywanie problemów</i>.";
$GLOBALS['strErrorDBContact'] = "Poinformuj administratora serwera o zaistniałym problemie.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "Nie można podłączyć banera do strefy, ponieważ:";
$GLOBALS['strUnableToLinkBanner'] = "Nie można podłączyć banera:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "nieprawidłowy format numeru w polu informacji o dochodach";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Błąd w aktualizacji strefy:";
$GLOBALS['strUnableToChangeZone'] = "Nie można wprowadzić tej zmiany, ponieważ:";
$GLOBALS['strDatesConflict'] = "nastąpił konflikt dat:";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Niektóre statystyki nie zostały zaprotokołowane w strefie czasowej UTC (uniwersalny czas koordynowany), wobec czego mogą zostać wyświetlone w nieodpowiedniej strefie czasowej.";
$GLOBALS['strWarningInaccurateReadMore'] = "Dowiedz się więcej na ten temat";
$GLOBALS['strWarningInaccurateReport'] = "Niektóre statystyki w tym raporcie nie zostały zaprotokołowane w strefie czasowej UTC (uniwersalny czas koordynowany), wobec czego mogą zostać wyświetlone w nieodpowiedniej strefie czasowej.";

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
$GLOBALS['strSirMadam'] = "Szanowny/a";
$GLOBALS['strMailSubject'] = "Raport dla reklamodawcy";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Poniżej widnieją statystyki banerów dla {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampania została aktywowana";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampania została dezaktywowana";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Poniższa kampania została dezaktywowana, ponieważ";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Ta kampania jest obecnie nieaktywna, ponieważ";
$GLOBALS['strBeforeActivate'] = "data aktywacji jeszcze nie nadeszła";
$GLOBALS['strAfterExpire'] = "data zakończenia już minęła";
$GLOBALS['strNoMoreImpressions'] = "wszystkie Odsłony zostały wykorzystane";
$GLOBALS['strNoMoreClicks'] = "wszystkie Kliknięcia zostały wykorzystane";
$GLOBALS['strNoMoreConversions'] = "pula Sprzedaży została wyczerpana";
$GLOBALS['strWeightIsNull'] = "jej waga jest ustawiona na zero";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "Nie zarejestrowano żadnych Odsłon w czasie objętym tym raportem";
$GLOBALS['strNoClickLoggedInInterval'] = "Nie zarejestrowano żadnych Kliknięć w czasie objętym tym raportem";
$GLOBALS['strNoConversionLoggedInInterval'] = "Nie zarejestrowano żadnych Konwersji w czasie objętym tym raportem";
$GLOBALS['strMailReportPeriod'] = "Ten raport zawiera statystyki od {startdate} do {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Ten raport zawiera wszystkie statystyki aż do {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Brak statystyk dla tej kampanii";
$GLOBALS['strImpendingCampaignExpiry'] = "Kampania wkrótce wygaśnie";
$GLOBALS['strYourCampaign'] = "Twoja kampania";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampania należy do";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "Wyświetlenia {clientname} wygasają {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "Klientowi {clientname} pozostało mniej niż {limit} wyświetleń";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Priorytet";
$GLOBALS['strSourceEdit'] = "Edytuj źródła";

// Preferences
$GLOBALS['strPreferences'] = "Preferencje";
$GLOBALS['strUserPreferences'] = "Ustawienia użytkownika";
$GLOBALS['strChangePassword'] = "Zmień hasło";
$GLOBALS['strChangeEmail'] = "Zmień adres e-mail";
$GLOBALS['strCurrentPassword'] = "Hasło aktualne";
$GLOBALS['strChooseNewPassword'] = "Wybierz nowe hasło";
$GLOBALS['strReenterNewPassword'] = "Wpisz ponownie nowe hasło";
$GLOBALS['strNameLanguage'] = "Nazwa i język";
$GLOBALS['strAccountPreferences'] = "Ustawienia konta";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Ustawienia raportów e-mail kampanii";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "Ostrzeżenia e-mail administratora";
$GLOBALS['strAgencyEmailWarnings'] = "Ostrzeżenia e-mail agencji";
$GLOBALS['strAdveEmailWarnings'] = "Ostrzeżenia e-mail reklamodawcy";
$GLOBALS['strFullName'] = "Pełna nazwa";
$GLOBALS['strEmailAddress'] = "Adres e-mail";
$GLOBALS['strUserDetails'] = "O użytkowniku";
$GLOBALS['strUserInterfacePreferences'] = "Ustawienia interfejsu użytkownika";
$GLOBALS['strPluginPreferences'] = "Ustawienia wtyczek";
$GLOBALS['strColumnName'] = "Nazwa kolumny";
$GLOBALS['strShowColumn'] = "Pokaż kolumnę";
$GLOBALS['strCustomColumnName'] = "Niestandardowa nazwa kolumny";
$GLOBALS['strColumnRank'] = "Ranga kolumny";

// Long names
$GLOBALS['strRevenue'] = "Dochód";
$GLOBALS['strNumberOfItems'] = "Ilość jednostek";
$GLOBALS['strRevenueCPC'] = "Dochody CPC";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "Konwersje oczekujące";
$GLOBALS['strImpressionSR'] = "Odsłona (współczynnik sprzedaży)";
$GLOBALS['strClickSR'] = "Kliknięcie (współczynnik sprzedaży)";

// Short names
$GLOBALS['strRevenue_short'] = "Doch.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Ilość jedn.";
$GLOBALS['strRevenueCPC_short'] = "Doch. CPC";
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
$GLOBALS['strRequests_short'] = "żąd.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Kliknięcia";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Konw.";
$GLOBALS['strPendingConversions_short'] = "Konw. oczekujące";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Kliknięcie (współczynnik sprzedaży)";

// Global Settings
$GLOBALS['strConfiguration'] = "Konfiguracja";
$GLOBALS['strGlobalSettings'] = "Ustawienia ogólne";
$GLOBALS['strGeneralSettings'] = "Ustawienia ogólne";
$GLOBALS['strMainSettings'] = "Ustawienia główne";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "Aktualizacje produktu";
$GLOBALS['strViewPastUpdates'] = "Zarządzanie poprzednimi aktualizacjami oraz kopiami zapasowymi";
$GLOBALS['strFromVersion'] = "Z wersji";
$GLOBALS['strToVersion'] = "Do wersji";
$GLOBALS['strToggleDataBackupDetails'] = "Przełącz do szczegółów danych kopii zapasowej";
$GLOBALS['strClickViewBackupDetails'] = "kliknij aby zobaczyć szczegóły kopii zapasowej";
$GLOBALS['strClickHideBackupDetails'] = "kliknij aby ukryć szczegóły kopii zapasowej";
$GLOBALS['strShowBackupDetails'] = "Pokaż szczegóły kopii zapasowej danych";
$GLOBALS['strHideBackupDetails'] = "Ukryj szczegóły kopii zapasowej danych";
$GLOBALS['strBackupDeleteConfirm'] = "Czy na pewno chcesz usunąć wszystkie kopie zapasowe utworzone z tego uaktualnienia?";
$GLOBALS['strDeleteArtifacts'] = "Usuń artefakty";
$GLOBALS['strArtifacts'] = "Atrefakty";
$GLOBALS['strBackupDbTables'] = "Kopia zapasowa tabel bazy danych";
$GLOBALS['strLogFiles'] = "Pliki protokołowania";
$GLOBALS['strConfigBackups'] = "Konfiguracja kopii zapasowych";
$GLOBALS['strUpdatedDbVersionStamp'] = "Zaktualizowano wersję znaczka bazy danych";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "AKTUALIZACJA ZAKOŃCZONA";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "AKTUALIZACJA NIE POWIOD�?A SIĘ";

// Agency
$GLOBALS['strAgencyManagement'] = "Zarządzanie kontem";
$GLOBALS['strAgency'] = "Konto";
$GLOBALS['strAddAgency'] = "Dodaj nowe konto";
$GLOBALS['strAddAgency_Key'] = "Dodaj <u>n</u>owe konto";
$GLOBALS['strTotalAgencies'] = "Wszystkie konta";
$GLOBALS['strAgencyProperties'] = "Ustawienia konta";
$GLOBALS['strNoAgencies'] = "Obecnie brak zdefiniowanych kont";
$GLOBALS['strConfirmDeleteAgency'] = "Czy na pewno chcesz usunąć konto?";
$GLOBALS['strHideInactiveAgencies'] = "Ukryj konta nieaktywne";
$GLOBALS['strInactiveAgenciesHidden'] = "ukryte konta nieaktywne";
$GLOBALS['strSwitchAccount'] = "Zmień konto";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "Nieaktywna";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "Brak Stron";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Opcje dostarczania";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'w'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Nazwa zmiennej";
$GLOBALS['strVariableDescription'] = "Opis";
$GLOBALS['strVariableDataType'] = "Wyświetlanie daty";
$GLOBALS['strVariablePurpose'] = "Cel";
$GLOBALS['strGeneric'] = "Ogólny";
$GLOBALS['strBasketValue'] = "Wartość koszyka";
$GLOBALS['strNumItems'] = "Ilość jednostek";
$GLOBALS['strVariableIsUnique'] = "Usunąć duplikaty konwersji?";
$GLOBALS['strNumber'] = "Numer";
$GLOBALS['strString'] = "Ciąg";
$GLOBALS['strTrackFollowingVars'] = "Śledzenie następującej zmiennej";
$GLOBALS['strAddVariable'] = "Dodaj zmienną";
$GLOBALS['strNoVarsToTrack'] = "Brak zmiennych do śledzenia.";
$GLOBALS['strVariableRejectEmpty'] = "Odrzuć jeśli puste?";
$GLOBALS['strTrackingSettings'] = "Ustawienia śledzenia";
$GLOBALS['strTrackerType'] = "Typ trackera";
$GLOBALS['strTrackerTypeJS'] = "Śledzenie zmiennych JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "Śledzenie zmiennych JavaScript (kompatybilne wstecznie, wymaga dostosowania)";
$GLOBALS['strTrackerTypeDOM'] = "Śledź elementy HTML używając DOM";
$GLOBALS['strTrackerTypeCustom'] = "Dowolny kod JS";
$GLOBALS['strVariableCode'] = "Kod śledzenia JavaScript";

// Password recovery
$GLOBALS['strForgotPassword'] = "Nie pamiętasz hasła?";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "Adres e-mail jest obligatoryjny";
$GLOBALS['strPwdRecWrongId'] = "ID niepoprawne";
$GLOBALS['strPwdRecEnterEmail'] = "Wprowadź adres e-mail poniżej";
$GLOBALS['strPwdRecEnterPassword'] = "Wprowadź nowe hasło poniżej";
$GLOBALS['strProceed'] = "Proceed >";
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
$GLOBALS['strAdditionalItems'] = "oraz dodatkowych pozycji";
$GLOBALS['strFor'] = "dla";
$GLOBALS['strHas'] = "has";
$GLOBALS['strBinaryData'] = "Dane binarne";
$GLOBALS['strAuditTrailDisabled'] = "Opcja Audyt została wyłączona przez administratora . W następstwie nie zalogowano żadnych kolejnych zdarzeń do wyświetlenia na liście Audytu.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Użytkownik nie był aktywny we wskazanym okresie czasu.";
$GLOBALS['strAuditTrail'] = "Audyt";
$GLOBALS['strAuditTrailSetup'] = "Ustaw Audyt na dziś";
$GLOBALS['strAuditTrailGoTo'] = "Przejdź do strony Audytu";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Przejdź do strony Kampanii";
$GLOBALS['strCampaignSetUp'] = "Rozpocznij dziś kampanię";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Brak danych o kampaniach do wyświetlenia.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Żadna kampania nie rozpoczęła się ani nie dobiegła końca we wskazanym okresie";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktywuj opcję Audyt, aby uruchomić podgląd Kampanii";

$GLOBALS['strUnsavedChanges'] = "Nie zapisałeś zmian na tej stronie. Pamiętaj, aby nacisnąć przycisk \"Zapisz zmiany\" kiedy skończysz.";
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
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";
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
