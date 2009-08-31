<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$GLOBALS['phpAds_hlp_dbhost'] = "\n	Vul hier het IP adres of de domeinnaam van de ".$phpAds_dbmsname." database server in.\n";

$GLOBALS['phpAds_hlp_dbuser'] = "\n        Vul hier de gebruikersnaam in wat ".MAX_PRODUCT_NAME." moet gebruiken om toegang te krijgen tot de\n	".$phpAds_dbmsname." database server.\n";

$GLOBALS['phpAds_hlp_dbpassword'] = "\n	Vul hier het wachtwoord in wat ".MAX_PRODUCT_NAME." moet gebruiken om toegang te krijgen tot de\n	".$phpAds_dbmsname." database server.\n";

$GLOBALS['phpAds_hlp_dbname'] = "\n	Vul hier de naam van de database in welke ".MAX_PRODUCT_NAME." moet gebruiken om gegevens\n	op te slaan.\n";

$GLOBALS['phpAds_hlp_persistent_connections'] = "\n	Door gebruik te maken van persistent connections met de database kan de snelheid\n	van ".MAX_PRODUCT_NAME." toenemen. Het is tevens van invloed op de belasting van de server. \n	Echter wanneer uw website veel bezoekers heeft kan de belasting van de\n	database server groter worden dan wanneer deze optie uit staat. Of het verstandig\n	is om deze optie gebruiken hangt geheel af van het aantal bezoekers en de hardware\n	die u gebruikt. Indien ".MAX_PRODUCT_NAME." een te hoge belasting op de database server veroorzaakt\n	kunt u proberen om deze optie uit te schakelen.\n";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "\n	Indien u problemen heeft met het integreren van ".MAX_PRODUCT_NAME." in een ander product dan\n	kan het helpen om de database compatibiliteits mode aan te zetten. Indien u banners toont\n	door middel van de Locale mode en de database compatibiliteit mode staat aan, dan zal\n	".MAX_PRODUCT_NAME." de staat van de database connectie exact hetzelfde achterlaten. Deze optie\n	vertraagd ".MAX_PRODUCT_NAME." iets en staat daarom standaard uit.\n";

$GLOBALS['phpAds_hlp_table_prefix'] = "\n	Als de database die ".MAX_PRODUCT_NAME." gebruik wordt gedeeld met andere software producten is\n	het verstandig om een voorvoegsel aan de namen van de tabellen te geven. Ook als u\n	meerdere installaties van ".MAX_PRODUCT_NAME." gebruikt, welke gebruik maken van dezelfde database\n	dient u bij elke installatie een uniek voorvoegsel te gebruiken.\n";

$GLOBALS['phpAds_hlp_tabletype'] = "\n	".$phpAds_dbmsname." ondersteund meerdere types tabellen. Elk type heeft unieke eigenschappen en sommige\n	tabeltypen kunnen de snelheid van ".MAX_PRODUCT_NAME." ten goede beinvloeden. MyISAM is de standaard\n	tabel type en is beschikbaar in alle versies van ".$phpAds_dbmsname.". Andere tabeltypen zijn misschien\n	niet aanwezig op uw server.\n";

$GLOBALS['phpAds_hlp_url_prefix'] = "\n	Om correct te functioneren moet ".MAX_PRODUCT_NAME." zijn eigen locatie op de webserver\n	weten. U moet de volledige URL invoeren van de map waar ".MAX_PRODUCT_NAME." is geinstalleerd,\n	bijvoorbeeld: http://www.uwwebsite.nl/".MAX_PRODUCT_NAME.".\n";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "\n	U kunt hier het pad naar de voetnoot en eindnoot bestanden invoeren (bijv.\n	/home/login/www/header.htm) indien u een voetnoot en/of eindnoot wil hebben\n	op alle pagina's van de administratie interface. U kunt zowel gewone tekst\n	bestanden als html bestanden gebruiken (indien u html wilt gebruiken in\n	deze bestanden moet u niet de <body> of <html> tags gebruiken).\n";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "\n	Door GZIP content compressie te gebruiken zal de data, die elke keer als een pagina\n	van de administratie interface wordt opgevraagd naar uw browser gestuurd wordt, afnemen\n	Om deze functie te kunnen gebruiken moet minimaal PHP 4.0.5 en de GZIP extentie op uw\n	server geinstalleerd zijn.\n";

