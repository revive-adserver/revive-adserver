<?php

/**
 *	base include file for SimpleTest
 *	@package	SimpleTest
 *	@subpackage	WebTester
 */

/**#@+
 *	include other SimpleTest class files
 */
require_once(__DIR__ . '/encoding.php');
/**#@-*/

/**
 *    URL parser to replace parse_url() PHP function which
 *    got broken in PHP 4.3.0. Adds some browser specific
 *    functionality such as expandomatics.
 *    Guesses a bit trying to separate the host from
 *    the path and tries to keep a raw, possibly unparsable,
 *    request string as long as possible.
 *    @package SimpleTest
 *    @subpackage WebTester
 */
class SimpleUrl
{
    public $_scheme;
    public $_username;
    public $_password;
    public $_host;
    public $_port = false;
    public $_path;
    public $_request;
    public $_fragment;
    public $_x;
    public $_y;
    public $_target;
    public $_raw = false;

    /**
     *    Constructor. Parses URL into sections.
     *    @param string $url        Incoming URL.
     */
    public function __construct($url)
    {
        [$x, $y] = $this->_chompCoordinates($url);
        $this->setCoordinates($x, $y);
        $this->_scheme = $this->_chompScheme($url);
        [$this->_username, $this->_password] = $this->_chompLogin($url);
        $this->_host = $this->_chompHost($url);
        if (preg_match('/(.*?):(.*)/', $this->_host, $host_parts)) {
            $this->_host = $host_parts[1];
            $this->_port = (int) $host_parts[2];
        }
        $this->_path = $this->_chompPath($url);
        $this->_request = $this->_parseRequest($this->_chompRequest($url));
        $this->_fragment = (str_starts_with($url, "#") ? substr($url, 1) : false);
        $this->_target = false;
    }

    /**
     *    Extracts the X, Y coordinate pair from an image map.
     *    @param string $url   URL so far. The coordinates will be
     *                         removed.
     *    @return array        X, Y as a pair of integers.
     *    @access private
     */
    public function _chompCoordinates(&$url)
    {
        if (preg_match('/(.*)\?(\d+),(\d+)$/', $url, $matches)) {
            $url = $matches[1];
            return [(int) $matches[2], (int) $matches[3]];
        }
        return [false, false];
    }

    /**
     *    Extracts the scheme part of an incoming URL.
     *    @param string $url   URL so far. The scheme will be
     *                         removed.
     *    @return string       Scheme part or false.
     *    @access private
     */
    public function _chompScheme(&$url)
    {
        if (preg_match('/(.*?):(\/\/)(.*)/', $url, $matches)) {
            $url = $matches[2] . $matches[3];
            return $matches[1];
        }
        return false;
    }

    /**
     *    Extracts the username and password from the
     *    incoming URL. The // prefix will be reattached
     *    to the URL after the doublet is extracted.
     *    @param string $url    URL so far. The username and
     *                          password are removed.
     *    @return array         Two item list of username and
     *                          password. Will urldecode() them.
     *    @access private
     */
    public function _chompLogin(&$url)
    {
        $prefix = '';
        if (preg_match('/^(\/\/)(.*)/', $url, $matches)) {
            $prefix = $matches[1];
            $url = $matches[2];
        }
        if (preg_match('/(.*?)@(.*)/', $url, $matches)) {
            $url = $prefix . $matches[2];
            $parts = preg_split("/:/D", $matches[1]);
            return [
                urldecode($parts[0]),
                isset($parts[1]) ? urldecode($parts[1]) : false];
        }
        $url = $prefix . $url;
        return [false, false];
    }

    /**
     *    Extracts the host part of an incoming URL.
     *    Includes the port number part. Will extract
     *    the host if it starts with // or it has
     *    a top level domain or it has at least two
     *    dots.
     *    @param string $url    URL so far. The host will be
     *                          removed.
     *    @return string        Host part guess or false.
     *    @access private
     */
    public function _chompHost(&$url)
    {
        if (preg_match('/^(\/\/)(.*?)(\/.*|\?.*|#.*|$)/', $url, $matches)) {
            $url = $matches[3];
            return $matches[2];
        }
        if (preg_match('/(.*?)(\.\.\/|\.\/|\/|\?|#|$)(.*)/', $url, $matches)) {
            $tlds = SimpleUrl::getAllTopLevelDomains();
            if (preg_match('/[a-z0-9\-]+\.(' . $tlds . ')/i', $matches[1])) {
                $url = $matches[2] . $matches[3];
                return $matches[1];
            }
            if (preg_match('/[a-z0-9\-]+\.[a-z0-9\-]+\.[a-z0-9\-]+/i', $matches[1])) {
                $url = $matches[2] . $matches[3];
                return $matches[1];
            }
        }
        return false;
    }

