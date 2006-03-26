<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
	Vul hier het IP adres of de domeinnaam van de ".$phpAds_dbmsname." database server in.
";

$GLOBALS['phpAds_hlp_dbport'] = "
        Vul hier het poortnummer in van de ".$phpAds_dbmsname." database server waarmee een connectie gemaakt moet
		worden. Het standaard poortnummer voor een ".$phpAds_dbmsname." database is <i>".
		($phpAds_productname == 'phpAdsNew' ? '3306' : '5432')."</i>.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        Vul hier de gebruikersnaam in wat ".$phpAds_productname." moet gebruiken om toegang te krijgen tot de
	".$phpAds_dbmsname." database server.
";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
	Vul hier het wachtwoord in wat ".$phpAds_productname." moet gebruiken om toegang te krijgen tot de
	".$phpAds_dbmsname." database server.
";
		
$GLOBALS['phpAds_hlp_dbname'] = "
	Vul hier de naam van de database in welke ".$phpAds_productname." moet gebruiken om gegevens
	op te slaan. Belangrijk: de database moet al bestaan op de database server. ".$phpAds_productname." kan deze
	<b>niet</b> automatisch aanmaken indien de database nog niet bestaat.
";

$GLOBALS['phpAds_hlp_persistent_connections'] = "
	Door gebruik te maken van persistent connections met de database kan de snelheid
	van ".$phpAds_productname." toenemen. Het is tevens van invloed op de belasting van de server. 
	Echter wanneer uw website veel bezoekers heeft kan de belasting van de
	database server groter worden dan wanneer deze optie uit staat. Of het verstandig
	is om deze optie gebruiken hangt geheel af van het aantal bezoekers en de hardware
	die u gebruikt. Indien ".$phpAds_productname." een te hoge belasting op de database server veroorzaakt
	kunt u proberen om deze optie uit te schakelen.
";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
	".$phpAds_dbmsname." blokkeerd de tabel wanneer er data wordt toegevoegd. Indien u veel bezoekers
	op uw website heeft is het mogelijk dat ".$phpAds_productname." moet wachten voordat er nieuwe
	gegevens in de database toegevoegd kunnen worden, omdat de database nog steeds
	geblokkeerd is. Wanneer u deze optie gebruikt hoeft ".$phpAds_productname." niet te wachten en
	zullen de gegevens op een rustiger tijdstip toegevoegd worden.
";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
	Indien u problemen heeft met het integreren van ".$phpAds_productname." in een ander product dan
	kan het helpen om de database compatibiliteits mode aan te zetten. Indien u banners toont
	door middel van de Locale mode en de database compatibiliteit mode staat aan, dan zal
	".$phpAds_productname." de staat van de database connectie exact hetzelfde achterlaten. Deze optie
	vertraagd ".$phpAds_productname." iets en staat daarom standaard uit.
";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
	Als de database die ".$phpAds_productname." gebruik wordt gedeeld met andere software producten is
	het verstandig om een voorvoegsel aan de namen van de tabellen te geven. Ook als u
	meerdere installaties van ".$phpAds_productname." gebruikt, welke gebruik maken van dezelfde database
	dient u bij elke installatie een uniek voorvoegsel te gebruiken.
";
		
$GLOBALS['phpAds_hlp_table_type'] = "
	".$phpAds_dbmsname." ondersteund meerdere types tabellen. Elk type heeft unieke eigenschappen en sommige
	tabeltypen kunnen de snelheid van ".$phpAds_productname." ten goede beinvloeden. MyISAM is de standaard
	tabel type en is beschikbaar in alle versies van ".$phpAds_dbmsname.". Andere tabeltypen zijn misschien
	niet aanwezig op uw server.
";

$GLOBALS['phpAds_hlp_url_prefix'] = "
	Om correct te functioneren moet ".$phpAds_productname." zijn eigen locatie op de webserver
	weten. U moet de volledige URL invoeren van de map waar ".$phpAds_productname." is geinstalleerd,
	bijvoorbeeld: http://www.uwwebsite.nl/".$phpAds_productname.".
