/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.zone;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Zone service tests
 */
public class TestZone {

	public static Test suite() {
		TestSuite suite = new TestSuite("Test for org.openads.zone");
		// $JUnit-BEGIN$
		suite.addTestSuite(TestZoneDailyStatistics.class);
		suite.addTestSuite(TestDeleteZone.class);
		suite.addTestSuite(TestAddZone.class);
		suite.addTestSuite(TestZoneBannerStatistics.class);
		suite.addTestSuite(TestZoneAdvertiserStatistics.class);
		suite.addTestSuite(TestModifyZone.class);
		suite.addTestSuite(TestZoneCampaignStatistics.class);
		suite.addTestSuite(TestGetZone.class);
		suite.addTestSuite(TestGetZoneListByPublisherId.class);
		suite.addTestSuite(TestZoneGenerateTags.class);
		suite.addTestSuite(TestZoneLinkBanner.class);
		suite.addTestSuite(TestZoneLinkCampaign.class);
		suite.addTestSuite(TestZoneUnlinkBanner.class);
		suite.addTestSuite(TestZoneUnlinkCampaign.class);

		// $JUnit-END$
		return suite;
	}

}
