<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//FR" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Openads testing - Selenium</title>
    <link rel="stylesheet" type="text/css" href="/testClasses/tests.css" />
</head>
<body>
<?php
/**
 * @since Openads 2.3.31-alpha - 11-Dec-2006
 */

require_once 'init.php';

$conf = $GLOBALS['_MAX']['CONF'];
$admin_host = $conf['webpath']['admin'];
if (strlen($admin_host) > 0) {
    $suite_url = 'http://' . $admin_host . '/tests/selenium/TestRunner.html?test=../functional/CriticalSuite.html';
}
?>
    <h2>Selenium Testing Suite</h2>
    <p>
      Selenium tests drive a real Web browser to test the Openads administrative interface.
      You'll probably need to set up a real Openads installation on a separate virtual host,
      such as <code class="host"><em>www-tests</em>.openads.local</code> with its own database.
    </p>
    <p>
      Once you have that, make sure your <code class="filename">test.conf.ini</code> has a
      section like the following:
    </p>
    <pre>
    <code class="configuration">
    [webpath]
    admin = www-tests.openads.local
    </code>
    </pre>
<?php
    if ($suite_url) {
        print "<p>This host is configured appropriately, so you may <a href='$suite_url' target='selenium'>run the Critical Test Suite</a> (opens in a new window).</p>";
    }
?>
</body>
</html>