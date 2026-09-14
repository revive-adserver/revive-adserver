<?php

/**
 *	base include file for SimpleTest
 *	@package	SimpleTest
 *	@subpackage	WebTester
 */

/**#@+
 *	include other SimpleTest class files
 */
require_once(__DIR__ . '/socket.php');
require_once(__DIR__ . '/cookies.php');
require_once(__DIR__ . '/url.php');
/**#@-*/

/**
 *    Creates HTTP headers for the end point of
 *    a HTTP request.
 *    @package SimpleTest
 *    @subpackage WebTester
 */
class SimpleRoute
{
    public $_url;

    /**
     *    Sets the target URL.
     *    @param SimpleUrl $url   URL as object.
     */
    public function __construct($url)
    {
        $this->_url = $url;
    }

    /**
     *    Resource name.
     *    @return SimpleUrl        Current url.
     *    @access protected
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     *    Creates the first line which is the actual request.
     *    @param string $method   HTTP request method, usually GET.
     *    @return string          Request line content.
     *    @access protected
     */
    public function _getRequestLine($method)
    {
        return $method . ' ' . $this->_url->getPath() .
                $this->_url->getEncodedRequest() . ' HTTP/1.0';
    }

    /**
     *    Creates the host part of the request.
     *    @return string          Host line content.
     *    @access protected
     */
    public function _getHostLine()
    {
        $line = 'Host: ' . $this->_url->getHost();
        if ($this->_url->getPort()) {
            $line .= ':' . $this->_url->getPort();
        }
        return $line;
    }

    /**
     *    Opens a socket to the route.
     *    @param string $method      HTTP request method, usually GET.
     *    @param integer $timeout    Connection timeout.
     *    @return SimpleSocket       New socket.
     */
    public function createConnection($method, $timeout)
    {
        $default_port = ('https' == $this->_url->getScheme()) ? 443 : 80;
        $socket = $this->_createSocket(
            $this->_url->getScheme() ?: 'http',
            $this->_url->getHost(),
            $this->_url->getPort() ?: $default_port,
            $timeout,
        );
        if (! $socket->isError()) {
            $socket->write($this->_getRequestLine($method) . "\r\n");
            $socket->write($this->_getHostLine() . "\r\n");
            $socket->write("Connection: close\r\n");
        }
        return $socket;
    }

    /**
     *    Factory for socket.
     *    @param string $scheme                   Protocol to use.
     *    @param string $host                     Hostname to connect to.
     *    @param integer $port                    Remote port.
     *    @param integer $timeout                 Connection timeout.
     *    @return SimpleSocket/SimpleSecureSocket New socket.
     *    @access protected
     */
    public function _createSocket($scheme, $host, $port, $timeout)
    {
        if ($scheme == 'https') {
            return new SimpleSecureSocket($host, $port, $timeout);
        }
        return new SimpleSocket($host, $port, $timeout);
    }
}

/**
 *    Creates HTTP headers for the end point of
 *    a HTTP request via a proxy server.
 *    @package SimpleTest
 *    @subpackage WebTester
 */
class SimpleProxyRoute extends SimpleRoute
{
    public $_proxy;
    public $_username;
    public $_password;

    /**
     *    Stashes the proxy address.
     *    @param SimpleUrl $url     URL as object.
     *    @param string $proxy      Proxy URL.
     *    @param string $username   Username for autentication.
     *    @param string $password   Password for autentication.
     */
    public function __construct($url, $proxy, $username = false, $password = false)
    {
        parent::__construct($url);
        $this->_proxy = $proxy;
        $this->_username = $username;
        $this->_password = $password;
    }

    /**
     *    Creates the first line which is the actual request.
     *    @param string $method   HTTP request method, usually GET.
     *    @param SimpleUrl $url   URL as object.
     *    @return string          Request line content.
     *    @access protected
     */
    public function _getRequestLine($method)
    {
        $url = $this->getUrl();
        $scheme = $url->getScheme() ?: 'http';
        $port = $url->getPort() ? ':' . $url->getPort() : '';
        return $method . ' ' . $scheme . '://' . $url->getHost() . $port .
                $url->getPath() . $url->getEncodedRequest() . ' HTTP/1.0';
    }

