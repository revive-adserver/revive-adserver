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
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Zone method
 */
public class TestGetZone extends ZoneTestCase {

	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetZoneAllFields() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> myZone = getZoneParams("test1");
		Integer id = createZone(myZone);
		Object[] params = new Object[] { sessionId, id };

		try {
			final Map<String, Object> zone = (Map<String, Object>) execute(
					GET_ZONE_METHOD, params);

			checkParameter(zone, PUBLISHER_ID, publisherId);
			checkParameter(zone, ZONE_ID, id);
			checkParameter(zone, ZONE_NAME, myZone.get(ZONE_NAME));
			checkParameter(zone, WIDTH, myZone.get(WIDTH));
			checkParameter(zone, HEIGHT, myZone.get(HEIGHT));
			checkParameter(zone, TYPE, myZone.get(TYPE));
		} finally {
			deleteZone(id);
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
	private void executeGetZoneWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(GET_ZONE_METHOD, params);
			deleteZone(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetZoneWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetZoneWithError(params, ErrorMessage.getMessage(ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1")));

	}

	/**
	 * Try to get zone with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetZoneUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createZone();
		deleteZone(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetZoneWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ZONE_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetZoneWrongTypeError() throws MalformedURLException,
			XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetZoneWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
