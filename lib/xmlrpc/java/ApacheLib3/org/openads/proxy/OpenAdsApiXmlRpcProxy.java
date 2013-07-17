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

import java.net.URL;
import java.util.Date;
import java.util.Map;

import org.apache.xmlrpc.XmlRpcException;
import org.apache.xmlrpc.client.XmlRpcClient;
import org.apache.xmlrpc.client.XmlRpcClientConfigImpl;

/**
 * The Class OpenAdsApiXmlRpcProxy.
 *
 */
public class OpenAdsApiXmlRpcProxy {
	private String host;
	private String basepath;
	private int port;
	private boolean ssl;

	private XmlRpcClient client;
	private String sessionId;

	private LogonService logonService;
	private AgencyService agencyService;
	private AdvertiserService advertiserService;
	private CampaignService campaignService;
	private BannerService bannerService;
	private PublisherService publisherService;
	private ZoneService zoneService;

	/**
	 * Instantiates a new open ads api xml rpc proxy.
	 *
	 * @param host
	 *            the host
	 * @param basepath
	 *            the basepath
	 * @param port
	 *            the port
	 * @param ssl
	 *            the ssl
	 */
	public OpenAdsApiXmlRpcProxy(String host, String basepath, int port,
			boolean ssl) {
		this.host = host;
		this.basepath = basepath;
		this.port = port;
		this.ssl = ssl;

		try {
			// create & config XML-RPC client
			XmlRpcClientConfigImpl config = new XmlRpcClientConfigImpl();

			String protocol = this.ssl ? "https" : "http";
			URL url = new URL(protocol, this.host, this.port, "//"
					+ this.basepath);
			config.setServerURL(url);

			client = new XmlRpcClient();
			client.setConfig(config);
		} catch (Exception e) {
			throw new RuntimeException(e.getMessage());
		}

		logonService = new LogonService(client, this.basepath);

		agencyService = new AgencyService(client, this.basepath);
		advertiserService = new AdvertiserService(client, this.basepath);
		campaignService = new CampaignService(client, this.basepath);
		bannerService = new BannerService(client, this.basepath);
		publisherService = new PublisherService(client, this.basepath);
		zoneService = new ZoneService(client, this.basepath);
	}

	/**
	 * Instantiates a new open ads api xml rpc proxy.
	 *
	 * @param host
	 *            the host
	 * @param basepath
	 *            the basepath
	 */
	public OpenAdsApiXmlRpcProxy(String host, String basepath) {
		this(host, basepath, -1, false);
	}

	/**
	 * This method is used to initialize session of user.
	 *
	 * @param username
	 *            the username
	 * @param password
	 *            the password
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Boolean logon(String username, String password)
			throws XmlRpcException {
		try {
			sessionId = logonService.logon(username, password);
			if (isValidSessionId()) {
				logonService.setSessionId(sessionId);
				agencyService.setSessionId(sessionId);
				advertiserService.setSessionId(sessionId);
				campaignService.setSessionId(sessionId);
				bannerService.setSessionId(sessionId);
				publisherService.setSessionId(sessionId);
				zoneService.setSessionId(sessionId);
				return true;
			} else {
				return false;
			}

		} catch (XmlRpcException e) {
			sessionId = null;
			throw e;
		}
	}

	/**
	 * Checks if is valid session id.
	 *
	 * @return true, if is valid session id
	 */
	private boolean isValidSessionId() {
		return (sessionId != null);
	}

	/**
	 * Verify logon.
	 */
	private void verifyLogon() {
		if (!isValidSessionId())
			throw new IllegalArgumentException("Not logined to server");
	}

	/**
	 * This method is used to abandon user session.
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Boolean logoff() throws XmlRpcException {
		verifyLogon();

		Boolean result = logonService.logoff();
		if (result)
			sessionId = null;
		return result;
	}

	/**
	 * This method adds an agency to the system.
	 *
	 * @param params -
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> agencyName String (255) The name of the agency
	 *            <li> contactName String (255) The name of the contact
	 *            <li> emailAddress String (64) The email address of the contact
	 *            <li> username String (64) The username of the contact used to
	 *            log into OA
	 *            <li> password String (64) The password of the contact used to
	 *            log into OA
	 *            <ol>
	 *
	 * @return The ID of the newly created agency
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 * @see Webservices API
	 */
	public Integer addAgency(Map params) throws XmlRpcException {
		verifyLogon();
		return agencyService.addAgency(params);
	}

