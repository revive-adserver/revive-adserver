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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "La manutenzione automatica è abilitata ma non è stata eseguita. Viene eseguita soltanto quando {$PRODUCT_NAME} spedisce dei banner. Per ottenere le performance migliori dovresti impostare la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>manutenzione programmata</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "La manutenzione automatica è disabilitata. Quando {$PRODUCT_NAME} distribuisce i banner non sarà eseguita. Per ottenere le performance migliori dovresti impostare la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>manutenzione programmata</a>. Se non vuoi farlo adesso, allora <em>devi</em> attivare la <a href='account-settings-maintenance.php'>manutenzione automatica</a> per assicurarti che {$PRODUCT_NAME} funzioni correttamente.'";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "La manutenzione automatica è abilitata e sarà eseguita quando richiesto, mentre {$PRODUCT_NAME} spedisce i banner. Per ottenere le migliori prestazioni dovresti impostare la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>manutenzione progammata</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "La manutenzione automatica è stata recentemente disabilitata. Per assicurarsi che {$PRODUCT_NAME} funzioni correttamente, dovresti impostare la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>manutenzione programmata</a> oppure <a href='account-settings-maintenance.php'>attivare nuovamente la manutenzione automatica</a>.<br><br>Per ottenere le performance migliori dovresti impostare la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>manutenzione programmata</a>.";

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
$GLOBALS['strBannerCacheExplaination'] = "La cache dei banner contiene una copia del codice HTML usato per visualizzare il banner. Usando la cache è possibile velocizzare
la fornitura dei banner, poiché che il codice HTML non deve essere generato tutte le volte che il banner viene richiamato.
Dal momento che la cache dei banner l\\'URL della posizione di OpenX e dei banner in forma codificata, la cache deve
essere aggiornata qualora OpenX venga spostato ad un altro indirizzo sul server web.";

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

// Security
$GLOBALS['strSecurity'] = "Sicurezza";
$GLOBALS['strSecurityExplanation'] = "Alcune directory nel pacchetto {$PRODUCT_NAME} non dovrebbero essere servite direttamente da 
    il tuo webserver, per motivi di sicurezza. Lasciare tali file e directory accessibili potrebbe rivelare informazioni
    indesiderate e rappresentare una minaccia per la sicurezza. È stato eseguito un rapido controllo di sicurezza e troverai i risultati qui sotto.";
$GLOBALS['strSecurityOK'] = "Il tuo browser non è stato in grado di recuperare i file protetti, questa è una grande notizia!";
$GLOBALS['strSecurityKO'] = "Il tuo browser è stato in grado di recuperare alcuni file che non dovrebbero essere accessibili. Per esempio:";
$GLOBALS['strSecurityReadMore'] = "Clicca qui per trovare maggiori informazioni su come proteggere la tua installazione.";

// Encoding
$GLOBALS['strEncoding'] = "Codifica";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} adesso salva nella base dati utilizzando la codifica UTF8.<br />Quando possibile, i tuoi dati sono convertiti automaticamente.<br />Se dopo l'aggiornamento troverai qualche carattere incorretto e sai quale codifica è stata usata in pecedenza, puoi usare questo strumento per codificare i dati in UTF8";
$GLOBALS['strEncodingConvertFrom'] = "Converti da questa codifica:";
$GLOBALS['strEncodingConvertTest'] = "Prova la conversione";
$GLOBALS['strConvertThese'] = "Se continui, i seguenti dati saranno cambiati";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Ricerca aggiornamenti in corso. Attendere prego...";
$GLOBALS['strAvailableUpdates'] = "Aggiornamenti disponibili";
$GLOBALS['strDownloadZip'] = "Scarica (.zip)";
$GLOBALS['strDownloadGZip'] = "Scarica (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "E` disponibile una nuova versione di {$PRODUCT_NAME}.

Vuoi  avere maggiori informazioni
su questo aggiornamento?";
$GLOBALS['strUpdateAlertSecurity'] = "E`disponibile una nuova versione di {$PRODUCT_NAME}.

E` altamente raccomandato effettuare l`aggiornamento
quanto prima, poichè questa versione contiene uno o più aggiornamenti alla sicurezza.";

$GLOBALS['strUpdateServerDown'] = "    Per motivi sconosciuti non è possibile scaricare le informazioni<br />
	sui possibili aggiornamenti disponibili. Riprovare più tardi, grazie.";

$GLOBALS['strNoNewVersionAvailable'] = "	La tua versione di {$PRODUCT_NAME} è aggiornata. Non ci sono aggiornamenti disponibili.";

