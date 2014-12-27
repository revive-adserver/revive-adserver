/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.banner;

import java.net.MalformedURLException;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.DateUtils;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Banner Publisher Statistics method
 */
public class TestBannerPublisherStatistics extends BannerTestCase {
	private Integer bannerId = null;

	@Override
	protected void setUp() throws Exception {
		super.setUp();

		bannerId = createBanner();
	}

	@Override
	protected void tearDown() throws Exception {
		deleteBanner(bannerId);
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
	private void executeBannerPublisherStatisticsWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			execute(BANNER_PUBLISHER_STATISTICS_METHOD, params);
			fail(BANNER_PUBLISHER_STATISTICS_METHOD
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
	public void testBannerPublisherStatisticsAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		assertNotNull("Can't get bannerId by setUp method.", bannerId);

		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MIN_DATE_VALUE };
		final Object[] result = (Object[]) execute(
				BANNER_PUBLISHER_STATISTICS_METHOD, params);

		assertNotNull("Can't get result for bannerPublisherStatisticsMethod.",
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
	public void testBannerPublisherStatisticsWithoutSomeRequiredFields()
			throws MalformedURLException {

		Object[] params = new Object[] { sessionId };

		executeBannerPublisherStatisticsWithError(params, ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"4, 3, or 2", "1"));

	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testBannerPublisherStatisticsGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.DATE_GREATER_THAN_MAX, DateUtils.MAX_DATE_VALUE };

		executeBannerPublisherStatisticsWithError(params,
				ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
	}

	/**
	 * Test method with fields that has value less than min
	 *
	 * @throws MalformedURLException
	 */
	public void testBannerPublisherStatisticsLessThanMinFieldValueError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MIN_DATE_VALUE, DateUtils.DATE_LESS_THAN_MIN };
		executeBannerPublisherStatisticsWithError(params,
				ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testBannerPublisherStatisticsMinValues()
			throws XmlRpcException, MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MIN_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		execute(BANNER_PUBLISHER_STATISTICS_METHOD, params);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testBannerPublisherStatisticsMaxValues()
			throws XmlRpcException, MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MAX_DATE_VALUE };

		execute(BANNER_PUBLISHER_STATISTICS_METHOD, params);
	}

	/**
	 * BannerPublisherStatistics banner with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testBannerPublisherStatisticsUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createBanner();
		deleteBanner(id);
		Object[] params = new Object[] { sessionId, id };

		executeBannerPublisherStatisticsWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, BANNER_ID));
	}

	/**
	 * BannerPublisherStatistics when end date is before start date
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testBannerPublisherStatisticsDateError()
			throws XmlRpcException, MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		executeBannerPublisherStatisticsWithError(params,
				ErrorMessage.START_DATE_IS_AFTER_END_DATE);
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testBannerPublisherStatisticsWrongTypeError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				TextUtils.NOT_DATE, DateUtils.MAX_DATE_VALUE };

		executeBannerPublisherStatisticsWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING,
								"3"));

		params = new Object[] { sessionId, bannerId, DateUtils.MIN_DATE_VALUE,
				TextUtils.NOT_DATE };
		executeBannerPublisherStatisticsWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING,
								"4"));
	}

}
