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

package org.openx.zone;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Zone service tests
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
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
		// $JUnit-END$
		return suite;
	}

}
