/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.campaign;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Campaign service tests
 */
public class TestCampaign {

	public static Test suite() {
		TestSuite suite = new TestSuite("Test for org.openads.campaign");
		// $JUnit-BEGIN$
		suite.addTestSuite(TestCampaignPublisherStatistics.class);
		suite.addTestSuite(TestCampaignDailyStatistics.class);
		suite.addTestSuite(TestModifyCampaign.class);
		suite.addTestSuite(TestAddCampaign.class);
		suite.addTestSuite(TestCampaignZoneStatistics.class);
		suite.addTestSuite(TestDeleteCampaign.class);
		suite.addTestSuite(TestCampaignBannerStatistics.class);
		suite.addTestSuite(TestGetCampaign.class);
		suite.addTestSuite(TestGetCampaignListByAdvertiserId.class);
		// $JUnit-END$
		return suite;
	}

}
