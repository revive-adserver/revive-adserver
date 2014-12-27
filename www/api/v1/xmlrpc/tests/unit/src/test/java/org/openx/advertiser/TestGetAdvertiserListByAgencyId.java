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
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Get Advertiser List By Agency Id method
 */
public class TestGetAdvertiserListByAgencyId extends AdvertiserTestCase {
	/**
	 * Test method with all fields.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	@SuppressWarnings("unchecked")
	public void testGetAdvertiserListByAgencyIdAllFields()
			throws XmlRpcException, MalformedURLException {
		final int advertisersCount = 3;
		Map<Integer, Map<String, Object>> myAdvertisers = new HashMap<Integer, Map<String, Object>>();
		for (int i = 0; i < advertisersCount; i++) {
			Map<String, Object> param = getAdvertiserParams("test2" + i);
			myAdvertisers.put(createAdvertiser(param), param);
		}

		try {
			final Object[] result = (Object[]) execute(GET_ADVERTISER_LIST_BY_AGENCY_ID_METHOD,
					new Object[] { sessionId, agencyId });

			assertEquals("Not correct count return advertises",
					myAdvertisers.size(), advertisersCount);

			for (Object advertiser : result) {
				Integer advertiserId = (Integer) ((Map) advertiser).get(ADVERTISER_ID);

				Map<String, Object> myAdvertiser = myAdvertisers.get(advertiserId);

				if (myAdvertiser != null) {
					checkParameter((Map) advertiser, AGENCY_ID, agencyId);
					checkParameter((Map) advertiser, ADVERTISER_ID, advertiserId);
					checkParameter((Map) advertiser, ADVERTISER_NAME, myAdvertiser
							.get(ADVERTISER_NAME));
					checkParameter((Map) advertiser, CONTACT_NAME, myAdvertiser
							.get(CONTACT_NAME));
					checkParameter((Map) advertiser, EMAIL_ADDRESS, myAdvertiser
							.get(EMAIL_ADDRESS));

					// remove checked agency
					myAdvertisers.remove(advertiserId);
				}
			}
		} finally {
			// delete all created advertisers
			for (Integer id : myAdvertisers.keySet()) {
				deleteAdvertiser(id);
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
	private void executeGetAdvertiserListByAgencyIdWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			List<Map<String, Object>> result = (List<Map<String, Object>>) execute(
					GET_ADVERTISER_LIST_BY_AGENCY_ID_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Try to get advertiser with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetAdvertiserListByAgencyIdUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetAdvertiserListByAgencyIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetAdvertiserListByAgencyIdWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetAdvertiserListByAgencyIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
								"2", "1")));

	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGetAdvertiserListByAgencyIdWrongTypeError()
			throws MalformedURLException, XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetAdvertiserListByAgencyIdWithError(
				params,
				ErrorMessage
						.getMessage(
								ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING,
								"2"));
	}

}
