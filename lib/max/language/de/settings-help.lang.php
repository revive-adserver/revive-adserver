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


$GLOBALS['phpAds_hlp_table_prefix'] = "Wird die Datenbank nicht nur von {$PRODUCT_NAME}, sondern auch von weiteren Anwendungen genutzt, ist es sinnvoll, den von {$PRODUCT_NAME} genutzten Tabellen einen individuellen Präfix voranzustellen. Damit kann sichergestellt werden, dass dieselben Tabellennamen nicht von verschiedenen Programmen verwendet werden. Sollten Sie {$PRODUCT_NAME} mehrfach installiert, und alle Installationen greifen auf dieselbe Datenbank zu, dann muss dann für jede Installation ein eigener eindeutiger Präfix verwendet werden.";








$GLOBALS['phpAds_hlp_gui_header_active_tab_color'] = "Sie sollten hier eine benutzerdefinierte Farbe setzen, die für den aktuell ausgewählte Tab verwendet wird.";

$GLOBALS['phpAds_hlp_gui_header_text_color'] = "Sie sollten hier eine benutzerdefinierte Farbe setzen, die für den Text in der Kopfzeile verwendet werden.";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "Durch das Aktivieren der GZIP Inhaltskomprimierung wird die Datenmenge, die zum Browser beim Anzeigen einer Administrationsseite übertragen wird, erheblich verringert. Die PHP Erweiterung 'GZIP' muss installiert sein um diese Zusatzfunktion nutzen zu können.";

$GLOBALS['phpAds_hlp_language'] = "Wählen Sie die Standard-Sprache die {$PRODUCT_NAME} verwenden soll. Diese Sprache wird als Standardwert für die Administrationsoberfläche verwendet. Bitte beachten Sie: Sie können eine andere Sprache für jeden Zugang zur Administrationsoberfläche setzen, zusätzlich diese später individuell anpassbar.";

$GLOBALS['phpAds_hlp_name'] = "Geben Sie den Namen, die, den Sie für diese Anwendung verwenden möchten. Diese Zeichenfolge wird auf allen Seiten der Benutzeroberfläche angezeigt. Wenn Sie diese Einstellung leer lassen (Standard) wird stattdessen ein Logo von {$PRODUCT_NAME} erscheint.";
















$GLOBALS['phpAds_hlp_obfuscate'] = "Wenn Sie möchten, daß {$PRODUCT_NAME} den Namen der Gruppe, zu der dieses Werbemittel gehört verschleiert, klicken Sie diese Option an.";
















