	/**
	 * This method modifies an existing agency.
	 *
	 * @param params
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> agencyId integer The ID of the agency
	 *            <li> agencyName String (255) The name of the agency
	 *            <li> contactName String (255) The name of the contact
	 *            <li> emailAddress String (64) The email address of the contact
	 *            <li> username String (64) The username of the contact used to
	 *            log into OA
	 *            <li> password String (64) The password of the contact used to
	 *            log into OA
	 *            <ol>
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Boolean modifyAgency(Map params) throws XmlRpcException {
		verifyLogon();
		return agencyService.modifyAgency(params);
	}

	/**
	 * Delete agency.
	 *
	 * @param id
	 *            the id
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Boolean deleteAgency(Integer id) throws XmlRpcException {
		verifyLogon();
		return agencyService.deleteAgency(id);
	}

	/**
	 * Gets the agency.
	 *
	 * @param id
	 *            the id
	 *
	 * @return map agency whith key:
	 *
	 * <ol>
	 * <li> agencyName String (255) The name of the agency
	 * <li> contactName String (255) The name of the contact
	 * <li> emailAddress String (64) The email address of the contact
	 * <li> username String (64) The username of the contact used to log into OA
	 * <li> password String (64) The password of the contact used to log into OA
	 * </ol>
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map getAgency(Integer id) throws XmlRpcException {
		verifyLogon();
		return agencyService.getAgency(id);
	}

	/**
	 * Gets the agency list.
	 *
	 * @return the agency list
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] getAgencyList() throws XmlRpcException {
		verifyLogon();
		return agencyService.getAgencyList();
	}

	/**
	 * Agency zone statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyZoneStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyZoneStatistics(id);
	}

	/**
	 * Agency zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyZoneStatistics(id, startDate);
	}

	/**
	 * Agency zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyZoneStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyZoneStatistics(id, startDate, endDate);
	}

	/**
	 * Agency advertiser statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyAdvertiserStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyAdvertiserStatistics(id);
	}

	/**
	 * Agency advertiser statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyAdvertiserStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyAdvertiserStatistics(id, startDate);
	}

	/**
	 * Agency advertiser statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyAdvertiserStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyAdvertiserStatistics(id, startDate, endDate);
	}

	/**
	 * Agency banner statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyBannerStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyBannerStatistics(id);
	}

	/**
	 * Agency banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyBannerStatistics(id, startDate);
	}

	/**
	 * Agency banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyBannerStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyBannerStatistics(id, startDate, endDate);
	}

	/**
	 * Agency campaign statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyCampaignStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyCampaignStatistics(id);
	}

	/**
	 * Agency campaign statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyCampaignStatistics(id, startDate);
	}

	/**
	 * Agency campaign statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyCampaignStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyCampaignStatistics(id, startDate, endDate);
	}

	/**
	 * Agency daily statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyDailyStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyDailyStatistics(id);
	}

	/**
	 * Agency daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyDailyStatistics(id, startDate);
	}

	/**
	 * Agency daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyDailyStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyDailyStatistics(id, startDate, endDate);
	}

	/**
	 * Agency publisher statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyPublisherStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyPublisherStatistics(id);
	}

	/**
	 * Agency publisher statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyPublisherStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyPublisherStatistics(id, startDate);
	}

	/**
	 * Agency publisher statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] agencyPublisherStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return agencyService.agencyPublisherStatistics(id, startDate, endDate);
	}

	/**
	 * This method adds an advertiser to the system.
	 *
	 * @param params -
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> agencyId integer The ID of the agency to which to add the
	 *            advertiser
	 *            <li> advertiserName string (255) The name of the advertiser
	 *            <li> contactName string (255) The name of the contact
	 *            <li> emailAddress string (64) The email address of the contact
	 *            <li> username string (64) The username of the contact used to
	 *            log into OA
	 *            <li> password string (64) The password of the contact used to
	 *            log into OA
	 *            </ol>
	 *
	 * @return The ID of the newly created advertiser
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Integer addAdvertiser(Map params) throws XmlRpcException {
		verifyLogon();
		return advertiserService.addAdvertiser(params);
	}

	/**
	 * This method modifies an existing advertiser.
	 *
	 * @param params
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> advertiserId integer The ID of the advertiser
	 *            <li> agencyId integer The ID of the agency to which to add the
	 *            advertiser
	 *            <li> advertiserName string (255) The name of the advertiser
	 *            <li> contactName string (255) The name of the contact
	 *            <li> emailAddress string (64) The email address of the contact
	 *            <li> username string (64) The username of the contact used to
	 *            log into OA
	 *            <li> password string (64) The password of the contact used to
	 *            log into OA
	 *            </ol>
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Boolean modifyAdvertiser(Map params) throws XmlRpcException {
		verifyLogon();
		return advertiserService.modifyAdvertiser(params);
	}

	/**
	 * Delete advertiser.
	 *
	 * @param id
	 *            the id
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Boolean deleteAdvertiser(Integer id) throws XmlRpcException {
		verifyLogon();
		return advertiserService.deleteAdvertiser(id);
	}

	/**
	 * Gets the advertiser.
	 *
	 * @param id
	 *            the id
	 *
	 * @return map advertiser whith key:
	 *
	 * <ol>
	 * <li> agencyId integer The ID of the agency to which to add the advertiser
	 * <li> advertiserName string (255) The name of the advertiser
	 * <li> contactName string (255) The name of the contact
	 * <li> emailAddress string (64) The email address of the contact
	 * <li> username string (64) The username of the contact used to log into OA
	 * <li> password string (64) The password of the contact used to log into OA
	 * </ol>
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map getAdvertiser(Integer id) throws XmlRpcException {
		verifyLogon();
		return advertiserService.getAdvertiser(id);
	}

	/**
	 * Gets the advertiser list by agency id all fields.
	 *
	 * @param id
	 *            the id
	 *
	 * @return advertisers list
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] getAdvertiserListByAgencyIdAllFields(Integer id)
			throws XmlRpcException {
		verifyLogon();
		return advertiserService.getAdvertiserListByAgencyIdAllFields(id);
	}

	/**
	 * Advertiser zone statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserZoneStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserZoneStatistics(id);
	}

	/**
	 * Advertiser zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserZoneStatistics(id, startDate);
	}

	/**
	 * Advertiser zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserZoneStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserZoneStatistics(id, startDate,
				endDate);
	}

	/**
	 * Advertiser banner statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserBannerStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserBannerStatistics(id);
	}

	/**
	 * Advertiser banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserBannerStatistics(id, startDate);
	}

	/**
	 * Advertiser banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserBannerStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserBannerStatistics(id, startDate,
				endDate);
	}

	/**
	 * Advertiser campaign statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserCampaignStatistics(Integer id)
			throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserCampaignStatistics(id);
	}

	/**
	 * Advertiser campaign statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserCampaignStatistics(id, startDate);
	}

	/**
	 * Advertiser campaign statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserCampaignStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserCampaignStatistics(id, startDate,
				endDate);
	}

	/**
	 * Advertiser daily statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserDailyStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserDailyStatistics(id);
	}

	/**
	 * Advertiser daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserDailyStatistics(id, startDate);
	}

	/**
	 * Advertiser daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserDailyStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserDailyStatistics(id, startDate,
				endDate);
	}

	/**
	 * Advertiser publisher statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserPublisherStatistics(Integer id)
			throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserPublisherStatistics(id);
	}

	/**
	 * Advertiser publisher statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserPublisherStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserPublisherStatistics(id, startDate);
	}

	/**
	 * Advertiser publisher statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] advertiserPublisherStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return advertiserService.advertiserPublisherStatistics(id, startDate,
				endDate);
	}

	/**
	 * This method adds an campaign to the system.
	 *
	 * @param params -
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> advertiserId integer The ID of the advertiser to which to
	 *            add the campaign
	 *            <li> campaignName string (255) The name of the campaign
	 *            <li> startDate date The date the campaign should start
	 *            <li> endDate date The date the campaign should end
	 *            <li> impressions integer The number of impressions from which
	 *            to book this campaign
	 *            <li> clicks integer The number of clicks from which to book
	 *            this campaign
	 *            <li> priority integer The priority of this campaign
	 *            <li> weight integer The priority of this campaign
	 *            </ol>
	 *
	 * @return The ID of the newly created campaign
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Integer addCampaign(Map params) throws XmlRpcException {
		verifyLogon();
		return campaignService.addCampaign(params);
	}

	/**
	 * This method modifies an existing campaign.
	 *
	 * @param params
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> campaignId integer The ID of the campaign
	 *            <li> advertiserId integer The ID of the advertiser to which to
	 *            add the campaign
	 *            <li> campaignName string (255) The name of the campaign
	 *            <li> startDate date The date the campaign should start
	 *            <li> endDate date The date the campaign should end
	 *            <li> impressions integer The number of impressions from which
	 *            to book this campaign
	 *            <li> clicks integer The number of clicks from which to book
	 *            this campaign
	 *            <li> priority integer The priority of this campaign
	 *            <li> weight integer The priority of this campaign
	 *            </ol>
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Boolean modifyCampaign(Map params) throws XmlRpcException {
		verifyLogon();
		return campaignService.modifyCampaign(params);
	}

	/**
	 * Delete campaign.
	 *
	 * @param id
	 *            the id
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Boolean deleteCampaign(Integer id) throws XmlRpcException {
		verifyLogon();
		return campaignService.deleteCampaign(id);
	}

	/**
	 * Gets the campaign.
	 *
	 * @param id
	 *            the id
	 *
	 * @return map campaign whith key:
	 *
	 * <ol>
	 * <li> advertiserId integer The ID of the advertiser to which to add the
	 * campaign
	 * <li> campaignName string (255) The name of the campaign
	 * <li> startDate date The date the campaign should start
	 * <li> endDate date The date the campaign should end
	 * <li> impressions integer The number of impressions from which to book
	 * this campaign
	 * <li> clicks integer The number of clicks from which to book this campaign
	 * <li> priority integer The priority of this campaign
	 * <li> weight integer The priority of this campaign
	 * </ol>
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map getCampaign(Integer id) throws XmlRpcException {
		verifyLogon();
		return campaignService.getCampaign(id);
	}

	/**
	 * Gets the campaign list by advertiser id.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the campaign list by advertiser id
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] getCampaignListByAdvertiserID(Integer id)
			throws XmlRpcException {
		verifyLogon();
		return campaignService.getCampaignListByAdvertiserID(id);
	}

	/**
	 * Campaign zone statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignZoneStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignZoneStatistics(id);
	}

	/**
	 * Campaign zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignZoneStatistics(id, startDate);
	}

	/**
	 * Campaign zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignZoneStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignZoneStatistics(id, startDate, endDate);
	}

	/**
	 * Campaign banner statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignBannerStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignBannerStatistics(id);
	}

	/**
	 * Campaign banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignBannerStatistics(id, startDate);
	}

	/**
	 * Campaign banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignBannerStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignBannerStatistics(id, startDate, endDate);
	}

	/**
	 * Campaign daily statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignDailyStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignDailyStatistics(id);
	}

	/**
	 * Campaign daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignDailyStatistics(id, startDate);
	}

	/**
	 * Campaign daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignDailyStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignDailyStatistics(id, startDate, endDate);
	}

	/**
	 * Campaign publisher statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignPublisherStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignPublisherStatistics(id);
	}

	/**
	 * Campaign publisher statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignPublisherStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignPublisherStatistics(id, startDate);
	}

	/**
	 * Campaign publisher statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] campaignPublisherStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return campaignService.campaignPublisherStatistics(id, startDate,
				endDate);
	}

	/**
	 * This method adds an banner to the system.
	 *
	 * @param params -
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> campaignId integer The ID of the campaign to which to add
	 *            the banner
	 *            <li> bannerName string (255) The name of the banner
	 *            <li> storageType enum One of
	 *            'sql','web','url','html','network','txt'
	 *            <li> fileName string (255) The name of the file in SQL or Web
	 *            types
	 *            <li> imageURL string (255) The URL of the image file in
	 *            network types
	 *            <li> htmlTemplate text The HTML template for HTML types
	 *            <li> width integer The width of the banner
	 *            <li> height integer The height of the banner
	 *            <li> weight integer The priority of this banner
	 *            <li> url text The destination URL of the banner
	 *            </ol>
	 *
	 *
	 * @return The ID of the newly created banner
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Integer addBanner(Map params) throws XmlRpcException {
		verifyLogon();
		return bannerService.addBanner(params);
	}

	/**
	 * This method modifies an existing banner.
	 *
	 * @param params
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> bannerId integer The ID of the banner
	 *            <li> campaignId integer The ID of the campaign to which to add
	 *            the banner
	 *            <li> bannerName string (255) The name of the banner
	 *            <li> storageType enum One of
	 *            'sql','web','url','html','network','txt'
	 *            <li> fileName string (255) The name of the file in SQL or Web
	 *            types
	 *            <li> imageURL string (255) The URL of the image file in
	 *            network types
	 *            <li> htmlTemplate text The HTML template for HTML types
	 *            <li> width integer The width of the banner
	 *            <li> height integer The height of the banner
	 *            <li> weight integer The priority of this banner
	 *            <li> url text The destination URL of the banner
	 *            </ol>
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Boolean modifyBanner(Map params) throws XmlRpcException {
		verifyLogon();
		return bannerService.modifyBanner(params);
	}

	/**
	 * Delete banner.
	 *
	 * @param id
	 *            the id
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Boolean deleteBanner(Integer id) throws XmlRpcException {
		verifyLogon();
		return bannerService.deleteBanner(id);
	}

	/**
	 * Gets the banner.
	 *
	 * @param id
	 *            the id
	 *
	 * @return map banner whith key:
	 *
	 * <ol>
	 * <li> campaignId integer The ID of the campaign to which to add the banner
	 * <li> bannerName string (255) The name of the banner
	 * <li> storageType enum One of 'sql','web','url','html','network','txt'
	 * <li> fileName string (255) The name of the file in SQL or Web types
	 * <li> imageURL string (255) The URL of the image file in network types
	 * <li> htmlTemplate text The HTML template for HTML types
	 * <li> width integer The width of the banner
	 * <li> height integer The height of the banner
	 * <li> weight integer The priority of this banner
	 * <li> url text The destination URL of the banner
	 * </ol>
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map getBanner(Integer id) throws XmlRpcException {
		verifyLogon();
		return bannerService.getBanner(id);
	}

	/**
	 * Gets the banner list by advertiser id.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the banner list by advertiser id
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] getBannerListByAdvertiserID(Integer id) throws XmlRpcException {
		verifyLogon();
		return bannerService.getBannerListByAdvertiserID(id);
	}

	/**
	 * Banner zone statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerZoneStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerZoneStatistics(id);
	}

	/**
	 * Banner zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerZoneStatistics(id, startDate);
	}

	/**
	 * Banner zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerZoneStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerZoneStatistics(id, startDate, endDate);
	}

	/**
	 * Banner daily statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerDailyStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerDailyStatistics(id);
	}

	/**
	 * Banner daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerDailyStatistics(id, startDate);
	}

	/**
	 * Banner daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerDailyStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerDailyStatistics(id, startDate, endDate);
	}

	/**
	 * Banner publisher statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerPublisherStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerPublisherStatistics(id);
	}

	/**
	 * Banner publisher statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerPublisherStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerPublisherStatistics(id, startDate);
	}

	/**
	 * Banner publisher statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] bannerPublisherStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return bannerService.bannerPublisherStatistics(id, startDate, endDate);
	}

	/**
	 * This method adds an zone to the system.
	 *
	 * @param params -
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> publisherId integer
	 *            <li> zoneName string (255)
	 *            <li> type integer
	 *            <li> width integer
	 *            <li> height integer
	 *            </ol>
	 *
	 *
	 *
	 * @return The ID of the newly created zone
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Integer addZone(Map params) throws XmlRpcException {
		verifyLogon();
		return zoneService.addZone(params);
	}

	/**
	 * This method modifies an existing zone.
	 *
	 * @param params
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> zoneId integer The ID of the zone
	 *            <li> publisherId integer
	 *            <li> zoneName string (255)
	 *            <li> type integer
	 *            <li> width integer
	 *            <li> height integer
	 *            </ol>
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Boolean modifyZone(Map params) throws XmlRpcException {
		verifyLogon();
		return zoneService.modifyZone(params);
	}

	/**
	 * Delete zone.
	 *
	 * @param id
	 *            the id
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Boolean deleteZone(Integer id) throws XmlRpcException {
		verifyLogon();
		return zoneService.deleteZone(id);
	}

	/**
	 * Gets the zone.
	 *
	 * @param id
	 *            the id
	 *
	 * @return map zone whith key:
	 *
	 * <ol>
	 * <li> publisherId integer
	 * <li> zoneName string (255)
	 * <li> type integer
	 * <li> width integer
	 * <li> height integer
	 * </ol>
	 *
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map getZone(Integer id) throws XmlRpcException {
		verifyLogon();
		return zoneService.getZone(id);
	}

	/**
	 * Gets the zone list by publisher id.
	 *
	 * @param id
	 *            the id
	 *
	 * @return zones list
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] getZoneListByPublisherId(Integer id) throws XmlRpcException {
		verifyLogon();
		return zoneService.getZoneListByPublisherId(id);
	}

	/**
	 * Zone advertiser statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneAdvertiserStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneAdvertiserStatistics(id);
	}

	/**
	 * Zone advertiser statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneAdvertiserStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneAdvertiserStatistics(id, startDate);
	}

	/**
	 * Zone advertiser statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneAdvertiserStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneAdvertiserStatistics(id, startDate, endDate);
	}

	/**
	 * Zone banner statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneBannerStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneBannerStatistics(id);
	}

	/**
	 * Zone banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneBannerStatistics(id, startDate);
	}

	/**
	 * Zone banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneBannerStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneBannerStatistics(id, startDate, endDate);
	}

	/**
	 * Zone campaign statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneCampaignStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneCampaignStatistics(id);
	}

	/**
	 * Zone campaign statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneCampaignStatistics(id, startDate);
	}

	/**
	 * Zone campaign statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneCampaignStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneCampaignStatistics(id, startDate, endDate);
	}

	/**
	 * Zone daily statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneDailyStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneDailyStatistics(id);
	}

	/**
	 * Zone daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneDailyStatistics(id, startDate);
	}

	/**
	 * Zone daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] zoneDailyStatistics(Integer id, Date startDate, Date endDate)
			throws XmlRpcException {
		verifyLogon();
		return zoneService.zoneDailyStatistics(id, startDate, endDate);
	}

	/**
	 * This method adds an publisher to the system.
	 *
	 * @param params -
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> agencyId integer The ID of the agency to which to add the
	 *            publisher
	 *            <li> publisherName string (255) The name of the publisher
	 *            <li> contactName string (255) The name of the contact
	 *            <li> emailAddress string (64) The email address of the contact
	 *            <li> username string (64) The username of the contact used to
	 *            log into OA
	 *            <li> password string (64) The password of the contact used to
	 *            log into OA
	 *            </ol>
	 *
	 * @return The ID of the newly created publisher
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Integer addPublisher(Map params) throws XmlRpcException {
		verifyLogon();
		return publisherService.addPublisher(params);
	}

	/**
	 * This method modifies an existing publisher.
	 *
	 * @param params
	 *            Structure with the following fields:
	 *            <ol>
	 *            <li> publisherId integer The ID of the publisher
	 *            <li> agencyId integer The ID of the agency to which to add the
	 *            publisher
	 *            <li> publisherName string (255) The name of the publisher
	 *            <li> contactName string (255) The name of the contact
	 *            <li> emailAddress string (64) The email address of the contact
	 *            <li> username string (64) The username of the contact used to
	 *            log into OA
	 *            <li> password string (64) The password of the contact used to
	 *            log into OA
	 *            </ol>
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 *
	 *
	 */
	public Boolean modifyPublisher(Map params) throws XmlRpcException {
		verifyLogon();
		return publisherService.modifyPublisher(params);
	}

