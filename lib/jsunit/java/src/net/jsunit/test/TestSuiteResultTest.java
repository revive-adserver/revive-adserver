package net.jsunit.test;

import junit.framework.TestCase;
import net.jsunit.TestCaseResult;
import net.jsunit.TestSuiteResult;
import net.jsunit.Utility;

import java.io.File;
import java.util.Iterator;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestSuiteResultTest extends TestCase {
    private TestSuiteResult result;
    private String expectedXmlFragment =
            "<testsuite id=\"An ID\" errors=\"1\" failures=\"1\" name=\"JsUnitTestCase\" tests=\"3\" time=\"4.3\">"
            + "<properties>"
            + "<property name=\"JsUnitVersion\" value=\"2.5\" />"
            + "<property name=\"userAgent\" value=\"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)\" />"
            + "<property name=\"remoteAddress\" value=\"Dummy Remote Address\" />"
            + "<property name=\"baseURL\" value=\"about:mozilla\" />"
            + "</properties>"
            + "<testcase name=\"testFoo\" time=\"1.3\" />"
            + "<testcase name=\"testFoo\" time=\"1.3\">"
            + "<error message=\"Test Error Message\" />"
            + "</testcase>"
            + "<testcase name=\"testFoo\" time=\"1.3\">"
            + "<failure message=\"Test Failure Message\" />"
            + "</testcase>"
            + "</testsuite>";

    public TestSuiteResultTest(String name) {
        super(name);
    }

    public void setUp() throws Exception {
        super.setUp();
        result = new TestSuiteResult(null);
        result.setJsUnitVersion("2.5");
        result.setId("An ID");
        result.setUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        result.setRemoteAddress("Dummy Remote Address");
        result.setBaseURL("about:mozilla");
        result.setTime(4.3);
        result.setTestCaseStrings(new String[]{"testFoo|1.3|S||", "testFoo|1.3|E|Test Error Message|", "testFoo|1.3|F|Test Failure Message|"});
    }

    public void testId() {
        assertNotNull(result.getId());
        result = new TestSuiteResult(null);
        result.setId("foo");
        assertEquals("foo", result.getId());
    }

    public void testFields() {
        assertFields(result);
    }

    private void assertFields(TestSuiteResult aResult) {
        assertEquals("2.5", aResult.getJsUnitVersion());
        assertEquals("An ID", aResult.getId());
        assertEquals("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)", aResult.getUserAgent());
        assertEquals("Dummy Remote Address", aResult.getRemoteAddress());
        assertEquals(4.3d, aResult.getTime(), 0.001d);
        assertEquals(3, aResult.getTestCaseResults().size());
        Iterator it = aResult.getTestCaseResults().iterator();
        while (it.hasNext()) {
            TestCaseResult next = (TestCaseResult) it.next();
            assertNotNull(next);
        }
    }

    public void testXml() {
        assertEquals(expectedXmlFragment, result.writeXmlFragment());
    }

    public void testSuccess() {
        assertFalse(result.hadSuccess());
    }

    public void testBuildFromXml() {
        Utility.writeFile(result.writeXml(), "resultXml.xml");
        File file = new File("resultXml.xml");
        TestSuiteResult reconstitutedResult = TestSuiteResult.fromXmlFile(file);
        assertFields(reconstitutedResult);
        file.delete();
    }
}