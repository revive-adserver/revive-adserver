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
 * Base class for implementing various dependency trees
 *
 * The Algorithm::Dependency is ported from CPAN:
 * http://search.cpan.org/~adamk/Algorithm-Dependency-1.106/lib/Algorithm/Dependency.pm
 *
 * @TODO Add a description of use and basic use cases here.
 *
 */

class OA_Algorithm_Dependency
{
    /**
     * @var OA_Algorithm_DependencySource
     */
    protected $source;
    protected $selected = [];

    /**
     * Normally, the item source is expected to be largely perfect and error free.
     * An 'orphan' is an item name that appears as a dependency of another item, but
     * doesn't exist, or has been deleted.
     *
     * By providing the ignoreOrphans flag, orphans are simply ignored. Without
     * the ignoreOrphans flag, an error will be returned if an orphan is found.
     *
     * @var boolean
     */
    protected $ignoreOrphans;

    /**
     * The constructor creates a new context object for the dependency algorithms to
     * act in. It takes as argument a series of options for creating the object.
     *
     * @param OA_Algorithm_DependencySource $source  The only compulsory option is the source of the dependency items.
     *                                               This is an object of a subclass of Algorithm::Dependency::Source.
     *                                               In practical terms, this means you will create the source object
     *                                               before creating the Algorithm::Dependency object.
     * @param array $selected  [ 'A', 'B', 'C', etc... ]
     *                         The selected option provides a list of those items that have already been
     *                         'selected', acted upon, installed, or whatever. If another item depends on one
     *                         in this list, we don't have to include it in the output of the schedule() or
     *                         depends() methods.
     * @param boolean $ignoreOrphans  Normally, the item source is expected to be largely perfect and error free.
     *                                An 'orphan' is an item name that appears as a dependency of another item, but
     *                                doesn't exist, or has been deleted.
     * @return returns a new Algorithm::Dependency
     */
    public function __construct(OA_Algorithm_Dependency_Source $source, $selected = [], $ignoreOrphans = false)
    {
        $this->source = $source;
        $this->ignoreOrphans = $ignoreOrphans;

        foreach ($selected as $id) {
            if (!$source->getItem($id)) {
                return false;
            }
            // add to selected index
            $this->selected[$id] = $id;
        }
    }

    /**
     * Given a list of one or more item names, the depends() method will return
     * an array containing a list of the names of all the OTHER
     * items that also have to be selected to meet dependencies.
     *
     * That is, if item A depends on B and C then the depends() method would
     * return a reference to an array with B and C. ( [ 'B', 'C' ] )
     *
     * If multiple item names are provided, the same applies. The list returned
     * will not contain duplicates.
     *
     * @param array $items  The array of items we need to check dependencies for.
     * @return array  The method returns a reference to an array of item names on success, a
     *                reference to an empty array if no other items are needed, or false
     *                on error.
     */
    public function depends($items = [])
    {
        $checked = [];
        $depends = [];
        $stack = $items;
        $itemsKeys = array_flip($items);
        while ($id = array_shift($stack)) {
            $item = $this->source->getItem($id);
            if (!$item) {
                if ($this->ignoreOrphans) {
                    continue;
                }
                return false;
            }
            $checked[$id] = 1;
            $deps = $item->getDependencies();
            foreach ($deps as $dependsOnId) {
                if (!isset($checked[$dependsOnId])) {
                    $stack[] = $dependsOnId;
                }
            }
            if (!isset($itemsKeys[$id])) {
                $depends[$id] = $id;
            }
        }
        // remove any items already selected
        $depends = array_diff($depends, $this->selected);
        sort($depends);
        return $depends;
    }

    /**
     * Given a list of one or more item names, the depends() method will return,
     * as a reference to an array, the ordered list of items you should act upon.
     *
     * This would be the original names provided, plus those added to satisfy
     * dependencies, in the prefered order of action. For the normal algorithm,
     * where order it not important, this is alphabetical order. This makes it
     * easier for someone watching a program operate on the items to determine
     * how far you are through the task and makes any logs easier to read.
     *
     * If any of the names you provided in the arguments is already selected, it
     * will not be included in the list.
     *
     * @param array $items  The array of items we need to check dependencies for.
     * @return array  The method returns an array of item names on success,
     *                an empty array if no items need to be acted upon, or false
     *                on error.
     */
    public function schedule($items = [])
    {
        $depends = $this->depends($items);
        if (!is_array($depends)) {
            return false;
        }
        // return combined list, removing any items already selected
        $items = array_combine(array_values($items), $items);
        $combined = array_merge($items, $depends);
        array_unique($combined);

        // remove any items already selected
        $combined = array_diff($combined, $this->selected);

        sort($combined);
        return $combined;
    }

    /**
     * The scheduleAll() method acts the same as the schedule() method, but
     * returns a schedule that selected all the so-far unselected items.
     *
     * @see schedule()
     * @return array
     */
    public function scheduleAll()
    {
        return $this->schedule($this->source->getItemsIds());
    }
}
