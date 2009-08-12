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

package org.openx.user;

import java.net.MalformedURLException;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.base.WebServiceTestCase;
import org.openx.config.GlobalSettings;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Auth User method
 *
 * @author     Pawel Dachterski <pawel.dachterski@openx.org>
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
