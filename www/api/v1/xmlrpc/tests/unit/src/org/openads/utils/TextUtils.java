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

package org.openads.utils;

/**
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
public class TextUtils {
	public static final String BAD_PASSWORD = "pass\\word";
	public static final Integer NOT_STRING = 10;
	public static final String NOT_INTEGER = "10";
	public static final String NOT_DATE = "bla bla bla";
	public static final String MIN_ALLOWED_EMAIL = "a@a.aa";

	public static String generateUniqueName(String prefix) {

		return prefix + System.currentTimeMillis()
				+ System.getProperty("user.name");
	}

	public static String generateUniqueString(int length) {

		StringBuffer uniqueName = new StringBuffer();

		String random = "" + System.currentTimeMillis();

		for (int i = 0, j = 0; i < length; i++, j++) {
			if (j == random.length())
				j = 0;
			uniqueName.append(random.charAt(j));
		}

		return uniqueName.toString();
	}

	public static String getString(final int length) {
		final StringBuilder sb = new StringBuilder(length);

		for (int i = 0; i < length; i++) {
			sb.append("s");
		}
		return sb.toString();
	}

}
