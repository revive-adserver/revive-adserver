<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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
 * @package    OpenXDll
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 */

// Require the base Info class.
require_once 'Info.php';

/**
 * The OA_Dll_UserInfo class extends the base OA_Info class and
 * contains information about the user.
 *
 */

class OA_Dll_UserInfo extends OA_Info
{
    /**
     * This fields provides the ID of the user
     *
     * @var int
     */
    var $userId;

    /**
     * This option provides the name of the contact for the user.
     *
     * @var string $contactName
     */
    var $contactName;

    /**
     * This field provides the email address of the user.
     *
     * @var string $emailAddress
     */
    var $emailAddress;

    /**
     * This option provides the username of the user.
     *
     * @var string $username
     */
    var $username;

    /**
     * This field provides the password of the user.
     *
     * @var string $password
     */
    var $password;

    /**
     * This field provides the default account ID of the user.
     *
     * @var int $defaultAccountId
     */
    var $defaultAccountId;

    /**
     * This field provides the status of the user.
     *
     * @var int $active
     */
    var $active;

    function getFieldsTypes()
    {
        return array(
                    'userId' => 'integer',
                    'contactName' => 'string',
                    'emailAddress' => 'string',
                    'username' => 'string',
                    'password' => 'string',
                    'defaultAccountId' => 'integer',
                    'active' => 'integer',
                );
    }
}

?>