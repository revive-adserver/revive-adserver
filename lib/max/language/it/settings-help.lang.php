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

// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
        Specifica l'hostname del server ".$phpAds_dbmsname." al quale ".$phpAds_productname." si deve connettere.
		";

$GLOBALS['phpAds_hlp_dbport'] = "
        Specifica il numero della porta del server ".$phpAds_dbmsname." al quale ".$phpAds_productname." si deve
		connettere. La porta di default di ".$phpAds_dbmsname." è la <i>".
		($phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>.
		";

$GLOBALS['phpAds_hlp_dbuser'] = "
        Specifica il nome utente che ".$phpAds_productname." deve utilizzare per connettersi al server ".$phpAds_dbmsname.".
		";

$GLOBALS['phpAds_hlp_dbpassword'] = "
        Specifica la password che ".$phpAds_productname." deve utilizzare per connettersi al server ".$phpAds_dbmsname.".
		";

$GLOBALS['phpAds_hlp_dbname'] = "
        Specifica il nome del database dove ".$phpAds_productname." deve salvare i dati.
		È importante che il database sia già stato creato sul server. ".$phpAds_productname." <b>non</b> creerà
		il database se non esiste.
		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "
        L'utilizzo delle connessioni persistenti può velocizzare considerevolmente ".$phpAds_productname."
		e può anche diminuire il carico di lavoro del server. C'è però una controindicazione:
		nei siti con molti visitatori il carico del server potrebbe aumentare anziché diminuire.
		La scelta sull'eventuale impiego delle connessioni persistenti deve perciò tenere conto del numero
		di visitatori e dell'hardware utilizzato. Se ".$phpAds_productname." consume troppe risorse, potrebbe essere
		necessario modificare questa impostazione.
		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "
		Se si verificano problemi di integrazione di ".$phpAds_productname." con altri prodotti di terze parti
		potrebbe essere utile attivare la compatibilità. Utilizzando la modalità di invocazione
		locale e la compatibilità è attiva, ".$phpAds_productname." non dovrebbe alterare lo stato
		della connessione al database dopo l'uso di ".$phpAds_productname.". Questa opzione produce un (seppur minimo)
		rallentamento ed è perciò disabilitata di default.
		";

$GLOBALS['phpAds_hlp_table_prefix'] = "
		Se il database utilizzato da ".$phpAds_productname." è condiviso con altri prodotti software
		è consigiabile utilizzare un prefisso per i nomi delle tabelle. Se più installazioni
		di ".$phpAds_productname." condividono lo stesso database, assicurati che i prefissi siano differenti.
		";

$GLOBALS['phpAds_hlp_table_type'] = "
		".$phpAds_dbmsname." supporta differenti tipi di tabelle. Ognuno ha le proprie caratteristiche ed
		alcuni possono velocizzare considerevolmente ".$phpAds_productname.". MyISAM è il tipo
		utilizzato di default ed è disponibile in tutte le installazioni di ".$phpAds_dbmsname.".
		Gli altri potrebbero non essere sempre disponibili.
		";

$GLOBALS['phpAds_hlp_url_prefix'] = "
		".$phpAds_productname." necessita di sapere il proprio indirizzo sul server web per poter
		funzionare correttamente. Devi specificare l'URL della directory dove ".$phpAds_productname."
		è stato installato, per esempio: <i>http://www.tuo-url.com/".$phpAds_productname."</i>.
		";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
		Qui si possono inserire gli indirizzi dei file (p.es. /home/login/www/header.htm)
		da utilizzare come intestazione e pié di pagina nelle pagine di amministrazione.
		Si possono utilizzare sia file di testo che html (questi ultimi non devono contenere tag
		<body> o <html>).
		";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		Abilitando la compressione GZIP dei contenuti si otterrà una grande diminuzione
		dei dei inviati al browser ogni volta che si utilizza l'interfaccia di amministrazione.
		Per abilitare questa caratteristica è necessario avere almeno PHP 4.0.5 con
		l'estensione GZIP installata.
		";

$GLOBALS['phpAds_hlp_language'] = "
		Specifica la lingua utilizzata di default da ".$phpAds_productname.". Questa verrà
		usata nelle interfaccia amministratore e inserzionista. Nota Bene: è comunque possibile
		specificare una lingua diversa per ogni inserzionista ed anche permettere loro di
		modificare la propria.
		";

$GLOBALS['phpAds_hlp_name'] = "
		Specifica il nome da utilizzare per questa applicazione. Questa stringa sarà
		visuallizzata in tutte le pagine dell'interfaccia utente. Se non viene specificato (stringa
		vuota) verrà mostrato il logo di ".$phpAds_productname.".
		";

