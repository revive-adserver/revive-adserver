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
    'Popup Tag' => 'Popup Tag',
    'Allow Popup Tags' => 'Erlaube Popup Tags',

    'Third Party Comment' => "
  -- Don't forget to replace the 'Insert_Clicktrack_URL_Here' text with
  -- the click tracking URL if this ad is to be delivered through a 3rd
  -- party (non-Max) ad server.
  --
  -- Don't forget to replace the 'Insert_Random_Number_Here' text with
  -- a cache-buster random number each time you deliver the tag through
  -- a 3rd party (non-Max) ad server.
  --",

    'Comment' => "
  -- This tag has been generated for use on a non-SSL page. If this tag
  -- is to be placed on an SSL page, change all instances of
  --   'http://{$conf['webpath']['delivery']}/...'
  -- to
  --   'https://{$conf['webpath']['deliverySSL']}/...'
  --"
);

?>
