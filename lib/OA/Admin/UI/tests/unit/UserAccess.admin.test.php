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

require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

class Test_OA_Admin_UI_UserAccess extends UnitTestCase
{
    public function test_validateUsername()
    {
        $data = [
            '' => false,
            'a' => false,
            'aa' => true,
            'A0' => true,
            'A.0' => true,
            'admin' => true,
            'abc 01' => false,
            'a_b.c-1' => true,
            '1234567890123456789012345678901234567890123456789012345678901234' => true,
            '1234567890123456789012345678901234567890123456789012345678901234a' => false,
        ];

        foreach ($data as $username => $expect) {
            $this->assertEqual(OA_Admin_UI_UserAccess::validateUsername($username), $expect, "Username $username is not " . var_export($expect, true));
        }
    }
}