$GLOBALS['phpAds_hlp_company_name'] = "
		Questo è il nome che ".$phpAds_productname." utilizza nella spedizione delle e-mail.
		";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
        ".$phpAds_productname." usually detects if the GD library is installed and which image
        format is supported by the installed version of GD. However it is possible
        the detection is not accurate or false, some versions of PHP do not allow
        the detection of the supported image formats. If ".$phpAds_productname." fails to auto-detect
        the right image format you can specify the right image format. Possible
        values are: none, png, jpeg, gif.
		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "
		Per utilizzare le funzioni P3P Privacy Policies di ".$phpAds_productname." questa opzione deve
		essere attivata.
		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
		La policy compatta inviata assieme ai cookie. L'impostazione di default è:
        'CUR ADM OUR NOR STA NID', che permette ad Internet Explorer 6 di accettare i cookie inviati
		da ".$phpAds_productname.". Volendo queste impostazioni si possono modificare in base alla
		propria informativa sulla privacy.
		";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
		Per utilizzare una policy completa sulla privacy, specificare qui l'indirizzo.
		";

$GLOBALS['phpAds_hlp_compact_stats'] = "
		Tradizionalmente ".$phpAds_productname." utilizzava un metodo di registrazione delle visualizzazioni
		e dei click molto dettagliato, ma anche molto esigente in termini di risorse per il database. Questo
		poteva essere un problema per siti con molti visitatori. Per superare questo problema
		".$phpAds_productname." supporta anche un nuovo tipo di statistiche, detto compatto, che è
		sì meno pesante per il database, ma anche meno dettagliato, in quanto non registra
		gli host. Se quest'ultima caratteristica è necessaria disabilitare questa optzione.
		";

$GLOBALS['phpAds_hlp_log_adviews'] = "
		Normalmente tutte le Visualizzazioni sono registrate; se non vuoi raccogliere statistiche
		sulle Visualizzazioni disattiva questa opzione.
		";

$GLOBALS['phpAds_hlp_block_adviews'] = "
		Se un visitatore ricarica una pagina, ".$phpAds_productname." registrerà ogni volta
		una Visualizzazione. Questa funzione è utile per assicurarsi che sia registrata solo
		una Visualizzazione per ogni banner differente nell'intervallo di secondi specificato. Ad
		esempio, se questo valore è impostato a 300 secondi, ".$phpAds_productname." registrerà
		una Visualizzazione solo se un banner non è già stato mostrato allo stesso
		visitatore negli ultimi 5 minuti. Questa opzione funziona solo se il browser accetta i cookie.
		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "
		Normalmente tutti i Click sono registrate; se non vuoi raccogliere statistiche
		sui Click disattiva questa opzione.
        Normally all AdClicks are logged, if you don't want to gather statistics
        about AdClicks you can turn this off.
		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Se un visitatore clicca più volte su un banner ".$phpAds_productname." registrerà
		ogni volta un Click. Questa funzione è utile per assicurarsi che sia registrata solo
		un Click per ogni banner differente nell'intervallo di secondi specificato. Ad
		esempio, se questo valore è impostato a 300 secondi, ".$phpAds_productname." registrerà
		un Click solo se un banner non è già stato cliccato dallo stesso
		visitatore negli ultimi 5 minuti. Questa opzione funziona solo se il browser accetta i cookie.
		";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		Se utilizzi un database per il tracking geografico, è possibile memorizzare anche
		le informazioni geografiche nel database. Così facendo sarà  possibile vedere la
		nazionalità dei visitatori e le statistiche suddivise per nazione.
		Questa opzione è disponibile solo utilizzando le statistiche estese.
		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		L'hostname è normalmente determinato dal server web, ma in alcuni casi questa
		funzionalità potrebbe essere disabilitata. Se il server non fornisce questa
		indicazione, per poter utilizzare l'hostname dei visitatori all'interno di limitazioni
		di consegna e/o memorizzarlo nelle statistiche, è necessario abilitare questa
		opzione. Determinare l'hostname dei visitatori occupa un po' di tempo, perciò
		la consegna dei banner sarà più lenta.
		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Alcuni visitatori utilizzano un server proxy per accedere a Internet. In questo caso
		".$phpAds_productname." registrerà l'indirizzo IP o il nome dell'host del
		server proxy invece di quelli del visitatore. Se questa opzione è abilitata
		".$phpAds_productname." cercherà di risalire all'indirizzo reale
		del computer del visitatore dietro al proxy. Se questo non sarà possibile, verrà
		memorizzato l'indirizzo del server proxy. Questa opzione non è
		abilitata di default poiché rallenta considerevolmente la registrazione
		delle Visualizzazioni e dei Click.
		";

