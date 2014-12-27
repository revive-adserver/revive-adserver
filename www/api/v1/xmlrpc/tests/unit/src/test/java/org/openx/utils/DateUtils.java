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

import java.util.Calendar;
import java.util.Date;

public class DateUtils {

	public static final Date MIN_DATE_VALUE;
	public static final Date MAX_DATE_VALUE;
	public static final Date DATE_GREATER_THAN_MAX;
	public static final Date DATE_LESS_THAN_MIN;
	public static final String ZERO_DATE = "00000000T00:00:00";
	//public static final Calendar ZERO_DATE;

	static {
		final Calendar calendar = Calendar.getInstance();
		calendar.clear();

		calendar.set(1970, Calendar.JANUARY, 1);
		MIN_DATE_VALUE = calendar.getTime();

		calendar.set(2038, Calendar.DECEMBER, 31);
		MAX_DATE_VALUE = calendar.getTime();

		final int oneDay = 24 * 60 * 60 * 1000;
		DATE_GREATER_THAN_MAX = new Date(MAX_DATE_VALUE.getTime() + oneDay);

		DATE_LESS_THAN_MIN = new Date(MIN_DATE_VALUE.getTime() - oneDay);
	}

	/**
	 *
	 * @param year -
	 *            the value used to set the YEAR calendar field.
	 * @param month -
	 *            the value used to set the MONTH calendar field. Month value is
	 *            0-based. e.g., 0 for January.
	 * @param date -
	 *            the value used to set the DAY_OF_MONTH calendar field.
	 * @return
	 */
	public static Date getDate(final int year, final int month, final int date) {
		final Calendar calendar = Calendar.getInstance();
		calendar.clear();
		calendar.set(year, month, date);

		return calendar.getTime();
	}

	public static void main(String[] args) {
		System.out.println(DATE_GREATER_THAN_MAX);
		System.out.println(MAX_DATE_VALUE);
		System.out.println(MIN_DATE_VALUE);

		System.out.println(DATE_LESS_THAN_MIN);
	}
}
