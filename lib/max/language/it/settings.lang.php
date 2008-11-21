<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

// Installer translation strings
$GLOBALS['strInstall']						= "Installa";
$GLOBALS['strChooseInstallLanguage']		= "Scegli la lingua per la procedura di installazione";
$GLOBALS['strLanguageSelection']			= "Selezione lingua";
$GLOBALS['strDatabaseSettings']				= "Impostazioni database";
$GLOBALS['strAdminSettings']				= "Impostazioni amministratore";
$GLOBALS['strAdvancedSettings']				= "Impostazioni avanzate";
$GLOBALS['strOtherSettings']				= "Altre impostazioni";

$GLOBALS['strWarning']						= "Attenzione";
$GLOBALS['strFatalError']					= "Si è verificato un errore fatale";
$GLOBALS['strUpdateError']					= "Si è verificato un errore durante l'aggiornamento";
$GLOBALS['strUpdateDatabaseError']			= "Per motivi sconosciuti l'aggiornamento del database non è andato a buon fine. È consigliato cliccare su <b>Riprova</b> per tentare di correggere questi potenziali problemi. Se sei sicuro che questi errori non influiscano sul corretto funzionamento di ".$phpAds_productname." clicca su <b>Ignora errori</b> per continuare. Ignorare questi errori può causare seri problemi e non è consigliato!";
$GLOBALS['strAlreadyInstalled']				= $phpAds_productname." è già installato su questo sistema. Per modificare le impostazioni clicca <a href='settings-index.php'>qui</a>";
$GLOBALS['strCouldNotConnectToDB']			= "Impossibile connettersi al database, controlla i parametri specificati";
$GLOBALS['strCreateTableTestFailed']		= "L'utente specificato non ha i permessi necessari a creare o aggiornare la struttura del database, contatta l'amministratore di sistema.";
$GLOBALS['strUpdateTableTestFailed']		= "L'utente specificato non ha i permessi necessari ad aggiornare la struttura del database, contatta l'amministratore di sistema.";
$GLOBALS['strTablePrefixInvalid']			= "Il prefisso delle tabelle contiene caratteri non validi";
$GLOBALS['strTableInUse']					= "Il database specificato è già utilizzato da ".$phpAds_productname.", utilizza un diverso prefisso per le tabelle, o leggi il manuale le istruzioni sull'aggiornamento.";
$GLOBALS['strTableWrongType']				= "Il tipo di tabella selezionato non è disponibile in questa installazione di ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']				= "Prima di continuare, correggi questi potenziali problemi:";
$GLOBALS['strFixProblemsBefore']			= "Le seguenti cose devono essere corrette prima di installare ".$phpAds_productname.". Per qulunque dubbio su questi messaggi di errore, consultare la <i>Administrator guide</i>, presente nell'archivio scaricato.";
$GLOBALS['strFixProblemsAfter']				= "Se non sei in grado di risolvere i problemi elencati, ocntatta l'amministratore del sistema su cui stai installando ".$phpAds_productname.". L'amministratore del server potrebbe essere in grado di aiutarti.";
$GLOBALS['strIgnoreWarnings']				= "Ignora avvertimenti";
$GLOBALS['strWarningDBavailable']			= "La versione di PHP utilizzata non ha il supporto per connettersi a un database ".$phpAds_dbmsname.". È necessario abilitare l'estensione PHP ".$phpAds_dbmsname." prima di procedere.";
$GLOBALS['strWarningPHPversion']			= $phpAds_productname." richiede PHP 4.0 o più recente per funzionare correttamente. La versione attualmente utilizzata è {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "La variabile di configurazione del PHP register_globals deve essere abilitata.";
$GLOBALS['strWarningMagicQuotesGPC']		= "La variabile di configurazione del PHP magic_quotes_gpc deve essere abilitata.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "La variabile di configurazione del PHP magic_quotes_runtime deve essere disabilitata.";
$GLOBALS['strWarningFileUploads']			= "La variabile di configurazione del PHP file_uploads deve essere abilitata.";
$GLOBALS['strWarningTrackVars']				= "La variabile di configurazione del PHP track_vars deve essere abilitata.";
$GLOBALS['strWarningPREG']					= "La versione di PHP utilizzata non ha il supporto alle espressioni regolari PERL-compatibili. È necessario abilitare l'estensione PREG prima di procedere.";
$GLOBALS['strConfigLockedDetected']			= "Il file <b>config.inc.php</b> non può essere sovrascritto dal server. Non � possiblie procedere finché non vengono modificati i permessi sul file. Puoi leggere sul manuale di ".$phpAds_productname." come fare.";
$GLOBALS['strCantUpdateDB']					= "Non è possibile aggiornare il database. Se decidi di procedere, tutti i banner, le statistiche e i clienti saranno cancellati.";
$GLOBALS['strIgnoreErrors']					= "Ignora errori";
$GLOBALS['strRetryUpdate']					= "Riprova";
$GLOBALS['strTableNames']					= "Nomi delle tabelle";
$GLOBALS['strTablesPrefix']					= "Prefisso delle tabelle";
$GLOBALS['strTablesType']					= "Tipo di tabelle";

