<?php

$fileName = 'ti.php';

$webPath = substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI']) - strlen('delivery_test/'.$fileName))."delivery/$fileName";
$debug = '';
// uncomment following line to turn on debugging
//$debug = '&start_debug=1&debug_port=10000&debug_host=127.0.0.1&debug_stop=1';
$protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
?>
<html>
<head>
<title>Example Web Page</title>
</head>
<body>
<div id='m3_tracker_1' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='<?php echo $protocol.$_SERVER['HTTP_HOST'].$webPath; ?>?trackerid=1&amp;boo=123&amp;foo=test123&amp;cb=<?php echo rand(1, 12323123) . $debug;?>' width='0' height='0' alt='' /></div>
</body>
</html>

