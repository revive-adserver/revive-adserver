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
       Geben Sie den Hostname an, der als Datenbankserver für ".$phpAds_dbmsname." fungiert.
		";

$GLOBALS['phpAds_hlp_dbport'] = "
        Geben Sie die Port-Nummer für den Datenbank-Server von ".$phpAds_dbmsname." an.. Die Voreinstellung für eine".$phpAds_dbmsname."-Datenbank ist <i>".
		($phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>.
		";

$GLOBALS['phpAds_hlp_dbuser'] = "
        Geben Sie den Benutzername für die <i>Datenbank</i> an. Mit diesem Benutzername greift ".MAX_PRODUCT_NAME." auf den Datenbankserver von ".$phpAds_dbmsname." zu.
		";

$GLOBALS['phpAds_hlp_dbpassword'] = "
Geben Sie das Passwort für die <b>Datenbank</b> an. Mit diesem Passwort kann ".MAX_PRODUCT_NAME." auf den Datenbankserver von ".$phpAds_dbmsname." zugreifen.
		";

$GLOBALS['phpAds_hlp_dbname'] = "
         Geben Sie den Namen der Datenbank an, in die ".MAX_PRODUCT_NAME." die Daten speichern soll.
		Wichtig! Die Datenbank muß bereits auf dem Datenbankserver vorhanden sein.
".MAX_PRODUCT_NAME." erstellt <b>nicht</b> diese
		Datenbank, wenn sie noch nicht existiert.
		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "
        Die dauerhafte Verbindung zur Datenbank kann die Geschwindigkeit von ".MAX_PRODUCT_NAME." durchaus erhöhen, insbesondere wird die Ladezeiten vom Server verringert. Andererseits können bei Seiten mit sehr vielen Besuchern - genau gegenteilig zu oben - durch die dauerhafte Verbindung die Ladezeiten erheblich ansteigen. <br />
Welche Art der Verbindung gewählt wird, <i>normale</i> oder <i>dauerhafte</i>, ist abhïängig von der Besucherzahl und der eingesetzten Hardware. Wenn ".MAX_PRODUCT_NAME." zu viele Ressourcen belegt, könnte dies durch die Einstellung <i>dauerhafte Verbindung </i> hervorgerufen worden sein.
		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        Wird die Datenbank ".$phpAds_dbmsname." nicht nur von ".MAX_PRODUCT_NAME.", sondern auch von weiteren Anwendungen genutzt, können unter Umständen Kompatibilitätsprobleme auftreten. Durch setzen des Kompatibilitätsmodus (Datenbank) werden diese Probleme behoben.<br />
Wenn die Bannerauslieferung im <i>lokalen Modus</i> erfolgt und Kompatibilitätsmodus (Datenbank) gesetzt ist, hinterläßt ".MAX_PRODUCT_NAME." die Einstellungen der Datenbank so, wie diese vorher vorgefunden wurden. <br />
Diese Option verlangsamt den Adserver etwas (sehr gering) und ist in der Voreinstellung deaktiv.
		";

$GLOBALS['phpAds_hlp_table_prefix'] = "
Wird die Datenbank ".$phpAds_dbmsname." nicht nur von ".MAX_PRODUCT_NAME.", sondern auch von weiteren Anwendungen genutzt, ist es angeraten, den von ".MAX_PRODUCT_NAME." genutzten Tabellen, einen individuellen <i>Präfix</i> voranzustellen. Damit kann sichergestellt werden, daß dieselben Tabellennamen nicht von verschiedenen Programmen verwendet werden. <br />
".MAX_PRODUCT_NAME." kann mehrfach installiert werden , wobei alle installierten Programme auf dieselbe Datenbank zugreifen können. Es muß dann für jede Anwendung den Tabellennamen ein eigener eindeutiger  <i>Präfix</i> vorangestellt werden.
		";

$GLOBALS['phpAds_hlp_table_type'] = "
        ".$phpAds_dbmsname." unterstützt mehrere Tabellentypen. Jeder Tabellentype hat seine eigenen Eigenschaften, die es durchaus ermöglichen, ".MAX_PRODUCT_NAME." stark zu beschleunigen. <br />
MyISAM ist der immer vorhandene Tabellentype und daher Voreinstellung bei ".$phpAds_dbmsname.".
		";

$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".MAX_PRODUCT_NAME." benötigt für das korrekte Funktionieren die genaue Angabe über den eigenen Standort auf dem Server. Benötigt wird die URL und das Verzeichnis, in dem ".MAX_PRODUCT_NAME." installiert ist. Z.B.: <i>http://www.your-url.com/".MAX_PRODUCT_NAME."</i>.
		";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "
        ".MAX_PRODUCT_NAME." muß wissen, in welchen Verzichnissen sich seine Dateien befinden um vernünftig zu funktionieren. Manchmal unterscheidet sich das SSL-Präfixx vom normalen URL-Präfix. Sie müssen deshalb die URL zum Verzeichnis in dem ".MAX_PRODUCT_NAME." installiert ist angeben. Beispielsweise <i>https://www.your-url.com/".MAX_PRODUCT_NAME."</i>.
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        Damit Kopf- bzw. Fußzeilen im Admin-Bereich eingeblendet werden können, müssen dies
         als HTML-Datei vorhanden sein. Eingegeben werden muß die Adresse dieser Dateien  (z.B.: /home/login/www/header.htm). <br />
In den HTML-Dateien ist der entsprechende Text für die Kopf- oder Fußzeile zu hinterlegen. Es können auch HTML-Tags verwendet werden. Wird HTML verwendet, sind Tags wie <i><body>, <html> </i>usw. nicht zugelassen. <br />
		";

$GLOBALS['phpAds_hlp_my_logo'] = "
        Geben Sie hier den Dateinamen Ihres Logos an. Dieses wird dann anstatt des Standard-Logos angezeigt. Sie müssen die Logo-Datei zuerst in das Verzeichnis admin/images hochladen, bevor Sie den Dateinamen hier angeben können.
               ";
               
$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = "
        Geben Sie hier Ihre Wunschfarbe ein, in der die Navigationsreiter, das Suchfeld und gefetteter Text erscheinen sollen.
               ";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "
        Geben Sie hier Ihre Wunschfarbe für die Hintergrundfarbe der Kopfzeile ein.
               ";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "
        Geben Sie hier Ihre Wunschfarbe für den aktiven Navigationsreiter ein.
               ";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "
        Geben Sie hier Ihre Wunschfarbe für den Text in der Kopfzeile an.
               ";
               
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		Die Kompression durch GZIP vermindert dem Umfang der Daten, die aus dem 	Administrationsberich zum Browser übertragen werden. Dadurch wird die Datenübertragung stark beschleunigt. Benötigt wird hierfür mindestens PHP 4.0.5 mit GZIP-Erweiterung.
		";

$GLOBALS['phpAds_hlp_language'] = "
        Voreinstellung der Sprache. Diese Sprache wird als Voreinstellung in alle Module und
        Programmteile, auch für Verleger- und Inserentenbereiche übernommen. <br />
        Unabhängig hiervon kann für jeden Verleger oder Inserenten eine eigene Sprache eingestellt werden. Auch kann ihnen in den jeweiligen Einstellungen gestattet werden, selbst die Sprachauswahl zu ändern.
		";

$GLOBALS['phpAds_hlp_name'] = "
        Es besteht die Möglichkeit, für die Anwendung anstelle <i>".MAX_PRODUCT_NAME." </i> eine
        eigene Bezeichnung oder einen eigenen Namen zu vergeben. Dieser Name erscheint auf allen Seiten
        im Administations-, Verleger- und Inserentenbereich. Bleibt dieses Feld leer, wird ein Logo von ".MAX_PRODUCT_NAME." angezeigt.
		";

$GLOBALS['phpAds_hlp_company_name'] = "
        Dieser Firmenname wird bei den automatischen E-Mails an Verleger und Inserenten verwendet.
		";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
         ".MAX_PRODUCT_NAME." prüft standardmäßig, ob die Bibliothek GD-library installiert ist und
          welche Bildformate unterstützt werden. Einige Versionen von PHP gestatten diese automatische
           Prüfung nicht. Das Ergebnis kann fehlerhaft sein. In diesem Fall können die unterstützten
           Bildformate manuell eingegeben werden. Gültige Formate sind z.B. <i> none, pgn, jpeg, gif.</i> .
		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "
        Wenn P3P Privacy Policies genutzt werden sollen, muß diese Option hier gesetzt werden.
		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        Die Zeile für die P3P Policies ist bei ".MAX_PRODUCT_NAME." wie folgt festgelegt: 'CUR ADM OUR NOR STA NID'. Sie wird gemeinsam mit Cookies an den Besucher gesendet. Durch dieses Verfahren wird sichergestellt, daß Internet Explorer 6 die Cookies akzeptiert. Der Inhalt der Zeile kann durch eigene gültige Texte geändert werden.
		";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        Wenn Sie eine vollständige Datenschutzerklärung nutzen, können Sie hier deren den Standort eingeben.
		";

$GLOBALS['phpAds_hlp_compact_stats'] = "
	".MAX_PRODUCT_NAME." bietet die Möglichkeit, entweder detaillierte Statistiken oder kompakte zu wählen. für die kompakten Statistiken werden AdViews und AdClicks gesammelt und stündlich verarbeitet. Die detaillierten Statistiken benötigen mehr Datenbank-Ressourcen.
		";

$GLOBALS['phpAds_hlp_log_adviews'] = "
	Normalerweise werden alle AdViews aufgezeichnet und fließen in die Statistiken ein. Diese Option kann deaktiviert werden.
		";

$GLOBALS['phpAds_hlp_block_adviews'] = "
		Die Reloadsperre verhindert, daß ein Banner mehrfach gezählt wird, wenn er auf derselben Seite demselben Besucher öfters präsentiert wird; z.B. dadurch, daß der Besucher die Browserseite aktualisiert. An dieser Stelle kann die Dauer in Sekunden eingegeben werden, für die die Reloadsperre aktiv ist. Die Sperre funktioniert nur, wenn der Besucher Cookies zuläßt.
		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "
	Normalerweise werden alle AdClicks aufgezeichnet und fließen in die Statistiken ein. Diese Option kann deaktiviert werden.
		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "
		Die Reclicksperre verhindert, daß Clicks auf ein Banner mehrfach gezählt wird, wenn  derselben Besucher mehr als einmal auf einen Banner klickt. An dieser Stelle kann die Dauer in Sekunden eingegeben werden, für die die Reclicksperre aktiv ist. Die Sperre funktioniert nur, wenn der Besucher Cookies zuläßt.
		";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		Geotargeting ist die Standortbestimmung des Besuchers. Wenn Sie eine Datenbank für
		Geotargeting einsetzen, werden als geographische Informationen gespeichert: <br /><br />
Das Herkunftsland des Besuchers und die Entwicklung der Banner nach Ländern. Die Option Geotargeting kann nur in Verbindung mit detaillierten Statistiken aktiviert werden.
		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		Der Hostname des Besuchers wird in der Regel vom Web-Server bestimmt.
		Bestimmt der (eigene) Web-Server nicht den Hostnamen, kann die Information von
		".MAX_PRODUCT_NAME." ermittelt werden. Wird diese Option gesetzt, kann es zur Verlangsamung der Bannerauslieferung kommen.
		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Verwendet der Besucher einen Proxy-Zugang, protokolliert ".MAX_PRODUCT_NAME." normalerweise die IP-Adresse und/oder den Hostname des Proxy-Servers. Diese Erfassung kann so gesetzt werden, daß ".MAX_PRODUCT_NAME." versucht, den tatsächlichen Hostnamen oder die IP-Adresse zu ermitteln, die hinter dem Proxy-Server steht. Kann diese  <i>richtige</i> Adresse des Besuchers nicht ermittelt werden, werden die Daten des Proxy-Servers verwendet. In der Voreinstellung ist diese Option deaktiviert, da sie die Bannerauslieferung verlangsamt.
		";

$GLOBALS['phpAds_hlp_obfuscate'] = "Wenn Sie möchten, daß ".MAX_PRODUCT_NAME." den Namen der Gruppe, zu der dieses Werbemittel gehört verschleiert, klicken Sie diese Option an.";

$GLOBALS['phpAds_hlp_auto_clean_tables'] =
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		Die aufgezeichneten Daten und erstellten Statistiken können nach einer bestimmten Zeit gelöscht werden. An dieser Stelle kann in Wochen eingegeben werden, nach welchem Zeitraum die Daten gelöscht werden sollen. Mindestens sind 3 Wochen einzugeben.
		";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] =
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		Durch diese Funktion können alle Einträge im Benutzerprotokoll nach einer bestimmten Zeit gelöscht werden. An dieser Stelle kann in Wochen eingegeben werden, nach welchem Zeitraum die aufgezeichneten Benutzerdaten gelöscht werden sollen. Mindestens sind 3 Wochen einzugeben
		";

$GLOBALS['phpAds_hlp_geotracking_type'] = "
		Über Geotargeting wird anhand der IP-Adresse der Standort bzw. die Herkunft des Besuchers ermittelt. Ermittelt wird das Land. Nützlich ist das, wenn mehrsprachige Banner oder Banner in mehreren Sprachen ausgeliefert werden können. Die Auslieferung eines Banners kann auf bestimmte Herkunftsländer (der Besucher) eingeschränkt oder nach Länderkategorien ausgewertet werden.<br />
für Geotargeting wird eine spezielle Datenbank benötigt. ".MAX_PRODUCT_NAME." unterstützt die Datenbanken von  <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> und <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a>.
		";

$GLOBALS['phpAds_hlp_geotracking_location'] = "
		Wenn nicht das Modul GeoIP Apache verwendet wird, muß für ".MAX_PRODUCT_NAME." das Verzeichnis eingegeben werden, in dem sich die Geotargeting-Datenbank befindet. Empfehlenswert ist es, diese außerhalb des Dokumentenverzeichnisses des Web-Servers abzulegen; da diese andernfalls für Dritte einsehbar sein könnte.
		";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "
		Die Umwandlung der IP-Adresse in länderspezifische Informationen benötigt Zeit. Damit diese Informationen nicht bei jeder Bannerauslieferung an denselben Besucher berechnet werden müssen, werden sie bei der ersten Bannerauslieferung berechnet und in einem Cookie gespeichert. Die geographischen Informationen aus dem Cookie werden bei nachfolgenden Bannerauslieferungen für das Geotargeting verwendet.
		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "
	Sollen AdViews und AdClicks von bestimmten Host nicht aufgezeichnet werden, können diese hier aufgelistet werden. Wurde eingestellt, daß der Hostname ermittelt wird, können Domain-Name oder IP-Adresse eingegeben werden. Wurde diese Option deaktiviert, ist nur die Eingabe der IP-Adresse möglich. Platzhalter/Wildcards sind zugelassen (z.B. '*.altavista.com' or '192.168.*')
		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "
	Der Tag des Wochenbeginns kann eingestellt werden. Voreinstellung ist Montag.
		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "
	Die Anzahl der Nachkommastellen für die Darstellung von Prozentangaben innerhalb der Statistiken.
		";

$GLOBALS['phpAds_hlp_warn_admin'] = "
	Es besteht die Möglichkeit, daß ".MAX_PRODUCT_NAME." eine E-Mail an den Administrator sendet, wenn für eine Kampagne ein bestimmtes Restguthaben für AdViews oder AdClicks unterschritten wurde. In der Voreinstellung ist diese Option gesetzt.
		";

$GLOBALS['phpAds_hlp_warn_client'] = "
	Es besteht die Möglichkeit, daß ".MAX_PRODUCT_NAME." eine E-Mail an den Inserenten sendet, wenn für eine Kampagne ein bestimmtes Restguthaben für AdViews oder AdClicks unterschritten wurde.
In der Voreinstellung ist diese Option gesetzt.
		";

$GLOBALS['phpAds_hlp_qmail_patch'] = "
	Einigen Versionen von <i>qMail</i> sind fehlerbehaftet. Die Kopfzeile der E-Mail wird in den Haupttext verschoben. Hier kann festgelegt werden, daß ".MAX_PRODUCT_NAME." jede E-Mail in einem Format versendet, das von <i>qMail</i> korrekt wiedergegeben wird.
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
		nicht aktiv sein, so bedeutet dies, daß er beim Generieren eines Bannercodes nicht zur Verfügung steht.
		Wichtig: Für bestehende Zonen ist dieser Bannercode nach wie vor aktiv und Sie können Banner ausliefern. Sie
		können nur keine neuen Zonen mit dem betreffenden Bannercode anlegen.
		";

$GLOBALS['phpAds_hlp_con_key'] = "
		für den lokalen Modus als Verfahren zur Bannerauslieferung bietet ".MAX_PRODUCT_NAME." mächtige Werkzeuge zur Selektion. Unter anderem können hier logische Operatoren verwendet werden. Weitere Informationen finden sich im Handbuch. In der Voreinstellung ist diese Option gesetzt.
		";

$GLOBALS['phpAds_hlp_mult_key'] = "
		Banner können nach Schlüsselwörtern ausgewählt werden. Es können ein oder mehrere Schlüsselwörter je Banner oder je Bannerauslieferung bestimmt werden. Die Anzahl der Schlüsselwörter kann auf ein Schlüsselwort begrenzt werden; andernfalls sind immer mehrere zulässig. Die Option für mehrere Schlüsselwörter ist in der Voreinstellung gesetzt. Ist nur ein Schlüsselwort gewünscht, muß die Option deaktiviert werden.
		";

$GLOBALS['phpAds_hlp_acl'] = "
	Sollen für die Bannerauslieferung keine Beschränkungen festgelegt werden, könnte durch die Deaktivierung dieser Option die Geschwindigkeit von ".MAX_PRODUCT_NAME." etwas beschleunigt werden.
		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "
	Wenn ".MAX_PRODUCT_NAME." keine Verbindung zur Datenbank herstellen kann, bzw. wenn kein gültiger Banner gefunden wurde, wird der hier definierte Banner ersatzweise ausgeliefert. für diesen Ersatzbanner werden weder AdViews noch AdClicks aufgezeichnet. In der Voreinstellung ist diese Funktion deaktiviert.
		";

$GLOBALS['phpAds_hlp_delivery_caching'] = "
		Die Verwendung eines Caches als Zwischenspeicher beschleunigt die Bannerauslieferung. In dem Cache sind alle Informationen, die für die Bannerauslieferung notwendig sind, hinterlegt. Als Voreinstellung ist der Cache Teil der Datenbank. Alternativ hierzu kann er in einer Datei oder in einem shared memory abgelegt werden. Die schnellste Bannerauslieferung bietet shared memory; doch bereits der Einsatz einer Datei beschleunigt die Bannerauslieferung erheblich. Wird die Option des Caches für die Bannerauslieferung deaktiviert, verlangsamt sich die Leistung von".MAX_PRODUCT_NAME." sehr und wird daher nicht empfohlen.
		";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] =
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
	".MAX_PRODUCT_NAME." unterstützt unterschiedliche Bannerformate, die auf unterschiedlicher Weise gespeichert werden. Die ersten zwei werden für das lokale Speichern verwendet. Banner können über das Administrationsmodul in die Datenbank geladen oder auf dem Web-Server gespeichert werden. Banner können auch auf externen Servern über die URL verwaltet werden. Sie können HTML-Banner sein und einfache Texte für Textanzeigen.
		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "
Wenn Banner auf dem Web-Server gespeichert werden sollen, müssen die Einstellungen hierfür konfiguriert werden. Sollen die Banner auf einem lokalen Verzeichnis gespeichert werden, muß  <i>Lokales Verzeichnis</i> gewählt werden. Für die Speicherung auf einem FTP-Server ist <i> Externer FTP-Server</i> einzustellen. Es ist durchaus möglich, daß der eigene Web-Server nicht lokal, sondern als FTP-Server eingerichtet wird.
		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "
	In das hier festgelegte Verzeichnis speichert ".MAX_PRODUCT_NAME." die hochgeladenen Banner. Das Verzeichnis darf für PHP nicht schreibgeschützt sein. Es muß, ggf. mit Hilfe eines FTP-Programmes, die Zugriffs- und Schreibberechtigung gesetzt werden. Das Verzeichnis muß im Root-Verzeichnis von ".MAX_PRODUCT_NAME." sein. Bei der Eingabe des Verzeichnisses darf als Ende kein  Slash (/) eingegeben werden. Diese Angaben werden nur bei  <i>Lokales Verzeichnis</i> als Wahl für die Speicherung benötigt.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		für das Speicherungsverfahren  <i> Externer FTP-Server</i> wird die IP-Adresse oder der Domain-Name des FTP-Servers benötigt.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		für das Speicherungsverfahren  <i> Externer FTP-Server</i> muß das Verzeichnis, in das die Banner gespeichert werden, genau bezeichnet werden (auf Groß-/Kleinschreibung ist ggf. zu achten).
		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		für das Speicherungsverfahren  <i> Externer FTP-Server</i> muß der Benutzername für den Zugang zum FTP-Server eingegeben werden.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		für das Speicherungsverfahren  <i> Externer FTP-Server</i> wird zum Benutzername ein gültiges Passwort benötigt.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_passive'] = " 
 	    Einige FTP Server und Firewalls verlangen, dass Sie bei �bertragungen den Passive Mode (PASV) verwenden. 
 	    Wenn " . MAX_PRODUCT_NAME . " Passive Mode verwenden soll, aktivieren Sie diese Option. 
 	    ";
 	    
$GLOBALS['phpAds_hlp_type_web_url'] = "
	Werden die Banner auf einem Web-Server gespeichert, müssen sowohl die (öffentliche) URL als auch das mit ihr korrespondierende lokale Verzeichnis eingegeben werden. Z. B.<br />
(öffentliche) URL       = <i>http://www.Werbeplatzvermarktung.de/ads</i><br />
Lokales Verzeichnis   = <i>/var/www/htdocs/ads</i><br />
Bei der Eingabe des Verzeichnisses darf als Ende kein  Slash (/) eingegeben werden.
		";

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "
        Wenn Sie Ihre Banner auf einem Web-Server speichern, muß ".MAX_PRODUCT_NAME." wissen, welche öffentliche URL (SSL) mit
dem von Ihnen unten angegebenen Verzeichnis korresondiert. Schließen Sie die Pfadangabe nicht mit einem Slash (/) ab.
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
	Durch diese Option modifiziert ".MAX_PRODUCT_NAME." den HTML-Code so, daß AdClicks aufgezeichnet werden können. Auch wenn diese Option an dieser Stelle aktiviert wird, ist es dennoch möglich, sie für jeden Banner individuell zu deaktivieren.
		";

$GLOBALS['phpAds_hlp_type_html_php'] = "
	Es kann zugelassen werden, daß ausführbare PHP-Codes in HTML-Banner eingebettet sind. Diese Funktion ist in der Voreinstellung deaktiviert.
		";

$GLOBALS['phpAds_hlp_admin'] = "
	Bitte geben Sie den Benutzername des Administrators ein. Mit diesem Benutzername ist der Zugang zum Administrationsmodul möglich
		";

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
	Bitte geben Sie ein Passwort für den Administrator ein. Die Passworteingabe muß durch erneute Eingabe bestätigt werden.
		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "
	Um das Passwort des Administrators zu ändern, muß zunächst das alte Passwort eingegeben werden. Das neue Passwort ist zweimal einzugeben.
		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "
	Eingabe des vollen Namen (Name, Vorname) des Administrators. Die Angaben werden für E-Mails benötigt.
		";

$GLOBALS['phpAds_hlp_admin_email'] = "
        Geben Sie hier die E-Mail-Adresse des Administrators an. Diese Adresse wird als Absender für die Statstik-E-Mals an die Werbetreibenden genutzt.";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        Sie können die E-Mail-Header der von ".MAX_PRODUCT_NAME." verschicketen E-Mails ändern.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
	Wenn eine Warnung erfolgen soll, bevor Zonen, Kampagnen, Banner, Verleger, Inserenten endgültig gelöscht werden, muß diese Option gesetzt sein.
		";

$GLOBALS['phpAds_hlp_client_welcome'] = "
		Wenn diese Option gesetzt wird, erscheint eine Begrüßungszeile auf der ersten Inserentenseite. Dieser Begrüßungstext, der in der Datei welcome.html gespeichert ist, kann personalisiert oder ergänzt werden. Möglich wären Firmenlogo, Kontaktinformationen, Links zu Angeboten ...
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Der Begrüßungstext für Inserenten kann hier eingegeben werden. HTML-Tags sind zugelassen.
		Ist hier ein Text eingegeben, wird die Datei welcome.html ignoriert.
		";

$GLOBALS['phpAds_hlp_updates_frequency'] = "
		".MAX_PRODUCT_NAME." wird ständig optimiert. Es kann in selbst definierten Intervallen direkt beim Update-Server nach neuen Versionen gesucht werden. Ist eine neue Version vorhanden, werden in einem Dialogfenster zunächst weitere Informationen über das Update gegeben.
		";

$GLOBALS['phpAds_hlp_userlog_email'] = "
		Soll von allen durch ".MAX_PRODUCT_NAME."  versandte E-Mails eine Kopie angefertigt werden, kann das durch diese Option ermöglicht werden. Die E-Mails werden in das Benutzerprotokoll eingetragen.
		";

$GLOBALS['phpAds_hlp_userlog_inventory'] = "
		Wenn Sie sichergehen wollen, daß die stündliche Inventarkalkulation korrekt abläuft,
		können Sie einen Bericht darüber anlegen lassen. Dieser Bericht enthält die Vorhersagen über die Werbemittelprofile und die Dringlicghkeitsdstufe für jedes Werbemittel. Diese Informationen sind mützlich, wenn Sie den Entwicklern einen Bugreport bezüglich der Inventarkalkulation senden möchten. Der Bereicht wird vom System als Teil des Benutzerprotokolls gespeichert.
		";
		
$GLOBALS['phpAds_hlp_userlog_priority'] = "
		Es kann in einem Bericht gespeichert werden, ob die stündlichen Neuberechnungen korrekt durchgeführt werden. Der Bericht enthält die voraussichtlichen Einblendungen und Prioritäten. Hilfreich kann der Bericht sein, um Fehler in der Kalkulation zu finden. Er wird in das Benutzerprotokoll eingetragen.
		";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "
		Um überprüfen zu können, ob die Datenbank fehlerfrei gesäubert wurde, kann ein Bericht über den Datenbanklauf erstellt werden. Er wird in das Benutzerprotokoll eingetragen.
		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "
		Die Gewichtung für Banner ist als Voreinstellung <i>1</i>. Die Voreinstellung kann an dieser Stelle höher gesetzt werden.
		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "
		Die Gewichtung für Kampagnen ist als Voreinstellung <i>1</i>. Die Voreinstellung kann an dieser Stelle höher gesetzt werden.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "
		Wenn diese Option aktiviert ist, werden weitere Informationen über jede Kampagne auf der Seite <i>übersicht Kampagnen</i> dargestellt. Diese Informationen sind: Restguthaben an AdViews und AdClicks., Aktivierungsdatum, Auslaufdatum und Priorität.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		Wenn diese Option aktiviert ist, werden weitere Informationen über jeden Banner auf der Seite <i>übersicht Banner</i> dargestellt. Diese Informationen sind: Ziel-URL, Schlüsselwörter, Größe und Bannergewichtung.
		";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		Wenn diese Option aktiviert ist, erfolgt eine Vorschau aller Banner auf der Seite <i>Übersicht Banner</i>. Ist diese Option deaktiviert, ist für jeden Banner einzeln dennoch eine Vorschau möglich. Hierzu muß auf das Dreieck neben dem Banner geklickt werden.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		Wenn diese Option aktiviert ist, wird der aktuelle HTML-Banner anstelle des HTML-Codes angezeigt. Diese Funktion ist in der Voreinstellung deaktiviert; denn auf diesem Wege angezeigte HTML-Banner können Konflikte produzieren. Jeder HTML-Banner kann in der <i>Übersicht Banner</i> durch anklicken von <i>Banner anzeigen</i> dargestellt werden.
		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		Wenn diese Option aktiviert ist, erfolgt eine Vorschau auf den Seiten <i>Bannermerkmale</i>, <i> Auslieferungsoptionen</i> und <i> Verknüpfte Zonen</i>.<br />
Ist diese Option deaktiviert, ist die Bannerdarstellung möglich, wenn auf <i>Banner anzeigen</i> geklickt wird.
		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		Wenn diese Option gesetzt ist, werden alle inaktiven Banner, Kampagnen und Inserenten auf den Seiten <i>Inserenten & Kampagnen</i> und <i>Übersicht Kampagnen</i> verborgen. Diese verborgenen Informationen können durch anklicken von </i>Alle anzeigen</i> dargestellt werden.
		";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "
	Wenn diese Option aktiviert ist, werden alle gefundene Banner auf der Seite <i>Verknüpfte Banner</i> dargestellt, wenn als Methode <i>Kampagne (Auswahl)</i> gewählt wurde. Hier durch wird genau dargestellt, welche Banner zur Auslieferung vorgesehen sind. Auch eine Vorschau der zugehörenden Banner ist möglich.
		";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		Wenn diese Option aktiviert ist, werden die zugehörenden Kampagnen der Banner auf der Seite <i>Verknüpfte Banner</i> angezeigt, wenn als Methode <i>Banner (Auswahl)</i> gewählt wurde. Hierdurch wird es - vor der Verknüpfung - möglich, anzuzeigen, welcher Banner den jeweiligen Kampagnen zugeordnet ist. Die Banner sind in der Sortierung der Kampagnen eingeordnet und werden nicht alphabetisch angezeigt.
		";

//neu in MMM 0.3

$GLOBALS['phpAds_hlp_admin_email'] = "
        Geben Sie hier die E-Mail-Adresse des Administrators an. Diese Adresse wird als Absender für die Statstik-E-Mals an die Werbetreibenden genutzt.";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "
        Sie können die E-Mail-Header der von ".MAX_PRODUCT_NAME." verschicketen E-Mails ändern.
		";
$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_plain_nocookies'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =


$GLOBALS['phpAds_hlp_block_adconversions'] = "
		Wenn ein Besucher eine Seite, die den Tracker-Code enthält erneut lädt, würde ".MAX_PRODUCT_NAME." normalerweise jedes Mal eine Konversion protokollieren. Mit Hilfe dieser Funktion stellen Sie sicher, daß pro Benutzer nur eine Ad-Konversion innerhalb eines von Ihnen bestimmten Intervalles aufgezeichnet wird. Beispiel: Wenn Sie das Intervall auf 300 Sekunden setzen, dann wird ".MAX_PRODUCT_NAME." nur dann eine Ad-Konversion protokollieren, wenn der Besucher die betreffende Seite innerhalb der letzten 5 Mnuten nicht bereits einmal aufgerufen hat. Diese Funktion setzt voraus, daß der Nutzer Cookies akzeptiert.
		";


$GLOBALS['phpAds_hlp_log_adconversions'] = "
        Normalerweise werden Ad-Konversionen protokolliert. Wenn Sie diese Funktion nicht benötigen, können Sie diese hier abschalten.
		";



$GLOBALS['phpAds_hlp_url_prefix'] = " ((gibt es schon!!)
        ".MAX_PRODUCT_NAME." muß wissen, in welchen Verzichnissen sich seine Dateien befinden um vernünftig zu funktionieren.
		  Sie müssen deshalb die URL zum Verzeichnis in dem ".MAX_PRODUCT_NAME." installiert ist angeben. Beispielsweise <i>http://www.your-url.com/".MAX_PRODUCT_NAME."</i>.
		";


?>
