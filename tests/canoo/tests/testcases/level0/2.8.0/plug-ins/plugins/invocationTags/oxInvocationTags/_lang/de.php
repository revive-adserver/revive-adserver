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
$Id: de.php 33995 2009-03-18 23:04:15Z chris.nutting $
*/

//german
$conf = $GLOBALS['_MAX']['CONF'];

$words = array(
    'Please choose the type of banner invocation' => 'Bitte w&auml;hlen Sie die Art der Bannereinbindung',

    // Other
    'Copy to clipboard' => 'In die Zwischenablage kopieren',
    'copy' => 'Kopieren',

    // Measures
    'px' => 'px',
    'sec' => 'Sek',

    // Common Invocation Parameters
    'Banner selection' => 'Werbemittelauswahl',
    'Advertiser' => 'Werbetreibende',
    'Campaign' => 'Kampagne',
    'Target frame' => 'Ziel-Frame',
    'Source' => 'Quelle',
    'Show text below banner' => 'Zeige Text unter dem Bannner',
    'Don\'t show the banner again on the same page' => 'Das Banner nicht mehrfach auf einer Seite anzeigen',
    'Don\'t show a banner from the same campaign again on the same page' => 'Banner einer Kampagne nur einmalig auf einer Seite anzeigen',
    'Store the banner inside a variable so it can be used in a template' => 'Den Bannercode in einer Variable speichern, so dass diese in einem Template verwendet werden kann',
    'Banner ID' => 'Banner ID',
    'No Zones Available!' => 'Keine verf&uuml;gbaren Zonen!',
    'Include comments' => 'Kommentare einschlie&szlig;en',
    
    // AdLayer
    'Style' => 'Style',
    'Alignment' => 'Ausrichtung',
    'Horizontal alignment' => 'Horizontale Ausrichtung',
    'Left' => 'Links',
    'Center' => 'Zentriert',
    'Right' => 'Rechts',
    'Vertical alignment' => 'Vertikale Ausrichtung',
    'Top' => 'Oben',
    'Middle' => 'Mitte',
    'Bottom' => 'Unten',
    'Automatically collapse after' => 'Automatisch einklappen nach',
    'Close text' => 'Schlie&szlig;text',
    '[Close]' => '[Schlie&szlig;en]',
    'Banner padding' => 'Banner ausf&uuml;llen',
    'Horizontal shift' => 'Horizontal verschieben',
    'Vertical shift' => 'Vertikal verschieben',
    'Show close button' => 'Zeige schlie&szlig;en Button',
    'Background color' => 'Hintergrundfarbe',
    'Border color' => 'Randfarbe',
    'Direction' => 'Richtung',
    'Left to right' => 'Von Links nach Rechts',
    'Right to left' => 'Von Rechts nach Links',
    'Looping' => 'Looping',
    'Always active' => 'Immer aktiv',
    'Speed' => 'Geschwindigkeit',
    'Pause' => 'Pause',
    'Limited' => 'Limitiert',
    'Left margin' => 'Linker Rand',
    'Right margin' => 'Rechter Rand',
    'Transparent background' => 'Transparenter Hintergrund',
    'Smooth movement' => 'Ruhige Bewegung',
    'Hide the banner when the cursor is not moving' => 'Das Banner verstecken, wenn sich der Mauszeiger nicht bewegt',
    'Delay before banner is hidden' => 'Verz&ouml;gerung, bevor das Banner versteckt wird',
    'Transparancy of the hidden banner' => 'Transparenz des versteckten Banners',
    'Support 3rd Party Server Clicktracking' => 'Unterst&uuml;tze 3rd Party Server Clicktracking',

    // Iframe
    'Refresh after' => 'Aktualisiere nach',
    'Resize iframe to banner dimensions' => 'Die Gr&ouml;sse des iFrame an die Bannergr&ouml;sse anpassen',
    'Make the iframe transparent' => 'Das iFrame transparent machen',
    'Include Netscape 4 compatible ilayer' => 'Netscape 4 kompatiblen ilayer (zus&auml;tzlich)',

    // PopUp
    'Pop-up type' => 'PopUp Typ',
    'Pop-up' => 'PopUp',
    'Pop-under' => 'PopUnder',
    'Instance when the pop-up is created' => 'Zeitpunkt zu dem das PopUp erscheinen wird',
    'Immediately' => 'Sofort',
    'When the page is closed' => 'Wenn die Seite geschlossen wird',
    'After' => 'Nach',
    'Automatically close after' => 'Automatisch schlie&szlig;en nach',
    'Initial position (top)' => 'Startposition (oben)',
    'Initial position (left)' => 'Startposition (links)',
    'Window options' => 'Window-Optionen',
    'Toolbars' => 'Werkzeugleiste',
    'Location' => 'Standortleiste',
    'Menubar' => 'Men&uuml;leiste',
    'Status' => 'Statusleiste',
    'Resizable' => 'Gr&ouml;&szlig;e anpassen',
    'Scrollbars' => 'Scrollbalken',

    // XML-RPC
    'Host Language' => 'Sprache auf Host',
    'Use HTTPS to contact XML-RPC Server' => 'HTTPS verwenden, um die Verbindung zum XML-RPC Server aufzunehmen',
    'XML-RPC Timeout (Seconds)' => 'XML-RPC Timeout (Sekunden)',

    // Default invocation comments
    // These can be over-ridden (or blanked out completely) by setting them in the individual packages
    'Third Party Comment' => "
  * Vergessen Sie nicht die Variable '{clickurl}' mit der Klicktracking URL zu ersetzen, 
  * wenn dieses Werbemittel ueber einen 3rd Party Ad-Server ausgeliefert werden soll.
  *",
    
    'Cache Buster Comment' => "
  * Aendern Sie alle Vorkommen von {random} mit einer zufaelltigen 
  * Zahl (oder Zeitstempel).
  *",
    
    'SSL Backup Comment' => "
  * Der Backup Bildbereich dieses Tags wurde zur Verwendung auf einer nicht-SSL Seite erstellt. 
  * Wenn dieser Tag auf einer SSL Seite platziert werden soll, aendern Sie
  *   'http://{$conf['webpath']['delivery']}/...'
  * zu
  *   'https://{$conf['webpath']['deliverySSL']}/...'
  *",
    
    'SSL Delivery Comment' => "
  * Dieser Tag wurde zur Verwendung auf einer nicht-SSL Seite erstellt. Wenn 
  * dieser Tag auf einer SSL Seite platziert werden soll, aendern Sie
  *   'http://{$conf['webpath']['delivery']}/...'
  * zu
  *   'https://{$conf['webpath']['deliverySSL']}/...'
  *",
);

?>
