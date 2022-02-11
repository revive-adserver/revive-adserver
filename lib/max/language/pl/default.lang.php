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

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['month_format'] = "%m/%Y";
$GLOBALS['day_format'] = "%d/%m";
$GLOBALS['week_format'] = "%W/%Y";
$GLOBALS['weekiso_format'] = "%V/%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Główna";
$GLOBALS['strHelp'] = "Pomoc";
$GLOBALS['strStartOver'] = "Zacznij od początku";
$GLOBALS['strShortcuts'] = "Skróty";
$GLOBALS['strActions'] = "Operacje";
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
$GLOBALS['strCompact'] = "Skrócone";
$GLOBALS['strUser'] = "Użytkownik";
$GLOBALS['strDuplicate'] = "Duplikuj";
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
$GLOBALS['strAll'] = "wszystkie";
$GLOBALS['strAverage'] = "średnio";
$GLOBALS['strOverall'] = "Ogółem";
$GLOBALS['strTotal'] = "Wszystkie";
$GLOBALS['strFrom'] = "Od";
$GLOBALS['strTo'] = "do";
$GLOBALS['strAdd'] = "Dodaj";
$GLOBALS['strLinkedTo'] = "podłączony do";
$GLOBALS['strDaysLeft'] = "Pozostało dni";
$GLOBALS['strCheckAllNone'] = "Zaznacz wszystkie / żaden";
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
$GLOBALS['strWarning'] = "Uwaga";
$GLOBALS['strNotice'] = "Ogłoszenie";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Panel nawigacyjny nie może zostać wyświetlony";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "kod";
$GLOBALS['strDashboardSystemMessage'] = "Wiadomość systemowa";
$GLOBALS['strDashboardErrorHelp'] = "Jeśli błąd będzie się powtarzał proszę opisz problem szczegółowo na <a href='http://forum.openx.org/'>forum OpenX</a>.";

// Priority
$GLOBALS['strPriority'] = "Priorytet";
$GLOBALS['strPriorityLevel'] = "Poziom priorytetu";
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
$GLOBALS['strComments'] = "Komentarze";

// User access
$GLOBALS['strWorkingAs'] = "Działasz jako";
$GLOBALS['strWorkingAs'] = "Działasz jako";
$GLOBALS['strSwitchTo'] = "Przełącz na";
$GLOBALS['strWorkingFor'] = "%s dla...";
$GLOBALS['strLinkUser'] = "Dodaj użytkownika";
$GLOBALS['strLinkUser_Key'] = "Dodaj <u>u</u>żytkownika";
$GLOBALS['strUsernameToLink'] = "Nazwa użytkownika, który ma być dodany";
$GLOBALS['strNewUserWillBeCreated'] = "Utworzony zostanie nowy użytkownik";
$GLOBALS['strToLinkProvideEmail'] = "Aby dodać użytkownika, podaj jego adres e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Aby dodać użytkownika, podaj jego nazwę";
$GLOBALS['strUserAccountUpdated'] = "Konto użytkownika zostało aktualizowane";
$GLOBALS['strUserWasDeleted'] = "Użytkownik został usunięty";
$GLOBALS['strUserNotLinkedWithAccount'] = "Podany użytkownik nie jest podłączony do konta";
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
$GLOBALS['strEnableCookies'] = "Przed rozpoczęciem korzystania z {$PRODUCT_NAME} należy aktywować pliki cookie";
$GLOBALS['strSessionIDNotMatch'] = "Błąd cookie, zaloguj się ponownie";
$GLOBALS['strLogout'] = "Wyloguj";
$GLOBALS['strUsername'] = "Nazwa użytkownika";
$GLOBALS['strPassword'] = "Hasło";
$GLOBALS['strPasswordRepeat'] = "Powtórz hasło";
$GLOBALS['strAccessDenied'] = "Dostęp zabroniony";
$GLOBALS['strUsernameOrPasswordWrong'] = "Niepoprawna nazwa użytkownika i/lub hasło. Spróbuj ponownie.";
$GLOBALS['strPasswordWrong'] = "Hasło jest nieprawidłowe";
$GLOBALS['strNotAdmin'] = "Nie masz odpowiednich uprawnień, aby korzystać z tej funkcji. Możesz zalogować się do innego konta, aby jej użyć. Kliknij <a href='logout.php'>tutaj</a>, aby zalogować się jako inny użytkownik.";
$GLOBALS['strDuplicateClientName'] = "Wpisana nazwa użytkownika już istnieje. Podaj inną nazwę.";
$GLOBALS['strInvalidEmail'] = "Format wiadomości jest niepoprawny, wpisz poprawny adres e-mail.";
$GLOBALS['strDeadLink'] = "Twój link jest nieprawidłowy.";
$GLOBALS['strNoPlacement'] = "Wybrana Kampania nie istnieje. Sprawdź <a href='{link}'>ten link</a>";
$GLOBALS['strNoAdvertiser'] = "Wybrany Reklamodawca nie istnieje. Sprawdź <a href='{link}'>ten link</a>";

