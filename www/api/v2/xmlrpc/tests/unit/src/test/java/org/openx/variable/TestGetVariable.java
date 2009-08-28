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
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
public class TestGetVariable extends VariableTestCase {

    private void executeGetVariableWithError(Object[] params, String errorMsg)
            throws MalformedURLException {
        try {
            @SuppressWarnings("unused")
            Map<String, Object> result = (Map<String, Object>) execute(
                    GET_VARIABLE_METHOD, params);
            fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testGetVariableAllFields() throws XmlRpcException,
            MalformedURLException {
        Map<String, Object> myVariable = getVariableParams("test1");
        Integer id = createVariable(myVariable);
        Object[] params = new Object[]{sessionId, id};

        try {
            final Map<String, Object> variable = (Map<String, Object>) execute(
                    GET_VARIABLE_METHOD, params);

            checkParameter(variable, VARIABLE_ID, id);
            checkParameter(variable, TRACKER_ID, myVariable.get(TRACKER_ID));
            checkParameter(variable, VARIABLE_NAME, myVariable.get(VARIABLE_NAME));
            checkParameter(variable, DESCRIPTION, myVariable.get(DESCRIPTION));
        } finally {
            deleteVariable(id);
        }
    }

    public void testGetVariableWithoutSomeRequiredFields()
            throws MalformedURLException {
        Object[] params = new Object[]{sessionId};

        executeGetVariableWithError(params, ErrorMessage.getMessage(ErrorMessage.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1")));

    }

    public void testGetVariableUnknownIdError() throws XmlRpcException,
            MalformedURLException {
        final Integer id = createVariable();
        deleteVariable(id);
        Object[] params = new Object[]{sessionId, id};

        executeGetVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, VARIABLE_ID));
    }

    public void testGetTrackerWrongTypeError() throws MalformedURLException,
            XmlRpcException {
        Object[] params = new Object[]{sessionId, TextUtils.NOT_INTEGER};

        executeGetVariableWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
    }
}
