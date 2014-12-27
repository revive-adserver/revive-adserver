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
 * Verify Add User method
 */
public class TestAddUser extends UserTestCase {

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            addUser XMLRPC method parameters
	 * @param errorMsg -
	 *            expected error messages
	 * @throws MalformedURLException
	 */
	private void executeAddUserWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_USER_METHOD, params);
			fail(ADD_USER_METHOD
					+ " should faild, but isn't.");

			deleteUser(result);
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
	public void testAddUserAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> addUserParameters = new HashMap<String, Object>();
		addUserParameters.put(USER_NAME, "user_one");
		addUserParameters.put(CONTACT_NAME, "Jan Kowalski");
		addUserParameters.put(EMAIL_ADDRESS, "jan.kowalski@openx.org");
		addUserParameters.put(LOGIN, "oxp");
		addUserParameters.put(PASSWORD, "oxp");
		addUserParameters.put(DEFAULT_ACCOUNT_ID, 1);
		addUserParameters.put(ACTIVE, "1");

		Object[] XMLMethodParameters = new Object[] { sessionId, addUserParameters };
		final Integer result = (Integer) execute(ADD_USER_METHOD, XMLMethodParameters);
		assertNotNull(result);
		deleteUser(result);
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testAddBannerWithoutSomeRequiredFields()
			throws MalformedURLException {

		Map<String, Object> addUserParameters = new HashMap<String, Object>();
		addUserParameters.put(USER_NAME, "Jan Kowalski");
		addUserParameters.put(CONTACT_NAME, "Jan Kowalski");
		addUserParameters.put(EMAIL_ADDRESS, "jan.kowalski@openx.org");
		addUserParameters.put(LOGIN, "openx" + (int) Math.random());
		addUserParameters.put(PASSWORD, "openx");
		addUserParameters.put(ACTIVE, "1");

		Object[] XMLMethodParameters = new Object[] { sessionId, addUserParameters };

		executeAddUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, DEFAULT_ACCOUNT_ID));
	}

	/**
	 * Test method with User Name already exists.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddUserWithUserNameAlreadyExists()
			throws MalformedURLException, XmlRpcException {

		Map<String, Object> addUserParameters = new HashMap<String, Object>();
		addUserParameters.put(USER_NAME, "Jan Kowalski");
		addUserParameters.put(CONTACT_NAME, "Jan Kowalski");
		addUserParameters.put(EMAIL_ADDRESS, "jan.kowalski@openx.org");
		addUserParameters.put(LOGIN, "test_openx");
		addUserParameters.put(PASSWORD, "openx");
		addUserParameters.put(DEFAULT_ACCOUNT_ID, 1);
		addUserParameters.put(ACTIVE, "1");

		Object[] XMLMethodParameters = new Object[] { sessionId, addUserParameters };
		final Integer result = (Integer) execute(ADD_USER_METHOD, XMLMethodParameters);
		assertNotNull(result);

		executeAddUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.USERNAME_MUST_BE_UNIQUE));

		deleteUser(result);
	}

	/**
	 * Test method with contactName value greater than max allowed.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddUserContactNameGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		final String stringGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> addUserParameters = new HashMap<String, Object>();
		addUserParameters.put(USER_NAME, "user_one");
		addUserParameters.put(CONTACT_NAME, stringGreaterThan255);
		addUserParameters.put(EMAIL_ADDRESS, "jan.kowalski@openx.org");
		addUserParameters.put(LOGIN, "oxp");
		addUserParameters.put(PASSWORD, "oxp");
		addUserParameters.put(DEFAULT_ACCOUNT_ID, 1);
		addUserParameters.put(ACTIVE, "1");

		Object[] XMLMethodParameters = new Object[] { sessionId, addUserParameters };

		executeAddUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CONTACT_NAME));
	}

	/**
	 * Test method with email value greater than max allowed.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddUserEmailGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		final String emailGreaterThan64 = TextUtils.getEmailString(65);

		Map<String, Object> addUserParameters = new HashMap<String, Object>();
		addUserParameters.put(USER_NAME, "user_one");
		addUserParameters.put(CONTACT_NAME, "Jan Kowalski");
		addUserParameters.put(EMAIL_ADDRESS, emailGreaterThan64);
		addUserParameters.put(LOGIN, "oxp");
		addUserParameters.put(PASSWORD, "oxp");
		addUserParameters.put(DEFAULT_ACCOUNT_ID, 1);
		addUserParameters.put(ACTIVE, "1");

		Object[] XMLMethodParameters = new Object[] { sessionId, addUserParameters };

		executeAddUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, EMAIL_ADDRESS));
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddUserMinValues() throws XmlRpcException,
			MalformedURLException {

		Map<String, Object> addUserParameters = new HashMap<String, Object>();
		addUserParameters.put(USER_NAME, "");
		addUserParameters.put(CONTACT_NAME, TextUtils.MIN_ALLOWED_STRING);
		addUserParameters.put(EMAIL_ADDRESS, TextUtils.MIN_ALLOWED_EMAIL);
		addUserParameters.put(LOGIN, TextUtils.MIN_ALLOWED_STRING);
		addUserParameters.put(PASSWORD, TextUtils.MIN_ALLOWED_STRING);
		addUserParameters.put(DEFAULT_ACCOUNT_ID, 1);
		addUserParameters.put(ACTIVE, "1");

		Object[] XMLMethodParameters = new Object[] { sessionId, addUserParameters };

		final Integer result = (Integer) execute(ADD_USER_METHOD, XMLMethodParameters);
		assertNotNull(result);
		deleteUser(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddUserWithMaxAllowedValues()
		throws MalformedURLException, XmlRpcException {

		final String emailGreaterThan64 = TextUtils.getEmailString(64);
		final String stringGreaterThan255 = TextUtils.getString(255);

		Map<String, Object> addUserParameters = new HashMap<String, Object>();
		addUserParameters.put(USER_NAME, "user_one");
		addUserParameters.put(CONTACT_NAME, stringGreaterThan255);
		addUserParameters.put(EMAIL_ADDRESS, emailGreaterThan64);
		addUserParameters.put(LOGIN, "oxp");
		addUserParameters.put(PASSWORD, "oxp");
		addUserParameters.put(DEFAULT_ACCOUNT_ID, 1);
		addUserParameters.put(ACTIVE, "1");

		Object[] XMLMethodParameters = new Object[] { sessionId, addUserParameters };

		final Integer result = (Integer) execute(ADD_USER_METHOD, XMLMethodParameters);
		assertNotNull(result);

		deleteUser(result);
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddUserWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> addUserParameters = new HashMap<String, Object>();
		addUserParameters.put(USER_NAME, "Jas Fasola");
		addUserParameters.put(CONTACT_NAME, TextUtils.NOT_STRING);
		addUserParameters.put(EMAIL_ADDRESS, "jan@openx.org");
		addUserParameters.put(LOGIN, "jan");
		addUserParameters.put(PASSWORD, "jan");
		addUserParameters.put(DEFAULT_ACCOUNT_ID, 1);
		addUserParameters.put(ACTIVE, "1");

		Object[] params = new Object[] { sessionId, addUserParameters };

		executeAddUserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, CONTACT_NAME));
	}
}
