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

class OX_Extension
{
    var $aExtensions = array();

    function __construct()
    {

    }

    /**
     * acquire the extensions event handling class if exists
     * execute the tasks
     *
     * @param string $event
     * @return boolean
     */
    function runTasksForEvent($event)
    {
        $result = true;
        $this->aExtensions = array_unique($this->aExtensions);
        foreach ($this->aExtensions as $extension)
        {
            $path = LIB_PATH.'/Extension/';
            $file = $extension.'.php';
            if (file_exists($path.$file))
            {
                $class = 'OX_Extension_'.$extension;
                require_once($path.$file);
                if (class_exists($class))
                {
                    $oExtension = new $class();
                    if (is_object($oExtension) && is_a($oExtension, $class))
                    {
                        $method = 'runTasks'.$event;
                        if (method_exists($oExtension, $method))
                        {
                            $result = $oExtension->$method();
                        }
                    }
                }
            }
        }
        return $result;
    }

    function setAllExtensions()
    {
        $this->aExtensions = $this->getAllExtensionsArray();
    }

    /**
     * a list of all known plugins
     * compiled by scanning the plugins folder
     *
     * @return unknown
     */
    function getAllExtensionsArray()
    {
        $aResult[] = 'admin';
        $aConf = $GLOBALS['_MAX']['CONF']['pluginPaths'];
        $pkgPath = rtrim(MAX_PATH.$aConf['packages'],DIRECTORY_SEPARATOR);
        $dh = opendir(MAX_PATH.$aConf['plugins']);
        while (false !== ($file = readdir($dh)))
        {
            if ( (substr($file,0,1) != '.') &&
                 ($file != '..') &&
                 (rtrim(MAX_PATH.$aConf['plugins'].$file,DIRECTORY_SEPARATOR) != $pkgPath))
            {
                $aResult[] = $file;
            }
        }
        closedir($dh);
        return $aResult;
    }


}

?>
