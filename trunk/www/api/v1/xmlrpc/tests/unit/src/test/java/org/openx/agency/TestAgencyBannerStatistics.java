/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| ======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                 |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

package org.openx.agency;

import java.net.MalformedURLException;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.DateUtils;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Agency Banner Statistics method
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TestAgencyBannerStatistics extends AgencyTestCase {
	private Integer agencyId;

	protected void setUp() throws Exception {
		super.setUp();
		agencyId = createAgency();
	}

	protected void tearDown() throws Exception {
		deleteAgency(agencyId);
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
	private void executeAgencyBannerStatisticsWithError(Object[] params,
			String errorMsg) throws MalformedURLException {
		try {
			execute(AGENCY_BANNER_STATISTICS_METHOD, params);
			fail(AGENCY_BANNER_STATISTICS_METHOD
					+ " executed successfully, but it shouldn't.");
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}

	}

	/**
	 * Test method with all required fields and some optional.
	 *
	 * @throws XmlRpcException
	 */
	public void testAgencyBannerStatisticsAllReqAndSomeOptionalFields()
			throws XmlRpcException {
		Object[] params = new Object[] { sessionId, agencyId,
				DateUtils.MIN_DATE_VALUE };
		Object[] result = (Object[]) client.execute(
				AGENCY_BANNER_STATISTICS_METHOD, params);

		assertNotNull(result);
	}

	/**
	 * Test method without some required fields.
	 * @throws MalformedURLException
	 */
	public void testAgencyBannerStatisticsWithoutSomeRequiredFields()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId };
		executeAgencyBannerStatisticsWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
				"4, 3, or 2", "1"));
	}

	/**
	 * Test method with fields that has value greater than max.
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testAgencyBannerStatisticsGreaterThanMaxFieldValueError()
			throws MalformedURLException, XmlRpcException {
		Object[] params = new Object[] { sessionId, agencyId,
				DateUtils.MIN_DATE_VALUE, DateUtils.DATE_GREATER_THAN_MAX };

		try {
			client.execute(AGENCY_BANNER_STATISTICS_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038, e
					.getMessage());
		}
	}

	/**
	 * Test method with fields that has value less than min
	 *
	 * @throws MalformedURLException
	 */
	public void testAgencyBannerStatisticsLessThanMinFieldValueError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, agencyId,
				DateUtils.DATE_LESS_THAN_MIN, DateUtils.MAX_DATE_VALUE };

		try {
			client.execute(AGENCY_BANNER_STATISTICS_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.YEAR_SHOULD_BE_IN_RANGE_1970_2038, e
					.getMessage());
		}
	}

	/**
	 * Test method with fields that has min. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAgencyBannerStatisticsMinValues() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, agencyId,
				DateUtils.MIN_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		client.execute(AGENCY_BANNER_STATISTICS_METHOD, params);
	}

	/**
	 * Test method with fields that has max. allowed values.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAgencyBannerStatisticsMaxValues() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, agencyId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MAX_DATE_VALUE };

		client.execute(AGENCY_BANNER_STATISTICS_METHOD, params);
	}

	/**
	 * AgencyBannerStatistics with unknown id
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAgencyBannerStatisticsUnknownIdError()
			throws XmlRpcException, MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		Object[] params = new Object[] { sessionId, id };

		try {
			client.execute(AGENCY_BANNER_STATISTICS_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, ErrorMessage
					.getMessage(ErrorMessage.UNKNOWN_ID_ERROR, "agencyId"), e
					.getMessage());
		}
	}

	/**
	 * AgencyBannerStatistics when end date is before start date
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testAgencyBannerStatisticsDateError() throws XmlRpcException,
			MalformedURLException {
		Object[] params = new Object[] { sessionId, agencyId,
				DateUtils.MAX_DATE_VALUE, DateUtils.MIN_DATE_VALUE };

		try {
			client.execute(AGENCY_BANNER_STATISTICS_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE,
					ErrorMessage.START_DATE_IS_AFTER_END_DATE, e.getMessage());
		}
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 */
	public void testAgencyBannerStatisticsWrongTypeError()
			throws MalformedURLException {
		Object[] params = new Object[] { sessionId, agencyId,
				TextUtils.NOT_DATE, DateUtils.MAX_DATE_VALUE };
		executeAgencyBannerStatisticsWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING, "3"));

		params = new Object[] { sessionId, agencyId, DateUtils.MIN_DATE_VALUE,
				TextUtils.NOT_DATE };
		executeAgencyBannerStatisticsWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING, "4"));
	}
}
