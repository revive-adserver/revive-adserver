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
$GLOBALS['strRecalculatePriority']		= "Ricalcola priorit&agrave;";
$GLOBALS['strHighPriorityCampaigns']		= "Campagne con Priorit&agrave; Alta";
$GLOBALS['strAdViewsAssigned']			= "Visualizzazioni assegnate";
$GLOBALS['strLowPriorityCampaigns']		= "Campagne con Priorit&agrave; Bassa";
$GLOBALS['strPredictedAdViews']			= "Visualizzazioni previste";
$GLOBALS['strPriorityDaysRunning']		= "Ci sono {days} giorni di statistiche disponibili su cui ".$phpAds_productname." pu&ograve; basare le proprie previsioni. ";
$GLOBALS['strPriorityBasedLastWeek']		= "La previsione &egrave; basata sui dati della settimana scorsa e di quella attuale. ";
$GLOBALS['strPriorityBasedLastDays']		= "La previsione &egrave; basata solo sui dati degli ultimi giorni. ";
$GLOBALS['strPriorityBasedYesterday']		= "La previsione &egrave; basata solo sui dati si ieri. ";
$GLOBALS['strPriorityNoData']			= "Non ci sono abbastanza dati per fornire una previsione affidabile sul numero di visualizzazioni che il server generer&agrave; oggi. L'assegnamento delle priorit&agrave; sar&agrave; basato solo sulle statistiche generate in tempo reale. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Dovrebbero esserci abbastanza Visualizzazioni per soddisfare completamente gli obiettivi di tutte le campagne ad alta priorit&agrave;. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Non &egrave; chiaro se oggi ci saranno AdViews abbastanza Visualizzazioni per soddisfare completamente gli obiettivi delle campagne ad alta priorit&agrave;. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Ricostruisci cache dei banner";
$GLOBALS['strBannerCacheExplaination']		= "
	La cahce dei banner contiene una copia del codice HTML usto per visualizzare il banner. Usando la cache &egrave; possibile velocizzare
	la fornitura dei banner, poich&eacute; che il codice HTML non deve essere generato tutte le volte che il banner viene richiamato.
	Dal momento che la cache dei banner l'URL della posizione di ".$phpAds_productname." e dei banner in forma codificata, la cache deve
	essere aggiornata qualora ".$phpAds_productname." venga spostato ad un altro indirizzo sul server web.
";


// Cache
$GLOBALS['strCache']			= "Cache di consegna";
$GLOBALS['strAge']				= "Et&agrave;";
$GLOBALS['strRebuildDeliveryCache']			= "Ricostruisci la cache di consegna";
$GLOBALS['strDeliveryCacheExplaination']		= "
	La cache di consegna &egrave; usata per velocizzare la fornitura dei banner. La cache contiene una copia di tutti i
	banner collegati a una zona e permette di evitare l'esecuzione di molte query al database quando il banner viene richiamato. Normalmente la cache
	&egrave; ricostruita ogni volta che si effettua una modifica alla zone o ad uno dei suoi banner, ma &egrave; possibile che essa diventi
	obsoleta. Per questo motivo la cache viene automaticamente ricostruita ogni ora, tuttavia &egrave; anche possibile forzare il processo manualmente.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Per memorizzare la cache di consegna &egrave; utilizzata la memoria condivisa.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	Per memorizzare la cache di consegna &egrave; utilizzato il database.
";
$GLOBALS['strDeliveryCacheFiles']		= "
	Per memorizzare la cache di consegna sono utilizzati dei file sul server.
";


