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

package org.openx.agency;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Add Agency method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>, Pawel Dachterski <pawel.dachterski@openx.org>
 */
public class TestAddAgencyV1 extends AgencyTestCase {
	
	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAgencyAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		Map<String, Object> addAgencyParameters = new HashMap<String, Object>();
		addAgencyParameters.put(AGENCY_NAME, "testAgancy");
		addAgencyParameters.put(CONTACT_NAME, "test");
		addAgencyParameters.put(EMAIL_ADDRESS, "test@mail.com");
		Object[] XMLMethodParameters = new Object[] { sessionId, addAgencyParameters };
		final Integer result = (Integer) client.execute(ADD_AGENCY_METHOD,
				XMLMethodParameters);
		assertNotNull(result);
		deleteAgency(result);
	}

	/**
	 * Test method with all required and all optional fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAgencyAllFields() throws XmlRpcException,
			MalformedURLException {
		
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_NAME, "testAgancy");
		struct.put(CONTACT_NAME, "test");
		struct.put(EMAIL_ADDRESS, "test@mail.com");
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) client.execute(ADD_AGENCY_METHOD,
				params);
		assertNotNull(result);
		deleteAgency(result);
	}

	/**
	 * Test method with all required and all optional fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAgencyUserFieldWithoutPassword() throws XmlRpcException,
			MalformedURLException {
		
		Map<String, Object> addAgencyParameters = new HashMap<String, Object>();
		addAgencyParameters.put(AGENCY_NAME, "testAgancy");
		addAgencyParameters.put(CONTACT_NAME, "test");
		addAgencyParameters.put(EMAIL_ADDRESS, "test@mail.com");
		addAgencyParameters.put(USER_NAME, "testUserName");
		Object[] XMLMethodParameters = new Object[] { sessionId, addAgencyParameters };
		
		executeAddAgencyWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, PASSWORD));
		
	}

	/**
	 * Test method with manager user creation.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testAddAgencyWithManagerUser() throws XmlRpcException,
			MalformedURLException {
		
		Map<String, Object> addAgencyParameters = new HashMap<String, Object>();
		addAgencyParameters.put(AGENCY_NAME, "testAgancy7");
		addAgencyParameters.put(CONTACT_NAME, "test");
		addAgencyParameters.put(EMAIL_ADDRESS, "test@mail.com");
		addAgencyParameters.put(USER_NAME, "testUserName");
		addAgencyParameters.put(PASSWORD, "testPassword");
		addAgencyParameters.put(USER_EMAIL, "user123@mailinator.com");
		addAgencyParameters.put(LANGUAGE, "de");
		
		Object[] XMLMethodParameters = new Object[] { sessionId, addAgencyParameters };
		final Integer id = (Integer) client.execute(ADD_AGENCY_METHOD,
				XMLMethodParameters);
		
		assertNotNull(id);

		Map<String, Object> agency = (Map<String, Object>) execute(
				GET_AGENCY_METHOD, new Object[] {sessionId, id});
		
		checkParameter(agency, AGENCY_ID, id);
		checkParameter(agency, AGENCY_NAME, addAgencyParameters.get(AGENCY_NAME));
		checkParameter(agency, CONTACT_NAME, addAgencyParameters.get(CONTACT_NAME));
		checkParameter(agency, EMAIL_ADDRESS, addAgencyParameters.get(EMAIL_ADDRESS));

		deleteAgency(id);
	}
	
	/**
	 * Test method without optional fields (only required).
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAgencyReqFieldsOnly() throws XmlRpcException,
			MalformedURLException {
		Integer result = null;
		Map<String, Object> struct = new HashMap<String, Object>(6);
		struct.put(AGENCY_NAME, "testAgancy");
		result = (Integer) client.execute(ADD_AGENCY_METHOD, new Object[] {
				sessionId, struct });
		assertNotNull(result);
		deleteAgency(result);
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAgencyMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_NAME, TextUtils.MIN_ALLOWED_STRING);
		struct.put(CONTACT_NAME, TextUtils.MIN_ALLOWED_STRING);
		struct.put(EMAIL_ADDRESS, TextUtils.MIN_ALLOWED_EMAIL);
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) client.execute(ADD_AGENCY_METHOD,
				params);
		assertNotNull(result);
		deleteAgency(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAgencyMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_NAME, TextUtils.getString(255));
		struct.put(CONTACT_NAME, TextUtils.getString(255));
		struct.put(EMAIL_ADDRESS, TextUtils.getString(55) + "@mail.com");
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) client.execute(ADD_AGENCY_METHOD,
				params);
		assertNotNull(result);
		deleteAgency(result);
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
	private void executeAddAgencyWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_AGENCY_METHOD, params);
			deleteAgency(result);
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
	public void testAddAgencyGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		final String strGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		// test agencyName
		struct.put(AGENCY_NAME, strGreaterThan255);
		executeAddAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, AGENCY_NAME));

		// test contactName
		struct.put(AGENCY_NAME, "Correct agency name");
		struct.put(CONTACT_NAME, strGreaterThan255);
		executeAddAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CONTACT_NAME));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddAgencyWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> struct = new HashMap<String, Object>();

		Object[] params = new Object[] { sessionId, struct };

		struct.put(AGENCY_NAME, TextUtils.NOT_STRING);
		executeAddAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, AGENCY_NAME));
	}
}
