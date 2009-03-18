/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                             |
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
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.base.WebServiceTestCase;
import org.openx.config.GlobalSettings;

/**
 * Base class for all User web service tests
 *
 * @author Pawel Dachterski <pawel.dachterski@openx.org>
 */
public class UserTestCase extends WebServiceTestCase {
	protected static final String ADD_USER_METHOD = "ox.addUser";
	protected static final String DELETE_USER_METHOD = "ox.deleteUser";
	protected static final String MODIFY_USER_METHOD = "ox.modifyUser";
	protected static final String GET_USER_METHOD = "ox.getUser";
	protected static final String GET_USER_LIST_BY_ACCOUNT_ID_METHOD = "ox.getUserListByAccountId";
	protected static final String UPDATE_SSO_USER_ID_METHOD = "ox.updateSsoUserId";
	protected static final String UPDATE_USER_EMAIL_BY_SSO_ID_METHOD = "ox.updateUserEmailBySsoId";

	protected static final String USER_ID = "userId";
	protected static final String USER_NAME = "userName";
	protected static final String CONTACT_NAME = "contactName";
	protected static final String EMAIL_ADDRESS = "emailAddress";
	protected static final String LOGIN = "username";
	protected static final String PASSWORD = "password";
	protected static final String DEFAULT_ACCOUNT_ID = "defaultAccountId";
	protected static final String ACTIVE = "active";
	protected static final String ACCOUNT_ID = "accountId";
	protected static final String SSO_USER_ID = "ssoUserId";
	protected static final String OLD_SSO_USER_ID = "oldSsoUserId";
	protected static final String NEW_SSO_USER_ID = "newSsoUserId";
	protected static final String SSO_EMAIL = "email";
	
	protected static final String TEST_DATA_PREFIX = "test_";
	
	protected Integer userId = null;

	protected void setUp() throws Exception {
		super.setUp();
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getUserServiceUrl()));
		userId = createUser();
	}

	protected void tearDown() throws Exception {
		deleteUser(userId);
		super.tearDown();
	}

	/**
	 * @return User Id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createUser() throws XmlRpcException,
			MalformedURLException {
		
		return createUser(getUserParams(TEST_DATA_PREFIX));
	}

	/**
	 * @return User Id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createUser(Map<String, Object> params)
			throws XmlRpcException, MalformedURLException {
	//	((XmlRpcClientConfigImpl) client.getClientConfig())
	//			.setServerURL(new URL(GlobalSettings.getUserServiceUrl()));

		Object[] paramsWithId = new Object[] { sessionId, params };
		final Integer result = (Integer) execute(ADD_USER_METHOD, paramsWithId);
		return result;
	}

	/**
	 * @param userId -
	 *            Id of User which will be removed
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public boolean deleteUser(Integer userId) throws XmlRpcException,
			MalformedURLException {
		//((XmlRpcClientConfigImpl) client.getClientConfig())
		//		.setServerURL(new URL(GlobalSettings.getUserServiceUrl()));
		return (Boolean) execute(DELETE_USER_METHOD, new Object[] {
				sessionId, userId });
	}

	public Object execute(String method, Object[] params)
			throws XmlRpcException, MalformedURLException {

		return client.execute(method, params);
	}

	/**
	 * @param prefix
	 * @return default parameters set
	 */
	public Map<String, Object> getUserParams(String prefix) {
		Map<String, Object> userParameters = new HashMap<String, Object>();
		userParameters.put(USER_NAME, prefix + USER_NAME);
		userParameters.put(CONTACT_NAME, prefix + CONTACT_NAME);
		userParameters.put(EMAIL_ADDRESS, prefix + "@mail.com");
		userParameters.put(LOGIN, prefix + LOGIN);
		userParameters.put(PASSWORD, prefix + LOGIN);
		userParameters.put(DEFAULT_ACCOUNT_ID, 1);
		userParameters.put(ACTIVE, 1);
		return userParameters;
	}
}