$GLOBALS['phpAds_hlp_language'] = "\n	Specificeer de standaard taal die ".MAX_PRODUCT_NAME." moet gebruiken. Deze taal zal\n	worden gebruikt in de administratie en adverteerder interface. Opmerking:\n	u kunt voor elke adverteerder een eigen taal instellen en adverteerders\n	de mogelijkheid geven om deze taal zelf aan te passen.\n";

$GLOBALS['phpAds_hlp_name'] = "\n	Specificeer de naam die uw wilt gebruiken voor deze applicatie. De naam\n	die u opgeeft zal worden getoond op elke pagina van de administratie en\n	adverteerders interface. Indien u dit veld leeg laat zal het logo van \n	".MAX_PRODUCT_NAME." zelf getoond worden.\n";

$GLOBALS['phpAds_hlp_company_name'] = "Specificeer de naam die gebruikt moet worden in alle e-mails die ". MAX_PRODUCT_NAME ." verstuurd.";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "\n	Normaal gesproken zal ".MAX_PRODUCT_NAME." zelf detecteren of de GD extentie is \n	geinstalleerd en welke formaten ondersteund worden door de geinstalleerde\n	versie. Echter sommige versies van PHP kunnen de ondersteunde formaten niet \n	goed en/of accuraat detecteren. Indien de automatische detectie faalt, dan\n	kunt u hier het juiste formaat instellen. Mogelijke formaten zijn:\n	geen, png, jpeg of gif.	\n";

$GLOBALS['phpAds_hlp_p3p_policies'] = "\n	Indien u gebruik wil maken van P3P Privacy Policies kunt u deze optie aanzetten.\n	Hieronder kunt u exact de P3P instellingen exact configureren.\n";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "\n	Een compacte policy wordt samen met cookies meegezonden. De standaard instelling\n	is: 'CUR ADM OUR NOR STA NID'. Met de standaard instelling zal Internet\n	Explorer 6 de cookies die door ".MAX_PRODUCT_NAME." gebruikt worden accepteren. Indien u\n	wilt kunt u deze instelling aanpassen naar uw eigen privacy verklaring.\n";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "\n	Indien u een volledige privacy policy wilt gebruiken kunt u hier de locatie\n	invullen van het P3P policy bestand.\n";

$GLOBALS['phpAds_hlp_compact_stats'] = "\n	Traditioneel slaat ".MAX_PRODUCT_NAME." gedetailleerde data op bij elke impressie. Echter deze\n	uitgebreide manier van opslaan kan veel vergen van de database server, wat een probleem\n	kan zijn als uw website veel bezoekers heeft. Om dit probleem op te lossen is er nu\n	een compactere manier van gegevens opslaan. Deze manier van opslaan vergt minder van\n	de database server, maar is ook minder gedetailleerd.\n";

$GLOBALS['phpAds_hlp_log_adviews'] = "\n	Normaal gesproken worden alle AdViews bijgehouden, maar in het geval dat u geen\n	statistieken wil bijhouden over het aantal AdViews, dan kunt u deze functie uitzetten.\n";

$GLOBALS['phpAds_hlp_block_adviews'] = "\n	Als een bezoeker de pagina ververst zal er iedere keer als de banner getoond wordt\n	een nieuwe AdView worden opgeslagen door ".MAX_PRODUCT_NAME.". Deze optie zorgt er voor dat\n	als een banner eenmaal getoond is deze niet meer wordt bijgehouden voor het aantal\n	seconde dat hier ingesteld is. Bijvoorbeeld: als u dit veld insteld op 300 seconden,\n	zal ".MAX_PRODUCT_NAME." alleen AdViews opslaan als de banner de laatste 300 seconden niet al\n	eerder getoond is. Deze functie werkt alleen als <i>Gebruik beacons om AdViews te\n	loggen</i> aan staat en de browser cookies accepteerd.\n";

