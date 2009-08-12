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

package org.openx.campaign;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.DateUtils;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Modify Campaign method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */

public class TestModifyCampaignV1 extends CampaignTestCase {
	private Integer campaignId = null;

	protected void setUp() throws Exception {
		super.setUp();

		campaignId = createCampaign();
	}

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
	private void executeModifyCampaignWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(MODIFY_CAMPAIGN_METHOD, params);
			fail(MODIFY_CAMPAIGN_METHOD
					+ " executed successfully, but it shouldn't.");
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method with all required fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testModifyCampaignAllReqFields()
			throws XmlRpcException, MalformedURLException {
		
		assertNotNull(advertiserId);
		
		Map<String, Object> myCampaign = new HashMap<String, Object>();

		myCampaign.put(CAMPAIGN_ID, campaignId);
		myCampaign.put(CAMPAIGN_NAME, "test campaign");
		myCampaign.put(START_DATE, DateUtils.MIN_DATE_VALUE);
		myCampaign.put(END_DATE, DateUtils.MAX_DATE_VALUE);
		myCampaign.put(PRIORITY, 7);
		myCampaign.put(WEIGHT, -1);
		
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, myCampaign };
		final boolean result = (Boolean) execute(MODIFY_CAMPAIGN_METHOD, XMLRPCMethodParameters);
		assertTrue(result);
		
		XMLRPCMethodParameters = new Object[] { sessionId, campaignId };
		final Map<String, Object> campaign = (Map<String, Object>) execute(
				GET_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		checkParameter(campaign, ADVERTISER_ID, advertiserId);
		checkParameter(campaign, CAMPAIGN_ID, campaignId);
		checkParameter(campaign, CAMPAIGN_NAME, myCampaign.get(CAMPAIGN_NAME));
		checkParameter(campaign, START_DATE, myCampaign.get(START_DATE));
		checkParameter(campaign, PRIORITY, myCampaign.get(PRIORITY));
		checkParameter(campaign, WEIGHT, myCampaign.get(WEIGHT));
	}

	/**
	 * Test method with all required fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testModifyCampaignWithCappingFields()
			throws XmlRpcException, MalformedURLException {
		
		assertNotNull(advertiserId);
		
		Map<String, Object> myCampaign = new HashMap<String, Object>();

		myCampaign.put(CAMPAIGN_ID, campaignId);
		myCampaign.put(CAMPAIGN_NAME, "test campaign");
		myCampaign.put(SESSION_CAPPING, 18);
		myCampaign.put(CAPPING, 8);
		myCampaign.put(BLOCK, 4155);
		myCampaign.put(PRIORITY, 7);
		myCampaign.put(WEIGHT, -1);
		myCampaign.put(COMMENTS, "some comments - modify campaign");
		
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, myCampaign };
		final boolean result = (Boolean) execute(MODIFY_CAMPAIGN_METHOD, XMLRPCMethodParameters);
		assertTrue(result);
		
		XMLRPCMethodParameters = new Object[] { sessionId, campaignId };
		final Map<String, Object> campaign = (Map<String, Object>) execute(
				GET_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		checkParameter(campaign, ADVERTISER_ID, advertiserId);
		checkParameter(campaign, CAMPAIGN_ID, campaignId);
		checkParameter(campaign, CAMPAIGN_NAME, myCampaign.get(CAMPAIGN_NAME));
		checkParameter(campaign, CAPPING, myCampaign.get(CAPPING));
		checkParameter(campaign, SESSION_CAPPING, myCampaign.get(SESSION_CAPPING));
		checkParameter(campaign, BLOCK, myCampaign.get(BLOCK));
		checkParameter(campaign, PRIORITY, myCampaign.get(PRIORITY));
		checkParameter(campaign, WEIGHT, myCampaign.get(WEIGHT));
		checkParameter(campaign, COMMENTS, myCampaign.get(COMMENTS));
	}
	
	/**
	 * Test method with all required fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	/* Not possible to test this kind of modifications with Java XMLRPC client
	@SuppressWarnings("unchecked")
	public void testModifyCampaignWithoutBeginAndEnd()
			throws XmlRpcException, MalformedURLException {
		
		assertNotNull(advertiserId);
		
		Map<String, Object> myCampaign = new HashMap<String, Object>();

		myCampaign.put(CAMPAIGN_ID, campaignId);
		myCampaign.put(CAMPAIGN_NAME, "test campaign");
		myCampaign.put(START_DATE, DateUtils.ZERO_DATE);
		myCampaign.put(END_DATE, DateUtils.ZERO_DATE);
		myCampaign.put(PRIORITY, 7);
		myCampaign.put(WEIGHT, -1);
		
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, myCampaign };
		final boolean result = (Boolean) client.execute(MODIFY_CAMPAIGN_METHOD, XMLRPCMethodParameters);
		assertTrue(result);
		
		XMLRPCMethodParameters = new Object[] { sessionId, campaignId };
		final Map<String, Object> campaign = (Map<String, Object>) execute(
				GET_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		checkParameter(campaign, CAMPAIGN_ID, campaignId);
		checkParameter(campaign, CAMPAIGN_NAME, myCampaign.get(CAMPAIGN_NAME));
		assertNull(campaign.get(START_DATE));
		assertNull(campaign.get(END_DATE));
		checkParameter(campaign, PRIORITY, myCampaign.get(PRIORITY));
		checkParameter(campaign, WEIGHT, myCampaign.get(WEIGHT));
	}*/
	
	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testModifyCampaignAllReqFieldsAndSomeOptional()
			throws XmlRpcException, MalformedURLException {
		
		assertNotNull(advertiserId);
		
		Map<String, Object> myCampaign = new HashMap<String, Object>();

		myCampaign.put(CAMPAIGN_ID, campaignId);
		myCampaign.put(CAMPAIGN_NAME, "test campaign");
		myCampaign.put(START_DATE, DateUtils.MIN_DATE_VALUE);
		myCampaign.put(END_DATE, DateUtils.MAX_DATE_VALUE);
		myCampaign.put(PRIORITY, 7);
		myCampaign.put(WEIGHT, -1);
		myCampaign.put(TARGET_IMPRESSIONS, 1000);
		myCampaign.put(TARGET_CLICKS, 100);
		myCampaign.put(TARGET_CONVERSIONS, 10);
		myCampaign.put(REVENUE, 2.33);
		myCampaign.put(REVENUE_TYPE, 1);
		
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, myCampaign };
		final boolean result = (Boolean) execute(MODIFY_CAMPAIGN_METHOD, XMLRPCMethodParameters);
		assertTrue(result);
		
