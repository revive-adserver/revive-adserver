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

require_once MAX_PATH . '/tests/testClasses/TestFiles.php';
require_once MAX_PATH . '/tests/testClasses/TestEnv.php';
require_once MAX_PATH . '/lib/simpletest/unit_tester.php';
require_once MAX_PATH . '/lib/simpletest/mock_objects.php';
require_once MAX_PATH . '/lib/simpletest/reporter.php';
require_once MAX_PATH . '/lib/simpletest/web_tester.php';
require_once MAX_PATH . '/lib/simpletest/xml.php';

require_once MAX_PATH . '/lib/OA/DB.php';
require_once 'Console/Getopt.php';

/**
 * A class for running tests.
 *
 * @package    Max
 * @subpackage TestSuite
 * @todo Consider fitting in with the SimpleTest style and inheriting from
 *       SimpleTestRunner.
 */
class TestRunner
{
    /**
     * @var string The reporter format for displaying results.
     *
     * One of 'auto', 'xml', 'text', or 'html'
     */
    public $output_format_name = 'auto';

    /**
     * @var string The type of tests being run.
     *
     * One of 'unit', 'integration', or maybe others.
     */
    public $test_type_name = 'unit';

    /**
     * @var string The level at which testing should be directed.
     *
     * One of 'all', 'layer', 'folder' or 'file'.
     */
    public $test_level_name = 'sdh';

    /**
     * @var string A folder (relative to the OpenX root) containing tests to run.
     *
     * It should not include a leading '/'.
     */
    public $test_folder_name = '';

    /**
     * @var string A base filename containing tests to run.
     *
     * Stored as a full filename without path, such as
     * "example.dal.test.php"
     */
    public $test_file_name;

    /**
     * @var string The host which should be used for tests
     */
    public $host;

