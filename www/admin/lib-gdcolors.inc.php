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

// Set HTML colors
$headercolor = "#66CCFF";
$bodycolor = "#000000";
$textcolor = "#006666";



// Populate RGB array with colors
$RGB = array(
		"white"         => array(0xFF,0xFF,0xFF),
        "black"         => array(0x00,0x00,0x00),
        "gray"          => array(0x7F,0x7F,0x7F),
        "lgray"         => array(0xBF,0xBF,0xBF),
        "egray"         => array(0xDD,0xDD,0xDD),
        "dgray"         => array(0x3F,0x3F,0x3F),
        "blue"          => array(0x00,0x00,0xBF),
        "lblue"         => array(0x00,0x00,0xFF),
        "dblue"         => array(0x00,0x00,0x7F),
        "yellow"        => array(0xBF,0xBF,0x00),
        "lyellow"       => array(0xFF,0xFF,0x00),
        "dyellow"       => array(0x7F,0x7F,0x00),
        "green"         => array(0x00,0xBF,0x00),
        "lgreen"        => array(0x00,0xFF,0x00),
        "dgreen"        => array(0x00,0x7F,0x00),
        "red"           => array(0xBF,0x00,0x00),
        "lred"          => array(0xFF,0x00,0x00),
        "dred"          => array(0x7F,0x00,0x00),
        "purple"        => array(0xBF,0x00,0xBF),
        "lpurple"       => array(0xFF,0x00,0xFF),
        "dpurple"       => array(0x7F,0x00,0x7F),
        "gold"          => array(0xFF,0xD7,0x00),
        "pink"          => array(0xFF,0xB7,0xC1),
        "dpink"         => array(0xFF,0x69,0xB4),
        "marine"        => array(0x7F,0x7F,0xFF),
        "cyan"          => array(0x00,0xFF,0xFF),
        "lcyan"         => array(0xE0,0xFF,0xFF),
        "maroon"        => array(0x80,0x00,0x00),
        "olive"         => array(0x80,0x80,0x00),
        "navy"          => array(0x00,0x00,0x80),
        "teal"          => array(0x00,0x80,0x80),
        "silver"        => array(0xC0,0xC0,0xC0),
        "lime"          => array(0x00,0xFF,0x00),
        "khaki"         => array(0xF0,0xE6,0x8C),
        "lsteelblue"    => array(0xB0,0xC4,0xDE),
        "seagreen"      => array(0x3C,0xB3,0x71),
        "lseagreen"     => array(0x20,0xB2,0xAA),
        "skyblue"       => array(0x87,0xCE,0xEB),
        "lskyblue"      => array(0x87,0xCE,0xFA),
        "slateblue"     => array(0x6A,0x5A,0xCD),
        "slategray"     => array(0x70,0x80,0x90),
        "steelblue"     => array(0x46,0x82,0xB4),
        "tan"           => array(0xD2,0xB4,0x8C),
        "violet"        => array(0xEE,0x82,0xEE),
        "wheat"         => array(0xF5,0xDE,0xB3),
        "phpAdsClicks"  => array(153,204,255),
        "phpAdsViews"   => array(0,102,204),
		"phpAdsLines"   => array(0,0,102)
);


// Set the colors used for creating the graphs
$bgcolors       = $RGB["white"];
$adviewscolors  = $RGB["phpAdsViews"];
$adclickscolors = $RGB["phpAdsClicks"];
$linecolors     = $RGB["phpAdsLines"];
$textcolors     = $RGB["black"];

?>