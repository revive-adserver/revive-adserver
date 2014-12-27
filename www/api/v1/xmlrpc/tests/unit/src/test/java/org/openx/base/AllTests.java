/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.base;

import junit.framework.Test;
import junit.framework.TestSuite;

import org.openx.advertiser.TestAdvertiser;
import org.openx.agency.TestAgency;
import org.openx.banner.TestBanner;
import org.openx.campaign.TestCampaign;
import org.openx.publisher.TestPublisher;
import org.openx.user.UserServiceTests;
import org.openx.zone.TestZone;

/**
 * Run all tests
 */
public class AllTests {

	public static Test suite() {
		TestSuite suite = new TestSuite("All tests");

		suite.addTest(TestAdvertiser.suite());
		suite.addTest(TestAgency.suite());
		suite.addTest(TestBanner.suite());
		suite.addTest(TestCampaign.suite());
		suite.addTest(TestPublisher.suite());
		suite.addTest(UserServiceTests.suite());
		suite.addTest(TestZone.suite());

		return suite;
	}

}