$GLOBALS['phpAds_hlp_log_adclicks'] = "\n	Normaal gesproken worden alle AdViews bijgehouden, maar in het geval dat u geen\n	statistieken wilt bijhouden over het aantal AdClicks, dan kunt u deze functie uitzetten.\n";

$GLOBALS['phpAds_hlp_block_adclicks'] = "\n	Als een bezoeker meerdere keren om een banner klikt, zullen alle keren bijgehouden\n	worden door ".MAX_PRODUCT_NAME.". Deze optie zorgt er voor dat als er eenmaal op een banner\n	geklikt is, deze niet meer bijgehouden worden gedurende het aantal seconde dat u hier\n	opgeeft. Bijvoorbeeld: als u dit veld insteld op 300 seconden, zal ".MAX_PRODUCT_NAME." alleen\n	AdClicks bijhouden als er de laatste 300 seconde niet als op de banner geklikt is.\n	Deze functie werkt alleen als <i>Gebruik beacons om AdViews te loggen</i> aan staat\n	en de browser cookies accepteerd.\n";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "\n	Standaard slaat ".MAX_PRODUCT_NAME." het IP adres van elke gebruiker op. Indien u wilt dat\n	".MAX_PRODUCT_NAME." de domeinnaam van de gebruiker wilt bijhouden kunt u deze functie aanzetten.\n	Het achterhalen van de domeinnaam kost tijd en zal daarom ".MAX_PRODUCT_NAME." vertragen.\n";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "\n	Sommige gebruikers gebruiken een proxy server voor de toegang tot internet. In dat\n	geval zal ".MAX_PRODUCT_NAME." het IP adres van de proxy server opslaan, inplaats het IP adres\n	van de gebruiker. Als u deze functie aanzet, zal ".MAX_PRODUCT_NAME." proberen om het IP adres\n	van de gebruiker achter de proxy server te achterhalen. Indien dit niet lukt zal \n	".MAX_PRODUCT_NAME." het IP adres van de proxy opslaan. Deze optie staat niet standaard aan\n	omdat het achterhalen van het IP adres tijd kost en ".MAX_PRODUCT_NAME." zal vertragen.\n";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "\n	Indien u van sommige computers niet de AdViews en AdClicks wilt bijhouden\n	kunt u het IP adres van de computer aan deze lijst toevoegen. Indien u\n	Reverse lookup aan heeft staan kunt u ook domeinnamen in deze lijst gebruiken.\n	U kunt ook een zgn. wildcard gebruiken (bijv. *.altavista.nl of 192.168.*).\n";

$GLOBALS['phpAds_hlp_begin_of_week'] = "\n	Voor de meeste mensen start een week op de Maandag, maar indien u in een land\n	woont waar het gewoonte is dat de week op een Zondag start kunt dit hier instellen.\n";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "\n	Specificeer hoe nauwkeurig achter de comma ".MAX_PRODUCT_NAME." moet rekenen.\n";

$GLOBALS['phpAds_hlp_warn_admin'] = "\n	".MAX_PRODUCT_NAME." kan u automatisch een e-mail sturen als een campagne op het staat\n	punt om gedeactiveerd te worden. Deze staat standaard optie aan.\n";

$GLOBALS['phpAds_hlp_warn_client'] = "\n	".MAX_PRODUCT_NAME." kan adverteerders automatisch per e-mail waarschuwen als hun campagnes\n	op het punt staan om gedeactiveerd te worden. Deze optie staat standaard aan.\n";

$GLOBALS['phpAds_hlp_qmail_patch'] = "Sommige versies van qmail bevatten een fout, waardoor e-mail welke door ". MAX_PRODUCT_NAME ."\nverstuurd wordt verminkt overkomt. Indien dit bij u het geval is, dan kunt u deze\noptie aanzetten, ". MAX_PRODUCT_NAME ." zal dan haar e-mail versturen in een formaat wat\nwel goed door qmail begrepen wordt.";

