/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

package org.openads.campaign;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openads.utils.DateUtils;
import org.openads.utils.ErrorMessage;
import org.openads.utils.TextUtils;

/**
 * Verify Add Campaign method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */

public class TestAddCampaign extends CampaignTestCase {
	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeAddCampaignWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_CAMPAIGN_METHOD, params);
			fail(ADD_CAMPAIGN_METHOD
					+ " executed successfully, but it shouldn't.");
			deleteCampaign(result);
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
	public void testAddCampaignAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		assertNotNull(advertiserId);

		Map<String, Object> struct = new HashMap<String, Object>();

		struct.put(ADVERTISER_ID, advertiserId);
		struct.put(CAMPAIGN_NAME, "test campaign");
		struct.put(START_DATE, DateUtils.MIN_DATE_VALUE);
		struct.put(PRIORITY, 7);
		struct.put(WEIGHT, -1);

		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_CAMPAIGN_METHOD, params);
		assertNotNull(result);
		deleteCampaign(result);
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testAddCampaignWithoutSomeRequiredFields()
			throws MalformedURLException {

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CAMPAIGN_NAME, "test campaign Name");

		Object[] params = new Object[] { sessionId, struct };
		executeAddCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, ADVERTISER_ID));
	}

	/**
	 * Test method with all required fields and all optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddCampaignAllReqAndAllOptionalFields()
			throws XmlRpcException, MalformedURLException {
		assertNotNull(advertiserId);

		Map<String, Object> struct = new HashMap<String, Object>();

		struct.put(ADVERTISER_ID, advertiserId);
		struct.put(CAMPAIGN_NAME, "test campaign");
		struct.put(START_DATE, DateUtils.MIN_DATE_VALUE);
		struct.put(END_DATE, DateUtils.MAX_DATE_VALUE);
		struct.put(IMPRESSIONS, 100);
		struct.put(CLICKS, 210);
		struct.put(PRIORITY, -1);
		struct.put(WEIGHT, 102);

		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_CAMPAIGN_METHOD, params);
		assertNotNull(result);
		deleteCampaign(result);
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddCampaignMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ADVERTISER_ID, advertiserId);
		struct.put(CAMPAIGN_NAME, "testCampaign");
		struct.put(START_DATE, DateUtils.MIN_DATE_VALUE);
		struct.put(END_DATE, DateUtils.MIN_DATE_VALUE);
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) execute(ADD_CAMPAIGN_METHOD, params);
		assertNotNull(result);
		deleteCampaign(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddCampaignMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ADVERTISER_ID, advertiserId);
		struct.put(CAMPAIGN_NAME, TextUtils.getString(255));
		struct.put(START_DATE, DateUtils.MAX_DATE_VALUE);
		struct.put(END_DATE, DateUtils.MAX_DATE_VALUE);
		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) execute(ADD_CAMPAIGN_METHOD, params);
		assertNotNull(result);
		deleteCampaign(result);
	}

	/**
	 * Try to add campaign to advertiser with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddCampaignUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAdvertiser();
		deleteAdvertiser(id);
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ADVERTISER_ID, id);
		Object[] params = new Object[] { sessionId, struct };

		executeAddCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ADVERTISER_ID));
	}

	/**
	 * Try to add campaign with end date that is before start date
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddCampaignDateError() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ADVERTISER_ID, advertiserId);
		struct.put(START_DATE, DateUtils.MAX_DATE_VALUE);
		struct.put(END_DATE, DateUtils.MIN_DATE_VALUE);
		Object[] params = new Object[] { sessionId, struct };

		executeAddCampaignWithError(params,
				ErrorMessage.START_DATE_IS_AFTER_END_DATE);
	}

	/**
	 * Try to add campaign when the weight is set > 0 for high priority
	 * campaigns
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddCampaignPriorityError() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(ADVERTISER_ID, advertiserId);
		struct.put(PRIORITY, 8);
		struct.put(WEIGHT, 2);
		Object[] params = new Object[] { sessionId, struct };

		executeAddCampaignWithError(params,
				ErrorMessage.WEIGHT_COULD_NOT_BE_GREATER_THAN_ZERO);
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddCampaignWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(ADVERTISER_ID, advertiserId);
		struct.put(CAMPAIGN_NAME, TextUtils.NOT_STRING);
		executeAddCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, CAMPAIGN_NAME));
	}
}
