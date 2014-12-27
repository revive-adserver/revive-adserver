/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.advertiser;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Advertiser service tests
 */
public class TestAdvertiser {

	public static Test suite() {
		TestSuite suite = new TestSuite("Tests for org.openx.advertiser");
		// $JUnit-BEGIN$
		suite.addTestSuite(TestAdvertiserZoneStatistics.class);
		suite.addTestSuite(TestModifyAdvertiser.class);
		suite.addTestSuite(TestDeleteAdvertiser.class);
		suite.addTestSuite(TestAdvertiserCampaignStatistics.class);
		suite.addTestSuite(TestAdvertiserPublisherStatistics.class);
		suite.addTestSuite(TestAdvertiserDailyStatistics.class);
		suite.addTestSuite(TestAddAdvertiser.class);
		suite.addTestSuite(TestAdvertiserBannerStatistics.class);
		suite.addTestSuite(TestGetAdvertiser.class);
		suite.addTestSuite(TestGetAdvertiserListByAgencyId.class);
		// $JUnit-END$
		return suite;
	}

}
