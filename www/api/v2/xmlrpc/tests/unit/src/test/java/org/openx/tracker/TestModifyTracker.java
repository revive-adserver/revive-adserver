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
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

public class TestModifyTracker extends TrackerTestCase {

    private Integer trackerId = null;

    @Override
    protected void setUp() throws Exception {
        super.setUp();

        trackerId = createTracker();
    }

    @Override
    protected void tearDown() throws Exception {
        deleteTracker(trackerId);

        super.tearDown();
    }

    private void executeModifyTrackerWithError(Object[] params, String errorMsg)
            throws MalformedURLException {
        try {
            execute(MODIFY_TRACKER_METHOD, params);
            fail(MODIFY_TRACKER_METHOD + " executed successfully, but it shouldn't.");
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testModifyTrackerAllReqFieldsAndSomeOptionalFields()
            throws XmlRpcException, MalformedURLException {

        assertNotNull(trackerId);

        Map<String, Object> myTracker = new HashMap<String, Object>();
        myTracker.put(TRACKER_ID, trackerId);
        myTracker.put(TRACKER_NAME, "test tracker");

        Object[] params = new Object[]{sessionId, myTracker};
        final boolean result = (Boolean) execute(MODIFY_TRACKER_METHOD, params);
        assertTrue(result);

        params = new Object[]{sessionId, trackerId};
        final Map<String, Object> tracker = (Map<String, Object>) execute(
                GET_TRACKER_METHOD, params);

        checkParameter(tracker, TRACKER_ID, trackerId);
        checkParameter(tracker, TRACKER_NAME, myTracker.get(TRACKER_NAME));
    }

    public void testModifyTrackerGreaterThanMaxFieldValueError()
            throws MalformedURLException, XmlRpcException {
        final String strGreaterThan255 = TextUtils.getString(256);

        assertNotNull(trackerId);

        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, trackerId);
        struct.put(TRACKER_NAME, strGreaterThan255);

        Object[] params = new Object[]{sessionId, struct};

        executeModifyTrackerWithError(params, ErrorMessage.getMessage(ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, TRACKER_NAME));
    }

    public void testModifyTrackerMaxValues() throws XmlRpcException,
            MalformedURLException {
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, trackerId);
        struct.put(TRACKER_NAME, TextUtils.getString(255));
        Object[] params = new Object[]{sessionId, struct};
        final Boolean result = (Boolean) execute(MODIFY_TRACKER_METHOD, params);
        assertTrue(result);
    }

    public void testModifyTrackerWrongTypeError() throws MalformedURLException {
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, trackerId);
        Object[] params = new Object[]{sessionId, struct};

        struct.put(TRACKER_NAME, TextUtils.NOT_STRING);
        executeModifyTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.FIELD_IS_NOT_STRING, TRACKER_NAME));
    }
}