$GLOBALS['phpAds_hlp_auto_clean_tables'] =
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		Abilitando questa opzione, le statistiche raccolte saranno automaticamente cancellate una volta
		trascorso il periodo specificato. Per esempio: impostando il periodo a 5 settimane, verranno
		cancellate automaticamente le statistiche più vecchie di 5 settimane.
		";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] =
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		Abilitando questa opzione, verranno cancellate automaticamente le informazioni del registro
		eventi più vecchie del numero di settimane specificato.
		";

$GLOBALS['phpAds_hlp_geotracking_type'] = "
		Il targeting geografico permette a ".$phpAds_productname." di convertire l'indirizzo IP del
		visitatore in una informazione geografica. Tramite questa informazione sarà possibile
		impostare limitazioni di consegna; inoltre, memorizzando le informazioni geografiche nelle statistiche
		sarà possibile vedere quale nazione genera più Visualizzazioni o Click.
		Per abilitare il tracking geografico è necessario selezionare il dipo di database di cui
		si è in possesso. Al momento ".$phpAds_productname." supporta i database
		<a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a>
		e <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a>.
		";

$GLOBALS['phpAds_hlp_geotracking_location'] = "
		A meno che non venga utilizzato il modulo GeoIP per Apache, è necessario fornire a
		".$phpAds_productname." il percorso del database geografico. È consigliabile posizionarlo
		al di fuori della radice dei documenti del server (document root), altrimenti estranei potrebbero
		essere in grado di scaricare il database.
		";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
		Convertire l'indirizzo IP in informazione geografica consuma del tempo. Per evitare
		che ".$phpAds_productname." debba farlo ogni volta che un banner viene consegnato, si
		può memorizzare il risultato in un cookie. Se il cookie è presente ".$phpAds_productname."
		utilizzerà questa informazione invece di effettuare ancora la conversione dall'indirizzo IP.
		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "
		Se non vuoi che siano registrati Visualizzazioni e Click per determinati computer,
		puoi aggiungerli a questa lista. Se è abilitata l'opzione <i>".$GLOBALS['strReverseLookup']."
		</i> puoi aggiungere nomi di dominio e indirizzi IP, altrimenti puoi utilizzare
		solo indirizzi IP. È inoltre possibile inserire caratteri jolly (p.es. '*.altavista.com'
		o '192.168.*').
		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "
		Per la maggior parte delle persone una settimana di Lunedì, ma se desideri
		puoi utilizzare anche la Domenica come primo giorno della settimana.
		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "
		Specifica quante cifre decimali utilizzare nelle pagine delle statistiche.
		";

$GLOBALS['phpAds_hlp_warn_admin'] = "
        ".$phpAds_productname." può spedirti una e-mail quando una campagna sta
		per esaurire i crediti di Visualizzazioni o Click. L'opzione è abilitata di default.
		";

$GLOBALS['phpAds_hlp_warn_client'] = "
        ".$phpAds_productname." può spedire una e-mail all'inserzionista quando una campagna sta
		per esaurire i crediti di Visualizzazioni o Click. L'opzione è abilitata di default.
		";

$GLOBALS['phpAds_hlp_qmail_patch'] = "
		Alcune versioni di qmail hanno un bug, che fa sì che le instestazioni delle e-mail
		inviate da ".$phpAds_productname." compaiano invece nel corpo della e-mail. Se questa opzione
		è abilitata ".$phpAds_productname." invierà le e-mail in un formato compatibile
		con qmail.
		";

