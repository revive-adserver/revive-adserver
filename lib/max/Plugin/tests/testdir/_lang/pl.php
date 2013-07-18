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
 * This file lets us test that the translate cascade mechanism is working
 * So if a translation is requested for a string that doesn't exist in this language, the english is returned
 * if no english, the key is returned
 */
    $words = array(
        'translate me' => 'translated text',
    );
?>