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
$GLOBALS['phpAds_hlp_dbhost'] = "Geben Sie den Hostnamen des Datenbankservers {$phpAds_dbmsname} an mit dem Sie versuchen eine Verbindung herstellen.";

$GLOBALS['phpAds_hlp_dbport'] = "Geben Sie die Portnummer an des {$phpAds_dbmsname}-Datenbank-Servers an, zu dem Sie verbinden möchten.";

$GLOBALS['phpAds_hlp_dbuser'] = "Geben Sie den Benutzernamen an, den {$PRODUCT_NAME} verwenden muss, um auf den {$phpAds_dbmsname}-Datenbank-Server zuzugreifen.";

$GLOBALS['phpAds_hlp_dbpassword'] = "Geben Sie das Passwort an, den {$PRODUCT_NAME} verwenden muss, um auf den {$phpAds_dbmsname}-Datenbank-Server zuzugreifen.";

$GLOBALS['phpAds_hlp_dbname'] = "Geben Sie den Namen der Datenbank an in die {$PRODUCT_NAME} die Daten speichern soll.
Wichtig! Die Datenbank muss bereits auf dem Datenbankserver vorhanden sein. {$PRODUCT_NAME} wird <b>keine</b> Datenbank erstellen, falls diese noch nicht existiert.
		.";

$GLOBALS['phpAds_hlp_persistent_connections'] = "Eine persistente Verbindung zur Datenbank kann die Geschwindigkeit von {$PRODUCT_NAME} erhöhen, insbesondere wird die Ladezeiten des Servers verringert. Andererseits können bei Seiten mit sehr vielen Besuchern - genau gegenteilig zu oben - durch die persistente Verbindung die Ladezeiten erheblich ansteigen. Welche Art der Verbindung gewählt wird, <i>normale</i> oder <i>persistente</i>, ist abhängig von der Besucherzahl und der eingesetzten Hardware. Wenn {$PRODUCT_NAME} zu viele Ressourcen belegt, könnte dies durch die Einstellung <i>persistente Verbindung </i> hervorgerufen worden sein.
		.";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "Wird die Datenbank nicht nur von {$PRODUCT_NAME}, sondern auch von weiteren Anwendungen genutzt, können unter Umständen Kompatibilitätsprobleme auftreten. Durch aktivieren des Kompatibilitätsmodus (Datenbank) werden diese Probleme behoben. Wenn die Bannerauslieferung im lokalen Modus erfolgt und der Kompatibilitätsmodus (Datenbank) aktiv ist, lässt {$PRODUCT_NAME} die Einstellungen der Datenbank so, wie diese vorher vorgefunden wurden.
Diese Option verlangsamt den Adserver etwas (nur sehr wenig) und ist daher in der Voreinstellung inaktiv.
		";

$GLOBALS['phpAds_hlp_table_prefix'] = "Wird die Datenbank nicht nur von {$PRODUCT_NAME}, sondern auch von weiteren Anwendungen genutzt, ist es sinnvoll, den von {$PRODUCT_NAME} genutzten Tabellen einen individuellen Präfix voranzustellen. Damit kann sichergestellt werden, dass dieselben Tabellennamen nicht von verschiedenen Programmen verwendet werden. Sollten Sie {$PRODUCT_NAME} mehrfach installiert, und alle Installationen greifen auf dieselbe Datenbank zu, dann muss dann für jede Installation ein eigener eindeutiger Präfix verwendet werden.";

$GLOBALS['phpAds_hlp_table_type'] = "MySQL unterstützt verschiedene Tabellentypen. Jeder Tabellentyp hat bestimmte Eigenschaften und einige
können {$PRODUCT_NAME} erheblich beschleunigen. MyISAM ist der Standard-Tabellentyp und ist in allen MySQL-Installationen
verfügbar. Andere Tabellentypen sind möglicherweise nicht auf Ihrem Server verfügbar.";

$GLOBALS['phpAds_hlp_url_prefix'] = " {$PRODUCT_NAME} muss wissen, in welchen Verzeichnissen sich seine Dateien befinden, 
um korrekt zu funktionieren. Sie müssen deshalb die URL zum Verzeichnis in dem {$PRODUCT_NAME}
installiert ist angeben, beispielsweise <i>http://www.your-url.com/ads</i>.
		";

$GLOBALS['phpAds_hlp_ssl_url_prefix'] = "{$PRODUCT_NAME} muss wissen, in welchen Verzeichnissen sich seine Dateien befinden um korrekt zu funktionieren. 
Manchmal unterscheidet sich das SSL-Präfix vom normalen URL-Präfix. Sie müssen deshalb die URL zum Verzeichnis in dem {$PRODUCT_NAME} installiert ist angeben, beispielsweise <i>https://www.your-url.com/ads</i>.
		";

$GLOBALS['phpAds_hlp_my_header'] = $GLOBALS['phpAds_hlp_my_footer'] = "
Geben Sie hier den Pfad zu den Header-Dateien ein (z.B.: /home/login/www/header.htm)
damit ein Header und/oder Footer auf jeder Seite des Admin-Bereichs erscheint.
Sie können entweder Text oder HTML in diesen Dateien verwenden (wenn Sie HTML in
diesen Datein verwenden, benutzen Sie bitte keine Tags wie <body> oder <html>).		";

$GLOBALS['phpAds_hlp_my_logo'] = "Hier sollten Sie den Namen der angepassten Logo-Datei angeben, welches anstelle 
des Standard-Logos angezeigt werden soll. Die Logo-Datei muss im Verzeichnis 
admin/images abgespeichert werden, bevor sie hier verwendet werden kann.";

