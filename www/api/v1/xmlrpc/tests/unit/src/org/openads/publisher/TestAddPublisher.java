/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
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

package org.openads.publisher;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openads.config.GlobalSettings;
import org.openads.utils.ErrorMessage;
import org.openads.utils.TextUtils;

/**
 * Verify Add Publisher method
 * 
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestAddPublisher extends PublisherTestCase {
	/**
	 * Test method with all required fields and some optional.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddPublisherAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_NAME, "testPublisherName");
		struct.put(EMAIL_ADDRESS, "test@gmail.com");
		struct.put(USERNAME, TextUtils.generateUniqueName("testUsername"));

		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
		assertNotNull(result);
		deletePublisher(result);
	}

	/**
	 * Test method without some required fields.
	 * 
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddPublisherWithoutSomeRequiredFields()
			throws MalformedURLException, XmlRpcException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(USERNAME, TextUtils.generateUniqueName("testUsername"));

		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);

		assertNotNull(result);
		deletePublisher(result);
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
	private void executeAddPublisherWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
			deletePublisher(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method with fields that has value greater than max.
	 * 
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddPublisherGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {
		final String strGreaterThan64 = TextUtils.getString(65);
		final String strGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(USERNAME, strGreaterThan64);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, USERNAME));

		struct.remove(USERNAME);
		struct.put(PASSWORD, strGreaterThan64);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, PASSWORD));

		struct.remove(PASSWORD);
		struct.put(PUBLISHER_NAME, strGreaterThan255);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, PUBLISHER_NAME));
	}

	/**
	 * Test method with fields that has value less than min
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddPublisherLessThanMinFieldValueError()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(USERNAME, "");
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.USERNAME_IS_FEWER_THAN, "1"));

		struct.remove(USERNAME);
		struct.put(EMAIL_ADDRESS, "");
		executeAddPublisherWithError(params, ErrorMessage.EMAIL_IS_NOT_VALID);

	}

	/**
	 * Test method with fields that has min. allowed values.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddPublisherMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_NAME, "");
		struct.put(CONTACT_NAME, "");
		struct.put(EMAIL_ADDRESS, TextUtils.MIN_ALLOWED_EMAIL);
		struct.put(USERNAME, "s");
		struct.put(PASSWORD, "");
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
		assertNotNull(result);
		deletePublisher(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddPublisherMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_NAME, TextUtils.getString(255));
		struct.put(CONTACT_NAME, TextUtils.getString(255));
		struct.put(EMAIL_ADDRESS, TextUtils.getString(55) + "@mail.com");
		struct.put(USERNAME, TextUtils.generateUniqueString(64));
		struct.put(PASSWORD, TextUtils.getString(64));
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
		assertNotNull(result);
		deletePublisher(result);
	}

	/**
	 * Try to add publisher with unknown agency id
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddPublisherUnknownAgencyIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getPublisherServiceUrl()));

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, id);
		Object[] params = new Object[] { sessionId, struct };

		try {
			final Integer result = (Integer) client.execute(
					ADD_PUBLISHER_METHOD, params);
			deletePublisher(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID),
					e.getMessage());
		}
	}

	/**
	 * Test methods for Duplicate Username Error, described in API
	 * 
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddPublisherDuplicateUsernameError()
			throws MalformedURLException, XmlRpcException {
		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		String uniqueName = TextUtils.generateUniqueString(64);
		struct.put(USERNAME, uniqueName);
		struct.put(PASSWORD, "testpsw");

		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
		assertNotNull(result);

		executeAddPublisherWithError(params,
				ErrorMessage.USERNAME_MUST_BE_UNIQUE);

		deletePublisher(result);
	}

	/**
	 * Test methods for Username Format Error, described in API
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddPublisherUsernameFormatError1()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(PASSWORD, "testpsw");
		executeAddPublisherWithError(params,
				ErrorMessage.USERNAME_IS_NULL_AND_THE_PASSWORD_IS_NOT);
	}

	/**
	 * Test methods for Username Format Error, described in API
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddPublisherUsernameFormatError2()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(USERNAME, "");
		struct.put(PASSWORD, "testpsw");
		Object[] params = new Object[] { sessionId, struct };

		try {
			Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
			deletePublisher(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(ErrorMessage.USERNAME_IS_FEWER_THAN, "1"), e
					.getMessage());
		}
	}

	/**
	 * Test methods for Password Format Error, described in API
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddPublisherPasswordFormatError()
			throws MalformedURLException {
		final String badPassword = TextUtils.BAD_PASSWORD;

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };
		struct.put(USERNAME, TextUtils.generateUniqueString(64));
		struct.put(PASSWORD, badPassword);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.PASSWORDS_CANNOT_CONTAIN, "\\"));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddPublisherWrongTypeError() throws MalformedURLException {

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(AGENCY_ID, TextUtils.NOT_INTEGER);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_INTEGER, AGENCY_ID));

		struct.remove(AGENCY_ID);
		struct.put(PUBLISHER_NAME, TextUtils.NOT_STRING);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, PUBLISHER_NAME));
	}
}
