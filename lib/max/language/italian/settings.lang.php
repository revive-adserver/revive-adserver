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
$GLOBALS['strInstall']						= "Installazione";
$GLOBALS['strChooseInstallLanguage']		= "Scegli la lingua per la procedura di installazione";
$GLOBALS['strLanguageSelection']			= "Selezione lingua";
$GLOBALS['strDatabaseSettings']				= "Impostazioni database";
$GLOBALS['strAdminSettings']				= "Impostazioni amministratore";
$GLOBALS['strAdvancedSettings']				= "Impostazioni avanzate";
$GLOBALS['strOtherSettings']				= "Altre impostazioni";

$GLOBALS['strWarning']						= "Attenzione";
$GLOBALS['strFatalError']					= "Si &egrave; verificato un errore fatale";
$GLOBALS['strUpdateError']					= "Si &egrave; verificato un errore durante l'aggiornamento";
$GLOBALS['strUpdateDatabaseError']			= "Per motivi sconosciuti l'aggiornamento del database non &egrave; andato a buon fine. &Egrave; consigliato cliccare su <b>Riprova</b> per tentare di correggere questi potenziali problemi. Se sei sicuro che questi errori non influiscano sul corretto funzionamento di ".$phpAds_productname." clicca su <b>Ignora errori</b> per continuare. Ignorare questi errori pu&ograve; causare seri problemi e non &egrave; consigliato!";
$GLOBALS['strAlreadyInstalled']				= $phpAds_productname." &egrave; gi&agrave; installato su questo sistema. Per modificare le impostazioni clicca <a href='settings-index.php'>qui</a>";
$GLOBALS['strCouldNotConnectToDB']			= "Impossibile connettersi al database, controlla i parametri specificati";
$GLOBALS['strCreateTableTestFailed']		= "L'utente specificato non ha i permessi necessari a creare o aggiornare la struttura del database, contatta l'amministratore di sistema.";
$GLOBALS['strUpdateTableTestFailed']		= "L'utente specificato non ha i permessi necessari ad aggiornare la struttura del database, contatta l'amministratore di sistema.";
$GLOBALS['strTablePrefixInvalid']			= "Il prefisso delle tabelle contiene caratteri non validi";
$GLOBALS['strTableInUse']					= "Il database specificato &egrave; gi&agrave; utilizzato da ".$phpAds_productname.", utilizza un diverso prefisso per le tabelle, o leggi il manuale le istruzioni sull'aggiornamento.";
$GLOBALS['strTableWrongType']				= "Il tipo di tabella selezionato non &egrave; disponibile in questa installazione di ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']				= "Prima di continuare, correggi questi potenziali problemi:";
$GLOBALS['strFixProblemsBefore']			= "Le seguenti cose devono essere corrette prima di installare ".$phpAds_productname.". Per qulunque dubbio su questi messaggi di errore, consultare la <i>Administrator guide</i>, presente nell'archivio scaricato.";
$GLOBALS['strFixProblemsAfter']				= "Se non sei in grado di risolvere i problemi elencati, ocntatta l'amministratore del sistema su cui stai installando ".$phpAds_productname.". L'amministratore del server potrebbe essere in grado di aiutarti.";
$GLOBALS['strIgnoreWarnings']				= "Ignora avvertimenti";
$GLOBALS['strWarningDBavailable']			= "La versione di PHP utilizzata non ha il supporto per connettersi a un database ".$phpAds_dbmsname.". &Egrave; necessario abilitare l'estensione PHP ".$phpAds_dbmsname." prima di procedere.";
$GLOBALS['strWarningPHPversion']			= $phpAds_productname." richiede PHP 4.0 o pi&ugrave; recente per funzionare correttamente. La versione attualmente utilizzata &egrave; {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "La variabile di configurazione del PHP register_globals deve essere abilitata.";
$GLOBALS['strWarningMagicQuotesGPC']		= "La variabile di configurazione del PHP magic_quotes_gpc deve essere abilitata.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "La variabile di configurazione del PHP magic_quotes_runtime deve essere disabilitata.";
$GLOBALS['strWarningFileUploads']			= "La variabile di configurazione del PHP file_uploads deve essere abilitata.";
$GLOBALS['strWarningTrackVars']				= "La variabile di configurazione del PHP track_vars deve essere abilitata.";
$GLOBALS['strWarningPREG']					= "La versione di PHP utilizzata non ha il supporto alle espressioni regolari PERL-compatibili. &Egrave; necessario abilitare l'estensione PREG prima di procedere.";
$GLOBALS['strConfigLockedDetected']			= "Il file <b>config.inc.php</b> non pu&ograve; essere sovrascritto dal server. Non � possiblie procedere finch&eacute; non vengono modificati i permessi sul file. Puoi leggere sul manuale di ".$phpAds_productname." come fare.";
$GLOBALS['strCantUpdateDB']					= "Non &egrave; possibile aggiornare il database. Se decidi di procedere, tutti i banner, le statistiche e i clienti saranno cancellati.";
$GLOBALS['strIgnoreErrors']					= "Ignora errori";
$GLOBALS['strRetryUpdate']					= "Riprova";
$GLOBALS['strTableNames']					= "Nomi delle tabelle";
$GLOBALS['strTablesPrefix']					= "Prefisso delle tabelle";
$GLOBALS['strTablesType']					= "Tipo di tabelle";

