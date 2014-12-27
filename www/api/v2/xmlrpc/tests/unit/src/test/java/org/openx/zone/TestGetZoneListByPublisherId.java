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

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Zone List By Publisher Id method
 */

public class TestGetZoneListByPublisherId extends ZoneTestCase {

	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testTestGetZoneListByPublisherIdAllFields()
			throws XmlRpcException, MalformedURLException {
//		int id1 = createZone();
//		int id2 = createZone();
//		final Object[] result = (Object[]) execute(
//				GET_ZONE_LIST_BY_PUBLISHER_ID_METHOD, new Object[] { sessionId,
//						publisherId });
//
//		final List<Integer> ids = new ArrayList<Integer>();
//		for (Object zone : result) {
//			Integer id = (Integer) ((Map) zone).get(ZONE_ID);
//			ids.add(id);
//		}
//
//		assertEquals("Size should be 2", ids.size(), 2);
//		assertTrue("Id should be there", ids.contains(id1));
//		assertTrue("Id should be there", ids.contains(id2));
//
//		deleteZone(id1);
//		deleteZone(id2);

		final int zonesCount = 3;
		Map<Integer, Map<String, Object>> myZones = new HashMap<Integer, Map<String, Object>>();
		for (int i = 0; i < zonesCount; i++) {
			Map<String, Object> param = getZoneParams("test2" + i);
			myZones.put(createZone(param), param);
		}

		try {
			final Object[] result = (Object[]) execute(GET_ZONE_LIST_BY_PUBLISHER_ID_METHOD,
					new Object[] { sessionId, publisherId });

			assertEquals("Not correct count return zones", myZones.size(), zonesCount);

			for (Object zone : result) {
				Integer zoneId = (Integer) ((Map) zone).get(ZONE_ID);

				Map<String, Object> myZone = myZones.get(zoneId);

				if (myZone != null) {
					checkParameter((Map) zone, PUBLISHER_ID, publisherId);
					checkParameter((Map) zone, ZONE_ID, zoneId);
					checkParameter((Map) zone, ZONE_NAME, myZone.get(ZONE_NAME));
					checkParameter((Map) zone, WIDTH, myZone.get(WIDTH));
					checkParameter((Map) zone, HEIGHT, myZone.get(HEIGHT));
					checkParameter((Map) zone, TYPE, myZone.get(TYPE));

					// remove checked zone
					myZones.remove(zoneId);
				}
			}
		} finally {
			// delete all created zones
			for (Integer id : myZones.keySet()) {
				deleteZone(id);
			}
		}
	}

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeGetZoneListByPublisherIdWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			execute(GET_ZONE_LIST_BY_PUBLISHER_ID_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Try to get zone list by publisher with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetZoneListByPublisherIdUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createPublisher();
		deletePublisher(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetZoneListByPublisherIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, PUBLISHER_ID));
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testTestGetZoneListByPublisherIdWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetZoneListByPublisherIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.getMessage(
						ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1")));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetZoneListByPublisherIdWrongTypeError()
			throws MalformedURLException, XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetZoneListByPublisherIdWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING,
								"2"));
	}
}
