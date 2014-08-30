<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Canvas
 *
 * Canvas class to handle PNG format.
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
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */
 
/**
 * Include file Image/Canvas/GD.php
 */
require_once 'Image/Canvas/GD.php';

/**
 * PNG Canvas class.
 * 
 * @category   Images
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */
class Image_Canvas_GD_PNG extends Image_Canvas_GD
{

    /**
     * Create the PNG canvas
     *
     * @param array $param Parameter array
     */
    function Image_Canvas_GD_PNG($param)
    {
        parent::Image_Canvas_GD($param);

        if ((isset($param['transparent'])) && ($param['transparent']) &&
            ($this->_gd2)
        ) {
            if ($param['transparent'] === true) {
                $transparent = '#123ABD';
            } else {
                $transparent = $param['transparent'];
            }
            $color = $this->_color($transparent);
            $trans = ImageColorTransparent($this->_canvas, $color);

            $this->rectangle(
                array(
                    'x0' => $this->_left,
                    'y0' => $this->_top,
                    'x1' => $this->_left + $this->_width - 1,
                    'y1' => $this->_top + $this->_height - 1,
                    'fill' => 'opague',
                    'line' => 'transparent'
                )
            );
        } else {
            $this->rectangle(
                array(
                    'x0' => $this->_left,
                    'y0' => $this->_top,
                    'x1' => $this->_left + $this->_width - 1,
                    'y1' => $this->_top + $this->_height - 1,
                    'fill' => 'white',
                    'line' => 'transparent'
                )
            );
        }
    }

    /**
     * Output the result of the canvas
     *
     * @param array $param Parameter array
     * @abstract
     */
    function show($param = false)
    {
        parent::show($param);
        header('Content-type: image/png');
        header('Content-Disposition: inline; filename = \"'. basename($_SERVER['PHP_SELF'], '.php') . '.png\"');
        ImagePNG($this->_canvas);
        ImageDestroy($this->_canvas);       
    }

        /**
     * Output the result of the canvas
     *
     * @param array $param Parameter array
     * @abstract
     */
    function save($param = false)
    {
        parent::save($param);
        ImagePNG($this->_canvas, $param['filename']);
        ImageDestroy($this->_canvas);
    }

}

?>
