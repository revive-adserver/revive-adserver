/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.campaign;

import java.net.MalformedURLException;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Delete Campaign method
 */
public class TestDeleteCampaign extends CampaignTestCase {
	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeDeleteCampaignWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(DELETE_CAMPAIGN_METHOD, params);
			fail(DELETE_CAMPAIGN_METHOD
					+ " executed successfully, but it shouldn't.");
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
	public void testDeleteCampaignAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		int campaignId = createCampaign();
		assertNotNull("Can't add campaign.", campaignId);
		final Boolean result = deleteCampaign(campaignId);
		assertTrue("Can't delete campaign.", result);
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testDeleteCampaignWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeDeleteCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));
	}

	/**
	 * Try to delete campaign with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteCampaignUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createCampaign();
		deleteCampaign(id);
		Object[] params = new Object[] { sessionId, id };

		executeDeleteCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CAMPAIGN_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testDeleteCampaignWrongTypeError() throws MalformedURLException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeDeleteCampaignWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}

}
