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
 * Algorithm::Dependency::Ordered implements the most common variety of
 * Algorithm::Dependency, the one in which the dependencies of an item must
 * be acted upon before the item itself can be acted upon.
 *
 * In use and semantics, this should be used in exactly the same way as for the
 * main parent class. Please note that the output of the depends() method is
 * NOT changed, as the order of the depends is not assumed to be important.
 * Only the output of the schedule() method is modified to ensure the correct
 * order.
 *
 * Ported from CPAN:
 * http://search.cpan.org/~adamk/Algorithm-Dependency-1.106/lib/Algorithm/Dependency/Ordered.pm
 *
 * @author Radek Maciaszek <radek.maciaszek@openx.org>
 */

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency.php';

class OA_Algorithm_Dependency_Ordered extends OA_Algorithm_Dependency
{
    /**
     * Returns the dependencies sorted in correct order.
     *
     * @param array $items
     * @return array
     */
    function schedule($items = array())
    {
        if (!$items) {
            return false;
        }
        $rv = parent::schedule($items);
        if (!$rv) {
            return false;
        }
        $errorMarker = '';
        $selected = $this->selected;
        $itemsIds = $this->source->getItemsIds();

        while ($id = array_shift($rv)) {
            // have we checked every item in the stack
            if ($id == $errorMarker) {
                return false;
            }
            // are there any un-met dependencies
            $item = $this->source->getItem($id);
            if (!$item) {
                if ($this->ignoreOrphans) {
                    continue;
                }
                return false;
            }
            $missing = array_diff($item->getDependencies(), $selected);
            if ($this->ignoreOrphans) {
                $missing = array_intersect($itemsIds, $missing);
            }

            if ($missing) {
                if (!$errorMarker) {
                    $errorMarker = $id;
                    $rv[] = $id;
                    continue;
                }
            }
            // All dependencies have been met. Add the item to the schedule
            // and to the selected index
            $schedule[$id] = $id;
            $selected[$id] = $id;
            $errorMarker = '';
        }
        return $schedule;
    }

}

?>