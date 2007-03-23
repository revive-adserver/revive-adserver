package net.jsunit.test;

import net.jsunit.*;

import javax.servlet.http.HttpServletRequest;
import java.io.File;
import java.util.HashMap;
import java.util.Map;

import junit.framework.TestCase;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class ResultAcceptorTest extends TestCase {
    protected Map requestMap;
    private JsUnitServer server;

    public ResultAcceptorTest(String name) {
        super(name);
    }

    public void setUp() throws Exception {
        super.setUp();
        server = new JsUnitServer();
        System.setProperty(Configuration.BROWSER_FILE_NAMES, "foo");
        System.setProperty(Configuration.URL, "http://bar");
        server.initialize();
        Utility.setLogToStandardOut(false);
        requestMap = new HashMap();
        requestMap.put(TestSuiteResultWriter.ID, "ID_foo");
        requestMap.put(TestSuiteResultWriter.USER_AGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        requestMap.put(TestSuiteResultWriter.TIME, "4.3");
        requestMap.put(TestSuiteResultWriter.JSUNIT_VERSION, "2.5");
        requestMap.put(TestSuiteResultWriter.TEST_CASES, dummyTestCaseStrings());
    }

    public void tearDown() throws Exception {
        System.getProperties().remove(Configuration.BROWSER_FILE_NAMES);
        System.getProperties().remove(Configuration.URL);
        File logFile = TestSuiteResult.logFileForId(server.getLogsDirectory(), "ID_foo");
        if (logFile.exists())
            logFile.delete();
        super.tearDown();
    }

    protected String[] dummyTestCaseStrings() {
        return new String[]{"file:///dummy/path/dummyPage.html:testFoo|1.3|S||", "testFoo|1.3|E|Test Error Message|", "testFoo|1.3|F|Test Failure Message|"};
    }

    protected void submit() {
        HttpServletRequest request = new DummyHttpRequest(requestMap);
        server.accept(request);
    }

    public void testSubmitResults() {
        assertEquals(0, server.getResults().size());
        submit();
        assertEquals(1, server.getResults().size());
        submit();
        assertEquals(1, server.getResults().size());
    }

    public void testSubmittedResultHeaders() {
        submit();
        TestSuiteResult result = (TestSuiteResult) server.getResults().get(0);
        assertEquals("ID_foo", result.getId());
        assertEquals("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)", result.getUserAgent());
        assertEquals("2.5", result.getJsUnitVersion());
        assertEquals(1, result.errorCount());
        assertEquals(1, result.failureCount());
        assertEquals(3, result.count());
        assertEquals(4.3d, result.getTime(), .001d);
    }

    public void testSubmittedTestCaseResults() {
        submit();
        TestSuiteResult result = (TestSuiteResult) server.getResults().get(0);
        assertEquals(3, result.getTestCaseResults().size());
    }

    public void testFindResultById() {
        assertNull(server.findResultWithId("ID_foo"));
        submit();
        assertNotNull(server.findResultWithId("ID_foo"));
        assertNull(server.findResultWithId("Invalid ID"));
        server.clearResults();
        //should look on disk when not in memory
        assertNotNull(server.findResultWithId("ID_foo"));
        assertNull(server.findResultWithId("Invalid ID"));
    }

    public void testLog() {
        File logFile = TestSuiteResult.logFileForId(server.getLogsDirectory(), "ID_foo");
        assertFalse(logFile.exists());
        submit();
        assertTrue(logFile.exists());
    }
}