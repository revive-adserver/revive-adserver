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
$GLOBALS['phpAds_hlp_dbhost'] = "Geef de hostname van de {$phpAds_dbmsname}-databaseserver waarnaar u verbinding probeert te maken.";

$GLOBALS['phpAds_hlp_dbport'] = "Geef het poortnummer van de {$phpAds_dbmsname}-databaseserver waarnaar u verbinding probeert te maken.";

$GLOBALS['phpAds_hlp_dbuser'] = "Geef de gebruikersnaam die {$PRODUCT_NAME} moet gebruiken om toegang te krijgen tot de {$phpAds_dbmsname}-databaseserver.";

$GLOBALS['phpAds_hlp_dbpassword'] = "Geef het wachtwoord dat {$PRODUCT_NAME} moet gebruiken om toegang te krijgen tot de {$phpAds_dbmsname}-databaseserver.";

$GLOBALS['phpAds_hlp_dbname'] = "Geef de naam van de database op de databaseserver waar {$PRODUCT_NAME} de gegevens moet opslaan. Belangrijk: de database moet al zijn gemaakt op de databaseserver. {$PRODUCT_NAME} zal maken deze database <b>niet</b>als deze nog niet bestaat.";

$GLOBALS['phpAds_hlp_persistent_connections'] = "	Door gebruik te maken van persistent connections met de database kan de snelheid
	van {$PRODUCT_NAME} toenemen. Het is tevens van invloed op de belasting van de server.
	Echter, wanneer uw website veel bezoekers heeft kan de belasting van de
	database server groter worden dan wanneer deze optie uit staat. Of het verstandig
	is om deze optie gebruiken hangt geheel af van het aantal bezoekers en de hardware
	die u gebruikt. Indien {$PRODUCT_NAME} een te hoge belasting op de database server veroorzaakt
	kunt u proberen om deze optie uit te schakelen.";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "	Indien u problemen heeft met het integreren van {$PRODUCT_NAME} in een ander product dan
	kan het helpen om de database compatibiliteits mode aan te zetten. Indien u banners toont
	door middel van de Locale mode en de database compatibiliteit mode staat aan, dan zal
	{$PRODUCT_NAME} de staat van de database connectie exact hetzelfde achterlaten. Deze optie
	vertraagd {$PRODUCT_NAME} iets en staat daarom standaard uit.";

$GLOBALS['phpAds_hlp_table_prefix'] = "	Als de database die {$PRODUCT_NAME} gebruik wordt gedeeld met andere software producten is
	het verstandig om een voorvoegsel aan de namen van de tabellen te geven. Ook als u
	meerdere installaties van {$PRODUCT_NAME} gebruikt, welke gebruik maken van dezelfde database
	dient u bij elke installatie een uniek voorvoegsel te gebruiken.";

$GLOBALS['phpAds_hlp_table_type'] = "MySQL ondersteunt meerdere tabel typen. Elk type tabel heeft unieke eigenschappen en sommige kunnen {$PRODUCT_NAME} aanzienlijk versnellen. MyISAM is de standaard tabelweergavetype en is beschikbaar in alle installaties van MySQL. Andere tabeltypes zijn mogelijk niet beschikbaar op uw server.";

$GLOBALS['phpAds_hlp_url_prefix'] = "{$PRODUCT_NAME} moet weten waar het zich bevindt op de webserver om juist te kunnen werken. U dient de URL in te vullen van de directory waar {$PRODUCT_NAME} is geïnstalleerd, bijvoorbeeld: <i>http://www.your-url.com/ads</i>.";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "{$PRODUCT_NAME} moet weten waar het zich bevindt op de webserver om juist te kunnen werken. Soms is het SSL voorvoegsel anders dan de gewone URL prefix. U dient de URL in te vullen van de directory waar {$PRODUCT_NAME} is geïnstalleerd, bijvoorbeeld: <i>https://www.your-url.com/ads</i>.";

$GLOBALS['phpAds_hlp_my_header'] = $GLOBALS['phpAds_hlp_my_footer'] = "Hier dient u het path naar de header files (bijvoorbeeld: /home/login/www/header.htm) om een header en/of footer toe te voegen aan elke pagina van de beheersinterface. U kunt tekst of HTML code in deze files plaatsen (als u HTML wilt gebruiken, gebruik dan geen tags zoals <body> of <html>).";

