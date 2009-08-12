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
public class TestAddChannelV2 extends ChannelTestCase {

    /**
	 * Execute test method with error
	 *
	 * @param params parameters for test method
	 * @param errorMsg error messages
	 * @throws MalformedURLException
	 */
	private void executeAddChannelWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_CHANNEL_METHOD, params);
			fail(ADD_CHANNEL_METHOD
					+ " executed successfully, but it shouldn't.");
			deleteChannel(result);
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
	public void testAddChannelAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		assertNotNull(agencyId);
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);
		struct.put(CHANNEL_NAME, "testChannel");
		struct.put(DESCRIPTION, "I am channel");

		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_CHANNEL_METHOD, params);
		assertNotNull(result);
		deleteChannel(result);
	}

    /**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 */
	public void testAddChannelWithoutSomeRequiredFields()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, agencyId);

		Object[] params = new Object[] { sessionId, struct };

		executeAddChannelWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IN_STRUCTURE_DOES_NOT_EXISTS, CHANNEL_NAME));
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddChannelMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CHANNEL_NAME, TextUtils.getString(255));
		struct.put(DESCRIPTION, TextUtils.getString(255));
		Object[] XMLMethodParameters = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_CHANNEL_METHOD,
				XMLMethodParameters);

		assertNotNull(result);
		deleteChannel(result);
	}

    /**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddChannelNameFieldGreaterThanMaxValueError()
			throws MalformedURLException, XmlRpcException {

		final String strGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CHANNEL_NAME, strGreaterThan255);
		Object[] XMLMethodParameters = new Object[] { sessionId, struct };
		executeAddChannelWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, CHANNEL_NAME));
	}

    /**
	 * Try to add channel with nonexistent agency id
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddChannelUnknownIdError() throws MalformedURLException,
			XmlRpcException {

		int testAgencyId = createAgency();
		deleteAgency(testAgencyId);
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(AGENCY_ID, testAgencyId);
		struct.put(CHANNEL_NAME, "testChannelName");
		Object[] XMLMethodParameters = new Object[] { sessionId, struct };
		executeAddChannelWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));
	}

    /**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddChannelWrongChannelNameTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(CHANNEL_NAME, TextUtils.NOT_STRING);
		Object[] XMLMethodParameters = new Object[] { sessionId, struct };
		executeAddChannelWithError(XMLMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, CHANNEL_NAME));
	}

}
