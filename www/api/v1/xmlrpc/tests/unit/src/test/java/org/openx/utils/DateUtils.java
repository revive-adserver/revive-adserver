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

package org.openx.utils;

import java.util.Calendar;
import java.util.Date;

/**
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */
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
