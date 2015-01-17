<?php
// +---------------------------------------------------------------------+
// | PHP Version 4                                                       |
// +---------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group            |
// +---------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is       |
// | available at through the world-wide-web at                          |
// | http://www.php.net/license/2_02.txt.                                |
// | If you did not receive a copy of the PHP license and are unable to  |
// | obtain it through the world-wide-web, please send a note to         |
// | license@php.net so we can mail you a copy immediately.              |
// +---------------------------------------------------------------------+
// | Author: Bertrand Mansion <bmansion@mamasam.com>                     |
// +---------------------------------------------------------------------+

require_once 'Config.php';

/**
* Interface for Config containers
*
* @author   Bertrand Mansion <bmansion@mamasam.com>
* @package  Config
*/
class Config_Container {

    /**
    * Container object type
    * Ex: section, directive, comment, blank
    * @var  string
    */
    var $type;

    /**
    * Container object name
    * @var  string
    */
    var $name = '';

    /**
    * Container object content
    * @var  string
    */
    var $content = '';

    /**
    * Container object children
    * @var  array
    */
    var $children = array();

    /**
    * Reference to container object's parent
    * @var  object
    */
    var $parent;

    /**
    * Array of attributes for this item
    * @var  array
    */
    var $attributes;

    /**
    * Unique id to differenciate nodes
    *
    * This is used to compare nodes
    * Will not be needed anymore when this class will use ZendEngine 2
    *
    * @var  int
    */
    var $_id;

    /**
    * Constructor
    *
    * @param  string  $type       Type of container object
    * @param  string  $name       Name of container object
    * @param  string  $content    Content of container object
    * @param  array   $attributes Array of attributes for container object
    */
    function __construct($type = 'section', $name = '', $content = '', $attributes = null)
    {
        $this->type       = $type;
        $this->name       = $name;
        $this->content    = $content;
        $this->attributes = $attributes;
        $this->parent     = null;
        $this->_id        = uniqid($name.$type, true);
    } // end constructor

    /**
    * Create a child for this item.
    * @param  string  $type       type of item: directive, section, comment, blank...
    * @param  mixed   $item       item name
    * @param  string  $content    item content
    * @param  array   $attributes item attributes
    * @param  string  $where      choose a position 'bottom', 'top', 'after', 'before'
    * @param  object  $target     needed if you choose 'before' or 'after' for where
    * @return object  reference to new item or Pear_Error
    */
    function &createItem($type, $name, $content, $attributes = null, $where = 'bottom', $target = null)
    {
        $item = new Config_Container($type, $name, $content, $attributes);
        $result =& $this->addItem($item, $where, $target);
        return $result;
    } // end func &createItem

    /**
    * Adds an item to this item.
    * @param  object   $item      a container object
    * @param  string   $where     choose a position 'bottom', 'top', 'after', 'before'
    * @param  object   $target    needed if you choose 'before' or 'after' in $where
    * @return mixed    reference to added container on success, Pear_Error on error
    */
    function &addItem(&$item, $where = 'bottom', $target = null)
    {
        if ($this->type != 'section') {
            return PEAR::raiseError('Config_Container::addItem must be called on a section type object.', null, PEAR_ERROR_RETURN);
        }
        if (is_null($target)) {
            $target =& $this;
        }
        if (strtolower(get_class($target)) != 'config_container') {
            return PEAR::raiseError('Target must be a Config_Container object in Config_Container::addItem.', null, PEAR_ERROR_RETURN);
        }

        switch ($where) {
            case 'before':
                $index = $target->getItemIndex();
                break;
            case 'after':
                $index = $target->getItemIndex()+1;
                break;
            case 'top':
                $index = 0;
                break;
            case 'bottom':
                $index = -1;
                break;
            default:
                return PEAR::raiseError('Use only top, bottom, before or after in Config_Container::addItem.', null, PEAR_ERROR_RETURN);
        }
        if (isset($index) && $index >= 0) {
            array_splice($this->children, $index, 0, 'tmp');
        } else {
            $index = count($this->children);
        }
        $this->children[$index] =& $item;
        $this->children[$index]->parent =& $this;

        return $item;
    } // end func addItem

