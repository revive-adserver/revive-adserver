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
$GLOBALS['phpAds_TextDirection']  		= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";

$GLOBALS['phpAds_DecimalPoint']			= ',';
$GLOBALS['phpAds_ThousandsSeperator']		= '.';


// Date & time configuration
$GLOBALS['date_format']				= "%d/%m/%Y";
$GLOBALS['time_format']				= "%H:%M:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%m/%Y";
$GLOBALS['day_format']				= "%d/%m";
$GLOBALS['week_format']				= "%W/%Y";
$GLOBALS['weekiso_format']			= "%V/%G";



/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome'] 				= "Główna";
$GLOBALS['strHelp']				= "Pomoc";
$GLOBALS['strNavigation'] 			= "Nawigacja";
$GLOBALS['strShortcuts'] 			= "Skróty";
$GLOBALS['strAdminstration'] 			= "Inwentarz";
$GLOBALS['strMaintenance']			= "Konserwacja";
$GLOBALS['strProbability']			= "Prawdopodobieństwo";
$GLOBALS['strInvocationcode']			= "Kod wywołujący";
$GLOBALS['strBasicInformation'] 		= "Podstawowe Informacje";
$GLOBALS['strContractInformation'] 		= "Informacje kontraktowe";
$GLOBALS['strLoginInformation'] 		= "Dane logowania";
$GLOBALS['strOverview']				= "Podgląd";
$GLOBALS['strSearch']				= "<u>S</u>zukaj";
$GLOBALS['strHistory']				= "Historia";
$GLOBALS['strPreferences'] 			= "Preferencje";
$GLOBALS['strDetails']				= "Szczegóły";
$GLOBALS['strCompact']				= "Skrócone";
$GLOBALS['strVerbose']				= "Rozszerzone";
$GLOBALS['strUser']				= "Użytkownik";
$GLOBALS['strEdit']				= "Edycja";
$GLOBALS['strCreate']				= "Utwórz";
$GLOBALS['strDuplicate']			= "Duplikuj";
$GLOBALS['strMoveTo']				= "Przenieś do";
$GLOBALS['strDelete'] 				= "Usuń";
$GLOBALS['strActivate']				= "Aktywuj";
$GLOBALS['strDeActivate'] 			= "Deaktywuj";
$GLOBALS['strConvert']				= "Konwertuj";
$GLOBALS['strRefresh']				= "Odśwież";
$GLOBALS['strSaveChanges']		 	= "Zapisz zmiany";
$GLOBALS['strUp'] 				= "Góra";
$GLOBALS['strDown'] 				= "Dół";
$GLOBALS['strSave'] 				= "Zapisz";
$GLOBALS['strCancel']				= "Anuluj";
$GLOBALS['strPrevious'] 			= "Poprzedni";
$GLOBALS['strPrevious_Key'] 			= "<u>P</u>oprzedni";
$GLOBALS['strNext'] 				= "Następny";
$GLOBALS['strNext_Key'] 			= "<u>N</u>astępny";
$GLOBALS['strYes']				= "Tak";
$GLOBALS['strNo']				= "Nie";
$GLOBALS['strNone'] 				= "Brak";
$GLOBALS['strCustom']				= "Własne";
$GLOBALS['strDefault'] 				= "Domyślne";
$GLOBALS['strOther']				= "Inne";
$GLOBALS['strUnknown']				= "Nieznane";
$GLOBALS['strUnlimited'] 			= "Nieograniczone";
$GLOBALS['strUntitled']				= "Bez tytułu";
$GLOBALS['strAll'] 				= "wszystkie";
$GLOBALS['strAvg'] 				= "śr.";
$GLOBALS['strAverage']				= "średnio";
$GLOBALS['strOverall'] 				= "Ogółem";
$GLOBALS['strTotal'] 				= "Wszystkie";
$GLOBALS['strActive'] 				= "aktywne";
$GLOBALS['strFrom']				= "Od";
$GLOBALS['strTo']				= "do";
$GLOBALS['strLinkedTo'] 			= "podłączony do";
$GLOBALS['strDaysLeft'] 			= "Pozostało dni";
$GLOBALS['strCheckAllNone']			= "Zaznacz wszystkie / żaden";
$GLOBALS['strKiloByte']				= "KB";
$GLOBALS['strExpandAll']			= "<u>R</u>ozwiń wszystkie";
$GLOBALS['strCollapseAll']			= "<u>Z</u>wiń wszystkie";
$GLOBALS['strShowAll']				= "Pokaż Wszystkie";
$GLOBALS['strNoAdminInteface']			= "Interfejs admina został wyłączony na czas przeprowadzenia konserwacji. Nie ma to wpływu na obsługę Twoich kampanii.";
$GLOBALS['strFilterBySource']			= "filtruj według źródła";
$GLOBALS['strFieldContainsErrors']		= "Następujące pola zawierają błędy:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Zanim przejdziesz dalej musisz";
$GLOBALS['strFieldFixBeforeContinue2']		= "skorygować te błędy.";
$GLOBALS['strDelimiter']			= "Ogranicznik";
$GLOBALS['strMiscellaneous']			= "Różne";



// Properties
$GLOBALS['strName']				= "Nazwa";
$GLOBALS['strSize']				= "Rozmiar";
$GLOBALS['strWidth'] 				= "Szerokość";
$GLOBALS['strHeight'] 				= "Wysokość";
$GLOBALS['strURL2']				= "URL";
$GLOBALS['strTarget']				= "Okno docelowe (np. _self)";
$GLOBALS['strLanguage'] 			= "Język";
$GLOBALS['strDescription'] 			= "Opis";
$GLOBALS['strID']				 = "ID";


// Login & Permissions
$GLOBALS['strAuthentification'] 		= "Autoryzacja";
$GLOBALS['strWelcomeTo']			= "Witamy w";
$GLOBALS['strEnterUsername']			= "Wpisz nazwę użytkownika i hasło, aby się zalogować";
$GLOBALS['strEnterBoth']			= "Wpisz zarówno nazwę użytkownika jak i hasło";
$GLOBALS['strEnableCookies']			= "Musisz włączyć cookies zanim będziesz mógł używać ".MAX_PRODUCT_NAME;
$GLOBALS['strLogin'] 				= "Login";
$GLOBALS['strLogout'] 				= "Wyloguj";
$GLOBALS['strUsername'] 			= "Nazwa użytkownika";
$GLOBALS['strPassword']				= "Hasło";
$GLOBALS['strAccessDenied']			= "Dostęp zabroniony";
$GLOBALS['strPasswordWrong']			= "Hasło jest nieprawidłowe";
$GLOBALS['strNotAdmin']				= "Nie masz odpowiednich uprawnień, aby korzystać z tej funkcji. Możesz zalogować się do innego konta, aby jej użyć. Kliknij <a href='logout.php'>tutaj</a>, aby zalogować się jako inny użytkownik.";
$GLOBALS['strDuplicateClientName']		= "Wpisana nazwa użytkownika już istnieje. Podaj inną nazwę.";


// General advertising
$GLOBALS['strImpressions'] 				= "Odsłony";
$GLOBALS['strClicks']				= "Kliknięcia";
$GLOBALS['strCTRShort'] 			= "CTR";
$GLOBALS['strCTR'] 				= "CTR";
$GLOBALS['strTotalViews'] 			= "Wszystkich Odsłon";
$GLOBALS['strTotalClicks'] 			= "Kliknięcia ogółem";
$GLOBALS['strViewCredits'] 			= "Pula Odsłon";
$GLOBALS['strClickCredits'] 			= "Pula Kliknięć";


// Time and date related
$GLOBALS['strDate'] 				= "Data";
$GLOBALS['strToday'] 				= "Dzisiaj";
$GLOBALS['strDay']				= "Dzień";
$GLOBALS['strDays']				= "Dni";
$GLOBALS['strLast7Days']			= "Ostatnie 7 dni";
$GLOBALS['strWeek'] 				= "Tydzień";
$GLOBALS['strWeeks']				= "Tygodni";
$GLOBALS['strMonths']				= "Miesiący";
$GLOBALS['strThisMonth'] 			= "Ten miesiąc";
$GLOBALS['strMonth'][0] = "Styczeń";
$GLOBALS['strMonth'][1] = "Luty";
$GLOBALS['strMonth'][2] = "Marzec";
$GLOBALS['strMonth'][3] = "Kwiecień";
$GLOBALS['strMonth'][4] = "Maj";
$GLOBALS['strMonth'][5] = "Czerwiec";
$GLOBALS['strMonth'][6] = "Lipiec";
$GLOBALS['strMonth'][7] = "Sierpień";
$GLOBALS['strMonth'][8] = "Wrzesień";
$GLOBALS['strMonth'][9] = "Październik";
$GLOBALS['strMonth'][10] = "Listopad";
$GLOBALS['strMonth'][11] = "Grudzień";

$GLOBALS['strDayShortCuts'][0] = "Ni";
$GLOBALS['strDayShortCuts'][1] = "Po";
$GLOBALS['strDayShortCuts'][2] = "Wt";
$GLOBALS['strDayShortCuts'][3] = "Śr";
$GLOBALS['strDayShortCuts'][4] = "Cz";
$GLOBALS['strDayShortCuts'][5] = "Pt";
$GLOBALS['strDayShortCuts'][6] = "So";

$GLOBALS['strHour']				= "godzina";
$GLOBALS['strSeconds']				= "sekund";
$GLOBALS['strMinutes']				= "minut";
$GLOBALS['strHours']				= "godzin";
$GLOBALS['strTimes']				= "razy";


// Advertiser
$GLOBALS['strClient']				= "Reklamodawca";
$GLOBALS['strClients'] 				= "Reklamodawcy";
$GLOBALS['strClientsAndCampaigns']		= "Reklamodawcy i Kampanie";
$GLOBALS['strAddClient'] 			= "Dodaj nowego reklamodawcę";
$GLOBALS['strAddClient_Key'] 			= "Dodaj <u>n</u>owego reklamodawcę";
$GLOBALS['strTotalClients'] 			= "Wszystkich reklamodawców";
$GLOBALS['strClientProperties']			= "Właściwości reklamodawcy";
$GLOBALS['strClientHistory']			= "Historia reklamodawcy";
$GLOBALS['strNoClients']			= "Obecnie nie istnieją żadni określeni reklamodawcy. Aby utworzyć kampanię najpierw <a href='advertiser-edit.php'> dodaj nowego reklamodawcę </ a>.";
$GLOBALS['strConfirmDeleteClient'] 		= "Czy na pewno chcesz usunąć tego reklamodawcę?";
$GLOBALS['strConfirmResetClientStats']		= "Czy na pewno chcesz usunąć wszystkie statystyki dla tego reklamodawcy?";
$GLOBALS['strHideInactiveAdvertisers']		= "Ukryj nieaktywnych reklamodawców";
$GLOBALS['strInactiveAdvertisersHidden']	= "ukryci reklamodawcy nieaktywni";


// Advertisers properties
$GLOBALS['strContact'] 				= "Kontakt";
$GLOBALS['strEMail'] 				= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Wyślij raport o kampanii na adres e-mail";
$GLOBALS['strNoDaysBetweenReports']		= "Liczba dni między sporządzaniem raportów o kampanii";
$GLOBALS['strSendDeactivationWarning']  	= "Wyślij ostrzeżenie, gdy kampania jest automatycznie aktywowana/dezaktywowana";
$GLOBALS['strAllowClientModifyInfo'] 		= "Zezwól temu użytkownikowi na modyfikację własnych ustawień";
$GLOBALS['strAllowClientModifyBanner'] 		= "Zezwól temu użytkownikowi na modyfikację własnych banerów";
$GLOBALS['strAllowClientAddBanner'] 		= "Zezwól temu użytkownikowi na dodawanie własnych bannerów";
$GLOBALS['strAllowClientDisableBanner'] 	= "Zezwól temu użytkownikowi na dezaktywowanie własnych banerów";
$GLOBALS['strAllowClientActivateBanner'] 	= "Zezwól temu użytkownikowi na aktywowanie własnych banerów";


// Campaign
$GLOBALS['strCampaign']				= "Kampania";
$GLOBALS['strCampaigns']			= "Kampanie";
$GLOBALS['strTotalCampaigns'] 			= "Wszystkich kampanii";
$GLOBALS['strActiveCampaigns'] 			= "Kampanie aktywne";
$GLOBALS['strAddCampaign'] 			= "Dodaj nową kampanię";
$GLOBALS['strAddCampaign_Key'] 			= "Dodaj <u>n</u>ową kampanię";
$GLOBALS['strCreateNewCampaign']		= "Utwórz kampanię";
$GLOBALS['strModifyCampaign']			= "Zmień kampanię";
$GLOBALS['strMoveToNewCampaign']		= "Przenieź do nowej kampanii";
$GLOBALS['strBannersWithoutCampaign']		= "Bannery bez kampanii";
$GLOBALS['strDeleteAllCampaigns']		= "Usuń wszystkie kampanie";
$GLOBALS['strCampaignStats']			= "Statystyki kampanii";
$GLOBALS['strCampaignProperties']		= "Właściwości kampanii";
$GLOBALS['strCampaignOverview']			= "Przegląd kampanii";
$GLOBALS['strCampaignHistory']			= "Historia kampanii";
$GLOBALS['strNoCampaigns']			= "Obecnie brak kampanii zdefiniowanych dla tego reklamodawcy.";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Czy na pewno chcesz usunąć wszystkie kampanie tego reklamodawcy?";
$GLOBALS['strConfirmDeleteCampaign']		= "Czy na pewno chcesz usunąć tę kampanię?";
$GLOBALS['strHideInactiveCampaigns']		= "Ukryj kampanie nieaktywne";
$GLOBALS['strInactiveCampaignsHidden']		= "ukrytenie kampanie aktywne";


