/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.channel;

import junit.framework.Test;
import junit.framework.TestSuite;

public class TestChannel {
    public static Test suite() {
		TestSuite suite = new TestSuite("Tests for org.openx.channel");
		// $JUnit-BEGIN$
		suite.addTestSuite(TestAddChannel.class);
        suite.addTestSuite(TestGetChannel.class);
        suite.addTestSuite(TestDeleteChannel.class);
        suite.addTestSuite(TestModifyChannel.class);
        suite.addTestSuite(TestGetChannelListByAgencyId.class);
        suite.addTestSuite(TestGetChannelListByWebsiteId.class);
        suite.addTestSuite(TestTargeting.class);
		// $JUnit-END$
		return suite;
	}
}
