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

require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';

class FieldFactoryTest extends UnitTestCase
{
    function testGenerateTextField()
    {
        $factory = new FieldFactory();
        $field =& $factory->newField('edit');
        $this->assertIsA($field, 'Admin_UI_TextField');
    }
}

?>
