package net.jsunit;

import org.jdom.Document;
import org.jdom.Element;
import org.jdom.output.XMLOutputter;

import java.util.Iterator;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestSuiteResultWriter {
    public static final String ID = "id",
    USER_AGENT = "userAgent",
    TIME = "time",
    TEST_CASES = "testCases",
    JSUNIT_VERSION = "JsUnitVersion",
    TEST_COUNT = "tests",
    REMOTE_ADDRESS = "remoteAddress",
    PROPERTIES = "properties",
    PROPERTY = "property",
    PROPERTY_KEY = "name",
    PROPERTY_VALUE = "value",
    BASE_URL = "baseURL";

    TestSuiteResult result;

    public TestSuiteResultWriter(TestSuiteResult result) {
        this.result = result;
    }

    public String writeXml() {
        Element root = createRootElement();
        Document document = new Document(root);
        return new XMLOutputter().outputString(document);
    }

    public String writeXmlFragment() {
        return new XMLOutputter().outputString(createRootElement());
    }

    private Element createRootElement() {
        Element root = new Element("testsuite");
        root.setAttribute(ID, result.getId());
        root.setAttribute("errors", "" + result.errorCount());
        root.setAttribute("failures", "" + result.failureCount());
        root.setAttribute("name", "JsUnitTestCase");
        root.setAttribute(TEST_COUNT, "" + result.count());
        root.setAttribute(TIME, String.valueOf(result.getTime()));
        addPropertiesElementTo(root);
        addTestResultElementsTo(root);
        return root;
    }

    private void addPropertiesElementTo(Element element) {
        Element properties = new Element(PROPERTIES);
        element.addContent(properties);
        addProperty(properties, JSUNIT_VERSION, result.getJsUnitVersion());
        addProperty(properties, USER_AGENT, result.getUserAgent());
        addProperty(properties, REMOTE_ADDRESS, result.getRemoteAddress());
        addProperty(properties, BASE_URL, result.getBaseURL());
    }

    private void addProperty(Element parent, String name, String value) {
        Element property = new Element(PROPERTY);
        property.setAttribute(PROPERTY_KEY, name);
        property.setAttribute(PROPERTY_VALUE, value == null ? "" : value);
        parent.addContent(property);
    }

    private void addTestResultElementsTo(Element element) {
        Iterator it = result.getTestCaseResults().iterator();
        while (it.hasNext()) {
            TestCaseResult next = (TestCaseResult) it.next();
            new TestCaseResultWriter(next).addXmlTo(element);
        }
    }

    public String writeProblems() {
        StringBuffer buffer = new StringBuffer();
        Iterator it = result.getTestCaseResults().iterator();
        while (it.hasNext()) {
            TestCaseResult next = (TestCaseResult) it.next();
            if (!next.hadSuccess()) {
                if (buffer.length() > 0)
                    buffer.append("\n");
                String problemMessage = next.writeProblemSummary();
                buffer.append(problemMessage);
            }
        }
        return buffer.toString();
    }
}
