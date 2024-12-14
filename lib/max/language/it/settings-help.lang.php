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

// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "Specifica il nome host del {$phpAds_dbmsname} server database sul quale stai tentando di connetterti.";

$GLOBALS['phpAds_hlp_dbport'] = "Specifica il numero della porta del {$phpAds_dbmsname} server database sul quale stai tentando di connetterti.";

$GLOBALS['phpAds_hlp_dbuser'] = "Specifica il nome utente che {$PRODUCT_NAME} deve usare per accedere al server database {$phpAds_dbmsname}.";

$GLOBALS['phpAds_hlp_dbpassword'] = "Specifica la password che {$PRODUCT_NAME} deve usare per accedere al server database {$phpAds_dbmsname}.";

$GLOBALS['phpAds_hlp_dbname'] = "Specifica il nome del database sul quale il server database  {$PRODUCT_NAME} deve salvare i dati.
Importante, il database deve già essere stato creato sul server database. {$PRODUCT_NAME} <b>non</b> creerà questo database se ancora non esiste.";

$GLOBALS['phpAds_hlp_persistent_connections'] = "L'uso di connessioni persistenti può aumentare la velocità di {$PRODUCT_NAME} considerevolmente e potrebbe anche diminuire il carico di lavoro sul server. C'è comunque una controindicazione, su siti con molti visitatori il carico sul server può aumentare e diventare più grande che usando connessioni normali. La scelta sull'eventuale impiego delle connessioni persistenti deve perciò tenere conto del numero di visitatori e dell'hardware utilizzato. Se {$PRODUCT_NAME} sta usando troppe risorse, potrebbe essere necessario modificare questa impostazione.";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "Se hai problemi di integrazione di {$PRODUCT_NAME} con altri prodotti potrebbe tornare utile attivare la modalità compatibilità database. Utilizzando la modalità invocazione locale e la compatibilità del database è attiva su {$PRODUCT_NAME} ti conviene lasciare lo stato di connessione del database di {$PRODUCT_NAME} esattamente com'era in precedenza. Questa opzione produce un (seppur minimo) rallentamento ed è perciò disabilitata di default.";

$GLOBALS['phpAds_hlp_table_prefix'] = "Se il database {$PRODUCT_NAME} sta usando è condiviso da più prodotti software, è saggio
aggiungere un prefisso ai nomi delle tabelle. Se stai usando più installazioni di {$PRODUCT_NAME}
nello stesso database, è necessario assicurarsi che questo prefisso sia unico per tutte le installazioni.";

$GLOBALS['phpAds_hlp_table_type'] = "MySQL supporta più tipi di tabella. Ogni tipo di tabella ha proprietà uniche e alcuni
possono velocizzare notevolmente {$PRODUCT_NAME} . MyISAM è il tipo di tabella predefinito ed è disponibile
in tutte le installazioni di MySQL. Altri tipi di tabella potrebbero non essere disponibili sul tuo server.";

$GLOBALS['phpAds_hlp_url_prefix'] = "{$PRODUCT_NAME} deve sapere dove si trova sul server web per far sì che
funzioni correttamente. È necessario specificare l'URL della directory in cui è installato {$PRODUCT_NAME}
, per esempio: <i>http://www.your-url.com/ads</i>.";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "{$PRODUCT_NAME} deve sapere dove si trova sul server web per far sì che
funzioni correttamente. A volte il prefisso SSL è diverso dal prefisso URL normale.
Devi specificare l'URL della directory in cui è installato {$PRODUCT_NAME}
, per esempio: <i>https://www.your-url.com/ads</i>.";

$GLOBALS['phpAds_hlp_my_header'] = $GLOBALS['phpAds_hlp_my_footer'] = "Dovresti mettere qui il percorso dei file di intestazione (ad esempio: /home/login/www/header. tm)
avere un'intestazione e/o un piè di pagina su ogni pagina nell'interfaccia di amministrazione. È
possibile inserire testo o html in questi file (se si desidera utilizzare html in
uno o entrambi i file non utilizzare tag come <body> o <html>).";

