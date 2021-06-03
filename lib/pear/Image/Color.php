<?php
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
// | Authors: Jason Lotito <jason@lehighweb.com>                          |
// |          Ulf Wendel <ulf.wendel@phpdoc.de>                           |
// |          Sebastian Bergmann <sb@sebastian-bergmann.de>               |
// |          Laurent Laville <pear@laurent-laville.org>                  |
// +----------------------------------------------------------------------+

/**
*    Color
*    Handles and manages color mixing.
*
*    TODO: Eventually, I would like to expand upon this class to include other
*    color types, and make it handle colors in a cleaner manner, however, as of
*    right now, I would rather get it out rather than remain vaporware.  At least
*    this way, other people can take a look at it, and make suggestions.
*    Besides, someone else might get more use out of it than I.
*
*    The class is really simple to use, and pretty much does its job fairly well.
*    A sample of what can be done with this class is found here:
*        http://www.newbienetwork.net/class.colour.php
*    As you can well see, it is very good at what it does, and is rather quick.
*    If someone has ideas or thoughts on this, please let me know.  I would like
*    expand it to handling image colors, as well as converting to CMYK, and even
*    the dreaded Pantone(TM) colors!  If someone knows of converting algo's or
*    know of anything that might be of interest to me, let me know =).
*    about it to.
*
*    Also, one more thing - Yes, I know, I will be try to get off the setColors()
*    2 color limitation, but since this script started out as a simple function
*    that could _mix_ to colors together, it just kept going like that.
*
*   If you notice, the version is only 0.1.  This is because I don't know of
*   anyone really using it, and so it hasn't been tested completely.  The more
*   input I get back on it, the closer it goes to a 1.0 release.
*
*   @version    0.2
*   @author     Jason Lotito <jason@lehighweb.com>
*/
class Image_Color
{
    /**
    *   first color that the class handles for ranges and mixes.
    *   @access private
    *   @see    setColors
    */
    var $color1 = array();

    /**
    *   second color that the class handles for ranges and mixes.
    *	@access private
    */
    var $color2 = array();

    /**
    *   Boolean value for determining whether colors outputted should be websafe or not.  Defaults to false.
    *	@access private
    *   @see    setWebSafe
    */
    var $_websafeb = false;

    /**
    *   the websafe ranges we use to determine where to set each value.  The key
    *   is the websafe part, and the value is the non-websafe value.
    *	@access private
    */
    var $websafe = array(   '00' => '00',
                            '33' => '51',
                            '66' => '102',
                            '99' => '153',
                            'cc' => '204',
                            'ff' => '255');

    /**
    *    mixColors
    *    Given two colors, this will return a mix of the two together.
    *
    *    @access    public
    *    @param    string(optional)    $col1    The first color you want to mix
    *    @param    string(optional)    $col2    The second color you want to mix
    *    @result    string                        The mixed color.
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    function mixColors ( $col1=false, $col2=false )
    {
        if ( $col1 )
        {
            $this->_setColors($col1, $col2);
        }

        // RED
        $color3[0] = ( $this->color1[0] + $this->color2[0] ) / 2;
        // GREEN
        $color3[1] = ( $this->color1[1] + $this->color2[1] ) / 2;
        // BLUE
        $color3[2] = ( $this->color1[2] + $this->color2[2] ) / 2;

        if ( $this->_websafeb )
        {
            array_walk( $color3, '_makeWebSafe' );
        }

        return $this->_returnColor( $color3 );
    }

    /**
    *    setWebSafe
    *    Sets whether we should output websafe colors or not.
    *
    *    @access    public
    *    @param    bool=true    If set to true (def.), websafe is on, otherwise not.
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    function setWebSafe( $bool=true )
    {
        $this->_websafeb = $bool;
    }

    /**
    *    setColors
    *    This class primarily works with two colors, and using this function, you
    *    can easily set both colors.
    *
    *    @access    public
    *    @param    string    The first color in hex format
    *    @param    string    The second color in hex format
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    function setColors( $col1, $col2 )
    {
        $this->_setColors($col1, $col2);
    }

    /**
    *   getRange
    *   Given a degree, you can get the range of colors between one color and
    *   another color.
    *
    *   @access     public
    *   @param      string  $degrees How much each 'step' between the colors we should take.
    *   @return     array   Returns an array of all the colors, one element for each color.
    *   @author     Jason Lotito <jason@lehighweb.com>
    */
    function getRange ( $degrees=2 )
    {
        if ( $degrees == 0 )
            $degrees = 1;

        /**
        The degrees give us how much we should advance each color at each phase
        of the loop.  This way, the advance is equal throughout all the colors.

        TODO: Allow for degrees for individual parts of the colors.
        */

        // RED
        $red_steps   = ( $this->color2[0] - $this->color1[0] ) / $degrees;
        // GREEN
        $green_steps = ( $this->color2[1] - $this->color1[1] ) / $degrees;
        // BLUE
        $blue_steps  = ( $this->color2[2] - $this->color1[2] ) / $degrees;

        $allcolors = array();
        $x = 0;

        /**
        The loop stops once any color has gone beyond the end color.
        */

        // Loop through all the degrees between the colors
        for ( $x = 0; $x < $degrees; $x++ )
        {
            $col[0] = $red_steps * $x;
            $col[1] = $green_steps * $x;
            $col[2] = $blue_steps * $x;

            // Loop through each R, G, and B
            for ( $i = 0; $i < 3; $i++ )
            {
                $partcolor = $this->color1[$i] + $col[$i];
                // If the color is less than 256
                if (  $partcolor < 256 )
                {
                    // Makes sure the colors is not less than 0
                    if ( $partcolor > -1 )
                    {
                        $newcolor[$i] = $partcolor;
                    } else {
                        $newcolor[$i] = 0;
                    }
                // Color was greater than 255
                } else {
                    $newcolor[$i] = 255;
                }
            }

            if ( $this->_websafeb )
            {
                array_walk( $newcolor, '_makeWebSafe' );
            }

            $allcolors[] = $this->_returnColor($newcolor);
        }


        return $allcolors;
    }

