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
$Id:$
*/

package org.openads.proxy;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClient;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;

/**
 * The Class AbstractService.
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
abstract class AbstractService {
	private XmlRpcClient client;
	private String sessionId;
	private String basepath;

	/**
	 * Gets the service.
	 *
	 * @return the service
	 */
	abstract String getService();

	/**
	 * Instantiates a new abstract service.
	 *
	 * @param client the client
	 * @param basepath the basepath
	 */
	public AbstractService(XmlRpcClient client, String basepath) {
		super();
		this.client = client;
		this.basepath = basepath;
	}

	/**
	 * Sets the server url.
	 */
	private void setServerUrl() {
		try {
			URL oldUrl = ((XmlRpcClientConfigImpl) client.getClientConfig())
					.getServerURL();

			URL newUrl = new URL(oldUrl.getProtocol(), oldUrl.getHost(), oldUrl
					.getPort(), "//" + basepath + "//" + getService());

			((XmlRpcClientConfigImpl) client.getClientConfig())
					.setServerURL(newUrl);
		} catch (MalformedURLException e) {
			throw new RuntimeException(e.getMessage());
		}
	}

	/**
	 * Sets the session id.
	 *
	 * @param sessionId the new session id
	 */
	public void setSessionId(String sessionId) {
		this.sessionId = sessionId;
	}

	/**
	 * Execute.
	 *
	 * @param methodName the method name
	 * @param params the params
	 *
	 * @return the object
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Object execute(String methodName, Object... params)
			throws XmlRpcException {
		setServerUrl();

		Object[] paramsWithSessionId = new Object[params.length + 1];
		paramsWithSessionId[0] = sessionId;

		for (int i = 1; i < paramsWithSessionId.length; i++) {
			paramsWithSessionId[i] = params[i - 1];
		}

		return client.execute(methodName, paramsWithSessionId);
	}

	/**
	 * Execute without session id.
	 *
	 * @param methodName the method name
	 * @param params the params
	 *
	 * @return the object
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Object executeWithoutSessionId(String methodName, Object... params)
			throws XmlRpcException {
		setServerUrl();
		return client.execute(methodName, params);
	}

	/**
	 * Object to array maps.
	 *
	 * @param arrayObjects the array objects
	 *
	 * @return the Map[]
	 */
	public Map[] objectToArrayMaps(Object arrayObjects) {
		Map[] arrayMaps;

		try {
			Object[] array = (Object[]) arrayObjects;

			arrayMaps = new Map[array.length];

			for (int i = 0; i < arrayMaps.length; i++) {
				arrayMaps[i] = (Map) array[i];
			}
		} catch (Exception e) {
			throw new IllegalArgumentException(e.getMessage());
		}

		return arrayMaps;
	}

}