$GLOBALS['phpAds_hlp_gui_header_foreground_color'] = " Geben Sie hier Ihre Wunschfarbe ein, die für Navigationsreiter, das Suchfeld und bestimmte gefettete Texte verwendet werden soll.
               ";

$GLOBALS['phpAds_hlp_gui_header_background_color'] = "Geben Sie hier eine Farbe ein, die für den Hintergrund des Seitenkopfes verwendet werden soll.";

$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "Sie sollten hier eine benutzerdefinierte Farbe setzen, die für den aktuell ausgewählte Tab verwendet wird.";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "Sie sollten hier eine benutzerdefinierte Farbe setzen, die für den Text in der Kopfzeile verwendet werden.";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "Durch das Aktivieren der GZIP Inhaltskomprimierung wird die Datenmenge, die zum Browser beim Anzeigen einer Administrationsseite übertragen wird, erheblich verringert. Die PHP Erweiterung 'GZIP' muss installiert sein um diese Zusatzfunktion nutzen zu können.";

$GLOBALS['phpAds_hlp_language'] = "Wählen Sie die Standard-Sprache die {$PRODUCT_NAME} verwenden soll. Diese Sprache wird als Standardwert für die Administrationsoberfläche verwendet. Bitte beachten Sie: Sie können eine andere Sprache für jeden Zugang zur Administrationsoberfläche setzen, zusätzlich diese später individuell anpassbar.";

$GLOBALS['phpAds_hlp_name'] = "Geben Sie den Namen, die, den Sie für diese Anwendung verwenden möchten. Diese Zeichenfolge wird auf allen Seiten der Benutzeroberfläche angezeigt. Wenn Sie diese Einstellung leer lassen (Standard) wird stattdessen ein Logo von {$PRODUCT_NAME} erscheint.";

$GLOBALS['phpAds_hlp_company_name'] = "Dieser Name wird in E-Mails verwendet, die von {$PRODUCT_NAME} gesendet werden.";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "{$PRODUCT_NAME} prüft standardmäßig, ob die GD-Bibliothek installiert ist und 
welche Bildformate unterstützt werden. Einige Versionen von PHP gestatten diese automatische 
Prüfung nicht. Das Ergebnis kann fehlerhaft sein. In diesem Fall können die unterstützten
Bildformate manuell eingegeben werden. Mögliche Formate sind: none, pgn, jpeg, gif
		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "Wenn Sie die {$PRODUCT_NAME} P3P Datenschutzrichtlinien aktivieren möchten, müssen Sie diese Option
einschalten.";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "Die komprimierte Regel, die zusammen mit Cookies gesendet wird. Die Standardeinstellung
ist 'CUR ADM OUR NOR STA NID', die es dem  Internet Explorer 6 erlaubt, die von {$PRODUCT_NAME} 
verwendeten Cookies zu akzeptieren. Wenn Sie möchten, können Sie diese
Einstellungen an Ihre eigene Datenschutzerklärung anpassen.";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "Wenn Sie eine vollständige Datenschutzrichtlinie verwenden möchten, können Sie den Ort
der Richtlinie angeben.";

$GLOBALS['phpAds_hlp_compact_stats'] = "Ursprünglich verwendete {$PRODUCT_NAME} eine sehr ausführliche Protokollierung, die sehr 
detailliert war, aber auch hohe Anforderungen an den Datenbank-Server stellte. Dies führte zu 
Problemen auf Webseiten mit vielen Besuchern. Um solche Probleme zu vermeiden, unterstützt 
{$PRODUCT_NAME} auch eine neue Art von kompakten Statistiken, die die Datenbank weniger
belasten, aber auch weniger Details bieten. Diese kompaktven Statistiken sammeln Daten zu Views,
Klicks und Konversionen für jede Stunde. Wenn Sie mehr Details benötigen, können Sie die kompakten
Statistiken deaktivieren.";

$GLOBALS['phpAds_hlp_log_adviews'] = "Normalerweise werden alle Views protokolliert. Wenn Sie keine Statistiken
über Views sammeln möchten, können Sie dies deaktivieren.";

$GLOBALS['phpAds_hlp_block_adviews'] = "Wenn ein Besucher eine Seite neu lädt, wird jedes Mal ein View von {$PRODUCT_NAME} protokolliert.
Diese Funktion wird verwendet um sicherzustellen, dass nur ein View für jedes einzelne
Banner für die Anzahl der von Ihnen angegebenen Sekunden protokolliert wird. Beispiel: Wenn Sie diesen Wert
auf 300 Sekunden (5 Minuten) setzen, wird {$PRODUCT_NAME} nur einen View protokollieren, wenn der gleiche Banner dem gleichen Besucher in den letzten 300 Sekunden nicht bereits angezeigt wurde. Diese Funktion funktioniert nur, wenn der Browser des Besuchers Cookies akzeptiert.";

$GLOBALS['phpAds_hlp_log_adclicks'] = "Normalerweise werde alle Klicks auf Anzeigen protokolliert. Wenn Sie keine Statistiken
über Klicks auf Anzeigen sammeln möchten, können Sie dies deaktivieren.";







$GLOBALS['phpAds_hlp_obfuscate'] = "Wenn Sie möchten, daß {$PRODUCT_NAME} den Namen der Gruppe, zu der dieses Werbemittel gehört verschleiert, klicken Sie diese Option an.";
















































