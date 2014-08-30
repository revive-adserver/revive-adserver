<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - Main class for the graph creation.
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
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Font.php
 */
require_once 'Image/Graph/Font.php';

// Constant declarations

/**
 * Defines an X (horizontal) axis
 */
define('IMAGE_GRAPH_AXIS_X', 1);

/**
 * Defines an Y (vertical) axis
 */
define('IMAGE_GRAPH_AXIS_Y', 2);

/**
 * Defines an Y (vertical) axis
 */
define('IMAGE_GRAPH_AXIS_Y_SECONDARY', 3);

/**
 * Defines an horizontal (X) axis
 */
define('IMAGE_GRAPH_AXIS_HORIZONTAL', 1);

/**
 * Defines an vertical (Y) axis
 */
define('IMAGE_GRAPH_AXIS_VERTICAL', 2);

/**
 * Define if label should be shown for axis minimum value
 */
define('IMAGE_GRAPH_LABEL_MINIMUM', 1);

/**
 * Define if label should be shown for axis 0 (zero) value
 */
define('IMAGE_GRAPH_LABEL_ZERO', 2);

/**
 * Define if label should be shown for axis maximum value
 */
define('IMAGE_GRAPH_LABEL_MAXIMUM', 4);

/**
 * Defines a horizontal gradient fill
 */
define('IMAGE_GRAPH_GRAD_HORIZONTAL', 1);

/**
 * Defines a vertical gradient fill
 */
define('IMAGE_GRAPH_GRAD_VERTICAL', 2);

/**
 * Defines a horizontally mirrored gradient fill
 */
define('IMAGE_GRAPH_GRAD_HORIZONTAL_MIRRORED', 3);

/**
 * Defines a vertically mirrored gradient fill
 */
define('IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED', 4);

/**
 * Defines a diagonal gradient fill from top-left to bottom-right
 */
define('IMAGE_GRAPH_GRAD_DIAGONALLY_TL_BR', 5);

/**
 * Defines a diagonal gradient fill from bottom-left to top-right
 */
define('IMAGE_GRAPH_GRAD_DIAGONALLY_BL_TR', 6);

/**
 * Defines a radial gradient fill
 */
define('IMAGE_GRAPH_GRAD_RADIAL', 7);

/**
 * Defines the default builtin font
 */
define('IMAGE_GRAPH_FONT', 1);

/**
 * Defines a X value should be used
 */
define('IMAGE_GRAPH_VALUE_X', 0);

/**
 * Defines a Y value should be used
 */
define('IMAGE_GRAPH_VALUE_Y', 1);

/**
 * Defines a min X% value should be used
 */
define('IMAGE_GRAPH_PCT_X_MIN', 2);

/**
 * Defines a max X% value should be used
 */
define('IMAGE_GRAPH_PCT_X_MAX', 3);

/**
 * Defines a min Y% value should be used
 */
define('IMAGE_GRAPH_PCT_Y_MIN', 4);

/**
 * Defines a max Y% value should be used
 */
define('IMAGE_GRAPH_PCT_Y_MAX', 5);

/**
 * Defines a total Y% value should be used
 */
define('IMAGE_GRAPH_PCT_Y_TOTAL', 6);

/**
 * Defines a ID value should be used
 */
define('IMAGE_GRAPH_POINT_ID', 7);

/**
 * Align text left
 */
define('IMAGE_GRAPH_ALIGN_LEFT', 0x1);

/**
 * Align text right
 */
define('IMAGE_GRAPH_ALIGN_RIGHT', 0x2);

/**
 * Align text center x (horizontal)
 */
define('IMAGE_GRAPH_ALIGN_CENTER_X', 0x4);

/**
 * Align text top
 */
define('IMAGE_GRAPH_ALIGN_TOP', 0x8);

/**
 * Align text bottom
 */
define('IMAGE_GRAPH_ALIGN_BOTTOM', 0x10);

/**
 * Align text center y (vertical)
 */
define('IMAGE_GRAPH_ALIGN_CENTER_Y', 0x20);

/**
 * Align text center (both x and y)
 */
define('IMAGE_GRAPH_ALIGN_CENTER', IMAGE_GRAPH_ALIGN_CENTER_X + IMAGE_GRAPH_ALIGN_CENTER_Y);

/**
 * Align text top left
 */
define('IMAGE_GRAPH_ALIGN_TOP_LEFT', IMAGE_GRAPH_ALIGN_TOP + IMAGE_GRAPH_ALIGN_LEFT);

/**
 * Align text top right
 */
define('IMAGE_GRAPH_ALIGN_TOP_RIGHT', IMAGE_GRAPH_ALIGN_TOP + IMAGE_GRAPH_ALIGN_RIGHT);

/**
 * Align text bottom left
 */
define('IMAGE_GRAPH_ALIGN_BOTTOM_LEFT', IMAGE_GRAPH_ALIGN_BOTTOM + IMAGE_GRAPH_ALIGN_LEFT);

/**
 * Align text bottom right
 */
define('IMAGE_GRAPH_ALIGN_BOTTOM_RIGHT', IMAGE_GRAPH_ALIGN_BOTTOM + IMAGE_GRAPH_ALIGN_RIGHT);

/**
 * Align vertical
 */
define('IMAGE_GRAPH_ALIGN_VERTICAL', IMAGE_GRAPH_ALIGN_TOP);

/**
 * Align horizontal
 */
define('IMAGE_GRAPH_ALIGN_HORIZONTAL', IMAGE_GRAPH_ALIGN_LEFT);

// Error codes
define('IMAGE_GRAPH_ERROR_GENERIC', 0);

?>
