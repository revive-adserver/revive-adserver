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

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Delete Agency method
 */
public class TestDeleteAgency extends AgencyTestCase {

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeDeleteAgencyWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(DELETE_AGENCY_METHOD, params);
			fail(DELETE_AGENCY_METHOD
					+ " executed successfully, but it shouldn't.");
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
	public void testDeleteAgencyAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		int agencyId = createAgency();

		assertNotNull("Can't add agency.", agencyId);

		final Boolean result = (Boolean) client.execute(DELETE_AGENCY_METHOD,
				new Object[] { sessionId, agencyId });

		assertTrue("Can't delete agency.", result);
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyWithoutSomeRequiredFields()
			throws XmlRpcException, MalformedURLException {
		int agencyId = createAgency();

		executeDeleteAgencyWithError(new Object[] { sessionId }, ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1"));
		deleteAgency(agencyId);
	}

	/**
	 * Test method with all fields
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyAllFields() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAgency();
		boolean result = deleteAgency(id);
		assertTrue(result);
	}

	/**
	 * Try to delete agency with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		Object[] params = new Object[] { sessionId, id };

		executeDeleteAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));

	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyWrongTypeError() throws MalformedURLException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeDeleteAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
