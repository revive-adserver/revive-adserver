<?php // $Revision: 1.10.2.5 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// German
// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "
       Geben Sie den Hostname an, der als Datenbankserver für ".$phpAds_dbmsname." fungiert.
		";
		
$GLOBALS['phpAds_hlp_dbport'] = "
        Geben Sie die Port-Nummer für den Datenbank-Server von ".$phpAds_dbmsname." an.. Die Voreinstellung für eine".$phpAds_dbmsname."-Datenbank ist <i>".
		($phpAds_productname == 'phpAdsNew' ? '3306' : '5432')."</i>.
		";
		
$GLOBALS['phpAds_hlp_dbuser'] = "
        Geben Sie den Benutzername für die <i>Datenbank</i> an. Mit diesem Benutzername greift ".$phpAds_productname." auf den Datenbankserver von ".$phpAds_dbmsname." zu.
		";
		
$GLOBALS['phpAds_hlp_dbpassword'] = "
Geben Sie das Kennwort für die <b>Datenbank</b> an. Mit diesem Kennwort kann ".$phpAds_productname." auf den Datenbankserver von ".$phpAds_dbmsname." zugreifen. 
		";

$GLOBALS['phpAds_hlp_dbname'] = "
         Geben Sie den Namen der Datenbank an, in die ".$phpAds_productname." die Daten speichern soll. 
		Wichtig! Die Datenbank muß bereits auf dem Datenbankserver vorhanden sein.
".$phpAds_productname." erstellt <b>nicht</b> diese
		Datenbank, wenn sie noch nicht existiert.
		";
		
$GLOBALS['phpAds_hlp_persistent_connections'] = "
        Die dauerhafte Verbindung zur Datenbank kann die Geschwindigkeit von ".$phpAds_productname." durchaus erhöhen, insbesondere wird die Ladezeiten vom Server verringert. Andererseits können bei Seiten mit sehr vielen Besuchern - genau gegenteilig zu oben - durch die dauerhafte Verbindung die Ladezeiten erheblich ansteigen. <br>
Welche Art der Verbindung gewählt wird, <i>normale</i> oder <i>dauerhafte</i>, ist abhängig von der Besucherzahl und der eingesetzten Hardware. Wenn ".$phpAds_productname." zu viele Ressourcen belegt, könnte dies durch die Einstellung <i>dauerhafte Verbindung </i> hervorgerufen worden sein.
		";
		
$GLOBALS['phpAds_hlp_insert_delayed'] = "
        ".$phpAds_dbmsname." sperrt während eines Schreibvorganges den Zugriff auf die jeweilige Tabelle für andere Benutzer. Hat die WEB-Seite viele Besucher, entsteht eine Warteschleife; jeder hat abzuwarten, bis für den vorderen Besucher die Tabellen beschrieben wurden und dann die Tabellen freigegeben werden. <br>
Der Schreibvorgang kann aber auch zeitlich versetzt erfolgen. Hierbei werden die Tabellen zu einem Zeitpunkt mit geringerer Datenbankbelastung gebündelt beschrieben. Mit einem Schreibvorgang werden mehrere Tabellenzeilen beschrieben. Die Tabellen sind dann während der Besucherabfrage nicht gesperrt.
		";
		
$GLOBALS['phpAds_hlp_compatibility_mode'] = "
        Wird die Datenbank ".$phpAds_dbmsname." nicht nur von ".$phpAds_productname.", sondern auch von weiteren Anwendungen genutzt, können unter Umständen Kompatibilitätsprobleme auftreten. Durch setzen des Kompatibilitätsmodus (Datenbank) werden diese Probleme behoben.<br>
Wenn die Bannerauslieferung im <i>lokalen Modus</i> erfolgt und Kompatibilitätsmodus (Datenbank) gesetzt ist, hinterläßt ".$phpAds_productname." die Einstellungen der Datenbank so, wie diese vorher vorgefunden wurden. <br>
Diese Option verlangsamt den Adserver etwas (sehr gering) und ist in der Voreinstellung deaktiv.
		";
		
