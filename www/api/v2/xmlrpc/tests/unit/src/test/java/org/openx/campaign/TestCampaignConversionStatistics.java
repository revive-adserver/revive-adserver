/*
+---------------------------------------------------------------------------+
| OpenX v2.8                                                                |
| =========                                                                 |
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
package org.openx.campaign;

import java.net.MalformedURLException;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.DateUtils;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

public class TestCampaignConversionStatistics extends CampaignTestCase {

    private Integer campaignId;

    @Override
    protected void setUp() throws Exception {
        super.setUp();
        campaignId = createCampaign();
    }

    @Override
    protected void tearDown() throws Exception {
        deleteCampaign(campaignId);
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
    private void executeCampaignConversionStatisticsWithError(Object[] params,
            String errorMsg) throws MalformedURLException {
        try {
            execute(CAMPAIGN_CONVERSION_STATISTICS_METHOD, params);
            fail(CAMPAIGN_CONVERSION_STATISTICS_METHOD + " executed successfully, but it shouldn't.");
        } catch (XmlRpcException e) {
            assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e.getMessage());
        }

    }

    /**
     * Test method with all required fields and some optional.
     *
     * @throws XmlRpcException
     * @throws MalformedURLException
     */
    @SuppressWarnings("unchecked")
    public void testCampaignConversionStatisticsAllReqAndSomeOptionalFields()
            throws XmlRpcException, MalformedURLException {
        assertNotNull("Can't get campaignId by setUp method.", campaignId);

        Object[] params = new Object[]{sessionId, campaignId, DateUtils.MIN_DATE_VALUE};
        final Object[] result = (Object[]) execute(CAMPAIGN_CONVERSION_STATISTICS_METHOD, params);

        assertNotNull("Can't get result for CampaignConversionStatisticsMethod.", result);

        if (result.length > 0) {
            // TODO: Update these with correct values.
            final Map<String, Object> item = (Map<String, Object>) result[0];
            assertTrue("Can't find 'campaignID' field.", item.containsKey("campaignID"));
            assertTrue("Can't find 'trackerID' field.", item.containsKey("trackerID"));
            assertTrue("Can't find 'bannerID' field.", item.containsKey("bannerID"));
            assertTrue("Can't find 'conversionTime' field.", item.containsKey("conversionTime"));
            assertTrue("Can't find 'conversionStatus' field.", item.containsKey("conversionStatus"));
            assertTrue("Can't find 'userIp' field.", item.containsKey("userIp"));
            assertTrue("Can't find 'action' field.", item.containsKey("action"));
            assertTrue("Can't find 'window' field.", item.containsKey("window"));
            assertTrue("Can't find 'variables' field.", item.containsKey("variables"));
        }
    }

    /**
     * Test method without some required fields.
     *
     * @throws MalformedURLException
     */
    public void testCampaignConversionStatisticsWithoutSomeRequiredFields()
            throws MalformedURLException {

        Object[] params = new Object[]{sessionId};

        executeCampaignConversionStatisticsWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
                "5, 4, 3, or 2", "1"));
    }

    /**
     * Test method with fields that has value greater than max.
     *
     * @throws MalformedURLException
     * @throws XmlRpcException
     */
    public void testCampaignConversionStatisticsGreaterThanMaxFieldValueError()
            throws MalformedURLException, XmlRpcException {

        Object[] params = new Object[]{sessionId, campaignId,
            DateUtils.DATE_GREATER_THAN_MAX, DateUtils.MAX_DATE_VALUE};

        executeCampaignConversionStatisticsWithError(params,
                ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);

    }

    /**
     * Test method with fields that has value less than min
     *
     * @throws MalformedURLException
     */
    public void testCampaignConversionStatisticsLessThanMinFieldValueError()
            throws MalformedURLException {
        Object[] params = new Object[]{sessionId, campaignId,
            DateUtils.MIN_DATE_VALUE, DateUtils.DATE_LESS_THAN_MIN};

        executeCampaignConversionStatisticsWithError(params,
                ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038);
    }

    /**
     * Test method with fields that has min. allowed values.
     *
     * @throws XmlRpcException
     * @throws MalformedURLException
     */
    public void testCampaignConversionStatisticsMinValues() throws XmlRpcException,
            MalformedURLException {
        Object[] params = new Object[]{sessionId, campaignId,
            DateUtils.MIN_DATE_VALUE, DateUtils.MIN_DATE_VALUE};

        final Object[] result = (Object[]) execute(
                CAMPAIGN_ZONE_STATISTICS_METHOD, params);

        assertNotNull("Can't get result for CampaignConversionStatisticsMethod.",
                result);
    }

    /**
     * Test method with fields that has max. allowed values.
     *
     * @throws XmlRpcException
     * @throws MalformedURLException
     */
    public void testCampaignConversionStatisticsMaxValues() throws XmlRpcException,
            MalformedURLException {
        Object[] params = new Object[]{sessionId, campaignId,
            DateUtils.MAX_DATE_VALUE, DateUtils.MAX_DATE_VALUE};

        final Object[] result = (Object[]) execute(
                CAMPAIGN_ZONE_STATISTICS_METHOD, params);

        assertNotNull("Can't get result for CampaignConversionStatisticsMethod.",
                result);
    }

    /**
     * CampaignConversionStatistics with unknown id
     *
     * @throws XmlRpcException
     * @throws MalformedURLException
     */
    public void testCampaignConversionStatisticsUnknownIdError()
            throws XmlRpcException, MalformedURLException {
        final Integer id = createCampaign();
        deleteCampaign(id);
        Object[] params = new Object[]{sessionId, id};

        executeCampaignConversionStatisticsWithError(params, ErrorMessage.getMessage(
                ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
    }

    /**
     * CampaignConversionStatistics when end date is before start date
     *
     * @throws XmlRpcException
     * @throws MalformedURLException
     */
    public void testCampaignConversionStatisticsDateError() throws XmlRpcException,
            MalformedURLException {
        Object[] params = new Object[]{sessionId, campaignId,
            DateUtils.MAX_DATE_VALUE, DateUtils.MIN_DATE_VALUE};

        executeCampaignConversionStatisticsWithError(params,
                ErrorMessage.START_DATE_IS_AFTER_END_DATE);
    }

    /**
     * Test method with fields that has value of wrong type (error).
     *
     * @throws MalformedURLException
     */
    public void testCampaignConversionStatisticsWrongTypeError()
            throws MalformedURLException {
        Object[] params = new Object[]{sessionId, campaignId,
            TextUtils.NOT_DATE, DateUtils.MAX_DATE_VALUE};
        executeCampaignConversionStatisticsWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING, "3"));

        params = new Object[]{sessionId, campaignId,
                    DateUtils.MIN_DATE_VALUE, TextUtils.NOT_DATE};
        executeCampaignConversionStatisticsWithError(params, ErrorMessage.getMessage(
                ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING, "4"));
    }
}
