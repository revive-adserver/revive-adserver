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

public class TestModifyVariable extends VariableTestCase {

    private Integer variableId = null;

    @Override
    protected void setUp() throws Exception {
        super.setUp();

        variableId = createVariable();
    }

    @Override
    protected void tearDown() throws Exception {
        deleteVariable(variableId);

        super.tearDown();
    }

    private void executeModifyVariableWithError(Object[] params, String errorMsg)
            throws MalformedURLException {
        try {
            execute(MODIFY_VARIABLE_METHOD, params);
            fail(MODIFY_VARIABLE_METHOD + " executed successfully, but it shouldn't.");
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testModifyVariableAllReqFieldsAndSomeOptionalFields()
            throws XmlRpcException, MalformedURLException {

        assertNotNull(variableId);

        Map<String, Object> myVariable = new HashMap<String, Object>();
        myVariable.put(VARIABLE_ID, variableId);
        myVariable.put(VARIABLE_NAME, "test variable");

        Object[] params = new Object[]{sessionId, myVariable};
        final boolean result = (Boolean) execute(MODIFY_VARIABLE_METHOD, params);
        assertTrue(result);

        params = new Object[]{sessionId, variableId};
        final Map<String, Object> variable = (Map<String, Object>) execute(
                GET_VARIABLE_METHOD, params);

        checkParameter(variable, VARIABLE_ID, variableId);
        checkParameter(variable, VARIABLE_NAME, myVariable.get(VARIABLE_NAME));
    }


    public void testModifyVariableGreaterThanMaxFieldValueError()
            throws MalformedURLException, XmlRpcException {
        final String strGreaterThan250 = TextUtils.getString(251);

        assertNotNull(variableId);

        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(VARIABLE_ID, variableId);
        struct.put(VARIABLE_NAME, strGreaterThan250);

        Object[] params = new Object[]{sessionId, struct};

        executeModifyVariableWithError(params, ErrorMessage.getMessage(ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, VARIABLE_NAME));
    }

    public void testModifyVariableMaxValues() throws XmlRpcException,
            MalformedURLException {
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(VARIABLE_ID, variableId);

        // To allow for the: var VARIABLE_NAME = escape(\\''%%VARIABLE_NAME%%\\'')
        // that is set in variablecode we must set VARIABLE_NAME length to be:
        // 250 = (33 + VAR_NAME_LEN) + VAR_NAME_LEN
        // --> 217 / 2 = 108
        struct.put(VARIABLE_NAME, TextUtils.getString(108));
        Object[] params = new Object[]{sessionId, struct};
        final Boolean result = (Boolean) execute(MODIFY_VARIABLE_METHOD, params);
        assertTrue(result);
    }

    public void testModifyVariableWrongTypeError() throws MalformedURLException {
        Map<String, Object> struct = new HashMap<String, Object>();
        struct.put(VARIABLE_ID, variableId);
        Object[] params = new Object[]{sessionId, struct};

        struct.put(VARIABLE_NAME, TextUtils.NOT_STRING);
        executeModifyVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.FIELD_IS_NOT_STRING, VARIABLE_NAME));
    }
}
