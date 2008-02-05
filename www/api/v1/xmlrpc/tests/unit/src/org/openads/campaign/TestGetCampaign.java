/*
+---------------------------------------------------------------------------+
| OpenX v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
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
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
|                                                                           |
|  Licensed under the Apache License, Version 2.0 (the "License");          |
|  you may not use this file except in compliance with the License.         |
|  You may obtain a copy of the License at                                  |
|                                                                           |
|    http://www.apache.org/licenses/LICENSE-2.0                             |
|                                                                           |
|  Unless required by applicable law or agreed to in writing, software      |
|  distributed under the License is distributed on an "AS IS" BASIS,        |
|  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. |
|  See the License for the specific language governing permissions and      |
|  limitations under the License.                                           |
+---------------------------------------------------------------------------+
$Id$
 */
package org.openads.campaign;

import java.net.MalformedURLException;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openads.utils.ErrorMessage;
import org.openads.utils.TextUtils;

/**
 * Verify Get Campaign method
 * 
 * @author <a href="mailto:apetlyovanyy@lohika.com">Andriy Petlyovanyy</a>
 */
public class TestGetCampaign extends CampaignTestCase {

	/**
	 * Test method with all fields.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetCampaignAllFields() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> myCampaign = getCampaignParams("test1");
		Integer id = createCampaign(myCampaign);
		Object[] params = new Object[] { sessionId, id };
		
		try {
			final Map<String, Object> campaign = (Map<String, Object>) execute(
					GET_CAMPAIGN_METHOD, params);

			checkParameter(campaign, ADVERTISER_ID, advertiserId);
			checkParameter(campaign, CAMPAIGN_ID, id);
			checkParameter(campaign, CAMPAIGN_NAME, myCampaign.get(CAMPAIGN_NAME));
			checkParameter(campaign, START_DATE, myCampaign.get(START_DATE));
			checkParameter(campaign, END_DATE, myCampaign.get(END_DATE));
			checkParameter(campaign, IMPRESSIONS, myCampaign.get(IMPRESSIONS));
			checkParameter(campaign, CLICKS, myCampaign.get(CLICKS));
			checkParameter(campaign, PRIORITY, myCampaign.get(PRIORITY));
			checkParameter(campaign, WEIGHT, myCampaign.get(WEIGHT));
		} finally {
			deleteCampaign(id);
		}
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
	@SuppressWarnings("unchecked")
	private void executeGetCampaignWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			Map<String, Object> result = (Map<String, Object>) execute(
					GET_CAMPAIGN_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method without some required fields(error).
	 * 
	 * @throws MalformedURLException
	 */
	public void testGetCampaignWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetCampaignWithError(params, ErrorMessage
				.getMessage(ErrorMessage.getMessage(ErrorMessage
						.INCORRECT_PARAMETERS_PASSED_TO_METHOD,	"2", "1")));

	}

	/**
	 * Try to get campaign with unknown id
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetCampaignUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createCampaign();
		deleteCampaign(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 * 
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetCampaignWrongTypeError() throws MalformedURLException,
			XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
