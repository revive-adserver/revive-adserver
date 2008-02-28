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
    // sso confirmation page (sso-accounts.php)
    'Server error: ' => 'Server error: ',
    'Error while updating an account. Please try again.' => 'Error while updating an account. Please try again.',
    'Your username or password are not correct. Please try again.' => 'Your username or password are not correct. Please try again.',
    "Error. There is no matching user. Check if your link is correct or contact your OpenX administrator." => "Error. There is no matching user. Check if your link is correct or contact your OpenX administrator.",
    'User name' => 'User name',
    'Enter user name' => 'Enter user name',
    'Password' => 'Password',
    'Enter password' => 'Enter password',
    'Enter details for your new OpenX account' => 'Enter details for your new OpenX account',
    'Email' => 'Email',
    'Desired user name' => 'Desired user name',
    'Enter desired user name' => 'Enter desired user name',
    'Enter password' => 'Enter password',
    'Password' => 'Password',
    'Re-enter password' => 'Re-enter password',
    'Re-enter the same password' => 'Re-enter the same password',
    'Could not create your new OpenX account. Please try again.' => 'Could not create your new OpenX account. Please try again.',
    'Server error: ' => 'Server error: ',
    // plugins translations
    'I have read and agree to the OpenX' => 'I have read and agree to the OpenX',
    'Terms and Conditions' => 'Terms and Conditions',
    'You must agree to the Terms and Conditions' => 'You must agree to the Terms and Conditions',
    'Data Privacy Policy' => 'Data Privacy Policy',
    'You must agree to the Data Privacy Policy' => 'You must agree to the Data Privacy Policy',
    'Accept invitation & create account' => 'Accept invitation & create account',
    'To create an OpenX account, you must choose a user name that is available' => 'To create an OpenX account, you must choose a user name that is available',
    // lib/templates/admin/sso-start.html
    'Welcome' => 'Welcome',
    'invited you to use OpenX. To accept this invitation,' => 'invited you to use OpenX. To accept this invitation,',
    'enter user name and password of your existing OpenX account' => 'enter user name and password of your existing OpenX account',
    'the one you use for e.g. OpenX Forum) or' => 'the one you use for e.g. OpenX Forum) or',
    'create a new OpenX account' => 'create a new OpenX account',
    'Do you already have an OpenX account?' => 'Do you already have an OpenX account?',
    'Yes, I want to use my existing account' => 'Yes, I want to use my existing account',
    'No, I want to create a new account' => 'No, I want to create a new account',
    '' => '',
    '' => '',
    // plugins specific translations
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
