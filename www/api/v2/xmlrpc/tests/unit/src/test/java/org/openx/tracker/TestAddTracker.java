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
package org.openx.tracker;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
public class TestAddTracker extends TrackerTestCase {

    private void executeAddTrackerWithError(Object[] params, String errorMsg)
            throws MalformedURLException {
        try {
            Integer result = (Integer) execute(ADD_TRACKER_METHOD, params);
            fail(ADD_TRACKER_METHOD + " executed successfully, but it shouldn't.");
            deleteTracker(result);
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testAddTrackerAllReqAndSomeOptionalFields()
            throws XmlRpcException, MalformedURLException {

        assertNotNull(clientId);
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(CLIENT_ID, clientId);
        struct.put(TRACKER_NAME, "testTracker");
        struct.put(DESCRIPTION, "I am tracker");

        Object[] params = new Object[]{sessionId, struct};
        final Integer result = (Integer) execute(ADD_TRACKER_METHOD, params);
        assertNotNull(result);
        deleteTracker(result);
    }

    public void testAddTrackerWithoutSomeRequiredFields()
            throws MalformedURLException {
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(CLIENT_ID, clientId);

        Object[] params = new Object[]{sessionId, struct};

        executeAddTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, TRACKER_NAME));
    }

    public void testAddTrackerMaxValues() throws XmlRpcException,
            MalformedURLException {
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(CLIENT_ID, clientId);
        struct.put(TRACKER_NAME, TextUtils.getString(255));
        struct.put(DESCRIPTION, TextUtils.getString(255));
        Object[] params = new Object[]{sessionId, struct};
        final Integer result = (Integer) execute(ADD_TRACKER_METHOD, params);

        assertNotNull(result);
        deleteTracker(result);
    }

    public void testAddTrackerNameFieldGreaterThanMaxValueError()
            throws MalformedURLException, XmlRpcException {

        final String strGreaterThan255 = TextUtils.getString(256);

        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(CLIENT_ID, clientId);
        struct.put(TRACKER_NAME, strGreaterThan255);
        Object[] XMLMethodParameters = new Object[]{sessionId, struct};
        executeAddTrackerWithError(XMLMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, TRACKER_NAME));
    }

    public void testAddTrackerUnknownIdError() throws MalformedURLException,
            XmlRpcException {

        int testClientId = createAdvertiser();
        deleteAdvertiser(testClientId);
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(CLIENT_ID, testClientId);
        struct.put(TRACKER_NAME, "testTrackerName");
        Object[] params = new Object[]{sessionId, struct};
        executeAddTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, ADVERTISER_ID));
    }

    public void testAddTrackerWrongTrackerNameTypeError() throws MalformedURLException,
            XmlRpcException {

        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(CLIENT_ID, clientId);
        struct.put(TRACKER_NAME, TextUtils.NOT_STRING);
        Object[] params = new Object[]{sessionId, struct};
        executeAddTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.FIELD_IS_NOT_STRING, TRACKER_NAME));
    }
}
