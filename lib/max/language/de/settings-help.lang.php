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

$GLOBALS['phpAds_hlp_block_adclicks'] = "Wenn ein Besucher mehrmals auf ein Banner klickt, wird jedes Mal ein Klick von {$PRODUCT_NAME}
protokolliert. Diese Funktion wird verwende, um sicherzustellen, dass nur ein Klick für jeden
eindeutigen Banner für die Anzahl der von Ihnen angegebenen Sekunden protokolliert wird. Beispiel: Wenn Sie diesen Wert
auf 300 Sekunden (5 Minuten) setzen,  wird {$PRODUCT_NAME} nur einen Klick protokolieren, wenn der Besucher in den letzten 5 Minuten nicht bereits auf das gleiche Banner geklickt hat. Diese Funktion funktioniert nur, wenn der Browser des Nutzers Cookies akzeptiert.";

$GLOBALS['phpAds_hlp_log_adconversions'] = "Normalerweise werden alle Konversionen protokolliert. Wenn Sie keine Statistiken
über Konversionen sammeln möchten, können Sie dies deaktivieren.";

$GLOBALS['phpAds_hlp_block_adconversions'] = "Wenn ein Besucher eine Seite mit einem \"Conversion Beacon\" neu lädt, wird {$PRODUCT_NAME} die Konversion
jedes Mal protokollieren. Diese Funktion wird verwendet um sicherzustellen, dass nur eine eindeutige Konversion für die Anzahl der von Ihnen angegebenen Sekunden protokolliert wird. Beispiel: Wenn Sie diesen Wert
auf 300 Sekunden (5 Minuten) setzen, wird {$PRODUCT_NAME} Konversionen nur dann protokollieren, wenn der Besucher nicht die gleiche Seite mit dem \"Conversion Beacon\" in den letzten 5 Minuten bereits geladen hat. Diese Funktion funktioniert nur, wenn der Browser des Nutzers Cookies akzeptiert.";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "Wenn Sie eine Geotargeting-Datenbank verwenden, können Sie die geografischen Informationen
auch in der Datenbank speichern. Wenn Sie diese Option aktiviert haben, können Sie Statistiken über den
Standort Ihrer Besucher und die Leistung jedes Banners in den verschiedenen Ländern sehen.
Diese Option steht Ihnen nur zur Verfügung, wenn Sie ausführliche Statistiken verwenden.";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "Der Hostname wird normalerweise vom Webserver bestimmt, aber in manchen Fällen ist dies
deaktiviert. Wenn Sie den Hostnamen des Besuchers in den Auslieferungsregeln verwenden möchten und/oder
Statistiken darüber erhalten möchten und der Server diese Information nicht liefert, müssen Sie diese Option
aktivieren. Das Abfragen des Hostnamens des Besuchers dauert einige Zeit und verlangsamt die Auslieferung von Bannern.";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "Einige Seitenbesucher verwenden einen Proxy Server für den Zugriff auf das Internet. In diesem Fall wird {$PRODUCT_NAME} 
die IP-Adresse oder den Hostnamen des Proxy Servers protokollieren. Wenn Sie diese Funktion aktivieren,
wird {$PRODUCT_NAME} versuchen, die IP-Adresse oder den Hostnamen des Besuchers hinter dem Proxy Server zu 
ermitteln. Wenn es nicht möglich sein sollte, die genaue Adresse des Besuchers zu ermitteln, wird {$PRODUCT_NAME} 
stattdessen die Adresse des Proxy Servers verwenden. Diese Funktion ist standardmäßig nicht aktiv, da sie die 
Bannerauslieferung deutlich verlangsamt.";

$GLOBALS['phpAds_hlp_obfuscate'] = "Wenn Sie möchten, daß {$PRODUCT_NAME} den Namen der Gruppe, zu der dieses Werbemittel gehört verschleiert, klicken Sie diese Option an.";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "Wenn Sie diese Funktion aktivieren, werden die gesammelten Statistiken automatisch nach dem
Zeitraum gelöscht, den Sie unter diesem Kontrollkästchen angeben. Wenn Sie dies beispielsweise auf 5 Wochen setzen, werden
Statistiken, die älter als 5 Wochen sind, automatisch gelöscht.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "Diese Funktion wird automatisch Einträge aus dem Benutzer-Protokoll löschen, die älter sind als die
Wochenzahl, die unter diesem Kontrollkästchen angegeben ist.";

