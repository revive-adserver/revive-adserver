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
$GLOBALS['strContactUs'] = "Contattaci";
$GLOBALS['strStartOver'] = "Inizia da capo";
$GLOBALS['strNavigation'] = "Navigazione";
$GLOBALS['strShortcuts'] = "Scorciatoie";
$GLOBALS['strActions'] = "Azioni";
$GLOBALS['strMore'] = "Di più";
$GLOBALS['strLess'] = "Meno";
$GLOBALS['strAdminstration'] = "Inventario";
$GLOBALS['strMaintenance'] = "Manutenzione";
$GLOBALS['strProbability'] = "Probabilità";
$GLOBALS['strInvocationcode'] = "Codice di invocazione";
$GLOBALS['strTrackerVariables'] = "Variabili del tracker";
$GLOBALS['strBasicInformation'] = "Informazioni di base";
$GLOBALS['strAdditionalInformation'] = "Informazioni aggiuntive";
$GLOBALS['strContractInformation'] = "Informazioni sul contratto";
$GLOBALS['strLoginInformation'] = "Informazioni sul login";
$GLOBALS['strLogoutURL'] = "URL al quale reindirizzare a seguito del logout.<br />Non compilare per utilizzare le impostazioni prestabilite";
$GLOBALS['strAppendTrackerCode'] = "Aggiungi codice tracker";
$GLOBALS['strOverview'] = "Descrizione";
$GLOBALS['strSearch'] = "<u>C</u>erca";
$GLOBALS['strHistory'] = "Storico";
$GLOBALS['strDetails'] = "Dettagli";
$GLOBALS['strUpdateSettings'] = "Aggiorna impostazioni";
$GLOBALS['strCheckForUpdates'] = "Controlla aggiornamenti";
$GLOBALS['strCompact'] = "Compatte";
$GLOBALS['strVerbose'] = "Complete";
$GLOBALS['strUser'] = "Utente";
$GLOBALS['strEdit'] = "Modifica";
$GLOBALS['strCreate'] = "Crea";
$GLOBALS['strDuplicate'] = "Duplicato";
$GLOBALS['strCopyOf'] = "Copia di ";
$GLOBALS['strMoveTo'] = "Muovi verso";
$GLOBALS['strDelete'] = "Elimina";
$GLOBALS['strActivate'] = "Attiva";
$GLOBALS['strDeActivate'] = "Disattiva";
$GLOBALS['strConvert'] = "Converti";
$GLOBALS['strRefresh'] = "Aggiorna";
$GLOBALS['strSaveChanges'] = "Salva modifiche";
$GLOBALS['strUp'] = "Su";
$GLOBALS['strDown'] = "Giù";
$GLOBALS['strSave'] = "Salva";
$GLOBALS['strCancel'] = "Annulla";
$GLOBALS['strBack'] = "Indietro";
$GLOBALS['strPrevious'] = "Precedente";
$GLOBALS['strPrevious_Key'] = "<u>P</u>recedente";
$GLOBALS['strNext'] = "Successivo";
$GLOBALS['strNext_Key'] = "<u>S</u>uccessivo";
$GLOBALS['strYes'] = "Sì";
$GLOBALS['strNo'] = "No";
$GLOBALS['strNone'] = "Nessuno";
$GLOBALS['strCustom'] = "Personalizzato";
$GLOBALS['strDefault'] = "Predefinito";
$GLOBALS['strOther'] = "Altro";
$GLOBALS['strUnknown'] = "Sconosciuto";
$GLOBALS['strUnlimited'] = "Illimitato";
$GLOBALS['strUntitled'] = "Senza nome";
$GLOBALS['strAll'] = "tutto";
$GLOBALS['strAvg'] = "Med.";
$GLOBALS['strAverage'] = "Media";
$GLOBALS['strOverall'] = "Totale";
$GLOBALS['strTotal'] = "Totale";
$GLOBALS['strActive'] = "attiva";
$GLOBALS['strFrom'] = "Da";
$GLOBALS['strTo'] = "a";
$GLOBALS['strAdd'] = "Aggiungi";
$GLOBALS['strLinkedTo'] = "collegato a";
$GLOBALS['strDaysLeft'] = "Giorni mancanti";
$GLOBALS['strCheckAllNone'] = "Seleziona tutti / nessuno";
$GLOBALS['strExpandAll'] = "<u>E</u>spandi tutti";
$GLOBALS['strCollapseAll'] = "<u>C</u>hiudi tutti";
$GLOBALS['strShowAll'] = "Mostra tutto";
$GLOBALS['strNoAdminInterface'] = "L'interfaccia di amministrazione non è accessibile per manutenzione. La consegna delle tue campagne avverrà normalmente.";
$GLOBALS['strFilterBySource'] = "filtra per sorgente";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La data di inizio deve essere antecedente alla data di fine";
$GLOBALS['strFieldContainsErrors'] = "I seguenti campi contengono errori:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Prima di continuare è necessario";
$GLOBALS['strFieldFixBeforeContinue2'] = "per correggere questi errori.";
$GLOBALS['strDelimiter'] = "Delimitatore";
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
$GLOBALS['strAdmin'] = "Amministratore";
$GLOBALS['strNotice'] = "Notifica";
$GLOBALS['strRequiredField'] = "Campo obbligatorio";

// Dashboard
$GLOBALS['strChoosenDisableHomePage'] = "Hai scelto di disabilitare la tua pagina iniziale.";
$GLOBALS['strAccessHomePage'] = "Accedi alla tua pagina iniziale";
$GLOBALS['strEditSyncSettings'] = "e modifica le tue impostazioni di sincronizzazione";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "codice";
$GLOBALS['strDashboardSystemMessage'] = "Messaggio di sistema";
$GLOBALS['strDashboardErrorHelp'] = "Se questo errore si ripete per favore descrivi il tuo problema nel dettaglio e pubblicalo sui <a href='http://forum.openx.org/'>forum OpenX</a>.";

// Priority
$GLOBALS['strPriority'] = "Priorità";
$GLOBALS['strPriorityLevel'] = "Livello di priorità";
$GLOBALS['strPriorityTargeting'] = "Distribuzione";
$GLOBALS['strPriorityOptimisation'] = "Varie"; // Er, what?
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
$GLOBALS['strComments'] = "Commenti";

