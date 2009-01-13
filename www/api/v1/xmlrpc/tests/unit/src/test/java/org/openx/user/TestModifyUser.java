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
$Id: TestModifyUser.java 16124 2008-02-11 18:16:06Z andrew.hill@openads.org $
*/

package org.openx.user;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Modify User method
 *
 * @author     Pawel Dachterski <pawel.dachterski@openx.org>
 */
public class TestModifyUser extends UserTestCase {

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            modifyUser XMLRPC method parameters
	 * @param errorMsg -
	 *            expected error messages
	 * @throws MalformedURLException
	 */
	private void executeModifyUserWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(MODIFY_USER_METHOD, params);
			fail(MODIFY_USER_METHOD
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
	public void testModifyUserAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		
		Map<String, Object> modifyUserParameters = new HashMap<String, Object>();
		modifyUserParameters.put(USER_ID, userId);
		modifyUserParameters.put(USER_NAME, "user_one");
		modifyUserParameters.put(CONTACT_NAME, "Jan Kowalski");
		modifyUserParameters.put(EMAIL_ADDRESS, "jan.kowalski@openx.org");
		modifyUserParameters.put(LOGIN, "oxp");
		modifyUserParameters.put(PASSWORD, "oxp");
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyUserParameters };
		final boolean result = (Boolean) execute(MODIFY_USER_METHOD, XMLMethodParameters);
		assertTrue(result);
	}
	
	/**
	 * Test method without userId required field.
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyUserWithoutUserIdRequiredField()
			throws MalformedURLException {
		
		Map<String, Object> modifyUserParameters = new HashMap<String, Object>();
		modifyUserParameters.put(USER_NAME, "user_two");
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyUserParameters };
		executeModifyUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, USER_ID));
	}
	
	/**
	 * Try to modify user with non existing userId
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyUserUnknownIdError() throws XmlRpcException,
			MalformedURLException {

		Integer userId = createUser(getUserParams("modifyTest"));
		deleteUser(userId);
		Map<String, Object> modifyUserParameters = new HashMap<String, Object>();
		modifyUserParameters.put(USER_ID, userId);
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyUserParameters };
		executeModifyUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, USER_ID));

	}
	
	/**
	 * Test method with contactName value greater than max allowed.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testModifyUserContactNameGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		final String stringGreaterThan255 = TextUtils.getString(256);
		Map<String, Object> modifyUserParameters = new HashMap<String, Object>();
		modifyUserParameters.put(USER_ID, userId);
		modifyUserParameters.put(CONTACT_NAME, stringGreaterThan255);
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyUserParameters };
		executeModifyUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CONTACT_NAME));
	}

	/**
	 * Test method with email value greater than max allowed.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testModifyUserEmailGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		final String emailGreaterThan64 = TextUtils.getEmailString(65);
		Map<String, Object> modifyUserParameters = new HashMap<String, Object>();
		modifyUserParameters.put(USER_ID, userId);
		modifyUserParameters.put(EMAIL_ADDRESS, emailGreaterThan64);
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyUserParameters };
		executeModifyUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, EMAIL_ADDRESS));
	}
	
	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyUserMinValues() throws XmlRpcException,
			MalformedURLException {
		
		Map<String, Object> modifyUserParameters = new HashMap<String, Object>();
		modifyUserParameters.put(USER_ID, userId);
		modifyUserParameters.put(USER_NAME, "");
		modifyUserParameters.put(CONTACT_NAME, "");
		modifyUserParameters.put(EMAIL_ADDRESS, "");
		modifyUserParameters.put(LOGIN, "");
		modifyUserParameters.put(PASSWORD, "");
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyUserParameters };
		final boolean result = (Boolean) execute(MODIFY_USER_METHOD, XMLMethodParameters);
		assertTrue(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyUserWithMaxAllowedValues()
		throws MalformedURLException, XmlRpcException {
	
		final String emailGreaterThan64 = TextUtils.getEmailString(64);
		final String stringGreaterThan255 = TextUtils.getString(255);
		Map<String, Object> modifyUserParameters = new HashMap<String, Object>();
		modifyUserParameters.put(USER_ID, userId);
		modifyUserParameters.put(CONTACT_NAME, stringGreaterThan255);
		modifyUserParameters.put(EMAIL_ADDRESS, emailGreaterThan64);
		modifyUserParameters.put(LOGIN, "oxp");
		modifyUserParameters.put(PASSWORD, "oxp");
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyUserParameters };
		final boolean result = (Boolean) execute(MODIFY_USER_METHOD, XMLMethodParameters);
		assertTrue(result);
	}
}