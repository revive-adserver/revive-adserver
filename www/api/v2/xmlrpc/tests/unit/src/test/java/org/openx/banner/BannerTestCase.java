/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                             |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id$
*/

package org.openx.banner;

import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.campaign.CampaignTestCase;
import org.openx.config.GlobalSettings;
import org.openx.utils.StreamUtils;

/**
 * Base class for all banner web service tests
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class BannerTestCase extends CampaignTestCase {
	protected static final String GET_BANNER_LIST_BY_CAMPAIGN_ID_METHOD = "ox.getBannerListByCampaignId";
	protected static final String GET_BANNER_METHOD = "ox.getBanner";
	protected static final String ADD_BANNER_METHOD = "ox.addBanner";
	protected static final String DELETE_BANNER_METHOD = "ox.deleteBanner";
	protected static final String MODIFY_BANNER_METHOD = "ox.modifyBanner";
	protected static final String GET_BANNER_TARGETING = "ox.getBannerTargeting";
	protected static final String SET_BANNER_TARGETING = "ox.setBannerTargeting";
	protected static final String BANNER_DAILY_STATISTICS_METHOD = "ox.bannerDailyStatistics";
	protected static final String BANNER_PUBLISHER_STATISTICS_METHOD = "ox.bannerPublisherStatistics";
	protected static final String BANNER_ZONE_STATISTICS_METHOD = "ox.bannerZoneStatistics";

	protected static final String BANNER_ID = "bannerId";
	protected static final String URL = "url";
	protected static final String WEIGHT = "weight";
	protected static final String HEIGHT = "height";
	protected static final String WIDTH = "width";
	protected static final String STATUS = "status";
	protected static final String HTML_TEMPLATE = "htmlTemplate";
	protected static final String BANNER_TEXT = "bannerText";
	protected static final String STORAGE_TYPE = "storageType";
	protected static final String BANNER_NAME = "bannerName";
	protected static final String CAMPAIGN_ID = "campaignId";
	protected static final String IMAGE_URL = "imageURL";
	protected static final String IMAGE = "aImage";
	protected static final String IMAGE_FILENAME = "filename";
	protected static final String IMAGE_CONTENT = "content";
	protected static final String ALTERNATE_BACKUP_IMAGE = "aBackupImage";
	protected static final String CAPPING = "capping";
	protected static final String SESSION_CAPPING = "sessionCapping";
	protected static final String BLOCK = "block";
	protected static final String COMMENTS = "comments";
	protected static final String[] STORAGE_TYPES = {"sql", "web", "url", "html", "txt"};

	protected static final String TARGETING_LOGICAL = "logical";
	protected static final String TARGETING_TYPE = "type";
	protected static final String TARGETING_COMPATISON = "comparison";
	protected static final String TARGETING_DATA = "data";

	protected Integer campaignId = null;

	protected void setUp() throws Exception {
		super.setUp();

		campaignId = createCampaign();
	}

	protected void tearDown() throws Exception {

		deleteCampaign(campaignId);

		super.tearDown();
	}

	/**
	 * @return banner id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createBanner() throws XmlRpcException, MalformedURLException {
		return createBanner(getBannerParams("test"));
	}

	/**
	 * @return banner id
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public Integer createBanner(Map<String, Object> params)
			throws XmlRpcException, MalformedURLException {
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getBannerServiceUrl()));

		Object[] paramsWithId = new Object[] { sessionId, params };
		final Integer result = (Integer) client.execute(ADD_BANNER_METHOD,
				paramsWithId);
		return result;
	}

	/**
	 * @param id -
	 *            id of banner you want to remove
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public boolean deleteBanner(Integer id) throws XmlRpcException,
			MalformedURLException {
		// set URL
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getBannerServiceUrl()));

		return (Boolean) client.execute(DELETE_BANNER_METHOD, new Object[] {
				sessionId, id });
	}

	public Object execute(String method, Object[] params)
			throws XmlRpcException, MalformedURLException {
		// set URL
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getBannerServiceUrl()));

		return client.execute(method, params);
	}

	public Map<String, Object> getBannerParams(String prefix) {
		
		Map<String, Object> params = new HashMap<String, Object>();
		params.put(CAMPAIGN_ID, campaignId);
		params.put(BANNER_NAME, prefix + BANNER_NAME);
		params.put(STORAGE_TYPE, STORAGE_TYPES[0]);
		params.put(IMAGE_URL, "http://www." + prefix + ".com/images/testFile.bmp");
		params.put(HTML_TEMPLATE, "<p>" + prefix + "</p>");
		params.put(WIDTH, 120);
		params.put(HEIGHT, 120);
		params.put(WEIGHT, 3);
		params.put(URL, "http://www." + prefix + ".com");
		params.put(IMAGE, getBannerImage());
		params.put(STATUS, 0);
		return params;
	}
	
	@SuppressWarnings("unchecked")
	public Map <String, Object> getBannerImage() {

		String fileName ="120x120.gif";
		InputStream imageFileStream = ClassLoader.getSystemResourceAsStream(fileName);
		Map<String, Object> bannerData = new HashMap();
		byte[] imageBinaryData = null;
		try {
			imageBinaryData = StreamUtils.getBytes(imageFileStream);
		} catch (IOException e) {
			e.printStackTrace();
			fail(e.getMessage());
		}
		bannerData.put(IMAGE_FILENAME, fileName);
		bannerData.put(IMAGE_CONTENT, imageBinaryData);
		return bannerData;
	}
}
