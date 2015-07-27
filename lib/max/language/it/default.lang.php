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
$GLOBALS['date_format'] = "%d-%m-%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%d-%m";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#.##0;-#.##0;-";
$GLOBALS['excel_decimal_formatting'] = "#.##0,000;-#.##0,000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Home";
$GLOBALS['strHelp'] = "Aiuto";
$GLOBALS['strStartOver'] = "Inizia da capo";
$GLOBALS['strShortcuts'] = "Scorciatoie";
$GLOBALS['strActions'] = "Azioni";
$GLOBALS['strAndXMore'] = "e %s altri";
$GLOBALS['strAdminstration'] = "Inventario";
$GLOBALS['strMaintenance'] = "Manutenzione";
$GLOBALS['strProbability'] = "Probabilità";
$GLOBALS['strInvocationcode'] = "Codice di invocazione";
$GLOBALS['strBasicInformation'] = "Informazioni di base";
$GLOBALS['strAppendTrackerCode'] = "Aggiungi codice tracker";
$GLOBALS['strOverview'] = "Descrizione";
$GLOBALS['strSearch'] = "<u>C</u>erca";
$GLOBALS['strDetails'] = "Dettagli";
$GLOBALS['strUpdateSettings'] = "Impostazioni aggiornamenti";
$GLOBALS['strCheckForUpdates'] = "Controlla aggiornamenti";
$GLOBALS['strWhenCheckingForUpdates'] = "Durante la ricerca degli aggiornamenti";
$GLOBALS['strCompact'] = "Compatte";
$GLOBALS['strUser'] = "Utente";
$GLOBALS['strDuplicate'] = "Duplicato";
$GLOBALS['strCopyOf'] = "Copia di ";
$GLOBALS['strMoveTo'] = "Muovi verso";
$GLOBALS['strDelete'] = "Elimina";
$GLOBALS['strActivate'] = "Attiva";
$GLOBALS['strConvert'] = "Converti";
$GLOBALS['strRefresh'] = "Aggiorna";
$GLOBALS['strSaveChanges'] = "Salva modifiche";
$GLOBALS['strUp'] = "Su";
$GLOBALS['strDown'] = "Giù";
$GLOBALS['strSave'] = "Salva";
$GLOBALS['strCancel'] = "Annulla";
$GLOBALS['strBack'] = "Indietro";
$GLOBALS['strPrevious'] = "Precedente";
$GLOBALS['strNext'] = "Successivo";
$GLOBALS['strYes'] = "Sì";
$GLOBALS['strNo'] = "No";
$GLOBALS['strNone'] = "Nessuno";
$GLOBALS['strCustom'] = "Personalizzato";
$GLOBALS['strDefault'] = "Predefinito";
$GLOBALS['strUnknown'] = "Sconosciuto";
$GLOBALS['strUnlimited'] = "Illimitato";
$GLOBALS['strUntitled'] = "Senza nome";
$GLOBALS['strAll'] = "tutto";
$GLOBALS['strAverage'] = "Media";
$GLOBALS['strOverall'] = "Totale";
$GLOBALS['strTotal'] = "Totale";
$GLOBALS['strFrom'] = "Da";
$GLOBALS['strTo'] = "a";
$GLOBALS['strAdd'] = "Aggiungi";
$GLOBALS['strLinkedTo'] = "collegato a";
$GLOBALS['strDaysLeft'] = "Giorni mancanti";
$GLOBALS['strCheckAllNone'] = "Seleziona tutti / nessuno";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>E</u>spandi tutti";
$GLOBALS['strCollapseAll'] = "<u>C</u>hiudi tutti";
$GLOBALS['strShowAll'] = "Mostra tutto";
$GLOBALS['strNoAdminInterface'] = "L'interfaccia di amministrazione non è accessibile per manutenzione. La consegna delle tue campagne avverrà normalmente.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La data di inizio deve essere antecedente alla data di fine";
$GLOBALS['strFieldContainsErrors'] = "I seguenti campi contengono errori:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Prima di continuare è necessario";
$GLOBALS['strFieldFixBeforeContinue2'] = "per correggere questi errori.";
$GLOBALS['strMiscellaneous'] = "Varie";
$GLOBALS['strCollectedAllStats'] = "Tutte le statistiche";
$GLOBALS['strCollectedToday'] = "Oggi";
$GLOBALS['strCollectedYesterday'] = "Ieri";
$GLOBALS['strCollectedThisWeek'] = "Questa settimana";
$GLOBALS['strCollectedLastWeek'] = "Scorsa settimana";
$GLOBALS['strCollectedThisMonth'] = "Questo mese";
$GLOBALS['strCollectedLastMonth'] = "Scorso mese";
$GLOBALS['strCollectedLast7Days'] = "Ultimi 7 giorni";
$GLOBALS['strCollectedSpecificDates'] = "Date specifiche";
$GLOBALS['strValue'] = "Valore";
$GLOBALS['strWarning'] = "Attenzione";
$GLOBALS['strNotice'] = "Notifica";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "La dashboard non può essere visualizzata";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "codice";
$GLOBALS['strDashboardSystemMessage'] = "Messaggio di sistema";
$GLOBALS['strDashboardErrorHelp'] = "Se questo errore si ripete per favore descrivi il tuo problema nel dettaglio e pubblicalo sui <a href='http://forum.openx.org/'>forum OpenX</a>.";

// Priority
$GLOBALS['strPriority'] = "Priorità";
$GLOBALS['strPriorityLevel'] = "Livello di priorità";
$GLOBALS['strOverrideAds'] = "Banner provenienti da campagne \"Override\"";
$GLOBALS['strHighAds'] = "Banner provenienti da campagne a contratto";
$GLOBALS['strECPMAds'] = "Banner provenienti da campagne eCPM";
$GLOBALS['strLowAds'] = "Banner provenienti da campagne Remnant";
$GLOBALS['strLimitations'] = "Limitazioni";
$GLOBALS['strNoLimitations'] = "Nessuna limitazione";
$GLOBALS['strCapping'] = "Capping";

// Properties
$GLOBALS['strName'] = "Nome";
$GLOBALS['strSize'] = "Dimensioni";
$GLOBALS['strWidth'] = "Larghezza";
$GLOBALS['strHeight'] = "Altezza";
$GLOBALS['strTarget'] = "Frame destinazione";
$GLOBALS['strLanguage'] = "Lingua";
$GLOBALS['strDescription'] = "Descrizione";
$GLOBALS['strVariables'] = "Variabili";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Commenti";

