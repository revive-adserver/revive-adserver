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

// Require the initialisation file
require_once '../../init-delivery.php';

// Required files
require_once MAX_PATH . '/lib/max/Delivery/adSelect.php';
require_once MAX_PATH . '/lib/max/Delivery/marketplace.php';

// Marketplace
MAX_marketplaceGetIdWithRedirect(basename(__FILE__));

// No Caching
MAX_commonSetNoCacheHeaders();

//Register any script specific input variables
MAX_commonRegisterGlobalsArray(
    array(
        'left',
        'top',
        'popunder',
        'timeout',
        'delay',
        'toolbars',
        'location',
        'menubar',
        'status',
        'resizable',
        'scrollbars'
    )
);

// Set defaults for script specific input variables
if (!isset($left))       $left       = 0;
if (!isset($top))        $top        = 0;
if (!isset($popunder))   $popunder   = 0;
if (!isset($timeout))    $timeout    = 0;
if (!isset($delay))      $delay      = 0;
if (!isset($toolbars))   $toolbars   = 0;
if (!isset($location))	 $location   = 0;
if (!isset($menubar))	 $menubar    = 0;
if (!isset($status))	 $status     = 0;
if (!isset($resizable))  $resizable  = 0;
if (!isset($scrollbars)) $scrollbars = 0;

// Get the banner
$row = MAX_adSelect($what, $campaignid, $target, $source, $withtext, $charset, $context, true, $ct0, $GLOBALS['loc'], $GLOBALS['referer']);
$row['zoneid'] = 0;
if (isset($zoneid)) {
    $row['zoneid'] = $zoneid;
}

// Do not pop a window if not banner was found..
if (!$row['bannerid']) {
    exit;
}

$contenturl = MAX_commonGetDeliveryUrl($conf['file']['content']) . "?bannerid={$row['bannerid']}&zoneid={$row['zoneid']}&target={$target}&withtext={$withtext}&source=".urlencode($source)."&timeout={$timeout}&ct0={$ct0}";

/*-------------------------------------------------------*/
/* Build the code needed to pop up a window              */
/*-------------------------------------------------------*/

MAX_commonSendContentTypeHeader("application/x-javascript");
echo "
var MAX_errorhandler = null;

if (window.captureEvents && Event.ERROR)
  window.captureEvents (Event.ERROR);

// Error handler to prevent 'Access denied' errors
function MAX_onerror(e) {
  window.onerror = MAX_errorhandler;
  return true;
}

function MAX_{$row['bannerid']}_pop() {
  MAX_errorhandler = window.onerror;
  window.onerror = MAX_onerror;

  // Determine the size of the window
  var X={$row['width']};
  var Y={$row['height']};

  // If Netscape 3 is used add 20 to the size because it doesn't support a margin of 0
  if(!window.resizeTo) {
    X+=20;
    Y+=20;
  }

  // Open the window if needed
  window.MAX_{$row['bannerid']}=window.open('', 'MAX_{$row['bannerid']}','height='+Y+',width='+X+',toolbar=".($toolbars == 1 ? 'yes' : 'no').",location=".($location == 1 ? 'yes' : 'no').",menubar=".($menubar == 1 ? 'yes' : 'no').",status=".($status == 1 ? 'yes' : 'no').",resizable=".($resizable == 1 ? 'yes' : 'no').",scrollbars=".($scrollbars == 1 ? 'yes' : 'no')."');

  if (window.MAX_{$row['bannerid']}.document.title == '' || window.MAX_{$row['bannerid']}.location == 'about:blank' || window.MAX_{$row['bannerid']}.location == '') {
    var browser = navigator.userAgent.toLowerCase();

    // Resize window to correct size on IE < 6, determine outer width and height - IE 5.1x on MAC should't resize!
    if (window.resizeTo && browser.match(/msie [345]/) && browser.indexOf('msie 5.1') == -1 && browser.indexOf('mac') == -1) {
      if(MAX_{$row['bannerid']}.innerHeight) {
        var diffY = MAX_{$row['bannerid']}.outerHeight-Y;
        var diffX = MAX_{$row['bannerid']}.outerWidth-X;
        var outerX = X+diffX;
        var outerY = Y+diffY;
      } else {
        MAX_{$row['bannerid']}.resizeTo(X, Y);
        var time = new Date().getTime();
        while (!MAX_{$row['bannerid']}.document.body) {
          if (new Date().getTime() - time > 250) {
            MAX_{$row['bannerid']}.close();
            return false;
          }
        }
        var diffY = MAX_{$row['bannerid']}.document.body.clientHeight-Y;
        var diffX = MAX_{$row['bannerid']}.document.body.clientWidth-X;
        var outerX = X-diffX;
        var outerY = Y-diffY;
      }
      MAX_{$row['bannerid']}.resizeTo(outerX, outerY);
    }";

if (!empty($left) && !empty($top)) {
	echo "
    if (window.moveTo) {";

	if ($left == 'center') {
		echo "
      var posX = parseInt((screen.width/2)-(outerX/2));";
	} elseif ($left >= 0) {
		echo "
      var posX = $left;";
	} elseif ($left < 0) {
	    echo "
      var posX = screen.width-outerX+$left;";
	}

	if ($top == 'center') {
	    echo "
      var posY = parseInt((screen.height/2)-(outerY/2));";
	} elseif ($top  >= 0) {
        echo "
      var posY = $top;";
	} elseif ($top  < 0) {
		echo "
      var posY = screen.height-outerY+$top;";
	}

	echo "
      MAX_{$row['bannerid']}.moveTo(posX, posY);
    }";
}

// Set the actual location after resize otherwise we might get 'access denied' errors
echo "
    MAX_{$row['bannerid']}.location='$contenturl';";

// Move main window to the foreground if we are dealing with a popunder
if (isset($popunder) && $popunder == '1') {
	echo "
    MAX_{$row['bannerid']}.blur();
    window.focus();";
}

echo "
  }

  window.onerror = MAX_errorhandler;
  return true;
}";

if (!empty($delay) && $delay == 'exit') {
	echo "
if (window.captureEvents && Event.UNLOAD)
  window.captureEvents (Event.UNLOAD);
window.onunload = MAX_{$row['bannerid']}_pop;";
} elseif (isset($delay) && $delay > 0) {
	echo "
window.setTimeout(\"MAX_{$row['bannerid']}_pop();\", ".($delay * 1000).");";
} else {
	echo "
MAX_{$row['bannerid']}_pop();";
}

?>
