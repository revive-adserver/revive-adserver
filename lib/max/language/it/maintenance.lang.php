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

// Main strings
$GLOBALS['strChooseSection']			= "Scgli sezione";


// Priority
$GLOBALS['strRecalculatePriority']		= "Ricalcola la priorità";
$GLOBALS['strHighPriorityCampaigns']		= "Campagne con Priorità Alta";
$GLOBALS['strAdViewsAssigned']			= "Visualizzazioni assegnate";
$GLOBALS['strLowPriorityCampaigns']		= "Campagne con Priorità Bassa";
$GLOBALS['strPredictedAdViews']			= "Visualizzazioni previste";
$GLOBALS['strPriorityDaysRunning']		= "Ci sono {days} giorni di statistiche disponibili su cui ".$phpAds_productname." può basare le proprie previsioni. ";
$GLOBALS['strPriorityBasedLastWeek']		= "La previsione è basata sui dati della settimana scorsa e di quella attuale. ";
$GLOBALS['strPriorityBasedLastDays']		= "La previsione è basata solo sui dati degli ultimi giorni. ";
$GLOBALS['strPriorityBasedYesterday']		= "La previsione è basata solo sui dati si ieri. ";
$GLOBALS['strPriorityNoData']			= "Non ci sono abbastanza dati per fornire una previsione affidabile sul numero di visualizzazioni che il server genererà oggi. L'assegnamento delle priorità sarà basato solo sulle statistiche generate in tempo reale. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Dovrebbero esserci abbastanza Visualizzazioni per soddisfare completamente gli obiettivi di tutte le campagne ad alta priorità. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Non è chiaro se oggi ci saranno AdViews abbastanza Visualizzazioni per soddisfare completamente gli obiettivi delle campagne ad alta priorità. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Ricostruisci cache dei banner";
$GLOBALS['strBannerCacheExplaination']		= "\nLa cache dei banner contiene una copia del codice HTML usato per visualizzare il banner. Usando la cache è possibile velocizzare\nla fornitura dei banner, poiché che il codice HTML non deve essere generato tutte le volte che il banner viene richiamato.\nDal momento che la cache dei banner l\'URL della posizione di OpenX e dei banner in forma codificata, la cache deve\nessere aggiornata qualora OpenX venga spostato ad un altro indirizzo sul server web.\n";


// Cache
$GLOBALS['strCache']			= "Cache di consegna";
$GLOBALS['strAge']				= "Età";
$GLOBALS['strRebuildDeliveryCache']			= "Ricostruisci la cache di consegna";
$GLOBALS['strDeliveryCacheExplaination']		= "\n	La cache di consegna è usata per velocizzare la fornitura dei banner. La cache contiene una copia di tutti i\n	banner collegati a una zona e permette di evitare l'esecuzione di molte query al database quando il banner viene richiamato. Normalmente la cache\n	è ricostruita ogni volta che si effettua una modifica alla zone o ad uno dei suoi banner, ma è possibile che essa diventi\n	obsoleta. Per questo motivo la cache viene automaticamente ricostruita ogni ora, tuttavia è anche possibile forzare il processo manualmente.\n";
$GLOBALS['strDeliveryCacheSharedMem']		= "\n	Per memorizzare la cache di consegna è utilizzata la memoria condivisa.\n";
$GLOBALS['strDeliveryCacheDatabase']		= "\n	Per memorizzare la cache di consegna si sta utilizzando il database.\n";
$GLOBALS['strDeliveryCacheFiles']		= "\n	Per memorizzare la cache di consegna sono utilizzati dei file sul server.\n";