$GLOBALS['phpAds_hlp_geotracking_type'] = "Geotargeting erlaubt es {$PRODUCT_NAME}, die IP-Adresse des Besuchers in geografische
Informationen umzuwandeln. Basierend auf diesen Informationen können Sie Auslieferungsregeln festlegen oder Sie können
diese Informationen speichern, um zu sehen, welches Land die meisten Views oder Klicks generiert.
Wenn Sie Geotargeting aktivieren möchten, müssen Sie auswählen, welche Art von Datenbank Sie haben.
{$PRODUCT_NAME} unterstützt derzeit die <a href='http://hop.clickbank.net/?phpadsnew/ip2country' target='_blank'>IP2Country</a> und die <a href='http://www.maxmind.com/?rId=phpadsnew' target='_blank'>GeoIP</a> Datenbank.";

$GLOBALS['phpAds_hlp_geotracking_location'] = "Wenn Sie nicht das GeoIP Apache-Modul sind, sollten Sie {$PRODUCT_NAME} den Standort der
Geotargeting Datenbank angeben. Es wird immer empfohlen, die Datenbank außerhalb des Wurzelverzeichnis (document root) des Webservers zu platzieren, da sonst die Datenbank heruntergeladen werden kann.";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "Die Umwandlung der IP-Adresse in geografische Informationen braucht Zeit. Um zu verhindern, dass
{$PRODUCT_NAME} dies jedes Mal tun muss, wenn ein Banner geliefert wird, kann das Ergebnis
in einem Cookie gespeichert werden. Wenn dieses Cookie vorhanden ist, verwendet {$PRODUCT_NAME} diese Informationen anstatt  der Umwandlung der IP-Adresse.";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "Sollen Views und Klicks von bestimmten Computern nicht aufgezeichnet werden, können diese hier aufgelistet werden. Wurde eingestellt, dass der Hostname per \"Reverse Lookup\" ermittelt wird, können Domain-Namen oder IP-Adressen eingegeben werden. Ohne Ermittlung von Hostnamen ist nur die Eingabe von IP-Adressen möglich. Die Verwendung von Platzhaltern/Wildcards ist möglich (z.B. '*.altavista.com' or '192.168.*')
		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Für die meisten Menschen beginnt die Woche an einem Montag,
Aber wenn Sie die Woche an einem Sonntag starten lassen möchten, können Sie das tun.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "Gibt an, wie viele Dezimalstellen auf Statistikseiten angezeigt werden sollen.";

$GLOBALS['phpAds_hlp_warn_admin'] = "{$PRODUCT_NAME} kann Ihnen eine E-Mail senden, wenn für eine Kampagne nur eine begrenzte Anzahl von
Views, Klicks oder Konversionen übrig ist. Dies ist standardmäßig aktiviert.";

$GLOBALS['phpAds_hlp_warn_client'] = "{$PRODUCT_NAME} kann eine E-Mail an den Werbetreibenden verschicken, wenn eine seiner Kampagnen nur noch eine
begrenzte Anzahl von Views, Klicks oder Konversionen übrig hat. Dies ist standardmäßig aktiviert.";

$GLOBALS['phpAds_hlp_qmail_patch'] = "Einige Versionen von qmail sind von einem Fehler betroffen der dazu führt, dass die von
{$PRODUCT_NAME} gesendeten E-Mails die Kopfzeilen im Text der E-Mail anzeigen. Wenn Sie
diese Einstellung aktivieren, wird {$PRODUCT_NAME} E-Mails in einem qmail-kompatiblen Format senden.";

$GLOBALS['phpAds_hlp_warn_limit'] = "Das Limit, ab dem {$PRODUCT_NAME} mit dem Versenden von Warn-E-Mails beginnt. Dies ist standardmäßig 100.
";

$GLOBALS['phpAds_hlp_acl'] = "Wenn Sie keine Auslieferungsregeln verwenden, können Sie diese Funktion mit diesem Parameter deaktivieren.
Dies wird {$PRODUCT_NAME} etwas beschleunigen.";

