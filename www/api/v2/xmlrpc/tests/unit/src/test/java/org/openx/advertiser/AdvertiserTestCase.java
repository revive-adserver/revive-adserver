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

package org.openx.advertiser;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.agency.AgencyTestCase;
import org.openx.config.GlobalSettings;

/**
 * Base class for all advertiser web service tests
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class AdvertiserTestCase extends AgencyTestCase {
	protected static final String TEST_DATA_PREFIX = "test";
	
	protected static final String GET_ADVERTISER_LIST_BY_AGENCY_ID_METHOD = "ox.getAdvertiserListByAgencyId";
	protected static final String GET_ADVERTISER_METHOD = "ox.getAdvertiser";
	protected static final String ADD_ADVERTISER_METHOD = "ox.addAdvertiser";
	protected static final String DELETE_ADVERTISER_METHOD = "ox.deleteAdvertiser";
	protected static final String MODIFY_ADVERTISER_METHOD = "ox.modifyAdvertiser";
	protected static final String ADVERTISER_BANNER_STATISTICS_METHOD = "ox.advertiserBannerStatistics";
	protected static final String ADVERTISER_CAMPAIGN_STATISTICS_METHOD = "ox.advertiserCampaignStatistics";
	protected static final String ADVERTISER_DAILY_STATISTICS_METHOD = "ox.advertiserDailyStatistics";
	protected static final String ADVERTISER_PUBLISHER_STATISTICS_METHOD = "ox.advertiserPublisherStatistics";
	protected static final String ADVERTISER_ZONE_STATISTICS_METHOD = "ox.advertiserZoneStatistics";

	protected static final String ADVERTISER_ID = "advertiserId";
	protected static final String EMAIL_ADDRESS = "emailAddress";
	protected static final String CONTACT_NAME = "contactName";
	protected static final String ADVERTISER_NAME = "advertiserName";
	protected static final String COMMENTS = "comments";

	protected Integer agencyId;

	protected void setUp() throws Exception {
		super.setUp();
		agencyId = createAgency();
	}

	protected void tearDown() throws Exception {
		deleteAgency(agencyId);
		super.tearDown();
	}

	/**
	 * @return advertiser id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createAdvertiser() throws XmlRpcException,
			MalformedURLException {

		return createAdvertiser(getAdvertiserParams(TEST_DATA_PREFIX));
	}

	/**
	 * @return advertiser id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createAdvertiser(Map<String, Object> params)
			throws XmlRpcException, MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getAdvertiserServiceUrl()));

		Object[] paramsWithId = new Object[] { sessionId, params };
		final Integer result = (Integer) client.execute(ADD_ADVERTISER_METHOD,
				paramsWithId);
		
		return result;
	}

	/**
	 * @param id -
	 *            id of advertiser you want to remove
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public boolean deleteAdvertiser(Integer id) throws XmlRpcException,
			MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getAdvertiserServiceUrl()));
		
		final Boolean result = (Boolean) client.execute(
				DELETE_ADVERTISER_METHOD, new Object[] { sessionId, id });
		
		assertTrue(result);
		return result;
	}

	public Object execute(String method, Object[] params)
			throws XmlRpcException, MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
			.setServerURL(new URL(GlobalSettings.getAdvertiserServiceUrl()));
		
		return client.execute(method, params);
	}

	public Map<String, Object> getAdvertiserParams(String prefix) {
		Map<String, Object> params = new HashMap<String, Object>();
		params.put(AGENCY_ID, agencyId);
		params.put(ADVERTISER_NAME, prefix + ADVERTISER_NAME);
		params.put(CONTACT_NAME, prefix + CONTACT_NAME);
		params.put(EMAIL_ADDRESS, prefix + "@mail.com");
		return params;
	}

}
