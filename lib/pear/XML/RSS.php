<?php
// vim: set expandtab tabstop=4 shiftwidth=4 fdm=marker:
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
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
// | Authors: Martin Jansen <mj@php.net>                                  |
// |                                                                      |
// +----------------------------------------------------------------------+

require_once 'XML/Parser.php';

/**
* RSS parser class.
*
* This class is a parser for Resource Description Framework (RDF) Site
* Summary (RSS) documents. For more information on RSS see the
* website of the RSS working group (http://www.purl.org/rss/).
*
* @author Martin Jansen <mj@php.net>
* @version $Revision: 1.28 $
* @access  public
*/
class XML_RSS extends XML_Parser
{
    // {{{ properties

    /**
     * @var string
     */
    var $insideTag = '';

    /**
     * @var array
     */
    var $insideTagStack = array();

    /**
     * @var string
     */
    var $activeTag = '';

    /**
     * @var array
     */
    var $channel = array();

    /**
     * @var array
     */
    var $items = array();

    /**
     * @var array
     */
    var $item = array();

    /**
     * @var array
     */
    var $image = array();

    /**
     * @var array
     */
    var $textinput = array();

    /**
     * @var array
     */
    var $textinputs = array();

    /**
     * @var array
     */
    var $attribs;

    /**
     * @var array
     */
    var $parentTags = array('CHANNEL', 'ITEM', 'IMAGE', 'TEXTINPUT');

    /**
     * @var array
     */
    var $channelTags = array('TITLE', 'LINK', 'DESCRIPTION', 'IMAGE',
                              'ITEMS', 'TEXTINPUT', 'LANGUAGE', 'COPYRIGHT',
                              'MANAGINGEditor', 'WEBMASTER', 'PUBDATE', 'LASTBUILDDATE',
                              'CATEGORY', 'GENERATOR', 'DOCS', 'CLOUD', 'TTL',
                              'RATING');

    /**
     * @var array
     */
    var $itemTags = array('TITLE', 'LINK', 'DESCRIPTION', 'PUBDATE', 'AUTHOR', 'CATEGORY',
                          'COMMENTS', 'ENCLOSURE', 'GUID', 'PUBDATE', 'SOURCE',
                          'CONTENT:ENCODED');

    /**
     * @var array
     */
    var $imageTags = array('TITLE', 'URL', 'LINK', 'WIDTH', 'HEIGHT');


    var $textinputTags = array('TITLE', 'DESCRIPTION', 'NAME', 'LINK');

    /**
     * List of allowed module tags
     *
     * Currently supported:
     *
     *   Dublin Core Metadata
     *   blogChannel RSS module
     *   CreativeCommons
     *   Content
     *   Syndication
     *   Trackback
     *   GeoCoding
     *   Media
     *   iTunes
     *
     * @var array
     */
    var $moduleTags = array('DC:TITLE', 'DC:CREATOR', 'DC:SUBJECT', 'DC:DESCRIPTION',
                            'DC:PUBLISHER', 'DC:CONTRIBUTOR', 'DC:DATE', 'DC:TYPE',
                            'DC:FORMAT', 'DC:IDENTIFIER', 'DC:SOURCE', 'DC:LANGUAGE',
                            'DC:RELATION', 'DC:COVERAGE', 'DC:RIGHTS',
                            'BLOGCHANNEL:BLOGROLL', 'BLOGCHANNEL:MYSUBSCRIPTIONS',
                            'BLOGCHANNEL:BLINK', 'BLOGCHANNEL:CHANGES',
                            'CREATIVECOMMONS:LICENSE', 'CC:LICENSE', 'CONTENT:ENCODED',
                            'SY:UPDATEPERIOD', 'SY:UPDATEFREQUENCY', 'SY:UPDATEBASE',
                            'TRACKBACK:PING', 'GEO:LAT', 'GEO:LONG',
                            'MEDIA:GROUP', 'MEDIA:CONTENT', 'MEDIA:ADULT',
                            'MEDIA:RATING', 'MEDIA:TITLE', 'MEDIA:DESCRIPTION',
                            'MEDIA:KEYWORDS', 'MEDIA:THUMBNAIL', 'MEDIA:CATEGORY',
                            'MEDIA:HASH', 'MEDIA:PLAYER', 'MEDIA:CREDIT',
                            'MEDIA:COPYRIGHT', 'MEDIA:TEXT', 'MEDIA:RESTRICTION',
                            'ITUNES:AUTHOR', 'ITUNES:BLOCK', 'ITUNES:CATEGORY',
                            'ITUNES:DURATION', 'ITUNES:EXPLICIT', 'ITUNES:IMAGE',
                            'ITUNES:KEYWORDS', 'ITUNES:NEW-FEED-URL', 'ITUNES:OWNER',
                            'ITUNES:PUBDATE', 'ITUNES:SUBTITLE', 'ITUNES:SUMMARY'
                            );

    /**
     * @var array
     */
    var $last = array();

    // }}}
    // {{{ Constructor

