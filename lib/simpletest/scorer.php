<?php

/**
 *	base include file for SimpleTest
 *	@package	SimpleTest
 *	@subpackage	UnitTester
 */

/**#@+*/
require_once(__DIR__ . '/invoker.php');
/**#@-*/

/**
 *    Can recieve test events and display them. Display
 *    is achieved by making display methods available
 *    and visiting the incoming event.
 *	  @package SimpleTest
 *	  @subpackage UnitTester
 *    @abstract
 */
class SimpleScorer
{
    public $_passes = 0;
    public $_fails = 0;
    public $_exceptions = 0;
    public $_is_dry_run = false;

    /**
     *    Signals that the next evaluation will be a dry
     *    run. That is, the structure events will be
     *    recorded, but no tests will be run.
     *    @param boolean $is_dry        Dry run if true.
     */
    public function makeDry($is_dry = true)
    {
        $this->_is_dry_run = $is_dry;
    }

    /**
     *    The reporter has a veto on what should be run.
     *    @param string $test_case_name  name of test case.
     *    @param string $method          Name of test method.
     */
    public function shouldInvoke($test_case_name, $method)
    {
        return ! $this->_is_dry_run;
    }

    /**
     *    Can wrap the invoker in preperation for running
     *    a test.
     *    @param SimpleInvokerDecorator $invoker   Individual test runner.
     *    @return SimpleInvokerDecorator           Wrapped test runner.
     */
    public function createInvoker($invoker)
    {
        return $invoker;
    }

    /**
     *    Accessor for current status. Will be false
     *    if there have been any failures or exceptions.
     *    Used for command line tools.
     *    @return boolean        True if no failures.
     */
    public function getStatus()
    {
        return !($this->_exceptions + $this->_fails > 0);
    }

    /**
     *    Paints the start of a group test.
     *    @param string $test_name     Name of test or other label.
     *    @param integer $size         Number of test cases starting.
     */
    public function paintGroupStart($test_name, $size) {}

    /**
     *    Paints the end of a group test.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintGroupEnd($test_name) {}

    /**
     *    Paints the start of a test case.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintCaseStart($test_name) {}

    /**
     *    Paints the end of a test case.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintCaseEnd($test_name) {}

    /**
     *    Paints the start of a test method.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintMethodStart($test_name) {}

    /**
     *    Paints the end of a test method.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintMethodEnd($test_name) {}

    /**
     *    Increments the pass count.
     *    @param string $message        Message is ignored.
     */
    public function paintPass($message)
    {
        $this->_passes++;
    }

    /**
     *    Increments the fail count.
     *    @param string $message        Message is ignored.
     */
    public function paintFail($message)
    {
        $this->_fails++;
    }

    /**
     *    Deals with PHP 4 throwing an error.
     *    @param string $message    Text of error formatted by
     *                              the test case.
     */
    public function paintError($message)
    {
        $this->_exceptions++;
    }

    /**
     *    Deals with PHP 5 throwing an exception.
     *    @param Exception $exception    The actual exception thrown.
     */
    public function paintException($exception)
    {
        $this->_exceptions++;
    }

    /**
     *    Prints the message for skipping tests.
     *    @param string $message    Text of skip condition.
     */
    public function paintSkip($message) {}

    /**
     *    Accessor for the number of passes so far.
     *    @return integer       Number of passes.
     */
    public function getPassCount()
    {
        return $this->_passes;
    }

    /**
     *    Accessor for the number of fails so far.
     *    @return integer       Number of fails.
     */
    public function getFailCount()
    {
        return $this->_fails;
    }

    /**
     *    Accessor for the number of untrapped errors
     *    so far.
     *    @return integer       Number of exceptions.
     */
    public function getExceptionCount()
    {
        return $this->_exceptions;
    }

    /**
     *    Paints a simple supplementary message.
     *    @param string $message        Text to display.
     */
    public function paintMessage($message) {}

    /**
     *    Paints a formatted ASCII message such as a
     *    variable dump.
     *    @param string $message        Text to display.
     */
    public function paintFormattedMessage($message) {}