$GLOBALS['phpAds_hlp_my_logo'] = "Hier kunt u de naam van een aangepast logo bestand invoeren, dat u wilt vertonen in plaats van het standaard logo. Het logo moet worden geplaatst in de admin/images director voordat u de bestandsnaam hier invoert.";

$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "U kunt hier een aangepaste kleur instellen die gebruikt zal worden voor tabbladen, de zoekbalk en sommige tekst in vet.";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "U kunt hier een aangepast kleur invoeren die zal worden gebruikt voor de achtergrond van de header.";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "U kunt hier een aangepast kleur invoeren die zal worden gebruikt voor de op dat moment geselecteerde hoofdtab.";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "U kunt hier een aangepast kleur invoeren die zal worden gebruikt voor de teksten in de header.";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "Door GZIP content compressie te gebruiken zal de data, die elke keer als een pagina
van de administratie interface wordt opgevraagd naar uw browser gestuurd wordt, afnemen
Om deze functie te kunnen gebruiken moet minimaal PHP 4.0.5 en de GZIP extentie op uw
server geinstalleerd zijn.";

$GLOBALS['phpAds_hlp_language'] = "Selecteer de standaar taal die {$PRODUCT_NAME} moet gebruiken. Deze taalkeuze zal standaard worden gebruikt voor de interface voor de beheerders en adverteerders. Let op: u kunt een andere taal instellen voor elke adverteerder vanuit de beheerdersinterface, en elke adverteerder toestaan zelf een andere taal te kiezen.";

$GLOBALS['phpAds_hlp_name'] = "Geef de naam die u wilt gebruiken voor deze toepassing. Deze tekenreeks wordt weergegeven op alle pagina's in de admin en adverteerder interface. Als u deze instelling leeg laat wordt (standaard) een logo van {$PRODUCT_NAME} in plaats daarvan getoond.";

$GLOBALS['phpAds_hlp_company_name'] = "Deze naam wordt gebruikt in de e-mail verzonden door {$PRODUCT_NAME}.";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "{$PRODUCT_NAME} detecteert gewoonlijk of de GD-bibliotheek is geïnstalleerd en welke afbeeldingsindeling wordt ondersteund door de geïnstalleerde versie van GD. Maar het is mogelijk dat de detectie niet accuraat of onjuist is, sommige versies van PHP staan de detectie van de ondersteunde afbeeldingsinstelingen niet toe. Indien {$PRODUCT_NAME} niet automatisch de juiste afbeelding-instelling detecteert, kunt u de juiste afbeeldingsinstelling kiezen. Mogelijke waarden zijn: geen, png, jpeg, gif.";

$GLOBALS['phpAds_hlp_p3p_policies'] = "	Indien u gebruik wil maken van P3P Privacy Policies kunt u deze optie aanzetten.
	Hieronder kunt u exact de P3P instellingen exact configureren.";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "The compact policy which is sent together with cookies. The default setting
is: 'CUR ADM OUR NOR STA NID', which will allow Internet Explorer 6 to
accept the cookies used by {$PRODUCT_NAME}. If you want you can alter these
settings to match your own privacy statement.";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "If you want to use a full privacy policy, you can specify the location
of the policy.";

$GLOBALS['phpAds_hlp_compact_stats'] = "	Traditioneel slaat {$PRODUCT_NAME} gedetailleerde data op bij elke impressie. Echter deze
	uitgebreide manier van opslaan kan veel vergen van de database server, wat een probleem
	kan zijn als uw website veel bezoekers heeft. Om dit probleem op te lossen is er nu
	een compactere manier van gegevens opslaan. Deze manier van opslaan vergt minder van
	de database server, maar is ook minder gedetailleerd.";

$GLOBALS['phpAds_hlp_log_adviews'] = "Normaal gesproken worden alle impressies geregistreerd. Als u geen statistieken over impressies wilt verzamelen, dan kunt u dit uitschakelen.";

$GLOBALS['phpAds_hlp_block_adviews'] = "	Als een bezoeker de pagina ververst zal er iedere keer als de banner getoond wordt
	een nieuwe impressie worden geteld door {$PRODUCT_NAME}. Deze optie zorgt er voor dat
	als een banner eenmaal getoond is, deze niet meer wordt bijgehouden voor het aantal
	seconde dat hier ingesteld is. Bijvoorbeeld: als u dit veld instelt op 300 seconden,
	zal {$PRODUCT_NAME} alleen impressies opslaan als de banner de laatste 300 seconden niet al
	eerder getoond is. Deze functie werkt alleen als <i>Gebruik beacons om impressies te
	loggen</i> aan staat en de browser cookies accepteert.";