    /**
     * Constructor
     *
     * @access public
     * @param mixed File pointer, name of the RSS file, or an RSS string.
     * @param string  Source charset encoding, use null (default) to use
     *                default encoding (ISO-8859-1)
     * @param string  Target charset encoding, use null (default) to use
     *                default encoding (ISO-8859-1)
     * @return void
     */
    function __construct($handle = '', $srcenc = null, $tgtenc = null)
    {
        if ($srcenc === null && $tgtenc === null) {
            parent::__construct();
        } else {
            parent::__construct($srcenc, 'event', $tgtenc);
        }

        $this->setInput($handle);

        if ($handle == '') {
            $this->raiseInstanceError('No input passed.');
        }
    }

    // }}}
    // {{{ startHandler()

    /**
     * Start element handler for XML parser
     *
     * @access private
     *
     * @param $xp
     * @param $elem
     * @param $attribs
     *
     * @return void
     */
    function startHandler($xp, $elem, $attribs)
    {
        if (substr($elem, 0, 4) == "RSS:") {
            $elem = substr($elem, 4);
        }

        switch ($elem) {
            case 'CHANNEL':
            case 'ITEM':
            case 'IMAGE':
            case 'TEXTINPUT':
                $this->insideTag = $elem;
                array_push($this->insideTagStack, $elem);
                break;

            case 'ENCLOSURE' :
                $this->attribs = $attribs;
                break;

            default:
                $this->activeTag = $elem;
        }
    }

    // }}}
    // {{{ endHandler()

    /**
     * End element handler for XML parser
     *
     * If the end of <item>, <channel>, <image> or <textinput>
     * is reached, this method updates the structure array
     * $this->struct[] and adds the field "type" to this array,
     * that defines the type of the current field.
     *
     * @access private
     * @param  object XML parser object
     * @param  string
     * @return void
     */
    function endHandler($parser, $element)
    {
        if (substr($element, 0, 4) == "RSS:") {
            $element = substr($element, 4);
        }

        if ($element == $this->insideTag) {
            array_pop($this->insideTagStack);
            $this->insideTag = end($this->insideTagStack);

            $this->struct[] = array_merge(array('type' => strtolower($element)),
                                          $this->last);
        }

        if ($element == 'ITEM') {
            $this->items[] = $this->item;
            $this->item = '';
        }

        if ($element == 'IMAGE') {
            $this->images[] = $this->image;
            $this->image = '';
        }

        if ($element == 'TEXTINPUT') {
            $this->textinputs = $this->textinput;
            $this->textinput = '';
        }

        if ($element == 'ENCLOSURE') {
            if (!isset($this->item['enclosures'])) {
                $this->item['enclosures'] = array();
            }

            $this->item['enclosures'][] = array_change_key_case($this->attribs, CASE_LOWER);
            $this->attribs = array();
        }

        $this->activeTag = '';
    }

    // }}}
    // {{{ cdataHandler()

    /**
     * Handler for character data
     *
     * @access private
     * @param  object XML parser object
     * @param  string CDATA
     * @return void
     */
    function cdataHandler($parser, $cdata)
    {
        if (in_array($this->insideTag, $this->parentTags)) {
            $tagName = strtolower($this->insideTag);
            $var = $this->{$tagName . 'Tags'};

            if (in_array($this->activeTag, $var) ||
                in_array($this->activeTag, $this->moduleTags)) {
                $this->_add($tagName, strtolower($this->activeTag),
                            $cdata);
            }

        }
    }

    // }}}
    // {{{ defaultHandler()

    /**
     * Default handler for XML parser
     *
     * @access private
     * @param  object XML parser object
     * @param  string CDATA
     * @return void
     */
    function defaultHandler($parser, $cdata)
    {
        return;
    }

    // }}}
    // {{{ _add()

    /**
     * Add element to internal result sets
     *
     * @access private
     * @param  string Name of the result set
     * @param  string Fieldname
     * @param  string Value
     * @return void
     * @see    cdataHandler
     */
    function _add($type, $field, $value)
    {
        if (empty($this->{$type}) || empty($this->{$type}[$field])) {
            $this->{$type}[$field] = $value;
        } else {
            $this->{$type}[$field] .= $value;
        }

        $this->last = $this->{$type};
    }

    // }}}
    // {{{ getStructure()

    /**
     * Get complete structure of RSS file
     *
     * @access public
     * @return array
     */
    function getStructure()
    {
        return (array)$this->struct;
    }

    // }}}
    // {{{ getchannelInfo()

    /**
     * Get general information about current channel
     *
     * This method returns an array containing the information
     * that has been extracted from the <channel>-tag while parsing
     * the RSS file.
     *
     * @access public
     * @return array
     */
    function getChannelInfo()
    {
        return (array)$this->channel;
    }

    // }}}
    // {{{ getItems()

    /**
     * Get items from RSS file
     *
     * This method returns an array containing the set of items
     * that are provided by the RSS file.
     *
     * @access public
     * @return array
     */
    function getItems()
    {
        return (array)$this->items;
    }

    // }}}
    // {{{ getImages()

    /**
     * Get images from RSS file
     *
     * This method returns an array containing the set of images
     * that are provided by the RSS file.
     *
     * @access public
     * @return array
     */
    function getImages()
    {
        return (array)$this->images;
    }

    // }}}
    // {{{ getTextinputs()

    /**
     * Get text input fields from RSS file
     *
     * @access public
     * @return array
     */
    function getTextinputs()
    {
        return (array)$this->textinputs;
    }

    // }}}

}
?>
