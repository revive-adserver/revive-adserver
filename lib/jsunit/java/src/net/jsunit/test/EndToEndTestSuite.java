package net.jsunit.test;

import junit.framework.TestCase;
import junit.framework.TestSuite;
import net.jsunit.StandaloneTest;

/**
 * @author Edward Hieatt, edward@jsunit.net
 */

public class EndToEndTestSuite extends TestCase {
    public static TestSuite suite() {
        TestSuite result = new TestSuite();
        result.addTestSuite(StandaloneTestTest.class);
        result.addTestSuite(DistributedTestTest.class);
        return result;
    }
}
