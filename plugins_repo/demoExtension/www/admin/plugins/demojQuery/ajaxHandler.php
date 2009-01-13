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
/**
 * OpenX jQuery ajax functions
 *
 * @author     Bernard Lange <bernard.lange@openx.org>
 *
 * $Id$
 *
 */
require_once '../../../../init.php';
require_once '../../config.php';
require_once 'lib/JSON.php';

$type = $_REQUEST['type'];

handleRequest($type);



function handleRequest($type)
{
    switch ($type)
    {
        case 'html':
            handleHTML();
            break;

        case 'json':
            handleJSON();
            break;
            
        default: 
            echo '';
    }
}

/**
 * Workhorse functions
 */ 
function handleHTML()
{
    global $phpAds_CharSet;
    
    header ("Content-Type: text/html".(isset($phpAds_CharSet) && $phpAds_CharSet != "" ? "; charset=".$phpAds_CharSet : ""));
    echo "Hello ".rand(1,100)." World!";
}

function handleJSON()
{
    global $phpAds_CharSet;
    $result['message'] = "Hello World! ".rand(1,100); 
    $result['jsonMessage'] = "With JSON result you can update multiple items ".rand(1,100);
    
    $json = new Services_JSON();
    $output = $json->encode($result);
    
    header ("Content-Type: application/x-javascript");
    echo $output;
}


?>