$GLOBALS['strInstallWelcome']				= "Benvenuto in ".$phpAds_productname;
$GLOBALS['strInstallMessage']				= "Prima di utilizzare ".$phpAds_productname." è necessario configurarlo e <br /> il database deve essere creato. Clicca su <b>Procedi</b> per continuare.";
$GLOBALS['strInstallSuccess']				= "Cliccando <em>continua</em> entrerai dentro il tuo ad server.	<p><strong>E dopo?</strong></p>	<div class='psub'>	<p><strong>Iscriviti per ricevere gli aggiornamenti sul prodotto</strong><br />	 <a href='". OX_PRODUCT_DOCSURL ."/wizard/join' target='_blank'>Iscriviti alla mailing list ". MAX_PRODUCT_NAME ."</a> per ricevere gli aggiornamenti sul prodotto, segnalazioni di sicurezza e annunci sui nuovi prodotti.	 </p>	 <p><strong>Crea la tua prima campagna pubblicitaria</strong><br />	 Usa la <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-firstcampaign' target='_blank'>guida rapida per pubblicare la prima campagna pubblicitaria</a>.	  </p></div>	<p><strong>Passi facoltativi dell'installazione</strong></p>	<div class='psub'>	 <p><strong>Blocca i tuoi file di configurazione</strong><br />	 Questo passo migliora notevolmente la sicurezza del tuo adserver, evitando che le impostazioni di configurazione vengano alterate. <a href='". OX_PRODUCT_DOCSURL ."/wizard/lock-config' target='_blank'>Per saperne di più</a>.	  </p>	 <p><b>Imposta la manutenzione programmata</b><br>	  La manutenzione programmata è consigliata per assicurare nel tempo la generazione dei report e le migliori performance del prodotto.  <a href='". OX_PRODUCT_DOCSURL ."/wizard/setup-cron' target='_blank'>Per saperne di più</a>	  </p>	 <p><b>Rivedi le tue configurazioni di sistema</b><br>	  Prima di iniziare ad usare ". MAX_PRODUCT_NAME ." ti consigliamo di rivedere le tue impostazioni del sistema nel pannello <em>Impostazioni</em>.	  </p>	</div>";
$GLOBALS['strUpdateSuccess']				= "<b>L'aggiornamento di ".$phpAds_productname." &egrave stato completato.</b><br /><br />Affinché ".$phpAds_productname." funzioni correttamente devi assicurarti\n                                        	   che lo script di manutenzione sia lanciato ogni ora. Puoi trovare informazioni maggiori sull'argomento nel manuale.\n                                        	   <br /><br />Clicca <b>Procedi</b> per andare alla pagina di configurazione e impostare\n                                        	   altri parametri. Ricordati di togliere i permessi al file config.inc.php quando hai finito, per evitare problemi di\n                                        	   sicurezza.";
$GLOBALS['strInstallNotSuccessful']			= "<b>L\'installazione di ". MAX_PRODUCT_NAME ." non ha avuto successo</b><br /><br />Alcune parti del processo di installazione non possono essere completate.\n                                       È possibile che questi problemi siano solo temporanei, in questo caso clicca <b>Procedi</b> per ritornare alla\n                                       prima fase dell\'installazione. Se vuoi saperne di più sul significato dell\'errore, e su come risolvere il problema,\n                                        consulta il manuale.";
$GLOBALS['strErrorOccured']					= "Si è verificato il seguente errore:";
$GLOBALS['strErrorInstallDatabase']			= "La struttura del database non pu� essere creata.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']			= "La configurazione (su file e/o database) non può essere aggiornata.";
$GLOBALS['strErrorInstallDbConnect']		= "Non è stato possibile connettersi al database.";

$GLOBALS['strUrlPrefix']					= "Prefisso URL";

$GLOBALS['strProceed']						= "Procedi >";
$GLOBALS['strInvalidUserPwd']				= "Username o password non validi";

$GLOBALS['strUpgrade']						= "Aggiornamento";
$GLOBALS['strSystemUpToDate']				= "Il sistema è aggiornato, al momento non sono necessari aggiornamenti. <br />Clicca <b>Procedi</b> per andare alla pagina principale.";
$GLOBALS['strSystemNeedsUpgrade']			= "La struttura del database e il file di configurazione devono essere aggiornati per funzionare correttamente. Clicca <b>Procedi</b> per iniziare il processo di aggiornamento. <br /><br />A seconda della versione da cui si fa l'aggiornamento e dalla quantità di statistiche presenti nel database, il processo potrebbe creare un elevato carico sul server di database. Sii paziente, il processo pu� durare anche alcuni minuti.";
$GLOBALS['strSystemUpgradeBusy']			= "Aggiornamento in corso, attendere prego...";
$GLOBALS['strSystemRebuildingCache']		= "Ricostruzione cache in corso, attendere prego...";
$GLOBALS['strServiceUnavalable']			= "Il servizio non è disponibile al momento. È in corso l'aggiornamento del sistema.";

$GLOBALS['strConfigNotWritable']			= "Il file config.inc.php non pu� essere sovrascritto";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']				= "Scegli la sezione";
$GLOBALS['strDayFullNames'][0] = "Domenica";
$GLOBALS['strDayFullNames'][1] = "Lunedì";
$GLOBALS['strDayFullNames'][2] = "Martedì";
$GLOBALS['strDayFullNames'][3] = "Mercoledì";
$GLOBALS['strDayFullNames'][4] = "Giovedì";
$GLOBALS['strDayFullNames'][5] = "Venerdì";
$GLOBALS['strDayFullNames'][6] = "Sabato";

$GLOBALS['strEditConfigNotPossible']		= "Non è possibile procedere alla modifica delle impostazioni dal momento che il file di configurazione è bloccato per ragioni di sicurezza. Se vuoi procedere alla modifica delle impostazioni, sblocca il file di configurazione.";
$GLOBALS['strEditConfigPossible']			= "E' possibile modificare tutte le impostazioni se il file di configurazione non è bloccato, ma questo potrebbe portare ad alcuni problemi di sicurezza. Per mettere in sicurezza il tuo sistema, blocca il file di configurazione per questa installazione.";



// Database
$GLOBALS['strDatabaseSettings']				= "Impostazioni database";
$GLOBALS['strDatabaseServer']				= "Impostazioni Globali del Database Server";
$GLOBALS['strDbLocal']						= "Usa la connessione al socket locale"; // Pg only
$GLOBALS['strDbHost']						= "Hostname del Database";
$GLOBALS['strDbPort']						= "Numero Porta del Database";
$GLOBALS['strDbUser']						= "Nome Utente del Database";
$GLOBALS['strDbPassword']					= "Password del Database";
$GLOBALS['strDbName']						= "Nome del Database";