$GLOBALS['phpAds_hlp_default_banner_url'] = $GLOBALS['phpAds_hlp_default_banner_target'] = "Wenn {$PRODUCT_NAME} keine Verbindung zum Datenbank Server aufbauen kann oder keine passenden Banner
finden kann, z.B. wenn die Datenbank abgestürzt ist oder gelöscht wurde, wird es nichts anzeigen. Einige Nutzer
wollen für solche Situationen ein Standard-Banner festlegen, welches dann angezeigt wird. Das Standard-Banner das
hier angegeben wird, wird nicht protokolliert und wird nicht genutzt wenn es noch aktive Banner in der Datenbank gibt.
Diese Option ist standardmäßig nicht aktiv.";

$GLOBALS['phpAds_hlp_delivery_caching'] = "Um die Auslieferung zu beschleunigen, verwendet {$PRODUCT_NAME} einen Cache-Speicher der alle benötigten Informationen
enthält, um die Banner an die Besucher Ihrer Website auszulieferen. Standardmäßig wird dieser Cache-Speicher in der Datenbank
gespeichert, aber um die Auslieferung noch weiter zu beschleunigen, ist es möglich ihn in einer Datei oder im Arbeitsspeicher abzulegen. Das Speichern im Arbeitsspeicher ist am schnellsten, Abspeichern in einer Datei ist ebenfalls schnell. Es wird nicht empfohlen, den Cache-Speicher abzuschalten, da das zu deutlich verminderter Leistung führt.";

$GLOBALS['phpAds_hlp_type_web_mode'] = "Wenn Banner auf dem Web-Server gespeichert werden sollen, müssen die Einstellungen dafür konfiguriert werden. 
Sollen die Banner in einem lokalen Verzeichnis gespeichert werden, muss <i>Lokales Verzeichnis</i> gewählt werden. 
Für die Speicherung auf einem FTP-Server ist <i>Externer FTP-Server</i> einzustellen.
Auf bestimmten Web-Servern kann es sinnvoll sein, hiefür den lokalen FTP-Server zu verwenden.
		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "Geben Sie das Verzeichnis an, in das {$PRODUCT_NAME} die hochgeladenen Banner
kopieren muss. Dieses Verzeichnis muss für PHP beschreibbar sein. Dies kann bedeuten, 
dass Sie die UNIX-Berechtigungen für dieses Verzeichnis anpassen müssen (chmod). 
Das Verzeichnis, das Sie hier angeben, muss innerhalb des Wurzelverzeichnisses des Web-Servers liegen (doc root).
Der Web-Server muss in der Lage sein, die Dateien direkt auszuliefern. Geben Sie keinen Schrägstrich am Ende
(/) an. Sie müssen diese Option nur konfigurieren, wenn Sie die Speichermethode für Banner auf <i>Lokales Verzeichnis</i> gesetzt haben.";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "Wenn Sie die Speichermethode auf <i>Externen FTP-Server</i> gesetzt haben, müssen Sie
die IP-Adresse oder den Domain-Namen des FTP-Servers angeben, auf den {$PRODUCT_NAME}
die hochgeladenen Banner kopieren soll.";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "Wenn Sie die Speichermethode auf <i>Externen FTP-Server</i> gesetzt haben, müssen Sie
das Verzeichnis auf dem FTP-Server angeben, in das {$PRODUCT_NAME} die hochgeladenen Banner kopieren soll.";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "Wenn Sie die Speichermethode auf <i>Externen FTP-Server</i> gesetzt haben, müssen Sie
den Benutzernamen angeben, den {$PRODUCT_NAME} verwenden soll, um sich mit dem
externen FTP-Server zu verbinden.";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "Wenn Sie die Speichermethode auf <i>Externen FTP-Server</i> gesetzt haben, müssen Sie
das Passwort angeben, das {$PRODUCT_NAME} verwenden soll, um sich mit dem
externen FTP-Server zu verbinden.";

$GLOBALS['phpAds_hlp_type_web_ftp_passive'] = "Einige FTP-Server und Firewalls benötigen für Übertragungen den Passiven Modus (PASV).
Wenn {$PRODUCT_NAME} den Passiven Modus verwenden soll, um sich mit dem 
FTP-Server zu verbinden, aktivieren Sie diese Option.";

$GLOBALS['phpAds_hlp_type_web_url'] = "Wenn Sie Banner auf einem Webserver speichern, muss {$PRODUCT_NAME} wissen, welche öffentliche
URL dem unten angegebenen Verzeichnis entspricht. Geben Sie dabei keinen abschließenden Schrägstrich (/) an.";

