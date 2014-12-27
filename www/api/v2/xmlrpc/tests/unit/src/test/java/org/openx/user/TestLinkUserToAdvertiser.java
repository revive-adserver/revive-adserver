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

public class TestLinkUserToAdvertiser extends UserTestCase {

    protected Integer advertiserId = null;
    protected Integer advertiserAccountId = null;

    protected void setUp() throws Exception {
        super.setUp();

        advertiserId = createAdvertiser();
        advertiserAccountId = getAdvertiserAccountId(advertiserId);
    }

    protected void tearDown() throws Exception {

        deleteAdvertiser(advertiserId);

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
    private void executeLinkUserToAdvertiserWithError(Object[] params, String errorMsg)
            throws MalformedURLException {

        try {
            execute(LINK_USER_TO_ADVERTISER_METHOD, params);
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
    public void testLinkUserToAdvertiserAllReqAndSomeOptionalFields()
            throws XmlRpcException, MalformedURLException {

        Object[] perms = new Object[]{OA_PERM_SUPER_ACCOUNT};
        Object[] params = new Object[]{sessionId, userId, advertiserAccountId, perms};
        final Boolean result = (Boolean) client.execute(LINK_USER_TO_ADVERTISER_METHOD, params);

        assertTrue(result);
    }

    public void testLinkUserToAdvertiserUnknownUserIdError() throws MalformedURLException,
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

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, userId, advertiserAccountId};

        executeLinkUserToAdvertiserWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, USER_ID));
    }

// Commented because of OX-4106
//    public void testLinkUserToAdvertiserUnknownAdvertiserIdError() throws MalformedURLException,
//            XmlRpcException {
//
//        Integer advertiserId = createAdvertiser();
//        Integer advertiserAccountId = getAdvertiserAccountId(advertiserId);
//        assertNotNull(advertiserAccountId);
//        deleteAdvertiser(advertiserId);
//
//        Object[] XMLRPCMethodParameters = new Object[]{sessionId, userId, advertiserAccountId};
//
//        executeLinkUserToAdvertiserWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
//                ErrorMessage.UNKNOWN_ID_ERROR, ACCOUNT_ID));
//    }

    public void testLinkUserToAdvertiserAccountIdWrongTypeError() throws MalformedURLException,
            XmlRpcException {

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, userId, TextUtils.NOT_INTEGER};

        executeLinkUserToAdvertiserWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "3"));
    }

    public void testLinkUserToAdvertiserUserIdWrongTypeError() throws MalformedURLException,
            XmlRpcException {

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, TextUtils.NOT_INTEGER, advertiserAccountId};

        executeLinkUserToAdvertiserWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
    }


    private Integer createAdvertiser()
            throws XmlRpcException, MalformedURLException {

        ((XmlRpcClientConfigImpl) client.getClientConfig()).setServerURL(new URL(GlobalSettings.getServiceUrl()));

        Map<String, Object> params = new HashMap<String, Object>();
        params.put("advertiserName", "advertiser");
        params.put("contactName", "contact");
        params.put("emailAddress", "test@mail.com");

        Object[] paramsWithId = new Object[]{sessionId, params};
        final Integer result = (Integer) client.execute("ox.addAdvertiser", paramsWithId);

        return result;
    }

    public boolean deleteAdvertiser(Integer id) throws XmlRpcException,
            MalformedURLException {

        ((XmlRpcClientConfigImpl) client.getClientConfig()).setServerURL(new URL(GlobalSettings.getServiceUrl()));

        final Boolean result = (Boolean) client.execute(
                "ox.deleteAdvertiser", new Object[]{sessionId, id});

        assertTrue(result);
        return result;
    }

    private Integer getAdvertiserAccountId(Integer id) throws XmlRpcException,
            MalformedURLException {

        Object[] params = new Object[]{sessionId, id};

        Map<String, Object> advertiser = (Map<String, Object>) execute(
                "ox.getAdvertiser", params);

        return (Integer) advertiser.get("accountId");
    }
}