$GLOBALS['phpAds_hlp_log_adclicks'] = "Normaal gesproken worden alle kliks geregistreerd. Als u geen statistieken over kliks wilt verzamelen, dan kunt u dit uitschakelen.";

$GLOBALS['phpAds_hlp_block_adclicks'] = "	Als een bezoeker meerdere keren om een banner klikt, zullen alle keren bijgehouden
	worden door {$PRODUCT_NAME}. Deze optie zorgt er voor dat als er eenmaal op een banner
	geklikt is, deze niet meer bijgehouden worden gedurende het aantal seconde dat u hier
	opgeeft. Bijvoorbeeld: als u dit veld insteld op 300 seconden, zal {$PRODUCT_NAME} alleen
	kliks bijhouden als er de laatste 300 seconde niet als op de banner geklikt is.
	Deze functie werkt alleen als <i>Gebruik beacons om impressies te loggen</i> aan staat
	en de browser cookies accepteert.";

$GLOBALS['phpAds_hlp_log_adconversions'] = "Normaal gesproken worden alle conversies geregistreerd. Als u geen statistieken over conversies wilt verzamelen, dan kunt u dit uitschakelen.";

$GLOBALS['phpAds_hlp_block_adconversions'] = "Als een bezoeker een pagina met een conversiepixel opnieuw laadt, dan zal {$PRODUCT_NAME} de conversie registreren. Deze functie wordt gebruikt om er voor te zorgen dat slechts een conversie wordt geregistreerd voor elke unieke conversie gedurende het aantal secondes dat u instelt. Bijvoorbeeld: als u deze waarde instelt op 300 secondes, dan zal {$PRODUCT_NAME} de conversie alleen registeren als de bezoeker dezelfde pagina met de conversiepixel niet heeft bekeken in de voorgaande 5 minuten. Deze functie werkt alleen als de browser cookies accepteert.";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "If you are using a geotargeting database you can also store the geographical information
in the database. If you have enabled this option you will be able to see statistics about the
location of your visitors and how each banner is performing in the different countries.
This option will only be available to you if you are using verbose statistics.";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "De host name wordt normaal gesproken vastgesteld door de web server, maar in sommige gevallen is deze functie uitgeschakeld. Als u de host name van de bezoeker wilt gebruiken voor uitleveringsregels en/of als u statistieken wilt bijhouden, en de server geeft deze informatie niet, dan dient u deze optie in te schakelen. Het vaststellen van de host name van de bezoeker kost enige tijd; het zal de uitlevering van banners trager maken.";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "Sommige bezoekers gebruiken een proxy server om verbinding te makne met het internet. In dat geval zal {$PRODUCT_NAME} het IP adres of de host name van de proxy server registreren, in plaats van de bezoeker. Als u deze functie inschakelt, zal {$PRODUCT_NAME} proberen om het IP adres of de host name van de computer van de bezoeker proberen vast te stellen. Als het niet mogelijk is om het exacte adres van de bezoeker vast te stellen, dan zal het adres van de proxy server gebruikt worden. Deze optie staat standaard niet aan, omdat het de uitlevering van banners aanzienlijk zal vertragen.";

$GLOBALS['phpAds_hlp_obfuscate'] = "Niets hier...";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "If you enable this feature, the gathered statistics will be automatically deleted after the
period you specify below this checkbox is passed. For example, if you set this to 5 weeks,
statistics older than 5 weeks will be automatically deleted.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "This feature will automatically delete entries from the userlog which are older than the
number of weeks specified below this checkbox.";

$GLOBALS['phpAds_hlp_geotracking_type'] = "Geotargeting stelt {$PRODUCT_NAME} in staat om het IP adres van een bezoeker om te zetten naar geografische
informatie. Op basis van deze informatie kunt u uitleveringsregels instellen of u kunt deze
informatie opslaan om te zien uit welk land de meeste impressies komen. Als u geotargeting wilt
inschakelen moet u kiezen welk type database u heeft.
{$PRODUCT_NAME} ondersteunt momenteel <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'></a>
en <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> databases.";