$GLOBALS['phpAds_hlp_my_logo'] = "Si dovrebbe mettere qui il nome del file logo personalizzato che si desidera visualizzare invece
del logo predefinito. Il logo deve essere inserito nella directory admin/images prima di
impostando qui il nome del file.";

$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "Dovresti mettere qui un colore personalizzato che sarà usato per le schede, la barra di ricerca e
qualche testo in grassetto.";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "Dovresti mettere qui un colore personalizzato che sarà usato per lo sfondo dell'intestazione.";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "Dovresti mettere qui un colore personalizzato che sarà usato per la scheda principale attualmente selezionata.";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "Dovresti mettere qui un colore personalizzato che verrà usato per il testo nell'intestazione.";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "Abilitando la compressione dei contenuti di GZIP otterrai una notevole diminuzione dei dati che
viene inviata al browser ogni volta che viene aperta una pagina dell'interfaccia di amministratore.
Per abilitare questa funzione è necessario avere l'installazione dell'estensione GZIP.";

$GLOBALS['phpAds_hlp_language'] = "Specifica la lingua predefinita che {$PRODUCT_NAME} dovrebbe usare. Questa lingua sarà
usata come predefinita per l'interfaccia admin e inserzionista. Si prega di notare:
è possibile impostare una lingua diversa per ogni inserzionista dall'interfaccia di amministrazione
e consentire agli inserzionisti di cambiare la propria lingua.";

$GLOBALS['phpAds_hlp_name'] = "Specifica il nome che vuoi usare per questa applicazione. Questa stringa
verrà visualizzata su tutte le pagine dell'interfaccia admin e inserzionista. Se lasci
questa impostazione vuota (predefinita) verrà invece visualizzato un logo di {$PRODUCT_NAME}.";

$GLOBALS['phpAds_hlp_company_name'] = "Questo nome è usato nell'email inviata da {$PRODUCT_NAME}.";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "{$PRODUCT_NAME} di solito rileva se la libreria GD è installata e quale formato di immagine
è supportato dalla versione installata di GD. Comunque è possibile
il rilevamento non è accurato o falso, alcune versioni di PHP non consentono
il rilevamento dei formati di immagine supportati. Se {$PRODUCT_NAME} non riesce a rilevare automaticamente
il formato immagine giusto è possibile specificare il formato immagine giusto. Possibili valori
sono: none, png, jpeg, gif.";

$GLOBALS['phpAds_hlp_log_adviews'] = "Normalmente tutte le viste sono registrate, se non vuoi raccogliere statistiche
su Visualizzazioni puoi disattivarlo.";

$GLOBALS['phpAds_hlp_block_adviews'] = "Se un visitatore ricarica una pagina un AdView sarà registrato da {$PRODUCT_NAME} ogni volta.
Questa funzione viene utilizzata per assicurarsi che un solo AdView sia registrato per ogni banner
univoco per il numero di secondi specificato. Per esempio: se si imposta questo valore
a 300 secondi, {$PRODUCT_NAME} registrerà solo le Visualizzazioni se lo stesso banner non è già
mostrato allo stesso visitatore negli ultimi 5 minuti. Questa funzione funziona solo il browser accetta cookie.";

$GLOBALS['phpAds_hlp_log_adclicks'] = "Normalmente tutti gli AdClick sono registrati, se non vuoi raccogliere statistiche
su AdClick puoi disattivarlo.";

$GLOBALS['phpAds_hlp_block_adclicks'] = "Se un visitatore fa clic più volte su un banner un AdClick sarà registrato da {$PRODUCT_NAME}
ogni volta. Questa funzione viene utilizzata per assicurarsi che un solo AdClick sia registrato per ogni banner
univoco per il numero di secondi specificato. Per esempio: se si imposta questo valore
a 300 secondi, {$PRODUCT_NAME} registrerà AdClick solo se il visitatore ha fatto clic sullo stesso banner
negli ultimi 5 minuti. Questa funzione funziona solo quando il browser accetta i cookie.";

$GLOBALS['phpAds_hlp_log_adconversions'] = "Normalmente tutte le AdConversioni sono registrate, se non vuoi raccogliere statistiche
su AdConversions puoi disattivarlo.";