$GLOBALS['phpAds_hlp_warn_limit'] = "\n	Door middel van dit veld kunt u instellen wanneer waarschuwingen per e-mail\n	worden verstuurd. Als het aantal AdViews wat nog over is voor een campagne\n	kleiner is dan dit getal dan worden automatisch e-mails verstuurd. Standaard\n	is dit als er minder dan 100 AdViews over zijn.\n";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "\n	Met deze instellingen kunt u beinvloeden welke invocatie types toegestaan zijn.\n	Als een invocatie types niet toegestaan is, zal deze niet meer beschikbaar zijn\n	in de bannercode generator. Belangrijk: de methode zelf zal nog steeds werken,\n	alleen het genereren van nieuwe bannercodes zal niet meer toegestaan zijn.\n";

$GLOBALS['phpAds_hlp_con_key'] = "\n	".MAX_PRODUCT_NAME." bevat een krachtig system waarmee banners direct geselecteerd kunnen\n	worden. Voor meer informatie lees de documentatie. Met deze optie kunt u\n	conditionele sleutelwoorden activeren. Deze optie staat standaard aan. \n";

$GLOBALS['phpAds_hlp_mult_key'] = "\n	Indien u banners toont door middel van een directe selectie, kunt u een of\n	meerdere sleutelwoorden specificeren voor elke banner. Deze optie moet aan\n	staan als u meerdere sleutelwoorden wilt gebruiken. Standaard staat deze \n	optie aan.\n";

$GLOBALS['phpAds_hlp_acl'] = "\n	Indien u geen gebruik wilt maken van leverings beperkingen dan kunt u deze\n	optie uitzetten. Dit zal ".MAX_PRODUCT_NAME." iets versnellen.\n";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "\n	Als ".MAX_PRODUCT_NAME." geen connectie op kan bouwen met de database server, of indien\n	er geen banner gevonden kan worden (bijv. omdat de database gecrashed of gewist\n	is), dan is het mogelijk om een standaard banner te tonen. Voor de banner die u\n	hier opgeeft zullen geen statistieken worden bijgehouden.\n";

$GLOBALS['phpAds_hlp_zone_cache'] = "\n	Indien u gebruik maakt van de zonecache worden tussentijdse informatie\n	zoals de banner gegevens tijdelijk opgeslagen. Hierdoor kan als de zone\n	nog een keer aangeroepen wordt de tussentijdse informatie gebruikt worden\n	waardoor deze niet iedere opnieuw aangemaakt hoeft te worden. Deze optie\n	staat standaard aan.\n";

$GLOBALS['phpAds_hlp_zone_cache_limit'] = "\n	Indien u gebruik van de van de zonecache kan het voorkomen dat de tussentijdse\n	informatie verouderd wordt. Eens in de zoveel tijd zal de tussentijdse\n	informatie ververst moeten worden, zodat bijv. nieuwe banners ook opgeslagen\n	worden. Met deze optie kunt u bepalen hoelang de tussentijdse informatie\n	maximaal gebruikt kan worden, voordat deze ververst moet worden. Bijvoorbeeld:\n	als deze optie ingesteld wordt op 600 seconden, zal de tussentijdse informatie\n	na 10 minuten verouderd raken en opnieuw ververst worden.\n";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] = "\n	".MAX_PRODUCT_NAME." kan verschillende banner typen gebruiken en deze opslaan in\n	verschillende manieren. De eerste twee opties worden gebruikt voor de\n	lokale opslag van banners. Het is ook mogelijk om banners die opgeslagen\n	zijn op een externe server, of HTML banners te gebruiken.\n";

$GLOBALS['phpAds_hlp_type_web_mode'] = "\n	Indien u uw banners wilt opslaan op een webserver, dan moet u deze optie\n	configureren. Indien u de banner wilt opslaan in een lokale map, zet dan\n	dit veld op <i>Lokale map</i>. Indien u de banner wilt opslaan op een externe\n	server, zet dan dit veld op <i>Externe FTP server</i>. Op sommige webservers\n	is het verstandig om de tweede optie te gebruiken, zelfs al is de map\n	waarin u de banner wilt opslaan lokaal bereikbaar is.\n";

