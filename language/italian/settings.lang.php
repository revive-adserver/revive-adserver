<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']					= "Installazione";
$GLOBALS['strChooseInstallLanguage']	= "Scegli la lingua per la procedura di installazione";
$GLOBALS['strLanguageSelection']		= "Selezione lingua";
$GLOBALS['strDatabaseSettings']			= "Impostazione database";
$GLOBALS['strAdminSettings']			= "Impostazioni amministratore";
$GLOBALS['strAdvancedSettings']			= "Impostazioni avanzate";
$GLOBALS['strOtherSettings']			= "Altre impostazioni";

$GLOBALS['strWarning']					= "Attenzione";
$GLOBALS['strFatalError']				= "Si &egrave; verificato un errore fatale";
$GLOBALS['strAlreadyInstalled']			= "phpAdsNew &egrave; gi&agrave; installato su questo sistema. Per modificare le impostazioni clicca <a href='settings-index.php'>qui</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Impossibile connettersi al database, controlla i parametri specificati";
$GLOBALS['strCreateTableTestFailed']	= "L'utente specificato non ha i permessi necessari a creare o aggiornare la struttura del database, contatta l'amministratore di sistema.";
$GLOBALS['strUpdateTableTestFailed']	= "L'utente specificato non ha i permessi necessari ad aggiornare la struttura del database, contatta l'amministratore di sistema.";
$GLOBALS['strTablePrefixInvalid']		= "Il prefisso delle tabelle contiene caratteri non validi";
$GLOBALS['strMayNotFunction']			= "Prima di continuare, correggi questi potenziali problemi:";
$GLOBALS['strIgnoreWarnings']			= "Ignora avvertimenti";
$GLOBALS['strWarningPHPversion']		= "phpAdsNew richiede PHP 3.0.8 o pi&ugrave; recente per funzionare correttamente. La versione attualmente utilizzata &egrave; {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "La variabile di configurazione del PHP register_globals deve essere abilitata.";
$GLOBALS['strWarningMagicQuotesGPC']	= "La variabile di configurazione del PHP magic_quotes_gpc deve essere abilitata.";
$GLOBALS['strWarningMagicQuotesRuntime']= "La variabile di configurazione del PHP magic_quotes_runtime deve essere disabilitata.";
$GLOBALS['strConfigLockedDetected']		= "Il file <b>config.inc.php</b> non pu&ograve; essere sovrascritto dal server.<br> Non è possiblie procedere finch&eacute; non vengono modificati i permessi sul file. <br>Puoi leggere sul manuale di phpAdsNew come fare.";
$GLOBALS['strCantUpdateDB']  			= "Non &egrave; possibile aggiornare il database. Se decidi di procedere, tutti i banner, le statistiche e i clienti saranno cancellati.";
$GLOBALS['strTableNames']				= "Nomi delle tabelle";
$GLOBALS['strTablesPrefix']				= "Prefisso delle tabelle";
$GLOBALS['strTablesType']				= "Tipo di tabelle";

$GLOBALS['strInstallWelcome']			= "Benvenuto in phpAdsNew";
$GLOBALS['strInstallMessage']			= "Prima di utilizzare phpAdsNew &egrave; necessario configurarlo e <br> il database deve essere creato. Clicca su <b>Procedi</b> per continuare.";
$GLOBALS['strInstallSuccess']			= "<b>L'istallazione di phpAdsNew &egrave stata completata.</b><br><br>Affinch&eacute; phpAdsNew funzioni correttamente devi assicurarti
										   che lo script di manutenzione sia lanciato ogni giorno. Puoi trovare informazioni maggiori sull'argomento nel manuale.
										   <br><br>Clicca <b>Procedi</b> per andare alla pagina di configurazione e impostare
										   altri parametri. Ricordati di togliere i permessi al file config.inc.php quando hai finito, per evitare problemi di
										   sicurezza.";
$GLOBALS['strInstallNotSuccessful']		= "<b>L'installazione di phpAdsNew non ha avuto successo</b><br><br>Alcune parti del processo di installazione non possono essere completate.
										   &Egrave; possibile che questi problemi siano solo temporanei, in questo caso clicca <b>Procedi</b> per ritornare alla
										   prima fase dell'installazione. Se vuoi saperne di più sul significato dell'errore, e su come risolvere il problema, 
										   consulta il manuale di phpAdsNew.";
$GLOBALS['strErrorOccured']				= "Si &egrave; verificato il seguente errore:";
$GLOBALS['strErrorInstallDatabase']		= "La struttura del database non può essere creata.";
$GLOBALS['strErrorInstallConfig']		= "La configurazione (su file e/o database) non pu&ograve; essere aggiornata.";
$GLOBALS['strErrorInstallDbConnect']	= "Non &egrave; stato possibile connettersi al database.";

$GLOBALS['strUrlPrefix']				= "Prefisso URL";