    /**
     *    Extracts the path information from the incoming
     *    URL. Strips this path from the URL.
     *    @param string $url     URL so far. The host will be
     *                           removed.
     *    @return string         Path part or '/'.
     *    @access private
     */
    public function _chompPath(&$url)
    {
        if (preg_match('/(.*?)(\?|#|$)(.*)/', $url, $matches)) {
            $url = $matches[2] . $matches[3];
            return ($matches[1] ?: '');
        }
        return '';
    }

    /**
     *    Strips off the request data.
     *    @param string $url  URL so far. The request will be
     *                        removed.
     *    @return string      Raw request part.
     *    @access private
     */
    public function _chompRequest(&$url)
    {
        if (preg_match('/\?(.*?)(#|$)(.*)/', $url, $matches)) {
            $url = $matches[2] . $matches[3];
            return $matches[1];
        }
        return '';
    }

    /**
     *    Breaks the request down into an object.
     *    @param string $raw           Raw request.
     *    @return SimpleFormEncoding    Parsed data.
     *    @access private
     */
    public function _parseRequest($raw)
    {
        $this->_raw = $raw;
        $request = new SimpleGetEncoding();
        foreach (preg_split("/&/D", $raw) as $pair) {
            if (preg_match('/(.*?)=(.*)/', $pair, $matches)) {
                $request->add($matches[1], urldecode($matches[2]));
            } elseif ($pair) {
                $request->add($pair, '');
            }
        }
        return $request;
    }

    /**
     *    Accessor for protocol part.
     *    @param string $default    Value to use if not present.
     *    @return string            Scheme name, e.g "http".
     */
    public function getScheme($default = false)
    {
        return $this->_scheme ?: $default;
    }

    /**
     *    Accessor for user name.
     *    @return string    Username preceding host.
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     *    Accessor for password.
     *    @return string    Password preceding host.
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     *    Accessor for hostname and port.
     *    @param string $default    Value to use if not present.
     *    @return string            Hostname only.
     */
    public function getHost($default = false)
    {
        return $this->_host ?: $default;
    }

    /**
     *    Accessor for top level domain.
     *    @return string       Last part of host.
     */
    public function getTld()
    {
        $path_parts = pathinfo($this->getHost());
        return ($path_parts['extension'] ?? false);
    }

    /**
     *    Accessor for port number.
     *    @return integer    TCP/IP port number.
     */
    public function getPort()
    {
        return $this->_port;
    }

    /**
      *    Accessor for path.
      *    @return string    Full path including leading slash if implied.
       */
    public function getPath()
    {
        if (! $this->_path && $this->_host) {
            return '/';
        }
        return $this->_path;
    }

    /**
     *    Accessor for page if any. This may be a
     *    directory name if ambiguious.
     *    @return            Page name.
     */
    public function getPage()
    {
        if (! preg_match('/([^\/]*?)$/', $this->getPath(), $matches)) {
            return false;
        }
        return $matches[1];
    }

    /**
     *    Gets the path to the page.
     *    @return string       Path less the page.
     */
    public function getBasePath()
    {
        if (! preg_match('/(.*\/)[^\/]*?$/', $this->getPath(), $matches)) {
            return false;
        }
        return $matches[1];
    }

    /**
     *    Accessor for fragment at end of URL after the "#".
     *    @return string    Part after "#".
     */
    public function getFragment()
    {
        return $this->_fragment;
    }

    /**
     *    Sets image coordinates. Set to false to clear
     *    them.
     *    @param integer $x    Horizontal position.
     *    @param integer $y    Vertical position.
     */
    public function setCoordinates($x = false, $y = false)
    {
        if (($x === false) || ($y === false)) {
            $this->_x = $this->_y = false;
            return;
        }
        $this->_x = (int) $x;
        $this->_y = (int) $y;
    }

    /**
     *    Accessor for horizontal image coordinate.
     *    @return integer        X value.
     */
    public function getX()
    {
        return $this->_x;
    }

    /**
     *    Accessor for vertical image coordinate.
     *    @return integer        Y value.
     */
    public function getY()
    {
        return $this->_y;
    }

    /**
     *    Accessor for current request parameters
     *    in URL string form. Will return teh original request
     *    if at all possible even if it doesn't make much
     *    sense.
     *    @return string   Form is string "?a=1&b=2", etc.
     */
    public function getEncodedRequest()
    {
        if ($this->_raw) {
            $encoded = $this->_raw;
        } else {
            $encoded = $this->_request->asUrlRequest();
        }
        if ($encoded) {
            return '?' . preg_replace('/^\?/', '', $encoded);
        }
        return '';
    }

    /**
     *    Adds an additional parameter to the request.
     *    @param string $key            Name of parameter.
     *    @param string $value          Value as string.
     */
    public function addRequestParameter($key, $value)
    {
        $this->_raw = false;
        $this->_request->add($key, $value);
    }

