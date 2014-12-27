/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.config;

import java.util.MissingResourceException;
import java.util.ResourceBundle;

public class GlobalSettings {

	private static final String SERVICE_URL = "ServiceURL";

	private static final String LOGON_SERVICE_LOCATION = "LogonServiceLocation";
	private static final String AGENCY_SERVICE_LOCATION = "AgencyServiceLocation";
	private static final String ADVERTISER_SERVICE_LOCATION = "AdvertiserServiceLocation";
	private static final String BANNER_SERVICE_LOCATION = "BannerServiceLocation";
	private static final String CAMPAIGN_SERVICE_LOCATION = "CampaignServiceLocation";
	private static final String PUBLISHER_SERVICE_LOCATION = "PublisherServiceLocation";
	private static final String ZONE_SERVICE_LOCATION = "ZoneServiceLocation";
	private static final String USER_SERVICE_LOCATION = "UserServiceLocation";

	private static final String USER_NAME = "UserName";
	private static final String PASSWORD = "Password";

	private static final String OUTPUT_TO_CONSOLE = "OutputToConsole";
	private static final String LOG_FILE_NAME = "LogFileName";

	private static final String BUNDLE_NAME = "config"; //$NON-NLS-1$

	private static final ResourceBundle RESOURCE_BUNDLE = ResourceBundle
			.getBundle(BUNDLE_NAME);

	private GlobalSettings() {
	}

	private static String getString(String key) {
		try {
			return RESOURCE_BUNDLE.getString(key);
		} catch (MissingResourceException e) {
			return '!' + key + '!';
		}
	}

	public static String getLogonServiceUrl() {
		return getString(SERVICE_URL) + getString(LOGON_SERVICE_LOCATION);
	}

	public static String getAgencyServiceUrl() {
		return getString(SERVICE_URL) + getString(AGENCY_SERVICE_LOCATION);
	}

	public static String getAdvertiserServiceUrl() {
		return getString(SERVICE_URL) + getString(ADVERTISER_SERVICE_LOCATION);
	}

	public static String getBannerServiceUrl() {
		return getString(SERVICE_URL) + getString(BANNER_SERVICE_LOCATION);
	}

	public static String getCampaignServiceUrl() {
		return getString(SERVICE_URL) + getString(CAMPAIGN_SERVICE_LOCATION);
	}

	public static String getPublisherServiceUrl() {
		return getString(SERVICE_URL) + getString(PUBLISHER_SERVICE_LOCATION);
	}

	public static String getZoneServiceUrl() {
		return getString(SERVICE_URL) + getString(ZONE_SERVICE_LOCATION);
	}

	public static String getUserServiceUrl() {
		return getString(SERVICE_URL) + getString(USER_SERVICE_LOCATION);
	}

	public static String getUserName() {
		return getString(USER_NAME);
	}

	public static String getPassword() {
		return getString(PASSWORD);
	}

	public static String getOutputToConsole() {
		return getString(OUTPUT_TO_CONSOLE);
	}

	public static String getLogFileName() {
		return getString(LOG_FILE_NAME);
	}
}