// User access
$GLOBALS['strWorkingAs'] = "Lavora come";
$GLOBALS['strWorkingAs'] = "Lavora come";
$GLOBALS['strSwitchTo'] = "Passa a";
$GLOBALS['strWorkingFor'] = "%s per...";
$GLOBALS['strLinkUser'] = "Aggiungi utente";
$GLOBALS['strLinkUser_Key'] = "Aggiungi <u>u</u>tente";
$GLOBALS['strUsernameToLink'] = "Nome dell’utente da aggiungere";
$GLOBALS['strEmailToLink'] = "Email dell’utente da aggiungere";
$GLOBALS['strNewUserWillBeCreated'] = "Il nuovo utente verrà creato";
$GLOBALS['strToLinkProvideEmail'] = "Per aggiungere l’utente si deve fornire la sua e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Per aggiungere l’utente si deve fornire il suo nome utente";
$GLOBALS['strErrorWhileCreatingUser'] = "Errore nella creazione utente: %s";
$GLOBALS['strUserLinkedToAccount'] = "L’utente è stato aggiunto all’account";
$GLOBALS['strUserAccountUpdated'] = "Account utente aggiornato";
$GLOBALS['strUserUnlinkedFromAccount'] = "L’utente è stato rimosso dall’account";
$GLOBALS['strUserWasDeleted'] = "L’utente è stato eliminato";
$GLOBALS['strUserNotLinkedWithAccount'] = "Tale utente non è collegato con l`account";
$GLOBALS['strCantDeleteOneAdminUser'] = "Non puoi cancellare l`utente. Almeno un altro utente necessita di essere collegato con l`account di amministrazione.";
$GLOBALS['strLinkUserHelp'] = "Per aggiungere un <strong>utente esistente</strong> digita %s e clicca {$GLOBALS['strLinkUser']}<br />Per aggiungere un <strong>nuovo utente</strong> digita %s voluto e clicca {$GLOBALS['strLinkUser']}";
$GLOBALS['strLinkUserHelpUser'] = "nome utente";
$GLOBALS['strLinkUserHelpEmail'] = "indirizzo email";
$GLOBALS['strLastLoggedIn'] = "Ultimo accesso";
$GLOBALS['strDateLinked'] = "Data collegata";
$GLOBALS['strUnlink'] = "Rimuovi";
$GLOBALS['strUnlinkingFromLastEntity'] = "Rimozione dell'utente dall'ultima entità";
$GLOBALS['strUnlinkingFromLastEntityBody'] = "Rimuovere l'utente dall'ultima entità ne causerà l'eliminazione. Vuoi eliminare l'utente?";
$GLOBALS['strUnlinkAndDelete'] = "Rimuovi ed elimina l'utente";
$GLOBALS['strUnlinkUser'] = "Rimuovi utente";
$GLOBALS['strUnlinkUserConfirmBody'] = "Confermi di voler rimuovere questo utente?";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Accesso utente";
$GLOBALS['strAdminAccess'] = "Accesso Amministratore";
$GLOBALS['strUserProperties'] = "Proprietà utente";
$GLOBALS['strLinkNewUser'] = "Collega nuovo utente";
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
$GLOBALS['strPasswordRepeat'] = "Ripeti la password";
$GLOBALS['strAccessDenied'] = "Accesso negato";
$GLOBALS['strUsernameOrPasswordWrong'] = "Nome utente o password non corretti. Inserire nuovamente le proprie credenziali.";
$GLOBALS['strPasswordWrong'] = "Password errata";
$GLOBALS['strNotAdmin'] = "Il tuo account non ha abbastanza privilegi per usare questa caratteristica.";
$GLOBALS['strDuplicateClientName'] = "Il nome utente fornito è già in uso, specificare un nome utente differente.";
$GLOBALS['strDuplicateAgencyName'] = "Il nome utente fornito è già in uso, specificare un nome utente differente.";
$GLOBALS['strInvalidPassword'] = "La nuova password non è valida, utilizzare un'altra password.";
$GLOBALS['strInvalidEmail'] = "L'email non è stata inserita correttamente, per favore inserisci un indirizzo email valido.";
$GLOBALS['strNotSamePasswords'] = "Le due password inserite non coincidono";
$GLOBALS['strRepeatPassword'] = "Ripeti password";
$GLOBALS['strOldPassword'] = "Vecchia password";
$GLOBALS['strNewPassword'] = "Nuova password";
$GLOBALS['strDeadLink'] = "Il tuo collegamento non è valido.";
$GLOBALS['strNoPlacement'] = "La campagna selezionata non esiste. Prova questo <a href='{link}'collegamento</a> invece";
$GLOBALS['strNoAdvertiser'] = "L'inserzionista selezionato non esiste. Prova questo <a href='{link}'collegamento</a> invece";

// General advertising
$GLOBALS['strRequests'] = "Richieste";
$GLOBALS['strImpressions'] = "Impressioni";
$GLOBALS['strClicks'] = "Click";
$GLOBALS['strConversions'] = "Conversioni";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strCNVR'] = "Proporzione vendita";
$GLOBALS['strTotalViews'] = "Visualizzazioni totali";
$GLOBALS['strTotalClicks'] = "Click totali";
$GLOBALS['strTotalConversions'] = "Conversioni totali";
$GLOBALS['strViewCredits'] = "Crediti impressioni";
$GLOBALS['strClickCredits'] = "Crediti click";
$GLOBALS['strConversionCredits'] = "Conversioni Crediti";
$GLOBALS['strDateTime'] = "Data Ora";
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
$GLOBALS['strFinanceMT'] = "Occupazione Mensile";
$GLOBALS['strPercentRevenueSplit'] = "% divisione ricavi";
$GLOBALS['strPercentBasketValue'] = "% Valore del cesto";
$GLOBALS['strAmountPerItem'] = "Ammontare per oggetto";
$GLOBALS['strPercentCustomVariable'] = "% Variabile personalizzata";
$GLOBALS['strPercentSumVariables'] = "% Somma delle variabili";

// Time and date related
$GLOBALS['strDate'] = "Data";
$GLOBALS['strToday'] = "Oggi";
$GLOBALS['strDay'] = "Giorno";
$GLOBALS['strDays'] = "Giorni";
$GLOBALS['strLast7Days'] = "Ultimi 7 giorni";
$GLOBALS['strWeek'] = "Settimana";
$GLOBALS['strWeeks'] = "Settimane";
$GLOBALS['strSingleMonth'] = "Mese";
$GLOBALS['strMonths'] = "Mesi";
$GLOBALS['strDayOfWeek'] = "Giorno della settimana";
$GLOBALS['strThisMonth'] = "Questo Mese";

$GLOBALS['strMonth'] = array();
$GLOBALS['strMonth'][0] = "Gennaio";
$GLOBALS['strMonth'][1] = "Febbraio";
$GLOBALS['strMonth'][2] = "Marzo";
$GLOBALS['strMonth'][3] = "Aprile";
$GLOBALS['strMonth'][4] = "Maggio";
$GLOBALS['strMonth'][5] = "Giugno";
$GLOBALS['strMonth'][6] = "Luglio";
$GLOBALS['strMonth'][7] = "Agosto";
$GLOBALS['strMonth'][8] = "Settembre";
$GLOBALS['strMonth'][9] = "Ottobre";
$GLOBALS['strMonth'][10] = "Novembre";
$GLOBALS['strMonth'][11] = "Dicembre";

$GLOBALS['strDayFullNames'] = array();

$GLOBALS['strDayShortCuts'] = array();
$GLOBALS['strDayShortCuts'][0] = 'Do';
$GLOBALS['strDayShortCuts'][1] = 'Lu';
$GLOBALS['strDayShortCuts'][2] = 'Ma';
$GLOBALS['strDayShortCuts'][3] = 'Me';
$GLOBALS['strDayShortCuts'][4] = 'Gi';
$GLOBALS['strDayShortCuts'][5] = 'Ve';

$GLOBALS['strHour'] = "Ora";
$GLOBALS['strSeconds'] = "secondi";
$GLOBALS['strMinutes'] = "minuti";
$GLOBALS['strHours'] = "ore";
$GLOBALS['strTimes'] = "volte";

// Advertiser
$GLOBALS['strClient'] = "Inserzionista";
$GLOBALS['strClients'] = "Inserzionisti";
$GLOBALS['strClientsAndCampaigns'] = "Inserzionisti e Campagne";
$GLOBALS['strAddClient'] = "Aggiungi un nuovo inserzionista";
$GLOBALS['strAddClient_Key'] = "Aggiungi un <u>n</u>uovo inserzionista";
$GLOBALS['strTotalClients'] = "Inserzionisti totali";
$GLOBALS['strClientProperties'] = "Impostazioni inserzionista";
$GLOBALS['strClientHistory'] = "Storico inserzionista";
$GLOBALS['strNoClients'] = "Non è stato definito alcun inserzionista. Per creare una campagna, prima <a href='advertiser-edit.php'>aggiungi un inserzionista</a>.";
$GLOBALS['strNoClientsForBanners'] = "Non è stato definito alcun inserzionista. Per creare una campagna, prima <a href='advertiser-edit.php'>aggiungi un inserzionista</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Vuoi veramente eliminare questo inserzionista?";
$GLOBALS['strConfirmDeleteClients'] = "Vuoi veramente eliminare questo inserzionista?";
$GLOBALS['strConfirmResetClientStats'] = "Vuoi veramente elminare tutte le statistiche esistenti per qusto inserzionista?";
$GLOBALS['strSite'] = "Dimensioni";
$GLOBALS['strHideInactiveAdvertisers'] = "Nascondi inserzionisti inattivi";
$GLOBALS['strInactiveAdvertisersHidden'] = "inserzionisti inattivi nascosti";
$GLOBALS['strOverallAdvertisers'] = "inserzionisti";
$GLOBALS['strAdvertiserSignup'] = "Registrazione inserzionisti";
$GLOBALS['strAdvertiserSignupDesc'] = "Iscriviti per accedere al self service e pagamento per l'Inserzionista";
$GLOBALS['strAdvertiserSignupLink'] = "Collegamento alla registrazione inserzionisti";
$GLOBALS['strAdvertiserSignupLinkDesc'] = "Per aggiungere nel tuo sito un collegamento alla registrazione inserzionisti, per favore copia il seguente codice HTML:";
$GLOBALS['strAdvertiserSignupOption'] = "Opzione registrazione inserzionisti";
$GLOBALS['strAdvertiserSignunOptionDesc'] = "Per modificare le opzioni di registrazione inserzionisti, segui";
$GLOBALS['strAdvertiserCampaigns'] = "Inserzionisti e Campagne";

