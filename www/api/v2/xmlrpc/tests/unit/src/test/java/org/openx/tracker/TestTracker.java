/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.tracker;

import junit.framework.Test;
import junit.framework.TestSuite;

public class TestTracker {

    public static Test suite() {
        TestSuite suite = new TestSuite("Tests for org.openx.tracker");
        // $JUnit-BEGIN$
        suite.addTestSuite(TestAddTracker.class);
        suite.addTestSuite(TestDeleteTracker.class);
        suite.addTestSuite(TestModifyTracker.class);
        suite.addTestSuite(TestGetTracker.class);
        suite.addTestSuite(TestTrackerLinkCampaign.class);
        // $JUnit-END$
        return suite;
    }
}
