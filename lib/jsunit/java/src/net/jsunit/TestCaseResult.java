package net.jsunit;

import org.jdom.Element;

import java.util.StringTokenizer;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class TestCaseResult {
    public static final String DELIMITER = "|", ERROR_INDICATOR = "E", FAILURE_INDICATOR = "F";
    private String name;
    private double time;
    private String failure, error;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getError() {
        return error;
    }

    public void setError(String error) {
        this.error = error;
    }

    public String getFailure() {
        return failure;
    }

    public void setFailure(String failure) {
        this.failure = failure;
    }

    public double getTime() {
        return time;
    }

    public void setTime(double time) {
        this.time = time;
    }

    public boolean hadError() {
        return error != null;
    }

    public boolean hadFailure() {
        return failure != null;
    }

    public boolean hadSuccess() {
        return !hadError() && !hadFailure();
    }

    public static TestCaseResult fromString(String string) {
        TestCaseResult result = new TestCaseResult();
        StringTokenizer toker = new StringTokenizer(string, DELIMITER);
        try {
            result.setName(toker.nextToken());
            result.setTime(Double.parseDouble(toker.nextToken()));
            String successString = toker.nextToken();
            if (successString.equals(ERROR_INDICATOR))
                result.setError(toker.nextToken());
            else if (successString.equals(FAILURE_INDICATOR))
                result.setFailure(toker.nextToken());
        } catch (java.util.NoSuchElementException ex) {
            result.setError("Incomplete test result: '" + string + "'.");
        }
        return result;
    }

    public static TestCaseResult fromXmlElement(Element testCaseElement) {
        return new TestCaseResultBuilder().build(testCaseElement);
    }

    public String writeXmlFragment() {
        return new TestCaseResultWriter(this).writeXmlFragment();
    }

    public String writeProblemSummary() {
        return new TestCaseResultWriter(this).writeProblemSummary();
    }
}
