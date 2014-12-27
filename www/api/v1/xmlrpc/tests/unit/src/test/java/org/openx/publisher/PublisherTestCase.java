/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.publisher;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.banner.BannerTestCase;
import org.openx.config.GlobalSettings;

/**
 * Base class for all publisher web service tests
 */
public class PublisherTestCase extends BannerTestCase {
	protected static final String GET_PUBLISHER_LIST_BY_AGENCY_ID_METHOD = "getPublisherListByAgencyId";
	protected static final String GET_PUBLISHER_METHOD = "getPublisher";
	protected static final String ADD_PUBLISHER_METHOD = "addPublisher";
	protected static final String DELETE_PUBLISHER_METHOD = "deletePublisher";
	protected static final String MODIFY_PUBLISHER_METHOD = "modifyPublisher";
	protected final static String PUBLISHER_ZONE_STATISTICS_METHOD = "publisherZoneStatistics";
	protected final static String PUBLISHER_CAMPAIGN_STATISTICS_METHOD = "publisherCampaignStatistics";
	protected static final String PUBLISHER_DAILY_STATISTICS_METHOD = "publisherDailyStatistics";
	protected final static String PUBLISHER_BANNER_STATISTICS_METHOD = "publisherBannerStatistics";
	protected final static String PUBLISHER_ADVERTISER_STATISTICS_METHOD = "publisherAdvertiserStatistics";

	protected static final String PUBLISHER_ID = "publisherId";
	protected static final String EMAIL_ADDRESS = "emailAddress";
	protected static final String COMMENTS = "comments"; //there is no comment field in UI

	//protected Integer agencyId = null;

	protected void setUp() throws Exception {
		super.setUp();

		//agencyId = createAgency();

		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getPublisherServiceUrl()));
	}

	protected void tearDown() throws Exception {

		//deleteAgency(agencyId);

		super.tearDown();
	}

	/**
	 * @return Publisher id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createPublisher() throws XmlRpcException,
			MalformedURLException {
		return createPublisher(getPublisherParams("test"));
	}

	/**
	 * @return publisher id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createPublisher(Map<String, Object> params)
			throws XmlRpcException, MalformedURLException {

		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getPublisherServiceUrl()));

		Object[] paramsWithId = new Object[] { sessionId, params };
		final Integer result = (Integer) client.execute(ADD_PUBLISHER_METHOD, paramsWithId);

		return result;
	}

	/**
	 * @param id -
	 *            id of publisher you want to remove
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public boolean deletePublisher(Integer id) throws XmlRpcException,
			MalformedURLException {
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getPublisherServiceUrl()));
		return (Boolean) client.execute(DELETE_PUBLISHER_METHOD, new Object[] {
				sessionId, id });
	}

	public Object execute(String method, Object[] params)
			throws XmlRpcException, MalformedURLException {
		// set URL
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getPublisherServiceUrl()));

		return client.execute(method, params);
	}

	/**
	 * @param prefix
	 * @return
	 */
	public Map<String, Object> getPublisherParams(String prefix) {
		Map<String, Object> params = new HashMap<String, Object>();

		params.put(AGENCY_ID, agencyId);
		params.put(PUBLISHER_NAME, prefix + PUBLISHER_NAME);
		params.put(CONTACT_NAME, prefix + CONTACT_NAME);
		params.put(EMAIL_ADDRESS, prefix + "@mail.com");

		return params;
	}
}
