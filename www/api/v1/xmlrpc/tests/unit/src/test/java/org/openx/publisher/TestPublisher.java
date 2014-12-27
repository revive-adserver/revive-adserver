/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.publisher;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Publisher service tests
 */
public class TestPublisher {

	public static Test suite() {
		TestSuite suite = new TestSuite("Tests for org.openx.publisher");
		// $JUnit-BEGIN$
		suite.addTestSuite(TestPublisherCampaignStatistics.class);
		suite.addTestSuite(TestAddPublisher.class);
		suite.addTestSuite(TestPublisherZoneStatistics.class);
		suite.addTestSuite(TestPublisherBannerStatistics.class);
		suite.addTestSuite(TestPublisherAdvertiserStatistics.class);
		suite.addTestSuite(TestModifyPublisher.class);
		suite.addTestSuite(TestDeletePublisher.class);
		suite.addTestSuite(TestPublisherDailyStatistics.class);
		suite.addTestSuite(TestGetPublisher.class);
		suite.addTestSuite(TestGetPublisherListByAgencyId.class);
		// $JUnit-END$
		return suite;
	}

}
