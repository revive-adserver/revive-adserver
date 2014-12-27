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
import org.openx.base.WebServiceTestCase;
import org.openx.config.GlobalSettings;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Auth User method
 */
public class TestAuthUser extends WebServiceTestCase {

	private String sessionId;

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            addUser XMLRPC method parameters
	 * @param errorMsg -
	 *            expected error messages
	 * @throws MalformedURLException
	 */
	private void executeLogOnUserWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			sessionId = (String) client.execute(LOGON_METHOD, params);
			fail(LOGON_METHOD
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
	public void testLogOnUserCorrectCredentials()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLMethodParameters = new Object[] {
				GlobalSettings.getUserName(), GlobalSettings.getPassword() };

		sessionId = (String) client.execute(LOGON_METHOD, XMLMethodParameters);
		assertNotNull(sessionId);
		assertTrue(sessionId.matches("phpads[a-z|0-9]{14}.[0-9]{8}"));
	}

	/**
	 * Test method with wrong user name.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLogOnUserWrongUserName()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLMethodParameters = new Object[] {
				"", GlobalSettings.getPassword() };

		executeLogOnUserWithError(XMLMethodParameters, ErrorMessage.USERNAME_OR_PASSWORD_NOT_CORRECT);
	}

	/**
	 * Test method with wrong password.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLogOnUserWrongPassword()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLMethodParameters = new Object[] {
				GlobalSettings.getUserName(), "" };

		executeLogOnUserWithError(XMLMethodParameters, ErrorMessage.USERNAME_OR_PASSWORD_NOT_CORRECT);
	}

	/**
	 * Test method with wrong userName and password.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLogOnUserWrongUserNameAndPassword()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLMethodParameters = new Object[] {
				"", "" };

		executeLogOnUserWithError(XMLMethodParameters, ErrorMessage.USERNAME_OR_PASSWORD_NOT_CORRECT);
	}

	/**
	 * Test method with wrong type.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLogOnUserWrongTypeUserName()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLMethodParameters = new Object[] {
				TextUtils.NOT_STRING, GlobalSettings.getPassword() };

		executeLogOnUserWithError(XMLMethodParameters, ErrorMessage.getMessage(ErrorMessage.INCORRECT_PARAMETERS_WANTED_STRING_GOT_INT, "1"));
	}

	/**
	 * Test method with wrong type.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLogOnUserWrongTypePassword()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLMethodParameters = new Object[] {
				GlobalSettings.getPassword(), TextUtils.NOT_STRING };

		executeLogOnUserWithError(XMLMethodParameters, ErrorMessage.getMessage(ErrorMessage.INCORRECT_PARAMETERS_WANTED_STRING_GOT_INT, "2"));
	}

	/**
	 * Test method with wrong parameter count.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLogOnUserWrongParameterCount()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLMethodParameters = new Object[] {
				GlobalSettings.getUserName()};

		executeLogOnUserWithError(XMLMethodParameters, ErrorMessage.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));
	}
}