    /**
    *    changeLightness
    *    Changes the lightness of the color.
    *
    *    The argument it takes determines the direction to go.  If you give it a
    *    negative number, it will make the color darker, however, if you give it
    *    a positive number, it gets lighter.
    *    @access public
    *    @param    int    degree    The degree of the change you wish to take place.
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    function changeLightness ( $degree=10 )
    {
        $color2 =& $this->color2;
        $color1 =& $this->color1;

        for ( $x = 0; $x < 3; $x++ )
        {
            if ( ( $color1[$x] + $degree ) < 256 )
            {
                if ( ( $color1[$x] + $degree ) > -1 )
                {
                    $color1[$x] += $degree;
                } else {
                    $color1[$x] = 0;
                }
            } else {
                $color1[$x] = 255;
            }
        }

        for ( $x = 0; $x < 3; $x++ )
        {
            if ( ( $color2[$x] + $degree ) < 256 )
            {
                if ( ( $color2[$x] + $degree ) > -1 )
                {
                    $color2[$x] += $degree;
                } else {
                    $color2[$x] = 0;
                }
            } else {
                $color2[$x] = 255;
            }
        }
    }

    /**
    *    getTextColor
    *    Given a color, will return whether you should use a dark font or a light font.
    *
    *    You can change the dark and the light color, however by default, they are
    *    set to be 'white' (ffffff) and 'black' (000000), which are standard text
    *    colors.  This is determined by the G(reen) value of RGB.
    *
    *   @access     public
    *   @param      string  $color  The color to analyze
    *   @param      string  $light(optional) The light color value to return if we should have light text
    *   @param      string  $dark(optional) The dark color value to return if we should have dark text
    *   @author     Jason Lotito <jason@lehighweb.com>
    */
    function getTextColor ( $color, $light='FFFFFF', $dark='000000' )
    {
        $color = Image_Color::_splitColor($color);
        if ( $color[1] > hexdec('66') )
        {
            return $dark;
        } else {
            return $light;
        }
    }

    /**
    *    _setColors
    *    Internal method to correctly set the colors.
    *
    *    @access    private
    *    @param    string    Color 1
    *    @param    string     Color 2
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    function _setColors ( $col1, $col2 )
    {
        $this->color1 = Image_Color::_splitColor($col1);
        $this->color2 = Image_Color::_splitColor($col2);
    }

    /**
    *    _splitColor
    *    Given a color, it will properly split it up into a 3 element dec. array.
    *
    *    @access    private
    *    @param    string    The color.
    *    @return    array    3 element array containing the RGB information.
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    public static function _splitColor ( $color )
    {
        $color = str_replace('#', '', $color);
        $c[] = hexdec( substr( $color, 0, 2 ) );
        $c[] = hexdec( substr( $color, 2, 2 ) );
        $c[] = hexdec( substr( $color, 4, 2 ) );
        return $c;
    }

    /**
    *    _returnColor
    *    Given an array of 3 elements containing RGB decimal information, it will
    *    return an HTML compatible HEX color.
    *
    *    @access    private
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    function _returnColor ( $color )
    {
        return sprintf('%02X%02X%02X',$color[0],$color[1],$color[2]);
    }

    /**
    *    rgb2hex
    *    Given an array of 3 elements containing RGB information, it will return
    *    a string of the HEX color.
    *
    *    @access    public
    *    @param    array    3 element array.
    *    @return string
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    function rgb2hex ( $color )
    {
        return Image_Color::_returnColor( $color );
    }

    /**
    *    hex2rgb
    *    Given a hex color, returns a 4 element array, with keys 0-2 containing
    *    the RGB values appropriately and with key 3 containing the original
    *    color.
    *
    *    @access    public
    *    @param    string    The HEX string of the color.
    *    @return    array    4 element array.
    *    @author    Jason Lotito <jason@lehighweb.com>
    */
    public static function hex2rgb ( $hex )
    {
        $return = Image_Color::_splitColor( $hex );
        $return['hex'] = $hex;
        return $return;
    }

