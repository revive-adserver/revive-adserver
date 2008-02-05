/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                              |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
| For contact details, see: http://www.openads.org/                         |
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
$Id:$
 */
package org.openads.agency;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;

/**
 * Verify Get Agency List method
 * 
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestGetAgencyList extends AgencyTestCase {

	/**
	 * Test method with all fields.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetAgencyListAllFields() throws XmlRpcException,
			MalformedURLException {

		final Object[] resultBeforeTest = (Object[]) execute(
				GET_AGENCY_LIST_METHOD, new Object[] { sessionId });

		// create agencies for test
		Map<Integer, Map<String, Object>> myAgencies = new HashMap<Integer, Map<String, Object>>();
		for (int i = 0; i < 3; i++) {
			Map<String, Object> param = getAgencyParams("test2" + i);
			myAgencies.put(createAgency(param), param);
		}

		try {
			final Object[] result = (Object[]) execute(GET_AGENCY_LIST_METHOD,
					new Object[] { sessionId });

			assertEquals("Not correct count return agencies",
					myAgencies.size(), result.length - resultBeforeTest.length);

			for (Object agency : result) {
				Integer agencyId = (Integer) ((Map) agency).get(AGENCY_ID);

				Map<String, Object> myAgency = myAgencies.get(agencyId);

				if (myAgency != null) {
					checkParameter((Map) agency, AGENCY_ID, agencyId);
					checkParameter((Map) agency, AGENCY_NAME, myAgency.get(AGENCY_NAME));
					checkParameter((Map) agency, CONTACT_NAME, myAgency.get(CONTACT_NAME));
					checkParameter((Map) agency, EMAIL_ADDRESS, myAgency.get(EMAIL_ADDRESS));
					checkParameter((Map) agency, USERNAME, myAgency.get(USERNAME));
					checkParameter((Map) agency, PASSWORD, "");

					// remove checked agency
					myAgencies.remove(agencyId);
				}
			}

			assertEquals("Not return all agency", 0, myAgencies.size());

		} finally {
			// delete all created agency
			for (Integer id : myAgencies.keySet()) {
				deleteAgency(id);
			}
		}
	}
}
