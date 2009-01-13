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
 * A script which defines the global {insert} function for Smarty
 */

/**
 * Include the custom header script
 *
 * @return string
 */
function insert_OA_Admin_UI_CustomHeader()
{
    $aConf = $GLOBALS['_MAX']['CONF'];

    if (!empty($aConf['ui']['headerFilePath'])) {
        ob_start();
        include ($aConf['ui']['headerFilePath']);
        return ob_get_clean();
    }

    return '';
}

/**
 * Include the custom footer script
 *
 * @return string
 */
function insert_OA_Admin_UI_CustomFooter()
{
    $aConf = $GLOBALS['_MAX']['CONF'];

    if (!empty($aConf['ui']['footerFilePath'])) {
        ob_start();
        include ($aConf['ui']['footerFilePath']);

        $content = ob_get_clean();

        return '
            <tr>
                <td width="40" height="20">&nbsp;</td>
                <td height="20">
                    '.$content.'
                </td>
            </tr>
        ';
    }

    return '';
}

?>