$GLOBALS['strDatabaseOptimalisations']		= "Ottimizzazioni Database";
$GLOBALS['strPersistentConnections']		= "Utilizza connessioni persistenti";
$GLOBALS['strCompatibilityMode']			= "Attiva compatibilità con server MySQL 3.22";
$GLOBALS['strCantConnectToDb']				= "Impossibile connettersi al database";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Impostazioni di invocazione";

$GLOBALS['strAllowedInvocationTypes']		= "Tipi di invocazione consentiti";
$GLOBALS['strAllowRemoteInvocation']		= "Consenti invocazione remota";
$GLOBALS['strAllowRemoteJavascript']		= "Consenti invocazione remota con JavaScript";
$GLOBALS['strAllowRemoteFrames']			= "Consenti invocazione remota con Frame";
$GLOBALS['strAllowRemoteXMLRPC']			= "Consenti invocazione remota XML-RPC";
$GLOBALS['strAllowLocalmode']				= "Consenti modo locale";
$GLOBALS['strAllowInterstitial']			= "Consenti Interstiziali";
$GLOBALS['strAllowPopups']					= "Consenti Popup";

$GLOBALS['strUseAcl']						= "Valuta eventuali limitazioni di consegna al momento della fornitura";

$GLOBALS['strDeliverySettings']				= "Impostazioni di consegna";
$GLOBALS['strCacheType']					= "Tipo di cache per la consegna";
$GLOBALS['strCacheFiles']					= "File";
$GLOBALS['strCacheDatabase']				= "Database";
$GLOBALS['strCacheShmop']					= "Memoria condivisa/Shmop";
$GLOBALS['strCacheSysvshm']					= "Memoria condivisa/Sysvshm";
$GLOBALS['strExperimental']					= "Sperimentale";
$GLOBALS['strKeywordRetrieval']				= "Abilita l'uso di parole chiave";
$GLOBALS['strBannerRetrieval']				= "Metodo di scelta del banner";
$GLOBALS['strRetrieveRandom']				= "Casuale (default)";
$GLOBALS['strRetrieveNormalSeq']			= "Sequenziale normale";
$GLOBALS['strWeightSeq']					= "Sequenziale pesata";
$GLOBALS['strFullSeq']						= "Sequenziale completa";
$GLOBALS['strUseConditionalKeys']			= "Abilita operatori logici nella selezione diretta";
$GLOBALS['strUseMultipleKeys']				= "Abilita parole chiave multiple nella selezione diretta";

$GLOBALS['strZonesSettings']				= "Impostazione zone";
$GLOBALS['strZoneCache']					= "Memorizza zone nella cache (dovrebbe velocizzare il tutto se si usano le zone)";
$GLOBALS['strZoneCacheLimit']				= "Tempo di validità della cache (in secondi)";
$GLOBALS['strZoneCacheLimitErr']			= "Il tempo di validità deve essere un intero positivo";

$GLOBALS['strP3PSettings']					= "Impostazioni Privacy P3P";
$GLOBALS['strUseP3P']						= "Utilizza le policy P3P";
$GLOBALS['strP3PCompactPolicy']				= "Versione compatta della policy P3P";
$GLOBALS['strP3PPolicyLocation']			= "Indirizzo della policy P3P completa";



// Banner Settings
$GLOBALS['strBannerSettings']				= "Impostazioni Banner";

$GLOBALS['strAllowedBannerTypes']			= "Tipi di Banner Permessi";
$GLOBALS['strTypeSqlAllow']					= "Permetti Banner Locai SQL";
$GLOBALS['strTypeWebAllow']					= "Permetti Banner Locali Webserver";
$GLOBALS['strTypeUrlAllow']					= "Permetti Banner Esterni";
$GLOBALS['strTypeHtmlAllow']				= "Permetti Banner HTML";
$GLOBALS['strTypeTxtAllow']					= "Permetti Inserzioni di Testo";

$GLOBALS['strTypeWebSettings']				= "Configurazione banner locali (Server web)";
$GLOBALS['strTypeWebMode']					= "Tipo di memorizzazione";
$GLOBALS['strTypeWebModeLocal']				= "Cartella locale";
$GLOBALS['strTypeWebModeFtp']				= "Modalità FTP (utilizza un server FTP esterno)";
$GLOBALS['strTypeWebDir']					= "Cartella locale";
$GLOBALS['strTypeWebFtp']					= "Server FTP per la modalità FTP";
$GLOBALS['strTypeWebUrl']					= "URL pubblico della directory locale / server FTP";
$GLOBALS['strTypeWebSslUrl']			= "URL pubblico (SSL)";
$GLOBALS['strTypeFTPHost']					= "Hostname FTP";
$GLOBALS['strTypeFTPDirectory']				= "Directory remota";
$GLOBALS['strTypeFTPUsername']				= "Nome utente";
$GLOBALS['strTypeFTPPassword']				= "Password";
$GLOBALS['strTypeFTPErrorDir']				= "La directory remota non esiste";
$GLOBALS['strTypeFTPErrorConnect']			= "Impossibile connettersi al server FTP, nome utente o password non corretti";
$GLOBALS['strTypeFTPErrorHost']				= "L'hostname del server FTP non è corretto";
$GLOBALS['strTypeDirError']					= "Impossibile accedere alla cartella locale";

$GLOBALS['strDefaultBanners']				= "Banner predefiniti";
$GLOBALS['strDefaultBannerUrl']				= "URL dell'immagine predefinito";
$GLOBALS['strDefaultBannerTarget']			= "URL destinazione del banner di default";

$GLOBALS['strTypeHtmlSettings']				= "Opzioni Banner HTML";
$GLOBALS['strTypeHtmlAuto']					= "Modifica automaticamente banner HTML per assicurare la registrazione dei click";
$GLOBALS['strTypeHtmlPhp']					= "Permetti l`esecuzione di istruzioni PHP da banner HTML";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']					= "Informazioni sull'host e targeting geografico";

$GLOBALS['strRemoteHost']					= "Host remoto";
$GLOBALS['strReverseLookup']				= "Cerca di determinare il nome di host del visitatore se non esplicito";
$GLOBALS['strProxyLookup']					= "Cerca di determinare l'indirizzo IP reale del visitatore se si connette tramite un proxy";

