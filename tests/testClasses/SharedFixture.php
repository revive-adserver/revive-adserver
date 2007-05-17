<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id$
*/

require_once MAX_PATH . '/lib/simpletest/runner.php';
require_once MAX_PATH . '/lib/simpletest/unit_tester.php';

/**
 * A test runner that runs special setup/teardown methods for the whole run.
 *
 * Per-suite shared fixtures differ from per-test fresh fixtures, which will
 * still be run as normal.
 */
class SharedFixtureRunner extends SimpleRunner
{

    function run()
    {
        $this->_test_case->setUpFixture();
        parent::run();
        $this->_test_case->tearDownFixture();
    }
}

/**
 * A test case that provides a shared fixture for the whole test case class.
 *
 * If you need to use this, it might mean your tests rely on sharing state with
 * each other. Shared state indicates potential problems with tests design.
 *
 * @url http://xunitpatterns.com/Shared%20Fixture.html
 * @url http://xunitpatterns.com/SuiteFixture%20Setup.html
 */
class SharedFixtureTestCase extends UnitTestCase
{

    function &_createRunner(&$reporter) {
        return new SharedFixtureRunner($this, $reporter);
    }

    /**
     * Set up the shared fixture once, before running any test in the test case.
     *
     * Override this in your test case subclasses.
     */
    function setUpFixture() {}

    /**
     * Tear down the shared fixture once, after all the tests have been run.
     *
     * Override this in your test case subclasses.
     */
    function tearDownFixture() {}
}

?>
