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
 * Verify Modify Zone method
 */

public class TestModifyZone extends ZoneTestCase {
	private Integer zoneId;

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeModifyZoneWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(MODIFY_ZONE_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	@Override
	protected void setUp() throws Exception {
		super.setUp();
		zoneId = createZone();
	}

	@Override
	protected void tearDown() throws Exception {
		deleteZone(zoneId);
		super.tearDown();
	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 */
	public void testModifyZoneAllReqAndSomeOptionalFields()
			throws XmlRpcException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ZONE_ID, zoneId);
		struct.put(PUBLISHER_ID, publisherId);
		struct.put(ZONE_NAME, "test Zone");
		struct.put(HEIGHT, 200);
		Object[] params = new Object[] { sessionId, struct };
		final boolean result = (Boolean) client.execute(MODIFY_ZONE_METHOD,
				params);
		assertTrue(result);
	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testModifyZoneCappingFields()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> myZone = new HashMap<String, Object>();
		myZone.put(PUBLISHER_ID, publisherId);
		myZone.put(ZONE_ID, zoneId);
		myZone.put(ZONE_NAME, "testZone");
		myZone.put(CAPPING, 7);
		myZone.put(SESSION_CAPPING, 17);
		myZone.put(BLOCK, 4212); //in sec
		myZone.put(COMMENTS, "some comments - modify zone");
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, myZone };

		final boolean result = (Boolean) client
				.execute(MODIFY_ZONE_METHOD, XMLRPCMethodParameters);
		assertTrue(result);

		XMLRPCMethodParameters = new Object[] { sessionId, zoneId };
		final Map<String, Object> zone = (Map<String, Object>) execute(
				GET_ZONE_METHOD, XMLRPCMethodParameters);

		checkParameter(zone, PUBLISHER_ID, publisherId);
		checkParameter(zone, ZONE_ID, zoneId);
		checkParameter(zone, ZONE_NAME, myZone.get(ZONE_NAME));
		checkParameter(zone, CAPPING, myZone.get(CAPPING));
		checkParameter(zone, SESSION_CAPPING, myZone.get(SESSION_CAPPING));
		checkParameter(zone, BLOCK, myZone.get(BLOCK));
		checkParameter(zone, COMMENTS, myZone.get(COMMENTS));
		}

	/**
	 * Test method without some required fields.
	 */
	public void testModifyZoneWithoutSomeRequiredFields() {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ZONE_NAME, "test Zone");
		struct.put(HEIGHT, 200);
		Object[] params = new Object[] { sessionId, struct };

		try {
			client.execute(MODIFY_ZONE_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(
							ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS,
							ZONE_ID), e.getMessage());
		}
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testModifyZoneGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {
		Integer result = null;
		final String strGreaterThan255 = TextUtils.getString(256);
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ZONE_ID, zoneId);
		struct.put(ZONE_NAME, strGreaterThan255);
		Object[] params = new Object[] { sessionId, struct };

		try {
			result = (Integer) client.execute(MODIFY_ZONE_METHOD, params);
			deleteZone(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD,
							ZONE_NAME), e.getMessage());
		}
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyZoneMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ZONE_ID, zoneId);
		struct.put(ZONE_NAME, "");
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) client.execute(MODIFY_ZONE_METHOD,
				params);
		assertTrue(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyZoneMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ZONE_ID, zoneId);
		struct.put(ZONE_NAME, TextUtils.getString(245));
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) client.execute(MODIFY_ZONE_METHOD,
				params);
		assertTrue(result);
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testModifyZoneUnknownIdError() throws MalformedURLException,
			XmlRpcException {
		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		// If the zoneId is not a defined publisher ID.
		int zoneId = createZone();
		assertNotNull(zoneId);
		deleteZone(zoneId);

		struct.put(ZONE_ID, zoneId);

		executeModifyZoneWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ZONE_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyZoneWrongTypeError() throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ZONE_ID, zoneId);
		Object[] params = new Object[] { sessionId, struct };

		struct.put(PUBLISHER_ID, TextUtils.NOT_INTEGER);
		executeModifyZoneWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_INTEGER, PUBLISHER_ID));

		struct.remove(PUBLISHER_ID);
		struct.put(ZONE_NAME, TextUtils.NOT_STRING);
		executeModifyZoneWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, ZONE_NAME));
	}
}
