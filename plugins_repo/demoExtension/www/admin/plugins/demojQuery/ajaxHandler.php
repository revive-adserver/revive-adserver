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

/**
 * OpenX jQuery ajax functions
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