";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
	U kunt hier het pad naar de voetnoot en eindnoot bestanden invoeren (bijv.
	/home/login/www/header.htm) indien u een voetnoot en/of eindnoot wil hebben
	op alle pagina's van de administratie interface. U kunt zowel gewone tekst
	bestanden als html bestanden gebruiken (indien u html wilt gebruiken in
	deze bestanden moet u niet de &lt;body> of &lt;html> tags gebruiken).
";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
	Door GZIP content compressie te gebruiken zal de data, die elke keer als een pagina
	van de administratie interface wordt opgevraagd naar uw browser gestuurd wordt, afnemen
	Om deze functie te kunnen gebruiken moet minimaal PHP 4.0.5 en de GZIP extentie op uw
	server geinstalleerd zijn.
";
		
$GLOBALS['phpAds_hlp_language'] = "
	Specificeer de standaard taal die ".$phpAds_productname." moet gebruiken. Deze taal zal
	worden gebruikt in de administratie en adverteerder interface. Opmerking:
	u kunt voor elke adverteerder een eigen taal instellen en adverteerders
	de mogelijkheid geven om deze taal zelf aan te passen.
";
		
$GLOBALS['phpAds_hlp_name'] = "
	Specificeer de naam die uw wilt gebruiken voor deze applicatie. De naam
	die u opgeeft zal worden getoond op elke pagina van de administratie en
	adverteerders interface. Indien u dit veld leeg laat zal het logo van 
	".$phpAds_productname." zelf getoond worden.
";
		
$GLOBALS['phpAds_hlp_company_name'] = "
	Specificeer de naam die gebruikt moet worden in alle e-mails die ".$phpAds_productname." verstuurd.
";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
	Normaal gesproken zal ".$phpAds_productname." zelf detecteren of de GD extentie is 
	geinstalleerd en welke formaten ondersteund worden door de geinstalleerde
	versie. Echter sommige versies van PHP kunnen de ondersteunde formaten niet 
	goed en/of accuraat detecteren. Indien de automatische detectie faalt, dan
	kunt u hier het juiste formaat instellen. Mogelijke formaten zijn:
	geen, png, jpeg of gif.	
";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
	Indien u gebruik wil maken van P3P Privacy Policies kunt u deze optie aanzetten.
	Hieronder kunt u exact de P3P instellingen exact configureren.
";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
	Een compacte policy wordt samen met cookies meegezonden. De standaard instelling
	is: 'CUR ADM OUR NOR STA NID'. Met de standaard instelling zal Internet
	Explorer 6 de cookies die door ".$phpAds_productname." gebruikt worden accepteren. Indien u
	wilt kunt u deze instelling aanpassen naar uw eigen privacy verklaring.
";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
	Indien u een volledige privacy policy wilt gebruiken kunt u hier de locatie
	invullen van het P3P policy bestand.
";
		
$GLOBALS['phpAds_hlp_log_beacon'] = "
	Beacons zijn kleine onzichtbare afbeeldingen welke op de pagina geplaatst worden
	waarop uw banners worden getoond. Als u deze optie aanzet zal ".$phpAds_productname." deze
	beacon afbeeldingen gebruiken om het aantal keer dat de banner gezien wordt te tellen.
	Als u deze functie niet gebruikt wordt het aantal keer dat de banner getoond wordt
	geteld op het moment dat de banner aangevraagd wordt, maar dit is niet geheel
	accuraat omdat een aangevraagde banner niet altijd of het scherm getoond hoeft te worden.
";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
	Traditioneel slaat ".$phpAds_productname." gedetailleerde data op bij elke impressie. Echter deze
	uitgebreide manier van opslaan kan veel vergen van de database server, wat een probleem
	kan zijn als uw website veel bezoekers heeft. Om dit probleem op te lossen is er nu
	een compactere manier van gegevens opslaan. Deze manier van opslaan vergt minder van
	de database server, maar is ook minder gedetailleerd.
";
		
$GLOBALS['phpAds_hlp_log_adviews'] = "
	Normaal gesproken worden alle AdViews bijgehouden, maar in het geval dat u geen
	statistieken wil bijhouden over het aantal AdViews, dan kunt u deze functie uitzetten.
