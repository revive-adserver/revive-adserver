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

package org.openads.agency;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openads.base.WebServiceTestCase;
import org.openads.config.GlobalSettings;
import org.openads.utils.TextUtils;

/**
 * Base class for all agency web service tests
 * 
 * @author <a href="mailto:apetlyovanyy@lohika.com">Andriy Petlyovanyy</a>
 */
public class AgencyTestCase extends WebServiceTestCase {

	protected static final String ADD_AGENCY_METHOD = "addAgency";
	protected static final String DELETE_AGENCY_METHOD = "deleteAgency";
	protected final static String MODIFY_AGENCY_METHOD = "modifyAgency";
	protected final static String AGENCY_ADVERTISER_STATISTICS_METHOD = "agencyAdvertiserStatistics";
	protected final static String AGENCY_BANNER_STATISTICS_METHOD = "agencyBannerStatistics";
	protected final static String AGENCY_CAMPAIGN_STATISTICS_METHOD = "agencyCampaignStatistics";
	protected static final String AGENCY_DAILY_STATISTICS_METHOD = "agencyDailyStatistics";
	protected final static String AGENCY_PUBLISHER_STATISTICS_METHOD = "agencyPublisherStatistics";
	protected final static String AGENCY_ZONE_STATISTICS_METHOD = "agencyZoneStatistics";

	protected static final String START_DATE = "startDate";
	protected static final String END_DATE = "endDate";
	protected static final String AGENCY_ID = "agencyId";
	protected static final String PASSWORD = "password";
	protected static final String USERNAME = "username";
	protected static final String EMAIL_ADDRESS = "emailAddress";
	protected static final String CONTACT_NAME = "contactName";
	protected static final String AGENCY_NAME = "agencyName";

	protected void setUp() throws Exception {
		super.setUp();

		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getAgencyServiceUrl()));
	}

	/**
	 * @return agency id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createAgency() throws XmlRpcException, MalformedURLException {
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getAgencyServiceUrl()));

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put("agencyId", 0);
		struct.put("agencyName", "testAgancy");
		struct.put("contactName", "Vasya");
		struct.put("emailAddress", "Vasya@mail.com");
		struct.put("username", TextUtils.generateUniqueName("testUser"));
		struct.put("password", "qwerty");
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) client.execute(ADD_AGENCY_METHOD,
				params);
		return result;
	}

	/**
	 * @param id -
	 *            id of agency you want to remove
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 * @throws MalformedURLException
	 */
	public boolean deleteAgency(Integer id) throws XmlRpcException,
			MalformedURLException {
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getAgencyServiceUrl()));
		return (Boolean) client.execute(DELETE_AGENCY_METHOD, new Object[] {
				sessionId, id });
	}

	protected void tearDown() throws Exception {
		super.tearDown();
	}

	public Object execute(String method, Object[] params)
			throws XmlRpcException, MalformedURLException {
		// set URL
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getAgencyServiceUrl()));

		return client.execute(method, params);
	}
}