// General advertising
$GLOBALS['strRequests'] = "Próby wywołania";
$GLOBALS['strImpressions'] = "Odsłony";
$GLOBALS['strClicks'] = "Kliknięcia";
$GLOBALS['strConversions'] = "Konwersje";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Kliknięcia ogółem";
$GLOBALS['strTotalConversions'] = "Konwersje ogółem";
$GLOBALS['strDateTime'] = "Data Godzina";
$GLOBALS['strTrackerID'] = "ID trackera";
$GLOBALS['strTrackerName'] = "Nazwa trackera";
$GLOBALS['strTrackerImageTag'] = "Znacznik obrazka";
$GLOBALS['strTrackerJsTag'] = "Znacznik Javascript";
$GLOBALS['strBanners'] = "Banery";
$GLOBALS['strCampaigns'] = "Kampanie";
$GLOBALS['strCampaignID'] = "ID kampanii";
$GLOBALS['strCampaignName'] = "Nazwa kampanii";
$GLOBALS['strCountry'] = "Kraj";
$GLOBALS['strStatsAction'] = "Akcja";
$GLOBALS['strWindowDelay'] = "Opóźnienie okna";
$GLOBALS['strStatsVariables'] = "Zmienne";

// Finance
$GLOBALS['strFinanceMT'] = "Użytkowanie miesięczne";

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
    $GLOBALS['strDayFullNames'] = [];
}

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'Ni';
$GLOBALS['strDayShortCuts'][1] = 'Po';
$GLOBALS['strDayShortCuts'][2] = 'Wt';
$GLOBALS['strDayShortCuts'][3] = 'Śr';
$GLOBALS['strDayShortCuts'][4] = 'Cz';
$GLOBALS['strDayShortCuts'][5] = 'Pt';
$GLOBALS['strDayShortCuts'][6] = 'So';

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
$GLOBALS['strNoClients'] = "Obecnie nie istnieją żadni określeni reklamodawcy. Aby utworzyć kampanię najpierw <a href='advertiser-edit.php'> dodaj nowego reklamodawcę</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Czy na pewno chcesz usunąć tego reklamodawcę?";
$GLOBALS['strConfirmDeleteClients'] = "Czy na pewno chcesz usunąć wybranych reklamodawców?";
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
$GLOBALS['strAdvertiserLimitation'] = "Wyświetlaj tylko jeden baner tego reklamodawcy na danej stronie";
$GLOBALS['strAllowAuditTrailAccess'] = "Zezwól temu użytkownikowi na dostęp do audytu";

// Campaign
$GLOBALS['strCampaign'] = "Kampania";
$GLOBALS['strCampaigns'] = "Kampanie";
$GLOBALS['strAddCampaign'] = "Dodaj nową kampanię";
$GLOBALS['strAddCampaign_Key'] = "Dodaj <u>n</u>ową kampanię";
$GLOBALS['strLinkedCampaigns'] = "Kampanie podłączone";
$GLOBALS['strCampaignProperties'] = "Właściwości kampanii";
$GLOBALS['strCampaignOverview'] = "Przegląd kampanii";
$GLOBALS['strNoCampaigns'] = "Obecnie brak kampanii zdefiniowanych dla tego reklamodawcy.";
$GLOBALS['strConfirmDeleteCampaign'] = "Czy na pewno chcesz usunąć tę kampanię?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Czy na pewno chcesz usunąć wybrane kampanie?";
$GLOBALS['strShowParentAdvertisers'] = "Pokaż głównych reklamodawców";
$GLOBALS['strHideParentAdvertisers'] = "Ukryj głównych reklamodawców";
$GLOBALS['strHideInactiveCampaigns'] = "Ukryj kampanie nieaktywne";
$GLOBALS['strInactiveCampaignsHidden'] = "ukrytenie kampanie aktywne";
$GLOBALS['strPriorityInformation'] = "Pierwszeństwo w stosunku do innych kampanii";
$GLOBALS['strHiddenCampaign'] = "Kampania";
$GLOBALS['strHiddenAdvertiser'] = "Reklamodawca";
$GLOBALS['strHiddenWebsite'] = "Strona";
$GLOBALS['strHiddenZone'] = "Strefa";
$GLOBALS['strCompanionPositioning'] = "Poyzcjonowanie wzajemne";
$GLOBALS['strSelectUnselectAll'] = "Zaznacz/ odznacz wszystko";

