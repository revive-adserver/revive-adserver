<?php
/**
 * Unit test support for sharing a fixture across a whole testcase.
 * @since Openads v2.3.30-alpha
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
