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

/** status messages * */
$GLOBALS['strInstallStatusRecovery'] = 'Ripristino di Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Installazione di Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Aggiornamento a Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Rilevato Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Benvenuto in {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Grazie per aver scelto {$PRODUCT_NAME}. Questa procedura ti guiderà attraverso il processo di installazione {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Grazie per aver scelto {$PRODUCT_NAME}. Questa procedura ti guiderà attraverso il processo di aggiornamento {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "Per aiutarti con il processo di installazione di {$PRODUCT_NAME}, guarda la documentazione <a href='{$PRODUCT_DOCSURL}' target='_blank'></a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} è distribuito gratuitamente sotto una licenza Open Source, la GNU General Public License. Ricontrolla e accetta i seguenti documenti per continuare l'installazione.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Controllo del sistema";
$GLOBALS['strSystemCheckIntro'] = "La procedura di installazione ha eseguito un controllo del tuo server web per garantire che il processo di installazione possa completarsi con successo.                                                  <br>Controlla ogni problema evidenziato per completare il processo di installazione.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "La configurazione del tuo server web non soddisfa i requisiti del {$PRODUCT_NAME}.
                                                   <br>Per procedere con l'installazione, correggi tutti gli errori.
                                                   Per aiuto, guarda la nostra <a href='{$PRODUCT_DOCSURL}'>documentazione</a> e <a href='http://{$PRODUCT_URL}/faq'>FAQ</a>";

$GLOBALS['strAppCheckErrors'] = "Sono stati rilevati degli errori durante la ricerca di installazioni precedenti di {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "Abbiamo rilevato problemi di integrità con il tuo database. Ciò vuol dire che il layout del tuo database
                                                   differisce da ciò che ci aspettiamo che sia. Questo potrebbe essere dovuto dalla personalizzazione del tuo database.";

$GLOBALS['strSyscheckProgressMessage'] = "Verificando i parametri di sistema...";
$GLOBALS['strError'] = "Errore";
$GLOBALS['strWarning'] = "Attenzione";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Verifica il nome";
$GLOBALS['strSyscheckValue'] = "Valore corrente";
$GLOBALS['strSyscheckStatus'] = "Stato";
$GLOBALS['strSyscheckSeeFullReport'] = "Mostra il controllo dettagliato del sistema";
$GLOBALS['strSyscheckSeeShortReport'] = "Mostra solo errori e avvertimenti";
$GLOBALS['strBrowserCookies'] = 'Cookie del browser';
$GLOBALS['strPHPConfiguration'] = 'Configurazione PHP';
$GLOBALS['strCheckError'] = 'errore';
$GLOBALS['strCheckErrors'] = 'errori';
$GLOBALS['strCheckWarning'] = 'avviso';
$GLOBALS['strCheckWarnings'] = 'avvisi';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Accedi come {$PRODUCT_NAME} amministratore";
$GLOBALS['strAdminLoginIntro'] = "Per continuare, inserisci i tuoi dati di accesso di amministratore sistema {$PRODUCT_NAME}.";
$GLOBALS['strLoginProgressMessage'] = 'Login in corso...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Fornisci il tuo database";
$GLOBALS['strDbSetupIntro'] = "Fornisci i dettagli per connetterti al tuo database {$PRODUCT_NAME}.";
$GLOBALS['strDbUpgradeTitle'] = "Il tuo database è stato rilevato";
$GLOBALS['strDbUpgradeIntro'] = "Il seguente database è stato rilevato per l'installazione di {$PRODUCT_NAME}.
                                                   Verifica che sia corretto poi clicca \"Continua\" per procedere.";
$GLOBALS['strDbProgressMessageInstall'] = 'Installazione del database in corso...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Aggiornamento database in corso...';
$GLOBALS['strDbSeeMoreFields'] = 'Guarda più campi del database...';
$GLOBALS['strDbTimeZoneNoWarnings'] = "Non visualizzare avvisi di fuso orario in futuro";
$GLOBALS['strDBInstallSuccess'] = "Database creato con successo";
$GLOBALS['strDBUpgradeSuccess'] = "Database aggiornato con successo";

