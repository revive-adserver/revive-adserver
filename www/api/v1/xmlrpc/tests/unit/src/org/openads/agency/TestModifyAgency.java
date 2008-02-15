/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

package org.openads.agency;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openads.config.GlobalSettings;
import org.openads.utils.ErrorMessage;
import org.openads.utils.TextUtils;

/**
 * Verify Modify Agency method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestModifyAgency extends AgencyTestCase {
	private Integer agencyId;

	protected void setUp() throws Exception {
		super.setUp();
		agencyId = createAgency();
	}

	protected void tearDown() throws Exception {
		deleteAgency(agencyId);
		super.tearDown();
	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 */
	public void testModifyAgencyAllReqAndSomeOptionalFields()
			throws XmlRpcException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(CONTACT_NAME, "agencyContact");
		struct.put(AGENCY_NAME, "newAgency");
		struct.put(EMAIL_ADDRESS, "test@mail.com");
		Object[] params = new Object[] { sessionId, struct };
		final boolean result = (Boolean) client.execute(MODIFY_AGENCY_METHOD,
				params);
		assertTrue(result);
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws Exception
	 */
	public void testModifyAgencyWithoutSomeRequiredFields() throws Exception {
		Map<String, String> struct = new HashMap<String, String>();
		struct.put(CONTACT_NAME, "agencyContact");
		struct.put(AGENCY_NAME, "testAgency");
		struct.put(EMAIL_ADDRESS, "test@mail.com");
		Object[] params = new Object[] { sessionId, struct };

		try {
			client.execute(MODIFY_AGENCY_METHOD, params);
			fail("Agency modified without required 'agencyId' parameter");
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(
							ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS,
							AGENCY_ID), e.getMessage());
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
	private void executeModifyAgencyWithError(Object[] params, String errorMsg)
			throws MalformedURLException {

		try {
			execute(MODIFY_AGENCY_METHOD, params);
			fail(MODIFY_AGENCY_METHOD
					+ " executed successfully, but it shouldn't.");
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
	public void testModifyAgencyGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		final String strGreaterThan255 = TextUtils.getString(256);
		final String strGreaterThan64 = TextUtils.getString(65);

		assertNotNull(agencyId);

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };
		struct.put(AGENCY_ID, agencyId);

		// test advertiserName
		struct.put(AGENCY_NAME, strGreaterThan255);
		executeModifyAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, AGENCY_NAME));

		// test contactName
		struct.remove(AGENCY_NAME);
		struct.put(CONTACT_NAME, strGreaterThan255);
		executeModifyAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CONTACT_NAME));
	}

	/**
	 * Test method with fields that has value less than min
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyAgencyLessThanMinFieldValueError()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);

		// test emailAddress
		struct.put(EMAIL_ADDRESS, "");
		try {
			client.execute(MODIFY_AGENCY_METHOD, new Object[] { sessionId,
					struct });
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.EMAIL_IS_NOT_VALID, e.getMessage());
		}
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyAgencyMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(AGENCY_NAME, "");
		struct.put(CONTACT_NAME, "");
		struct.put(EMAIL_ADDRESS, TextUtils.MIN_ALLOWED_EMAIL);
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) client.execute(MODIFY_AGENCY_METHOD,
				params);
		assertTrue(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyAgencyMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(AGENCY_NAME, TextUtils.getString(255));
		struct.put(CONTACT_NAME, TextUtils.getString(255));
		struct.put(EMAIL_ADDRESS, TextUtils.getString(55) + "@mail.com");
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) client.execute(MODIFY_AGENCY_METHOD,
				params);
		assertTrue(result);
	}

	/**
	 * Try to modify agency with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyAgencyUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, id);
		Object[] params = new Object[] { sessionId, struct };

		try {
			client.execute(MODIFY_AGENCY_METHOD, params);
			fail("Agency modified but shouldn't have");
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, "agencyId"), e
					.getMessage());
		}
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyAgencyWrongTypeError() throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(AGENCY_ID, TextUtils.NOT_INTEGER);
		executeModifyAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_INTEGER, AGENCY_ID));

		struct.put(AGENCY_ID, agencyId);
		struct.put(AGENCY_NAME, TextUtils.NOT_STRING);
		executeModifyAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, AGENCY_NAME));
	}
}
