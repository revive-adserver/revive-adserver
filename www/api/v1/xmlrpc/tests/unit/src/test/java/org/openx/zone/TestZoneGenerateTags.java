/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.zone;

import java.net.MalformedURLException;
import java.util.HashMap;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.openx.utils.ErrorMessage;
import org.openx.utils.TextUtils;

/**
 * Verify Generate Tags method
 */
public class TestZoneGenerateTags extends ZoneTestCase {

	//TODO: Make not allowed type error verification more flexible
	//TODO: Manage the available ad types

	protected Integer zoneId = null;

	protected void setUp() throws Exception {
		super.setUp();

		zoneId = createZone();
	}

	protected void tearDown() throws Exception {
		deleteZone(zoneId);

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
	private void executeGenerateTagsWithError(Object[] params, String errorMsg)
		throws MalformedURLException {

		try {
			execute(ZONE_GENERATE_TAGS_METHOD, params);
			fail(ErrorMessage.METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE);
		} catch (XmlRpcException e) {
			assertEquals(ErrorMessage.WRONG_ERROR_MESSAGE, errorMsg, e
					.getMessage());
		}
	}

	/**
	 * Test method with all required fields for adframe.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGenerateTagsAllReqFieldsAdFrame()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[0], generateTagsParameters };
		final String result = (String) client
				.execute(ZONE_GENERATE_TAGS_METHOD, XMLRPCMethodParameters);

		assertNotNull(result);
	}

	/**
	 * Test method with all required fields for adjs.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGenerateTagsAllReqFieldsAdJS()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[1], generateTagsParameters };
		final String result = (String) client
				.execute(ZONE_GENERATE_TAGS_METHOD, XMLRPCMethodParameters);

		assertNotNull(result);
	}

	/**
	 * Test method with all required fields for adlayer.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGenerateTagsAllReqFieldsAdLayer()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[2], generateTagsParameters };
		final String result = (String) client
				.execute(ZONE_GENERATE_TAGS_METHOD, XMLRPCMethodParameters);

		assertNotNull(result);
	}

	/**
	 * Test method with all required fields for adview.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGenerateTagsAllReqFieldsAdView()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();
		//generateTagsParameters.put("", "");

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[3], generateTagsParameters };
		final String result = (String) client
				.execute(ZONE_GENERATE_TAGS_METHOD, XMLRPCMethodParameters);

		assertNotNull(result);
	}

	/**
	 * Test method with all required fields for adviewnocookies.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGenerateTagsAllReqFieldsAdViewNoCookies()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[4], generateTagsParameters };
		final String result = (String) client
				.execute(ZONE_GENERATE_TAGS_METHOD, XMLRPCMethodParameters);

		assertNotNull(result);
	}

	/**
	 * Test method with all required fields for local.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGenerateTagsAllReqFieldsLocal()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[5], generateTagsParameters };
		final String result = (String) client
				.execute(ZONE_GENERATE_TAGS_METHOD, XMLRPCMethodParameters);

		assertNotNull(result);
	}

	/**
	 * Test method with all required fields for popup.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGenerateTagsAllReqFieldsPopUp()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();
		//generateTagsParameters.put("", "");

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[6], generateTagsParameters };
		final String result = (String) client
				.execute(ZONE_GENERATE_TAGS_METHOD, XMLRPCMethodParameters);

		assertNotNull(result);
	}

	/**
	 * Test method with SPC type which shouldn't be allowed in Zone Service(error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGenerateTagsNotAllowedSPCType() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();
		//generateTagsParameters.put("", "");

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[7], generateTagsParameters };

		executeGenerateTagsWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_MUST_BE_ONE_OF_ENUM, CODE_TYPE, "invocationTags:oxInvocationTags:adframe, invocationTags:oxInvocationTags:adjs, invocationTags:oxInvocationTags:adlayer, invocationTags:oxInvocationTags:adview, invocationTags:oxInvocationTags:adviewnocookies, invocationTags:oxInvocationTags:local, invocationTags:oxInvocationTags:popup, invocationTags:oxInvocationTags:xmlrpc"));
	}

	/**
	 * Test method with all required fields for xmlrpc.
	 *
	 * @throws XmlRpcException
	 * @throws MalformedURLException
	 */
	public void testGenerateTagsAllReqFieldsXMLRPC()
			throws XmlRpcException, MalformedURLException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();
		//generateTagsParameters.put("", "");

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[8], generateTagsParameters };
		final String result = (String) client
				.execute(ZONE_GENERATE_TAGS_METHOD, XMLRPCMethodParameters);

		assertNotNull(result);
	}

	/**
	 * Test methods for Unknown codeType
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGenerateTagsUnknownCodeTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, "clickonly", generateTagsParameters };

		executeGenerateTagsWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_MUST_BE_ONE_OF_ENUM, CODE_TYPE, "invocationTags:oxInvocationTags:adframe, invocationTags:oxInvocationTags:adjs, invocationTags:oxInvocationTags:adlayer, invocationTags:oxInvocationTags:adview, invocationTags:oxInvocationTags:adviewnocookies, invocationTags:oxInvocationTags:local, invocationTags:oxInvocationTags:popup, invocationTags:oxInvocationTags:xmlrpc"));
	}

	/**
	 * Test methods for Empty codeType
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGenerateTagsEmptyCodeTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();
		//generateTagsParameters.put("", "");

		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, "", generateTagsParameters };

		executeGenerateTagsWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.FIELD_MUST_BE_ONE_OF_ENUM, CODE_TYPE, "invocationTags:oxInvocationTags:adframe, invocationTags:oxInvocationTags:adjs, invocationTags:oxInvocationTags:adlayer, invocationTags:oxInvocationTags:adview, invocationTags:oxInvocationTags:adviewnocookies, invocationTags:oxInvocationTags:local, invocationTags:oxInvocationTags:popup, invocationTags:oxInvocationTags:xmlrpc"));
	}


	/**
	 * Test methods for Unknown ID Error, described in API
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGenerateTagsUnknownZoneIdError() throws MalformedURLException,
			XmlRpcException {

		Integer zoneId = createZone();
		assertNotNull(zoneId);
		deleteZone(zoneId);

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, zoneId, CODE_TYPES[0], generateTagsParameters };

		executeGenerateTagsWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.UNKNOWN_ID_ERROR, ZONE_ID));
	}

	/**
	 * Test method with fields that has value of wrong type (error).
	 *
	 * @throws MalformedURLException
	 * @throws XmlRpcException
	 */
	public void testGenerateTagsZoneIdWrongTypeError() throws MalformedURLException,
			XmlRpcException {

		Map<String, Object> generateTagsParameters = new HashMap<String, Object>();
		Object[] XMLRPCMethodParameters = new Object[] { sessionId, TextUtils.NOT_INTEGER, CODE_TYPES[0], generateTagsParameters };

		executeGenerateTagsWithError(XMLRPCMethodParameters, ErrorMessage.getMessage(
				ErrorMessage.INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING, "2"));
	}
}
