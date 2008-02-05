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

package org.openads.advertiser;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openads.config.GlobalSettings;
import org.openads.utils.ErrorMessage;
import org.openads.utils.TextUtils;

/**
 * Verify Add Advertiser method
 * 
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestAddAdvertiser extends AdvertiserTestCase {
	/**
	 * Test method with all required fields and some optional.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		assertNotNull(agencyId);
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(ADVERTISER_NAME, "testAdvertiserName");
		struct.put(CONTACT_NAME, "testContactName");
		struct.put(USERNAME, TextUtils.generateUniqueName("advertiserUser"));
		struct.put(PASSWORD, "qwerty");

		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) client.execute(ADD_ADVERTISER_METHOD,
				params);
		assertNotNull(result);
		deleteAdvertiser(result);
	}

	/**
	 * Test method without some required fields.
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserWithoutSomeRequiredFields()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(EMAIL_ADDRESS, "test@mail.com");

		Object[] params = new Object[] { sessionId, struct };

		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS,
				ADVERTISER_NAME));
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
	private void executeAddAdvertiserWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_ADVERTISER_METHOD, params);
			deleteAdvertiser(result);
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
	public void testAddAdvertiserGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		final String strGreaterThan255 = TextUtils.getString(256);
		final String strGreaterThan64 = TextUtils.getString(65);

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		// test advertiserName
		struct.put(ADVERTISER_NAME, strGreaterThan255);
		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, ADVERTISER_NAME));

		// test contactName
		struct.put(ADVERTISER_NAME, "Correct advertiser name");
		struct.put(CONTACT_NAME, strGreaterThan255);
		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CONTACT_NAME));

		// test username
		struct.remove(CONTACT_NAME);
		struct.put(USERNAME, strGreaterThan64);
		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, USERNAME));

		// test password
		struct.remove(USERNAME);
		struct.put(PASSWORD, strGreaterThan64);
		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, PASSWORD));

	}

	/**
	 * Test method with fields that has value less than min
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserLessThanMinFieldValueError()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(ADVERTISER_NAME, "test advertiser name");
		struct.put(USERNAME, "");

		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.USERNAME_IS_FEWER_THAN, "1"));
	}

	/**
	 * Test method with fields that has min. allowed values.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ADVERTISER_NAME, "testAdvertiser");
		struct.put(CONTACT_NAME, "");
		struct.put(EMAIL_ADDRESS, TextUtils.MIN_ALLOWED_EMAIL);
		struct.put(USERNAME, "s");
		struct.put(PASSWORD, "");
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) client.execute(ADD_ADVERTISER_METHOD,
				params);
		assertNotNull(result);
		deleteAdvertiser(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ADVERTISER_NAME, TextUtils.getString(255));
		struct.put(CONTACT_NAME, TextUtils.getString(255));
		struct.put(EMAIL_ADDRESS, TextUtils.getString(59) + "@a.aa");
		struct.put(USERNAME, TextUtils.generateUniqueString(64));
		struct.put(PASSWORD, TextUtils.getString(64));
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) client.execute(ADD_ADVERTISER_METHOD,
				params);
		assertNotNull(result);
		deleteAdvertiser(result);
	}

	/**
	 * Try to add advertiser with nonexistent agency id
	 * 
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddAdvertiserUnknownIdError() throws MalformedURLException,
			XmlRpcException {
		// get nonexistent agency id
		int testAgencyId = createAgency();
		deleteAgency(testAgencyId);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, testAgencyId);
		struct.put(ADVERTISER_NAME, "testAdvertiserName");
		struct.put(CONTACT_NAME, "testContactName");
		struct.put(EMAIL_ADDRESS, "lola@gmail.com");
		struct.put(USERNAME, TextUtils.generateUniqueName("advertiserUser"));
		struct.put(PASSWORD, "qwerty");

		Object[] params = new Object[] { sessionId, struct };

		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));
	}

	/**
	 * Try to add advertiser with the same username as an existing admin,
	 * agency, advertiser, or publisher username.
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserDuplicateUsernameError()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(ADVERTISER_NAME, "testAdvertiserName");
		struct.put(CONTACT_NAME, "testContactName");
		struct.put(EMAIL_ADDRESS, "lola@gmail.com");
		struct.put(USERNAME, GlobalSettings.getUserName());
		struct.put(PASSWORD, "qwerty");
		Object[] params = new Object[] { sessionId, struct };

		executeAddAdvertiserWithError(params,
				ErrorMessage.USERNAME_MUST_BE_UNIQUE);
	}

	/**
	 * Try to add advertiser with username fewer than 1 characters.
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserUsernameFormatError1()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(ADVERTISER_NAME, "testAdvertiserName");
		struct.put(CONTACT_NAME, "testContactName");
		struct.put(EMAIL_ADDRESS, "lola@gmail.com");
		struct.put(USERNAME, "");
		struct.put(PASSWORD, "qwerty");
		Object[] params = new Object[] { sessionId, struct };

		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.USERNAME_IS_FEWER_THAN, "1"));
	}

	/**
	 * Try to add advertiser without username but with password.
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserUsernameFormatError2()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(ADVERTISER_NAME, "testAdvertiserName");
		struct.put(CONTACT_NAME, "testContactName");
		struct.put(EMAIL_ADDRESS, "lola@gmail.com");
		struct.put(PASSWORD, "qwerty");
		Object[] params = new Object[] { sessionId, struct };

		executeAddAdvertiserWithError(params,
				ErrorMessage.USERNAME_IS_NULL_AND_THE_PASSWORD_IS_NOT);
	}

	/**
	 * Try to add advertiser with unsupported characters in password.
	 * 
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserPasswordFormatError()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(ADVERTISER_NAME, "testAdvertiserName");
		struct.put(CONTACT_NAME, "testContactName");
		struct.put(EMAIL_ADDRESS, "lola@gmail.com");
		struct.put(USERNAME, TextUtils.generateUniqueName("advertiserUser"));
		struct.put(PASSWORD, "qwerty\\");
		Object[] params = new Object[] { sessionId, struct };

		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.PASSWORDS_CANNOT_CONTAIN, "\\"));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 * 
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddAdvertiserWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> struct = new HashMap<String, Object>();

		Object[] params = new Object[] { sessionId, struct };

		struct.put(ADVERTISER_NAME, TextUtils.NOT_STRING);
		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, ADVERTISER_NAME));

		struct.put(ADVERTISER_NAME, "test name");
		struct.put(AGENCY_ID, TextUtils.NOT_INTEGER);
		executeAddAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_INTEGER, AGENCY_ID));
	}
}
