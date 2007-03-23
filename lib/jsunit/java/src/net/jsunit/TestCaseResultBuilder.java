package net.jsunit;

import org.jdom.Element;

import java.util.Iterator;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestCaseResultBuilder {
    public TestCaseResult build(Element element) {
        TestCaseResult result = new TestCaseResult();
        updateWithHeaders(result, element);
        updateWithMessage(result, element);
        return result;
    }

    private void updateWithHeaders(TestCaseResult result, Element element) {
        result.setName(element.getAttributeValue(TestCaseResultWriter.NAME));
        result.setTime(Double.parseDouble(element.getAttributeValue(TestCaseResultWriter.TIME)));
    }

    private void updateWithMessage(TestCaseResult result, Element element) {
        Iterator it = element.getChildren().iterator();
        while (it.hasNext()) {
            Element next = (Element) it.next();
            String type = next.getName();
            String message = next.getAttributeValue(TestCaseResultWriter.MESSAGE);
            if (TestCaseResultWriter.FAILURE.equals(type))
                result.setFailure(message);
            else if (TestCaseResultWriter.ERROR.equals(type))
                result.setError(message);
        }
    }
}