$GLOBALS['phpAds_hlp_geotracking_location'] = "Tenzij u de GeoIP Apache module, moet u {$PRODUCT_NAME} de locatie van de geotargeting database vertellen. Het is aan te raden om de database te plaatsen buiten de web servers document root, omdat anders mensen in staat zijn om de database te downloaden.";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "Het omzetten van het IP adres in geografisch informatie kost tijd. Om te voorkomen dat
{$PRODUCT_NAME} dit elke keer moet doen als een banner wordt uitgeleverd, kan het
resultaat worden opgeslagen in een cookie. Als dit cookie aanwezig is, zal {$PRODUCT_NAME}
deze informatie gebruiken in plaats van het IP adres nogmaals te verwerken.";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "Als u geen impressies, kliks en conversies wilt tellen van bepaalde computers, dan
kunt u deze toevoegen aan deze lijst. Als u reverse lookup heeft ingeschakeld, dan
kunt u zowel domain names als IP adressen toevoegen, anders kut u alleen IP
adressen gebruiken. U kunt ook jokertekens gebruiken (bijvoorbeeld:  '*.altavista.com' or '192.168.*').";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Voor de meeste mensen begint de week op maandag, maar als je elke week op zondag wilt beginnen, dan kan dat.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "Geeft aan hoeveel decimalen u wilt weergeven op statistieken pagina's.";

$GLOBALS['phpAds_hlp_warn_admin'] = "{$PRODUCT_NAME} kan u e-mail sturen op het moment dat een campagne slechts een beperkt aantal impressies, kliks of conversies over heeft. Dit is standaard ingeschakeld.";

$GLOBALS['phpAds_hlp_warn_client'] = "	{$PRODUCT_NAME} kan adverteerders automatisch per e-mail waarschuwen als hun campagnes
	op het punt staan om gedeactiveerd te worden. Deze optie staat standaard aan.";

$GLOBALS['phpAds_hlp_qmail_patch'] = "Sommige versies van qmail bevatten een fout, waardoor e-mail welke door {$PRODUCT_NAME}
verstuurd wordt verminkt overkomt. Indien dit bij u het geval is, dan kunt u deze
optie aanzetten, {$PRODUCT_NAME} zal dan haar e-mail versturen in een formaat wat
wel goed door qmail begrepen wordt.";

$GLOBALS['phpAds_hlp_warn_limit'] = "De limiet waarbij {$PRODUCT_NAME} begint waarschuwings-emails te verzenden. Dit is standaard bij 100.";

$GLOBALS['phpAds_hlp_acl'] = "Als u geen gebruik maakt van Uitleveringsregels, dan kunt u deze optie uitschakelen,
dit zal {$PRODUCT_NAME} iets sneller maken.";

$GLOBALS['phpAds_hlp_default_banner_url'] = $GLOBALS['phpAds_hlp_default_banner_target'] = "Als {$PRODUCT_NAME} geen verbinding kan maken met de databaseserver, of geen enkele
geschikte banner kan vinden, bijvoorbeeld omdat de database gecrashed of gewist is,
dan wordt er niets vertoond. Sommige gebruikers willen dan een standaard banner
opgeven, die in dat soort situaties wordt vertoond. De hier opgegeven standaard banner
wordt niet geteld en wordt ook niet gebruik als er nog actieve banners over zijn in de
database. Deze functie is standaard uitgeschakeld.";

$GLOBALS['phpAds_hlp_delivery_caching'] = "Om de uitlevering van banners te versnellen, gebruikt {$PRODUCT_NAME} een buffer waarin alle informatie wordt opgeslagen die nodig is voor de uitlevering van een banner aan een bezoeker van uw website. Het uitleveringsbuffer wordt standaard opgeslagen in de database, maar om de snelheid te verhogen is het ook mogelijk om het buffer op te slaan in een bestand of in het geheugen. Geheugenopslag is het snelste. Bestandsopslag is ook erg snel. Het is af te raden om het uitleveringsbuffer uit te schakelen, aangezien dit een ernstige vermindering van de performance zal veroorzaken.";

$GLOBALS['phpAds_hlp_type_web_mode'] = "Als u banners wilt gebruiken die opgeslagen zijn op de webserver, dan dient u deze instelling in te vullen. Als u de banners wilt opslaan in een lokale directory, stel dan deze optie in op <i>local directory</i>. Als u de banner wilt opslaan op een externe FTP server, stel dan deze optie in op <i>External FTP server</i>. Op sommige web servers zou u de FTP optie zelfs ook kunnen gebruiken op de lokale webserver.";

