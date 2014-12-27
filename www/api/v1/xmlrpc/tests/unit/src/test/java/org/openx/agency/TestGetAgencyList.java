/*
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

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;

/**
 * Verify Get Agency List method
 */
public class TestGetAgencyList extends AgencyTestCase {

	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
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
				Integer agencyId = (Integer) ((Map <String, Object>) agency).get(AGENCY_ID);

				Map<String, Object> myAgency = myAgencies.get(agencyId);

				if (myAgency != null) {
					checkParameter((Map <String, Object>) agency, AGENCY_ID, agencyId);
					checkParameter((Map <String, Object>) agency, AGENCY_NAME, myAgency.get(AGENCY_NAME));
					checkParameter((Map <String, Object>) agency, CONTACT_NAME, myAgency.get(CONTACT_NAME));
					checkParameter((Map <String, Object>) agency, EMAIL_ADDRESS, myAgency.get(EMAIL_ADDRESS));

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
