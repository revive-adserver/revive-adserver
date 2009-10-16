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
 * Defines objects which allow to persist key value pairs.
 * 
 * @package OX_Admin_UI
 * @author Bernard Lange <bernard@openx.org> 
 */
interface OX_Admin_UI_Storage
{
    /**
     * Retrieves value of the given property from the storage.
     *
     * @param string $propertyName
     * @return mixed value of the property
     */
    public function get($propertyName);
    
    
    /**
     * Sets the value of the given property in the storage.
     *
     * @param string $propertyName
     * @param mixed $value
     */
    public function set($propertyName, $value);
}

?>