// Storage
$GLOBALS['strStorage']				= "Memorizzazione";
$GLOBALS['strMoveToDirectory']			= "Sposta le immagini memorizzate nel database in una cartella";
$GLOBALS['strStorageExplaination']		= "\nLe immagini utilizzate nei banner locali vengono memorizzate nel database o in una directory sul server web. Memorizzare\nle immagini in una directory riduce il carico di lavoro eseguito dal database e, di conseguenza, aumenta la velocità\ndel sistema.\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\n	Hai abilitato il <i>formato compatto</i> delle statistiche, ma le vecchie statistiche sono ancora nel formato esteso.\n	Vuoi convertire le statistiche estese nel nuovo formato compatto?\n";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Ricerca aggiornamenti in corso. Attendere prego...";
$GLOBALS['strAvailableUpdates']			= "Aggiornamenti disponibili";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "E` disponibile una nuova versione di ". MAX_PRODUCT_NAME .".          \n\nVuoi  avere maggiori informazioni \nsu questo aggiornamento?";
$GLOBALS['strUpdateAlertSecurity']		= "E`disponibile una nuova versione di ". MAX_PRODUCT_NAME .".          \n\nE` altamente raccomandato effettuare l`aggiornamento\nquanto prima, poichè questa versione contiene uno o più aggiornamenti alla sicurezza.";

$GLOBALS['strUpdateServerDown']			= "\n    Per motivi sconosciuti non è possibile scaricare le informazioni<br />\n	sui possibili aggiornamenti disponibili. Riprovare più tardi, grazie.\n";

$GLOBALS['strNoNewVersionAvailable']		= "\n	La tua versione di ". MAX_PRODUCT_NAME ." è aggiornata. Non ci sono aggiornamenti disponibili.\n";

$GLOBALS['strNewVersionAvailable']		= "\n	<b>È disponibile una nuova versione di ". MAX_PRODUCT_NAME .".</b><br /> È consigliato effettuare l\'aggiornamento,\n	poiché potrebbe correggere alcuni porblemi esistenti e aggiungerà nuove potenzialità. Per maggiori\n	informazioni sull\'aggiornamento leggere la documentazione incluse nei file qui sotto. \n";

$GLOBALS['strSecurityUpdate']			= "\n	<b>È vivamente consigliato installare questo aggiornamento al più presto possibile, poiché contine alcuni\n	aggiornamenti alla sicurezza.</b> La versione di ". MAX_PRODUCT_NAME ." utilizzata al momento potrebbe essere\n	vulnerabile ad alcuni attacchi e probabilmente non è sicura. Per maggiori\n	informazioni sull\'aggiornamento leggere la documentazione incluse nei file qui sotto. \n";

$GLOBALS['strNotAbleToCheck']			= "\n	<b>". MAX_PRODUCT_NAME ." non è in grado di controllare se ci sono nuove versioni,\n	poiché l\'estensione XML non è disponibile su questo server .</b>\n";

$GLOBALS['strForUpdatesLookOnWebsite']	= "\n	Per sapere se è disponibile una versione più recente, collegati al nostro sito.\n";

$GLOBALS['strClickToVisitWebsite']		= "Clicca qui per visitare il nostro sito";
$GLOBALS['strCurrentlyUsing'] 			= "Attualmente stai utilizzando";
$GLOBALS['strRunningOn']				= "in esecuzione su";
$GLOBALS['strAndPlain']					= "e";


// Stats conversion
$GLOBALS['strConverting']			= "Conversione";
$GLOBALS['strConvertingStats']			= "Conversione statistiche...";
$GLOBALS['strConvertStats']			= "Converti statistiche";
$GLOBALS['strConvertAdViews']			= "Visualizzazioni convertite,";
$GLOBALS['strConvertAdClicks']			= "Click convertiti...";
$GLOBALS['strConvertNothing']			= "Niente da convertire...";
$GLOBALS['strConvertFinished']			= "Operazione terminata...";

$GLOBALS['strConvertExplaination']		= "\n	Stai utilizzando il formato compatto delle statistiche, ma ci sono ancora alcune <br />\n	statistiche nel formato dettagliato. Finché le statistiche dettagliare non <br />\n	saranno convertite nel formato compatto, esse non verranno utilizzate.  <br />\n	Prima di convertire le statistiche, esegui un backup del database!  <br />\n	Vuoi convertire le statistiche dettagliate nel nuovo formato compatto? <br />\n";