$GLOBALS['phpAds_hlp_type_web_ssl_url'] = "Wenn Sie Banner auf einem Webserver speichern, muss {$PRODUCT_NAME} wissen, welche öffentliche
URL (SSL) dem unten angegebenen Verzeichnis entspricht. Geben Sie dabei keinen abschließenden Schrägstrich (/) an.";

$GLOBALS['phpAds_hlp_type_html_auto'] = "Wenn diese Option aktiv ist, wird {$PRODUCT_NAME} automatisch HTML-Banner so verändern, dass Klicks protokolliert werden können. Auch wenn diese Option aktiv ist, ist es weiterhin möglich, dieses Verhalten für bestimmte Banner manuell zu deaktivieren.";

$GLOBALS['phpAds_hlp_type_html_php'] = "Es ist möglich, dass {$PRODUCT_NAME} PHP-Code in HTML-Banner einbindet und ausführt. 
Diese Funktion ist standardmäßig deaktiviert.";

$GLOBALS['phpAds_hlp_admin'] = "Bitte geben Sie den Benutzernamen des Administrators ein. 
Mit diesem Benutzernamen können Sie sich in der Administrator-Oberfläche anmelden.";

$GLOBALS['phpAds_hlp_admin_pw'] = $GLOBALS['phpAds_hlp_admin_pw2'] = "Bitte geben Sie das Passwort ein, mit dem Sie sich in der Administrator-Oberfläche anmelden möchten.
Sie müssen es zweimal eingeben, um Tippfehler zu vermeiden.";

$GLOBALS['phpAds_hlp_pwold'] = $GLOBALS['phpAds_hlp_pw'] = $GLOBALS['phpAds_hlp_pw2'] = "Um das Administrator-Passwort zu ändern, müssen Sie das alte Passwort oben angeben. 
Außerdem müssen Sie das neue Passwort zweimal eingeben, um Tippfehler zu vermeiden.";

$GLOBALS['phpAds_hlp_admin_fullname'] = "Geben Sie den vollen Namen des Administrators an. Dieser wird beim Senden von Statistiken per E-Mail verwendet.";

$GLOBALS['phpAds_hlp_admin_email'] = "Die E-Mail-Adresse des Administrators. Dies wird als Absender-Adresse verwendet, wenn Statistiken per E-Mail versendet werden.";

$GLOBALS['phpAds_hlp_admin_novice'] = "Wenn Sie vor dem Löschen von Werbetreibenden, Kampagnen, Bannern,
Webseiten und Zonen eine Warnung erhalten möchten, aktivieren Sie diese Option.";

$GLOBALS['phpAds_hlp_client_welcome'] = "Wenn Sie diese Option aktivieren, wird auf der ersten Seite die ein Werbetreibender nach der Anmeldung sieht, eine Willkommensnachricht angezeigt. Sie können diese Nachricht personalisieren, indem Sie die
Datei welcome.html im Verzeichnis admin/templates bearbeiten. Dinge, die Sie z.B. in diese Nachricht aufnehmen könnten, sind: Ihr Firmenname, Kontaktinformationen, Ihr Firmenlogo, ein Link zu einer Seite mit Werbepreisen usw..";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "Anstatt die Datei welcome.html zu bearbeiten, können Sie hier auch einen kleinen Text angeben. Wenn Sie
den Text hier eingeben, wird die welcome.html Datei ignoriert. Es ist möglich im Text HTML-Tags zu verwenden.";

$GLOBALS['phpAds_hlp_updates_frequency'] = "Wenn Sie nach neuen Versionen von {$PRODUCT_NAME} suchen möchten, können Sie diese Funktion aktivieren.
Es ist möglich, das Intervall anzugeben, in dem {$PRODUCT_NAME} eine Verbindung zum Update-Server herstellt. 
Wenn eine neue Version gefunden wurde, erscheint ein Dialogfenster mit zusätzlichen Informationen über dieses Update.";

$GLOBALS['phpAds_hlp_userlog_email'] = "Wenn Sie eine Kopie aller ausgehenden E-Mails behalten möchten, die von {$PRODUCT_NAME} versendet werden, können Sie diese Funktion aktivieren. Die E-Mail-Nachrichten werden im Benutzer-Protokoll gespeichert.";

