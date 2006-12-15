package net.jsunit.test;

import net.jsunit.StandaloneTest;
import net.jsunit.Configuration;

public class StandaloneTestTest extends StandaloneTest {
    public StandaloneTestTest(String name) {
        super(name);
    }

    public void setUp() throws Exception {
        System.setProperty(Configuration.BROWSER_FILE_NAMES, "c:\\program files\\internet explorer\\iexplore.exe,c:\\program files\\Mozilla Firefox\\firefox.exe");
        System.setProperty(Configuration.URL, "file:///c:/dev/jsunit/testRunner.html?testPage=c:\\dev\\jsunit\\tests\\jsUnitTestSuite.html&autoRun=true&submitresults=true");
        super.setUp();
    }

    public void tearDown() throws Exception {
        System.getProperties().remove(Configuration.BROWSER_FILE_NAMES);
        System.getProperties().remove(Configuration.URL);
        super.tearDown();
    }
}
