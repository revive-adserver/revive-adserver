<?php

/**
 *	base include file for SimpleTest
 *	@package	SimpleTest
 *	@subpackage	UnitTester
 */

/**#@+
 * Includes SimpleTest files.
 */
require_once(__DIR__ . '/invoker.php');
require_once(__DIR__ . '/test_case.php');
require_once(__DIR__ . '/expectation.php');

/**
 *    Extension that traps errors into an error queue.
 *	  @package SimpleTest
 *	  @subpackage UnitTester
 */
class SimpleErrorTrappingInvoker extends SimpleInvokerDecorator
{
    /**
     *    Invokes a test method and dispatches any
     *    untrapped errors. Called back from
     *    the visiting runner.
     *    @param string $method    Test method to call.
     */
    public function invoke($method)
    {
        $context = SimpleTest::getContext();
        $queue = $context->get('SimpleErrorQueue');
        $queue->setTestCase($this->GetTestCase());
        set_error_handler(SimpleTestErrorHandler(...));
        parent::invoke($method);
        while ($res = $queue->extract()) {
            [$severity, $message, $file, $line] = $res;
            $severity = SimpleErrorQueue::getSeverityAsString($severity);
            $test = $this->getTestCase();
            $test->error($severity, $message, $file, $line);
        }
        restore_error_handler();
    }
}

/**
 *    Singleton error queue used to record trapped
 *    errors.
 *	  @package	SimpleTest
 *	  @subpackage	UnitTester
 */
class SimpleErrorQueue
{
    private const MAP = [
        E_ERROR => 'E_ERROR',
        E_WARNING => 'E_WARNING',
        E_PARSE => 'E_PARSE',
        E_NOTICE => 'E_NOTICE',
        E_CORE_ERROR => 'E_CORE_ERROR',
        E_CORE_WARNING => 'E_CORE_WARNING',
        E_COMPILE_ERROR => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING => 'E_COMPILE_WARNING',
        E_USER_ERROR => 'E_USER_ERROR',
        E_USER_WARNING => 'E_USER_WARNING',
        E_USER_NOTICE => 'E_USER_NOTICE',
        E_DEPRECATED => 'E_DEPRECATED',
        E_USER_DEPRECATED => 'E_USER_DEPRECATED',
        2048 => 'E_STRICT', // Using value, deprecated since PHP 8.4
    ];

    public $_queue;
    public $_expectation_queue;
    public $_test;

    /**
     *    Starts with an empty queue.
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     *    Sets the currently running test case.
     *    @param SimpleTestCase $test    Test case to send messages to.
     */
    public function setTestCase($test)
    {
        $this->_test = $test;
    }

    /**
     *    Adds an error to the front of the queue.
     *    @param integer $severity       PHP error code.
     *    @param string $content         Text of error.
     *    @param string $filename        File error occoured in.
     *    @param integer $line           Line number of error.
     */
    public function add($severity, $content, $filename, $line)
    {
        $content = str_replace('%', '%%', $content);
        if (count($this->_expectation_queue)) {
            $this->_testLatestError($severity, $content, $filename, $line);
        } else {
            $this->_queue[] = [$severity, $content, $filename, $line];
        }
    }

    /**
     *    Tests the error against the most recent expected
     *    error.
     *    @param integer $severity       PHP error code.
     *    @param string $content         Text of error.
     *    @param string $filename        File error occoured in.
     *    @param integer $line           Line number of error.
     *    @access private
     */
    public function _testLatestError($severity, $content, $filename, $line)
    {
        [$expected, $message] = array_shift($this->_expectation_queue);
        $severity = static::getSeverityAsString($severity);
        $is_match = $this->_test->assert(
            $expected,
            $content,
            sprintf($message, "%s -> PHP error [$content] severity [$severity] in [$filename] line [$line]"),
        );
        if (! $is_match) {
            $this->_test->error($severity, $content, $filename, $line);
        }
    }

    /**
     *    Pulls the earliest error from the queue.
     *    @return     False if none, or a list of error
     *                information. Elements are: severity
     *                as the PHP error code, the error message,
     *                the file with the error, the line number
     *                and a list of PHP super global arrays.
     */
    public function extract()
    {
        if (count($this->_queue)) {
            return array_shift($this->_queue);
        }
        return false;
    }

    /**
     *    Discards the contents of the error queue.
     */
    public function clear()
    {
        $this->_queue = [];
        $this->_expectation_queue = [];
    }

    /**
     *    @deprecated
     */
    public function assertNoErrors($message)
    {
        return $this->_test->assert(
            new TrueExpectation(),
            count($this->_queue) == 0,
            sprintf($message, 'Should be no errors'),
        );
    }

    /**
     *    @deprecated
     */
    public function assertError($expected, $message)
    {
        if (count($this->_queue) == 0) {
            $this->_test->fail(sprintf($message, 'Expected error not found'));
            return false;
        }
        [$severity, $content, $file, $line] = $this->extract();
        $severity = static::getSeverityAsString($severity);
        return $this->_test->assert(
            $expected,
            $content,
            sprintf($message, "Expected PHP error [$content] severity [$severity] in [$file] line [$line]"),
        );
    }

    /**
     *    Sets up an expectation of an error. If this is
     *    not fulfilled at the end of the test, a failure
     *    will occour. If the error does happen, then this
     *    will cancel it out and send a pass message.
     *    @param SimpleExpectation $expected    Expected error match.
     *    @param string $message                Message to display.
     */
    public function expectError($expected, $message)
    {
        $this->_expectation_queue[] = [$expected, $message];
    }

    /**
     *    Converts an error code into it's string
     *    representation.
     *    @param string $severity  PHP integer error code.
     *    @return           String version of error code.
     */
    public static function getSeverityAsString($severity)
    {
        return self::MAP[$severity] ?? "Unknown E_* constant: $severity";
    }
}

/**
 *    Error handler that simply stashes any errors into the global
 *    error queue. Simulates the existing behaviour with respect to
 *    logging errors, but this feature may be removed in future.
 *    @param int $severity        PHP error code.
 *    @param string $message         Text of error.
 *    @param string $filename        File error occoured in.
 *    @param int $line            Line number of error.
 *    @param array $super_globals   Hash of PHP super global arrays.
 *    @static
 *    @access public
 */
function SimpleTestErrorHandler($severity, $message, $filename, $line, $super_globals = [])
{
    if ($severity & error_reporting()) {
        restore_error_handler();
        if (ini_get('log_errors')) {
            $label = SimpleErrorQueue::getSeverityAsString($severity);
            error_log("$label: $message in $filename on line $line");
        }
        $context = SimpleTest::getContext();
        $queue = $context->get('SimpleErrorQueue');
        $queue->add($severity, $message, $filename, $line);
        set_error_handler(SimpleTestErrorHandler(...));
    }
}
