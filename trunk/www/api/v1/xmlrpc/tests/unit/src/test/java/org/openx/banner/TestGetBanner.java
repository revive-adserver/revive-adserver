/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Banner method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
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