$GLOBALS['strConvertingExplaination']		= "\n	Tutte le statistiche dettagliate verranno ora convertite nel formato compatto. <br />\n	La durata del processo dipende dal numero di visualizzazioni registrate, e potrà <br />\n	durare alcuni minuti. Attendi il completamento della conversione prima di visitare <br />\n	altre pagine. Qui sotto vedrai il registro delle modifiche fatte al database. <br />\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	La conversione delle restanti statistiche dettagliate è stata completata <br />\n	con successo e 	i dati sono nuovamente disponibili. Qui sotto vedrai il registro\n	delle modifiche fatte al database. <br />\n";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "Controlla la cache dei banner";
$GLOBALS['strBannerCacheErrorsFound'] = "La cache dei banner nel database ha riscontrato qualche errore. Questi banner non funzioneranno finchè non correggerai manualmente gli errori riscontrati.";
$GLOBALS['strBannerCacheOK'] = "Non sono stati rilevati errori. La cache dei banner nel database è stata aggiornata.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Il controllo della cache dei banner del database ha trovato che la cache non è aggiornata e deve essere ricalcolata. Clicca qui per aggiornare automaticamente la cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Ricostruisci";
$GLOBALS['strBannerCacheFixed'] = "La ricostruzione della cache dei banner nel catabase è stata completata con successo. La tua cache del database è ora aggiornata.";
$GLOBALS['strEncoding'] = "Codifica";
$GLOBALS['strEncodingExplaination'] = "". MAX_PRODUCT_NAME ." adesso salva nella base dati utilizzando la codifica UTF8.<br />Quando possibile, i tuoi dati sono convertiti automaticamente.<br />Se dopo l'aggiornamento troverai qualche carattere incorretto e sai quale codifica è stata usata in pecedenza, puoi usare questo strumento per codificare i dati in UTF8";
$GLOBALS['strEncodingConvertFrom'] = "Converti da questa codifica:";
$GLOBALS['strEncodingConvert'] = "Converti";
$GLOBALS['strEncodingConvertTest'] = "Prova la conversione";
$GLOBALS['strConvertThese'] = "Se continui, i seguenti dati saranno cambiati";
$GLOBALS['strAppendCodes'] = "Accoda i codici";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<strong>La manutenzione programmata non è stata eseguita nell'ultima ora. Potrebbe darsi che non sia stata configurata correttamente.</strong>";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "La manutenzione automatica è abilitata ma non è stata eseguita. Viene eseguita soltanto quando ". MAX_PRODUCT_NAME ." spedisce dei banner. Per ottenere le performance migliori dovresti impostare la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>manutenzione programmata</a>.";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "La manutenzione automatica è disabilitata. Quando ". MAX_PRODUCT_NAME ." distribuisce i banner non sarà eseguita. Per ottenere le performance migliori dovresti impostare la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>manutenzione programmata</a>. Se non vuoi farlo adesso, allora <em>devi</em> attivare la <a href='account-settings-maintenance.php'>manutenzione automatica</a> per assicurarti che ". MAX_PRODUCT_NAME ." funzioni correttamente.'";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "La manutenzione automatica è abilitata e sarà eseguita quando richiesto, mentre ". MAX_PRODUCT_NAME ." spedisce i banner. Per ottenere le migliori prestazioni dovresti impostare la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>manutenzione progammata</a>.";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "La manutenzione automatica è stata recentemente disabilitata. Per assicurarsi che ". MAX_PRODUCT_NAME ." funzioni correttamente, dovresti impostare la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>manutenzione programmata</a> oppure <a href='account-settings-maintenance.php'>attivare nuovamente la manutenzione automatica</a>.<br><br>Per ottenere le performance migliori dovresti impostare la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>manutenzione programmata</a>.";
$GLOBALS['strScheduledMantenaceRunning'] = "<strong>La manutenzione programmata funziona correttamente.</strong>";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "<strong>La manutenzione automatica funziona correttamente</strong>";
$GLOBALS['strAutoMantenaceEnabled'] = "La manutenzione automatica rimane funzionante. Per ottenere le performance migliori dovresti <a href='account-settings-maintenance.php'>disabilitare la manutenzione automatica</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "La manutenzione automatica è disabilitata.";
$GLOBALS['strAutoMaintenanceEnabled'] = "La manutenzione automatica è abilitata. Per ottenere le performance migliori ti consigliamo di <a href='settings-admin.php'>disabilitare la manutenzione automatica</a>.";
$GLOBALS['strCheckACLs'] = "Controlla la lista di controllo degli accessi";
$GLOBALS['strScheduledMaintenance'] = "La manutenzione programmata sembra essere pianificata correttamente.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "La manutenzione automatica è abilitata, ma non è stata eseguita. Nota bene: la manutenzione automatica viene eseguita soltanto quando ". MAX_PRODUCT_NAME ." spedisce banner.";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "Per ottenere le performance migliori ti consigliamo di impostare la <a href='". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>manutenzione programmata</a>";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "La manutenzione automatica è abilitata e sarà eseguita circa ogni ora.";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "Anche la manutenzione automatica è stata disabilitata ma un lavoro di manutenzione è stato eseguito recentemente. Per assicurarti che ". MAX_PRODUCT_NAME ." funzioni correttamente dovresti impostare la <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>manutenzione programmata</a> oppure la <a href='settings-admin.php'>manutenzione automatica</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "Anche la manutenzione automatica è stata disabilitata, quindi quando ". MAX_PRODUCT_NAME ." spedisce banner, la manutenzione non viene eseguita. Se non intendi pianificare alcuna <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>manutenzione programmata</a>, devi <a href='settings-admin.php'>abilitare la manutenzione automatica</a> per assicurarti che ". MAX_PRODUCT_NAME ." funzioni correttamente.";
$GLOBALS['strAllBannerChannelCompiled'] = "Sono stati ricompilati tutti i valori compilati di limitazioni banner / canale.";
$GLOBALS['strBannerChannelResult'] = "Seguono i risultati della validazione delle limitazioni banner/canale";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Tutte le limitazioni compilate del canale sono valide";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Tutte le limitazioni compilate del banner sono valide";
$GLOBALS['strErrorsFound'] = "Sono stati rilevati degli errori";
$GLOBALS['strRepairCompiledLimitations'] = "Sono state trovate alcune inconsistenze, puoi ripararle usando il bottone seguente. Ricompilerai la limitazione banner / canale nel sistema<br />";
$GLOBALS['strRecompile'] = "Ricompila";
$GLOBALS['strAppendCodesDesc'] = "In alcune circostanze il motore di distribuzione è in disaccordo con i codici accodati. Usa il seguente collegamento per convalidare nel database i codici accodati.";
$GLOBALS['strCheckAppendCodes'] = "Controlla i codici accodati";
$GLOBALS['strAppendCodesRecompiled'] = "Tutti i codici accodati sono stati ricalcolati";
$GLOBALS['strAppendCodesResult'] = "Ecco i risultati di convalida dei codici accodati";
$GLOBALS['strAppendCodesValid'] = "Tutti i codici accodati sono validi";
$GLOBALS['strRepairAppenedCodes'] = "Sono state trovate alcune inconsistenze, puoi ripararle usando il bottone seguente. Ricompilerai i codici accodati per ogni tracker del sistema";
$GLOBALS['strScheduledMaintenanceNotRun'] = "<strong>La manutenzione programmata non è stata eseguita nell'ultima ora. Potrebbe darsi che non sia stata configurata correttamente.</strong>";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "In alcune circostanze il motore di distribuzione è in disaccordo con la lista di controllo degli accessi per banner e canali. Clicca sul link sotto per convalidare la lista di controllo degli accessi.";
?>