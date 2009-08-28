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
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.campaign.CampaignTestCase;
import org.openx.config.GlobalSettings;

/**
 * Base class for all tracker web service tests
 *
 * @author     David Keen <david.keen@openx.org>
 */
public class TrackerTestCase extends CampaignTestCase {

	protected static final String ADD_TRACKER_METHOD = "ox.addTracker";
	protected static final String DELETE_TRACKER_METHOD = "ox.deleteTracker";
	protected static final String MODIFY_TRACKER_METHOD = "ox.modifyTracker";
	protected static final String GET_TRACKER_METHOD = "ox.getTracker";
        protected static final String TRACKER_LINK_CAMPAIGN_METHOD = "ox.linkTrackerToCampaign";

	protected static final String TRACKER_ID = "trackerId";
	protected static final String TRACKER_NAME = "trackerName";
	protected static final String CLIENT_ID = "clientId";
        protected static final String DESCRIPTION = "description";
        protected static final String VIEW_WINDOW = "viewwindow";
        protected static final String CLICK_WINDOW = "clickwindow";
        protected static final String BLOCK_WINDOW = "blockwindow";
        protected static final String STATUS = "status";
        protected static final String TYPE = "type";
        protected static final String LINK_CAMPAIGNS = "linkcampaigns";
        protected static final String VARIABLE_METHOD = "variablemethod";

        protected static final Integer MAX_CONNECTION_STATUS_APPROVED = 4;

	protected Integer clientId;

	protected void setUp() throws Exception {
		super.setUp();
		clientId = createAdvertiser();
	}

	protected void tearDown() throws Exception {
		deleteAdvertiser(clientId);
		super.tearDown();
	}

	public Integer createTracker() throws XmlRpcException,
			MalformedURLException {

		return createTracker(getTrackerParams(TEST_DATA_PREFIX));
	}

	public Integer createTracker(Map<String, Object> params)
			throws XmlRpcException, MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getServiceUrl()));

		Object[] paramsWithId = new Object[] { sessionId, params };
		final Integer result = (Integer) client.execute(ADD_TRACKER_METHOD,
				paramsWithId);

		return result;
	}

	public boolean deleteTracker(Integer id) throws XmlRpcException,
			MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getServiceUrl()));

		final Boolean result = (Boolean) client.execute(
				DELETE_TRACKER_METHOD, new Object[] { sessionId, id });

		assertTrue(result);
		return result;
	}

	public Object execute(String method, Object[] params)
			throws XmlRpcException, MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getServiceUrl()));

		return client.execute(method, params);
	}

	public Map<String, Object> getTrackerParams(String prefix) {
		Map<String, Object> params = new HashMap<String, Object>();
		params.put(CLIENT_ID, clientId);
		params.put(TRACKER_NAME, prefix + TRACKER_NAME);
                params.put(DESCRIPTION, prefix + DESCRIPTION);
                params.put(VIEW_WINDOW, 0);
                params.put(CLICK_WINDOW, 0);
                params.put(BLOCK_WINDOW, 0);
                params.put(STATUS, 4);
                params.put(TYPE, 1);
                params.put(LINK_CAMPAIGNS, false);
                params.put(VARIABLE_METHOD, "default");

		return params;
	}

}
