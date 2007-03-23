package net.jsunit.test;


import junit.framework.TestResult;
import junit.framework.TestCase;
import junit.textui.TestRunner;
import net.jsunit.DistributedTest;
import net.jsunit.JsUnitServer;
import net.jsunit.Configuration;

public class DistributedTestTest extends TestCase {
    private JsUnitServer server;

    public DistributedTestTest(String name) {
        super(name);
    }

    public void setUp() throws Exception {
        super.setUp();
        System.setProperty(Configuration.BROWSER_FILE_NAMES, "c:\\program files\\internet explorer\\iexplore.exe");
        System.setProperty(Configuration.URL, "file:///c:/dev/jsunit/testRunner.html?testPage=c:\\dev\\jsunit\\tests\\jsUnitTestSuite.html&autoRun=true&submitresults=true");
        server = new JsUnitServer();
        server.initialize();
        server.start();
    }

    public void tearDown() throws Exception {
        server.stop();
        System.getProperties().remove(Configuration.BROWSER_FILE_NAMES);
        System.getProperties().remove(Configuration.URL);
        super.tearDown();
    }

    public void testDistributedRunWithTwoLocalhosts() {
        System.setProperty(DistributedTest.REMOTE_MACHINE_URLS, "http://localhost:8080, http://localhost:8080");
        TestResult result = TestRunner.run(new DistributedTest("testCollectResults"));
        assertEquals(1, result.runCount());
        assertTrue(result.wasSuccessful());
    }

    public void testDistributedRunWithInvalidHosts() {
        System.setProperty(DistributedTest.REMOTE_MACHINE_URLS, "http://fooXXX:1234, http://barXXX:5678");
        TestResult result = TestRunner.run(new DistributedTest("testCollectResults"));
        assertEquals(1, result.runCount());
        assertFalse(result.wasSuccessful());
    }

}