$GLOBALS['phpAds_hlp_type_web_dir'] = "\n	U kunt hier de map specificeren waar ".MAX_PRODUCT_NAME." de banners moet opslaan.\n	Deze map moet te beschrijven zijn door PHP, wat mogelijk betekend dat u\n	de UNIX permissies van de map moet aanpassen (chmod). De map moet bereikbaar\n	zijn voor de webserver, zodat deze de banners direct kan aanbieden aan \n	de browser. U moet hier geen slash (/) aan het einde van locatie van de map \n	plaatsen. U hoeft deze instelling alleen te configureren als u gebruik maakt\n	van de <i>Lokale map</i> methode.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "\n	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u het\n	IP adres of de domeinnaam van de FTP server, waar ".MAX_PRODUCT_NAME." de banners op moet\n	opslaan, opgeven.\n";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "\n	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u de map\n	opgeven op de FTP server, waar ".MAX_PRODUCT_NAME." de banners op moet opslaan, opgeven.\n";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "\n	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u de\n	gebruikersnaam van de FTP server, waar ".MAX_PRODUCT_NAME." de banners op moet\n	opslaan, opgeven.\n";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "\n	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u het\n	wachtwoord van de FTP server, waar ".MAX_PRODUCT_NAME." de banners op moet\n	opslaan, opgeven.\n";

$GLOBALS['phpAds_hlp_type_web_url'] = "\n	Indien u banners opslaat op de webserver, moet u ".MAX_PRODUCT_NAME." laten weten waar\n	de banners via de webserver te vinden zijn. U moet hier de URL opgeven van\n	de map die u eerder opgegeven heeft (zonder slash aan het einde).\n";

$GLOBALS['phpAds_hlp_type_html_auto'] = "\n	Als deze optie aan staat zal ".MAX_PRODUCT_NAME." automatisch de HTML banners aanpassen,\n	zodat deze geschikt worden voor het bijhouden van AdClicks. Echter het is\n	nog steeds mogelijk om deze optie per banner uit te schakelen.\n";

$GLOBALS['phpAds_hlp_type_html_php'] = "\n	Als deze optie aan staat is het mogelijk om PHP code te gebruiken in HTML\n	banners. Deze optie staat standaard uit.\n";

$GLOBALS['phpAds_hlp_admin'] = "\n	U kunt hier de gebruikersnaam van de beheerder instellen. Met deze\n	gebruikersnaam krijgt u toegang tot de administratie interface.\n";

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "\n	Vul hier het wachtwoord at u wilt gebruiken om toegang te krijgen tot\n	de administratie interface. U dient het wachtwoord twee maal in te vullen\n	om typefouten te voorkomen.\n";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "\n	Om het wachtwoord van de beheerder te veranderen dient u eerst het\n	oude wachtwoord in te vullen, en daaronder tweemaal het nieuwe wachtwoord.\n	U moet dit dubbel invullen, om typefouten te voorkomen.\n";

$GLOBALS['phpAds_hlp_admin_fullname'] = "\n        U kunt hier de volledige naam van de beheerder invullen. Deze naam wordt\n	gebruikt in de e-mails die ".MAX_PRODUCT_NAME." verstuurd.\n";

$GLOBALS['phpAds_hlp_admin_email'] = "Het e-mail adres van de administrator. Dit wordt gebruikt als \"afzender\" adres wanneer";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "\n	U kunt in dit veld extra headers toevoegen aan de e-mail die ".MAX_PRODUCT_NAME." verstuurd.\n";

$GLOBALS['phpAds_hlp_admin_novice'] = "Indien u een waarschuwing wilt krijgen voordat u adverteerders, campagnes of banners verwijder, moet u deze optie aanzetten.";

$GLOBALS['phpAds_hlp_client_welcome'] =
$GLOBALS['phpAds_hlp_client_welcome_msg'] = "\n	Als u deze functie aanzet zal er een welkomstbericht getoond worden op de\n	eerste pagina die de adverteerder ziet als hij inlogd. U kunt dit bericht\n	personaliseren door het bestand 'welcome.html' te wijzigen welke te vinden\n	is in de 'admin/templates' map. U kunt bijvoorbeeld de naam van uw bedrijf, \n	uw logo, contact informatie en een link naar een pagina met advertentie\n	tarieven toevoegen.\n";