// Campaign-zone linking page
$GLOBALS['strNoWebsitesAndZones'] = "Brak stron i stref";
$GLOBALS['strNoWebsitesAndZonesText'] = "z \"%s\" w nazwie";


// Campaign properties
$GLOBALS['strDontExpire'] = "Kampania nie kończy się o określonej dacie";
$GLOBALS['strActivateNow'] = "Rozpocznij natychmiast";
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
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Kampania została ustwiona jako pozostała,
jednak jej waga jest równa zeru bądź nie została
sprecyzowana. Spowoduje to dezaktywację
kampanii. Banery będą dostarczane dopiero
po wprowadzeniu wartości w formacie liczby.

Czy na pewno chcesz kontynuować?";
$GLOBALS['strCampaignWarningNoTarget'] = "Kampania została ustwiona jako Kontrakt,
jednak dzienny limit nie został
sprecyzowany. Spowoduje to dezaktywację
kampanii. Banery będą dostarczane dopiero
po wprowadzeniu dziennego limitu.

Czy na pewno chcesz kontynuować?";
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
$GLOBALS['strStandardContract'] = "Kontrakt";

// Tracker
$GLOBALS['strTrackers'] = "Trackery";
$GLOBALS['strTrackerPreferences'] = "Ustawienia trackera";
$GLOBALS['strAddTracker'] = "Dodaj nowy tracker";
$GLOBALS['strNoTrackers'] = "Obecnie brak trackerów zdefiniowanych dla tego reklamodawcy.";
$GLOBALS['strConfirmDeleteTrackers'] = "Czy na pewno chcesz usunąć wybrane trackery?";
$GLOBALS['strConfirmDeleteTracker'] = "Czy na pewno chcesz usunąć tracker?";
$GLOBALS['strTrackerProperties'] = "Właściwości trackera";
$GLOBALS['strDefaultStatus'] = "Status domyślny";
$GLOBALS['strLinkedTrackers'] = "Podłączone trackery";
$GLOBALS['strConversionWindow'] = "Odstęp między konwersjami";
$GLOBALS['strUniqueWindow'] = "Odstęp między walidacją zmiennych";
$GLOBALS['strClick'] = "Kliknięcie";
$GLOBALS['strView'] = "Widok";
$GLOBALS['strImpression'] = "Odsłona";
$GLOBALS['strConversionType'] = "Typ konwersji";
$GLOBALS['strLinkCampaignsByDefault'] = "Podłącz nowo utworzone kampanie w ramach ustawień domyślnych";

// Banners (General)
$GLOBALS['strBanner'] = "Baner";
$GLOBALS['strBanners'] = "Banery";
$GLOBALS['strAddBanner'] = "Dodaj nowy baner";
$GLOBALS['strAddBanner_Key'] = "Dodaj <u>n</u>owy baner";
$GLOBALS['strBannerToCampaign'] = "Twoja kampania";
$GLOBALS['strShowBanner'] = "Pokaż baner";
$GLOBALS['strBannerProperties'] = "Właściwości banera";
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
$GLOBALS['strDefaultBannerDestination'] = "Docelowy adres URL";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Wybierz typ banera";
$GLOBALS['strMySQLBanner'] = "Banner lokalny (SQL)";
$GLOBALS['strWebBanner'] = "Banner lokalny (Webserver)";
$GLOBALS['strURLBanner'] = "Banner zewnętrzny";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Reklama tekstowa";
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
$GLOBALS['strBannerWeight'] = "Waga banera";
$GLOBALS['strAdserverTypeGeneric'] = "Ogólny baner HTML";
$GLOBALS['strGenericOutputAdServer'] = "Ogólny";

