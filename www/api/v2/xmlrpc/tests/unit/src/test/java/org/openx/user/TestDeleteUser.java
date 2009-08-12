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
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Delete Banner method
 *
 * @author     Pawel Dachterski <pawel.dachterski@openx.org>
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
	public void testDeleteUserUnknownIdError() throws XmlRpcException,
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
	public void testDeleteUserWrongTypeError() throws MalformedURLException {
		Object[] XMLMethodParameters = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeDeleteUserWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}