    /**
    * Adds a comment to this item.
    * This is a helper method that calls createItem
    *
    * @param  string    $content        Object content
    * @param  string    $where          Position : 'top', 'bottom', 'before', 'after'
    * @param  object    $target         Needed when $where is 'before' or 'after'
    * @return object  reference to new item or Pear_Error
    */
    function &createComment($content = '', $where = 'bottom', $target = null)
    {
        return $this->createItem('comment', null, $content, null, $where, $target);
    } // end func &createComment

    /**
    * Adds a blank line to this item.
    * This is a helper method that calls createItem
    *
    * @return object  reference to new item or Pear_Error
    */
    function &createBlank($where = 'bottom', $target = null)
    {
        return $this->createItem('blank', null, null, null, $where, $target);
    } // end func &createBlank

    /**
    * Adds a directive to this item.
    * This is a helper method that calls createItem
    *
    * @param  string    $name           Name of new directive
    * @param  string    $content        Content of new directive
    * @param  mixed     $attributes     Directive attributes
    * @param  string    $where          Position : 'top', 'bottom', 'before', 'after'
    * @param  object    $target         Needed when $where is 'before' or 'after'
    * @return object  reference to new item or Pear_Error
    */
    function &createDirective($name, $content, $attributes = null, $where = 'bottom', $target = null)
    {
        return $this->createItem('directive', $name, $content, $attributes, $where, $target);
    } // end func &createDirective

    /**
    * Adds a section to this item.
    *
    * This is a helper method that calls createItem
    * If the section already exists, it won't create a new one.
    * It will return reference to existing item.
    *
    * @param  string    $name           Name of new section
    * @param  array     $attributes     Section attributes
    * @param  string    $where          Position : 'top', 'bottom', 'before', 'after'
    * @param  object    $target         Needed when $where is 'before' or 'after'
    * @return object  reference to new item or Pear_Error
    */
    function &createSection($name, $attributes = null, $where = 'bottom', $target = null)
    {
        return $this->createItem('section', $name, null, $attributes, $where, $target);
    } // end func &createSection

    /**
    * Tries to find the specified item(s) and returns the objects.
    *
    * Examples:
    * $directives =& $obj->getItem('directive');
    * $directive_bar_4 =& $obj->getItem('directive', 'bar', null, 4);
    * $section_foo =& $obj->getItem('section', 'foo');
    *
    * This method can only be called on an object of type 'section'.
    * Note that root is a section.
    * This method is not recursive and tries to keep the current structure.
    * For a deeper search, use searchPath()
    *
    * @param  string    $type        Type of item: directive, section, comment, blank...
    * @param  mixed     $name        Item name
    * @param  mixed     $content     Find item with this content
    * @param  array     $attributes  Find item with attribute set to the given value
    * @param  int       $index       Index of the item in the returned object list. If it is not set, will try to return the last item with this name.
    * @return mixed  reference to item found or false when not found
    * @see &searchPath()
    */
    function &getItem($type = null, $name = null, $content = null, $attributes = null, $index = -1)
    {
        if ($this->type != 'section') {
            return PEAR::raiseError('Config_Container::getItem must be called on a section type object.', null, PEAR_ERROR_RETURN);
        }
        if (!is_null($type)) {
            $testFields[] = 'type';
        }
        if (!is_null($name)) {
            $testFields[] = 'name';
        }
        if (!is_null($content)) {
            $testFields[] = 'content';
        }
        if (!is_null($attributes) && is_array($attributes)) {
            $testFields[] = 'attributes';
        }

        $itemsArr = array();
        $fieldsToMatch = count($testFields);
        for ($i = 0, $count = count($this->children); $i < $count; $i++) {
            $match = 0;
            reset($testFields);
            foreach ($testFields as $field) {
                if ($field != 'attributes') {
                    if ($this->children[$i]->$field == ${$field}) {
                        $match++;
                    }
                } else {
                    // Look for attributes in array
                    $attrToMatch = count($attributes);
                    $attrMatch = 0;
                    foreach ($attributes as $key => $value) {
                        if (isset($this->children[$i]->attributes[$key]) &&
                            $this->children[$i]->attributes[$key] == $value) {
                            $attrMatch++;
                        }
                    }
                    if ($attrMatch == $attrToMatch) {
                        $match++;
                    }
                }
            }
            if ($match == $fieldsToMatch) {
                $itemsArr[] =& $this->children[$i];
            }
        }
        if ($index >= 0) {
            if (isset($itemsArr[$index])) {
                return $itemsArr[$index];
            } else {
                return false;
            }
        } else {
            if ($count = count($itemsArr)) {
                return $itemsArr[$count-1];
            } else {
                return false;
            }
        }
    } // end func &getItem

