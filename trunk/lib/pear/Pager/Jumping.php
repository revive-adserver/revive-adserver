<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Contains the Pager_Jumping class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE FREEBSD PROJECT OR CONTRIBUTORS BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
 * THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   HTML
 * @package    Pager
 * @author     Lorenzo Alberton <l dot alberton at quipo dot it>
 * @author     Richard Heyes <richard@phpguru.org>,
 * @copyright  2003-2006 Lorenzo Alberton, Richard Heyes
 * @license    http://www.debian.org/misc/bsd.license  BSD License (3 Clause)
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Pager
 */

/**
 * require PEAR::Pager_Common base class
 */
require_once 'Pager/Common.php';

/**
 * Pager_Jumping - Generic data paging class  ("jumping window" style)
 * Handles paging a set of data. For usage see the example.php provided.
 *
 * @category   HTML
 * @package    Pager
 * @author     Lorenzo Alberton <l dot alberton at quipo dot it>
 * @author     Richard Heyes <richard@phpguru.org>,
 * @copyright  2003-2005 Lorenzo Alberton, Richard Heyes
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://pear.php.net/package/Pager
 */
class Pager_Jumping extends Pager_Common
{
    // {{{ Pager_Jumping()

    /**
     * Constructor
     *
     * @param array $options    An associative array of option names
     *                          and their values
     * @access public
     */
    function Pager_Jumping($options = array())
    {
        $err = $this->setOptions($options);
        if ($err !== PAGER_OK) {
            return $this->raiseError($this->errorMessage($err), $err);
        }
        $this->build();
    }

    // }}}
    // {{{ build()

    /**
     * Generate or refresh the links and paged data after a call to setOptions()
     *
     * @access public
     */
    function build()
    {
        //reset
        $this->_pageData = array();
        $this->links = '';

        $this->_generatePageData();
        $this->_setFirstLastText();

        $this->links .= $this->_getBackLink();
        $this->links .= $this->_getPageLinks();
        $this->links .= $this->_getNextLink();

        $this->linkTags .= $this->_getFirstLinkTag();
        $this->linkTags .= $this->_getPrevLinkTag();
        $this->linkTags .= $this->_getNextLinkTag();
        $this->linkTags .= $this->_getLastLinkTag();
    }

    // }}}
    // {{{ getPageIdByOffset()

    /**
     * Returns pageID for given offset
     *
     * @param $index Offset to get pageID for
     * @return int PageID for given offset
     */
    function getPageIdByOffset($index)
    {
        if (!isset($this->_pageData)) {
            $this->_generatePageData();
        }

        if (($index % $this->_perPage) > 0) {
            $pageID = ceil((float)$index / (float)$this->_perPage);
        } else {
            $pageID = $index / $this->_perPage;
        }
        return $pageID;
    }

    // }}}
    // {{{ getPageRangeByPageId()

    /**
     * Given a PageId, it returns the limits of the range of pages displayed.
     * While getOffsetByPageId() returns the offset of the data within the
     * current page, this method returns the offsets of the page numbers interval.
     * E.g., if you have pageId=3 and delta=10, it will return (1, 10).
     * PageID of 8 would give you (1, 10) as well, because 1 <= 8 <= 10.
     * PageID of 11 would give you (11, 20).
     * If the method is called without parameter, pageID is set to currentPage#.
     *
     * @param integer PageID to get offsets for
     * @return array  First and last offsets
     * @access public
     */
    function getPageRangeByPageId($pageid = null)
    {
        $pageid = isset($pageid) ? (int)$pageid : $this->_currentPage;
        if (isset($this->_pageData[$pageid]) || is_null($this->_itemData)) {
            // I'm sure I'm missing something here, but this formula works
            // so I'm using it until I find something simpler.
            $start = ((($pageid + (($this->_delta - ($pageid % $this->_delta))) % $this->_delta) / $this->_delta) - 1) * $this->_delta +1;
            return array(
                max($start, 1),
                min($start+$this->_delta-1, $this->_totalPages)
            );
        } else {
            return array(0, 0);
        }
    }

    // }}}
    // {{{ getLinks()

    /**
     * Returns back/next/first/last and page links,
     * both as ordered and associative array.
     *
     * NB: in original PEAR::Pager this method accepted two parameters,
     * $back_html and $next_html. Now the only parameter accepted is
     * an integer ($pageID), since the html text for prev/next links can
     * be set in the constructor. If a second parameter is provided, then
     * the method act as it previously did. This hack's only purpose is to
     * mantain backward compatibility.
     *
     * @param integer $pageID Optional pageID. If specified, links
     *                for that page are provided instead of current one.
     *                [ADDED IN NEW PAGER VERSION]
     * @param  string $next_html HTML to put inside the next link
     *                [deprecated: use the constructor instead]
     * @return array Back/pages/next links
     */
    function getLinks($pageID=null, $next_html='')
    {
        //BC hack
        if (!empty($next_html)) {
            $back_html = $pageID;
            $pageID    = null;
        } else {
            $back_html = '';
        }

        if (!is_null($pageID)) {
            $_sav = $this->_currentPage;
            $this->_currentPage = $pageID;

            $this->links = '';
            if ($this->_totalPages > $this->_delta) {
                $this->links .= $this->_printFirstPage();
            }
            $this->links .= $this->_getBackLink('', $back_html);
            $this->links .= $this->_getPageLinks();
            $this->links .= $this->_getNextLink('', $next_html);
            if ($this->_totalPages > $this->_delta) {
                $this->links .= $this->_printLastPage();
            }
        }

        $back  = str_replace('&nbsp;', '', $this->_getBackLink());
        $next  = str_replace('&nbsp;', '', $this->_getNextLink());
        $pages = $this->_getPageLinks();
        $first = $this->_printFirstPage();
        $last  = $this->_printLastPage();
        $all   = $this->links;
        $linkTags = $this->linkTags;

        if (!is_null($pageID)) {
            $this->_currentPage = $_sav;
        }

        return array(
            $back,
            $pages,
            trim($next),
            $first,
            $last,
            $all,
            $linkTags,
            'back'  => $back,
            'pages' => $pages,
            'next'  => $next,
            'first' => $first,
            'last'  => $last,
            'all'   => $all,
            'linktags' => $linkTags
        );
    }

    // }}}
    // {{{ _getPageLinks()

    /**
     * Returns pages link
     *
     * @param $url  URL to use in the link
     *              [deprecated: use the constructor instead]
     * @return string Links
     * @access private
     */
    function _getPageLinks($url = '')
    {
        //legacy setting... the preferred way to set an option now
        //is adding it to the constuctor
        if (!empty($url)) {
            $this->_path = $url;
        }

        //If there's only one page, don't display links
        if ($this->_clearIfVoid && ($this->_totalPages < 2)) {
            return '';
        }

        $links = '';
        $limits = $this->getPageRangeByPageId($this->_currentPage);

        for ($i=$limits[0]; $i<=min($limits[1], $this->_totalPages); $i++) {
            if ($i != $this->_currentPage) {
                $this->range[$i] = false;
                $this->_linkData[$this->_urlVar] = $i;
                $links .= $this->_renderLink($this->_altPage.' '.$i, $i);
            } else {
                $this->range[$i] = true;
                $links .= $this->_curPageSpanPre . $i . $this->_curPageSpanPost;
            }
            $links .= $this->_spacesBefore
                   . (($i != $this->_totalPages) ? $this->_separator.$this->_spacesAfter : '');
        }
        return $links;
    }

    // }}}
}
?>