$GLOBALS['phpAds_hlp_block_adconversions'] = "Se un visitatore ricarica una pagina con un beacon, {$PRODUCT_NAME} registrerà l'AdConversione
ogni volta. Questa funzione viene utilizzata per assicurarsi che sia registrata una sola AdConversion per ogni conversione
univoca per il numero di secondi specificati. Per esempio: se si imposta questo valore
a 300 secondi, {$PRODUCT_NAME} registrerà AdConversioni solo se il visitatore ha caricato la stessa pagina
con il faro di AdConversion negli ultimi 5 minuti. Questa funzione funziona solo quando il browser accetta i cookie.";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "Se stai usando un database di geotargeting puoi anche memorizzare le informazioni geografiche
nel database. Se hai abilitato questa opzione, sarai in grado di vedere le statistiche sulla posizione
dei tuoi visitatori e come ogni banner sta eseguendo nei diversi paesi.
Questa opzione sarà disponibile solo se stai usando statistiche dettagliate.";

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
		{$PRODUCT_NAME} registrerà l'indirizzo IP o il nome dell'host del
		server proxy invece di quelli del visitatore. Se questa opzione è abilitata
		{$PRODUCT_NAME} cercherà di risalire all'indirizzo reale
		del computer del visitatore dietro al proxy. Se questo non sarà possibile, verrà
		memorizzato l'indirizzo del server proxy. Questa opzione non è
		abilitata di default poiché rallenta considerevolmente la registrazione
		delle Visualizzazioni e dei Click.
		";

$GLOBALS['phpAds_hlp_obfuscate'] = "Niente qui....";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "Se abiliti questa funzione, le statistiche raccolte verranno cancellate automaticamente dopo il periodo
specificato sotto questa casella di controllo. Ad esempio, se si imposta questa a 5 settimane, le statistiche
più vecchie di 5 settimane saranno automaticamente cancellate.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "Questa funzione eliminerà automaticamente le voci dal registro utente che sono più vecchie del numero di settimane
specificato sotto questa casella di controllo.";

$GLOBALS['phpAds_hlp_geotracking_type'] = "Geotargeting permette ad {$PRODUCT_NAME} di convertire l'indirizzo IP del visitatore in informazioni geografiche
. Sulla base di queste informazioni è possibile impostare le regole di consegna o è possibile memorizzare
queste informazioni per vedere quale paese sta generando il maggior numero di impressioni o click-thrus.
Se vuoi abilitare il geotargeting devi scegliere quale tipo di database possiedi.
{$PRODUCT_NAME} supporta attualmente il database <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a>
e <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a>.";

$GLOBALS['phpAds_hlp_geotracking_location'] = "A meno che tu non sia il modulo GeoIP Apache, dovresti dire ad {$PRODUCT_NAME} la posizione del database di geotargeting
. Si consiglia sempre di posizionare il database al di fuori della radice dei documenti dei server web
, perché altrimenti le persone sono in grado di scaricare il database.";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "La conversione dell'indirizzo IP in informazioni geografiche richiede tempo. Per evitare che
{$PRODUCT_NAME} debba farlo ogni volta che viene consegnato un banner, il risultato può essere
memorizzato in un cookie. Se questo cookie è presente, {$PRODUCT_NAME} utilizzerà queste informazioni invece
per convertire l'indirizzo IP.";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "Se non si desidera contare visualizzazioni, clic e conversioni da un determinato computer
è possibile aggiungerle a questo elenco. Se hai abilitato la ricerca inversa puoi aggiungere
sia i nomi di dominio che gli indirizzi IP, altrimenti puoi usare solo gli indirizzi IP
. Puoi anche usare caratteri jolly (es. '*.altavista.com' o '192.168.*').";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Per la maggior parte delle persone una settimana inizia il lunedì, ma se si desidera iniziare ogni settimana
in una domenica è possibile.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "Specifica quanti decimali visualizzare nelle pagine delle statistiche.";

