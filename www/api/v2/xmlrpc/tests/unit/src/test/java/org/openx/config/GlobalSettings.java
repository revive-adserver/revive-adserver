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

/**
 *
 * TODO: Refactor for API v2.
 */
public class GlobalSettings {

    private static final String SERVICE_URL = "ServiceURL";
    private static final String USER_NAME = "UserName";
    private static final String PASSWORD = "Password";
    private static final String OUTPUT_TO_CONSOLE = "OutputToConsole";
    private static final String LOG_FILE_NAME = "LogFileName";
    private static final String BUNDLE_NAME = "config"; //$NON-NLS-1$
    private static final ResourceBundle RESOURCE_BUNDLE = ResourceBundle.getBundle(BUNDLE_NAME);

    private GlobalSettings() {
    }

    private static String getString(String key) {
        try {
            return RESOURCE_BUNDLE.getString(key);
        } catch (MissingResourceException e) {
            return '!' + key + '!';
        }
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

    public static String getServiceUrl() {
        return getString(SERVICE_URL);
    }
}
