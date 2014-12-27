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

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.DateUtils;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Campaign Daily Statistics method
 */

public class TestCampaignDailyStatistics extends CampaignTestCase {
	private Integer campaignId = null;

	protected void setUp() throws Exception {
		super.setUp();

		campaignId = createCampaign();
	}

	protected void tearDown() throws Exception {

		deleteCampaign(campaignId);

		super.tearDown();
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
	private void executeCampaignDailyStatisticsWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			execute(CAMPAIGN_DAILY_STATISTICS_METHOD, params);
			fail(CAMPAIGN_DAILY_STATISTICS_METHOD
					+ " executed successfully, but it shouldn't.");
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}

	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignDailyStatisticsAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MIN_DATE_VALUE };

		Object[] result = (Object[]) execute(CAMPAIGN_DAILY_STATISTICS_METHOD,
				params);
		assertNotNull(result);
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testCampaignDailyStatisticsWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeCampaignDailyStatisticsWithError(params, ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"4, 3, or 2", "1"));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testCampaignDailyStatisticsGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.DATE_GREATER_THAN_MAX, DateUtils.MAX_DATE_VALUE };

		executeCampaignDailyStatisticsWithError(params,
				ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
	}

	/**
	 * Test method with fields that has value less than min
	 *
	 * @throws MalformedURLException
	 */
	public void testCampaignDailyStatisticsLessThanMinFieldValueError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MIN_DATE_VALUE, DateUtils.DATE_LESS_THAN_MIN };

		executeCampaignDailyStatisticsWithError(params,
				ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignDailyStatisticsMinValues() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MIN_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		Object[] result = (Object[]) execute(CAMPAIGN_DAILY_STATISTICS_METHOD,
				params);
		assertNotNull(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignDailyStatisticsMaxValues() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MAX_DATE_VALUE };

		Object[] result = (Object[]) execute(CAMPAIGN_DAILY_STATISTICS_METHOD,
				params);
		assertNotNull(result);
	}

	/**
	 * CampaignDailyStatistics with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignDailyStatisticsUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createCampaign();
		deleteCampaign(id);
		Object[] params = new Object[] { sessionId, id };

		executeCampaignDailyStatisticsWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * CampaignDailyStatistics when end date is before start date
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignDailyStatisticsDateError() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		executeCampaignDailyStatisticsWithError(params,
				ErrorMessage.START_DATE_IS_AFTER_END_DATE);
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testCampaignDailyStatisticsWrongTypeError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				TextUtils.NOT_DATE, DateUtils.MAX_DATE_VALUE };
		executeCampaignDailyStatisticsWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING,
								"3"));

		params = new Object[] { sessionId, campaignId,
				DateUtils.MIN_DATE_VALUE, TextUtils.NOT_DATE };
		executeCampaignDailyStatisticsWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING,
								"4"));
	}
}