$GLOBALS['phpAds_hlp_userlog_inventory'] = "Um sicherzustellen, dass die Inventar-Berechnung korrekt ausgeführt wurde, können Sie einen Bericht über
die stündlichen Inventar-Berechnungen speichern. Dieser Bericht enthält das prognostizierte Profil und wie viel
Priorität allen Bannern zugewiesen ist. Diese Informationen können nützlich sein, wenn Sie
eine Fehlermeldung über die Prioritätsberechnungen einreichen möchten. Die Berichte sind
im Benutzer-Protokoll gespeichert.";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "Um sicherzustellen, dass die Datenbank vollständig geleert wurde, können Sie einen Bericht darüber
speichern, was genau während des Löschens passiert ist. Diese Informationen werden
im Benutzer-Protokoll gespeichert.";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "Wenn Sie eine höhere Standard-Gewichtung des Banners verwenden möchten, können Sie hier das gewünschte Gewicht festlegen.
Der Standardwert für diese Einstellung ist 1.";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "Wenn Sie eine höhere Standard-Gewichtung für Kampagnen verwenden möchten, können Sie hier das gewünschte Gewicht festlegen.
Der Standardwert für diese Einstellung ist 1.";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Wenn diese Option aktiviert ist, werden zusätzliche Informationen über jede Kampagne auf der
<i>Kampagnen</i> Seite angezeigt. Die zusätzlichen Informationen beinhalten die Anzahl der verbleibenden Views, die Anzahl der verbleibenden Klicks, die Anzahl der verbleibende Konversionen, das Aktivierungsdatum, das Ablaufdatum
und die Einstellungen zur Priorität.";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Wenn diese Option aktiviert ist, werden zusätzliche Informationen über jedes Banner auf der
<i>Banner</i> Seite angezeigt. Die zusätzlichen Informationen beinhalten die Ziel-URL, Schlüsselwörter,
Größe und die Gewichtung des Banners.";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Wenn diese Option aktiviert ist, wird eine Vorschau jedes Banners auf der <i>Banner</i>-Seite angezeigt. Selbst wenn diese Option nicht ausgewählt ist, haben Sie auf der <i>Banner</i>-Seite die Möglichkeit durch einen Klick auf das Dreieck neben dem Banner, sich eine Vorschau anzeigen zu lassen.";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "Wenn diese Option aktiviert ist, wird das eigentliche HTML-Banner anstelle des HTML-Codes angezeigt. Diese Option ist standardmäßig deaktiviert, da HTML-Banner mit der Benutzeroberfläche kollidieren können.
Wenn diese Option deaktiviert ist, ist es immer noch möglich, das eigentliche HTML-Banner anzuzeigen durch einen Klick auf
den <i>Banner anzeigen</i> Button neben dem HTML-Code.";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "Wenn diese Option aktiviert ist, wird eine Vorschau oben auf den Seiten <i>Banner-Eigenschaften</i>,
<i>Auslieferungsoptionen</i> und <i>Verknüpfte Zonen</i> angezeigt. Wenn diese Option deaktiviert ist, ist es dennoch
möglich den Banner anzuzeigen durch einen Klick auf den <i>Banner anzeigen</i> Button oben auf den Seiten.";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Wenn diese Option aktiviert ist, werden alle inaktiven Banner, Kampagnen und Werbetreibenden auf den
Seiten <i>Werbetreibende & Kampagnen</i> und <i>Kampagnen</i> ausgeblendet. Wenn diese Option aktiviert ist, ist es
dennoch möglich die versteckten Elemente zu sehen, indem Sie auf den <i>Alle anzeigen</i> -Knopf unten auf der Seite klicken.";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "Wenn diese Option aktiviert ist, wird der passende Banner auf der Seite <i>verknüpfte Banner</i> angezeigt, wenn
die <i>Kampagnenauswahl</i> Methode gewählt wurde. Auf diese Weise sehen Sie genau, welche Banner
für den Versand in Betracht gezogen werden, wenn die Kampagne verknüpft ist. Es wird auch möglich sein, eine Vorschau
der passenden Banner anzuzeigen.";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "Wenn diese Option aktiviert ist, werden die übergeordneten Kampagnen der Banner auf der Seite <i>verknüpfte Banner</i> angezeigt, wenn die <i>Banner-Auswahl</i> Methode gewählt wurde. So können Sie sehen, welcher Banner
zu welcher Kampagne gehört, bevor das Banner verknüpft wird. Das bedeutet auch, dass die Banner
nach den übergeordneten Kampagnen gruppiert werden und nicht mehr alphabetisch sortiert werden.";
