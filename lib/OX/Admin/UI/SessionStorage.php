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
 */
class OX_Admin_UI_SessionStorage implements OX_Admin_UI_Storage
{
    private $id;
    private $path;

    function __construct($id = null, $path = null)
    {
        if ('cli' !== PHP_SAPI && 'files' === ini_get('session.save_handler')) {
            // Gotta make sure we get only the actual path, respecting PHP's M and N options,
            // for example this var might hold "3;644;/home/session". For full reference:
            // http://php.net/manual/en/session.configuration.php#ini.session.save-path
            $s_array = explode(';',session_save_path());
            $path = end($s_array);
            if (!empty($path) && !is_writable($path)) {
                // We can only trust this if open basedir is not enabled
                if (empty(ini_get('open_basedir'))) {
                    echo htmlspecialchars("The session save path '{$path}' is not writable.");
                    exit;
                }
            }
        }

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
        if ($this->id && $this->id !== session_name()) {
            session_name($this->id);
        }
        session_start();
    }


    public function destroy()
    {
        $this->initStorage();
        $_SESSION = array();
        session_destroy();
    }
}

?>
