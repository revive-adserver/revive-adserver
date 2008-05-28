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
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Add Banner method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestAddBanner extends BannerTestCase {
	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeAddBannerWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_BANNER_METHOD, params);
			fail(ADD_BANNER_METHOD
					+ " executed successfully, but it shouldn't.");
			deleteBanner(result);
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
	public void testAddBannerAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		
		assertNotNull(campaignId);
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(BANNER_NAME, "testBanner");
		struct.put(STORAGE_TYPE, "web");
		struct.put(IMAGE_URL, "http://www.a.com/image.gif");
		struct.put(HTML_TEMPLATE, "<p>I am banner</p>");
		struct.put(WIDTH, 1);
		struct.put(WEIGHT, 2);
		struct.put(URL, "http://www.a.com/index.html");
		struct.put(IMAGE, getBannerImage());

		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_BANNER_METHOD, params);
		assertNotNull(result);
		deleteBanner(result);
	}

	/**
	 * Test method without aImage required field.
	 *
	 * @throws MalformedURLException
	 */
	public void testAddBannerWithoutImageField()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(STORAGE_TYPE, "html");
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(BANNER_NAME, "testBanner");
		struct.put(STORAGE_TYPE, "web");
		struct.put(IMAGE_URL, "http://www.a.com/image.gif");
		struct.put(HTML_TEMPLATE, "<p>I am banner</p>");
		struct.put(WIDTH, 1);
		struct.put(WEIGHT, 2);
		struct.put(URL, "http://www.a.com/index.html");
		
		Object[] params = new Object[] { sessionId, struct };

		executeAddBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_MUST_NOT_BE_EMPTY, IMAGE));
	}
	
	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testAddBannerWithoutSomeRequiredFields()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(STORAGE_TYPE, "html");

		Object[] params = new Object[] { sessionId, struct };

		executeAddBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, CAMPAIGN_ID));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddBannerGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {
		final String strGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(BANNER_NAME, strGreaterThan255);

		Object[] params = new Object[] { sessionId, struct };

		executeAddBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, BANNER_NAME));
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddBannerMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(BANNER_NAME, "");
		struct.put(IMAGE_URL, "");
		struct.put(HTML_TEMPLATE, "");
		struct.put(URL, "");
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) execute(ADD_BANNER_METHOD, params);
		assertNotNull(result);
		deleteBanner(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddBannerMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(BANNER_NAME, TextUtils.getString(255));
		struct.put(IMAGE_URL, TextUtils.getString(255));
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) execute(ADD_BANNER_METHOD, params);
		assertNotNull(result);
		deleteBanner(result);
	}

	/**
	 * Try to add banner with nonexistent campaign id
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddBannerUnknownIdError() throws MalformedURLException,
			XmlRpcException {
		// get nonexistent campaign id
		int id = createCampaign();
		deleteCampaign(id);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, id);
		Object[] params = new Object[] { sessionId, struct };

		executeAddBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddBannerWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(BANNER_NAME, TextUtils.NOT_STRING);
		executeAddBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, BANNER_NAME));
	}
}
