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



// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
        Specifica l'hostname del server ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        Specifica il nome utente che ".$phpAds_productname." deve utilizzare per connettersi al server ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
        Specifica la password che ".$phpAds_productname." deve utilizzare per connettersi al server ".$phpAds_dbmsname.".
		";
		
$GLOBALS['phpAds_hlp_dbname'] = "
        Specifica il nome del database dove ".$phpAds_productname." deve salvare i dati.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        L'utilizzo delle connessioni persistenti pu&ograve; velocizzare considerevolmente ".$phpAds_productname."
		e pu&ograve; anche diminuire il carico di lavoro del server. C'&egrave; per&ograve; una controindicazione:
		nei siti con molti visitatori il carico del server potrebbe aumentare anzich&eacute; diminuire.
		La scelta sull'eventuale impiego delle connessioni persistenti deve perci&ograve; tenere conto del numero
		di visitatori e dell'hardware utilizzato. Se ".$phpAds_productname." consume troppe risorse, potrebbe essere
		necessario modificare questa impostazione.
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
		".$phpAds_dbmsname." blocca le tabelle mentre inserisce i dati. Se il sito ha molti visitatori, &egrave;
		possibile che ".$phpAds_productname." debba aspettare prima di inserire una nuova riga, poich&egrave; il
		database &egrave; ancora bloccato. Se si utilizzano gli inserimenti in differita, non ci sar&agrave; bisogno
		di attendere e la riga verr&agrave; inserita in seguito, quando la tabella non sar&agrave; pi&ugrave;
		bloccata da un'altra sessione.
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
		Se si verificano problemi di integrazione di ".$phpAds_productname." con altri prodotti di terze parti
		potrebbe essere utile attivare la compatibilit&agrave;. Utilizzando la modalit&agrave; di invocazione
		locale e la compatibilit&agrave; &egrave; attiva, ".$phpAds_productname." non dovrebbe alterare lo stato
		della connessione al database dopo l'uso di ".$phpAds_productname.". Questa opzione produce un (seppur minimo)
		rallentamento ed è perci&ograve; disabilitata di default.
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
		Se il database utilizzato da ".$phpAds_productname." &egrave; condiviso con altri prodotti software
		&egrave; consigiabile utilizzare un prefisso per i nomi delle tabelle. Se pi&ugrave; installazioni
		di ".$phpAds_productname." condividono lo stesso database, assicurati che i prefissi siano differenti.
		";
		
$GLOBALS['phpAds_hlp_tabletype'] = "
		".$phpAds_dbmsname." supporta differenti tipi di tabelle. Ognuno ha le proprie caratteristiche ed 
		alcuni possono velocizzare considerevolmente ".$phpAds_productname.". MyISAM &egrave; il tipo
		utilizzato di default ed &egrave; disponibile in tutte le installazioni di ".$phpAds_dbmsname.".
		Gli altri potrebbero non essere sempre disponibili.
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
		".$phpAds_productname." necessita di sapere il proprio indirizzo sul server web per poter
		funzionare correttamente. Devi specificare l'URL della directory dove ".$phpAds_productname."
		&egrave; stato installato, p.es. http://www.tuo-url.com/".$phpAds_productname." 
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
		Qui si possono inserire gli indirizzi dei file (p.es. /home/login/www/header.htm)
		da utilizzare come intestazione e pi&eacute; di pagina nelle pagine di amministrazione.
		Si possono utilizzare sia file di testo che html (questi ultimi non devono contenere tag
		&lt;body> o &lt;html>).
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		Abilitando la compressione GZIP dei contenuti si otterr&agrave; una grande diminuzione
		dei dei inviati al browser ogni volta che si utilizza l'interfaccia di amministrazione.
		Per abilitare questa caratteristica &egrave; necessario avere almeno PHP 4.0.5 con
		l'estensione GZIP installata.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
		Specifica la lingua utilizzata di default da ".$phpAds_productname.". Questa verr&agrave;
		usata nelle interfaccia amministratore e inserzionista. Nota Bene: &egrave; comunque possibile
		specificare una lingua diversa per ogni inserzionista ed anche permettere loro di
		modificare la propria.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
		Specifica il nome da utilizzare per questa applicazione. Questa stringa sar&agrave;
		visuallizzata in tutte le pagine dell'interfaccia utente. Se non viene specificato (stringa
		vuota) verr&agrave; mostrato il logo di ".$phpAds_productname.".
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
		Questo &egrave; il nome che ".$phpAds_productname." utilizza nella spedizione delle e-mail.
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
		La policy compatta inviata assieme ai cookie. L'impostazione di default &egrave;:
        'CUR ADM OUR NOR STA NID', che permette ad Internet Explorer 6 di accettare i cookie inviati
		da ".$phpAds_productname.". Volendo queste impostazioni si possono modificare in base alla
		propria informativa sulla privacy.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
		Per utilizzare una policy completa sulla privacy, specificare qui l'indirizzo.
		";
		
