/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
