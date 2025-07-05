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

// Installer translation strings
$GLOBALS['strInstall'] = "Installa";
$GLOBALS['strDatabaseSettings'] = "Impostazioni database";
$GLOBALS['strAdminAccount'] = "Account dell'amministratore";
$GLOBALS['strAdvancedSettings'] = "Impostazioni avanzate";
$GLOBALS['strWarning'] = "Attenzione";
$GLOBALS['strBtnContinue'] = "Continua »";
$GLOBALS['strBtnRecover'] = "Recupera »";
$GLOBALS['strBtnAgree'] = "Acconsento »";
$GLOBALS['strBtnRetry'] = "Riprova";
$GLOBALS['strTablesPrefix'] = "Prefisso delle tabelle";
$GLOBALS['strTablesType'] = "Tipo di tabelle";

$GLOBALS['strRecoveryRequiredTitle'] = "Il tuo precedente tentativo di aggiornamento ha generato un errore";
$GLOBALS['strRecoveryRequired'] = "Durante il tuo precedente tentativo di aggiornamento è stato riscontrato un errore e {$PRODUCT_NAME} cercherà di recuperare il processo interrotto. Premi il pulsante Recupera.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} è aggiornato";
$GLOBALS['strOaUpToDate'] = "Il database e i file della tua installazione di {$PRODUCT_NAME} sono già aggiornati all'ultima versione e non è quindi al momento necessario procedere ad alcun aggiornamento. Premi Continua per raggiungere il pannello di amministrazione di OpenX.";
$GLOBALS['strOaUpToDateCantRemove'] = "Attenzione: il file UPGRADE è ancora presente all'interno della cartella 'var'. Non è possibile cancellare questo file automaticamente per mancanza dei permessi necessari. Si prega di rimuovere il file manualmente.";
$GLOBALS['strErrorWritePermissions'] = "E' stato riscontrato un errore nei permessi dei file che deve essere corretto prima procedere.<br />Per correggere l'errore su un sistema Linux, prova a digitare i seguenti comandi:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NON scrivibile";
$GLOBALS['strDirNotWriteableError'] = "La directory deve essere scrivibile";

$GLOBALS['strErrorWritePermissionsWin'] = "Sono stati rilevati errori nei permessi dei file, e devono essere corretti per procedere.";
$GLOBALS['strCheckDocumentation'] = "Per maggiori informazioni, consulta la <a href='{$PRODUCT_DOCSURL}'>documentazione di {$PRODUCT_NAME}</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "La tua configurazione PHP non soddisfa i requisiti di {$PRODUCT_NAME}. Per risolvere i problemi, modifica le impostazioni nel tuo file 'php.ini'.";