$GLOBALS['strInstallWelcome']				= "Benvenuto in ".$phpAds_productname;
$GLOBALS['strInstallMessage']				= "Prima di utilizzare ".$phpAds_productname." &egrave; necessario configurarlo e <br /> il database deve essere creato. Clicca su <b>Procedi</b> per continuare.";
$GLOBALS['strInstallSuccess']				= "<b>L'istallazione di ".$phpAds_productname." &egrave stata completata.</b><br /><br />Affinch&eacute; ".$phpAds_productname." funzioni correttamente devi assicurarti
                                        	   che lo script di manutenzione sia lanciato ogni ora. Puoi trovare informazioni maggiori sull'argomento nel manuale.
                                        	   <br /><br />Clicca <b>Procedi</b> per andare alla pagina di configurazione e impostare
                                        	   altri parametri. Ricordati di togliere i permessi al file config.inc.php quando hai finito, per evitare problemi di
                                        	   sicurezza.";
$GLOBALS['strUpdateSuccess']				= "<b>L'aggiornamento di ".$phpAds_productname." &egrave stato completato.</b><br /><br />Affinch&eacute; ".$phpAds_productname." funzioni correttamente devi assicurarti
                                        	   che lo script di manutenzione sia lanciato ogni ora. Puoi trovare informazioni maggiori sull'argomento nel manuale.
                                        	   <br /><br />Clicca <b>Procedi</b> per andare alla pagina di configurazione e impostare
                                        	   altri parametri. Ricordati di togliere i permessi al file config.inc.php quando hai finito, per evitare problemi di
                                        	   sicurezza.";
$GLOBALS['strInstallNotSuccessful']			= "<b>L'installazione di ".$phpAds_productname." non ha avuto successo</b><br /><br />Alcune parti del processo di installazione non possono essere completate.
                                        	   &Egrave; possibile che questi problemi siano solo temporanei, in questo caso clicca <b>Procedi</b> per ritornare alla
                                        	   prima fase dell'installazione. Se vuoi saperne di pi� sul significato dell'errore, e su come risolvere il problema,
                                        	   consulta il manuale di ".$phpAds_productname.".";
$GLOBALS['strErrorOccured']					= "Si &egrave; verificato il seguente errore:";
$GLOBALS['strErrorInstallDatabase']			= "La struttura del database non pu� essere creata.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']			= "La configurazione (su file e/o database) non pu&ograve; essere aggiornata.";
$GLOBALS['strErrorInstallDbConnect']		= "Non &egrave; stato possibile connettersi al database.";

$GLOBALS['strUrlPrefix']					= "Prefisso URL";