$GLOBALS['phpAds_hlp_table_prefix'] = "
Wird die Datenbank ".$phpAds_dbmsname." nicht nur von ".$phpAds_productname.", sondern auch von weiteren Anwendungen genutzt, ist es angeraten, den von ".$phpAds_productname." genutzten Tabellen, einen individuellen <i>Präfix</i> voranzustellen. Damit kann sichergestellt werden, daß dieselben Tabellennamen nicht von verschiedenen Programmen verwendet werden. <br>
".$phpAds_productname." kann mehrfach installiert werden , wobei alle installierten Programme auf dieselbe Datenbank zugreifen können. Es muß dann für jede Anwendung den Tabellennamen ein eigener eindeutiger  <i>Präfix</i> vorangestellt werden.
		";
		
$GLOBALS['phpAds_hlp_table_type'] = "
        ".$phpAds_dbmsname." unterstützt mehrere Tabellentypen. Jeder Tabellentype hat seine eigenen Eigenschaften, die es durchaus ermöglichen, ".$phpAds_productname." stark zu beschleunigen. <br>
MyISAM ist der immer vorhandene Tabellentype und daher Voreinstellung bei ".$phpAds_dbmsname.". 
		";
		
$GLOBALS['phpAds_hlp_url_prefix'] = "
        ".$phpAds_productname." benötigt für das korrekte Funktionieren die genaue Angabe über den eigenen Standort auf dem Server. Benötigt wird die URL und das Verzeichnis, in dem ".$phpAds_productname." installiert ist. Z.B.: <i>http://www.your-url.com/".$phpAds_productname."</i>.
		";
		
$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "
        Damit Kopf- bzw. Fußzeilen im Admin-Bereich eingeblendet werden können, müssen dies
         als HTML-Datei vorhanden sein. Eingegeben werden muß die Adresse dieser Dateien  (z.B.: /home/login/www/header.htm). <br>
In den HTML-Dateien ist der entsprechende Text für die Kopf- oder Fußzeile zu hinterlegen. Es können auch HTML-Tags verwendet werden. Wird HTML verwendet, sind Tags wie <i><body>, <html> </i>usw. nicht zugelassen. <br>
		";
		
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "
		Die Kompression durch GZIP vermindert dem Umfang der Daten, die aus dem 	Administrationsberich zum Browser übertragen werden. Dadurch wird die Datenübertragung stark beschleunigt. Benötigt wird hierfür mindestens PHP 4.0.5 mit GZIP-Erweiterung.
		";
		
$GLOBALS['phpAds_hlp_language'] = "
        Voreinstellung der Sprache. Diese Sprache wird als Voreinstellung in alle Module und
        Programmteile, auch für Verleger- und Inserentenbereiche übernommen. <br>
        Unabhängig hiervon kann für jeden Verleger oder Inserenten eine eigene Sprache eingestellt werden.
        Auch kann ihnen in den jeweiligen Einstellungen gestattet werden, selbst die Sprachauswahl zu ändern.
		";
		
$GLOBALS['phpAds_hlp_name'] = "
        Es besteht die Möglichkeit, für die Anwendung anstelle <i>".$phpAds_productname." </i> eine
        eigene Bezeichnung oder einen eigenen Namen zu vergeben. Dieser Name erscheint auf allen Seiten
        im Administations-, Verleger- und Inserentenbereich. Bleibt dieses Feld leer, wird ein Logo von ".$phpAds_productname." angezeigt.
		";
		
$GLOBALS['phpAds_hlp_company_name'] = "
        Dieser Firmenname wird bei den automatischen eMails an Verleger und Inserenten verwendet.
		";
		
$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "
         ".$phpAds_productname." prüft standardmäßig, ob die Bibliothek GD-library installiert ist und
          welche Bildformate unterstützt werden. Einige Versionen von PHP gestatten diese automatische
           Prüfung nicht. Das Ergebnis kann fehlerhaft sein. In diesem Fall können die unterstützten
           Bildformate manuell eingegeben werden. Gültige Format sind z.B. <i> none, pgn, jpeg, gif.</i> .
		";
		
$GLOBALS['phpAds_hlp_p3p_policies'] = "
        Wenn P3P Privacy Policies genutzt werden sollen, muß diese Option hier gesetzt werden. 
		";
		
$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "
        Die Zeile für die P3P Policies ist bei ".$phpAds_productname." wie folgt festgelegt: 'CUR ADM OUR NOR STA NID'. Sie wird gemeinsam mit Cookies an den Besucher gesendet. Durch dieses Verfahren wird sichergestellt, daß Internet Explorer 6 die Cookies akzeptiert. Der Inhalt der Zeile kann durch eigene gültige Texte geändert werden.
		";
		
