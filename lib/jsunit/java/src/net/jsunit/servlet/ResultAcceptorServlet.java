package net.jsunit.servlet;

import net.jsunit.TestSuiteResult;
import net.jsunit.Utility;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.io.OutputStream;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class ResultAcceptorServlet extends JsUnitServlet {

    protected void service(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        Utility.log("ResultAcceptorServlet: Received request");
        TestSuiteResult result = server.accept(request);
        String xml = result.writeXml();
        response.setContentType("text/xml");
        OutputStream out = response.getOutputStream();
        out.write(xml.getBytes());
        out.close();
        Utility.log("ResultAcceptorServlet: Done");
    }
}
