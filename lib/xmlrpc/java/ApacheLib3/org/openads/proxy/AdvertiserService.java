/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id:$
*/

package org.openads.proxy;
import java.util.Date;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClient;

/**
 * Base class for all advertiser web service tests.
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
class AdvertiserService extends AbstractService {
	private static final String ADVERTISER_SERVICE = "AdvertiserXmlRpcService.php";

	private static final String ADD_ADVERTISER_METHOD = "addAdvertiser";
	private static final String DELETE_ADVERTISER_METHOD = "deleteAdvertiser";
	private static final String MODIFY_ADVERTISER_METHOD = "modifyAdvertiser";
	private static final String ADVERTISER_BANNER_STATISTICS_METHOD = "advertiserBannerStatistics";
	private static final String ADVERTISER_CAMPAIGN_STATISTICS_METHOD = "advertiserCampaignStatistics";
	private static final String ADVERTISER_DAILY_STATISTICS_METHOD = "advertiserDailyStatistics";
	private static final String ADVERTISER_PUBLISHER_STATISTICS_METHOD = "advertiserPublisherStatistics";
	private static final String ADVERTISER_ZONE_STATISTICS_METHOD = "advertiserZoneStatistics";
	private static final String GET_ADVERTISER_LIST_BY_AGENCY_ID_METHOD = "getAdvertiserListByAgencyId";
	private static final String GET_ADVERTISER_METHOD = "getAdvertiser";

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
		return objectToArrayMaps(execute(GET_ADVERTISER_LIST_BY_AGENCY_ID_METHOD));
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
}