$GLOBALS['strProceed']						= "Procedi &gt;";
$GLOBALS['strInvalidUserPwd']				= "Username o password non validi";

$GLOBALS['strUpgrade']						= "Aggiornamento";
$GLOBALS['strSystemUpToDate']				= "Il sistema &egrave; aggiornato, al momento non sono necessari aggiornamenti. <br />Clicca <b>Procedi</b> per andare alla pagina principale.";
$GLOBALS['strSystemNeedsUpgrade']			= "La struttura del database e il file di configurazione devono essere aggiornati per funzionare correttamente. Clicca <b>Procedi</b> per iniziare il processo di aggiornamento. <br /><br />A seconda della versione da cui si fa l'aggiornamento e dalla quantit&agrave; di statistiche presenti nel database, il processo potrebbe creare un elevato carico sul server di database. Sii paziente, il processo pu� durare anche alcuni minuti.";
$GLOBALS['strSystemUpgradeBusy']			= "Aggiornamento in corso, attendere prego...";
$GLOBALS['strSystemRebuildingCache']		= "Ricostruzione cache in corso, attendere prego...";
$GLOBALS['strServiceUnavalable']			= "Il servizio non &egrave; disponibile al momento. &Egrave; in corso l'aggiornamento del sistema.";

$GLOBALS['strConfigNotWritable']			= "Il file config.inc.php non pu� essere sovrascritto";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']				= "Scegli la sezione";
$GLOBALS['strDayFullNames']					= array("Domenica","Luned&igrave;","Martedi&igrave;","Mercoled&igrave;","Gioved&igrave;","Venerd&igrave;","Sabato");
$GLOBALS['strEditConfigNotPossible']		= "Non risulta possibile modificare queste ipostazioni a causa del file config.inc.php protetto da scrittura per aumentare la sicurezza. ".
                                        	  "Se vuoi effettuare cambiamenti devi prima sbloccare il file config.inc.php.";
$GLOBALS['strEditConfigPossible']			= "Puoi modificare tutte le impostazioni dato che il file config.inc.php risulta non protetto da scrittura, tuttavia consigliamo di proteggerlo per evitare rischi di sicurezza. ".
                                        	  "Se vuoi rendere maggiormente sicuro il tuo sistema, dovresti proteggere il file.";



// Database
$GLOBALS['strDatabaseSettings']				= "Impostazioni database";
$GLOBALS['strDatabaseServer']				= "Database server";
$GLOBALS['strDbLocal']						= "Connetti al server locale tramite socket"; // Pg only
$GLOBALS['strDbHost']						= "Hostname database";
$GLOBALS['strDbPort']						= "Numero porta database";
$GLOBALS['strDbUser']						= "Username database";
$GLOBALS['strDbPassword']					= "Password database";
$GLOBALS['strDbName']						= "Nome database";

$GLOBALS['strDatabaseOptimalisations']		= "Ottimizzazioni database";
$GLOBALS['strPersistentConnections']		= "Utilizza connessioni persistenti";
$GLOBALS['strCompatibilityMode']			= "Attiva compatibilit&agrave; con server MySQL 3.22";
$GLOBALS['strCantConnectToDb']				= "Impossibile connettersi al database";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Impostazioni di invocazione e fornitura banner";

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
$GLOBALS['strZoneCacheLimit']				= "Tempo di validit&agrave; della cache (in secondi)";
$GLOBALS['strZoneCacheLimitErr']			= "Il tempo di validit&agrave; deve essere un intero positivo";

$GLOBALS['strP3PSettings']					= "Impostazioni P3P";
$GLOBALS['strUseP3P']						= "Utilizza le policy P3P";
$GLOBALS['strP3PCompactPolicy']				= "Versione compatta della policy P3P";
$GLOBALS['strP3PPolicyLocation']			= "Indirizzo della policy P3P completa";



// Banner Settings
$GLOBALS['strBannerSettings']				= "Impostazioni banner";