	/**
	 * Delete publisher.
	 *
	 * @param id
	 *            the id
	 *
	 * @return True if the operation was successful
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Boolean deletePublisher(Integer id) throws XmlRpcException {
		verifyLogon();
		return publisherService.deletePublisher(id);
	}

	/**
	 * Gets the publisher.
	 *
	 * @param id
	 *            the id
	 *
	 * @return map publisher whith key:
	 *
	 * <ol>
	 * <li> agencyId integer The ID of the agency to which to add the publisher
	 * <li> publisherName string (255) The name of the publisher
	 * <li> contactName string (255) The name of the contact
	 * <li> emailAddress string (64) The email address of the contact
	 * <li> username string (64) The username of the contact used to log into OA
	 * <li> password string (64) The password of the contact used to log into OA
	 * </ol>
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map getPublisher(Integer id) throws XmlRpcException {
		verifyLogon();
		return publisherService.getPublisher(id);
	}

	/**
	 * Gets the publisher list by agency id.
	 *
	 * @param id
	 *            the id
	 *
	 * @return publishers list
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] getPublisherListByAgencyId(Integer id) throws XmlRpcException {
		verifyLogon();
		return publisherService.getPublisherListByAgencyId(id);
	}

	/**
	 * Publisher zone statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherZoneStatistics(id);
	}

	/**
	 * Publisher zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherZoneStatistics(id, startDate);
	}

	/**
	 * Publisher zone statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherZoneStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherZoneStatistics(id, startDate, endDate);
	}

	/**
	 * Publisher campaign statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherCampaignStatistics(id);
	}

	/**
	 * Publisher campaign statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherCampaignStatistics(id, startDate);
	}

	/**
	 * Publisher campaign statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherCampaignStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherCampaignStatistics(id, startDate,
				endDate);
	}

	/**
	 * Publisher daily statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherDailyStatistics(id);
	}

	/**
	 * Publisher daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherDailyStatistics(id, startDate);
	}

	/**
	 * Publisher daily statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherDailyStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return publisherService
				.publisherDailyStatistics(id, startDate, endDate);
	}

	/**
	 * Publisher banner statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id) throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherBannerStatistics(id);
	}

	/**
	 * Publisher banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherBannerStatistics(id, startDate);
	}

	/**
	 * Publisher banner statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherBannerStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherBannerStatistics(id, startDate,
				endDate);
	}

	/**
	 * Publisher advertiser statistics.
	 *
	 * @param id
	 *            the id
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id)
			throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherAdvertiserStatistics(id);
	}

	/**
	 * Publisher advertiser statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id, Date startDate)
			throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherAdvertiserStatistics(id, startDate);
	}

	/**
	 * Publisher advertiser statistics.
	 *
	 * @param id
	 *            the id
	 * @param startDate
	 *            the start date
	 * @param endDate
	 *            the end date
	 *
	 * @return the Map[]
	 *
	 * @throws XmlRpcException
	 *             the xml rpc exception
	 */
	public Map[] publisherAdvertiserStatistics(Integer id, Date startDate,
			Date endDate) throws XmlRpcException {
		verifyLogon();
		return publisherService.publisherAdvertiserStatistics(id, startDate,
				endDate);
	}
}
