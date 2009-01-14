// Javascript

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

/**
 * Client-side (browser) script for date selection on web pages.
 */

/**
 * Do these values represent an actual date?
 *
 * Pass any values you like (including nulls and objects) -- only
 * fully formed, numeric days will produce a True result.
 *
 * @param calendar_year        Numeric year (Gregorian, AD)
 * @param calendar_month       Numberic month, wherer 1=January .. 12=December
 * @param calendar_day         Day of the month (1..31)
 *
 * @return boolean             True if the numbers represent a valid date
 */
function isValidDate(calendar_year, calendar_month, calendar_day)
{
    d = newDateFromNumbers(calendar_year, calendar_month, calendar_day);

    if (d.getDate() != calendar_day) {
        return false;
    }

    return true;
}

/**
 * Create a Date object pre-loaded with a calendar date.
 *
 * This factory method takes human-friendly one-based months instead
 * of the zero-based months that JavaScript Date objects expect.
 *
 *
 * @param calendar_year        Numeric year (Gregorian, AD)
 * @param calendar_month       Numberic month, wherer 1=January .. 12=December
 * @param calendar_day         Day of the month (1..31)
 *
 * @return Date                Date object representing the given date
 */
function newDateFromNumbers(calendar_year, calendar_month, calendar_day)
{
    var zero_based_month = calendar_month - 1;
    var d = new Date(0);

    d.setFullYear(calendar_year);
    d.setMonth(zero_based_month);
    d.setDate(calendar_day);

    return d;
}

/**
 * Is one date before another?
 *
 * @param Date a    Date to compare
 * @param Date b    Date to compare against
 * @return boolean True if the first parameter is before the second.
 */
function isDateBefore(a, b)
{
    return a.getTime() < b.getTime();
}

/**
 * Is the set of user-interface controls for a date actually active?
 *
 * @param string            base_name
 * @param HTMLFormElement   form       DOM element representing a form
 */
function isDateSetActive(base_name, form)
{
    var radio = form.elements[base_name + 'Set_specific'];
    return radio.checked;
}

/**
 * Is one date equal to another?
 *
 * @param Date a    Date to compare
 * @param Date b    Date to compare against
 *
 * @return boolean  True if the first parameter represents the same date as the second.
 */
function isDateEqual(a,b)
{
    return a.getTime() == b.getTime();
}


/**
 * Creates a Date object from collection of user-interface controls representing a date.
 *
 * @param HTMLDocument      dom_document
 * @param HTMLFormElement   form
 * @param string            base_name
 */
function newDateFromNamedFields(dom_document, form, base_name)
{
    formDate = getValueFromNamedElement(document, base_name);

    //  split date into day, month, & year
    formDate = formDate.split(" ");

    day     = formDate[0];
    month   = getMonthFromName(formDate[1]);
    year    = formDate[2];

    date = new Date(0);

    if (!isValidDate(year,month,day)) {
        return false;
    }

    date.setDate(day);
    date.setMonth(month - 1);
    date.setFullYear(year);

    return date;
}

/**
 * Finds the value of an HTML input control with a given identifier.
 *
 * @param HTMLDocument  dom_document   The document to search
 * @param string        name           The unique identifier for the requested control
 */
function getValueFromNamedElement(dom_document, name)
{
    var element = dom_document.getElementById(name);

    return element.value;
}

/**
 * Returns the month number for the given month name
 *
 * @param string    name    Name of month
 */
function getMonthFromName(name)
{
    var aMonth = {January: 1, February: 2, March: 3, April: 4, May: 5,
                    June: 6, July: 7, August: 8, September: 9, October: 10,
                    November: 11, December: 12};
    return aMonth[name];
}
