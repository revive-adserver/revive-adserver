/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
|  Copyright 2003-2007 Openads Limited                                      |
|                                                                           |
|  Licensed under the Apache License, Version 2.0 (the "License");          |
|  you may not use this file except in compliance with the License.         |
|  You may obtain a copy of the License at                                  |
|                                                                           |
|    http://www.apache.org/licenses/LICENSE-2.0                             |
|                                                                           |
|  Unless required by applicable law or agreed to in writing, software      |
|  distributed under the License is distributed on an "AS IS" BASIS,        |
|  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. |
|  See the License for the specific language governing permissions and      |
|  limitations under the License.                                           |
+---------------------------------------------------------------------------+
$Id:$
*/

package org.openads.agency;

import java.net.MalformedURLException;

import org.apache.xmlrpc.XmlRpcException;
import org.openads.utils.ErrorMessage;
import org.openads.utils.TextUtils;

/**
 * Verify Delete Agency method
 * 
 * @author <a href="mailto:apetlyovanyy@lohika.com">Andriy Petlyovanyy</a>
 */
public class TestDeleteAgency extends AgencyTestCase {

	/**
	 * Execute test method with error
	 * 
	 * @param params -
	 *            parameters for test method
	 * @param errorMsg -
	 *            true error messages
	 * @throws MalformedURLException
	 */
	private void executeDeleteAgencyWithError(Object[] params, String errorMsg)
			throws MalformedURLException {
		try {
			execute(DELETE_AGENCY_METHOD, params);
			fail(DELETE_AGENCY_METHOD
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
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyAllReqAndSomeOptionalFields()
			throws XmlRpcException, MalformedURLException {

		int agencyId = createAgency();

		assertNotNull("Can't add agency.", agencyId);

		final Boolean result = (Boolean) client.execute(DELETE_AGENCY_METHOD,
				new Object[] { sessionId, agencyId });

		assertTrue("Can't delete agency.", result);
	}

	/**
	 * Test method without some required fields.
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyWithoutSomeRequiredFields()
			throws XmlRpcException, MalformedURLException {
		int agencyId = createAgency();

		executeDeleteAgencyWithError(new Object[] { sessionId }, ErrorMessage
				.getMessage(ErrorMessage.INCORRECT_PARAMETERS_PASSED_TO_METHOD,
						"2", "1"));
		deleteAgency(agencyId);
	}

	/**
	 * Test method with all fields
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyAllFields() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAgency();
		boolean result = deleteAgency(id);
		assertTrue(result);
	}

	/**
	 * Try to delete agency with unknown id
	 * 
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyUnknownIdError() throws XmlRpcException,
			MalformedURLException {
		final Integer id = createAgency();
		deleteAgency(id);
		Object[] params = new Object[] { sessionId, id };

		executeDeleteAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, AGENCY_ID));

	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 * 
	 * @throws MalformedURLException
	 */
	public void testDeleteAgencyWrongTypeError() throws MalformedURLException {
		Object[] params = new Object[] { sessionId, TextUtils.NOT_INTEGER };

		executeDeleteAgencyWithError(params, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