$GLOBALS['strAdminUrlPrefix'] = "URL dell'interfaccia di amministrazione";
$GLOBALS['strDeliveryUrlPrefix'] = "URL sistema di consegna";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL sistema di consegna (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL memorizzazione immagini";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL memorizzazione immagini (SSL)";


$GLOBALS['strUpgrade'] = "Aggiornamento";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Scegli sezione";
$GLOBALS['strEditConfigNotPossible'] = "Non è possibile modificare tutte le impostazioni perché il file di configurazione è bloccato per motivi di sicurezza.
    Se si desidera apportare modifiche, potrebbe essere necessario sbloccare prima il file di configurazione per questa installazione.";
$GLOBALS['strEditConfigPossible'] = "È possibile modificare tutte le impostazioni perché il file di configurazione non è bloccato, ma questo potrebbe portare a problemi di sicurezza.
    Se si desidera proteggere il sistema, è necessario bloccare il file di configurazione per questa installazione.";
$GLOBALS['strUnableToWriteConfig'] = "Impossibile salvare le modifiche nel file di configurazione";
$GLOBALS['strUnableToWritePrefs'] = "Impossibile salvare le preferenze nel database";
$GLOBALS['strImageDirLockedDetected'] = "IL server non può scrivere nella <b>Cartelle delle Immagini</b>. <br>Non è possibile procedere fino a che i permessi della cartella non sono cambiati o la cartelle non è stata creata.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Impostazioni di configurazione";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Amministratore  Nome utente";
$GLOBALS['strAdminPassword'] = "Amministratore  Password";
$GLOBALS['strInvalidUsername'] = "Nome utente non valido";
$GLOBALS['strBasicInformation'] = "Informazioni di base";
$GLOBALS['strAdministratorEmail'] = "Indirizzo email dell'Amministratore";
$GLOBALS['strAdminCheckUpdates'] = "Controlla aggiornamenti disponibili";
$GLOBALS['strAdminShareStack'] = "Condividi informazioni tecniche con il team di {$PRODUCT_NAME} per aiutarli nelle fasi di sviluppo e test.";
$GLOBALS['strNovice'] = "Per sicurezza, le cancellazioni richiedono la conferma";
$GLOBALS['strUserlogEmail'] = "Registra tutte le email in uscita";
$GLOBALS['strEnableDashboard'] = "Abilita dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Per favore abilita <a href='account-settings-update.php'>Controllo aggiornamenti</a> se vuoi usare la bacheca.";
$GLOBALS['strTimezone'] = "Fuso orario";
$GLOBALS['strEnableAutoMaintenance'] = "Esegue automaticamente la manutenzione durante la consegna se la manutenzione progeammata non è impostata.";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Impostazioni database";
$GLOBALS['strDatabaseServer'] = "Impostazioni Globali del Database Server";
$GLOBALS['strDbLocal'] = "Usa la connessione al socket locale";
$GLOBALS['strDbType'] = "Tipo di Database";
$GLOBALS['strDbHost'] = "Hostname del Database";
$GLOBALS['strDbSocket'] = "Socket del database";
$GLOBALS['strDbPort'] = "Numero Porta del Database";
$GLOBALS['strDbUser'] = "Nome Utente del Database";
$GLOBALS['strDbPassword'] = "Password del Database";
$GLOBALS['strDbName'] = "Nome del Database";
$GLOBALS['strDbNameHint'] = "La base dati sarà creata, se non esiste";
$GLOBALS['strDatabaseOptimalisations'] = "Ottimizzazioni Database";
$GLOBALS['strPersistentConnections'] = "Utilizza connessioni persistenti";
$GLOBALS['strCantConnectToDb'] = "Impossibile connettersi al database";
$GLOBALS['strCantConnectToDbDelivery'] = 'Impossibile connettersi al Database per la consegna';

// Email Settings
$GLOBALS['strEmailSettings'] = "Impostazioni Email";
$GLOBALS['strEmailAddresses'] = "Indirizzo del mittente";
$GLOBALS['strEmailFromName'] = "Nome del mittente";
$GLOBALS['strEmailFromAddress'] = "Indirizzo del mittente";
$GLOBALS['strEmailFromCompany'] = "Azienda del mittente";
$GLOBALS['strUseManagerDetails'] = 'Utilizzare il contatto dell\'account proprietario, l\'email e il nome invece del nome, indirizzo email e azienda sopra riportati quando si inviano messaggi di posta elettronica agli account dell\'inserzionista o del sito web.';
$GLOBALS['strQmailPatch'] = "Abilita patch per qmail";
$GLOBALS['strEnableQmailPatch'] = "Abilita patch qmail";
$GLOBALS['strEmailHeader'] = "Intestazione email";
$GLOBALS['strEmailLog'] = "Log email";

// Security settings
$GLOBALS['strSecurityAndDebug'] = "Impostazioni di sicurezza e debug";
$GLOBALS['strSecuritySettings'] = "Impostazioni di sicurezza";
$GLOBALS['strSecurityPasswordMinLength'] = "Lunghezza minima della password";
$GLOBALS['strSecurityBadLoginPath'] = "File di log per accessi errati";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Impostazioni Audit Trail";
$GLOBALS['strEnableAudit'] = "Abilita Audit Trail";
$GLOBALS['strEnableAuditForZoneLinking'] = "Abilita Audit Trail per lo schermo Zone Linking (introduce enormi penalità di prestazioni quando si collegano grandi quantità di zone)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Impostazioni Log di Debug";
$GLOBALS['strEnableDebug'] = "Abilita il log di debug";
$GLOBALS['strDebugMethodNames'] = "Includi il nome dei metodi nei log di debug";
$GLOBALS['strDebugLineNumbers'] = "Includi il numero di riga nei log di debug";
$GLOBALS['strDebugType'] = "Tipo di log di debug";
$GLOBALS['strDebugTypeFile'] = "File";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "Database SQL";
$GLOBALS['strDebugTypeSyslog'] = "Log si sistema";
$GLOBALS['strDebugName'] = "Nome del log di debug, Calendario, Tabella SQL<br /> o log di sistema";
$GLOBALS['strDebugPriority'] = "Livello di priorità debug";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Maggiori informazioni";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informazioni predefinite";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Meno informazioni";
$GLOBALS['strDebugIdent'] = "Stringa di indentificazione debug";
$GLOBALS['strDebugUsername'] = "mCal, Nome utente server SQL";
$GLOBALS['strDebugPassword'] = "mCal, password server SQL";
$GLOBALS['strProductionSystem'] = "Sistema di produzione";

// Delivery Settings
$GLOBALS['strWebPath'] = "Percorsi Di Accesso Server {$PRODUCT_NAME}";
$GLOBALS['strWebPathSimple'] = "Percorso Web";
$GLOBALS['strDeliveryPath'] = "Percorso di consegna";
$GLOBALS['strImagePath'] = "Percorso immagini";
$GLOBALS['strDeliverySslPath'] = "Percorso di consegna SSL";
$GLOBALS['strImageSslPath'] = "Percorso immagini SSL";
$GLOBALS['strImageStore'] = "Cartella delle immagini";
$GLOBALS['strTypeWebSettings'] = "Configurazione banner locali (Server web)";
$GLOBALS['strTypeWebMode'] = "Tipo di memorizzazione";
$GLOBALS['strTypeWebModeLocal'] = "Cartella locale";
$GLOBALS['strTypeDirError'] = "Impossibile accedere alla cartella locale";
$GLOBALS['strTypeWebModeFtp'] = "Modalità FTP (utilizza un server FTP esterno)";
$GLOBALS['strTypeWebDir'] = "Cartella locale";
$GLOBALS['strTypeFTPHost'] = "Hostname FTP";
$GLOBALS['strTypeFTPDirectory'] = "Directory remota";
$GLOBALS['strTypeFTPUsername'] = "Nome utente";
$GLOBALS['strTypeFTPPassword'] = "Password";
$GLOBALS['strTypeFTPPassive'] = "Usa connessione FTP passiva";
$GLOBALS['strTypeFTPErrorDir'] = "La directory remota non esiste";
$GLOBALS['strTypeFTPErrorConnect'] = "Impossibile connettersi al server FTP, nome utente o password non corretti";
$GLOBALS['strTypeFTPErrorNoSupport'] = "La tua installazione di php non supporta FTP";
$GLOBALS['strTypeFTPErrorUpload'] = "Impossibile caricare i files sul server FTP, controlla che siano impostati i privilegi corretti nella directory host";
$GLOBALS['strTypeFTPErrorHost'] = "L'hostname del server FTP non è corretto";
$GLOBALS['strDeliveryFilenames'] = "Nomi dei file di consegna";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Click Inserzione";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Clic Annuncio Firmato";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Variabili di Conversione Inserzioni";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Contenuto Inserzione";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Conversione Inserzione";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Conversione Inserzione (Javascript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Frame Inserzione";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Immagine Inserzione";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Inserzione (Javascript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Layer Inserzione";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Log Inserzione";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Popup Inserzione";
$GLOBALS['strDeliveryFilenamesAdView'] = "Vista Inserzione";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Invocazione XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Invocazione Locale";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Controllo Front";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Async JavaScript (file sorgente)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Async JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Async JavaScript Single Page Call";
$GLOBALS['strDeliveryCaching'] = "Impostazioni cache per la consegna dei banner";
$GLOBALS['strDeliveryCacheLimit'] = "Intervallo di tempo fra due aggiornamenti della cache (in secondi)";
$GLOBALS['strDeliveryCacheStore'] = "Tipo di cache per la consegna dei banner";
$GLOBALS['strDeliveryAcls'] = "Valuta le regole di consegna banner durante la consegna";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Valuta le regole di consegna banner per gli annunci selezionati direttamente";
$GLOBALS['strDeliveryObfuscate'] = "Regola di consegna offuscata impostata quando consegna annunci";
$GLOBALS['strDeliveryPreconnect'] = "Richiedi ai browser di pre-connettersi all'URL delle immagini (se diverso dall'URL di consegna, solo con HTTPS)";
$GLOBALS['strDeliveryClickUrlValidity'] = "Validità delle destinazioni personalizzate nelle macro {clickurl} (in secondi). Inserire 0 per disattivare la funzionalità.";
$GLOBALS['strDeliveryRelAttribute'] = "Attributo rel predefinito per i tag &lt;a href&gt; HTML";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Banner HTML predefinito globale per zone non esistenti";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Banner HTML predefinito globale per gli account sospesi";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Banner HTML predefinito globale per gli account inattivi";
$GLOBALS['strPrivacySettings'] = "Impostazioni Privacy";
$GLOBALS['strDisableViewerId'] = "Disabilita cookie Id visualizzatore univoco";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer indirizzi IP";
$GLOBALS['strDisableDeliveryCookies'] = 'Disattiva cookie durante la consegna banner';
$GLOBALS['strBannerFileSettings'] = 'Impostazioni generali dei banner';
$GLOBALS['strMaxBannerFilesize'] = 'Dimensione massima del file banner (in byte, 0 per dimensioni illimitate)';

// General Settings
$GLOBALS['generalSettings'] = "Impostazioni di sistema generale globale";
$GLOBALS['uiEnabled'] = "Interfaccia utente abilitata";
$GLOBALS['defaultLanguage'] = "Lingua di sistema predefinita<br />(Ogni utente può scegliere il linguaggio che preferisce)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Targeting geografico";
$GLOBALS['strGeotargeting'] = "Targeting geografico";
$GLOBALS['strGeotargetingType'] = "Tipo di Modulo Targeting Geografico";
$GLOBALS['strGeoShowUnavailable'] = "Mostra le regole di consegna geotargeting anche se i dati GeoIP non sono disponibili";

// Interface Settings
$GLOBALS['strInventory'] = "Inventario";
$GLOBALS['strShowCampaignInfo'] = "Mostra informazioni aggiuntive nella pagina <i>Campagna</i>";
$GLOBALS['strShowBannerInfo'] = "Mostra informazioni aggiuntive nella pagina <i>Banner</i>";
$GLOBALS['strShowCampaignPreview'] = "Mostra anteprima dei banner nella pagina <i>Banner</i>";
$GLOBALS['strShowBannerHTML'] = "Mostra il banner invece del codice HTML nell'anteprima dei banner HTML";
$GLOBALS['strShowBannerPreview'] = "Mostra anteprima nella parte superiore delle pagine relative ai banner";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Usa l'editor HTML WYSIWYG per impostazione predefinita quando crei o modifichi banner HTML";
$GLOBALS['strHideInactive'] = "Nascondi inattivi";
$GLOBALS['strGUIShowMatchingBanners'] = "Mostra banner corrispondenti nella pagina <i>Banner collegati</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Mostra campagne nella pagina <i>Banner collegati</i>";
$GLOBALS['strShowEntityId'] = "Mostra ID numerici delle entità";
$GLOBALS['strStatisticsDefaults'] = "Statistiche";
$GLOBALS['strBeginOfWeek'] = "Primo giorno della settimana";
$GLOBALS['strPercentageDecimals'] = "Numero decimali nelle percentuali";
$GLOBALS['strWeightDefaults'] = "Peso predefinito";
$GLOBALS['strDefaultBannerWeight'] = "Peso predefinito del banner";
$GLOBALS['strDefaultCampaignWeight'] = "Peso predefinito della campagna";
$GLOBALS['strConfirmationUI'] = "Conferma nell`interfaccia utente";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Impostazioni predefinite per l'invocazione";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Abilita in modo predefinito il tracciamento dei click di terze parti";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Impostazioni per la consegna dei Banner";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Impostazioni Log dei Banner";
$GLOBALS['strLogAdRequests'] = "Traccia una richiesta ogni volta che un banner viene richiesto";
$GLOBALS['strLogAdImpressions'] = "Traccia un'impressione ogni volta che un banner viene visto";
$GLOBALS['strLogAdClicks'] = "Traccia un click ogni vota che il banner viene cliccato";
$GLOBALS['strReverseLookup'] = "Cerca di determinare il nome di host del visitatore se non esplicito";
$GLOBALS['strProxyLookup'] = "Cerca di determinare l'indirizzo IP reale del visitatore se si connette tramite un proxy";
$GLOBALS['strPreventLogging'] = "Blocca impostazioni Log dei Banner";
$GLOBALS['strIgnoreHosts'] = "Non tracciare le statistiche di visualizzazione per gli IP e gli hostname specificati sotto";
$GLOBALS['strIgnoreUserAgents'] = "<strong>Non</strong> loggare le statistiche dai client con una qualsiasi delle seguenti stringhe nel campo user-agent (una per linea)";
$GLOBALS['strEnforceUserAgents'] = "Logga <strong>soltanto</strong> le statistiche dai client con una qualsiasi delle seguenti stringhe nel campo user-agent (una per linea)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Impostazioni di memorizzazione banner";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Utilizza priorità ottimizzate per eCPM per le campagne remnant";
$GLOBALS['strEnableContractECPM'] = "Utilizza priorità ottimizzate per eCPM per le campagne a contratto";
$GLOBALS['strEnableECPMfromRemnant'] = "(Se la funzionalità viene abilitata, tutte le campagne remnant verranno disabilitate e dovranno essere riabilitate manualmente)";
$GLOBALS['strEnableECPMfromECPM'] = "(Disabilitando questa funzione alcune delle tue campagne attive eCPM verranno disattivate, dovrai aggiornarle manualmente per riattivarle)";
$GLOBALS['strInactivatedCampaigns'] = "Lista delle campagne che sono state disattivate a causa del cambiamento delle preferenze:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Impostazioni di manutenzione";
$GLOBALS['strConversionTracking'] = "Impostazioni del monitoraggio conversioni";
$GLOBALS['strEnableConversionTracking'] = "Abilita il monitoraggio conversioni";
$GLOBALS['strBlockInactiveBanners'] = "Non contare le impressioni pubblicitarie, fare clic o reindirizzare l'utente all'URL di destinazione se il visualizzatore fa clic su un banner inattivo";
$GLOBALS['strBlockAdClicks'] = "Non conteggiare il click se il visitatore ha cliccato la stessa inserzione nella stessa zona entro il tempo specificato (in secondi)";
$GLOBALS['strMaintenanceOI'] = "Intervallo delle operazioni di manutenzione (in minuti)";
$GLOBALS['strPrioritySettings'] = "Impostazioni Priorità";
$GLOBALS['strPriorityInstantUpdate'] = "Aggiorna immediatamente le priorità a seguito di un cambiamento effettuato da interfaccia grafica";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Prova intenzionalmente a consegnare più del dovuto (over-delivery) le campagne a contratto";
$GLOBALS['strDefaultImpConvWindow'] = "Finestra Predefinita Di Conversione Ad Impressione (Secondi)";
$GLOBALS['strDefaultCliConvWindow'] = "Finestra Predefinita Di Conversione Ad Click (Secondi)";
$GLOBALS['strAdminEmailHeaders'] = "Aggiungi i seguenti header ad ogni e-mail inviata da {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Invia un avviso quando il numero di impressioni rimaste sono inferiori a";
$GLOBALS['strWarnLimitDays'] = "Invia un messaggio di avviso quando i giorni rimasti sono inferiori al numero specificato";
$GLOBALS['strWarnAdmin'] = "Invia un messaggio di avviso all'amministratore quando una campagna sta per scadere";
$GLOBALS['strWarnClient'] = "Invia un messaggio di avviso all'inserzionista quando una campagna sta per scadere";
$GLOBALS['strWarnAgency'] = "Invia un messaggio di avviso all'agenzia quando una campagna sta per scadere";

// UI Settings
$GLOBALS['strGuiSettings'] = "Configurazione interfaccia utente";
$GLOBALS['strGeneralSettings'] = "Impostazioni generali";
$GLOBALS['strAppName'] = "Intestazione programma";
$GLOBALS['strMyHeader'] = "File da includere come intestazione";
$GLOBALS['strMyFooter'] = "File da includere a pié di pagina";
$GLOBALS['strDefaultTrackerStatus'] = "Stato predefinito del tracker";
$GLOBALS['strDefaultTrackerType'] = "Tipo di tracker predefinito";
$GLOBALS['strSSLSettings'] = "Impostazioni SSL";
$GLOBALS['requireSSL'] = "Forza accesso SSL nell`interfaccia utente";
$GLOBALS['sslPort'] = "Porta SSL usata dal Web Server";
$GLOBALS['strDashboardSettings'] = "Impostazioni Dashboard";
$GLOBALS['strMyLogo'] = "Nome del file per logo personalizzato";
$GLOBALS['strGuiHeaderForegroundColor'] = "Colore in primo piano dell'intestazione";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Colore di sfondo dell'intestazione";
$GLOBALS['strGuiActiveTabColor'] = "Colore del tab attivo";
$GLOBALS['strGuiHeaderTextColor'] = "Colore del testo nell'intestazione";
$GLOBALS['strGuiSupportLink'] = "URL personalizzato per il link di Supporto in alto";
$GLOBALS['strAdminCookieDomain'] = "Dominio dei cookie dell'interfaccia utente";
$GLOBALS['strGuiLoaderDelay'] = "Visualizza l'animazione di caricamento quando la schermata successiva richiede più di X millisecondi per caricare (usa -1 per disabilitare)";
$GLOBALS['strGzipContentCompression'] = "Utilizza la compressione GZIP per i contenuti";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Piattaforma Hash Rigenera";
$GLOBALS['strNewPlatformHash'] = "La nuova piattaforma Hash è:";
$GLOBALS['strPlatformHashInsertingError'] = "Errore nell'inserimento della Piattaforma Hash nel database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Impostazioni del plugin";
$GLOBALS['strEnableNewPlugins'] = "Attiva i plugin appena installati";
$GLOBALS['strUseMergedFunctions'] = "Usa il file delle funzioni di consegna unito";
