/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
| For contact details, see: http://www.openads.org/                         |
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
|  Copyright 2003-2007 Openads Limited                                      |
|                                                                           |
|  Licensed under the Apache License, Version 2.0 (the "License");          |
|  you may not use this file except in compliance with the License.         |
|  You may obtain a copy of the License at                                  |
|                                                                           |
|    http://www.apache.org/licenses/LICENSE-2.0                             |
|                                                                           |
|  Unless required by applicable law or agreed to in writing, software      |
|  distributed under the License is distributed on an "AS IS" BASIS,        |
|  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. |
|  See the License for the specific language governing permissions and      |
|  limitations under the License.                                           |
+---------------------------------------------------------------------------+
$Id:$
 */
package org.openads.utils;

import java.text.MessageFormat;

/**
 * @author <a href="mailto:apetlyovanyy@lohika.com">Andriy Petlyovanyy</a>
 */
public class ErrorMessage {
	public static final String WRONG_ERROR_MESSAGE = "Wrong error message";
	public static final String EMAIL_IS_NOT_VALID = "Email is not valid";
	public static final String USERNAME_IS_FEWER_THAN = "Username is fewer than {0} character";
	public static final String USERNAME_IS_NULL_AND_THE_PASSWORD_IS_NOT = "Username is null and the password is not";
	public static final String USERNAME_MUST_BE_UNIQUE = "Username must be unique";
	public static final String USERNAME_FORMAT_ERROR = "Username Format Error";
	public static final String INCORRECT_PARAMETERS_PASSED_TO_METHOD = "Incorrect parameters passed to method: Signature permits {0} parameters but the request had {1}";
	public static final String PASSWORDS_CANNOT_CONTAIN = "Passwords cannot contain \"{0}\"";
	public static final String FIELD_IN_STRUCTURE_DOES_NOT_EXISTS = "Field ''{0}'' in structure does not exists";
	public static final String EXCEED_MAXIMUM_LENGTH_OF_FIELD = "Exceed Maximum length of field ''{0}''";
	public static final String FIELD_IS_NOT_STRING = "Field ''{0}'' is not string";
	public static final String FIELD_IS_NOT_INTEGER = "Field ''{0}'' is not integer";
	public static final String INCORRECT_PARAMETERS_WANTED_INT_GOT_STRING = "Incorrect parameters passed to method: Wanted int, got string at param {0}";
	public static final String INCORRECT_PARAMETERS_WANTED_DATE_GOT_STRING = "Incorrect parameters passed to method: Wanted dateTime.iso8601, got string at param {0}";

//	public static final String NULL_VALUES_ARE_NOT_SUPPORTED = "Null values aren''t supported, if isEnabledForExtensions() == false";
	public static final String START_DATE_IS_AFTER_END_DATE = "The start date is after the end date";
	public static final String YEAR_SHOULD_BE_IN_RANGE_1970_2038 = "Year should be in range 1970-2038";
	public static final String UNKNOWN_ID_ERROR = "Unknown {0} Error";
	public static final String UNKNOWN_ADVERTISER_ID_ERROR = "Unknown advertiserId Error";
	public static final String WEIGHT_COULD_NOT_BE_GREATER_THAN_ZERO = "The weight could not be greater than zero for high or medium priority campaigns";
	public static final String METHOD_EXECUTED_SUCCESSFULLY_BUT_SHOULD_NOT_HAVE = "Method executed successfully but shouldn''t have";

	public static String getMessage(final String message,
			final String... parameters) {
		return MessageFormat.format(message, (Object[]) parameters);
	}
}
