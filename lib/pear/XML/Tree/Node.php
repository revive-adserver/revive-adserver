<?php
// +----------------------------------------------------------------------+
// | PEAR :: XML_Tree                                                     |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Bernd R�mer <berndr@bonn.edu>                               |
// |          Sebastian Bergmann <sb@sebastian-bergmann.de>               |
// |          Christian K�hn <ck@chkuehn.de> (escape xml entities)        |
// |          Michele Manzato <michele.manzato@verona.miz.it>             |
// +----------------------------------------------------------------------+
//
// $Id$
//

/**
 * PEAR::XML_Tree_Node
 *
 * @author  Bernd R�mer <berndr@bonn.edu>
 * @package XML_Tree
 * @version 1.0  16-Aug-2001
 */

class XML_Tree_Node {
    /**
     * Attributes of this node
     *
     * @var  array
     */

    var $attributes;

    /**
     * Children of this node
     *
     * @var  array
     */

    var $children;

    /**
     * Content (text) of this node
     *
     * @var  string
     */

    var $content;

    /**
     * Name of the node
     *
     * @var  string
     */

    var $name;

    /**
     * Namespaces for the node
     *
     * @var array
     */


    var $namespaces = array();

    /**
     * Stores PEAR_Error upon error
     *
     * @var object PEAR_Error
     */

    var $error = null;

    /**
     * Whether to encapsulate the CDATA in a <![CDATA[]]> section
     *
     * @var boolean
     */

    var $use_cdata_section = null;


    /**
     * Constructor
     *
     * @param  string    name            Node name
     * @param  string    content         Node content (text)
     * @param  array     attributes      Attribute-hash for the node
     */

    function __construct($name, $content = '', $attributes = array(), $lineno = null, $use_cdata_section = null)
    {
        $check_name = XML_Tree::isValidName($name, 'element');
        if (PEAR::isError($check_name)) {
            $this->error =& $check_name;
            return;
        }
        
        if (!is_array($attributes)) {
            $attributes = array();
        }
        
        foreach ($attributes as $attribute_name => $value) {
            $error = XML_Tree::isValidName($attribute_name, 'Attribute');
            if (PEAR::isError($error)) {
                $this->error =& $error;
                return;
            }
        }
        $this->name = $name;
        $this->setContent($content, $use_cdata_section);
        $this->attributes = $attributes;
        $this->children   = array();
        $this->lineno     = $lineno;
    }

    /**
     * Append a child node to this node, after all other nodes
     *
     * @param mixed      child           Child to insert (XML_Tree or XML_Tree_Node),
     *                                   or name of child node
     * @param string     content         Content (text) for the new node (only if
     *                                   $child is the node name)
     * @param array      attributes      Attribute-hash for new node
     *
     * @return object  reference to new child node
     * @access public
     */

    function &addChild($child, $content = '', $attributes = array(), $lineno = null, $use_cdata_section = null)
    {
        $index = sizeof($this->children);

        if (is_object($child)) {
            if (strtolower(get_class($child)) == 'xml_tree_node') {
                $this->children[$index] = $child;
            }

            if (strtolower(get_class($child)) == 'xml_tree' && isset($child->root)) {
                $this->children[$index] = $child->root->getElement();
            }
        } else {
            $node = new XML_Tree_Node($child, $content, $attributes, $lineno, $use_cdata_section);
            if (PEAR::isError($node->error)) {
                return $node->error;
            }

            $this->children[$index] = $node;
        }

        return $this->children[$index];
    }

    /**
     * Get a copy of this node by clone this node and all of its children,
     * recursively.
     *
     * @return object    Reference to the cloned copy.
     * @access public
     */

    function &cloneNode()
    {
        $clone = new XML_Tree_Node($this->name,$this->content,$this->attributes);

        $max_child=count($this->children);
        for($i=0;$i<$max_child;$i++) {
            $clone->children[]=$this->children[$i]->cloneNode();
        }

        /* for future use....
        // clone all other vars
        $temp=get_object_vars($this);
        foreach($temp as $varname => $value)
        if (!in_array($varname,array('name','content','attributes','children')))
        $clone->$varname=$value;
         */

        return $clone;
    }

    /**
     * Inserts child ($child) to a specified child-position ($pos)
     *
     * @param mixed      path            Path to parent node to add child (see getNodeAt()
     *                                   for format). If null child is inserted in the
     *                                   current node.
     * @param integer    pos             Position where to insert the new child.
     *                                   0 < means |$pos| elements before the end,
     *                                   e.g. -1 appends as last child.
     * @param mixed      child           Child to insert (XML_Tree or XML_Tree_Node),
     *                                   or name of child node
     * @param string     content         Content (text) for the new node (only if
     *                                   $child is the node name)
     * @param array      attributes      Attribute-hash for new node
     *
     * @return Reference to the newly inserted node, or PEAR_Error upon insertion error.
     * @access public
     */