";
		
$GLOBALS['phpAds_hlp_block_adviews'] = "
	Als een bezoeker de pagina ververst zal er iedere keer als de banner getoond wordt
	een nieuwe AdView worden opgeslagen door ".$phpAds_productname.". Deze optie zorgt er voor dat
	als een banner eenmaal getoond is deze niet meer wordt bijgehouden voor het aantal
	seconde dat hier ingesteld is. Bijvoorbeeld: als u dit veld insteld op 300 seconden,
	zal ".$phpAds_productname." alleen AdViews opslaan als de banner de laatste 5 minuten niet al
	eerder getoond is. Deze functie werkt alleen als de browser cookies accepteert.
";
		
$GLOBALS['phpAds_hlp_log_adclicks'] = "
	Normaal gesproken worden alle AdViews bijgehouden, maar in het geval dat u geen
	statistieken wilt bijhouden over het aantal AdClicks, dan kunt u deze functie uitzetten.
";
		
$GLOBALS['phpAds_hlp_block_adclicks'] = "
	Als een bezoeker meerdere keren om een banner klikt, zullen alle keren bijgehouden
	worden door ".$phpAds_productname.". Deze optie zorgt er voor dat als er eenmaal op een banner
	geklikt is, deze niet meer bijgehouden worden gedurende het aantal seconde dat u hier
	opgeeft. Bijvoorbeeld: als u dit veld insteld op 300 seconden, zal ".$phpAds_productname." alleen
	AdClicks bijhouden als er de laatste 300 seconde niet als op de banner geklikt is.
	Deze functie werkt alleen als <i>Gebruik beacons om AdViews te loggen</i> aan staat
	en de browser cookies accepteerd.
";
		
$GLOBALS['phpAds_hlp_log_source'] = "
	Als u de bron parameter gebruikt in de invocatie code dan kan ".$phpAds_productname." deze informatie
	opslaan in de database. U kunt dan statistieken bekijken over het gebruik van de bron parameter.
	Indien u de bron parameter niet gebruikt, of indien u geen informatie wilt opslaan over de bron parameter
	kunt u deze optie veilig uitschakelen.
";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "
	Als u een geotargeting database gebruikt kunt u de geografische informatie opslaan in de database.
	U bent dan in staat om statistieken te bekijken over de locaties van uw bezoekers en hoe elke
	banner presteert in de verschillende landen. Deze optie alleen toegankelijk als u de uitgebreide
	statistieken ingeschakeld heeft.
";

$GLOBALS['phpAds_hlp_log_hostname'] = "
	Indien u de domeinnaam of het IP adres van de bezoeker in uw statistieken wilt opnemen dan kunt
	u deze optie aanzetten. Door het opslaan van deze informatie bent u in staat om te kijken welke
	bezoekers de meeste banners bekijken. Deze optie is alleen toegankelijk als u de uitgebreide
	statistieken ingeschakeld heeft.
";
		
$GLOBALS['phpAds_hlp_log_iponly'] = "
	Het opslaan van de domeinnaam van de bezoeker neemt veel ruimte in binnen de database. Als u deze
	optie aanzet dan zal ".phpAds_productname." alleen het IP adres opslaan, wat veel minder ruimte inneemt.
	Deze optie is niet beschikbaar als de domeinnaam niet door de server doorgegeven wordt of bekend is
	bij ".$phpAds_productname.", omdat in dat geval zowiezo alleen het IP adres wordt opgeslagen.
";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "
	De domeinnaam van de bezoeker wordt meestal door de web server uitgezocht, maar in sommige gevallen
	kan dit uit staan. Als domeinnaam niet door de server wordt doorgegeven aan ".$phpAds_productname." en u 
	de domeinnaam van de bezoeker wilt gebruiken in leveringsopties en/of statistieken hierover wilt bijhouden,
	dan kunt u deze optie aanzetten. Het achterhalen van de domeinnaam kost tijd en zal daarom het
	tonen van de banners vertragen.
