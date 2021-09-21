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

/**
 * Source for a HASH of ARRAYs
 *
 * Based on CPAN class:
 * http://search.cpan.org/~adamk/Algorithm-Dependency-1.106/lib/Algorithm/Dependency/Source/HoA.pm
 *
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
    private $hash = [];

    public function __construct($deps = [])
    {
        $this->hash = $deps;
    }

    public function _loadItemList()
    {
        $items = [];
        foreach ($this->hash as $id => $dependency) {
            if (!is_array($dependency)) {
                $id = $dependency;
                $dependency = [];
            }
            $items[] = new OA_Algorithm_Dependency_Item($id, $dependency);
        }
        return $items;
    }
}