    /**
     *    By default just ignores user generated events.
     *    @param string $type        Event type as text.
     *    @param mixed $payload      Message or object.
     */
    public function paintSignal($type, $payload) {}
}

/**
 *    Recipient of generated test messages that can display
 *    page footers and headers. Also keeps track of the
 *    test nesting. This is the main base class on which
 *    to build the finished test (page based) displays.
 *	  @package SimpleTest
 *	  @subpackage UnitTester
 */
class SimpleReporter extends SimpleScorer
{
    public $_test_stack = [];
    public $_size = null;
    public $_progress = 0;

    /**
     *    Gets the formatter for variables and other small
     *    generic data items.
     *    @return SimpleDumper          Formatter.
     */
    public function getDumper()
    {
        return new SimpleDumper();
    }

    /**
     *    Paints the start of a group test. Will also paint
     *    the page header and footer if this is the
     *    first test. Will stash the size if the first
     *    start.
     *    @param string $test_name   Name of test that is starting.
     *    @param integer $size       Number of test cases starting.
     */
    public function paintGroupStart($test_name, $size)
    {
        $this->_size ??= $size;
        if (count($this->_test_stack) == 0) {
            $this->paintHeader($test_name);
        }
        $this->_test_stack[] = $test_name;
    }

    /**
     *    Paints the end of a group test. Will paint the page
     *    footer if the stack of tests has unwound.
     *    @param string $test_name   Name of test that is ending.
     *    @param integer $progress   Number of test cases ending.
     */
    public function paintGroupEnd($test_name)
    {
        array_pop($this->_test_stack);
        if (count($this->_test_stack) == 0) {
            $this->paintFooter($test_name);
        }
    }

    /**
     *    Paints the start of a test case. Will also paint
     *    the page header and footer if this is the
     *    first test. Will stash the size if the first
     *    start.
     *    @param string $test_name   Name of test that is starting.
     */
    public function paintCaseStart($test_name)
    {
        $this->_size ??= 1;
        if (count($this->_test_stack) == 0) {
            $this->paintHeader($test_name);
        }
        $this->_test_stack[] = $test_name;
    }

    /**
     *    Paints the end of a test case. Will paint the page
     *    footer if the stack of tests has unwound.
     *    @param string $test_name   Name of test that is ending.
     */
    public function paintCaseEnd($test_name)
    {
        $this->_progress++;
        array_pop($this->_test_stack);
        if (count($this->_test_stack) == 0) {
            $this->paintFooter($test_name);
        }
    }

    /**
     *    Paints the start of a test method.
     *    @param string $test_name   Name of test that is starting.
     */
    public function paintMethodStart($test_name)
    {
        $this->_test_stack[] = $test_name;
    }

    /**
     *    Paints the end of a test method. Will paint the page
     *    footer if the stack of tests has unwound.
     *    @param string $test_name   Name of test that is ending.
     */
    public function paintMethodEnd($test_name)
    {
        array_pop($this->_test_stack);
    }

    /**
     *    Paints the test document header.
     *    @param string $test_name     First test top level
     *                                 to start.
     *    @abstract
     */
    public function paintHeader($test_name) {}

    /**
     *    Paints the test document footer.
     *    @param string $test_name        The top level test.
     *    @abstract
     */
    public function paintFooter($test_name) {}

    /**
     *    Accessor for internal test stack. For
     *    subclasses that need to see the whole test
     *    history for display purposes.
     *    @return array     List of methods in nesting order.
     */
    public function getTestList()
    {
        return $this->_test_stack;
    }

    /**
     *    Accessor for total test size in number
     *    of test cases. Null until the first
     *    test is started.
     *    @return integer   Total number of cases at start.
     */
    public function getTestCaseCount()
    {
        return $this->_size;
    }

    /**
     *    Accessor for the number of test cases
     *    completed so far.
     *    @return integer   Number of ended cases.
     */
    public function getTestCaseProgress()
    {
        return $this->_progress;
    }

    /**
     *    Static check for running in the comand line.
     *    @return boolean        True if CLI.
     */
    public static function inCli()
    {
        return php_sapi_name() == 'cli';
    }
}