";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "
	Sommige gebruikers gebruiken een proxy server voor de toegang tot internet. In dat
	geval zal ".$phpAds_productname." het IP adres of de domeinnaam van de proxy server opslaan, inplaats 
	van de gebruiker. Als u deze functie aanzet, zal ".$phpAds_productname." proberen om het IP adres of
	de domeinnaam van de gebruiker achter de proxy server te achterhalen. Indien dit niet lukt zal 
	".$phpAds_productname." het adres van de proxy opslaan. Deze optie staat niet standaard aan
	omdat het achterhalen tijd kost en ".$phpAds_productname." zal vertragen.
";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
	Als u deze functie aanzet worden de verzamelde statistieken automatisch verwijderd na de door u
	gespecificeerde periode. Bijvoorbeeld, indien u de periode insteld op 5 weken, zullen alle statistieken
	welke ouder zijn dan 5 weken automatisch verwijderd worden.
";
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
	Als u deze functie zal automatisch alle verzamelde gegevens welke ouder zijn dan de door u gespecificeerde 
	period uit het gebruikers log verwijderen.
";
		
$GLOBALS['phpAds_hlp_geotracking_type'] = "
	Geotargeting stelt ".$phpAds_productname." in staat op het IP adres van de bezoeker om te zetten naar
	geografische informatie. Op basis van deze informatie kun u leverings beperkingen instellen of de
	informatie opslaan bij de statistieken, zodat u kunt zien welk land de meeste impressies genereerd.
	Indien u deze optie wilt gebruiken heeft u een database nodig en dient u het juiste type database uit deze 
	lijst te selecteren. ".$phpAds_productname." ondersteunt momenteel de IP2Country 
	en de <a href='http://www.maxmind.com/?rId=phpadsnew2' target='_blank'>GeoIP</a> database.
";
		
$GLOBALS['phpAds_hlp_geotracking_location'] = "
	Behalve als u de GeoIP Apache module gebruikt, dient u de locatie van de geotargeting database op te geven.
	Het wordt aangeraden om de database in een niet-publieke locatie op slaan, omdat het anders mogelijk is om
	de database van uw server af te downloaden.
";
		
$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
	Het converteren van een IP adres naar geografische informatie kost tijd. Om te voorkomen dat
	".$phpAds_productname." ieder keer als er een banner getoond moet worden dezelfde informatie om
	moet zetten, kan het resultaat in een cookie worden opgeslagen. Indien dit cookie door de browser
	wordt doorgegeven, zal ".$phpAds_productname." deze gegevens niet nogmaals proberen te achterhalen
	van het IP adres.
";
		
$GLOBALS['phpAds_hlp_ignore_hosts'] = "
	Indien u van sommige computers niet de AdViews en AdClicks wilt bijhouden
	kunt u het IP adres van de computer aan deze lijst toevoegen. Indien u
	Reverse lookup aan heeft staan kunt u ook domeinnamen in deze lijst gebruiken.
	U kunt ook een zgn. wildcard gebruiken (bijv. *.altavista.nl of 192.168.*).
";
		
$GLOBALS['phpAds_hlp_begin_of_week'] = "
	Voor de meeste mensen start een week op de Maandag, maar indien u in een land
	woont waar het gewoonte is dat de week op een Zondag start kunt dit hier instellen.
";
		
$GLOBALS['phpAds_hlp_percentage_decimals'] = "
	Specificeer hoe nauwkeurig achter de comma ".$phpAds_productname." moet rekenen.
";
		
$GLOBALS['phpAds_hlp_warn_admin'] = "
	".$phpAds_productname." kan u automatisch een e-mail sturen als een campagne op het staat
	punt om gedeactiveerd te worden. Deze staat standaard optie aan.
";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
	".$phpAds_productname." kan adverteerders automatisch per e-mail waarschuwen als hun campagnes
	op het punt staan om gedeactiveerd te worden. Deze optie staat standaard aan.
";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
	Sommige versies van qmail bevatten een fout, waardoor e-mail welke door ".$phpAds_productname."
	verstuurd wordt verminkt overkomt. Indien dit bij u het geval is, dan kunt u deze
	optie aanzetten, ".$phpAds_productname." zal dan haar e-mail versturen in een formaat wat
	wel goed door qmail begrepen wordt.
