package net.jsunit;

import net.jsunit.servlet.JsUnitServlet;
import net.jsunit.servlet.ResultAcceptorServlet;
import net.jsunit.servlet.ResultDisplayerServlet;
import net.jsunit.servlet.TestRunnerServlet;
import org.mortbay.http.HttpContext;
import org.mortbay.http.HttpServer;
import org.mortbay.http.handler.ResourceHandler;
import org.mortbay.jetty.servlet.ServletHandler;
import org.mortbay.start.Monitor;
import org.mortbay.util.MultiException;

import javax.servlet.http.HttpServletRequest;
import java.io.File;
import java.io.IOException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class JsUnitServer extends HttpServer {
    private List results = new ArrayList();

    private int port;
    private File resourceBase;
    private File logsDirectory;
    private List localBrowserFileNames;
    private URL testURL;
    private boolean initialized;

    public static void main(String args[]) {
        JsUnitServer server = new JsUnitServer();
        try {
            server.initialize(args);
            server.start();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void initialize(String[] args) throws ConfigurationException {
        try {
            Configuration configuration = Configuration.resolve(args);
            configuration.configure(this);
            initialized = true;
        } catch (ConfigurationException ce) {
            System.err.println("Server initialization failed because property \"" + ce.getPropertyInError() + "\" has an invalid value of \"" + ce.getInvalidValue() + "\"");
            throw ce;
        }
    }

    public void start() throws MultiException {
        if (!initialized) {
            System.err.println("Cannot start server: not initialized");
            return;
        }
        try {
            setUpHttpServer();
        } catch (IOException e) {
            e.printStackTrace();
            return;
        }
        super.start();
        Utility.log(asString());
    }

    private void setUpHttpServer() throws IOException {
        addListener(":" + port);
        HttpContext context = getContext("/jsunit");
        ServletHandler handler;
        handler = new ServletHandler();
        handler.addServlet("JsUnitResultAcceptor", "/acceptor", ResultAcceptorServlet.class.getName());
        handler.addServlet("JsUnitResultDisplayer", "/displayer", ResultDisplayerServlet.class.getName());
        handler.addServlet("JsUnitTestRunner", "/runner", TestRunnerServlet.class.getName());
        context.addHandler(handler);
        context.setResourceBase(resourceBase.toString());
        context.addHandler(new ResourceHandler());
        addContext(context);
        JsUnitServlet.setServer(this);
        Monitor.monitor();
    }

    public void initialize() throws ConfigurationException {
        initialize(new String[]{});
    }

    public TestSuiteResult accept(HttpServletRequest request) {
        TestSuiteResult result = TestSuiteResult.fromRequest(request, logsDirectory);
        TestSuiteResult existingResultWithSameId =
                findResultWithId(result.getId());
        if (existingResultWithSameId != null)
            results.remove(existingResultWithSameId);
        results.add(result);
        result.writeLog();
        return result;
    }

    public List getResults() {
        return results;
    }

    public void clearResults() {
        results.clear();
    }

    public TestSuiteResult findResultWithId(String id) {
        TestSuiteResult result = findResultWithIdInResultList(id);
        if (result == null)
            result = TestSuiteResult.findResultWithIdInResultLogs(logsDirectory, id);
        return result;
    }

    private TestSuiteResult findResultWithIdInResultList(String id) {
        Iterator it = getResults().iterator();
        while (it.hasNext()) {
            TestSuiteResult result = (TestSuiteResult) it.next();
            if (result.hasId(id))
                return result;
        }
        return null;
    }

    public TestSuiteResult lastResult() {
        List results = getResults();
        return results.isEmpty()
                ? null
                : (TestSuiteResult) results.get(results.size() - 1);
    }

    public int resultsCount() {
        return getResults().size();
    }

    public String asString() {
        StringBuffer result = new StringBuffer();
        result.append(Configuration.PORT).append(": ").append(port).append("\n");
        result.append(Configuration.RESOURCE_BASE).append(": ").append(resourceBase.getAbsolutePath()).append("\n");
        result.append(Configuration.LOGS_DIRECTORY).append(": ").append(logsDirectory.getAbsolutePath()).append("\n");
        result.append(Configuration.BROWSER_FILE_NAMES).append(": ").append(localBrowserFileNames).append("\n");
        result.append(Configuration.URL).append(": ").append(testURL);
        return result.toString();
    }

    public String toString() {
        return "JsUnit Server";
    }

    public void setResourceBase(File resourceBase) {
        this.resourceBase = resourceBase;
    }

    public void setPort(int port) {
        this.port = port;
    }

    public void setLogsDirectory(File logsDirectory) {
        this.logsDirectory = logsDirectory;
    }

    public List getLocalBrowserFileNames() {
        return localBrowserFileNames;
    }

    public void setLocalBrowserFileNames(List names) {
        this.localBrowserFileNames = names;
    }

    public void setTestURL(URL url) {
        this.testURL = url;
    }

    public URL getTestURL() {
        return testURL;
    }

    public File getLogsDirectory() {
        return logsDirectory;
    }

    public int getPort() {
        return port;
    }

    public File getResourceBase() {
        return resourceBase;
    }

    public void finalize() throws Exception {
        stop();
    }

}