// User access
$GLOBALS['strWorkingAs'] = "Lavora come";
$GLOBALS['strWorkingAs_Key'] = "<u>L</u>avorando come";
$GLOBALS['strWorkingAs'] = "Lavora come";
$GLOBALS['strSwitchTo'] = "Passa a";
$GLOBALS['strWorkingFor'] = "%s per...";
$GLOBALS['strNoAccountWithXInNameFound'] = "Nessun account con \"%s\" nel nome trovato";
$GLOBALS['strRecentlyUsed'] = "Utilizzati di recente";
$GLOBALS['strLinkUser'] = "Aggiungi utente";
$GLOBALS['strLinkUser_Key'] = "Aggiungi <u>u</u>tente";
$GLOBALS['strUsernameToLink'] = "Nome dell’utente da aggiungere";
$GLOBALS['strNewUserWillBeCreated'] = "Il nuovo utente verrà creato";
$GLOBALS['strToLinkProvideEmail'] = "Per aggiungere l’utente si deve fornire la sua e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Per aggiungere l’utente si deve fornire il suo nome utente";
$GLOBALS['strUserLinkedToAccount'] = "L’utente è stato aggiunto all’account";
$GLOBALS['strUserAccountUpdated'] = "Account utente aggiornato";
$GLOBALS['strUserUnlinkedFromAccount'] = "L’utente è stato rimosso dall’account";
$GLOBALS['strUserWasDeleted'] = "L’utente è stato eliminato";
$GLOBALS['strUserNotLinkedWithAccount'] = "Tale utente non è collegato con l`account";
$GLOBALS['strCantDeleteOneAdminUser'] = "Non puoi cancellare l`utente. Almeno un altro utente necessita di essere collegato con l`account di amministrazione.";
$GLOBALS['strLinkUserHelpUser'] = "nome utente";
$GLOBALS['strLinkUserHelpEmail'] = "indirizzo email";
$GLOBALS['strLastLoggedIn'] = "Ultimo accesso";
$GLOBALS['strDateLinked'] = "Data collegata";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Accesso utente";
$GLOBALS['strAdminAccess'] = "Accesso Amministratore";
$GLOBALS['strUserProperties'] = "Proprietà utente";
$GLOBALS['strPermissions'] = "Permessi";
$GLOBALS['strAuthentification'] = "Autenticazione";
$GLOBALS['strWelcomeTo'] = "Benvenuto su";
$GLOBALS['strEnterUsername'] = "Inserisci il tuo nome utente e la tua password per accedere";
$GLOBALS['strEnterBoth'] = "È necessario inserire sia nome utente che password";
$GLOBALS['strEnableCookies'] = "Devi abilitare i cookies prima di poter usare {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Errore nel cookie di sessione, per favore entra nuovamente.";
$GLOBALS['strLogin'] = "Nome utente";
$GLOBALS['strLogout'] = "Esci";
$GLOBALS['strUsername'] = "Nome utente";
$GLOBALS['strPassword'] = "Password";
$GLOBALS['strPasswordRepeat'] = "Ripeti la password";
$GLOBALS['strAccessDenied'] = "Accesso negato";
$GLOBALS['strUsernameOrPasswordWrong'] = "Nome utente o password non corretti. Inserire nuovamente le proprie credenziali.";
$GLOBALS['strPasswordWrong'] = "Password errata";
$GLOBALS['strNotAdmin'] = "Il tuo account non ha abbastanza privilegi per usare questa caratteristica.";
$GLOBALS['strDuplicateClientName'] = "Il nome utente fornito è già in uso, specificare un nome utente differente.";
$GLOBALS['strInvalidPassword'] = "La nuova password non è valida, utilizzare un'altra password.";
$GLOBALS['strInvalidEmail'] = "L'email non è stata inserita correttamente, per favore inserisci un indirizzo email valido.";
$GLOBALS['strNotSamePasswords'] = "Le due password inserite non coincidono";
$GLOBALS['strRepeatPassword'] = "Ripeti password";
$GLOBALS['strDeadLink'] = "Il tuo collegamento non è valido.";
$GLOBALS['strNoPlacement'] = "La campagna selezionata non esiste. Prova questo <a href='{link}'collegamento</a> invece";
$GLOBALS['strNoAdvertiser'] = "L'inserzionista selezionato non esiste. Prova questo <a href='{link}'collegamento</a> invece";

// General advertising
$GLOBALS['strRequests'] = "Richieste";
$GLOBALS['strImpressions'] = "Impressioni";
$GLOBALS['strClicks'] = "Click";
$GLOBALS['strConversions'] = "Conversioni";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Click totali";
$GLOBALS['strTotalConversions'] = "Conversioni totali";
$GLOBALS['strDateTime'] = "Data Ora";
$GLOBALS['strTrackerID'] = "Tracker ID";
$GLOBALS['strTrackerName'] = "Nome Tracker";
$GLOBALS['strTrackerImageTag'] = "Tag Immagine";
$GLOBALS['strTrackerJsTag'] = "Tag Javascript";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strCampaigns'] = "Campagne";
$GLOBALS['strCampaignID'] = "ID Campagna";
$GLOBALS['strCampaignName'] = "Nome Campagna";
$GLOBALS['strCountry'] = "Stato";
$GLOBALS['strStatsAction'] = "Azione";
$GLOBALS['strWindowDelay'] = "Ritardo finestra";
$GLOBALS['strStatsVariables'] = "Variabili";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Occupazione Mensile";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Data";
$GLOBALS['strDay'] = "Giorno";
$GLOBALS['strDays'] = "Giorni";
$GLOBALS['strWeek'] = "Settimana";
$GLOBALS['strWeeks'] = "Settimane";
$GLOBALS['strSingleMonth'] = "Mese";
$GLOBALS['strMonths'] = "Mesi";
$GLOBALS['strDayOfWeek'] = "Giorno della settimana";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Domenica';
$GLOBALS['strDayFullNames'][1] = 'Lunedì';
$GLOBALS['strDayFullNames'][2] = 'Martedì';
$GLOBALS['strDayFullNames'][3] = 'Mercoledì';
$GLOBALS['strDayFullNames'][4] = 'Giovedì';
$GLOBALS['strDayFullNames'][5] = 'Venerdì';
$GLOBALS['strDayFullNames'][6] = 'Sabato';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'Do';
$GLOBALS['strDayShortCuts'][1] = 'Lu';
$GLOBALS['strDayShortCuts'][2] = 'Ma';
$GLOBALS['strDayShortCuts'][3] = 'Me';
$GLOBALS['strDayShortCuts'][4] = 'Gi';
$GLOBALS['strDayShortCuts'][5] = 'Ve';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "Ora";
$GLOBALS['strSeconds'] = "secondi";
$GLOBALS['strMinutes'] = "minuti";
$GLOBALS['strHours'] = "ore";

// Advertiser
$GLOBALS['strClient'] = "Inserzionista";
$GLOBALS['strClients'] = "Inserzionisti";
$GLOBALS['strClientsAndCampaigns'] = "Inserzionisti e Campagne";
$GLOBALS['strAddClient'] = "Aggiungi un nuovo inserzionista";
$GLOBALS['strClientProperties'] = "Impostazioni inserzionista";
$GLOBALS['strClientHistory'] = "Storico inserzionista";
$GLOBALS['strNoClients'] = "Non è stato definito alcun inserzionista. Per creare una campagna, prima <a href='advertiser-edit.php'>aggiungi un inserzionista</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Vuoi veramente eliminare questo inserzionista?";
$GLOBALS['strConfirmDeleteClients'] = "Vuoi veramente eliminare questo inserzionista?";
$GLOBALS['strHideInactive'] = "Nascondere inattivi/e";
$GLOBALS['strInactiveAdvertisersHidden'] = "inserzionisti inattivi nascosti";
$GLOBALS['strAdvertiserSignup'] = "Registrazione inserzionisti";
$GLOBALS['strAdvertiserCampaigns'] = "Inserzionisti e Campagne";