";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
	Door middel van dit veld kunt u instellen wanneer waarschuwingen per e-mail
	worden verstuurd. Als het aantal AdViews wat nog over is voor een campagne
	kleiner is dan dit getal dan worden automatisch e-mails verstuurd. Standaard
	is dit als er minder dan 100 AdViews over zijn.
";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
	Met deze instellingen kunt u beinvloeden welke invocatie types toegestaan zijn.
	Als een invocatie types niet toegestaan is, zal deze niet meer beschikbaar zijn
	in de bannercode generator. Belangrijk: de methode zelf zal nog steeds werken,
	alleen het genereren van nieuwe bannercodes zal niet meer toegestaan zijn.
";
		
$GLOBALS['phpAds_hlp_con_key'] = "
	".$phpAds_productname." bevat een krachtig system waarmee banners direct geselecteerd kunnen
	worden. Voor meer informatie lees de documentatie. Met deze optie kunt u
	conditionele sleutelwoorden activeren. Deze optie staat standaard aan. 
";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
	Indien u banners toont door middel van een directe selectie, kunt u een of
	meerdere sleutelwoorden specificeren voor elke banner. Deze optie moet aan
	staan als u meerdere sleutelwoorden wilt gebruiken. Standaard staat deze 
	optie aan.
";
		
$GLOBALS['phpAds_hlp_acl'] = "
	Indien u geen gebruik wilt maken van leverings beperkingen dan kunt u deze
	optie uitzetten. Dit zal ".$phpAds_productname." iets versnellen.
";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
	Als ".$phpAds_productname." geen connectie op kan bouwen met de database server, of indien
	er geen banner gevonden kan worden (bijv. omdat de database gecrashed of gewist
	is), dan is het mogelijk om een standaard banner te tonen. Voor de banner die u
	hier opgeeft zullen geen statistieken worden bijgehouden.
";

$GLOBALS['phpAds_hlp_delivery_caching'] = "
	Om het tonen van de banners te versnellen gebruikt ".$phpAds_productname." een <i>cache</i>
	om de informatie die nodig is om de banners te tonen tijdelijk op te slaan. De leveringscache
	wordt standaard opgeslagen in de database, maar om de het tonen van banners nog meer te versnellen
	kan deze informatie op opgeslagen worden in een normaal bestand of in gedeeld geheugen. Gedeeld
	geheugen is het snelste, opslaan in een bestand is bijna net zo snel. Het is niet aan te raden
	om de leveringscache uit te zetten, omdat dit de snelheid van ".$phpAds_productname." ernstig
	zal vertragen.
";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = "
	".$phpAds_productname." kan verschillende banner typen gebruiken en deze opslaan in
	verschillende manieren. De eerste twee opties worden gebruikt voor de
	lokale opslag van banners. Het is ook mogelijk om banners die opgeslagen
	zijn op een externe server, of HTML banners te gebruiken.
";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
	Indien u uw banners wilt opslaan op een webserver, dan moet u deze optie
	configureren. Indien u de banner wilt opslaan in een lokale map, zet dan
	dit veld op <i>Lokale map</i>. Indien u de banner wilt opslaan op een externe
	server, zet dan dit veld op <i>Externe FTP server</i>. Op sommige webservers
	is het verstandig om de tweede optie te gebruiken, zelfs al is de map
	waarin u de banner wilt opslaan lokaal bereikbaar is.
";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
	U kunt hier de map specificeren waar ".$phpAds_productname." de banners moet opslaan.
	Deze map moet te beschrijven zijn door PHP, wat mogelijk betekend dat u
	de UNIX permissies van de map moet aanpassen (chmod). De map moet bereikbaar
	zijn voor de webserver, zodat deze de banners direct kan aanbieden aan 
	de browser. U moet hier geen slash (/) aan het einde van locatie van de map 
	plaatsen. U hoeft deze instelling alleen te configureren als u gebruik maakt
	van de <i>Lokale map</i> methode.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u het
	IP adres of de domeinnaam van de FTP server, waar ".$phpAds_productname." de banners op moet
	opslaan, opgeven.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u de map
	opgeven op de FTP server, waar ".$phpAds_productname." de banners op moet opslaan, opgeven.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u de
	gebruikersnaam van de FTP server, waar ".$phpAds_productname." de banners op moet
	opslaan, opgeven.
