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
 * A script to generate the tree menu for the test suite.
 *
 * @package    OpenX
 * @subpackage TestSuite
 */

require_once 'init.php';

// Required files
require_once MAX_PATH . '/tests/testClasses/Menu.php';

// Output the menu of tests
$menu = new Menu();
echo $menu->buildTree();

?>
