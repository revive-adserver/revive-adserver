/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

package org.openads.advertiser;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Advertiser service tests
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestAdvertiser {

	public static Test suite() {
		TestSuite suite = new TestSuite("Test for org.openads.advertiser");
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