";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u het
	wachtwoord van de FTP server, waar ".$phpAds_productname." de banners op moet
	opslaan, opgeven.
";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
	Indien u banners opslaat op de webserver, moet u ".$phpAds_productname." laten weten waar
	de banners via de webserver te vinden zijn. U moet hier de URL opgeven van
	de map die u eerder opgegeven heeft (zonder slash aan het einde).
";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
	Als deze optie aan staat zal ".$phpAds_productname." automatisch de HTML banners aanpassen,
	zodat deze geschikt worden voor het bijhouden van AdClicks. Echter het is
	nog steeds mogelijk om deze optie per banner uit te schakelen.
";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
	Als deze optie aan staat is het mogelijk om PHP code te gebruiken in HTML
	banners. Deze optie staat standaard uit.
";
		
$GLOBALS['phpAds_hlp_admin'] = "
	U kunt hier de gebruikersnaam van de beheerder instellen. Met deze
	gebruikersnaam krijgt u toegang tot de administratie interface.
";
		
$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
	Vul hier het wachtwoord at u wilt gebruiken om toegang te krijgen tot
	de administratie interface. U dient het wachtwoord twee maal in te vullen
	om typefouten te voorkomen.
";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
	Om het wachtwoord van de beheerder te veranderen dient u eerst het
	oude wachtwoord in te vullen, en daaronder tweemaal het nieuwe wachtwoord.
	U moet dit dubbel invullen, om typefouten te voorkomen.
";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
        U kunt hier de volledige naam van de beheerder invullen. Deze naam wordt
	gebruikt in de e-mails die ".$phpAds_productname." verstuurd.
";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
	U kunt hier het e-mail adres van de beheerder invullen. Dit adres zal
	gebruikt worden als afzenden van alle e-mail die ".$phpAds_productname." verstuurd.
";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
	U kunt in dit veld extra headers toevoegen aan de e-mail die ".$phpAds_productname." verstuurd.
";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
	Indien u een waarschuwing wilt krijgen voordat u adverteerders, campagnes of
	banners verwijder, moet u deze optie aanzetten.
";
		
$GLOBALS['phpAds_hlp_client_welcome'] = 
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
	Als u deze functie aanzet zal er een welkomstbericht getoond worden op de
	eerste pagina die de adverteerder ziet als hij inlogd. U kunt dit bericht
	personaliseren door het bestand 'welcome.html' te wijzigen welke te vinden
	is in de 'admin/templates' map. U kunt bijvoorbeeld de naam van uw bedrijf, 
	uw logo, contact informatie en een link naar een pagina met advertentie
	tarieven toevoegen.
";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
	Indien u wilt dat ".$phpAds_productname." automatisch controleerd of er nieuwere versies
	beschikbaar zijn kunt u hier instellen hoevaak deze controle wordt uitgevoerd.
	Indien een nieuwe versie beschikbaar is zal er een nieuw venster verschijnen met
	daarin extra informatie over de nieuwere versie.
";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
	Indien u een kopie wilt bewaren van alle e-mail berichten die ".$phpAds_productname." verzend
	dan kunt u deze optie aanzetten. De e-mail berichten worden opgeslagen in de
	gebruikers log.
";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
	Als u zeker wilt weten dat de prioriteit berekeningen correct verlopen zijn kunt u
	een rapport hierover opslaan. Het rapport bevat het voorspelde profiel en hoe
	de prioriteiten verdeeld zijn over de banners. Deze informatie is handig wanneer
	u een fout wilt melden bij de makers van ".$phpAds_productname.". De rapporten worden opgeslagen
	in de gebruikers log.