$GLOBALS['phpAds_hlp_p3p_policy_location'] = "
        Wenn Sie eine vollständige Privacy Policy nutzen, können Sie hier deren den Standort eingeben.
		";
		
$GLOBALS['phpAds_hlp_log_beacon'] = "
		Beacons sind kleine, nicht sichtbare Bilddateien. Zu jeder Seite, zu der ein Banner ausgeliefert wird, wird nach dieser Auslieferung ein Beacon ausgeliefert. Ist die Verwendung von Beacons gewählt worden, wird nicht die Auslieferung des Banners protokolliert, sondern die der Beacon. Denn da ein Beacon direkt nach einem Banner ausgeliefert wird, ist dokumentiert, daß der Banner  <i><b>vollständig</i></b> ausgeliefert wurde. <br>
Wird diese Option nicht gesetzt, zählt ".$phpAds_productname." die Banner während der Auslieferung. Banner, die zwar ausgeliefert wurden, nicht oder nicht vollständig beim Besucher ankamen, werden mitgezählt. Solcherart Verluste entstehen z.B. wenn der Besucher mit der ESC-Taste die Übertragung unterbricht oder wenn er rasch die Seite wechselt. 
		";
		
$GLOBALS['phpAds_hlp_compact_stats'] = "
	".$phpAds_productname." bietet die Möglichkeit, entweder detaillierte Statistiken oder kompakte zu wählen. Für die kompakten Statistiken werden AdViews und AdClicks gesammelt und stündlich verarbeitet. Die detaillierten Statistiken benötigen mehr Datenbank- Ressourcen.
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
		
$GLOBALS['phpAds_hlp_log_source'] = "
		Wenn Sie die Parameter des Quellcodes in den Code für die Bannerauslieferung übernehmen, können sie diese Informationen auch in der Datenbank speichern. Das ermöglicht, die Entwicklung der unterschiedlichen Parameter zu verfolgen. Wenn Sie keine Parameter aus dem Quellcode verwenden, oder wenn diese Daten nicht wichtig sind, empfiehlt es sich aus Sicherheitsgründen, diese Option zu deaktivieren.
		";
		
$GLOBALS['phpAds_hlp_geotracking_stats'] = "
		Geotargeting ist die Standortbestimmung des Besuchers. Wenn Sie eine Datenbank für
		Geotargeting einsetzen, werden als geographische Informationen gespeichert: <br><br>
Das Herkunftsland des Besuchers und die Entwicklung der Banner nach Ländern. Die Option Geotargeting kann nur in Verbindung mit detaillierten Statistiken aktiviert werden. 
		";
		
$GLOBALS['phpAds_hlp_log_hostname'] = "
		Sowohl IP-Adresse al auch der Hostname können für jeden Besucher aufgezeichnet werden.
		Die Speicherung beider Informationen gestattet die Auswertung, wie sich Banner in Abhängigkeit zum Besucherhost entwickeln. Diese Option kann nur in Verbindung mit detaillierten Statistiken aktiviert werden. Der Speicherbedarf ist größer als bei alleiniger Speicherung der IP-Adresse.
		";
		
$GLOBALS['phpAds_hlp_log_iponly'] = "
		Es wird nur die IP-Adresse des jeweiligen Besuchers aufgezeichnet. Das gilt auch, wenn der Hostname bekannt ist oder während des Besuchs mitgeliefert wird. Der Speicherbedarf ist geringer als durch die Speicherung von IP-Adresse und Hostname. 
		";
		
$GLOBALS['phpAds_hlp_reverse_lookup'] = "
		Der Hostname des Besuchers wird in der Regel vom WEB-Server bestimmt. 
		Bestimmt der (eigene) WEB-Server nicht den Hostname, kann die Information von 
		".$phpAds_productname." ermittelt werden. Wird diese Option gesetzt, kann es zur Verlangsamung der Bannerauslieferung kommen. 
		";
		
$GLOBALS['phpAds_hlp_proxy_lookup'] = "
		Verwendet der Besucher einen Proxy-Zugang, protokolliert ".$phpAds_productname." normalerweise die IP-Adresse und/oder den Hostname des Proxy-Servers. Diese Erfassung kann so gesetzt werden, daß ".$phpAds_productname." versucht, den tatsächlichen Hostname oder die IP-Adresse zu ermitteln, die hinter dem Proxy-Server steht. Kann diese  <i>richtige</i> Adresse des Besuchers nicht ermittelt werden, werden die Daten des Proxy-Servers verwendet. In der Voreinstellung ist diese Option deaktiviert, da sie die Bannerauslieferung verlangsamt.
		";
		
