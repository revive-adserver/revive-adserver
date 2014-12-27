/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

package org.openx.utils;

public class TextUtils {
	public static final String BAD_PASSWORD = "pass\\word";
	public static final Integer NOT_STRING = 10;
	public static final String NOT_INTEGER = "10";
	public static final String NOT_DATE = "bla bla bla";
	public static final String MIN_ALLOWED_EMAIL = "a@a.aa";
	public static final String MIN_ALLOWED_STRING = "a";

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

	public static String getEmailString(final int length) {
		if (length > 10)
			return getString(length-10) + "@openx.org";
		else return "a@openx.org";
	}
}