$GLOBALS['phpAds_hlp_warn_limit'] = "
		Il limite di Visualizzazioni o Click rimasti raggiunto il quale ".$phpAds_productname." deve
		inviare le e-mail di avvertimento. Il valore di default è 100.
		";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Queste impostazioni controllano i tipi di invocazione consentiti.
		Se un tipo di invocazione non è abilitata, essa non sarà
		disponibile nel generatore di codici di invocazione.<br /><b>N.B.</b> i tipi di
		invocazione disabilitati continueranno a funzionare, benché non sia
		possibile generarne il codice.
		";

$GLOBALS['phpAds_hlp_con_key'] = "
		".$phpAds_productname." include un potente sistema di fornitura dei banner
		tramite selezione diretta. Per maggiori informazioni leggere il manuale utente.
		Con questa opzione sarà possibile utilizzare parole chiave condizionali.
		L'opzione è abilitata di default.
		";

$GLOBALS['phpAds_hlp_mult_key'] = "
		Utilizzando la selezione diretta per invocare i banner, è possibile
		specificare una o più parole chiave per ogni banner. Quaesta opzione
		deve essere attivata per utilizzare più di una parola chiave per banner.
		L'opzione è abilitata di default.
		";

$GLOBALS['phpAds_hlp_acl'] = "
		Se non utilizzi le limitazioni di consegna puoi disabilitare questa opzione per
		ottenere un lieve incremento di velocit&agrave.
		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "
		Se ".$phpAds_productname." non riesce a connettersi al database, o non riesce a trovare
		banner corrispondenti alla richiesta, per esempio se il database si è rovinato
		o è stato cancellato, non mostra nulla. Alcune utenti preferiscono che
		in questi casi venga mostrato un banner di default. Il banner specificato qui non
		verrà ignorato ai fini della registrazione di Visualizzazioni e Click e non
		sarà usato se ci saranno ancora banner attivi nel database. L'opzione è
		disabilitata di default.
		";

$GLOBALS['phpAds_hlp_delivery_caching'] = "
		Per diminuire i tempi di consegna, ".$phpAds_productname." utilizza una cache per
		memorizzare le informazioni necessarie alla consegna dei banner ai visitatori. La cache
		di consegna è memorizzata di default nel database, ma per aumentare ancora la
		velocità di risposta, è possibile memorizzare la cache in un file o nella
		memoria condivisa. La memoria condivisa è la più veloce. I file sono quasi
		altrettanto veloci. Non è consigliabile disabilitare la cache, in quanto il decadimento
		delle prestazioni sarebbe considerevole.
		";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] =
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." può utilizzare diversi tipi di banner e memorizzarli in maniera
		differente. Le prime due opzioni regolano la memorizzazione locale dei banner; è
		infatti possibile usare l'interfaccia di amministrazione per eseguire l'upload dei banner
		e ".$phpAds_productname."  li salverà nel database o su un server web. Si possono inoltre
		utilizzare banner memorizzati su server esterni, oppure usare HTML o un testo semplice
		per generare un banner.
		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "
		Per utilizzare i banner memorizzati sul server web, è necessario configurare
		questa opzione. Per memorizzare i banner in una directory locale selezionare
		<i>".$GLOBALS['strTypeWebModeLocal']."</i>; per utilizzare un server FTP esterno
		<i>".$GLOBALS['strTypeWebModeFtp']."</i>. Su alcuni server web si può anche
		utilizzare FTP anche per il server locale.
		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "
		Inserire la directory dove ".$phpAds_productname."  deve copiare i banner di cui si è
		eseguito l'upload. L'interprete PHP deve essere in grado di potervi scrivere, e questo
		significa che potrebbe essere necessario modificarne i permessi UNIX (chmod). La directory
		qui specificata deve essere nella document root del server web, poiché il server
		deve essere in grado di inviarla autonomamente. Non inserire la barra finale (/). È
		necessario configurare questa opzione solo se il metodo di memorizzazione selezionato è
		<i>".$GLOBALS['strTypeWebModeLocal']."</i>.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Se il metodo di memorizzazione selezionato è <i>".$GLOBALS['strTypeWebModeLocal']."</i>
		è necessario specificare l'indirizzio IP o il nome di dominio del server FTP dove
		".$phpAds_productname." deve copiare i banner.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		Se il metodo di memorizzazione selezionato è <i>".$GLOBALS['strTypeWebModeLocal']."</i>
		è necessario specificare la directory sul server FTP dove
		".$phpAds_productname." deve copiare i banner.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		Se il metodo di memorizzazione selezionato è <i>".$GLOBALS['strTypeWebModeLocal']."</i>
		è necessario specificare il nome utente per connettersi al server FTP dove
		".$phpAds_productname." deve copiare i banner.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		Se il metodo di memorizzazione selezionato è <i>".$GLOBALS['strTypeWebModeLocal']."</i>
		è necessario specificare la password per connettersi al server FTP dove
		";