$GLOBALS['phpAds_hlp_auto_clean_tables'] = 
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "
		Die aufgezeichneten Daten und erstellten Statistiken können nach einer bestimmten Zeit gelöscht werden. An dieser Stelle kann in Wochen eingegeben werden, nach welchem Zeitraum die Daten gelöscht werden sollen. Mindestens sind 3 Wochen einzugeben.
		";
		
$GLOBALS['phpAds_hlp_auto_clean_userlog'] = 
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "
		Durch diese Funktion können alle Einträge im Benutzerprotokoll nach einer bestimmten Zeit gelöscht werden. An dieser Stelle kann in Wochen eingegeben werden, nach welchem Zeitraum die aufgezeichneten Benutzerdaten gelöscht werden sollen. Mindestens sind 3 Wochen einzugeben
		";
		


$GLOBALS['phpAds_hlp_geotracking_type'] = "
		Über Geotargeting wird anhand der IP-Adresse der Standort bzw. die Herkunft des Besuchers ermittelt. Ermittelt wird das Land. Nützlich ist das, wenn mehrsprachige Banner oder Banner in mehreren Sprachen ausgeliefert werden können. Die Auslieferung eines Banners kann auf bestimmte Herkunftsländer (der Besucher) eingeschränkt oder nach Länderkategorien ausgewertet werden.<br>
Für Geotargeting wird eine spezielle Datenbank benötigt. ".$phpAds_productname." unterstützt die Datenbanken von  <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> und <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a>.
		";
		
$GLOBALS['phpAds_hlp_geotracking_location'] = "
		Wenn nicht das Modul GeoIP Apache verwendet wird, muß für ".$phpAds_productname." das Verzeichnis eingegeben werden, in dem sich die Geotargeting-Datenbank befindet. Empfehlenswert ist es, diese außerhalb des Dokumentenverzeichnisses des WEB-Servers abzulegen; da diese andernfalls für Dritte einsehbar sein könnte.
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
	Es besteht die Möglichkeit, daß ".$phpAds_productname." eine eMail an den Administrator sendet, wenn für eine Kampagne ein bestimmtes Restguthaben für AdViews oder AdClicks unterschritten wurde.
In der Voreinstellung ist diese Option gesetzt.
		";
		
$GLOBALS['phpAds_hlp_warn_client'] = "
	Es besteht die Möglichkeit, daß ".$phpAds_productname." eine eMail an den Inserenten sendet, wenn für eine Kampagne ein bestimmtes Restguthaben für AdViews oder AdClicks unterschritten wurde.
In der Voreinstellung ist diese Option gesetzt.
		";
		
$GLOBALS['phpAds_hlp_qmail_patch'] = "
	Einigen Versionen von <i>qMail</i> sind fehlerbehaftet. Die Kopfzeile der eMail wird in den Haupttext verschoben. Hier kann festgelegt werden, daß ".$phpAds_productname." jede eMail in einem Format versendet, das von <i>qMail</i> korrekt wiedergegeben ist.
		";
		
$GLOBALS['phpAds_hlp_warn_limit'] = "
	Eingegeben wird das Restguthaben, nach dessen Unterschreitung ".$phpAds_productname." Warnungen per eMail versendet. Voreinstellung ist 100.
		";
		
$GLOBALS['phpAds_hlp_allow_invocation_plain'] = 
$GLOBALS['phpAds_hlp_allow_invocation_js'] = 
$GLOBALS['phpAds_hlp_allow_invocation_frame'] = 
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] = 
$GLOBALS['phpAds_hlp_allow_invocation_local'] = 
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] = 
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "
		Mit dieser Einstellung werden die Verfahren der Bannerauslieferung festgelegt. Für jedes Verfahren wird ein eigener Bannercode erstellt. Ist eines der Verfahren an dieser Stelle deaktiviert, erfolgt diese Sperre nur für den Bannercode-Generator. Der Ausschluß des Verfahrens betrifft Bannercodes an sich nicht. Existierende Banner eines ausgeschlossenen Verfahrens bleiben weiterhin lauffähig.
		";
		
