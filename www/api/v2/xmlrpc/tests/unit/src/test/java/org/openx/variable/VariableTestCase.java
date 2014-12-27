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
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.config.GlobalSettings;
import org.openx.tracker.TrackerTestCase;

/**
 * Base class for all tracker web service tests
 */
public class VariableTestCase extends TrackerTestCase {

	protected static final String ADD_VARIABLE_METHOD = "ox.addVariable";
	protected static final String DELETE_VARIABLE_METHOD = "ox.deleteVariable";
	protected static final String MODIFY_VARIABLE_METHOD = "ox.modifyVariable";
	protected static final String GET_VARIABLE_METHOD = "ox.getVariable";


	protected static final String VARIABLE_ID = "variableId";
	protected static final String VARIABLE_NAME = "variableName";
	protected static final String TRACKER_ID = "trackerId";
        protected static final String DESCRIPTION = "description";
        protected static final String DATA_TYPE = "dataType";
        protected static final String PURPOSE = "purpose";
        protected static final String REJECT_IF_EMPTY = "rejectIfEmpty";
        protected static final String IS_UNIQUE = "isUnique";
        protected static final String UNIQUE_WINDOW = "uniqueWindow";
        protected static final String VARIABLE_CODE = "variableCode";
        protected static final String HIDDEN = "hidden";
        protected static final String HIDDEN_WEBSITES = "hiddenWebsites";


	protected Integer trackerId;

	protected void setUp() throws Exception {
		super.setUp();
		trackerId = createTracker();
	}

	protected void tearDown() throws Exception {
		deleteTracker(trackerId);
		super.tearDown();
	}

	public Integer createVariable() throws XmlRpcException,
			MalformedURLException {

		return createVariable(getVariableParams(TEST_DATA_PREFIX));
	}

	public Integer createVariable(Map<String, Object> params)
			throws XmlRpcException, MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getServiceUrl()));

		Object[] paramsWithId = new Object[] { sessionId, params };
		final Integer result = (Integer) client.execute(ADD_VARIABLE_METHOD,
				paramsWithId);

		return result;
	}

	public boolean deleteVariable(Integer id) throws XmlRpcException,
			MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getServiceUrl()));

		final Boolean result = (Boolean) client.execute(
				DELETE_VARIABLE_METHOD, new Object[] { sessionId, id });

		assertTrue(result);
		return result;
	}

	public Object execute(String method, Object[] params)
			throws XmlRpcException, MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getServiceUrl()));

		return client.execute(method, params);
	}

	public Map<String, Object> getVariableParams(String prefix) {
		Map<String, Object> params = new HashMap<String, Object>();
		params.put(TRACKER_ID, trackerId);
		params.put(VARIABLE_NAME, prefix + VARIABLE_NAME);
                params.put(DESCRIPTION, prefix + DESCRIPTION);
                params.put(DATA_TYPE, "numeric");
                params.put(PURPOSE, "basket_value");
                params.put(REJECT_IF_EMPTY, false);
                params.put(IS_UNIQUE, false);
                params.put(UNIQUE_WINDOW, 0);
                params.put(VARIABLE_CODE, prefix + VARIABLE_CODE);
                params.put(HIDDEN, false);

		return params;
	}

}
