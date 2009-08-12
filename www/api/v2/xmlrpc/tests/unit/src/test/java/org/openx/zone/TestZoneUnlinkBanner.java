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
 * Verify Unlink Banner method
 *
 * @author     Pawel Dachterski <pawel.dachterski@openx.org>
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