$GLOBALS['phpAds_hlp_updates_frequency'] = "\n	Indien u wilt dat ".MAX_PRODUCT_NAME." automatisch controleerd of er nieuwere versies\n	beschikbaar zijn kunt u hier instellen hoevaak deze controle wordt uitgevoerd.\n	Indien een nieuwe versie beschikbaar is zal er een nieuw venster verschijnen met\n	daarin extra informatie over de nieuwere versie.\n";

$GLOBALS['phpAds_hlp_userlog_email'] = "\n	Indien u een kopie wilt bewaren van alle e-mail berichten die ".MAX_PRODUCT_NAME." verzend\n	dan kunt u deze optie aanzetten. De e-mail berichten worden opgeslagen in de\n	gebruikers log.\n";

$GLOBALS['phpAds_hlp_userlog_priority'] = "\n	Als u zeker wilt weten dat de prioriteit berekeningen correct verlopen zijn kunt u\n	een rapport hierover opslaan. Het rapport bevat het voorspelde profiel en hoe\n	de prioriteiten verdeeld zijn over de banners. Deze informatie is handig wanneer\n	u een fout wilt melden bij de makers van ".MAX_PRODUCT_NAME.". De rapporten worden opgeslagen\n	in de gebruikers log.\n";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "\n	Indien u standaard een hoger gewicht wilt geven aan banners, dan kunt u hier het\n	gewenste gewicht instellen. Deze optie staat standaard op 1.\n";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "\n	Indien u standaard een hoger gewicht wilt geven aan campagnes, dan kunt u hier het\n	gewenste gewicht instellen. Deze optie staat standaard op 1.\n";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "\n	Als deze optie aan staat, wordt er extra informatie over elke campagne getoond op de\n	<i>Campagne overzicht</i> pagina. De extra informatie bevat o.a. het overgebleven aantal\n	AdViews en AdClicks, de activeringsdatum, de vervaldatum en de prioriteit\n	instellingen.\n";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "\n	Als deze optie aan staat, wordt er extra informatie over elke banner getoond op de\n	<i>Banner overzicht</i> pagina. De extra informatie bevat o.a. de doel URL, sleutelwoorden,\n	grootte en gewicht.\n";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "\n	Als deze optie aan staat, wordt er een voorbeeld van alle banners getoond op de <i>Banner \n	overzicht</i> pagina. Als deze optie niet aan staat is het nog steeds mogelijk een een voorbeeld\n	van een banner te zien, door op de driehoek naast elke banner op de <i>Banner overzicht</i>\n	pagina te klikken.\n";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "\n	Als deze optie aan staat wordt de HTML banner zelf getoond in plaats van de HTML code. Deze\n	optie staat standaard uit, omdat de HTML code in sommige gevallen storend kan werken op de\n	pagina van de administratie interface. Als deze optie uit staat dan is het nog steeds mogelijk\n	om de werkelijke banner te zien, door te klikken op <i>Toon banner</i> knop naast de HTML\n	code.\n";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "\n	Als deze optie aan staat wordt er een voorbeeld van de banner getoond aan de bovenkant van\n	de <i>Banner eigenschappen</i>, <i>Leveringsopties</i> en <i>Gekoppelde zones</i> pagina's.\n	Als deze optie uit staat is het nog steeds mogelijk om een voorbeeld te bekijken door te \n	klikken op de <i>Toon banner</i> knop bovenaan de pagina.\n";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "\n	Als deze optie aan staat worden alle niet-actieve banners, campagnes en adverteerders verborgen\n	op de <i>Adverteerders & campagnes</i> en <i>Campagne overzicht</i> pagina's. Als deze optie\n	aan staat is het mogelijk om de verborgen items te tonen door te klikken op de <i>Toon alles</i>\n	knop onderaan de pagina.\n";

?>