    /**
     *    Creates the host part of the request.
     *    @param SimpleUrl $url   URL as object.
     *    @return string          Host line content.
     *    @access protected
     */
    public function _getHostLine()
    {
        $host = 'Host: ' . $this->_proxy->getHost();
        $port = $this->_proxy->getPort() ?: 8080;
        return "$host:$port";
    }

    /**
     *    Opens a socket to the route.
     *    @param string $method       HTTP request method, usually GET.
     *    @param integer $timeout     Connection timeout.
     *    @return SimpleSocket        New socket.
     */
    public function createConnection($method, $timeout)
    {
        $socket = $this->_createSocket(
            $this->_proxy->getScheme() ?: 'http',
            $this->_proxy->getHost(),
            $this->_proxy->getPort() ?: 8080,
            $timeout,
        );
        if ($socket->isError()) {
            return $socket;
        }
        $socket->write($this->_getRequestLine($method) . "\r\n");
        $socket->write($this->_getHostLine() . "\r\n");
        if ($this->_username && $this->_password) {
            $socket->write('Proxy-Authorization: Basic ' .
                    base64_encode($this->_username . ':' . $this->_password) .
                    "\r\n");
        }
        $socket->write("Connection: close\r\n");
        return $socket;
    }
}

/**
 *    HTTP request for a web page. Factory for
 *    HttpResponse object.
 *    @package SimpleTest
 *    @subpackage WebTester
 */
class SimpleHttpRequest
{
    public $_route;
    public $_encoding;
    public $_headers = [];
    public $_cookies = [];

    /**
     *    Builds the socket request from the different pieces.
     *    These include proxy information, URL, cookies, headers,
     *    request method and choice of encoding.
     *    @param SimpleRoute $route              Request route.
     *    @param SimpleFormEncoding $encoding    Content to send with
     *                                           request.
     */
    public function __construct(&$route, $encoding)
    {
        $this->_route = $route;
        $this->_encoding = $encoding;
    }

    /**
     *    Dispatches the content to the route's socket.
     *    @param integer $timeout      Connection timeout.
     *    @return SimpleHttpResponse   A response which may only have
     *                                 an error, but hopefully has a
     *                                 complete web page.
     */
    public function fetch($timeout)
    {
        $socket = $this->_route->createConnection($this->_encoding->getMethod(), $timeout);
        if (! $socket->isError()) {
            $this->_dispatchRequest($socket, $this->_encoding);
        }
        $response = $this->_createResponse($socket);
        return $response;
    }

    /**
     *    Sends the headers.
     *    @param SimpleSocket $socket           Open socket.
     *    @param string $method                 HTTP request method,
     *                                          usually GET.
     *    @param SimpleFormEncoding $encoding   Content to send with request.
     *    @access private
     */
    public function _dispatchRequest(&$socket, $encoding)
    {
        foreach ($this->_headers as $header_line) {
            $socket->write($header_line . "\r\n");
        }
        if (count($this->_cookies) > 0) {
            $socket->write("Cookie: " . implode(";", $this->_cookies) . "\r\n");
        }
        $encoding->writeHeadersTo($socket);
        $socket->write("\r\n");
        $encoding->writeTo($socket);
    }

    /**
     *    Adds a header line to the request.
     *    @param string $header_line    Text of full header line.
     */
    public function addHeaderLine($header_line)
    {
        $this->_headers[] = $header_line;
    }

    /**
     *    Reads all the relevant cookies from the
     *    cookie jar.
     *    @param SimpleCookieJar $jar     Jar to read
     *    @param SimpleUrl $url           Url to use for scope.
     */
    public function readCookiesFromJar($jar, $url)
    {
        $this->_cookies = $jar->selectAsPairs($url);
    }

    /**
     *    Wraps the socket in a response parser.
     *    @param SimpleSocket $socket   Responding socket.
     *    @return SimpleHttpResponse    Parsed response object.
     *    @access protected
     */
    public function _createResponse(&$socket)
    {
        $response = new SimpleHttpResponse(
            $socket,
            $this->_route->getUrl(),
            $this->_encoding,
        );
        return $response;
    }
}