/**
 *    For modifying the behaviour of the visual reporters.
 *	  @package SimpleTest
 *	  @subpackage UnitTester
 */
class SimpleReporterDecorator
{
    public $_reporter;

    /**
     *    Mediates between the reporter and the test case.
     *    @param SimpleScorer $reporter       Reporter to receive events.
     */
    public function __construct(&$reporter)
    {
        $this->_reporter = $reporter;
    }

    /**
     *    Signals that the next evaluation will be a dry
     *    run. That is, the structure events will be
     *    recorded, but no tests will be run.
     *    @param boolean $is_dry        Dry run if true.
     */
    public function makeDry($is_dry = true)
    {
        $this->_reporter->makeDry($is_dry);
    }

    /**
     *    Accessor for current status. Will be false
     *    if there have been any failures or exceptions.
     *    Used for command line tools.
     *    @return boolean        True if no failures.
     */
    public function getStatus()
    {
        return $this->_reporter->getStatus();
    }

    /**
     *    The reporter has a veto on what should be run.
     *    @param string $test_case_name  name of test case.
     *    @param string $method          Name of test method.
     *    @return boolean                True if test should be run.
     */
    public function shouldInvoke($test_case_name, $method)
    {
        return $this->_reporter->shouldInvoke($test_case_name, $method);
    }

    /**
     *    Can wrap the invoker in preperation for running
     *    a test.
     *    @param SimpleInvoker $invoker   Individual test runner.
     *    @return SimpleInvoker           Wrapped test runner.
     */
    public function createInvoker(&$invoker)
    {
        return $this->_reporter->createInvoker($invoker);
    }

    /**
     *    Gets the formatter for variables and other small
     *    generic data items.
     *    @return SimpleDumper          Formatter.
     */
    public function getDumper()
    {
        return $this->_reporter->getDumper();
    }

    /**
     *    Paints the start of a group test.
     *    @param string $test_name     Name of test or other label.
     *    @param integer $size         Number of test cases starting.
     */
    public function paintGroupStart($test_name, $size)
    {
        $this->_reporter->paintGroupStart($test_name, $size);
    }

    /**
     *    Paints the end of a group test.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintGroupEnd($test_name)
    {
        $this->_reporter->paintGroupEnd($test_name);
    }

    /**
     *    Paints the start of a test case.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintCaseStart($test_name)
    {
        $this->_reporter->paintCaseStart($test_name);
    }

    /**
     *    Paints the end of a test case.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintCaseEnd($test_name)
    {
        $this->_reporter->paintCaseEnd($test_name);
    }

    /**
     *    Paints the start of a test method.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintMethodStart($test_name)
    {
        $this->_reporter->paintMethodStart($test_name);
    }

    /**
     *    Paints the end of a test method.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintMethodEnd($test_name)
    {
        $this->_reporter->paintMethodEnd($test_name);
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message        Message is ignored.
     */
    public function paintPass($message)
    {
        $this->_reporter->paintPass($message);
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message        Message is ignored.
     */
    public function paintFail($message)
    {
        $this->_reporter->paintFail($message);
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message    Text of error formatted by
     *                              the test case.
     */
    public function paintError($message)
    {
        $this->_reporter->paintError($message);
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param Exception $exception        Exception to show.
     */
    public function paintException($exception)
    {
        $this->_reporter->paintException($exception);
    }

    /**
     *    Prints the message for skipping tests.
     *    @param string $message    Text of skip condition.
     */
    public function paintSkip($message)
    {
        $this->_reporter->paintSkip($message);
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message        Text to display.
     */
    public function paintMessage($message)
    {
        $this->_reporter->paintMessage($message);
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message        Text to display.
     */
    public function paintFormattedMessage($message)
    {
        $this->_reporter->paintFormattedMessage($message);
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $type        Event type as text.
     *    @param mixed $payload      Message or object.
     *    @return boolean            Should return false if this
     *                               type of signal should fail the
     *                               test suite.
     */
    public function paintSignal($type, &$payload)
    {
        $this->_reporter->paintSignal($type, $payload);
    }
}

/**
 *    For sending messages to multiple reporters at
 *    the same time.
 *	  @package SimpleTest
 *	  @subpackage UnitTester
 */
class MultipleReporter
{
    public $_reporters = [];

    /**
     *    Adds a reporter to the subscriber list.
     *    @param SimpleScorer $reporter     Reporter to receive events.
     */
    public function attachReporter(&$reporter)
    {
        $this->_reporters[] = $reporter;
    }

    /**
     *    Signals that the next evaluation will be a dry
     *    run. That is, the structure events will be
     *    recorded, but no tests will be run.
     *    @param boolean $is_dry        Dry run if true.
     */
    public function makeDry($is_dry = true)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->makeDry($is_dry);
        }
    }

    /**
     *    Accessor for current status. Will be false
     *    if there have been any failures or exceptions.
     *    If any reporter reports a failure, the whole
     *    suite fails.
     *    @return boolean        True if no failures.
     */
    public function getStatus()
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            if (! $this->_reporters[$i]->getStatus()) {
                return false;
            }
        }
        return true;
    }

    /**
     *    The reporter has a veto on what should be run.
     *    It requires all reporters to want to run the method.
     *    @param string $test_case_name  name of test case.
     *    @param string $method          Name of test method.
     */
    public function shouldInvoke($test_case_name, $method)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            if (! $this->_reporters[$i]->shouldInvoke($test_case_name, $method)) {
                return false;
            }
        }
        return true;
    }