// Advertisers properties
$GLOBALS['strContact'] = "Contatto";
$GLOBALS['strContactName'] = "Nome del contatto";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strChars'] = "caratteri";
$GLOBALS['strSendAdvertisingReport'] = "Spedisci report della campagna via Email";
$GLOBALS['strNoDaysBetweenReports'] = "numero di giorni tra rapporti";
$GLOBALS['strSendDeactivationWarning'] = "Spedisci un avvertimento quando la campagna viene disattivata";
$GLOBALS['strAllowClientModifyInfo'] = "Permetti a questo utente di modificare le proprie impostazioni";
$GLOBALS['strAllowClientModifyBanner'] = "Permetti a questo utente di modificare i propri banner";
$GLOBALS['strAllowClientAddBanner'] = "Permetti a questo utente di aggiungere i propri banner";
$GLOBALS['strAllowClientDisableBanner'] = "Permetti a questo utente di disattivare i propri banner";
$GLOBALS['strAllowClientActivateBanner'] = "Permetti a questo utente di attivare i propri banner";
$GLOBALS['strAllowClientViewTargetingStats'] = "Permetti a questo utente di visualizzare le statiche di targeting";
$GLOBALS['strAllowCreateAccounts'] = "Permetti a questo utente di creare nuovi account";
$GLOBALS['strCsvImportConversions'] = "Permetti a questo utente di importare conversioni offline";
$GLOBALS['strAdvertiserLimitation'] = "Mostra solo un banner di questo editore sulla stessa pagina web";
$GLOBALS['strAllowAuditTrailAccess'] = "Permetti a questo utente di accedere all'Audit Trail";

// Campaign
$GLOBALS['strCampaign'] = "Campagna";
$GLOBALS['strCampaigns'] = "Campagne";
$GLOBALS['strOverallCampaigns'] = "campagne";
$GLOBALS['strTotalCampaigns'] = "Campagne totali";
$GLOBALS['strActiveCampaigns'] = "Campagne attive";
$GLOBALS['strAddCampaign'] = "Aggiungi nuova campagna";
$GLOBALS['strAddCampaign_Key'] = "Aggiungi <u>n</u>uova campagna";
$GLOBALS['strCreateNewCampaign'] = "Crea nuova campagna";
$GLOBALS['strModifyCampaign'] = "Modifica campagna";
$GLOBALS['strMoveToNewCampaign'] = "Muovi verso una nuova campagna";
$GLOBALS['strBannersWithoutCampaign'] = "Banner senza una campagna";
$GLOBALS['strDeleteAllCampaigns'] = "Elimina tutte le campagne";
$GLOBALS['strLinkedCampaigns'] = "Campagne collegate";
$GLOBALS['strCampaignStats'] = "Statistiche campagna";
$GLOBALS['strCampaignProperties'] = "Impostazioni campagna";
$GLOBALS['strCampaignOverview'] = "Descrizione campagne";
$GLOBALS['strCampaignHistory'] = "Storico campagna";
$GLOBALS['strNoCampaigns'] = "Attualmente non sono presenti campagne definite";
$GLOBALS['strConfirmDeleteAllCampaigns'] = "Desideri realmente procedere alla cancellazione di tutte le campagne di questo inserzionista?";
$GLOBALS['strConfirmDeleteCampaign'] = "Desideri realmente procedere alla cancellazione di questa campagna?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Desideri realmente procedere alla cancellazione di questa campagna?";
$GLOBALS['strConfirmResetCampaignStats'] = "Desideri realmente cancellare tutte le statistiche di questa campagna?";
$GLOBALS['strShowParentAdvertisers'] = "Mostra inserzionisti padri";
$GLOBALS['strHideParentAdvertisers'] = "Nascondi inserzionisti padri";
$GLOBALS['strHideInactiveCampaigns'] = "Nascondi campagne inattive";
$GLOBALS['strInactiveCampaignsHidden'] = "campagne inattive nascoste";
$GLOBALS['strContractDetails'] = "Dettagli contratto";
$GLOBALS['strInventoryDetails'] = "Dettagli inventario";
$GLOBALS['strPriorityInformation'] = "Priorità in relazione ad altre campagne";
$GLOBALS['strHiddenCampaign'] = "Campagna";
$GLOBALS['strHiddenAd'] = "Inserzione";
$GLOBALS['strHiddenAdvertiser'] = "Inserzionista";
$GLOBALS['strHiddenWebsite'] = "Sito";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCompanionPositioning'] = "Posizionamento del companion";
$GLOBALS['strSelectUnselectAll'] = "Seleziona / Deseleziona tutti";

// Campaign-zone linking page


// Campaign properties
$GLOBALS['strDontExpire'] = "Non far scadere";
$GLOBALS['strActivateNow'] = "Attiva immediatamente";
$GLOBALS['strLow'] = "Bassa";
$GLOBALS['strHigh'] = "Alta";
$GLOBALS['strExpirationDate'] = "Data Fine";
$GLOBALS['strExpirationDateComment'] = "La campagna finirà alla fine di questo giorno";
$GLOBALS['strActivationDate'] = "Data Inzio";
$GLOBALS['strActivationDateComment'] = "La campagna incomincerà all'inizio di questo giorno";
$GLOBALS['strRevenueInfo'] = "Informazioni Ricavi";
$GLOBALS['strTotalRevenue'] = "Totale Ricavi";
$GLOBALS['strImpressionsRemaining'] = "Impressioni Rimaste";
$GLOBALS['strClicksRemaining'] = "Click rimasti";
$GLOBALS['strConversionsRemaining'] = "Conversioni rimaste";
$GLOBALS['strImpressionsBooked'] = "Impressioni Prenotate";
$GLOBALS['strClicksBooked'] = "Click Prenotati";
$GLOBALS['strConversionsBooked'] = "Conversioni Prenotate";
$GLOBALS['strCampaignWeight'] = "Imposta il peso della campagna";
$GLOBALS['strOptimise'] = "Ottimizza";
$GLOBALS['strAnonymous'] = "Nascondi l'inserzionista e il sito di questa campagna";
$GLOBALS['strHighPriority'] = "Visualizza i banner in questa campagna con Priorità Alta.<br /> Usando questa opzione {$PRODUCT_NAME} prova a distribuire il numero di Visualizzazioni Scelto durante il corso della giornata.";
$GLOBALS['strLowPriority'] = "Visualizza i banner in questa campagna con Priorità Bassa.<br /> Usando questa opzione i banner sfrutteranno le visualizzazioni lasciate a disposizione dalla campagna con Priorità Alta.";
$GLOBALS['strTargetPerDay'] = "al giorno.";
$GLOBALS['strPriorityAutoTargeting'] = "Automatico - Distribuisci le visualizzazioni durante il corso delle rimanenti giornate. Il limite giornaliero di visualizzazioni verrà calcolato automaticamente.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Questa campagna è stata impostata come esclusiva,
ma il suo peso è impostato a zero o non è stato specificato.
Questo comporterà la disattivazione della campagna: i suoi banner
non verranno visualizzati finché il peso non sarà impostato
ad un numero valido.

Sei sicuro di voler procedere?";
$GLOBALS['strCampaignWarningNoTarget'] = "Questa campagna è stata impostata come campagna ad alta priorità,
ma il numero di Visualizzazioni giornaliere non è stato specificato.
Questo comporterà la disattivazione della campagna: i suoi banner
non verranno visualizzati finché non sarà impostato
un numero valido di Visualizzazioni giornaliere.

Sei sicuro di voler procedere?";
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
$GLOBALS['strCampaignApprove'] = "Approva";
$GLOBALS['strCampaignApproveDescription'] = "accetta questa campagna";
$GLOBALS['strCampaignReject'] = "Rifiuta";
$GLOBALS['strCampaignRejectDescription'] = "rifiuta questa campagna";
$GLOBALS['strCampaignPause'] = "Pausa";
$GLOBALS['strCampaignPauseDescription'] = "ferma temporaneamente questa campagna";
$GLOBALS['strCampaignRestart'] = "Riprendi";
$GLOBALS['strCampaignRestartDescription'] = "riprendi questa campagna";
$GLOBALS['strCampaignStatus'] = "Stato della campagna";
$GLOBALS['strReasonForRejection'] = "Ragione del rifiuto";
$GLOBALS['strReasonSiteNotLive'] = "Sito non attivo";
$GLOBALS['strReasonBadCreative'] = "Contenuto inopportuno";
$GLOBALS['strReasonBadUrl'] = "Indirizzo di destinazione inappropriato";
$GLOBALS['strReasonBreakTerms'] = "Sito contro il regolamento";
$GLOBALS['strChangeStatus'] = "Cambia stato";
$GLOBALS['strCampaignType'] = "Nome Campagna";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strContract'] = "Contatto";
$GLOBALS['strStandardContract'] = "Contatto";