$GLOBALS['strGeotargeting']					= "Targeting geografico";
$GLOBALS['strGeotrackingType']				= "Tipo di database per il targeting geografico";
$GLOBALS['strGeotrackingLocation'] 			= "Percorso del database targeting geografico";
$GLOBALS['strGeotrackingLocationError']		= "Il database per il targeting geografico non è stato trovato nel percorso specificato";
$GLOBALS['strGeoStoreCookie']				= "Memorizza risultato in un cookie per riutilizzarlo in seguito";



// Statistics Settings
$GLOBALS['strStatisticsSettings']			= "Impostazioni Statistiche e Manutenzione";

$GLOBALS['strStatisticsFormat']				= "Formato statistiche";
$GLOBALS['strCompactStats']					= "Formato statistiche";
$GLOBALS['strLogAdviews']					= "Registra una Visualizzazione ongi volta che viene consegnato un banner";
$GLOBALS['strLogAdclicks']					= "Registra un Click ongi volta che un visitatore clicca su un banner";
$GLOBALS['strLogSource']					= "Registra il parametro sorgente specificato durante l'invocazione";
$GLOBALS['strGeoLogStats']					= "Registra la nazionalità del visitatore nelle statistiche";
$GLOBALS['strLogHostnameOrIP']				= "Registra il nome di host o l'indirizzo IP del visitatore";
$GLOBALS['strLogIPOnly']					= "Registra solo l'indirizzo IP anche se è noto il nome di host";
$GLOBALS['strLogIP']						= "Registra l'indirizzo IP del visitatore";
$GLOBALS['strLogBeacon']					= "Utilizza una piccola immgine <i>beacon</i> per registrare le Visualizzazioni, per assicurarsi di registrare solo i banner effettivamente consegnati";

$GLOBALS['strPreventLogging']				= "Blocca impostazioni Log dei Banner";
$GLOBALS['strRemoteHosts']					= "Host remoti";
$GLOBALS['strIgnoreHosts']					= "Non tracciare le statistiche di visualizzazione per gli IP e gli hostname specificati sotto";
$GLOBALS['strBlockAdviews']					= "Non registrare una Visualizzazione se il visitatore ha già visto lo stesso banner entro il numero di secondi specificato";
$GLOBALS['strBlockAdclicks']				= "Non registrare un Click se il visitatore ha già cliccato sullo stesso banner entro il numero di secondi specificato";


$GLOBALS['strEmailWarnings']				= "Email di avviso";
$GLOBALS['strAdminEmailHeaders']			= "Aggiungi i seguenti header ad ogni e-mail inviata da ".$phpAds_productname;
$GLOBALS['strWarnLimit']					= "Invia un avviso quando il numero di impressioni rimaste sono inferiori a";
$GLOBALS['strWarnLimitErr']					= "Il limite di avviso deve essere un intero positivo";
$GLOBALS['strWarnAdmin']					= "Invia un messaggio di avviso all'amministratore quando una campagna sta per scadere";
$GLOBALS['strWarnClient']					= "Invia un messaggio di avviso all'inserzionista quando una campagna sta per scadere";
$GLOBALS['strQmailPatch']					= "Abilita patch per qmail";

$GLOBALS['strAutoCleanTables']				= "Pulizia del database";
$GLOBALS['strAutoCleanStats']				= "Pulisci statistiche";
$GLOBALS['strAutoCleanUserlog']				= "Pulisci registro eventi";
$GLOBALS['strAutoCleanStatsWeeks']			= "Età massima statistiche <br />(minimo 3 settimane)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Età massima registro eventi <br />(minimo 3 settimane)";
$GLOBALS['strAutoCleanErr']					= "L'età massima deve essere di almeno 3 settimane";
$GLOBALS['strAutoCleanVacuum']				= "Esegui VACUUM ANALYZE sulle tabelle ogni notte"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Impostazioni amministratore";

$GLOBALS['strLoginCredentials']				= "Credenziali di accesso";
$GLOBALS['strAdminUsername']				= "Amministratore  Nome utente";
$GLOBALS['strInvalidUsername']				= "Nome utente non valido";

$GLOBALS['strBasicInformation']				= "Informazioni di base";
$GLOBALS['strAdminFullName']				= "Nome completo dell'Amministratore";
$GLOBALS['strAdminEmail']					= "Indirizzo email dell'Amministratore";
$GLOBALS['strCompanyName']					= "Società";

$GLOBALS['strAdminCheckUpdates']			= "Controlla aggiornamenti disponibili";
$GLOBALS['strAdminCheckEveryLogin']			= "Ad ogni login";
$GLOBALS['strAdminCheckDaily']				= "Una volta al giorno";
$GLOBALS['strAdminCheckWeekly']				= "Una volta alla settimana";
$GLOBALS['strAdminCheckMonthly']			= "Una volta al mese";
$GLOBALS['strAdminCheckNever']				= "Non controllare";

$GLOBALS['strAdminNovice']					= "Le operazioni di eliminazione eseguite dal super utente necessitano di conferma, per sicurezza.";
$GLOBALS['strUserlogEmail']					= "Registra tutte le email in uscita";
$GLOBALS['strUserlogPriority']				= "Registra i calcoli eseguiti ogni ora nell'assegnamento delle priorità";
$GLOBALS['strUserlogAutoClean']				= "Registra la pulizia automatica del database";


// User interface settings
$GLOBALS['strGuiSettings']					= "Configurazione interfaccia utente";

$GLOBALS['strGeneralSettings']				= "Impostazioni generali";
$GLOBALS['strAppName']						= "Intestazione programma";
$GLOBALS['strMyHeader']						= "File da includere come intestazione";
$GLOBALS['strMyHeaderError']				= "Il file da includere come intestazione non è stato trovato nel percorso specificato";
$GLOBALS['strMyFooter']						= "File da includere a pié di pagina";
$GLOBALS['strMyFooterError']				= "Il file da includere a pié di pagina non è stato trovato nel percorso specificato";
$GLOBALS['strGzipContentCompression']		= "Utilizza la compressione GZIP per i contenuti";

