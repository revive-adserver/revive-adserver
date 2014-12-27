/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.campaign;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Campaign List By Advertiser Id method
 */

public class TestGetCampaignListByAdvertiserId extends CampaignTestCase {
	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetCampaignListByAdvertiserIdAllFields()
			throws XmlRpcException, MalformedURLException {
		final int campaignsCount = 3;
		Map<Integer, Map<String, Object>> myCampaignes = new HashMap<Integer, Map<String, Object>>();
		for (int i = 0; i < campaignsCount; i++) {
			Map<String, Object> param = getCampaignParams("test2" + i);
			myCampaignes.put(createCampaign(param), param);
		}

		try {
			final Object[] result = (Object[]) execute(GET_CAMPAIGN_LIST_BY_ADVERTISER_ID_METHOD,
					new Object[] { sessionId, advertiserId });

			assertEquals("Not correct count return campaignes",
					myCampaignes.size(), campaignsCount);

			for (Object campaign : result) {
				Integer campaignId = (Integer) ((Map) campaign).get(CAMPAIGN_ID);

				Map<String, Object> myCampaign = myCampaignes.get(campaignId);

				if (myCampaign != null) {
					checkParameter((Map) campaign, ADVERTISER_ID, advertiserId);
					checkParameter((Map) campaign, CAMPAIGN_ID, campaignId);
					checkParameter((Map) campaign, CAMPAIGN_NAME, myCampaign.get(CAMPAIGN_NAME));
					checkParameter((Map) campaign, START_DATE, myCampaign.get(START_DATE));
					checkParameter((Map) campaign, END_DATE, myCampaign.get(END_DATE));
					checkParameter((Map) campaign, IMPRESSIONS, myCampaign.get(IMPRESSIONS));
					checkParameter((Map) campaign, CLICKS, myCampaign.get(CLICKS));
					checkParameter((Map) campaign, PRIORITY, myCampaign.get(PRIORITY));
					checkParameter((Map) campaign, WEIGHT, myCampaign.get(WEIGHT));

					// remove checked campaign
					myCampaignes.remove(campaignId);
				}
			}
		} finally {
			// delete all created campaignes
			for (Integer id : myCampaignes.keySet()) {
				deleteCampaign(id);
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
	private void executeGetCampaignListByAdvertiserIdWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			List<Map<String, Object>> result = (List<Map<String, Object>>) execute(
					GET_CAMPAIGN_LIST_BY_ADVERTISER_ID_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Try to get campaign list by advertiser with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetCampaignListByAdvertiserIdUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createAdvertiser();
		deleteAdvertiser(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetCampaignListByAdvertiserIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, ADVERTISER_ID));
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetCampaignListByAdvertiserIdWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetCampaignListByAdvertiserIdWithError(params, ErrorMessage
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
	public void testGetCampaignListByAdvertiserIdWrongTypeError()
			throws MalformedURLException, XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetCampaignListByAdvertiserIdWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING,
								"2"));
	}

}
