/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.variable;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

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
