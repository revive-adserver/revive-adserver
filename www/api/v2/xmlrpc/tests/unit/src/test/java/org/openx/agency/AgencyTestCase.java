/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
 */
public class AgencyTestCase extends WebServiceTestCase {
	protected static final String GET_AGENCY_LIST_METHOD = "ox.getAgencyList";
	protected static final String GET_AGENCY_METHOD = "ox.getAgency";
	protected static final String ADD_AGENCY_METHOD = "ox.addAgency";
	protected static final String DELETE_AGENCY_METHOD = "ox.deleteAgency";
	protected final static String MODIFY_AGENCY_METHOD = "ox.modifyAgency";
	protected final static String AGENCY_ADVERTISER_STATISTICS_METHOD = "ox.agencyAdvertiserStatistics";
	protected final static String AGENCY_BANNER_STATISTICS_METHOD = "ox.agencyBannerStatistics";
	protected final static String AGENCY_CAMPAIGN_STATISTICS_METHOD = "ox.agencyCampaignStatistics";
	protected static final String AGENCY_DAILY_STATISTICS_METHOD = "ox.agencyDailyStatistics";
	protected final static String AGENCY_PUBLISHER_STATISTICS_METHOD = "ox.agencyPublisherStatistics";
	protected final static String AGENCY_ZONE_STATISTICS_METHOD = "ox.agencyZoneStatistics";

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
				.setServerURL(new URL(GlobalSettings.getServiceUrl()));
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
				.setServerURL(new URL(GlobalSettings.getServiceUrl()));

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
				.setServerURL(new URL(GlobalSettings.getServiceUrl()));
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
				.setServerURL(new URL(GlobalSettings.getServiceUrl()));

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
