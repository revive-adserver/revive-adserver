<?php
chdir('../../../tests');

ob_start(); // catch any cookies, redirects and that sort of thing in the face of printed errors
require_once 'init.php';
require_once MAX_PATH . '/www/admin/lib-sessions.inc.php';
phpAds_SessionDataDestroy();
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Openads post-test environment tear-down</title>
</head>
<body>
<p>Openads state has been tidied up. You can continue to the Openads <a href="/">admin interface</a>.</p>
</body>
</html>