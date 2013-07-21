<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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
