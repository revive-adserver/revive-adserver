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
 * Verify Link Campaign method
 */
public class TestZoneLinkCampaign extends ZoneTestCase {

	protected Integer zoneId = null;
	protected Integer campaignId = null;

	protected void setUp() throws Exception {
		super.setUp();

		campaignId = createCampaign();
		zoneId = createZone();
	}

	protected void tearDown() throws Exception {

		deleteCampaign(campaignId);
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
	private void executeLinkCampaignWithError(Object[] params, String errorMsg)
		throws MalformedURLException {

		try {
			execute(ZONE_LINK_CAMPAIGN_METHOD, params);
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
	public void testLinkCampaignAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };
		final Boolean result = (Boolean) client
				.execute(ZONE_LINK_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		assertTrue(result);
	}

	/**
	 * Test method for case when linking campaign once again with same id.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testLinkCampaignOnceAgain()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };
		client.execute(ZONE_LINK_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		//TODO: Add expected behavior from https://developer.openx.org/jira/browse/OX-3296
		final Boolean result = (Boolean) client
				.execute(ZONE_LINK_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		assertTrue(result);
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkCampaignUnknownZoneIdError() throws MalformedURLException,
			XmlRpcException {

		Integer zoneId = createZone();
		assertNotNull(zoneId);
		deleteZone(zoneId);

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };

		executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ZONE_ID));
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkCampaignUnknownCampaignIdError() throws MalformedURLException,
			XmlRpcException {

		Integer campaignId = createCampaign();
		assertNotNull(campaignId);
		deleteCampaign(campaignId);

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };

		executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkCampaignCampaignIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, TextUtils.NOT_INTEGER };

		executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "3"));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkCampaignZoneIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, TextUtils.NOT_INTEGER, campaignId };

		executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}

	/**
	 * Test method with wrong sessionId.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testLinkCampaignZoneWrongSessionIdError() throws MalformedURLException,
			XmlRpcException {

		String sessionId = "phpads11111111111111.11111111";
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };

		executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INVALID_SESSION_ID));
	}
}