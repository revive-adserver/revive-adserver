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
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Publisher List By Agency Id method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestGetPublisherListByAgencyId extends PublisherTestCase {
	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetPublisherListByAgencyIdAllFields()
			throws XmlRpcException, MalformedURLException {
		final int publishersCount = 3;
		Map<Integer, Map<String, Object>> myPublishers = new HashMap<Integer, Map<String, Object>>();
		for (int i = 0; i < publishersCount; i++) {
			Map<String, Object> param = getPublisherParams("test2" + i);
			myPublishers.put(createPublisher(param), param);
		}

		try {
			final Object[] result = (Object[]) execute(GET_PUBLISHER_LIST_BY_AGENCY_ID_METHOD,
					new Object[] { sessionId, agencyId });

			assertEquals("Not correct count return publisher",
					myPublishers.size(), publishersCount);

			for (Object publisher : result) {
				Integer publisherId = (Integer) ((Map) publisher).get(PUBLISHER_ID);

				Map<String, Object> myPublisher = myPublishers.get(publisherId);

				if (myPublisher != null) {
					checkParameter((Map) publisher, AGENCY_ID, agencyId);
					checkParameter((Map) publisher, PUBLISHER_ID, publisherId);
					checkParameter((Map) publisher, PUBLISHER_NAME, myPublisher.get(PUBLISHER_NAME));
					checkParameter((Map) publisher, CONTACT_NAME, myPublisher.get(CONTACT_NAME));
					checkParameter((Map) publisher, EMAIL_ADDRESS, myPublisher.get(EMAIL_ADDRESS));

					// remove checked publisher
					myPublishers.remove(publisherId);
				}
			}
		} finally {
			// delete all created publishers
			for (Integer id : myPublishers.keySet()) {
				deletePublisher(id);
			}
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
	private void executeGetPublisherListByAgencyIdWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			List<Map<String, Object>> result = (List<Map<String, Object>>) execute(
					GET_PUBLISHER_LIST_BY_AGENCY_ID_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Try to get publisher list by agency with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetPublisherListByAgencyIdUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetPublisherListByAgencyIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetPublisherListByAgencyIdWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetPublisherListByAgencyIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.getMessage(
						ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1")));

	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetPublisherListByAgencyIdWrongTypeError()
			throws MalformedURLException, XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetPublisherListByAgencyIdWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING,
								"2"));
	}

}
