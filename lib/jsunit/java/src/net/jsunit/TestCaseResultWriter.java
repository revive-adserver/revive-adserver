package net.jsunit;

import org.jdom.Element;
import org.jdom.output.XMLOutputter;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestCaseResultWriter {
    public static final String TEST_CASE = "testcase", NAME = "name", TIME = "time", FAILURE = "failure", ERROR = "error", MESSAGE = "message";

    private TestCaseResult result;

    public TestCaseResultWriter(TestCaseResult result) {
        this.result = result;
    }

    public void addXmlTo(Element element) {
        element.addContent(createTestCaseElement());
    }

    public Element createTestCaseElement() {
        Element testCaseElement = new Element(TEST_CASE);
        try {
            testCaseElement.setAttribute(NAME, result.getName().replace('\u0000', ' '));
        } catch (Exception ex) {
            ex.printStackTrace();
        }
        testCaseElement.setAttribute(TIME, String.valueOf(result.getTime()));
        if (result.hadFailure()) {
            Element failureElement = new Element(FAILURE);
            try {
                failureElement.setAttribute(MESSAGE, result.getFailure().replace('\u0000', ' '));
            } catch (Exception ex) {
                ex.printStackTrace();
            }
            testCaseElement.addContent(failureElement);
        } else if (result.hadError()) {
            Element errorElement = new Element(ERROR);
            try {
                errorElement.setAttribute(MESSAGE, result.getError().replace('\u0000', ' '));
            } catch (Exception ex) {
                ex.printStackTrace();
            }
            testCaseElement.addContent(errorElement);
        }
        return testCaseElement;
    }

    public String writeProblemSummary() {
        if (result.hadFailure())
            return result.getName() + " failed:\n" + result.getFailure();
        else if (result.hadError())
            return result.getName() + " had an error:\n" + result.getError();
        return null;
    }

    public String writeXmlFragment() {
        return new XMLOutputter().outputString(createTestCaseElement());
    }
}
