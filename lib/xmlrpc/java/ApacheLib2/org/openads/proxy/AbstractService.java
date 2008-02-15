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
$Id:$
*/

package org.openads.proxy;
import java.io.IOException;
import java.net.MalformedURLException;
import java.util.Map;
import java.util.Vector;

import org.apache.xmlrpc.XmlRpcClient;
import org.apache.xmlrpc.XmlRpcException;

/**
 * The Class AbstractService.
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
abstract class AbstractService {
	private XmlRpcClient client;
	private String sessionId;

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
	 * @throws MalformedURLException
	 */
	public AbstractService(String basepath) throws MalformedURLException {
		super();
		this.client = new XmlRpcClient(basepath + "/" + getService());
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
	 * @throws IOException
	 */
	public Object execute(String methodName, Object... params)
			throws XmlRpcException, IOException {

		Vector paramsWithSessionId = new Vector(params.length + 1);
		paramsWithSessionId.add(sessionId);

		for (int i = 0; i < params.length; i++) {
			paramsWithSessionId.add(params[i]);
		}

		Object result = client.execute(methodName, paramsWithSessionId);

		if (result instanceof XmlRpcException) {
			throw (XmlRpcException) result;
		}

		return result;
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
	 * @throws IOException
	 */
	public Object executeWithoutSessionId(String methodName, Object... params)
			throws XmlRpcException, IOException {
		Vector paramsVector = new Vector();
		for(int i = 0; i < params.length; i++) {
			paramsVector.add(params[i]);
		}

		Object result = client.execute(methodName, paramsVector);

		if (result instanceof XmlRpcException) {
			throw (XmlRpcException) result;
		}

		return result;
	}

	/**
	 * Object to array maps.
	 *
	 * @param arrayObjects the array objects
	 *
	 * @return the Map[]
	 */
	public Map[] vectorToArrayMaps(Object arrayObjects) {
		Map[] arrayMaps;

		try {
			Vector vector = (Vector) arrayObjects;

			arrayMaps = new Map[vector.size()];

			for (int i = 0; i < arrayMaps.length; i++) {
				arrayMaps[i] = (Map) vector.get(i);
			}
		} catch (Exception e) {
			throw new IllegalArgumentException(e.getMessage());
		}

		return arrayMaps;
	}

}