    /**
     *    Every reporter gets a chance to wrap the invoker.
     *    @param SimpleInvoker $invoker   Individual test runner.
     *    @return SimpleInvoker           Wrapped test runner.
     */
    public function createInvoker(&$invoker)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $invoker = $this->_reporters[$i]->createInvoker($invoker);
        }
        return $invoker;
    }

    /**
     *    Gets the formatter for variables and other small
     *    generic data items.
     *    @return SimpleDumper          Formatter.
     */
    public function getDumper()
    {
        return new SimpleDumper();
    }

    /**
     *    Paints the start of a group test.
     *    @param string $test_name     Name of test or other label.
     *    @param integer $size         Number of test cases starting.
     */
    public function paintGroupStart($test_name, $size)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintGroupStart($test_name, $size);
        }
    }

    /**
     *    Paints the end of a group test.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintGroupEnd($test_name)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintGroupEnd($test_name);
        }
    }

    /**
     *    Paints the start of a test case.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintCaseStart($test_name)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintCaseStart($test_name);
        }
    }

    /**
     *    Paints the end of a test case.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintCaseEnd($test_name)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintCaseEnd($test_name);
        }
    }

    /**
     *    Paints the start of a test method.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintMethodStart($test_name)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintMethodStart($test_name);
        }
    }

    /**
     *    Paints the end of a test method.
     *    @param string $test_name     Name of test or other label.
     */
    public function paintMethodEnd($test_name)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintMethodEnd($test_name);
        }
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message        Message is ignored.
     */
    public function paintPass($message)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintPass($message);
        }
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message        Message is ignored.
     */
    public function paintFail($message)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintFail($message);
        }
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message    Text of error formatted by
     *                              the test case.
     */
    public function paintError($message)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintError($message);
        }
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param Exception $exception    Exception to display.
     */
    public function paintException($exception)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintException($exception);
        }
    }

    /**
     *    Prints the message for skipping tests.
     *    @param string $message    Text of skip condition.
     */
    public function paintSkip($message)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintSkip($message);
        }
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message        Text to display.
     */
    public function paintMessage($message)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintMessage($message);
        }
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $message        Text to display.
     */
    public function paintFormattedMessage($message)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintFormattedMessage($message);
        }
    }

    /**
     *    Chains to the wrapped reporter.
     *    @param string $type        Event type as text.
     *    @param mixed $payload      Message or object.
     *    @return boolean            Should return false if this
     *                               type of signal should fail the
     *                               test suite.
     */
    public function paintSignal($type, &$payload)
    {
        for ($i = 0; $i < count($this->_reporters); $i++) {
            $this->_reporters[$i]->paintSignal($type, $payload);
        }
    }
}