// Campaign properties
$GLOBALS['strDontExpire']			= "Kampania nie kończy się o określonej dacie";
$GLOBALS['strActivateNow'] 			= "Rozpocznij natychmiast";
$GLOBALS['strLow']				= "Niski";
$GLOBALS['strHigh']				= "Wysoki";
$GLOBALS['strExpirationDate']			= "Data zakończenia";
$GLOBALS['strActivationDate']			= "Data rozpoczęcia";
$GLOBALS['strImpressionsPurchased'] 			= "Pozostało Odsłon";
$GLOBALS['strClicksPurchased'] 			= "Pozostało Kliknięć";
$GLOBALS['strCampaignWeight']			= "Waga kampanii";
$GLOBALS['strHighPriority']			= "Wyświetlaj bannery z tej kampanii z wysokim priorytetem.<br />Jeśli skorzystasz z tej opcji phpAdsNew spróbuje rozdzielić liczbę Odsłon równomiernie w ciągu dnia.";
$GLOBALS['strLowPriority']			= "Wyświetlaj bannery z tej kampanii z niskim priorytetem.<br />Ta kampania wykorzysta liczbę Odsłon pozostałą po wyświetleniu kampanii o wysokich priorytetach.";
$GLOBALS['strTargetLimitAdviews']		= "Organicz liczbę Odsłon do";
$GLOBALS['strTargetPerDay']			= "dziennie.";
$GLOBALS['strPriorityAutoTargeting']		= "Rozdziel pozostałą liczbę Odsłon równomiernie przez pozostałą liczbę dni.";



// Banners (General)
$GLOBALS['strBanner'] 				= "Baner";
$GLOBALS['strBanners'] 				= "Banery";
$GLOBALS['strAddBanner'] 			= "Dodaj nowy baner";
$GLOBALS['strAddBanner_Key'] 			= "Dodaj <u>n</u>owy baner";
$GLOBALS['strModifyBanner'] 			= "Modyfikuj baner";
$GLOBALS['strActiveBanners'] 			= "Banery aktywne";
$GLOBALS['strTotalBanners'] 			= "Wszystkich banerów";
$GLOBALS['strShowBanner']			= "Pokaż baner";
$GLOBALS['strShowAllBanners']	 		= "Pokaż wszystkie bannery";
$GLOBALS['strShowBannersNoAdClicks']		= "Pokaż bannery bez kliknięć";
$GLOBALS['strShowBannersNoAdViews']		= "Pokaż bannery bez Odsłon";
$GLOBALS['strDeleteAllBanners']	 		= "Usuń wszystkie banery";
$GLOBALS['strActivateAllBanners']		= "Aktywuj wszystkie banery";
$GLOBALS['strDeactivateAllBanners']		= "Dezaktywuj wszystkie banery";
$GLOBALS['strBannerOverview']			= "Podgląd banerów";
$GLOBALS['strBannerProperties']			= "Właściwości banera";
$GLOBALS['strBannerHistory']			= "Historia banera";
$GLOBALS['strBannerNoStats'] 			= "Nie ma żadnych statystyk dla tego bannera";
$GLOBALS['strNoBanners']			= "Obecnie brak stref zdefiniowanych dla tej strony.";
$GLOBALS['strConfirmDeleteBanner']		= "Czy na pewno chcesz usunąć ten baner?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Czy na pewno chcesz usunąć wszystkie banery należące do tej kampanii?";
$GLOBALS['strConfirmResetBannerStats']		= "Czy na pewno chcesz usunąć wszystkie istniejące statystyki dla tego bannera?";
$GLOBALS['strShowParentCampaigns']		= "Pokaż kampanie nadrzędne";
$GLOBALS['strHideParentCampaigns']		= "Ukryj kampanie nadrzędne";
$GLOBALS['strHideInactiveBanners']		= "Ukryj banery nieaktywne";
$GLOBALS['strInactiveBannersHidden']		= "ukryte banery nieaktywne";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= "Wybierz typ banera";
$GLOBALS['strMySQLBanner'] 			= "Banner lokalny (SQL)";
$GLOBALS['strWebBanner'] 			= "Banner lokalny (Webserver)";
$GLOBALS['strURLBanner'] 			= "Banner zewnętrzny";
$GLOBALS['strHTMLBanner'] 			= "Banner HTML";
$GLOBALS['strTextBanner'] 			= "Reklama tekstowa";
$GLOBALS['strAutoChangeHTML']			= "Zmodyfikuj HTML, aby umożliwić śledzenie Kliknięć";
$GLOBALS['strUploadOrKeep']			= "Chcesz zatrzymać <br />istniejący obrazek czy też chcesz <br />dodać inny?";
$GLOBALS['strNewBannerFile'] 			= "Wybierz obrazek, którego chcesz <br />użyć dla tego banera<br /><br />";
$GLOBALS['strNewBannerURL'] 			= "Adres URL obrazka (dodaj http://)";
$GLOBALS['strURL'] 				= "Docelowy adres URL (dodaj http://)";
$GLOBALS['strHTML'] 				= "HTML";
$GLOBALS['strTextBelow'] 			= "Tekst pod banerem";
$GLOBALS['strKeyword'] 				= "Słowa kluczowe";
$GLOBALS['strWeight'] 				= "Waga";
$GLOBALS['strAlt'] 				= "Tekst Alt";
$GLOBALS['strStatusText']			= "Tekst paska statusu";
$GLOBALS['strBannerWeight']			= "Waga banera";


// Banner (swf)
$GLOBALS['strCheckSWF']				= "Sprawdź wpisane w animację Flash odnośniki";
$GLOBALS['strConvertSWFLinks']			= "Konwertuj odnośniki w amimacji Flash";
$GLOBALS['strHardcodedLinks']			= "Wpisane odnośniki";
$GLOBALS['strConvertSWF']			= "<br />Wysłany plik Flash zawiera niezmienne adresy url. ". MAX_PRODUCT_NAME ." będzie w stanie prześledzić liczbę Kliknięć tego banera, dopiero po konwertowaniu tych adresów. Poniżej znajduje się lista adresów url w tej animacji. Jeżeli chcesz konwertować te adresy, kliknij <b>Konwertuj</b>, lub kliknij <b>Anuluj</b>.<br /><br />Uwaga: jeżeli klikniesz <b>Konwertuj</b> wysłany plik Flash zostanie zmieniony. <br />Zrób kopię zapasową pliku. Bez względu na wersję, w której baner został wykonany, plik docelowy może być poprawnie odtworzony w wersji Flash 4 (lub nowszej).<br /><br />";
$GLOBALS['strCompressSWF']			= "Kompresuj plik SWF, aby usprawnić pobieranie (wymagany Flash 6)";
$GLOBALS['strOverwriteSource']			= "Wstaw nowy parametr źródła";


// Banner (network)
$GLOBALS['strBannerNetwork']			= "Szablon HTML";
$GLOBALS['strChooseNetwork']			= "Wybierz szablon, który chcesz wykorzystać";
$GLOBALS['strMoreInformation']			= "Więcej informacji...";
$GLOBALS['strRichMedia']			= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "Śledź Kliknięcia";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "Opcje dostarczania";
$GLOBALS['strACL'] 				= "Dostarczanie";
$GLOBALS['strACLAdd'] 				= "Dodaj nowe ograniczenie";
$GLOBALS['strACLAdd_Key'] 			= "Dodaj <u>n</u>owe ograniczenie";
$GLOBALS['strNoLimitations']			= "Bez limitów";
$GLOBALS['strApplyLimitationsTo']		= "Zastosuj limity do";
$GLOBALS['strRemoveAllLimitations']		= "Usuń wszystkie limity";
$GLOBALS['strEqualTo']				= "jest równy";
$GLOBALS['strDifferentFrom']			= "jest inny niż";
$GLOBALS['strLaterThan']			= "jest później niż";
$GLOBALS['strLaterThanOrEqual']			= "jest później lub równocześnie z";
$GLOBALS['strEarlierThan']			= "jest wcześniej niż";
$GLOBALS['strEarlierThanOrEqual']		= "jest wcześniej lub równoczesnie z";
$GLOBALS['strAND']				= "I";  						// logical operator
$GLOBALS['strOR']				= "LUB"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Wyświetlaj ten baner wyłącznie, gdy:";
$GLOBALS['strWeekDay'] 				= "Dzień roboczy";
$GLOBALS['strTime'] 				= "Czas";
$GLOBALS['strUserAgent'] 			= "Program dostępowy";
$GLOBALS['strDomain'] 				= "Domena";
$GLOBALS['strClientIP'] 			= "Adres IP";
$GLOBALS['strSource'] 				= "Źródło";
$GLOBALS['strBrowser'] 				= "Przeglądarka";
$GLOBALS['strOS'] 				= "System";
$GLOBALS['strCountry'] 				= "Kraj";
$GLOBALS['strContinent'] 			= "Kontynent";
$GLOBALS['strDeliveryLimitations']		= "Limity dostarczania";
$GLOBALS['strDeliveryCapping']			= "Capping na osobę";
$GLOBALS['strTimeCapping']			= "Kiedy ten banner zostanie wyświetlony raz, nie pokazuj go ponownie temu samemu użytkownikowi przez:";
$GLOBALS['strImpressionCapping']		= "Nie pokazuj tego bannera temu samemu użytkownikowi więcej niż�?:";


// Publisher
$GLOBALS['strAffiliate']			= "Strona";
$GLOBALS['strAffiliates']			= "Strony";
$GLOBALS['strAffiliatesAndZones']		= "Strony i Strefy";
$GLOBALS['strAddNewAffiliate']			= "Dodaj Stronę";
$GLOBALS['strAddNewAffiliate_Key']		= "Dodaj <u>n</u>ową Stronę";
$GLOBALS['strAddAffiliate']			= "Utwórz Stronę";
$GLOBALS['strAffiliateProperties']		= "Właściwości Strony";
$GLOBALS['strAffiliateOverview']		= "Podgląd Strony";
$GLOBALS['strAffiliateHistory']			= "Historia Strony";
$GLOBALS['strZonesWithoutAffiliate']		= "Strefy bez Stron";
$GLOBALS['strMoveToNewAffiliate']		= "Przenieś do nowej Strony";
$GLOBALS['strNoAffiliates']			= "Obecnie nie istnieją żadne zdefiniowane strony internetowe. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strConfirmDeleteAffiliate']		= "Czy na pewno chcesz usunąć tę Stronę?";
$GLOBALS['strMakePublisherPublic']		= "Udostępnij publicznie strefy należące do tej Strony";


// Publisher (properties)
$GLOBALS['strWebsite']				= "Strona";
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "Zezwól temu użytkownikowi na modyfikację własnych ustawień";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Zezwól temu użytkownikowi na modyfikację własnych stref";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Zezwól temu użytkownikowi na łączenie banerów z własnymi strefami";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Zezwól temu użytkownikowi na definiowanie nowych stref";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "Zezwól temu użytkownikowi na usuwanie istniejących stref";


// Zone
$GLOBALS['strZone']				= "Strefa";
$GLOBALS['strZones']				= "Strefy";
$GLOBALS['strAddNewZone']			= "Dodaj strefę";
$GLOBALS['strAddNewZone_Key']			= "Dodaj <u>n</u>ową strefę";
$GLOBALS['strAddZone']				= "Utwórz strefę";
$GLOBALS['strModifyZone']			= "Zmień strefę";
$GLOBALS['strLinkedZones']			= "Przyłączone strefy";
$GLOBALS['strZoneOverview']			= "Podgląd strefy";
$GLOBALS['strZoneProperties']			= "Właściwości strefy";
$GLOBALS['strZoneHistory']			= "Historia strefy";
$GLOBALS['strNoZones']				= "Obecnie brak stref zdefiniowanych dla tej strony.";
$GLOBALS['strConfirmDeleteZone']		= "Czy na pewno chcesz usunąć tę strefę?";
$GLOBALS['strZoneType']				= "Typ strefy";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Button lub Prostokąt";
$GLOBALS['strInterstitial']			= "Interstitial lub Floating DHTML";
$GLOBALS['strPopup']				= "Popup";
$GLOBALS['strTextAdZone']			= "Reklama tekstowa";
$GLOBALS['strShowMatchingBanners']		= "Pokaż pasujące banery";
$GLOBALS['strHideMatchingBanners']		= "Ukryj pasujące banery";


