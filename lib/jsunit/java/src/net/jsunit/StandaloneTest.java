package net.jsunit;

import junit.framework.TestCase;

import java.util.Iterator;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class StandaloneTest extends TestCase {
    private boolean needToStopServer = false;
    public static final int MAX_SECONDS_TO_WAIT = 2 * 60;
    private JsUnitServer server;
    private Process process;

    public StandaloneTest(String name) {
        super(name);
    }

    public void setServer(JsUnitServer server) {
        this.server = server;
    }

    public void setUp() throws Exception {
        super.setUp();
        if (server == null) {
            server = new JsUnitServer();
            server.initialize();
            server.start();
            needToStopServer = true;
        }
    }

    public void tearDown() throws Exception {
        if (needToStopServer)
            server.stop();
        if (process != null)
            process.destroy();
        super.tearDown();
    }

    public void testStandaloneRun() throws Exception {
        Iterator it = server.getLocalBrowserFileNames().iterator();
        while (it.hasNext()) {
            String next = (String) it.next();
            int currentResultCount = server.resultsCount();
            launchBrowser(next);
            waitForResultToBeSubmitted(next, currentResultCount);
            process.destroy();
            verifyLastResult();
        }
    }

    private void launchBrowser(String browser) {
        Utility.log("StandaloneTest: launching " + browser);
        try {
            process = Runtime.getRuntime().exec(new String[] {browser, server.getTestURL().toString()});
        } catch (Throwable t) {
            t.printStackTrace();
            fail("All browser processes should start, but the following did not: " + browser);
        }
    }

    private void waitForResultToBeSubmitted(String browser, int initialResultCount) throws Exception {
        Utility.log("StandaloneTest: waiting for " + browser + " to submit result");
        long secondsWaited = 0;
        while (server.getResults().size() == initialResultCount) {
            Thread.sleep(1000);
            secondsWaited ++;
            if (secondsWaited > MAX_SECONDS_TO_WAIT)
                fail("Waited more than " + MAX_SECONDS_TO_WAIT + " seconds for browser " + browser);
        }
    }

    private void verifyLastResult() {
        TestSuiteResult result = server.lastResult();
        if (!result.hadSuccess()) {
            StringBuffer buffer = new StringBuffer();
            buffer.append("Result with ID ");
            buffer.append(result.getId());
            buffer.append(" had problems: ");
            buffer.append(result.errorCount() + " errors, ");
            buffer.append(result.failureCount() + " failures ");
            fail(buffer.toString());
        }
    }

}