<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - PEAR PHP OO Graph Rendering Utility.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or (at your
 * option) any later version. This library is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details. You should have received a copy of
 * the GNU Lesser General Public License along with this library; if not, write
 * to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage DataPreprocessor
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/DataPreprocessor.php
 */
require_once 'Image/Graph/DataPreprocessor.php';

/**
 * Formatting a number as its written in languages supported by Numbers_Words.
 *
 * Used to display values as text, i.e. 123 is displayed as one hundred and twenty three.
 * Requires Numbers_Words
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage DataPreprocessor
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_DataPreprocessor_NumberText extends Image_Graph_DataPreprocessor
{

    /**
     * The language identifier
     * @var string
     * @access private
     */
    var $_language;

    /**
     * Image_Graph_NumberText [Constructor].
     *
     * Supported languages see {@link http://pear.php.net/package/Numbers_Words Numbers_Words}
     *
     * @param string $langugage The language identifier for the language.
     */
    function Image_Graph_DataPreprocessor_NumberText($language = 'en_US')
    {
        parent::__construct();
        $this->_language = $language;
        require_once 'Numbers/Words.php';
    }

    /**
     * Process the value
     *
     * @param var $value The value to process/format
     * @return string The processed value
     * @access private
     */
    function _process($value)
    {
        return Numbers_Words::toWords($value, $this->_language);
    }

}

?>
