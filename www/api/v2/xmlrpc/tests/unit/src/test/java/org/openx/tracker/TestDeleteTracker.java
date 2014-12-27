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
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

public class TestDeleteTracker extends TrackerTestCase {

    private void executeDeleteTrackerWithError(Object[] params, String errorMsg)
            throws MalformedURLException {
        try {
            execute(DELETE_TRACKER_METHOD, params);
            fail(DELETE_TRACKER_METHOD + " executed successfully, but it shouldn't.");
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testDeleteChannel() throws XmlRpcException, MalformedURLException {
        int trackerId = createTracker();
        assertNotNull("Can't add tracker.", trackerId);
        final Boolean result = deleteTracker(trackerId);
        assertTrue("Can't delete tracker.", result);
    }

    public void testDeleteTrackerWithoutSomeRequiredFields() throws MalformedURLException {
        Object[] params = new Object[]{sessionId};

        executeDeleteTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));
    }

    public void testDeleteTrackerUnknownIdError() throws XmlRpcException,
            MalformedURLException {
        final Integer id = createTracker();
        deleteTracker(id);
        Object[] params = new Object[]{sessionId, id};

        executeDeleteTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, TRACKER_ID));
    }

    public void testDeleteTrackerWrongTypeError() throws MalformedURLException {
        Object[] params = new Object[]{sessionId, TextUtils.NOT_INTEGER};

        executeDeleteTrackerWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
    }
}