$GLOBALS['strDetectedVersion'] = "Rilevata versione {$PRODUCT_NAME}";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Configura il tuo account di sistema amministratore locale {$PRODUCT_NAME}";
$GLOBALS['strConfigureInstallIntro'] = "Fornisci le informazioni di accesso desiderate per il tuo account {$PRODUCT_NAME} amministratore sistema locale.";
$GLOBALS['strConfigureUpgradeTitle'] = "Impostazioni di configurazione";
$GLOBALS['strConfigureUpgradeIntro'] = "Fornisci il percorso di installazione di {$PRODUCT_NAME} precedente.";
$GLOBALS['strConfigSeeMoreFields'] = "Guarda più campi di configurazione...";
$GLOBALS['strPreviousInstallTitle'] = "Installazione precedente";
$GLOBALS['strPathToPrevious'] = "Percorso di installazione precedente di {$PRODUCT_NAME}";
$GLOBALS['strPathToPreviousError'] = "Uno o più file di plugin non sono stati individuati, controlla il file install.log per maggiori informazioni";
$GLOBALS['strConfigureProgressMessage'] = "Configurazione {$PRODUCT_NAME} in corso...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Esecuzione delle attività di installazione in corso";
$GLOBALS['strJobsInstallIntro'] = "L'installer sta eseguendo le ultime attività di installazione.";
$GLOBALS['strJobsUpgradeTitle'] = "Eseguendo le mansioni di aggiornamento";
$GLOBALS['strJobsUpgradeIntro'] = "L'installer sta eseguendo le ultime mansioni di aggiornamento.";
$GLOBALS['strJobsProgressInstallMessage'] = "Eseguendo le mansioni di installazione...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Eseguendo le mansioni di aggiornamento...";

$GLOBALS['strPluginTaskChecking'] = "Controllo dei Plugin {$PRODUCT_NAME} in corso";
$GLOBALS['strPluginTaskInstalling'] = "Installazione dei Plugin {$PRODUCT_NAME} in corso";
$GLOBALS['strPostInstallTaskRunning'] = "Attività in esecuzione";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "L'installazione di {$PRODUCT_NAME} è completa.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "L'aggiornamento di {$PRODUCT_NAME} è stato completato. Controlla i problemi evidenziati.";
$GLOBALS['strFinishUpgradeTitle'] = "L'aggiornamento di {$PRODUCT_NAME} è stato completato.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "L'installazione di {$PRODUCT_NAME} è stata completata. Controlla i problemi evidenziati.";
$GLOBALS['strDetailedTaskErrorList'] = "Trovata una lista dettagliata di errori";
$GLOBALS['strPluginInstallFailed'] = "Installazione dei plugin \"%s\" fallita:";
$GLOBALS['strTaskInstallFailed'] = "Si è verificato un errore durante l'attività di installazione \"%s\":";
$GLOBALS['strContinueToLogin'] = "Clicca \"Continua\" per accedere all'istanza di {$PRODUCT_NAME}.";

$GLOBALS['strUnableCreateConfFile'] = "Non riusciamo a creare il tuo file di configurazione. Ricontrolla i permessi nella cartella var di {$PRODUCT_NAME}.";
$GLOBALS['strUnableUpdateConfFile'] = "Non riusciamo ad aggiornare i tuoi file di configurazione. Ricontrolla i permessi nella cartella var di {$PRODUCT_NAME}, e controlla anche i permessi della configurazione di installazione precedente che hai copiato in questa cartella.";
$GLOBALS['strUnableToCreateAdmin'] = "Non riusciamo a creare un account amministratore sistema, il tuo database è accessibile?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} ha rilevato che la tua installazione PHP sta reimpostando \"Sistema/OraLocale\" come fuso orario del tuo server. Questo è a causa di una patch a PHP applicata da alcuni distrubutori Linux.
Sfortunatamente, questo non è un fuso orario valido di PHP. Modifica il tuo file php.ini e imposta la \"Data.FusoOrario\" al valore corretto per il tuo server.";