// Storage
$GLOBALS['strStorage']				= "Memorizzazione";
$GLOBALS['strMoveToDirectory']			= "Sposta le immagini memorizzate nel database sul server web";
$GLOBALS['strStorageExplaination']		= "
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
$GLOBALS['strSearchingUpdates']			= "Ricerca aggiornamenti in corso. Attendere prego...";
$GLOBALS['strAvailableUpdates']			= "Aggiornamenti disponibili";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "E\' disponibile una nuova versione di ".$phpAds_productname.".          \\n\\nVuoi  avere maggiori informazioni \\nsu questo aggiornamento?";
$GLOBALS['strUpdateAlertSecurity']		= "E\' disponibile una nuova versione di ".$phpAds_productname.".          \\n\\nE\' consigliato effettuare l\' aggiornamento\\nquanto prima, poich� questa versione contiene uno o pi� aggiornamenti alla sicurezza.";

$GLOBALS['strUpdateServerDown']			= "
    Per motivi sconosciuti non &egrave; possibile scaricare le informazioni<br />
	sui possibili aggiornamenti. Riprovare pi&ugrave; tardi, grazie.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	La tua versione di ".$phpAds_productname." &agrave; aggiornata. Non ci sono aggiornamenti disponibili.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>&Egrave; disponibile una nuova versione di ".$phpAds_productname.".</b><br /> &Egrave; consigliato effettuare l'aggiornamento,
	poich&eacute; potrebbe correggere alcuni porblemi esistenti e aggiunger&agrave; nuove potenzialit&agrave;. Per maggiori
	informazioni sull'aggiornamento leggere la documentazione incluse nei file qui sotto. 
";

$GLOBALS['strSecurityUpdate']			= "
	<b>&Egrave; vivamente consigliato installare questo aggiornamento al pi� presto possibile, poich&eacute; contine alcuni
	aggiornamenti alla sicurezza.</b> La versione di ".$phpAds_productname." utilizzata al momento potrebbe essere
	vulnerabile ad alcuni attacchi e probabilmente non &egrave; sicura. Per maggiori
	informazioni sull'aggiornamento leggere la documentazione incluse nei file qui sotto. 
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>".$phpAds_productname." non &egrave; in grado di controllare se ci sono nuove versioni,
	poich&eacute; l'estensione XML non &egrave; disponibile su questo server .</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	Per sapere se c'&egrave; una versione pi&ugrave; recente, collegati al nostro sito.
";

$GLOBALS['strClickToVisitWebsite']		= "Clicca qui per visitare il nostro sito";
$GLOBALS['strCurrentlyUsing'] 			= "Stai utilizzando";
$GLOBALS['strRunningOn']				= "su";
$GLOBALS['strAndPlain']					= "e";


// Stats conversion
$GLOBALS['strConverting']			= "Conversione";
$GLOBALS['strConvertingStats']			= "Conversione statistiche...";
$GLOBALS['strConvertStats']			= "Converti statistiche";
$GLOBALS['strConvertAdViews']			= "Visualizzazioni convertite,";
$GLOBALS['strConvertAdClicks']			= "Click convertiti...";
$GLOBALS['strConvertNothing']			= "Niente da convertire...";
$GLOBALS['strConvertFinished']			= "Operazione terminata...";

$GLOBALS['strConvertExplaination']		= "
	Stai utilizzando il formato compatto delle statistiche, ma ci sono ancora alcune <br />
	statistiche nel formato dettagliato. Finch&eacute; le statistiche dettagliare non <br />
	saranno convertite nel formato compatto, esse non verranno utilizzate.  <br />
	Prima di convertire le statistiche, esegui un backup del database!  <br />
	Vuoi convertire le statistiche dettagliate nel nuovo formato compatto? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Tutte le statistiche dettagliate verranno ora convertite nel formato compatto. <br />
	La durata del processo dipende dal numero di visualizzazioni registrate, e potr&agrave; <br />
	durare alcuni minuti. Attendi il completamento della conversione prima di visitare <br />
	altre pagine. Qui sotto vedrai il registro delle modifiche fatte al database. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	La conversione delle restanti statistiche dettagliate &egrave; stata completata <br />
	con successo e 	i dati sono nuovamente disponibili. Qui sotto vedrai il registro
	delle modifiche fatte al database. <br />
";

?>