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
$Id$
 */
package org.openx.config;

import java.util.MissingResourceException;
import java.util.ResourceBundle;

/**
 *
 * TODO: Refactor for API v2.
 *
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
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
