/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2010 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU Lesser General Public License as published  |
| by the Free Software Foundation; either version 2 of the License, or      |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU Lesser General Public License for more details.                       |
|                                                                           |
| You should have received a copy of the GNU Lesser General Public License  |
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
 * Base class for all zone web service tests.
 *
 */
class ZoneService extends AbstractService {
	private static final String ZONE_SERVICE = "";

	private static final String ADD_ZONE_METHOD = "ox.addZone";
	private static final String MODIFY_ZONE_METHOD = "ox.modifyZone";
	private static final String DELETE_ZONE_METHOD = "ox.deleteZone";
	private final static String ZONE_ADVERTISER_STATISTICS_METHOD = "ox.zoneAdvertiserStatistics";
	private static final String ZONE_DAILY_STATISTICS_METHOD = "ox.zoneDailyStatistics";
	private final static String ZONE_CAMPAIGN_STATISTICS_METHOD = "ox.zoneCampaignStatistics";
	private final static String ZONE_BANNER_STATISTICS_METHOD = "ox.zoneBannerStatistics";
	private static final String GET_ZONE_LIST_BY_PUBLISHER_ID_METHOD = "ox.getZoneListByPublisherId";
	private static final String GET_ZONE_METHOD = "ox.getZone";

	/**
	 * Instantiates a new zone service.
	 *
	 * @param client the client
	 * @param basepath the basepath
	 */
	public ZoneService(XmlRpcClient client, String basepath) {
		super(client, basepath);
	}

	/* (non-Javadoc)
	 * @see org.openads.proxy.AbstractService#getService()
	 */
	@Override
	public String getService() {
		return ZONE_SERVICE;
	}

	/**
	 * Adds the zone.
	 *
	 * @param params the params
	 *
	 * @return the integer
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Integer addZone(Map params) throws XmlRpcException {
		return (Integer) execute(ADD_ZONE_METHOD, params);
	}

	/**
	 * Modify zone.
	 *
	 * @param params the params
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean modifyZone(Map params) throws XmlRpcException {
		return (Boolean) execute(MODIFY_ZONE_METHOD, params);
	}

	/**
	 * Delete zone.
	 *
	 * @param id the id
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean deleteZone(Integer id) throws XmlRpcException {
		return (Boolean) execute(DELETE_ZONE_METHOD, id);
	}

	/**
	 * Gets the zone.
	 *
	 * @param id the id
	 *
	 * @return the zone
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map getZone(Integer id) throws XmlRpcException {
		return (Map) execute(GET_ZONE_METHOD, id);
	}

	/**
	 * Gets the zone list by publisher id.
	 *
	 * @param id the id
	 *
	 * @return the zone list by publisher id
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] getZoneListByPublisherId(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(GET_ZONE_LIST_BY_PUBLISHER_ID_METHOD, id));
	}

	/**
	 * Zone advertiser statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneAdvertiserStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_ADVERTISER_STATISTICS_METHOD,
				id));
	}

	/**
	 * Zone advertiser statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneAdvertiserStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_ADVERTISER_STATISTICS_METHOD,
				id, startDate));
	}

	/**
	 * Zone advertiser statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneAdvertiserStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_ADVERTISER_STATISTICS_METHOD,
				id, startDate, endDate));
	}

	/**
	 * Zone advertiser statistics.
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
	public Map[] zoneAdvertiserStatistics(Integer id, Date startDate,
			Date endDate, Boolean useLocalTimeZone) throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_ADVERTISER_STATISTICS_METHOD,
				id, startDate, endDate, useLocalTimeZone));
	}

	/**
	 * Zone banner statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneBannerStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_BANNER_STATISTICS_METHOD, id));
	}

	/**
	 * Zone banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_BANNER_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Zone banner statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneBannerStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_BANNER_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Zone banner statistics.
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
	public Map[] zoneBannerStatistics(Integer id, Date startDate, Date endDate, Boolean useLocalTimeZone)
			throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_BANNER_STATISTICS_METHOD, id,
				startDate, endDate, useLocalTimeZone));
	}

	/**
	 * Zone campaign statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneCampaignStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_CAMPAIGN_STATISTICS_METHOD, id));
	}

	/**
	 * Zone campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_CAMPAIGN_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Zone campaign statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneCampaignStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_CAMPAIGN_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Zone campaign statistics.
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
	public Map[] zoneCampaignStatistics(Integer id, Date startDate,
			Date endDate, Boolean useLocalTimeZone) throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_CAMPAIGN_STATISTICS_METHOD, id,
				startDate, endDate, useLocalTimeZone));
	}

	/**
	 * Zone daily statistics.
	 *
	 * @param id the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneDailyStatistics(Integer id) throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_DAILY_STATISTICS_METHOD, id));
	}

	/**
	 * Zone daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_DAILY_STATISTICS_METHOD, id,
				startDate));
	}

	/**
	 * Zone daily statistics.
	 *
	 * @param id the id
	 * @param startDate the start date
	 * @param endDate the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Map[] zoneDailyStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_DAILY_STATISTICS_METHOD, id,
				startDate, endDate));
	}

	/**
	 * Zone daily statistics.
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
	public Map[] zoneDailyStatistics(Integer id, Date startDate, Date endDate, Boolean useLocalTimeZone)
			throws XmlRpcException {
		return objectToArrayMaps(execute(ZONE_DAILY_STATISTICS_METHOD, id,
				startDate, endDate, useLocalTimeZone));
	}

}