$GLOBALS['strProceed']					= "Procedi &gt;";
$GLOBALS['strRepeatPassword']			= "Ripeti password";
$GLOBALS['strNotSamePasswords']			= "Le password non coincidono";
$GLOBALS['strInvalidUserPwd']			= "Username o password non validi";

$GLOBALS['strUpgrade']					= "Aggiornamento";
$GLOBALS['strSystemUpToDate']			= "Il sistema &egrave; aggiornato, al momento non sono necessari aggiornamenti. <br>Clicca <b>Procedi</b> per andare alla pagina principale.";
$GLOBALS['strSystemNeedsUpgrade']		= "La struttura del database e il file di configurazione devono essere aggiornati per funzionare correttamente. Clicca <b>Procedi</b> per iniziare il processo di aggiornamento. <br>Sii paziente, il processo può durare anche alcuni minuti.";
$GLOBALS['strSystemUpgradeBusy']		= "Aggiornamento in corso, attendere prego...";
$GLOBALS['strServiceUnavalable']		= "Il servizio non &egrave; disponibile al momento. &Egrave; in corso l'aggiornamento del sistema.";

$GLOBALS['strConfigNotWritable']		= "Il file config.inc.php non può essere sovrascritto";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Scegli la sezione";
$GLOBALS['strDayFullNames'] 			= array("Domenica","Luned&igrave;","Martedi&igrave;","Mercoled&igrave;","Gioved&igrave;","Venerd&igrave;","Sabato");
$GLOBALS['strEditConfigNotPossible']    = "It is not possible to edit these settings because the configuration file is locked for security reasons. ".
										  "If you want to make changes, you need to unlock the config.inc.php file first.";
$GLOBALS['strEditConfigPossible']		= "It is possible to edit all settings because the configuration file is not locked, but this could lead to security leaks. ".
										  "If you want to secure your system, you need to lock the config.inc.php file.";



// Database
$GLOBALS['strDatabaseSettings']			= "Impostazione database";

$GLOBALS['strDatabaseServer']			= "Database server";
$GLOBALS['strDbHost']					= "Hostname database";
$GLOBALS['strDbUser']					= "Username database";
$GLOBALS['strDbPassword']				= "Password database";
$GLOBALS['strDbName']					= "Nome database";

$GLOBALS['strDatabaseOptimalisations']	= "Database optimalisations";
$GLOBALS['strPersistentConnections']	= "Utilizza connessioni persistenti";
$GLOBALS['strInsertDelayed']			= "Utilizza inserimenti in differita";
$GLOBALS['strCompatibilityMode']		= "Attiva compatibilit&agrave; con server MySQL 3.22";
$GLOBALS['strCantConnectToDb']			= "Impossibile connettersi al database";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "Invocation and delivery settings";

$GLOBALS['strKeywordRetrieval']			= "Keyword retrieval";
$GLOBALS['strBannerRetrieval']			= "Metodo di scelta del banner";
$GLOBALS['strRetrieveRandom']			= "Casuale (default)";
$GLOBALS['strRetrieveNormalSeq']		= "Sequenziale normale";
$GLOBALS['strWeightSeq']				= "Sequenziale pesata";
$GLOBALS['strFullSeq']					= "Sequenziale completa";
$GLOBALS['strUseConditionalKeys']		= "Utilizza keyword condizionali";
$GLOBALS['strUseMultipleKeys']			= "Utilizza keyword multiple";
$GLOBALS['strUseAcl']					= "Utilizza le limitazioni di visualizzazione";

$GLOBALS['strZonesSettings']			= "Impostazione zone";
$GLOBALS['strZoneCache']				= "Memorizza zone nella cache (dovrebbe velocizzare il tutto se si usano le zone)";
$GLOBALS['strZoneCacheLimit']			= "Tempo di validit&agrave; della cache (in secondi)";
$GLOBALS['strZoneCacheLimitErr']		= "Il tempo di validit&agrave; deve essere un intero positivo";

$GLOBALS['strP3PSettings']				= "Impostazioni P3P";
$GLOBALS['strUseP3P']					= "Utilizza le policy P3P";
$GLOBALS['strP3PCompactPolicy']			= "Versione compatta della policy P3P";
$GLOBALS['strP3PPolicyLocation']		= "Indirizzo della policy p£p completa";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Banner settings";

$GLOBALS['strTypeHtmlSettings']			= "Configurazione banner HTML";
$GLOBALS['strTypeHtmlAuto']				= "Modifica automaticamente i banner HTML per poter registrare i click";
$GLOBALS['strTypeHtmlPhp']				= "Consenti l'esecuzione di espressioni PHP all'interno dei banner HTML";

