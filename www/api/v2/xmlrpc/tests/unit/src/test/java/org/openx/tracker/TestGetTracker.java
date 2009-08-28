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
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
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