$GLOBALS['strClientInterface']				= "Interfaccia inserzionista";
$GLOBALS['strClientWelcomeEnabled']			= "Attiva messaggio di benvenuto per l'inserzionista";
$GLOBALS['strClientWelcomeText']			= "Messaggio di benvenuto<br />(tag HTML consentite)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']			= "Impostazioni predefinite dell'interfaccia";

$GLOBALS['strInventory']					= "Inventario";
$GLOBALS['strShowCampaignInfo']				= "Mostra informazioni aggiuntive nella pagina <i>Campagna</i>";
$GLOBALS['strShowBannerInfo']				= "Mostra informazioni aggiuntive nella pagina <i>Banner</i>";
$GLOBALS['strShowCampaignPreview']			= "Mostra anteprima dei banner nella pagina <i>Banner</i>";
$GLOBALS['strShowBannerHTML']				= "Mostra il banner invece del codice HTML nell'anteprima dei banner HTML";
$GLOBALS['strShowBannerPreview']			= "Mostra anteprima nella parte superiore delle pagine relative ai banner";
$GLOBALS['strHideInactive']					= "Nascondi inattivi";
$GLOBALS['strGUIShowMatchingBanners']		= "Mostra banner corrispondenti nella pagina <i>Banner collegati</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Mostra campagne nella pagina <i>Banner collegati</i>";
$GLOBALS['strGUILinkCompactLimit']			= "Nascondi campagne o banner non collegati nella pagina <i>Banner collegati</i> quando ce ne sono più di";


$GLOBALS['strStatisticsDefaults']			= "Statistiche";
$GLOBALS['strBeginOfWeek']					= "Primo giorno della settimana";
$GLOBALS['strPercentageDecimals']			= "Numero decimali nelle percentuali";

$GLOBALS['strWeightDefaults']				= "Peso predefinito";
$GLOBALS['strDefaultBannerWeight']			= "Peso predefinito del banner";
$GLOBALS['strDefaultCampaignWeight']		= "Peso predefinito della campagna";
$GLOBALS['strDefaultBannerWErr']			= "Il peso di default dei banner deve essere un intero positivo";
$GLOBALS['strDefaultCampaignWErr']			= "Il peso di default delle campagne deve essere un intero positivo";



