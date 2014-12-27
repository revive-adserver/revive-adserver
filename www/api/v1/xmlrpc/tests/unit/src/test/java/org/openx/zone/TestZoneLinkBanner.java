/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.zone;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.config.GlobalSettings;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Link Banner method
 */
public class TestZoneLinkBanner extends ZoneTestCase {

	protected Integer zoneId = null;
	protected Integer bannerId = null;

	protected void setUp() throws Exception {
		super.setUp();

		bannerId = createBanner();
		zoneId = createZone();
	}

	protected void tearDown() throws Exception {

		deleteBanner(bannerId);
		deleteZone(zoneId);

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
	private void executeLinkBannerWithError(Object[] params, String errorMsg)
		throws MalformedURLException {

		try {
			execute(ZONE_LINK_BANNER_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
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
	public void testLinkBannerAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };
		final Boolean result = (Boolean) client
				.execute(ZONE_LINK_BANNER_METHOD, XMLRPCMethodParameters);

		assertTrue(result);
	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLinkBannerTxtWithZoneTxt()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> zoneParams = getZoneParams("txt");
		zoneParams.put(TYPE, 3);
		zoneParams.put(PUBLISHER_ID, publisherId);
		int zoneId = createZone(zoneParams);
		Map<String, Object> bannerParams = getBannerParams("txt");
		bannerParams.put(STORAGE_TYPE, STORAGE_TYPES[4]);
		bannerParams.put(CAMPAIGN_ID, campaignId);
		int bannerId = createBanner(bannerParams);

		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getZoneServiceUrl()));

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };
		final Boolean result = (Boolean) client
				.execute(ZONE_LINK_BANNER_METHOD, XMLRPCMethodParameters);

		assertTrue(result);
	}

	/**
	 * Test method for case when linking two times Banner with same id.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLinkBannerOnceAgain()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };
		client.execute(ZONE_LINK_BANNER_METHOD, XMLRPCMethodParameters);
		//TODO: Add expected behavior from https://developer.openx.org/jira/browse/OX-3296
		final Boolean result = (Boolean) client
				.execute(ZONE_LINK_BANNER_METHOD, XMLRPCMethodParameters);

		assertTrue(result);
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkBannerUnknownZoneIdError() throws MalformedURLException,
			XmlRpcException {

		Integer zoneId = createZone();
		assertNotNull(zoneId);
		deleteZone(zoneId);

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };

		executeLinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ZONE_ID));
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkBannerUnknownBannerIdError() throws MalformedURLException,
			XmlRpcException {

		Integer bannerId = createBanner();
		assertNotNull(bannerId);
		deleteBanner(bannerId);

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };

		executeLinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, BANNER_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkBannerBannerIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, TextUtils.NOT_INTEGER };

		executeLinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "3"));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkBannerZoneIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, TextUtils.NOT_INTEGER, bannerId };

		executeLinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkBannerWrongBannerSizeError() throws MalformedURLException,
			XmlRpcException {

		Integer zoneId = createZone(getZoneWrongParams("test_"));
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };

		executeLinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.WORNG_BANNER_SIZE));
	}

	/**
	 * Test method with wrong sessionId.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkBannerZoneWrongSessionIdError() throws MalformedURLException,
			XmlRpcException {

		String sessionId = "phpads11111111111111.11111111";
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };

		executeLinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INVALID_SESSION_ID));
	}
}