    /**
    *   hsv2rgb
    *   Converts a HSV (Hue, Saturation, Brightness) value to RGB.
    *
    *   @access public
    *   @param  integer $h  Hue
    *   @param  integer $s  Saturation
    *   @param  integer $v  Brightness
    *   @return string      The RGB value.
    *   @author    Jason Lotito <jason@lehighweb.com>
    */
    function hsv2rgb ( $h, $s, $v )
    {
        return Image_Color::hex2rgb(Image_Color::hsv2hex($h, $s, $v));
    }

    /**
    *   hsv2hex
    *   Converts a HSV (Hue, Saturation, Brightness) value to Hexidecimal.
    *
    *   Originally written by @author.  Integrated into Class by Jason Lotito.
    *
    *   @access public
    *   @param  integer $h  Hue
    *   @param  integer $s  Saturation
    *   @param  integer $v  Brightness
    *   @return string      The hex value.
    *	@author	@author	Jurgen Schwietering <jurgen@schwietering.com>
    */
    function hsv2hex ( $h, $s, $v )
    {
        $s /= 256.0;
        $v /= 256.0;
        if ( $s == 0.0 )
        {
            $r = $g = $b = $v;
            return '';
        } else {
            $h = $h/256.0*6.0;
            $i = floor($h);
            $f = $h - $i;

            $v *= 256.0;
            $p = (integer)($v * (1.0 - $s));
            $q = (integer)($v * (1.0 - $s * $f));
            $t = (integer)($v * (1.0 - $s * (1.0 - $f)));
            switch( $i )
            {
                case 0:
                    $r = $v;
                    $g = $t;
                    $b = $p;
                    break;
                case 1:
                    $r = $q;
                    $g = $v;
                    $b = $p;
                    break;
                case 2:
                    $r = $p;
                    $g = $v;
                    $b = $t;
                    break;
                case 3:
                    $r = $p;
                    $g = $q;
                    $b = $v;
                    break;
                case 4:
                    $r = $t;
                    $g = $p;
                    $b = $v;
                    break;
                default:
                    $r = $v;
                    $g = $p;
                    $b = $q;
                    break;
            }
        }

        $newcolor = array($r, $g, $b);

        return $this->_returnColor($newcolor);
    }

    /**
    * Allocates a color in the given image.
    *
    * Userdefined color specifications get translated into
    * an array of rgb values.
    *
    * @param    resource    Image handle
    * @param    mixed       (Userdefined) color specification
    * @return   resource    Image color handle
    * @see      color2RGB()
    * @access   public
    */
    public static function allocateColor(&$img, $color) {
        $color = Image_Color::color2RGB($color);

        return ImageColorAllocate($img, $color[0], $color[1], $color[2]);
    }

    /**
    * @access   public
    * @static
    * @author   Laurent Laville <pear@laurent-laville.org>
    */
    public static function color2RGB($color)
    {
        $c = array();

        if ($color[0] == '#') {
            $c = Image_Color::hex2rgb($color);
        } else {
             $c = Image_Color::namedColor2RGB($color);
        }

        return $c;
    }