    /**
    * Finds a node using XPATH like format.
    *
    * The search format is an array:
    * array(item1, item2, item3, ...)
    *
    * Each item can be defined as the following:
    * item = 'string' : will match the container named 'string'
    * item = array('string', array('name' => 'xyz'))
    * will match the container name 'string' whose attribute name is equal to "xyz"
    * For example : <string name="xyz">
    *
    * @param    mixed   Search path and attributes
    *
    * @return   mixed   Config_Container object, array of Config_Container objects or false on failure.
    * @access   public
    */
    function &searchPath($args)
    {
        if ($this->type != 'section') {
            return PEAR::raiseError('Config_Container::searchPath must be called on a section type object.', null, PEAR_ERROR_RETURN);
        }

        $arg = array_shift($args);

        if (is_array($arg)) {
            $name = $arg[0];
            $attributes = $arg[1];
        } else {
            $name = $arg;
            $attributes = null;
        }
        // find all the matches for first..
        $match =& $this->getItem(null, $name, null, $attributes);

        if (!$match) {
            return false;
        }
        if (!empty($args)) {
            return $match->searchPath($args);
        }
        return $match;
    } // end func &searchPath

    /**
    * Return a child directive's content.
    *
    * This method can use two different search approach, depending on
    * the parameter it is given. If the parameter is an array, it will use
    * the {@link Config_Container::searchPath()} method. If it is a string,
    * it will use the {@link Config_Container::getItem()} method.
    *
    * Example:
    * <code>
    * require_once 'Config.php';
    * $ini = new Config();
    * $conf =& $ini->parseConfig('/path/to/config.ini', 'inicommented');
    *
    * // Will return the value found at :
    * // [Database]
    * // host=localhost
    * echo $conf->directiveContent(array('Database', 'host')));
    *
    * // Will return the value found at :
    * // date="dec-2004"
    * echo $conf->directiveContent('date');
    *
    * </code>
    *
    * @param    mixed   Search path and attributes or a directive name
    * @param    int     Index of the item in the returned directive list.
    *                   Eventually used if args is a string.
    *
    * @return   mixed   Content of directive or false if not found.
    * @access   public
    */
    function directiveContent($args, $index = -1)
    {
        if (is_array($args)) {
            $item =& $this->searchPath($args);
        } else {
            $item =& $this->getItem('directive', $args, null, null, $index);
        }
        if ($item) {
            return $item->getContent();
        }
        return false;
    } // end func getDirectiveContent

    /**
    * Returns how many children this container has
    *
    * @param  string    $type    type of children counted
    * @param  string    $name    name of children counted
    * @return int  number of children found
    */
    function countChildren($type = null, $name = null)
    {
        if (is_null($type) && is_null($name)) {
            return count($this->children);
        }
        $count = 0;
        if (isset($name) && isset($type)) {
            for ($i = 0, $children = count($this->children); $i < $children; $i++) {
                if ($this->children[$i]->name == $name &&
                    $this->children[$i]->type == $type) {
                    $count++;
                }
            }
            return $count;
        }
        if (isset($type)) {
            for ($i = 0, $children = count($this->children); $i < $children; $i++) {
                if ($this->children[$i]->type == $type) {
                    $count++;
                }
            }
            return $count;
        }
        if (isset($name)) {
            // Some directives can have the same name
            for ($i = 0, $children = count($this->children); $i < $children; $i++) {
                if ($this->children[$i]->name == $name) {
                    $count++;
                }
            }
            return $count;
        }
    } // end func &countChildren

    /**
    * Deletes an item (section, directive, comment...) from the current object
    * TODO: recursive remove in sub-sections
    * @return mixed  true if object was removed, false if not, or PEAR_Error if root
    */
    function removeItem()
    {
        if ($this->isRoot()) {
            return PEAR::raiseError('Cannot remove root item in Config_Container::removeItem.', null, PEAR_ERROR_RETURN);
        }
        $index = $this->getItemIndex();
        if (!is_null($index)) {
            array_splice($this->parent->children, $index, 1);
            return true;
        }
        return false;
    } // end func removeItem

