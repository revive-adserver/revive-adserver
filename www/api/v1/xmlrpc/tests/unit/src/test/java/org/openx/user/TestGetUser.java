/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.user;

import java.net.MalformedURLException;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get User method
 */
public class TestGetUser extends UserTestCase {

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeGetUserWithError(Object[] params, String errorMsg)
			throws MalformedURLException {

		try {
			execute(GET_USER_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method with all fields.
	 *
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetUserAllFields() throws XmlRpcException,
			MalformedURLException {

		Map<String, Object> patternUserAttributes = getUserParams(TEST_DATA_PREFIX);

		Object[] XMLMethodParameters = new Object[] { sessionId, userId };

		try {
			final Map<String, Object> user = (Map<String, Object>) execute(
					GET_USER_METHOD, XMLMethodParameters);

			checkParameter(user, USER_ID, userId);
			checkParameter(user, CONTACT_NAME, patternUserAttributes.get(CONTACT_NAME));
			checkParameter(user, EMAIL_ADDRESS, patternUserAttributes.get(EMAIL_ADDRESS));
			checkParameter(user, LOGIN, patternUserAttributes.get(LOGIN));
			checkParameter(user, PASSWORD, "");
			checkParameter(user, DEFAULT_ACCOUNT_ID, patternUserAttributes.get(DEFAULT_ACCOUNT_ID));
			checkParameter(user, ACTIVE, patternUserAttributes.get(ACTIVE));
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetUserWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] XMLMethodParameters = new Object[] { sessionId };

		executeGetUserWithError(XMLMethodParameters, ErrorMessage.getMessage(ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1")));

	}

	/**
	 * Try to get User with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetUserUnknownIdError() throws XmlRpcException,
			MalformedURLException {

		final Integer userId = createUser(getUserParams("test1_"));
		deleteUser(userId);
		Object[] XMLMethodParameters = new Object[] { sessionId, userId };

		executeGetUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, USER_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetUserWrongUserIdTypeError() throws MalformedURLException,
			XmlRpcException {

		final String userId = TextUtils.NOT_INTEGER;
		Object[] XMLMethodParameters = new Object[] { sessionId, userId};

		executeGetUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