// Advertisers properties
$GLOBALS['strContact'] = "Contatto";
$GLOBALS['strContactName'] = "Nome del contatto";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Spedisci report della campagna via Email";
$GLOBALS['strNoDaysBetweenReports'] = "numero di giorni tra rapporti";
$GLOBALS['strSendDeactivationWarning'] = "Spedisci un avvertimento quando la campagna viene disattivata";
$GLOBALS['strAllowClientModifyBanner'] = "Permetti a questo utente di modificare i propri banner";
$GLOBALS['strAllowClientDisableBanner'] = "Permetti a questo utente di disattivare i propri banner";
$GLOBALS['strAllowClientActivateBanner'] = "Permetti a questo utente di attivare i propri banner";
$GLOBALS['strAllowCreateAccounts'] = "Permetti a questo utente di creare nuovi account";
$GLOBALS['strAdvertiserLimitation'] = "Mostra solo un banner di questo editore sulla stessa pagina web";
$GLOBALS['strAllowAuditTrailAccess'] = "Permetti a questo utente di accedere all'Audit Trail";

// Campaign
$GLOBALS['strCampaign'] = "Campagna";
$GLOBALS['strCampaigns'] = "Campagne";
$GLOBALS['strAddCampaign'] = "Aggiungi nuova campagna";
$GLOBALS['strAddCampaign_Key'] = "Aggiungi <u>n</u>uova campagna";
$GLOBALS['strLinkedCampaigns'] = "Campagne collegate";
$GLOBALS['strCampaignProperties'] = "Impostazioni campagna";
$GLOBALS['strCampaignOverview'] = "Descrizione campagne";
$GLOBALS['strCampaignHistory'] = "Storico campagna";
$GLOBALS['strNoCampaigns'] = "Attualmente non sono presenti campagne definite";
$GLOBALS['strConfirmDeleteCampaign'] = "Desideri realmente procedere alla cancellazione di questa campagna?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Desideri realmente procedere alla cancellazione di questa campagna?";
$GLOBALS['strShowParentAdvertisers'] = "Mostra inserzionisti padri";
$GLOBALS['strHideParentAdvertisers'] = "Nascondi inserzionisti padri";
$GLOBALS['strHideInactiveCampaigns'] = "Nascondi campagne inattive";
$GLOBALS['strInactiveCampaignsHidden'] = "campagne inattive nascoste";
$GLOBALS['strPriorityInformation'] = "Priorità in relazione ad altre campagne";
$GLOBALS['strECPMInformation'] = "Prioritizzazione eCPM";
$GLOBALS['strHiddenCampaign'] = "Campagna";
$GLOBALS['strHiddenAd'] = "Inserzione";
$GLOBALS['strHiddenAdvertiser'] = "Inserzionista";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strHiddenWebsite'] = "Sito";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCompanionPositioning'] = "Posizionamento del companion";
$GLOBALS['strSelectUnselectAll'] = "Seleziona / Deseleziona tutti";
$GLOBALS['strCampaignsOfAdvertiser'] = "di"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calcolato per tutte le campagne";
$GLOBALS['strCalculatedForThisCampaign'] = "Calcolato per questa campagna";
$GLOBALS['strZonesLinked'] = "zona/e collegate";
$GLOBALS['strZonesUnlinked'] = "zona/e scollegate";
$GLOBALS['strZonesSearch'] = "Cerca";
$GLOBALS['strNoWebsitesAndZonesText'] = "con \"%s\" nel nome";
$GLOBALS['strToLink'] = "collegare";
$GLOBALS['strToUnlink'] = "Scollegare";
$GLOBALS['strLinked'] = "Collegato";
$GLOBALS['strAvailable'] = "Disponibile";
$GLOBALS['strEditZone'] = "Modifica zona";
$GLOBALS['strEditWebsite'] = "Modificare sito web";


// Campaign properties
$GLOBALS['strDontExpire'] = "Non far scadere";
$GLOBALS['strActivateNow'] = "Attiva immediatamente";
$GLOBALS['strSetSpecificDate'] = "Imposta data specifica";
$GLOBALS['strLow'] = "Bassa";
$GLOBALS['strHigh'] = "Alta";
$GLOBALS['strExpirationDate'] = "Data Fine";
$GLOBALS['strExpirationDateComment'] = "La campagna finirà alla fine di questo giorno";
$GLOBALS['strActivationDate'] = "Data Inzio";
$GLOBALS['strActivationDateComment'] = "La campagna incomincerà all'inizio di questo giorno";
$GLOBALS['strImpressionsRemaining'] = "Impressioni Rimaste";
$GLOBALS['strClicksRemaining'] = "Click rimasti";
$GLOBALS['strConversionsRemaining'] = "Conversioni rimaste";
$GLOBALS['strImpressionsBooked'] = "Impressioni Prenotate";
$GLOBALS['strClicksBooked'] = "Click Prenotati";
$GLOBALS['strConversionsBooked'] = "Conversioni Prenotate";
$GLOBALS['strCampaignWeight'] = "Imposta il peso della campagna";
$GLOBALS['strAnonymous'] = "Nascondi l'inserzionista e il sito di questa campagna";
$GLOBALS['strTargetPerDay'] = "al giorno.";
$GLOBALS['strCampaignStatusPending'] = "In attesa";
$GLOBALS['strCampaignStatusInactive'] = "attiva";
$GLOBALS['strCampaignStatusRunning'] = "In funzione";
$GLOBALS['strCampaignStatusPaused'] = "In pausa";
$GLOBALS['strCampaignStatusAwaiting'] = "In attesa";
$GLOBALS['strCampaignStatusExpired'] = "Completato";
$GLOBALS['strCampaignStatusApproval'] = "In attesa di approvazione »";
$GLOBALS['strCampaignStatusRejected'] = "Rifiutata";
$GLOBALS['strCampaignStatusAdded'] = "Aggiunto";
$GLOBALS['strCampaignStatusStarted'] = "Avviato";
$GLOBALS['strCampaignStatusRestarted'] = "Riavviato";
$GLOBALS['strCampaignStatusDeleted'] = "Eliminata";
$GLOBALS['strCampaignType'] = "Nome Campagna";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strContract'] = "Contratto";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strStandardContract'] = "Contratto";
$GLOBALS['strRemnant'] = "Remnant";
$GLOBALS['strPricing'] = "Tariffe";
$GLOBALS['strPricingModel'] = "Modello di pricing";
$GLOBALS['strSelectPricingModel'] = "-- Seleziona il modello --";
$GLOBALS['strRatePrice'] = "Tariffa / prezzo";
$GLOBALS['strLimit'] = "Limite";
$GLOBALS['strWhyDisabled'] = "perché è disabilitato?";
$GLOBALS['strBackToCampaigns'] = "Torna a campagne";
$GLOBALS['strCampaignBanners'] = "Banner della campagna";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strTrackers'] = "Tracker";
$GLOBALS['strTrackerPreferences'] = "Preferenze tracker";
$GLOBALS['strAddTracker'] = "Aggiungi nuovo tracker";
$GLOBALS['strNoTrackers'] = "Attualmente non ci sono tracker definiti";
$GLOBALS['strConfirmDeleteTrackers'] = "Vuoi davvero procedere alla cancellazione di questo tracker?";
$GLOBALS['strConfirmDeleteTracker'] = "Vuoi davvero procedere alla cancellazione di questo tracker?";
$GLOBALS['strTrackerProperties'] = "Impostazioni tracker";
$GLOBALS['strDefaultStatus'] = "Stato predefinito";
$GLOBALS['strStatus'] = "Stato";
$GLOBALS['strLinkedTrackers'] = "Tracker collegati";
$GLOBALS['strConversionWindow'] = "Finestra di conversione";
$GLOBALS['strUniqueWindow'] = "Finestra unica";
$GLOBALS['strClick'] = "Click";
$GLOBALS['strView'] = "Impressione";
$GLOBALS['strArrival'] = "Arrivo";
$GLOBALS['strManual'] = "Manuale";
$GLOBALS['strImpression'] = "Impressione";
$GLOBALS['strConversionType'] = "Tipo di conversione";
$GLOBALS['strLinkCampaignsByDefault'] = "Collega automaticamente le nuove campagne appena create";
$GLOBALS['strIPAddress'] = "Indirizzo IP";