    /**
    * Returns the item index in its parent children array.
    * @return int  returns int or null if root object
    */
    function getItemIndex()
    {
        if (is_object($this->parent)) {
            // This will be optimized with Zend Engine 2
            $pchildren =& $this->parent->children;
            for ($i = 0, $count = count($pchildren); $i < $count; $i++) {
                if ($pchildren[$i]->_id == $this->_id) {
                    return $i;
                }
            }
        }
        return;
    } // end func getItemIndex

    /**
    * Returns the item rank in its parent children array
    * according to other items with same type and name.
    * @return int  returns int or null if root object
    */
    function getItemPosition()
    {
        if (is_object($this->parent)) {
            $pchildren =& $this->parent->children;
            for ($i = 0, $count = count($pchildren); $i < $count; $i++) {
                if ($pchildren[$i]->name == $this->name &&
                    $pchildren[$i]->type == $this->type) {
                    $obj[] =& $pchildren[$i];
                }
            }
            for ($i = 0, $count = count($obj); $i < $count; $i++) {
                if ($obj[$i]->_id == $this->_id) {
                    return $i;
                }
            }
        }
        return;
    } // end func getItemPosition

    /**
    * Returns the item parent object.
    * @return object  returns reference to parent object or null if root object
    */
    function &getParent()
    {
        return $this->parent;
    } // end func &getParent

    /**
    * Returns the item parent object.
    * @return mixed  returns reference to child object or false if child does not exist
    */
    function &getChild($index = 0)
    {
        if (!empty($this->children[$index])) {
            return $this->children[$index];
        } else {
            return false;
        }
    } // end func &getChild

    /**
    * Set this item's name.
    * @return void
    */
    function setName($name)
    {
        $this->name = $name;
    } // end func setName

    /**
    * Get this item's name.
    * @return string    item's name
    */
    function getName()
    {
        return $this->name;
    } // end func getName

    /**
    * Set this item's content.
    * @return void
    */
    function setContent($content)
    {
        $this->content = $content;
    } // end func setContent

    /**
    * Get this item's content.
    * @return string    item's content
    */
    function getContent()
    {
        return $this->content;
    } // end func getContent

    /**
    * Set this item's type.
    * @return void
    */
    function setType($type)
    {
        $this->type = $type;
    } // end func setType

    /**
    * Get this item's type.
    * @return string    item's type
    */
    function getType()
    {
        return $this->type;
    } // end func getType

