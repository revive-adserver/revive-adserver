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
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get User method
 */
public class TestGetUserListByAccountId extends UserTestCase {

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeGetUserListByAccountIdWithError(Object[] params, String errorMsg)
			throws MalformedURLException {

		try {
			execute(GET_USER_LIST_BY_ACCOUNT_ID_METHOD, params);
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
	public void testGetUserListByAccountIdAllFields() throws XmlRpcException,
			MalformedURLException {

		final int usersCount = 3;

		Map<Integer, Map<String, Object>> patternUsersAttributes = new HashMap<Integer, Map<String, Object>>();
		for (int i = 0; i < usersCount; i++) {
			Map<String, Object> patternUserAttributes = getUserParams(TEST_DATA_PREFIX + i);
			patternUsersAttributes.put(createUser(patternUserAttributes), patternUserAttributes);
		}

		try {
			final Object[] users = (Object[]) execute(GET_USER_LIST_BY_ACCOUNT_ID_METHOD,
					new Object[] { sessionId, 1 });

			assertEquals("Not correct count created users", usersCount, patternUsersAttributes.size());
			//TODO: "users.length-2" because 1 default user from test setup and 1 admin user, refactor to use unique accountID
			assertEquals("Not correct count return users", usersCount, users.length-2);

			for (Object user : users) {
				Integer userId = (Integer) ((Map) user).get(USER_ID);
				Map<String, Object> patternUserAttributes = patternUsersAttributes.get(userId);
				if (patternUserAttributes != null) {
					checkParameter((Map) user, USER_ID, userId);
					checkParameter((Map) user, CONTACT_NAME, patternUserAttributes.get(CONTACT_NAME));
					checkParameter((Map) user, EMAIL_ADDRESS, patternUserAttributes.get(EMAIL_ADDRESS));
					checkParameter((Map) user, LOGIN, patternUserAttributes.get(LOGIN));
					checkParameter((Map) user, PASSWORD, "");
					checkParameter((Map) user, DEFAULT_ACCOUNT_ID, patternUserAttributes.get(DEFAULT_ACCOUNT_ID));
					checkParameter((Map) user, ACTIVE, patternUserAttributes.get(ACTIVE));
					deleteUser(userId);
				}
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetUserListByAccountIdWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] XMLMethodParameters = new Object[] { sessionId };

		executeGetUserListByAccountIdWithError(XMLMethodParameters, ErrorMessage.getMessage(ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1")));
	}

	/**
	 * Try to get Users with unknown accountId
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetUserListByAccountIdUnknownIdError() throws XmlRpcException,
			MalformedURLException {

		final Integer accountId = new Integer(111111111);
		//TODO: Refactor to use unique not existing accountId
		Object[] XMLMethodParameters = new Object[] { sessionId, accountId };
		executeGetUserListByAccountIdWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ACCOUNT_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetUserListByAccountIdWrongUserIdTypeError() throws MalformedURLException,
			XmlRpcException {

		final String accountId = TextUtils.NOT_INTEGER;
		Object[] XMLMethodParameters = new Object[] { sessionId, accountId};

		executeGetUserListByAccountIdWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
