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
 * A custom XML parser facility from
 * http://www.devarticles.com/c/a/PHP/Converting-XML-Into-a-PHP-Data-Structure/
 */

class XMLToArray
{
    //-----------------------------------------
    // private variables
    var $parser;
    var $node_stack = array();

    //-----------------------------------------
    /** PUBLIC
    * If a string is passed in, parse it right away.
    */
    function XMLToArray($xmlstring="") {
        if ($xmlstring) return($this->parse($xmlstring));
        return(true);
    }


    //-----------------------------------------
    /** PUBLIC
    * Parse a text string containing valid XML into a multidimensional array
    * located at rootnode.
    */
    function parse($xmlstring="") {
        // set up a new XML parser to do all the work for us
        $this->parser = xml_parser_create();
        xml_set_object($this->parser, $this);
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($this->parser, "startElement", "endElement");
        xml_set_character_data_handler($this->parser, "characterData");

        // Build a Root node and initialize the node_stack...
        $this->node_stack = array();
        $this->startElement(null, "root", array());

        // parse the data and free the parser...
        xml_parse($this->parser, $xmlstring);
        xml_parser_free($this->parser);

        // recover the root node from the node stack
        $rnode = array_pop($this->node_stack);

        // return the root node...
        return($rnode);
    }


    //-----------------------------------------
    /** PROTECTED
    * Start a new Element. This means we push the new element onto the stack
    * and reset it's properties.
    */
    function startElement($parser, $name, $attrs)
    {

        // create a new node...
        $node = array();
        $node["_NAME"] = $name;
        foreach ($attrs as $key => $value) {
        $node[$key] = $value;
        }

        $node["_DATA"] = "";
        $node["_ELEMENTS"] = array();

        // add the new node to the end of the node stack
        array_push($this->node_stack, $node);
    }


    //-----------------------------------------
    /** PROTECTED
    * End an element. This is done by popping the last element from the
    * stack and adding it to the previous element on the stack.
    */
    function endElement($parser, $name) {
        // pop this element off the node stack
        $node = array_pop($this->node_stack);
        $node["_DATA"] = trim($node["_DATA"]);

        // and add it an an element of the last node in the stack...
        $lastnode = count($this->node_stack);
        array_push($this->node_stack[$lastnode-1]["_ELEMENTS"], $node);
    }


    //-----------------------------------------
    /** PROTECTED
    * Collect the data onto the end of the current chars.
    */
    function characterData($parser, $data) {
        // add this data to the last node in the stack...
        $lastnode = count($this->node_stack);
        $this->node_stack[$lastnode-1]["_DATA"] .= $data;
    }

    //-----------------------------------------
}