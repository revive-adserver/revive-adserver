/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                             |
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

package org.openx.channel;

import java.net.MalformedURLException;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
public class TestGetChannelV2 extends ChannelTestCase {

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
