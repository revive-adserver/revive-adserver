/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Add Zone method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestAddZoneV2 extends ZoneTestCase {
	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeAddZoneWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_ZONE_METHOD, params);
			deleteZone(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddZoneAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		assertNotNull(publisherId);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_ID, publisherId);
		struct.put(ZONE_NAME, "testZone");
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) client
				.execute(ADD_ZONE_METHOD, params);
		assertNotNull(result);
		deleteZone(result);
	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testAddZoneWithCappingFields()
			throws XmlRpcException, MalformedURLException {
		assertNotNull(publisherId);

		Map<String, Object> myZone = new HashMap<String, Object>();
		myZone.put(PUBLISHER_ID, publisherId);
		myZone.put(ZONE_NAME, "testZone");
		myZone.put(CAPPING, 6);
		myZone.put(SESSION_CAPPING, 16);
		myZone.put(BLOCK, 4211); //in sec
		myZone.put(COMMENTS, "some comments");
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, myZone };

		final Integer result = (Integer) client
				.execute(ADD_ZONE_METHOD, XMLRPCMethodParameters);
		assertNotNull(result);
		
		try {
			XMLRPCMethodParameters = new Object[] { sessionId, result };
			final Map<String, Object> zone = (Map<String, Object>) execute(
					GET_ZONE_METHOD, XMLRPCMethodParameters);

			checkParameter(zone, PUBLISHER_ID, publisherId);
			checkParameter(zone, ZONE_ID, result);
			checkParameter(zone, ZONE_NAME, myZone.get(ZONE_NAME));
			checkParameter(zone, CAPPING, myZone.get(CAPPING));
			checkParameter(zone, SESSION_CAPPING, myZone.get(SESSION_CAPPING));
			checkParameter(zone, BLOCK, myZone.get(BLOCK));
			checkParameter(zone, COMMENTS, myZone.get(COMMENTS));
		} finally {
			deleteZone(result);
		}
	}
	
	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testAddZoneWithoutSomeRequiredFields()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ZONE_NAME, "testZone");

		Object[] params = new Object[] { sessionId, struct };

		try {
			Integer result = (Integer) client.execute(ADD_ZONE_METHOD, params);
			assertNotNull(result);
			deleteZone(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(
							ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS,
							PUBLISHER_ID), e.getMessage());
		}
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddZoneGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {
		final String strGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_ID, publisherId);
		struct.put(ZONE_NAME, strGreaterThan255);

		Object[] params = new Object[] { sessionId, struct };

		try {
			Integer result = (Integer) client.execute(ADD_ZONE_METHOD, params);
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
	public void testAddZoneMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_ID, publisherId);
		struct.put(ZONE_NAME, "");
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) client
				.execute(ADD_ZONE_METHOD, params);
		assertNotNull(result);
		deleteZone(result);
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddZoneMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_ID, publisherId);
		struct.put(ZONE_NAME, TextUtils.getString(245));
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) client
				.execute(ADD_ZONE_METHOD, params);
		assertNotNull(result);
		deleteZone(result);
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddZoneUnknownIdError() throws MalformedURLException,
			XmlRpcException {
		int publisherId = createPublisher();
		assertNotNull(publisherId);
		deletePublisher(publisherId);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_ID, publisherId);
		Object[] params = new Object[] { sessionId, struct };

		executeAddZoneWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, PUBLISHER_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddZoneWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(ZONE_NAME, TextUtils.NOT_STRING);
		executeAddZoneWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, ZONE_NAME));
	}
}
