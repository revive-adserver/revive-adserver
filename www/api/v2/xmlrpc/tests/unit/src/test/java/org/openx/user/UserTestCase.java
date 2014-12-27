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
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.base.WebServiceTestCase;
import org.openx.config.GlobalSettings;

/**
 * Base class for all User web service tests
 */
public class UserTestCase extends WebServiceTestCase {
	protected static final String ADD_USER_METHOD = "ox.addUser";
	protected static final String DELETE_USER_METHOD = "ox.deleteUser";
	protected static final String MODIFY_USER_METHOD = "ox.modifyUser";
	protected static final String GET_USER_METHOD = "ox.getUser";
	protected static final String GET_USER_LIST_BY_ACCOUNT_ID_METHOD = "ox.getUserListByAccountId";
	protected static final String UPDATE_SSO_USER_ID_METHOD = "ox.updateSsoUserId";
	protected static final String UPDATE_USER_EMAIL_BY_SSO_ID_METHOD = "ox.updateUserEmailBySsoId";
	protected static final String LINK_USER_TO_ADVERTISER_METHOD = "ox.linkUserToAdvertiserAccount";
	protected static final String LINK_USER_TO_TRAFFICKER_METHOD = "ox.linkUserToTraffickerAccount";
	protected static final String LINK_USER_TO_MANAGER_METHOD = "ox.linkUserToManagerAccount";

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

        protected static final Integer OA_PERM_SUPER_ACCOUNT = 10;
        protected static final Integer OA_PERM_ZONE_EDIT = 7;
        protected static final Integer OA_PERM_BANNER_EDIT = 4;

	protected static final String TEST_DATA_PREFIX = "test_";

	protected Integer userId = null;

	protected void setUp() throws Exception {
		super.setUp();
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getServiceUrl()));
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
