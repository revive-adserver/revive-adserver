/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
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

package org.openx.publisher;

import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.openx.config.GlobalSettings;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Add Publisher method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
@SuppressWarnings("unchecked")
public class TestAddPublisherV2 extends PublisherTestCase {
	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddPublisherAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {
		Map<String, Object> addPublisherParameters = new HashMap<String, Object>();
		addPublisherParameters.put(PUBLISHER_NAME, "testPublisherName");
		addPublisherParameters.put(EMAIL_ADDRESS, "test@gmail.com");
		addPublisherParameters.put(CONTACT_NAME, "testContactPublisher");
		addPublisherParameters.put(COMMENTS, "some comments");

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, addPublisherParameters };

		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, XMLRPCMethodParameters);
		assertNotNull(result);
		
		try {
			XMLRPCMethodParameters = new Object[] { sessionId, result };
			final Map<String, Object> publisher = (Map<String, Object>) execute(
					GET_PUBLISHER_METHOD, XMLRPCMethodParameters);

			checkParameter(publisher, AGENCY_ID, agencyId);
			checkParameter(publisher, PUBLISHER_NAME, addPublisherParameters.get(PUBLISHER_NAME));
			checkParameter(publisher, CONTACT_NAME, addPublisherParameters.get(CONTACT_NAME));
			checkParameter(publisher, EMAIL_ADDRESS, addPublisherParameters.get(EMAIL_ADDRESS));
			checkParameter(publisher, COMMENTS, addPublisherParameters.get(COMMENTS));
		} finally {
			deletePublisher(result);
		}
	}

	/**
	 * Test method without some required fields.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddPublisherWithoutSomeRequiredFields()
			throws MalformedURLException, XmlRpcException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_NAME, "Publisher name");

		Object[] params = new Object[] { sessionId, struct };

		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);

		assertNotNull(result);
		deletePublisher(result);
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
	private void executeAddPublisherWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
			deletePublisher(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAddPublisherGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {

		final String strGreaterThan255 = TextUtils.getString(256);

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(PUBLISHER_NAME, strGreaterThan255);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.EXCEED_MAXIMUM_LENGTH_OF_FIELD, PUBLISHER_NAME));
	}

	/**
	 * Test method with fields that has value less than min
	 *
	 * @throws MalformedURLException
	 */
	public void testAddPublisherLessThanMinFieldValueError()
			throws MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };

		struct.put(PUBLISHER_NAME, "testPublisher");
		struct.put(EMAIL_ADDRESS, "");
		executeAddPublisherWithError(params, ErrorMessage.EMAIL_IS_NOT_VALID);

	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddPublisherMinValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_NAME, TextUtils.MIN_ALLOWED_STRING);
		struct.put(CONTACT_NAME, TextUtils.MIN_ALLOWED_STRING);
		struct.put(EMAIL_ADDRESS, TextUtils.MIN_ALLOWED_EMAIL);
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
		assertNotNull(result);
		deletePublisher(result);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddPublisherMaxValues() throws XmlRpcException,
			MalformedURLException {
		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_NAME, TextUtils.getString(255));
		struct.put(CONTACT_NAME, TextUtils.getString(255));
		struct.put(EMAIL_ADDRESS, TextUtils.getString(55) + "@mail.com");
		Object[] params = new Object[] { sessionId, struct };
		final Integer result = (Integer) execute(ADD_PUBLISHER_METHOD, params);
		assertNotNull(result);
		deletePublisher(result);
	}

	/**
	 * Try to add publisher with unknown agency id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAddPublisherUnknownAgencyIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getPublisherServiceUrl()));

		Map<String, Object> struct = new HashMap<String, Object>();
		struct.put(PUBLISHER_NAME, TextUtils.MIN_ALLOWED_STRING);
		struct.put(AGENCY_ID, id);
		Object[] params = new Object[] { sessionId, struct };

		try {
			final Integer result = (Integer) client.execute(
					ADD_PUBLISHER_METHOD, params);
			deletePublisher(result);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID),
					e.getMessage());
		}
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testAddPublisherWrongTypeError() throws MalformedURLException {

		Map<String, Object> struct = new HashMap<String, Object>();
		Object[] params = new Object[] { sessionId, struct };
		struct.put(PUBLISHER_NAME, TextUtils.MIN_ALLOWED_STRING);

		struct.put(AGENCY_ID, TextUtils.NOT_INTEGER);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_INTEGER, AGENCY_ID));

		struct.remove(AGENCY_ID);
		struct.put(PUBLISHER_NAME, TextUtils.NOT_STRING);
		executeAddPublisherWithError(params, ErrorMessage.getMessage(
				ErrorMessage.FIELD_IS_NOT_STRING, PUBLISHER_NAME));
	}
}