$GLOBALS['strServerCommunicationError'] = "    <b>La comunicazione con il server di aggiornamento non è riuscita, quindi al momento {$PRODUCT_NAME} non è in grado di verificare se è disponibile una nuova versione. Riprova più tardi.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Il controllo degli aggiornamenti è disattivato. Si prega di abilitarlo nelle <a href='account-settings-update.php'>impostazioni di aggiornamento</a>.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>È disponibile una nuova versione di {$PRODUCT_NAME}.</b><br /> È consigliato effettuare l\\'aggiornamento,
	poiché potrebbe correggere alcuni porblemi esistenti e aggiungerà nuove potenzialità. Per maggiori
	informazioni sull\\'aggiornamento leggere la documentazione incluse nei file qui sotto.";

$GLOBALS['strSecurityUpdate'] = "	<b>È vivamente consigliato installare questo aggiornamento al più presto possibile, poiché contine alcuni
	aggiornamenti alla sicurezza.</b> La versione di {$PRODUCT_NAME} utilizzata al momento potrebbe essere
	vulnerabile ad alcuni attacchi e probabilmente non è sicura. Per maggiori
	informazioni sull\\'aggiornamento leggere la documentazione incluse nei file qui sotto.";

$GLOBALS['strNotAbleToCheck'] = "	<b>{$PRODUCT_NAME} non è in grado di controllare se ci sono nuove versioni,
	poiché l\\'estensione XML non è disponibile su questo server .</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Per sapere se è disponibile una versione più recente, collegati al nostro sito.";

$GLOBALS['strClickToVisitWebsite'] = "Clicca qui per visitare il nostro sito";
$GLOBALS['strCurrentlyUsing'] = "Attualmente stai utilizzando";
$GLOBALS['strRunningOn'] = "in esecuzione su";
$GLOBALS['strAndPlain'] = "e";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Regole Di Consegna";
$GLOBALS['strAllBannerChannelCompiled'] = "Tutti i valori della regola di consegna compilati di banner/delivery sono stati ricompilati";
$GLOBALS['strBannerChannelResult'] = "Ecco i risultati della validazione della regola di consegna di banner/set compilata";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Tutte le regole di consegna compilate per i set di regole di consegna sono valide";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Tutte le regole di consegna compilate per i banner sono valide";
$GLOBALS['strErrorsFound'] = "Sono stati rilevati degli errori";
$GLOBALS['strRepairCompiledLimitations'] = "Sono state trovate alcune inconsistenze, puoi ripararle usando il bottone seguente. Ricompilerai la limitazione banner / canale nel sistema<br />";
$GLOBALS['strRecompile'] = "Ricompila";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "In alcune circostanze il motore di consegna può non essere d'accordo con le regole di consegna memorizzate per i banner e i set di regole di consegna, utilizzare il link di ripiegamento per convalidare le regole di consegna nel database";
$GLOBALS['strCheckACLs'] = "Controlla le regole di consegna";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "In alcune circostanze il motore di distribuzione è in disaccordo con i codici accodati. Usa il seguente collegamento per convalidare nel database i codici accodati.";
$GLOBALS['strCheckAppendCodes'] = "Controlla i codici accodati";
$GLOBALS['strAppendCodesRecompiled'] = "Tutti i codici accodati sono stati ricalcolati";
$GLOBALS['strAppendCodesResult'] = "Ecco i risultati di convalida dei codici accodati";
$GLOBALS['strAppendCodesValid'] = "Tutti i codici accodati sono validi";
$GLOBALS['strRepairAppenedCodes'] = "Sono state trovate alcune inconsistenze, puoi ripararle usando il bottone seguente. Ricompilerai i codici accodati per ogni tracker del sistema";

$GLOBALS['strPlugins'] = "Plugin";
$GLOBALS['strPluginsPrecis'] = "Diagnostica e ripara i problemi con i plugin di {$PRODUCT_NAME}";

$GLOBALS['strMenus'] = "Menu";
$GLOBALS['strMenusPrecis'] = "Ricostruisci la cache dei menu";
$GLOBALS['strMenusCachedOk'] = "La cache dei menù è stata ricostruita";

// Users
$GLOBALS['strUserPasswords'] = "Password utente";
$GLOBALS['strUserPasswordsExplaination'] = "A partire dalla versione 5.4, {$PRODUCT_NAME} memorizza le password in un formato più sicuro.
Usa questo strumento per controllare se alcuni utenti hanno ancora password memorizzate nel vecchio formato, e per inviare agli utenti selezionati un'email che consenta loro di inserire una nuova password.
Lo strumento può anche essere usato per ricordare ai nuovi utenti che dovrebbero impostare la loro prima password.";
$GLOBALS['strCheckUserPasswords'] = "Controlla password utente";
$GLOBALS['strUserPasswordsEverythingOK'] = "Nessun utente richiede un reset della password, tutto va bene.";
$GLOBALS['strUserPasswordsEmailsSent'] = "Le email per gli utenti che hai selezionato sono state inviate.";
