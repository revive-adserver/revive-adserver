/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openads.proxy;
import java.util.Date;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClient;

/**
 * Base class for all campaign web service tests.
 *
 */
class CampaignService extends AbstractService {
	private static final String CAMPAIGN_SERVICE = "CampaignXmlRpcService.php";

	private static final String ADD_CAMPAIGN_METHOD = "addCampaign";
	private static final String DELETE_CAMPAIGN_METHOD = "deleteCampaign";
	private static final String MODIFY_CAMPAIGN_METHOD = "modifyCampaign";
	private static final String GET_CAMPAIGN_METHOD = "getCampaign";
	private static final String GET_CAMPAIGN_LIST_BY_ADVERTISER_ID_METHOD = "getCampaignListByAdvertiserId";
	private static final String CAMPAIGN_ZONE_STATISTICS_METHOD = "campaignZoneStatistics";
	private static final String CAMPAIGN_DAILY_STATISTICS_METHOD = "campaignDailyStatistics";
	private static final String CAMPAIGN_PUBLISHER_STATISTICS_METHOD = "campaignPublisherStatistics";
	private static final String CAMPAIGN_BANNER_STATISTICS_METHOD = "campaignBannerStatistics";

	/**
	 * Instantiates a new campaign service.
	 *
	 * @param client the client
	 * @param basepath the basepath
	 */
	public CampaignService(XmlRpcClient client, String basepath) {
		super(client, basepath);
	}

	/* (non-Javadoc)
	 * @see org.openads.proxy.AbstractService#getService()
	 */
	@Override
	String getService() {
		return CAMPAIGN_SERVICE;
	}

	/**
	 * Adds the campaign.
	 *
	 * @param params the params
	 *
	 * @return the integer
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Integer addCampaign(Map params) throws XmlRpcException {
		return (Integer) execute(ADD_CAMPAIGN_METHOD, params);
	}

	/**
	 * Modify campaign.
	 *
	 * @param params the params
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean modifyCampaign(Map params) throws XmlRpcException {
		return (Boolean) execute(MODIFY_CAMPAIGN_METHOD, params);
	}

	/**
	 * Delete campaign.
	 *
	 * @param id the id
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean deleteCampaign(Integer id) throws XmlRpcException {
		return (Boolean) execute(DELETE_CAMPAIGN_METHOD, id);
	}

	/**
	 * Gets the campaign.
	 *
	 * @param id the id
	 *
	 * @return the campaign
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map getCampaign(Integer id) throws XmlRpcException {
		return (Map) execute(GET_CAMPAIGN_METHOD, id);
	}

	/**
	 * Gets the campaign list by advertiser id.
	 *
	 * @param id the id
	 *
	 * @return the campaign list by advertiser id
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] getCampaignListByAdvertiserID(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(GET_CAMPAIGN_LIST_BY_ADVERTISER_ID_METHOD, id));
	}

	/**
	 * Campaign daily statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignDailyStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_DAILY_STATISTICS_METHOD, id));
	}

	/**
	 * Campaign daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_DAILY_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Campaign daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignDailyStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_DAILY_STATISTICS_METHOD, id, startDate,
				endDate));
	}

	/**
	 * Campaign publisher statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignPublisherStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_PUBLISHER_STATISTICS_METHOD, id));
	}

	/**
	 * Campaign publisher statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignPublisherStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_PUBLISHER_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Campaign publisher statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignPublisherStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_PUBLISHER_STATISTICS_METHOD, id, startDate,
				endDate));
	}

	/**
	 * Campaign banner statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignBannerStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_BANNER_STATISTICS_METHOD, id));
	}

	/**
	 * Campaign banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_BANNER_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Campaign banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignBannerStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_BANNER_STATISTICS_METHOD, id, startDate,
				endDate));
	}

	/**
	 * Campaign zone statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignZoneStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_ZONE_STATISTICS_METHOD, id));
	}

	/**
	 * Campaign zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_ZONE_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Campaign zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] campaignZoneStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(CAMPAIGN_ZONE_STATISTICS_METHOD, id, startDate,
				endDate));
	}
}
