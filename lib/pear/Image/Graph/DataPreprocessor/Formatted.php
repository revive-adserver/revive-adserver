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
 * @version    CVS: $Id: Formatted.php,v 1.6 2005/08/24 20:35:59 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/DataPreprocessor.php
 */
require_once 'Image/Graph/DataPreprocessor.php';

/**
 * Format data using a (s)printf pattern.
 *
 * This method is useful when data must displayed using a simple (s) printf
 * pattern as described in the {@link http://www.php. net/manual/en/function.
 * sprintf.php PHP manual}
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
class Image_Graph_DataPreprocessor_Formatted extends Image_Graph_DataPreprocessor
{

    /**
     * A (s)printf format string.
     * See {@link http://www.php.net/manual/en/function.sprintf.php PHP Manual}
     * for a description
     * @var string
     * @access private
     */
    var $_format;

    /**
     * Create a (s)printf format data preprocessor
     *
     * @param string $format See {@link http://www.php.net/manual/en/function.sprintf.php
     *   PHP Manual} for a description
     */
    function Image_Graph_DataPreprocessor_Formatted($format)
    {
        parent::Image_Graph_DataPreprocessor();
        $this->_format = $format;
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
        return sprintf($this->_format, $value);
    }

}

?>