$GLOBALS['strAllowedBannerTypes']			= "Tipi di banner consentiti";
$GLOBALS['strTypeSqlAllow']					= "Consenti banner locali (SQL)";
$GLOBALS['strTypeWebAllow']					= "Consenti banner locali (Server web)";
$GLOBALS['strTypeUrlAllow']					= "Consenti banner esterni";
$GLOBALS['strTypeHtmlAllow']				= "Consenti banner HTML";
$GLOBALS['strTypeTxtAllow']					= "Consenti banner testuali";

$GLOBALS['strTypeWebSettings']				= "Configurazione banner locali (Server web)";
$GLOBALS['strTypeWebMode']					= "Tipo di memorizzazione";
$GLOBALS['strTypeWebModeLocal']				= "Modalit&agrave; locale (utilizza una directory locale)";
$GLOBALS['strTypeWebModeFtp']				= "Modalit&agrave; FTP (utilizza un server FTP esterno)";
$GLOBALS['strTypeWebDir']					= "Directory per la modalit&agrave; locale";
$GLOBALS['strTypeWebFtp']					= "Server FTP per la modalit&agrave; FTP";
$GLOBALS['strTypeWebUrl']					= "URL pubblico della directory locale / server FTP";
$GLOBALS['strTypeWebSslUrl']			= "URL pubblico (SSL)";
$GLOBALS['strTypeFTPHost']					= "Hostname FTP";
$GLOBALS['strTypeFTPDirectory']				= "Directory remota";
$GLOBALS['strTypeFTPUsername']				= "Login";
$GLOBALS['strTypeFTPPassword']				= "Password";
$GLOBALS['strTypeFTPErrorDir']				= "La directory remota non esiste";
$GLOBALS['strTypeFTPErrorConnect']			= "Impossibile connettersi al server FTP, Il login o la password non sono corretti";
$GLOBALS['strTypeFTPErrorHost']				= "L'hostname del server FTP non &egrave; corretto";
$GLOBALS['strTypeDirError']					= "La directory locale non esiste";

$GLOBALS['strDefaultBanners']				= "Banner di default";
$GLOBALS['strDefaultBannerUrl']				= "URL del banner di default";
$GLOBALS['strDefaultBannerTarget']			= "URL destinazione del banner di default";

$GLOBALS['strTypeHtmlSettings']				= "Configurazione banner HTML";
$GLOBALS['strTypeHtmlAuto']					= "Modifica automaticamente i banner HTML per poter registrare i click";
$GLOBALS['strTypeHtmlPhp']					= "Consenti l'esecuzione di espressioni PHP all'interno dei banner HTML";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']					= "Informazioni sull'host e targeting geografico";

$GLOBALS['strRemoteHost']					= "Host remoto";
$GLOBALS['strReverseLookup']				= "Cerca di determinare il nome di host del visitatore se non &egrave; fornito dal server web";
$GLOBALS['strProxyLookup']					= "Cerca di determinare l'indirizzo IP reale del visitatore se si connette tramite un proxy";

$GLOBALS['strGeotargeting']					= "Targeting geografico";
$GLOBALS['strGeotrackingType']				= "Tipo di database per il targeting geografico";
$GLOBALS['strGeotrackingLocation'] 			= "Percorso del database targeting geografico";
$GLOBALS['strGeotrackingLocationError']		= "Il database per il targeting geografico non &egrave; stato trovato nel percorso specificato";
$GLOBALS['strGeoStoreCookie']				= "Memorizza risultato in un cookie per riutilizzarlo in seguito";



// Statistics Settings
$GLOBALS['strStatisticsSettings']			= "Impostazioni statistiche";

