<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* Translations byMatteo Beccati                                        */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Main strings
$GLOBALS['strChooseSection']				= "Scgli sezione";


// Priority
$GLOBALS['strRecalculatePriority']			= "Ricalcola priorit&agrave;";
$GLOBALS['strHighPriorityCampaigns']		= "Campagne con Priorit&agrave; Alta";
$GLOBALS['strAdViewsAssigned']				= "Visualizzazioni assegnate";
$GLOBALS['strLowPriorityCampaigns']			= "Campagne con Priorit&agrave; Bassa";
$GLOBALS['strPredictedAdViews']				= "Visualizzazioni previste";
$GLOBALS['strPriorityDaysRunning']			= "Ci sono {days} giorni di statistiche disponibili su cui ".$phpAds_productname." pu&ograve; basare le proprie previsioni. ";
$GLOBALS['strPriorityBasedLastWeek']		= "La previsione &egrave; basata sui dati della settimana scorsa e di quella attuale. ";
$GLOBALS['strPriorityBasedLastDays']		= "La previsione &egrave; basata solo sui dati degli ultimi giorni. ";
$GLOBALS['strPriorityBasedYesterday']		= "La previsione &egrave; basata solo sui dati si ieri. ";
$GLOBALS['strPriorityNoData']				= "Non ci sono abbastaza dati per fornire una previsione affidabile sul numero di visualizzazioni che il server generer&agrave; oggi. L'assegnamento delle priorit&agrave; sar&agrave; basato solo sulle statistiche generate in tempo reale. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Dovrebbero esserci abbastanza Visualizzazioni per soddisfare completamente gli obiettivi di tutte le campagne ad alta priorit&agrave;. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Non &egrave; chiaro se oggi ci saranno AdViews abbastanza Visualizzazioni per soddisfare completamente gli obiettivi delle campagne ad alta priorit&agrave;. Perciò tutte le campagne a bassa priorit&agrave; sono state temporaneamente disabilitate. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']			= "Ricostruisci cache dei banner";
$GLOBALS['strBannerCacheExplaination']		= "
	La cahce dei banner contiene una copia del codice HTML usto per visualizzare il banner. Usando la cache &egrave; possibile velocizzare
	la fornitura dei banner, poich&eacute; che il codice HTML non deve essere generato tutte le volte che il banner viene richiamato.
	Dal momento che la cache dei banner l'URL della posizione di ".$phpAds_productname." e dei banner in forma codificata, la cache deve
	essere aggiornata qualora ".$phpAds_productname." venga spostato ad un altro indirizzo sul server web.
";


// Zone cache
$GLOBALS['strAge']							= "Et&agrave;";
$GLOBALS['strRebuildZoneCache']				= "Ricostruisci la cache delle zone";
$GLOBALS['strZoneCacheExplaination']		= "
	La cache delle zone &egrave; usata per velocizzare la fornitura dei banner collegati alle zone. La cache contiene una copia di tutti i
	banner collegati e permette di evitare l'esecuzione di molte query al database quando il banner viene richiamato. Normalmente la cache
	&egrave; ricostruita ogni volta che si effettua una modifica alla zone o ad uno dei suoi banner, ma &egrave; possibile che essa diventi
	obsoleta. Per questo motivo la cache viene automaticamente ricostruita ogni {seconds} secondi, ma &egrave; anche possibile forzare il processo manualmente.
";


// Storage
$GLOBALS['strStorage']						= "Memorizzazione";
$GLOBALS['strMoveToDirectory']				= "Sposta le immagini memorizzate nel database sul server web";
$GLOBALS['strStorageExplaination']			= "
	Le immagini utilizzate nei banner locali vengono memorizzate nel database o in una directory sul server web. Memorizzare
	le immagini in una directory riduce il carico di lavoro eseguito dal database e, di conseguenza, aumenta la velocit&agrave;
	del sistema.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Hai abilitato il <i>formato compatto</i> delle statistiche, ma le vecchie statistiche sono ancora nel formato esteso.
	Vuoi convertire le statistiche estese nel nuovo formato compatto?
";


// Product Updates
$GLOBALS['strSearchingUpdates']				= "Ricerca aggiornamenti in corso. Attendere prego...";
$GLOBALS['strAvailableUpdates']				= "Aggiornamenti disponibili";
$GLOBALS['strDownloadZip']					= "Download (.zip)";
$GLOBALS['strDownloadGZip']					= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']					= "E\' disponibile una nuova versione di ".$phpAds_productname.".          \\n\\nVuoi  avere maggiori informazioni \\nsu questo aggiornamento?";
$GLOBALS['strUpdateAlertSecurity']			= "E\' disponibile una nuova versione di ".$phpAds_productname.".          \\n\\nE\' consigliato effettuare l\' aggiornamento\\nquanto prima, poiché questa versione contiene uno o più aggiornamenti alla sicurezza.";

$GLOBALS['strUpdateServerDown']				= "
    Per motivi sconosciuti non &egrave; possibile scaricare le informazioni<br>
	sui possibili aggiornamenti. Riprovare pi&ugrave; tardi, grazie.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	La tua versione di ".$phpAds_productname." &agrave; aggiornata. Non ci sono aggiornamenti disponibili.
";

$GLOBALS['strNewVersionAvailable']			= "
	<b>&Egrave; disponibile una nuova versione di ".$phpAds_productname.".</b><br> &Egrave; consigliato effettuare l'aggiornamento,
	poich&eacute; potrebbe correggere alcuni porblemi esistenti e aggiunger&agrave; nuove potenzialit&agrave;. Per maggiori
	informazioni sull'aggiornamento leggere la documentazione incluse nei file qui sotto. 
";

$GLOBALS['strSecurityUpdate']				= "
	<b>&Egrave; vivamente consigliato installare questo aggiornamento al più presto possibile, poich&eacute; contine alcuni
	aggiornamenti alla sicurezza.</b> La versione di ".$phpAds_productname." utilizzata al momento potrebbe essere
	vulnerabile ad alcuni attacchi e probabilmente non &egrave; sicura. Per maggiori
	informazioni sull'aggiornamento leggere la documentazione incluse nei file qui sotto. 
";
?>