";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
	Om er zeker van te zijn dat de database correct was opgeschoont kun een een rapport
	op laten slaan met daarin informatie over wat werkelijk gebeurt is tijdens het opschonen.
	Deze informatie zal worden opgeslagen in de gebruikers log.
";
		
$GLOBALS['phpAds_hlp_default_banner_weight'] = "
	Indien u standaard een hoger gewicht wilt geven aan banners, dan kunt u hier het
	gewenste gewicht instellen. Deze optie staat standaard op 1.
";
		
$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
	Indien u standaard een hoger gewicht wilt geven aan campagnes, dan kunt u hier het
	gewenste gewicht instellen. Deze optie staat standaard op 1.
";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
	Als deze optie aan staat, wordt er extra informatie over elke campagne getoond op de
	<i>Campagne overzicht</i> pagina. De extra informatie bevat o.a. het overgebleven aantal
	AdViews en AdClicks, de activeringsdatum, de vervaldatum en de prioriteit
	instellingen.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
	Als deze optie aan staat, wordt er extra informatie over elke banner getoond op de
	<i>Banner overzicht</i> pagina. De extra informatie bevat o.a. de doel URL, sleutelwoorden,
	grootte en gewicht.
";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
	Als deze optie aan staat, wordt er een voorbeeld van alle banners getoond op de <i>Banner 
	overzicht</i> pagina. Als deze optie niet aan staat is het nog steeds mogelijk een een voorbeeld
	van een banner te zien, door op de driehoek naast elke banner op de <i>Banner overzicht</i>
	pagina te klikken.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
	Als deze optie aan staat wordt de HTML banner zelf getoond in plaats van de HTML code. Deze
	optie staat standaard uit, omdat de HTML code in sommige gevallen storend kan werken op de
	pagina van de administratie interface. Als deze optie uit staat dan is het nog steeds mogelijk
	om de werkelijke banner te zien, door te klikken op <i>Toon banner</i> knop naast de HTML
	code.
";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
	Als deze optie aan staat wordt er een voorbeeld van de banner getoond aan de bovenkant van
	de <i>Banner eigenschappen</i>, <i>Leveringsopties</i> en <i>Gekoppelde zones</i> pagina's.
	Als deze optie uit staat is het nog steeds mogelijk om een voorbeeld te bekijken door te 
	klikken op de <i>Toon banner</i> knop bovenaan de pagina.
";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
	Als deze optie aan staat worden alle niet-actieve banners, campagnes en adverteerders verborgen
	op de <i>Adverteerders & campagnes</i> en <i>Campagne overzicht</i> pagina's. Als deze optie
	aan staat is het mogelijk om de verborgen items te tonen door te klikken op de <i>Toon alles</i>
	knop onderaan de pagina.
";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "
	Als deze optie aanstaat zullen, indien <i>Campagne selectie</i> is gekozen, de bijpassende banners 
	getoond worden op de <i>Gekoppelde banners</i> pagina. Dit stelt u in staat om exact te zien welke
	banners mogelijk getoond worden als deze campagne daadwerkelijk gekoppeld wordt aan de zone. Het zal 
	ook mogelijk worden een een voorbeeld op te roepen van alle banners welke (indirect) gekoppeld zijn
	aan de campagne.
";
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = "
	Als de optie aanstaat zullen, indien <i>Banner selectie</i> is gekozen, de bijbehorende campagnes waartoe
	de banners behoren getoond worden op de <i>Gekoppelde banners</i> pagina. Dit stelt u ook in staat om 
	te zien welke banners bij welke campagne horen, voordat de banner gekoppeld is aan de zone. Dit betekend
	ook dat de banners gegroepeerd per campagne getoond worden. De lijst met banners wordt niet meer alfabetisch
	gesorteerd.
";
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
	Standaard zullen alle beschikbare banner of campagnes getoond worden op de <i>Gekoppelde banners</i> pagina.
	Hierdoor kan deze pagina erg lang kan worden indien er veel verschillende banners beschikbaar zijn. Deze
	optie staat u in staat om de gekoppelde banners op een compactere manier te tonen, indien de lijst erg lang
	wordt.
";
	
?>