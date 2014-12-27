/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.variable;

import junit.framework.Test;
import junit.framework.TestSuite;

public class TestVariable {

    public static Test suite() {
        TestSuite suite = new TestSuite("Tests for org.openx.variable");
        // $JUnit-BEGIN$
        suite.addTestSuite(TestAddVariable.class);
        suite.addTestSuite(TestDeleteVariable.class);
        suite.addTestSuite(TestModifyVariable.class);
        suite.addTestSuite(TestGetVariable.class);
        // $JUnit-END$
        return suite;
    }
}