// Banner (advanced)

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Opcje dostarczania";
$GLOBALS['strACL'] = "Opcje dostarczania";
$GLOBALS['strEqualTo'] = "jest równy";
$GLOBALS['strDifferentFrom'] = "jest inny niż";
$GLOBALS['strLaterThan'] = "jest później niż";
$GLOBALS['strLaterThanOrEqual'] = "jest później lub równocześnie z";
$GLOBALS['strEarlierThan'] = "jest wcześniej niż";
$GLOBALS['strEarlierThanOrEqual'] = "jest wcześniej lub równoczesnie z";
$GLOBALS['strGreaterThan'] = "jest większe niż";
$GLOBALS['strLessThan'] = "jest mniej niż";
$GLOBALS['strAND'] = "I";                          // logical operator
$GLOBALS['strOR'] = "LUB";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Wyświetlaj ten baner wyłącznie, gdy:";
$GLOBALS['strWeekDays'] = "Dni robocze";
$GLOBALS['strTime'] = "Czas";
$GLOBALS['strDomain'] = "Domena";
$GLOBALS['strSource'] = "Źródło";
$GLOBALS['strBrowser'] = "Przeglądarka";
$GLOBALS['strOS'] = "System";

$GLOBALS['strDeliveryCappingReset'] = "Zresetuj liczniki po:";
$GLOBALS['strDeliveryCappingTotal'] = "ogółem";
$GLOBALS['strDeliveryCappingSession'] = "na sesję";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['limit'] = "Ogranicz wyświetlenia banera do:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['limit'] = "Ogranicz wyświetlenia kampanii do:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['limit'] = "Ogranicz wyświetlenia stref do:";

// Website
$GLOBALS['strAffiliate'] = "Strona";
$GLOBALS['strAffiliates'] = "Strony";
$GLOBALS['strAffiliatesAndZones'] = "Strony i Strefy";
$GLOBALS['strAddNewAffiliate'] = "Dodaj Stronę";
$GLOBALS['strAffiliateProperties'] = "Właściwości Strony";
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
$GLOBALS['strTextAdZone'] = "Reklama tekstowa";
$GLOBALS['strEmailAdZone'] = "Strefa E-mail/Biuletyn";
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
$GLOBALS['strZonesOfWebsite'] = 'w'; //this is added between page name and website name eg. 'Zones in www.example.com'

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Duży Baner (468 x 60 )";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Mały przycisk (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Duży przycisk (120 x 90)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Połowa banera (234 x 60)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Kwadratowy przycisk(125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Prostokąt (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Kwadratowy Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Pionowy Baner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Średni prostokąt (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Duży prostokąt (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Pionowy prostokąt (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Szeroki Skyscraper (160 x 600)";

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
$GLOBALS['strStatusApproved'] = "Zatwierdzono";
$GLOBALS['strStatusDisapproved'] = "Odrzucono";
$GLOBALS['strStatusDuplicate'] = "Duplikuj";
$GLOBALS['strStatusOnHold'] = "Zatrzymano";
$GLOBALS['strStatusIgnore'] = "Ignoruj";
$GLOBALS['strConnectionType'] = "Typ";
$GLOBALS['strConnTypeSale'] = "Sprzedaż";
$GLOBALS['strConnTypeSignUp'] = "Rejestracja";
$GLOBALS['strShortcutEditStatuses'] = "Edytuj statusy";
$GLOBALS['strShortcutShowStatuses'] = "Pokaż statusy";

// Statistics
$GLOBALS['strStats'] = "Statystyki";
$GLOBALS['strNoStats'] = "Nie ma obecnie żadnych statystyk";
$GLOBALS['strNoStatsForPeriod'] = "Obecnie brak statystyk za okres od %s do %s";
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
$GLOBALS['strStartDate'] = "Data rozpoczęcia";
$GLOBALS['strEndDate'] = "Data zakończenia";
$GLOBALS['strPeriod'] = "Okres";
$GLOBALS['strWorksheets'] = "Arkusze";

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
$GLOBALS['strBackToTheList'] = "Wróć do listy raportów";
$GLOBALS['strCharset'] = "Zestaw znaków";
$GLOBALS['strAutoDetect'] = "Automatyczne wykrywanie";