// Not used at the moment
$GLOBALS['strTableBorderColor']				= "Colore del bordo delle tabelle";
$GLOBALS['strTableBackColor']				= "Colore di sfondo delle tabelle";
$GLOBALS['strTableBackColorAlt']			= "Colore di sfondo delle tabelle (Alternativo)";
$GLOBALS['strMainBackColor']				= "Colore di sfondo delle pagine";
$GLOBALS['strOverrideGD']					= "Utilizza formato GD personalizzato";
$GLOBALS['strTimeZone']						= "Fuso orario";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strHasTaxID'] = "Tax ID";
$GLOBALS['strAdminAccount'] = "Account dell'amministratore";
$GLOBALS['strSpecifySyncSettings'] = "Sincronizzazione delle impostazioni";
$GLOBALS['strOpenadsIdYour'] = "Il tuo OpenX ID";
$GLOBALS['strOpenadsIdSettings'] = "Impostazioni OpenX ID";
$GLOBALS['strBtnContinue'] = "Continua »";
$GLOBALS['strBtnRecover'] = "Recupera »";
$GLOBALS['strBtnStartAgain'] = "Riavvia aggiornamento »";
$GLOBALS['strBtnGoBack'] = "« Torna Indietro";
$GLOBALS['strBtnAgree'] = "Acconsento »";
$GLOBALS['strBtnDontAgree'] = "« Non acconsento";
$GLOBALS['strBtnRetry'] = "Riprova";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Per favore correggi tutti gli errori prima di continuare.";
$GLOBALS['strWarningRegisterArgcArv'] = "La variabile di configurazione del PHP register_argc_argv deve essere attiva per eseguire la manutenzione da linea di comando.";
$GLOBALS['strInstallIntro'] = "Grazie per aver scelto <a href='http://". MAX_PRODUCT_URL ."' target='_blank'><strong>". MAX_PRODUCT_NAME ."</strong></a><p>Questa procedura guidata ti aiuterà durante il processo di installazione / aggiornamento dell'adserver ". MAX_PRODUCT_NAME .".</p><p>Per aiutarti con la procedura di installazione abbiamo creato una <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>Guida rapida all'installazione</a> per permetterti di avere una piattaforma funzionante. Per ottenere una guida più dettagliata sull'installazione e la configurazione di ". MAX_PRODUCT_NAME ." visita la <a href='". OX_PRODUCT_DOCSURL ."/wizard/admin-guide' target='_blank'>Guida per l'amministratore</a>.";
$GLOBALS['strRecoveryRequiredTitle'] = "Il tuo precedente tentativo di aggiornamento ha generato un errore";
$GLOBALS['strRecoveryRequired'] = "Durante il tuo precedente tentativo di aggiornamento è stato riscontrato un errore e ". MAX_PRODUCT_NAME ." cercherà di recuperare il processo interrotto. Premi il pulsante Recupera.";
$GLOBALS['strTermsTitle'] = "Termini, condizioni d'uso e informativa sulla privacy";
$GLOBALS['strTermsIntro'] = "". MAX_PRODUCT_NAME ." è software Open Source, inoltre viene distribuito liberamente tramite licenza Free Software: The GNU General Public License. Per favore leggi attentamente il testo della licenza: per proseguire l'installazione è necessario accettare e condividere le condizioni di licenza.";
$GLOBALS['strPolicyTitle'] = "Informativa sulla privacy";
$GLOBALS['strPolicyIntro'] = "Per continuare l'installazione, è necessario accettare e condividere il contenuto del seguente documento, per favore leggi attentamente.";
$GLOBALS['strDbSetupTitle'] = "Impostazioni database";
$GLOBALS['strDbSetupIntro'] = "Per favore inserisci le informazioni per effettuare il collegamento alla base dati. Se non ne sei al corrente, contatta il tuo amministratore di sistema. <p> Il prossimo passo sarà quello di allestimento della base dati. Clicca <em>continua</em> per procedere.</p>";
$GLOBALS['strDbUpgradeIntro'] = "Di seguito sono stati individuati i dati relativi alla tua base dati di ". MAX_PRODUCT_NAME .". Per favore controlla l'esattezza dei dati, il prossimo passo sarà quello per aggiornare la base dati. Clicca <em>continua</em> per aggiornare la tua installazione.</p>";
$GLOBALS['strOaUpToDate'] = "Il database e i file della tua installazione di ". MAX_PRODUCT_NAME ." sono già aggiornati all'ultima versione e non è quindi al momento necessario procedere ad alcun aggiornamento. Premi Continua per raggiungere il pannello di amministrazione di OpenX.";
$GLOBALS['strOaUpToDateCantRemove'] = "Attenzione: il file UPGRADE è ancora presente all'interno della cartella var. Non è possibile cancellare questo file automaticamente per mancanza dei permessi necessari. Si prega di rimuovere il file manualmente.";
$GLOBALS['strRemoveUpgradeFile'] = "Devi rimuovere il file UPGRADE dalla cartella var.";
$GLOBALS['strSystemCheck'] = "Controllo sistema";
$GLOBALS['strSystemCheckIntro'] = "La procedura di installazione sta controllando le impostazioni del web server per assicurare che il processo di installazione sia completato con successo.	<p>Per favore risolvi ogni problema che viene evidenziato.</p>";
$GLOBALS['strDbSuccessIntro'] = "Il database di ". MAX_PRODUCT_NAME ." è stato creato. Clicca su 'Continua' per procedere alla configurazione di Amministrazione e Consegna di ". MAX_PRODUCT_NAME .".";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Il tuo sistema è stato aggiornato con successo. Le rimanenti schermate ti aiuteranno per la configurazione del nuovo server ad.";
$GLOBALS['strErrorWritePermissions'] = "E' stato riscontrato un errore nei permessi dei file che deve essere corretto prima procedere.<br />Per correggere l'errore su un sistema Linux, prova a digitare i seguenti comandi:";
$GLOBALS['strErrorFixPermissionsCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin'] = "Sono stati rilevati errori nei permessi dei file, e devono essere corretti per procedere.";
$GLOBALS['strCheckDocumentation'] = "Per maggiori informazioni, consulta la <a href='". OX_PRODUCT_DOCSURL ."'>documentazione di ". MAX_PRODUCT_NAME ."<a/>.";
$GLOBALS['strAdminUrlPrefix'] = "URL dell'interfaccia di amministrazione";
$GLOBALS['strDeliveryUrlPrefix'] = "URL sistema di consegna";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL sistema di consegna (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL memorizzazione immagini";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL memorizzazione immagini (SSL)";
$GLOBALS['strUnableToWriteConfig'] = "Impossibile salvare le modifiche nel file di configurazione";
$GLOBALS['strUnableToWritePrefs'] = "Impossibile salvare le preferenze nel database";
$GLOBALS['strImageDirLockedDetected'] = "IL server non può scrivere nella <b>Cartelle delle Immagini</b>. <br>Non è possibile procedere fino a che i permessi della cartella non sono cambiati o la cartelle non è stata creata.";
$GLOBALS['strConfigurationSetup'] = "Lista di controllo della configurazione";
$GLOBALS['strConfigurationSettings'] = "Configurazione impostazioni";
$GLOBALS['strAdminPassword'] = "Amministratore  Password";
$GLOBALS['strAdministratorEmail'] = "Indirizzo email dell'Amministratore";
$GLOBALS['strTimezone'] = "Fuso orario";
$GLOBALS['strTimezoneEstimated'] = "Fuso orario stimato";
$GLOBALS['strTimezoneGuessedValue'] = "Il fuso orario del server non è impostato correttamente in PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Consultare la %DOCS% su come impostare questa variabile in PHP.";
$GLOBALS['strTimezoneDocumentation'] = "documentazione";
$GLOBALS['strLoginSettingsTitle'] = "Login Amministratore";
$GLOBALS['strLoginSettingsIntro'] = "Per procedere con l'aggiornamento, inserisci i dettagli dell'Amministratore del tuo ". MAX_PRODUCT_NAME .". E' necessario autenticarsi come Amministratore per procedere con l'upgrade.";
$GLOBALS['strAdminSettingsTitle'] = "Crea un account di amministrazione";
$GLOBALS['strAdminSettingsIntro'] = "Completa questa form per creare l'account di amministrazione del tuo server ad.";
$GLOBALS['strConfigSettingsIntro'] = "Per favore controlla le seguenti impostazioni di configurazione ed eventualmente apporta le modifiche necessarie. In caso di dubbio lascia tranquillamente i valori predefiniti.";
$GLOBALS['strEnableAutoMaintenance'] = "Esegue automaticamente la manutenzione durante la consegna se la manutenzione progeammata non è impostata.";
$GLOBALS['strOpenadsUsername'] = "". MAX_PRODUCT_NAME ." Nome utente";
$GLOBALS['strOpenadsPassword'] = "". MAX_PRODUCT_NAME ." Password";
$GLOBALS['strOpenadsEmail'] = "". MAX_PRODUCT_NAME ." Email";
$GLOBALS['strDbType'] = "Tipo di Database";
$GLOBALS['strDemoDataInstall'] = "Carica dati dimostrativi";
$GLOBALS['strDemoDataIntro'] = "È possibile caricare le impostazioni standard di ". MAX_PRODUCT_NAME ." per aiutarti ad iniziare subito a servire inserzioni on line. I tipi di banner più comuni e alcune campagne di esempio possono essere caricate e preconfigurate. È fortemente consigliato caricare le impostazioni standard per le nuove installazioni.";
$GLOBALS['strDebug'] = "Impostazioni Log di Debug";
$GLOBALS['strProduction'] = "Server di produzione";
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
$GLOBALS['strWebPath'] = "". MAX_PRODUCT_NAME ." Percorsi di accesso al Server'";
$GLOBALS['strWebPathSimple'] = "Percorso Web";
$GLOBALS['strDeliveryPath'] = "Percorso di consegna";
$GLOBALS['strImagePath'] = "Percorso immagini";
$GLOBALS['strDeliverySslPath'] = "Percorso di consegna SSL";
$GLOBALS['strImageSslPath'] = "Percorso immagini SSL";
$GLOBALS['strImageStore'] = "Cartella delle immagini";
$GLOBALS['strTypeFTPPassive'] = "Usa connessione FTP passiva";
$GLOBALS['strDeliveryFilenames'] = "Nomi dei file di consegna";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Click Inserzione";
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
$GLOBALS['strDeliveryFilenamesFlash'] = "Inclusione Flash (può essere un URL assoluto)";
$GLOBALS['strDeliveryCaching'] = "Impostazioni cache per la consegna dei Banner";
$GLOBALS['strDeliveryCacheLimit'] = "Intervallo di tempo fra due aggiornamenti della cache (in secondi)";
$GLOBALS['strOrigin'] = "Utilizza il server di origine remoto";
$GLOBALS['strOriginType'] = "Tipo server di origine";
$GLOBALS['strOriginHost'] = "Hostname del server di origine";
$GLOBALS['strOriginPort'] = "Numero di porta per il database di origine";
$GLOBALS['strOriginScript'] = "File di script per il database di origine";
$GLOBALS['strOriginTypeXMLRPC'] = "XMLRPC";
$GLOBALS['strOriginTimeout'] = "Timeout origine (in secondi)";
$GLOBALS['strOriginProtocol'] = "Protocollo del server di origine";
$GLOBALS['strDeliveryAcls'] = "Valuta le limitazioni nella consegna dei banner durante la consegna";
$GLOBALS['strDeliveryObfuscate'] = "Offusca il canale durante la consegna delle inserzioni";
$GLOBALS['strDeliveryExecPhp'] = "Permetti di eseguire codice PHP all'interno delle inserzioni<br />(Attenzione: Potrebbe introdurre rischi di sicurezza)";
$GLOBALS['strDeliveryCtDelimiter'] = "Delimitatore tracciamento click di terze parti";
$GLOBALS['uiEnabled'] = "Interfaccia utente abilitata";
$GLOBALS['strGeotargetingSettings'] = "Targeting geografico";
$GLOBALS['strGeotargetingType'] = "Tipo di Modulo Targeting Geografico";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Posizione del database MaxMind GeoIP Country";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Posizione del database MaxMind GeoIP Region Database";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Posizione del database MaxMind GeoIP City";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Posizione del database MaxMind GeoIP Area";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Posizione del database MaxMind GeoIP DMA";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Posizione del database MaxMind GeoIP Organisation";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Posizione del database MaxMind GeoIP ISP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Posizione del database MaxMind GeoIP Netspeed";
$GLOBALS['strGeoSaveStats'] = "Scrivi i dati GeoIP nel log del database";
$GLOBALS['strGeoShowUnavailable'] = "Mostra le limitazioni sulla consegna geotargetizzata anche se le informazioni GeoIP non sono presenti";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "Il database MaxMind GeoIP Country non esiste nella posizione specificata";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "Il database MaxMind GeoIP Region Database non esiste nella posizione specificata";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "Il database MaxMind GeoIP City non esiste nella posizione specificata";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "Il database MaxMind GeoIP Area non esiste nella posizione specificata";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "Il database MaxMind GeoIP DMA non esiste nella posizione specificata";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "Il database MaxMind GeoIP Organisation non esiste nella posizione specificata";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "Il database MaxMind GeoIP ISP non esiste nella posizione specificata";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "Il database MaxMind GeoIP Netspeed non esiste nella posizione specificata";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Assegna in modo predefinito le campagne a Anonymous";
$GLOBALS['strPublisherDefaults'] = "Impostazioni predefinite del sito internet";
$GLOBALS['strModesOfPayment'] = "Modalità di pagamento";
$GLOBALS['strCurrencies'] = "Valute";
$GLOBALS['strCategories'] = "Categorie";
$GLOBALS['strHelpFiles'] = "File di aiuto";
$GLOBALS['strDefaultApproved'] = "Check box di approvazione";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Abilita in modo predefinito il tracciamento dei click di terze parti";
$GLOBALS['strCsvImport'] = "Permetti il caricamento di conversioni off line";
$GLOBALS['strLogAdRequests'] = "Traccia una richiesta ogni volta che un banner viene richiesto";
$GLOBALS['strLogAdImpressions'] = "Traccia un'impressione ogni volta che un banner viene visto";
$GLOBALS['strLogAdClicks'] = "Traccia un click ogni vota che il banner viene cliccato";
$GLOBALS['strLogTrackerImpressions'] = "Traccia una impressione del tracker ogni volta che il tracker viene visualizzato";
$GLOBALS['strBlockAdViews'] = "Non conteggiare l'impressione se il visitatore ha visto la stessa inserzione nella stessa zona entro il tempo specificato (in secondi)";
$GLOBALS['strBlockAdViewsError'] = "Il valore dei blocchi di impressioni deve essere un intero non negativo";
$GLOBALS['strBlockAdClicks'] = "Non conteggiare il click se il visitatore ha cliccato la stessa inserzione nella stessa zona entro il tempo specificato (in secondi)";
$GLOBALS['strBlockAdClicksError'] = "Il valore dei blocchi di click deve essere un intero non negativo";
$GLOBALS['strMaintenanceOI'] = "Intervallo delle operazioni di manutenzione (in minuti)";
$GLOBALS['strMaintenanceOIError'] = "L'intervallo delle operazioni non è valido - consulta la documentazione per conoscere i valori validi";
$GLOBALS['strPrioritySettings'] = "Impostazioni Priorità";
$GLOBALS['strPriorityInstantUpdate'] = "Aggiorna immediatamente le priorità a seguito di un cambiamento effettuato da interfaccia grafica";
$GLOBALS['strDefaultImpConWindow'] = "Finestra di connessione Ad Impression predefinita (secondi)";
$GLOBALS['strDefaultImpConWindowError'] = "Se impostato, il valore predefinito della Finestra di connessione Ad Impression deve essere un intero positivo";
$GLOBALS['strDefaultCliConWindow'] = "Valore predefinito della Finestra di connessione Ad Click (in secondi)";
$GLOBALS['strDefaultCliConWindowError'] = "Se impostato, il valore predefinito della Finestra di connessione Ad Click deve essere un intero positivo";
$GLOBALS['strWarnLimitDays'] = "Invia un messaggio di avviso quando i giorni rimasti sono inferiori al numero specificato";
$GLOBALS['strWarnLimitDaysErr'] = "Il numero di giorni deve essere un intero positivo";
$GLOBALS['strWarnAgency'] = "Invia un messaggio di avviso all'agenzia quando una campagna sta per scadere";
$GLOBALS['strEnableQmailPatch'] = "Abilita patch qmail";
$GLOBALS['strDefaultTrackerStatus'] = "Stato predefinito del tracker";
$GLOBALS['strDefaultTrackerType'] = "Tipo di tracker predefinito";
$GLOBALS['strMyLogo'] = "Nome del file per logo personalizzato";
$GLOBALS['strMyLogoError'] = "Il file per il logo non esiste nella cartella admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Colore in primo piano dell'intestazione";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Colore di sfondo dell'intestazione";
$GLOBALS['strGuiActiveTabColor'] = "Colore del tab attivo";
$GLOBALS['strGuiHeaderTextColor'] = "Colore del testo nell'intestazione";
$GLOBALS['strColorError'] = "Inserisci i colori in un formato RGB, come '0066CC'";
$GLOBALS['strReportsInterface'] = "Interfaccia dei Report";
$GLOBALS['strPublisherInterface'] = "Interfaccia sito";
$GLOBALS['strPublisherAgreementEnabled'] = "Abilita il controllo del login per i siti che non hanno accettato i termini e le condizioni d'uso";
$GLOBALS['strPublisherAgreementText'] = "Testo per il login (tag HTML consentiti)";
$GLOBALS['strNovice'] = "Per sicurezza, le cancellazioni richiedono la conferma";
$GLOBALS['strEmailSettings'] = "Impostazioni Email";
$GLOBALS['strEmailHeader'] = "Intestazione email";
$GLOBALS['strEmailLog'] = "Log email";
$GLOBALS['strAuditTrailSettings'] = "Impostazioni Audit Trail";
$GLOBALS['strEnableAudit'] = "Abilita Audit Trail";
$GLOBALS['strTypeFTPErrorNoSupport'] = "La tua installazione di php non supporta FTP";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Utilizza il database MaxMind GeoLiteCountry incluso";
$GLOBALS['strConfirmationUI'] = "Conferma nell`interfaccia utente";
$GLOBALS['strBannerStorage'] = "Impostazioni di memorizzazione banner";
$GLOBALS['strMaintenanceSettings'] = "Impostazioni di manutenzione";
$GLOBALS['strSSLSettings'] = "Impostazioni SSL";
$GLOBALS['requireSSL'] = "Forza accesso SSL nell`interfaccia utente";
$GLOBALS['sslPort'] = "Porta SSL usata dal Web Server";
$GLOBALS['strAlreadyInstalled'] = "". MAX_PRODUCT_NAME ." è già installato nel sistema. Se vuoi configurarlo vai nell`<a href='account-index.php'>interfaccia impostazioni</a>.";
$GLOBALS['strAllowEmail'] = "Permettere l`invio globale di email";
$GLOBALS['strEmailAddressFrom'] = "Indirizzo di posta elettronica da utilizzare come mittente per i report";
$GLOBALS['strEmailAddressName'] = "Nome di persona o della compagnia da utilizzare come firma in calce all'email";
$GLOBALS['strInvocationDefaults'] = "Impostazioni predefinite per l'invocazione";
$GLOBALS['strDbSocket'] = "Socket del database";
$GLOBALS['strEmailAddresses'] = "Indirizzo del mittente";
$GLOBALS['strEmailFromName'] = "Nome del mittente";
$GLOBALS['strEmailFromAddress'] = "Indirizzo del mittente";
$GLOBALS['strEmailFromCompany'] = "Azienda del mittente";
$GLOBALS['strIgnoreUserAgents'] = "<strong>Non</strong> loggare le statistiche dai client con una qualsiasi delle seguenti stringhe nel campo user-agent (una per linea)";
$GLOBALS['strEnforceUserAgents'] = "Logga <strong>soltanto</strong> le statistiche dai client con una qualsiasi delle seguenti stringhe nel campo user-agent (una per linea)";
$GLOBALS['strConversionTracking'] = "Impostazioni del monitoraggio conversioni";
$GLOBALS['strEnableConversionTracking'] = "Abilita il monitoraggio conversioni";
$GLOBALS['strDbNameHint'] = "La base dati sarà creata, se non esiste";
$GLOBALS['strProductionSystem'] = "Sistema di produzione";
$GLOBALS['strTypeFTPErrorUpload'] = "Impossibile caricare i files sul server FTP, controlla che siano impostati i privilegi corretti nella directory host";
$GLOBALS['strBannerLogging'] = "Impostazioni Log dei Banner";
$GLOBALS['strBannerDelivery'] = "Impostazioni per la consegna dei Banner";
$GLOBALS['strEnableDashboardSyncNotice'] = "Per favore abilita <a href='account-settings-update.php'>Controllo aggiornamenti</a> se vuoi usare la bacheca.";
$GLOBALS['strDashboardSettings'] = "Impostazioni Bacheca";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strGlobalDefaultBannerUrl'] = "URL dell'immagine banner predefinito globale";
$GLOBALS['strDefaultConversionStatus'] = "Regole di conversione predefinite";
$GLOBALS['strDefaultConversionType'] = "Regole di conversione predefinite";
?>