$GLOBALS['phpAds_hlp_con_key'] = "
		Für den lokalen Modus als Verfahren zur Bannerauslieferung bietet ".$phpAds_productname." mächtige Werkzeuge zur Selektion. U. a. können hier logische Operatoren verwendet werden. Weitere Informationen finden sich im Handbuch. In der Voreinstellung ist diese Option gesetzt.
		";
		
$GLOBALS['phpAds_hlp_mult_key'] = "
		Banner können nach Schlüsselwörtern ausgewählt werden. Es können ein oder mehrere Schlüsselwörter je Banner oder je Bannerauslieferung bestimmt werden. Die Anzahl der Schlüsselwörter kann auf ein Schlüsselwort begrenzt werden; andernfalls sind immer mehrere zulässig. Die Option für mehrere Schlüsselwörter ist in der Voreinstellung gesetzt. Ist nur ein Schlüsselwort gewünscht, muß die Option deaktiviert werden.
		";
		
$GLOBALS['phpAds_hlp_acl'] = "
	Sollen für die Bannerauslieferung keine Beschränkungen festgelegt werden, könnte durch die Deaktivierung dieser Option die Geschwindigkeit von ".$phpAds_productname." etwas beschleunigt werden.
		";
		
$GLOBALS['phpAds_hlp_default_banner_url'] = 
$GLOBALS['phpAds_hlp_default_banner_target'] = "
	Wenn ".$phpAds_productname." keine Verbindung zur Datenbank herstellen kann, bzw. wenn kein gültiger Banner gefunden wurde, wird der hier definierte Banner ersatzweise ausgeliefert. Für diesen Ersatzbanner werden weder AdViews noch AdClicks aufgezeichnet. In der Voreinstellung ist diese Funktion deaktiviert.
		";
		
$GLOBALS['phpAds_hlp_delivery_caching'] = "
		Die Verwendung eines Caches als Zwischenspeicher beschleunigt die Bannerauslieferung. In dem Cache sind alle Informationen, die für die Bannerauslieferung notwendig sind, hinterlegt. Als Voreinstellung ist der Cache Teil der Datenbank. Alternativ hierzu kann er in einer Datei oder in einem shared memory abgelegt werden. Die schnellste Bannerauslieferung bietet shared memory; doch bereits der Einsatz einer Datei beschleunigt die Bannerauslieferung erheblich. Wird die Option des Caches für die Bannerauslieferung deaktiviert, verlangsamt sich die Leistung von".$phpAds_productname." sehr und wird daher nicht empfohlen.
		";
		
$GLOBALS['phpAds_hlp_type_sql_allow'] = 
$GLOBALS['phpAds_hlp_type_web_allow'] = 
$GLOBALS['phpAds_hlp_type_url_allow'] = 
$GLOBALS['phpAds_hlp_type_html_allow'] = 
$GLOBALS['phpAds_hlp_type_txt_allow'] = "
	".$phpAds_productname." unterstützt unterschiedliche Bannerformate, die auf unterschiedlicher Weise gespeichert werden. Die ersten zwei werden für das lokale Speichern verwendet. Banner können über das Administrationsmodul in die Datenbank geladen oder auf dem WEB-Server gespeichert werden. Banner können auch auf externen Servern über die URL verwaltet werden. Sie können HTML-Banner sein und einfache Texte für Textanzeigen.
		";
		
$GLOBALS['phpAds_hlp_type_web_mode'] = "
Wenn Banner auf dem WEB-Server gespeichert werden sollen, müssen die Einstellungen hierfür konfiguriert werden. Sollen die Banner auf einem lokalen Verzeichnis gespeichert werden, muß  <i>Lokales Verzeichnis</i> gewählt werden. Für die Speicherung auf einem FTP-Server ist <i> Externer FTP-Server</i> einzustellen. Es ist durchaus möglich, daß der eigene WEB-Server nicht lokal, sondern als FTP-Server eingerichtet wird.
		";
		
$GLOBALS['phpAds_hlp_type_web_dir'] = "
	In das hier festgelegte Verzeichnis speichert ".$phpAds_productname." die hochgeladenen Banner. Das Verzeichnis darf für PHP nicht schreibgeschützt sein. Es muß, ggf. mit Hilfe eines FTP-Programmes, die Zugriffs- und Schreibberechtigung gesetzt werden. Das Verzeichnis muß im Root-Verzeichnis von ".$phpAds_productname." sein. Bei der Eingabe des Verzeichnisses darf als Ende kein  Slash (/) eingegeben werden. Diese Angaben werden nur bei  <i>Lokales Verzeichnis</i> als Wahl für die Speicherung benötigt.
		";
		