$GLOBALS['phpAds_hlp_type_web_url'] = "
		Se si memorizzano banner su un server web, ".$phpAds_productname." deve conoscere
		l'URL pubblico a cui corrisponde la directory specificata qui sotto. Non inserire
		la barra alla fine (/).
		";

$GLOBALS['phpAds_hlp_type_html_auto'] = "
		Se questa opzione è attiva ".$phpAds_productname." modificherà automaticamente
		i banner HTML per rendere possibile la registrazione dei click. Se attiva, sarà
		comunque possibile disabilitarla per i banner per i quali lo si desidera.
		";

$GLOBALS['phpAds_hlp_type_html_php'] = "
		È possibile far eseguire a ".$phpAds_productname." codice PHP contenuto all'interno
		dei banner HTML. L'opzione è disabilitata di default.
		";

$GLOBALS['phpAds_hlp_admin'] = "
        Inserire lo username dell'amministratore. Utilizzando questo nome sarà possibile
		entrare nell'interfaccia di amministrazione.
		";

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
		Inserire la password per entrare nell'interfaccia di amministrazione.
		È necessario scrivere la nuova password due volte, per evitare errori di battitura.
		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "
		Per modificare la password dell'amministratore è necessario inserire la
		vecchia password in alto. È inoltre necessario scrivere la nuova password
		due volte, per evitare errori di battitura.
		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "
		Inserire il nome completo dell'amministratore. Questo campo viene utilizzato nella
		spedizione delle statistiche via email.
		";

$GLOBALS['phpAds_hlp_admin_email'] = "
		Inserire  l'indirizzo email dell'amministratore. Questo campo viene utilizzato come
		mittente nella spedizione delle statistiche via email.
		";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "
		Qui si possono inserire header supplementari per le email inviate da ".$phpAds_productname.".
		";

$GLOBALS['phpAds_hlp_admin_novice'] = "
		Attivare questa opzione per ricevere una richiesta di conferma prima di cancellare
		inserzionisti, campagne o banner.
		";

$GLOBALS['phpAds_hlp_client_welcome'] = "
		Se questa opzione è attiva, verrà visualizzato un messaggio di benvenuto
		dopo il login dell'inserzionista. E' possibile personalizzare il messaggio modificando
		il file welcome.html nella directory admin/templates. Nella maggior parte dei casi
		può essere utile includere il nome della propria società, il logo,
		informazioni sui contatti, un link alla pagina del listino, ecc...
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Invece di modificare il file welcome.html, è possibile inserire un breve testo qui;
		il file welcome.html sarà così ignorato. E' possibile usare codice HTML.
		";

$GLOBALS['phpAds_hlp_updates_frequency'] = "
		Attivare questa funzione per ricercare automaticamente versioni aggiornate di ".$phpAds_productname.".
		E' possibile specificare l'intervallo con cui ".$phpAds_productname." effettuerà la
		connessione al server degli aggiornamenti. Se viene trovata una versione aggiornata apparirà
		una finestra con le informazioni necessarie.
		";

$GLOBALS['phpAds_hlp_userlog_email'] = "
		Attivando questa opzione sarà possibile salvare una copia di tutte le e-mail inviate da
		".$phpAds_productname.". I messaggi saranno memorizzati nel ".$GLOBALS['strUserLog'].".
		";

