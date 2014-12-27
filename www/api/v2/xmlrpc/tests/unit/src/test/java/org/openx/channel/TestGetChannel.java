/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.channel;

import java.net.MalformedURLException;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

public class TestGetChannel extends ChannelTestCase {

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
	private void executeGetChannelWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			Map<String, Object> result = (Map<String, Object>) execute(
					GET_CHANNEL_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

    /**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetChannelAllFields() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> myChannel = getChannelParams("test1");
		Integer id = createChannel(myChannel);
		Object[] params = new Object[] { sessionId, id };

		try {
			final Map<String, Object> channel = (Map<String, Object>) execute(
					GET_CHANNEL_METHOD, params);

			checkParameter(channel, CHANNEL_ID, id);
			checkParameter(channel, AGENCY_ID, myChannel.get(AGENCY_ID));
            checkParameter(channel, CHANNEL_NAME, myChannel.get(CHANNEL_NAME));
			checkParameter(channel, WEBSITE_ID, myChannel.get(WEBSITE_ID));
			checkParameter(channel, DESCRIPTION, myChannel.get(DESCRIPTION));
			checkParameter(channel, COMMENTS, myChannel.get(COMMENTS));
		} finally {
			deleteChannel(id);
		}
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetChannelWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetChannelWithError(params, ErrorMessage
				.getMessage(ErrorMessage.getMessage(ErrorMessage
						.INCORRECT_PARAMETERS_PASSED_TO_METHOD,	"2", "1")));

	}

	/**
	 * Try to get channel with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetChannelUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createChannel();
		deleteChannel(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetChannelWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CHANNEL_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetChannelWrongTypeError() throws MalformedURLException,
			XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetChannelWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
