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
$Id$
*/

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check to see if this impression contains the valid language.
 *
 * @param string $limitation The language limitation
 * @param string $op The operator
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's language passes this limitation's test.
 */
function MAX_checkClient_Language($limitation, $op, $aParams = array())
{
    if (empty($aParams)) {
        $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    } else {
        $language = $aParams['language'];
    }
    if ($limitation == '' || empty($language)) {
        return true;
    }
    // Strip off q=X if present
    $language = preg_replace('/;q=[0-9\.]+$/', '', $language);
    
    $aLimitation = MAX_limitationsGetAFromS($limitation);
    $aLanguages = MAX_limitationsGetAFromS($language);

    $aMatchedValues = array_intersect($aLimitation, $aLanguages);
    if ('=~' == $op) {
        return !empty($aMatchedValues);
    } else {
        return empty($aMatchedValues);
    }
}

?>
