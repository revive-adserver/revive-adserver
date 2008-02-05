/*
+---------------------------------------------------------------------------+
| OpenX v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
| For contact details, see: http://www.openx.org/                         |
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
|  Copyright 2003-2007 Openads Limited                                      |
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

package org.openads.zone;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openads.utils.ErrorMessage;
import org.openads.utils.TextUtils;

/**
 * Verify Modify Zone method
 * 
 * @author <a href="mailto:apetlyovanyy@lohika.com">Andriy Petlyovanyy</a>
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
