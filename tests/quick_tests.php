<?php
/**
 * @since Max 0.3.30 29-Nov-2006
 * @version $Id$
 */
require_once 'init.php';
require_once MAX_PATH . '/lib/simpletest/reporter.php';
require_once MAX_PATH . '/tests/testClasses/MaxGroupTest.php';
require_once MAX_PATH . '/tests/testClasses/TestRunner.php';
require_once MAX_PATH . '/tests/testClasses/TestFiles.php';


/**
 * A test suite that developers run all the time.
 * 
 * The execution time should be kept under 20 seconds to encourage
 * frequent testing. Any longer than 20 seconds sharply reduces the frequency
 * with which developers run these tests.
 * 
 * The short timeframe means that thorough testing of real databases is
 * probably inappropriate. Those tests should be in the "complete tests"
 * suite, which can be run on demand but can also be scheduled to run from a
 * build server.
 * 
 * @link http://xunitpatterns.com/Named%20Test%20Suite.html#Subset%20Suite
 * 
 */
class QuickTests extends MaxGroupTest
{
    /**
     * Constructor.
     */
    function QuickTests()
    {
        parent::MaxGroupTest('Quick, repeatable developer tests for Max');
    }
    
    /**
     * Populate this group test with "known good" tests.
     * 
     * At the time of writing, there are many unit tests that don't pass (some
     * don't even run). Sending feedback like "a test failed, you broke the
     * build" is only useful when it can be trusted to indicate a problem.
     * 
     * @todo Find a broken "developer test" today! Fix it then add it here.
     * @todo Consider using annotation and reflection to mark "brokenness"
     */
    function addTestsKnownToPass()
    {
        $this->addLayersKnownToPass();

        $test_folders = array();
        $test_folders += TestFiles::getTestFiles('unit', 'plg', MAX_PATH . '/lib/max/Plugin');
        $test_folders += TestFiles::getTestFiles('unit', 'plg', MAX_PATH . '/plugins/reports');
        $test_folders += TestFiles::getTestFiles('unit', 'admin', MAX_PATH . '/lib/max/Admin/UI/Field');
        $test_folders += TestFiles::getTestFiles('unit', 'admin', MAX_PATH . '/plugins');
        $this->_addFilesInFolders($test_folders);
    }
    
    function addLayersKnownToPass()
    {
        $passing_layers = array('core', 'ent', 'fct', 'mtc', 'mts', 'mtf', 'sdh', 'mol');
        foreach ($passing_layers as $layer_name) {
            $this->addTestForLayer($layer_name);
        }
    }
    
    function addTestForLayer($layer_abbreviation)
    {
        $test_folders = TestFiles::getTestFiles('unit', $layer_abbreviation, MAX_PATH);
        $this->_addFilesInFolders($test_folders);
    }
}

// TODO: reduce duplication with "complete_tests.php" and "run.php"
$test_runner = new TestRunner();
$test_suite = new QuickTests();
$test_suite->addTestsKnownToPass();
$test_runner->runCase($test_suite);
$test_runner->exitWithCode();
?>
