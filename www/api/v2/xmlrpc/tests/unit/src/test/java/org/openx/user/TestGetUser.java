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
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get User method
 *
 * @author     Pawel Dachterski <pawel.dachterski@openx.org>
 */
public class TestGetUserV2 extends UserTestCase {

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
