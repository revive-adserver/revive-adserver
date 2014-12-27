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

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Delete Banner method
 */
public class TestDeleteUser extends UserTestCase {

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            deleteUser XMLRPC method parameters
	 * @param errorMsg -
	 *            expected error messages
	 * @throws MalformedURLException
	 */
	private void executeDeleteUserWithError(Object[] params, String errorMsg)
		throws MalformedURLException {

		try {
			execute(DELETE_USER_METHOD, params);
			fail(DELETE_USER_METHOD
					+ " should faild, but isn't.");

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
	public void testDeleteUserAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		int userId = createUser(getUserParams("deltest_"));
		assertNotNull("Can't add User.", userId);
		final Boolean result = (Boolean) execute(DELETE_USER_METHOD,
				new Object[] { sessionId, userId });

		assertTrue("Can't delete user.", result);
	}

	/**
	 * Test method without required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testDeleteUserWithoutSomeRequiredFields()
			throws MalformedURLException {

		Object[] XMLMethodParameters = new Object[] { sessionId };

		executeDeleteUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));
	}

	/**
	 * Try to User with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteBannerUnknownIdError() throws XmlRpcException,
			MalformedURLException {

		final Integer userId = createUser(getUserParams("deltest_"));
		deleteUser(userId);
		Object[] XMLMethodParameters = new Object[] { sessionId, userId };

		executeDeleteUserWithError(XMLMethodParameters, ErrorMessage
				.getMessage(ErrorMessage.getMessage(
						ErrorMessage.UNKNOWN_ID_ERROR, USER_ID)));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testDeleteBannerWrongTypeError() throws MalformedURLException {
		Object[] XMLMethodParameters = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeDeleteUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}