    /** @var int The number of times any run has failed.
     * @todo Consider querying report object instead of storing failures.
     */
    public $_failed_runs = 0;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->findDefaults();
        TestEnv::backupConfig();
    }

    /**
     * A method to run all the tests in the OpenX project.
     */
    public function runAll()
    {
        $type = $GLOBALS['_MAX']['TEST']['test_type'];
        foreach ($GLOBALS['_MAX']['TEST'][$type . '_layers'] as $layer => $data) {
            // Run each layer test in turn
            $this->runLayer($layer);
        }
    }

    /**
     * A method to run all tests in a layer.
     *
     * @param string $layer The layer group to run.
     */
    public function runLayer($layer)
    {
        $type = $GLOBALS['_MAX']['TEST']['test_type'];
        // Set up the environment for the test
        TestRunner::setupEnv($layer);
        // Find all the tests in the layer
        $tests = TestFiles::getLayerTestFiles($type, $layer);
        // Add the test files to a SimpleTest group
        $testName = $this->_testName($layer);
        $secondaryName = $this->_secondaryTestName($layer);
        $test = new GroupTest($testName, $secondaryName);
        foreach ($tests as $layerCode => $folders) {
            foreach ($folders as $folder => $files) {
                foreach ($files as $index => $file) {
                    $testFile = MAX_PROJECT_PATH . '/' . $folder . '/' . constant($type . '_TEST_STORE') . '/' . $file;
                    $test->addTestFile($testFile);
                }
            }
        }
        $this->runCase($test);
        // Tear down the environment for the test
        TestRunner::teardownEnv($layer);
    }

    /**
     * A method to all tests in a layer/folder.
     *
     * @param string $layer  The layer group to run.
     * @param string $folder The folder group to run.
     */
    public function runFolder($layer, $folder)
    {
        $type = $GLOBALS['_MAX']['TEST']['test_type'];
        // Set up the environment for the test
        TestRunner::setupEnv($layer);
        // Find all the tests in the layer/folder, but ensure
        // that they are NOT obtained recursively!
        $tests = TestFiles::getTestFiles($type, $layer, MAX_PROJECT_PATH . '/' . $folder, false);
        // Add the test files to a SimpleTest group
        $testName = $this->_testName($layer, $folder);
        $secondaryName = $this->_secondaryTestName($layer);
        $test = new GroupTest($testName, $secondaryName);
        foreach ($tests as $folder => $data) {
            foreach ($data as $index => $file) {
                $testFile = MAX_PROJECT_PATH . '/' . $folder . '/' . constant($type . '_TEST_STORE') . '/' . $file;
                $test->addTestFile($testFile);
            }
        }
        $this->runCase($test);
        // Tear down the environment for the test
        TestRunner::teardownEnv($layer);
    }

    /** A method to run a single test file.
     *
     * @param string $layer  The name of a layer group to run.
     * @param string $folder The folder group to run, not including "tests/unit"
     * @param string $file   The file to run, including ".test.php"
     */
    public function runFile($layer, $folder, $file)
    {
        $type = $GLOBALS['_MAX']['TEST']['test_type'];
        // Set up the environment for the test
        TestRunner::setupEnv($layer);
        $configBefore = TestEnv::parseConfigFile();
        // Add the test file to a SimpleTest group
        $testName = $this->_testName($layer, $folder, $file);
        $secondaryName = $this->_secondaryTestName($layer);
        $test = new GroupTest($testName, $secondaryName);
        $testFile = MAX_PROJECT_PATH . '/' . $folder . '/' . constant($type . '_TEST_STORE') . '/' . $file;
        $test->addTestFile($testFile);
        $this->runCase($test);
        // Tear down the environment for the test
        $configAfter = TestEnv::parseConfigFile();
        $configDiff = array_diff_assoc_recursive($configBefore, $configAfter);
        if (!empty($configDiff)) {
            OA::debug("Config file was changed by test: {$folder} {$file}", PEAR_LOG_DEBUG);
        }
        TestRunner::teardownEnv($layer);
    }

    /**
     * A private method to create the test name for display.
     *
     * @access private
     * @param string $layer  The name of a layer group to run.
     * @param string $folder The folder group to run, not including "tests/unit". Optional.
     * @param string $file   The file to run, including ".test.php". Optional.
     * @return string The display string for the test.
     */
    public function _testName($layer, $folder = null, $file = null)
    {
        $type = $GLOBALS['_MAX']['TEST']['test_type'];
        $name = strtoupper($type) . ': ';
        $name .= $GLOBALS['_MAX']['TEST'][$type . '_layers'][$layer][0];
        if (is_null($folder) && is_null($file)) {
            $name .= ' Tests';
        } elseif (!is_null($folder) && is_null($file)) {
            $name .= ': Tests in ' . $folder;
        } elseif (!is_null($folder) && !is_null($file)) {
            $name .= ': ' . $folder . '/' . $file;
        }
        return $name;
    }

    /**
     * A private method to determine if a secondary test name for
     * the tests is needed.
     *
     * @access private
     * @param string $layer  The name of a layer group to run.
     * @return string The secondary display string for the test.
     */
    public function _secondaryTestName($layer)
    {
        $type = $GLOBALS['_MAX']['TEST']['test_type'];
        $runType = $GLOBALS['_MAX']['TEST'][$type . '_layers'][$layer][1];
        if ($runType !== NO_DB) {
            $aConf = $GLOBALS['_MAX']['CONF'];
            $oDbh = OA_DB::singleton();
            $query = "SELECT VERSION() AS version";
            $aRow = $oDbh->queryRow($query);
            $version = 'UNKNOWN!';
            if (!PEAR::isError($aRow)) {
                if (preg_match('/(\S*( ([0-9]|\.)*)?)/ ', $aRow['version'], $aMatches)) {
                    $version = $aMatches[0];
                }
                if ($aConf['database']['type'] == 'mysql' || $aConf['database']['type'] == 'mysqli') {
                    $version .= ' using ' . $aConf['table']['type'];
                }
            }
            return 'Database: ' . $aConf['database']['type'] . ' (' . $version . ') on  ' . $aConf['database']['host'];
        } else {
            return '';
        }
    }

    /**
     * A method to set up the environment based on
     * the layer the test/s is/are in.
     *
     * @param string $layer The layer the test/s is/are in.
     * @param bool $keepDatabase True if the dabase needs to be preserved.
     */
    public static function setupEnv($layer, $keepDatabase = false)
    {
        if (is_null($layer)) {
            $layer = $_GET['layer'];
        }
        $type = $GLOBALS['_MAX']['TEST']['test_type'];
        $envType = $GLOBALS['_MAX']['TEST'][$type . '_layers'][$layer][1];
        // Ensure the config file is fresh
        TestEnv::restoreConfig();
        // Tear down the database, if needed
        if (!$keepDatabase) {
            TestEnv::teardownDB();
        }
        TestEnv::backupPluginSchemaFiles();
        // Setup the database, if needed
        if ($envType == DB_NO_TABLES) {
            TestEnv::setupDB($keepDatabase);
        } elseif ($envType == DB_WITH_TABLES) {
            TestEnv::setupDB($keepDatabase);
            TestEnv::setupCoreTables();
        } elseif ($envType == DB_WITH_DATA) {
            TestEnv::setupDB($keepDatabase);
            TestEnv::setupCoreTables();
            TestEnv::setupDefaultData();
        }
        // Store the layer in a global variable, so the environment
        // can be completely re-built during tests using the
        // TestEnv::restoreEnv() method
        $GLOBALS['_MAX']['TEST']['layerEnv'] = $layer;
    }

    /**
     * A method to tear down the environment based on
     * the layer the test/s is/are in.
     *
     * @param string $layer The layer the test/s is/are in.
     */
    public function teardownEnv($layer)
    {
        $type = $GLOBALS['_MAX']['TEST']['test_type'];
        $envType = $GLOBALS['_MAX']['TEST'][$type . '_layers'][$layer][1];
        if ($envType != NO_DB) {
            // Don't tear down the DB, it will be dropped at the next test execution
            //TestEnv::teardownDB();
            TestEnv::restorePluginSchemaFiles();
        }
    }

    /**
     * Populate default testing focus based on parameters.
     *
     * This implementation reads parameters from the command-line.
     *
     * @return void This method does not return a value.
     *
     * @todo Consider renaming this method to better express its intent.
     * @todo Deprecate the $_GET compatibility, moving $_GET parameter handling
     * to a subclass.
     */
    public function findDefaults()
    {
        $con = new Console_Getopt();
        $args = $con->readPHPArgv();
        array_shift($args);
        $options = $con->getopt2($args, [], ['format=', 'type=', 'level=', 'layer=', 'folder=', 'file=', 'dir=', 'host=']);
        if (PEAR::isError($options)) {
            PEAR::raiseError($args);
            die(254);
        }
        foreach ($options[0] as $option) {
            $name_with_dashes = $option[0];
            $name = str_replace('--', '', $name_with_dashes);
            $value = $option[1];
            switch ($name) {
                case 'format':
                    $this->output_format_name = $value;
                    break;
                case 'type':
                    $this->test_type_name = $value;
                    $GLOBALS['_MAX']['TEST']['test_type'] = $value;
                    break;
                case 'level':
                    $this->test_level_name = $value;
                    break;
                case 'folder':
                    $this->test_folder_name = $value;
                    break;
                case 'file':
                    $this->test_file_name = $value;
                    break;
                case 'host':
                    $this->host = $value;
                    break;
            }
            // For compatibility with legacy Web runner, pretend that commandline arguments came in through GET
            if (!isset($_GET[$name])) {
                $_GET[$name] = $value;
            }
        }
    }

    /**
     * @return SimpleReporter
     */
    public function createReporter()
    {
        $format = $this->output_format_name;
        switch ($format) {
            case 'xml': return new XmlReporter();
            case 'text': return new TextReporter();
            case 'html': return new HtmlReporter();
            case 'auto': return $this->_createDefaultReporter();
        }
        $error = new PEAR_Error("Only specific output formats are valid (xml, text and html).");
        PEAR::raiseError($error);
        die(254);
    }

    /**
     * @return SimpleReporter
     */
    public function _createDefaultReporter()
    {
        if (SimpleReporter::inCli()) {
            $reporter = new TextReporter();
        } else {
            $reporter = new HtmlReporter();
        }
        return $reporter;
    }

    /**
     * Run a test case (usually a group/suite) with the inferred reporter.
     *
     * @param SimpleTestCase $test_case
     * @return void    This method does not return a value.
     *                 Use hasFailures() to query status after running this.
     * @todo Stop creating an individual reporter for each run, in case a client
     * calls this method multiple times.
     */
    public function runCase($test_case)
    {
        $reporter = $this->createReporter();
        $test_case->run($reporter);
        $all_tests_passed = $reporter->getStatus();
        if (!$all_tests_passed) {
            $this->_failed_runs++;
        }
    }

    /**
     * @return bool True if this runner has seen any test failing.
     */
    public function hasFailures()
    {
        return $this->_failed_runs > 0;
    }

    public function exitWithCode()
    {
        TestEnv::removeBackupConfig();

        if ($this->hasFailures()) {
            exit(1); // non-zero signals execution failure to anyone running this script
        } else {
            exit(0); // the UNIX success code -- all-clear
        }
    }
}

function array_diff_assoc_recursive($array1, $array2)
{
    foreach ($array1 as $key => $value) {
        if (is_array($value)) {
            if (!isset($array2[$key])) {
                $difference[$key] = $value;
            } elseif (!is_array($array2[$key])) {
                $difference[$key] = $value;
            } else {
                $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                if ($new_diff != false) {
                    $difference[$key] = $new_diff;
                }
            }
        } elseif (!isset($array2[$key]) || $array2[$key] != $value) {
            $difference[$key] = $value;
        }
    }
    return !isset($difference) ? 0 : $difference;
}
