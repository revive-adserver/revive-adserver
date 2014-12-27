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
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Banner method
 */
public class TestGetBanner extends BannerTestCase {

	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetBannerAllFields() throws XmlRpcException,
			MalformedURLException {

		Map<String, Object> myBanner = getBannerParams("test1");
		Integer bannerId = createBanner(myBanner);
		Object[] params = new Object[] { sessionId, bannerId };

		try {
			final Map<String, Object> banner = (Map<String, Object>) execute(
					GET_BANNER_METHOD, params);

			checkParameter(banner, CAMPAIGN_ID, campaignId);
			checkParameter(banner, BANNER_ID, bannerId);
			checkParameter(banner, BANNER_NAME, myBanner.get(BANNER_NAME));
			checkParameter(banner, STORAGE_TYPE, myBanner.get(STORAGE_TYPE));
			checkParameter(banner, IMAGE_URL, myBanner.get(IMAGE_URL));
			checkParameter(banner, HTML_TEMPLATE, myBanner.get(HTML_TEMPLATE));
			checkParameter(banner, WIDTH, myBanner.get(WIDTH));
			checkParameter(banner, HEIGHT, myBanner.get(HEIGHT));
			checkParameter(banner, WEIGHT, myBanner.get(WEIGHT));
			checkParameter(banner, URL, myBanner.get(URL));
			checkParameter(banner, STATUS, myBanner.get(STATUS));
		} finally {
			deleteBanner(bannerId);
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
	private void executeGetBannerWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			Map<String, Object> result = (Map<String, Object>) execute(
					GET_BANNER_METHOD, params);
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
	public void testGetBannerWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetBannerWithError(params, ErrorMessage.getMessage(ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1")));

	}

	/**
	 * Try to get banner with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetBannerUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createBanner();
		deleteBanner(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, BANNER_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetBannerIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
