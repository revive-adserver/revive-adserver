/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
