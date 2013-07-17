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
import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClient;

/**
 * The Class LogonService.
 *
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
	 */
	public LogonService(XmlRpcClient client, String basepath) {
		super(client, basepath);
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
	 * @throws XmlRpcException the xml rpc exception
	 */
	public String logon(String username, String password) throws XmlRpcException {
		return (String) executeWithoutSessionId(LOGON_METHOD, username,
				password);
	}

	/**
	 * Logoff.
	 *
	 * @return the boolean
	 *
	 * @throws XmlRpcException the xml rpc exception
	 */
	public Boolean logoff() throws XmlRpcException {
		return (Boolean) execute(LOGOFF_METHOD);
	}

}
