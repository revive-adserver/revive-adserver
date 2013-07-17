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
 * The Class AgencyService.
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
class AgencyService extends AbstractService {
	private static final String AGENCY_SERVICE = "AgencyXmlRpcService.php";

	private static final String ADD_AGENCY_METHOD = "addAgency";
	private static final String DELETE_AGENCY_METHOD = "deleteAgency";
	private static final String MODIFY_AGENCY_METHOD = "modifyAgency";
	private static final String GET_AGENCY_LIST_METHOD = "getAgencyList";
	private static final String GET_AGENCY_METHOD = "getAgency";
	private static final String AGENCY_ADVERTISER_STATISTICS_METHOD = "agencyAdvertiserStatistics";
	private static final String AGENCY_BANNER_STATISTICS_METHOD = "agencyBannerStatistics";
	private static final String AGENCY_CAMPAIGN_STATISTICS_METHOD = "agencyCampaignStatistics";
	private static final String AGENCY_DAILY_STATISTICS_METHOD = "agencyDailyStatistics";
	private static final String AGENCY_PUBLISHER_STATISTICS_METHOD = "agencyPublisherStatistics";
	private static final String AGENCY_ZONE_STATISTICS_METHOD = "agencyZoneStatistics";

	/**
	 * Instantiates a new agency service.
	 *
	 * @param client the client
	 * @param basepath the basepath
	 * @throws MalformedURLException
	 */
	public AgencyService(String basepath) throws MalformedURLException {
		super(basepath);
	}

	/* (non-Javadoc)
	 * @see org.openads.proxy.AbstractService#getService()
	 */
	@Override
	public String getService() {
		return AGENCY_SERVICE;
	}

	/**
	 * Adds the agency.
	 *
	 * @param params the params
	 *
	 * @return the integer
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Integer addAgency(Map params) throws XmlRpcException, IOException {
		return (Integer) execute(ADD_AGENCY_METHOD, params);
	}

	/**
	 * Modify agency.
	 *
	 * @param params the params
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Boolean modifyAgency(Map params) throws XmlRpcException, IOException {
		return (Boolean) execute(MODIFY_AGENCY_METHOD, params);
	}

	/**
	 * Delete agency.
	 *
	 * @param id the id
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Boolean deleteAgency(Integer id) throws XmlRpcException, IOException {
		return (Boolean) execute(DELETE_AGENCY_METHOD, id);
	}

	/**
	 * Gets the agency.
	 *
	 * @param id the id
	 *
	 * @return the agency
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map getAgency(Integer id) throws XmlRpcException, IOException {
		return (Map) execute(GET_AGENCY_METHOD, id);
	}

	/**
	 * Gets the agency list.
	 *
	 * @return the agency list
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] getAgencyList() throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(GET_AGENCY_LIST_METHOD));
	}

	/**
	 * Agency zone statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyZoneStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_ZONE_STATISTICS_METHOD, id));
	}

	/**
	 * Agency zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_ZONE_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Agency zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyZoneStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_ZONE_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Agency advertiser statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyAdvertiserStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_ADVERTISER_STATISTICS_METHOD,
				id));
	}

	/**
	 * Agency advertiser statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyAdvertiserStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_ADVERTISER_STATISTICS_METHOD,
				id, startDate));
	}

	/**
	 * Agency advertiser statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyAdvertiserStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_ADVERTISER_STATISTICS_METHOD,
				id, startDate, endDate));
	}

	/**
	 * Agency banner statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyBannerStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_BANNER_STATISTICS_METHOD, id));
	}

	/**
	 * Agency banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_BANNER_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Agency banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyBannerStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_BANNER_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Agency campaign statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyCampaignStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_CAMPAIGN_STATISTICS_METHOD, id));
	}

	/**
	 * Agency campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_CAMPAIGN_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Agency campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyCampaignStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_CAMPAIGN_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Agency daily statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyDailyStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_DAILY_STATISTICS_METHOD, id));
	}

	/**
	 * Agency daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_DAILY_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Agency daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyDailyStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_DAILY_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Agency publisher statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyPublisherStatistics(Integer id) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_PUBLISHER_STATISTICS_METHOD, id));
	}

	/**
	 * Agency publisher statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyPublisherStatistics(Integer id, Date startDate)
			throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_DAILY_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Agency publisher statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Map[] agencyPublisherStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException, IOException {
		return vectorToArrayMaps(execute(AGENCY_DAILY_STATISTICS_METHOD, id,
				startDate, endDate));
	}
}
