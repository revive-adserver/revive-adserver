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
package org.openx.variable;

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
public class TestAddVariable extends VariableTestCase {

    private void executeAddVariableWithError(Object[] params, String errorMsg)
            throws MalformedURLException {
        try {
            Integer result = (Integer) execute(ADD_VARIABLE_METHOD, params);
            fail(ADD_VARIABLE_METHOD + " executed successfully, but it shouldn't.");
            deleteVariable(result);
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testAddVariableAllReqAndSomeOptionalFields()
            throws XmlRpcException, MalformedURLException {

        assertNotNull(trackerId);
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, trackerId);
        struct.put(VARIABLE_NAME, "testVariable");
        struct.put(DESCRIPTION, "I am variable");

        Object[] params = new Object[]{sessionId, struct};
        final Integer result = (Integer) execute(ADD_VARIABLE_METHOD, params);
        assertNotNull(result);
        deleteVariable(result);
    }

    public void testAddVariableWithoutSomeRequiredFields()
            throws MalformedURLException {
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, trackerId);

        Object[] params = new Object[]{sessionId, struct};

        executeAddVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, VARIABLE_NAME));
    }

    public void testAddVariableMaxValues() throws XmlRpcException,
            MalformedURLException {
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, trackerId);

        // To allow for the: var VARIABLE_NAME = escape(\\''%%VARIABLE_NAME%%\\'')
        // that is set in variablecode we must set VARIABLE_NAME length to be:
        // 250 = (33 + VAR_NAME_LEN) + VAR_NAME_LEN
        // --> 217 / 2 = 108
        struct.put(VARIABLE_NAME, TextUtils.getString(108));
        struct.put(DESCRIPTION, TextUtils.getString(250));
        Object[] params = new Object[]{sessionId, struct};
        final Integer result = (Integer) execute(ADD_VARIABLE_METHOD, params);

        assertNotNull(result);
        deleteVariable(result);
    }

    public void testAddVariableNameFieldGreaterThanMaxValueError()
            throws MalformedURLException, XmlRpcException {

        final String strGreaterThan250 = TextUtils.getString(251);

        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, trackerId);
        struct.put(VARIABLE_NAME, strGreaterThan250);
        Object[] params = new Object[]{sessionId, struct};
        executeAddVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, VARIABLE_NAME));
    }

    public void testAddVariableUnknownIdError() throws MalformedURLException,
            XmlRpcException {

        int testTrackerId = createTracker();
        deleteTracker(testTrackerId);
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, testTrackerId);
        struct.put(VARIABLE_NAME, "testVariableName");
        Object[] params = new Object[]{sessionId, struct};
        executeAddVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, TRACKER_ID));
    }

    public void testAddVariableWrongTrackerNameTypeError() throws MalformedURLException,
            XmlRpcException {

        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(TRACKER_ID, trackerId);
        struct.put(VARIABLE_NAME, TextUtils.NOT_STRING);
        Object[] params = new Object[]{sessionId, struct};
        executeAddVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.FIELD_IS_NOT_STRING, VARIABLE_NAME));
    }
}