$GLOBALS['phpAds_hlp_warn_admin'] = "        {$PRODUCT_NAME} può spedirti una e-mail quando una campagna sta
		per esaurire i crediti di Visualizzazioni, Click o Conversioni. L'opzione è abilitata di default.
		";

$GLOBALS['phpAds_hlp_warn_client'] = "{$PRODUCT_NAME} può inviare l'email inserzionista se una delle sue campagne ha solo un
numero limitato di visualizzazioni, clic o conversioni rimaste. Questo è attivato per impostazione predefinita.";

$GLOBALS['phpAds_hlp_qmail_patch'] = "Alcune versioni di qmail sono interessate da un bug, che fa sì che l'email inviata da
{$PRODUCT_NAME} mostri le intestazioni all'interno del corpo dell'email. Se abiliti
questa impostazione, {$PRODUCT_NAME} invierà email in un formato compatibile con qmail.";

$GLOBALS['phpAds_hlp_warn_limit'] = "Il limite in cui {$PRODUCT_NAME} inizia a inviare email di avvertimento. Questo è 100
per impostazione predefinita.";

$GLOBALS['phpAds_hlp_acl'] = "Se non stai usando le regole di consegna puoi disabilitare questa opzione con questo parametro,
questo accelera leggermente {$PRODUCT_NAME}.";

$GLOBALS['phpAds_hlp_default_banner_url'] = $GLOBALS['phpAds_hlp_default_banner_target'] = "Se {$PRODUCT_NAME} non riesce a connettersi al server del database, o non riesce a trovare alcun banner corrispondente a
, ad esempio quando il database è andato in crash o è stato eliminato,
non visualizzerà nulla. Alcuni utenti potrebbero voler specificare un banner predefinito,
che verrà visualizzato in queste situazioni. Il banner predefinito specificato
qui non verrà registrato e non verrà utilizzato se ci sono ancora banner attivi
rimasti nel database. Questo è disattivato per impostazione predefinita.";

$GLOBALS['phpAds_hlp_delivery_caching'] = "Per velocizzare la consegna {$PRODUCT_NAME} utilizza una cache che include tutte le
le informazioni necessarie per consegnare il banner al visitatore del tuo sito web. La cache di consegna
è memorizzata di default nel database, ma per aumentare ancora di più la velocità è anche
possibile memorizzare la cache all'interno di un file o all'interno della memoria condivisa. La memoria condivisa è più veloce, anche i file
sono molto veloci. Non è consigliabile disattivare la cache di consegna, perché questa
influenzerà seriamente le prestazioni.";

$GLOBALS['phpAds_hlp_type_web_mode'] = "Se si desidera utilizzare banner memorizzati sul server web, è necessario configurare
questa impostazione. Se si desidera memorizzare i banner in una directory locale set
questa opzione per <i>Directory locale</i>. Se si desidera memorizzare il banner su un server FTP esterno
impostare questa opzione su <i>server FTP esterno</i>. Su alcuni server web
potresti voler utilizzare l'opzione FTP anche sul server web locale.";

$GLOBALS['phpAds_hlp_type_web_dir'] = "Specifica la directory in cui {$PRODUCT_NAME} deve copiare i banner caricati
. Questa directory deve essere scrivibile da PHP, questo potrebbe significare che hai bisogno di
per modificare i permessi UNIX per questa directory (chmod). La directory
che specifichi qui deve essere nella radice del documento del server web, il server web
deve essere in grado di servire direttamente i file. Non specificare uno slash
finale (/). Devi configurare questa opzione solo se hai impostato il metodo
di archiviazione su <i>Directory locale</i>.";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "Se il metodo selezionato è  <i>Server FTP esterno<i>, è necessario specificare l'indirizzo IP o l'hostname del server FTP dove {$PRODUCT_NAME} dovrà copiare i banner caricati.";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "Se si imposta il metodo di archiviazione su <i>server FTP esterno</i> è necessario specificare
la directory sul server FTP esterno dove {$PRODUCT_NAME} ha bisogno di
per copiare i banner caricati.";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "Se si imposta il metodo di archiviazione su <i>server FTP esterno</i> è necessario specificare
il nome utente che {$PRODUCT_NAME} deve utilizzare per connettersi al server FTP esterno
.";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "Se il metodo selezionato è  <i>Server FTP esterno<i>, è necessario specificare la password con cui connettersi al server FTP dove {$PRODUCT_NAME} dovrà copiare i banner caricati.";

