<?php
    /**
     *	Global state for SimpleTest and kicker script in future versions.
     *	@package	SimpleTest
     *	@subpackage	UnitTester
     */

    /**#@+
     * include SimpleTest files
     */

    if (PHP_VERSION_ID >= 80000) {
        require_once(__DIR__ . '/reflection_php8.php');
    } else {
        require_once(__DIR__ . '/reflection_php5.php');
    }

    /**#@-*/

    /**
     *    Registry and test context. Includes a few
     *    global options that I'm slowly getting rid of.
     *	  @package	SimpleTest
     */
    class SimpleTest {

        /**
         *    Reads the SimpleTest version from the release file.
         *    @return string        Version string.
         *    @static
         *    @access public
         */
        function getVersion() {
            $content = file(dirname(__FILE__) . '/VERSION');
            return trim($content[0]);
        }

        /**
         *    Sets the name of a test case to ignore, usually
         *    because the class is an abstract case that should
         *    not be run. Once PHP4 is dropped this will disappear
         *    as a public method and "abstract" will rule.
         *    @param string $class        Add a class to ignore.
         */
        public static function ignore($class) {
            $registry =& self::_getRegistry();
            $registry['IgnoreList'][strtolower($class)] = true;
        }

        /**
         *    Scans the now complete ignore list, and adds
         *    all parent classes to the list. If a class
         *    is not a runnable test case, then it's parents
         *    wouldn't be either. This is syntactic sugar
         *    to cut down on ommissions of ignore()'s or
         *    missing abstract declarations. This cannot
         *    be done whilst loading classes wiithout forcing
         *    a particular order on the class declarations and
         *    the ignore() calls. It's just nice to have the ignore()
         *    calls at the top of the file before the actual declarations.
         *    @param array $classes     Class names of interest.
         */
        public static function ignoreParentsIfIgnored($classes) {
            foreach ($classes as $class) {
                if (SimpleTest::isIgnored($class)) {
                    $reflection = new SimpleReflection($class);
                    if ($parent = $reflection->getParent()) {
                        SimpleTest::ignore($parent);
                    }
                }
            }
        }

        /**
         *    Test to see if a test case is in the ignore
         *    list. Quite obviously the ignore list should
         *    be a separate object and will be one day.
         *    This method is internal to SimpleTest. Don't
         *    use it.
         *    @param string $class        Class name to test.
         *    @return boolean             True if should not be run.
         */
        public static function isIgnored($class) {
            $registry = self::_getRegistry();
            return isset($registry['IgnoreList'][strtolower($class)]);
        }

        /**
         *    @deprecated
         */
        public static function setMockBaseClass($mock_base) {
            $registry = self::_getRegistry();
            $registry['MockBaseClass'] = $mock_base;
        }

        /**
         *    @deprecated
         */
        public static function getMockBaseClass() {
            $registry = self::_getRegistry();
            return $registry['MockBaseClass'];
        }

        /**
         *    Sets proxy to use on all requests for when
         *    testing from behind a firewall. Set host
         *    to false to disable. This will take effect
         *    if there are no other proxy settings.
         *    @param string $proxy     Proxy host as URL.
         *    @param string $username  Proxy username for authentication.
         *    @param string $password  Proxy password for authentication.
         */
        public static function useProxy($proxy, $username = false, $password = false) {
            $registry =& self::_getRegistry();
            $registry['DefaultProxy'] = $proxy;
            $registry['DefaultProxyUsername'] = $username;
            $registry['DefaultProxyPassword'] = $password;
        }

        /**
         *    Accessor for default proxy host.
         *    @return string       Proxy URL.
         *    @access public
         */
        public static function getDefaultProxy() {
            $registry = self::_getRegistry();
            return $registry['DefaultProxy'];
        }

        /**
         *    Accessor for default proxy username.
         *    @return string    Proxy username for authentication.
         *    @access public
         */
        public static function getDefaultProxyUsername() {
            $registry = self::_getRegistry();
            return $registry['DefaultProxyUsername'];
        }

        /**
         *    Accessor for default proxy password.
         *    @return string    Proxy password for authentication.
         *    @access public
         */
        public static function getDefaultProxyPassword() {
            $registry = self::_getRegistry();
            return $registry['DefaultProxyPassword'];
        }

        /**
         *    Accessor for global registry of options.
         *    @return array           All stored values.
         */
        private static function &_getRegistry() {
            static $registry = false;
            if (! $registry) {
                $registry = self::_getDefaults();
            }
            return $registry;
        }

        /**
         *    Accessor for the context of the current
         *    test run.
         *    @return SimpleTestContext    Current test run.
         */
        public static function getContext() {
            static $context = false;
            if (! $context) {
                $context = new SimpleTestContext();
            }
            return $context;
        }

        /**
         *    Constant default values.
         *    @return array       All registry defaults.
         *    @access private
         *    @static
         */
        private static function _getDefaults() {
            return array(
                    'StubBaseClass' => 'SimpleStub',
                    'MockBaseClass' => 'SimpleMock',
                    'IgnoreList' => array(),
                    'DefaultProxy' => false,
                    'DefaultProxyUsername' => false,
                    'DefaultProxyPassword' => false);
        }
    }

    /**
     *    Container for all components for a specific
     *    test run. Makes things like error queues
     *    available to PHP event handlers, and also
     *    gets around some nasty reference issues in
     *    the mocks.
     *	  @package	SimpleTest
     */
    class SimpleTestContext {
        var $_test;
        var $_reporter;
        var $_resources;

        /**
         *    Clears down the current context.
         *    @access public
         */
        function clear() {
            $this->_resources = array();
        }

        /**
         *    Sets the current test case instance. This
         *    global instance can be used by the mock objects
         *    to send message to the test cases.
         *    @param SimpleTestCase $test        Test case to register.
         *    @access public
         */
        function setTest(&$test) {
            $this->clear();
            $this->_test = &$test;
        }

        /**
         *    Accessor for currently running test case.
         *    @return SimpleTestCase    Current test.
         *    @acess pubic
         */
        function &getTest() {
            return $this->_test;
        }

        /**
         *    Sets the current reporter. This
         *    global instance can be used by the mock objects
         *    to send messages.
         *    @param SimpleReporter $reporter     Reporter to register.
         *    @access public
         */
        function setReporter(&$reporter) {
            $this->clear();
            $this->_reporter = &$reporter;
        }

        /**
         *    Accessor for current reporter.
         *    @return SimpleReporter    Current reporter.
         *    @acess pubic
         */
        function &getReporter() {
            return $this->_reporter;
        }

        /**
         *    Accessor for the Singleton resource.
         *    @return object       Global resource.
         *    @access public
         *    @static
         */
        function &get($resource) {
            if (! isset($this->_resources[$resource])) {
                $this->_resources[$resource] = new $resource();
            }
            return $this->_resources[$resource];
        }
    }

    /**
     *    Interrogates the stack trace to recover the
     *    failure point.
	 *	  @package SimpleTest
	 *	  @subpackage UnitTester
     */
    class SimpleStackTrace {
        var $_prefixes;

        /**
         *    Stashes the list of target prefixes.
         *    @param array $prefixes      List of method prefixes
         *                                to search for.
         */
        function __construct($prefixes) {
            $this->_prefixes = $prefixes;
        }

        /**
         *    Extracts the last method name that was not within
         *    Simpletest itself. Captures a stack trace if none given.
         *    @param array $stack      List of stack frames.
         *    @return string           Snippet of test report with line
         *                             number and file.
         *    @access public
         */
        function traceMethod($stack = false) {
            $stack = $stack ? $stack : $this->_captureTrace();
            foreach ($stack as $frame) {
                if ($this->_frameLiesWithinSimpleTestFolder($frame)) {
                    continue;
                }
                if ($this->_frameMatchesPrefix($frame)) {
                    return ' at [' . $frame['file'] . ' line ' . $frame['line'] . ']';
                }
            }
            return '';
        }

        /**
         *    Test to see if error is generated by SimpleTest itself.
         *    @param array $frame     PHP stack frame.
         *    @return boolean         True if a SimpleTest file.
         *    @access private
         */
        function _frameLiesWithinSimpleTestFolder($frame) {
            if (isset($frame['file'])) {
                $path = substr(SIMPLE_TEST, 0, -1);
                if (strpos($frame['file'], $path) === 0) {
                    if (dirname($frame['file']) == $path) {
                        return true;
                    }
                }
            }
            return false;
        }

        /**
         *    Tries to determine if the method call is an assert, etc.
         *    @param array $frame     PHP stack frame.
         *    @return boolean         True if matches a target.
         *    @access private
         */
        function _frameMatchesPrefix($frame) {
            foreach ($this->_prefixes as $prefix) {
                if (strncmp($frame['function'], $prefix, strlen($prefix)) == 0) {
                    return true;
                }
            }
            return false;
        }

        /**
         *    Grabs a current stack trace.
         *    @return array        Fulle trace.
         *    @access private
         */
        function _captureTrace() {
            if (function_exists('debug_backtrace')) {
                return array_reverse(debug_backtrace());
            }
            return array();
        }
    }

    /**
     *    @deprecated
     */
    class SimpleTestOptions extends SimpleTest {

        /**
         *    @deprecated
         */
        function getVersion() {
            return Simpletest::getVersion();
        }

        /**
         *    @deprecated
         */
        public static function ignore($class) {
            parent::ignore($class);
        }

        /**
         *    @deprecated
         */
        public static function isIgnored($class) {
            return parent::isIgnored($class);
        }

        /**
         *    @deprecated
         */
        public static function setMockBaseClass($mock_base) {
            parent::setMockBaseClass($mock_base);
        }

        /**
         *    @deprecated
         */
        public static function getMockBaseClass() {
            return parent::getMockBaseClass();
        }

        /**
         *    @deprecated
         */
        public static function useProxy($proxy, $username = false, $password = false) {
            Simpletest::useProxy($proxy, $username, $password);
        }

        /**
         *    @deprecated
         */
        public static function getDefaultProxy() {
            return Simpletest::getDefaultProxy();
        }

        /**
         *    @deprecated
         */
        public static function getDefaultProxyUsername() {
            return Simpletest::getDefaultProxyUsername();
        }

        /**
         *    @deprecated
         */
        public static function getDefaultProxyPassword() {
            return Simpletest::getDefaultProxyPassword();
        }
    }
?>
