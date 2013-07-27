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