// Tracker
$GLOBALS['strTrackers'] = "Tracker";
$GLOBALS['strTrackerOverview'] = "Informazioni Tracker";
$GLOBALS['strTrackerPreferences'] = "Preferenze tracker";
$GLOBALS['strAddTracker'] = "Aggiungi nuovo tracker";
$GLOBALS['strAddTracker_Key'] = "Aggiungi <u>n</u>uovo tracker";
$GLOBALS['strNoTrackers'] = "Attualmente non ci sono tracker definiti";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Vuoi davvero procedere alla cancellazione di tutti i tracker di questo inserzionista?";
$GLOBALS['strConfirmDeleteTrackers'] = "Vuoi davvero procedere alla cancellazione di questo tracker?";
$GLOBALS['strConfirmDeleteTracker'] = "Vuoi davvero procedere alla cancellazione di questo tracker?";
$GLOBALS['strDeleteAllTrackers'] = "Cancella tutti i tracker";
$GLOBALS['strTrackerProperties'] = "Impostazioni tracker";
$GLOBALS['strTrackerOverview'] = "Informazioni Tracker";
$GLOBALS['strModifyTracker'] = "Modifica tracker";
$GLOBALS['strDefaultStatus'] = "Stato predefinito";
$GLOBALS['strStatus'] = "Stato";
$GLOBALS['strLinkedTrackers'] = "Tracker collegati";
$GLOBALS['strConversionWindow'] = "Finestra di conversione";
$GLOBALS['strUniqueWindow'] = "Finestra unica";
$GLOBALS['strView'] = "Impressione";
$GLOBALS['strImpression'] = "Impressione";
$GLOBALS['strConversionType'] = "Tipo di conversione";
$GLOBALS['strLinkCampaignsByDefault'] = "Collega automaticamente le nuove campagne appena create";
$GLOBALS['strPerSingleImpression'] = "per singola impressione";



