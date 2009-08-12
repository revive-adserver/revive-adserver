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
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Modify Banner method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestModifyBannerV2 extends BannerTestCase {
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
	private void executeModifyBannerWithError(Object[] params, String errorMsg)
		throws MalformedURLException {
		
		try {
			execute(MODIFY_BANNER_METHOD, params);
			fail(MODIFY_BANNER_METHOD
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
	public void testModifyBannerAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(BANNER_ID, bannerId);
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(BANNER_NAME, "test Banner Modified");
		struct.put(STORAGE_TYPE, "sql");
		Object[] params = new Object[] { sessionId, struct };
		final boolean result = (Boolean) execute(MODIFY_BANNER_METHOD, params);
		assertTrue(result);
	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testModifyBannerWithCappingsField()
			throws XmlRpcException, MalformedURLException {
		
		assertNotNull(campaignId);
		Map<String, Object> myBanner = new HashMap<String, Object>();
		myBanner.put(BANNER_ID, bannerId);
		myBanner.put(CAMPAIGN_ID, campaignId);
		myBanner.put(BANNER_NAME, "test Banner Modified");
		myBanner.put(URL, "http://www.a.com/index.html");
		myBanner.put(CAPPING, 5);
		myBanner.put(SESSION_CAPPING, 15);
		myBanner.put(BLOCK, 4210); //in sec
		myBanner.put(COMMENTS, "Some comments - modify banner");

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, myBanner };
		final boolean result = (Boolean) execute(MODIFY_BANNER_METHOD, XMLRPCMethodParameters);
		assertTrue(result);

		XMLRPCMethodParameters = new Object[] { sessionId, bannerId };
		final Map<String, Object> banner = (Map<String, Object>) execute(
				GET_BANNER_METHOD, XMLRPCMethodParameters);

		checkParameter(banner, CAMPAIGN_ID, campaignId);
		checkParameter(banner, BANNER_ID, bannerId);
		checkParameter(banner, BANNER_NAME, myBanner.get(BANNER_NAME));
		checkParameter(banner, URL, myBanner.get(URL));
		checkParameter(banner, CAPPING, myBanner.get(CAPPING));
		checkParameter(banner, SESSION_CAPPING, myBanner.get(SESSION_CAPPING));
		checkParameter(banner, COMMENTS, myBanner.get(COMMENTS));
	}
	
	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyBannerWithoutSomeRequiredFields()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(BANNER_NAME, "test Banner Modified");
		Object[] params = new Object[] { sessionId, struct };

		executeModifyBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, BANNER_ID));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testModifyBannerGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {
		final String strGreaterThan255 = TextUtils.getString(256);
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(BANNER_ID, bannerId);
		Object[] params = new Object[] { sessionId, struct };

		struct.put(BANNER_NAME, strGreaterThan255);

		executeModifyBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, BANNER_NAME));
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyBannerMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(BANNER_ID, bannerId);
		struct.put(BANNER_NAME, "");
		struct.put("fileName", "");
		struct.put(IMAGE_URL, "");
		struct.put(HTML_TEMPLATE, "");
		struct.put(URL, "");
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) execute(MODIFY_BANNER_METHOD, params);
		assertTrue(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyBannerMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(BANNER_ID, bannerId);
		struct.put(BANNER_NAME, TextUtils.getString(255));
		struct.put(IMAGE_URL, TextUtils.getString(255));
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) execute(MODIFY_BANNER_METHOD, params);
		assertTrue(result);
	}

	/**
	 * Try to modify banner with unknown bannerId
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyBannerUnknownBannerIdError() throws XmlRpcException,
			MalformedURLException {

		Integer bannerId = createBanner();
		deleteBanner(bannerId);
		Map<String, Object> modifyBannerParameters = new HashMap<String, Object>();
		modifyBannerParameters.put(BANNER_ID, bannerId);
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyBannerParameters };

		executeModifyBannerWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, BANNER_ID));
	}

	/**
	 * Try to modify banner with unknown campaignId
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyBannerUnknownCampaignIdError() throws XmlRpcException,
			MalformedURLException {

		Map<String, Object> modifyBannerParameters = new HashMap<String, Object>();
		modifyBannerParameters.put(BANNER_ID, bannerId);
		int campaignId = createCampaign();
		deleteCampaign(campaignId);
		modifyBannerParameters.put(CAMPAIGN_ID, campaignId);
		Object[] XMLMethodParameters = new Object[] { sessionId, modifyBannerParameters };
		executeModifyBannerWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	
	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyBannerWrongTypeError() throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(BANNER_ID, bannerId);
		Object[] params = new Object[] { sessionId, struct };

		struct.put(CAMPAIGN_ID, TextUtils.NOT_INTEGER);
		executeModifyBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_INTEGER, CAMPAIGN_ID));

		struct.remove(CAMPAIGN_ID);
		struct.put(BANNER_NAME, TextUtils.NOT_STRING);
		executeModifyBannerWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, BANNER_NAME));
	}
}
