/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.base;

import java.net.URL;
import java.util.Date;
import java.util.Map;

import junit.framework.TestCase;

import org.apache.xmlrpc.client.XmlRpcClient;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;
import org.apache.xmlrpc.client.XmlRpcTransport;
import org.apache.xmlrpc.client.XmlRpcTransportFactory;
import org.openx.config.GlobalSettings;
import org.openx.proxy.ErrorLoggingXmlRpcSunHttpTransport;

/**
 * Base class for all web service tests
 */
public class WebServiceTestCase extends TestCase {

	protected static final String LOGON_METHOD = "logon";
	protected static final String LOGOFF_METHOD = "logoff";

	protected XmlRpcClient client;
	protected String sessionId;


	protected void setUp() throws Exception {
		super.setUp();

		// create & config XML-RPC client
		final XmlRpcClientConfigImpl config = new XmlRpcClientConfigImpl();

		config.setServerURL(new URL(GlobalSettings.getLogonServiceUrl()));
		client = new XmlRpcClient();
		//client.setTransportFactory(new XmlRpcCommonsTransportFactory(client));
        final XmlRpcTransport transport = new ErrorLoggingXmlRpcSunHttpTransport(client);
            client.setTransportFactory(new XmlRpcTransportFactory() {

                @Override
                public XmlRpcTransport getTransport()
                {
                    return transport;
                }

            });

		client.setConfig(config);

		// logon and get session id
		sessionId = (String) client.execute(LOGON_METHOD, new Object[] {
				GlobalSettings.getUserName(), GlobalSettings.getPassword() });
	}

	protected void tearDown() throws Exception {
		// logoff
		((XmlRpcClientConfigImpl) client.getClientConfig())
				.setServerURL(new URL(GlobalSettings.getLogonServiceUrl()));
		client.execute(LOGOFF_METHOD, new Object[] { sessionId });

		super.tearDown();
	}

	public void checkParameter(Map<String, Object> referencedObject, String parameter,
			Object correctValue) {

		if (correctValue instanceof Integer) {
			Integer value = (Integer) correctValue;
			assertEquals(parameter + " fields should be equal", value,
					(Integer) referencedObject.get(parameter));
		} else if (correctValue instanceof String) {
			String value = (String) correctValue;
			assertEquals(parameter + " fields should be equal", value,
					(String) referencedObject.get(parameter));
		} else if (correctValue instanceof Date) {
			String value = ((Date) correctValue).toString();
			assertEquals(parameter + " fields should be equal", value,
					((Date) referencedObject.get(parameter)).toString());
		} else if (correctValue instanceof Double) {
			Double value = (Double) correctValue;
			assertEquals(parameter + " fields should be equal", value,
					(Double) referencedObject.get(parameter));
		} else {
			fail(parameter + " fields should be equal");
		}
	}

	public void checkParameter(Map<String, Object> referencedObject,
			Map<String, Object> testObject, String parameter) {

		checkParameter(referencedObject, parameter, testObject.get(parameter));
	}
}
