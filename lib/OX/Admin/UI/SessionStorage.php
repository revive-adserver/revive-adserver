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

require_once MAX_PATH . '/lib/OX/Admin/UI/Storage.php';

/**
 * @package OX_Admin_UI
 * @author Bernard Lange <bernard@openx.org> 
 */
class OX_Admin_UI_SessionStorage
    implements OX_Admin_UI_Storage
{
    private $id;
    private $path;
    
    function __construct($id = null, $path = null)
    {
        $this->id = isset($id)? $id : 'session_id';    
        $this->path = $path;
    }
    
    
    /**
     * Retrieves value of the given property from the storage.
     *
     * @param string $propertyName
     * @return mixed value of the property
     */
    public function get($propertyName)
    {
        $this->initStorage();
        $value = $_SESSION[$propertyName];
        
        return $value;
    }
    
    /**
     * Sets the value of the given property in the storage.
     *
     * @param string $propertyName
     * @param mixed $value
     */
    public function set($propertyName, $value)
    {
        $this->initStorage();
        $_SESSION[$propertyName] = $value;
    }
    
    
    protected function initStorage()
    {
        session_set_cookie_params(0);
        if ($this->id) {
            session_name($this->id); 
        }
        session_start();
    }
    
    
    public function destroy()
    {
        $this->initStorage();
        $_SESSION = array();
        session_set_cookie_params(0);
        session_name($this->id); 
        session_destroy();
        setcookie($this->id, '');
    }
}

?>
