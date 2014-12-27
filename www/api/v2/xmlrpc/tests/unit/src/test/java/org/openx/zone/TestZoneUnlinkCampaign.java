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
 * Verify Unlink Campaign method
 */
public class TestZoneUnlinkCampaign extends ZoneTestCase {

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
	private void executeUnlinkCampaignWithError(Object[] params, String errorMsg)
		throws MalformedURLException {

		try {
			execute(ZONE_UNLINK_CAMPAIGN_METHOD, params);
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
	public void testUnlinkCampaignAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };
		final Boolean linkResult = (Boolean) client
				.execute(ZONE_LINK_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		assertTrue(linkResult);
		final Boolean unlinkResult = (Boolean) client
				.execute(ZONE_UNLINK_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		assertTrue(unlinkResult);


	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkCampaignUnknownZoneIdError() throws MalformedURLException,
			XmlRpcException {

		Integer zoneId = createZone();
		assertNotNull(zoneId);
		deleteZone(zoneId);

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };

		executeUnlinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ZONE_ID));
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkCampaignUnknownCampaignIdError() throws MalformedURLException,
			XmlRpcException {

		Integer campaignId = createCampaign();
		assertNotNull(campaignId);
		deleteCampaign(campaignId);

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };

		executeUnlinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkCampaignCampaignIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, TextUtils.NOT_INTEGER };

		executeUnlinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "3"));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkCampaignZoneIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, TextUtils.NOT_INTEGER, campaignId };

		executeUnlinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}

	/**
	 * Test method with not existing link.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testUnlinkCampaignNotExistingLinkError() throws MalformedURLException,
			XmlRpcException {

		Integer zoneId = createZone();
		Integer campaignId = createCampaign();

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, campaignId };

		executeUnlinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_LINK_ERROR, ZONE_ID, CAMPAIGN_ID));
	}
}