<?php
/**
 * @since 05-Dec-2006
 */
require_once 'init.php';
require_once MAX_PATH . '/tests/testClasses/MaxGroupTest.php';
require_once MAX_PATH . '/lib/simpletest/reporter.php';
require_once MAX_PATH . '/tests/testClasses/TestRunner.php';
require_once MAX_PATH . '/tests/testClasses/TestFiles.php';

/**
 * A thorough test suite that identifies any failures.
 * 
 * @see http://xunitpatterns.com/Named%20Test%20Suite.html#AllTests%20Suite
 */
 
class CompleteTests extends MaxGroupTest
{
    /**
     * Constructor.
     */
    function CompleteTests()
    {
        $this->MaxGroupTest("Thorough testing including a real database");
    }

    /**
     * Populate this group test with "known good" tests.
     * 
     * At the time of writing, there are many tests that don't pass (some don't
     * even run). Sending feedback like "a test failed, you broke the build" is
     * only useful when it can be trusted to indicate a problem.
     * 
     * @todo Find a broken test today! Fix it then add it here.
     * @todo Consider using annotation and reflection to mark "brokenness"
     */
    function addTestsKnownToPass()
    {
        $test_folders = array();
        $test_folders += TestFiles::getTestFiles('unit','dal', MAX_PATH);
        $this->_addFilesInFolders($test_folders);
    }
    
    /**
     * Run the tests in the suite, taking care of environment setup.
     * 
     * The fixtures should probably be specified by the test cases themselves
     * rather than implicitly rely on a special runner.
     *  
     * @todo Ensure that individual layer setups are obeyed (not just 'dal')
     */
    function run(&$reporter)
    {
        $GLOBALS['_MAX']['TEST']['test_type'] = 'unit';
        TestRunner::setupEnv('dal');
        parent::run($reporter);
        TestRunner::teardownEnv('dal');
    }
}

// TODO: reduce duplication with "quick_tests.php" and "run.php"
$test_runner = new TestRunner();
$test_suite = new CompleteTests();
$test_suite->addTestsKnownToPass();
$test_runner->runCase($test_suite);
$test_runner->exitWithCode();
?>
