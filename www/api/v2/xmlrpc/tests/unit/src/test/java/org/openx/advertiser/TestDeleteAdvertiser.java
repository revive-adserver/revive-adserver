/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.advertiser;

import java.net.MalformedURLException;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Delete Advertiser method
 */
public class TestDeleteAdvertiser extends AdvertiserTestCase {
	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeDeleteAdvertiserWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			execute(DELETE_ADVERTISER_METHOD, params);
			fail(DELETE_ADVERTISER_METHOD
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
	public void testDeleteAdvertiserAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		int advertiserId = createAdvertiser();
		assertNotNull("Can't add advertiser.", advertiserId);
		final Boolean result = (Boolean) client.execute(
				DELETE_ADVERTISER_METHOD, new Object[] { sessionId,
						advertiserId });
		assertTrue("Can't delete advertiser.", result);

	}

	/**
	 * Test method without some required fields.
	 * @throws MalformedURLException
	 */
	public void testDeleteAdvertiserWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeDeleteAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));

	}

	/**
	 * Try to delete advertiser with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteAdvertiserUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAdvertiser();
		deleteAdvertiser(id);
		Object[] params = new Object[] { sessionId, id };

		try {
			client.execute(DELETE_ADVERTISER_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE,
					ErrorMessage.UNKNOWN_ADVERTISER_ID_ERROR, e.getMessage());
		}
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testDeleteAdvertiserWrongTypeError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeDeleteAdvertiserWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