/**
 *    Collection of header lines in the response.
 *    @package SimpleTest
 *    @subpackage WebTester
 */
class SimpleHttpHeaders
{
    public $_raw_headers;
    public $_response_code = false;
    public $_http_version = false;
    public $_mime_type = '';
    public $_location = false;
    public $_cookies = [];
    public $_authentication = false;
    public $_realm = false;

    /**
     *    Parses the incoming header block.
     *    @param string $headers     Header block.
     */
    public function __construct($headers)
    {
        $this->_raw_headers = $headers;
        foreach (preg_split("/\r\n/D", $headers) as $header_line) {
            $this->_parseHeaderLine($header_line);
        }
    }

    /**
     *    Accessor for parsed HTTP protocol version.
     *    @return integer           HTTP error code.
     */
    public function getHttpVersion()
    {
        return $this->_http_version;
    }

    /**
     *    Accessor for raw header block.
     *    @return string        All headers as raw string.
     */
    public function getRaw()
    {
        return $this->_raw_headers;
    }

    /**
     *    Accessor for parsed HTTP error code.
     *    @return integer           HTTP error code.
     */
    public function getResponseCode()
    {
        return (int) $this->_response_code;
    }

    /**
     *    Returns the redirected URL or false if
     *    no redirection.
     *    @return string      URL or false for none.
     */
    public function getLocation()
    {
        return $this->_location;
    }

    /**
     *    Test to see if the response is a valid redirect.
     *    @return boolean       True if valid redirect.
     */
    public function isRedirect()
    {
        return in_array($this->_response_code, [301, 302, 303, 307]) &&
                (bool) $this->getLocation();
    }

    /**
     *    Test to see if the response is an authentication
     *    challenge.
     *    @return boolean       True if challenge.
     */
    public function isChallenge()
    {
        return ($this->_response_code == 401) &&
                (bool) $this->_authentication &&
                (bool) $this->_realm;
    }

    /**
     *    Accessor for MIME type header information.
     *    @return string           MIME type.
     */
    public function getMimeType()
    {
        return $this->_mime_type;
    }

    /**
     *    Accessor for authentication type.
     *    @return string        Type.
     */
    public function getAuthentication()
    {
        return $this->_authentication;
    }

    /**
     *    Accessor for security realm.
     *    @return string        Realm.
     */
    public function getRealm()
    {
        return $this->_realm;
    }

    /**
     *    Writes new cookies to the cookie jar.
     *    @param SimpleCookieJar $jar   Jar to write to.
     *    @param SimpleUrl $url         Host and path to write under.
     */
    public function writeCookiesToJar(&$jar, $url)
    {
        foreach ($this->_cookies as $cookie) {
            $jar->setCookie(
                $cookie->getName(),
                $cookie->getValue(),
                $url->getHost(),
                $cookie->getPath(),
                $cookie->getExpiry(),
            );
        }
    }

    /**
     *    Called on each header line to accumulate the held
     *    data within the class.
     *    @param string $header_line        One line of header.
     *    @access protected
     */
    public function _parseHeaderLine($header_line)
    {
        if (preg_match('/HTTP\/(\d+\.\d+)\s+(\d+)/i', $header_line, $matches)) {
            $this->_http_version = $matches[1];
            $this->_response_code = $matches[2];
        }
        if (preg_match('/Content-type:\s*(.*)/i', $header_line, $matches)) {
            $this->_mime_type = trim($matches[1]);
        }
        if (preg_match('/Location:\s*(.*)/i', $header_line, $matches)) {
            $this->_location = trim($matches[1]);
        }
        if (preg_match('/Set-cookie:(.*)/i', $header_line, $matches)) {
            $this->_cookies[] = $this->_parseCookie($matches[1]);
        }
        if (preg_match('/WWW-Authenticate:\s+(\S+)\s+realm=\"(.*?)\"/i', $header_line, $matches)) {
            $this->_authentication = $matches[1];
            $this->_realm = trim($matches[2]);
        }
    }