$GLOBALS['phpAds_hlp_log_beacon'] = "
		I beacon sono piccole immagini invisibili posizionate nella pagina dove viene visualizzato
		il banner. Quando questa impostazione &egrave; attiva ".$phpAds_productname." utilizzer&agrave;
		questo beacon per contare il numero di visualizzazioni del banner. Se viceversa non è attiva, le
		visualizzazioni saranno contate durante la consegna; questo metodo non &egrave; completamente accurato,
		poich&eacute; non sempre ad una consegna corrisponde una visualizzazione sullo schermo.
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
		Tradizionalmente ".$phpAds_productname." utilizzava un metodo di registrazione delle visualizzazioni
		e dei click molto dettagliato, ma anche molto esigente in termini di risorse per il database. Questo
		poteva essere un problema per siti con molti visitatori. Per superare questo problema
		".$phpAds_productname." supporta anche un nuovo tipo di statistiche, detto compatto, che &egrave;
		s&igrave; meno pesante per il database, ma anche meno dettagliato, in quanto non registra
		gli host. Se quest'ultima caratteristica &egrave; necessaria disabilitare questa optzione.
		";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
		Normalmente tutte le Visualizzazioni sono registrate; se non vuoi raccogliere statistiche
		sulle Visualizzazioni disattiva questa opzione.
		";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
		Se un visitatore ricarica una pagina, ".$phpAds_productname." registrer&agrave; ogni volta 
		una Visualizzazione. Questa funzione &egrave; utile per assicurarsi che sia registrata solo
		una Visualizzazione per ogni banner differente nell'intervallo di secondi specificato. Ad
		esempio, se questo valore &egrave; impostato a 300 secondi, ".$phpAds_productname." registrer&agrave;
		una Visualizzazione solo se un banner non &egrave; gi&agrave; stato mostrato allo stesso
		visitatore negli ultimi 5 minuti. Questa funzione funziona solo se &egrave; abilitata
		l'opzione <i>".$GLOBALS['strLogBeacons']."</i> e il browser accetta i cookie.
		";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
		Normalmente tutti i Click sono registrate; se non vuoi raccogliere statistiche
		sui Click disattiva questa opzione.
        Normally all AdClicks are logged, if you don't want to gather statistics 
        about AdClicks you can turn this off.
		";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Se un visitatore clicca pi&ugrave; volte su un banner ".$phpAds_productname." registrer&agrave;
		ogni volta un Click. Questa funzione &egrave; utile per assicurarsi che sia registrata solo
		un Click per ogni banner differente nell'intervallo di secondi specificato. Ad
		esempio, se questo valore &egrave; impostato a 300 secondi, ".$phpAds_productname." registrer&agrave;
		un Click solo se un banner non &egrave; gi&agrave; stato cliccato dallo stesso
		visitatore negli ultimi 5 minuti. Questa funzione funziona solo se il browser accetta i cookie.
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
        ".$phpAds_productname." logs the IP address of each visitor by default. If you want 
        ".$phpAds_productname." to log domain names you should turn this on. Reverse lookup 
        does take some time; it will slow everything down.
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Alcuni utenti utilizzano un server proxy per accedere a Internet. In questo caso
		".$phpAds_productname." registrer&agrave; l'indirizzo IP o il nome dell'host del
		server proxy invece di quelli dell'utente. Se questa opzione &egrave; abilitata
		".$phpAds_productname." cercher&agrave; di risalire all'indirizzo reale
		dell'utente dietro al proxy. Se questo non sar&agrave; possibile, verr&agrave;
		comunque utilizzato l'indirizzo del server proxy. Questa opzione non &egrave;
		abilitata di default poich&eacute; rallenta la registrazione delle Visualizzazioni
		e dei Click.
		";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
		Se non vuoi che siano registrati Visualizzazioni e Click per determinati computer,
		puoi aggiungerli a questa lista. Se è abilitata l'opzione <i>".$GLOBALS['strReverseLookup']."
		</i> puoi aggiungere nomi di dominio e indirizzi IP, altrimenti puoi utilizzare
		solo indirizzi IP. &Egrave; inoltre possibile inserire caratteri jolly (p.es. '*.altavista.com' 
		o '192.168.*').
		";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
		Per la maggior parte delle persone una settimana di Luned&igrave;, ma se desideri
		puoi utilizzare anche la Domenica come primo giorno della settimana.
		";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
		Specifica quante cifre decimali utilizzare nelle pagine delle statistiche.
		";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
        ".$phpAds_productname." pu&ograve; spedirti una e-mail quando una campagna sta
		per esaurire i crediti di Visualizzazioni o Click. L'opzione &egrave; abilitata di default.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
        ".$phpAds_productname." pu&ograve; spedire una e-mail all'inserzionista quando una campagna sta
		per esaurire i crediti di Visualizzazioni o Click. L'opzione &egrave; abilitata di default.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
		Alcune versioni di qmail hanno un bug, che fa s&igrave; che le instestazioni delle e-mail
		inviate da ".$phpAds_productname." compaiano invece nel corpo della e-mail. Se questa opzione
		&egrave; abilitata ".$phpAds_productname." invier&agrave; le e-mail in un formato compatibile
		con qmail.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
		Il limite di Visualizzazioni o Click rimasti raggiunto il quale ".$phpAds_productname." deve
		inviare le e-mail di avvertimento. Il valore di default &egrave; 100.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Queste impostazioni controllano i tipi di invocazione consentiti.
		Se un tipo di invocazione non &egrave; abilitata, essa non sar&agrave;
		disponibile nel generatore di codici di invocazione.<br><b>N.B.</b> i tipi di
		invocazione disabilitati continueranno a funzionare, bench&eacute; non sia
		possibile generarne il codice.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
		".$phpAds_productname." include un potente sistema di fornitura dei banner
		tramite selezione diretta. Per maggiori informazioni leggere il manuale utente.
		Con questa opzione sar&agrave; possibile utilizzare parole chiave condizionali.
		L'opzione &egrave; abilitata di default.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
		Utilizzando la selezione diretta per invocare i banner, &egrave; possibile 
		specificare una o pi&ugrave; parole chiave per ogni banner. Quaesta opzione
		deve essere attivata per utilizzare pi&ugrave; di una parola chiave per banner.
		L'opzione &egrave; abilitata di default.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
		Se non utilizzi le limitazioni di consegna puoi disabilitare questa opzione per
		ottenere un lieve incremento di velocit&agrave.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
		Se ".$phpAds_productname." non riesce a connettersi al database, o non riesce a trovare
		banner corrispondenti alla richiesta, per esempio se il database si &egrave; rovinato
		o &egrave; stato cancellato, non mostra nulla. Alcune utenti preferiscono che
		in questi casi venga mostrato un banner di default. Il banner specificato qui non
		verr&agrave; ignorato ai fini della registrazione di Visualizzazioni e Click e non
		sar&agrave; usato se ci saranno ancora banner attivi nel database. L'opzione &egrave;
		disabilitata di default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache'] = "
		Se vengono utilizzate le zone per richiamare i banner e questa opzione &egrave; attiva,
		".$phpAds_productname." memorizzer&agrave; le informazioni sui banner appartenenti alle
		zone all'interno di una cache, che potr&agrave; essere utilizzata in seguito. Questo
		aumenter&agrave; la velocit&agrave; di risposta di ".$phpAds_productname.", dal momento che
		sar&agrave; solo necessario caricare la cache piuttosto che effettuare nuovamente 
		tutte le operazioni richieste. Questa opzione &egrave; abilitata di default.
		";
		
