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
	 */
	public PublisherService(XmlRpcClient client, String basepath) {
		super(client, basepath);
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Integer addPublisher(Map params) throws XmlRpcException {
		return (Integer) execute(ADD_PUBLISHER_METHOD, params);
	}

	/**
	 * Modify publisher.
	 *
	 * @param params the params
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean modifyPublisher(Map params) throws XmlRpcException {
		return (Boolean) execute(MODIFY_PUBLISHER_METHOD, params);
	}

	/**
	 * Delete publisher.
	 *
	 * @param id the id
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean deletePublisher(Integer id) throws XmlRpcException {
		return (Boolean) execute(DELETE_PUBLISHER_METHOD, id);
	}

	/**
	 * Gets the publisher.
	 *
	 * @param id the id
	 *
	 * @return the publisher
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map getPublisher(Integer id) throws XmlRpcException {
		return (Map) execute(GET_PUBLISHER_METHOD, id);
	}

	/**
	 * Gets the publisher list by agency id.
	 *
	 * @param id the id
	 *
	 * @return the publisher list by agency id
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] getPublisherListByAgencyId(Integer id)
			throws XmlRpcException {
		return objectToArrayMaps(execute(GET_PUBLISHER_LIST_BY_AGENCY_ID_METHOD));
	}

	/**
	 * Publisher zone statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_ZONE_STATISTICS_METHOD, id));
	}

	/**
	 * Publisher zone statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_ZONE_STATISTICS_METHOD, id,
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_ZONE_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Publisher campaign statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_CAMPAIGN_STATISTICS_METHOD,
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_CAMPAIGN_STATISTICS_METHOD,
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_CAMPAIGN_STATISTICS_METHOD,
				id, startDate, endDate));
	}

	/**
	 * Publisher daily statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_DAILY_STATISTICS_METHOD, id));
	}

	/**
	 * Publisher daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_DAILY_STATISTICS_METHOD, id,
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_DAILY_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Publisher banner statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_BANNER_STATISTICS_METHOD, id));
	}

	/**
	 * Publisher banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_BANNER_STATISTICS_METHOD,
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps(execute(PUBLISHER_BANNER_STATISTICS_METHOD,
				id, startDate, endDate));
	}

	/**
	 * Publisher advertiser statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id)
			throws XmlRpcException {
		return objectToArrayMaps(execute(
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps(execute(
				PUBLISHER_ADVERTISER_STATISTICS_METHOD, id, startDate, endDate));
	}
}
