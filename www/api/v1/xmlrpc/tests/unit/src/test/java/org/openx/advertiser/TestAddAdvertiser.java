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

package org.openx.advertiser;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Add Advertiser method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestAddAdvertiserV1 extends AdvertiserTestCase {

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
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testAddAdvertiserAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		
		assertNotNull(agencyId);
		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(AGENCY_ID, agencyId);
		addAdvertiserParameters.put(ADVERTISER_NAME, "testAdvertiserName");
		addAdvertiserParameters.put(CONTACT_NAME, "testContactName");
		addAdvertiserParameters.put(COMMENTS, "some comments");
		
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		final Integer result = (Integer) execute(ADD_ADVERTISER_METHOD,
				XMLRPCMethodParameters);

		assertNotNull(result);
		try {
			XMLRPCMethodParameters = new Object[] { sessionId, result };
			final Map<String, Object> advertiser = (Map<String, Object>) execute(
					GET_ADVERTISER_METHOD, XMLRPCMethodParameters);

			checkParameter(advertiser, AGENCY_ID, agencyId);
			checkParameter(advertiser, ADVERTISER_NAME, addAdvertiserParameters.get(ADVERTISER_NAME));
			checkParameter(advertiser, CONTACT_NAME, addAdvertiserParameters.get(CONTACT_NAME));
			checkParameter(advertiser, COMMENTS, addAdvertiserParameters.get(COMMENTS));
		} finally {
			deleteAdvertiser(result);
		}
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserWithoutSomeRequiredFields()
			throws MalformedURLException {
		
		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(EMAIL_ADDRESS, "test@mail.com");
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		executeAddAdvertiserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, ADVERTISER_NAME));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddAdvertiserNameFieldGreaterThanMaxValueError()
			throws MalformedURLException, XmlRpcException {

		final String strGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(ADVERTISER_NAME, strGreaterThan255);
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		executeAddAdvertiserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, ADVERTISER_NAME));
	}
	
	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddAdvertiserContactNameFieldGreaterThanMaxValueError()
			throws MalformedURLException, XmlRpcException {

		final String strGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(ADVERTISER_NAME, "Correct advertiser name");
		addAdvertiserParameters.put(CONTACT_NAME, strGreaterThan255);
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		executeAddAdvertiserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CONTACT_NAME));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddAdvertiserEmailFieldGreaterThanMaxValueError()
			throws MalformedURLException, XmlRpcException {

		final String strGreaterThan64 = TextUtils.getEmailString(65);

		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(ADVERTISER_NAME, "Correct advertiser name");
		addAdvertiserParameters.put(CONTACT_NAME, "Jan Kowalski");
		addAdvertiserParameters.put(EMAIL_ADDRESS, strGreaterThan64);
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		executeAddAdvertiserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, EMAIL_ADDRESS));
	}
	
	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddAdvertiserMinValues() throws XmlRpcException,
			MalformedURLException {
		
		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(ADVERTISER_NAME, "testAdvertiser");
		addAdvertiserParameters.put(CONTACT_NAME, "");
		addAdvertiserParameters.put(EMAIL_ADDRESS, TextUtils.MIN_ALLOWED_EMAIL);
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		final Integer result = (Integer) execute(ADD_ADVERTISER_METHOD,
				XMLMethodParameters);
		
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
		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(ADVERTISER_NAME, TextUtils.getString(255));
		addAdvertiserParameters.put(CONTACT_NAME, TextUtils.getString(255));
		addAdvertiserParameters.put(EMAIL_ADDRESS, TextUtils.getEmailString(64));
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		final Integer result = (Integer) execute(ADD_ADVERTISER_METHOD,
				XMLMethodParameters);
		
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
		
		int testAgencyId = createAgency();
		deleteAgency(testAgencyId);
		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(AGENCY_ID, testAgencyId);
		addAdvertiserParameters.put(ADVERTISER_NAME, "testAdvertiserName");
		addAdvertiserParameters.put(CONTACT_NAME, "testContactName");
		addAdvertiserParameters.put(EMAIL_ADDRESS, "lola@openx.org");
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		executeAddAdvertiserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddAdvertiserWrongAdvertiserNameTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(ADVERTISER_NAME, TextUtils.NOT_STRING);
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		executeAddAdvertiserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, ADVERTISER_NAME));
	}
	
	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddAdvertiserWrongAgencyIdTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> addAdvertiserParameters = new HashMap<String, Object>();
		addAdvertiserParameters.put(ADVERTISER_NAME, "test name");
		addAdvertiserParameters.put(AGENCY_ID, TextUtils.NOT_INTEGER);
		Object[] XMLMethodParameters = new Object[] { sessionId, addAdvertiserParameters };
		executeAddAdvertiserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_INTEGER, AGENCY_ID));
	}
}