// Advanced zone settings
$GLOBALS['strAdvanced']				= "Zaawansowane";
$GLOBALS['strChains']				= "�?ańcuchy";
$GLOBALS['strChainSettings']			= "Ustawienia łańcucha";
$GLOBALS['strZoneNoDelivery']			= "Jeśli żaden baner z tej strefy <br />nie może być dostarczony...";
$GLOBALS['strZoneStopDelivery']			= "Zaprzestań dostarczania i nie pokazuj banera";
$GLOBALS['strZoneOtherZone']			= "Wyświetl wybraną strefę w zastępstwie";
$GLOBALS['strZoneUseKeywords']			= "Wybierz banner używając poniższych słów kluczowych";
$GLOBALS['strZoneAppend']			= "Zawsze dodawaj poniższy kod HTML do banerów wyświetlanych przez tę strefę";
$GLOBALS['strAppendSettings']			= "Ustawienia dodawania";
$GLOBALS['strZonePrependHTML']			= "Zawsze dodawaj ten kod HTML przed odnośnikami tekstowymi wyświetlanymi przez tę strefę";
$GLOBALS['strZoneAppendHTML']			= "Zawsze dodawaj ten kod HTML po odnośnikach tekstowych wyświetlanych przez tę strefę";
$GLOBALS['strZoneAppendType']			= "Dodaj typ";
$GLOBALS['strZoneAppendHTMLCode']		= "Kod HTML";
$GLOBALS['strZoneAppendZoneSelection']		= "Popup lub interstitial";
$GLOBALS['strZoneAppendSelectZone']		= "Zawsze dodawaj ten popup lub interstitial do banerów wyświetlanych przez tę strefę";


// Zone probability
$GLOBALS['strZoneProbListChain']		= "Wszystkie banery podłączone do tej strefy są obecnie nieaktywne. <br />Tak wygląda łańcuch strefy, według którego będą ustawione:";
$GLOBALS['strZoneProbNullPri']			= "Do tej strefy nie podłączono żadnych aktywnych banerów.";
$GLOBALS['strZoneProbListChainLoop']		= "Postępowanie zgodnie z łańcuchem stref spowodowałoby kołową pętlę. Dostarczanie z tej strefy zostało wstrzymane.";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "Wybierz pozycje, które mają być podłączone do tej strefy";
$GLOBALS['strBannerSelection']			= "Wybór bannera";
$GLOBALS['strCampaignSelection']		= "Wybór kampanii";
$GLOBALS['strInteractive']			= "Interaktywny";
$GLOBALS['strRawQueryString']			= "Słowo kluczowe";
$GLOBALS['strIncludedBanners']			= "Podłączone banery";
$GLOBALS['strLinkedBannersOverview']		= "Przegląd przyłączonych bannerów";
$GLOBALS['strLinkedBannerHistory']		= "Historia przyłączonych bannerów";
$GLOBALS['strNoZonesToLink']			= "Brak stref, do których ten baner mógłby zostać podłączony";
$GLOBALS['strNoBannersToLink']			= "Nie ma obecnie bannerów, które mogłyby zostać przyłączone do tej strefy";
$GLOBALS['strNoLinkedBanners']			= "Nie ma żadnych bannerów przyłączonych do tej strefy";
$GLOBALS['strMatchingBanners']			= "{count} pasujących banerów";
$GLOBALS['strNoCampaignsToLink']		= "Obecnie brak kampanii, które można podłączyć do tej strefy";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "Obecnie brak stref, do których ta kampania mogłaby zostać podłączona";
$GLOBALS['strSelectBannerToLink']		= "Wybierz baner, który chcesz podłączyć do tej strefy:";
$GLOBALS['strSelectCampaignToLink']		= "Wybierz kampanię, którą chcesz podłączyć do tej strefy:";


// Statistics
$GLOBALS['strStats'] 				= "Statystyki";
$GLOBALS['strNoStats']				= "Nie ma obecnie żadnych statystyk";
$GLOBALS['strConfirmResetStats']		= "Czy na pewno chcesz usunąć wszystkie statystyki?";
$GLOBALS['strGlobalHistory']			= "Historia ogólna";
$GLOBALS['strDailyHistory']			= "Historia dzienna";
$GLOBALS['strDailyStats'] 			= "Statystyki dzienne";
$GLOBALS['strWeeklyHistory']			= "Historia tygodniowa";
$GLOBALS['strMonthlyHistory']			= "Historia miesięczna";
$GLOBALS['strCreditStats'] 			= "Statystyki kredytów";
$GLOBALS['strDetailStats'] 			= "Szczegółowe statystyki";
$GLOBALS['strTotalThisPeriod']			= "Ogółem dla tego okresu";
$GLOBALS['strAverageThisPeriod']		= "Średnio dla tego okresu";
$GLOBALS['strDistribution']			= "Dystrybucja";
$GLOBALS['strResetStats'] 			= "Resetuj statystyki";
$GLOBALS['strSourceStats']			= "Statystyki źródła";
$GLOBALS['strSelectSource']			= "Wybierz źródło, ktęre chcesz zobaczyć:";
$GLOBALS['strSizeDistribution']			= "Dystrybucja według rozmiaru";
$GLOBALS['strCountryDistribution']		= "Dystrybucja według kraju";
$GLOBALS['strEffectivity']			= "Efektywność";
$GLOBALS['strTargetStats']			= "Statystyki targetowania";
$GLOBALS['strCampaignTarget']			= "Cel";
$GLOBALS['strTargetRatio']			= "Ratio Celu";
$GLOBALS['strTargetModifiedDay']		= "Cele zostały zmodyfikowane w ciągu dnia, targeting może nie być precyzyjny";
$GLOBALS['strTargetModifiedWeek']		= "Cele zostały zmodyfikowane w ciągu tygodnia, targeting może nie być precyzyjny";
$GLOBALS['strTargetModifiedMonth']		= "Cele zostały zmodyfikowane w ciągu miesiąca, targeting może nie być precyzyjny";
$GLOBALS['strNoTargetStats']			= "Nie ma obecnie żadnych statystyk targetingu";


// Hosts
$GLOBALS['strHosts']				= "Hosty";
$GLOBALS['strTopHosts'] 			= "Najczęściej pobierające hosty";
$GLOBALS['strTopCountries'] 			= "Najczęściej pobierające kraje";
$GLOBALS['strRecentHosts'] 			= "Ostatnio pobierające hosty";


// Expiration
$GLOBALS['strExpired']				= "Zakończony";
$GLOBALS['strExpiration'] 			= "Zakończenie";
$GLOBALS['strNoExpiration'] 			= "Bez daty zakończenia";
$GLOBALS['strEstimated'] 			= "Szacowana data zakończenia";


// Reports
$GLOBALS['strReports']				= "Raporty";
$GLOBALS['strSelectReport']			= "Wybierz raport, który chcesz utworzyć";


// Userlog
$GLOBALS['strUserLog']				= "Log użytkownika";
$GLOBALS['strUserLogDetails']			= "Szczegóły logu użytkownika";
$GLOBALS['strDeleteLog']			= "Usuń log";
$GLOBALS['strAction']				= "Akcja";
$GLOBALS['strNoActionsLogged']			= "Żadne działania nie są zalogowane";


// Code generation
$GLOBALS['strGenerateBannercode']		= "Generuj kod banera";
$GLOBALS['strChooseInvocationType']		= "Wybierz typ kodu wywołującego baner";
$GLOBALS['strGenerate']				= "Generuj";
$GLOBALS['strParameters']			= "Atrybuty znacznika";
$GLOBALS['strFrameSize']			= "Rozmiar ramki";
$GLOBALS['strBannercode']			= "Kod banera";


// Errors
$GLOBALS['strMySQLError'] 			= "Błąd SQL:";
$GLOBALS['strLogErrorClients'] 			= "[phpAds] Wystąpił błąd podczas próby pobrania reklamodawców z bazy danych.";
$GLOBALS['strLogErrorBanners'] 			= "[phpAds] Wystąpił błąd podczas próby pobrania banerów z bazy danych.";
$GLOBALS['strLogErrorViews'] 			= "[phpAds] Wystąpił błąd podczas próby pobrania Odsłon z bazy danych.";
$GLOBALS['strLogErrorClicks'] 			= "[phpAds] Wystąpił błąd podczas próby pobrania Kliknięć z bazy danych.";
$GLOBALS['strErrorViews'] 			= "Musisz wpisać liczbę Odsłon lub zaznaczyć pole Bez ograniczeń!";
$GLOBALS['strErrorNegViews'] 			= "Ujemne liczby Odsłon nie są dozwolone";
$GLOBALS['strErrorClicks'] 			= "Musisz wpisać liczbę Kliknięć lub zaznaczyć pole Bez ograniczeń!";
$GLOBALS['strErrorNegClicks'] 			= "Ujemne liczby kliknięć nie są dozwolone";
$GLOBALS['strNoMatchesFound']			= "Nie znaleziono pasujących elementów";
$GLOBALS['strErrorOccurred']			= "Wystąpił błąd";
$GLOBALS['strErrorUploadSecurity']		= "Wykryto możliwy błąd zabezpieczeń, wysyłanie wstrzymane!";
$GLOBALS['strErrorUploadBasedir']		= "Brak dostępu do wysłanego pliku, prawdopodobnie z powodu restrykcji safemode lub open_basedir";
$GLOBALS['strErrorUploadUnknown']		= "Z niewiadomego powodu, brak dostępu do wysłanego pliku. Sprawdź konfigurację PHP";
$GLOBALS['strErrorStoreLocal']			= "Wystąpił błąd podczas zapisywania bannera w lokalnym katalogu. Powodem tego jest prawdopodobnie błędna ścieżka lokalnego katalogu podana w ustawieniach";
$GLOBALS['strErrorStoreFTP']			= "Wystąpił błąd podczas zapisywania bannera na serwerze FTP. Powodem tego może być niedostępność serwera lub jego błędna konfiguracja w ustawieniach";


