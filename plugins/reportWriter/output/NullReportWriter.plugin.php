<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
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

require_once MAX_PATH . '/lib/max/Plugin/Common.php';

/**
 * Report writer base class for Openads.
 *
 * (Not abstract, used for cases where no writer exists.)
 *
 * @package    MaxPlugin
 * @subpackage ReportWriter
 * @author     Rob Hunter <roh@m3.net>
 */
class Plugins_ReportWriter_Output_NullReportWriter extends MAX_Plugin_Common
{

    function openWithFilename($filename) {}

    function createReportWorksheet($worksheet, $name, $params) {}

    function createReportSection($worksheet, $title, $headers, $data, $width) {}

    function closeAndSend() {}

}

?>
