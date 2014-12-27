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
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Campaign method
 */
public class TestGetCampaign extends CampaignTestCase {

	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetCampaignAllFields() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> myCampaign = getCampaignParams("test1");
		Integer id = createCampaign(myCampaign);
		Object[] params = new Object[] { sessionId, id };

		try {
			final Map<String, Object> campaign = (Map<String, Object>) execute(
					GET_CAMPAIGN_METHOD, params);

			checkParameter(campaign, ADVERTISER_ID, advertiserId);
			checkParameter(campaign, CAMPAIGN_ID, id);
			checkParameter(campaign, CAMPAIGN_NAME, myCampaign.get(CAMPAIGN_NAME));
			checkParameter(campaign, START_DATE, myCampaign.get(START_DATE));
			checkParameter(campaign, END_DATE, myCampaign.get(END_DATE));
			checkParameter(campaign, IMPRESSIONS, myCampaign.get(IMPRESSIONS));
			checkParameter(campaign, CLICKS, myCampaign.get(CLICKS));
			checkParameter(campaign, PRIORITY, myCampaign.get(PRIORITY));
			checkParameter(campaign, WEIGHT, myCampaign.get(WEIGHT));
		} finally {
			deleteCampaign(id);
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
	private void executeGetCampaignWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			Map<String, Object> result = (Map<String, Object>) execute(
					GET_CAMPAIGN_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetCampaignWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetCampaignWithError(params, ErrorMessage
				.getMessage(ErrorMessage.getMessage(ErrorMessage
						.INCORRECT_PARAMETERS_PASSED_TO_METHOD,	"2", "1")));

	}

	/**
	 * Try to get campaign with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetCampaignUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createCampaign();
		deleteCampaign(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetCampaignWrongTypeError() throws MalformedURLException,
			XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
