<?php

/*
 *    Copyright (c) 2009 Bouncing Minds - Option 3 Ventures Limited
 *
 *    This file is part of the Regions plug-in for Flowplayer.
 *
 *    The Regions plug-in is free software: you can redistribute it
 *    and/or modify it under the terms of the GNU General Public License
 *    as published by the Free Software Foundation, either version 3 of
 *    the License, or (at your option) any later version.
 *
 *    The Regions plug-in is distributed in the hope that it will be
 *    useful, but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with the plug-in.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @package    Plugin
 * @subpackage vastServeVideoPlayer
 */

MAX_commonRegisterGlobalsArray( array('file_to_serve' ));

if ( $file_to_serve
    && strpos($file_to_serve, '..') === false){
    $pwd = dirname(__FILE__);
    if ( strpos( $file_to_serve, 'swf') !== false) {
        header("content-type: application/x-shockwave-flash");
    }

    echo file_get_contents( $pwd . '/' . $file_to_serve);
}
else {
    echo "no 'file_to_serve' parameter supplied";
}
