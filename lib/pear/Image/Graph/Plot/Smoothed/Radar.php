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
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Radar.php,v 1.10 2005/11/27 22:21:17 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 * @since      File available since Release 0.3.0dev2
 */

/**
 * Include file Image/Graph/Plot/Smoothed/Bezier.php
 */
require_once 'Image/Graph/Plot/Smoothed/Bezier.php';

/**
 * Smoothed radar chart.
 * 
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plot
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @since      Class available since Release 0.3.0dev2
 */
class Image_Graph_Plot_Smoothed_Radar extends Image_Graph_Plot_Smoothed_Bezier
{

    /**
     * Output the plot
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        $this->_canvas->startGroup(get_class($this) . '_' . $this->_title);
        $this->_clip(true);
        if (is_a($this->_parent, 'Image_Graph_Plotarea_Radar')) {
            $keys = array_keys($this->_dataset);
            foreach ($keys as $key) {
                $dataset =& $this->_dataset[$key];
                if ($dataset->count() >= 3) {
                    $dataset->_reset();
                    $p1_ = $dataset->_next();
                    $p2_ = $dataset->_next();
                    $p3_ = $dataset->_next();
                    $plast_ = false;
                    if ($p3_) {
                        while ($p = $dataset->_next()) {
                            $plast_ = $p;
                        }
                    }

                    if ($plast_ === false) {
                        $plast_ = $p3_;
                    }
                    $dataset->_reset();
                    while ($p1 = $dataset->_next()) {
                        $p0 = $dataset->_nearby(-2);
                        $p2 = $dataset->_nearby(0);
                        $p3 = $dataset->_nearby(1);

                        if ($p0 === false) {
                            $p0 = $plast_;
                        }

                        if ($p2 === false) {
                            $p2 = $p1_;
                            $p3 = $p2_;
                        } elseif ($p3 === false) {
                            $p3 = $p1_;
                        }


                        $cp = $this->_getControlPoints($p1, $p0, $p2, $p3);
                        $this->_canvas->addSpline(
	                    	array(
	                        	'x' => $cp['X'],
	                        	'y' => $cp['Y'],
	                        	'p1x' => $cp['P1X'],
	                        	'p1y' => $cp['P1Y'],
	                        	'p2x' => $cp['P2X'],
	                        	'p2y' => $cp['P2Y']
	                        )
	                    );

                        $next2last = $p0;
                        $last = $p1;
                    }

                    $cp = $this->_getControlPoints($p1_, $plast_, $p2_, $p3_);
                    $this->_canvas->addSpline(
                    	array(
                        	'x' => $cp['X'],
                        	'y' => $cp['Y'],
                        	'p1x' => $cp['P1X'],
                        	'p1y' => $cp['P1Y'],
                        	'p2x' => $cp['P2X'],
                        	'p2y' => $cp['P2Y']
                        )
                    );
                    $this->_getFillStyle($key);
                    $this->_getLineStyle($key);
                    $this->_canvas->polygon(array('connect' => true));
                }
            }
            unset($keys);
        }
        $this->_drawMarker();
        $this->_clip(false);
        $this->_canvas->endGroup($this->_title);
        return parent::_done();
    }

}

?>