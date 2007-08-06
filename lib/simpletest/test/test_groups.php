<?php
    // $Id$
    require_once(dirname(__FILE__) . '/../unit_tester.php');
    require_once(dirname(__FILE__) . '/../shell_tester.php');
    require_once(dirname(__FILE__) . '/../mock_objects.php');
    require_once(dirname(__FILE__) . '/../web_tester.php');
    require_once(dirname(__FILE__) . '/../extensions/pear_test_case.php');
    require_once(dirname(__FILE__) . '/../extensions/phpunit_test_case.php');

    class UnitTests extends TestSuite {
        function UnitTests() {
            $this->TestSuite('Unit tests');
            $path = dirname(__FILE__);
            $this->addTestFile($path . '/errors_test.php');
            if (version_compare(phpversion(), '5') >= 0) {
                $this->addTestFile($path . '/exceptions_test.php');
            }
            $this->addTestFile($path . '/compatibility_test.php');
            $this->addTestFile($path . '/simpletest_test.php');
            $this->addTestFile($path . '/dumper_test.php');
            $this->addTestFile($path . '/expectation_test.php');
            $this->addTestFile($path . '/unit_tester_test.php');
            if (version_compare(phpversion(), '5', '>=')) {
                $this->addTestFile($path . '/reflection_php5_test.php');
            } else {
                $this->addTestFile($path . '/reflection_php4_test.php');
            }
            $this->addTestFile($path . '/mock_objects_test.php');
            if (version_compare(phpversion(), '5', '>=')) {
                $this->addTestFile($path . '/interfaces_test.php');
            }
            $this->addTestFile($path . '/collector_test.php');
            $this->addTestFile($path . '/adapter_test.php');
            $this->addTestFile($path . '/socket_test.php');
            $this->addTestFile($path . '/encoding_test.php');
            $this->addTestFile($path . '/url_test.php');
            $this->addTestFile($path . '/cookies_test.php');
            $this->addTestFile($path . '/http_test.php');
            $this->addTestFile($path . '/authentication_test.php');
            $this->addTestFile($path . '/user_agent_test.php');
            $this->addTestFile($path . '/parser_test.php');
            $this->addTestFile($path . '/tag_test.php');
            $this->addTestFile($path . '/form_test.php');
            $this->addTestFile($path . '/page_test.php');
            $this->addTestFile($path . '/frames_test.php');
            $this->addTestFile($path . '/browser_test.php');
            $this->addTestFile($path . '/web_tester_test.php');
            $this->addTestFile($path . '/shell_tester_test.php');
            $this->addTestFile($path . '/xml_test.php');
        }
    }

    // Uncomment and modify the following line if you are accessing
    // the net via a proxy server.
    //
    // SimpleTest::useProxy('http://my-proxy', 'optional username', 'optional password');

    class AllTests extends TestSuite {
        function AllTests() {
            $this->TestSuite('All tests for SimpleTest ' . SimpleTest::getVersion());
            $this->addTestCase(new UnitTests());
            $this->addTestFile(dirname(__FILE__) . '/shell_test.php');
            $this->addTestFile(dirname(__FILE__) . '/live_test.php');
            $this->addTestFile(dirname(__FILE__) . '/acceptance_test.php');
        }
    }
?>