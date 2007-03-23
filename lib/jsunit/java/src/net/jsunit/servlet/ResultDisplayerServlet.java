package net.jsunit.servlet;

import net.jsunit.TestSuiteResult;
import net.jsunit.TestSuiteResultWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.io.OutputStream;

public class ResultDisplayerServlet extends JsUnitServlet {

    protected void service(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String id = request.getParameter(TestSuiteResultWriter.ID);
        String xml = null;
        if (id == null) {
            xml = "<error>No id specified</error>";
        } else {
            TestSuiteResult result = server.findResultWithId(id);
            if (result != null)
                xml = result.writeXml();
            else
                xml = "<error>No Test Result has been submitted with id " + id + "</error>";
        }
        response.setContentType("text/xml");
        OutputStream out = response.getOutputStream();
        out.write(xml.getBytes());
        out.close();
    }
}
