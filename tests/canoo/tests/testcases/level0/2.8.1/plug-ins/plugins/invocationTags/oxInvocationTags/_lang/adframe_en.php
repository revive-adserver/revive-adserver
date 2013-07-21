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

$conf = $GLOBALS['_MAX']['CONF'];

$words = array(
    'iFrame Tag' => 'iFrame Tag',
    'Allow iFrame Tags' => 'Allow iFrame Tags',

    'Comment' => "
  * If iFrames are not supported by the viewer's browser, then this
  * tag only shows image banners. There is no width or height in these
  * banners, so if you want these tags to allocate space for the ad
  * before it shows, you will need to add this information to the <img>
  * tag.",

    'Placement Comment' => "Place this part of the code just above the </body> tag"
);

?>
