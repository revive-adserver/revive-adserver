<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
@version $Id$
*/

class TrackerVariable
{
    var $id;
    var $name;
    var $description;
    var $value;
    var $purpose;
    var $hidden;

    /**
     * Static factory-style method
     */
    /* static */ function createFromArray($array)
    {
        $var = new TrackerVariable();
        $var->id = $array['id'];
        $var->name = $array['name'];
        $var->description = $array['description'];
        $var->value = $array['value'];
        $var->purpose = $array['purpose'];
        $var->hidden = $array['hidden'] == 't';

        if (!is_null($array['visible'])) {
            $var->hidden = !$array['visible'];
        }

        return $var;
    }
}
?>
