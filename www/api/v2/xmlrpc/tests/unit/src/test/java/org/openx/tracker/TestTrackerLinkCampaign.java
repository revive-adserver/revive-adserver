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
package org.openx.tracker;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Link Campaign method
 *
 * @author     David Keen <david.keen@openx.org>
 */
public class TestTrackerLinkCampaign extends TrackerTestCase {

    protected Integer trackerId = null;
    protected Integer campaignId = null;

    protected void setUp() throws Exception {
        super.setUp();

        campaignId = createCampaign();
        trackerId = createTracker();
    }

    protected void tearDown() throws Exception {

        deleteCampaign(campaignId);
        deleteTracker(trackerId);

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
            execute(TRACKER_LINK_CAMPAIGN_METHOD, params);
            fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }
    }

    public void testLinkCampaignDifferentAdvertiserError()
            throws XmlRpcException, MalformedURLException {

        // Create a new advertiser
        Integer newAdvertiserId = createAdvertiser();

        // Create a tracker for the new advertiser
        Map<String, Object> trackerParams = new HashMap<String, Object>();
        trackerParams.put(CLIENT_ID, newAdvertiserId);
        trackerParams.put(TRACKER_NAME, "test" + TRACKER_NAME);
        trackerParams.put(DESCRIPTION, "test" + DESCRIPTION);
        trackerParams.put(VIEW_WINDOW, 0);
        trackerParams.put(CLICK_WINDOW, 0);
        trackerParams.put(BLOCK_WINDOW, 0);
        trackerParams.put(STATUS, 4);
        trackerParams.put(TYPE, 1);
        trackerParams.put(LINK_CAMPAIGNS, false);
        trackerParams.put(VARIABLE_METHOD, "default");
        Integer newTrackerId = createTracker(trackerParams);

        Object[] params = new Object[] {sessionId, newTrackerId, campaignId, MAX_CONNECTION_STATUS_APPROVED};
        executeLinkCampaignWithError(params, ErrorMessage.getMessage(ErrorMessage.CAMPAIGN_ADVERTISER_MISMATCH));
    }

    /**
     * Test method with all required fields and some optional.
     *
     * @throws XmlRpcException
     * @throws MalformedURLException
     */
    public void testLinkCampaignAllReqAndSomeOptionalFields()
            throws XmlRpcException, MalformedURLException {

        Object[] params = new Object[] {sessionId, trackerId, campaignId, MAX_CONNECTION_STATUS_APPROVED};
        final Boolean result = (Boolean) client.execute(TRACKER_LINK_CAMPAIGN_METHOD, params);

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

        Object[] params = new Object[] {sessionId, trackerId, campaignId};
        client.execute(TRACKER_LINK_CAMPAIGN_METHOD, params);

        final Boolean result = (Boolean) client.execute(TRACKER_LINK_CAMPAIGN_METHOD, params);

        assertTrue(result);
    }

    /**
     * Test methods for Unknown ID Error
     *
     * @throws MalformedURLException
     * @throws XmlRpcException
     */
    public void testLinkCampaignUnknownTrackerIdError() throws MalformedURLException,
            XmlRpcException {

        Integer trackerId = createTracker();
        assertNotNull(trackerId);
        deleteTracker(trackerId);

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, trackerId, campaignId};

        executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, TRACKER_ID));
    }

    /**
     * Test methods for Unknown ID Error
     *
     * @throws MalformedURLException
     * @throws XmlRpcException
     */
    public void testLinkCampaignUnknownCampaignIdError() throws MalformedURLException,
            XmlRpcException {

        Integer campaignId = createCampaign();
        assertNotNull(campaignId);
        deleteCampaign(campaignId);

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, trackerId, campaignId};

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

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, trackerId, TextUtils.NOT_INTEGER};

        executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "3"));
    }

    /**
     * Test method with fields that has value of wrong type (error).
     *
     * @throws MalformedURLException
     * @throws XmlRpcException
     */
    public void testLinkCampaignTrackerIdWrongTypeError() throws MalformedURLException,
            XmlRpcException {

        Object[] XMLRPCMethodParameters = new Object[]{sessionId, TextUtils.NOT_INTEGER, campaignId};

        executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
    }

    /**
     * Test method with wrong sessionId.
     *
     * @throws MalformedURLException
     * @throws XmlRpcException
     */
    public void testLinkCampaignWrongSessionIdError() throws MalformedURLException,
            XmlRpcException {

        String sessionId = "phpads11111111111111.11111111";
        Object[] XMLRPCMethodParameters = new Object[]{sessionId, trackerId, campaignId};

        executeLinkCampaignWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
                ErrorMessage.INVALID_SESSION_ID));
    }
}
