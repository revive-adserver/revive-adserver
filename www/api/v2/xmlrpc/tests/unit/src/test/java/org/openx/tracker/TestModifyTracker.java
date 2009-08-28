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
