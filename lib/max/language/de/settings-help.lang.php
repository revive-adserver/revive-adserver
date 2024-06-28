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







$GLOBALS['phpAds_hlp_p3p_policy_location'] = "Wenn Sie eine vollständige Datenschutzrichtlinie verwenden möchten, können Sie den Ort
der Richtlinie angeben.";


$GLOBALS['phpAds_hlp_log_adviews'] = "Normalerweise werden alle Views protokolliert. Wenn Sie keine Statistiken
über Views sammeln möchten, können Sie dies deaktivieren.";


$GLOBALS['phpAds_hlp_log_adclicks'] = "Normalerweise werde alle Klicks auf Anzeigen protokolliert. Wenn Sie keine Statistiken
über Klicks auf Anzeigen sammeln möchten, können Sie dies deaktivieren.";


$GLOBALS['phpAds_hlp_log_adconversions'] = "Normalerweise werden alle Konversionen protokolliert. Wenn Sie keine Statistiken
über Konversionen sammeln möchten, können Sie dies deaktivieren.";


$GLOBALS['phpAds_hlp_geotracking_stats'] = "Wenn Sie eine Geotargeting-Datenbank verwenden, können Sie die geografischen Informationen
auch in der Datenbank speichern. Wenn Sie diese Option aktiviert haben, können Sie Statistiken über den
Standort Ihrer Besucher und die Leistung jedes Banners in den verschiedenen Ländern sehen.
Diese Option steht Ihnen nur zur Verfügung, wenn Sie ausführliche Statistiken verwenden.";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "Der Hostname wird normalerweise vom Webserver bestimmt, aber in manchen Fällen ist dies
deaktiviert. Wenn Sie den Hostnamen des Besuchers in den Auslieferungsregeln verwenden möchten und/oder
Statistiken darüber erhalten möchten und der Server diese Information nicht liefert, müssen Sie diese Option
aktivieren. Das Abfragen des Hostnamens des Besuchers dauert einige Zeit und verlangsamt die Auslieferung von Bannern.";


$GLOBALS['phpAds_hlp_obfuscate'] = "Wenn Sie möchten, daß {$PRODUCT_NAME} den Namen der Gruppe, zu der dieses Werbemittel gehört verschleiert, klicken Sie diese Option an.";

$GLOBALS['phpAds_hlp_auto_clean_tables'] = $GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "Wenn Sie diese Funktion aktivieren, werden die gesammelten Statistiken automatisch nach dem
Zeitraum gelöscht, den Sie unter diesem Kontrollkästchen angeben. Wenn Sie dies beispielsweise auf 5 Wochen setzen, werden
Statistiken, die älter als 5 Wochen sind, automatisch gelöscht.";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] = $GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "Diese Funktion wird automatisch Einträge aus dem Benutzer-Protokoll löschen, die älter sind als die
Wochenzahl, die unter diesem Kontrollkästchen angegeben ist.";




$GLOBALS['phpAds_hlp_ignore_hosts'] = "Sollen Views und Klicks von bestimmten Computern nicht aufgezeichnet werden, können diese hier aufgelistet werden. Wurde eingestellt, dass der Hostname per \"Reverse Lookup\" ermittelt wird, können Domain-Namen oder IP-Adressen eingegeben werden. Ohne Ermittlung von Hostnamen ist nur die Eingabe von IP-Adressen möglich. Die Verwendung von Platzhaltern/Wildcards ist möglich (z.B. '*.altavista.com' or '192.168.*')
		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "Für die meisten Menschen beginnt die Woche an einem Montag,
Aber wenn Sie die Woche an einem Sonntag starten lassen möchten, können Sie das tun.";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "Gibt an, wie viele Dezimalstellen auf Statistikseiten angezeigt werden sollen.";








$GLOBALS['phpAds_hlp_type_web_mode'] = "Wenn Banner auf dem Web-Server gespeichert werden sollen, müssen die Einstellungen dafür konfiguriert werden. 
Sollen die Banner in einem lokalen Verzeichnis gespeichert werden, muss <i>Lokales Verzeichnis</i> gewählt werden. 
Für die Speicherung auf einem FTP-Server ist <i>Externer FTP-Server</i> einzustellen.
Auf bestimmten Web-Servern kann es sinnvoll sein, hiefür den lokalen FTP-Server zu verwenden.
		";











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
