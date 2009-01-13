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
 * @package    OpenX
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */

// Require Zone Service Implementation
require_once MAX_PATH . '/www/api/v1/xmlrpc/ZoneServiceImpl.php';

/**
 * Base Zone Service
 *
 */
class BaseZoneService
{
    /**
     * Reference to zone Service implementation.
     *
     * @var ZoneServiceImpl $_oZoneServiceImp
     */
    var $_oZoneServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    function BaseZoneService()
    {
        $this->_oZoneServiceImp = new ZoneServiceImpl();
    }
}

?>