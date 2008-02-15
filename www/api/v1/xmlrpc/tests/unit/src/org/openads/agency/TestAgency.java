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

package org.openads.agency;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Agency cervice tests
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
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