$GLOBALS['strStatisticsFormat']				= "Formato statistiche";
$GLOBALS['strCompactStats']					= "Formato statistiche";
$GLOBALS['strLogAdviews']					= "Registra una Visualizzazione ongi volta che viene consegnato un banner";
$GLOBALS['strLogAdclicks']					= "Registra un Click ongi volta che un visitatore clicca su un banner";
$GLOBALS['strLogSource']					= "Registra il parametro sorgente specificato durante l'invocazione";
$GLOBALS['strGeoLogStats']					= "Registra la nazionalit&agrave; del visitatore nelle statistiche";
$GLOBALS['strLogHostnameOrIP']				= "Registra il nome di host o l'indirizzo IP del visitatore";
$GLOBALS['strLogIPOnly']					= "Registra solo l'indirizzo IP anche se &egrave; noto il nome di host";
$GLOBALS['strLogIP']						= "Registra l'indirizzo IP del visitatore";
$GLOBALS['strLogBeacon']					= "Utilizza una piccola immgine <i>beacon</i> per registrare le Visualizzazioni, per assicurarsi di registrare solo i banner effettivamente consegnati";

$GLOBALS['strPreventLogging']				= "Eccezioni della memorizzazione";
$GLOBALS['strRemoteHosts']					= "Host remoti";
$GLOBALS['strIgnoreHosts']					= "Non memorizzare statistiche dei visitatori che utilizzano uno dei seguenti indirizzi IP o nomi di host";
$GLOBALS['strBlockAdviews']					= "Non registrare una Visualizzazione se il visitatore ha gi&agrave; visto lo stesso banner entro il numero di secondi specificato";
$GLOBALS['strBlockAdclicks']				= "Non registrare un Click se il visitatore ha gi&agrave; cliccato sullo stesso banner entro il numero di secondi specificato";


$GLOBALS['strEmailWarnings']				= "Avvertimenti E-mail";
$GLOBALS['strAdminEmailHeaders']			= "Aggiungi i seguenti header ad ogni e-mail inviata da ".$phpAds_productname;
$GLOBALS['strWarnLimit']					= "Invia un avviso quando il numero di Visualizzazioni rimaste sono inferiori a";
$GLOBALS['strWarnLimitErr']					= "Il lmite di avvertimento deve essere un numero positivo";
$GLOBALS['strWarnAdmin']					= "Invia un avviso all'amministratore quando una campagna sta per scadere";
$GLOBALS['strWarnClient']					= "Invia un avviso all'inserzionista quando una campagna sta per scadere";
$GLOBALS['strQmailPatch']					= "Abilita patch per qmail";

$GLOBALS['strAutoCleanTables']				= "Pulizia del database";
$GLOBALS['strAutoCleanStats']				= "Pulisci statistiche";
$GLOBALS['strAutoCleanUserlog']				= "Pulisci registro eventi";
$GLOBALS['strAutoCleanStatsWeeks']			= "Et&agrave; massima statistiche <br />(minimo 3 settimane)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Et&agrave; massima registro eventi <br />(minimo 3 settimane)";
$GLOBALS['strAutoCleanErr']					= "L'et&agrave; massima deve essere di almeno 3 settimane";
$GLOBALS['strAutoCleanVacuum']				= "Esegui VACUUM ANALYZE sulle tabelle ogni notte"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Impostazioni amministratore";

$GLOBALS['strLoginCredentials']				= "Credenziali di login";
$GLOBALS['strAdminUsername']				= "Username";
$GLOBALS['strInvalidUsername']				= "Username non valido";

$GLOBALS['strBasicInformation']				= "Informazioni di base";
$GLOBALS['strAdminFullName']				= "Nome e cognome";
$GLOBALS['strAdminEmail']					= "Indirizzo email";
$GLOBALS['strCompanyName']					= "Societ&agrave;";

$GLOBALS['strAdminCheckUpdates']			= "Controlla aggiornamenti disponibili";
$GLOBALS['strAdminCheckEveryLogin']			= "Ad ogni login";
$GLOBALS['strAdminCheckDaily']				= "Una volta al giorno";
$GLOBALS['strAdminCheckWeekly']				= "Una volta alla settimana";
$GLOBALS['strAdminCheckMonthly']			= "Una volta al mese";
$GLOBALS['strAdminCheckNever']				= "Non controllare";

