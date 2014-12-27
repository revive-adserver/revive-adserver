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
import org.openx.utils.DateUtils;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Campaign Publisher Statistics method
 */
public class TestCampaignPublisherStatistics extends CampaignTestCase {
	private Integer campaignId;

	@Override
	protected void setUp() throws Exception {
		super.setUp();
		campaignId = createCampaign();
	}

	@Override
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
	private void executeCampaignPublisherStatisticsWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			execute(CAMPAIGN_PUBLISHER_STATISTICS_METHOD, params);
			fail(CAMPAIGN_PUBLISHER_STATISTICS_METHOD
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
	@SuppressWarnings("unchecked")
	public void testCampaignPublisherStatisticsAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		assertNotNull("Can't get campaignId by setUp method.", campaignId);

		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MIN_DATE_VALUE };
		final Object[] result = (Object[]) execute(
				CAMPAIGN_PUBLISHER_STATISTICS_METHOD, params);

		assertNotNull(
				"Can't get result for CampaignPublisherStatisticsMethod.",
				result);

		if (result.length > 0) {
			final Map<String, Object> item = (Map<String, Object>) result[0];
			assertTrue("Can't find 'publisherId' field.", item
					.containsKey("publisherId"));
			assertTrue("Can't find 'publisherName' field.", item
					.containsKey("publisherName"));
			assertTrue("Can't find 'requests' field.", item
					.containsKey("requests"));
			assertTrue("Can't find 'impressions' field.", item
					.containsKey("impressions"));
			assertTrue("Can't find 'clicks' field.", item.containsKey("clicks"));
			assertTrue("Can't find 'revenue' field.", item
					.containsKey("revenue"));
		}
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testCampaignPublisherStatisticsWithoutSomeRequiredFields()
			throws MalformedURLException {

		Object[] params = new Object[] { sessionId };

		executeCampaignPublisherStatisticsWithError(params, ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"4, 3, or 2", "1"));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testCampaignPublisherStatisticsGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.DATE_GREATER_THAN_MAX, DateUtils.MAX_DATE_VALUE };

		executeCampaignPublisherStatisticsWithError(params,
				ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
	}

	/**
	 * Test method with fields that has value less than min
	 *
	 * @throws MalformedURLException
	 */
	public void testCampaignPublisherStatisticsLessThanMinFieldValueError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MIN_DATE_VALUE, DateUtils.DATE_LESS_THAN_MIN };

		executeCampaignPublisherStatisticsWithError(params,
				ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignPublisherStatisticsMinValues()
			throws XmlRpcException, MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MIN_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		final Object[] result = (Object[]) execute(
				CAMPAIGN_PUBLISHER_STATISTICS_METHOD, params);

		assertNotNull(
				"Can't get result for CampaignPublisherStatisticsMethod.",
				result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignPublisherStatisticsMaxValues()
			throws XmlRpcException, MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MAX_DATE_VALUE };

		final Object[] result = (Object[]) execute(
				CAMPAIGN_PUBLISHER_STATISTICS_METHOD, params);

		assertNotNull(
				"Can't get result for CampaignPublisherStatisticsMethod.",
				result);
	}

	/**
	 * with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignPublisherStatisticsUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createCampaign();
		deleteCampaign(id);
		Object[] params = new Object[] { sessionId, id };

		executeCampaignPublisherStatisticsWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * when end date is before start date
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testCampaignPublisherStatisticsDateError()
			throws XmlRpcException, MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		executeCampaignPublisherStatisticsWithError(params,
				ErrorMessage.START_DATE_IS_AFTER_END_DATE);
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testCampaignPublisherStatisticsWrongTypeError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, campaignId,
				TextUtils.NOT_DATE, DateUtils.MAX_DATE_VALUE };
		executeCampaignPublisherStatisticsWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING,
								"3"));

		params = new Object[] { sessionId, campaignId,
				DateUtils.MIN_DATE_VALUE, TextUtils.NOT_DATE };
		executeCampaignPublisherStatisticsWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING,
								"4"));
	}
}
