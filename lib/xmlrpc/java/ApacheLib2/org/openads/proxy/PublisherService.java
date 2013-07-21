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
import java.io.IOException;
import java.net.MalformedURLException;
import java.util.Date;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;

/**
 * Base class for all publiser web service tests.
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
class PublisherService extends AbstractService {
	private static final String PUBLISHER_SERVICE = "PublisherXmlRpcService.php";

	private static final String ADD_PUBLISHER_METHOD = "addPublisher";
	private static final String DELETE_PUBLISHER_METHOD = "deletePublisher";
	private static final String MODIFY_PUBLISHER_METHOD = "modifyPublisher";
	private static final String GET_PUBLISHER_LIST_BY_AGENCY_ID_METHOD = "getPublisherListByAgencyId";
	private static final String GET_PUBLISHER_METHOD = "getPublisher";
	private final static String PUBLISHER_ZONE_STATISTICS_METHOD = "publisherZoneStatistics";
	private final static String PUBLISHER_CAMPAIGN_STATISTICS_METHOD = "publisherCampaignStatistics";
	private static final String PUBLISHER_DAILY_STATISTICS_METHOD = "publisherDailyStatistics";
	private final static String PUBLISHER_BANNER_STATISTICS_METHOD = "publisherBannerStatistics";
	private final static String PUBLISHER_ADVERTISER_STATISTICS_METHOD = "publisherAdvertiserStatistics";

	/**
	 * Instantiates a new publisher service.
	 *
	 * @param client the client
	 * @param basepath the basepath
	 * @throws MalformedURLException
	 */
	public PublisherService(String basepath) throws MalformedURLException {
		super(basepath);
	}

	/* (non-Javadoc)
	 * @see org.openads.proxy.AbstractService#getService()
	 */
	@Override
	public String getService() {
		return PUBLISHER_SERVICE;
	}

	/**
	 * Adds the publisher.
	 *
	 * @param params the params
	 *
	 * @return the integer
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Integer addPublisher(Map params) throws XmlRpcException, IOException {
		return (Integer) execute(ADD_PUBLISHER_METHOD, params);
	}

	/**
	 * Modify publisher.
	 *
	 * @param params the params
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Boolean modifyPublisher(Map params) throws XmlRpcException, IOException {
		return (Boolean) execute(MODIFY_PUBLISHER_METHOD, params);
	}

	/**
	 * Delete publisher.
	 *
	 * @param id the id
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Boolean deletePublisher(Integer id) throws XmlRpcException, IOException {
		return (Boolean) execute(DELETE_PUBLISHER_METHOD, id);
	}

	/**
	 * Gets the publisher.
	 *
	 * @param id the id
	 *
	 * @return the publisher
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map getPublisher(Integer id) throws XmlRpcException, IOException {
		return (Map) execute(GET_PUBLISHER_METHOD, id);
	}

	/**
	 * Gets the publisher list by agency id.
	 *
	 * @param id the id
	 *
	 * @return the publisher list by agency id
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] getPublisherListByAgencyId(Integer id)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(GET_PUBLISHER_LIST_BY_AGENCY_ID_METHOD));
	}

	/**
	 * Publisher zone statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_ZONE_STATISTICS_METHOD, id));
	}

	/**
	 * Publisher zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_ZONE_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Publisher zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_ZONE_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Publisher campaign statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_CAMPAIGN_STATISTICS_METHOD,
				id));
	}

	/**
	 * Publisher campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_CAMPAIGN_STATISTICS_METHOD,
				id, startDate));
	}

	/**
	 * Publisher campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_CAMPAIGN_STATISTICS_METHOD,
				id, startDate, endDate));
	}

	/**
	 * Publisher daily statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_DAILY_STATISTICS_METHOD, id));
	}

	/**
	 * Publisher daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_DAILY_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Publisher daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_DAILY_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Publisher banner statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_BANNER_STATISTICS_METHOD, id));
	}

	/**
	 * Publisher banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_BANNER_STATISTICS_METHOD,
				id, startDate));
	}

	/**
	 * Publisher banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(PUBLISHER_BANNER_STATISTICS_METHOD,
				id, startDate, endDate));
	}

	/**
	 * Publisher advertiser statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(
				PUBLISHER_ADVERTISER_STATISTICS_METHOD, id));
	}

	/**
	 * Publisher advertiser statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(
				PUBLISHER_ADVERTISER_STATISTICS_METHOD, id, startDate));
	}

	/**
	 * Publisher advertiser statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(
				PUBLISHER_ADVERTISER_STATISTICS_METHOD, id, startDate, endDate));
	}
}
