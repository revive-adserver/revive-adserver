/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.publisher;

import java.net.MalformedURLException;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Delete Publisher method
 */
public class TestDeletePublisher extends PublisherTestCase {
	/**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeDeletePublisherWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			execute(DELETE_PUBLISHER_METHOD, params);
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
	public void testDeletePublisherAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		int publisherId = createPublisher();
		assertNotNull("Can't add publisher.", publisherId);

		final Boolean result = (Boolean) execute(DELETE_PUBLISHER_METHOD,
				new Object[] { sessionId, publisherId });
		assertTrue("Can't delete publisher.", result);
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testDeletePublisherWithoutSomeRequiredFields()
			throws MalformedURLException, XmlRpcException {
		Object[] params = new Object[] { sessionId };
		executeDeletePublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));
	}

	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testDeletePublisherUnknownIdError()
			throws MalformedURLException, XmlRpcException {
		int publisheId = createPublisher();
		assertNotNull(publisheId);
		deletePublisher(publisheId);

		Object[] params = new Object[] { sessionId, publisheId };
		executeDeletePublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, PUBLISHER_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testDeletePublisherWrongTypeError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeDeletePublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}

}
