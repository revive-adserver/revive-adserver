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
 * Base class for all advertiser web service tests.
 *
 */
class AdvertiserService extends AbstractService {
	private static final String ADVERTISER_SERVICE = "";

	private static final String ADD_ADVERTISER_METHOD = "ox.addAdvertiser";
	private static final String DELETE_ADVERTISER_METHOD = "ox.deleteAdvertiser";
	private static final String MODIFY_ADVERTISER_METHOD = "ox.modifyAdvertiser";
	private static final String ADVERTISER_BANNER_STATISTICS_METHOD = "ox.advertiserBannerStatistics";
	private static final String ADVERTISER_CAMPAIGN_STATISTICS_METHOD = "ox.advertiserCampaignStatistics";
	private static final String ADVERTISER_DAILY_STATISTICS_METHOD = "ox.advertiserDailyStatistics";
	private static final String ADVERTISER_PUBLISHER_STATISTICS_METHOD = "ox.advertiserPublisherStatistics";
	private static final String ADVERTISER_ZONE_STATISTICS_METHOD = "ox.advertiserZoneStatistics";
	private static final String GET_ADVERTISER_LIST_BY_AGENCY_ID_METHOD = "ox.getAdvertiserListByAgencyId";
	private static final String GET_ADVERTISER_METHOD = "ox.getAdvertiser";

	/**
	 * Instantiates a new advertiser service.
	 *
	 * @param client the client
	 * @param basepath the basepath
	 */
	public AdvertiserService(XmlRpcClient client, String basepath) {
		super(client, basepath);
	}

	/* (non-Javadoc)
	 * @see org.openads.proxy.AbstractService#getService()
	 */
	@Override
	public String getService() {
		return ADVERTISER_SERVICE;
	}

	/**
	 * Adds the advertiser.
	 *
	 * @param params the params
	 *
	 * @return the integer
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Integer addAdvertiser(Map params) throws XmlRpcException {
		return (Integer) execute(ADD_ADVERTISER_METHOD, params);
	}

	/**
	 * Modify advertiser.
	 *
	 * @param params the params
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean modifyAdvertiser(Map params) throws XmlRpcException {
		return (Boolean) execute(MODIFY_ADVERTISER_METHOD, params);
	}

	/**
	 * Delete advertiser.
	 *
	 * @param id the id
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean deleteAdvertiser(Integer id) throws XmlRpcException {
		return (Boolean) execute(DELETE_ADVERTISER_METHOD, id);
	}

	/**
	 * Gets the advertiser.
	 *
	 * @param id the id
	 *
	 * @return the advertiser
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map getAdvertiser(Integer id) throws XmlRpcException {
		return (Map) execute(GET_ADVERTISER_METHOD, id);
	}

	/**
	 * Gets the advertiser list by agency id all fields.
	 *
	 * @param id the id
	 *
	 * @return the advertiser list by agency id all fields
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] getAdvertiserListByAgencyIdAllFields(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(GET_ADVERTISER_LIST_BY_AGENCY_ID_METHOD, id));
	}

	/**
	 * Advertiser daily statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserDailyStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_DAILY_STATISTICS_METHOD, id));
	}

	/**
	 * Advertiser daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_DAILY_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Advertiser daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserDailyStatistics(Integer id, Date startDate,
			Date endDate, Boolean userLocalTimeZone) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_DAILY_STATISTICS_METHOD, id, startDate,
				endDate, userLocalTimeZone));
	}

	/**
	 * Advertiser daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 * @param useLocalTimeZone
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserDailyStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_DAILY_STATISTICS_METHOD, id, startDate,
				endDate));
	}

	/**
	 * Advertiser campaign statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserCampaignStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_CAMPAIGN_STATISTICS_METHOD, id));
	}

	/**
	 * Advertiser campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_CAMPAIGN_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Advertiser campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserCampaignStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_CAMPAIGN_STATISTICS_METHOD, id, startDate,
				endDate));
	}

	/**
	 * Advertiser campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 * @param userLocalTimeZone
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserCampaignStatistics(Integer id, Date startDate,
			Date endDate, Boolean useLocalTimeZone) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_CAMPAIGN_STATISTICS_METHOD, id, startDate,
				endDate, useLocalTimeZone));
	}

	/**
	 * Advertiser banner statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserBannerStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_BANNER_STATISTICS_METHOD, id));
	}

	/**
	 * Advertiser banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_BANNER_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Advertiser banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserBannerStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_BANNER_STATISTICS_METHOD, id, startDate,
				endDate));
	}

	/**
	 * Advertiser banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 * @param useLocalTimeZone
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserBannerStatistics(Integer id, Date startDate,
			Date endDate, Boolean useLocalTimeZone) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_BANNER_STATISTICS_METHOD, id, startDate,
				endDate, useLocalTimeZone));
	}

	/**
	 * Advertiser publisher statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserPublisherStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_PUBLISHER_STATISTICS_METHOD, id));
	}

	/**
	 * Advertiser publisher statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserPublisherStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_PUBLISHER_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Advertiser publisher statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserPublisherStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_PUBLISHER_STATISTICS_METHOD, id, startDate,
				endDate));
	}

	/**
	 * Advertiser publisher statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 * @param useLocalTimeZone
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserPublisherStatistics(Integer id, Date startDate,
			Date endDate, Boolean useLocalTimeZone) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_PUBLISHER_STATISTICS_METHOD, id, startDate,
				endDate, useLocalTimeZone));
	}

	/**
	 * Advertiser zone statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserZoneStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_ZONE_STATISTICS_METHOD, id));
	}

	/**
	 * Advertiser zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_ZONE_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Advertiser zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserZoneStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_ZONE_STATISTICS_METHOD, id, startDate,
				endDate));
	}
	
	/**
	 * Advertiser zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 * @param useLocalTimeZone
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] advertiserZoneStatistics(Integer id, Date startDate,
			Date endDate, Boolean useLocalTimeZone) throws XmlRpcException {
		return objectToArrayMaps( execute(ADVERTISER_ZONE_STATISTICS_METHOD, id, startDate,
				endDate, useLocalTimeZone));
	}
}
