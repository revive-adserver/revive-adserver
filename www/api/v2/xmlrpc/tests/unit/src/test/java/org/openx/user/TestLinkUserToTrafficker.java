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
import org.openx.config.GlobalSettings;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

public class TestLinkUserToTrafficker extends UserTestCase {

    protected Integer traffickerId = null;
    protected Integer traffickerAccountId = null;

    protected void setUp() throws Exception {
        super.setUp();

        traffickerId = createTrafficker();
        traffickerAccountId = getTraffickerAccountId(traffickerId);
    }

    protected void tearDown() throws Exception {

        deleteTrafficker(traffickerId);

        super.tearDown();
    }

    /**
     * Execute test method with error
     *
     * @param params -
     *            parameters for test method
     * @param errorMsg -
     *            true error messages
     * @throws MalformedURLException
     */
    private void executeLinkUserToTraffickerWithError(Object[] params, String errorMsg)
            throws MalformedURLException {

        try {
            execute(LINK_USER_TO_TRAFFICKER_METHOD, params);
            fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    /**
     * Test method with all required fields and some optional.
     *
     * @throws XmlRpcException
     * @throws MalformedURLException
     */
    public void testLinkUserToTraffickerAllReqAndSomeOptionalFields()
            throws XmlRpcException, MalformedURLException {

        Object[] perms = new Object[]{OA_PERM_SUPER_ACCOUNT};
        Object[] params = new Object[]{sessionId, userId, traffickerAccountId, perms};
        final Boolean result = (Boolean) client.execute(LINK_USER_TO_TRAFFICKER_METHOD, params);

        assertTrue(result);
    }

    public void testLinkUserToTraffickerUnknownUserIdError() throws MalformedURLException,
            XmlRpcException {

        String prefix = "new";
        Map<String, Object> userParameters = new HashMap<String, Object>();
        userParameters.put(USER_NAME, prefix + USER_NAME);
        userParameters.put(CONTACT_NAME, prefix + CONTACT_NAME);
        userParameters.put(EMAIL_ADDRESS, prefix + "@mail.com");
        userParameters.put(LOGIN, prefix + LOGIN);
        userParameters.put(PASSWORD, prefix + LOGIN);
        userParameters.put(DEFAULT_ACCOUNT_ID, 1);
        userParameters.put(ACTIVE, 1);

        Integer userId = createUser(userParameters);
        assertNotNull(userId);
        deleteUser(userId);

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, userId, traffickerAccountId};

        executeLinkUserToTraffickerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, USER_ID));
    }

    public void testLinkUserToTraffickerAccountIdWrongTypeError() throws MalformedURLException,
            XmlRpcException {

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, userId, TextUtils.NOT_INTEGER};

        executeLinkUserToTraffickerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "3"));
    }

    public void testLinkUserToTraffickerUserIdWrongTypeError() throws MalformedURLException,
            XmlRpcException {

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, TextUtils.NOT_INTEGER, traffickerAccountId};

        executeLinkUserToTraffickerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
    }


    private Integer createTrafficker()
            throws XmlRpcException, MalformedURLException {

        ((XmlRpcClientConfigImpl) client.getClientConfig()).setServerURL(new URL(GlobalSettings.getServiceUrl()));

        Map<String, Object> params = new HashMap<String, Object>();
        params.put("publisherName", "publisher");
        params.put("contactName", "contact");
        params.put("emailAddress", "test@mail.com");

        Object[] paramsWithId = new Object[]{sessionId, params};
        final Integer result = (Integer) client.execute("ox.addPublisher", paramsWithId);

        return result;
    }

    public boolean deleteTrafficker(Integer id) throws XmlRpcException,
            MalformedURLException {

        ((XmlRpcClientConfigImpl) client.getClientConfig()).setServerURL(new URL(GlobalSettings.getServiceUrl()));

        final Boolean result = (Boolean) client.execute(
                "ox.deletePublisher", new Object[]{sessionId, id});

        assertTrue(result);
        return result;
    }

    private Integer getTraffickerAccountId(Integer id) throws XmlRpcException,
            MalformedURLException {

        Object[] params = new Object[]{sessionId, id};

        Map<String, Object> trafficker = (Map<String, Object>) execute(
                "ox.getPublisher", params);

        return (Integer) trafficker.get("accountId");
    }
}
