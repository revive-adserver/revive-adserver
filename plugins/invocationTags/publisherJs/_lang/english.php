<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
<!-- NOTE: You can remove the (extensive) comments when moving this code
--       to a live server to reduce the size of your pages
-->",

    'Publisher JS Channel Script Comment 1' => "
<!-- Openads Channel Script
--
-- Generated with Openads " . MAX_VERSION_READABLE . "
--
-- Include this script directly ABOVE the Openads Header Script
-- (defined below), in the <head> tag.
--
-- The script below should define a variable, az_channel. This variable
-- should contain the name of the 'virtual directory' of the site.
--
-- For example, if you are on the football summary page of the sports section
-- of a news site, the following should be included:
--   var az_channel = '",

    'Publisher JS Channel Script Comment 2' => "/sports/football';
-- Conversely, if you are on the home page of the site, the variable should be:
--   var az_channel = '",

    'Publisher JS Channel Script Comment 3' => "';
-->",

    'Publisher JS Header Script Comment' => "
<!-- Openads Header Script
--
-- Generated with Openads " . MAX_VERSION_READABLE . "
--
-- Include this script below the Openads Channel Scipt (but still
-- in the <head> tag) of every page on your site.
--
-- NOTE: This script does not change for any page on your site, so it may be
--     more efficient to include it as a .js file rather than putting the
--     entire text on every page. For example, if you cut and paste the code
--     below and store it in a file called 'mmm.js', the code below should
--     call the script:
--
-- <script type='text/javascript' src='mmm.js'></script>
-->",

    'Publisher JS Ad Tag Script(s) Comment' => "
<!-- Openads Ad Tag Script(s)
--
-- Generated with Openads " . MAX_VERSION_READABLE . "
--
-- The following are the script(s) for each ad tag. There are a couple of items to watch out for:
--
-- 1. Each tag has a different zone number (var 1), and a different key value (var 2). If the
--    key value is the same for any two zone tags, the clickthrough URL may not work correctly.
-- 2. Each tag has a <noscript> section. If this tag is on an SSL page, change the
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