$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "
		Für das Speicherungsverfahren  <i> Externer FTP-Server</i> wird die IP-Adresse oder der Domain-Name des FTP-Servers benötigt.
		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "
		Für das Speicherungsverfahren  <i> Externer FTP-Server</i> muß das Verzeichnis, in das die Banner gespeichert werden, genau bezeichnet werden (auf Groß-/Kleinschreibung ist ggf. zu achten).
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "
		Für das Speicherungsverfahren  <i> Externer FTP-Server</i> muß der Benutzername für den Zugang zum FTP-Server eingegeben werden.
		";
      
$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "
		Für das Speicherungsverfahren  <i> Externer FTP-Server</i> wird zum Benutzername ein gültiges Kennwort benötigt.
		";
      
$GLOBALS['phpAds_hlp_type_web_url'] = "
	Werden die Banner auf einem WEB-Server gespeichert, müssen sowohl die (öffentliche) URL als auch das mit ihr korrespondierende lokale Verzeichnis eingegeben werden. Z. B.<br>
(öffentliche) URL       = <i>http://www.Werbeplatzvermarktung.de/ads</i><br>
Lokales Verzeichnis   = <i>/var/www/htdocs/ads</i><br>
Bei der Eingabe des Verzeichnisses darf als Ende kein  Slash (/) eingegeben werden.
		";
		
$GLOBALS['phpAds_hlp_type_html_auto'] = "
	Durch diese Option modifiziert ".$phpAds_productname." den HTML-Code so, daß AdClicks aufgezeichnet werden können. Auch wenn diese Option an dieser Stelle aktiviert wird, ist es dennoch möglich, sie für jeden Banner individuell zu deaktivieren.
		";
		
$GLOBALS['phpAds_hlp_type_html_php'] = "
	Es kann zugelassen werden, daß ausführbare PHP-Codes in HTML-Banner eingebettet sind. Diese Funktion ist in der Voreinstellung deaktiviert.
		";
		
$GLOBALS['phpAds_hlp_admin'] = "
	Bitte geben Sie den Benutzername des Administrators ein. Mit diesem Benutzername ist der Zugang zum Administrationsmodul möglich
		";
		
$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "
	Bitte geben Sie ein Kennwort für den Administrator ein. Die Kennworteingabe muß durch erneute Eingabe bestätigt werden.
		";
		
$GLOBALS['phpAds_hlp_pwold'] = 
$GLOBALS['phpAds_hlp_pw'] = 
$GLOBALS['phpAds_hlp_pw2'] = "
	Um das Kennwort des Administrators zu ändern, muß zunächst das alte Kennwort eingegeben werden. Das neue Kennwort ist zweimal einzugeben.
		";
		
$GLOBALS['phpAds_hlp_admin_fullname'] = "
	Eingabe des vollen Namen (Name, Vorname) des Administrators. Die Angaben werden für eMails benötigt.
		";
		
$GLOBALS['phpAds_hlp_admin_email'] = "
	Eingabe der eMail-Adresse des Administrators. Die Angaben werden für eMails benötigt.
		";
		
$GLOBALS['phpAds_hlp_admin_email_headers'] = "
	Die Kopfzeile für die eMails, die ".$phpAds_productname." versenden soll, kann hier geändert werden.
		";
		
$GLOBALS['phpAds_hlp_admin_novice'] = "
	Wenn eine Warnung erfolgen soll, bevor Zonen, Kampagnen, Banner, Verleger, Inserenten endgültig gelöscht werden, muß diese Option gesetzt sein.
		";
		
$GLOBALS['phpAds_hlp_client_welcome'] = "
		Wenn diese Option gesetzt wird, erscheint eine Begrüßungszeile auf der ersten Inserentenseite. Dieser Begrüßungstext, der in der Datei welcome.html gespeichert ist, kann personalisiert oder ergänzt werden. Möglich wären Firmenlogo, Kontaktinformationen, Links zu Angeboten ....
		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "
		Der Begrüßungstext für Inserenten kann hier eingegeben werden. HTML-Tags sind zugelassen. 
		Ist hier ein Text eingegeben, wird die Datei welcome.html ignoriert.
		";
		
