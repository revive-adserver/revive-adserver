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

/** check step * */
$GLOBALS['strSystemCheck'] = "Controllo del sistema";
$GLOBALS['strSystemCheckIntro'] = "La procedura di installazione ha eseguito un controllo del tuo server web per garantire che il processo di installazione possa completarsi con successo.                                                  <br>Controlla ogni problema evidenziato per completare il processo di installazione.";

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
$GLOBALS['strLoginProgressMessage'] = 'Login in corso...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Fornisci il tuo database";
$GLOBALS['strDbUpgradeTitle'] = "Il tuo database è stato rilevato";
$GLOBALS['strDbProgressMessageInstall'] = 'Installazione del database in corso...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Aggiornamento database in corso...';
$GLOBALS['strDbSeeMoreFields'] = 'Guarda più campi del database...';
$GLOBALS['strDbTimeZoneNoWarnings'] = "Non visualizzare avvisi di fuso orario in futuro";
$GLOBALS['strDBInstallSuccess'] = "Database creato con successo";
$GLOBALS['strDBUpgradeSuccess'] = "Database aggiornato con successo";


/** config step * */
$GLOBALS['strConfigureUpgradeTitle'] = "Impostazioni di configurazione";
$GLOBALS['strConfigSeeMoreFields'] = "Guarda più campi di configurazione...";
$GLOBALS['strPreviousInstallTitle'] = "Installazione precedente";
$GLOBALS['strPathToPreviousError'] = "Uno o più file di plugin non sono stati individuati, controlla il file install.log per maggiori informazioni";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Esecuzione delle attività di installazione in corso";
$GLOBALS['strJobsInstallIntro'] = "L'installer sta eseguendo le ultime attività di installazione.";
$GLOBALS['strJobsUpgradeTitle'] = "Eseguendo le mansioni di aggiornamento";
$GLOBALS['strJobsUpgradeIntro'] = "L'installer sta eseguendo le ultime mansioni di aggiornamento.";
$GLOBALS['strJobsProgressInstallMessage'] = "Eseguendo le mansioni di installazione...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Eseguendo le mansioni di aggiornamento...";

$GLOBALS['strPostInstallTaskRunning'] = "Attività in esecuzione";

/** finish step * */
$GLOBALS['strDetailedTaskErrorList'] = "Trovata una lista dettagliata di errori";
$GLOBALS['strPluginInstallFailed'] = "Installazione dei plugin \"%s\" fallita:";
$GLOBALS['strTaskInstallFailed'] = "Si è verificato un errore durante l'attività di installazione \"%s\":";

$GLOBALS['strUnableToCreateAdmin'] = "Non riusciamo a creare un account amministratore sistema, il tuo database è accessibile?";

