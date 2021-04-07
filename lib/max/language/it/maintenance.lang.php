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

// Main strings
$GLOBALS['strChooseSection'] = "Scgli sezione";
$GLOBALS['strAppendCodes'] = "Accoda i codici";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<strong>La manutenzione programmata non è stata eseguita nell'ultima ora. Potrebbe darsi che non sia stata configurata correttamente.</strong>";





$GLOBALS['strScheduledMantenaceRunning'] = "<strong>La manutenzione programmata funziona correttamente.</strong>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<strong>La manutenzione automatica funziona correttamente</strong>";

$GLOBALS['strAutoMantenaceEnabled'] = "La manutenzione automatica rimane funzionante. Per ottenere le performance migliori dovresti <a href='account-settings-maintenance.php'>disabilitare la manutenzione automatica</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Ricalcola la priorità";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Controlla la cache dei banner";
$GLOBALS['strBannerCacheErrorsFound'] = "La cache dei banner nel database ha riscontrato qualche errore. Questi banner non funzioneranno finchè non correggerai manualmente gli errori riscontrati.";
$GLOBALS['strBannerCacheOK'] = "Non sono stati rilevati errori. La cache dei banner nel database è stata aggiornata.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Il controllo della cache dei banner del database ha trovato che la cache non è aggiornata e deve essere ricalcolata. Clicca qui per aggiornare automaticamente la cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Ricostruisci";
$GLOBALS['strRebuildDeliveryCache'] = "Ricostruisci la cache di consegna";

// Cache
$GLOBALS['strCache'] = "Cache di consegna";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Per memorizzare la cache di consegna è utilizzata la memoria condivisa.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Per memorizzare la cache di consegna si sta utilizzando il database.";
$GLOBALS['strDeliveryCacheFiles'] = "	Per memorizzare la cache di consegna sono utilizzati dei file sul server.";

// Storage
$GLOBALS['strStorage'] = "Memorizzazione";
$GLOBALS['strMoveToDirectory'] = "Sposta le immagini memorizzate nel database in una cartella";
$GLOBALS['strStorageExplaination'] = "Le immagini utilizzate nei banner locali vengono memorizzate nel database o in una directory sul server web. Memorizzare
le immagini in una directory riduce il carico di lavoro eseguito dal database e, di conseguenza, aumenta la velocità
del sistema.";

// Encoding
$GLOBALS['strEncoding'] = "Codifica";
$GLOBALS['strEncodingConvertFrom'] = "Converti da questa codifica:";
$GLOBALS['strEncodingConvertTest'] = "Prova la conversione";
$GLOBALS['strConvertThese'] = "Se continui, i seguenti dati saranno cambiati";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Ricerca aggiornamenti in corso. Attendere prego...";
$GLOBALS['strAvailableUpdates'] = "Aggiornamenti disponibili";
$GLOBALS['strDownloadZip'] = "Scarica (.zip)";
$GLOBALS['strDownloadGZip'] = "Scarica (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "    Per motivi sconosciuti non è possibile scaricare le informazioni<br />
	sui possibili aggiornamenti disponibili. Riprovare più tardi, grazie.";



$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Il controllo degli aggiornamenti è disattivato. Si prega di abilitarlo nelle <a href='account-settings-update.php'>impostazioni di aggiornamento</a>.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = "	Per sapere se è disponibile una versione più recente, collegati al nostro sito.";

$GLOBALS['strClickToVisitWebsite'] = "Clicca qui per visitare il nostro sito";
$GLOBALS['strCurrentlyUsing'] = "Attualmente stai utilizzando";
$GLOBALS['strRunningOn'] = "in esecuzione su";
$GLOBALS['strAndPlain'] = "e";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Regole Di Consegna";
$GLOBALS['strErrorsFound'] = "Sono stati rilevati degli errori";
$GLOBALS['strRepairCompiledLimitations'] = "Sono state trovate alcune inconsistenze, puoi ripararle usando il bottone seguente. Ricompilerai la limitazione banner / canale nel sistema<br />";
$GLOBALS['strRecompile'] = "Ricompila";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "In alcune circostanze il motore di distribuzione è in disaccordo con i codici accodati. Usa il seguente collegamento per convalidare nel database i codici accodati.";
$GLOBALS['strCheckAppendCodes'] = "Controlla i codici accodati";
$GLOBALS['strAppendCodesRecompiled'] = "Tutti i codici accodati sono stati ricalcolati";
$GLOBALS['strAppendCodesResult'] = "Ecco i risultati di convalida dei codici accodati";
$GLOBALS['strAppendCodesValid'] = "Tutti i codici accodati sono validi";
$GLOBALS['strRepairAppenedCodes'] = "Sono state trovate alcune inconsistenze, puoi ripararle usando il bottone seguente. Ricompilerai i codici accodati per ogni tracker del sistema";

$GLOBALS['strPlugins'] = "Plugin";

$GLOBALS['strMenus'] = "Menu";
$GLOBALS['strMenusPrecis'] = "Ricostruisci la cache dei menu";
$GLOBALS['strMenusCachedOk'] = "La cache dei menù è stata ricostruita";
