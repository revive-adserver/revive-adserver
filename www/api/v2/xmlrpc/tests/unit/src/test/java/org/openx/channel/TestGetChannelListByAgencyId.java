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
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

public class TestGetChannelListByAgencyId extends ChannelTestCase {

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
	private void executeGetChannelListByAgencyIdWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			@SuppressWarnings("unused")
			List<Map<String, Object>> result = (List<Map<String, Object>>) execute(
					GET_CHANNEL_LIST_BY_AGENCY_ID_METHOD, params);
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
	public void testGetChannelListByAgencyIdAllFields()
			throws XmlRpcException, MalformedURLException {
		final int channelCount = 3;
		Map<Integer, Map<String, Object>> myChannels = new HashMap<Integer, Map<String, Object>>();
		for (int i = 0; i < channelCount; i++) {
			Map<String, Object> param = getChannelParams("test2" + i);
			myChannels.put(createChannel(param), param);
		}

		try {
			final Object[] result = (Object[]) execute(GET_CHANNEL_LIST_BY_AGENCY_ID_METHOD,
					new Object[] { sessionId, agencyId });

			assertEquals("Incorrect count for returned channels",
					myChannels.size(), channelCount);

			for (Object channel : result) {
				Integer channelId = (Integer) ((Map) channel).get(CHANNEL_ID);

				Map<String, Object> myCampaign = myChannels.get(channelId);

				if (myCampaign != null) {
					checkParameter((Map) channel, CHANNEL_ID, channelId);
					checkParameter((Map) channel, AGENCY_ID, agencyId);
					checkParameter((Map) channel, CHANNEL_NAME, myCampaign.get(CHANNEL_NAME));
					checkParameter((Map) channel, DESCRIPTION, myCampaign.get(DESCRIPTION));
					checkParameter((Map) channel, COMMENTS, myCampaign.get(COMMENTS));

					// remove checked campaign
					myChannels.remove(channelId);
				}
			}
		} finally {
			// delete all created campaignes
			for (Integer id : myChannels.keySet()) {
				deleteChannel(id);
			}
		}
	}



	/**
	 * Try to get campaign list by advertiser with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGetChannelListByAgencyIdUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		Object[] params = new Object[] { sessionId, id };

		executeGetChannelListByAgencyIdWithError(params, ErrorMessage
				.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));
	}

	/**
	 * Test method without some required fields(error).
	 *
	 * @throws MalformedURLException
	 */
	public void testGetChannelListByAgencyIdWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };

		executeGetChannelListByAgencyIdWithError(params, ErrorMessage
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
	public void testGetChannelListByAgencyIdWrongTypeError()
			throws MalformedURLException, XmlRpcException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeGetChannelListByAgencyIdWithError(params, ErrorMessage.getMessage(
            ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}

}
