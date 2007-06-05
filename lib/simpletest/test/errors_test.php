<?php
    require_once(dirname(__FILE__) . '/../errors.php');
    require_once(dirname(__FILE__) . '/../expectation.php');
    require_once(dirname(__FILE__) . '/../test_case.php');
    Mock::generate('SimpleTestCase');
    Mock::generate('SimpleExpectation');

    class TestOfErrorQueue extends UnitTestCase {

        function setUp() {
            $context = &SimpleTest::getContext();
            $queue = &$context->get('SimpleErrorQueue');
            $queue->clear();
        }

        function tearDown() {
            $context = &SimpleTest::getContext();
            $queue = &$context->get('SimpleErrorQueue');
            $queue->clear();
        }

        function testOrder() {
            $context = &SimpleTest::getContext();
            $queue = &$context->get('SimpleErrorQueue');
            $queue->add(1024, 'Ouch', 'here.php', 100);
            $queue->add(512, 'Yuk', 'there.php', 101);
            $this->assertEqual(
                    $queue->extract(),
                    array(1024, 'Ouch', 'here.php', 100));
            $this->assertEqual(
                    $queue->extract(),
                    array(512, 'Yuk', 'there.php', 101));
            $this->assertFalse($queue->extract());
        }

        function testAssertNoErrorsGivesTrueWhenNoErrors() {
            $test = &new MockSimpleTestCase();
            $test->expectOnce('assert', array(new TrueExpectation(), true, 'Should be no errors'));
            $test->setReturnValue('assert', true);
            $queue = &new SimpleErrorQueue();
            $queue->setTestCase($test);
            $this->assertTrue($queue->assertNoErrors('%s'));
        }

        function testAssertNoErrorsIssuesFailWhenErrors() {
            $test = &new MockSimpleTestCase();
            $test->expectOnce('assert', array(new TrueExpectation(), false, 'Should be no errors'));
            $test->setReturnValue('assert', false);
            $queue = &new SimpleErrorQueue();
            $queue->setTestCase($test);
            $queue->add(1024, 'Ouch', 'here.php', 100);
            $this->assertFalse($queue->assertNoErrors('%s'));
        }

        function testAssertErrorFailsWhenNoError() {
            $test = &new MockSimpleTestCase();
            $test->expectOnce('fail', array('Expected error not found'));
            $test->setReturnValue('assert', false);
            $queue = &new SimpleErrorQueue();
            $queue->setTestCase($test);
            $this->assertFalse($queue->assertError(false, '%s'));
        }

        function testAssertErrorFailsWhenErrorDoesntMatch() {
            $test = &new MockSimpleTestCase();
            $test->expectOnce('assert', array(
                    new MockSimpleExpectation(),
                    'B',
                    'Expected PHP error [B] severity [E_USER_NOTICE] in [b.php] line [100]'));
            $test->setReturnValue('assert', false);
            $queue = &new SimpleErrorQueue();
            $queue->setTestCase($test);
            $queue->add(1024, 'B', 'b.php', 100);
            $this->assertFalse($queue->assertError(new MockSimpleExpectation(), '%s'));
        }

        function testExpectationMatchCancelsIncomingError() {
            $test = &new MockSimpleTestCase();
            $test->expectOnce('assert', array(new MockSimpleExpectation(), 'B', 'a message'));
            $test->setReturnValue('assert', true);
            $test->expectNever('error');
            $queue = &new SimpleErrorQueue();
            $queue->setTestCase($test);
            $queue->expectError(new MockSimpleExpectation(), 'a message');
            $queue->add(1024, 'B', 'b.php', 100);
        }

        function testExpectationMissTriggersError() {
            $test = &new MockSimpleTestCase();
            $test->expectOnce('assert', array(new MockSimpleExpectation(), 'B', 'a message'));
            $test->setReturnValue('assert', false);
            $test->expectOnce('error');
            $queue = &new SimpleErrorQueue();
            $queue->setTestCase($test);
            $queue->expectError(new MockSimpleExpectation(), 'a message');
            $queue->add(1024, 'B', 'b.php', 100);
        }
    }

    class TestOfErrorTrap extends UnitTestCase {
        var $_old;

        function setUp() {
            $this->_old = error_reporting(E_ALL);
            set_error_handler('SimpleTestErrorHandler');
        }

        function tearDown() {
            restore_error_handler();
            error_reporting($this->_old);
        }

        function testQueueStartsEmpty() {
            $context = &SimpleTest::getContext();
            $queue = &$context->get('SimpleErrorQueue');
            $this->assertFalse($queue->extract());
        }

        function testTrappedErrorPlacedInQueue() {
            trigger_error('Ouch!');
            $context = &SimpleTest::getContext();
            $queue = &$context->get('SimpleErrorQueue');
            list($severity, $message, $file, $line) = $queue->extract();
            $this->assertEqual($message, 'Ouch!');
            $this->assertEqual($file, __FILE__);
            $this->assertFalse($queue->extract());
        }

        function testErrorsAreSwallowedByMatchingExpectation() {
            $this->expectError('Ouch!');
            trigger_error('Ouch!');
        }

        function testErrorsAreSwallowedInOrder() {
            $this->expectError('a');
            $this->expectError('b');
            trigger_error('a');
            trigger_error('b');
        }

        function testAnyErrorCanBeSwallowed() {
            $this->expectError();
            trigger_error('Ouch!');
        }

        function testErrorCanBeSwallowedByPatternMatching() {
            $this->expectError(new PatternExpectation('/ouch/i'));
            trigger_error('Ouch!');
        }
		
		/*
		 * Regression Test for Error messages producing
		 * sprintf errors if they contain standalone % char
		 */
		function testErrorWithPercentsPassesWithNoSprintfError()
		{
			$this->expectError("%");
			trigger_error('%');
		}
    }

    class TestOfErrors extends UnitTestCase {
        var $_old;

        function setUp() {
            $this->_old = error_reporting(E_ALL);
        }

        function tearDown() {
            error_reporting($this->_old);
        }

        function testDefaultWhenAllReported() {
            error_reporting(E_ALL);
            trigger_error('Ouch!');
            $this->assertError('Ouch!');
        }

        function testNoticeWhenReported() {
            error_reporting(E_ALL);
            trigger_error('Ouch!', E_USER_NOTICE);
            $this->assertError('Ouch!');
        }

        function testWarningWhenReported() {
            error_reporting(E_ALL);
            trigger_error('Ouch!', E_USER_WARNING);
            $this->assertError('Ouch!');
        }

        function testErrorWhenReported() {
            error_reporting(E_ALL);
            trigger_error('Ouch!', E_USER_ERROR);
            $this->assertError('Ouch!');
        }

        function testNoNoticeWhenNotReported() {
            error_reporting(0);
            trigger_error('Ouch!', E_USER_NOTICE);
        }

        function testNoWarningWhenNotReported() {
            error_reporting(0);
            trigger_error('Ouch!', E_USER_WARNING);
        }

        function testNoErrorWhenNotReported() {
            error_reporting(0);
            trigger_error('Ouch!', E_USER_ERROR);
        }

        function testNoticeSuppressedWhenReported() {
            error_reporting(E_ALL);
            @trigger_error('Ouch!', E_USER_NOTICE);
        }

        function testWarningSuppressedWhenReported() {
            error_reporting(E_ALL);
            @trigger_error('Ouch!', E_USER_WARNING);
        }

        function testErrorSuppressedWhenReported() {
            error_reporting(E_ALL);
            @trigger_error('Ouch!', E_USER_ERROR);
        }

		/*
		 * Regression Test for Error messages producing
		 * sprintf errors if they contain standalone % char
		 */
		function testErrorWithPercentsReportedWithNoSprintfError()
		{
			trigger_error('%');
			$this->assertError('%');
		}
    }
// TODO: Add stacked error handler test
?>