$GLOBALS['phpAds_hlp_type_web_dir'] = "Geef op naar welke directory {$PRODUCT_NAME} de banners die zijn toegevoegd moet
kopieren. Deze directory moet beschrijfbaar zijn door PHP, dit zou kunnen betekenen
dat u de permissis van deze directory moet aanpassen (chmod). De directory
die u hier opgeeft moet zich in de document root van de webserver bevinden, de
webserver moet in staat zijn om deze bestanden direct uit te leveren. Voeg geen afsluitende
slash (/) toe. U hoeft deze optie alleen in te stellen als u de opslagmethode heeft ingesteld
op <i>Local Directory</i>.";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u het
	IP adres of de domeinnaam van de FTP server, waar {$PRODUCT_NAME} de banners op moet
	opslaan, opgeven.";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u de map
	opgeven op de FTP server, waar {$PRODUCT_NAME} de banners op moet opslaan, opgeven.";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u de
	gebruikersnaam van de FTP server, waar {$PRODUCT_NAME} de banners op moet
	opslaan, opgeven.";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "	Indien u gebruik maakt van de <i>Externe FTP server</i> methode moet u het
	wachtwoord van de FTP server, waar {$PRODUCT_NAME} de banners op moet
	opslaan, opgeven.";

$GLOBALS['phpAds_hlp_type_web_ftp_passive'] = "Sommige FTP-servers en firewalls vereisen dat transfers de passieve modus (PASV) gebruiken. Als {$PRODUCT_NAME} passieve modus moet gebruiken om te verbinden met uw FTP-server, schakelt u deze optie.";

$GLOBALS['phpAds_hlp_type_web_url'] = "Als u banners op een webserver opslaat, moet {$PRODUCT_NAME} weten welke openbare
URL overeenkomt met de map die u hebt opgegeven. Voer geen slash (/) in aan het einde.";

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "Als u banners op een webserver opslaat, moet {$PRODUCT_NAME} weten welke openbare
URL (SSL) overeenkomt met de map die u hebt opgegeven. Voer geen slash (/) in aan het einde.";

$GLOBALS['phpAds_hlp_type_html_auto'] = "Als deze optie is ingeschakeld, zal {$PRODUCT_NAME} zal automatisch HTML-banners aanpassen zodat kliks worden geteld. Als deze optie is ingeschakeld, is het nog steeds mogelijk om dit uit te schakelen per individuele banner.";

$GLOBALS['phpAds_hlp_type_html_php'] = "Het is mogelijk om {$PRODUCT_NAME} PHP code te laten uitvoeren die is opgenomen in HTML-banners. Deze functie is standaard uitgeschakeld.";

$GLOBALS['phpAds_hlp_admin'] = "Voer de gebruikersnaam van de beheerder in. Met deze gebruikersnaam kunt u inloggen in de interface van de beheerder.";

$GLOBALS['phpAds_hlp_admin_pw'] = $GLOBALS['phpAds_hlp_admin_pw2'] = "	Vul hier het wachtwoord dat u wilt gebruiken om toegang te krijgen tot
	de administratie interface. U dient het wachtwoord twee maal in te vullen
	om typefouten te voorkomen.";

$GLOBALS['phpAds_hlp_pwold'] = $GLOBALS['phpAds_hlp_pw'] = $GLOBALS['phpAds_hlp_pw2'] = "	Om het wachtwoord van de beheerder te veranderen dient u eerst het
	oude wachtwoord in te vullen, en daaronder tweemaal het nieuwe wachtwoord.
	U moet dit dubbel invullen, om typefouten te voorkomen.";

$GLOBALS['phpAds_hlp_admin_fullname'] = "Geef de volledige naam van de beheerder. Deze wordt gebruikt bij het verzenden van statistieken via e-mail.";

$GLOBALS['phpAds_hlp_admin_email'] = "E-mailadres van de beheerder. Dit wordt gebruikt als het FROM-adres wanneer statistieken via e-mail verzenden.";

$GLOBALS['phpAds_hlp_admin_novice'] = "Indien u een waarschuwing wilt krijgen voordat u adverteerders, campagnes of banners verwijdert, moet u deze optie aanzetten.";

$GLOBALS['phpAds_hlp_client_welcome'] = "If you turn this feature on a welcome message will be displayed on the first page an
advertiser will see after loggin in. You can personalize this message by editing the
welcome.html file location in the admin/templates directory. Things you might want to
include are for example: Your company name, contact information, your company logo, a
link a page with advertising rates, etc..";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "U kunt ook hier een kleine tekst opgeven in plaats van het bewerken van het bestand welcome.html. Als u een tekst hier invoert, zal het bestand welcome.html worden genegeerd. Het is toegestaan om HTML-codes gebruiken.";