// Banners (General)
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strAddBanner'] = "Aggiungi nuovo banner";
$GLOBALS['strAddBanner_Key'] = "Aggiungi <u>n</u>uovo banner";
$GLOBALS['strBannerToCampaign'] = "Tue campagne";
$GLOBALS['strShowBanner'] = "Mostra banner";
$GLOBALS['strBannerProperties'] = "Impostazioni banner";
$GLOBALS['strBannerHistory'] = "Storico banner";
$GLOBALS['strNoBanners'] = "Non è ancora stato creato nessun banner";
$GLOBALS['strNoBannersAddCampaign'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strConfirmDeleteBanner'] = "Vuoi veramente cancellare questo banner?";
$GLOBALS['strConfirmDeleteBanners'] = "Vuoi veramente cancellare questo banner?";
$GLOBALS['strShowParentCampaigns'] = "Mostra campagne";
$GLOBALS['strHideParentCampaigns'] = "Nascondi campagne";
$GLOBALS['strHideInactiveBanners'] = "Nascondi banner inattivi";
$GLOBALS['strInactiveBannersHidden'] = "banner inattivi nascosti";
$GLOBALS['strWarningMissing'] = "Attenzione, possibile omissione";
$GLOBALS['strWarningMissingClosing'] = "chiusura del tag \">\"";
$GLOBALS['strWarningMissingOpening'] = "apertura tag \"<\"";
$GLOBALS['strSubmitAnyway'] = "Invia comunque";
$GLOBALS['strBannersOfCampaign'] = "in"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Preferenze banner";
$GLOBALS['strCampaignPreferences'] = "Preferenze campagne";
$GLOBALS['strDefaultBanners'] = "Banner predefinito";
$GLOBALS['strDefaultBannerUrl'] = "URL dell'immagine predefinita";
$GLOBALS['strDefaultBannerDestination'] = "URL di destinazione predefinito";
$GLOBALS['strTypeUrlAllow'] = "Consenti Banner Esterni";
$GLOBALS['strTypeHtmlAllow'] = "Consenti banner HTML";
$GLOBALS['strTypeTxtAllow'] = "Consentire gli annunci di testo";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Per favore seleziona il tipo di banner";
$GLOBALS['strMySQLBanner'] = "Banner locale (SQL)";
$GLOBALS['strWebBanner'] = "Banner locale (su questo Webserver)";
$GLOBALS['strURLBanner'] = "Banner esterno";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Banner testuale";
$GLOBALS['strIframeFriendly'] = "Questo banner può essere visualizzato in modo sicuro all'interno di un iframe (ad esempio non è espandibile)";
$GLOBALS['strUploadOrKeep'] = "Preferisci mantenere la<br />immagine esistente, o preferisci<br />caricarne un altra?";
$GLOBALS['strNewBannerFile'] = "Scegli <br />la immagine che vuoi <br />utilizzare per questo banner<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Seleziona l'immagine che vuoi utilizzare nel caso il browser non supporti il file multimediale";
$GLOBALS['strNewBannerURL'] = "URL immagine (http://...)";
$GLOBALS['strURL'] = "URL di destinazione (http://...)";
$GLOBALS['strKeyword'] = "Parole chiave";
$GLOBALS['strTextBelow'] = "Testo sotto immagine";
$GLOBALS['strWeight'] = "Peso";
$GLOBALS['strAlt'] = "Testo Alternativo";
$GLOBALS['strStatusText'] = "Testo di stato";
$GLOBALS['strBannerWeight'] = "Peso del banner";
$GLOBALS['strAdserverTypeGeneric'] = "Banner HTML Generico";
$GLOBALS['strGenericOutputAdServer'] = "Generico";
$GLOBALS['strSwfTransparency'] = "Permetti il background trasparente";
$GLOBALS['strBackToBanners'] = "Torna ai banner";

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Controlla links presenti all'interno del file flash";
$GLOBALS['strConvertSWFLinks'] = "Converti links Flash";
$GLOBALS['strHardcodedLinks'] = "Link codificati all'interno del file";
$GLOBALS['strConvertSWF'] = "<br />Il file Flash appena caricato contiene urls codificati. {$PRODUCT_NAME} non risulta in grado ditracciare il numero di click per questo banner fino a quando non convertirai questi urls codificati. Di seguito troverai una lista di tutti gli urls presenti nel file flash. Se vuoi convertire questi urls, semplicemente clicca <b>Converti</b>, altrimenti clicca <b>Cancella</b>.<br /><br /> Nota Bene: cliccando <b>Converti</b> il file flash che hai appena caricato viene modificato fisicamente. <br />Tieni da parte una copia di backup del file originale. Indipendentemente alla versione di flash utilizzata, il file risultante necessita del plug-in Flash 4 (o superiore).<br /><br />";
$GLOBALS['strCompressSWF'] = "Comprimi il file SWF per uno scaricamento più veloce (plug-in Flash 6 necessario)";
$GLOBALS['strOverwriteSource'] = "Sovrascrivi parametro sorgente";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Impostazioni di consegna";
$GLOBALS['strACL'] = "Consegna";
$GLOBALS['strACLAdd'] = "Aggiungi nuova limitazione";
$GLOBALS['strNoLimitations'] = "Nessuna limitazione";
$GLOBALS['strApplyLimitationsTo'] = "Applica limitazioni a";
$GLOBALS['strAllBannersInCampaign'] = "Tutti i banner in questa campagna";
$GLOBALS['strRemoveAllLimitations'] = "Rimuovi tutte le limitazioni";
$GLOBALS['strEqualTo'] = "è uguale a";
$GLOBALS['strDifferentFrom'] = "è differente da";
$GLOBALS['strLaterThan'] = "è successiva a";
$GLOBALS['strLaterThanOrEqual'] = "è successiva o uguale a";
$GLOBALS['strEarlierThan'] = "è precedente a";
$GLOBALS['strEarlierThanOrEqual'] = "è precedente o uguale a";
$GLOBALS['strContains'] = "contiene";
$GLOBALS['strNotContains'] = "non contiene";
$GLOBALS['strGreaterThan'] = "è maggiore di";
$GLOBALS['strLessThan'] = "è minore di";
$GLOBALS['strAND'] = "E";                          // logical operator
$GLOBALS['strOR'] = "O";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Mostra questo banner solo quando:";
$GLOBALS['strWeekDays'] = "Giorni della settimana";
$GLOBALS['strTime'] = "Ora";
$GLOBALS['strDomain'] = "Dominio";
$GLOBALS['strSource'] = "Risorsa";
$GLOBALS['strDeliveryLimitations'] = "Limitazioni consegna";

$GLOBALS['strDeliveryCappingReset'] = "Azzera contatore visualizzazioni dopo:";
$GLOBALS['strDeliveryCappingTotal'] = "in totale";
$GLOBALS['strDeliveryCappingSession'] = "per sessione";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['limit'] = "Limita visualizzazioni banner a:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['limit'] = "Limita visualizzazioni campagna a:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['limit'] = "Limita visualizzazioni zona a:";

// Website
$GLOBALS['strAffiliate'] = "Sito";
$GLOBALS['strAffiliates'] = "Editori";
$GLOBALS['strAffiliatesAndZones'] = "Editori e Zone";
$GLOBALS['strAddNewAffiliate'] = "Aggiungi un nuovo editore";
$GLOBALS['strAffiliateProperties'] = "Impostazioni editore";
$GLOBALS['strAffiliateHistory'] = "Storico editore";
$GLOBALS['strNoAffiliates'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Desideri realmente cancellare questo editore?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Desideri realmente cancellare questo editore?";
$GLOBALS['strInactiveAffiliatesHidden'] = "editori inattivi nascosti";
$GLOBALS['strShowParentAffiliates'] = "Mostra editori padri";
$GLOBALS['strHideParentAffiliates'] = "Nascondi editori padri";

// Website (properties)
$GLOBALS['strWebsite'] = "Sito";
$GLOBALS['strWebsiteURL'] = "URL del sito";
$GLOBALS['strAllowAffiliateModifyZones'] = "Permetti a questo utente di modificare le proprie zone";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Permetti a questo utente di collegare i banner alle proprie zone";
$GLOBALS['strAllowAffiliateAddZone'] = "Permetti a questo utente di definire nuove zone";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Permetti a questo utente di cancellare le zone esistenti";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permetti a questo utente di generare il codice di invocazione";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "CAP";
$GLOBALS['strCountry'] = "Stato";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Editori e Zone";

// Zone
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strZones'] = "Zone";
$GLOBALS['strAddNewZone'] = "Aggiungi una nuova zona";
$GLOBALS['strAddNewZone_Key'] = "Aggiungi una <u>n</u>uova zona";
$GLOBALS['strZoneToWebsite'] = "Nessun sito";
$GLOBALS['strLinkedZones'] = "Zone collegate";
$GLOBALS['strZoneProperties'] = "Impostazioni zona";
$GLOBALS['strZoneHistory'] = "Storico zona";
$GLOBALS['strNoZones'] = "Attualmente non sono presenti zone definite";
$GLOBALS['strNoZonesAddWebsite'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strConfirmDeleteZone'] = "Desideri veramente procedere alla cancellazione di questa zona?";
$GLOBALS['strConfirmDeleteZones'] = "Desideri veramente procedere alla cancellazione di questa zona?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Ci sono ancora dei pagamenti per campagne collegate a questa zona, se la elimini non riuscirai ad eseguire le campagne ed ottenere i pagamenti.";
$GLOBALS['strZoneType'] = "Tipo di zona";
$GLOBALS['strBannerButtonRectangle'] = "Banner, Pulsante o Rettangolo";
$GLOBALS['strInterstitial'] = "Interstiziale o DHTML floating";
$GLOBALS['strTextAdZone'] = "Inserzione testuale";
$GLOBALS['strEmailAdZone'] = "Zone Email/Newsletter";
$GLOBALS['strShowMatchingBanners'] = "Mostra banner corrispondenti";
$GLOBALS['strHideMatchingBanners'] = "Nascondi banner corrispondenti";
$GLOBALS['strBannerLinkedAds'] = "Banner collegati alla zona";
$GLOBALS['strCampaignLinkedAds'] = "Campagne collegate alla zona";
$GLOBALS['strInactiveZonesHidden'] = "zone inattive nascoste";
$GLOBALS['strWarnChangeZoneType'] = "Cambiando il tipo di zona a testo o email saranno persi i collegamenti a banner o campagne per via delle limitazioni di questo tipo di zona
<ul>
<li>Zone testuali possono essere collegate solo a inserzioni testuali</li>
<li>Zone delle campagne Email possono avere solo un banner attivo alla volta</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Cambiando la dimensione della zona si perderanno i collegamenti con tutti i banner che non sono della nuova dimensione, e saranno aggiunti tutti i banner dalle campagne collegate che sono della nuova dimensione';
$GLOBALS['strWarnChangeBannerSize'] = 'Cambiando la dimensione del banner tutti i banner che non sono della nuova dimensione verranno scollegati dalle relative zone, e se la campagna di questo banner è collegato ad una zona della nuova dimensione, questo banner sarà collegato automaticamente';
$GLOBALS['strWarnBannerReadonly'] = 'Il banner è di sola lettura perchè un\'estensione è stata disabilitata. Contatta l\'amministratore del tuo sistema per maggiori informazioni.';
$GLOBALS['strZonesOfWebsite'] = 'in'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Torna a zone";

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
$GLOBALS['strAdvanced'] = "Avanzate";
$GLOBALS['strChainSettings'] = "Impostazioni della catena";
$GLOBALS['strZoneNoDelivery'] = "Se nessun banner di questa zona <br />può essere fornito, prova a...";
$GLOBALS['strZoneStopDelivery'] = "Arrestare la fornitura e non visualizzare alcun banner";
$GLOBALS['strZoneOtherZone'] = "Mostrare la zona selezionata in sostituzione";
$GLOBALS['strZoneAppend'] = "Aggiungi sempre il seguente codice HTML ai banner di questa zona";
$GLOBALS['strAppendSettings'] = "Impostazioni prefisso e suffisso";
$GLOBALS['strZonePrependHTML'] = "Codice HTML da utilizzare come prefisso per i banner testuali visualizzati in questa zona";
$GLOBALS['strZoneAppendNoBanner'] = "Utilizza come suffisso anche se non viene fornito alcun banner";
$GLOBALS['strZoneAppendHTMLCode'] = "Codice HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup o interstiziale";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Tutti i banner collegati alla zona selezionata sono al momento disattivati. <br />Questa è la catena di zone che verrà seguita:";
$GLOBALS['strZoneProbNullPri'] = "Tutti i banner collegati alla zona selezionata sono al momento disattivati";
$GLOBALS['strZoneProbListChainLoop'] = "Si è verificato un ciclo infinito seguendo la catena delle zone. La fornitura della zona è sospesa";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Scegli la tipologia di collegamento con i banner";
$GLOBALS['strLinkedBanners'] = "Collega banner individuali";
$GLOBALS['strCampaignDefaults'] = "Collega banner per campagna di appartenenza";
$GLOBALS['strLinkedCategories'] = "Collega banner per categoria";
$GLOBALS['strWithXBanners'] = "Banner %d";
$GLOBALS['strRawQueryString'] = "Parola chiave";
$GLOBALS['strIncludedBanners'] = "Banner collegati";
$GLOBALS['strMatchingBanners'] = "{count} banner corrispondenti";
$GLOBALS['strNoCampaignsToLink'] = "Non ci sono attualmente campagne disponibili che possano essere collegati a questa zona";
$GLOBALS['strNoTrackersToLink'] = "Non ci sono attualmente tracker disponibili che possano essere collegati a questa campagna";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Non ci sono zone disponibili a cui questa campagna possa essere collegata";
$GLOBALS['strSelectBannerToLink'] = "Seleziona il banner che vorresti collegare a questa zona:";
$GLOBALS['strSelectCampaignToLink'] = "Seleziona la campagna che vorresti collegare a questa zona:";
$GLOBALS['strSelectAdvertiser'] = "Seleziona inserzionista";
$GLOBALS['strSelectPlacement'] = "Seleziona campagna";
$GLOBALS['strSelectAd'] = "Seleziona banner";
$GLOBALS['strSelectPublisher'] = "Seleziona sito";
$GLOBALS['strSelectZone'] = "Seleziona zona";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strStatusPending'] = "In attesa";
$GLOBALS['strStatusApproved'] = "Approvato";
$GLOBALS['strStatusDisapproved'] = "Rifiutato";
$GLOBALS['strStatusDuplicate'] = "Duplicato";
$GLOBALS['strStatusOnHold'] = "Sospeso";
$GLOBALS['strStatusIgnore'] = "Ignorato";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strConnTypeSale'] = "Vendita";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Iscrizione";
$GLOBALS['strShortcutEditStatuses'] = "Modifica stati";
$GLOBALS['strShortcutShowStatuses'] = "Mostra stati";

// Statistics
$GLOBALS['strStats'] = "Statistiche";
$GLOBALS['strNoStats'] = "Non ci sono statistiche disponibili";
$GLOBALS['strNoStatsForPeriod'] = "Non sono disponibili statistiche per il periodo dal %s al %s";
$GLOBALS['strGlobalHistory'] = "Storico globale";
$GLOBALS['strDailyHistory'] = "Storico giornaliero";
$GLOBALS['strDailyStats'] = "Statistiche giornaliere";
$GLOBALS['strWeeklyHistory'] = "Storico settimanale";
$GLOBALS['strMonthlyHistory'] = "Storico mensile";
$GLOBALS['strTotalThisPeriod'] = "Totale in questo periodo";
$GLOBALS['strPublisherDistribution'] = "Distribuzione editori";
$GLOBALS['strCampaignDistribution'] = "Distribuzione campagne";
$GLOBALS['strViewBreakdown'] = "Visto da";
$GLOBALS['strBreakdownByDay'] = "Giorno";
$GLOBALS['strBreakdownByWeek'] = "Settimana";
$GLOBALS['strBreakdownByMonth'] = "Mese";
$GLOBALS['strBreakdownByDow'] = "Giorno della settimana";
$GLOBALS['strBreakdownByHour'] = "Ora";
$GLOBALS['strItemsPerPage'] = "Oggetti per pagina";
$GLOBALS['strShowGraphOfStatistics'] = "Mostra <u>G</u>rafico delle Statistiche";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>sporta Statistiche in Excel";
$GLOBALS['strGDnotEnabled'] = "E' necessario avere GD abilitato in PHP per mostrare i grafici. Per maggiori informazioni su coma abilitare GD sul tuo sistema consulta <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>.";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "Data scadenza non impostata";
$GLOBALS['strEstimated'] = "Scadenza prevista";
$GLOBALS['strNoExpirationEstimation'] = "Non è ancora stata stimata nessuna scadenza.";
$GLOBALS['strDaysAgo'] = "giorni fa";
$GLOBALS['strCampaignStop'] = "Termina campagna";

// Reports
$GLOBALS['strAdvancedReports'] = "Report avanzati";
$GLOBALS['strStartDate'] = "Data Inzio";
$GLOBALS['strEndDate'] = "Data Fine";
$GLOBALS['strPeriod'] = "Periodo";
$GLOBALS['strLimitations'] = "Limitazioni";
$GLOBALS['strWorksheets'] = "Fogli di lavoro";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Tutti gli inserzionisti";
$GLOBALS['strAnonAdvertisers'] = "Inserzionisti anonimi";
$GLOBALS['strAllPublishers'] = "Tutti gli editori";
$GLOBALS['strAnonPublishers'] = "Editori anonimi";
$GLOBALS['strAllAvailZones'] = "Tutte le zone disponibili";

// Userlog
$GLOBALS['strUserLog'] = "Registro eventi";
$GLOBALS['strUserLogDetails'] = "Dettagli registro eventi";
$GLOBALS['strDeleteLog'] = "Cancella registro";
$GLOBALS['strAction'] = "Azione";
$GLOBALS['strNoActionsLogged'] = "Nessuna azione registrata";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Selezione diretta";
$GLOBALS['strChooseInvocationType'] = "Seleziona il tipo di invocazione banner";
$GLOBALS['strGenerate'] = "Genera";
$GLOBALS['strParameters'] = "Impostazioni tag";
$GLOBALS['strFrameSize'] = "Dimensione frame";
$GLOBALS['strBannercode'] = "Codice banner";
$GLOBALS['strBackToTheList'] = "Torna alla lista dei report";
$GLOBALS['strCharset'] = "Set di caratteri";
$GLOBALS['strAutoDetect'] = "Riconoscimento automatico";


// Errors
$GLOBALS['strErrorDatabaseConnetion'] = "Errore nella connessione al database";
$GLOBALS['strErrorCantConnectToDatabase'] = "Errore fatale %s non può collegarsi al database. Per tanto non è possibile usare l'interfaccia amministrativa. Inoltre può essere stata compromessa la distribuzione dei banner. Possibili cause del problema:<ul><li>Il server database in questo momento non funziona</li> <li>L'indirizzo del server database è cambiato</li> <li>Le credenziali di accesso al server database non sono corrette</li> <li>L'estensione MySQL di PHP non è stata caricata</li> </ul>";
$GLOBALS['strNoMatchesFound'] = "Nessuna corrispondenza trovata";
$GLOBALS['strErrorOccurred'] = "Segnalazione Errore";
$GLOBALS['strErrorDBPlain'] = "Si è verificato un errore nell'accesso al database";
$GLOBALS['strErrorDBSerious'] = "È stato riscontrato un grave problema con il database";
$GLOBALS['strErrorDBCorrupt'] = "Probabilmente la tabella è corrotta ed è necessario ripararla. Per avere più informazioni su come riparare le tabelle corrotte, leggere il capitolo <i>Troubleshooting</i> della <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Contatta l'amministratore di questo server ed informalo del problema.";
$GLOBALS['strErrorLinkingBanner'] = "Non è stato possibile collegare questo banner a questa zona perché:";
$GLOBALS['strUnableToLinkBanner'] = "Impossibile collegare questo banner:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "numero nel formato non corretto per il campo Informazioni ricavi ";
$GLOBALS['strErrorEditingZone'] = "Errore durante l'aggiornamento della zona:";
$GLOBALS['strUnableToChangeZone'] = "Impossibile applicare questi cambiamenti perché:";
$GLOBALS['strDatesConflict'] = "le date sono in conflitto con:";
$GLOBALS['strWarningInaccurateStats'] = "Alcune di queste statistiche sono state loggate in un fuso orario non Universal Time, potrebbero non essere mostrate nel fuso orario corretto.";
$GLOBALS['strWarningInaccurateReadMore'] = "Leggi di più in proposito";
$GLOBALS['strWarningInaccurateReport'] = "Alcune delle statistiche in questo report sono state loggate in un fuso orario non Universal Time, potrebbero non essere mostrate nel fuso orario corretto";

//Validation
$GLOBALS['strInvalidWebsiteURL'] = "URL del sito Web non valido";

// Email
$GLOBALS['strSirMadam'] = "Signore/Signora";
$GLOBALS['strMailSubject'] = "Rapporto inserzionista";
$GLOBALS['strMailHeader'] = "Gentile {contact},";
$GLOBALS['strMailBannerStats'] = "Di seguito troverai le statistiche di visualizzazione banner per {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campagna attivata";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campagna disattivata";
$GLOBALS['strMailBannerDeactivated'] = "La campagna segnalata di seguito è stata disattivata perché";
$GLOBALS['strMailFooter'] = "Cordiali saluti,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Questa campagna non risulta attualmente attiva poiché";
$GLOBALS['strBeforeActivate'] = "non ha raggiunto la data di attivazione";
$GLOBALS['strAfterExpire'] = "ha raggiunto la data di scadenza";
$GLOBALS['strNoMoreImpressions'] = "non sono rimaste visualizzazioni";
$GLOBALS['strNoMoreClicks'] = "non ci sono più Click a disposizione";
$GLOBALS['strNoMoreConversions'] = "non ci sono Vendite rimaste";
$GLOBALS['strWeightIsNull'] = "il suo peso è impostato a zero";
$GLOBALS['strNoViewLoggedInInterval'] = "Nessuna visualizzazione risulta essere stata loggata durante la creazione di questo rapporto";
$GLOBALS['strNoClickLoggedInInterval'] = "Nessun click risulta essere stata loggata durante la creazione di questo rapporto";
$GLOBALS['strNoConversionLoggedInInterval'] = "Nessuna conversione registrata durante l`arco di questo report";
$GLOBALS['strMailReportPeriod'] = "Questo rapporto include le statistiche da {startdate} fino a {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Questo rapporto include  tutte le statistiche fino a {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Non ci sono statistiche disponibili per questa campagna.";
$GLOBALS['strImpendingCampaignExpiry'] = "Scadenza campagna imminente";
$GLOBALS['strYourCampaign'] = "Tue campagne";
$GLOBALS['strTheCampiaignBelongingTo'] = "La campagna appartenente a";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} mostrato di seguito sta per scadere il {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} mostrato di seguito ha meno di {limit} impressioni rimaste.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Come risultato, la campagna verrà automaticamente disabilitata, e anche i seguenti banner verranno di conseguenza disabilitati:";

// Priority
$GLOBALS['strPriority'] = "Priorità";
$GLOBALS['strSourceEdit'] = "Modifica risorse";

// Preferences
$GLOBALS['strPreferences'] = "Preferenze";
$GLOBALS['strUserPreferences'] = "Preferenze utente";
$GLOBALS['strChangePassword'] = "Cambia password";
$GLOBALS['strChangeEmail'] = "Cambia email";
$GLOBALS['strCurrentPassword'] = "Password attuale";
$GLOBALS['strChooseNewPassword'] = "Scegli una nuova password";
$GLOBALS['strReenterNewPassword'] = "Ripeti la nuova password";
$GLOBALS['strNameLanguage'] = "Nome e lingua";
$GLOBALS['strAccountPreferences'] = "Preferenze account";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferenze rapporti email della campagna";
$GLOBALS['strTimezonePreferences'] = "Preferenze fuso orario";
$GLOBALS['strAdminEmailWarnings'] = "Email di notifica amministratore";
$GLOBALS['strAgencyEmailWarnings'] = "Email di notifica agenzia";
$GLOBALS['strAdveEmailWarnings'] = "Email di notifica inserzionista";
$GLOBALS['strFullName'] = "Nome completo";
$GLOBALS['strEmailAddress'] = "Indirizzo email";
$GLOBALS['strUserDetails'] = "Dettagli utente";
$GLOBALS['strUserInterfacePreferences'] = "Preferenze interfaccia utente";
$GLOBALS['strPluginPreferences'] = "Preferenze principali";
$GLOBALS['strColumnName'] = "Nome colonna";
$GLOBALS['strShowColumn'] = "Mostra colonna";
$GLOBALS['strCustomColumnName'] = "Nome colonna personalizzato";
$GLOBALS['strColumnRank'] = "Colonna Rank";

// Long names
$GLOBALS['strRevenue'] = "Entrate";
$GLOBALS['strNumberOfItems'] = "Numero di oggetti";
$GLOBALS['strRevenueCPC'] = "Ricavo Cost Per Click (CPC)";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "Conversioni in attesa";
$GLOBALS['strImpressionSR'] = "Visualizzazione SR";
$GLOBALS['strClickSR'] = "Click SR";

// Short names
$GLOBALS['strRevenue_short'] = "Ric.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Ogg.";
$GLOBALS['strRevenueCPC_short'] = "Ric. CPC";
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
$GLOBALS['strRequests_short'] = "Ric.";
$GLOBALS['strClicks_short'] = "Click";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strPendingConversions_short'] = "Conv. in attesa";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configurazione";
$GLOBALS['strGlobalSettings'] = "Impostazioni globali";
$GLOBALS['strGeneralSettings'] = "Impostazioni generali";
$GLOBALS['strMainSettings'] = "Impostazioni principali";
$GLOBALS['strPlugins'] = "Plugin";
$GLOBALS['strChooseSection'] = 'Scegli sezione';

// Product Updates
$GLOBALS['strProductUpdates'] = "Ricerca aggiornamenti";
$GLOBALS['strViewPastUpdates'] = "Gestisci scorsi aggiornamenti e backup";
$GLOBALS['strFromVersion'] = "Dalla versione";
$GLOBALS['strToVersion'] = "alla versione";
$GLOBALS['strToggleDataBackupDetails'] = "Altera i dettagli dei dati di backup";
$GLOBALS['strClickViewBackupDetails'] = "clicca per mostrare i dettagli";
$GLOBALS['strClickHideBackupDetails'] = "clicca per nascondere i dettagli";
$GLOBALS['strShowBackupDetails'] = "Mostra i dettagli";
$GLOBALS['strHideBackupDetails'] = "Nascondi i dettagli";
$GLOBALS['strBackupDeleteConfirm'] = "Confermi l'eliminazione di tutti i backup creati da questo aggiornamento?";
$GLOBALS['strDeleteArtifacts'] = "Elimina gli artifatti";
$GLOBALS['strArtifacts'] = "Artifatti";
$GLOBALS['strBackupDbTables'] = "Backup tabelle del database";
$GLOBALS['strLogFiles'] = "File di registro";
$GLOBALS['strConfigBackups'] = "Conf. backup";
$GLOBALS['strUpdatedDbVersionStamp'] = "Aggiornato il numero di versione del database";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "Aggiornamento completato";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "Aggiornamento fallito";

// Agency
$GLOBALS['strAgencyManagement'] = "Gestione account";
$GLOBALS['strAgency'] = "Account";
$GLOBALS['strAddAgency'] = "Aggiungi un nuovo account";
$GLOBALS['strAddAgency_Key'] = "Aggiungi un <u>n</u>uovo account";
$GLOBALS['strTotalAgencies'] = "Account totali";
$GLOBALS['strAgencyProperties'] = "Proprietà dell'account";
$GLOBALS['strNoAgencies'] = "Non è stato definito alcun account";
$GLOBALS['strConfirmDeleteAgency'] = "Vuoi davvero cancellare questo account?";
$GLOBALS['strHideInactiveAgencies'] = "Nascondi gli account non attivi";
$GLOBALS['strInactiveAgenciesHidden'] = "account non attivi, nascosti";
$GLOBALS['strSwitchAccount'] = "Passa a questo account";

// Channels
$GLOBALS['strChannel'] = "Canale di targeting";
$GLOBALS['strChannels'] = "Canali di targeting";
$GLOBALS['strChannelManagement'] = "Gestione canale di targeting";
$GLOBALS['strAddNewChannel'] = "Aggiungi un nuovo canale di targeting";
$GLOBALS['strAddNewChannel_Key'] = "Aggiungi un <n>n</n>uovo canale di targeting";
$GLOBALS['strChannelToWebsite'] = "Nessun sito";
$GLOBALS['strNoChannels'] = "Non è stato definito alcun canale di targeting";
$GLOBALS['strNoChannelsAddWebsite'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strEditChannelLimitations'] = "Modifica le limitazioni del canale di targeting";
$GLOBALS['strChannelProperties'] = "Proprietà del canale di targeting";
$GLOBALS['strChannelLimitations'] = "Impostazioni di consegna";
$GLOBALS['strConfirmDeleteChannel'] = "Vuoi davvero cancellare questo canale di targeting?";
$GLOBALS['strConfirmDeleteChannels'] = "Vuoi davvero cancellare questo canale di targeting?";
$GLOBALS['strChannelsOfWebsite'] = 'in'; //this is added between page name and website name eg. 'Targeting channels in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Nome variabile";
$GLOBALS['strVariableDescription'] = "Descrizione";
$GLOBALS['strVariableDataType'] = "Tipo di dati";
$GLOBALS['strVariablePurpose'] = "Scopo";
$GLOBALS['strGeneric'] = "Generico";
$GLOBALS['strBasketValue'] = "Valore del cesto";
$GLOBALS['strNumItems'] = "Numero di oggetti";
$GLOBALS['strVariableIsUnique'] = "Conversione Dedup?";
$GLOBALS['strNumber'] = "Numero";
$GLOBALS['strString'] = "Stringa";
$GLOBALS['strTrackFollowingVars'] = "Traccia la seguente variabile";
$GLOBALS['strAddVariable'] = "Aggiungi variabile";
$GLOBALS['strNoVarsToTrack'] = "Nessuna variabile da tracciare";
$GLOBALS['strVariableRejectEmpty'] = "Rifiuta se vuoto?";
$GLOBALS['strTrackingSettings'] = "Impostazioni tracciamenti";
$GLOBALS['strTrackerType'] = "Tipo di tracciatore";
$GLOBALS['strTrackerTypeJS'] = "Traccia variabili Javascript";
$GLOBALS['strTrackerTypeDefault'] = "Traccia variabili Javascript (compatibilità con le versioni precedenti, richiesto l'escaping)";
$GLOBALS['strTrackerTypeDOM'] = "Traccia elementi HTML utilizzando DOM";
$GLOBALS['strTrackerTypeCustom'] = "Codice Javascript personalizzato";
$GLOBALS['strVariableCode'] = "Codice tracciamento Javascript";

// Password recovery
$GLOBALS['strForgotPassword'] = "Hai dimenticato la password?";
$GLOBALS['strPasswordRecovery'] = "Recupero password";
$GLOBALS['strEmailRequired'] = "Email è un campo richiesto";
$GLOBALS['strPwdRecEmailNotFound'] = "Indirizzo email non trovato";
$GLOBALS['strPwdRecWrongId'] = "ID errato";
$GLOBALS['strPwdRecEnterEmail'] = "Inserisci il tuo indirizzo e-mail qui sotto";
$GLOBALS['strPwdRecEnterPassword'] = "Inserisci qui sotto la nuova password";
$GLOBALS['strPwdRecResetLink'] = "Link reset della password";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s password recuperata";
$GLOBALS['strNotifyPageMessage'] = "Ti è stata spedita una email con un link che ti permetterà di reimpostare la password ed entrare nel sistema.<br />Attendi pochi minutil l'arrivo della email.<br />Se non la ricevi entro breve, controlla che non sia finita nella posta indesiderata.<br /><a href='index.php'>Torna alla pagina di accesso.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "e oggetti aggiuntivi";
$GLOBALS['strFor'] = "per";
$GLOBALS['strHas'] = "era";
$GLOBALS['strBinaryData'] = "Dati binari";
$GLOBALS['strAuditTrailDisabled'] = "L'amministratore ha disabilitato Audit Trail. Non saranno registrati e mostrati ulteriori eventi nella lista Audit Trail.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Nessuna attività dell`utente  è stata registrata durante il periodo di tempo che hai selezionato.";
$GLOBALS['strAuditTrailSetup'] = "Importa Audit Trail oggi";
$GLOBALS['strAuditTrailGoTo'] = "Vai alla pagina Audit Trail";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Vai alla pagina delle campagne";
$GLOBALS['strCampaignSetUp'] = "Impostare una campagna di oggi";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Non ci sono attività da mostrare.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Nessuna campagna avviata o finita durante il periodo selezionato";
$GLOBALS['strCampaignAuditTrailSetup'] = "Attiva Audit Trail per iniziare a vedere le campagne";

$GLOBALS['strUnsavedChanges'] = "I cambiamenti effettuati su questa pagina non sono stati salvati, accertati di premere \"Salva cambiamenti\" al termine";
$GLOBALS['strDeliveryLimitationsDisagree'] = "ATTENZIONE: Alcune limitazioni del motore di distribuzione <strong>non permettono</strong> le limitazioni elencate di seuito<br /> Per favore premi &quot;salva cambiamenti&quot; per aggiornare le regole di distribuzione del motore.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Alcune limitazioni di distribuzione hanno riportato dei valori incorretti:";

//confirmation messages

$GLOBALS['strAdvertisersHaveBeenDeleted'] = "Eliminati tutti gli inserzionisti selezionati";






$GLOBALS['strZoneHasBeenDeleted'] = "La zona <b>%s</b> è stata cancellata";
$GLOBALS['strZonesHaveBeenDeleted'] = "Tutte le zone selezionate sono state cancellate";
$GLOBALS['strZoneHasBeenDuplicated'] = "La zona <a href='%s'>%s</a> è stata copiata in <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "La zona <b>%s</b> è stata spostata nel sito <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Il banner è stato collegato alla zona <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "La campagna è stata collegata alla zona <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Il banner è stato scollegato dalla zona <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "La campagna è stata scollegata dalla zona <a href='%s'>%s</a>";


$GLOBALS['strUserPreferencesUpdated'] = "Le preferenze di <b>%s</b> sono state aggiornate";
$GLOBALS['strPasswordChanged'] = "La tua password è stata cambiata";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "Nessun foglio di lavoro è stato selezionato per la relazione";
$GLOBALS['strReportErrorUnknownCode'] = "Codice di errore sconosciuto #";

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "c";
$GLOBALS['keyCollapseAll'] = "h";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "s";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['keyWorkingAs'] = "l";