$GLOBALS['phpAds_hlp_type_web_ftp_passive'] = "Alcuni server FTP e firewall richiedono trasferimenti per utilizzare la Modalità Passiva (PASV).
Se {$PRODUCT_NAME} dovrà usare la Modalità Passiva per connettersi al tuo server FTP
, quindi abilitare questa opzione.";

$GLOBALS['phpAds_hlp_type_web_url'] = "Se conservi banner su un server web, {$PRODUCT_NAME} deve sapere quale URL pubblico
corrisponde alla directory che hai specificato sotto. Non specificare
una barra finale (/).";

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "Se si memorizzano banner su un server web, {$PRODUCT_NAME} deve sapere quale URL pubblico
(SSL) corrisponde alla directory che hai specificato sotto. Non specificare
una barra finale (/).";

$GLOBALS['phpAds_hlp_type_html_auto'] = "Se questa opzione è attivata {$PRODUCT_NAME} modificherà automaticamente i banner HTML
per consentire la registrazione dei clic. Tuttavia, anche se questa opzione
è attiva, sarà comunque possibile disabilitare questa funzione su base per banner
.";

$GLOBALS['phpAds_hlp_type_html_php'] = "È possibile lasciare che {$PRODUCT_NAME} esegua il codice PHP incorporato all'interno dei banner HTML
. Questa funzione è disattivata per impostazione predefinita.";

$GLOBALS['phpAds_hlp_admin'] = "Inserisci il nome utente dell'amministratore. Con questo nome utente puoi accedere all'interfaccia
dell'amministratore.";

$GLOBALS['phpAds_hlp_admin_pw'] = $GLOBALS['phpAds_hlp_admin_pw2'] = "Inserire la password che si desidera utilizzare per accedere all'interfaccia amministratore.
È necessario inserirla due volte per evitare errori di digitazione.";

$GLOBALS['phpAds_hlp_pwold'] = $GLOBALS['phpAds_hlp_pw'] = $GLOBALS['phpAds_hlp_pw2'] = "Per modificare la password dell'amministratore, è possibile specificare la vecchia password
sopra. Inoltre è necessario specificare la nuova password due volte, per
evitare errori di digitazione.";

$GLOBALS['phpAds_hlp_admin_fullname'] = "Specifica il nome completo dell'amministratore. Questo usato quando si inviano statistiche
via email.";

$GLOBALS['phpAds_hlp_admin_email'] = "L'indirizzo email dell'amministratore. Questo è usato come indirizzo di provenienza quando
invia statistiche via email.";

$GLOBALS['phpAds_hlp_admin_novice'] = "Se si desidera ricevere un avviso prima di eliminare inserzionisti, campagne, banner,
siti web e zone; impostare questa opzione a true.";

$GLOBALS['phpAds_hlp_client_welcome'] = "Se si attiva questa funzione su un messaggio di benvenuto verrà visualizzato sulla prima pagina un inserzionista
vedrà dopo l'accesso. È possibile personalizzare questo messaggio modificando il benvenuto
. posizione del file tml nella directory admin/templates. Le cose che potresti voler includere
sono per esempio: il nome della tua azienda, informazioni di contatto, il logo della tua azienda, un collegamento
una pagina con le tariffe pubblicitarie, ecc.";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "Invece di modificare il file welcome.html puoi anche specificare un piccolo testo qui. Se inserisci un testo
qui, il file welcome.html verrà ignorato. È consentito usare tag html.";

$GLOBALS['phpAds_hlp_updates_frequency'] = "Se vuoi controllare la presenza di nuove versioni di {$PRODUCT_NAME} puoi abilitare questa funzione.
È possibile specificare l'intervallo in cui {$PRODUCT_NAME} fa una connessione ad
il server di aggiornamento. Se viene trovata una nuova versione, verrà visualizzata una finestra di dialogo con ulteriori informazioni
sull'aggiornamento.";

