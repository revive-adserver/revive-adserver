/*
+---------------------------------------------------------------------------+
| OpenX v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
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
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
|                                                                           |
|  Licensed under the Apache License, Version 2.0 (the "License");          |
|  you may not use this file except in compliance with the License.         |
|  You may obtain a copy of the License at                                  |
|                                                                           |
|    http://www.apache.org/licenses/LICENSE-2.0                             |
|                                                                           |
|  Unless required by applicable law or agreed to in writing, software      |
|  distributed under the License is distributed on an "AS IS" BASIS,        |
|  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. |
|  See the License for the specific language governing permissions and      |
|  limitations under the License.                                           |
+---------------------------------------------------------------------------+
$Id$
*/

package org.openads.agency;

import junit.framework.Test;
import junit.framework.TestSuite;

/**
 * Run all Agency cervice tests
 * 
 * @author <a href="mailto:apetlyovanyy@lohika.com">Andriy Petlyovanyy</a>
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
