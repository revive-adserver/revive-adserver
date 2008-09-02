<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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
$Id:invocation.lang.php 20042 2008-05-09 01:10:00Z aj.tarachanowicz@openx.org $
*/

$conf = $GLOBALS['_MAX']['CONF'];
$name = (!empty($GLOBALS['_MAX']['PREF']['name'])) ? $GLOBALS['_MAX']['PREF']['name'] : MAX_PRODUCT_NAME;

$words = array(
    'Connection error, please send your data again' => 'Connection error, please send your data again',
    'User do not exists, please try again with different account' => 'User do not exists, please try again with different account',
    'Wrong password, please try again' => 'Wrong password, please try again',
    'Such email already exists, please try again using different e-mail address' => 'Such email already exists, please try again using different e-mail address',
    'Invalid verification hash, please recheck you confirmation mail' => 'Invalid verification hash, please recheck you confirmation mail',
    'User not authenticated, please correct your credentials' => 'User not authenticated, please correct your credentials',
    'User not authenticated, please correct your credentials' => 'User not authenticated, please correct your credentials',
    'Error while communicating with server, error code %d' => 'Error while communicating with server, error code %d',
    'Platform hash doesn\'t exist, please execute sync process' => 'Platform hash doesn\'t exist, please execute sync process',
    'strEmailSsoConfirmationSubject' => "{superUserName} has given you access to an ".$name ." account, please complete your sign up",
    'strEmailSsoConfirmationBody' => "Hello {contactName}

You have been given access to an ".$name." account by {superUserName}, to confirm your details and complete the sign up process please click on the link below
{url}

Please contact us at info@openx.org if you have any questions

Thanks
The OpenX Team",
    'strRegistrationRequiredInfo' => "<br><br>Welcome <b>{userName}</b><br/><hr />" .
        "<br /><br />You do not currently have an account on the hosted version of OpenX.<br /> " .
        "If you want to create one please sign up <a href='http://www.openx.org/hosted'>here</a>.<br /><br />" .
        "To login as a different user click <a href='logout.php'>here</a>.<br />"
);

?>
