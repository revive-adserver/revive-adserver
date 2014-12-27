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
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Unlink Banner method
 */
public class TestZoneUnlinkBanner extends ZoneTestCase {

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
	private void executeUnlinkBannerWithError(Object[] params, String errorMsg)
		throws MalformedURLException {

		try {
			execute(ZONE_UNLINK_BANNER_METHOD, params);
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
	public void testUnlinkBannerAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };
		final Boolean linkResult = (Boolean) client
				.execute(ZONE_LINK_BANNER_METHOD, XMLRPCMethodParameters);

		assertTrue(linkResult);
		final Boolean unlinkResult = (Boolean) client
				.execute(ZONE_UNLINK_BANNER_METHOD, XMLRPCMethodParameters);

		assertTrue(unlinkResult);

	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkBannerUnknownZoneIdError() throws MalformedURLException,
			XmlRpcException {

		Integer zoneId = createZone();
		assertNotNull(zoneId);
		deleteZone(zoneId);

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };

		executeUnlinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ZONE_ID));
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkBannerUnknownBannerIdError() throws MalformedURLException,
			XmlRpcException {

		Integer bannerId = createBanner();
		assertNotNull(bannerId);
		deleteBanner(bannerId);

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };

		executeUnlinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, BANNER_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkBannerBannerIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, TextUtils.NOT_INTEGER };

		executeUnlinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "3"));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkBannerZoneIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, TextUtils.NOT_INTEGER, bannerId };

		executeUnlinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}

	/**
	 * Test method with not existing link.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkBannerNotExistingLinkError() throws MalformedURLException,
			XmlRpcException {

		Integer zoneId = createZone();
		Integer bannerId = createBanner();

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, bannerId };

		executeUnlinkBannerWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_LINK_ERROR, ZONE_ID, BANNER_ID));
	}
}