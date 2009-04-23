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
$Id: Ip.delivery.php 30054 2008-12-15 13:19:46Z chris.nutting $
*/

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check to see if this impression contains the valid IP Address.
 *
 * @param string $limitation The IP address limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's IP address passes this limitation's test.
 */
function MAX_checkClient_Ip($limitation, $op, $aParams = array())
{
    if ($limitation == '') {
        return true;
    }
    if (empty($aParams)) {
        $aParams = $_SERVER;
    }
    $ip = $aParams['REMOTE_ADDR'];

    if ($limitation == '')
		return (true);
	
	if (!strpos($limitation, '/')) {
		$net = explode('.', $limitation);
		
		for ($i=0;$i<sizeof($net);$i++) {
			if ($net[$i] == '*') {
				$net[$i] = 0;
				$mask[$i] = 0;
			} else {
				$mask[$i] = 255;
			}
		}
		$pnet 	= pack('C4', $net[0], $net[1], $net[2], $net[3]);
		$pmask 	= pack('C4', $mask[0], $mask[1], $mask[2], $mask[3]);
	} else {
		list ($net, $mask) = explode('/', $limitation);
		$net 	= explode('.', $net);
		$pnet 	= pack('C4', $net[0], $net[1], $net[2], $net[3]);
		$mask 	= explode('.', $mask);
		$pmask 	= pack('C4', $mask[0], $mask[1], $mask[2], $mask[3]);
	}
	
	$ip 	= explode('.', $ip);
	$phost 	= pack('C4', $ip[0], $ip[1], $ip[2], $ip[3]);
	
	$expression = ($limitation == "*" || ($phost & $pmask) == $pnet);
	$op   = $op == '==';
	return ($expression == $op);
}
?>
