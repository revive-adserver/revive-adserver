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


/**
 * The Algorithm::Dependency::Source class provides an abstract parent class for
 * implementing sources for the heirachy data the algorithm will use. For an
 * example of an implementation of this, see
 * Algorithm::Dependency::Source::HoA
 *
 * Based on CPAN module:
 * http://search.cpan.org/~adamk/Algorithm-Dependency-1.106/lib/Algorithm/Dependency/Source.pm
 *
 * @author Radek Maciaszek <radek.maciaszek@openx.org>
 */

require_once MAX_PATH . '/lib/OA/Algorithm/Dependency/Item.php';

abstract class OA_Algorithm_Dependency_Source
{
    protected $loaded = false;
    protected $itemsHash = array();
    protected $itemsQueue = array();

    /**
     * The load() method is the public method used to actually load the items from
     * their storage location into the the source object. The method will
     * automatically called, as needed, in most circumstances. You would generally
     * only want to use load() manually if you think there may be some uncertainty
     * that the source will load correctly, and want to check it will work.
     *
     * @return boolean  Returns true if the items are loaded successfully,
     *                  or false on error.
     */
    function load()
    {
        if ($this->loaded) {
            $this->loaded = false;
            $this->itemsQueue = array();
            $this->itemsHash = array();
        }

        $items = $this->_loadItemList();
        if (!$items) {
            return $items;
        }
        if (!is_array($items)) {
            throw new Exception('_loadItemList() did not return an Algorithm_Dependency_Item array');
        }

        foreach ($items as $item) {
            if (isset($this->itemsHash[$item->getId()])) {
                // duplicate entry
                return false;
            }
            $this->itemsHash[$item->getId()] = $item;
            $this->itemsQueue[] = $item;
        }
        $this->loaded = true;
        return true;
    }

    /**
     * The getItem() method fetches and returns the item object specified by the
     * name argument.
     *
     * Returns an Algorithm::Dependency::Item object on success, or false if
     * the named item does not exist in the source.
     *
     * @param mixed $id
     * @return OA_Algorithm_Dependency_Item  Returns an Item or false if it
     *                                       doesn't exist in the source
     */
    function getItem($id)
    {
        if (!$this->checkLoaded() || !isset($this->itemsHash[$id])) {
            return false;
        }
        return $this->itemsHash[$id];
    }

    /**
     * The getItems() method returns, as a list of objects, all of the items
     * contained in the source. The item objects will be returned in the same order
     * as that in the storage location.
     *
     * Returns a list of Algorithm::Dependency::Item objects on success, or
     * false on error.
     *
     * @return array
     */
    function getItems()
    {
        if (!$this->checkLoaded()) {
            return false;
        }
        return $this->itemsQueue;
    }

    /**
     * The getItems() method returns, as a list of items ids, all of the items
     * contained in the source. The item objects will be returned in the same order
     * as that in the storage location.
     *
     * @return array  Returns an array of ids on success, or false on error
     */
    function getItemsIds()
    {
        if (!$this->checkLoaded()) {
            return false;
        }
        $itemsIds = array();
        foreach($this->itemsQueue as $item) {
            $itemsIds[] = $item->getId();
        }
        return $itemsIds;
    }

    /**
     * By default, we are leniant with missing dependencies if the item is never
     * used. For systems where having a missing dependency can be very bad, the
     * getMissingDependencies() method checks all Items to make sure their
     * dependencies exist.
     *
     * If there are any missing dependencies, returns a reference to an array of
     * their ids. If there are no missing dependencies, returns empty array. Returns
     * false on error.
     *
     * @return mixed
     */
    function getMissingDependencies()
    {
        if (!$this->checkLoaded()) {
            return false;
        }
        $dependencies = array();
        foreach ($this->itemsQueue as $item) {
            $dependencies = array_merge($dependencies, $item->getDependencies());
        }
        return array_diff($dependencies, array_keys($this->itemsHash));
    }

    /**
     * Lazy loading
     *
     * @return boolean  True if data is already loaded or was loaded succesfully or false
     *                  if any error occured.
     */
    function checkLoaded()
    {
        if (!$this->loaded) {
            return $this->load();
        }
        return true;
    }

    /**
     * Catch unimplemented methods in subclasses
     *
     */
    abstract function _loadItemList();

}

?>