    function &insertChild($path,$pos,&$child, $content = '', $attributes = array())
    {
        $parent = $this->getNodeAt($path);
        if (PEAR::isError($parent)) {
            // $path was not found
            return $parent;
        } elseif ($parent != $this) {
            // Insert at the node found
            return $parent->insertChild(null, $pos, $child, $content, $attributes);
        }

        if (($pos < -count($this->children)) || ($pos > count($this->children))) {
            return new PEAR_Error("Invalid insert position.");
        }

        if (is_object($child)) { // child is an object
        // insert a single node
        if (strtolower(get_class($child)) == 'xml_tree_node') {
            array_splice($this->children, $pos, 0, 'dummy');
            if ($pos < 0) {
                $pos = count($this->children) + $pos - 1;
            }
            $this->children[$pos] = &$child;
            // insert a tree i.e insert root-element of tree
        } elseif (strtolower(get_class($child)) == 'xml_tree' && isset($child->root)) {
            array_splice($this->children, $pos, 0, 'dummy');
            if ($pos < 0) {
                $pos = count($this->children) + $pos - 1;
            }
            $this->children[$pos] = $child->root;
        } else {
            return new PEAR_Error("Bad node (must be a XML_Tree or an XML_Tree_Node)");
        }
        } else { // child offered is a string
        array_splice($this->children, $pos, 0, 'dummy');
        if ($pos < 0) {
            $pos = count($this->children) + $pos - 1;
        }
        $this->children[$pos] = new XML_Tree_Node($child, $content, $attributes);
        }
        return $this;
    }

    /**
     * Removes child at a given position
     *
     * @param    integer     pos     position of child to remove in children-list.
     *                               0 < means |$pos| elements before the end,
     *                               e.g. -1 removes the last child.
     *
     * @return mixed     The removed node, or PEAR_Error upon removal error.
     * @access public
     */

    function &removeChild($pos)
    {
        if (($pos < -count($this->children)) || ($pos >= count($this->children))) {
            return new PEAR_Error("Invalid remove position.");
        }

        // Using array_splice() instead of a simple unset() to maintain index-integrity
        return array_splice($this->children, $pos, 1);
    }

    /**
     * Register a namespace.
     *
     * @param  string  $name namespace
     * @param  string  $path path
     *
     * @access public
     */

    function registerName($name, $path) {
        $this->namespace[$name] = $path;
    }

    /**
     * Returns text representation of this node.
     *
     * @return  string   text (xml) representation of this node. Each tag is
     *                   indented according to its level.
     * @access public
     */

    function &get($use_cdata_section = false)
    {
        static $deep = -1;
        static $do_ident = true;
        $deep++;
        $empty = false;
        $ident = str_repeat('  ', $deep);
        if ($this->name !== null) {
            if ($do_ident) {
                $out = $ident . '<' . $this->name;
            } else {
                $out = '<' . $this->name;
            }
            foreach ($this->attributes as $name => $value) {
                $out .= ' ' . $name . '="' . $value . '"';
            }

            if (isset($this->namespace) && (is_array($this->namespace))) {
                foreach ($this->namespace as $qualifier => $uri) {
                    if ($qualifier == '') {
                        $out .= " xmlns='$uri'";
                    } else {
                        $out .= " xmlns:$qualifier='$uri'";
                    }
                }
            }

            if ($this->content == '' && sizeof($this->children) === 0 && $deep != 0) {
                $out .= ' />';
                $empty = true;
            } else {
                $out .= '>';
                if ($this->use_cdata_section == true || ($use_cdata_section == true && $this->use_cdata_section !== false)) {
                    if (trim($this->content) != '') {
                        $out .= '<![CDATA[' .$this->content. ']]>';
                    }
                    } else {
                    if (trim($this->content) != '') {
                        $out .= $this->content;
                    }
                }
            }

            if (sizeof($this->children) > 0) {
                $out .= "\n";
                foreach ($this->children as $child) {
                    $out .= $child->get($use_cdata_section);
                }
            } else {
                $ident = '';
            }

            if ($do_ident && $empty != true) {
                $out .= $ident . '</' . $this->name . ">\n";
            } elseif ($empty != true) {
                $out .= '</' . $this->name . '>';
            }
            $do_ident = true;
        } else {
            if ($this->use_cdata_section == true || ($use_cdata_section == true && $this->use_cdata_section !== false)) {
                if (trim($this->content) != '') {
                    $out = $ident . '<![CDATA[' .$this->content. ']]>' . "\n";
                }
            } else {
                if (trim($this->content) != '') {
                    $out = $ident . $this->content . "\n";
                }
            }
        }
        $deep--;
        return $out;
    }

    /**
     * Get an attribute by its name.
     *
     * @param  string  $name     Name of attribute to retrieve
     *
     * @return string  attribute, or null if attribute is unset.
     * @access public
     */

