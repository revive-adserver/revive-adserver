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
import java.util.HashMap;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
public class TestModifyChannelV2 extends ChannelTestCase {
    private Integer channelId = null;

    @Override
	protected void setUp() throws Exception {
		super.setUp();

		channelId = createChannel();
	}

    @Override
	protected void tearDown() throws Exception {
		deleteChannel(channelId);

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
	private void executeModifyChannelWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(MODIFY_CHANNEL_METHOD, params);
			fail(MODIFY_CHANNEL_METHOD
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
	public void testModifyChannelAllReqFieldsAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		assertNotNull(channelId);

		Map<String, Object> myChannel = new HashMap<String, Object>();
		myChannel.put(CHANNEL_ID, channelId);
		myChannel.put(CHANNEL_NAME, "test channel");

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, myChannel };
		final boolean result = (Boolean) execute(MODIFY_CHANNEL_METHOD, XMLRPCMethodParameters);
		assertTrue(result);

		XMLRPCMethodParameters = new Object[] { sessionId, channelId };
		final Map<String, Object> channel = (Map<String, Object>) execute(
				GET_CHANNEL_METHOD, XMLRPCMethodParameters);

		checkParameter(channel, CHANNEL_ID, channelId);
		checkParameter(channel, CHANNEL_NAME, myChannel.get(CHANNEL_NAME));
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyChannelWithoutSomeRequiredFields()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CHANNEL_NAME, "testChannel Modified");
		struct.put(COMMENTS, "Comments");
		Object[] params = new Object[] { sessionId, struct };

		executeModifyChannelWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, CHANNEL_ID));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testModifyChannelGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {
		final String strGreaterThan255 = TextUtils.getString(256);

		assertNotNull(channelId);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CHANNEL_ID, channelId);
		struct.put(CHANNEL_NAME, strGreaterThan255);

		Object[] params = new Object[] { sessionId, struct };

		executeModifyChannelWithError(params, ErrorMessage
				.getMessage(ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CHANNEL_NAME));
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testModifyChannelMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CHANNEL_ID, channelId);
		struct.put(CHANNEL_NAME, TextUtils.getString(255));
		Object[] params = new Object[] { sessionId, struct };
		final Boolean result = (Boolean) execute(MODIFY_CHANNEL_METHOD, params);
		assertTrue(result);
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testModifyChannelWrongTypeError() throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CHANNEL_ID, channelId);
		Object[] params = new Object[] { sessionId, struct };

		struct.put(CHANNEL_NAME, TextUtils.NOT_STRING);
		executeModifyChannelWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, CHANNEL_NAME));
	}

}
