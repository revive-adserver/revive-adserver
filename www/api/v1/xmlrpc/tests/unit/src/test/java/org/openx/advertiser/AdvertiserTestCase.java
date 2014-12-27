/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
 */
public class AdvertiserTestCase extends AgencyTestCase {
	protected static final String TEST_DATA_PREFIX = "test";

	protected static final String GET_ADVERTISER_LIST_BY_AGENCY_ID_METHOD = "getAdvertiserListByAgencyId";
	protected static final String GET_ADVERTISER_METHOD = "getAdvertiser";
	protected static final String ADD_ADVERTISER_METHOD = "addAdvertiser";
	protected static final String DELETE_ADVERTISER_METHOD = "deleteAdvertiser";
	protected static final String MODIFY_ADVERTISER_METHOD = "modifyAdvertiser";
	protected static final String ADVERTISER_BANNER_STATISTICS_METHOD = "advertiserBannerStatistics";
	protected static final String ADVERTISER_CAMPAIGN_STATISTICS_METHOD = "advertiserCampaignStatistics";
	protected static final String ADVERTISER_DAILY_STATISTICS_METHOD = "advertiserDailyStatistics";
	protected static final String ADVERTISER_PUBLISHER_STATISTICS_METHOD = "advertiserPublisherStatistics";
	protected static final String ADVERTISER_ZONE_STATISTICS_METHOD = "advertiserZoneStatistics";

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