    /**
    * Set this item's attributes.
    * @param  array    $attributes        Array of attributes
    * @return void
    */
    function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    } // end func setAttributes

    /**
    * Set this item's attributes.
    * @param  array    $attributes        Array of attributes
    * @return void
    */
    function updateAttributes($attributes)
    {
        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $this->attributes[$key] = $value;
            }
        }
    } // end func updateAttributes

    /**
    * Get this item's attributes.
    * @return array    item's attributes
    */
    function getAttributes()
    {
        return $this->attributes;
    } // end func getAttributes

    /**
    * Get one attribute value of this item
    * @param  string   $attribute        Attribute key
    * @return mixed    item's attribute value
    */
    function getAttribute($attribute)
    {
        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }
        return null;
    } // end func getAttribute

    /**
    * Set a children directive content.
    * This is an helper method calling getItem and addItem or setContent for you.
    * If the directive does not exist, it will be created at the bottom.
    *
    * @param  string    $name        Name of the directive to look for
    * @param  mixed     $content     New content
    * @param  int       $index       Index of the directive to set,
    *                                in case there are more than one directive
    *                                with the same name
    * @return object    newly set directive
    */
    function &setDirective($name, $content, $index = -1)
    {
        $item =& $this->getItem('directive', $name, null, null, $index);
        if ($item === false || PEAR::isError($item)) {
            // Directive does not exist, will create one
            unset($item);
            return $this->createDirective($name, $content, null);
        } else {
            // Change existing directive value
            $item->setContent($content);
            return $item;
        }
    } // end func setDirective

    /**
    * Is this item root, in a config container object
    * @return bool    true if item is root
    */
    function isRoot()
    {
        if (is_null($this->parent)) {
            return true;
        }
        return false;
    } // end func isRoot

    /**
    * Call the toString methods in the container plugin
    * @param    string  $configType  Type of configuration used to generate the string
    * @param    array   $options     Specify special options used by the parser
    * @return   mixed   true on success or PEAR_ERROR
    */
    function toString($configType, $options = array())
    {
        $configType = strtolower($configType);
        if (!isset($GLOBALS['CONFIG_TYPES'][$configType])) {
            return PEAR::raiseError("Configuration type '$configType' is not registered in Config_Container::toString.", null, PEAR_ERROR_RETURN);
        }
        $includeFile = $GLOBALS['CONFIG_TYPES'][$configType][0];
        $className   = $GLOBALS['CONFIG_TYPES'][$configType][1];
        include_once($includeFile);
        $renderer = new $className($options);
        return $renderer->toString($this);
    } // end func toString

    /**
    * Returns a key/value pair array of the container and its children.
    *
    * Format : section[directive][index] = value
    * If the container has attributes, it will use '@' and '#'
    * index is here because multiple directives can have the same name.
    *
    * @param    bool    $useAttr        Whether to return the attributes too
    * @return array
    */
    function toArray($useAttr = true)
    {
        $array[$this->name] = array();
        switch ($this->type) {
            case 'directive':
                if ($useAttr && count($this->attributes) > 0) {
                    $array[$this->name]['#'] = $this->content;
                    $array[$this->name]['@'] = $this->attributes;
                } else {
                    $array[$this->name] = $this->content;
                }
                break;
            case 'section':
                if ($useAttr && count($this->attributes) > 0) {
                    $array[$this->name]['@'] = $this->attributes;
                }
                if ($count = count($this->children)) {
                    for ($i = 0; $i < $count; $i++) {
                        $newArr = $this->children[$i]->toArray($useAttr);
                        if (!is_null($newArr)) {
                            foreach ($newArr as $key => $value) {
                                if (isset($array[$this->name][$key])) {
                                    // duplicate name/type
                                    if (!is_array($array[$this->name][$key]) ||
                                        !isset($array[$this->name][$key][0])) {
                                        $old = $array[$this->name][$key];
                                        unset($array[$this->name][$key]);
                                        $array[$this->name][$key][0] = $old;
                                    }
                                    $array[$this->name][$key][] = $value;
                                } else {
                                    $array[$this->name][$key] = $value;
                                }
                            }
                        }
                    }
                }
                break;
            default:
                return null;
        }
        return $array;
    } // end func toArray

    /**
    * Writes the configuration to a file
    *
    * @param  mixed  $datasrc        Info on datasource such as path to the configuraton file or dsn...
    * @param  string $configType     Type of configuration
    * @param  array  $options        Options for writer
    * @access public
    * @return mixed     true on success or PEAR_ERROR
    */
    function writeDatasrc($datasrc, $configType, $options = array())
    {
        $configType = strtolower($configType);
        if (!isset($GLOBALS['CONFIG_TYPES'][$configType])) {
            return PEAR::raiseError("Configuration type '$configType' is not registered in Config_Container::writeDatasrc.", null, PEAR_ERROR_RETURN);
        }
        $includeFile = $GLOBALS['CONFIG_TYPES'][$configType][0];
        $className = $GLOBALS['CONFIG_TYPES'][$configType][1];
        include_once($includeFile);

        $writeMethodName = (version_compare(phpversion(), '5', '<')) ? 'writedatasrc' : 'writeDatasrc';
        if (in_array($writeMethodName, get_class_methods($className))) {
            $writer = new $className($options);
            return $writer->writeDatasrc($datasrc, $this);
        }

        // Default behaviour
        $fp = @fopen($datasrc, 'w');
        if ($fp) {
            $string = $this->toString($configType, $options);
            $len = strlen($string);
            @flock($fp, LOCK_EX);
            @fwrite($fp, $string, $len);
            @flock($fp, LOCK_UN);
            @fclose($fp);
            return true;
        } else {
            return PEAR::raiseError('Cannot open datasource for writing.', 1, PEAR_ERROR_RETURN);
        }
    } // end func writeDatasrc
} // end class Config_Container
?>