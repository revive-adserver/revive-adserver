package net.jsunit;

import javax.servlet.http.HttpServletRequest;
import java.io.File;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestSuiteResult {
    private String remoteAddress, id, jsUnitVersion, userAgent, baseURL;
    private List testCaseResults = new ArrayList();
    private double time;
    private String SEPARATOR = "---------------------";
    private File logsDirectory;

    public TestSuiteResult(File logsDirectory) {
        this.id = String.valueOf(System.currentTimeMillis());
        this.logsDirectory = logsDirectory;
    }

    public static File logFileForId(File logsDirectory, String id) {
        return new File(logsDirectory+File.separator+ id + ".xml");
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        if (id != null)
            this.id = id;
    }

    public boolean hasId(String id) {
        return this.id.equals(id);
    }

    public String getJsUnitVersion() {
        return jsUnitVersion;
    }

    public void setJsUnitVersion(String jsUnitVersion) {
        this.jsUnitVersion = jsUnitVersion;
    }

    public String getBaseURL() {
        return baseURL;
    }

    public void setBaseURL(String baseURL) {
        this.baseURL = baseURL;
    }

    public String getUserAgent() {
        return userAgent;
    }

    public void setUserAgent(String userAgent) {
        this.userAgent = userAgent;
    }

    public double getTime() {
        return time;
    }

    public void setTime(double time) {
        this.time = time;
    }

    public List getTestCaseResults() {
        return testCaseResults;
    }

    public void setTestCaseStrings(String[] testCaseResultStrings) {
        buildTestCaseResults(testCaseResultStrings);
    }

    public static TestSuiteResult fromRequest(HttpServletRequest request, File logsDirectory) {
        TestSuiteResult result = new TestSuiteResult(logsDirectory);
        String testId = request.getParameter(TestSuiteResultWriter.ID);
        if (!Utility.isEmpty(testId))
            result.setId(testId);
        result.setRemoteAddress(request.getRemoteAddr());
        result.setUserAgent(request.getParameter(TestSuiteResultWriter.USER_AGENT));
        result.setBaseURL(request.getParameter(TestSuiteResultWriter.BASE_URL));
        String time = request.getParameter(TestSuiteResultWriter.TIME);
        if (!Utility.isEmpty(time))
            result.setTime(Double.parseDouble(time));
        result.setJsUnitVersion(request.getParameter(TestSuiteResultWriter.JSUNIT_VERSION));
        result.setTestCaseStrings(request.getParameterValues(TestSuiteResultWriter.TEST_CASES));
        return result;
    }

    public String getRemoteAddress() {
        return remoteAddress;
    }

    public void setRemoteAddress(String remoteAddress) {
        this.remoteAddress = remoteAddress;
    }

    private void buildTestCaseResults(String[] testCaseResultStrings) {
        if (testCaseResultStrings == null)
            return;
        for (int i = 0; i < testCaseResultStrings.length; i++)
            testCaseResults.add(TestCaseResult.fromString(testCaseResultStrings[i]));
    }

    public static TestSuiteResult findResultWithIdInResultLogs(File logsDirectory, String id) {
        File logFile = logFileForId(logsDirectory, id);
        if (logFile.exists())
            return fromXmlFile(logFile);
        return null;
    }

    public int errorCount() {
        int result = 0;
        Iterator it = testCaseResults.iterator();
        while (it.hasNext()) {
            TestCaseResult next = (TestCaseResult) it.next();
            if (next.hadError())
                result++;
        }
        return result;
    }

    public int failureCount() {
        int result = 0;
        Iterator it = testCaseResults.iterator();
        while (it.hasNext()) {
            TestCaseResult next = (TestCaseResult) it.next();
            if (next.hadFailure())
                result++;
        }
        return result;
    }

    public int count() {
        return testCaseResults.size();
    }

    public String writeXml() {
        return new TestSuiteResultWriter(this).writeXml();
    }

    public String writeXmlFragment() {
        return new TestSuiteResultWriter(this).writeXmlFragment();
    }

    public void writeLog() {
        writeXmlToFile();
        logProblems();
    }

    private void logProblems() {
        String problems = new TestSuiteResultWriter(this).writeProblems();
        if (!Utility.isEmpty(problems)) {
            Utility.log("Problems:");
            Utility.log(SEPARATOR, false);
            Utility.log(problems, false);
            Utility.log(SEPARATOR, false);
        }
    }

    private void writeXmlToFile() {
        String xml = writeXml();
        Utility.writeFile(xml, logFileForId(logsDirectory, getId()));
    }

    public boolean hadSuccess() {
        Iterator it = testCaseResults.iterator();
        while (it.hasNext()) {
            TestCaseResult next = (TestCaseResult) it.next();
            if (!next.hadSuccess())
                return false;
        }
        return true;
    }

    public static TestSuiteResult fromXmlFile(File aFile) {
        return new TestSuiteResultBuilder(aFile.getParentFile()).build(aFile);
    }

    public void addTestCaseResult(TestCaseResult result) {
        testCaseResults.add(result);
    }
}
