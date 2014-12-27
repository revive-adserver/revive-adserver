/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.agency;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Agency service tests
 */
public class TestAgency {

	public static Test suite() {
		TestSuite suite = new TestSuite("Test Agency service");
		// $JUnit-BEGIN$
		suite.addTestSuite(TestAgencyZoneStatistics.class);
		suite.addTestSuite(TestAgencyBannerStatistics.class);
		suite.addTestSuite(TestAddAgency.class);
		suite.addTestSuite(TestAgencyDailyStatistics.class);
		suite.addTestSuite(TestAgencyCampaignStatistics.class);
		suite.addTestSuite(TestModifyAgency.class);
		suite.addTestSuite(TestAgencyPublisherStatistics.class);
		suite.addTestSuite(TestAgencyAdvertiserStatistics.class);
		suite.addTestSuite(TestDeleteAgency.class);
		suite.addTestSuite(TestGetAgency.class);
		suite.addTestSuite(TestGetAgencyList.class);
		// $JUnit-END$
		return suite;
	}
}
