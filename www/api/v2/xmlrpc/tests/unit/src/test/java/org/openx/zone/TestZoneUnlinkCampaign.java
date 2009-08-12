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

package org.openx.zone;

import java.net.MalformedURLException;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Unlink Campaign method
 *
 * @author     Pawel Dachterski <pawel.dachterski@openx.org>
 */
public class TestZoneUnlinkCampaignV2 extends ZoneTestCase {

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