// Errors
$GLOBALS['strNoMatchesFound'] = "Nie znaleziono pasujących elementów";
$GLOBALS['strErrorOccurred'] = "Wystąpił błąd";
$GLOBALS['strErrorDBPlain'] = "Wystąpił błąd podczas wywoływania bazy danych";
$GLOBALS['strErrorDBSerious'] = "Wykryto poważny błąd z bazą danych";
$GLOBALS['strErrorDBNoDataPlain'] = "Problem z bazą danych uniemożliwił {$PRODUCT_NAME}  odczytanie i zachowanie danych.";
$GLOBALS['strErrorDBNoDataSerious'] = "Poważny problem z bazą danych uniemożliwił {$PRODUCT_NAME}  odczytanie danych";
$GLOBALS['strErrorDBCorrupt'] = "Tabela bazy danych jest prawdopodobnie uszkodzona i wymaga naprawienia. Więcej informacji na temat naprawiania uszkodzonych tabel znajdziesz w <i>Przewodniku administratora</i> w rozdziale <i>Rozwiązywanie problemów</i>.";
$GLOBALS['strErrorDBContact'] = "Poinformuj administratora serwera o zaistniałym problemie.";
$GLOBALS['strErrorDBSubmitBug'] = "Jeśli ten problem pojawia się wielkorotnie, może być spowodowany błędem MAX_PRODUCT_NAME. Prosimy o przekazanie poniższych informacji twórcom {$PRODUCT_NAME}. Pomocne jest dokładne opisanie działań, które doprowadziły do pojawienia się tego błędu.";
$GLOBALS['strMaintenanceNotActive'] = "Skrypt konserwacyjny nie był uruchomiony w ciągu ostatnich 24 godzin.
Aby {$PRODUCT_NAME} funkcjonował poprawnie, skrypt ten musi być uruchamiany co godzinę.

Zapoznaj się z Przewodnikiem administratora, gdzie uzyskasz więcej informacji
na temat konfiguracji skryptu konserwacyjnego.";
$GLOBALS['strErrorLinkingBanner'] = "Nie można podłączyć banera do strefy, ponieważ:";
$GLOBALS['strUnableToLinkBanner'] = "Nie można podłączyć banera:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "nieprawidłowy format numeru w polu informacji o dochodach";
$GLOBALS['strErrorEditingZone'] = "Błąd w aktualizacji strefy:";
$GLOBALS['strUnableToChangeZone'] = "Nie można wprowadzić tej zmiany, ponieważ:";
$GLOBALS['strDatesConflict'] = "nastąpił konflikt dat:";
$GLOBALS['strEmailNoDates'] = "Kampanie w strefie typu e-mail muszą być opatrzone datą rozpoczęcia i zakończenia";
$GLOBALS['strWarningInaccurateStats'] = "Niektóre statystyki nie zostały zaprotokołowane w strefie czasowej UTC (uniwersalny czas koordynowany), wobec czego mogą zostać wyświetlone w nieodpowiedniej strefie czasowej.";
$GLOBALS['strWarningInaccurateReadMore'] = "Dowiedz się więcej na ten temat";
$GLOBALS['strWarningInaccurateReport'] = "Niektóre statystyki w tym raporcie nie zostały zaprotokołowane w strefie czasowej UTC (uniwersalny czas koordynowany), wobec czego mogą zostać wyświetlone w nieodpowiedniej strefie czasowej.";

//Validation

// Email
$GLOBALS['strSirMadam'] = "Szanowny/a";
$GLOBALS['strMailSubject'] = "Raport dla reklamodawcy";
$GLOBALS['strMailHeader'] = "Drogi {contact},";
$GLOBALS['strMailBannerStats'] = "Poniżej widnieją statystyki banerów dla {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampania została aktywowana";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampania została dezaktywowana";
$GLOBALS['strMailBannerActivated'] = "Poniższa kampania została aktywowana, ponieważ nadeszła data jej aktywacji.";
$GLOBALS['strMailBannerDeactivated'] = "Poniższa kampania została dezaktywowana, ponieważ";
$GLOBALS['strMailFooter'] = "Z poważaniem,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Ta kampania jest obecnie nieaktywna, ponieważ";
$GLOBALS['strBeforeActivate'] = "data aktywacji jeszcze nie nadeszła";
$GLOBALS['strAfterExpire'] = "data zakończenia już minęła";
$GLOBALS['strNoMoreImpressions'] = "wszystkie Odsłony zostały wykorzystane";
$GLOBALS['strNoMoreClicks'] = "wszystkie Kliknięcia zostały wykorzystane";
$GLOBALS['strNoMoreConversions'] = "pula Sprzedaży została wyczerpana";
$GLOBALS['strWeightIsNull'] = "jej waga jest ustawiona na zero";
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
$GLOBALS['strImpendingCampaignExpiryBody'] = "W rezultacie kampania zostanie wkrótce automatycznie dezaktywowana,
podobnie jak i banery do niej przynależące.";

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
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strPendingConversions'] = "Konwersje oczekujące";
$GLOBALS['strImpressionSR'] = "Odsłona (współczynnik sprzedaży)";
$GLOBALS['strClickSR'] = "Kliknięcie (współczynnik sprzedaży)";

