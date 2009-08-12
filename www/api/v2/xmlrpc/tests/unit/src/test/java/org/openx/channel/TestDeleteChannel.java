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
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 *
 * @author David Keen <david.keen@openx.org>
 */
public class TestDeleteChannelV2 extends ChannelTestCase {
    /**
	 * Execute test method with error
	 *
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeDeleteChannelWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(DELETE_CHANNEL_METHOD, params);
			fail(DELETE_CHANNEL_METHOD
					+ " executed successfully, but it shouldn't.");
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}

	}

	/**
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteChannel()
			throws XmlRpcException, MalformedURLException {

		int channelId = createChannel();
		assertNotNull("Can't add channel.", channelId);
		final Boolean result = deleteChannel(channelId);
		assertTrue("Can't delete channel.", result);
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testDeleteChannelWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeDeleteChannelWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD, "2", "1"));
	}

	/**
	 * Try to delete channel with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteChannelUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createChannel();
		deleteChannel(id);
		Object[] params = new Object[] { sessionId, id };

		executeDeleteChannelWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, CHANNEL_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testDeleteChannelWrongTypeError() throws MalformedURLException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeDeleteChannelWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
