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
$Id: en.php 33995 2009-03-18 23:04:15Z chris.nutting $
*/

$conf = $GLOBALS['_MAX']['CONF'];

$words = array(
    'Please choose the type of banner invocation' => 'Please choose the type of banner invocation',

    // Other
    'Copy to clipboard' => 'Copy to clipboard',
    'copy' => 'copy',

    // Measures
    'px' => 'px',
    'sec' => 'sec',

    // Common Invocation Parameters
    'Banner selection' => 'Banner selection',
    'Advertiser' => 'Advertiser',
    'Campaign' => 'Campaign',
    'Target frame' => 'Target frame',
    'Source' => 'Source',
    'Show text below banner' => 'Show text below banner',
    'Don\'t show the banner again on the same page' => 'Don\'t show the banner again on the same page',
    'Don\'t show a banner from the same campaign again on the same page' => 'Don\'t show a banner from the same campaign again on the same page',
    'Store the banner inside a variable so it can be used in a template' => 'Store the banner inside a variable so it can be used in a template',
    'Banner ID' => 'Banner ID',
    'No Zones Available!' => 'No Zones Available!',
    'Include comments' => 'Include comments',

    // AdLayer
    'Style' => 'Style',
    'Alignment' => 'Alignment',
    'Horizontal alignment' => 'Horizontal alignment',
    'Left' => 'Left',
    'Center' => 'Center',
    'Right' => 'Right',
    'Vertical alignment' => 'Vertical alignment',
    'Top' => 'Top',
    'Middle' => 'Middle',
    'Bottom' => 'Bottom',
    'Automatically collapse after' => 'Automatically collapse after',
    'Close text' => 'Close text',
    '[Close]' => '[Close]',
    'Banner padding' => 'Banner padding',
    'Horizontal shift' => 'Horizontal shift',
    'Vertical shift' => 'Vertical shift',
    'Show close button' => 'Show close button',
    'Background color' => 'Background color',
    'Border color' => 'Border color',
    'Direction' => 'Direction',
    'Left to right' => 'Left to right',
    'Right to left' => 'Right to left',
    'Looping' => 'Looping',
    'Always active' => 'Always active',
    'Speed' => 'Speed',
    'Pause' => 'Pause',
    'Limited' => 'Limited',
    'Left margin' => 'Left margin',
    'Right margin' => 'Right margin',
    'Transparent background' => 'Transparent background',
    'Smooth movement' => 'Smooth movement',
    'Hide the banner when the cursor is not moving' => 'Hide the banner when the cursor is not moving',
    'Delay before banner is hidden' => 'Delay before banner is hidden',
    'Transparancy of the hidden banner' => 'Transparancy of the hidden banner',
    'Support 3rd Party Server Clicktracking' => 'Support 3rd Party Server Clicktracking',

    // Iframe
    'Refresh after' => 'Refresh after',
    'Resize iframe to banner dimensions' => 'Resize iframe to banner dimensions',
    'Make the iframe transparent' => 'Make the iframe transparent',
    'Include Netscape 4 compatible ilayer' => 'Include Netscape 4 compatible ilayer',

    // PopUp
    'Pop-up type' => 'Pop-up type',
    'Pop-up' => 'Pop-up',
    'Pop-under' => 'Pop-under',
    'Instance when the pop-up is created' => 'Instance when the pop-up is created',
    'Immediately' => 'Immediately',
    'When the page is closed' => 'When the page is closed',
    'After' => 'After',
    'Automatically close after' => 'Automatically close after',
    'Initial position (top)' => 'Initial position (top)',
    'Initial position (left)' => 'Initial position (left)',
    'Window options' => 'Window options',
    'Toolbars' => 'Toolbars',
    'Location' => 'Location',
    'Menubar' => 'Menubar',
    'Status' => 'Status',
    'Resizable' => 'Resizable',
    'Scrollbars' => 'Scrollbars',

    // XML-RPC
    'Host Language' => 'Host Language',
    'Use HTTPS to contact XML-RPC Server' => 'Use HTTPS to contact XML-RPC Server',
    'XML-RPC Timeout (Seconds)' => 'XML-RPC Timeout (Seconds)',

    // Default invocation comments
    // These can be over-ridden (or blanked out completely) by setting them in the individual packages
    'Third Party Comment' => "
  * Don't forget to replace the '{clickurl}' text with
  * the click tracking URL if this ad is to be delivered through a 3rd
  * party (non-Max) adserver.
  *",

    'Cache Buster Comment' => "
  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *",

    'SSL Backup Comment' => "
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://{$conf['webpath']['delivery']}/...'
  * to
  *   'https://{$conf['webpath']['deliverySSL']}/...'
  *",

    'SSL Delivery Comment' => "
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://{$conf['webpath']['delivery']}/...'
  * to
  *   'https://{$conf['webpath']['deliverySSL']}/...'
  *",
);

?>
