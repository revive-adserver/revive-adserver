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
 * @package    MaxDal
 * @subpackage TestSuite
 */

define('DATA_AGENCY', 'INSERT INTO
    agency (
        agencyid,
        name,
        contact,
        email,
        username,
        password,
        permissions,
        language,
        logout_url,
        active
    )
    VALUES (
        1,
        \'Agency\',
        \'Contact\',
        \'contact@example.com\',
        \'agency\',
        \'1d1d5778763061ebb2bdc5db696077a6\',
        0,
        \'\',
        \'\',
        0
    )'
);

?>
