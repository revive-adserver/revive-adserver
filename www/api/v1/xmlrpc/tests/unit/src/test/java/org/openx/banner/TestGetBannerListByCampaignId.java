/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
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

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Banner List By Campaign Id method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */

public class TestGetBannerListByCampaignId extends BannerTestCase {
	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetBannerListByCampaignIdAllFields()
			throws XmlRpcException, MalformedURLException {

		final int bannersCount = 3;
		Map<Integer, Map<String, Object>> myBanners = new HashMap<Integer, Map<String, Object>>();
		for (int i = 0; i < bannersCount; i++) {
			Map<String, Object> param = getBannerParams("test2" + i);
			myBanners.put(createBanner(param), param);
		}

		try {
			final Object[] result = (Object[]) execute(GET_BANNER_LIST_BY_CAMPAIGN_ID_METHOD,
					new Object[] { sessionId, campaignId });

			assertEquals("Not correct count return banners", myBanners.size(), bannersCount);

			for (Object banner : result) {
				Integer bannerId = (Integer) ((Map) banner).get(BANNER_ID);

				Map<String, Object> myBanner = myBanners.get(bannerId);

				if (myBanner != null) {
					checkParameter((Map) banner, CAMPAIGN_ID, campaignId);
					checkParameter((Map) banner, BANNER_ID, bannerId);
					checkParameter((Map) banner, STORAGE_TYPE, myBanner.get(STORAGE_TYPE));
					checkParameter((Map) banner, IMAGE_URL, myBanner.get(IMAGE_URL));
					checkParameter((Map) banner, HTML_TEMPLATE, myBanner.get(HTML_TEMPLATE));
					checkParameter((Map) banner, WIDTH, myBanner.get(WIDTH));
					checkParameter((Map) banner, HEIGHT, myBanner.get(HEIGHT));
					checkParameter((Map) banner, WEIGHT, myBanner.get(WEIGHT));
					checkParameter((Map) banner, URL, myBanner.get(URL));
					// remove checked agency
					myBanners.remove(bannerId);
				}
			}
		} finally {
			// delete all created advertisers
			for (Integer id : myBanners.keySet()) {
				deleteBanner(id);
			}
		}
	}

	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	private void executeGetBannerListByCampaignIdWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			List<Map<String, Object>> result = (List<Map<String, Object>>) execute(
					GET_BANNER_LIST_BY_CAMPAIGN_ID_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Try to get banner list by campaign with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetBannerListByCampaignIdUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createCampaign();
		deleteCampaign(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetBannerListByCampaignIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetBannerListByCampaignIdWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetBannerListByCampaignIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.getMessage(
						ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1")));

	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetBannerListByCampaignIdWrongTypeError()
			throws MalformedURLException, XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetBannerListByCampaignIdWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING,
								"2"));
	}

}