// Short names
$GLOBALS['strRevenue_short'] = "Doch.";
$GLOBALS['strNumberOfItems_short'] = "Ilość jedn.";
$GLOBALS['strRevenueCPC_short'] = "Doch. CPC";
$GLOBALS['strRequests_short'] = "żąd.";
$GLOBALS['strClicks_short'] = "Kliknięcia";
$GLOBALS['strConversions_short'] = "Konw.";
$GLOBALS['strPendingConversions_short'] = "Konw. oczekujące";
$GLOBALS['strClickSR_short'] = "Kliknięcie (współczynnik sprzedaży)";

// Global Settings
$GLOBALS['strConfiguration'] = "Konfiguracja";
$GLOBALS['strGlobalSettings'] = "Ustawienia ogólne";
$GLOBALS['strGeneralSettings'] = "Ustawienia ogólne";
$GLOBALS['strMainSettings'] = "Ustawienia główne";
$GLOBALS['strPlugins'] = "Moduły dodatkowe";
$GLOBALS['strChooseSection'] = 'Wybierz sekcję';

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
$GLOBALS['strAgencyStatusInactive'] = "Nieaktywna";

// Channels
$GLOBALS['strChannelToWebsite'] = "Brak Stron";
$GLOBALS['strChannelLimitations'] = "Opcje dostarczania";
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
$GLOBALS['strEmailRequired'] = "Adres e-mail jest obligatoryjny";
$GLOBALS['strPwdRecEnterEmail'] = "Wprowadź adres e-mail poniżej";
$GLOBALS['strPwdRecEnterPassword'] = "Wprowadź nowe hasło poniżej";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strAdditionalItems'] = "oraz dodatkowych pozycji";
$GLOBALS['strFor'] = "dla";
$GLOBALS['strBinaryData'] = "Dane binarne";
$GLOBALS['strAuditTrailDisabled'] = "Opcja Audyt została wyłączona przez administratora . W następstwie nie zalogowano żadnych kolejnych zdarzeń do wyświetlenia na liście Audytu.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Użytkownik nie był aktywny we wskazanym okresie czasu.";
$GLOBALS['strAuditTrail'] = "Audyt";
$GLOBALS['strAuditTrailSetup'] = "Ustaw Audyt na dziś";
$GLOBALS['strAuditTrailGoTo'] = "Przejdź do strony Audytu";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audyt pozwala zobaczyć kto i kiedy wykonał jakie operacje. Innymi słowy, monitoruje zmiany wprowadzane w {$PRODUCT_NAME}</li>
<li>Widzisz tę wiadomość, ponieważ nie aktywowałeś opcji Audyt</li>
<li>Chcesz dowiedzieć się więcej? Zapoznaj się z <a href='{$PRODUCT_DOCSURL}/settings/auditTrail' class='site-link' target='help' >dokumentacją o Audycie</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Przejdź do strony Kampanii";
$GLOBALS['strCampaignSetUp'] = "Rozpocznij dziś kampanię";
$GLOBALS['strCampaignNoRecords'] = "<li>Kampanie pozwalają Ci grupować dowolną ilość banerów reklamowych dowolnego rodzaju odpowiadających kryteriom klienta.<li><li>Grupując banery zaoszczędzisz czas. Nie będziesz musiał wybierać ustawień dostarczania dla każdego banera z osobna</li><li>Więcej informacji uzyskasz w <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/inventory/advertisersAndCampaigns/campaigns'>Dokumentacji o Kampaniach</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Brak danych o kampaniach do wyświetlenia.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Żadna kampania nie rozpoczęła się ani nie dobiegła końca we wskazanym okresie";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Aby zobaczyć kampanie, które rozpoczęły się bądź dobiegły końca we wskazanym okresie, musisz uaktywnić opcję Audyt</li>	        <li>Ten komunikat został wyświetlony, ponieważ Audyt nie został aktywowany<li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktywuj opcję Audyt, aby uruchomić podgląd Kampanii";

$GLOBALS['strUnsavedChanges'] = "Nie zapisałeś zmian na tej stronie. Pamiętaj, aby nacisnąć przycisk \"Zapisz zmiany\" kiedy skończysz.";

//confirmation messages










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
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
