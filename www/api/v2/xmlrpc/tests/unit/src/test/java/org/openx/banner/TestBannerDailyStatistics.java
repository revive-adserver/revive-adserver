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

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.DateUtils;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Banner Daily Statistics method
 */

public class TestBannerDailyStatistics extends BannerTestCase {
	private Integer bannerId = null;

	protected void setUp() throws Exception {
		super.setUp();

		bannerId = createBanner();
	}

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
	private void executeBannerDailyStatisticsWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			execute(BANNER_DAILY_STATISTICS_METHOD, params);
			fail(BANNER_DAILY_STATISTICS_METHOD
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
	public void testBannerDailyStatisticsAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MIN_DATE_VALUE };

		Object[] result = (Object[]) execute(BANNER_DAILY_STATISTICS_METHOD,
				params);

		assertNotNull(result);

	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testBannerDailyStatisticsWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeBannerDailyStatisticsWithError(params, ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"5, 4, 3, or 2", "1"));

	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testBannerDailyStatisticsGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.DATE_GREATER_THAN_MAX, DateUtils.MAX_DATE_VALUE };

		executeBannerDailyStatisticsWithError(params,
				ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
	}

	/**
	 * Test method with fields that has value less than min
	 *
	 * @throws MalformedURLException
	 */
	public void testBannerDailyStatisticsLessThanMinFieldValueError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MIN_DATE_VALUE, DateUtils.DATE_LESS_THAN_MIN };

		executeBannerDailyStatisticsWithError(params,
				ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testBannerDailyStatisticsMinValues() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MIN_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		execute(BANNER_DAILY_STATISTICS_METHOD, params);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testBannerDailyStatisticsMaxValues() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MAX_DATE_VALUE };

		execute(BANNER_DAILY_STATISTICS_METHOD, params);
	}

	/**
	 * BannerDailyStatistics banner with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testBannerDailyStatisticsUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createBanner();
		deleteBanner(id);
		Object[] params = new Object[] { sessionId, id };

		executeBannerDailyStatisticsWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, BANNER_ID));
	}

	/**
	 * BannerDailyStatistics when end date is before start date
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testBannerDailyStatisticsDateError() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		executeBannerDailyStatisticsWithError(params,
				ErrorMessage.START_DATE_IS_AFTER_END_DATE);
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testBannerDailyStatisticsWrongTypeError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, bannerId,
				TextUtils.NOT_DATE, DateUtils.MAX_DATE_VALUE };
		executeBannerDailyStatisticsWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING, "3"));

		params = new Object[] { sessionId, bannerId, DateUtils.MIN_DATE_VALUE,
				TextUtils.NOT_DATE };
		executeBannerDailyStatisticsWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING, "4"));
	}

}
