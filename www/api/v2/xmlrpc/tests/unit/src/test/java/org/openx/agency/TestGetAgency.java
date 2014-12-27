/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.agency;

import java.net.MalformedURLException;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Agency method
 */
public class TestGetAgency extends AgencyTestCase {

	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetAgencyAllFields() throws XmlRpcException,
			MalformedURLException {

		Map<String, Object> myAgency = getAgencyParams("test1");

		Integer id = createAgency(myAgency);
		Object[] params = new Object[] { sessionId, id };
		try {
			Map<String, Object> agency = (Map<String, Object>) execute(
					GET_AGENCY_METHOD, params);

			checkParameter(agency, AGENCY_ID, id);

			checkParameter(agency, AGENCY_NAME, myAgency.get(AGENCY_NAME));
			checkParameter(agency, CONTACT_NAME, myAgency.get(CONTACT_NAME));
			checkParameter(agency, EMAIL_ADDRESS, myAgency.get(EMAIL_ADDRESS));
		} finally {
			deleteAgency(id);
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
	private void executeGetAgencyWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(GET_AGENCY_METHOD, params);
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
	public void testGetAgencyWithoutSomeRequiredFields()
			throws MalformedURLException {

		Object[] params = new Object[] { sessionId };

		executeGetAgencyWithError(params, ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));

	}

	/**
	 * Try to get advertiser with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetAgencyUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetAgencyWrongTypeError() throws MalformedURLException,
			XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
