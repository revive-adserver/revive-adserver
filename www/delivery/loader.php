<?php
/**
 * Revive Adserver - Stealth Loader (The Translator)
 * * ROLE:
 * 1. Receives requests for "fake" files (lib.js, packet, etc).
 * 2. Includes the ACTUAL Revive script (asyncjs.php, etc) to generate logic.
 * 3. Intercepts the output.
 * 4. Performs "Search & Replace" to hide Revive filenames and attributes.
 * 5. Sends the "sanitized" code to the browser.
 */

if (!defined('MAX_PATH')) {
    define('MAX_PATH', dirname(dirname(__DIR__)));
}

$scriptMap = [
    'core'    => 'asyncjs.php',   // The JS Loader (lib.js)
    'data'    => 'asyncspc.php',  // The Content Fetcher (packet)
    'frame'   => 'afr.php',       // iFrame (widget.html)
    'log'     => 'lg.php',        // Logging (ping.gif)
    'click'   => 'ck.php',        // Clicks (go)
    'view'    => 'avw.php',       // View Tracking (view.gif)
];

$type = $_GET['type'] ?? '';

if (!array_key_exists($type, $scriptMap)) {
    http_response_code(404);
    exit('Invalid Type');
}

$realScript = $scriptMap[$type];
$scriptPath = MAX_PATH . '/www/delivery/' . $realScript;

if (!file_exists($scriptPath)) {
    http_response_code(500);
    exit("Error: Script $realScript not found.");
}

// Handle CORS preflight requests and set CORS headers
if ($type === 'data') {
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        if (!empty($_SERVER['HTTP_ORIGIN']) && preg_match('#https?://#', $_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Max-Age: 86400");
        }
        http_response_code(200);
        exit;
    }
    
    // Set CORS headers for actual requests (BEFORE requiring the script)
    // asyncspc.php sets CORS headers, but we need to set them before it runs
    // to ensure they're properly sent
    if (!empty($_SERVER['HTTP_ORIGIN']) && preg_match('#https?://#', $_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
        header("Access-Control-Allow-Credentials: true");
    }
}

ob_start();

require $scriptPath;

$content = ob_get_contents();
ob_end_clean();

$replacements = [
    // --- FILES ---
    'asyncspc.php' => '../data/packet', 
    'lg.php'       => '../ping.gif',
    'ck.php'       => '../go',
    'avw.php'      => '../view.gif',
    'afr.php'      => '../frames/widget.html',

    // --- ATTRIBUTES ---
    'data-revive-' => 'data-content-',
    'reviveAsync'  => 'contentAsync',
    'revive-'      => 'content-',
    'revive'       => 'content', 
];

// Perform the translation
// String replacements for filenames
$stealthContent = str_replace(array_keys($replacements), array_values($replacements), $content);

// Replacements for full URLs (needed for iframe backup images)
$stealthContent = preg_replace(
    '#(https?://[^/]+)(/.*?)/delivery/avw\.php(\?[^"\'>\s]*)?#i',
    '$1$2/assets/view.gif$3',
    $stealthContent
);
$stealthContent = preg_replace(
    '#(https?://[^/]+)(/.*?)/delivery/ck\.php(\?[^"\'>\s]*)?#i',
    '$1$2/assets/go$3',
    $stealthContent
);
// Also handle relative URLs
$stealthContent = preg_replace(
    '#(/.*?)/delivery/avw\.php(\?[^"\'>\s]*)?#i',
    '$1/assets/view.gif$2',
    $stealthContent
);
$stealthContent = preg_replace(
    '#(/.*?)/delivery/ck\.php(\?[^"\'>\s]*)?#i',
    '$1/assets/go$2',
    $stealthContent
);

// Set Headers
if ($type === 'core') {
    header('Content-Type: application/javascript');
} elseif ($type === 'data') {
    header('Content-Type: application/json');
    if (!empty($_SERVER['HTTP_ORIGIN']) && preg_match('#https?://#', $_SERVER['HTTP_ORIGIN'])) {
        // Remove any existing CORS headers that might conflict
        header_remove('Access-Control-Allow-Origin');
        header_remove('Access-Control-Allow-Credentials');
        // Set the correct CORS headers
        header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN'], true);
        header("Access-Control-Allow-Credentials: true", true);
    }
} elseif ($type === 'frame') {
    header('Content-Type: text/html');
} elseif ($type === 'log') {
    header('Content-Type: image/gif');
} elseif ($type === 'view') {
    header('Content-Type: image/gif');
}

echo $stealthContent;
?>