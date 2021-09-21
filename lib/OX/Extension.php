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

class OX_Extension
{
    public $aExtensions = [];

    public function __construct()
    {
    }

    /**
     * acquire the extensions event handling class if exists
     * execute the tasks
     *
     * @param string $event
     * @return boolean
     */
    public function runTasksForEvent($event)
    {
        $result = true;
        $this->aExtensions = array_unique($this->aExtensions);
        foreach ($this->aExtensions as $extension) {
            $path = LIB_PATH . '/Extension/';
            $file = $extension . '.php';
            if (file_exists($path . $file)) {
                $class = 'OX_Extension_' . $extension;
                require_once($path . $file);
                if (class_exists($class)) {
                    $oExtension = new $class();
                    if (is_object($oExtension) && is_a($oExtension, $class)) {
                        $method = 'runTasks' . $event;
                        if (method_exists($oExtension, $method)) {
                            $result = $oExtension->$method();
                        }
                    }
                }
            }
        }
        return $result;
    }

    public function setAllExtensions()
    {
        $this->aExtensions = $this->getAllExtensionsArray();
    }

    /**
     * a list of all known plugins
     * compiled by scanning the plugins folder
     *
     * @return unknown
     */
    public function getAllExtensionsArray()
    {
        $aResult[] = 'admin';
        $aConf = $GLOBALS['_MAX']['CONF']['pluginPaths'];
        $pkgPath = rtrim(MAX_PATH . $aConf['packages'], DIRECTORY_SEPARATOR);
        $dh = opendir(MAX_PATH . $aConf['plugins']);
        while (false !== ($file = readdir($dh))) {
            if ((substr($file, 0, 1) != '.') &&
                 ($file != '..') &&
                 (rtrim(MAX_PATH . $aConf['plugins'] . $file, DIRECTORY_SEPARATOR) != $pkgPath)) {
                $aResult[] = $file;
            }
        }
        closedir($dh);
        return $aResult;
    }
}