// E-mail
$GLOBALS['strMailSubject'] 			= "Raport dla reklamodawcy";
$GLOBALS['strAdReportSent']			= "Raport dla reklamodawcy wysłany";
$GLOBALS['strMailSubjectDeleted'] 		= "Deaktytowane bannery";
$GLOBALS['strMailHeader'] 			= "Drogi {contact},\n";
$GLOBALS['strMailBannerStats'] 			= "Poniżej widnieją statystyki banerów dla {clientname}:";
$GLOBALS['strMailFooter'] 			= "Z poważaniem,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "Poniższe bannery zostały deaktywowane ponieważ";
$GLOBALS['strMailNothingLeft'] 			= "Jeśli chcieliby Państwo kontynuować reklamę na naszej stronie, prosimy o kontakt.\nZ przyjemnością udzielimy dalszych informacji.";
$GLOBALS['strClientDeactivated']		= "Ta kampania jest obecnie nieaktywna, ponieważ";
$GLOBALS['strBeforeActivate']			= "data aktywacji jeszcze nie nadeszła";
$GLOBALS['strAfterExpire']			= "data zakończenia już minęła";
$GLOBALS['strNoMoreClicks']			= "wszystkie Kliknięcia zostały wykorzystane";
$GLOBALS['strNoMoreViews']			= "wszystkie Odsłony zostały wykorzystane";
$GLOBALS['strWarnClientTxt']			= "Liczba Odsłon, Kliknięć lub Konwersji pozostałych dla banerów schodzi poniżej granicy {limit}. \nKiedy liczba Odsłon, Kliknięć lub Konwersji zostanie wykorzystana, banery zostaną deaktywowane.";
$GLOBALS['strImpressionsClicksLow']			= "Liczba Kliknięć/Odsłon jest prawie wykorzystana";
$GLOBALS['strNoViewLoggedInInterval']   	= "Nie zarejestrowano żadnych Odsłon w czasie objętym tym raportem";
$GLOBALS['strNoClickLoggedInInterval']  	= "Nie zarejestrowano żadnych Kliknięć w czasie objętym tym raportem";
$GLOBALS['strMailReportPeriod']			= "Ten raport zawiera statystyki od {startdate} do {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "Ten raport zawiera wszystkie statystyki aż do {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "Brak statystyk dla tej kampanii";


// Priority
$GLOBALS['strPriority']				= "Priorytet";


// Settings
$GLOBALS['strSettings'] 			= "Ustawienia";
$GLOBALS['strGeneralSettings']			= "Ustawienia ogólne";
$GLOBALS['strMainSettings']			= "Ustawienia główne";
$GLOBALS['strAdminSettings']			= "Ustawienia administracji";


// Product Updates
$GLOBALS['strProductUpdates']			= "Aktualizacje produktu";




/*-------------------------------------------------------*/
/* Keyboard shortcut assignments                         */
/*-------------------------------------------------------*/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']			= 'h';
$GLOBALS['keyUp']			= 'u';
$GLOBALS['keyNextItem']			= '.';
$GLOBALS['keyPreviousItem']		= ',';
$GLOBALS['keyList']			= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']			= 's';
$GLOBALS['keyCollapseAll']		= 'c';
$GLOBALS['keyExpandAll']		= 'e';
$GLOBALS['keyAddNew']			= 'n';
$GLOBALS['keyNext']			= 'n';
$GLOBALS['keyPrevious']			= 'p';



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strStartOver'] = "Zacznij od początku";
$GLOBALS['strTrackerVariables'] = "Zmienne trackera";
$GLOBALS['strLogoutURL'] = "URL - przekierowanie po wylogowaniu";
$GLOBALS['strAppendTrackerCode'] = "Dodaj kod trackera";
$GLOBALS['strStatusDuplicate'] = "Duplikuj";
$GLOBALS['strPriorityOptimisation'] = "Różne";
$GLOBALS['strCollectedAllStats'] = "Wszystkie statystyki";
$GLOBALS['strCollectedToday'] = "Dziś";
$GLOBALS['strCollectedYesterday'] = "Wczoraj";
$GLOBALS['strCollectedThisWeek'] = "W tym tygodniu";
$GLOBALS['strCollectedLastWeek'] = "W poprzednim tygodniu";
$GLOBALS['strCollectedThisMonth'] = "W tym miesiącu";
$GLOBALS['strCollectedLastMonth'] = "W poprzednim miesiącu";
$GLOBALS['strCollectedLast7Days'] = "W ciągu ostatnich 7 dni";
$GLOBALS['strCollectedSpecificDates'] = "Określone daty";
$GLOBALS['strAdmin'] = "Admin";
$GLOBALS['strNotice'] = "Ogłoszenie";
$GLOBALS['strPriorityLevel'] = "Poziom priorytetu";
$GLOBALS['strPriorityTargeting'] = "Dystrybucja";
$GLOBALS['strLimitations'] = "Limity";
$GLOBALS['strCapping'] = "Ograniczenia";
$GLOBALS['strVariableDescription'] = "Opis";
$GLOBALS['strVariables'] = "Zmienne";
$GLOBALS['strStatsVariables'] = "Zmienne";
$GLOBALS['strComments'] = "Komentarze";
$GLOBALS['strUsernameOrPasswordWrong'] = "Niepoprawna nazwa użytkownika i/lub hasło. Spróbuj ponownie.";
$GLOBALS['strDuplicateAgencyName'] = "Wpisana nazwa użytkownika już istnieje. Podaj inną nazwę.";
$GLOBALS['strRequests'] = "Próby wywołania";
$GLOBALS['strConversions'] = "Konwersje";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCNVR'] = "Wskaźnik sprzedaży (SR)";
$GLOBALS['strTotalConversions'] = "Konwersje ogółem";
$GLOBALS['strConversionCredits'] = "Pula Konwersji";
$GLOBALS['strDateTime'] = "Data Godzina";
$GLOBALS['strTrackerID'] = "ID trackera";
$GLOBALS['strTrackerName'] = "Nazwa trackera";
$GLOBALS['strCampaignID'] = "ID kampanii";
$GLOBALS['strCampaignName'] = "Nazwa kampanii";
$GLOBALS['strStatsAction'] = "Akcja";
$GLOBALS['strWindowDelay'] = "Opóźnienie okna";
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Użytkowanie miesięczne";
$GLOBALS['strBreakdownByDay'] = "Dzień";
$GLOBALS['strBreakdownByWeek'] = "Tydzień";
$GLOBALS['strSingleMonth'] = "Miesiąc";
$GLOBALS['strBreakdownByMonth'] = "Miesiąc";
$GLOBALS['strDayOfWeek'] = "Dzień tygodnia";
$GLOBALS['strBreakdownByDow'] = "Dzień tygodnia";
$GLOBALS['strBreakdownByHour'] = "godzina";
$GLOBALS['strHiddenAdvertiser'] = "Reklamodawca";
$GLOBALS['strChars'] = "znaki";
$GLOBALS['strAllowClientViewTargetingStats'] = "Zezwól temu użytkownikowi na wgląd w statystki targetowania";
$GLOBALS['strCsvImportConversions'] = "Zezwól temu użytkownikowi na importowanie konwersji offline";
$GLOBALS['strHiddenCampaign'] = "Kampania";
$GLOBALS['strLinkedCampaigns'] = "Kampanie podłączone";
$GLOBALS['strShowParentAdvertisers'] = "Pokaż głównych reklamodawców";
$GLOBALS['strHideParentAdvertisers'] = "Ukryj głównych reklamodawców";
$GLOBALS['strContractDetails'] = "Szczegóły kontraktu";
$GLOBALS['strInventoryDetails'] = "Szczegóły zasobów";
$GLOBALS['strPriorityInformation'] = "Pierwszeństwo w stosunku do innych kampanii";
$GLOBALS['strPriorityHigh'] = "\- Kampanie opłacone";
$GLOBALS['strPriorityLow'] = "\- Kampanie wewnętrzne oraz nieopłacone";
$GLOBALS['strHiddenAd'] = "Advertisement";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strHiddenZone'] = "Strefa";
$GLOBALS['strCompanionPositioning'] = "Poyzcjonowanie wzajemne";
$GLOBALS['strSelectUnselectAll'] = "Zaznacz/ odznacz wszystko";
$GLOBALS['strExclusive'] = "Wyłączny";
$GLOBALS['strExpirationDateComment'] = "Kampania wygaśnie z końcem dnia";
$GLOBALS['strActivationDateComment'] = "Kampania rozpocznie się z początkiem dnia";
$GLOBALS['strRevenueInfo'] = "Informacje o dochodzie";
$GLOBALS['strImpressionsRemaining'] = "Pozostałe odsłony";
$GLOBALS['strClicksRemaining'] = "Pozostałe kliknięcia";
$GLOBALS['strConversionsRemaining'] = "Pozostałe konwersje";
$GLOBALS['strImpressionsBooked'] = "Odsłony zarezerwowane";
$GLOBALS['strClicksBooked'] = "Kliknięcia zarezerwowane";
$GLOBALS['strConversionsBooked'] = "Konwersje zarezerwowane";
$GLOBALS['strOptimise'] = "Optymalizacja";
$GLOBALS['strAnonymous'] = "Ukryj reklamodawcę i strony tej kampanii.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Kampania została ustwiona jako pozostała, \njednak jej waga jest równa zeru bądź nie została \nsprecyzowana. Spowoduje to dezaktywację \nkampanii. Banery będą dostarczane dopiero \npo wprowadzeniu wartości w formacie liczby. \n\nCzy na pewno chcesz kontynuować?";
$GLOBALS['strCampaignWarningExclusiveNoWeight'] = "Kampania została ustwiona jako wyłączna, \njednak jej waga jest równa zeru bądź nie została \nsprecyzowana. Spowoduje to dezaktywację \nkampanii. Banery będą dostarczane dopiero \npo wprowadzeniu wartości w formacie liczby. \n\nCzy na pewno chcesz kontynuować?";
$GLOBALS['strCampaignWarningNoTarget'] = "Kampania została ustwiona jako Kontrakt, \njednak dzienny limit nie został \nsprecyzowany. Spowoduje to dezaktywację \nkampanii. Banery będą dostarczane dopiero \npo wprowadzeniu dziennego limitu. \n\nCzy na pewno chcesz kontynuować?";
$GLOBALS['strTrackerOverview'] = "Podgląd trackera";
$GLOBALS['strAddTracker'] = "Dodaj nowy tracker";
$GLOBALS['strAddTracker_Key'] = "Dodaj <u>n</u>owy tracker";
$GLOBALS['strNoTrackers'] = "Obecnie brak trackerów zdefiniowanych dla tego reklamodawcy.";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Czy na pewno chcesz usunąć wszystkie trackery należące do tego reklamodawcy?";
$GLOBALS['strConfirmDeleteTracker'] = "Czy na pewno chcesz usunąć tracker?";
$GLOBALS['strDeleteAllTrackers'] = "Usuń wszystkie trackery";
$GLOBALS['strTrackerProperties'] = "Właściwości trackera";
$GLOBALS['strModifyTracker'] = "Modyfikuj tracker";
$GLOBALS['strLog'] = "Protokołować?";
$GLOBALS['strDefaultStatus'] = "Status domyślny";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strLinkedTrackers'] = "Podłączone trackery";
$GLOBALS['strConversionWindow'] = "Odstęp między konwersjami";
$GLOBALS['strUniqueWindow'] = "Odstęp między walidacją zmiennych";
$GLOBALS['strClick'] = "Kliknięcie";
$GLOBALS['strView'] = "Widok";
$GLOBALS['strLinkCampaignsByDefault'] = "Podłącz nowo utworzone kampanie w ramach ustawień domyślnych";
$GLOBALS['strConversionType'] = "Typ konwersji";
$GLOBALS['strAppendTextAdNotPossible'] = "Nie można dołączyć innych banerów do reklam tekstowych.";
$GLOBALS['strWarningMissing'] = "Uwaga, prawdopodobnie brakuje ";
$GLOBALS['strWarningMissingClosing'] = "znacznika zamykającego '>'";
$GLOBALS['strWarningMissingOpening'] = "znacznika otwierającego '<'";
$GLOBALS['strSubmitAnyway'] = "Pomimo to wyślij";
$GLOBALS['strUploadOrKeepAlt'] = "Chcesz zatrzymać <br />istniejący obrazek zamienny czy też chcesz <br />dodać inny?";
$GLOBALS['strNewBannerFileAlt'] = "Wybierz obrazek, którego chcesz <br />użyć jeśli przeglądarka />nie obsługuje Rich Media<br /><br />";
$GLOBALS['strAdserverTypeGeneric'] = "Ogólny baner HTML";
$GLOBALS['strGenericOutputAdServer'] = "Ogólny";
$GLOBALS['strGeneric'] = "Ogólny";
$GLOBALS['strSwfTransparency'] = "Tło transparentne";
$GLOBALS['strChannelLimitations'] = "Opcje dostarczania";
$GLOBALS['strGreaterThan'] = "jest większe niż";
$GLOBALS['strLessThan'] = "jest mniej niż";
$GLOBALS['strWeekDays'] = "Dni robocze";
$GLOBALS['strCity'] = "Miasto";
$GLOBALS['strDeliveryCappingReset'] = "Zresetuj liczniki po:";
$GLOBALS['strDeliveryCappingTotal'] = "ogółem";
$GLOBALS['strDeliveryCappingSession'] = "na sesję";
$GLOBALS['strAffiliateInvocation'] = "Kod wywołujący";
$GLOBALS['strTotalAffiliates'] = "Wszystkich Stron";
$GLOBALS['strInactiveAffiliatesHidden'] = "ukryte Strony nieaktywne";
$GLOBALS['strShowParentAffiliates'] = "Pokaż Strony nadrzędne";
$GLOBALS['strHideParentAffiliates'] = "Ukryj Strony nadrzędne";
$GLOBALS['strMnemonic'] = "Mnemonik";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Zezwól temu użytkownikowi na generowanie kodu inwokacyjnego";
$GLOBALS['strAllowAffiliateZoneStats'] = "Zezwól temu użytkownikowi na podgląd statystyk strefy";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Zezwól temu użytkownikowi na podgląd jedynie zatwierdzonych lub oczekujących konwersji";
$GLOBALS['strPaymentInformation'] = "Informacje odnośnie płatności";
$GLOBALS['strAddress'] = "Adres";
$GLOBALS['strPostcode'] = "Kod pocztowy";
$GLOBALS['strPhone'] = "Telefon";
$GLOBALS['strFax'] = "Faks";
$GLOBALS['strAccountContact'] = "Dane kontaktowe użytkownika konta";
$GLOBALS['strPayeeName'] = "Nazwa beneficjenta";
$GLOBALS['strTaxID'] = "NIP";
$GLOBALS['strModeOfPayment'] = "Metoda płatności";
$GLOBALS['strPaymentChequeByPost'] = "Czek przesłany pocztą";
$GLOBALS['strCurrency'] = "Waluta";
$GLOBALS['strCurrencyGBP'] = "GBP (funt szterling)";
$GLOBALS['strOtherInformation'] = "Inne informacje";
$GLOBALS['strUniqueUsersMonth'] = "Użytkowników unikalnych/miesiąc";
$GLOBALS['strUniqueViewsMonth'] = "Wyświetleń unikalnych/miesiąc";
$GLOBALS['strPageRank'] = "Ranga strony";
$GLOBALS['strCategory'] = "Kategoria";
$GLOBALS['strHelpFile'] = "Plik pomocy";
$GLOBALS['strEmailAdZone'] = "Strefa E-mail/Biuletyn";
$GLOBALS['strZoneClick'] = "Kliknij śledzenie strefy";
$GLOBALS['strBannerLinkedAds'] = "Banery podłączone do strefy";
$GLOBALS['strCampaignLinkedAds'] = "Kampanie podłączone do strefy";
$GLOBALS['strTotalZones'] = "Strefy ogółem";
$GLOBALS['strCostInfo'] = "Koszty nośników";
$GLOBALS['strTechnologyCost'] = "Koszty technologiczne";
$GLOBALS['strInactiveZonesHidden'] = "ukryte strefy nieaktywne";
$GLOBALS['strWarnChangeZoneType'] = "Jeżeli zmienisz strefę na typ tekstowy bądź e-mail, wszystkie banery/kampanie zostaną odłączone z racji restrykcji dla tego typu stref\n<ul>\n<li>Do stref tekstowych podłączyć można wyłącznie reklamy tekstowe</li>\n<li>Kampanie w strefie e-mail mogą w danym czasie posiadać tylko jeden aktywny baner</li>\n</ul>";
$GLOBALS['strWarnChangeZoneSize'] = "Modyfikacja rozmiarów strefy spowoduje odłączenie wszystkich banerów, których rozmiary nie odpowiadają nowym parametrom, oraz dodanie wszystkich banerów o odpowiednich rozmiarach z podłączonych kampanii.";
$GLOBALS['strZoneForecasting'] = "Ustawienia prognozowania w strefie";
$GLOBALS['strZoneAppendNoBanner'] = "Dodaj, nawet jeśli baner nie jest dostarczany";
$GLOBALS['strLinkedBanners'] = "Podłącz banery indywidualne";
$GLOBALS['strCampaignDefaults'] = "Podłącz banery wg kampanii nadrzędnej";
$GLOBALS['strLinkedCategories'] = "Podłącz banery wg kategorii";
$GLOBALS['strNoTrackersToLink'] = "Obecnie brak trackerów, które można podłączyć do tej kampanii";
$GLOBALS['strSelectAdvertiser'] = "Wybierz reklamodawcę";
$GLOBALS['strSelectPlacement'] = "Wybierz kampanię";
$GLOBALS['strSelectAd'] = "Wybierz baner";
$GLOBALS['strStatusPending'] = "Oczekuje";
$GLOBALS['strStatusApproved'] = "Zatwierdzono";
$GLOBALS['strStatusDisapproved'] = "Odrzucono";
$GLOBALS['strStatusOnHold'] = "Zatrzymano";
$GLOBALS['strStatusIgnore'] = "Ignoruj";
$GLOBALS['strConnectionType'] = "Typ";
$GLOBALS['strType'] = "Typ";
$GLOBALS['strConnTypeSale'] = "Sprzedaż";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Rejestracja";
$GLOBALS['strShortcutEditStatuses'] = "Edytuj statusy";
$GLOBALS['strShortcutShowStatuses'] = "Pokaż statusy";
$GLOBALS['strNoTargetingStats'] = "Obecnie brak statystyk targetowania";
$GLOBALS['strNoStatsForPeriod'] = "Obecnie brak statystyk za okres od %s do %s";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Obecnie brak statystyk targetowania za okres od %s do %s";
$GLOBALS['strPublisherDistribution'] = "Dystrybucja Stron";
$GLOBALS['strCampaignDistribution'] = "Dystrybucja kampanii";
$GLOBALS['strViewBreakdown'] = "Kryteria podglądu";
$GLOBALS['strItemsPerPage'] = "Pozycji na stronę";
$GLOBALS['strDistributionHistory'] = "Historia dystrybucji";
$GLOBALS['strShowGraphOfStatistics'] = "Pokaż <u>W</u>ykres statystyk";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>ksportuj statystyki do arkusza Excel";
$GLOBALS['strGDnotEnabled'] = "Aby wyświetlać wykresy musisz uruchomić GD w PHP. <br />Na tej stronie <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> uzyskasz więcej informacji oraz dowiesz się jak zainstalować GD na swoim serwerze.";
$GLOBALS['strStartDate'] = "Data rozpoczęcia";
$GLOBALS['strEndDate'] = "Data zakończenia";
$GLOBALS['strAllAdvertisers'] = "Wszyscy reklamodawcy";
$GLOBALS['strAnonAdvertisers'] = "Reklamodawcy anonimowi";
$GLOBALS['strAllPublishers'] = "Wszystkie Strony";
$GLOBALS['strAnonPublishers'] = "Strony anonimowe";
$GLOBALS['strAllAvailZones'] = "Wszystkie dostępne strefy";
$GLOBALS['strBackToTheList'] = "Wróć do listy raportów";
$GLOBALS['strLogErrorConversions'] = "[phpAds] Wystąpił błąd podczas próby pobrania Konwersji z bazy danych.";
$GLOBALS['strErrorDBPlain'] = "Wystąpił błąd podczas wywoływania bazy danych";
$GLOBALS['strErrorDBSerious'] = "Wykryto poważny błąd z bazą danych";
$GLOBALS['strErrorDBNoDataPlain'] = "Problem z bazą danych uniemożliwił ". MAX_PRODUCT_NAME ."  odczytanie i zachowanie danych.";
$GLOBALS['strErrorDBNoDataSerious'] = "Poważny problem z bazą danych uniemożliwił ". MAX_PRODUCT_NAME ."  odczytanie danych";
$GLOBALS['strErrorDBCorrupt'] = "Tabela bazy danych jest prawdopodobnie uszkodzona i wymaga naprawienia. Więcej informacji na temat naprawiania uszkodzonych tabel znajdziesz w <i>Przewodniku administratora</i> w rozdziale <i>Rozwiązywanie problemów</i>.";
$GLOBALS['strErrorDBContact'] = "Poinformuj administratora serwera o zaistniałym problemie.";
$GLOBALS['strErrorDBSubmitBug'] = "Jeśli ten problem pojawia się wielkorotnie, może być spowodowany błędem MAX_PRODUCT_NAME. Prosimy o przekazanie poniższych informacji twórcom ". MAX_PRODUCT_NAME .". Pomocne jest dokładne opisanie działań, które doprowadziły do pojawienia się tego błędu.";
$GLOBALS['strMaintenanceNotActive'] = "Skrypt konserwacyjny nie był uruchomiony w ciągu ostatnich 24 godzin. \nAby ". MAX_PRODUCT_NAME ." funkcjonował poprawnie, skrypt ten musi być uruchamiany co godzinę. \n\nZapoznaj się z Przewodnikiem administratora, gdzie uzyskasz więcej informacji \nna temat konfiguracji skryptu konserwacyjnego.";
$GLOBALS['strErrorLinkingBanner'] = "Nie można podłączyć banera do strefy, ponieważ:";
$GLOBALS['strUnableToLinkBanner'] = "Nie można podłączyć banera:";
$GLOBALS['strErrorEditingCampaign'] = "Błąd podczas aktualizowania kampanii:";
$GLOBALS['strUnableToChangeCampaign'] = "Nie można wprowadzić tej zmiany, ponieważ:";
$GLOBALS['strDatesConflict'] = "nastąpił konflikt dat:";
$GLOBALS['strEmailNoDates'] = "Kampanie w strefie typu e-mail muszą być opatrzone datą rozpoczęcia i zakończenia";
$GLOBALS['strSirMadam'] = "Szanowny/a";
$GLOBALS['strMailBannerActivatedSubject'] = "Kampania została aktywowana";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Kampania została dezaktywowana";
$GLOBALS['strMailBannerActivated'] = "Poniższa kampania została aktywowana, ponieważ nadeszła data jej aktywacji.";
$GLOBALS['strMailBannerDeactivated'] = "Poniższa kampania została dezaktywowana, ponieważ";
$GLOBALS['strNoMoreImpressions'] = "wszystkie Odsłony zostały wykorzystane";
$GLOBALS['strNoMoreConversions'] = "pula Sprzedaży została wyczerpana";
$GLOBALS['strWeightIsNull'] = "jej waga jest ustawiona na zero";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Liczba Odsłon/Kliknięć/Konwersji jest niska";
$GLOBALS['strNoConversionLoggedInInterval'] = "Nie zarejestrowano żadnych Konwersji w czasie objętym tym raportem";
$GLOBALS['strImpendingCampaignExpiry'] = "Kampania wkrótce wygaśnie";
$GLOBALS['strYourCampaign'] = "Twoja kampania";
$GLOBALS['strTheCampiaignBelongingTo'] = "Kampania należy do";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "Wyświetlenia {clientname} wygasają {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "Klientowi {clientname} pozostało mniej niż {limit} wyświetleń";
$GLOBALS['strImpendingCampaignExpiryBody'] = "W rezultacie kampania zostanie wkrótce automatycznie dezaktywowana,\npodobnie jak i banery do niej przynależące.";
$GLOBALS['strSourceEdit'] = "Edytuj źródła";
$GLOBALS['strViewPastUpdates'] = "Zarządzanie poprzednimi aktualizacjami oraz kopiami zapasowymi";
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
$GLOBALS['strAllowAgencyEditConversions'] = "Zezwalaj temu użytkownikowi na edytowanie konwersji";
$GLOBALS['strAllowMoreReports'] = "Pokaż przycisk 'Więcej raportów'";
$GLOBALS['strChannel'] = "Kanał targetowania";
$GLOBALS['strChannels'] = "Kanały targetowania";
$GLOBALS['strChannelOverview'] = "Podgląd kanału targetowania";
$GLOBALS['strChannelManagement'] = "Zarządzenie kanałem targetowania";
$GLOBALS['strAddNewChannel'] = "Dodaj nowy kanał targetowania";
$GLOBALS['strAddNewChannel_Key'] = "Dodaj <u>n</u>owy kanał targetowania";
$GLOBALS['strNoChannels'] = "W tej chwili brak zdefiniowanych kanałów targetowania";
$GLOBALS['strEditChannelLimitations'] = "Edytuj limity dla kanału targetowania";
$GLOBALS['strChannelProperties'] = "Ustawienia docelowego kanału";
$GLOBALS['strConfirmDeleteChannel'] = "Czy jesteś pewien, że chcesz usunąć kanał targetowania?";
$GLOBALS['strVariableName'] = "Nazwa zmiennej";
$GLOBALS['strVariableDataType'] = "Wyświetlanie daty";
$GLOBALS['strVariablePurpose'] = "Cel";
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
$GLOBALS['strForgotPassword'] = "Nie pamiętasz hasła?";
$GLOBALS['strPasswordRecovery'] = "Odzyskiwanie hasła";
$GLOBALS['strEmailRequired'] = "Adres e-mail jest obligatoryjny";
$GLOBALS['strPwdRecEmailNotFound'] = "Nie znaleziono adresu e-mail";
$GLOBALS['strPwdRecPasswordSaved'] = "Nowe hasło zostało zapisane, przejdź do <a href='index.php'>loginu</a>";
$GLOBALS['strPwdRecWrongId'] = "ID niepoprawne";
$GLOBALS['strPwdRecEnterEmail'] = "Wprowadź adres e-mail poniżej";
$GLOBALS['strPwdRecEnterPassword'] = "Wprowadź nowe hasło poniżej";
$GLOBALS['strPwdRecResetLink'] = "Link do zresetowania hasła";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s odzyskiwanie hasła";
$GLOBALS['strDefaultBannerDestination'] = "Docelowy adres URL";
$GLOBALS['strEvent'] = "Zdarzenie";
$GLOBALS['strValue'] = "Wartość";
$GLOBALS['strAuditTrail'] = "Audyt";
$GLOBALS['strLinkNewUser'] = "Podłącz nowego użytkownika";
$GLOBALS['strUserAccess'] = "Dostęp użytkownika";
$GLOBALS['strCampaignStatusRunning'] = "Aktywna";
$GLOBALS['strCampaignStatusPaused'] = "Wstrzymano";
$GLOBALS['strCampaignStatusAwaiting'] = "Oczekuje";
$GLOBALS['strCampaignStatusExpired'] = "Zakończona";
$GLOBALS['strCampaignStatusApproval'] = "Czeka na akceptację »";
$GLOBALS['strCampaignStatusRejected'] = "Odrzucono";
$GLOBALS['strCampaignApprove'] = "Akceptuj";
$GLOBALS['strCampaignApproveDescription'] = "Akceptuj kampanię";
$GLOBALS['strCampaignReject'] = "Odrzuć";
$GLOBALS['strCampaignRejectDescription'] = "Odrzuć kampanię";
$GLOBALS['strCampaignPause'] = "Przerwij";
$GLOBALS['strCampaignPauseDescription'] = "Tymczasowo przerwij tę kampanię";
$GLOBALS['strCampaignRestart'] = "Powróć";
$GLOBALS['strCampaignRestartDescription'] = "Przywróć tę kampanię";
$GLOBALS['strCampaignStatus'] = "Status kampanii";
$GLOBALS['strReasonForRejection'] = "Powód odrzucenia";
$GLOBALS['strReasonSiteNotLive'] = "Błąd strony";
$GLOBALS['strReasonBadCreative'] = "Nieprawidłowe działanie";
$GLOBALS['strReasonBadUrl'] = "Nieprawidłowy adres URL";
$GLOBALS['strReasonBreakTerms'] = "Strona niezgodna z regulaminem";
$GLOBALS['strTrackerPreferences'] = "Ustawienia trackera";
$GLOBALS['strBannerPreferences'] = "Ustawienia banera";
$GLOBALS['strAdvertiserSetup'] = "Podpis reklamodawcy";
$GLOBALS['strAdvertiserSignup'] = "Podpis reklamodawcy";
$GLOBALS['strSelectPublisher'] = "Wybierz stronę";
$GLOBALS['strSelectZone'] = "Wybierz strefę (obszar)";
$GLOBALS['strMainPreferences'] = "Główne ustawienia";
$GLOBALS['strAccountPreferences'] = "Ustawienia konta";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Ustawienia raportów e-mail kampanii";
$GLOBALS['strAdminEmailWarnings'] = "Ostrzeżenia e-mail administratora";
$GLOBALS['strAgencyEmailWarnings'] = "Ostrzeżenia e-mail agencji";
$GLOBALS['strAdveEmailWarnings'] = "Ostrzeżenia e-mail reklamodawcy";
$GLOBALS['strFullName'] = "Pełna nazwa";
$GLOBALS['strEmailAddress'] = "Adres e-mail";
$GLOBALS['strUserDetails'] = "O użytkowniku";
$GLOBALS['strLanguageTimezone'] = "Język oraz strefa czasowa";
$GLOBALS['strUserInterfacePreferences'] = "Ustawienia interfejsu użytkownika";
$GLOBALS['strInvocationPreferences'] = "Ustawienia kodu wywołującego";
$GLOBALS['strUserProperties'] = "Właściwości użytkownika";
$GLOBALS['strBack'] = "Wstecz";
$GLOBALS['strUsernameToLink'] = "Nazwa użytkownika, który ma być dodany";
$GLOBALS['strEmailToLink'] = "E-mail użytkownika, który ma być dodany";
$GLOBALS['strNewUserWillBeCreated'] = "Utworzony zostanie nowy użytkownik";
$GLOBALS['strToLinkProvideEmail'] = "Aby dodać użytkownika, podaj jego adres e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Aby dodać użytkownika, podaj jego nazwę";
$GLOBALS['strPermissions'] = "Uprawnienia";
$GLOBALS['strContactName'] = "Dane kontaktowe";
$GLOBALS['strPwdRecReset'] = "Resetuj hasło";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Resetuj hasło dla tego użytkownika";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['strAdSenseAccounts'] = "Konta AdSense";
$GLOBALS['strLinkAdSenseAccount'] = "Podłącz konto AdSense";
$GLOBALS['strCreateAdSenseAccount'] = "Utwórz konto AdSense";
$GLOBALS['strEditAdSenseAccount'] = "Edytuj konto AdSense";
$GLOBALS['strAllowCreateAccounts'] = "Zezwól temu użytkownikowi na tworzenie nowych kont";
$GLOBALS['strErrorWhileCreatingUser'] = "Błąd w trakcie tworzenia użytkownika: %s";
$GLOBALS['strUserLinkedToAccount'] = "Użytkownik został dodany do konta";
$GLOBALS['strUserAccountUpdated'] = "Konto użytkownika zostało aktualizowane";
$GLOBALS['strUserUnlinkedFromAccount'] = "Użytkownik został usunięty z konta";
$GLOBALS['strUserWasDeleted'] = "Użytkownik został usunięty";
$GLOBALS['strUserNotLinkedWithAccount'] = "Podany użytkownik nie jest podłączony do konta";
$GLOBALS['strWorkingAs'] = "Działasz jako";
$GLOBALS['strWorkingFor'] = "%s dla...";
$GLOBALS['strCantDeleteOneAdminUser'] = "Nie można usunąć użytkownika. Do konta admina musi być podłączony przynajmniej jeden użytkownik.";
$GLOBALS['strWarnChangeBannerSize'] = "Modyfikacja rozmiarów banera spowoduje odłączenie go od stref nie obsługujących nowych rozmiarów. Jeśli <strong>kampania</strong> tego banera jest podłączona do strefy z nowymi rozmiarami, podłączenie banera nastąpi automatycznie";
$GLOBALS['strAuditNoData'] = "Użytkownik nie był aktywny we wskazanym okresie czasu.";
$GLOBALS['strCampaignGoTo'] = "Przejdź do strony Kampanii";
$GLOBALS['strCampaignSetUp'] = "Rozpocznij dziś kampanię";
$GLOBALS['strCampaignNoRecords'] = "<li>Kampanie pozwalają Ci grupować dowolną ilość banerów reklamowych dowolnego rodzaju odpowiadających kryteriom klienta.<li><li>Grupując banery zaoszczędzisz czas. Nie będziesz musiał wybierać ustawień dostarczania dla każdego banera z osobna</li><li>Więcej informacji uzyskasz w <a class='site-link' target='help' href='". OX_PRODUCT_DOCSURL ."/inventory/advertisersAndCampaigns/campaigns'>Dokumentacji o Kampaniach</a>!</li>";
$GLOBALS['strPublisherReports'] = "Raport o Stronach";
$GLOBALS['strVariableHidden'] = "Schować zmienną dla Stron?";
$GLOBALS['strCampaignNoDataTimeSpan'] = "Żadna kampania nie rozpoczęła się ani nie dobiegła końca we wskazanym okresie";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Aby zobaczyć kampanie, które rozpoczęły się bądź dobiegły końca we wskazanym okresie, musisz uaktywnić opcję Audyt</li>	        <li>Ten komunikat został wyświetlony, ponieważ Audyt nie został aktywowany<li>";
$GLOBALS['strAuditTrailSetup'] = "Ustaw Audyt na dziś";
$GLOBALS['strAuditTrailGoTo'] = "Przejdź do strony Audytu";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audyt pozwala zobaczyć kto i kiedy wykonał jakie operacje. Innymi słowy, monitoruje zmiany wprowadzane w ". MAX_PRODUCT_NAME ."</li> \n<li>Widzisz tę wiadomość, ponieważ nie aktywowałeś opcji Audyt</li> \n<li>Chcesz dowiedzieć się więcej? Zapoznaj się z <a href='". OX_PRODUCT_DOCSURL ."/settings/auditTrail' class='site-link' target='help' >dokumentacją o Audycie</a></li>";
$GLOBALS['strNoAdminInterface'] = "Interfejs admina został wyłączony na czas przeprowadzenia konserwacji. Nie ma to wpływu na obsługę Twoich kampanii.";
$GLOBALS['strAdminAccess'] = "Dostęp Admina";
$GLOBALS['strOverallAdvertisers'] = "reklamodawca(y)";
$GLOBALS['strAdvertiserSignupDesc'] = "Zapisz się do Samoobsługi i Płatności Reklamodawcy";
$GLOBALS['strOverallCampaigns'] = "kampania(e)";
$GLOBALS['strTotalRevenue'] = "Dochód ogółem";
$GLOBALS['strChangeStatus'] = "Zmień status";
$GLOBALS['strImpression'] = "Odsłona";
$GLOBALS['strOverallBanners'] = "baner(y)";
$GLOBALS['strTrackerImageTag'] = "Znacznik obrazka";
$GLOBALS['strTrackerJsTag'] = "Znacznik Javascript";
$GLOBALS['strPeriod'] = "Okres";
$GLOBALS['strWorksheets'] = "Arkusze";
$GLOBALS['strSwitchAccount'] = "Zmień konto";
$GLOBALS['strAdditionalItems'] = "oraz dodatkowych pozycji";
$GLOBALS['strFor'] = "dla";
$GLOBALS['strFieldStartDateBeforeEnd'] = "Data 'Od' musi być wcześniejsza niż data 'Do'";
$GLOBALS['strDashboardForum'] = "Forum OpenX";
$GLOBALS['strDashboardDocs'] = "Dokumentacja OpenX";
$GLOBALS['strLinkUserHelpUser'] = "Nazwa użytkownika";
$GLOBALS['strLinkUserHelpEmail'] = "adres e-mail";
$GLOBALS['strSessionIDNotMatch'] = "Błąd cookie, zaloguj się ponownie";
$GLOBALS['strPasswordRepeat'] = "Powtórz hasło";
$GLOBALS['strInvalidEmail'] = "Format wiadomości jest niepoprawny, wpisz poprawny adres e-mail.";
$GLOBALS['strAdvertiserLimitation'] = "Wyświetlaj tylko jeden baner tego reklamodawcy na danej stronie";
$GLOBALS['strAllowAuditTrailAccess'] = "Zezwól temu użytkownikowi na dostęp do audytu";
$GLOBALS['strCampaignStatusAdded'] = "Dodana";
$GLOBALS['strCampaignStatusStarted'] = "Rozpoczęta";
$GLOBALS['strCampaignStatusRestarted'] = "Uruchomiona ponownie";
$GLOBALS['strAdserverTypeMax'] = "Rich Media - OpenX";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Do tej strefy wciąż podłączone są kampanie, jeśli ją usuniesz, kampanie przestaną działać i nie otrzymasz za nie należności.";
$GLOBALS['strCharset'] = "Zestaw znaków";
$GLOBALS['strAutoDetect'] = "Automatyczne wykrywanie";
$GLOBALS['strWarningInaccurateStats'] = "Niektóre statystyki nie zostały zaprotokołowane w strefie czasowej UTC (uniwersalny czas koordynowany), wobec czego mogą zostać wyświetlone w nieodpowiedniej strefie czasowej.";
$GLOBALS['strWarningInaccurateReadMore'] = "Dowiedz się więcej na ten temat";
$GLOBALS['strWarningInaccurateReport'] = "Niektóre statystyki w tym raporcie nie zostały zaprotokołowane w strefie czasowej UTC (uniwersalny czas koordynowany), wobec czego mogą zostać wyświetlone w nieodpowiedniej strefie czasowej.";
$GLOBALS['strUserPreferences'] = "Ustawienia użytkownika";
$GLOBALS['strChangePassword'] = "Zmień hasło";
$GLOBALS['strChangeEmail'] = "Zmień adres e-mail";
$GLOBALS['strCurrentPassword'] = "Hasło aktualne";
$GLOBALS['strChooseNewPassword'] = "Wybierz nowe hasło";
$GLOBALS['strReenterNewPassword'] = "Wpisz ponownie nowe hasło";
$GLOBALS['strNameLanguage'] = "Nazwa i język";
$GLOBALS['strNotifyPageMessage'] = "Na Twój adres e-mail wyslaliśmy wiadomość zawierającą link, który pozwoli Ci zresetować hasło i zalogować się.<br />E-mail powinien pojawić się w Twojej skrzynce w ciągu kilku minut.<br />Jeśli nie otrzymasz tej wiadomości, sprawdź swój folder Spam.<br /><a href='index.php'>Powrót do strony logowania.</a>";
$GLOBALS['strAdZoneAsscociation'] = "Powiązanie reklama - strefa";
$GLOBALS['strBinaryData'] = "Dane binarne";
$GLOBALS['strAuditTrailDisabled'] = "Opcja Audyt została wyłączona przez administratora . W następstwie nie zalogowano żadnych kolejnych zdarzeń do wyświetlenia na liście Audytu.";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Brak danych o kampaniach do wyświetlenia.</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Aktywuj opcję Audyt, aby uruchomić podgląd Kampanii";
$GLOBALS['strAdd'] = "Dodaj";
$GLOBALS['strRequiredField'] = "Pole wymagane";
$GLOBALS['strSslAccessCentralSys'] = "Aby uzyskać dostęp do strony głównej, serwer reklamowy (AdServer) musi być w stanie bezpiecznie zalogować się do naszego centralnego system, używając Secure Socket Layer (SSL).";
$GLOBALS['strInstallSslExtension'] = "Niezbędne jest zainstalowanie rozszerzenia PHP do komunikacji z SSL, bądź openssl lub curl z włączonym SSL. Aby uzyskać więcej informacji skontaktuj się z administratorem systemu.";
$GLOBALS['strChoosenDisableHomePage'] = "Wybrano wyłączenie strony głównej.";
$GLOBALS['strAccessHomePage'] = "Kliknij tutaj, aby uzyskać dostęp do strony głównej";
$GLOBALS['strEditSyncSettings'] = "i edytować ustawienia synchronizacji";
$GLOBALS['strLinkUser'] = "Dodaj użytkownika";
$GLOBALS['strLinkUser_Key'] = "Dodaj <u>u</u>żytkownika";
$GLOBALS['strLastLoggedIn'] = "Ostatnio zalogowany";
$GLOBALS['strDateLinked'] = "Data zlinkowania";
$GLOBALS['strUnlink'] = "Usuń";
$GLOBALS['strUnlinkingFromLastEntity'] = "Usuwanie użytkownika z ostatniego podmiotu";
$GLOBALS['strUnlinkingFromLastEntityBody'] = "Usunięcie użytkownika z ostatniego podmiotu spowoduje usunięcie go z systemu. Czy chcesz usunąć tego użytkownika?";
$GLOBALS['strUnlinkAndDelete'] = "Odłącz i usuń użytkownika";
$GLOBALS['strUnlinkUser'] = "Usuń użytkownika";
$GLOBALS['strUnlinkUserConfirmBody'] = "Czy jesteś pewien, że chcesz usunąć użytkownika?";
$GLOBALS['strDeadLink'] = "Twój link jest nieprawidłowy.";
$GLOBALS['strNoPlacement'] = "Wybrana Kampania nie istnieje. Sprawdź <a href='{link}'>ten link</a>";
$GLOBALS['strNoAdvertiser'] = "Wybrany Reklamodawca nie istnieje. Sprawdź <a href='{link}'>ten link</a>";
$GLOBALS['strPercentRevenueSplit'] = "% Wykaz przychodów";
$GLOBALS['strPercentBasketValue'] = "% Wartość koszyka";
$GLOBALS['strAmountPerItem'] = "Kwota za sztukę";
$GLOBALS['strPercentCustomVariable'] = "% Niestandardowa zmienna";
$GLOBALS['strPercentSumVariables'] = "% Suma zmiennych";
$GLOBALS['strAdvertiserSignupLink'] = "Link do rejestracji reklamodawcy";
$GLOBALS['strAdvertiserSignupLinkDesc'] = "Aby dodać link z podpisem reklamodawcy na Twojej stronie, proszę skopiować poniższy kod HTML:";
$GLOBALS['strAdvertiserSignupOption'] = "Opcje rejestracji reklamodawcy";
$GLOBALS['strAdvertiserSignunOptionDesc'] = "Aby edytować podpis twojego reklamodawcy idź do";
$GLOBALS['strCampaignStatusPending'] = "Oczekuje";
$GLOBALS['strCampaignStatusDeleted'] = "Usunięta";
$GLOBALS['strTrackers'] = "Trackery";
$GLOBALS['strWebsiteURL'] = "Adres URL strony";
$GLOBALS['strInventoryForecasting'] = "Prognozowanie dla zasobów";
$GLOBALS['strPerSingleImpression'] = "na pojedynczą odsłonę";
$GLOBALS['strWithXBanners'] = "%d baner(y)";
$GLOBALS['strTrackerCodeSubject'] = "Dodaj kod trackera";
$GLOBALS['strStatsArea'] = "Obszar";
$GLOBALS['strNoExpirationEstimation'] = "Obecnie bezterminowo";
$GLOBALS['strDaysAgo'] = "dni temu";
$GLOBALS['strCampaignStop'] = "Zatrzymanie kampanii";
$GLOBALS['strErrorEditingCampaignRevenue'] = "nieprawidłowy format numeru w polu informacji o dochodach";
$GLOBALS['strErrorEditingZone'] = "Błąd w aktualizacji strefy:";
$GLOBALS['strUnableToChangeZone'] = "Nie można wprowadzić tej zmiany, ponieważ:";
$GLOBALS['strErrorEditingZoneTechnologyCost'] = "nieprawidłowy format numeru w polu Koszty Mediów";
$GLOBALS['strErrorEditingZoneCost'] = "nieprawidłowy format numeru w polu Koszty technologiczne";
$GLOBALS['strLanguageTimezonePreferences'] = "Ustawienia języka oraz strefy czasowej";
$GLOBALS['strColumnName'] = "Nazwa kolumny";
$GLOBALS['strShowColumn'] = "Pokaż kolumnę";
$GLOBALS['strCustomColumnName'] = "Niestandardowa nazwa kolumny";
$GLOBALS['strColumnRank'] = "Ranga kolumny";
$GLOBALS['strCost'] = "Koszt";
$GLOBALS['strNumberOfItems'] = "Ilość jednostek";
$GLOBALS['strRevenueCPC'] = "Dochody CPC";
$GLOBALS['strCostCPC'] = "Koszty CPC";
$GLOBALS['strIncome'] = "Dochód";
$GLOBALS['strIncomeMargin'] = "Marża dochodu";
$GLOBALS['strProfit'] = "Zysk";
$GLOBALS['strMargin'] = "Marża";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strEPPM'] = "EPPM";
$GLOBALS['strEPPC'] = "EPPC";
$GLOBALS['strEPPS'] = "EPPS";
$GLOBALS['strCheckForUpdates'] = "Sprawdź dostępne aktualizacje";
$GLOBALS['strFromVersion'] = "Z wersji";
$GLOBALS['strToVersion'] = "Do wersji";
$GLOBALS['strToggleDataBackupDetails'] = "Przełącz do szczegółów danych kopii zapasowej";
$GLOBALS['strClickViewBackupDetails'] = "kliknij aby zobaczyć szczegóły kopii zapasowej";
$GLOBALS['strClickHideBackupDetails'] = "kliknij aby ukryć szczegóły kopii zapasowej";
$GLOBALS['strShowBackupDetails'] = "Pokaż szczegóły kopii zapasowej danych";
$GLOBALS['strHideBackupDetails'] = "Ukryj szczegóły kopii zapasowej danych";
$GLOBALS['strInstallation'] = "Instalacja";
$GLOBALS['strBackupDeleteConfirm'] = "Czy na pewno chcesz usunąć wszystkie kopie zapasowe utworzone z tego uaktualnienia?";
$GLOBALS['strDeleteArtifacts'] = "Usuń artefakty";
$GLOBALS['strArtifacts'] = "Atrefakty";
$GLOBALS['strBackupDbTables'] = "Kopia zapasowa tabel bazy danych";
$GLOBALS['strLogFiles'] = "Pliki protokołowania";
$GLOBALS['strConfigBackups'] = "Konfiguracja kopii zapasowych";
$GLOBALS['strUpdatedDbVersionStamp'] = "Zaktualizowano wersję znaczka bazy danych";
$GLOBALS['strAgencies'] = "Konta";
$GLOBALS['strModifychannel'] = "Edycja kanału targetowania";
$GLOBALS['strPwdRecEmailSent'] = "E-mail z odzyskanym hasłem został wysłany";
$GLOBALS['strAccount'] = "Konto";
$GLOBALS['strAccountUserAssociation'] = "Połączenie konto - użytkownik";
$GLOBALS['strImage'] = "Obraz";
$GLOBALS['strCampaignZoneAssociation'] = "Połączenie strefa - kampania";
$GLOBALS['strAccountPreferenceAssociation'] = "Połączenie konto - preferencje";
$GLOBALS['strUnsavedChanges'] = "Nie zapisałeś zmian na tej stronie. Pamiętaj, aby nacisnąć przycisk \"Zapisz zmiany\" kiedy skończysz.";
$GLOBALS['strDeliveryLimitationsDisagree'] = "OSTRZEŻENIE: Ograniczenia maszyny dostarczania <strong>NIE SĄ ZGODNE</strong> z ograniczeniami przedstawionymi poniżej<br /> Proszę nacisnąć ZAPISZ ZMIANY, aby aktualizować reguły dla maszyny dostarczania";
$GLOBALS['strPendingConversions'] = "Konwersje oczekujące";
$GLOBALS['strImpressionSR'] = "Odsłona (współczynnik sprzedaży)";
$GLOBALS['strClickSR'] = "Kliknięcie (współczynnik sprzedaży)";
$GLOBALS['str_cs'] = "Czeski";
$GLOBALS['str_de'] = "Niemiecki";
$GLOBALS['str_en'] = "Angielski";
$GLOBALS['str_es'] = "Hiszpański";
$GLOBALS['str_fa'] = "Perski";
$GLOBALS['str_fr'] = "Francuski";
$GLOBALS['str_he'] = "Hebrajski";
$GLOBALS['str_hu'] = "Węgierski";
$GLOBALS['str_id'] = "Indonezyjski";
$GLOBALS['str_it'] = "Włoski";
$GLOBALS['str_ja'] = "Japoński";
$GLOBALS['str_ko'] = "Koreański";
$GLOBALS['str_nl'] = "Duński";
$GLOBALS['str_pl'] = "Polski";
$GLOBALS['str_pt_BR'] = "Portugalski Brazylia";
$GLOBALS['str_ro'] = "Rumuński";
$GLOBALS['str_ru'] = "Rosyjski";
$GLOBALS['str_sl'] = "Słoweński";
$GLOBALS['str_tr'] = "Turecki";
$GLOBALS['str_zh_CN'] = "Chiński (pismo uproszczone)";
$GLOBALS['strGlobalSettings'] = "Ustawienia ogólne";
$GLOBALS['strMyAccount'] = "Moje konto";
$GLOBALS['strSwitchTo'] = "Przełącz na";
$GLOBALS['strRevenue'] = "Dochód";
$GLOBALS['str_ar'] = "Arabski";
$GLOBALS['str_bg'] = "Bułgarski";
$GLOBALS['str_cy'] = "Walijski";
$GLOBALS['str_da'] = "Duński";
$GLOBALS['str_el'] = "Grecki";
$GLOBALS['str_hr'] = "Chorwacki";
$GLOBALS['str_lt'] = "Litewski";
$GLOBALS['str_ms'] = "Malajski";
$GLOBALS['str_nb'] = "Norweski";
$GLOBALS['str_sk'] = "Słowacki";
$GLOBALS['str_sv'] = "Szwedzki";
$GLOBALS['str_uk'] = "Ukraiński";
$GLOBALS['str_zh_TW'] = "Chiński (pismo tradycyjne)";
$GLOBALS['strDashboardErrorCode'] = "kod";
$GLOBALS['strDashboardGenericError'] = "Typowy błąd";
$GLOBALS['strDashboardSystemMessage'] = "Wiadomość systemowa";
$GLOBALS['strDashboardErrorHelp'] = "Jeśli błąd będzie się powtarzał proszę opisz problem szczegółowo na <a href='http://forum.openx.org/'>forum OpenX</a>.";
$GLOBALS['strDashboardErrorMsg800'] = "błąd połączenia XML-RPC";
$GLOBALS['strDashboardErrorMsg801'] = "Nie uwierzytelniono";
$GLOBALS['strDashboardErrorMsg802'] = "błąd CAPTCHA";
$GLOBALS['strDashboardErrorMsg803'] = "Nieprawidłowe parametry";
$GLOBALS['strDashboardErrorMsg804'] = "Nazwa użytkownika jest niepoprawna";
$GLOBALS['strDashboardErrorMsg805'] = "Platforma nie istnieje";
$GLOBALS['strDashboardErrorMsg806'] = "błąd serwera";
$GLOBALS['strDashboardErrorMsg807'] = "Nieautoryzowany";
$GLOBALS['strDashboardErrorMsg808'] = "XML-RPC wersji nie są obsługiwane";
$GLOBALS['strDashboardErrorMsg900'] = "błąd transportu kodu";
$GLOBALS['strDashboardErrorMsg821'] = "Błąd autoryzacji M2M - zabroniony typ konta";
$GLOBALS['strDashboardErrorMsg822'] = "Błąd autoryzacji M2M - hasło już stworzone";
$GLOBALS['strDashboardErrorMsg823'] = "Błąd autoryzacji M2M - nieprawidłowe hasło";
$GLOBALS['strDashboardErrorMsg824'] = "Błąd autoryzacji M2M - hasło wygasło";
$GLOBALS['strDashboardErrorMsg825'] = "Błąd autoryzacji M2M - brak połączenia";
$GLOBALS['strDashboardErrorMsg826'] = "Błąd autoryzacji M2M - brak ponownego połączenia";
$GLOBALS['strDashboardErrorDsc800'] = "Dla niektórych widżetów panel pobiera informacje z serwera centralnego. Jest kilka rzeczy, które mogą mieć na to wpływ.<br /> Twój serwer może nie mieć włączonego rozszerzenia Curl. Być może trzeba zainstalować lub włączyć rozszerzenie Curl, sprawdź <a href='http://php.net/curl'>tutaj</a>, aby otrzymać więcej szczegółów.<br />	                                           Należy również sprawdzić, czy zapora nie blokuje połączeń wychodzących.";
$GLOBALS['strDashboardErrorDsc803'] = "Błąd we wniosku do serwera - błędne parametry, proszę poprawić swoje dane";
$GLOBALS['strDashboardErrorDsc805'] = "Połączenie XML-RPC nie zostało dopuszczone podczas instalacji OpenX i centralny serwer OpenX nie uznaje Twojej instalacji OpenX za prawidłową.<br />	                                           Przejdź do konta administratora: Moje konto -> Aktualizacje produktów, aby połączyć się i zarejestrować w serwerze centralnym.";
$GLOBALS['strActions'] = "Operacje";
$GLOBALS['strAdditionalInformation'] = "Informacje dodatkowe";
$GLOBALS['strDashboardCantBeDisplayed'] = "Panel nawigacyjny nie może zostać wyświetlony";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";
$GLOBALS['strNoClientsForBanners'] = "Na obecną chwilę nie określeno żadnych reklamodawców. Aby utworzyć kampanię najpierw <a href='advertiser-edit.php'> dodaj nowego reklamodawcę</a> i kampanię.";
$GLOBALS['strAdvertiserCampaigns'] = "Kampanie Reklamodawcy";
$GLOBALS['strNoWebsitesAndZones'] = "Brak stron i stref";
$GLOBALS['strNoWebsitesAndZonesCategory'] = "w kategorii";
$GLOBALS['strNoWebsitesAndZonesText'] = "z \"%s\" w nazwie";
$GLOBALS['strCampaignStatusInactive'] = "Nieaktywna";
$GLOBALS['strCampaignType'] = "Typ kampanii";
$GLOBALS['strContract'] = "Kontrakt";
$GLOBALS['strStandardContract'] = "Kontrakt";
$GLOBALS['strBannerToCampaign'] = "Twoja kampania";
$GLOBALS['strBannersOfCampaign'] = "w";
$GLOBALS['strWebsiteZones'] = "Strefy Strony";
$GLOBALS['strZoneToWebsite'] = "Brak Stron";
$GLOBALS['strNoZonesAddWebsite'] = "Na obecną chwilę nie określeno żadnych stron internetowych. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strZonesOfWebsite'] = "w";
$GLOBALS['strConfiguration'] = "Konfiguracja";
$GLOBALS['strPluginPreferences'] = "Ustawienia wtyczek";
$GLOBALS['strRevenue_short'] = "Doch.";
$GLOBALS['strCost_short'] = "Koszt";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Ilość jedn.";
$GLOBALS['strRevenueCPC_short'] = "Doch. CPC";
$GLOBALS['strCostCPC_short'] = "Koszty CPC";
$GLOBALS['strTechnologyCost_short'] = "Koszty tech.";
$GLOBALS['strIncome_short'] = "Dochód";
$GLOBALS['strIncomeMargin_short'] = "Marża przych.";
$GLOBALS['strProfit_short'] = "Zysk";
$GLOBALS['strMargin_short'] = "Marża";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strEPPM_short'] = "EPPM";
$GLOBALS['strEPPC_short'] = "EPPC";
$GLOBALS['strEPPS_short'] = "EPPS";
$GLOBALS['strChannelToWebsite'] = "Brak Stron";
$GLOBALS['strChannelsOfWebsite'] = "w";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Niektóre limity dostarczania podają nieprawidłowe wartości:";
$GLOBALS['strConfirmDeleteClients'] = "Czy na pewno chcesz usunąć wybranych reklamodawców?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Czy na pewno chcesz usunąć wybrane kampanie?";
$GLOBALS['strConfirmDeleteTrackers'] = "Czy na pewno chcesz usunąć wybrane trackery?";
$GLOBALS['strNoBannersAddCampaign'] = "Obecnie nie istnieją żadne zdefiniowane strony internetowe. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strNoBannersAddAdvertiser'] = "Obecnie nie istnieją żadne zdefiniowane strony internetowe. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strConfirmDeleteBanners'] = "Czy na pewno chcesz usunąć wybrane banery?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Czy na pewno chcesz usunąć wybrane strony?";
$GLOBALS['strConfirmDeleteZones'] = "Czy na pewno chcesz usunąć wybrane strefy?";
$GLOBALS['strErrorDatabaseConnetion'] = "Błąd połączenia z bazą danych.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Błąd krytyczny. %s nie może połączyć się z bazą danych. Interfejs administratora jest niedostępny. Dostarczanie banerów również może zostać zakłócone. Przyczyny zaistniałego problemu mogą być następujące: <ul> <li>Serwer bazy danych nie działa w danej chwili</li> <li>Lokalizacja serwera bazy danych uległa zmianie</li> <li>Nazwa użytkownika bądź hasło używane do łączenia się z serwerem bazy danych jest niepoprawne</li> <li>PHP nie załadował rozwinięcia MySQL.";
$GLOBALS['strActualImpressions'] = "Odsłony";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "żąd.";
$GLOBALS['strClicks_short'] = "Kliknięcia";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Konw.";
$GLOBALS['strPendingConversions_short'] = "Konw. oczekujące";
$GLOBALS['strClickSR_short'] = "Kliknięcie (współczynnik sprzedaży)";
$GLOBALS['strNoChannelsAddWebsite'] = "Obecnie nie istnieją żadne zdefiniowane strony internetowe. Aby utworzyć strefę najpierw <a href='affiliate-edit.php'> dodaj nową stronę internetową </ a> .";
$GLOBALS['strConfirmDeleteChannels'] = "Czy na pewno chcesz usunąć wybrane kanały targetowania?";
$GLOBALS['strUpdateSettings'] = "Ustawienia aktualizacji";
$GLOBALS['strSite'] = "Rozmiar";
$GLOBALS['strHiddenWebsite'] = "Strona";
$GLOBALS['strYouHaveNoCampaigns'] = "Reklamodawcy i Kampanie";
$GLOBALS['strSyncSettings'] = "Ustawienia synchronizacji";
$GLOBALS['strEnableCookies'] = "Przed rozpoczęciem korzystania z ". MAX_PRODUCT_NAME ." należy aktywować pliki cookie";
$GLOBALS['strHideInactiveOverview'] = "Ukryj nieaktywne elementy na wszystkich stronach podglądu";
$GLOBALS['strHiddenPublisher'] = "Strona";
$GLOBALS['strDefaultConversionRules'] = "Domyślne zasady konwersji";
$GLOBALS['strClickWindow'] = "Odstęp między kliknięciami";
$GLOBALS['strViewWindow'] = "Odstęp między wyświetleniami";
$GLOBALS['strAppendNewTag'] = "Dodaj nowy znacznik";
$GLOBALS['strMoveUp'] = "Do góry";
$GLOBALS['strMoveDown'] = "Do dołu";
$GLOBALS['strRestart'] = "Restart";
$GLOBALS['strRegexMatch'] = "Regex pasuje";
$GLOBALS['strRegexNotMatch'] = "Regex nie pasuje";
$GLOBALS['strIsAnyOf'] = "jest którymkolwiek spośród";
$GLOBALS['strIsNotAnyOf'] = "nie jest żadnym spośród";
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingBanner']['limit'] = "Ogranicz wyświetlenia banera do:";
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['limit'] = "Ogranicz wyświetlenia kampanii do:";
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['limit'] = "Ogranicz wyświetlenia stref do:";
$GLOBALS['strPickCategory'] = "\- wybierz kategorię -";
$GLOBALS['strPickCountry'] = "\- wybierz kraj -";
$GLOBALS['strPickLanguage'] = "\- wybierz język -";
$GLOBALS['strKeywordStatistics'] = "Statystyki na temat słów kluczowych";
$GLOBALS['strNoWebsites'] = "Brak Stron";
$GLOBALS['strSomeWebsites'] = "Kilka Stron";
$GLOBALS['strVariableHiddenTo'] = "Zmienna ukryta w";
$GLOBALS['strHide'] = "Ukryj:";
$GLOBALS['strShow'] = "Pokaż:";
$GLOBALS['strInstallWelcome'] = "Witaj w ". MAX_PRODUCT_NAME ." ";
$GLOBALS['strTimezoneInformation'] = "Informacje o strefach czasowych (zmiana strefy czasowej wpłynie na statystyki)";
$GLOBALS['strDebugSettings'] = "Protokołowanie diagnostyczne";
$GLOBALS['strDeliveryBanner'] = "Ogólne ustawienia dostraczania banerów";
$GLOBALS['strIncovationDefaults'] = "Domyślne ustawienia kodu wywołującego";
$GLOBALS['strStatisticsLogging'] = "Ogólne ustawienia protokołowania";
$GLOBALS['strMaintenaceSettings'] = "Ogólne ustawienia konserwacji";
$GLOBALS['strMaintenanceAdServerInstalled'] = "Przetwórz statystyki dla modułu AdServer";
$GLOBALS['strMaintenanceTrackerInstalled'] = "Przetwórz statystyki dla modułu Tracker";
$GLOBALS['strMaintenanceCompactStats'] = "Usunąć surowe statystyki po przetworzeniu";
$GLOBALS['strMaintenanceCompactStatsGrace'] = "Okres prolongaty przed usunięciem przetworzonych statystyk (w sekundach)";
$GLOBALS['strWarnCompactStatsGrace'] = "Okres prolongaty dla statystyk skrótowych musi być dodatnią liczbą całkowitą";
$GLOBALS['strIn'] = "w";
$GLOBALS['strEventDetails'] = "Szczegóły zdarzenia";
$GLOBALS['strEventHistory'] = "Historia zdarzenia";
$GLOBALS['strLinkNewUser_Key'] = "Podłącz <u>u</u>żytkownika";
$GLOBALS['strLinkUserHelp'] = "Aby dodać <b> istniejącego użytkownika </ b>, wpisz jego nazwę %s, a następnie kliknij przycisk {$GLOBALS['strLinkUser']} <br /> Aby dodać <b> nowego użytkownika </ b>, wpisz wymagane pola% s, a następnie kliknij przycisk {$GLOBALS['strLinkUser']}";
$GLOBALS['strOpenadsImpressionsRemaining'] = "Pozostałe odsłony OpenX";
$GLOBALS['strOpenadsImpressionsRemainingHelp'] = "Ilość odsłon kampanii jest zbyt mała, aby pokryć ilość odsłon zamówionych przez reklamodawcę. Oznacza to, że ilość pozostałych kliknięć jest mniejsza niż zamówiona i powinieneś zwiększyć ilość zamówionych odsłon o brakującą wartość.";
$GLOBALS['strOpenadsClicksRemaining'] = "Pozostałe kliknięcia OpenX";
$GLOBALS['strOpenadsConversionsRemaining'] = "Pozostałe konwersje OpenX";
$GLOBALS['strNoDataToDisplay'] = "Brak danych do wyświetlenia.";
$GLOBALS['strDisagreeACL_BannersExplaination'] = "W pewnych okolicznościach mechanizm dostarczania może nie być kompatybilny z listami ACL dla banerów i kanałów, użyj tego linku, aby sprawdzić poprawność list ACL w bazie danych";
$GLOBALS['strHomePageDisabled'] = "Twoja strona główna jest wyłączona";
$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Duży Baner (468 x 60 )";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Mały przycisk (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Duży przycisk (120 x 90)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Połowa banera (234 x 60)";
$GLOBALS['strIab']['IAB_LeaderBoard(728x90)*'] = "IAB Pionowy baner (728 x 90)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Kwadratowy przycisk(125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Prostokąt (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Kwadratowy Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Pionowy Baner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Średni prostokąt (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Duży prostokąt (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Pionowy prostokąt (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Szeroki Skyscraper (160 x 600)";
$GLOBALS['strRevenueShort'] = "Doch.";
$GLOBALS['strCostShort'] = "Koszt";
$GLOBALS['strBasketValueShort'] = "BV";
$GLOBALS['strNumberOfItemsShort'] = "Ilość jedn.";
$GLOBALS['strRevenueCPCShort'] = "Doch. CPC";
$GLOBALS['strCostCPCShort'] = "Koszty CPC";
$GLOBALS['strTechnologyCostShort'] = "Koszty tech.";
$GLOBALS['strIncomeShort'] = "Dochód";
$GLOBALS['strIncomeMarginShort'] = "Marża przych.";
$GLOBALS['strProfitShort'] = "Zysk";
$GLOBALS['strMarginShort'] = "Marża";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "AKTUALIZACJA ZAKOŃCZONA";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "AKTUALIZACJA NIE POWIOD�?A SIĘ";
$GLOBALS['strConversionsShort'] = "Konw.";
$GLOBALS['strPendingConversionsShort'] = "Konw. oczekujące";
$GLOBALS['strClickSRShort'] = "Kliknięcie (współczynnik sprzedaży)";
$GLOBALS['phpAds_hlp_my_header'] = "Tutaj należy umieścić ścieżkę do nagłówka plików (np.: / home / login / www / header.htm), aby mieć nagłówek i/lub stopkę na każdej stronie w interfejsie administratora. W tych plikach możesz umieścić tekst lub html (jeśli chcesz używać HTML w jednym lub obu plikach nie używaj tagów tak jak <body> lub <html>).";
$GLOBALS['strReportBug'] = "Zgłoś błąd";
$GLOBALS['strSameWindow'] = "To samo okno";
$GLOBALS['strNewWindow'] = "Nowe okno";
$GLOBALS['strClick-ThroughRatio'] = "Wskaźnik liczby kliknięć (CTR)";
$GLOBALS['strImpressionSRShort'] = "Odsłona (WS)";
$GLOBALS['strRequestsShort'] = "żąd.";
$GLOBALS['strClicksShort'] = "Kliknięcia";
$GLOBALS['strImpressionsShort'] = "Odsłony";
$GLOBALS['strCampaignTracker'] = "Tracker Kampanii";
$GLOBALS['strVariable'] = "Zmienna";
$GLOBALS['strAffiliateExtra'] = "Dodatkowe informacje na temat strony";
$GLOBALS['strPreference'] = "Preferencje";
$GLOBALS['strAccountUserPermissionAssociation'] = "Powiązanie konto - uprawnienia użytkownika";
$GLOBALS['strDeliveryLimitation'] = "Limit dostarczania";
$GLOBALS['strSaveAnyway'] = "Zapisz";
$GLOBALS['str_ID'] = "ID";
$GLOBALS['str_Requests'] = "Próby wywołania";
$GLOBALS['str_Impressions'] = "Odsłony";
$GLOBALS['str_Clicks'] = "Kliknięcia";
$GLOBALS['str_CTR'] = "CTR";
$GLOBALS['str_BasketValue'] = "Wartość koszyka";
$GLOBALS['str_TechnologyCost'] = "Koszty technologiczne";
?>