package net.jsunit;

import org.jdom.Document;
import org.jdom.Element;
import org.jdom.input.SAXBuilder;

import java.io.File;
import java.util.Iterator;
import java.util.List;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestSuiteResultBuilder {
    private File logsDirectory;

    public TestSuiteResultBuilder(File logsDirectory) {
        this.logsDirectory = logsDirectory;
    }

    public TestSuiteResult build(File file) {
        try {
            Document document = new SAXBuilder().build(file);
            return build(document);
        } catch (Exception e) {
            System.err.println("Failed to read file " + file + ": " + e.getMessage());
            e.printStackTrace();
            return null;
        }
    }

    public TestSuiteResult build(Document document) {
        TestSuiteResult result = new TestSuiteResult(logsDirectory);
        Element root = document.getRootElement();
        updateWithHeaders(result, root);
        updateWithProperties(root.getChild(TestSuiteResultWriter.PROPERTIES), result);
        updateWithTestCaseResults(root.getChildren(TestCaseResultWriter.TEST_CASE), result);
        return result;
    }

    private void updateWithHeaders(TestSuiteResult result, Element element) {
        String id = element.getAttributeValue(TestSuiteResultWriter.ID);
        double time = Double.parseDouble(element.getAttributeValue(TestSuiteResultWriter.TIME));
        result.setId(id);
        result.setTime(time);
    }

    private void updateWithProperties(Element element, TestSuiteResult result) {
        Iterator it = element.getChildren().iterator();
        while (it.hasNext()) {
            Element next = (Element) it.next();
            if (TestSuiteResultWriter.JSUNIT_VERSION.equals(next.getAttributeValue(TestSuiteResultWriter.PROPERTY_KEY)))
                result.setJsUnitVersion(next.getAttributeValue(TestSuiteResultWriter.PROPERTY_VALUE));
            else if (TestSuiteResultWriter.USER_AGENT.equals(next.getAttributeValue(TestSuiteResultWriter.PROPERTY_KEY)))
                result.setUserAgent(next.getAttributeValue(TestSuiteResultWriter.PROPERTY_VALUE));
            else if (TestSuiteResultWriter.REMOTE_ADDRESS.equals(next.getAttributeValue(TestSuiteResultWriter.PROPERTY_KEY)))
                result.setRemoteAddress(next.getAttributeValue(TestSuiteResultWriter.PROPERTY_VALUE));
            else if (TestSuiteResultWriter.BASE_URL.equals(next.getAttributeValue(TestSuiteResultWriter.PROPERTY_KEY)))
                result.setBaseURL(next.getAttributeValue(TestSuiteResultWriter.PROPERTY_VALUE));
        }
    }

    private void updateWithTestCaseResults(List testCaseElements, TestSuiteResult result) {
        TestCaseResultBuilder testCaseBuilder = new TestCaseResultBuilder();
        Iterator it = testCaseElements.iterator();
        while (it.hasNext()) {
            Element next = (Element) it.next();
            result.addTestCaseResult(testCaseBuilder.build(next));
        }
    }
}
