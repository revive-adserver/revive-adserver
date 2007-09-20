/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
|  Copyright 2003-2007 Openads Limited                                      |
|                                                                           |
|  Licensed under the Apache License, Version 2.0 (the "License");          |
|  you may not use this file except in compliance with the License.         |
|  You may obtain a copy of the License at                                  |
|                                                                           |
|    http://www.apache.org/licenses/LICENSE-2.0                             |
|                                                                           |
|  Unless required by applicable law or agreed to in writing, software      |
|  distributed under the License is distributed on an "AS IS" BASIS,        |
|  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. |
|  See the License for the specific language governing permissions and      |
|  limitations under the License.                                           |
+---------------------------------------------------------------------------+
$Id:$
*/

package org.openads.zone;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openads.config.GlobalSettings;
import org.openads.publisher.PublisherTestCase;

/**
 * Base class for all zone web service tests
 * 
 * @author <a href="mailto:apetlyovanyy@lohika.com">Andriy Petlyovanyy</a>
 */
public class ZoneTestCase extends PublisherTestCase {
	protected static final String ADD_ZONE_METHOD = "addZone";
	protected static final String MODIFY_ZONE_METHOD = "modifyZone";
	protected static final String DELETE_ZONE_METHOD = "deleteZone";
	protected final static String ZONE_ADVERTISER_STATISTICS_METHOD = "zoneAdvertiserStatistics";
	protected static final String ZONE_DAILY_STATISTICS_METHOD = "zoneDailyStatistics";
	protected final static String ZONE_CAMPAIGN_STATISTICS_METHOD = "zoneCampaignStatistics";
	protected final static String ZONE_BANNER_STATISTICS_METHOD = "zoneBannerStatistics";

	protected static final String CAMPAIGN_ID = "campaignId";
	protected static final String PUBLISHER_ID = "publisherId";
	protected static final String ZONE_ID = "zoneId";
	protected static final String ZONE_NAME = "zoneName";
	protected static final String HEIGHT = "height";
	protected static final String WIDTH = "width";
	protected static final String TYPE = "type";

	protected Integer publisherId = null;

	protected void setUp() throws Exception {
		super.setUp();

		publisherId = createPublisher();

		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getZoneServiceUrl()));
	}

	protected void tearDown() throws Exception {

		deletePublisher(publisherId);

		super.tearDown();
	}

	/**
	 * @return Zone id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createZone() throws XmlRpcException, MalformedURLException {
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getZoneServiceUrl()));
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_ID, publisherId);
		struct.put(ZONE_NAME, "test Zone");
		struct.put(TYPE, 0);
		struct.put(WIDTH, 200);
		struct.put(HEIGHT, 200);
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) client
				.execute(ADD_ZONE_METHOD, params);
		return result;
	}

	/**
	 * @param id -
	 *            id of zone you want to remove
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public boolean deleteZone(Integer id) throws XmlRpcException,
			MalformedURLException {
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getZoneServiceUrl()));
		return (Boolean) client.execute(DELETE_ZONE_METHOD, new Object[] {
				sessionId, id });
	}

	public Object execute(String method, Object[] params)
			throws XmlRpcException, MalformedURLException {
		// set URL
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getZoneServiceUrl()));

		return client.execute(method, params);
	}
}