    /**
    * Returns the RGB interger values of a named color, [0,0,0] if unknown.
    *
    * The static variable $colornames is used to resolve
    * the color names. Modify it if neccessary.
    *
    * @param    string  Case insensitive color name.
    * @return   array   [int red, int green, int blue],
    *                   returns black [0, 0, 0] if the color is unknown.
    * @access   public
    * @static
    * @author   Sebastian Bergmann <sb@sebastian-bergmann.de>
    */
    public static function namedColor2RGB($color)
    {
        static $colornames;

        if (!isset($colornames)) {
            $colornames = array(
              'aliceblue'             => array(240, 248, 255),
              'antiquewhite'          => array(250, 235, 215),
              'aqua'                  => array(  0, 255, 255),
              'aquamarine'            => array(127, 255, 212),
              'azure'                 => array(240, 255, 255),
              'beige'                 => array(245, 245, 220),
              'bisque'                => array(255, 228, 196),
              'black'                 => array(  0,   0,   0),
              'blanchedalmond'        => array(255, 235, 205),
              'blue'                  => array(  0,   0, 255),
              'blueviolet'            => array(138,  43, 226),
              'brown'                 => array(165,  42,  42),
              'burlywood'             => array(222, 184, 135),
              'cadetblue'             => array( 95, 158, 160),
              'chartreuse'            => array(127, 255,   0),
              'chocolate'             => array(210, 105,  30),
              'coral'                 => array(255, 127,  80),
              'cornflowerblue'        => array(100, 149, 237),
              'cornsilk'              => array(255, 248, 220),
              'crimson'               => array(220,  20,  60),
              'cyan'                  => array(  0, 255, 255),
              'darkblue'              => array(  0,   0,  13),
              'darkcyan'              => array(  0, 139, 139),
              'darkgoldenrod'         => array(184, 134,  11),
              'darkgray'              => array(169, 169, 169),
              'darkgreen'             => array(  0, 100,   0),
              'darkkhaki'             => array(189, 183, 107),
              'darkmagenta'           => array(139,   0, 139),
              'darkolivegreen'        => array( 85, 107,  47),
              'darkorange'            => array(255, 140,   0),
              'darkorchid'            => array(153,  50, 204),
              'darkred'               => array(139,   0,   0),
              'darksalmon'            => array(233, 150, 122),
              'darkseagreen'          => array(143, 188, 143),
              'darkslateblue'         => array( 72,  61, 139),
              'darkslategray'         => array( 47,  79,  79),
              'darkturquoise'         => array(  0, 206, 209),
              'darkviolet'            => array(148,   0, 211),
              'deeppink'              => array(255,  20, 147),
              'deepskyblue'           => array(  0, 191, 255),
              'dimgray'               => array(105, 105, 105),
              'dodgerblue'            => array( 30, 144, 255),
              'firebrick'             => array(178,  34,  34),
              'floralwhite'           => array(255, 250, 240),
              'forestgreen'           => array( 34, 139,  34),
              'fuchsia'               => array(255,   0, 255),
              'gainsboro'             => array(220, 220, 220),
              'ghostwhite'            => array(248, 248, 255),
              'gold'                  => array(255, 215,   0),
              'goldenrod'             => array(218, 165,  32),
              'gray'                  => array(128, 128, 128),
              'green'                 => array(  0, 128,   0),
              'greenyellow'           => array(173, 255,  47),
              'honeydew'              => array(240, 255, 240),
              'hotpink'               => array(255, 105, 180),
              'indianred'             => array(205,  92,  92),
              'indigo'                => array(75,    0, 130),
              'ivory'                 => array(255, 255, 240),
              'khaki'                 => array(240, 230, 140),
              'lavender'              => array(230, 230, 250),
              'lavenderblush'         => array(255, 240, 245),
              'lawngreen'             => array(124, 252,   0),
              'lemonchiffon'          => array(255, 250, 205),
              'lightblue'             => array(173, 216, 230),
              'lightcoral'            => array(240, 128, 128),
              'lightcyan'             => array(224, 255, 255),
              'lightgoldenrodyellow'  => array(250, 250, 210),
              'lightgreen'            => array(144, 238, 144),
              'lightgrey'             => array(211, 211, 211),
              'lightpink'             => array(255, 182, 193),
              'lightsalmon'           => array(255, 160, 122),
              'lightseagreen'         => array( 32, 178, 170),
              'lightskyblue'          => array(135, 206, 250),
              'lightslategray'        => array(119, 136, 153),
              'lightsteelblue'        => array(176, 196, 222),
              'lightyellow'           => array(255, 255, 224),
              'lime'                  => array(  0, 255,   0),
              'limegreen'             => array( 50, 205,  50),
              'linen'                 => array(250, 240, 230),
              'magenta'               => array(255,   0, 255),
              'maroon'                => array(128,   0,   0),
              'mediumaquamarine'      => array(102, 205, 170),
              'mediumblue'            => array(  0,   0, 205),
              'mediumorchid'          => array(186,  85, 211),
              'mediumpurple'          => array(147, 112, 219),
              'mediumseagreen'        => array( 60, 179, 113),
              'mediumslateblue'       => array(123, 104, 238),
              'mediumspringgreen'     => array(  0, 250, 154),
              'mediumturquoise'       => array(72, 209, 204),
              'mediumvioletred'       => array(199,  21, 133),
              'midnightblue'          => array( 25,  25, 112),
              'mintcream'             => array(245, 255, 250),
              'mistyrose'             => array(255, 228, 225),
              'moccasin'              => array(255, 228, 181),
              'navajowhite'           => array(255, 222, 173),
              'navy'                  => array(  0,   0, 128),
              'oldlace'               => array(253, 245, 230),
              'olive'                 => array(128, 128,   0),
              'olivedrab'             => array(107, 142,  35),
              'orange'                => array(255, 165,   0),
              'orangered'             => array(255,  69,   0),
              'orchid'                => array(218, 112, 214),
              'palegoldenrod'         => array(238, 232, 170),
              'palegreen'             => array(152, 251, 152),
              'paleturquoise'         => array(175, 238, 238),
              'palevioletred'         => array(219, 112, 147),
              'papayawhip'            => array(255, 239, 213),
              'peachpuff'             => array(255, 218, 185),
              'peru'                  => array(205, 133,  63),
              'pink'                  => array(255, 192, 203),
              'plum'                  => array(221, 160, 221),
              'powderblue'            => array(176, 224, 230),
              'purple'                => array(128,   0, 128),
              'red'                   => array(255,   0,   0),
              'rosybrown'             => array(188, 143, 143),
              'royalblue'             => array( 65, 105, 225),
              'saddlebrown'           => array(139,  69,  19),
              'salmon'                => array(250, 128, 114),
              'sandybrown'            => array(244, 164,  96),
              'seagreen'              => array( 46, 139,  87),
              'seashell'              => array(255, 245, 238),
              'sienna'                => array(160,  82,  45),
              'silver'                => array(192, 192, 192),
              'skyblue'               => array(135, 206, 235),
              'slateblue'             => array(106,  90, 205),
              'slategray'             => array(112, 128, 144),
              'snow'                  => array(255, 250, 250),
              'springgreen'           => array(  0, 255, 127),
              'steelblue'             => array( 70, 130, 180),
              'tan'                   => array(210, 180, 140),
              'teal'                  => array(  0, 128, 128),
              'thistle'               => array(216, 191, 216),
              'tomato'                => array(255,  99,  71),
              'turquoise'             => array( 64, 224, 208),
              'violet'                => array(238, 130, 238),
              'wheat'                 => array(245, 222, 179),
              'white'                 => array(255, 255, 255),
              'whitesmoke'            => array(245, 245, 245),
              'yellow'                => array(255, 255,   0),
              'yellowgreen'           => array(154, 205,  50)
            );
        }

        $color = strtolower($color);

        if (!isset($colornames[$color])) {
            return array(0, 0, 0);
        }

        return $colornames[$color];
    }