// Banners (General)
$GLOBALS['strBanners'] = "Banner";
$GLOBALS['strAddBanner'] = "Aggiungi nuovo banner";
$GLOBALS['strAddBanner_Key'] = "Aggiungi <u>n</u>uovo banner";
$GLOBALS['strBannerToCampaign'] = "Tue campagne";
$GLOBALS['strModifyBanner'] = "Modifica banner";
$GLOBALS['strActiveBanners'] = "Banner attivi";
$GLOBALS['strTotalBanners'] = "Banner totali";
$GLOBALS['strShowBanner'] = "Mostra banner";
$GLOBALS['strShowAllBanners'] = "Mostra tutti i banner";
$GLOBALS['strShowBannersNoAdViews'] = "Mostra i banner senza visualizzazioni";
$GLOBALS['strShowBannersNoAdClicks'] = "Mostra i banner senza click";
$GLOBALS['strDeleteAllBanners'] = "Cancella tutti i banner";
$GLOBALS['strActivateAllBanners'] = "Attiva tutti i banner";
$GLOBALS['strDeactivateAllBanners'] = "Disattiva tutti i banner";
$GLOBALS['strBannerOverview'] = "Descrizione banner";
$GLOBALS['strBannerProperties'] = "Impostazioni banner";
$GLOBALS['strBannerHistory'] = "Storico banner";
$GLOBALS['strBannerNoStats'] = "Non ci sono statistiche disponibili per questo banner";
$GLOBALS['strNoBanners'] = "Non è ancora stato creato nessun banner";
$GLOBALS['strNoBannersAddCampaign'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strConfirmDeleteBanner'] = "Vuoi veramente cancellare questo banner?";
$GLOBALS['strConfirmDeleteBanners'] = "Vuoi veramente cancellare questo banner?";
$GLOBALS['strConfirmDeleteAllBanners'] = "Vuoi veramente cancellare tutti i banner appartenenti a questa campagna?";
$GLOBALS['strConfirmResetBannerStats'] = "Vuoi veramente cancellare tutte le statistiche di questo banner?";
$GLOBALS['strShowParentCampaigns'] = "Mostra campagne";
$GLOBALS['strHideParentCampaigns'] = "Nascondi campagne";
$GLOBALS['strHideInactiveBanners'] = "Nascondi banner inattivi";
$GLOBALS['strInactiveBannersHidden'] = "banner inattivi nascosti";
$GLOBALS['strAppendOthers'] = "Accoda altri";
$GLOBALS['strAppendTextAdNotPossible'] = "Non è possibile accodare altri banner ai banner testuali.";
$GLOBALS['strWarningMissing'] = "Attenzione, possibile omissione";
$GLOBALS['strWarningMissingClosing'] = "chiusura del tag \">\"";
$GLOBALS['strWarningMissingOpening'] = "apertura tag \"<\"";
$GLOBALS['strSubmitAnyway'] = "Invia comunque";
$GLOBALS['strOverallBanners'] = "Banner";
$GLOBALS['strBannerPreferences'] = "Preferenze banner";
$GLOBALS['strDefaultBannerDestination'] = "URL di destinazione predefinito";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Per favore seleziona il tipo di banner";
$GLOBALS['strMySQLBanner'] = "Banner locale (SQL)";
$GLOBALS['strWebBanner'] = "Banner locale (su questo Webserver)";
$GLOBALS['strURLBanner'] = "Banner esterno";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strTextBanner'] = "Banner testuale";
$GLOBALS['strUploadOrKeep'] = "Preferisci mantenere la<br />immagine esistente, o preferisci<br />caricarne un altra?";
$GLOBALS['strUploadOrKeepAlt'] = "Preferisci mantenere la<br />immagine di backup esistente, o preferisci<br />caricarne un altra?";
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

// Banner (advanced)

// Banner (swf)
$GLOBALS['strCheckSWF'] = "Controlla links presenti all'interno del file flash";
$GLOBALS['strConvertSWFLinks'] = "Converti links Flash";
$GLOBALS['strHardcodedLinks'] = "Link codificati all'interno del file";
$GLOBALS['strConvertSWF'] = "<br />Il file Flash appena caricato contiene urls codificati. {$PRODUCT_NAME} non risulta in grado ditracciare il numero di click per questo banner fino a quando non convertirai questi urls codificati. Di seguito troverai una lista di tutti gli urls presenti nel file flash. Se vuoi convertire questi urls, semplicemente clicca <b>Converti</b>, altrimenti clicca <b>Cancella</b>.<br /><br /> Nota Bene: cliccando <b>Converti</b> il file flash che hai appena caricato viene modificato fisicamente. <br />Tieni da parte una copia di backup del file originale. Indipendentemente alla versione di flash utilizzata, il file risultante necessita del plug-in Flash 4 (o superiore).<br /><br />";
$GLOBALS['strCompressSWF'] = "Comprimi il file SWF per uno scaricamento più veloce (plug-in Flash 6 necessario)";
$GLOBALS['strOverwriteSource'] = "Sovrascrivi parametro sorgente";

// Banner (network)
$GLOBALS['strBannerNetwork'] = "Template HTML";
$GLOBALS['strChooseNetwork'] = "Scegli il modello da utilizzare";
$GLOBALS['strMoreInformation'] = "Maggiori informazioni...";
$GLOBALS['strTrackAdClicks'] = "Traccia i Click";

// Banner (AdSense)
$GLOBALS['strAdSenseAccounts'] = "Account AdSense";
$GLOBALS['strLinkAdSenseAccount'] = "Link Account AdSense";
$GLOBALS['strCreateAdSenseAccount'] = "Crea Account AdSense";
$GLOBALS['strEditAdSenseAccount'] = "Modifica Account AdSense";

// Display limitations
$GLOBALS['strModifyBannerAcl'] = "Impostazioni di consegna";
$GLOBALS['strACL'] = "Consegna";
$GLOBALS['strACLAdd'] = "Aggiungi nuova limitazione";
$GLOBALS['strACLAdd_Key'] = "Aggiungi <u>nuova</u> limitazione";
$GLOBALS['strNoLimitations'] = "Nessuna limitazione";
$GLOBALS['strApplyLimitationsTo'] = "Applica limitazioni a";
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
$GLOBALS['strOnlyDisplayWhen'] = "Mostra questo banner solo quando:";
$GLOBALS['strWeekDay'] = "Giorno della settimana";
$GLOBALS['strWeekDays'] = "Giorni della settimana";
$GLOBALS['strTime'] = "Ora";
$GLOBALS['strDomain'] = "Dominio";
$GLOBALS['strClientIP'] = "IP Client";
$GLOBALS['strSource'] = "Risorsa";
$GLOBALS['strOS'] = "Sistema operativo";
$GLOBALS['strCity'] = "Città";
$GLOBALS['strReferer'] = "Pagina di provenienza";
$GLOBALS['strDeliveryLimitations'] = "Limitazioni consegna";

$GLOBALS['strDeliveryCapping'] = "Limitazione di consegna per visitatore";
$GLOBALS['strDeliveryCappingReset'] = "Azzera contatore visualizzazioni dopo:";
$GLOBALS['strDeliveryCappingTotal'] = "in totale";
$GLOBALS['strDeliveryCappingSession'] = "per sessione";

$GLOBALS['strCappingBanner'] = array();
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingBanner']['limit'] = "Limita visualizzazioni banner a:";

$GLOBALS['strCappingCampaign'] = array();
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['limit'] = "Limita visualizzazioni campagna a:";

$GLOBALS['strCappingZone'] = array();
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['limit'] = "Limita visualizzazioni zona a:";

// Website
$GLOBALS['strAffiliate'] = "Sito";
$GLOBALS['strAffiliates'] = "Editori";
$GLOBALS['strAffiliatesAndZones'] = "Editori e Zone";
$GLOBALS['strAddNewAffiliate'] = "Aggiungi un nuovo editore";
$GLOBALS['strAddNewAffiliate_Key'] = "Aggiungi un <u>n</u>uovo editore";
$GLOBALS['strAddAffiliate'] = "Crea editore";
$GLOBALS['strAffiliateProperties'] = "Impostazioni editore";
$GLOBALS['strAffiliateOverview'] = "Descrizione Editore";
$GLOBALS['strAffiliateHistory'] = "Storico editore";
$GLOBALS['strZonesWithoutAffiliate'] = "Zone senza editore";
$GLOBALS['strMoveToNewAffiliate'] = "Muovi verso un nuovo editore";
$GLOBALS['strNoAffiliates'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Desideri realmente cancellare questo editore?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Desideri realmente cancellare questo editore?";
$GLOBALS['strMakePublisherPublic'] = "Rendi pubblicamente disponibili le zone di questo editore";
$GLOBALS['strAffiliateInvocation'] = "Codice di invocazione";
$GLOBALS['strAdvertiserSetup'] = "Registrazione inserzionisti";
$GLOBALS['strTotalAffiliates'] = "Totale editori";
$GLOBALS['strInactiveAffiliatesHidden'] = "editori inattivi nascosti";
$GLOBALS['strShowParentAffiliates'] = "Mostra editori padri";
$GLOBALS['strHideParentAffiliates'] = "Nascondi editori padri";

// Website (properties)
$GLOBALS['strWebsite'] = "Sito";
$GLOBALS['strWebsiteURL'] = "URL del sito";
$GLOBALS['strMnemonic'] = "Mnemonico";
$GLOBALS['strAllowAffiliateModifyInfo'] = "Permetti a questo utente di modificare le proprie impostazioni";
$GLOBALS['strAllowAffiliateModifyZones'] = "Permetti a questo utente di modificare le proprie zone";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Permetti a questo utente di collegare i banner alle proprie zone";
$GLOBALS['strAllowAffiliateAddZone'] = "Permetti a questo utente di definire nuove zone";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Permetti a questo utente di cancellare le zone esistenti";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permetti a questo utente di generare il codice di invocazione";
$GLOBALS['strAllowAffiliateZoneStats'] = "Permetti a questo utente di visualizzare le statistiche per zona";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Permetti a questo utente di visualizzare solo le conversioni approvate o pendenti";

// Website (properties - payment information)
$GLOBALS['strPaymentInformation'] = "Informazioni di pagamento";
$GLOBALS['strAddress'] = "Indirizzo";
$GLOBALS['strPostcode'] = "CAP";
$GLOBALS['strCity'] = "Città";
$GLOBALS['strCountry'] = "Stato";
$GLOBALS['strPhone'] = "Telefono";
$GLOBALS['strAccountContact'] = "Contatto account";
$GLOBALS['strPayeeName'] = "Nome";
$GLOBALS['strModeOfPayment'] = "Modalità di pagamento";
$GLOBALS['strPaymentChequeByPost'] = "Ordine per post";
$GLOBALS['strCurrency'] = "Valuta";

// Website (properties - other information)
$GLOBALS['strOtherInformation'] = "Altre informazioni";
$GLOBALS['strUniqueUsersMonth'] = "Utenti unici al mese";
$GLOBALS['strUniqueViewsMonth'] = "Visite uniche al mese";
$GLOBALS['strCategory'] = "Categoria";
$GLOBALS['strHelpFile'] = "File di Aiuto";
$GLOBALS['strWebsiteZones'] = "Editori e Zone";

// Zone
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strZones'] = "Zone";
$GLOBALS['strAddNewZone'] = "Aggiungi una nuova zona";
$GLOBALS['strAddNewZone_Key'] = "Aggiungi una <u>n</u>uova zona";
$GLOBALS['strAddZone'] = "Crea zona";
$GLOBALS['strModifyZone'] = "Modifica zona";
$GLOBALS['strZoneToWebsite'] = "Nessun sito";
$GLOBALS['strLinkedZones'] = "Zone collegate";
$GLOBALS['strZoneOverview'] = "Descrizione zona";
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
$GLOBALS['strZoneClick'] = "Zona tracciamento click";
$GLOBALS['strShowMatchingBanners'] = "Mostra banner corrispondenti";
$GLOBALS['strHideMatchingBanners'] = "Nascondi banner corrispondenti";
$GLOBALS['strBannerLinkedAds'] = "Banner collegati alla zona";
$GLOBALS['strCampaignLinkedAds'] = "Campagne collegate alla zona";
$GLOBALS['strTotalZones'] = "Zone totali";
$GLOBALS['strInactiveZonesHidden'] = "zone inattive nascoste";
$GLOBALS['strWarnChangeZoneType'] = "Cambiando il tipo di zona a testo o email saranno persi i collegamenti a banner o campagne per via delle limitazioni di questo tipo di zona
<ul>
<li>Zone testuali possono essere collegate solo a inserzioni testuali</li>
<li>Zone delle campagne Email possono avere solo un banner attivo alla volta</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Cambiando la dimensione della zona si perderanno i collegamenti con tutti i banner che non sono della nuova dimensione, e saranno aggiunti tutti i banner dalle campagne collegate che sono della nuova dimensione';
$GLOBALS['strWarnChangeBannerSize'] = 'Cambiando la dimensione del banner tutti i banner che non sono della nuova dimensione verranno scollegati dalle relative zone, e se la campagna di questo banner è collegato ad una zona della nuova dimensione, questo banner sarà collegato automaticamente';
$GLOBALS['strInventoryForecasting'] = 'Previsione inventario';


// Advanced zone settings
$GLOBALS['strAdvanced'] = "Avanzate";
$GLOBALS['strChains'] = "Catene";
$GLOBALS['strChainSettings'] = "Impostazioni della catena";
$GLOBALS['strZoneNoDelivery'] = "Se nessun banner di questa zona <br />può essere fornito, prova a...";
$GLOBALS['strZoneStopDelivery'] = "Arrestare la fornitura e non visualizzare alcun banner";
$GLOBALS['strZoneOtherZone'] = "Mostrare la zona selezionata in sostituzione";
$GLOBALS['strZoneUseKeywords'] = "Scegliere un banner usando la seguente stringa di query";
$GLOBALS['strZoneAppend'] = "Aggiungi sempre il seguente codice HTML ai banner di questa zona";
$GLOBALS['strAppendSettings'] = "Impostazioni prefisso e suffisso";
$GLOBALS['strZoneForecasting'] = "Impostazioni previsioni della zona";
$GLOBALS['strZonePrependHTML'] = "Codice HTML da utilizzare come prefisso per i banner testuali visualizzati in questa zona";
$GLOBALS['strZoneAppendHTML'] = "Codice HTML da utilizzare come suffisso per i banner testuali visualizzati in questa zona";
$GLOBALS['strZoneAppendNoBanner'] = "Utilizza come suffisso anche se non viene fornito alcun banner";
$GLOBALS['strZoneAppendType'] = "Tipo di suffisso";
$GLOBALS['strZoneAppendHTMLCode'] = "Codice HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup o interstiziale";
$GLOBALS['strZoneAppendSelectZone'] = "Aggiungi sempre il seguente popup o interstiziale ai banner di questa zona";

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
$GLOBALS['strInteractive'] = "Interattivo";
$GLOBALS['strRawQueryString'] = "Parola chiave";
$GLOBALS['strIncludedBanners'] = "Banner collegati";
$GLOBALS['strLinkedBannersOverview'] = "Descrizione banner collegati";
$GLOBALS['strLinkedBannerHistory'] = "Storico banner collegati";
$GLOBALS['strNoZonesToLink'] = "Non ci sono zone disponibili a cui questo banner possa essere collegato";
$GLOBALS['strNoBannersToLink'] = "Non ci sono banner disponibili che possano essere collegati a questa zona";
$GLOBALS['strNoLinkedBanners'] = "Non ci sono banner disponibili che siano collegati a questa zona";
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
$GLOBALS['strTrackerCodeSubject'] = "Accoda codice tracker";
$GLOBALS['strStatusPending'] = "In attesa";
$GLOBALS['strStatusApproved'] = "Approvato";
$GLOBALS['strStatusDisapproved'] = "Rifiutato";
$GLOBALS['strStatusDuplicate'] = "Duplicato";
$GLOBALS['strStatusOnHold'] = "Sospeso";
$GLOBALS['strStatusIgnore'] = "Ignora";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strConnTypeSale'] = "Vendita";
$GLOBALS['strConnTypeSignUp'] = "Iscrizione";
$GLOBALS['strShortcutEditStatuses'] = "Modifica stati";
$GLOBALS['strShortcutShowStatuses'] = "Mostra stati";

// Statistics
$GLOBALS['strStats'] = "Statistiche";
$GLOBALS['strNoStats'] = "Non ci sono statistiche disponibili";
$GLOBALS['strNoTargetingStats'] = "Non ci sono statistiche sul targeting disponibili";
$GLOBALS['strNoStatsForPeriod'] = "Non sono disponibili statistiche per il periodo dal %s al %s";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Non sono disponibili statistiche sul targeting per il periodo dal %s al %s";
$GLOBALS['strConfirmResetStats'] = "Vuoi veramente cancellare tutte le statistiche?";
$GLOBALS['strGlobalHistory'] = "Storico globale";
$GLOBALS['strDailyHistory'] = "Storico giornaliero";
$GLOBALS['strDailyStats'] = "Statistiche giornaliere";
$GLOBALS['strWeeklyHistory'] = "Storico settimanale";
$GLOBALS['strMonthlyHistory'] = "Storico mensile";
$GLOBALS['strCreditStats'] = "Statistiche credito";
$GLOBALS['strDetailStats'] = "Statistiche dettagliate";
$GLOBALS['strTotalThisPeriod'] = "Totale in questo periodo";
$GLOBALS['strAverageThisPeriod'] = "Media in questo periodo";
$GLOBALS['strPublisherDistribution'] = "Distribuzione editori";
$GLOBALS['strCampaignDistribution'] = "Distribuzione campagne";
$GLOBALS['strResetStats'] = "Azzera statistiche";
$GLOBALS['strSourceStats'] = "Statistiche sorgente";
$GLOBALS['strSelectSource'] = "Seleziona la sorgente da visualizzare:";
$GLOBALS['strSizeDistribution'] = "Distribuzione per dimensioni";
$GLOBALS['strCountryDistribution'] = "Distribuzione per stato";
$GLOBALS['strEffectivity'] = "Efficacia";
$GLOBALS['strTargetStats'] = "Statistiche target di visualizzazioni";
$GLOBALS['strTargetRatio'] = "Rapporto";
$GLOBALS['strTargetModifiedDay'] = "I target sono stati modificati durante il giorno, il targeting può essere impreciso";
$GLOBALS['strTargetModifiedWeek'] = "I target sono stati modificati durante la settimana, il targeting può essere impreciso";
$GLOBALS['strTargetModifiedMonth'] = "I target sono stati modificati durante il mese, il targeting può essere impreciso";
$GLOBALS['strNoTargetStats'] = "Non ci sono statistiche sul targeting disponibili";
$GLOBALS['strViewBreakdown'] = "Visto da";
$GLOBALS['strBreakdownByDay'] = "Giorno";
$GLOBALS['strBreakdownByWeek'] = "Settimana";
$GLOBALS['strBreakdownByMonth'] = "Mese";
$GLOBALS['strBreakdownByDow'] = "Giorno della settimana";
$GLOBALS['strBreakdownByHour'] = "Ora";
$GLOBALS['strItemsPerPage'] = "Oggetti per pagina";
$GLOBALS['strDistributionHistory'] = "Storico distribuzioni";
$GLOBALS['strShowGraphOfStatistics'] = "Mostra <u>G</u>rafico delle Statistiche";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>sporta Statistiche in Excel";
$GLOBALS['strGDnotEnabled'] = "E' necessario avere GD abilitato in PHP per mostrare i grafici. Per maggiori informazioni su coma abilitare GD sul tuo sistema consulta <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>.";

// Hosts
$GLOBALS['strHosts'] = "Host";
$GLOBALS['strTopHosts'] = "Host con più richieste";
$GLOBALS['strTopCountries'] = "Stati con più richieste";
$GLOBALS['strRecentHosts'] = "Host più recenti";

// Expiration
$GLOBALS['strExpired'] = "Scaduto";
$GLOBALS['strExpiration'] = "Scadenza";
$GLOBALS['strNoExpiration'] = "Data scadenza non impostata";
$GLOBALS['strEstimated'] = "Scadenza prevista";
$GLOBALS['strNoExpirationEstimation'] = "Non è ancora stata stimata nessuna scadenza.";
$GLOBALS['strDaysAgo'] = "giorni fa";
$GLOBALS['strCampaignStop'] = "Termina campagna";

// Reports
$GLOBALS['strReports'] = "Rapporti";
$GLOBALS['strPublisherReports'] = "Rapporti Editore";
$GLOBALS['strSelectReport'] = "Seleziona il rapporto che vuoi generare";
$GLOBALS['strStartDate'] = "Data Inzio";
$GLOBALS['strEndDate'] = "Data Fine";
$GLOBALS['strPeriod'] = "Periodo";
$GLOBALS['strLimitations'] = "Limitazioni";
$GLOBALS['strWorksheets'] = "Foglio di lavoro";

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
$GLOBALS['strOptional'] = "opzionale";
$GLOBALS['strBackToTheList'] = "Torna alla lista dei report";
$GLOBALS['strCharset'] = "Set di caratteri";
$GLOBALS['strAutoDetect'] = "Riconoscimento automatico";


// Errors
$GLOBALS['strMySQLError'] = "Errore SQL:";
$GLOBALS['strErrorDatabaseConnetion'] = "Errore nella connessione al database";
$GLOBALS['strErrorCantConnectToDatabase'] = "Errore fatale %s non può collegarsi al database. Per tanto non è possibile usare l'interfaccia amministrativa. Inoltre può essere stata compromessa la distribuzione dei banner. Possibili cause del problema:<ul><li>Il server database in questo momento non funziona</li> <li>L'indirizzo del server database è cambiato</li> <li>Le credenziali di accesso al server database non sono corrette</li> <li>L'estensione MySQL di PHP non è stata caricata</li> </ul>";
$GLOBALS['strLogErrorClients'] = "[OpenX] Errore intercorso durante il tentativo di estrarre gli inserzionisti dal database.";
$GLOBALS['strLogErrorBanners'] = "[OpenX] Errore intercorso durante il tentativo di estrarre i banner dal database.";
$GLOBALS['strLogErrorViews'] = "[OpenX] Errore intercorso durante il tentativo di estrarre le visualizzazioni dal database.";
$GLOBALS['strLogErrorClicks'] = "[OpenX] Errore intercorso durante il tentativo di estrarre i click dal database.";
$GLOBALS['strLogErrorConversions'] = "[OpenX] Errore intercorso durante il tentativo di estrarre le conversioni dal database.";
$GLOBALS['strErrorViews'] = "Devi inserire il nomero di visualizzazioni oppure selezionare il checkbox illimitati !";
$GLOBALS['strErrorNegViews'] = "Le visualizzazioni negative non sono permesse";
$GLOBALS['strErrorClicks'] = "Devi inserire il numero di click oppure selezionare il checkbox illimitati !";
$GLOBALS['strErrorNegClicks'] = "I click negativi non sono permessi";
$GLOBALS['strNoMatchesFound'] = "Nessuna corrispondenza trovata";
$GLOBALS['strErrorOccurred'] = "Segnalazione Errore";
$GLOBALS['strErrorUploadSecurity'] = "È stato riscontrato un possibile problema di sicurezza nell'upload. Upload bloccato!";
$GLOBALS['strErrorUploadBasedir'] = "Impossibile accedere al file uploadato, probabilmente ciò è dovuto alle impostazioni di sicurezza safe_mode e/o open_basedir del PHP";
$GLOBALS['strErrorUploadUnknown'] = "Impossibile accedere al file uploadato per un motivo sconosciuto. Controllare la propria configurazione del PHP";
$GLOBALS['strErrorStoreLocal'] = "Impossibile salvare il banner nella directory locale. La causa probabile è una configurazione errata del percorso della directory locale";
$GLOBALS['strErrorStoreFTP'] = "Impossibile effetuare l'upload del banner via FTP. Il server potrebbe non essere raggiungibile o i parametri di connessione sono errati";
$GLOBALS['strErrorDBPlain'] = "Si è verificato un errore nell'accesso al database";
$GLOBALS['strErrorDBSerious'] = "È stato riscontrato un grave problema con il database";
$GLOBALS['strErrorDBNoDataPlain'] = "A causa di un problema con il database {$PRODUCT_NAME} non può leggere o memorizzare i dati. ";
$GLOBALS['strErrorDBNoDataSerious'] = "A causa di un grave problema con il database, {$PRODUCT_NAME} non può leggere i dati";
$GLOBALS['strErrorDBCorrupt'] = "Probabilmente la tabella è corrotta ed è necessario ripararla. Per avere più informazioni su come riparare le tabelle corrotte, leggere il capitolo <i>Troubleshooting</i> della <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Contatta l'amministratore di questo server ed informalo del problema.";
$GLOBALS['strErrorDBSubmitBug'] = "Se questo problema è riproducibile, potrebbe essere causato da un bug di {$PRODUCT_NAME}. Per favore sottoponi le informazioni sottostanti ai creatori di {$PRODUCT_NAME}. Tenta inoltre di descrivere le azioni che hanno portato a questo errore il più chiaramente possible.";
$GLOBALS['strMaintenanceNotActive'] = "La procedura di manutenzione non è stata avviata nelle ultime 24 ore.
Per fare in modo che {$PRODUCT_NAME} funzioni correttamente, lo script deve essere avviato ogni ora

Consulta la guida per l'amministratore per maggiori informazioni sulla
configurazione dello script di manutenzione.";
$GLOBALS['strErrorLinkingBanner'] = "Non è stato possibile collegare questo banner a questa zona perché:";
$GLOBALS['strUnableToLinkBanner'] = "Impossibile collegare questo banner:";
$GLOBALS['strErrorEditingCampaign'] = "Errore durante il caricamento della campagna:";
$GLOBALS['strUnableToChangeCampaign'] = "Impossibile applicare questi cambiamenti perché:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "numero nel formato non corretto per il campo Informazioni ricavi ";
$GLOBALS['strErrorEditingZone'] = "Errore durante l'aggiornamento della zona:";
$GLOBALS['strUnableToChangeZone'] = "Impossibile applicare questi cambiamenti perché:";
$GLOBALS['strDatesConflict'] = "le date sono in conflitto con:";
$GLOBALS['strEmailNoDates'] = "Campagne zone Email devono avere una data di inizio e una data di fine";
$GLOBALS['strWarningInaccurateStats'] = "Alcune di queste statistiche sono state loggate in un fuso orario non Universal Time, potrebbero non essere mostrate nel fuso orario corretto.";
$GLOBALS['strWarningInaccurateReadMore'] = "Leggi di più in proposito";
$GLOBALS['strWarningInaccurateReport'] = "Alcune delle statistiche in questo report sono state loggate in un fuso orario non Universal Time, potrebbero non essere mostrate nel fuso orario corretto";

//Validation
$GLOBALS['strRequiredField'] = "Campo obbligatorio";


// Email
$GLOBALS['strSirMadam'] = "Signore/Signora";
$GLOBALS['strMailSubject'] = "Rapporto inserzionista";
$GLOBALS['strAdReportSent'] = "Rapporto inserzionista spedito";
$GLOBALS['strMailHeader'] = "Gentile {contact},";
$GLOBALS['strMailBannerStats'] = "Di seguito troverai le statistiche di visualizzazione banner per {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campagna attivata";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campagna disattivata";
$GLOBALS['strMailBannerActivated'] = "Questa campagna non risulta attualmente attiva poiché";
$GLOBALS['strMailBannerDeactivated'] = "La campagna segnalata di seguito è stata disattivata perché";
$GLOBALS['strMailFooter'] = "Cordiali saluti,
   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] = "I seguenti banner sono stati disattivati poiché";
$GLOBALS['strMailNothingLeft'] = "Se desideri continuare ad apparire sul nostro sito con i tuoi banner, per favore contattaci.
Saremo felici di poter soddisfare le tue richieste.";
$GLOBALS['strClientDeactivated'] = "Questa campagna non risulta attualmente attiva poich�";
$GLOBALS['strBeforeActivate'] = "non ha raggiunto la data di attivazione";
$GLOBALS['strAfterExpire'] = "ha raggiunto la data di scadenza";
$GLOBALS['strNoMoreImpressions'] = "non sono rimaste visualizzazioni";
$GLOBALS['strNoMoreClicks'] = "non ci sono più Click a disposizione";
$GLOBALS['strNoMoreConversions'] = "non ci sono Vendite rimaste";
$GLOBALS['strWeightIsNull'] = "il suo peso è impostato a zero";
$GLOBALS['strWarnClientTxt'] = "I click e le visualizzazioni rimaste per i tuoi banner sono inferiori a {limit}.
I tuoi banner verranno disabilitati quando termineranno i click o visualizzazioni a tua dispoizione. ";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Visualizzazioni/Click/Conversioni sono basse";
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
$GLOBALS['strImpendingCampaignExpiryBody'] = "Come risultato, la campagna sarà presto disabilitata automaticamente, così come
verranno disabilitati i seguenti banner:";

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
$GLOBALS['strAdminEmailWarnings'] = "Email di notifica amministratore";
$GLOBALS['strAgencyEmailWarnings'] = "Email di notifica agenzia";
$GLOBALS['strAdveEmailWarnings'] = "Email di notifica inserzionista";
$GLOBALS['strFullName'] = "Nome completo";
$GLOBALS['strEmailAddress'] = "Indirizzo email";
$GLOBALS['strUserDetails'] = "Dettagli utente";
$GLOBALS['strLanguageTimezone'] = "Lingua & Timezone";
$GLOBALS['strLanguageTimezonePreferences'] = "Preferenze lingua e fuso orario";
$GLOBALS['strUserInterfacePreferences'] = "Preferenze interfaccia utente";
$GLOBALS['strPluginPreferences'] = "Preferenze principali";
$GLOBALS['strInvocationPreferences'] = "Preferenze invocazione";
$GLOBALS['strColumnName'] = "Nome colonna";
$GLOBALS['strShowColumn'] = "Mostra colonna";
$GLOBALS['strCustomColumnName'] = "Nome colonna personalizzato";
$GLOBALS['strColumnRank'] = "Colonna Rank";


// Statistics columns
// Long names
$GLOBALS['strRevenue'] = "Entrate";
$GLOBALS['strNumberOfItems'] = "Numero di oggetti";
$GLOBALS['strRevenueCPC'] = "Ricavo Cost Per Click (CPC)";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strPendingConversions'] = "Conversioni in attesa";
$GLOBALS['strImpressionSR'] = "Visualizzazione SR";
$GLOBALS['strActualImpressions'] = "Impressioni";

// Short names
$GLOBALS['strRevenue_short'] = "Ric.";
$GLOBALS['strNumberOfItems_short'] = "Num. Ogg.";
$GLOBALS['strRevenueCPC_short'] = "Ric. CPC";
$GLOBALS['strRequests_short'] = "Ric.";
$GLOBALS['strClicks_short'] = "Click";
$GLOBALS['strPendingConversions_short'] = "Conv. in attesa";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Impostazioni globali";
$GLOBALS['strGeneralSettings'] = "Impostazioni generali";
$GLOBALS['strMainSettings'] = "Impostazioni principali";
$GLOBALS['strAdminSettings'] = "Impostazioni amministratore";


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
$GLOBALS['strInstallation'] = "Installazione";
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
$GLOBALS['strAddAgency'] = "Aggiungi un nuovo account";
$GLOBALS['strAddAgency_Key'] = "Aggiungi un <u>n</u>uovo account";
$GLOBALS['strTotalAgencies'] = "Account totali";
$GLOBALS['strAgencyProperties'] = "Proprietà dell'account";
$GLOBALS['strNoAgencies'] = "Non è stato definito alcun account";
$GLOBALS['strConfirmDeleteAgency'] = "Vuoi davvero cancellare questo account?";
$GLOBALS['strHideInactiveAgencies'] = "Nascondi gli account non attivi";
$GLOBALS['strInactiveAgenciesHidden'] = "account non attivi, nascosti";
$GLOBALS['strAllowAgencyEditConversions'] = "Consenti a questo utente di modificare le conversioni";
$GLOBALS['strAllowMoreReports'] = "Consenti pulsante 'Più Rapporti'";
$GLOBALS['strSwitchAccount'] = "Passa a questo account";

// Channels
$GLOBALS['strChannel'] = "Canale di targeting";
$GLOBALS['strChannels'] = "Canali di targeting";
$GLOBALS['strChannelOverview'] = "Descrizione canale di targeting";
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
$GLOBALS['strModifychannel'] = "Modifica obiettivo del canale";
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
$GLOBALS['strVariableHidden'] = "Nascondere variabile per l'editore?";
$GLOBALS['strVariableRejectEmpty'] = "Rifiuta se vuoto?";
$GLOBALS['strTrackingSettings'] = "Impostazioni tracciamenti";
$GLOBALS['strTrackerType'] = "Tipo di tracciatore";
$GLOBALS['strTrackerTypeJS'] = "Traccia variabili Javascript";
$GLOBALS['strTrackerTypeDefault'] = "Traccia variabili Javascript (compatibilità con le versioni precedenti, richiesto l'escaping)";
$GLOBALS['strTrackerTypeDOM'] = "Traccia elementi HTML utilizzando DOM";
$GLOBALS['strTrackerTypeCustom'] = "Codice Javascript personalizzato";
$GLOBALS['strVariableCode'] = "Codice tracciamento Javascript";


// Upload conversions
$GLOBALS['strYouHaveNoCampaigns'] = "Inserzionisti e Campagne";


// Password recovery
$GLOBALS['strForgotPassword'] = "Hai dimenticato la password?";
$GLOBALS['strPasswordRecovery'] = "Recupero password";
$GLOBALS['strEmailRequired'] = "Email è un campo richiesto";
$GLOBALS['strPwdRecEmailSent'] = "Spedizione della email di recupero password";
$GLOBALS['strPwdRecEmailNotFound'] = "Indirizzo email non trovato";
$GLOBALS['strPwdRecPasswordSaved'] = "La nuova password è stata salvata, procedi con il <a href='index.php'>login</a>";
$GLOBALS['strPwdRecWrongId'] = "ID errato";
$GLOBALS['strPwdRecEnterEmail'] = "Inserisci il tuo indirizzo e-mail qui sotto";
$GLOBALS['strPwdRecEnterPassword'] = "Inserisci qui sotto la nuova password";
$GLOBALS['strPwdRecReset'] = "Reimpostazione password";
$GLOBALS['strPwdRecResetLink'] = "Link reset della password";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Reimpostazione password per questo utente";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s password recuperata";
$GLOBALS['strNotifyPageMessage'] = "Ti è stata spedita una email con un link che ti permetterà di reimpostare la password ed entrare nel sistema.<br />Attendi pochi minutil l'arrivo della email.<br />Se non la ricevi entro breve, controlla che non sia finita nella posta indesiderata.<br /><a href='index.php'>Torna alla pagina di accesso.</a>";

// Audit
$GLOBALS['strAdditionalItems'] = "e oggetti aggiuntivi";
$GLOBALS['strFor'] = "per";
$GLOBALS['strHas'] = "era";
$GLOBALS['strAdZoneAsscociation'] = "Associazione zona";
$GLOBALS['strBinaryData'] = "Dati binari";
$GLOBALS['strAuditTrailDisabled'] = "L'amministratore ha disabilitato Audit Trail. Non saranno registrati e mostrati ulteriori eventi nella lista Audit Trail.";
$GLOBALS['strAccountUserAssociation'] = "Associazione account utente";
$GLOBALS['strEvent'] = "Evento";
$GLOBALS['strImage'] = "Immagine";
$GLOBALS['strCampaignZoneAssociation'] = "Associazione zona";
$GLOBALS['strAccountPreferenceAssociation'] = "Associazione preferenze account";


// Widget - Audit
$GLOBALS['strAuditNoData'] = "Nessuna attività dell`utente  è stata registrata durante il periodo di tempo che hai selezionato.";
$GLOBALS['strAuditTrailSetup'] = "Importa Audit Trail oggi";
$GLOBALS['strAuditTrailGoTo'] = "Vai alla pagina Audit Trail";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail ti permette di vedere chi ha fatto cosa e quando. In altre parole, Audit Trail mantiene traccia dei cambiamenti del sistema {$PRODUCT_NAME}</li>
<li>Se visualizzi questo messaggio, Audit Trail non è stato attivato</li>
<li>Vuoi saperne di più? Leggi la <a href='{$PRODUCT_DOCSURL}/settings/auditTrail' class='site-link' target='help' >Documentazione Audit Trail</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Vai alla pagina delle campagne";
$GLOBALS['strCampaignSetUp'] = "Impostare una campagna di oggi";
$GLOBALS['strCampaignNoRecords'] = "<li>Le campagne ti permettono di raggruppare insieme banner di ogni dimensione che condividono gli stessi requisiti</li><li>Risparmia tempo definendo guppi di banner e non dovrai più impostare tutti i parametri singolarmente per ogni banner</li><li>Consulta la <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/inventory/advertisersAndCampaigns/campaigns'>Documentazione sulle Campagne</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Non ci sono attività da mostrare.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Nessuna campagna avviata o finita durante il periodo selezionato";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Per essere in grado di vedere le campagne iniziate o concluse durante il lasso di tempo che hai selezionato, devi attivare Audit Trail</li>	        <li>Stai leggendo questo messaggio perché Audit Trail non è stato attivato.</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Attiva Audit Trail per iniziare a vedere le campagne";

$GLOBALS['strUnsavedChanges'] = "I cambiamenti effettuati su questa pagina non sono stati salvati, accertati di premere \"Salva cambiamenti\" al termine";
$GLOBALS['strDeliveryLimitationsDisagree'] = "ATTENZIONE: Alcune limitazioni del motore di distribuzione <strong>non permettono</strong> le limitazioni elencate di seuito<br /> Per favore premi &quot;salva cambiamenti&quot; per aggiornare le regole di distribuzione del motore.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Alcune limitazioni di distribuzione hanno riportato dei valori incorretti:";

//confirmation messages











/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "c";
$GLOBALS['keyCollapseAll'] = "h";
$GLOBALS['keyNext'] = "s";

/* ------------------------------------------------------- */
/* Languages Names                                       */
/* ------------------------------------------------------- */

$GLOBALS['str_ar'] = "Arabo";
$GLOBALS['str_bg'] = "Bulgaro";
$GLOBALS['str_cs'] = "Ceco";
$GLOBALS['str_cy'] = "Gallese";
$GLOBALS['str_da'] = "Danese";
$GLOBALS['str_de'] = "Tedesco";
$GLOBALS['str_el'] = "Greco";
$GLOBALS['str_en'] = "Inglese";
$GLOBALS['str_es'] = "Spagnolo";
$GLOBALS['str_fa'] = "Persiano";
$GLOBALS['str_fr'] = "Francese";
$GLOBALS['str_he'] = "Ebraico";
$GLOBALS['str_hr'] = "Croato";
$GLOBALS['str_hu'] = "Ungherese";
$GLOBALS['str_id'] = "Indonesiano";
$GLOBALS['str_it'] = "Italiano";
$GLOBALS['str_ja'] = "Giapponese";
$GLOBALS['str_ko'] = "Coreano";
$GLOBALS['str_lt'] = "Lituano";
$GLOBALS['str_ms'] = "Malese";
$GLOBALS['str_nb'] = "Norvegese Bokmål";
$GLOBALS['str_nl'] = "Olandese";
$GLOBALS['str_pl'] = "Polacco";
$GLOBALS['str_ro'] = "Rumeno";
$GLOBALS['str_ru'] = "Russo";
$GLOBALS['str_sk'] = "Slovacco";
$GLOBALS['str_sl'] = "Sloveno";
$GLOBALS['str_sv'] = "Svedese";
$GLOBALS['str_tr'] = "Turco";
$GLOBALS['str_uk'] = "Ucraino";
?>
