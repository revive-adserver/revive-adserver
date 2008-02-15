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

// German
// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
       Geben Sie den Hostname an, der als Datenbankserver f&uuml;r ".$phpAds_dbmsname." fungiert.
		";

$GLOBALS['phpAds_hlp_dbport'] = "
        Geben Sie die Port-Nummer f&uuml;r den Datenbank-Server von ".$phpAds_dbmsname." an.. Die Voreinstellung f&uuml;r eine".$phpAds_dbmsname."-Datenbank ist <i>".
		($phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>.
		";

$GLOBALS['phpAds_hlp_dbuser'] = "
        Geben Sie den Benutzername f&uuml;r die <i>Datenbank</i> an. Mit diesem Benutzername greift ".MAX_PRODUCT_NAME." auf den Datenbankserver von ".$phpAds_dbmsname." zu.
		";

$GLOBALS['phpAds_hlp_dbpassword'] = "
Geben Sie das Passwort f&uuml;r die <b>Datenbank</b> an. Mit diesem Passwort kann ".MAX_PRODUCT_NAME." auf den Datenbankserver von ".$phpAds_dbmsname." zugreifen.
		";

$GLOBALS['phpAds_hlp_dbname'] = "
         Geben Sie den Namen der Datenbank an, in die ".MAX_PRODUCT_NAME." die Daten speichern soll.
		Wichtig! Die Datenbank mu&szlig; bereits auf dem Datenbankserver vorhanden sein.
".MAX_PRODUCT_NAME." erstellt <b>nicht</b> diese
		Datenbank, wenn sie noch nicht existiert.
		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "
        Die dauerhafte Verbindung zur Datenbank kann die Geschwindigkeit von ".MAX_PRODUCT_NAME." durchaus erh&ouml;hen, insbesondere wird die Ladezeiten vom Server verringert. Andererseits k&ouml;nnen bei Seiten mit sehr vielen Besuchern - genau gegenteilig zu oben - durch die dauerhafte Verbindung die Ladezeiten erheblich ansteigen. <br />
Welche Art der Verbindung gew&auml;hlt wird, <i>normale</i> oder <i>dauerhafte</i>, ist abh&iuml;&auml;ngig von der Besucherzahl und der eingesetzten Hardware. Wenn ".MAX_PRODUCT_NAME." zu viele Ressourcen belegt, k&ouml;nnte dies durch die Einstellung <i>dauerhafte Verbindung </i> hervorgerufen worden sein.
		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        Wird die Datenbank ".$phpAds_dbmsname." nicht nur von ".MAX_PRODUCT_NAME.", sondern auch von weiteren Anwendungen genutzt, k&ouml;nnen unter Umst&auml;nden Kompatibilit&auml;tsprobleme auftreten. Durch setzen des Kompatibilit&auml;tsmodus (Datenbank) werden diese Probleme behoben.<br />
Wenn die Bannerauslieferung im <i>lokalen Modus</i> erfolgt und Kompatibilit&auml;tsmodus (Datenbank) gesetzt ist, hinterl&auml;&szlig;t ".MAX_PRODUCT_NAME." die Einstellungen der Datenbank so, wie diese vorher vorgefunden wurden. <br />
Diese Option verlangsamt den Adserver etwas (sehr gering) und ist in der Voreinstellung deaktiv.
		";

$GLOBALS['phpAds_hlp_table_prefix'] = "
Wird die Datenbank ".$phpAds_dbmsname." nicht nur von ".MAX_PRODUCT_NAME.", sondern auch von weiteren Anwendungen genutzt, ist es angeraten, den von ".MAX_PRODUCT_NAME." genutzten Tabellen, einen individuellen <i>Pr&auml;fix</i> voranzustellen. Damit kann sichergestellt werden, da&szlig; dieselben Tabellennamen nicht von verschiedenen Programmen verwendet werden. <br />
".MAX_PRODUCT_NAME." kann mehrfach installiert werden , wobei alle installierten Programme auf dieselbe Datenbank zugreifen k&ouml;nnen. Es mu&szlig; dann f&uuml;r jede Anwendung den Tabellennamen ein eigener eindeutiger  <i>Pr&auml;fix</i> vorangestellt werden.
		";

$GLOBALS['phpAds_hlp_table_type'] = "
        ".$phpAds_dbmsname." unterst&uuml;tzt mehrere Tabellentypen. Jeder Tabellentype hat seine eigenen Eigenschaften, die es durchaus erm&ouml;glichen, ".MAX_PRODUCT_NAME." stark zu beschleunigen. <br />
MyISAM ist der immer vorhandene Tabellentype und daher Voreinstellung bei ".$phpAds_dbmsname.".
		";

$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".MAX_PRODUCT_NAME." ben&ouml;tigt f&uuml;r das korrekte Funktionieren die genaue Angabe &uuml;ber den eigenen Standort auf dem Server. Ben&ouml;tigt wird die URL und das Verzeichnis, in dem ".MAX_PRODUCT_NAME." installiert ist. Z.B.: <i>http://www.your-url.com/".MAX_PRODUCT_NAME."</i>.
		";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "
        ".MAX_PRODUCT_NAME." mu&szlig; wissen, in welchen Verzichnissen sich seine Dateien befinden um vern&uuml;nftig zu funktionieren. Manchmal unterscheidet sich das SSL-Pr&auml;fixx vom normalen URL-Pr&auml;fix. Sie m&uuml;ssen deshalb die URL zum Verzeichnis in dem ".MAX_PRODUCT_NAME." installiert ist angeben. Beispielsweise <i>https://www.your-url.com/".MAX_PRODUCT_NAME."</i>.
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        Damit Kopf- bzw. Fu&szlig;zeilen im Admin-Bereich eingeblendet werden k&ouml;nnen, m&uuml;ssen dies
         als HTML-Datei vorhanden sein. Eingegeben werden mu&szlig; die Adresse dieser Dateien  (z.B.: /home/login/www/header.htm). <br />
In den HTML-Dateien ist der entsprechende Text f&uuml;r die Kopf- oder Fu&szlig;zeile zu hinterlegen. Es k&ouml;nnen auch HTML-Tags verwendet werden. Wird HTML verwendet, sind Tags wie <i><body>, <html> </i>usw. nicht zugelassen. <br />
		";

$GLOBALS['phpAds_hlp_my_logo'] = "
        Geben Sie hier den Dateinamen Ihres Logos an. Dieses wird dann anstatt des Standard-Logos angezeigt. Sie m&uuml;ssen die Logo-Datei zuerst in das Verzeichnis admin/images hochladen, bevor Sie den Dateinamen hier angeben k&ouml;nnen.
               ";
               
$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "
        Geben Sie hier Ihre Wunschfarbe ein, in der die Navigationsreiter, das Suchfeld und gefetteter Text erscheinen sollen.
               ";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "
        Geben Sie hier Ihre Wunschfarbe f&uuml;r die Hintergrundfarbe der Kopfzeile ein.
               ";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "
        Geben Sie hier Ihre Wunschfarbe f&uuml;r den aktiven Navigationsreiter ein.
               ";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "
        Geben Sie hier Ihre Wunschfarbe f&uuml;r den Text in der Kopfzeile an.
               ";
               
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		Die Kompression durch GZIP vermindert dem Umfang der Daten, die aus dem 	Administrationsberich zum Browser &uuml;bertragen werden. Dadurch wird die Daten&uuml;bertragung stark beschleunigt. Ben&ouml;tigt wird hierf&uuml;r mindestens PHP 4.0.5 mit GZIP-Erweiterung.
		";

$GLOBALS['phpAds_hlp_language'] = "
        Voreinstellung der Sprache. Diese Sprache wird als Voreinstellung in alle Module und
        Programmteile, auch f&uuml;r Verleger- und Inserentenbereiche &uuml;bernommen. <br />
        Unabh&auml;ngig hiervon kann f&uuml;r jeden Verleger oder Inserenten eine eigene Sprache eingestellt werden. Auch kann ihnen in den jeweiligen Einstellungen gestattet werden, selbst die Sprachauswahl zu &auml;ndern.
		";

$GLOBALS['phpAds_hlp_name'] = "
        Es besteht die M&ouml;glichkeit, f&uuml;r die Anwendung anstelle <i>".MAX_PRODUCT_NAME." </i> eine
        eigene Bezeichnung oder einen eigenen Namen zu vergeben. Dieser Name erscheint auf allen Seiten
        im Administations-, Verleger- und Inserentenbereich. Bleibt dieses Feld leer, wird ein Logo von ".MAX_PRODUCT_NAME." angezeigt.
		";

$GLOBALS['phpAds_hlp_company_name'] = "
        Dieser Firmenname wird bei den automatischen E-Mails an Verleger und Inserenten verwendet.
		";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
         ".MAX_PRODUCT_NAME." pr&uuml;ft standardm&auml;&szlig;ig, ob die Bibliothek GD-library installiert ist und
          welche Bildformate unterst&uuml;tzt werden. Einige Versionen von PHP gestatten diese automatische
           Pr&uuml;fung nicht. Das Ergebnis kann fehlerhaft sein. In diesem Fall k&ouml;nnen die unterst&uuml;tzten
           Bildformate manuell eingegeben werden. G&uuml;ltige Formate sind z.B. <i> none, pgn, jpeg, gif.</i> .
		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "
        Wenn P3P Privacy Policies genutzt werden sollen, mu&szlig; diese Option hier gesetzt werden.
		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        Die Zeile f&uuml;r die P3P Policies ist bei ".MAX_PRODUCT_NAME." wie folgt festgelegt: 'CUR ADM OUR NOR STA NID'. Sie wird gemeinsam mit Cookies an den Besucher gesendet. Durch dieses Verfahren wird sichergestellt, da&szlig; Internet Explorer 6 die Cookies akzeptiert. Der Inhalt der Zeile kann durch eigene g&uuml;ltige Texte ge&auml;ndert werden.
		";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        Wenn Sie eine vollst&auml;ndige Datenschutzerkl&auml;rung nutzen, k&ouml;nnen Sie hier deren den Standort eingeben.
		";

$GLOBALS['phpAds_hlp_compact_stats'] = "
	".MAX_PRODUCT_NAME." bietet die M&ouml;glichkeit, entweder detaillierte Statistiken oder kompakte zu w&auml;hlen. f&uuml;r die kompakten Statistiken werden AdViews und AdClicks gesammelt und st&uuml;ndlich verarbeitet. Die detaillierten Statistiken ben&ouml;tigen mehr Datenbank-Ressourcen.
		";

$GLOBALS['phpAds_hlp_log_adviews'] = "
	Normalerweise werden alle AdViews aufgezeichnet und flie&szlig;en in die Statistiken ein. Diese Option kann deaktiviert werden.
		";

$GLOBALS['phpAds_hlp_block_adviews'] = "
		Die Reloadsperre verhindert, da&szlig; ein Banner mehrfach gez&auml;hlt wird, wenn er auf derselben Seite demselben Besucher &ouml;fters pr&auml;sentiert wird; z.B. dadurch, da&szlig; der Besucher die Browserseite aktualisiert. An dieser Stelle kann die Dauer in Sekunden eingegeben werden, f&uuml;r die die Reloadsperre aktiv ist. Die Sperre funktioniert nur, wenn der Besucher Cookies zul&auml;&szlig;t.
		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "
	Normalerweise werden alle AdClicks aufgezeichnet und flie&szlig;en in die Statistiken ein. Diese Option kann deaktiviert werden.
		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Die Reclicksperre verhindert, da&szlig; Clicks auf ein Banner mehrfach gez&auml;hlt wird, wenn  derselben Besucher mehr als einmal auf einen Banner klickt. An dieser Stelle kann die Dauer in Sekunden eingegeben werden, f&uuml;r die die Reclicksperre aktiv ist. Die Sperre funktioniert nur, wenn der Besucher Cookies zul&auml;&szlig;t.
		";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		Geotargeting ist die Standortbestimmung des Besuchers. Wenn Sie eine Datenbank f&uuml;r
		Geotargeting einsetzen, werden als geographische Informationen gespeichert: <br /><br />
Das Herkunftsland des Besuchers und die Entwicklung der Banner nach L&auml;ndern. Die Option Geotargeting kann nur in Verbindung mit detaillierten Statistiken aktiviert werden.
		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		Der Hostname des Besuchers wird in der Regel vom Web-Server bestimmt.
		Bestimmt der (eigene) Web-Server nicht den Hostnamen, kann die Information von
		".MAX_PRODUCT_NAME." ermittelt werden. Wird diese Option gesetzt, kann es zur Verlangsamung der Bannerauslieferung kommen.
		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Verwendet der Besucher einen Proxy-Zugang, protokolliert ".MAX_PRODUCT_NAME." normalerweise die IP-Adresse und/oder den Hostname des Proxy-Servers. Diese Erfassung kann so gesetzt werden, da&szlig; ".MAX_PRODUCT_NAME." versucht, den tats&auml;chlichen Hostnamen oder die IP-Adresse zu ermitteln, die hinter dem Proxy-Server steht. Kann diese  <i>richtige</i> Adresse des Besuchers nicht ermittelt werden, werden die Daten des Proxy-Servers verwendet. In der Voreinstellung ist diese Option deaktiviert, da sie die Bannerauslieferung verlangsamt.
		";

$GLOBALS['phpAds_hlp_obfuscate'] = "Wenn Sie m&ouml;chten, da&szlig; ".MAX_PRODUCT_NAME." den Namen der Gruppe, zu der dieses Werbemittel geh&ouml;rt verschleiert, klicken Sie diese Option an.";

$GLOBALS['phpAds_hlp_auto_clean_tables'] =
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		Die aufgezeichneten Daten und erstellten Statistiken k&ouml;nnen nach einer bestimmten Zeit gel&ouml;scht werden. An dieser Stelle kann in Wochen eingegeben werden, nach welchem Zeitraum die Daten gel&ouml;scht werden sollen. Mindestens sind 3 Wochen einzugeben.
		";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] =
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		Durch diese Funktion k&ouml;nnen alle Eintr&auml;ge im Benutzerprotokoll nach einer bestimmten Zeit gel&ouml;scht werden. An dieser Stelle kann in Wochen eingegeben werden, nach welchem Zeitraum die aufgezeichneten Benutzerdaten gel&ouml;scht werden sollen. Mindestens sind 3 Wochen einzugeben
		";

$GLOBALS['phpAds_hlp_geotracking_type'] = "
		&Uuml;ber Geotargeting wird anhand der IP-Adresse der Standort bzw. die Herkunft des Besuchers ermittelt. Ermittelt wird das Land. N&uuml;tzlich ist das, wenn mehrsprachige Banner oder Banner in mehreren Sprachen ausgeliefert werden k&ouml;nnen. Die Auslieferung eines Banners kann auf bestimmte Herkunftsl&auml;nder (der Besucher) eingeschr&auml;nkt oder nach L&auml;nderkategorien ausgewertet werden.<br />
f&uuml;r Geotargeting wird eine spezielle Datenbank ben&ouml;tigt. ".MAX_PRODUCT_NAME." unterst&uuml;tzt die Datenbanken von  <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> und <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a>.
		";

$GLOBALS['phpAds_hlp_geotracking_location'] = "
		Wenn nicht das Modul GeoIP Apache verwendet wird, mu&szlig; f&uuml;r ".MAX_PRODUCT_NAME." das Verzeichnis eingegeben werden, in dem sich die Geotargeting-Datenbank befindet. Empfehlenswert ist es, diese au&szlig;erhalb des Dokumentenverzeichnisses des Web-Servers abzulegen; da diese andernfalls f&uuml;r Dritte einsehbar sein k&ouml;nnte.
		";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
		Die Umwandlung der IP-Adresse in l&auml;nderspezifische Informationen ben&ouml;tigt Zeit. Damit diese Informationen nicht bei jeder Bannerauslieferung an denselben Besucher berechnet werden m&uuml;ssen, werden sie bei der ersten Bannerauslieferung berechnet und in einem Cookie gespeichert. Die geographischen Informationen aus dem Cookie werden bei nachfolgenden Bannerauslieferungen f&uuml;r das Geotargeting verwendet.
		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "
	Sollen AdViews und AdClicks von bestimmten Host nicht aufgezeichnet werden, k&ouml;nnen diese hier aufgelistet werden. Wurde eingestellt, da&szlig; der Hostname ermittelt wird, k&ouml;nnen Domain-Name oder IP-Adresse eingegeben werden. Wurde diese Option deaktiviert, ist nur die Eingabe der IP-Adresse m&ouml;glich. Platzhalter/Wildcards sind zugelassen (z.B. '*.altavista.com' or '192.168.*')
		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "
	Der Tag des Wochenbeginns kann eingestellt werden. Voreinstellung ist Montag.
		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "
	Die Anzahl der Nachkommastellen f&uuml;r die Darstellung von Prozentangaben innerhalb der Statistiken.
		";

$GLOBALS['phpAds_hlp_warn_admin'] = "
	Es besteht die M&ouml;glichkeit, da&szlig; ".MAX_PRODUCT_NAME." eine E-Mail an den Administrator sendet, wenn f&uuml;r eine Kampagne ein bestimmtes Restguthaben f&uuml;r AdViews oder AdClicks unterschritten wurde. In der Voreinstellung ist diese Option gesetzt.
		";

$GLOBALS['phpAds_hlp_warn_client'] = "
	Es besteht die M&ouml;glichkeit, da&szlig; ".MAX_PRODUCT_NAME." eine E-Mail an den Inserenten sendet, wenn f&uuml;r eine Kampagne ein bestimmtes Restguthaben f&uuml;r AdViews oder AdClicks unterschritten wurde.
In der Voreinstellung ist diese Option gesetzt.
		";

$GLOBALS['phpAds_hlp_qmail_patch'] = "
	Einigen Versionen von <i>qMail</i> sind fehlerbehaftet. Die Kopfzeile der E-Mail wird in den Haupttext verschoben. Hier kann festgelegt werden, da&szlig; ".MAX_PRODUCT_NAME." jede E-Mail in einem Format versendet, das von <i>qMail</i> korrekt wiedergegeben wird.
		";

$GLOBALS['phpAds_hlp_warn_limit'] = "
	Eingegeben wird das Restguthaben, nach dessen Unterschreitung ".MAX_PRODUCT_NAME." Warnungen per E-Mail versendet. Voreinstellung ist 100.
		";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_plain_nocookies'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Mit diesen Einstellungen kontrollieren Sie, welche Bannercodes erlaubt sind. Sollte einer der Bannercodes
		nicht aktiv sein, so bedeutet dies, da&szlig; er beim Generieren eines Bannercodes nicht zur Verf&uuml;gung steht.
		Wichtig: F&uuml;r bestehende Zonen ist dieser Bannercode nach wie vor aktiv und Sie k&ouml;nnen Banner ausliefern. Sie
		k&ouml;nnen nur keine neuen Zonen mit dem betreffenden Bannercode anlegen.
		";

$GLOBALS['phpAds_hlp_con_key'] = "
		f&uuml;r den lokalen Modus als Verfahren zur Bannerauslieferung bietet ".MAX_PRODUCT_NAME." m&auml;chtige Werkzeuge zur Selektion. Unter anderem k&ouml;nnen hier logische Operatoren verwendet werden. Weitere Informationen finden sich im Handbuch. In der Voreinstellung ist diese Option gesetzt.
		";

$GLOBALS['phpAds_hlp_mult_key'] = "
		Banner k&ouml;nnen nach Schl&uuml;sselw&ouml;rtern ausgew&auml;hlt werden. Es k&ouml;nnen ein oder mehrere Schl&uuml;sselw&ouml;rter je Banner oder je Bannerauslieferung bestimmt werden. Die Anzahl der Schl&uuml;sselw&ouml;rter kann auf ein Schl&uuml;sselwort begrenzt werden; andernfalls sind immer mehrere zul&auml;ssig. Die Option f&uuml;r mehrere Schl&uuml;sselw&ouml;rter ist in der Voreinstellung gesetzt. Ist nur ein Schl&uuml;sselwort gew&uuml;nscht, mu&szlig; die Option deaktiviert werden.
		";

$GLOBALS['phpAds_hlp_acl'] = "
	Sollen f&uuml;r die Bannerauslieferung keine Beschr&auml;nkungen festgelegt werden, k&ouml;nnte durch die Deaktivierung dieser Option die Geschwindigkeit von ".MAX_PRODUCT_NAME." etwas beschleunigt werden.
		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "
	Wenn ".MAX_PRODUCT_NAME." keine Verbindung zur Datenbank herstellen kann, bzw. wenn kein g&uuml;ltiger Banner gefunden wurde, wird der hier definierte Banner ersatzweise ausgeliefert. f&uuml;r diesen Ersatzbanner werden weder AdViews noch AdClicks aufgezeichnet. In der Voreinstellung ist diese Funktion deaktiviert.
		";

$GLOBALS['phpAds_hlp_delivery_caching'] = "
		Die Verwendung eines Caches als Zwischenspeicher beschleunigt die Bannerauslieferung. In dem Cache sind alle Informationen, die f&uuml;r die Bannerauslieferung notwendig sind, hinterlegt. Als Voreinstellung ist der Cache Teil der Datenbank. Alternativ hierzu kann er in einer Datei oder in einem shared memory abgelegt werden. Die schnellste Bannerauslieferung bietet shared memory; doch bereits der Einsatz einer Datei beschleunigt die Bannerauslieferung erheblich. Wird die Option des Caches f&uuml;r die Bannerauslieferung deaktiviert, verlangsamt sich die Leistung von".MAX_PRODUCT_NAME." sehr und wird daher nicht empfohlen.
		";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] =
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
	".MAX_PRODUCT_NAME." unterst&uuml;tzt unterschiedliche Bannerformate, die auf unterschiedlicher Weise gespeichert werden. Die ersten zwei werden f&uuml;r das lokale Speichern verwendet. Banner k&ouml;nnen &uuml;ber das Administrationsmodul in die Datenbank geladen oder auf dem Web-Server gespeichert werden. Banner k&ouml;nnen auch auf externen Servern &uuml;ber die URL verwaltet werden. Sie k&ouml;nnen HTML-Banner sein und einfache Texte f&uuml;r Textanzeigen.
		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "
Wenn Banner auf dem Web-Server gespeichert werden sollen, m&uuml;ssen die Einstellungen hierf&uuml;r konfiguriert werden. Sollen die Banner auf einem lokalen Verzeichnis gespeichert werden, mu&szlig;  <i>Lokales Verzeichnis</i> gew&auml;hlt werden. F&uuml;r die Speicherung auf einem FTP-Server ist <i> Externer FTP-Server</i> einzustellen. Es ist durchaus m&ouml;glich, da&szlig; der eigene Web-Server nicht lokal, sondern als FTP-Server eingerichtet wird.
		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "
	In das hier festgelegte Verzeichnis speichert ".MAX_PRODUCT_NAME." die hochgeladenen Banner. Das Verzeichnis darf f&uuml;r PHP nicht schreibgesch&uuml;tzt sein. Es mu&szlig;, ggf. mit Hilfe eines FTP-Programmes, die Zugriffs- und Schreibberechtigung gesetzt werden. Das Verzeichnis mu&szlig; im Root-Verzeichnis von ".MAX_PRODUCT_NAME." sein. Bei der Eingabe des Verzeichnisses darf als Ende kein  Slash (/) eingegeben werden. Diese Angaben werden nur bei  <i>Lokales Verzeichnis</i> als Wahl f&uuml;r die Speicherung ben&ouml;tigt.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		f&uuml;r das Speicherungsverfahren  <i> Externer FTP-Server</i> wird die IP-Adresse oder der Domain-Name des FTP-Servers ben&ouml;tigt.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		f&uuml;r das Speicherungsverfahren  <i> Externer FTP-Server</i> mu&szlig; das Verzeichnis, in das die Banner gespeichert werden, genau bezeichnet werden (auf Gro&szlig;-/Kleinschreibung ist ggf. zu achten).
		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		f&uuml;r das Speicherungsverfahren  <i> Externer FTP-Server</i> mu&szlig; der Benutzername f&uuml;r den Zugang zum FTP-Server eingegeben werden.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		f&uuml;r das Speicherungsverfahren  <i> Externer FTP-Server</i> wird zum Benutzername ein g&uuml;ltiges Passwort ben&ouml;tigt.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_passive'] = " 
 	    Einige FTP Server und Firewalls verlangen, dass Sie bei �bertragungen den Passive Mode (PASV) verwenden. 
 	    Wenn " . MAX_PRODUCT_NAME . " Passive Mode verwenden soll, aktivieren Sie diese Option. 
 	    ";
 	    
$GLOBALS['phpAds_hlp_type_web_url'] = "
	Werden die Banner auf einem Web-Server gespeichert, m&uuml;ssen sowohl die (&ouml;ffentliche) URL als auch das mit ihr korrespondierende lokale Verzeichnis eingegeben werden. Z. B.<br />
(&ouml;ffentliche) URL       = <i>http://www.Werbeplatzvermarktung.de/ads</i><br />
Lokales Verzeichnis   = <i>/var/www/htdocs/ads</i><br />
Bei der Eingabe des Verzeichnisses darf als Ende kein  Slash (/) eingegeben werden.
		";

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "
        Wenn Sie Ihre Banner auf einem Web-Server speichern, mu&szlig; ".MAX_PRODUCT_NAME." wissen, welche &ouml;ffentliche URL (SSL) mit
dem von Ihnen unten angegebenen Verzeichnis korresondiert. Schlie&szlig;en Sie die Pfadangabe nicht mit einem Slash (/) ab.
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
	Durch diese Option modifiziert ".MAX_PRODUCT_NAME." den HTML-Code so, da&szlig; AdClicks aufgezeichnet werden k&ouml;nnen. Auch wenn diese Option an dieser Stelle aktiviert wird, ist es dennoch m&ouml;glich, sie f&uuml;r jeden Banner individuell zu deaktivieren.
		";

$GLOBALS['phpAds_hlp_type_html_php'] = "
	Es kann zugelassen werden, da&szlig; ausf&uuml;hrbare PHP-Codes in HTML-Banner eingebettet sind. Diese Funktion ist in der Voreinstellung deaktiviert.
		";

$GLOBALS['phpAds_hlp_admin'] = "
	Bitte geben Sie den Benutzername des Administrators ein. Mit diesem Benutzername ist der Zugang zum Administrationsmodul m&ouml;glich
		";

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
	Bitte geben Sie ein Passwort f&uuml;r den Administrator ein. Die Passworteingabe mu&szlig; durch erneute Eingabe best&auml;tigt werden.
		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "
	Um das Passwort des Administrators zu &auml;ndern, mu&szlig; zun&auml;chst das alte Passwort eingegeben werden. Das neue Passwort ist zweimal einzugeben.
		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "
	Eingabe des vollen Namen (Name, Vorname) des Administrators. Die Angaben werden f&uuml;r E-Mails ben&ouml;tigt.
		";

$GLOBALS['phpAds_hlp_admin_email'] = "
        Geben Sie hier die E-Mail-Adresse des Administrators an. Diese Adresse wird als Absender f&uuml;r die Statstik-E-Mals an die Werbetreibenden genutzt.";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        Sie k&ouml;nnen die E-Mail-Header der von ".MAX_PRODUCT_NAME." verschicketen E-Mails &auml;ndern.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
	Wenn eine Warnung erfolgen soll, bevor Zonen, Kampagnen, Banner, Verleger, Inserenten endg&uuml;ltig gel&ouml;scht werden, mu&szlig; diese Option gesetzt sein.
		";

$GLOBALS['phpAds_hlp_client_welcome'] = "
		Wenn diese Option gesetzt wird, erscheint eine Begr&uuml;&szlig;ungszeile auf der ersten Inserentenseite. Dieser Begr&uuml;&szlig;ungstext, der in der Datei welcome.html gespeichert ist, kann personalisiert oder erg&auml;nzt werden. M&ouml;glich w&auml;ren Firmenlogo, Kontaktinformationen, Links zu Angeboten ...
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Der Begr&uuml;&szlig;ungstext f&uuml;r Inserenten kann hier eingegeben werden. HTML-Tags sind zugelassen.
		Ist hier ein Text eingegeben, wird die Datei welcome.html ignoriert.
		";

$GLOBALS['phpAds_hlp_updates_frequency'] = "
		".MAX_PRODUCT_NAME." wird st&auml;ndig optimiert. Es kann in selbst definierten Intervallen direkt beim Update-Server nach neuen Versionen gesucht werden. Ist eine neue Version vorhanden, werden in einem Dialogfenster zun&auml;chst weitere Informationen &uuml;ber das Update gegeben.
		";

$GLOBALS['phpAds_hlp_userlog_email'] = "
		Soll von allen durch ".MAX_PRODUCT_NAME."  versandte E-Mails eine Kopie angefertigt werden, kann das durch diese Option erm&ouml;glicht werden. Die E-Mails werden in das Benutzerprotokoll eingetragen.
		";

$GLOBALS['phpAds_hlp_userlog_inventory'] = "
		Wenn Sie sichergehen wollen, da&szlig; die st&uuml;ndliche Inventarkalkulation korrekt abl&auml;uft,
		k&ouml;nnen Sie einen Bericht dar&uuml;ber anlegen lassen. Dieser Bericht enth&auml;lt die Vorhersagen &uuml;ber die Werbemittelprofile und die Dringlicghkeitsdstufe f&uuml;r jedes Werbemittel. Diese Informationen sind m&uuml;tzlich, wenn Sie den Entwicklern einen Bugreport bez&uuml;glich der Inventarkalkulation senden m&ouml;chten. Der Bereicht wird vom System als Teil des Benutzerprotokolls gespeichert.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		Es kann in einem Bericht gespeichert werden, ob die st&uuml;ndlichen Neuberechnungen korrekt durchgef&uuml;hrt werden. Der Bericht enth&auml;lt die voraussichtlichen Einblendungen und Priorit&auml;ten. Hilfreich kann der Bericht sein, um Fehler in der Kalkulation zu finden. Er wird in das Benutzerprotokoll eingetragen.
		";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
		Um &uuml;berpr&uuml;fen zu k&ouml;nnen, ob die Datenbank fehlerfrei ges&auml;ubert wurde, kann ein Bericht &uuml;ber den Datenbanklauf erstellt werden. Er wird in das Benutzerprotokoll eingetragen.
		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		Die Gewichtung f&uuml;r Banner ist als Voreinstellung <i>1</i>. Die Voreinstellung kann an dieser Stelle h&ouml;her gesetzt werden.
		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		Die Gewichtung f&uuml;r Kampagnen ist als Voreinstellung <i>1</i>. Die Voreinstellung kann an dieser Stelle h&ouml;her gesetzt werden.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		Wenn diese Option aktiviert ist, werden weitere Informationen &uuml;ber jede Kampagne auf der Seite <i>&uuml;bersicht Kampagnen</i> dargestellt. Diese Informationen sind: Restguthaben an AdViews und AdClicks., Aktivierungsdatum, Auslaufdatum und Priorit&auml;t.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		Wenn diese Option aktiviert ist, werden weitere Informationen &uuml;ber jeden Banner auf der Seite <i>&uuml;bersicht Banner</i> dargestellt. Diese Informationen sind: Ziel-URL, Schl&uuml;sselw&ouml;rter, Gr&ouml;&szlig;e und Bannergewichtung.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		Wenn diese Option aktiviert ist, erfolgt eine Vorschau aller Banner auf der Seite <i>&Uuml;bersicht Banner</i>. Ist diese Option deaktiviert, ist f&uuml;r jeden Banner einzeln dennoch eine Vorschau m&ouml;glich. Hierzu mu&szlig; auf das Dreieck neben dem Banner geklickt werden.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		Wenn diese Option aktiviert ist, wird der aktuelle HTML-Banner anstelle des HTML-Codes angezeigt. Diese Funktion ist in der Voreinstellung deaktiviert; denn auf diesem Wege angezeigte HTML-Banner k&ouml;nnen Konflikte produzieren. Jeder HTML-Banner kann in der <i>&Uuml;bersicht Banner</i> durch anklicken von <i>Banner anzeigen</i> dargestellt werden.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		Wenn diese Option aktiviert ist, erfolgt eine Vorschau auf den Seiten <i>Bannermerkmale</i>, <i> Auslieferungsoptionen</i> und <i> Verkn&uuml;pfte Zonen</i>.<br />
Ist diese Option deaktiviert, ist die Bannerdarstellung m&ouml;glich, wenn auf <i>Banner anzeigen</i> geklickt wird.
		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		Wenn diese Option gesetzt ist, werden alle inaktiven Banner, Kampagnen und Inserenten auf den Seiten <i>Inserenten & Kampagnen</i> und <i>&Uuml;bersicht Kampagnen</i> verborgen. Diese verborgenen Informationen k&ouml;nnen durch anklicken von </i>Alle anzeigen</i> dargestellt werden.
		";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "
	Wenn diese Option aktiviert ist, werden alle gefundene Banner auf der Seite <i>Verkn&uuml;pfte Banner</i> dargestellt, wenn als Methode <i>Kampagne (Auswahl)</i> gew&auml;hlt wurde. Hier durch wird genau dargestellt, welche Banner zur Auslieferung vorgesehen sind. Auch eine Vorschau der zugeh&ouml;renden Banner ist m&ouml;glich.
		";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		Wenn diese Option aktiviert ist, werden die zugeh&ouml;renden Kampagnen der Banner auf der Seite <i>Verkn&uuml;pfte Banner</i> angezeigt, wenn als Methode <i>Banner (Auswahl)</i> gew&auml;hlt wurde. Hierdurch wird es - vor der Verkn&uuml;pfung - m&ouml;glich, anzuzeigen, welcher Banner den jeweiligen Kampagnen zugeordnet ist. Die Banner sind in der Sortierung der Kampagnen eingeordnet und werden nicht alphabetisch angezeigt.
		";

//neu in MMM 0.3

$GLOBALS['phpAds_hlp_admin_email'] = "
        Geben Sie hier die E-Mail-Adresse des Administrators an. Diese Adresse wird als Absender f&uuml;r die Statstik-E-Mals an die Werbetreibenden genutzt.";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        Sie k&ouml;nnen die E-Mail-Header der von ".MAX_PRODUCT_NAME." verschicketen E-Mails &auml;ndern.
		";
$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_plain_nocookies'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =


$GLOBALS['phpAds_hlp_block_adconversions'] = "
		Wenn ein Besucher eine Seite, die den Tracker-Code enth&auml;lt erneut l&auml;dt, w&uuml;rde ".MAX_PRODUCT_NAME." normalerweise jedes Mal eine Konversion protokollieren. Mit Hilfe dieser Funktion stellen Sie sicher, da&szlig; pro Benutzer nur eine Ad-Konversion innerhalb eines von Ihnen bestimmten Intervalles aufgezeichnet wird. Beispiel: Wenn Sie das Intervall auf 300 Sekunden setzen, dann wird ".MAX_PRODUCT_NAME." nur dann eine Ad-Konversion protokollieren, wenn der Besucher die betreffende Seite innerhalb der letzten 5 Mnuten nicht bereits einmal aufgerufen hat. Diese Funktion setzt voraus, da&szlig; der Nutzer Cookies akzeptiert.
		";


$GLOBALS['phpAds_hlp_log_adconversions'] = "
        Normalerweise werden Ad-Konversionen protokolliert. Wenn Sie diese Funktion nicht ben&ouml;tigen, k&ouml;nnen Sie diese hier abschalten.
		";



$GLOBALS['phpAds_hlp_url_prefix'] = " ((gibt es schon!!)
        ".MAX_PRODUCT_NAME." mu&szlig; wissen, in welchen Verzichnissen sich seine Dateien befinden um vern&uuml;nftig zu funktionieren.
		  Sie m&uuml;ssen deshalb die URL zum Verzeichnis in dem ".MAX_PRODUCT_NAME." installiert ist angeben. Beispielsweise <i>http://www.your-url.com/".MAX_PRODUCT_NAME."</i>.
		";


?>
