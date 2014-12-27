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
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

public class TestDeleteVariable extends VariableTestCase {

    private void executeDeleteVariableWithError(Object[] params, String errorMsg)
            throws MalformedURLException {
        try {
            execute(DELETE_VARIABLE_METHOD, params);
            fail(DELETE_VARIABLE_METHOD + " executed successfully, but it shouldn't.");
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testDeleteVariable() throws XmlRpcException, MalformedURLException {
        int variableId = createVariable();
        assertNotNull("Can't add variable.", variableId);
        final Boolean result = deleteVariable(variableId);
        assertTrue("Can't delete variable.", result);
    }

    public void testDeleteVariableWithoutSomeRequiredFields() throws MalformedURLException {
        Object[] params = new Object[]{sessionId};

        executeDeleteVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));
    }

    public void testDeleteVariableUnknownIdError() throws XmlRpcException,
            MalformedURLException {
        final Integer id = createVariable();
        deleteVariable(id);
        Object[] params = new Object[]{sessionId, id};

        executeDeleteVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, VARIABLE_ID));
    }

    public void testDeleteVariableWrongTypeError() throws MalformedURLException {
        Object[] params = new Object[]{sessionId, TextUtils.NOT_INTEGER};

        executeDeleteVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
    }
}
