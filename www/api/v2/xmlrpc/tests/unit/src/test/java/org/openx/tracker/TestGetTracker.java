/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.tracker;

import java.net.MalformedURLException;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

public class TestGetTracker extends TrackerTestCase {

    private void executeGetTrackerWithError(Object[] params, String errorMsg)
            throws MalformedURLException {
        try {
            @SuppressWarnings("unused")
            Map<String, Object> result = (Map<String, Object>) execute(
                    GET_TRACKER_METHOD, params);
            fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testGetTrackerAllFields() throws XmlRpcException,
            MalformedURLException {
        Map<String, Object> myTracker = getTrackerParams("test1");
        Integer id = createTracker(myTracker);
        Object[] params = new Object[]{sessionId, id};

        try {
            final Map<String, Object> tracker = (Map<String, Object>) execute(
                    GET_TRACKER_METHOD, params);

            checkParameter(tracker, TRACKER_ID, id);
            checkParameter(tracker, CLIENT_ID, myTracker.get(CLIENT_ID));
            checkParameter(tracker, TRACKER_NAME, myTracker.get(TRACKER_NAME));
            checkParameter(tracker, DESCRIPTION, myTracker.get(DESCRIPTION));
        } finally {
            deleteTracker(id);
        }
    }

    public void testGetTrackerWithoutSomeRequiredFields()
            throws MalformedURLException {
        Object[] params = new Object[]{sessionId};

        executeGetTrackerWithError(params, ErrorMessage.getMessage(ErrorMessage.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1")));

    }

    public void testGetTrackerUnknownIdError() throws XmlRpcException,
            MalformedURLException {
        final Integer id = createTracker();
        deleteTracker(id);
        Object[] params = new Object[]{sessionId, id};

        executeGetTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, TRACKER_ID));
    }

    public void testGetTrackerWrongTypeError() throws MalformedURLException,
            XmlRpcException {
        Object[] params = new Object[]{sessionId, TextUtils.NOT_INTEGER};

        executeGetTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
    }
}
