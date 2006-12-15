package net.jsunit.servlet;

import junit.framework.TestResult;
import junit.textui.TestRunner;
import net.jsunit.StandaloneTest;
import net.jsunit.Utility;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.io.OutputStream;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestRunnerServlet extends JsUnitServlet {

    protected synchronized void service(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        Utility.log("TestRunnerServlet: Received request to run standalone test...");
        StandaloneTest test = createTest();
        TestResult result = TestRunner.run(test);
        writeResponse(response, result);
        Utility.log("TestRunnerServlet: ...Done");
    }

    protected void writeResponse(HttpServletResponse response, TestResult result) throws IOException {
        response.setContentType("text/xml");
        OutputStream out = response.getOutputStream();
        String resultString = result.wasSuccessful() ? "success" : "failure";
        out.write(("<result>" + resultString + "</result>").getBytes());
        out.close();
    }

    protected StandaloneTest createTest() {
        StandaloneTest standaloneTest = new StandaloneTest("testStandaloneRun");
        standaloneTest.setServer(server);
        return standaloneTest;
    }
}
