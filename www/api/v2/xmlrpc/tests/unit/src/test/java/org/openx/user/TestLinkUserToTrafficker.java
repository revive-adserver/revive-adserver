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
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.config.GlobalSettings;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 *
 * @author     David Keen <david.keen@openx.org>
 */
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