    /**
    * Returns the RGB integer values of a color specified by a "percentage string" like "50%,20%,100%".
    *
    * @param    string
    * @return   array   [int red, int green, int blue]
    * @access   public
    */
    function percentageColor2RGB($color) {
        // split the string 50%,20%,100% by ,
        $color = explode(",", $color);

        foreach ($color as $k => $v) {
            // remove the trailing percentage sign %
            $v = (int)substr($v, 1);

            // range checks
            if ($v >= 100) {
                $color[$k] = 255;
            } else if ($v <= 0) {
                $color[$k] = 0;
            } else {
                $color[$k] = (int)(2.55 * $v);
            }
        }

        return $color;
    }
}

// For Array Walk
// {{{
    /**
    *    _makeWebSafe
    *    Function for array_walk() to easily change colors from whatever to
    *    the closests websafe representation.
    *
    *    @access   private
    *    @param    int        One element of the decimal RGB value of a color.
    *    @return   int        The websafe equivalent of the color setting.
    *    @author   Jason Lotito <jason@lehighweb.com>
    */
    function _makeWebSafe ( &$color )
    {
        if ( $color == 0 )
        {
            return $color;
        } else {
            if ( ($color % 51) == 0 )
            {
                return $color;
            } else {
                if ( $color < 26 ) {
                    $color = 00;
                    return $color;
                } else if ( $color < 77 && $color > 25 ) {
                    $color = 51;
                    return $color;
                } else if ( $color > 76 && $color < 127 ) {
                    $color = 102;
                    return $color;
                } else if ( $color > 126 && $color < 178 ) {
                    $color = 153;
                    return $color;
                } else if ( $color > 177 && $color < 229 ) {
                    $color = 204;
                    return $color;
                } else {
                    $color = 255;
                    return $color;
                }
            }
        }
    }
// }}}

/*
* Local variables:
* tab-width: 4
* c-basic-offset: 4
* End:
*/
?>