    /**
     *    Parse the Set-cookie content.
     *    @param string $cookie_line    Text after "Set-cookie:"
     *    @return SimpleCookie          New cookie object.
     *    @access private
     */
    public function _parseCookie($cookie_line)
    {
        $parts = preg_split("/;/D", $cookie_line);
        $cookie = [];
        preg_match('/\s*(.*?)\s*=(.*)/', array_shift($parts), $cookie);
        foreach ($parts as $part) {
            if (preg_match('/\s*(.*?)\s*=(.*)/', $part, $matches)) {
                $cookie[$matches[1]] = trim($matches[2]);
            }
        }
        return new SimpleCookie(
            $cookie[1],
            trim($cookie[2]),
            $cookie["path"] ?? "",
            $cookie["expires"] ?? false,
        );
    }
}

/**
 *    Basic HTTP response.
 *    @package SimpleTest
 *    @subpackage WebTester
 */
class SimpleHttpResponse extends SimpleStickyError
{
    public $_url;
    public $_encoding;
    public $_sent;
    public $_content = false;
    public $_headers;

    /**
     *    Constructor. Reads and parses the incoming
     *    content and headers.
     *    @param SimpleSocket $socket   Network connection to fetch
     *                                  response text from.
     *    @param SimpleUrl $url         Resource name.
     *    @param mixed $encoding        Record of content sent.
     */
    public function __construct(&$socket, $url, $encoding)
    {
        parent::__construct();
        $this->_url = $url;
        $this->_encoding = $encoding;
        $this->_sent = $socket->getSent();
        $raw = $this->_readAll($socket);
        if ($socket->isError()) {
            $this->_setError('Error reading socket [' . $socket->getError() . ']');
            return;
        }
        $this->_parse($raw);
    }

    /**
     *    Splits up the headers and the rest of the content.
     *    @param string $raw    Content to parse.
     *    @access private
     */
    public function _parse($raw)
    {
        if (! $raw) {
            $this->_setError('Nothing fetched');
            $this->_headers = new SimpleHttpHeaders('');
        } elseif (! strstr($raw, "\r\n\r\n")) {
            $this->_setError('Could not split headers from content');
            $this->_headers = new SimpleHttpHeaders($raw);
        } else {
            [$headers, $this->_content] = preg_split("/\r\n\r\n/D", $raw, 2);
            $this->_headers = new SimpleHttpHeaders($headers);
        }
    }

    /**
     *    Original request method.
     *    @return string        GET, POST or HEAD.
     */
    public function getMethod()
    {
        return $this->_encoding->getMethod();
    }

    /**
     *    Resource name.
     *    @return SimpleUrl        Current url.
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     *    Original request data.
     *    @return mixed              Sent content.
     */
    public function getRequestData()
    {
        return $this->_encoding;
    }

    /**
     *    Raw request that was sent down the wire.
     *    @return string        Bytes actually sent.
     */
    public function getSent()
    {
        return $this->_sent;
    }

    /**
     *    Accessor for the content after the last
     *    header line.
     *    @return string           All content.
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     *    Accessor for header block. The response is the
     *    combination of this and the content.
     *    @return SimpleHeaders        Wrapped header block.
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     *    Accessor for any new cookies.
     *    @return array       List of new cookies.
     */
    public function getNewCookies()
    {
        return $this->_headers->getNewCookies();
    }

    /**
     *    Reads the whole of the socket output into a
     *    single string.
     *    @param SimpleSocket $socket  Unread socket.
     *    @return string               Raw output if successful
     *                                 else false.
     *    @access private
     */
    public function _readAll(&$socket)
    {
        $all = '';
        while (! $this->_isLastPacket($next = $socket->read())) {
            $all .= $next;
        }
        return $all;
    }

    /**
     *    Test to see if the packet from the socket is the
     *    last one.
     *    @param string $packet    Chunk to interpret.
     *    @return boolean          True if empty or EOF.
     *    @access private
     */
    public function _isLastPacket($packet)
    {
        if (is_string($packet)) {
            return $packet === '';
        }
        return ! $packet;
    }
}
