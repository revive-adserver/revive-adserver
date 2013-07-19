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

$words = array(
    'XML-RPC Tag' => 'XML-RPCタグ',
    'Allow XML-RPC Tags' => 'XML-RPCタグを許可する',
    'Third Party Comment' => '',
    'Cache Buster Comment' => '',
    'SSL Backup Comment' => '',
    'SSL Delivery Comment' => '',

    'Comment' => "",

    'PHP Comment' => "
  * As the PHP script below tries to set cookies, it must be called
  * before any output is sent to the user's browser. Once the script
  * has finished running, the HTML code needed to display the ad is
  * stored in the \$adArray array (so that multiple ads can be obtained
  * by using mulitple tags). Once all ads have been obtained, and all
  * cookies set, then you can send output to the user's browser, and
  * print out the contents of \$adArray where appropriate.
  *
  * Example code for printing from \$adArray is at the end of the tag -
  * you will need to remove this before using the tag in production.
  * Remember to ensure that the PEAR::XML-RPC package is installed
  * and available to this script, and to copy over the
  * lib/xmlrpc/php/openads-xmlrpc.inc.php library file. You may need to
  * alter the 'include_path' value immediately below.
  */"
);

?>
