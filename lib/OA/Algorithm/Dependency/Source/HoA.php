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
 * Source for a HASH of ARRAYs
 *
 * Based on CPAN class:
 * http://search.cpan.org/~adamk/Algorithm-Dependency-1.106/lib/Algorithm/Dependency/Source/HoA.pm
 *
 * @author Radek Maciaszek <radek.maciaszek@openx.org>
 */

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Source.php';

/**
 * Algorithm::Dependency::Source::HoA implements a
 * Algorithm::Dependency::Source where the items names are provided
 * in the most simple form, an array.
 *
 * The basic data structure:
 * $deps = array {
 *     foo => array('bar', 'baz'),
 *     bar => array(),
 *     baz => array('bar'),
 *     bar, // same as: bar => array()
 * }
 *
 * Create the source from it
 * $source = OA_Algorithm_Dependency_Source_HoA($deps);
 *
 */
class OA_Algorithm_Dependency_Source_HoA extends OA_Algorithm_Dependency_Source
{
    private $hash = array();

    function __construct($deps = array())
    {
        $this->hash = $deps;
    }

    function _loadItemList()
    {
        $items = array();
        foreach ($this->hash as $id => $dependency) {
            if (!is_array($dependency)) {
                $id = $dependency;
                $dependency = array();
            }
            $items[] = new OA_Algorithm_Dependency_Item($id, $dependency);
        }
        return $items;
    }

}

?>