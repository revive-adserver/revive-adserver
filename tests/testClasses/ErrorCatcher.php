<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

class SimpletestErrorCatcher
{
    var $oRunner;
    var $active = true;

    function SimpletestErrorCatcher(&$oRunner)
    {
        $this->oRunner = &$oRunner;
        ob_start();
        register_shutdown_function(array(&$this, 'shutdown'));
    }

    function deactivate()
    {
        $this->active = false;
    }

    function shutdown()
    {
        if ($this->active) {
            $buffer = ob_get_clean();
            if (strlen($buffer)) {
                echo "<h1>Warning: unclean exit</h1>\n".$buffer;
                die(1);
            }
        }
    }
}

?>