$GLOBALS['phpAds_hlp_userlog_priority'] = "
		Per assicurarsi che il calcolo delle priorità sia andato a buon fine, è
		possibile salvare un resoconto dei calcoli effettuati ogni ora. Il rapporto contiene
		il profilo previsto e la proritè assegnata a tutti i banner. Questa informazione
		è utile nel caso si voglia segnalare un bug nel calcolo delle priorità.
		I rapporti sono memorizzati nel ".$GLOBALS['strUserLog'].".
		";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
		Per assicurarsi che il database venga ripulito correttamente, è
		possibile salvare un resoconto di quanto è effettivavente accaduto durante
		la pulizia. I rapporti sono memorizzati nel ".$GLOBALS['strUserLog'].".
		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		Inserire il peso proposto durante la creazione dei banner.
		Il valore di default è 1.
		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		Inserire il peso proposto durante la creazione delle campagne.
		Il valore di default è 1.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		Se questa opzione è attiva verranno visualizzate informazioni aggiuntive nella pagina
		<i>".$GLOBALS['strCampaignOverview']."</i>. Queste informazioni comprendono il numero di Visualizzazioni
		e di Click rimanenti, le date di attivazione e scadenza, e le impostazioni di priorità.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		Se questa opzione è attiva verranno visualizzate informazioni aggiuntive nella pagina
		<i>".$GLOBALS['strBannerOverview']."</i>. Queste informazioni comprendono l'URL di destinazione,
		le parole chiave, la dimensione e il peso dei banner.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		Se questa opzione è attiva verrà mostrata un'anteprima nella pagina
		<i>".$GLOBALS['strBannerOverview']."</i>. Se l'opzione è disabilitata sarà comunque
		possibile visualizzare l'anteprima cliccando sul triangolo posto a fianco di ogni banner.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		Se questa opzione è attiva verrà mostrato il banner HTML invece del codice. Questa
		opzione è disbailitata di default, poiché il codice di un banner HTML può
		creare conflitti con l'interfaccia utente. Se l'opzione è disabilitata sarà comunque
		possibile visualizzare il banner cliccando sul pulsante <i>".$GLOBALS['strShowBanner']."</i>
		a fianco del codice HTML del banner.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		Se questa opzione è attiva verrà mostrata un'anteprima nella parte superiore delle pagine
		<i>".$GLOBALS['strBannerProperties']."</i>, <i>".$GLOBALS['strModifyBannerAcl']."</i> and
		<i>".$GLOBALS['strLinkedZones']."</i>. Se l'opzione è disabilitata sarà comunque
		possibile visualizzare il banner cliccando sul pulsante <i>".$GLOBALS['strShowBanner']."</i> in alto.
		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		Se questa opzione è attiva tutti i banner, le campagne e gli inserzionisti non attivi
		saranno nascosti nelle pagine <i>".$GLOBALS['strClientsAndCampaigns']."</i> e <i>".
		$GLOBALS['strCampaignOverview']."</i>. Sarà comunque possibile visualizzare gli oggetti
		nascosti cliccando sul pulsante <i>".$GLOBALS['strShowAll']."</i> in fondo alla pagina.
		";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "
		Se questa opzione è attiva, i banner corrispondenti verranno mostrati nella pagina
		<i>".$GLOBALS['strIncludedBanners']."</i>, se è selezionato il metodo
		<i>". $GLOBALS['strCampaignSelection']."</i>. Questo permetterà di vedere
		quali banner sono presi in considerazione per la consegna se la campagna è collegata.
		Sarà inoltre possibile vedere un'anteprima dei banner corrispondenti.
		";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		Se questa opzione è attiva, verranno mostrate le campagne che contengono i banner nella pagina
		<i>".$GLOBALS['strIncludedBanners']."</i>, se è selezionato il metodo
		<i>". $GLOBALS['strBannerSelection']."</i>. Questo permetterà di vedere a quali campagne
		appartengono i banner prima di collegarli alla zona. I banner saranno perciò raggruppati
		per campagne e non più ordinati alfabeticamente.
		";

$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
		Per defualt tutti banner o le campagne disponibili sono visualizzati nella pagina <i>".$GLOBALS['strIncludedBanners']."</i>.
		Di conseguenza, se l'inventario contiene molti banner, la pagina può diventare molto lunga.
		Questa opzione permette di impostare il numero massimo di oggetti da visualizzare nella pagina.
		Se il numero è maggiore verrà mostrato il metodo di collegamento che richiede meno spazio.
		";

?>