    /**
     *    Adds additional parameters to the request.
     *    @param hash/SimpleFormEncoding $parameters   Additional
     *                                                parameters.
     */
    public function addRequestParameters($parameters)
    {
        $this->_raw = false;
        $this->_request->merge($parameters);
    }

    /**
     *    Clears down all parameters.
     */
    public function clearRequest()
    {
        $this->_raw = false;
        $this->_request = new SimpleGetEncoding();
    }

    /**
     *    Gets the frame target if present. Although
     *    not strictly part of the URL specification it
     *    acts as similarily to the browser.
     *    @return boolean/string    Frame name or false if none.
     */
    public function getTarget()
    {
        return $this->_target;
    }

    /**
     *    Attaches a frame target.
     *    @param string $frame        Name of frame.
     */
    public function setTarget($frame)
    {
        $this->_raw = false;
        $this->_target = $frame;
    }

    /**
     *    Renders the URL back into a string.
     *    @return string        URL in canonical form.
     */
    public function asString()
    {
        $scheme = $identity = $host = $path = $encoded = $fragment = '';
        if ($this->_username && $this->_password) {
            $identity = $this->_username . ':' . $this->_password . '@';
        }
        if ($this->getHost()) {
            $scheme = $this->getScheme() ?: 'http';
            $host = $this->getHost();
        }
        if (str_starts_with($this->_path, '/')) {
            $path = $this->normalisePath($this->_path);
        }
        $encoded = $this->getEncodedRequest();
        $fragment = $this->getFragment() ? '#' . $this->getFragment() : '';
        $coords = $this->getX() === false ? '' : '?' . $this->getX() . ',' . $this->getY();
        return "$scheme://$identity$host$path$encoded$fragment$coords";
    }

    /**
     *    Replaces unknown sections to turn a relative
     *    URL into an absolute one. The base URL can
     *    be either a string or a SimpleUrl object.
     *    @param string/SimpleUrl $base       Base URL.
     */
    public function makeAbsolute($base)
    {
        if (! is_object($base)) {
            $base = new SimpleUrl($base);
        }
        $scheme = $this->getScheme() ?: $base->getScheme();
        if ($this->getHost()) {
            $host = $this->getHost();
            $port = $this->getPort() ? ':' . $this->getPort() : '';
            $identity = $this->getIdentity() ? $this->getIdentity() . '@' : '';
            if (! $identity) {
                $identity = $base->getIdentity() ? $base->getIdentity() . '@' : '';
            }
        } else {
            $host = $base->getHost();
            $port = $base->getPort() ? ':' . $base->getPort() : '';
            $identity = $base->getIdentity() ? $base->getIdentity() . '@' : '';
        }
        $path = $this->normalisePath($this->_extractAbsolutePath($base));
        $encoded = $this->getEncodedRequest();
        $fragment = $this->getFragment() ? '#' . $this->getFragment() : '';
        $coords = $this->getX() === false ? '' : '?' . $this->getX() . ',' . $this->getY();
        return new SimpleUrl("$scheme://$identity$host$port$path$encoded$fragment$coords");
    }

    /**
     *    Replaces unknown sections of the path with base parts
     *    to return a complete absolute one.
     *    @param string/SimpleUrl $base       Base URL.
     *    @param string                       Absolute path.
     *    @access private
     */
    public function _extractAbsolutePath($base)
    {
        if ($this->getHost()) {
            return $this->_path;
        }
        if (! $this->_isRelativePath($this->_path)) {
            return $this->_path;
        }
        if ($this->_path) {
            return $base->getBasePath() . $this->_path;
        }
        return $base->getPath();
    }

    /**
     *    Simple test to see if a path part is relative.
     *    @param string $path        Path to test.
     *    @return boolean            True if starts with a "/".
     *    @access private
     */
    public function _isRelativePath($path)
    {
        return (!str_starts_with($path, '/'));
    }

    /**
     *    Extracts the username and password for use in rendering
     *    a URL.
     *    @return string/boolean    Form of username:password or false.
     */
    public function getIdentity()
    {
        if ($this->_username && $this->_password) {
            return $this->_username . ':' . $this->_password;
        }
        return false;
    }

    /**
     *    Replaces . and .. sections of the path.
     *    @param string $path    Unoptimised path.
     *    @return string         Path with dots removed if possible.
     */
    public function normalisePath($path)
    {
        $path = preg_replace('|/\./|', '/', $path);
        return preg_replace('|/[^/]+/\.\./|', '/', $path);
    }

    /**
     *    A pipe seperated list of all TLDs that result in two part
     *    domain names.
     *    @return string        Pipe separated list.
     */
    public static function getAllTopLevelDomains()
    {
        return 'com|edu|net|org|gov|mil|int|biz|info|name|pro|aero|coop|museum';
    }
}