$GLOBALS['phpAds_hlp_updates_frequency'] = "	Indien u wilt dat {$PRODUCT_NAME} automatisch controleert of er nieuwere versies
	beschikbaar zijn kunt u hier instellen hoe vaak deze controle wordt uitgevoerd.
	Indien een nieuwe versie beschikbaar is zal er een nieuw venster verschijnen met
	daarin extra informatie over de nieuwere versie.";

$GLOBALS['phpAds_hlp_userlog_email'] = "	Indien u een kopie wilt bewaren van alle e-mail berichten die {$PRODUCT_NAME} verzend
	dan kunt u deze optie aanzetten. De e-mail berichten worden opgeslagen in de
	gebruikers log.";

$GLOBALS['phpAds_hlp_userlog_inventory'] = "To ensure the inventory calculation ran correctly, you can save a report about
the hourly inventory calculation. This report includes the predicted profile and how much
priority is assigned to all banners. This information might be useful if you
want to submit a bugreport about the priority calculations. The reports are
stored inside the userlog.";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "To ensure the database was pruned correctly, you can save a report about
what exactly happened during the pruning. This information will be stored
in the userlog.";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "	Indien u standaard een hoger gewicht wilt geven aan banners, dan kunt u hier het
	gewenste gewicht instellen. Deze optie staat standaard op 1.";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "	Indien u standaard een hoger gewicht wilt geven aan campagnes, dan kunt u hier het
	gewenste gewicht instellen. Deze optie staat standaard op 1.";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Als deze optie aan staat, wordt er extra informatie over elke campagne getoond op de
<i>Campagne overzicht</i> pagina. De extra informatie bevat o.a. het overgebleven aantal
impressies, kliks en conversies, de begindatum en de einddatum en de prioriteits-instellingen.";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Als deze optie aan staat, wordt er extra informatie over elke banner getoond op de<i>Banner overzicht</i> pagina. De extra informatie bevat o.a. de doel URL, sleutelwoorden, grootte en gewicht.";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Als deze optie aan staat, wordt er een voorbeeld van alle banners getoond op de <i>Banner
overzicht</i> pagina. Als deze optie niet aan staat is het nog steeds mogelijk een een voorbeeld
van een banner te zien, door op de driehoek naast elke banner op de <i>Banner overzicht</i>
pagina te klikken.";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "Als deze optie aan staat wordt de HTML banner zelf getoond in plaats van de HTML code. Deze
optie staat standaard uit, omdat de HTML code in sommige gevallen storend kan werken op de
pagina van de administratie interface. Als deze optie uit staat dan is het nog steeds mogelijk
om de werkelijke banner te zien, door te klikken op <i>Toon banner</i> knop naast de HTML
code.";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "Als deze optie aan staat wordt er een voorbeeld van de banner getoond aan de bovenkant van
de <i>Banner eigenschappen</i>, <i>Leveringsopties</i> en <i>Gekoppelde zones</i> pagina's.
Als deze optie uit staat is het nog steeds mogelijk om een voorbeeld te bekijken door te
klikken op de <i>Toon banner</i> knop bovenaan de pagina.";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Als deze optie aan staat worden alle niet-actieve banners, campagnes en adverteerders verborgen
op de <i>Adverteerders & campagnes</i> en <i>Campagne overzicht</i> pagina's. Als deze optie
aan staat is het mogelijk om de verborgen items te tonen door te klikken op de <i>Toon alles</i>
knop onderaan de pagina.";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "Als deze optie is ingeschakeld, dan zal de overeenkomende banner worden vertoond op de <i>Gekoppelde banners</i> pagina,
als gekozen is voor de <i>Campagne selectie</i>methode. Dit stelt u in staat om precies te zien welke banners worden
meegenomen voor uitlevering als de campagne gekoppeld wordt. Het is ook mogelijk om naar een voorbeeld van
de overeenkomstige banners te kijken.";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "Als deze optie is ingeschakeld, dan zal de bovenliggende campange van de banners worden vertoond op de
<i>Gekoppelde banners</i> pagina. indien de <i>Banner selectie</i> methode is gekozen. Dit stelt u in staat om te zien
welke banner behoort bij welke campagne, voordat de banner wordt gekoppeld. Dit betent ook dat de banners worden
gegroepeerd per bovenliggende campagne en niet langer meer alfabetisch worden gesorteerd.";
