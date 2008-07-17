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
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
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

	public void checkParameter(Map<String, Object> params, String param,
			Object correctValue) {

		if (correctValue instanceof Integer) {
			Integer value = (Integer) correctValue;
			assertEquals(param + " fields should be equal", (Integer) params
					.get(param), value);
		} else if (correctValue instanceof String) {
			String value = (String) correctValue;
			assertEquals(param + " fields should be equal", (String) params
					.get(param), value);
		} else if (correctValue instanceof Date) {
			String value = ((Date) correctValue).toString();
			assertEquals(param + " fields should be equal", ((Date) params
					.get(param)).toString(), value);
		} else {
			fail(param + " fields should be equal");
		}
	}
}
