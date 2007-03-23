package net.jsunit.test;

import junit.framework.TestCase;
import net.jsunit.TestCaseResult;
import net.jsunit.TestCaseResultWriter;
import org.jdom.Element;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestCaseResultTest extends TestCase {
    public TestCaseResultTest(String name) {
        super(name);
    }

    public void testBuildSuccessfulResultFromString() {
        TestCaseResult result = TestCaseResult.fromString("file:///dummy/path/dummyPage.html:testFoo|1.3|S||");
        assertEquals("file:///dummy/path/dummyPage.html:testFoo", result.getName());
        assertEquals(1.3d, result.getTime(), .001d);
        assertFalse(result.hadError());
        assertFalse(result.hadFailure());
        assertTrue(result.hadSuccess());
        assertNull(result.getError());
        assertNull(result.getFailure());
        assertEquals("<testcase name=\"file:///dummy/path/dummyPage.html:testFoo\" time=\"1.3\" />", result.writeXmlFragment());
    }

    public void testProblemSummary() {
        TestCaseResult result = TestCaseResult.fromString("file:///dummy/path/dummyPage.html:testFoo|1.3|E|Test Error Message|");
        assertEquals("file:///dummy/path/dummyPage.html:testFoo had an error:\nTest Error Message", result.writeProblemSummary());
    }

    public void testBuildErrorResultFromString() {
        TestCaseResult result = TestCaseResult.fromString("file:///dummy/path/dummyPage.html:testFoo|1.3|E|Test Error Message|");
        assertEquals("file:///dummy/path/dummyPage.html:testFoo", result.getName());
        assertEquals(1.3d, result.getTime(), .001d);
        assertTrue(result.hadError());
        assertFalse(result.hadFailure());
        assertFalse(result.hadSuccess());
        assertEquals("Test Error Message", result.getError());
        assertNull(result.getFailure());
        assertEquals("<testcase name=\"file:///dummy/path/dummyPage.html:testFoo\" time=\"1.3\"><error message=\"Test Error Message\" /></testcase>", result.writeXmlFragment());
    }

    public void testBuildFailureResultFromString() {
        TestCaseResult result = TestCaseResult.fromString("file:///dummy/path/dummyPage.html:testFoo|1.3|F|Test Failure Message|");
        assertEquals("file:///dummy/path/dummyPage.html:testFoo", result.getName());
        assertEquals(1.3d, result.getTime(), .001d);
        assertFalse(result.hadError());
        assertTrue(result.hadFailure());
        assertFalse(result.hadSuccess());
        assertNull(result.getError());
        assertEquals("Test Failure Message", result.getFailure());
        assertEquals("<testcase name=\"file:///dummy/path/dummyPage.html:testFoo\" time=\"1.3\"><failure message=\"Test Failure Message\" /></testcase>", result.writeXmlFragment());
    }

    public void testBuildFromXmlFragment() {
        TestCaseResult result = TestCaseResult.fromString("file:///dummy/path/dummyPage.html:testFoo|1.3|F|Test Failure Message|");
        Element element = new TestCaseResultWriter(result).createTestCaseElement();
        TestCaseResult reconstitutedResult = TestCaseResult.fromXmlElement(element);
        assertEquals("file:///dummy/path/dummyPage.html:testFoo", reconstitutedResult.getName());
        assertEquals(1.3d, reconstitutedResult.getTime(), .001d);
        assertFalse(reconstitutedResult.hadError());
        assertTrue(reconstitutedResult.hadFailure());
        assertFalse(reconstitutedResult.hadSuccess());
        assertNull(reconstitutedResult.getError());
        assertEquals("Test Failure Message", reconstitutedResult.getFailure());
    }
}
