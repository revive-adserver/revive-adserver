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

require_once MAX_PATH . '/lib/OA/Admin/Option.php';

class Test_OA_Admin_Option extends UnitTestCase
{

    /**
     * Test pearLogPriorityToConstrantName function
     *
     */
    function test_pearLogPriorityToConstrantName()
    {
        $GLOBALS['_MAX']['CONF']['webpath']['adminAssetsVersion'] = '1';

        $oOption = new OA_Admin_Option('settings');
        $this->assertEqual('PEAR_LOG_CRIT', $oOption->pearLogPriorityToConstrantName(PEAR_LOG_CRIT));
        $this->assertEqual('PEAR_LOG_INFO', $oOption->pearLogPriorityToConstrantName('PEAR_LOG_INFO'));
    }
}

?>