$GLOBALS['strAdminNovice']					= "Richiedi conferma nelle operazioni di cancellazione dell'amministratore";
$GLOBALS['strUserlogEmail']					= "Registra tutte le email in uscita";
$GLOBALS['strUserlogPriority']				= "Registra i calcoli eseguiti ogni ora nell'assegnamento delle priorit&agrave;";
$GLOBALS['strUserlogAutoClean']				= "Registra la pulizia automatica del database";


// User interface settings
$GLOBALS['strGuiSettings']					= "Configurazione interfaccia utente";

$GLOBALS['strGeneralSettings']				= "Impostazioni generali";
$GLOBALS['strAppName']						= "Intestazione programma";
$GLOBALS['strMyHeader']						= "File da includere come intestazione";
$GLOBALS['strMyHeaderError']				= "Il file da includere come intestazione non &egrave; stato trovato nel percorso specificato";
$GLOBALS['strMyFooter']						= "File da includere a pi&eacute; di pagina";
$GLOBALS['strMyFooterError']				= "Il file da includere a pi&eacute; di pagina non &egrave; stato trovato nel percorso specificato";
$GLOBALS['strGzipContentCompression']		= "Utilizza la compressione GZIP";

$GLOBALS['strClientInterface']				= "Interfaccia inserzionista";
$GLOBALS['strClientWelcomeEnabled']			= "Attiva messaggio di benvenuto";
$GLOBALS['strClientWelcomeText']			= "Testo del messaggio<br />(tag HTML consentite)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']			= "Default di interfaccia";

$GLOBALS['strInventory']					= "Inventario";
$GLOBALS['strShowCampaignInfo']				= "Mostra informazioni aggiuntive nella pagina <i>Descrizione Campagne</i>";
$GLOBALS['strShowBannerInfo']				= "Mostra informazioni aggiuntive nella pagina <i>Descrizione Banner</i>";
$GLOBALS['strShowCampaignPreview']			= "Mostra anteprima dei banner nella pagina <i>Descrizione Banner</i>";
$GLOBALS['strShowBannerHTML']				= "Mostra il banner invece del codice HTML nell'anteprima dei banner HTML";
$GLOBALS['strShowBannerPreview']			= "Mostra anteprima nella parte superiore della pagina nelle pagine dei banner";
$GLOBALS['strHideInactive']					= "Nascondi entit&agrave; inattive in tutte le pagine riassuntive";
$GLOBALS['strGUIShowMatchingBanners']		= "Mostra banner corrispondenti nella pagina <i>Banner collegati</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Mostra campagne nella pagina <i>Banner collegati</i>";
$GLOBALS['strGUILinkCompactLimit']			= "Nascondi campagne o banner non collegati nella pagina <i>Banner collegati</i> quando ce ne sono pi&ugrave; di";


$GLOBALS['strStatisticsDefaults']			= "Statistiche";
$GLOBALS['strBeginOfWeek']					= "Primo giorno della settimana";
$GLOBALS['strPercentageDecimals']			= "Numero decimali nelle percentuali";

$GLOBALS['strWeightDefaults']				= "Peso di default";
$GLOBALS['strDefaultBannerWeight']			= "Peso di default dei banner";
$GLOBALS['strDefaultCampaignWeight']		= "Peso di default delle campagne";
$GLOBALS['strDefaultBannerWErr']			= "Il peso di default dei banner deve essere un intero positivo";
$GLOBALS['strDefaultCampaignWErr']			= "Il peso di default delle campagne deve essere un intero positivo";



// Not used at the moment
$GLOBALS['strTableBorderColor']				= "Colore del bordo delle tabelle";
$GLOBALS['strTableBackColor']				= "Colore di sfondo delle tabelle";
$GLOBALS['strTableBackColorAlt']			= "Colore di sfondo delle tabelle (Alternativo)";
$GLOBALS['strMainBackColor']				= "Colore di sfondo delle pagine";
$GLOBALS['strOverrideGD']					= "Utilizza formato GD personalizzato";
$GLOBALS['strTimeZone']						= "Fuso orario";

?>