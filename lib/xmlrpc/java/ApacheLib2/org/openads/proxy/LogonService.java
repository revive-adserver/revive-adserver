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

import org.apache.xmlrpc.XmlRpcException;

/**
 * The Class LogonService.
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class LogonService extends AbstractService {
	private static final String LOGON_SERVICE = "LogonXmlRpcService.php";

	private static final String LOGON_METHOD = "logon";
	private static final String LOGOFF_METHOD = "logoff";

	/**
	 * Instantiates a new logon service.
	 *
	 * @param client the client
	 * @param basepath the basepath
	 * @throws MalformedURLException
	 */
	public LogonService(String basepath) throws MalformedURLException {
		super(basepath);
	}

	/* (non-Javadoc)
	 * @see org.openads.proxy.AbstractService#getService()
	 */
	@Override
	String getService() {
		return LOGON_SERVICE;
	}

	/**
	 * Logon.
	 *
	 * @param username the username
	 * @param password the password
	 *
	 * @return the string
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public String logon(String username, String password) throws XmlRpcException, IOException {
		return (String) executeWithoutSessionId(LOGON_METHOD, username,
				password);
	}

	/**
	 * Logoff.
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException, IOException the xml rpc exception
	 */
	public Boolean logoff() throws XmlRpcException, IOException, IOException {
		return (Boolean) execute(LOGOFF_METHOD);
	}

}
