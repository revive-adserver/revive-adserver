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







$GLOBALS['phpAds_hlp_p3p_policy_location'] = "If you want to use a full privacy policy, you can specify the location
of the policy.";


$GLOBALS['phpAds_hlp_log_adviews'] = "Normaal gesproken worden alle impressies geregistreerd. Als u geen statistieken over impressies wilt verzamelen, dan kunt u dit uitschakelen.";


$GLOBALS['phpAds_hlp_log_adclicks'] = "Normaal gesproken worden alle kliks geregistreerd. Als u geen statistieken over kliks wilt verzamelen, dan kunt u dit uitschakelen.";


$GLOBALS['phpAds_hlp_log_adconversions'] = "Normaal gesproken worden alle conversies geregistreerd. Als u geen statistieken over conversies wilt verzamelen, dan kunt u dit uitschakelen.";


$GLOBALS['phpAds_hlp_geotracking_stats'] = "If you are using a geotargeting database you can also store the geographical information
in the database. If you have enabled this option you will be able to see statistics about the
location of your visitors and how each banner is performing in the different countries.
This option will only be available to you if you are using verbose statistics.";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "De host name wordt normaal gesproken vastgesteld door de web server, maar in sommige gevallen is deze functie uitgeschakeld. Als u de host name van de bezoeker wilt gebruiken voor uitleveringsregels en/of als u statistieken wilt bijhouden, en de server geeft deze informatie niet, dan dient u deze optie in te schakelen. Het vaststellen van de host name van de bezoeker kost enige tijd; het zal de uitlevering van banners trager maken.";


$GLOBALS['phpAds_hlp_obfuscate'] = "Niets hier...";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "If you enable this feature, the gathered statistics will be automatically deleted after the
period you specify below this checkbox is passed. For example, if you set this to 5 weeks,
statistics older than 5 weeks will be automatically deleted.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "This feature will automatically delete entries from the userlog which are older than the
number of weeks specified below this checkbox.";




$GLOBALS['phpAds_hlp_ignore_hosts'] = "Als u geen impressies, kliks en conversies wilt tellen van bepaalde computers, dan
kunt u deze toevoegen aan deze lijst. Als u reverse lookup heeft ingeschakeld, dan
kunt u zowel domain names als IP adressen toevoegen, anders kut u alleen IP
adressen gebruiken. U kunt ook jokertekens gebruiken (bijvoorbeeld:  '*.altavista.com' or '192.168.*').";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Voor de meeste mensen begint de week op maandag, maar als je elke week op zondag wilt beginnen, dan kan dat.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "Geeft aan hoeveel decimalen u wilt weergeven op statistieken pagina's.";








$GLOBALS['phpAds_hlp_type_web_mode'] = "Als u banners wilt gebruiken die opgeslagen zijn op de webserver, dan dient u deze instelling in te vullen. Als u de banners wilt opslaan in een lokale directory, stel dan deze optie in op <i>local directory</i>. Als u de banner wilt opslaan op een externe FTP server, stel dan deze optie in op <i>External FTP server</i>. Op sommige web servers zou u de FTP optie zelfs ook kunnen gebruiken op de lokale webserver.";











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