$GLOBALS['strTypeWebSettings']			= "Configurazione banner memorizzati sul server Web";
$GLOBALS['strTypeWebMode']				= "Tipo di memorizzazione";
$GLOBALS['strTypeWebModeLocal']			= "Modalit&agrave; locale (utilizza una directory locale)";
$GLOBALS['strTypeWebModeFtp']			= "Modalit&agrave; FTP (utilizza un server FTP esterno)";
$GLOBALS['strTypeWebDir']				= "Directory per la modalit&agrave; locale";
$GLOBALS['strTypeWebFtp']				= "Server FTP per la modalit&agrave; FTP";
$GLOBALS['strTypeWebUrl']				= "URL pubblico della directory locale / server FTP";

$GLOBALS['strDefaultBanners']			= "Default banners";
$GLOBALS['strDefaultBannerUrl']			= "URL del banner di default";
$GLOBALS['strDefaultBannerTarget']		= "URL destinazione del banner di default";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Statistics Settings";

$GLOBALS['strStatisticsFormat']			= "Statistics format";
$GLOBALS['strLogBeacon']				= "Use beacons to log Adviews";
$GLOBALS['strCompactStats']				= "Utilizza il formato delle statistiche compatto";
$GLOBALS['strLogAdviews']				= "Registra visualizzazioni";
$GLOBALS['strLogAdclicks']				= "Registra click";

$GLOBALS['strEmailWarnings']			= "E-mail warnings";
$GLOBALS['strAdminEmailHeaders']		= "Header aggiuntivi delle email";
$GLOBALS['strWarnLimit']				= "Limite di avvertimento";
$GLOBALS['strWarnLimitErr']				= "Il lmite di avvertimento deve essere un intero positivo";
$GLOBALS['strWarnAdmin']				= "Avvisa l'amministratore";
$GLOBALS['strWarnClient']				= "Avvisa i clienti";

$GLOBALS['strRemoteHosts']				= "Remote hosts";
$GLOBALS['strIgnoreHosts']				= "Host da ignorare nelle statistiche";
$GLOBALS['strReverseLookup']			= "Risolvi nomi di dominio";
$GLOBALS['strProxyLookup']				= "Proxy Lookup";



// Administrator settings
$GLOBALS['strAdministratorSettings']	= "Administrator settings";

$GLOBALS['strLoginCredentials']			= "Login credentials";
$GLOBALS['strAdminUsername']			= "Username";
$GLOBALS['strOldPassword']				= "Vecchia password";
$GLOBALS['strNewPassword']				= "Nuova password";
$GLOBALS['strInvalidUsername']			= "Username non valido";
$GLOBALS['strInvalidPassword']			= "Password non valida";

$GLOBALS['strBasicInformation']			= "Basic information";
$GLOBALS['strAdminFullName']			= "Nome e cognome";
$GLOBALS['strAdminEmail']				= "Indirizzo email";
$GLOBALS['strCompanyName']				= "Società";

$GLOBALS['strAdminNovice']				= "Richiedi conferma nelle operazioni di cancellazione dell'amministratore";



// User interface settings
$GLOBALS['strGuiSettings']				= "Configurazione Interfaccia Utente";

$GLOBALS['strGeneralSettings']			= "General settings";
$GLOBALS['strAppName']					= "Intestazione programma";
$GLOBALS['strMyHeader']					= "File da includere come intestazione";
$GLOBALS['strMyFooter']					= "File da includere a pi&eacute; di pagina";

$GLOBALS['strClientInterface']			= "Client interface";
$GLOBALS['strClientWelcomeEnabled']		= "Attiva messaggio di benvenuto";
$GLOBALS['strClientWelcomeText']		= "Testo del messaggio<br>(tag HTML consentite)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Interface defaults";

$GLOBALS['strStatisticsDefaults'] 		= "Statistics";
$GLOBALS['strBeginOfWeek']				= "Primo giorno della settimana";
$GLOBALS['strPercentageDecimals']		= "Numero decimali nelle percentuali";

$GLOBALS['strWeightDefaults']			= "Default weight";
$GLOBALS['strDefaultBannerWeight']		= "Peso di default dei banner";
$GLOBALS['strDefaultCampaignWeight']	= "Peso di default delle campagne";
$GLOBALS['strDefaultBannerWErr']		= "Il peso di default dei banner deve essere un intero positivo";
$GLOBALS['strDefaultCampaignWErr']		= "Il peso di default delle campagne deve essere un intero positivo";

$GLOBALS['strAllowedBannerTypes']		= "Tipi di banner consentiti";
$GLOBALS['strTypeSqlAllow']				= "Consenti banner memorizzati nel database";
$GLOBALS['strTypeWebAllow']				= "Consenti banner memorizzati sul server Web";
$GLOBALS['strTypeUrlAllow']				= "Consenti banner richiamati da altri URL";
$GLOBALS['strTypeHtmlAllow']			= "Consenti banner HTML";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Table Border Color";
$GLOBALS['strTableBackColor']			= "Table Back Color";
$GLOBALS['strTableBackColorAlt']		= "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']			= "Main Back Color";
$GLOBALS['strOverrideGD']				= "Utilizza formato GD personale";
$GLOBALS['strTimeZone']					= "Fuso Orario";

?>