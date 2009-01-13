/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
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

package org.openx.agency;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.base.WebServiceTestCase;
import org.openx.config.GlobalSettings;

/**
 * Base class for all agency web service tests
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class AgencyTestCase extends WebServiceTestCase {
	protected static final String GET_AGENCY_LIST_METHOD = "getAgencyList";
	protected static final String GET_AGENCY_METHOD = "getAgency";
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
	protected static final String EMAIL_ADDRESS = "emailAddress";
	protected static final String CONTACT_NAME = "contactName";
	protected static final String AGENCY_NAME = "agencyName";
	protected static final String PUBLISHER_NAME = "publisherName";
	protected static final String USER_NAME = "username";
	protected static final String PASSWORD = "password";
	protected static final String USER_EMAIL = "userEmail";
	protected static final String LANGUAGE = "language";
	
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
		return createAgency(getAgencyParams("test"));
	}

	/**
	 * @return agency id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createAgency(Map<String, Object> params)
			throws XmlRpcException, MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getAgencyServiceUrl()));

		Object[] paramsWithId = new Object[] { sessionId, params };
		final Integer result = (Integer) client.execute(ADD_AGENCY_METHOD,
				paramsWithId);
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

	/**
	 * @param prefix
	 * @return
	 */
	public Map<String, Object> getAgencyParams(String prefix) {
		Map<String, Object> params = new HashMap<String, Object>();

		params.put(AGENCY_NAME, prefix + AGENCY_NAME);
		params.put(CONTACT_NAME, prefix + CONTACT_NAME);
		params.put(EMAIL_ADDRESS, prefix + "@mail.com");
		return params;
	}
}
