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
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
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
