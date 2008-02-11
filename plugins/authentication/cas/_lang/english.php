<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
$Id$
*/

$conf = $GLOBALS['_MAX']['CONF'];
$name = (!empty($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;

$words = array(
    'Connection error, please send your data again' => 'Connection error, please send your data again',
    'strEmailSsoConfirmationSubject' => "{superUserName} has given you access to an ".$name ." account, please complete your sign up",
    'strEmailSsoConfirmationBody' => "Hello {contactName}

You have been given access to an ".$name." account by {superUserName}, to confirm your details and complete the sign up process please click on the link below
{url}

Please contact us at info@openx.org if you have any questions

Thanks
The Openads Team",
);

?>