$GLOBALS['phpAds_hlp_userlog_email'] = "Abilita questa funzionalità per salvare una copia di tutte le e-mail inviate da {$PRODUCT_NAME} nello userlog";

$GLOBALS['phpAds_hlp_userlog_inventory'] = "Per garantire che il calcolo dell'inventario sia eseguito correttamente, puoi salvare un rapporto su
il calcolo dell'inventario orario. Questo rapporto include il profilo previsto e quanto
priorità è assegnata a tutti i banner. Queste informazioni potrebbero essere utili se
vuoi inviare una segnalazione di bugreport sui calcoli di priorità. I report sono
memorizzati all'interno del registro utente.";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "Per garantire che il database sia stato potato correttamente, puoi salvare un report su
che cosa è accaduto esattamente durante la potatura. Queste informazioni saranno memorizzate
nel registro utente.";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "Se si desidera utilizzare un peso banner predefinito più alto è possibile specificare il peso desiderato qui.
Questa impostazione è 1 per impostazione predefinita.";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "Se si desidera utilizzare un peso di campagna predefinito più alto è possibile specificare il peso desiderato qui.
Questa impostazione è 1 per impostazione predefinita.";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Se questa opzione è abilitata, le informazioni aggiuntive su ogni campagna saranno mostrate nella pagina
<i>Campagne</i> . Le informazioni extra includono il numero di AdViews rimanenti,
il numero di AdClick rimanenti, il numero di AdConversioni rimanenti, la data di attivazione, la data di scadenza
e le impostazioni di priorità.";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Se questa opzione è abilitata, ulteriori informazioni su ogni banner saranno mostrate sulla pagina
<i>Banners</i> . Le informazioni extra includono l'URL di destinazione, le parole chiave, le dimensioni
e il peso del banner.";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Se questa opzione è abilitata, un'anteprima di tutti i banner sarà mostrata nella pagina <i>Banners</i>
. Se questa opzione è disabilitata, è ancora possibile visualizzare un'anteprima di ogni banner facendo clic su
sul triangolo accanto a ogni banner nella pagina <i>Banner</i>.";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "Se questa opzione è abilitata, verrà mostrato il banner HTML effettivo invece del codice HTML. Questa opzione
è disabilitata per impostazione predefinita, perché i banner HTML potrebbero entrare in conflitto con l'interfaccia utente.
Se questa opzione è disabilitata, è ancora possibile visualizzare il banner HTML attuale, cliccando su
il pulsante <i>Mostra banner</i> accanto al codice HTML.";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "Se questa opzione è abilitata, un'anteprima verrà mostrata nella parte superiore delle proprietà <i>Banner</i>,
<i>Opzioni di consegna</i> e <i>Zone collegate</i> pagine. Se questa opzione è disabilitata, è ancora
possibile visualizzare il banner, cliccando sul pulsante <i>Mostra banner</i> nella parte superiore delle pagine.";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Se questa opzione è abilitata tutti i banner inattivi, campagne e inserzionisti saranno nascosti dalle pagine
<i>Advertisers & Campaigns</i> e <i>Campagne</i> . Se questa opzione è abilitata, è ancora
possibile visualizzare gli elementi nascosti, cliccando sul pulsante <i>Mostra tutti</i> in basso
della pagina.";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "Se questa opzione è abilitata, il banner corrispondente verrà visualizzato sulla pagina <i>banner collegati</i> , se viene scelto il metodo
di selezione <i>della Campagna</i> . Questo ti permetterà di vedere esattamente quali banner sono
considerati per la consegna se la campagna è collegata. Sarà anche possibile guardare un'anteprima
dei banner corrispondenti.";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "Se questa opzione è abilitata, le campagne genitore dei banner saranno mostrate nella pagina <i>Link banner</i>
, se viene scelto il metodo <i>Banner selection</i> . Questo ti permetterà di vedere quale banner
appartiene a quale campagna prima che il banner sia collegato. Questo significa anche che i banner sono raggruppati
dalle campagne genitore e non sono più ordinati in modo alfabetico.";
