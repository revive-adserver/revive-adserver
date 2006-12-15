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
 * @subpackage DataSelector
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: EveryNthPoint.php,v 1.6 2005/08/24 20:35:59 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/DataSelector.php
 */
require_once 'Image/Graph/DataSelector.php';

/**
 * Filter out all points except every Nth point.
 *
 * Use this dataselector if you have a large number of datapoints, but only want to
 * show markers for a small number of them, say every 10th.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage DataSelector
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_DataSelector_EveryNthPoint extends Image_Graph_DataSelector
{

    /**
     * The number of points checked
     * @var int
     * @access private
     */
    var $_pointNum = 0;

    /**
     * The number of points between every 'show', default: 10
     * @var int
     * @access private
     */
    var $_pointInterval = 10;

    /**
     * EvertNthPoint [Constructor]
     *
     * @param int $pointInterval The number of points between every 'show',
     *   default: 10
     */
    function Image_Graph_DataSelector_EveryNthpoint($pointInterval = 10)
    {
        parent::Image_Graph_DataSelector();
        $this->_pointInterval = $pointInterval;
    }

    /**
     * Check if a specified value should be 'selected', ie shown as a marker
     *
     * @param array $values The values to check
     * @return bool True if the Values should cause a marker to be shown,
     *   false if not
     * @access private
     */
    function _select($values)
    {
        $oldPointNum = $this->_pointNum;
        $this->_pointNum++;
        return (($oldPointNum % $this->_pointInterval) == 0);
    }

}

?>