<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: Email.mtc.test.php 15399 2008-01-28 15:22:20Z chris.nutting@openads.org $
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Auth.php';

/**
 * A class for testing the OA_Auth class
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_OA_Auth extends UnitTestCase
{

    function Test_OA_Auth()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests that default authentication plugin is correctly created
     *
     */
    function testStaticGetAuthPlugin()
    {
        $authInternal = OA_Auth::staticGetAuthPlugin('internal');
        $this->assertIsA($authInternal, 'Plugins_Authentication');
        $authInternal2 = OA_Auth::staticGetAuthPlugin('internal');
        $this->assertIdentical($authInternal, $authInternal2);

        $authDefault = OA_Auth::staticGetAuthPlugin();
        $this->assertIsA($authInternal, 'Plugins_Authentication');
    }
}

?>