    function getAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        return null;
    }

    /**
     * Sets an attribute for this node.
     *
     * @param  string    name        Name of attribute to set
     * @param  string    value       Value of attribute
     *
     * @access public
     */

    function setAttribute($name, $value = '')
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Unsets an attribute of this node.
     *
     * @param  string  $name     Name of attribute to unset
     *
     * @access public
     */

    function unsetAttribute($name)
    {
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
        }
    }

    /**
     * Sets the content for this node.
     *
     * @param  string    content     Node content to assign
     *
     * @access public
     */

    function setContent($content, $use_cdata_section = null)
    {
        $this->use_cdata_section = $use_cdata_section;

        if ($use_cdata_section == true) {
            $this->content = $content;
        } else {
            $this->content = $this->encodeXmlEntities($content);
        }
    }

    /**
     * Gets an element by its 'path'.
     *
     * @param  array     path    path to element: sequence of indexes to the
     *                           children. E.g. array(1, 2, 3) means "third
     *                           child of second child of first child" of the node.
     *
     * @return object    reference to element found, or PEAR_Error if node can't
     *                   be found.
     * @access public
     */

    function &getElement($path)
    {
        if (!is_array($path)) {
            $path = array($path);
        }
        if (sizeof($path) == 0) {
            return $this;
        }

        $path1 = $path;
        $next = array_shift($path1);
        if (isset($this->children[$next])) {
            $x = $this->children[$next]->getElement($path1);
            if (!PEAR::isError($x)) {
                return $x;
            }
        }

        return new PEAR_Error("Bad path to node: [".implode('-', $path)."]");
    }

    /**
     * Get a reference to a node by its 'path'.
     *
     * @param  mixed     path    Path to node. Can be either a string (slash-separated
     *   children names) or an array (sequence of children names) both
     *                           starting from this node. The first name in sequence
     *   is a child name, not the name of this node.
     *
     * @return object    Reference to the XML_Tree_Node found, or PEAR_Error if
     *                   the path does not match any node. Note that if more than
     *                   one element matches then only the first matching node is
     *                   returned.
     * @access public
     */

    function &getNodeAt($path)
    {
        if (is_string($path))
            $path = explode("/", $path);

        if (sizeof($path) == 0) {
            return $this;
        }

        $path1 = $path;
        $next = array_shift($path1);

        // Get the first children of this node whose name is '$next'
        $child = null;
        for ($i = 0; $i < count($this->children); $i++) {
            if ($this->children[$i]->name == $next) {
                $child = $this->children[$i];
                break;
            }
        }
        if (!is_null($child)) {
            $x =& $child->getNodeAt($path1);
            if (!PEAR::isError($x)) {
                return $x;
            }
        }

        // No node with that name found
        return new PEAR_Error("Bad path to node: [".implode('/', $path)."]");
    }

    /**
     * Escape XML entities.
     *
     * @param   string  xml      Text string to escape.
     *
     * @return  string  xml
     * @access  public
     */

    function encodeXmlEntities($xml)
    {
        $xml = str_replace(array('�', '�', '�',
                                 '�', '�', '�',
                                 '�', '<', '>',
                                 '"', '\''
                                ),
                           array('&#252;', '&#220;', '&#246;',
                                 '&#214;', '&#228;', '&#196;',
                                  '&#223;', '&lt;', '&gt;',
                                  '&quot;', '&apos;'
                                ),
                           $xml
                          );

        $xml = preg_replace(array("/\&([a-z\d\#]+)\;/i",
                                  "/\&/",
                                  "/\#\|\|([a-z\d\#]+)\|\|\#/i",
                                  "/([^a-zA-Z\d\s\<\>\&\;\.\:\=\"\-\/\%\?\!\'\(\)\[\]\{\}\$\#\+\,\@_])/e"
                                 ),
                            array("#||\\1||#",
                                  "&amp;",
                                  "&\\1;",
                                  "'&#'.ord('\\1').';'"
                                 ),
                            $xml
                           );

        return $xml;
    }

    /**
     * Decode XML entities in a text string.
     *
     * @param   string  xml  Text to decode
     *
     * @return  string  Decoded text
     * @access  public
     */

    function decodeXmlEntities($xml)
    {
        static $trans_tbl = null;
        if (!$trans_tbl) {
            $trans_tbl = get_html_translation_table(HTML_ENTITIES);
            $trans_tbl = array_flip($trans_tbl);
        }
        for ($i = 1; $i <= 255; $i++) {
            $ent = sprintf("&#%03d;", $i);
            $ch = chr($i);
            $xml = str_replace($ent, $ch, $xml);
        }

        return strtr($xml, $trans_tbl);
    }


    /**
     * Print text representation of XML_Tree_Node.
     *
     * @access  public
     */

    function dump() {
        echo $this->get();
    }
}
?>
