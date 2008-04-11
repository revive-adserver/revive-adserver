<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// For performance reasons this file is standalone from the rest of the
// product and does not include any configuration files or libraries!

require_once 'jsmin-1.1.1.php';

// Enable advanced caching control using ETag headers
define ('_STRATEGY_ETAG_', true);

// Enable advanced caching control using Modified headers
define ('_STRATEGY_MODIFIED_', true);

// Enable caching the combined files on the server
define ('_STRATEGY_CACHE_', true);

// Determine the type
$type = $_GET['type'];
if ($type != 'js' && $type != 'css') {
	header ("HTTP/1.0 403 Forbidden");
	exit;
}

//disable zlib compression for it collides with combine logic
$zlibCompression = ini_get('zlib.output_compression');
if ($zlibCompression) {
    ini_set("zlib.output_compression", 0);
}

// Build our paths
$base = realpath(dirname(dirname(__FILE__)));
$cacheFolder = realpath(dirname(dirname($base)) . '/var/cache');

// Check if files exist
$elements = explode(',', $_GET['files']);
$files = array();

while (list(,$element) = each($elements)) {
	$path = realpath($base . '/' . $element);

	$dirSep = preg_quote(DIRECTORY_SEPARATOR, '#');
	if (preg_match("#^{$dirSep}(images|css|js){$dirSep}#", substr($path, strlen($base)))) {
		$files[] = $path;
	} 
	else {
	   header ("HTTP/1.0 403 Forbidden");
	   exit;
	}
}

// Determine supported compression methods
$encoding = strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') ? 'gzip' :
			(strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'deflate') ? 'deflate' : 'none');

if (!strstr($_SERVER['HTTP_USER_AGENT'], 'Opera') &&
	preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
	$version = floatval($matches[1]);

	if ($version < 6)
		$encoding = 'none';

	if ($version == 6 && !strstr($_SERVER['HTTP_USER_AGENT'], 'EV1'))
		$encoding = 'none';
}

// Determine the date of the last modification
$modified = 0;
while (list(,$file) = each($files)) {
	$modified = max($modified, filemtime($file));
}

// Determine the unique hash
$hash = $modified . '_' . md5(implode('', $files)) . '_' . $encoding . '.' . $type;

// Check if the cache version of the browser is still valid
if (_STRATEGY_MODIFIED_) {
	header ('Last-Modified: ' . gmdate("D, d M Y H:i:s",  $modified) . ' GMT');

	if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) <= $modified) {
		header ("HTTP/1.0 304 Not Modified");
		header ('Content-Length: 0');
		exit;
	}
}

if (_STRATEGY_ETAG_) {
	header ("ETag: \"" . $hash . "\"");

	if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && ($_SERVER['HTTP_IF_NONE_MATCH'] == $hash || $_SERVER['HTTP_IF_NONE_MATCH'] == '"' . $hash . '"')) {
		header ("HTTP/1.0 304 Not Modified");
		header ('Content-Length: 0');
		exit;
	}
}

$cacheFile = $cacheFolder . '/combine_' . $hash;
if (_STRATEGY_CACHE_ && file_exists($cacheFile)) {
	$contents = file_get_contents($cacheFile);
} 
else {
	$contents = '';
	reset ($files);
	while (list(,$file) = each($files)) {
      if (preg_match("/\.js$/", $file)) {
         // Minify JS
		   $contents .= "\n\n" . JSMin::minify(file_get_contents($file));
      } else {
		   $contents .= "\n\n" . file_get_contents($file);
      }
	}

	if ($encoding != 'none') {
		$contents = gzencode($contents, 9, $encoding == 'gzip' ? FORCE_GZIP : FORCE_DEFLATE);
	}

	if (_STRATEGY_CACHE_ && is_writable($cacheFolder)) {
		if ($fp = fopen($cacheFile, 'wb')) {
			fwrite($fp, $contents);
			fclose($fp);
		}
	}
}

header ("Content-Type: text/" . ($type == 'js' ? 'javascript' : $type));
header ("Content-Encoding: " . $encoding);
header ('Content-Length: ' . strlen($contents));
echo $contents;

?>