<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

$conf = $GLOBALS['_MAX']['CONF'];

$words = array(
    'Remove Comments Note' => "
<!-- Hinweis: Sie koennen die umfangreichen Kommentare in dieser Seite entfernen, wenn Sie diese Seite
  --          unter Produktionsbedingungen nutzen und das Gewicht der Seite reduzieren moechten.
  -->",

    'Publisher JS Channel Script Comment 1' => "
<!-- Max Media Manager Channel Script
  --
  -- Erstellt mit Max " . MAX_VERSION_READABLE . "
  --
  -- Fuegen Sie dieses Script unmittelbar UEBER dem Max Media Manager Header Script
  -- (wie unten definiert) in den <head>-Tag Ihrer Site ein.
  --
  -- Das untenstehende Script definiert die Variable az_channel. Diese Variable
  -- enthaelt den Namen des 'virtuellen Verzeichnisses' der Web-Site.
  --
  -- Beispiel: Wenn Sie sich auf der Fussball-Uebersichtsseite des Sportbereiches einer
  -- einer Magazin-Web-Site befinden, sollte das folgende Verzeichnis mit der Variable verknuepft werden:
  --   var az_channel = '",

    'Publisher JS Channel Script Comment 2' => "/sport/fussball';
  -- Umgekehrt, wenn Sie sich auf der Homepage der Site befinden, sollte die Variable wie folgt aussehen:
  --   var az_channel = '",

    'Publisher JS Channel Script Comment 3' => "';
-->",

    'Publisher JS Header Script Comment' => "
<!-- Max Media Manager Header Script
  --
  -- Erstellt mit Max " . MAX_VERSION_READABLE . "
  --
  -- Fuegen Sie dieses Script UNTERHALB des Max Media Manager Channel Scipts (aber dennoch
  -- innerhalb des <head>-Tags Ihrer Site ein). Jede Seite Ihrer Web-Site, auf der Sie
  -- Werbung ausliefern moechten muss dieses Script enthalten.
  --
  -- Hinweis: Dieses Script bleibt immer gleich, egal auf welcher Seite Sie es einbinden.
  --    Sie sollten diese Datei deshalb am besten in eine externe .js-Datei auslagern, anstatt
  --    jede Seite mit dem gesammten Code zu belasten. Kopieren Sie den untenstehenden Code und
  --    speichern Sie ihn in einer Datei namens 'mmm.js'. Damm muessen Sie in Ihre Seiten nur noch
  --    den untenstehden Code integrieren (und evtl. den Pfad anpassen).
  --
  -- <script language='JavaScript' type='text/javascript' src='mmm.js'></script>
  -->",

    'Publisher JS Ad Tag Script(s) Comment' => "
<!-- Max Media Manager Ad Tag Script(s)
  --
  -- Erstellt mit Max " . MAX_VERSION_READABLE . "
  --
  -- Im folgenden finden Sie die Script(e) fuer jede Zone(n).
  -- Bitte beachten Sie die folgenden Dinge:
  --
  -- 1. Jeder Tag hat eine unterschiedliche Zonennummer (var 1) und eine , and eine unterschiedliche ID (var 2).
  --    Jede ID darf nur genau einmal vergeben werden. Haben 2 Zonen die gleiche ID, kommt es zu Problemem beim Klick auf
  --    das Werbemittel.
  -- 2. Jeder Tag hat eine <noscript>-Section. If this tag is on an SSL page, change the
  --    'http://{$conf['webpath']['delivery']}/...' to 'https://{$conf['webpath']['deliverySSL']}/...'
  --    Note that the <noscript> section cannot dynamically choose between SSL and non-SSL.
  -- 3. The <noscript> section will only show image banners. There is no width or height in
  --    these banners, so if you want these tags to allocate space for the ad before it shows,
  --    you need to add this information to the <img> tag.
  -- 4. If you do not want to deal with the intricities of the <noscript> section, delete the
  --    tag (from <noscript>... to </noscript>). On average, the <noscript> tag is called from
  --    less than 1% of internet users.
  -->"
);

?>