$GLOBALS['phpAds_hlp_updates_frequency'] = "
		".$phpAds_productname." wird ständig optimiert. Es kann in selbst definierten Intervallen direkt beim Update-Server nach neuen Versionen geprüft werden. Ist eine neue Version vorhanden, werden in einem Dialogfenster zunächst weitere Informationen über das Update gegeben.
		";
		
$GLOBALS['phpAds_hlp_userlog_email'] = "
		Soll von allen durch ".$phpAds_productname."  versandte eMails eine Kopie angefertigt werden, kann das durch diese Option ermöglicht werden. Die eMails werden in das Benutzerprotokoll eingetragen.
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
		Wenn diese Option aktiviert ist, werden weitere Informationen über jede Kampagne auf der Seite <i>Übersicht Kampagnen</i> dargestellt. Diese Informationen sind: Restguthaben an AdViews und AdClicks., Aktivierungsdatum, Auslaufdatum und Priorität.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "
		Wenn diese Option aktiviert ist, werden weitere Informationen über jeden Banner auf der Seite <i>Übersicht Banner</i> dargestellt. Diese Informationen sind: Ziel-URL, Schlüsselwörter, Größe und Bannergewichtung.
		";
		
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "
		Wenn diese Option aktiviert ist, erfolgt eine Vorschau aller Banner auf der Seite <i>Übersicht Banner</i>. Ist diese Option deaktiviert, ist für jeden Banner einzeln dennoch eine Vorschau möglich. Hierzu muß auf das Dreieck neben dem Banner geklickt werden.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "
		Wenn diese Option aktiviert ist, wird der aktuelle HTML-Banner anstelle des HTML-Codes angezeigt. Diese Funktion ist in der Voreinstellung deaktiviert; denn auf diesem Wege angezeigte HTML-Banner können Konflikte produzieren. Jeder HTML-Banner kann in der <i>Übersicht Banner</i> durch anklicken von <i>Banner anzeigen</i> dargestellt werden.
		";
		
$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "
		Wenn diese Option aktiviert ist, erfolgt eine Vorschau auf den Seiten <i>Bannermerkmale</i>, <i> Auslieferungsoptionen</i> und <i> Verknüpfte Zonen</i>.<br>
Ist diese Option deaktiviert, ist die Bannerdarstellung möglich, wenn auf <i>Banner anzeigen</i> geklickt wird.
		";
		
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "
		Wenn diese Option gesetzt ist, werden alle inaktiven Banner, Kampagnen und Inserenten auf den Seiten <i> Inserenten & Kampagnen</i> und <i>Übersicht Kampagnen</i> verborgen. Diese verborgenen Informationen können durch anklicken von </i> Alle anzeigen</i> dargestellt werden.
		";
		
$GLOBALS['phpAds_hlp_gui_show_matching'] = "
	Wenn diese Option aktiviert ist, werden alle gefundene Banner auf der Seite <i> Verknüpfte Banner</i> dargestellt, wenn als Methode <i> Kampagne (Auswahl)</i> gewählt wurde. Hierdurch wird genau dargestellt, welche Banner zur Auslieferung vorgesehen sind. Auch eine Vorschau der zugehörenden Banner ist möglich.
		";
		
$GLOBALS['phpAds_hlp_gui_show_parents'] = "
		Wenn diese Option aktiviert ist, werden die zugehörenden Kampagnen der Banner auf der Seite <i>Verknüpfte Banner</i> angezeigt, wenn als Methode <i> Banner (Auswahl)</i> gewählt wurde. Hierdurch wird es - vor der Verknüpfung - möglich, anzuzeigen, welcher Banner den jeweiligen Kampagnen zugeordnet ist. Die Banner sind in der Sortierung den Kampagnen eingeordnet und werden nicht alphabetisch angezeigt.
		";
		
$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "
	Als Voreinstellung werden auf der Seite <i>Verknüpfte Banner</i> alle verfügbaren Banner oder Kampagnen angezeigt. Da diese Anzeige sehr lang werden kann, gestattet diese Option die Darstellung einer maximalen Anzahl von Positionen. Sind mehr Positionen als festgelegt vorhanden, aber verschiedene Wege der Darstellung, wird die Darstellungsart gewählt, die weniger Platz benötigt.
		";
?>
