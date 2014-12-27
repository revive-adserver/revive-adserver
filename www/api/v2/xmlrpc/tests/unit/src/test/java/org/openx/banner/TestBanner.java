/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.banner;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Banner service tests
 */
public class TestBanner {

	public static Test suite() {
		TestSuite suite = new TestSuite("Tests for org.openx.banner");
		// $JUnit-BEGIN$
		suite.addTestSuite(TestBannerDailyStatistics.class);
		suite.addTestSuite(TestModifyBanner.class);
		suite.addTestSuite(TestDeleteBanner.class);
		suite.addTestSuite(TestBannerPublisherStatistics.class);
		suite.addTestSuite(TestBannerZoneStatistics.class);
		suite.addTestSuite(TestAddBanner.class);
		suite.addTestSuite(TestGetBanner.class);
		suite.addTestSuite(TestGetBannerListByCampaignId.class);
		// $JUnit-END$
		return suite;
	}

}
