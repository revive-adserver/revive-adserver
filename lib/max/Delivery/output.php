<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
 * handles output that cannot be captured by buffering
 * reason: headers/cookies cause problems in simulations
 *
 * am looking for a better way of doing this
 * possibly by using a pecl extension that allows function overrides
 *
 * if the var check causes problems then
 * just comment out the if wrapper
 *
 * @author Monique Szpak
 * @package Max
 *
 */
global $is_simulation;

if (!$is_simulation)
{
    /**
     * set a cookie (for real)
     *
     */
    function MAX_setcookie($name, $value, $expire, $path, $domain)
    {
        setcookie($name, $value, $expire, $path, $domain);
    }

    /**
     * send a header (for real)
     *
     */
    function MAX_header($value)
    {
        header($value);
    }
}
else
{
    /**
     * assign a cookie to the global cookie array
     * for simulation purposes ONLY
     *
     */
    function MAX_setcookie($name, $value, $expire, $path, $domain)
    {
        $_COOKIE[$name] = $value;
    }

    /**
     * ignore headers
     * for simulation purposes ONLY
     *
     */
    function MAX_header($value)
    {
        // do nothing
    }
}
?>