$GLOBALS['phpAds_hlp_zone_cache_limit'] = "
		Se viene utilizzata la cache delle zone, può accadere che le informazioni contenute all'interno
		di essa siano obsolete. Ogni tanto ".$phpAds_productname." necessita di ricostruire la
		cache, in modo tale da includere i nuovi banner nella cache. Questa opzione permette di
		decidere quando deve avvenire questa operazione, specificando un tempo massimo di permananza
		delle informazioni nella cache. Per esempio: se questa opzione &egrave; impostata a 600, la cache
		sar&agrave; ricostruita se le informazioni sono pi&ugrave; vecchie di 10 minuti (600 secondi).
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
        ".$phpAds_productname." pu&ograve; utilizzare diversi tipi di banner e memorizzarli in maniera
		differente. Le prime due opzioni regolano la memorizzazione locale dei banner; &egrave;
		infatti possibile usare l'interfaccia di amministrazione per eseguire l'upload dei banner
		e ".$phpAds_productname."  li salver&agrave; nel database o su un server web. Si possono inoltre
		utilizzare banner memorizzati su server esterni, oppure usare HTML o un testo semplice
		per generare un banner.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
		Per utilizzare i banner memorizzati sul server web, &egrave; necessario configurare
		questa opzione. Per memorizzare i banner in una directory locale selezionare
		<i>".$GLOBALS['strTypeWebModeLocal']."</i>; per utilizzare un server FTP esterno
		<i>".$GLOBALS['strTypeWebModeFtp']."</i>. Su alcuni server web si pu&ograve; anche
		utilizzare FTP anche per il server locale.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
		Inserire la directory dove ".$phpAds_productname."  deve copiare i banner di cui si &egrave;
		eseguito l'upload. L'interprete PHP deve essere in grado di potervi scrivere, e questo
		significa che potrebbe essere necessario modificarne i permessi UNIX (chmod). La directory
		qui specificata deve essere nella document root del server web, poich&eacute; il server
		deve essere in grado di inviarla autonomamente. Non inserire la barra finale (/). &Egrave;
		necessario configurare questa opzione solo se il metodo di memorizzazione selezionato &egrave;
		<i>".$GLOBALS['strTypeWebModeLocal']."</i>.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Se il metodo di memorizzazione selezionato &egrave; <i>".$GLOBALS['strTypeWebModeLocal']."</i>
		&egrave; necessario specificare l'indirizzio IP o il nome di dominio del server FTP dove
		".$phpAds_productname." deve copiare i banner.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		Se il metodo di memorizzazione selezionato &egrave; <i>".$GLOBALS['strTypeWebModeLocal']."</i>
		&egrave; necessario specificare la directory sul server FTP dove
		".$phpAds_productname." deve copiare i banner.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		Se il metodo di memorizzazione selezionato &egrave; <i>".$GLOBALS['strTypeWebModeLocal']."</i>
		&egrave; necessario specificare il nome utente per connettersi al server FTP dove
		".$phpAds_productname." deve copiare i banner.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		Se il metodo di memorizzazione selezionato &egrave; <i>".$GLOBALS['strTypeWebModeLocal']."</i>
		&egrave; necessario specificare la password per connettersi al server FTP dove
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
		Se si memorizzano banner su un server web, ".$phpAds_productname." deve conoscere
		l'URL pubblico a cui corrisponde la directory specificata qui sotto. Non inserire
		la barra alla fine (/).
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
		Se questa opzione &egrave; attiva ".$phpAds_productname." modificher&agrave; automaticamente
		i banner HTML per rendere possibile la registrazione dei click. Se attiva, sar&agrave;
		comunque possibile disabilitarla per i banner per i quali lo si desidera.
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
		&Egrave; possibile far eseguire a ".$phpAds_productname." codice PHP contenuto all'interno
		dei banner HTML. L'opzione &egrave; disabilitata di default.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
        The administrator username, you can specify the username that you can 
        use to log into the administrator interface.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
		Per modificare la password dell'amministratore &egrave; necessario inserire la
		vecchia password in alto. &Egrave; inoltre necessario scrivere la nuova password
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
		Se questa opzione &egrave; attiva, verr&agrave; visualizzato un messaggio di benvenuto
		dopo il login dell'inserzionista. E' possibile personalizzare il messaggio modificando
		il file welcome.html nella directory admin/templates. Nella maggior parte dei casi
		pu&ograve; essere utile includere il nome della propria societ&agrave;, il logo,
		informazioni sui contatti, un link alla pagina del listino, ecc...
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Invece di modificare il file welcome.html, &egrave; possibile inserire un breve testo qui;
		il file welcome.html sar&agrave; cos&igrave; ignorato. E' possibile usare codice HTML.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
		Attivare questa funzione per ricercare automaticamente versioni aggiornate di ".$phpAds_productname.".
		E' possibile specificare l'intervallo con cui ".$phpAds_productname." effettuer&agrave; la
		connessione al server degli aggiornamenti. Se viene trovata una versione aggiornata apparir&agrave;
		una finestra con le informazioni necessarie.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		Attivando questa opzione sar&agrave; possibile salvare una copia di tutte le e-mail inviate da
		".$phpAds_productname.". I messaggi saranno memorizzati nel ".$GLOBALS['strUserLog'].".
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		Per assicurarsi che il calcolo delle priorit&agrave; sia andato a buon fine, &egrave;
		possibile salvare un resoconto dei calcoli effettuati ogni ora. Il rapporto contiene
		il profilo previsto e la prorit&egrave; assegnata a tutti i banner. Questa informazione
		&egrave; utile nel caso si voglia segnalare un bug nel calcolo delle priorit&agrave;.
		I rapporti sono memorizzati nel ".$GLOBALS['strUserLog'].".
		";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		Inserire il peso proposto durante la creazione dei banner.
		Il valore di default &egrave; 1. 
		";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		Inserire il peso proposto durante la creazione delle campagne.
		Il valore di default &egrave; 1. 
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		Se questa opzione &egrave; attiva verranno visualizzate informazioni aggiuntive nella pagina
		<i>".$GLOBALS['strCampaignOverview']."</i>. Queste informazioni comprendono il numero di Visualizzazioni
		e di Click rimanenti, le date di attivazione e scadenza, e le impostazioni di priorit&agrave;.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		Se questa opzione &egrave; attiva verranno visualizzate informazioni aggiuntive nella pagina
		<i>".$GLOBALS['strBannerOverview']."</i>. Queste informazioni comprendono l'URL di destinazione,
		le parole chiave, la dimensione e il peso dei banner.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		Se questa opzione &egrave; attiva verr&agrave; mostrata un'anteprima nella pagina
		<i>".$GLOBALS['strBannerOverview']."</i>. Se l'opzione &egrave; disabilitata sar&agrave; comunque
		possibile visualizzare l'anteprima cliccando sul triangolo posto a fianco di ogni banner.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		Se questa opzione &egrave; attiva verr&agrave; mostrato il banner HTML invece del codice. Questa
		opzione &egrave; disbailitata di default, poiché il codice di un banner HTML pu&ograve;
		creare conflitti con l'interfaccia utente. Se l'opzione &egrave; disabilitata sar&agrave; comunque
		possibile visualizzare il banner cliccando sul pulsante <i>".$GLOBALS['strShowBanner']."</i>
		a fianco del codice HTML del banner.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		Se questa opzione &egrave; attiva verr&agrave; mostrata un'anteprima nella parte superiore delle pagine
		<i>".$GLOBALS['strBannerProperties']."</i>, <i>".$GLOBALS['strModifyBannerAcl']."</i> and 
		<i>".$GLOBALS['strLinkedZones']."</i>. Se l'opzione &egrave; disabilitata sar&agrave; comunque
		possibile visualizzare il banner cliccando sul pulsante <i>".$GLOBALS['strShowBanner']."</i> in alto.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		Se questa opzione &egrave; attiva tutti i banner, le campagne e gli inserzionisti non attivi
		saranno nascosti nelle pagine <i>".$GLOBALS['strClientsAndCampaigns']."</i> e <i>".
		$GLOBALS['strCampaignOverview']."</i>. Sar&agrave; comunque possibile visualizzare gli oggetti
		nascosti cliccando sul pulsante <i>".$GLOBALS['strShowAll']."</i> in fondo alla pagina.
		";
		
?>