		XMLRPCMethodParameters = new Object[] { sessionId, campaignId };
		final Map<String, Object> campaign = (Map<String, Object>) execute(
				GET_CAMPAIGN_METHOD, XMLRPCMethodParameters);

		checkParameter(campaign, ADVERTISER_ID, advertiserId);
		checkParameter(campaign, CAMPAIGN_ID, campaignId);
		checkParameter(campaign, CAMPAIGN_NAME, myCampaign.get(CAMPAIGN_NAME));
		checkParameter(campaign, START_DATE, myCampaign.get(START_DATE));
		checkParameter(campaign, PRIORITY, myCampaign.get(PRIORITY));
		checkParameter(campaign, WEIGHT, myCampaign.get(WEIGHT));
		checkParameter(campaign, TARGET_IMPRESSIONS, myCampaign.get(TARGET_IMPRESSIONS));
		checkParameter(campaign, TARGET_CLICKS, myCampaign.get(TARGET_CLICKS));
		checkParameter(campaign, TARGET_CONVERSIONS, myCampaign.get(TARGET_CONVERSIONS));
		checkParameter(campaign, REVENUE, myCampaign.get(REVENUE));
		checkParameter(campaign, REVENUE_TYPE, myCampaign.get(REVENUE_TYPE));
	}
	
	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyCampaignWithoutSomeRequiredFields()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_NAME, "testCampaign Modified");
		struct.put(END_DATE, DateUtils.MAX_DATE_VALUE);
		Object[] params = new Object[] { sessionId, struct };

		executeModifyCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, CAMPAIGN_ID));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testModifyCampaignGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {
		final String strGreaterThan255 = TextUtils.getString(256);

		assertNotNull(campaignId);

		Map<String, Object> struct = new HashMap<String, Object>();

		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(CAMPAIGN_NAME, strGreaterThan255);

		Object[] params = new Object[] { sessionId, struct };

		executeModifyCampaignWithError(params, ErrorMessage
				.getMessage(ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CAMPAIGN_NAME));
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyCampaignMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(CAMPAIGN_NAME, "");
		struct.put(START_DATE, DateUtils.MIN_DATE_VALUE);
		struct.put(END_DATE, DateUtils.MIN_DATE_VALUE);
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) execute(MODIFY_CAMPAIGN_METHOD, params);
		assertTrue(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyCampaignMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(CAMPAIGN_NAME, TextUtils.getString(255));
		struct.put(START_DATE, DateUtils.MAX_DATE_VALUE);
		struct.put(END_DATE, DateUtils.MAX_DATE_VALUE);
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) execute(MODIFY_CAMPAIGN_METHOD, params);
		assertTrue(result);
	}

	/**
	 * Try to modify campaign with unknown advertiser id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyCampaignUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAdvertiser();
		deleteAdvertiser(id);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(ADVERTISER_ID, id);
		Object[] params = new Object[] { sessionId, struct };

		executeModifyCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ADVERTISER_ID));
	}

	/**
	 * Try to modify campaign with end date that is before start date
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyCampaignDateError() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(START_DATE, DateUtils.MAX_DATE_VALUE);
		struct.put(END_DATE, DateUtils.MIN_DATE_VALUE);
		Object[] params = new Object[] { sessionId, struct };

		executeModifyCampaignWithError(params,
				ErrorMessage.START_DATE_IS_AFTER_END_DATE);
	}

	/**
	 * Try to modify campaign when the weight is set > 0 for high priority
	 * campaigns
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyCampaignPriorityError() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		struct.put(PRIORITY, 8);
		struct.put(WEIGHT, 2);
		Object[] params = new Object[] { sessionId, struct };

		executeModifyCampaignWithError(params,
				ErrorMessage.WEIGHT_COULD_NOT_BE_GREATER_THAN_ZERO);
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyCampaignWrongTypeError() throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_ID, campaignId);
		Object[] params = new Object[] { sessionId, struct };

		struct.put(ADVERTISER_ID, TextUtils.NOT_INTEGER);
		executeModifyCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_INTEGER, ADVERTISER_ID));

		struct.remove(ADVERTISER_ID);
		struct.put(CAMPAIGN_NAME, TextUtils.NOT_STRING);
		executeModifyCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, CAMPAIGN_NAME));
	}
}
